<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class TravelAlertAdjustmentService
{
    public static function get(string $countryCode): ?string
    {
        try {
            $serviceKey = config('services.safe_koica.key');
            $url = 'http://apis.data.go.kr/1262000/CountryHistoryService2/getCountryHistoryList2';

            $query = http_build_query([
                'serviceKey' => $serviceKey,
                'pageNo' => 1,
                'numOfRows' => 10,
                'returnType' => 'JSON',
                'cond[country_iso_alp2::EQ]' => $countryCode,
            ]);

            $response = Http::get("$url?$query");

            if ($response->failed()) {
                Log::warning('TravelAlertAdjustmentService API 요청 실패', [
                    'code' => $countryCode,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return null;
            }

            $title = $response->json('response.body.items.item.0.title');
            $txt_origin_cn = $response->json('response.body.items.item.0.txt_origin_cn');

            if ($title || $txt_origin_cn) {
                return "{$title} - {$txt_origin_cn}";
            }

            return null;
        } catch (Throwable $e) {
            Log::error('TravelAlertAdjustmentService@get 에러', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return null;
        }
    }
}
