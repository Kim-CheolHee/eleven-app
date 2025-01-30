<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Laos" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                디지털 세상에서 나만의 아이디어 그리기
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                <div>
                  <h1 class="text-2xl font-bold">ໂລກດິຈິຕອນ ກັບການວາດຄວາມຄິດຂອງຂ້ອຍໃຫ້ເປັນຈິງ</h1>
                  <h2 class="text-2xl font-serif">Thunkable / Scratch</h2>
                </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
