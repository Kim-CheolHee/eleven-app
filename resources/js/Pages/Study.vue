<script setup>
import { ref, computed } from "vue";

// 현재 환경에 따라 메인 페이지 링크 변경
const mainPageUrl = computed(() => {
    return window.location.hostname === "localhost" || window.location.hostname === "127.0.0.1"
        ? "http://127.0.0.1:8000/"
        : "https://mica92.com/";
});

// 현재 선택된 학습 콘텐츠
const selectedTopic = ref("intro");

// 학습 목차 목록
const topics = [
    { id: "intro", title: "학습 소개" },
    { id: "html", title: "HTML 기초" },
    { id: "css", title: "CSS 디자인" },
    { id: "js", title: "JavaScript 개요" },
    { id: "vue", title: "Vue.js 시작하기" },
    { id: "practice", title: "실습 예제" },
];

// 학습 콘텐츠
const content = {
    intro: "온라인 학습 공간에 오신 것을 환영합니다! 여기서는 웹 개발을 쉽게 배울 수 있어요.",
    html: "HTML(HyperText Markup Language)은 웹 페이지의 구조를 만드는 언어입니다.",
    css: "CSS(Cascading Style Sheets)는 웹 사이트의 디자인과 스타일을 정의하는 언어입니다.",
    js: "JavaScript는 웹 페이지에 동적인 기능을 추가하는 프로그래밍 언어입니다.",
    vue: "Vue.js는 프론트엔드 개발을 쉽게 해주는 JavaScript 프레임워크입니다.",
    practice: "배운 내용을 직접 실습해 보세요! 간단한 프로젝트를 만들어 보세요.",
};
</script>

<template>
    <div class="min-h-screen bg-gray-100 flex">
        <!-- 📌 목차 (1/4) -->
        <aside class="w-1/4 bg-white shadow-lg p-6 flex flex-col space-y-4">
            <!-- 🏠 메인 페이지 이동 버튼 -->
            <a :href="mainPageUrl"
                class="flex flex-col items-start bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600 transition">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    <span class="text-lg font-semibold">ໄປໜ້າຫຼັກ</span>
                </div>
                <span class="text-sm text-white/80 ml-8">(Go to Main Page)</span>
            </a>

            <!-- 학습 목차 -->
            <h2 class="text-xl font-semibold">📌 학습 목차</h2>
            <ul class="space-y-2">
                <li v-for="topic in topics" :key="topic.id">
                    <button
                        @click="selectedTopic = topic.id"
                        :class="['w-full text-left px-4 py-3 rounded-lg text-lg font-medium', selectedTopic === topic.id ? 'bg-blue-500 text-white' : 'bg-gray-200 hover:bg-gray-300']">
                        {{ topic.title }}
                    </button>
                </li>
            </ul>
        </aside>

        <!-- 📚 학습 콘텐츠 (3/4) -->
        <main class="w-3/4 p-10">
            <h1 class="text-3xl font-bold mb-6">{{ topics.find(t => t.id === selectedTopic)?.title }}</h1>
            <p class="text-lg text-gray-700">{{ content[selectedTopic] }}</p>
        </main>
    </div>
</template>
