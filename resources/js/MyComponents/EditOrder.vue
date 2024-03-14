<script setup>
import FloorAreaLogo from './FloorAreaLogo.vue';
import LotAreaLogo from './LotAreaLogo.vue';
import FloorLogo from './FloorLogo.vue';
import Collapsible from './Collapsible.vue';

const props = defineProps({
    propertyCode: String,
    order: Object
})

// console.log("property_code: ", props.propertyCode);
// console.log("order: ", props.order);
</script>

<template>
    <div class=" grid grid-rows-1 gap-2 md:gap-5">
        <!-- Tablet/Desktop -->
        <div class="hidden md:block">
            <img src="../../img/Rectangle 39.png">
            <div class="grid grid-cols-3 mt-4">
                <div class="flex gap-3">
                    <FloorLogo />
                    <div>
                        <p class="text-gray-400">Floor</p>
                        <p>1st Floor</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <LotAreaLogo />
                    <div>
                        <p class="text-gray-400">Unit</p>
                        <p>B</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <FloorAreaLogo />
                    <div>
                        <p class="text-gray-400">Floor Area</p>
                        <p>24 SQM</p>
                    </div>
                </div>
            </div>
            <div class="mt-4 relative">
                <div class="flex rounded-md shadow-sm">
                    <slot />
                </div>
            </div>
            <!-- <div class="my-4 font-bold">
                <p>Calculate Financial Scheme</p>
            </div> -->
            <div class="hidden md:block">
            <div class="mt-4">
                <div class="border-b-2 pb-4">
                    <div class="flex gap-1">
                        <p class="text-sm font-bold">Total Contract Price:</p>
                        <p class="text-sm font-bold">₱2,900,000.00</p>
                    </div>
                    <div class="mt-2">
                        <p class="font-bold">Reservation Fee:</p>
                        <p class="text-4xl font-bold text-primary_color">₱{{ props.order.product.processing_fee.toLocaleString() }}.00</p>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <div class="border-b-2 pb-4 mt-4 py-3">
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
            <div class="my-4">
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
        </div>
        <!-- Mobile -->
        <div class="block md:hidden">
            <img src="../../img/Rectangle 39.png">
            <div class="my-4 relative">
                <div class="flex rounded-md shadow-sm">
                    <slot />
                </div>
            </div>
            <div class="w-full">
                <Collapsible>
                    <div class="grid grid-cols-3">
                        <div class="flex gap-3">
                            <FloorLogo />
                            <div>
                                <p class="text-gray-400">Floor</p>
                                <p>1st Floor</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <LotAreaLogo />
                            <div>
                                <p class="text-gray-400">Unit</p>
                                <p>B</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <FloorAreaLogo />
                            <div>
                                <p class="text-gray-400">Floor Area</p>
                                <p>24 SQM</p>
                            </div>
                        </div>
                    </div>
                    <div class="">
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