<script setup>
import { onMounted, ref } from 'vue'
import { Head } from '@inertiajs/vue3'

const countryInfo = ref(null)
const countryCode = ref(null)

// 추가: 설치 관련 변수
const showInstallButton = ref(false)
let deferredPrompt = null

onMounted(async () => {
  // PWA service worker 등록
  if ('serviceWorker' in navigator) {
    const swScript = document.createElement('script')
    swScript.setAttribute('type', 'module')
    swScript.setAttribute('src', '/build/registerSW.js')
    document.head.appendChild(swScript)
  }

  // 설치 이벤트 대기
  window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault()
    deferredPrompt = e
    showInstallButton.value = true
  })

  // 국가 정보 로딩
  try {
    const res = await fetch('https://ipapi.co/json/')
    const data = await res.json()
    countryCode.value = data.country

    const safetyRes = await fetch(`/api/safe-koica/${countryCode.value}`)
    const safetyData = await safetyRes.json()

    // 화면 렌더링용 변수에 반영
    countryInfo.value = {
      country: safetyData.country,
      level: safetyData.travel_alert || '정보 없음',
      incident: safetyData.event || '정보 없음',
      danger: '추가 예정',
      summary: safetyData.summary || '요약 정보 없음',
    }

    // localStorage에 저장
    localStorage.setItem('safeKoicaCountryInfo', JSON.stringify(countryInfo.value))
  } catch (err) {
    console.error('국가 코드 조회 실패:', err)
    // localStorage에 저장된 데이터 로드
    const cached = localStorage.getItem('safeKoicaCountryInfo')
    if (cached) {
      countryInfo.value = JSON.parse(cached)
    } else {
      countryInfo.value = {
        country: '위치 확인 실패',
        level: '-',
        incident: '-',
        danger: '-',
        summary: '오프라인 - 저장된 정보 없음',
      }
    }
  }
})

// 설치 버튼 클릭 처리
const handleInstallClick = async () => {
  if (deferredPrompt) {
    deferredPrompt.prompt()
    const result = await deferredPrompt.userChoice
    console.log('설치 결과:', result.outcome)
    deferredPrompt = null
    showInstallButton.value = false

    // 설치 성공한 경우에만 로그 전송
    if (result.outcome === 'accepted') {
      await fetch('/api/safe-koica/install-log', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
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
