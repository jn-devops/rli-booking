<script setup>
import DefaultPrimaryButton from '@/MyComponents/DefaultPrimaryButton.vue';
import { inject, ref } from 'vue';

let products = inject('products');

const props = defineProps({
    projectName: String
})
const emit = defineEmits(['product-selected']);

const selectProduct = (product) => {
  emit('product-selected', product);
};

const showFullImage = ref(false);
const imgSrc = ref(null);
const showingFullImage = (newparams) =>{
    showFullImage.value = true;
    console.log('img src:', newparams);
    imgSrc.value = newparams
}
const closeModalViewDetail = () =>{
    showFullImage.value = !true;
}
console.log('productList:', products);

</script>
<template>
<!-- <div class="grid sm:hidden md:grid-cols-2 lg:grid-cols-4 gap-2 justify-items-center dark:text-white white:text-black 2xl:w-4/5">
    <div v-for="product in products" :key="product.id"
    class="max-w-sm rounded-lg overflow-hidden shadow-lg p-2 border bg_border dark:text-white white:text-black">
        <div class="w-full h-48 rounded-lg flex items-center justify-start overflow-hidden">
            <img 
            @click="showingFullImage(product)"
            :src="product.url_links.facade " 
            class="object-fit w-full h-full rounded-lg scale-100 hover:scale-125 transition duration-300 ease-in-out hover:delay-100"/>
        </div>
        <div class="px-6 py-4 dark:text-white white:text-black">
            <div class="font-bold text-md mb-2 dark:text-white white:text-black h-20 line-clamp-3">{{ product.name }}</div>
            <p class="font-bold text-gray-700 text-sm dark:text-white white:text-black">
                ₱{{ product.price.toLocaleString() }}.00
            </p>
            <p class="text-gray-700 text-sm dark:text-white white:text-black">
                Total Contract Price
            </p>
        </div>
        <div v-if="$slots.buttons" class="block xl:flex items-center px-2 py-4">
           <slot name="buttons" :product="product"/>
        </div>
      
    </div>
</div> -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-2 justify-items-center dark:text-white white:text-black 2xl:w-4/5">
    <div v-for="product in products" :key="product.id"
    class="max-w-sm rounded-lg overflow-hidden shadow-lg p-2 border bg_border dark:text-white white:text-black">
        <div class="w-full h-28 md:h-48 rounded-lg flex items-center justify-start overflow-hidden">
            <img 
            @click="showingFullImage(product)"
            :src="product.url_links.facade " 
            class="object-contain w-full h-full rounded-lg scale-100 hover:scale-125 transition duration-300 ease-in-out hover:delay-100"/>
        </div>
        <div class="px-2 py-2 md:py-4 md:px-6 dark:text-white white:text-black">
            <div class="font-bold text-xs sm:text-sm md:text-md mb-2 dark:text-white white:text-black h-auto md:h-20 line-clamp-3">{{ product.name }}</div>
            <p class="font-bold text-gray-700 text-xs sm:text-sm md:text-sm dark:text-white white:text-black">
                ₱{{ product.price.toLocaleString() }}.00
            </p>
            <p class="text-gray-700 text-xs sm:text-sm md:text-sm dark:text-white white:text-black">
                Total Contract Price
            </p>
        </div>
        <div v-if="$slots.buttons" class="block xl:flex items-center px-2 py-1 md:py-4">
           <slot name="buttons" :product="product"/>
        </div>
        <!-- <div class="px-6 pt-4 pb-2">
            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#photography</span>
            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#travel</span>
            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#winter</span>
        </div> -->
    </div>
</div>
    <!-- <div class="grid grid-cols-4 gap-4">
        <div v-for="product in products" :key="product.id" class="p-2 border rounded flex flex-col">
            <div class="text-left flex-grow">
                <div class="w-full h-48 flex items-center justify-start overflow-hidden">
                    <img :src="product.url_links.facade " class="object-cover w-full h-full"/>
                </div>
                <div class="mt-2">
                    <p class="font-bold"> {{ product.name }}</p>
                </div>
                <div class="mt-auto">
                    <p>₱{{ product.price.toLocaleString() }}.00</p>
                    <p>Total Contract Price</p>
                </div>
            </div>
        </div>
    </div> -->
     <!-- Modal Details -->
     <div v-show="showFullImage"
  @click.prevent="closeModalViewDetail()"
  class="fixed inset-0 bg-black bg-opacity-30 top-0 left-0 flex justify-center px-6 py-1 z-10  overflow-y-auto"
  >
        <div
        v-if="showFullImage" 
        class="bg-transparent self-center max-w-screen-xl rounded py-2">
            <!-- <div class="w-full p-4 text-right">
                <button 
                @click="showInfoDetail"
                class="bg-gray-50 text-gray-400 px-3 py-1 rounded-full text-1xl text-right">&times;</button>
            </div> -->
            <!-- <div class="py-2 mb-3 md:flex flex-row gap-4">
                <img src="../../../img/RaemulanLandsLogo.png" alt="Logo" class="mx-auto h-20 mt-2">
                <img src="../../../img/Elnvital_Logo.png" alt="Logo" class="mx-auto h-20 mt-2">
            </div> -->
            <div class="">
                <div class="w-full p-4 text-right">
                    <button 
                    @click.prevent="closeModalViewDetail()"
                    class="bg-gray-500 text-white px-3 py-1 rounded-full text-lg text-right">&times;</button>
                </div>
                <img :src="imgSrc.url_links.facade" class="object-fit w-full h-full" alt="Detail Image" srcset="">
              </div>
          
        </div>
      </div>
</template>

<style scoped>
.bg_btn{
    /* border-radius: 20px; */
    background: linear-gradient(268deg, #ec732e 1%, #CD045D 99.92%);
}

.bg_border:hover{
  border: solid 1px #CD045D;
}
.bg_text{
    color: #CD045D
}

.line-clamp3{
    display: -webkit-box;
    -webkit-line-clamp: 3; /* Number of lines to show */
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>