<script setup>
import { Head } from '@inertiajs/vue3';

// Props 정의
defineProps({
    worldTimes: {
        type: Object,
        required: true,
    },
});

// Tailwind 색상 클래스 배열
const colors = [
    'text-red-500',
    'text-orange-500',
    'text-yellow-500',
    'text-green-500',
    'text-blue-500',
    'text-indigo-500',
    'text-purple-500',
];

</script>

<template>
    <Head title="World Time" />
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 dark:bg-gray-900">
        <h1 class="text-4xl font-bold text-black-800 dark:text-gray-100 mb-8">KOICA 164❤️</h1>

        <div class="text-lg flex flex-col space-y-4">
            <div class="flex items-center space-x-2">
                <span class="text-red-500 font-bold">{{ worldTimes[0].country }}</span>:
                <span class="text-black-500">{{ worldTimes[0].time.substring(5, 10) }}</span>
                <span class="text-red-500">{{ worldTimes[0].time.substring(11, 16) }}</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="text-orange-500 font-bold">{{ worldTimes[1].country }}</span>:
                <span class="text-black-500">{{ worldTimes[1].time.substring(5, 10) }}</span>
                <span class="text-orange-500">{{ worldTimes[1].time.substring(11, 16) }}</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="text-yellow-500 font-bold">{{ worldTimes[2].country }}</span>:
                <span class="text-black-500">{{ worldTimes[2].time.substring(5, 10) }}</span>
                <span class="text-yellow-500">{{ worldTimes[2].time.substring(11, 16) }}</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="text-green-500 font-bold">{{ worldTimes[3].country }}</span>:
                <span class="text-black-500">{{ worldTimes[3].time.substring(5, 10) }}</span>
                <span class="text-green-500">{{ worldTimes[3].time.substring(11, 16) }}</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="text-blue-500 font-bold">{{ worldTimes[4].country }}</span>:
                <span class="text-black-500">{{ worldTimes[4].time.substring(5, 10) }}</span>
                <span class="text-blue-500">{{ worldTimes[4].time.substring(11, 16) }}</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="text-indigo-500 font-bold">{{ worldTimes[5].country }}</span>:
                <span class="text-black-500">{{ worldTimes[5].time.substring(5, 10) }}</span>
                <span class="text-indigo-500">{{ worldTimes[5].time.substring(11, 16) }}</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="text-purple-500 font-bold">{{ worldTimes[6].country }}</span>:
                <span class="text-black-500">{{ worldTimes[6].time.substring(5, 10) }}</span>
                <span class="text-purple-500">{{ worldTimes[6].time.substring(11, 16) }}</span>
            </div>
        </div>
    </div>
</template>
