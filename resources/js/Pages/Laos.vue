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
                        <h2 class="text-2xl font-semibold mb-4">모바일 시대(ໄວທີເມືອງມືຖື)</h2>
                        <p class="text-xl font-serif">라오스 핀테크, 국영은행(BCEL) 주도로 발전 중.</p>
                        <p class="text-xl font-serif mb-4">ຟິນເທັກທີເຫົາລາວ, ທາງການທະນາຄານລາວ (BCEL) ນຳພາກວິທະຍາສາດ ກຳລັງພັດທະນາ.</p>
                        <p class="text-xl font-serif">현금 없는 사회로 가기 위한 라오스 정부 정책 하에, 모바일 관련 산업이 더욱 성장할 것으로 보입니다.</p>
                        <p class="text-xl font-serif mb-4">ໃນການພັດທະນາໃຫ້ທີ່ສັງຄົມບໍ່ມີລາງດັງເຊິ່ງຕາມນະໂຍບາຍລາວ, ອຸດົມກຳລັງພັດທະນາອຸດົມການຄວມສົມຫວັງຂອງສັງຄົມມືຖືແລະການປະຕິບັດງານ.</p>

                        <h2 class="text-2xl font-semibold mt-12 mb-4">청소년 주요 사용 앱(ແອັບທີ່ນັກຮຽນອາຫານປະຊາກອງ)</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div class="text-center">
                                <h3 class="text-lg font-semibold">인기 순위 / 여가 - 게임</h3>
                                <h3 class="text-lg font-semibold mb-2">ຄືບຄິດຂອງຄວາມຄິດ - ປຽດພິຈັງຂອງປິດ.</h3>
                                <img src="/images/app_1.jpg" alt="Popularity ranking" class="w-full aspect-[4/3] object-contain rounded-lg">
                                <h3 class="text-lg font-semibold mb-2">TikTok, YouTube / My Talking Tom, Picsart</h3>
                            </div>
                            <div class="text-center">
                                <h3 class="text-lg font-semibold">무료 / 사진</h3>
                                <h3 class="text-lg font-semibold mb-2">ຟຣີ / ສະຫັບກະທີໃນວຸທານ.</h3>
                                <img src="/images/app_2.jpg" alt="Free" class="w-full aspect-[4/3] object-contain rounded-lg">
                                <h3 class="text-lg font-semibold mb-2">DeepSeek, ThaID / Meitu, SnapEdit</h3>
                            </div>
                            <div class="text-center">
                                <h3 class="text-lg font-semibold">게임 / SNS</h3>
                                <h3 class="text-lg font-semibold mb-2">ປຽດພິຈັງຂອງພິກສາງ. / SNS</h3>
                                <img src="/images/app_3.jpg" alt="Game" class="w-full aspect-[4/3] object-contain rounded-lg">
                                <h3 class="text-lg font-semibold mb-2">Kodable Basics, Budge World / LINE, Gemini</h3>
                            </div>
                        </div>

                        <h2 class="text-2xl font-semibold mt-12 mb-4">교육 프로그램 소개(ການເກີດວາດສັຈກໄຂ)</h2>

                        <ul class="list-none list-inside space-y-6">
                            <li>
                                <h3 class="text-xl font-semibold mb-4">Thunkable: 모바일 앱 개발(ການຕະຫຸວກິດຜົນຍທີກະຊບຄສີ)</h3>
                                <p class="text-gray-700">학생들이 블록 코딩을 통해 쉽고 빠르게 모바일 앱을 개발할 수 있도록 지원합니다.</p>
                                <p class="text-gray-700">ການສະໜອງສົກກະກວມຮຽນຄວາມຄິດທັບຄົວຍຜົງເພີມຄິດຮີກມດ.</p>
                                <img src="/images/thunkable.jpg" alt="Thunkable" class="w-full max-w-2xl mt-2 rounded-lg mx-auto mb-8">
                            </li>
                            <li>
                                <h3 class="text-xl font-semibold mb-4">Scratch: 창의적 코딩(ຄິດຜົງຈະພາສາ)</h3>
                                <p class="text-gray-700">기초적인 코딩 원리를 배우고, 재미있는 프로젝트를 만들며 논리적 사고를 키웁니다.</p>
                                <p class="text-gray-700">ຮຽນຮູ້ຫຼັກການຂຽນຄົງກົດການ, ສ້າງໂປຣເຈັກທີ່ນັນໃຈແລະພັດທະນາຄວາມຄິດເຫົາ.</p>
                                <img src="/images/scratch.jpg" alt="Scratch" class="w-full max-w-2xl mt-2 rounded-lg mx-auto mb-8">
                            </li>
                            <li>
                                <h3 class="text-xl font-semibold mb-4">Kahoot!: 재미있는 한국어 학습(ການຮຽນພາສາເກົາຫີຫຼາຍຫນ້າສົນໃຈ)</h3>
                                <p class="text-gray-700">퀴즈 게임을 통해 학생들이 흥미롭게 한국어 단어와 문법을 배울 수 있도록 합니다.</p>
                                <p class="text-gray-700">ການເຫັົກປິດແກ້ຮຸນເກຍລົງວຽວງກວິເລກມີບູນເຫົາທັກຕົວອອກ.</p>
                                <img src="/images/kahoot.jpg" alt="Kahoot" class="w-full max-w-2xl mt-2 rounded-lg mx-auto mb-8">
                            </li>
                            <li>
                                <h3 class="text-xl font-semibold mb-4">MS Office: 실무 소프트웨어 활용(ການນຳໃຊ້ຊອບເວີທາງວຽກງານ)</h3>
                                <p class="text-gray-700">문서 작성, 데이터 정리, 프레젠테이션 제작 등 실무적인 소프트웨어 활용 능력을 기릅니다.</p>
                                <p class="text-gray-700">ການຂຽນເອກະສານ, ການຈັດການຂໍ້ມູນ, ການສ້າງພາບພະນັກງານເທົາກັບການນຳໃຊ້ຊອບເວີທາງວຽກງານ</p>
                                <img src="/images/ms_office.jpg" alt="MS Office" class="w-full max-w-2xl mt-2 rounded-lg mx-auto mb-8">
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
