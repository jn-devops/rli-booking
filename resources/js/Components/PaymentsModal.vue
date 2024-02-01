<template>
    <div
    v-show="modalActive" 
    class="absolute w-full  bg-black bg-opacity-30 lg:h-screen top-0 left-0 flex justify-center p-8">
        <div
        v-if="modalActive" 
        class="p-4 bg-white self-start mt-32 max-w-screen-lg dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg rounded">
            <div class="w-full">
                <div class="container mb-4">
                    <div class="grid justify-end">
                        <button
                        @click="$emit('close-modal')"
                        >X</button>
                    </div>
                    <div class="font-bold">
                        <p class="text-2xl text-center">Select Payment Options</p>
                    </div>
                </div>
                <div class="container">
                    <div class="grid grid-rows-1 md:grid-cols-2 lg:grid-cols-3">
                        <div class="px-3">
                            <div class="border-solid border-black-100 rounded ">
                                <div class="bg_rli-primary text-white rounded text-center p-2 font-bold text-2xl">E-wallet</div>
                                <div class="border grid grid-cols-3 p-4 border-t-0 rounded bg-neutral-50">
                                    <div class="p-4 flex flex-col items-center" style="height: 100px;">
                                        <Link
                                        href="/invoice"
                                        >
                                            <img src="../../img/Gcash.png" alt="" class="w-full h-full object-cover">
                                        </Link>
                                    </div>
                                    <div class="p-4 flex flex-col items-center" style="height: 100px;">
                                        <Link
                                        href="/invoice"
                                        >
                                            <img src="../../img/GrabPay.png" alt="" class="w-full h-full object-cover">
                                        </Link>
                                    </div>
                                    <div class="p-4 flex flex-col items-center" style="height: 100px;">
                                        <Link
                                        href="/invoice"
                                        >
                                        <img src="../../img/ShopeePay.png" alt="" class="w-full h-full object-cover">
                                        </Link>
                                    </div>
                                </div>
                            </div>
                            <div class="border-solid border-black-100 rounded mt-4">
                                <div class="bg_rli-primary text-white rounded text-center p-2 font-bold text-2xl">InstaPay</div>
                                <div class="border grid grid-cols-1 p-4 border-t-0 rounded bg-neutral-50">
                                    <div class="flex items-center" style="height: 100px">
                                        <img src="../../img/InstaPay.png" alt="" class="w-full h-full object-cover">
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="px-3">
                            <div class="border-solid border-black-100 rounded">
                                <div class="bg_rli-primary text-white rounded text-center p-2 font-bold text-2xl">Credit Card</div>
                                <div class="border grid grid-cols-2 p-4 items-center border-t-0 rounded bg-neutral-50">
                                    <div class="p-4 flex flex-col items-center" style="height: 100px">
                                        <img src="../../img/MasterCard.png" alt="">
                                    </div>
                                    <div class="p-4 flex items-center" style="height: 100px">
                                        <img src="../../img/Visa.png" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-3">
                            <div class="border-solid border-black-100 rounded">
                                <div class="bg_rli-primary text-white rounded text-center p-2 font-bold text-2xl">QR PH</div>
                                <div class="border grid grid-cols-1 p-4 items-center border-t-0 rounded bg-neutral-50">
                                    <div class="p-4 flex items-center">
                                        <img src="../../img/QrPh.png" alt="" class="w-32">
                                    </div>
                                    <div class="p-4 flex items-center">
                                        <img src="../../img/PaymentMethods.png" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3';
    defineEmits(['close-modal']);
    defineProps({
        modalActive: {
            type: Boolean,
            default: false,
        }
    })
</script>

<style scoped>
 .bg_rli-primary{
     background: linear-gradient(268deg, #FCB115 7.47%, #CC035C 98.92%);
 }
</style>