<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RiskCalendarService
{
    public static function get(string $countryCode): array
    {
        $key = config('services.safe_koica.key');
        $res = Http::get("http://apis.data.go.kr/B260003/RiskCalendarService2/getRiskCalendarList2", [
            'serviceKey' => $key,
            'pageNo' => 1,
            'numOfRows' => 10,
            'cond[country_iso_alp2::EQ]' => $countryCode,
            'returnType' => 'JSON',
        ]);

        $item = $res->json()['response']['body']['items']['item'][0] ?? null;

        // 시작, 끝 날짜 추출
        $startDate = $item['icdt_occur_start_dt'] ?? null;
        $endDate = $item['icdt_occur_end_dt'] ?? null;
        $occurDate = null;

        if ($startDate && $endDate) {
            if ($startDate === $endDate) {
                $occurDate = $startDate;
            } else {
                $start = explode('-', $startDate); // [년, 월, 일]
                $end = explode('-', $endDate);     // [년, 월, 일]

                if ($start[0] !== $end[0]) {
                    // 연도 다름 → 전체 날짜 출력
                    $occurDate = "{$startDate} ~ {$endDate}";
                } elseif ($start[1] !== $end[1]) {
                    // 월 다름 → 연월일 ~ 월일
                    $occurDate = "{$startDate} ~ {$end[1]}-{$end[2]}";
                } elseif ($start[2] !== $end[2]) {
                    // 일만 다름 → 연월일 ~ 일
                    $occurDate = "{$startDate} ~ {$end[2]}";
                } else {
                    $occurDate = $startDate; // 동일한 날짜
                }
            }
        }

        return [
            'event' => $item['icdt_cn'] ?? null,
            'country' => $item['country_nm'] ?? null,
            'occur_date' => $occurDate ?? null,
        ];
    }
}
