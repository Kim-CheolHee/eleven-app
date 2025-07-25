<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use OpenAI;
use Throwable;

class SafeKoicaAIService
{
    public static function summarize(array $info): string
    {
        try {
            $client = OpenAI::client(config('services.openai.key'));

            $alarmLevels = is_array($info['alarmLevels']) ? implode(', ', $info['alarmLevels']) : $info['alarmLevels'];
            $alarmLevelReason = is_array($info['alarmLevelReason']) ? implode(', ', $info['alarmLevelReason']) : $info['alarmLevelReason'];
            $travelAdjustment = $info['travel_adjustment'] ?? '없음';
            $prompt = "국가명: {$info['country']}
                이벤트: {$info['event']},
                이벤트 날짜: {$info['occurDate']}
                경보 단계: {$alarmLevels},
                주의 지역: {$alarmLevelReason},
                특별여행주의보 발령 여부: {$info['specialLevel']},
                특별여행주의보 발령 일자 및 지역: {$info['specialReason']},
                여행경보 조정 내용: {$travelAdjustment},

                위 정보를 3~4줄 정도로 요약해서 안내 카드 문장을 생성해줘. 문장은 친절하고 간결하게 작성해줘.
                그리고 여행 경보 지도 관련 내용은 넣지 않아도 돼. 이건 텍스트로 정보를 전달하는 용도야.";

            $response = $client->chat()->create([
                'model' => 'gpt-4o',
                'messages' => [
                    ['role' => 'system', 'content' => '너는 KOICA 안전비서 역할이야. 친절하게 응답해줘.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

            return $response->choices[0]->message->content ?? '요약 생성 실패';
        } catch (Throwable $e) {
            Log::error('SafeKoicaAIService@summarize 실패', [
                'error' => $e->getMessage(),
                'info' => $info,
            ]);

            return '요약 생성 중 오류가 발생했습니다.';
        }
    }

    public static function ask(string $message): string
    {
        try {
            $client = OpenAI::client(config('services.openai.key'));

            $response = $client->chat()->create([
                'model' => 'gpt-4o',
                'messages' => [
                    ['role' => 'system', 'content' => '너는 KOICA 안전비서야. 친절하고 실용적인 답변을 제공해줘.'],
                    ['role' => 'user', 'content' => $message],
                ],
            ]);

            return $response->choices[0]->message->content ?? '답변 생성 실패';
        } catch (Throwable $e) {
            Log::error('SafeKoicaAIService@ask 실패', [
                'error' => $e->getMessage(),
                'message' => $message,
            ]);

            return '답변 생성 중 오류가 발생했습니다.';
        }
    }
}
