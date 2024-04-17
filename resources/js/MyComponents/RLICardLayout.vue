<template>
    <div class="min-h-96 flex flex-col justify-center pt-6 md:mt-0 sm:pt-0 bg-gray-100 dark:bg-gray-900 bg_layout">
        <div v-if="$slots.logo">
            <slot name="logo" />
        </div>
        <div v-if="$slots.title">
            <slot name="title" />
        </div>

        <div class="w-full sm:max-w-lg mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>
<style>
.bg_layout{
    background: url('../../img/BGLayout.png') center no-repeat ;
    background-size: cover;
    z-index: 1;
}
</style>