<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use OpenAI;

class SafeKoicaAIService
{
    public static function summarize(array $info): string
    {
        $client = OpenAI::client(config('services.openai.key'));

        $prompt = "국가명: {$info['country']}
            이벤트: {$info['event']},
            경보 단계: {$info['alert']},
            주의 지역: {$info['danger']}

            위 정보를 1~2줄 정도로 요약해서 안내 카드 문장을 생성해줘. 문장은 친절하고 간결하게 작성해.";

        $response = $client->chat()->create([
            'model' => 'gpt-4o',
            'messages' => [
                ['role' => 'system', 'content' => '너는 KOICA 안전비서 역할이야. 친절하게 응답해줘.'],
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        return $response->choices[0]->message->content ?? '요약 생성 실패';
    }
}
