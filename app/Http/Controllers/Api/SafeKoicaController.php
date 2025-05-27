<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SafeKoicaController extends Controller
{
    public function getCountrySafety($iso)
    {
        $serviceKey = env('SAFEKOICA_API_KEY'); // .env에 저장된 인증키
        $countryCode = strtoupper($iso);

        // 한국국제협력단_파견국 안전이슈 월력표
        $url = "http://apis.data.go.kr/B260003/RiskCalendarService2/getRiskCalendarList2";
        $response = Http::get($url, [
            'serviceKey' => $serviceKey,
            'pageNo' => 1,
            'numOfRows' => 10,
            'cond[country_iso_alp2::EQ]' => $countryCode,
            'returnType' => 'JSON',
        ]);

        if ($response->ok()) {
            $data = $response->json()['response']['body']['items']['item'][0] ?? null;

            return response()->json([
                'country' => $data['country_nm'] ?? '알 수 없음',
                'travel_alert' => $data['current_travel_alarm'] ?? '정보 없음',
                'suicide_rate' => $data['suicide_death_rate'] ?? null,
                'unemployment_rate' => $data['unemployment_rate'] ?? null,
            ]);
        }

        return response()->json(['error' => 'API 요청 실패'], 500);
    }
}
