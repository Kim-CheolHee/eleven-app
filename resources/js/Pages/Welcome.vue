<script setup>
import { Head, Link, usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";

// 서버에서 전달된 공지사항 목록 가져오기
const page = usePage();
const notices = computed(() => page.props.notices || []);

// 선택된 공지사항 ID (토글용)
const selectedNoticeId = ref(null);

// 줄바꿈을 <br>로 변환하는 함수
const formatContent = (content) => {
    if (!content) return "";
    return content.replace(/\n/g, "<br>");
};

defineProps({
    canLogin: { type: Boolean },
    canRegister: { type: Boolean },
    laravelVersion: { type: String, required: true },
    phpVersion: { type: String, required: true },
});

</script>

<template>
    <Head title="Welcome" />

    <div class="relative min-h-screen bg-cover bg-center" style="background-image: url('/images/thedsaban.jpg');">
        <!-- 반투명 오버레이 -->
        <div class="absolute inset-0 bg-black/50"></div>

        <div class="relative z-10 flex flex-col items-center min-h-screen text-white">
            <!-- 헤더 -->
            <header class="w-full max-w-7xl px-6 py-5 flex justify-between items-center">
                <h1 class="text-3xl font-bold drop-shadow-lg">📚 ຫ້ອງຮຽນຂອງ ຊອນ</h1>

                <nav v-if="canLogin" class="flex space-x-4">
                    <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="text-lg font-semibold hover:text-gray-300">
                        Dashboard
                    </Link>
                    <template v-else>
                        <Link :href="route('login')" class="text-lg font-semibold hover:text-gray-300">Log in</Link>
                    </template>
                </nav>
            </header>

            <!-- 메인 콘텐츠 -->
            <main class="flex flex-col items-center justify-center w-full max-w-5xl p-6">
                <!-- 페이지 이동 버튼 -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4 text-center">
                    <Link :href="route('play')" class="px-5 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg text-white text-lg">
                        Game 🎮
                    </Link>
                    <Link v-for="id in 4" :key="id" :href="route('class.board', { class_id: id })"
                        class="px-5 py-3 bg-green-600 hover:bg-green-700 rounded-lg text-white text-lg">
                        4/{{ id }}
                    </Link>
                    <Link :href="route('study')" class="px-5 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg text-white text-lg">
                        Study 📖
                    </Link>
                </div>

                <!-- 공지사항 섹션 -->
                <div class="w-full bg-white/80 backdrop-blur-md shadow-lg rounded-lg mt-6 p-6 text-gray-800">
                    <h2 class="text-2xl font-semibold text-center text-black mb-4">📢 ປະກາດ (Announcements)</h2>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- 공지사항 목록 (왼쪽) -->
                        <div class="col-span-1">
                            <ul class="space-y-2">
                                <li v-for="notice in notices" :key="notice.id">
                                    <div class="bg-gray-100 p-4 rounded-lg">
                                        <p class="text-xl font-semibold">{{ notice.title }}</p>
                                        <p class="text-lg text-gray-700" v-html="formatContent(notice.content)"></p>
                                        <div v-if="notice.file_path" class="mt-2">
                                            <a :href="'/storage/' + notice.file_path" target="_blank" class="text-blue-600 hover:underline">
                                                📎 {{ notice.file_path.split('/').pop() }}
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <!-- 공지사항 이미지 출력 (오른쪽) -->
                        <div class="col-span-1 bg-gray-200 rounded-lg flex flex-col items-center">
                            <div v-if="notices && notices.length" class="w-full space-y-2">
                                <template v-for="(notice, index) in notices" :key="index">
                                    <div v-if="notice?.image_path" class="w-full flex justify-center">
                                        <img :src="'/storage/' + notice.image_path"
                                            class="rounded-lg shadow-md max-h-40 object-contain w-full"
                                            alt="공지 이미지" />
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <!-- 푸터 -->
            <footer class="py-4 mt-auto text-center text-sm text-white/70">
                Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
            </footer>
        </div>
    </div>
</template>

<style scoped>
/* 공지사항 내용이 펼쳐질 때 자연스럽게 보이도록 트랜지션 추가 */
.fade-enter-active, .fade-leave-active {
    transition: all 0.3s ease-in-out;
}
.fade-enter-from, .fade-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}
</style>
