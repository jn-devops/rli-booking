
<script setup>
import { ref } from 'vue';
const collapsed = ref(false); // Track collapsible state

</script>
<template>
    <div class="w-full overflow-hidden z-10">
    <div class="relative w-full overflow-hidden z-10">
        <!-- Checkbox for collapsible -->
        <input type="checkbox" 
        class="peer absolute top-0 inset-x-0 w-full h-12 opacity-0 z-10 cursor-pointer"
        @change="collapsed = !collapsed">
        
        <!-- Header with title and edit icon -->
        <div class="h-12 w-full flex items-center mb-3 relative">
            <!-- Title -->
            <h1 :class="{ bg_cursor : !collapsed, 'text-black': collapsed  }" class="text-2xl flex-grow">
                <slot name="title"></slot>
            </h1>
            <!-- Edit Icon -->
            <div class="absolute top-4 right-0 z-20">
                <slot name="edit"></slot>
            </div>
        </div>
        
        <!-- Icon Arrow -->
        <div class="absolute top-3 right-10 transition-transform duration-500 rotate-0 peer-checked:rotate-180">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 bg_cursor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
            </svg>
        </div>
    </div>
        
    <!-- Content -->
    <div class="bg-white overflow-hidden transition-all duration-500 max-h-0" :class="{ 'max-h-screen': collapsed }">
            <slot />
    </div>
    <div v-if="$slots.contentDropdown" class="bg-white overflow-hidden transition-all duration-500 max-h-0"
    :class="{ 'max-h-screen': collapsed }">
        <slot name="contentDropdown"></slot>
    </div>
</div>

</template>

<style>
.bg_cursor{
    color: #CC035C;
}
.bg_outline_b{
    /* outline: #CC035C; */
    border-bottom: 3px solid #CC035C;
    /* border: 0 0 1px 0 solid #CC035C; */
}
#collapsible-checkbox {
  width: 0;
  height: 0;
  opacity: 0;
}
</style>
