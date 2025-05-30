<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TravelAlertService
{
    public static function get(string $countryCode): array
    {
        $key = config('services.safe_koica.key');
        $res = Http::get("http://apis.data.go.kr/1262000/TravelAlarmService0404/getTravelAlarm0404List", [
            'ServiceKey' => $key,
            'page' => 1,
            'perPage' => 10,
            'cond[country_iso_alp2::EQ]' => $countryCode,
            'returnType' => 'JSON',
        ]);

        $items = $res->json()['response']['body']['items']['item'] ?? [];
        $level = '정보 없음';
        $danger = '정보 없음';

        foreach ($items as $item) {
            if ($item['alarm_lvl'] == 4) {
                $level = '4단계: 여행금지 (' . ($item['remark'] ?? '일부 지역') . ')';
                $danger = $item['remark'] ?? '정보 없음';
                break;
            }
            if ($item['alarm_lvl'] == 1 && $level === '정보 없음') {
                $level = '1단계: 여행유의 (' . ($item['remark'] ?? '전 지역') . ')';
                $danger = $item['remark'] ?? '정보 없음';
            }
        }

        return compact('level', 'danger');
    }
}
