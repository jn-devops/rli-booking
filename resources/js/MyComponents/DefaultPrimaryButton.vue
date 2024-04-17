<template>
    <button class="bg_btn text-white w-64 py-4 rounded-lg mt-4 outline-none">
        <slot name="text" />
    </button>
</template>

<style>
.bg_btn{
    /* border-radius: 20px; */
    background: linear-gradient(268deg, #CC035C 7.47%, #FCB115 98.92%);
}
</style>