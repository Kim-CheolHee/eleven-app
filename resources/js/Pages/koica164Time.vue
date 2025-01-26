<script setup>
import { Head } from '@inertiajs/vue3';

// Props 정의
defineProps({
    koica164Times: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <Head title="World Time" />
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 dark:bg-gray-900">
        <h1 class="text-4xl font-bold text-black-800 dark:text-gray-100 mb-8">KOICA 164❤️</h1>

        <div class="text-lg flex flex-col space-y-4">
            <div class="flex items-center space-x-2">
                <span class="text-red-600 font-bold">{{ koica164Times[0].country }}</span>:
                <span class="text-black-500">{{ koica164Times[0].time.substring(2, 10) }}</span>
                <span class="text-red-600">{{ koica164Times[0].time.substring(11, 16) }}</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="text-red-400 font-bold">{{ koica164Times[1].country }}</span>:
                <span class="text-black-500">{{ koica164Times[1].time.substring(2, 10) }}</span>
                <span class="text-red-400">{{ koica164Times[1].time.substring(11, 16) }}</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="text-orange-600 font-bold">{{ koica164Times[2].country }}</span>:
                <span class="text-black-500">{{ koica164Times[2].time.substring(2, 10) }}</span>
                <span class="text-orange-600">{{ koica164Times[2].time.substring(11, 16) }}</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="text-orange-400 font-bold">{{ koica164Times[3].country }}</span>:
                <span class="text-black-500">{{ koica164Times[3].time.substring(2, 10) }}</span>
                <span class="text-orange-400">{{ koica164Times[3].time.substring(11, 16) }}</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="text-yellow-600 font-bold">{{ koica164Times[4].country }}</span>:
                <span class="text-black-500">{{ koica164Times[4].time.substring(2, 10) }}</span>
                <span class="text-yellow-600">{{ koica164Times[4].time.substring(11, 16) }}</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="text-green-600 font-bold">{{ koica164Times[5].country }}</span>:
                <span class="text-black-500">{{ koica164Times[5].time.substring(2, 10) }}</span>
                <span class="text-green-600">{{ koica164Times[5].time.substring(11, 16) }}</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="text-green-400 font-bold">{{ koica164Times[6].country }}</span>:
                <span class="text-black-500">{{ koica164Times[6].time.substring(2, 10) }}</span>
                <span class="text-green-400">{{ koica164Times[6].time.substring(11, 16) }}</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="text-blue-400 font-bold">{{ koica164Times[7].country }}</span>:
                <span class="text-black-500">{{ koica164Times[7].time.substring(2, 10) }}</span>
                <span class="text-blue-400">{{ koica164Times[7].time.substring(11, 16) }}</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="text-blue-600 font-bold">{{ koica164Times[8].country }}</span>:
                <span class="text-black-500">{{ koica164Times[8].time.substring(2, 10) }}</span>
                <span class="text-blue-600">{{ koica164Times[8].time.substring(11, 16) }}</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="text-indigo-500 font-bold">{{ koica164Times[9].country }}</span>:
                <span class="text-black-500">{{ koica164Times[9].time.substring(2, 10) }}</span>
                <span class="text-indigo-500">{{ koica164Times[9].time.substring(11, 16) }}</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="text-purple-400 font-bold">{{ koica164Times[10].country }}</span>:
                <span class="text-black-500">{{ koica164Times[10].time.substring(2, 10) }}</span>
                <span class="text-purple-400">{{ koica164Times[10].time.substring(11, 16) }}</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="text-purple-600 font-bold">{{ koica164Times[11].country }}</span>:
                <span class="text-black-500">{{ koica164Times[11].time.substring(2, 10) }}</span>
                <span class="text-purple-600">{{ koica164Times[11].time.substring(11, 16) }}</span>
            </div>
        </div>
    </div>
</template>
