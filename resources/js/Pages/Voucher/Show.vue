<script setup>

import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { router } from "@inertiajs/vue3";

const props = defineProps({
    booking: Object,
    voucherCode: String,
    product: Object,
    qrCode: String,
    seller: Object,
    buyer: Object,
    url: String,
});

Echo.channel(`voucher.${props.voucherCode}`)
    .listen('.buyer.processed', (e) => {
        router.reload();
        console.log(e);
    })
</script>

<template>
    <Head title="RLI Booking" http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"/>

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>
        <template v-if="buyer">
            <div>Buyer:</div>
            <div>{{ buyer.name }}</div>
            <div>{{ buyer.address }}</div>
            <div>{{ buyer.birthdate }}</div>
            <div>{{ buyer.id_type }}</div>
            <div>{{ buyer.id_number }}</div>
            <div>Seller:</div>
            <div>{{ seller.name }}</div>
            <div>{{ seller.email }}</div>
            <div>Product:</div>
            <div>{{ product.name }}</div>
            <div>{{ product.sku }}</div>
            <div>{{ product.processing_fee }}</div>
        </template>
        <template v-else>
            <div class="text-center py-6">
                Take note of the reservation code:
                <div class="font-extrabold text-blue-500">{{ booking.reference_code }}</div>
                Scan the QR code below to authenticate (eKYC)
                <div class="mt-4 mb-2 p-2 inline-block bg-white center" v-html="qrCode" />
                <!-- <div><button class="bg-gray-500 text-white"><a :href="url">Or click this ugly button to authenticate (eKYC)</a></button></div> -->
                <div>
                    <button class="bg-gray-500 text-white">
                        <a :href="url" class="border border-black text-white bg-black mt-4 py-2 px-6 rounded">Proceed to Authenticate</a>
                    </button>
                </div>
            </div>
            <div> {{ booking }} </div>

        </template>
    </AuthenticationCard>
</template>
