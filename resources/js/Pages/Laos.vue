<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Laos" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                디지털 세상에서 나만의 아이디어 그리기
            </h2>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                ໂລກດິຈິຕອນ ກັບການວາດຄວາມຄິດຂອງຂ້ອຍໃຫ້ເປັນຈິງ
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white">
                        <h2 class="text-2xl font-semibold mb-4">모바일 시대</h2>
                        <h2 class="text-xl font-serif mb-4">qr결제</h2>
                        <h2 class="text-xl font-serif mb-4">사용앱</h2>

                        <h2 class="text-2xl font-semibold mb-4">교육 프로그램 소개</h2>

                        <ul class="list-disc list-inside space-y-2">
                            <li>
                                <h3 class="text-xl font-semibold">Thunkable: 모바일 앱 개발</h3>
                                <p class="text-gray-700">학생들이 블록 코딩을 통해 쉽고 빠르게 모바일 앱을 개발할 수 있도록 지원합니다.</p>
                                <p class="text-gray-700">오늘 운세</p>
                                <p class="text-gray-700">생년월일 남 녀 이름 입력</p>
                            </li>
                            <li>
                                <h3 class="text-xl font-semibold">Scratch: 창의적 코딩</h3>
                                <p class="text-gray-700">기초적인 코딩 원리를 배우고, 재미있는 프로젝트를 만들며 논리적 사고를 키웁니다.</p>
                            </li>
                            <li>
                                <h3 class="text-xl font-semibold">Kahoot!: 재미있는 한국어 학습</h3>
                                <p class="text-gray-700">퀴즈 게임을 통해 학생들이 흥미롭게 한국어 단어와 문법을 배울 수 있도록 합니다.</p>
                            </li>
                            <li>
                                <h3 class="text-xl font-semibold">MS Office: 실무 소프트웨어 활용</h3>
                                <p class="text-gray-700">문서 작성, 데이터 정리, 프레젠테이션 제작 등 실무적인 소프트웨어 활용 능력을 기릅니다.</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
