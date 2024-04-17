<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900 bg_layout">
        <div>
            <slot name="logo" />
        </div>
        <div v-if="$slots.title">
            <slot name="title" />
        </div>
        <div class="w-full max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-900 shadow-2xl overflow-hidden sm:rounded-lg">
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