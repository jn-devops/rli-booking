<template>
    <div class="min-h-screen sm:flex sm:flex-row gap-4 sm:justify-center items-center pt-0 bg-gray-100 dark:bg-gray-900 bg_layout">
        <div>
            <slot name="logo" />
        </div>
    
        <div class="hidden md:grid md:grid-cols-2 gap-4">
            <div v-if="$slots.contentLeft" class="w-full max-w-xl my-3 px-6 py-4 bg-white dark:bg-gray-800 shadow-2xl overflow-hidden sm:rounded-lg">
                    <slot name="contentLeft"/>
            </div>
            <div v-if="$slots.contentRight" class="h-auto w-full place-self-center max-w-xl mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-2xl overflow-hidden sm:rounded-lg">
                <slot name="contentRight" />
            </div>
        </div>

        <div class="md:hidden grid grid-rows-1">
            <div v-if="$slots.contentLeft" class="w-full max-w-xl px-6 py-4 bg-white dark:bg-gray-800 shadow-2xl overflow-hidden sm:rounded-lg">
                    <slot name="contentLeft"/>
            </div>
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