<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class SafeKoicaController extends Controller
{
    public function getCountrySafety($iso)
    {
        $serviceKey = env('SAFEKOICA_API_KEY');
        $countryCode = strtoupper($iso);
        Log::info('접속국가: ', $countryCode ?? []);

        // 1️. 한국국제협력단_파견국 안전이슈 월력표
        $calendarUrl = "http://apis.data.go.kr/B260003/RiskCalendarService2/getRiskCalendarList2";
        $calendarRes = Http::get($calendarUrl, [
            'serviceKey' => $serviceKey,
            'pageNo' => 1,
            'numOfRows' => 10,
            'cond[country_iso_alp2::EQ]' => $countryCode,
            'returnType' => 'JSON',
        ]);
        Log::info('calendarRes API 응답', $calendarRes->json() ?? []);

        // 2. 외교부_국가·지역별 여행경보 목록 조회(0404 대륙정보)
        $alarmUrl = "http://apis.data.go.kr/1262000/TravelAlarmService0404/getTravelAlarm0404List";
        $alarmRes = Http::get($alarmUrl, [
            'ServiceKey' => $serviceKey,
            'page' => 1,
            'perPage' => 10,
            'cond[country_iso_alp2::EQ]' => $countryCode,
            'returnType' => 'JSON',
        ]);
        Log::info('alarmRes API 응답', $alarmRes->json() ?? []);

        // 파싱 데이터 초기화
        $event = null;
        $alarm = '정보 없음';

        // 월력표 응답 처리
        if ($calendarRes->ok()) {
            $calendarItems = $calendarRes->json()['response']['body']['items']['item'] ?? [];
            $firstEvent = $calendarItems[0] ?? null;
            $event = $firstEvent['icdt_cn'] ?? '이벤트 정보 없음';
        }

        // 여행경보 응답 처리
        if ($alarmRes->ok()) {
            $alarmItems = $alarmRes->json()['response']['body']['items']['item'] ?? [];
            $alarmLevelMap = [1 => '1단계: 여행유의', 2 => '2단계: 여행자제', 3 => '3단계: 철수권고', 4 => '4단계: 여행금지'];
            foreach ($alarmItems as $item) {
                if ($item['alarm_lvl'] == 4) {
                    $alarm = '4단계: 여행금지 (' . ($item['remark'] ?? '일부 지역') . ')';
                    break;
                }
                if ($item['alarm_lvl'] == 1 && $alarm === '정보 없음') {
                    $alarm = '1단계: 여행유의 (' . ($item['remark'] ?? '전 지역') . ')';
                }
            }
        }

        return response()->json([
            'country' => $firstEvent['country_nm'] ?? '알 수 없음',
            'travel_alert' => $alarm,
            'event' => $event,
        ]);
    }
}
