<script setup>
import { ref, computed, shallowRef, defineAsyncComponent, onMounted } from "vue";

// 현재 환경에 따라 메인 페이지 링크 변경
const mainPageUrl = computed(() => {
    return window.location.hostname === "localhost" || window.location.hostname === "127.0.0.1"
        ? "http://127.0.0.1:8000/"
        : "https://mica92.com/";
});

// 현재 선택된 학습 항목
const selectedTopic = ref("excel_intro");
const selectedComponent = shallowRef(null);

// 학습 항목 컴포넌트를 동적으로 불러오기
const loadComponent = async (topicId) => {
    selectedTopic.value = topicId;
    try {
        selectedComponent.value = defineAsyncComponent(() => import(`./Study/${topicId}.vue`));
    } catch (error) {
        console.error("컴포넌트를 불러오는 중 오류 발생:", error);
        selectedComponent.value = null;
    }
};

// 학습 목차 사이드바 열림/닫힘 상태
const isAsideOpen = ref(true);

// 사이드바 토글 함수
const toggleAside = () => {
    isAsideOpen.value = !isAsideOpen.value;
};

// 과별 학습 목차
const chapters = ref([
    {
        id: "chapter5",
        titleLa: "ບົດທີ 5 ຄວາມຮູ້ພື້ນຖານກ່ຽວກັບ Microsoft Excel",
        titleKr: "제5과 Microsoft Excel 기본",
        topics: [
            { id: "ExcelIntro", titleLa: "ການແນະນຳ Microsoft Excel", titleKr: "Microsoft Excel 소개" },
            { id: "ExcelWorkbook", titleLa: "Microsoft Excel ແລະ Workbook", titleKr: "Microsoft Excel과 Workbook" },
            { id: "ExcelNavigation", titleLa: "ການເຄື່ອນໄຫວ ແລະ ການເລື່ອນ Worksheet", titleKr: "이동 및 스크롤 Worksheet" },
            { id: "ExcelSelection", titleLa: "ເທັກນິກການເລືອກ", titleKr: "선택 기술" },
            { id: "ExcelEditing", titleLa: "ການແກ້ໄຂຂໍ້ມູນໃນ Worksheet", titleKr: "Worksheet 데이터 수정" },
            { id: "ExcelSerial", titleLa: "ການໃສ່ຂໍ້ມູນໂດຍໃຊ້ຄຳສັ່ງລຳດັບ", titleKr: "시리얼 명령을 이용한 데이터 입력" },
            { id: "ExcelSave", titleLa: "ບັນທຶກ Workbook", titleKr: "Workbook 저장" },
            { id: "ExcelOpen", titleLa: "ເປີດ Workbook ທີ່ບັນທຶກໄວ້", titleKr: "저장된 Workbook 열기" },
            { id: "ExcelCopyPaste", titleLa: "ການຄັດລອກ, ຕັດ, ວາງຂໍ້ມູນ", titleKr: "Data 복사, 잘라내기, 붙여넣기" },
            { id: "ExcelUndo", titleLa: "ໃຊ້ຄວາມສາມາດ Undo", titleKr: "되돌리기 기능 사용" },
            { id: "ExcelDelete", titleLa: "ການລຶບຂໍ້ມູນ", titleKr: "Data 삭제" },
            { id: "ExcelColumns", titleLa: "ການແຊກ ແລະ ລຶບ Columns", titleKr: "Columns 삽입과 삭제" },
            { id: "ExcelExit", titleLa: "ອອກຈາກ Excel", titleKr: "Excel 프로그램 종료" }
        ],
        isOpen: true
    },
    {
        id: "chapter6",
        titleLa: "ບົດທີ 6 ການຈັດຮູບແບບເຊວໃນ Microsoft Excel",
        titleKr: "제6과 Excel 셀 서식 지정",
        topics: [
            { id: "ExcelFormatMerge", titleLa: "ຄວາມສາມາດ Merge Cells", titleKr: "셀 병합" },
            { id: "ExcelFont", titleLa: "ປ່ຽນຟອນເທິງ", titleKr: "폰트 변경" },
            { id: "ExcelSorting", titleLa: "ຈັດລຽງຂໍ້ມູນ", titleKr: "Data 정렬" },
            { id: "ExcelColorFill", titleLa: "ປ່ຽນສີຟອນ ແລະ ສີເຕີມ", titleKr: "폰트 색상 변경 및 색 채우기" },
            { id: "ExcelMargin", titleLa: "ຕັ້ງຄ່າ ແລະ ຍົກເລີກຂອບເຂດ", titleKr: "여백 설정 및 해제" }
        ],
        isOpen: false
    },
    {
        id: "chapter7",
        titleLa: "ບົດທີ 7 ການນຳໃຊ້ຄວາມສາມາດຂອງ Excel",
        titleKr: "제7과 Excel 기능 활용",
        topics: [
            { id: "ExcelAutoSum", titleLa: "ໃຊ້ຟັງຊັນ Autosum ຄິດໄລນັບລວມ", titleKr: "Autosum 함수를 사용하여 합계 계산" },
            { id: "ExcelCustomFormula", titleLa: "ຂຽນສູດຄິດໄລຂອງຕົນເອງ", titleKr: "나만의 공식 작성" },
            { id: "ExcelPreview", titleLa: "ກວດສອບການພິມ ແລະ Preview", titleKr: "인쇄물 검토 및 미리보기" },
            { id: "ExcelPrint", titleLa: "ພິມເອກະສານ Excel", titleKr: "종이 페이지 인쇄" }
        ],
        isOpen: false
    },
    {
        id: "chapter8",
        titleLa: "ບົດທີ 8 ສ້າງການວາດແຜນໃນ Excel",
        titleKr: "제8과 Excel 차트 만들기",
        topics: [
            { id: "ExcelChartCreate", titleLa: "ໃຊ້ Chart Wizard ສ້າງແຜນພາບ", titleKr: "차트 마법사를 사용하여 차트 만들기" },
            { id: "ExcelChartEdit", titleLa: "ເຄື່ອນຍ້າຍ ແລະ ປ່ຽນຂະໜາດຂອງ Chart", titleKr: "차트 이동 및 크기 변경" }
        ],
        isOpen: false
    }
]);

