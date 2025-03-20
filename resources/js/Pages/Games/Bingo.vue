<script setup>
import { ref, computed } from "vue";
import { Link } from "@inertiajs/vue3";

// 빙고판 데이터
const bingoGrid = ref([
    ["AI", "KOICA", "Cyber Security"],
    ["Big Data", "Cloud Computing", "IoT"],
    ["Blockchain", "5G", "E-Government"]
]);

// OX 퀴즈 문제
const questions = {
    "AI": { question: "인공지능은 기계가 학습할 수 있는 기술이다.", answer: "O" },
    "KOICA": { question: "KOICA는 민간 기업을 지원하는 기관이다.", answer: "X" },
    "Cyber Security": { question: "패스워드를 주기적으로 변경하는 것이 보안에 도움이 된다.", answer: "O" },
    "Big Data": { question: "빅데이터의 3V는 Velocity, Variety, Variable이다.", answer: "X" },
    "Cloud Computing": { question: "클라우드 서비스는 인터넷을 통해서만 접근할 수 있다.", answer: "O" },
    "IoT": { question: "IoT는 사물인터넷을 의미한다.", answer: "O" },
    "Blockchain": { question: "블록체인은 데이터를 수정하기 쉽게 만든 기술이다.", answer: "X" },
    "5G": { question: "5G는 4G보다 속도가 느리다.", answer: "X" },
    "E-Government": { question: "전자정부는 공공 행정을 디지털화한 시스템이다.", answer: "O" }
};

// 선택된 문제 & 정답 상태 관리
const selectedTopic = ref(null);
const userAnswer = ref(null);
const correctAnswers = ref([]);
const incorrectAnswers = ref([]);
const completedLines = ref([]);

// 문제 선택 시 실행
const selectCell = (topic) => {
    if (!correctAnswers.value.includes(topic) && !incorrectAnswers.value.includes(topic)) {
        selectedTopic.value = topic;
        userAnswer.value = null;
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

    // 대각선 체크 (좌상-우하)
    if (bingoGrid.value.every((row, i) => correctAnswers.value.includes(row[i]))) {
        count++;
    }

    // 대각선 체크 (우상-좌하)
    if (bingoGrid.value.every((row, i) => correctAnswers.value.includes(row[gridSize - 1 - i]))) {
        count++;
    }

    return count;
});

// 빙고 완성 체크
const checkBingo = () => {
    completedLines.value = [];
    const gridSize = bingoGrid.value.length;

    // 행 체크
    for (let i = 0; i < gridSize; i++) {
        if (bingoGrid.value[i].every(topic => correctAnswers.value.includes(topic))) {
            completedLines.value.push({ type: "row", index: i });
        }
    }

    // 열 체크
    for (let j = 0; j < gridSize; j++) {
        if (bingoGrid.value.every(row => correctAnswers.value.includes(row[j]))) {
            completedLines.value.push({ type: "col", index: j });
        }
    }

    // 대각선 체크
    if (bingoGrid.value.every((row, i) => correctAnswers.value.includes(row[i]))) {
        completedLines.value.push({ type: "diag", index: 0 });
    }
    if (bingoGrid.value.every((row, i) => correctAnswers.value.includes(row[gridSize - 1 - i]))) {
        completedLines.value.push({ type: "diag", index: 1 });
    }
};
</script>

<template>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 p-4 relative">
        <!-- 🔙 돌아가기 버튼 -->
        <div class="absolute top-4 left-4 md:top-2 md:left-4 z-10">
            <Link :href="route('play')" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                🔙 ກັບຄືນ (Go Back)
            </Link>
        </div>

        <h1 class="text-2xl font-bold mb-4">디지털 빙고 퀴즈 🎯</h1>

        <div class="relative">
            <!-- 빙고판 -->
            <div class="grid grid-cols-3 relative">
                <div v-for="(row, rowIndex) in bingoGrid" :key="rowIndex">
                    <div v-for="(topic, colIndex) in row" :key="colIndex"
                         @click="selectCell(topic)"
                         :class="correctAnswers.includes(topic) ? 'bg-green-500 text-white' : (incorrectAnswers.includes(topic) ? 'bg-red-500 text-white' : 'bg-blue-200')"
                         class="p-8 text-center border rounded-lg cursor-pointer hover:bg-blue-300 relative">
                        {{ topic }}
                    </div>
                </div>
            </div>

            <!-- 빙고 라인 표시 -->
            <div v-for="line in completedLines" :key="line.type + line.index"
                 class="absolute bg-red-500 opacity-75"
                 :class="{
                     'w-full h-2 top-[calc(33%*line.index+10%)] left-0': line.type === 'row',
                     'h-full w-2 left-[calc(33%*line.index+10%)] top-0': line.type === 'col',
                     'w-full h-2 top-[50%] left-0 rotate-45': line.type === 'diag' && line.index === 0,
                     'w-full h-2 top-[50%] left-0 -rotate-45': line.type === 'diag' && line.index === 1
                 }">
            </div>
        </div>

        <!-- 빙고 완성 개수 표시 -->
        <div class="mt-4 text-lg font-bold" v-if="completedBingos > 0">
            🎉 빙고 완성: {{ completedBingos }} 개 🎉
        </div>

        <!-- OX 퀴즈 문제 전체 화면 팝업 -->
        <div v-if="selectedTopic" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg text-center">
                <h2 class="text-lg font-bold mb-4">{{ questions[selectedTopic].question }}</h2>
                <div class="flex gap-4 justify-center">
                    <button @click="checkAnswer('O')" class="px-6 py-3 bg-green-500 text-white rounded-lg text-xl">O</button>
                    <button @click="checkAnswer('X')" class="px-6 py-3 bg-red-500 text-white rounded-lg text-xl">X</button>
                </div>
            </div>
        </div>
    </div>
</template>
