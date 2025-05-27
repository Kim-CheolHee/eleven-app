<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use App\Services\SafeKoicaAIService;
use Illuminate\Support\Facades\Log;

class SafeKoicaController extends Controller
{
    public function getCountrySafety($iso)
    {
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

        // AI 요약 카드 생성
        $summary = SafeKoicaAIService::summarize([
            'country' => $countryName,
            'event' => $event,
            'alert' => $alarmLevel,
            'danger' => $dangerZone ?? '정보 없음',
        ]);

        return response()->json([
            'country' => $countryName,
            'travel_alert' => $alarmLevel,
            'event' => $event,
            'danger' => $dangerZone ?? '정보 없음',
            'summary' => $summary,
        ]);
    }
}
