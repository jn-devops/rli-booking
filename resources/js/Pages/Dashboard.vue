<script setup>
import SectionBorder from '@/Components/SectionBorder.vue';
import Generate from "@/Pages/Voucher/Generate.vue";
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <!-- <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Sales Booking
            </h2>
        </template> -->

        <div class="">
            <div class="max-w-full">
                <Generate/>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">

                </div>
            </div>
        </div>
    </AppLayout>
</template>
