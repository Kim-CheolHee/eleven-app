<script setup>
import { ref, computed } from "vue";

// 빙고판 데이터
const bingoGrid = ref([
    ["AI", "KOICA-2", "Cyber Security"],
    ["Big Data", "KOICA-1", "IoT"],
    ["Blockchain", "5G", "KOICA-3"]
]);

// OX 퀴즈 문제
const questions = {
    // KOICA 관련 문제 (3문제)
    "KOICA-1": {
        question: "KOICA supports Laos in digital transformation and education.",
        answer: "O" // 쉬움 ⭐
    },
    "KOICA-2": {
        question: "KOICA provides support only to private companies abroad.",
        answer: "X" // 중간 ⭐⭐
    },
    "KOICA-3": {
        question: "KOICA does not operate any volunteer programs like World Friends Korea in Laos.",
        answer: "X" // 어려움 ⭐⭐⭐
    },

    // 디지털위크 관련 문제 (6문제)
    "AI": {
        question: "AI was one of the discussion topics in the Digital Week forum in Laos.",
        answer: "O" // 쉬움 ⭐
    },
    "Cyber Security": {
        question: "Deepfake scams were not addressed in the Laos Digital Week discussions.",
        answer: "X" // 중간 ⭐⭐
    },
    "Big Data": {
        question: "Data Science Hackathon was part of the Laos Digital Week.",
        answer: "O" // 쉬움 ⭐
    },
    "IoT": {
        question: "IoT training was provided to government officials during the event.",
        answer: "O" // 중간 ⭐⭐
    },
    "Blockchain": {
        question: "The event included seminars on blockchain technology.",
        answer: "O" // 쉬움 ⭐
    },
    "5G": {
        question: "The main theme of Digital Week was promoting 5G in rural areas.",
        answer: "X" // 어려움 ⭐⭐⭐
    }
};

// 선택된 문제 & 정답 상태 관리
const selectedTopic = ref(null);
const correctAnswers = ref([]);
const incorrectAnswers = ref([]);

// 문제 선택 시 실행
const selectCell = (topic) => {
    if (!correctAnswers.value.includes(topic) && !incorrectAnswers.value.includes(topic)) {
        selectedTopic.value = topic;
    }
};

// 정답 확인
const checkAnswer = (answer) => {
    if (selectedTopic.value) {
        if (questions[selectedTopic.value].answer === answer) {
            correctAnswers.value.push(selectedTopic.value);
        } else {
            incorrectAnswers.value.push(selectedTopic.value);
        }
    }
    selectedTopic.value = null;
};

// 빙고 완성 개수 계산
const completedBingos = computed(() => {
    let count = 0;
    const gridSize = bingoGrid.value.length;

    // 행 체크
    for (let i = 0; i < gridSize; i++) {
        if (bingoGrid.value[i].every(topic => correctAnswers.value.includes(topic))) {
            count++;
        }
    }

    // 열 체크
    for (let j = 0; j < gridSize; j++) {
        if (bingoGrid.value.every(row => correctAnswers.value.includes(row[j]))) {
            count++;
        }
    }

    // 대각선 체크
    if (bingoGrid.value.every((row, i) => correctAnswers.value.includes(row[i]))) {
        count++;
    }
    if (bingoGrid.value.every((row, i) => correctAnswers.value.includes(row[gridSize - 1 - i]))) {
        count++;
    }

    return count;
});
</script>

<template>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 p-4 relative">
        <!-- 🔙 돌아가기 버튼 (주석 유지) -->
        <!-- <div class="absolute top-4 left-4 md:top-2 md:left-4 z-10">
            <Link :href="route('play')" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                🔙 돌아가기
            </Link>
        </div> -->

        <!-- 상단 이미지 (라오스 국기 + KOICA 로고) -->
        <div class="w-full flex justify-center items-center gap-6 mb-6">
            <img src="/images/games/bingo/plag_laos.gif" alt="라오스 국기" class="w-32 sm:w-40">
            <img src="/images/games/bingo/KOICA_Logo.png" alt="KOICA 로고" class="w-40 sm:w-48">
        </div>

        <h1 class="text-xl sm:text-2xl font-bold mb-6 text-center">Digital Bingo Quiz 🎯</h1>

        <!-- 빙고판 (간격 없이 3x3 형태 유지) -->
        <div class="grid grid-cols-3 w-fit mx-auto border border-gray-300 mb-6">
            <div v-for="(row, rowIndex) in bingoGrid" :key="rowIndex" class="contents">
                <div v-for="(topic, colIndex) in row" :key="colIndex"
                     @click="selectCell(topic)"
                     :class="correctAnswers.includes(topic) ? 'bg-green-500 text-white' : (incorrectAnswers.includes(topic) ? 'bg-red-500 text-white' : 'bg-blue-200')"
                     class="w-24 h-24 sm:w-28 sm:h-28 flex items-center justify-center border border-gray-300 cursor-pointer hover:bg-blue-300 text-sm sm:text-base text-center">
                    {{ topic }}
                </div>
            </div>
        </div>

        <!-- 빙고 완성 개수 표시 -->
        <div class="mt-4 text-base sm:text-lg font-bold text-center" v-if="completedBingos > 0">
            🎉 Completed Bingos: {{ completedBingos }} 🎉
        </div>

        <!-- OX 퀴즈 문제 전체 화면 팝업 -->
        <div v-if="selectedTopic" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 p-4">
            <div class="bg-white p-4 sm:p-6 rounded-lg shadow-lg max-w-sm sm:max-w-lg text-center">
                <h2 class="text-base sm:text-lg font-bold mb-4">{{ questions[selectedTopic].question }}</h2>
                <div class="flex gap-4 justify-center">
                    <button @click="checkAnswer('O')" class="px-6 sm:px-8 py-3 bg-green-500 text-white rounded-lg text-lg sm:text-xl">
                        O
                    </button>
                    <button @click="checkAnswer('X')" class="px-6 sm:px-8 py-3 bg-red-500 text-white rounded-lg text-lg sm:text-xl">
                        X
                    </button>
                </div>
            </div>
        </div>

        <!-- 하단 이미지 (WFK 로고) -->
        <div class="w-full flex justify-center mt-10">
            <img src="/images/games/bingo/WFK_CI.png" alt="World Friends Korea" class="w-40 sm:w-48">
        </div>
    </div>
</template>
