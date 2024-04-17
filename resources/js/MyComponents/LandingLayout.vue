<script setup>
import LandingDefaultLogo from './LandingDefaultLogo.vue';
import DefaultLandingMobileLogo from './DefaultLandingMobileLogo.vue';

</script>
<template>
    <div class="hidden md:grid grid-cols-2 relative bg_layout">
        <div class="h-auto grid items-center md:p-8  z-20">
            <div class="p-10">
                <div class="">
                    <!-- <img src="../../img/RLI_logo.png" alt="RLI_Logo" class="h-40"> -->
                </div>
                <div v-if="$slots.content">
                    <slot name="content" />
                </div>
                <div v-if="$slots.buttons">
                    <slot name="buttons" />
                </div>
            </div>
        </div>
        <div class="overflow-hidden hidden md:grid z-0">
            <!-- <img src="../../img/Welcome_img.png" alt="Welcome_img" class=""> -->
            <LandingDefaultLogo class="z-0 relative" />
            <!-- <img src="../../img/DefaultLandingImg.png" alt=""> -->
        </div>
    </div>
    <div class="md:hidden grid grid-rows-1 h-full">
        <div class="grid justify-center items-center md:p-8 gap-4">
            <div class="overflow-hidden">
                <DefaultLandingMobileLogo class="h-full pb-4 mb-4"/>
            </div>
            <div class="p-10 mt-4">
                <div v-if="$slots.content">
                    <slot name="content" />
                </div>
                <div v-if="$slots.buttons">
                    <slot name="buttons" />
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.bg_layout{
    background: url('../../img/RLI_heart_logo.png') no-repeat ;
    /* left: 5%; */
    background-size: cover;
    z-index: 20;

}

</style>