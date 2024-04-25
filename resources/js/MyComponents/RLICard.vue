<template>
    <div class="min-h-screen sm:flex sm:flex-row sm:justify-center items-start px-4 bg-gray-100 dark:bg-gray-900 bg_layout w-full">
        <div>
            <slot name="logo" />
        </div>
        <div class="w-full mt-2">
            <div v-if="$slots.title" class="w-full">
                <slot name="title"/>
            </div>
            <div class="hidden md:grid md:grid-cols-2 gap-3 w-full">
                <div class="grid grid-rows-1">
                    <div v-if="$slots.contentLeft" class="w-full max-w-4xl my-2 px-6 py-3 bg-white dark:bg-gray-800 shadow-2xl overflow-hidden sm:rounded-lg justify-items-center justify-self-center">
                            <slot name="contentLeft"/>
                    </div>
                    <div v-if="$slots.BrowseProperty && $slots.subTitle" class="w-full max-w-4xl my-2 px-6 py-3 bg-white dark:bg-gray-800 shadow-2xl overflow-hidden sm:rounded-lg justify-items-center justify-self-center">
                        <div v-if="$slots.subTitle">
                            <slot name="subTitle" />
                        </div>
                        <div v-if="$slots.BrowseProperty">
                            <slot name="BrowseProperty"/>
                        </div>
                    </div>
                </div>
    
                <div class="flex flex-col items-center justify-items-center">
                    <div v-if="$slots.tcp" class=" justify-center h-auto w-full md:max-w-xl lg:max-w-4xl mt-2 px-6 py-4 bg-white dark:bg-gray-800 shadow-2xl overflow-hidden sm:rounded-lg ">
                        <slot name="tcp" />
                    </div>
                    <div v-if="$slots.contentRight" class="row-span-2 h-auto w-full  md:max-w-xl lg:max-w-4xl mt-2 px-6 py-4 bg-white dark:bg-gray-800 shadow-2xl overflow-hidden sm:rounded-lg ">
                        <slot name="contentRight" />
                    </div>
                </div>
    
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