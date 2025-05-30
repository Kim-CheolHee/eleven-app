<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

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

        return [
            'event' => $item['icdt_cn'] ?? null,
            'country' => $item['country_nm'] ?? null,
        ];
    }
}