// 과별 토글 함수
const toggleChapter = (id) => {
    const chapter = chapters.value.find(c => c.id === id);
    if (chapter) {
        chapter.isOpen = !chapter.isOpen;
    }
};

// 처음 페이지 로드시 ExcelIntro 불러오기
onMounted(() => {
    loadComponent("ExcelIntro");
});
</script>


<template>
    <div class="min-h-screen bg-gray-100 flex relative">
        <!-- 학습 목차 사이드바 -->
        <aside
            v-if="isAsideOpen"
            class="w-1/4 bg-white shadow-lg p-6 flex flex-col space-y-4 relative transition-all duration-300"
        >
            <a :href="mainPageUrl" class="flex flex-col items-start bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600 transition">
                <span class="text-lg font-semibold">ໄປໜ້າຫຼັກ (Go to Main Page)</span>
            </a>

            <h2 class="text-xl font-semibold">📌 ລາຍການຮຽນ 학습 목차</h2>
            <ul class="space-y-4">
                <li v-for="chapter in chapters" :key="chapter.id">
                    <button
                        @click="toggleChapter(chapter.id)"
                        class="w-full text-left px-4 py-3 rounded-lg text-lg font-semibold flex flex-col relative transition"
                        :class="chapter.isOpen ? 'bg-green-700 text-white' : 'bg-green-300 text-black hover:bg-green-400'"
                    >
                        <div class="flex justify-between items-center">
                            <div>
                                <span :class="chapter.isOpen ? 'text-white' : 'text-blue-600'">
                                    {{ chapter.titleLa }}
                                </span>
                                <br />
                                <span class="text-black">
                                    {{ chapter.titleKr }}
                                </span>
                            </div>
                            <!-- 화살표 아이콘 -->
                            <span class="text-xl" :class="chapter.isOpen ? 'text-white' : 'text-gray-700'">
                                {{ chapter.isOpen ? '▼' : '▲' }}
                            </span>
                        </div>
                    </button>

                    <ul v-if="chapter.isOpen" class="ml-4 space-y-2">
                        <li v-for="topic in chapter.topics" :key="topic.id">
                            <button
                                @click="loadComponent(topic.id)"
                                class="w-full text-left px-4 py-2 rounded-lg text-base flex flex-col"
                                :class="selectedTopic === topic.id ? 'bg-blue-500 text-white' : 'bg-gray-200 hover:bg-gray-300'"
                            >
                                <span :class="selectedTopic === topic.id ? 'text-white' : 'text-blue-600'">
                                    {{ topic.titleLa }}
                                </span>
                                <span class="text-black">
                                    {{ topic.titleKr }}
                                </span>
                            </button>
                        </li>
                    </ul>
                </li>
            </ul>
        </aside>

        <!-- 사이드바 토글 버튼 -->
        <button
            @click="toggleAside"
            class="fixed top-1/2 left-0 transform -translate-y-1/2 bg-gray-500 text-white p-2 rounded-r-lg shadow-md z-50 transition-all duration-300"
            :class="isAsideOpen ? 'left-[25%]' : 'left-0'"
        >
            {{ isAsideOpen ? '◀' : '▶' }}
        </button>

        <!-- 학습 콘텐츠 -->
        <main class="transition-all duration-300" :class="isAsideOpen ? 'w-3/4 p-10' : 'w-full p-10'">
            <component :is="selectedComponent" />
        </main>
    </div>
</template>
