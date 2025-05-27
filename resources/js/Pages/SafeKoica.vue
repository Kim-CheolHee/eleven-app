<script setup>
import { onMounted, ref } from 'vue'
import { Head } from '@inertiajs/vue3'

const countryInfo = ref(null)
const countryCode = ref(null)

onMounted(async () => {
  try {
    const res = await fetch('https://ipapi.co/json/')
    const data = await res.json()
    countryCode.value = data.country

    const safetyRes = await fetch(`/api/safe-koica/${countryCode.value}`)
    const safetyData = await safetyRes.json()

    countryInfo.value = {
      country: safetyData.country,
      level: safetyData.travel_alert || '정보 없음',
      incident: safetyData.event || '정보 없음',
      danger: '추가 예정',
    }
  } catch (err) {
    console.error('국가 코드 조회 실패:', err)
    countryInfo.value = {
      country: '위치 확인 실패',
      level: '-',
      incident: '-',
      danger: '-',
    }
  }
})
</script>

<template>
  <Head title="Safe KOICA" />
  <div class="min-h-screen bg-white dark:bg-gray-900 p-6">
    <h1 class="text-3xl font-bold mb-4 text-center text-blue-700">🛡️ Safe KOICA</h1>

    <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-xl shadow mb-4">
      <p class="text-lg"><strong>국가:</strong> {{ countryInfo?.country }}</p>
      <p class="text-lg"><strong>여행경보:</strong> {{ countryInfo?.level }}</p>
      <p class="text-lg"><strong>사건사고:</strong> {{ countryInfo?.incident }}</p>
      <p class="text-lg"><strong>주의사항:</strong> {{ countryInfo?.danger }}</p>
    </div>

    <div class="text-gray-600 text-sm text-center">
      ※ 정보는 실시간 공공데이터를 기반으로 요약 제공됩니다.
    </div>
  </div>
</template>
