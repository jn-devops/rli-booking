<template>
    <div class="min-h-96 flex flex-col sm:justify-center items-center pt-6 md:mt-32 sm:pt-0 bg-gray-100 dark:bg-gray-900">
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
