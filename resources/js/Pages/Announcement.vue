<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref } from "vue";

// 공지사항 입력 폼
const form = useForm({
    title: "",
    content: "",
    file: null,
});

// 선택한 파일명 표시
const fileInput = ref(null);
const selectedFileName = ref(""); // 선택된 파일명 저장

const handleFileUpload = (event) => {
    const file = event.target.files[0];
    form.file = file;
    selectedFileName.value = file ? file.name : ""; // 선택된 파일명 업데이트
};

// 제출 핸들러
const submit = () => {
    form.post(route("announcement.store"), {
        onSuccess: () => {
            form.reset();
            selectedFileName.value = ""; // 제출 후 파일명 초기화
        },
    });
};
</script>

<template>
    <Head title="공지사항 작성" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                📢 공지사항 작성
            </h2>
        </template>

        <div class="py-12 flex justify-center">
            <div class="w-full md:w-1/2 bg-white border border-gray-300 rounded-xl shadow-md p-6">
                <form @submit.prevent="submit" class="space-y-4">
                    <!-- 제목 입력 -->
                    <div>
                        <label class="block text-gray-700 font-semibold">제목</label>
                        <input
                            v-model="form.title"
                            type="text"
                            placeholder="공지사항 제목을 입력하세요"
                            class="border border-gray-300 p-3 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-400"
                            required
                        />
                    </div>

                    <!-- 내용 입력 -->
                    <div>
                        <label class="block text-gray-700 font-semibold">내용</label>
                        <textarea
                            v-model="form.content"
                            placeholder="공지사항 내용을 입력하세요"
                            rows="4"
                            class="border border-gray-300 p-3 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-400 resize-none"
                            required
                        ></textarea>
                    </div>

                    <!-- 파일 업로드 -->
                    <div>
                        <label for="file-upload"
                            class="border border-gray-300 p-3 rounded-lg w-full text-gray-600 cursor-pointer bg-gray-100 hover:bg-gray-200 transition block">
                            📎 파일 첨부
                        </label>
                        <input id="file-upload" ref="fileInput" type="file" @change="handleFileUpload" class="hidden" />

                        <!-- 선택된 파일명 표시 -->
                        <p v-if="selectedFileName" class="mt-2 text-sm text-gray-700">
                            ✅ 선택된 파일: <span class="font-semibold">{{ selectedFileName }}</span>
                        </p>
                    </div>

                    <!-- 제출 버튼 -->
                    <button
                        type="submit"
                        class="bg-blue-500 text-white w-full py-3 rounded-lg text-lg font-semibold hover:bg-blue-600 transition">
                        등록
                    </button>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
