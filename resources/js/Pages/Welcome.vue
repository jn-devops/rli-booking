<script setup>
 import LandingLayout from '@/MyComponents/LandingLayout.vue';
 import DefaultPrimaryButton from '@/MyComponents/DefaultPrimaryButton.vue';
 import DefaultSecondaryButton from '@/MyComponents/DefaultSecondaryButton.vue';
 import { Link } from '@inertiajs/vue3'; 
</script>

<template>
    <div class="h-screen">
        <LandingLayout>
            <template #content>
                <div class="pt-4 text-left">
                    <h1 class="font-bold text-5xl">Welcome to 
                        <br /><span class="text-primary_color">book.homeful.ph</span>
                    </h1>
                </div>
                <div class="pt-4 pr-4 text-left">
                    <p>Unlock the buyer’s dream home: Find their perfect property today!</p>
                </div>
            </template>
            <template #buttons>
                <div class="grid grid-rows-1 mt-4">
                    <Link
                    href="/login"
                    >
                    <DefaultPrimaryButton>
                        <template #text>
                            <div class="flex justify-center items-center">
                                Login
                            </div>
                        </template>
                    </DefaultPrimaryButton>                    
                    </Link>
                    <Link
                    href="/register"
                    >
                    <DefaultSecondaryButton>
                        <template #textSecondary>
                            <div class="flex justify-center items-center">
                               Register
                            </div>
                        </template>
                    </DefaultSecondaryButton>
                    </Link>
                </div>
            </template>
        </LandingLayout>
    </div>
</template>

<style>
.text-primary_color{
    color: #CC035C;
}
</style>