<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SpecialWarningService
{
    public static function get(string $countryCode): array
    {
        $key = config('services.safe_koica.key');
        $res = Http::get("http://apis.data.go.kr/1262000/SptravelWarningServiceV2/getSptravelWarningListV2", [
            'ServiceKey' => $key,
            'pageNo' => 1,
            'numOfRows' => 10,
            'returnType' => 'JSON',
            'cond[country_iso_alp2::EQ]' => $countryCode,
        ]);

        $item = $res->json()['response']['body']['items']['item'][0] ?? null;

        if (!$item || empty($item['evacuate_rcmnd_remark'])) {
            return [
                'status' => '없음',
                'remark' => null,
            ];
        }

        return [
            'status' => '특별여행주의보 발령',
            'remark' => "({$item['written_dt']}) {$item['evacuate_rcmnd_remark']}",
        ];
    }
}
