<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, usePage, router } from "@inertiajs/vue3";
import { ref, computed } from "vue";

// 서버에서 전달된 공지사항 목록 가져오기
const page = usePage();
const announcements = computed(() => page.props.announcements || []);

// 공지사항 입력 폼 (새로운 공지 등록용)
const form = useForm({
    title: "",
    content: "",
    file: null,
});

// 수정 모드 관련 상태값
const editMode = ref(null); // 현재 수정 중인 공지사항 ID
const editForm = useForm({ title: "", content: "", file: null });

// 선택한 파일명 표시
const fileInput = ref(null);
const selectedFileName = ref(""); // 선택된 파일명 저장

const handleFileUpload = (event) => {
    const file = event.target.files[0];
    form.file = file;
    selectedFileName.value = file ? file.name : "";
};

// 공지사항 등록 핸들러
const submit = () => {
    form.post(route("announcement.store"), {
        onSuccess: () => {
            form.reset();
            selectedFileName.value = "";
        },
    });
};

// 공지사항 삭제 핸들러
const deleteAnnouncement = (id) => {
    if (confirm("⚠️ 해당 공지사항을 삭제하시겠습니까?")) {
        router.delete(route("announcement.destroy", { id }), {
            onSuccess: () => {
                console.log("공지사항 삭제 성공!");
            },
            onError: (errors) => {
                console.error("공지사항 삭제 실패!", errors);
            },
        });
    }
};

// 수정 모드 활성화
const enableEditMode = (announcement) => {
    editMode.value = announcement.id;
    editForm.title = announcement.title;
    editForm.content = announcement.content;
    editForm.file = null;
};

// 수정 취소
const cancelEdit = () => {
    editMode.value = null;
};

// 수정 완료 후 저장
const updateAnnouncement = (id) => {
    editForm.patch(route("announcement.update", { id }), {
        onSuccess: () => {
            editMode.value = null;
        },
        onError: (errors) => {
            console.error("공지사항 수정 실패!", errors);
        },
    });
};

// 줄바꿈을 <br>로 변환하는 함수
const formatContent = (content) => {
    if (!content) return "";
    return content.replace(/\n/g, "<br>");
};
</script>

<template>
    <Head title="공지사항 관리" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                📢 공지사항 관리
            </h2>
        </template>

        <div class="py-12 flex flex-col items-center space-y-6">
            <!-- 공지사항 작성 폼 -->
            <div class="w-full md:w-1/2 bg-white border border-gray-300 rounded-xl shadow-md p-6">
                <form @submit.prevent="submit" class="space-y-4">
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

                    <div>
                        <label for="file-upload"
                            class="border border-gray-300 p-3 rounded-lg w-full text-gray-600 cursor-pointer bg-gray-100 hover:bg-gray-200 transition block">
                            📎 파일 첨부
                        </label>
                        <input id="file-upload" ref="fileInput" type="file" @change="handleFileUpload" class="hidden" />

                        <p v-if="selectedFileName" class="mt-2 text-sm text-gray-700">
                            ✅ 선택된 파일: <span class="font-semibold">{{ selectedFileName }}</span>
                        </p>
                    </div>

                    <button
                        type="submit"
                        class="bg-blue-500 text-white w-full py-3 rounded-lg text-lg font-semibold hover:bg-blue-600 transition">
                        등록
                    </button>
                </form>
            </div>

            <!-- 공지사항 목록 -->
            <div class="w-full md:w-3/4 bg-white border border-gray-300 rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">📜 등록된 공지사항</h3>

                <ul v-if="announcements.length" class="space-y-3">
                    <li v-for="announcement in announcements" :key="announcement.id"
                        class="flex flex-col md:flex-row md:items-center justify-between p-4 border rounded-lg bg-gray-50">
                        <!-- 수정 모드 -->
                        <div v-if="editMode === announcement.id" class="w-full">
                            <input v-model="editForm.title" class="border border-gray-300 p-2 rounded w-full mb-2" />
                            <textarea v-model="editForm.content" rows="3" class="border border-gray-300 p-2 rounded w-full"></textarea>

                            <div class="flex gap-2 mt-2">
                                <button @click="updateAnnouncement(announcement.id)"
                                    class="bg-green-500 text-white px-3 py-2 rounded hover:bg-green-600">
                                    저장
                                </button>
                                <button @click="cancelEdit" class="bg-gray-500 text-white px-3 py-2 rounded hover:bg-gray-600">
                                    취소
                                </button>
                            </div>
                        </div>

                        <!-- 일반 모드 -->
                        <div v-else>
                            <p class="text-lg font-semibold">{{ announcement.title }}</p>
                            <p class="text-gray-600 text-sm" v-html="formatContent(announcement.content)"></p>
                            <div v-if="announcement.file_path" class="mt-1">
                                <a :href="`/storage/${announcement.file_path}`" class="text-blue-500" download>
                                    📎 {{ announcement.file_path.split('/').pop() }}
                                </a>
                            </div>

                            <div class="flex gap-2 mt-2">
                                <button @click="enableEditMode(announcement)" class="text-yellow-500 hover:text-yellow-700">✏ 수정</button>
                                <button @click="deleteAnnouncement(announcement.id)" class="text-red-500 hover:text-red-700">🗑 삭제</button>
                            </div>
                        </div>
                    </li>
                </ul>
                <p v-else class="text-gray-500 text-center">❌ 등록된 공지사항이 없습니다.</p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
