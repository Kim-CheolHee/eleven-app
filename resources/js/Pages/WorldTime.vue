<script setup>
import { Head } from '@inertiajs/vue3';

defineProps({
    serverTime: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="World Time" />
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 dark:bg-gray-900">
        <h1 class="text-4xl font-bold text-gray-800 dark:text-gray-100">World Time</h1>
        <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">
            Current server time: <strong>{{ serverTime }}</strong>
        </p>
    </div>
</template>
