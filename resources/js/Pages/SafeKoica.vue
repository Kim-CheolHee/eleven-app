<script setup>
import { onMounted, ref } from 'vue'
import { Head } from '@inertiajs/vue3'

const countryInfo = ref({
  country: '로딩 중...',
  level: '조회 중...',
  incident: '조회 중...',
  danger: '조회 중...',
  summary: '초기 정보를 불러오는 중입니다...',
  updated_at: '-',
})
const countryCode = ref(null)

// 앱 설치 관련
const showInstallButton = ref(false)
let deferredPrompt = null

onMounted(async () => {
  // 로컬 캐시 먼저 불러오기
  const cached = localStorage.getItem('safeKoicaCountryInfo')
  if (cached && cached !== 'undefined' && cached !== 'null') {
    try {
      countryInfo.value = JSON.parse(cached)
    } catch (e) {
      console.error('로컬 캐시 파싱 실패:', e)
    }
  }

  // Service Worker 등록 (설치 버튼용만 유지)
  if ('serviceWorker' in navigator) {
    const swScript = document.createElement('script')
    swScript.setAttribute('type', 'module')
    swScript.setAttribute('src', '/build/registerSW.js')
    document.head.appendChild(swScript)
  }

  // 설치 이벤트
  window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault()
    deferredPrompt = e
    showInstallButton.value = true
  })

  // IP 기반 국가 코드 조회
  try {
    const res = await fetch('https://ipapi.co/json/')
    if (!res.ok) throw new Error(`ipapi.co 오류: ${res.status}`)
    const data = await res.json()
    countryCode.value = data.country || 'LA'
  } catch (err) {
    console.error('국가 코드 조회 실패:', err)
    countryCode.value = 'LA'
  }

  // 실시간 안전 정보 요청 및 캐시 업데이트
  try {
    const safetyRes = await fetch(`/api/safe-koica/${countryCode.value}`)
    if (!safetyRes.ok) throw new Error(`API 응답 오류: ${safetyRes.status}`)
    const safetyData = await safetyRes.json()

    countryInfo.value = {
      country: safetyData.country || '국가명 없음',
      level: safetyData.travel_alert || '정보 없음',
      incident: safetyData.event || '정보 없음',
      danger: '추가 예정',
      summary: safetyData.summary || '요약 정보 없음',
      updated_at: new Date().toLocaleString(),
    }

    // 최신 정보 캐시 저장
    localStorage.setItem('safeKoicaCountryInfo', JSON.stringify(countryInfo.value))
  } catch (err) {
    console.error('안전정보 API 호출 실패:', err)
  }
})

// 설치 버튼 핸들러
const handleInstallClick = async () => {
  if (deferredPrompt) {
    deferredPrompt.prompt()
    const result = await deferredPrompt.userChoice
    console.log('설치 결과:', result.outcome)
    deferredPrompt = null
    showInstallButton.value = false

    if (result.outcome === 'accepted') {
      await fetch('/api/safe-koica/install-log', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          event: 'install',
          time: new Date().toISOString(),
        })
      })
    }
  }
}
</script>

<template>
  <Head>
    <title>Safe KOICA</title>
    <link rel="manifest" href="/build/manifest.webmanifest" />
    <meta name="theme-color" content="#ffffff" />
  </Head>

  <div class="min-h-screen bg-white dark:bg-gray-900 p-6">
    <h1 class="text-3xl font-bold mb-4 text-center text-blue-700">🛡️ Safe KOICA</h1>

    <div class="text-gray-500 text-xs text-center mt-2">
      마지막 업데이트: {{ countryInfo?.updated_at }}
    </div>

    <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-xl shadow mb-4">
      <p class="text-lg"><strong>국가:</strong> {{ countryInfo?.country }}</p>
      <p class="text-lg"><strong>여행경보:</strong> {{ countryInfo?.level }}</p>
      <p class="text-lg"><strong>사건사고:</strong> {{ countryInfo?.incident }}</p>
      <p class="text-lg"><strong>주의사항:</strong> {{ countryInfo?.danger }}</p>
    </div>

    <div class="bg-blue-50 dark:bg-blue-900 text-blue-800 dark:text-blue-100 p-4 rounded-lg mb-4">
      <strong>📌 안전 요약 카드:</strong>
      <p class="mt-2 text-base">{{ countryInfo?.summary }}</p>
    </div>

    <div class="text-gray-600 text-sm text-center">
      ※ 정보는 실시간 공공데이터를 기반으로 요약 제공됩니다.
    </div>


    <div v-if="showInstallButton" class="text-center mt-6">
      <button @click="handleInstallClick"
              class="bg-blue-600 text-white font-semibold px-4 py-2 rounded-xl shadow hover:bg-blue-700 transition">
        📲 앱 설치하기
      </button>
    </div>
  </div>
</template>
