<script setup>
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

// Props 정의
defineProps({
    koica164Times: {
        type: Array,
        required: true,
    },
});

// 색상 클래스를 동적으로 계산
const getColorClass = (index) => {
    const colors = [
        'text-red-600', // 대한민국
        'text-red-400', // 필리핀
        'text-orange-600', // 베트남/라오스/태국
        'text-orange-400', // 방글라데시/키르기스스탄
        'text-yellow-600', // 네팔
        'text-green-600', // 우간다/탄자니아
        'text-blue-400', // 르완다
        'text-blue-600', // 튀니지/카메룬
        'text-indigo-500', // 가나/세네갈
        'text-purple-400', // 볼리비아/도미니카공화국
        'text-purple-600', // 페루/콜롬비아
    ];
    return colors[index % colors.length];
};

// 국가 코드
const countryCodes = {
    '대한민국': 'KR',
    '필리핀': 'PH',
    '베트남/라오스/태국': ['VN', 'LA', 'TH'],
    '방글라데시/키르기스스탄': ['BD', 'KG'],
    '네팔': 'NP',
    '우간다/탄자니아': ['UG', 'TZ'],
    '르완다': 'RW',
    '튀니지/카메룬': ['TN', 'CM'],
    '가나/세네갈': ['GH', 'SN'],
    '볼리비아/도미니카공화국': ['BO', 'DO'],
    '페루/콜롬비아': ['PE', 'CO'],
};

// 국가 이름에 맞는 코드 반환
const getCountryCodes = (countryName) => {
    return countryCodes[countryName] || null;
};

// 국기 이미지 경로 반환
const getFlagImage = (countryCode) => {
    if (!countryCode) return null;
    return `/flags/${countryCode.toLowerCase()}.gif`;
};

// 이미지 로딩 상태 관리
const isImageLoaded = ref(false);

// 이미지 로드 완료 시 호출될 함수
const handleImageLoad = () => {
  isImageLoaded.value = true;
};
</script>

<template>
  <GuestLayout>
    <Head title="KOICA 164" />
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 dark:bg-gray-900 p-4">
      <h1 class="text-4xl font-bold text-black-800 dark:text-gray-100 mb-8">KOICA 164❤️</h1>
      <!-- 반응형 테이블 -->
      <div class="w-full max-w-screen-md overflow-x-auto">
        <table class="table-auto border-collapse border border-gray-300 dark:border-gray-700 w-full text-center">
          <thead>
            <tr class="bg-gray-200 dark:bg-gray-800">
              <th class="border border-gray-300 dark:border-gray-700 px-4 py-2">국 기</th>
              <th class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-sm md:text-base whitespace-pre-wrap tracking-tight">나라 이름</th>
              <th class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-sm md:text-base whitespace-nowrap tracking-tight">월 - 일</th>
              <th class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-sm md:text-base whitespace-nowrap tracking-tight">시 간</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(item, index) in koica164Times"
              :key="index"
              :class="index % 2 === 0 ? 'bg-white dark:bg-gray-800' : 'bg-gray-100 dark:bg-gray-700'"
            >
              <!-- Flag 컬럼 -->
              <td class="border border-gray-300 dark:border-gray-700 px-4 py-2 flex flex-col justify-center items-center gap-1">
                <template v-if="Array.isArray(getCountryCodes(item.country))">
                  <img
                    v-for="(code, idx) in getCountryCodes(item.country)"
                    :key="idx"
                    :src="getFlagImage(code)"
                    alt="Flag"
                    class="w-8 h-8"
                    v-if="isImageLoaded"
                  />
                  <img
                    v-for="(code, idx) in getCountryCodes(item.country)"
                    :key="idx"
                    :src="getFlagImage(code)"
                    alt="Flag"
                    class="w-8 h-8"
                    @load="handleImageLoad"
                    v-if="!isImageLoaded"
                  />
                </template>
                <template v-else>
                  <img
                    :src="getFlagImage(getCountryCodes(item.country))"
                    alt="Flag"
                    class="w-8 h-8"
                    v-if="isImageLoaded"
                  />
                  <img
                    :src="getFlagImage(getCountryCodes(item.country))"
                    alt="Flag"
                    class="w-8 h-8"
                    @load="handleImageLoad"
                    v-if="!isImageLoaded"
                  />
                </template>
              </td>
              <!-- Country 컬럼 -->
              <td :class="getColorClass(index)" class="font-bold border border-gray-300 dark:border-gray-700 px-2 py-1 text-sm md:text-base whitespace-pre-line">
                {{ item.country.replaceAll('/', '\n') }}
              </td>
              <!-- Date 컬럼 -->
              <td class="border border-gray-300 dark:border-gray-700 px-2 py-1 text-sm w-16">
                {{ item.time.substring(5, 10) }}
              </td>
              <!-- Time 컬럼 -->
              <td :class="getColorClass(index)" class="border border-gray-300 dark:border-gray-700 px-4 py-2">
                {{ item.time.substring(11, 16) }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </GuestLayout>
</template>
