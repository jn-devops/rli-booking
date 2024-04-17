<script setup>
 import { Link } from '@inertiajs/vue3'; 
</script>
<template>
    <button class="bg_btnSecondary text-black w-64 py-4 rounded-lg mt-4 outline-none">
        <slot name="textSecondary" />
    </button>
</template>

<style>
.bg_btnSecondary{
    /* border-radius: 20px; */
    /* background: linear-gradient(268deg, #CC035C 7.47%, #FCB115 98.92%); */
    border: 1px solid #CC035C;
    color: #CC035C;
    background-color: transparent;
}
</style>