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

        $levels = [];
        $remarks = [];

        $levelMap = [
            1 => '1단계 여행유의',
            2 => '2단계 여행자제',
            3 => '3단계 출국권고',
            4 => '4단계 여행금지',
        ];

        foreach ($items as $item) {
            if (!empty($item['alarm_lvl']) && isset($levelMap[(int) $item['alarm_lvl']])) {
                $levels[] = $levelMap[(int) $item['alarm_lvl']];
            }

            if (!empty($item['remark'])) {
                $remarks[] = trim($item['remark']);
            }
        }

        return [
            'levels' => array_unique($levels),
            'remarks' => array_unique($remarks),
        ];
    }
}
