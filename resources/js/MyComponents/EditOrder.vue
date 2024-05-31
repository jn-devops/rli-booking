<script setup>
import FloorAreaLogo from './FloorAreaLogo.vue';
import LotAreaLogo from './LotAreaLogo.vue';
import FloorLogo from './FloorLogo.vue';
import Collapsible from './Collapsible.vue';
import CarparkLogo from './CarparkLogo.vue';
import ToiletBathLogo from './ToiletBathLogo.vue';
import UnitTypeLogo from './UnitTypeLogo.vue';
import {ref} from 'vue';

const props = defineProps({
    propertyCode: String,
    order: Object
})

console.log('facde:', props.order.product.url_links.facade);
</script>

<template>
    <div class=" grid grid-rows-1 gap-2 md:gap-2">
        <!-- Tablet/Desktop -->
        <div class="hidden md:block">
            <div class="relative">
                <img :src="props.order.product.url_links.facade" class="w-full">
            </div>
            <div class="hidden lg:grid lg:grid-cols-5 mt-2 dark:text-white light:text-black">
                <div class="flex gap-2">
                    <LotAreaLogo />
                    <div>
                        <p class="text-gray-400">Lot Area</p>
                        <p>{{ props.order.product.lot_area }}</p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <FloorAreaLogo />
                    <div>
                        <p class="text-gray-400">Floor Area</p>
                        <p>{{ props.order.product.floor_area}}SQM</p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <UnitTypeLogo />
                    <div>
                        <p class="text-gray-400">Unit Type</p>
                        <p>{{ props.order.product.unit_type.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ') }}</p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <ToiletBathLogo />
                    <div>
                        <p class="text-gray-400">Bedrooms</p>
                        <p>1</p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <CarparkLogo />
                    <div>
                        <p class="text-gray-400">Carpark</p>
                        <p>1</p>
                    </div>
                </div>
            </div>
            <div class="lg:hidden md:block dark:text-white light:text-black">
                <div class="grid md:grid-cols-3 mt-2">
                    <div class="flex gap-2">
                        <LotAreaLogo />
                        <div>
                            <p class="text-gray-400">Lot Area</p>
                            <p>{{ props.order.product.lot_area }}</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <FloorAreaLogo />
                        <div>
                            <p class="text-gray-400">Floor Area</p>
                            <p>{{ props.order.product.floor_area}}SQM</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <UnitTypeLogo />
                        <div>
                            <p class="text-gray-400">Unit Type</p>
                            <p>{{ props.order.product.unit_type.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ') }}</p>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-3 mt-4">
                    <div class="flex gap-2">
                        <ToiletBathLogo />
                        <div>
                            <p class="text-gray-400">Bedrooms</p>
                            <p>1</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <CarparkLogo />
                        <div>
                            <p class="text-gray-400">Carparks</p>
                            <p>1</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="grid grid-cols-3 mt-4">
                <div class="flex gap-2">
                    <ToiletBathLogo />
                    <div>
                        <p class="text-gray-400">Bedrooms</p>
                        <p>1</p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <CarparkLogo />
                    <div>
                        <p class="text-gray-400">Bedrooms</p>
                        <p>1</p>
                    </div>
                </div>
            </div> -->
            <div class="mt-2 relative">
                <div class="flex rounded-md shadow-sm">
                    <slot />
                </div>
            </div>
            <!-- <div class="my-4 font-bold">
                <p>Calculate Financial Scheme</p>
            </div> -->
            <div class="hidden md:block">
            <!-- <div class="mt-4">
                <div class="border-b-2 pb-4">
                    <div class="flex gap-1">
                        <p class="text-sm font-bold">Total Contract Price:</p>
                        <p class="text-sm font-bold">₱2,900,000</p>
                    </div>
                    <div class="mt-2">
                        <p class="font-bold">Processing Fee:</p>
                        <p class="text-4xl font-bold text-primary_color">₱{{ props.order.product.processing_fee.toLocaleString() }}</p>
                    </div>
                </div>
            </div> -->
            <!-- <div class="mt-2">
                <div class="flex flex-wrap gap-3 border-b-2 pb-3 mt-2 py-2">
                    <div class="flex gap-1 font-bold">
                            <p>Property Code:</p>
                            <p>{{ props.propertyCode }}</p>
                    </div>
                    <div class="flex gap-1">
                            <p class="font-bold">Location:</p>
                            <p>Laguna</p>
                    </div>
                    <div class="flex gap-1">
                            <p class="font-bold">Bedrooms:</p>
                            <p>Studio</p>
                    </div>
                    <div class="flex gap-1">
                            <p class="font-bold">Toilet and Bath:</p>
                            <p>1</p>
                    </div>
                </div>
           
            </div> -->
            <div class="my-2 dark:text-white light:text-black">
                <h3 class="font-bold">Seller Details:</h3>
                <div class="flex gap-1 mt-1">
                    <div class="grow w-8">
                        <p class="font-bold">Name:</p>
                        <p>{{ props.order.seller.name}}</p>
                    </div>
                    <div class="grow w-62">
                        <p class="font-bold">Email:</p>
                        <p>{{ props.order.seller.email}}</p>
                    </div>
               </div>
            </div>
        </div>
        </div>
        <!-- Mobile -->
        <div class="block md:hidden">
            <!-- <img src="../../img/Rectangle_39.png"> -->
            <img :src="props.order.product.url_links.facade">
            <div class="my-4 relative">
                <div class="flex rounded-md shadow-sm">
                    <slot />
                </div>
            </div>
            <div class="w-full">
                <Collapsible >
                    <div class="grid grid-cols-3 dark:text-white light:text-black">
                        <div class="flex gap-2">
                            <LotAreaLogo />
                            <div>
                                <p class="text-gray-400">Lot Area</p>
                                <p>{{ props.order.product.lot_area }}</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <FloorAreaLogo />
                            <div>
                                <p class="text-gray-400">Floor Area</p>
                                <p>{{ props.order.product.floor_area}}SQM</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <UnitTypeLogo />
                            <div>
                                <p class="text-gray-400">Unit Type</p>
                                <p>{{ props.order.product.unit_type.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 mt-4 dark:text-white light:text-black">
                        <div class="flex gap-2">
                            <ToiletBathLogo />
                            <div>
                                <p class="text-gray-400">Bedrooms</p>
                                <p>1</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <CarparkLogo />
                            <div>
                                <p class="text-gray-400">Carparks</p>
                                <p>1</p>
                            </div>
                        </div>
                    </div>
                    <div class="dark:text-white light:text-black">
                        <div class="">
                            <div class="border-b-2 pb-4 py-3">
                                <div class="flex gap-1 font-bold">
                                        <p>Property Code:</p>
                                        <p>{{ props.propertyCode }}</p>
                                </div>
                                <div class="flex gap-1">
                                        <p class="font-bold">Location:</p>
                                        <p>Laguna</p>
                                </div>
                                <div class="flex gap-1">
                                        <p class="font-bold">Bedrooms:</p>
                                        <p>Studio</p>
                                </div>
                                <div class="flex gap-1">
                                        <p class="font-bold">Toilet and Bath:</p>
                                        <p>1</p>
                                </div>
                            </div>
                        </div>
                        <div class="border-b-2 pb-4 my-4">
                            <h3 class="font-bold">Seller Details:</h3>
                            <div class="flex gap-1 mt-4">
                                <div class="grow w-8">
                                    <p class="font-bold">Name:</p>
                                    <p>{{ props.order.seller.name}}</p>
                                </div>
                                <div class="grow w-62">
                                    <p class="font-bold">Email:</p>
                                    <p>{{ props.order.seller.email}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </Collapsible>
            </div>
        </div>
       
        
    </div>
</template>



<style scoped>
.text-primary_color{
    color: #CC035C;
}
</style>