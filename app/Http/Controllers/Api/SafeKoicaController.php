<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Throwable;

use App\Services\SafeKoicaAIService; // AI 요약 및 질의응답 API
use App\Services\RiskCalendarService; // 한국국제협력단_파견국 안전이슈 월력표 API
use App\Services\TravelAlertService; //  외교부_국가·지역별 여행경보 목록 조회(0404 대륙정보) API
use App\Services\SpecialWarningService;// 외교부_국가∙지역별 특별여행주의보 API
use App\Services\TravelAlertAdjustmentService; // 외교부_국가∙지역별 여행경보 조정 API

class SafeKoicaController extends Controller
{
    public function getCountrySafety($iso)
    {
        try {

            $serviceKey = config('services.safe_koica.key');
            $countryCode = strtoupper($iso);
            Log::info('접속국가:', ['code' => $countryCode]);

            // 한국국제협력단_파견국 안전이슈 월력표 API
            $calendar = RiskCalendarService::get($countryCode);
            $event = $calendar['event'] ?? '정보 없음';
            $countryName = $calendar['country'] ?? '알 수 없음';
            $occurDate = $calendar['occur_date'] ?? '알 수 없음';

            // 외교부_국가·지역별 여행경보 목록 조회(0404 대륙정보) API
            $travelAlertData = TravelAlertService::get($countryCode);
            $alarmLevels = $travelAlertData['levels'] ?? [];
            $alarmLevelReason = $travelAlertData['remarks'] ?? [];

            // 외교부_국가∙지역별 특별여행주의보 API
            $specialWarning = SpecialWarningService::get($countryCode);
            $specialLevel = $specialWarning['status'];
            $specialReason = $specialWarning['remark'];

            // 외교부_국가∙지역별 여행경보 조정 API
            $travelAdjustment = TravelAlertAdjustmentService::get($countryCode);

            // ai 요약 호출 캐시 처리 (10분)
            $cacheKey = 'summary_' . $countryCode;
            // api 테스트 할 때는 ttl 값을 0으로. 배포시엔 600
            $summary = Cache::remember($cacheKey, 600, function () use (
                $countryName, $event, $occurDate, $alarmLevels, $alarmLevelReason, $specialLevel, $specialReason, $travelAdjustment) {
                return SafeKoicaAIService::summarize([
                    'country' => $countryName,
                    'event' => $event,
                    'occurDate' => $occurDate,
                    'alarmLevels' => $alarmLevels,
                    'alarmLevelReason' => $alarmLevelReason ?? '정보 없음',
                    'specialLevel' => $specialLevel ?? '없음',
                    'specialReason' => $specialReason ?? '없음',
                    'travel_adjustment' => $travelAdjustment ?? '없음',
                ]);
            });
            Log::info('summary', ['summary' => $summary]);

            return response()->json([
                'country' => $countryName,
                'event' => $event,
                'occurDate' => $occurDate,
                'alarmLevels' => $alarmLevels,
                'alarmLevelReason' => $alarmLevelReason ?? '정보 없음',
                'specialLevel' => $specialLevel ?? '없음',
                'specialReason' => $specialReason ?? '없음',
                'travel_adjustment' => $travelAdjustment ?? '없음',
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
