<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';

// 게시글 데이터 Props
const props = defineProps({
    posts: {
        type: Object,
        default: () => ({
            data: [],
            links: [],
        }),
    },
    class_id: [String, Number], // String도 허용하고 내부에서 변환
});

// `computed`를 사용하여 `class_id`를 Number로 변환
const classId = computed(() => Number(props.class_id));

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
const selectedFileName = ref(""); // 선택된 파일명을 저장

// 파일 업로드 핸들러
const handleFileUpload = (event) => {
    const selectedFile = event.target.files[0];

    if (selectedFile) {
        const fileSize = selectedFile.size / 1024 / 1024; // MB 단위
        if (fileSize > 5) {
            alert("❌ ໄຟລ໌ໃຫຍ່ເກີນ 5MB, ກະລຸນາເລືອກໄຟລ໌ທີ່ໜ້ອຍກວ່າ (File size exceeds 5MB. Please select a smaller file.)");
            fileInput.value = null; // 파일 선택 초기화
            form.file = null;
            selectedFileName.value = ""; // 파일명 초기화
        } else {
            form.file = selectedFile;
            selectedFileName.value = selectedFile.name; // 파일명 저장
        }
    }
};

// 게시글 제출 핸들러
const submit = () => {
    // 비밀번호 유효성 검사
    if (!/^\d{4}$/.test(form.password)) {
        alert("⚠️ 4자리 숫자 비밀번호를 입력해주세요.");
        return;
    }

    const formData = new FormData();
    Object.keys(form).forEach((key) => {
        if (form[key]) {
            formData.append(key, form[key]);
        }
    });

    // 여기에 `class_id` 추가
    formData.append("class_id", classId.value);

    // Ziggy에서 반환하는 URL 확인
    const routeUrl = route("class.board.store", { class_id: classId.value });

    // Axios POST 요청
    router.post(routeUrl, formData, {
        onSuccess: () => {
            console.log("게시글 등록 성공!");
            form.reset();
            fileInput.value = null;
        },
        onError: (errors) => {
            console.error("게시글 등록 실패!", errors);
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

    const routeUrl = route("class.board.destroy", { class_id: classId.value, post_id: id });

    form.delete(routeUrl, {
        onError: (errors) => alert(errors.password || "❌ ລົບບໍ່ສຳເລັດ (Failed to delete post.)"),
    });
};

// 줄바꿈을 <br>로 변환하는 함수
const formatContent = (content) => {
    if (!content) return "";
    return content.replace(/\n/g, "<br>");
};

// 수정 모드 관련 상태
const editMode = ref(null);
const editForm = useForm({
    title: "",
    content: "",
    password: " ", // 빈 문자열이 아닌 공백 추가
    file: null,
    file_path: "", // 기존 파일 경로 저장
});
const editSelectedFileName = ref("");

// 수정할 게시글 로드
const startEdit = (post) => {
    editMode.value = post.id;
    editForm.title = post.title;
    editForm.content = post.content;
    editForm.password = ""; // 비밀번호는 항상 새로 입력해야 함

    // 기존 파일 정보 저장
    editForm.file_path = post.file_path || "";
    editSelectedFileName.value = post.file_path ? post.file_path.split("/").pop() : "";
};

// 파일 업로드 핸들러
const handleEditFileUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        editForm.file = file;
        editSelectedFileName.value = file.name;
    }
};

// 게시글 수정 핸들러
const updatePost = (postId) => {
    if (!/^\d{4}$/.test(editForm.password.trim())) {
        alert("⚠️ ລະຫັດຕ້ອງເປັນ 4 ຕົວເລກ (Password must be 4 digits.)");
        return;
    }

    const formData = new FormData();
    formData.append("title", editForm.title);
    formData.append("content", editForm.content);
    formData.append("password", editForm.password.trim()); // 비밀번호 필수
    formData.append("class_id", classId.value);
    formData.append("_method", "PATCH"); // Laravel에서 PATCH로 인식하도록 추가

    if (editForm.file) {
        formData.append("file", editForm.file);
    } else if (editForm.file_path) {
        formData.append("file_path", editForm.file_path); // 기존 파일 유지
    }

    const routeUrl = route("class.board.update", { class_id: classId.value, post_id: postId });

    router.post(routeUrl, formData, {
        headers: { "Content-Type": "multipart/form-data" }, // 명시적으로 설정
        onSuccess: () => {
            editMode.value = null;
            editForm.reset();
            editSelectedFileName.value = "";
        },
        onError: (errors) => {
            alert(errors.password || "❌ 수정 실패");
        },
    });
};

</script>

<template>
    <div class="p-4 md:p-6 h-screen flex flex-col">
        <!-- 제목 & 메인페이지 링크 (반응형 적용) -->
        <div class="bg-gray-100 border border-gray-300 rounded-xl shadow-md mb-3 p-4 grid grid-cols-1 md:grid-cols-3 items-center text-center">
            <!-- 모바일: 메인 페이지 이동이 맨 위 / 데스크탑: 왼쪽 정렬 -->
            <a :href="mainPageUrl"
                class="text-blue-500 flex items-center justify-center md:justify-start space-x-2 hover:text-blue-700 transition order-1 md:order-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                <span>ໄປໜ້າຫຼັກ (Go to Main Page)</span>
            </a>

            <!-- 중앙 제목 (데스크탑에서도 정확히 중앙) -->
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 order-2 md:order-none">
                ມ4 ທັບ {{ class_id }}
            </h1>

            <!-- 오른쪽 빈 공간 (데스크탑 균형 유지) -->
            <div class="hidden md:block order-3"></div>
        </div>

        <!-- 게시글 목록 & 글 작성 폼 -->
        <div class="flex flex-col md:flex-row h-full gap-4">
            <!-- 게시글 목록 (반응형 적용) -->
            <div class="w-full md:w-1/2 pr-0 md:pr-4 h-full overflow-y-auto">
                <div v-if="posts.data.length">
                    <div v-for="post in posts.data" :key="post.id" class="border p-4 mb-2 rounded-lg">
                        <!-- 수정 모드가 아닐 때 -->
                        <template v-if="editMode !== post.id">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                                <h2 class="text-xl font-bold">{{ post.title }}</h2>
                                <p class="text-gray-600">{{ post.author }}</p>
                                <p class="text-gray-500">{{ post.formatted_created_at }}</p>

                                <!-- 버튼 그룹 (수정, 삭제) -->
                                <div class="flex gap-2">
                                    <button @click="startEdit(post)" class="text-yellow-500 hover:text-yellow-700 text-lg">✏️</button>
                                    <button @click="deletePost(post.id)" class="text-red-500 hover:text-red-700 text-lg">🗑</button>
                                </div>
                            </div>
                            <p class="mt-2" v-html="formatContent(post.content)"></p>
                            <div v-if="post.file_path" class="mt-2">
                                <a :href="`/storage/${post.file_path}`" class="text-blue-500" download>
                                    📎 {{ post.file_path.split("/").pop() }}
                                </a>
                            </div>
                        </template>
                        <!-- 수정 모드일 때 -->
                        <template v-else>
                            <div class="space-y-3 bg-gray-50 p-4 rounded-lg shadow-md">
                                <input v-model="editForm.title" type="text" class="border p-3 w-full rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="ຫົວຂໍ້ (Title)" />
                                <textarea v-model="editForm.content" class="border p-3 w-full rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 resize-none" rows="4" placeholder="ເນື້ອໃນ (Content)"></textarea>
                                <input v-model="editForm.password" type="password" placeholder="ລະຫັດຈຳນວນ 4 ຕົວເລກ (4-digit number password)" class="border p-3 w-full rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />
                                <!-- 파일 첨부 -->
                                <label for="edit-file-upload" class="border border-gray-300 p-3 rounded-lg w-full text-gray-600 cursor-pointer bg-gray-100 hover:bg-gray-200 transition block">
                                    📎 ເລືອກໄຟລ໌ (Select File)
                                </label>
                                <input id="edit-file-upload" type="file" @change="handleEditFileUpload" class="hidden" />
                                <!-- 선택된 파일명 표시 -->
                                <p v-if="editSelectedFileName" class="mt-2 text-sm text-gray-700">
                                    ✅ **ໄຟລ໌ທີ່ເລືອກ (Selected File):** <span class="font-semibold">{{ editSelectedFileName }}</span>
                                </p>
                                <!-- 버튼 그룹 (가운데 정렬) -->
                                <div class="flex justify-center gap-2">
                                    <button @click="updatePost(post.id)" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">💾 ບັນທຶກ (Save)</button>
                                    <button @click="editMode = null" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">❌ ຍົກເລີກ (Cancel)</button>
                                </div>
                            </div>
                        </template>
                    </div>
                    <!-- 페이지네이션 추가 -->
                    <div v-if="posts.links.length > 3" class="flex justify-center space-x-2 mt-4">
                        <button
                            v-for="(link, index) in posts.links"
                            :key="index"
                            @click="navigate(link.url)"
                            v-html="link.label"
                            :class="[
                                'px-4 py-2 border rounded',
                                link.active ? 'bg-blue-500 text-white' : 'bg-white text-gray-700',
                                link.url ? 'cursor-pointer' : 'opacity-50 cursor-not-allowed'
                            ]"
                            :disabled="!link.url"
                        ></button>
                    </div>
                </div>
                <p v-else class="text-gray-500 text-center">ຍັງບໍ່ມີໂພສ (No posts yet)</p>
            </div>

            <!-- 글 작성 폼 (반응형 적용) -->
            <div class="w-full md:w-1/2 h-full overflow-y-auto">
                <div class="bg-white border border-gray-300 rounded-xl shadow-md p-6">
                    <form @submit.prevent="submit" class="space-y-3">
                        <input type="hidden" v-model="form.class_id" />
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

                        <!-- 선택된 파일명 표시 -->
                        <p v-if="selectedFileName" class="mt-2 text-sm text-gray-700">
                            ✅ <span class="font-semibold">{{ selectedFileName }}</span>
                        </p>

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
