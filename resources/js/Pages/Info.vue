<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const activeContent = ref(null);

const showContent = (content) => {
  activeContent.value = content;
};
</script>

<style scoped>
  ul {
    list-style: none;
    padding: 0;
  }

  li {
    position: relative;
    padding: 8px 12px;
    cursor: pointer;
    background-color: #f9fafb;
    transition: background-color 0.2s;
  }

  li::before {
    content: "▲"; /* 기본 상태 (채운 삼각형) */
    display: inline-block;
    margin-right: 8px;
    font-size: 14px;
    color: #4b5563;
    transition: transform 0.2s ease;
  }

  /* 클릭된 상태 (속이 빈 삼각형) */
  li.active::before {
    content: "▽"; /* 속이 빈 아래 삼각형 */
  }

  /* hover 및 클릭 시 배경 강조 */
  li:hover,
  li.active {
    background-color: #e5e7eb;
  }

  /* 큰 화면에서는 마진을 적용하고 모바일에서는 제거 */
  @media (min-width: 640px) {
    .remove-whitespace-on-mobile {
      margin-left: 16px; /* 원하는 마진 값 (예: 4는 1rem, 16은 4rem) */
    }
  }

  @media (max-width: 640px) {
    .remove-whitespace-on-mobile {
      margin-left: 0; /* 모바일에서는 마진을 제거 */
    }
  }
</style>

<template>
  <Head title="Info" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        자기소개
      </h2>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        ການແນະນໍາຕົນເອງ
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 items-center mb-6">
            <div class="flex flex-col sm:flex-row items-center">
              <img src="/images/profile.jpg" alt="image" class="rounded-xl w-40 h-45 object-cover shadow-lg mb-4 sm:mb-0">
              <div class="text-gray-800 ml-5 mt-5 sm:mt-0 flex flex-col justify-center">
                <p class="text-2xl font-semibold">ຄິມ ຊອນຮີ (ຊອນ) 김철희</p>
                <p class="text-2xl font-semibold">Kim Cheolhee</p>
                <p class="text-xl mt-1">ອາສາສະໝັກ ຄອມພິວເຕີ</p>
                <p class="text-xl mt-1">Computer Education / KOICA Volunteer</p>
                <p class="text-lg mt-1">📞 +856 20-5778-1515</p>
                <p class="text-lg">✉️ windowlife92@gmail.com</p>
              </div>
            </div>
            <div class="text-gray-800">
              <p class="text-xl font-semibold">▶ 경 력 <span class="ml-4">ປະຫວັດການເຮັດວຽກ</span></p>
              <p class="text-lg mt-1 ml-4 font-normal">
                - 03.2011 ~ 02.2015
                <span class="block sm:inline">학사학위 취득 (일본어 전공)</span>
                <span class="block sm:ml-4 remove-whitespace-on-mobile">
                  ຮຽນຈົບປະລິນຍາ ວິຊາພາສາຍີ່ປຸ່ນ
                </span>
              </p>

              <p class="text-lg ml-4 font-normal">
                - 03.2015 ~ 06.2022
                <span class="block sm:inline">대한민국 육군 장교</span>
                <span class="block sm:ml-4 remove-whitespace-on-mobile">
                  ນາຍທະຫານເກົາຫຼີ
                </span>
              </p>

              <p class="text-lg ml-4 font-normal">
                - 09.2022 ~ 04.2023
                <span class="block sm:inline">IoT 기반 웹서비스 개발자 과정 수료</span>
                <span class="block sm:ml-4 remove-whitespace-on-mobile">
                  ສຳເລັດຫຼັກສູດການພັດທະນາເວັບຂອງ IoT
                </span>
              </p>

              <p class="text-lg ml-4 font-normal">
                - 04.2023 ~ 03.2024
                <span class="block sm:inline">(주)DTWORESOURCE - ICT엔지니어링</span>
                <span class="block sm:ml-4 remove-whitespace-on-mobile">
                  ບໍລິສັດ DTWORESOURCE ວິສະວະກໍາ ICT
                </span>
              </p>
            </div>
          </div>

          <div class="bg-gray-50 p-6 rounded-lg">
            <ul class="text-gray-800">
              <li
                :class="{ active: activeContent === 'a' }"
                @click="showContent('a')"
              >
                사는 곳
              </li>
              <li
                :class="{ active: activeContent === 'b' }"
                @click="showContent('b')"
              >
                b
              </li>
              <li
                :class="{ active: activeContent === 'c' }"
                @click="showContent('c')"
              >
                c
              </li>
              <li
                :class="{ active: activeContent === 'd' }"
                @click="showContent('d')"
              >
                d
              </li>
              <li
                :class="{ active: activeContent === 'e' }"
                @click="showContent('e')"
              >
                e
              </li>
            </ul>

            <div v-if="activeContent === 'a'" class="mt-4">
              <p class="text-gray-600">a에 대한 상세 내용: ...</p>
            </div>
            <div v-if="activeContent === 'b'" class="mt-4">
              <h4 class="text-lg font-semibold text-gray-800">b</h4>
              <p class="text-gray-600">b에 대한 상세 내용: ...</p>
            </div>
            <div v-if="activeContent === 'c'" class="mt-4">
              <h4 class="text-lg font-semibold text-gray-800">c</h4>
              <p class="text-gray-600">c에 대한 상세 내용: ...</p>
            </div>
            <div v-if="activeContent === 'd'" class="mt-4">
              <h4 class="text-lg font-semibold text-gray-800">d</h4>
              <p class="text-gray-600">d에 대한 상세 내용: ...</p>
            </div>
            <div v-if="activeContent === 'e'" class="mt-4">
              <h4 class="text-lg font-semibold text-gray-800">e</h4>
              <p class="text-gray-600">e에 대한 상세 내용: ...</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
