<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

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
                <!-- <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg"> -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg relative aspect-[4/3]">  <img src="/images/dashboard.jpg" alt="Dashboard Image" class="w-full h-full object-cover absolute inset-0">
                    <img src="/images/dashboard.jpg" alt="Dashboard Image" class="w-full h-auto md:h-48 object-cover">
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
