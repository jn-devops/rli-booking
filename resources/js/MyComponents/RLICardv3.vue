<template>
    <div class="min-h-screen md:flex sm:flex-row sm:justify-center md:justify-start items-start px-4 bg-gray-100 dark:bg-gray-900 bg_layout w-full">
        <div>
            <slot name="logo" />
        </div>
        <div class="w-full my-2">
            <div v-if="$slots.title" class="w-full">
                <slot name="title"/>
            </div>
            <div class="hidden md:grid md:grid-rows-1 gap-3 w-full">
                <div v-if="$slots.contentLeft" class="w-full my-2 px-6 py-3 bg-white dark:bg-gray-800 shadow-2xl overflow-hidden sm:rounded-lg justify-items-center justify-self-center">
                        <slot name="contentLeft"/>
                </div>
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