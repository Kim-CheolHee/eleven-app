<script setup>
import { computed } from "@vue/reactivity";
import { Link } from "@inertiajs/vue3";

// 현재 환경에 따라 메인 페이지 링크 변경
const mainPageUrl = computed(() => {
    return window.location.hostname === "localhost" || window.location.hostname === "127.0.0.1"
        ? "http://127.0.0.1:8000/"
        : "https://mica92.com/";
});

// 게임 & 심리테스트 데이터
const games = [
    { id: 1, title: "Memory Game", image: "/images/games/memory-game/memory-game.png", route: "memory_game", isExternal: false },
    { id: 2, title: "Bingo", image: "/images/games/bingo/bingo.jpg", route: "bingo", isExternal: false },
    { id: 3, title: "Driving Car", image: "/images/games/driving-car.png", route: "https://slowroads.io/", isExternal: true },
    { id: 4, title: "Moving Sketch", image: "/images/games/moving-sketch.png", route: "https://sketch.metademolab.com/canvas", isExternal: true },
    { id: 5, title: "Radio", image: "/images/games/radio.png", route: "https://radio.garden/", isExternal: true },
    { id: 6, title: "Windy", image: "/images/games/windy.png", route: "https://www.windy.com/", isExternal: true },
];
</script>

<template>
    <div class="relative min-h-screen flex flex-col items-center">
        <!-- 배경 이미지 -->
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('/images/game_background.jpg');"></div>

        <!-- 반투명 오버레이 -->
        <div class="absolute inset-0 bg-black/40"></div>

        <!-- 제목 & 메인페이지 링크 -->
        <div class="relative z-10 bg-white/80 backdrop-blur-md border border-gray-300 rounded-xl shadow-md mb-6 p-4 grid grid-cols-1 md:grid-cols-3 items-center text-center w-full max-w-6xl">
            <!-- 메인 페이지 이동 -->
            <a :href="mainPageUrl" class="text-blue-500 flex items-center justify-center md:justify-start space-x-2 hover:text-blue-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                <span>ໄປໜ້າຫຼັກ (Go to Main Page)</span>
            </a>

            <!-- 중앙 제목 -->
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900">
                Mini Game World 🎮
            </h1>

            <!-- 빈 공간 -->
            <div class="hidden md:block"></div>
        </div>

        <!-- 게임 목록 -->
        <div class="relative z-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 w-full max-w-4xl">
            <template v-for="game in games" :key="game.id">
                <!-- 내부 라우트 -->
                <Link v-if="!game.isExternal" :href="route(game.route)" class="block group">
                    <div class="relative bg-gray-200 rounded-xl shadow-md overflow-hidden transition hover:shadow-lg hover:scale-105">
                        <img :src="game.image" alt="Game Image" class="w-full h-48 object-cover" />
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                            <span class="text-white text-xl font-bold">{{ game.title }}</span>
                        </div>
                    </div>
                </Link>

                <!-- 외부 링크 -->
                <a v-else :href="game.route" target="_blank" class="block group">
                    <div class="relative bg-gray-200 rounded-xl shadow-md overflow-hidden transition hover:shadow-lg hover:scale-105">
                        <img :src="game.image" alt="Game Image" class="w-full h-48 object-cover" />
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                            <span class="text-white text-xl font-bold">{{ game.title }}</span>
                        </div>
                    </div>
                </a>
            </template>
        </div>
    </div>
</template>
