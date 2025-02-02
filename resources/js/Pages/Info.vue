<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

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
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 items-center">
            <!-- 왼쪽 사진 영역 -->
            <div class="flex justify-center">
              <img src="/images/profile.jpg" alt="image" class="rounded-xl w-40 h-45 object-cover shadow-lg">
            </div>
            <!-- 오른쪽 텍스트 정보 -->
            <div class="text-gray-800">
              <p class="text-2xl font-semibold">김철희 / Kim Cheolhee</p>
              <p class="text-xl mt-2">ຄີມ ຊອນຮີ (ຊອນ)</p>
              <p class="text-lg mt-4">📞 02057781515</p>
              <p class="text-lg">✉️ windowlife92@gmail.com</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
