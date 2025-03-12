<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { computed } from 'vue';

// 현재 환경에 따라 메인 페이지 링크 변경
const mainPageUrl = computed(() => {
    return window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1'
        ? 'http://127.0.0.1:8000/'
        : 'https://mica92.com/';
});

// 페이지네이션 및 네비게이션을 위한 함수 추가
const navigate = (url) => {
    if (url) {
        router.get(url);
    }
};

// 게시글 데이터 Props
const props = defineProps({
    posts: {
        type: Object,
        default: () => ({
            data: [],
            links: [],
        }),
    },
});

// 게시글 작성 폼
const form = useForm({
    title: "",
    content: "",
    author: "",
    password: "",
    file: null,
});

// 파일 업로드를 위한 ref
const fileInput = ref(null);

// 파일 업로드 핸들러
const handleFileUpload = (event) => {
    const selectedFile = event.target.files[0];

    if (selectedFile) {
        const fileSize = selectedFile.size / 1024 / 1024; // MB 단위
        if (fileSize > 5) {
            alert("❌ ໄຟລ໌ໃຫຍ່ເກີນ 5MB, ກະລຸນາເລືອກໄຟລ໌ທີ່ໜ້ອຍກວ່າ (File size exceeds 5MB. Please select a smaller file.)");
            fileInput.value = null; // 파일 선택 초기화
            form.file = null;
        } else {
            form.file = selectedFile;
        }
    }
};

// 게시글 제출 핸들러
const submit = () => {
    // ❗ 비밀번호가 숫자가 아니면 경고창 표시 후 return
    if (!/^\d{4}$/.test(form.password)) {
        alert("⚠️ ລະຫັດຕ້ອງເປັນຈຳນວນ 4 ຕົວເລກ (Password must be a 4-digit number.)");
        return;
    }

    const formData = new FormData();
    Object.keys(form).forEach((key) => {
        if (form[key]) formData.append(key, form[key]);
    });

    router.post(route("class.four_one.store"), formData, {
        onSuccess: () => {
            form.reset();
            fileInput.value = null;
        },
    });
};

// 게시글 삭제 핸들러
const deletePost = (id) => {
    let password = prompt("🔑 ປ້ອນລະຫັດ 4 ຕົວເພື່ອລົບໂພສ (Enter 4-digit password to delete post):")?.trim();
    if (!password) return;

    if (!/^\d{4}$/.test(password)) {
        alert("⚠️ ລະຫັດຕ້ອງເປັນ 4 ຕົວເລກ (Password must be 4 digits.)");
        return;
    }

    form.password = password;
    form.delete(route("class.four_one.destroy", id), {
        onError: (errors) => alert(errors.password || "❌ ລົບບໍ່ສຳເລັດ (Failed to delete post.)"),
    });
};
</script>

<template>
    <div class="p-4 md:p-6 h-screen flex flex-col">
        <!-- 제목 & 메인페이지 링크 (반응형 적용) -->
        <div class="bg-gray-100 border border-gray-300 rounded-xl shadow-md mb-3 p-4 flex flex-col md:flex-row items-center md:justify-between">
            <a :href="mainPageUrl" class="text-blue-500 flex items-center space-x-2 hover:text-blue-700 transition mb-2 md:mb-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                <span>ໄປໜ້າຫຼັກ (Go to Main Page)</span>
            </a>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 text-center">ມ4 ທັບ 1</h1>
        </div>

        <!-- 게시글 목록 & 글 작성 폼 -->
        <div class="flex flex-col md:flex-row h-full gap-4">
            <!-- 게시글 목록 (반응형 적용) -->
            <div class="w-full md:w-1/2 pr-0 md:pr-4 h-full overflow-y-auto">
                <div v-if="posts.data.length">
                    <div v-for="post in posts.data" :key="post.id" class="border p-4 mb-2 rounded-lg">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                            <h2 class="text-xl font-bold">{{ post.title }}</h2>
                            <p class="text-gray-600">{{ post.author }}</p>
                            <p class="text-gray-500">{{ post.formatted_created_at }}</p>
                            <button @click="deletePost(post.id)" class="text-red-500 md:ml-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>
                        </div>
                        <p class="mt-2">{{ post.content }}</p>
                        <div v-if="post.file_path" class="mt-2">
                            <a :href="`/storage/${post.file_path}`" class="text-blue-500" download>
                                📎 {{ post.file_path.split("/").pop() }}
                            </a>
                        </div>
                    </div>
                </div>
                <p v-else class="text-gray-500 text-center">ຍັງບໍ່ມີໂພສ (No posts yet)</p>
            </div>

            <!-- 글 작성 폼 (반응형 적용) -->
            <div class="w-full md:w-1/2 h-full overflow-y-auto">
                <div class="bg-white border border-gray-300 rounded-xl shadow-md p-6">
                    <form @submit.prevent="submit" class="space-y-3">
                        <div class="flex flex-col md:flex-row gap-2">
                            <input v-model="form.author" type="text" placeholder="ຜູ້ຂຽນ (Author)"
                                class="border border-gray-300 p-3 rounded-lg w-full md:w-1/2 focus:outline-none focus:ring-2 focus:ring-blue-400" required />
                            <input v-model="form.password" type="password" placeholder="ລະຫັດຈຳນວນ 4 ຕົວເລກ (4-digit number password)"
                                class="border border-gray-300 p-3 rounded-lg w-full md:w-1/2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                required maxlength="4" />
                        </div>

                        <input v-model="form.title" type="text" placeholder="ຫົວຂໍ້ (Title)"
                            class="border border-gray-300 p-3 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-400" required />

                        <textarea v-model="form.content" placeholder="ເນື້ອໃນ (Content)" rows="4"
                            class="border border-gray-300 p-3 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-400 resize-none" required></textarea>

                        <div class="text-gray-600 text-sm text-center">
                            🎉 ທ່ານສາມາດໃຊ້ <a href="https://www.emojiall.com/th" target="_blank" class="text-blue-500 underline hover:text-blue-700">ອີໂມຈິ</a> ໃນໂພສຂອງທ່ານ!
                        </div>

                        <label for="file-upload" class="border border-gray-300 p-3 rounded-lg w-full text-gray-600 cursor-pointer bg-gray-100 hover:bg-gray-200 transition block">
                            📎 ເລືອກໄຟລ໌ (Select File)
                        </label>
                        <input id="file-upload" ref="fileInput" type="file" @change="handleFileUpload" class="hidden" />

                        <button type="submit"
                            class="bg-blue-500 text-white w-full py-3 rounded-lg text-lg font-semibold hover:bg-blue-600 transition">
                            ໂພສ (Submit)
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
