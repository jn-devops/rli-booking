<template>
    <div class="relative w-full overflow-hidden">
        <input type="checkbox"
        class="peer absolute top-0 inset-x-0 w-full h-12 opacity-0 z-10 cursor-pointer"
        >
        <div 
        class="h-12 w-full flex items-center mb-3"
        >
        <h1 class="font-semibold underline dark:text-white light:text-black">View More Details</h1>
        </div>
        <!-- Icon Arrow -->
        <div class="absolute top-3 right-0 transition-transform duration-500 rotate-0 peer-checked:rotate-180">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 dark:text-white light:text-black">
            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
            </svg>
        </div>
        <!-- Content -->
        <div class="overflow-hidden transition-all duration-500 max-h-0 peer-checked:max-h-96 relative">
            <div class="">
                <slot />
            </div>
        </div>
    </div>
</template>