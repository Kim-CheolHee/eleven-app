<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const activeContent = ref(null);
const activeImage_map = ref('/images/map_world.jpg');
const activeImage_uni = ref('/images/uni_1.jpg');
const activeImage_mil = ref('/images/mil_1.jpg');
const activeImage_devel = ref('/images/devel_1.jpg');
const activeImage_koica = ref('/images/koica_1.jpg');

// 내용 토글 함수
const showContent = (content) => {
  if (activeContent.value === content) {
    activeContent.value = null;
  } else {
    activeContent.value = content;
  }
};

// 이미지 클릭 함수
const changeImage_map = () => {
  if (activeImage_map.value === '/images/map_world.jpg') {
    activeImage_map.value = '/images/map_korea.jpg';
  } else if (activeImage_map.value === '/images/map_korea.jpg') {
    activeImage_map.value = '/images/gwangju.jpg';
  } else {
    activeImage_map.value = '/images/map_world.jpg';
  }
};
const changeImage_uni = () => {
  if (activeImage_uni.value === '/images/uni_1.jpg') {
    activeImage_uni.value = '/images/uni_2.jpg';
  } else {
    activeImage_uni.value = '/images/uni_1.jpg';
  }
};
const changeImage_mil = () => {
  if (activeImage_mil.value === '/images/mil_1.jpg') {
    activeImage_mil.value = '/images/mil_2.jpg';
  } else {
    activeImage_mil.value = '/images/mil_1.jpg';
  }
};
const changeImage_devel = () => {
  if (activeImage_devel.value === '/images/devel_1.jpg') {
    activeImage_devel.value = '/images/devel_2.jpg';
  } else {
    activeImage_devel.value = '/images/devel_1.jpg';
  }
};
const changeImage_koica = () => {
  if (activeImage_koica.value === '/images/koica_1.jpg') {
    activeImage_koica.value = '/images/koica_2.jpg';
  } else {
    activeImage_koica.value = '/images/koica_1.jpg';
  }
};

const openYoutubeLink1 = () => {
  window.open('https://www.youtube.com/watch?v=Q3lfAyjtu5U', '_blank');
};

const openYoutubeLink2 = () => {
  window.open('https://www.youtube.com/shorts/hIaWihW3Ci8', '_blank');
};

const openYoutubeLink3 = () => {
  window.open('https://youtu.be/XRJYENv5Qkg', '_blank');
};
</script>

<style>
  ul {
    list-style: none;
    padding: 0;
  }

  li {
    position: relative;
    padding: 2px 12px;
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
</style>

<template>
  <Head>
    <title>Info</title>
    <link rel="preload" href="/images/map_world.jpg" as="image">
    <link rel="preload" href="/images/map_korea.jpg" as="image">
    <link rel="preload" href="/images/uni_1.jpg" as="image">
    <link rel="preload" href="/images/uni_2.jpg" as="image">
    <link rel="preload" href="/images/mil_1.jpg" as="image">
    <link rel="preload" href="/images/mil_2.jpg" as="image">
    <link rel="preload" href="/images/devel_1.jpg" as="image">
    <link rel="preload" href="/images/devel_2.jpg" as="image">
    <link rel="preload" href="/images/koica_1.jpg" as="image">
    <link rel="preload" href="/images/koica_2.jpg" as="image">
    <link rel="preload" href="/images/gwangju.jpg" as="image">
  </Head>

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
              <p class="text-lg ml-4 font-normal">
                - 04.2023 ~ 03.2024
                <span class="block sm:inline">(주)DTWORESOURCE - ICT엔지니어링</span>
                <span class="block sm:ml-44">
                  ບໍລິສັດ DTWORESOURCE ວິສະວະກໍາ ICT
                </span>
              </p>
              <p class="text-lg ml-4 font-normal">
                - 09.2022 ~ 04.2023
                <span class="block sm:inline">IoT 기반 웹서비스 개발자 과정 수료</span>
                <span class="block sm:ml-44">
                  ສຳເລັດຫຼັກສູດການພັດທະນາເວັບຂອງ IoT
                </span>
              </p>
              <p class="text-lg ml-4 font-normal">
                - 03.2015 ~ 06.2022
                <span class="block sm:inline">대한민국 육군 장교</span>
                <span class="block sm:ml-44">
                  ນາຍທະຫານເກົາຫຼີ
                </span>
              </p>
              <p class="text-lg mt-1 ml-4 font-normal">
                - 03.2011 ~ 02.2015
                <span class="block sm:inline">학사학위 취득 (일본어 전공)</span>
                <span class="block sm:ml-44">
                  ຮຽນຈົບປະລິນຍາຕີ ວິຊາພາສາຍີ່ປຸ່ນ

                </span>
              </p>
            </div>
          </div>

          <div class="bg-gray-50 rounded-lg">
            <ul class="text-gray-800">
              <li :class="{ active: activeContent === 'a' }" @click="showContent('a')">사는 곳</li>
              <li :class="{ active: activeContent === 'b' }" @click="showContent('b')">대학 시절</li>
              <li :class="{ active: activeContent === 'c' }">
                <span @click="showContent('c')" class="cursor-pointer">군인 시절</span>
                <span @click="openYoutubeLink1" class="ml-2 cursor-pointer text-blue-600">🎥1</span>
                <span @click="openYoutubeLink2" class="ml-2 cursor-pointer text-blue-600">🎥2</span>
              </li>
              <li :class="{ active: activeContent === 'd' }" @click="showContent('d')">개발자</li>
              <li :class="{ active: activeContent === 'e' }">
                <span @click="showContent('e')" class="cursor-pointer">코이카</span>
                <span @click="openYoutubeLink3" class="ml-2 cursor-pointer text-blue-600">🎥</span>
              </li>
            </ul>

            <div v-if="activeContent === 'a'" class="mt-4">
              <img :src="activeImage_map" alt="Location Map" class="w-full h-auto rounded-lg shadow-md" @click="changeImage_map">
            </div>
            <div v-if="activeContent === 'b'" class="mt-4">
                <img :src="activeImage_uni" alt="university" class="w-full h-auto rounded-lg shadow-md" @click="changeImage_uni">
            </div>
            <div v-if="activeContent === 'c'" class="mt-4">
                <img :src="activeImage_mil" alt="army" class="w-full h-auto rounded-lg shadow-md" @click="changeImage_mil">
            </div>
            <div v-if="activeContent === 'd'" class="mt-4">
                <img :src="activeImage_devel" alt="army" class="w-full h-auto rounded-lg shadow-md" @click="changeImage_devel">
            </div>
            <div v-if="activeContent === 'e'" class="mt-4">
                <img :src="activeImage_koica" alt="army" class="w-full h-auto rounded-lg shadow-md" @click="changeImage_koica">
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
