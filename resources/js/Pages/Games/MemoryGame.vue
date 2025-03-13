<script setup>
import { ref, computed, onMounted } from "vue";
import { Link } from "@inertiajs/vue3";

// 카드 데이터 (짝을 맞출 이미지 리스트)
const cardImages = [
    { id: 1, image: "/images/card1.jpg" },
    { id: 2, image: "/images/card2.jpg" },
    { id: 3, image: "/images/card3.jpg" },
    { id: 4, image: "/images/card4.jpg" },
    { id: 5, image: "/images/card5.jpg" },
    { id: 6, image: "/images/card6.jpg" },
];

// 게임 상태
const cards = ref([]);
const flippedCards = ref([]);
const matchedCards = ref([]);
const moves = ref(0);
const gameCompleted = ref(false);

// 카드 셔플 함수
const shuffleCards = () => {
    const duplicatedCards = [...cardImages, ...cardImages]; // 같은 이미지 두 개씩
    cards.value = duplicatedCards.sort(() => Math.random() - 0.5).map((card, index) => ({
        ...card,
        uniqueId: index,
        flipped: false,
        matched: false,
    }));
};

// 카드 선택 핸들러
const flipCard = (card) => {
    if (flippedCards.value.length === 2 || card.flipped || card.matched) return;

    card.flipped = true;
    flippedCards.value.push(card);

    if (flippedCards.value.length === 2) {
        moves.value++;
        checkForMatch();
    }
};

// 두 개의 카드 비교
const checkForMatch = () => {
    const [first, second] = flippedCards.value;

    if (first.id === second.id) {
        first.matched = true;
        second.matched = true;
        matchedCards.value.push(first, second);
    } else {
        setTimeout(() => {
            first.flipped = false;
            second.flipped = false;
        }, 1000);
    }

    flippedCards.value = [];

    if (matchedCards.value.length === cards.value.length) {
        gameCompleted.value = true;
    }
};

// 게임 재시작
const resetGame = () => {
    gameCompleted.value = false;
    moves.value = 0;
    matchedCards.value = [];
    flippedCards.value = [];
    shuffleCards();
};

// 초기화
onMounted(shuffleCards);
</script>

<template>
    <div class="min-h-screen flex flex-col items-center bg-gray-100 py-10">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">🃏 Memory Game</h1>

        <!-- 게임 완료 메시지 -->
        <div v-if="gameCompleted" class="bg-green-500 text-white px-6 py-3 rounded-lg text-xl">
            🎉 축하합니다! 게임을 완료했습니다! <button @click="resetGame" class="ml-3 bg-white text-green-700 px-3 py-1 rounded">다시하기</button>
        </div>

        <!-- 게임 보드 -->
        <div class="grid grid-cols-4 gap-4 mt-6">
            <div
                v-for="card in cards"
                :key="card.uniqueId"
                class="w-24 h-32 bg-white shadow-md rounded-lg flex items-center justify-center cursor-pointer transition"
                :class="{ 'bg-gray-300': card.flipped || card.matched }"
                @click="flipCard(card)"
            >
                <img v-if="card.flipped || card.matched" :src="card.image" class="w-20 h-28 object-cover" />
                <div v-else class="w-full h-full bg-blue-500 rounded-lg"></div>
            </div>
        </div>

        <!-- 게임 정보 -->
        <div class="mt-6 text-lg">
            <p>🔄 시도 횟수: <span class="font-semibold">{{ moves }}</span></p>
        </div>

        <!-- 돌아가기 버튼 -->
        <Link :href="route('play')" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            🔙 돌아가기
        </Link>
    </div>
</template>
