<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const navigate = (url) => {
    if (url) {
        router.get(url);
    }
};

const props = defineProps({
    posts: {
        type: Object,
        default: () => ({
            data: [],
            links: [],
        }),
    },
});

const form = useForm({
    title: '',
    content: '',
    author: '',
    password: '',
});

const submit = () => {
    form.post(route('class.four_one.store'), {
        onSuccess: () => form.reset(),
    });
};

const deletePost = (id) => {
    let password = prompt("게시글 삭제를 위해 비밀번호를 입력하세요:");
    if (!password) return;

    password = password.trim();

    if (!/^\d{4}$/.test(password)) {
        alert("비밀번호는 4자리 숫자여야 합니다.");
        return;
    }

    // 새로운 form 객체 생성하여 요청 보내기
    const deleteForm = useForm({ password });

    deleteForm.delete(route('class.four_one.destroy', id), {
        onError: (errors) => alert(errors.password || '삭제에 실패했습니다.'),
    });
};
</script>

<template>
    <div class="p-6 h-screen flex flex-col">
        <a href="https://mica92.com/" class="text-blue-500 inline-block">메인 페이지로 가기</a>
        <h1 class="text-3xl font-bold mb-6 text-center">4학년 1반 게시판</h1>

        <div class="flex h-full">
            <!-- 좌측: 게시글 목록 -->
            <div class="w-1/2 pr-4 h-full overflow-y-auto">
                <div v-if="posts.data.length">
                    <div v-for="post in posts.data" :key="post.id" class="border p-4 mb-2">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-bold flex-[2]">{{ post.title }}</h2>
                            <p class="text-gray-600 flex-[1] text-center">{{ post.author }}</p>
                            <p class="text-gray-500 flex-[1] text-center">{{ post.formatted_created_at }}</p>
                            <button @click="deletePost(post.id)" class="text-red-500 ml-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>
                        </div>
                        <p class="mt-2">{{ post.content }}</p>
                    </div>
                </div>
                <p v-else class="text-gray-500">아직 게시글이 없습니다.</p>
                <!-- 페이지네이션 -->
                <div class="flex justify-center space-x-2 mt-4">
                    <button v-for="(link, index) in posts.links" :key="index" @click="navigate(link.url)" v-html="link.label"
                        :class="[
                            'px-4 py-2 border rounded',
                            link.active ? 'bg-blue-500 text-white' : 'bg-white text-gray-700',
                            link.url ? 'cursor-pointer' : 'opacity-50 cursor-not-allowed'
                        ]"
                        :disabled="!link.url"
                    ></button>
                </div>
            </div>


            <!-- 우측: 글 작성 폼 -->
            <div class="w-1/2 pl-4 h-full overflow-y-auto">
                <form @submit.prevent="submit" class="mb-6">
                    <input v-model="form.author" type="text" placeholder="작성자" class="border p-2 w-full mb-2" required />
                    <input v-model="form.password" type="password" placeholder="비밀번호 (4자리 숫자)" class="border p-2 w-full mb-2" required maxlength="4" />
                    <input v-model="form.title" type="text" placeholder="제목" class="border p-2 w-full mb-2" required />
                    <textarea v-model="form.content" placeholder="내용" class="border p-2 w-full mb-2" required></textarea>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2">글 작성</button>
                </form>
            </div>
        </div>
    </div>
</template>
