<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const isImageLoaded = ref(false);

const handleImageLoad = () => {
  isImageLoaded.value = true;
};
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Dashboard
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg relative aspect-[4/3]">
          <!-- 로딩 완료 후 보이는 이미지 -->
          <img
            v-if="isImageLoaded"
            src="/images/dashboard.jpg"
            alt="Dashboard Image"
            class="w-full h-full object-cover absolute inset-0 transition-all duration-500 ease-in-out"
          />
          <!-- 로딩 중 이미지 (최초에만 보이도록) -->
          <img
            v-else
            src="/images/dashboard.jpg"
            alt="Dashboard Image"
            class="w-full h-auto object-cover absolute inset-0"
            @load="handleImageLoad"
          />
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
