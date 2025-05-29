<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use App\Services\SafeKoicaAIService;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Throwable;

class SafeKoicaController extends Controller
{
    public function getCountrySafety($iso)
    {
        try {

            $serviceKey = config('services.safe_koica.key');
            $countryCode = strtoupper($iso);
            Log::info('접속국가:', ['code' => $countryCode]);

            // 월력표 API 호출
            $calendarRes = Http::get("http://apis.data.go.kr/B260003/RiskCalendarService2/getRiskCalendarList2", [
            'serviceKey' => $serviceKey,
            'pageNo' => 1,
            'numOfRows' => 10,
            'cond[country_iso_alp2::EQ]' => $countryCode,
            'returnType' => 'JSON',
            ]);
            $calendarItems = $calendarRes->json()['response']['body']['items']['item'] ?? [];
            $firstEvent = $calendarItems[0] ?? null;
            $event = $firstEvent['icdt_cn'] ?? '이벤트 정보 없음';
            $countryName = $firstEvent['country_nm'] ?? '알 수 없음';

            // 여행경보 API 호출
            $alarmRes = Http::get("http://apis.data.go.kr/1262000/TravelAlarmService0404/getTravelAlarm0404List", [
                'ServiceKey' => $serviceKey,
                'page' => 1,
                'perPage' => 10,
                'cond[country_iso_alp2::EQ]' => $countryCode,
                'returnType' => 'JSON',
            ]);
            $alarmItems = $alarmRes->json()['response']['body']['items']['item'] ?? [];
            $alarmLevel = '정보 없음';
            $dangerZone = null;

            foreach ($alarmItems as $item) {
                if ($item['alarm_lvl'] == 4) {
                    $alarmLevel = '4단계: 여행금지 (' . ($item['remark'] ?? '일부 지역') . ')';
                    $dangerZone = $item['remark'] ?? '정보 없음';
                    break;
                }
                if ($item['alarm_lvl'] == 1 && $alarmLevel === '정보 없음') {
                    $alarmLevel = '1단계: 여행유의 (' . ($item['remark'] ?? '전 지역') . ')';
                    $dangerZone = $item['remark'] ?? '정보 없음';
                }
            }

            // 특별여행주의보 API 호출
            $spWarningRes = Http::get("http://apis.data.go.kr/1262000/SptravelWarningServiceV2/getSptravelWarningListV2", [
                'ServiceKey' => $serviceKey,
                'pageNo' => 1,
                'numOfRows' => 10,
                'returnType' => 'JSON',
                'cond[country_iso_alp2::EQ]' => $countryCode,
            ]);

            $spItems = $spWarningRes->json()['response']['body']['items']['item'] ?? [];
            $specialWarning = null;

            if (!empty($spItems)) {
                $writtenDate = $spItems[0]['written_dt'] ?? null;
                $specialWarning = $writtenDate
                    ? "특별여행주의보 발령됨 ({$writtenDate})"
                    : "특별여행주의보 발령됨";
            }

            // ai 요약 호출 캐시 처리 (10분)
            $cacheKey = 'summary_' . $countryCode;
            $summary = Cache::remember($cacheKey, 600, function () use ($countryName, $event, $alarmLevel, $dangerZone) {
                return SafeKoicaAIService::summarize([
                    'country' => $countryName,
                    'event' => $event,
                    'alert' => $alarmLevel,
                    'danger' => $dangerZone ?? '정보 없음',
                    'special' => $specialWarning ?? '없음',
                ]);
            });

            return response()->json([
                'country' => $countryName,
                'travel_alert' => $alarmLevel,
                'event' => $event,
                'danger' => $dangerZone ?? '정보 없음',
                'special_warning' => $specialWarning ?? '없음',
                'summary' => $summary,
            ]);
        } catch (Throwable $e) {
            Log::error('SafeKoicaController@getCountrySafety 에러', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => request()->all(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => '요청 처리 중 오류가 발생했습니다. 잠시 후 다시 시도해주세요.',
            ], 500);
        }
    }

    public function askGPT(Request $request)
    {
        $message = $request->input('message');

        if (!$message) {
            return response()->json(['reply' => '질문을 입력해주세요.'], 400);
        }

        try {
            $reply = SafeKoicaAIService::ask($message);

            // 로깅 추가
            Log::info('GPT 질문 요청', [
                'ip' => $request->ip(),
                'agent' => $request->userAgent(),
                'message' => $message,
                'reply_snippet' => mb_substr($reply, 0, 100), // 응답 일부만 로깅
            ]);

            return response()->json(['reply' => $reply]);
        } catch (Throwable $e) {
            Log::error('SafeKoicaController@askGPT 에러', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => request()->all(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => '요청 처리 중 오류가 발생했습니다. 잠시 후 다시 시도해주세요.',
            ], 500);
        }
    }

}
