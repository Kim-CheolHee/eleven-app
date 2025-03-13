<script setup>
import { ref, computed, onMounted } from "vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";

// 서버에서 받아온 기존 기록 (순위표)
const page = usePage();
const rankings = ref(page.props.scores || []);

// 카드 이미지 리스트
const cardImages = [
    { id: 1, image: "/images/games/memory-game/card1.jpg" },
    { id: 2, image: "/images/games/memory-game/card2.jpg" },
    { id: 3, image: "/images/games/memory-game/card3.jpg" },
    { id: 4, image: "/images/games/memory-game/card4.jpg" },
    { id: 5, image: "/images/games/memory-game/card5.jpg" },
    { id: 6, image: "/images/games/memory-game/card6.jpg" },
];

// 게임 상태
const cards = ref([]);
const flippedCards = ref([]);
const matchedCards = ref([]);
const moves = ref(0);
const gameCompleted = ref(false);
const timer = ref(0);
const interval = ref(null);
const gameStarted = ref(false);
const recordSaved = ref(false);

// 카드 셔플 함수
const shuffleCards = () => {
    const duplicatedCards = [...cardImages, ...cardImages];
    cards.value = duplicatedCards.sort(() => Math.random() - 0.5).map((card, index) => ({
        ...card,
        uniqueId: index,
        flipped: false,
        matched: false,
    }));
};

// 타이머 시작
const startTimer = () => {
    if (!gameStarted.value) {
        gameStarted.value = true;
        interval.value = setInterval(() => {
            timer.value++;
        }, 1000);
    }
};

// 카드 선택 핸들러
const flipCard = (card) => {
    if (flippedCards.value.length === 2 || card.flipped || card.matched) return;
    if (!gameStarted.value) startTimer();

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
        endGame();
    }
};

// 게임 종료
const endGame = () => {
    clearInterval(interval.value);
    gameCompleted.value = true;
};

// 게임 기록 저장
const form = useForm({
    name: "",
    time: 0,
    moves: 0,
});

const saveRanking = () => {
    if (!form.name.trim()) {
        console.log("❌ 이름이 입력되지 않음!");
        return;
    }

    // 현재 게임 결과를 저장
    form.time = timer.value;
    form.moves = moves.value;

    form.post(route("memory_game.store"), {
        onSuccess: () => {
            console.log("✅ 기록 저장 성공!");
            form.reset();  // 이제 안전하게 reset 가능
            rankings.value = page.props.scores; // 최신 순위 데이터 업데이트
            recordSaved.value = true; // 기록 저장 후 입력 폼 숨김
        },
        onError: (errors) => {
            console.error("❌ 기록 저장 실패:", errors);
        }
    });
};

// 게임 재시작
const resetGame = () => {
    gameCompleted.value = false;
    gameStarted.value = false;
    timer.value = 0;
    moves.value = 0;
    matchedCards.value = [];
    flippedCards.value = [];
    recordSaved.value = false; // 다시 플레이할 수 있도록 초기화
    shuffleCards();
};

// 초기화
onMounted(shuffleCards);
</script>

<template>
    <div class="min-h-screen flex flex-col md:flex-row md:justify-start items-start bg-gray-100 py-12">
        <!-- 🔙 돌아가기 버튼 (화면 좌측 상단 고정) -->
        <div class="absolute top-4 left-4 md:top-2 md:left-4 z-10">
            <Link :href="route('play')" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                🔙 ກັບຄືນ (Go Back)
            </Link>
        </div>

        <!-- 🏆 순위표 (모바일: 게임 위, 데스크톱: 왼쪽 고정) -->
        <div class="w-full sm:w-80 bg-white shadow-md p-4 rounded-lg max-h-[400px] sm:max-h-[600px] overflow-auto mb-4 md:mb-0 md:ml-4">
            <h2 class="text-lg font-semibold mb-2">🏆 ຕາຕະລາງຄັ້ງລຳດັບ (Rankings)</h2>
            <table class="w-full text-left">
                <thead>
                    <tr>
                        <th class="border-b">ລຳດັບ (Rank)</th>
                        <th class="border-b">ຊື່ (Name)</th>
                        <th class="border-b">ເວລາ (sec)</th>
                        <th class="border-b">ພະຍາຍາມ (Moves)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(rank, index) in rankings.slice(0, 20)" :key="index">
                        <td class="border-b p-1 text-center">{{ index + 1 }}</td>
                        <td class="border-b p-1 text-center">{{ rank.name }}</td>
                        <td class="border-b p-1 text-center">{{ rank.time }}</td>
                        <td class="border-b p-1 text-center">{{ rank.moves }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- 🃏 게임 컨텐츠 (데스크톱에서 우측 정렬) -->
        <div class="flex flex-col items-center w-full md:ml-auto mr-24">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">🃏 Memory Game</h1>

            <!-- 게임 완료 메시지 -->
            <div v-if="gameCompleted" class="bg-green-500 text-white px-6 py-3 rounded-lg text-xl text-center mb-4">
                🎉 ຍິນດີດ້ວຍ! ເກມສຳເລັດແລ້ວ! (Congratulations! You completed the game!)<br />
                ⏳ <strong>ເວລາ:</strong> {{ timer }} ວິນາທີ | 🔄 <strong>ຄວາມພະຍາຍາມ:</strong> {{ moves }}

                <!-- 기록 저장 폼 (기록 저장 후 숨김) -->
                <div v-if="!recordSaved" class="mt-3 flex flex-col items-center min-w-[250px]">
                    <input
                        v-model="form.name"
                        type="text"
                        placeholder="이름 입력 (선택)"
                        class="p-2 border rounded text-black"
                    />
                    <button @click="saveRanking" class="mt-2 bg-white text-green-700 px-3 py-1 rounded">
                        ບັນທຶກ (Save)
                    </button>
                </div>
                <button @click="resetGame" class="mt-3 bg-white text-green-700 px-3 py-1 rounded">
                    ໃໝ່ (Retry)
                </button>
            </div>

            <!-- 🎴 게임 보드 (모바일: 2열, 태블릿: 3열, 데스크톱: 4열) -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mt-6">
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

            <!-- ⏳ 게임 정보 (경과시간 & 시도 횟수) -->
            <div class="mt-6 text-lg">
                <p>⏳ ເວລາ(sec): <span class="font-semibold">{{ timer }} ວິນາທີ</span></p>
                <p>🔄 ຄວາມພະຍາຍາມ(Moves): <span class="font-semibold">{{ moves }}</span></p>
            </div>
        </div>
    </div>
</template>

