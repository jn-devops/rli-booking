<template>
    <div class="min-h-screen container mx-auto px-4 sm:pt-0 bg-gray-100 dark:bg-gray-900 bg_layout">
        <div>
            <slot name="logo" />
        </div>
        <div class="w-full pt-4">
            <div v-if="$slots.title">
                <slot name="title" />
            </div>
            <div v-if="$slots.search">
                <slot name="search" />
            </div>
        </div>
        <div 
        v-if="$slots.content"
        class="">
            <slot name="content" />
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