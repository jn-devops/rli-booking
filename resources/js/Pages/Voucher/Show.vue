<script setup>

    import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
    import AuthenticationCard from '@/Components/AuthenticationCard.vue';
    import { Head, Link, useForm } from '@inertiajs/vue3';
    import { router } from "@inertiajs/vue3";
    import ButtonPrimary from '@/MyComponents/ButtonPrimary.vue';
    
    const props = defineProps({
        booking: Object,
        voucherCode: String,
        // product: Object,
        qrCode: String,
        // seller: Object,
        buyer: Object,
        url: String,
    });
    console.log('url', props.url);
    console.log('booking:', props.booking);
    console.log('buyer info:', props.buyer);
    Echo.channel(`voucher.${props.voucherCode}`)
        .listen('.buyer.processed', (e) => {
            router.reload();
            console.log(e);
        })
    </script>
    <template>
        <Head title="RLI Booking" http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"/>
        <template v-if="buyer">
           
            <div class="relative">
                <div class="bg_rli-primary h-36 z-10"></div>
                <div class="drop-shadow-2xl h-screen block_div-content">
                    <div class="bg-white lg:w-3/4 sm:w-auto md:w-auto mx-auto rounded p-4">
                        <div class="p-4">
                            <div class="border-b-2 py-4">
                                <div class="grid  md:grid-rows-1 lg:grid-cols-2">
                                    <div class="pb-4">
                                        <img src="../../../img/Elnvital_Logo.png" alt="" class="h-36 w-auto mx-auto">
                                    </div>
                                    <div class="pb-4 md:mx-auto">
                                        <p class="mb-3 text-primary font-bold text-xl">Thank you for choosing <br />
                                            Raemulan Lands Inc. for your reservation.</p>
                                        <p>We are looking forward to making your stay comfortable and enjoyable.</p>
                                    </div>
                                </div>
                            </div>
                         
                            <div class="mt-4" v-if="props.booking.order.dp_percent === 10">
                                <div class="">
                                    <h6 class="font-bold my-1 text-gray-500">Client Details</h6>
                                    <div class="bg-sky-50 p-4 rounded">
                                        <div class="grid lg:grid-cols-2 sm:grid-rows-1 lg:gap-8 px-8">
                                            <div class="flex gap-6">
    
                                                <div class="font-bold ">
                                                    <ul>
                                                        <li>Name:</li>
                                                    </ul>
                                                </div>
                                                <div class="pl-8 w-full lg:text-left lg:pr-7">
                                                    <p>{{ props.booking.order.buyer.name }}</p>
                                                </div>
                                            </div>
                                            <div class="flex">
                                                <div class="font-bold">
                                                <p>Contact Number:</p>
                                                </div>
                                                <div class="pl-8">
                                                    <p>{{ props.booking.order.buyer.mobile }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <h6 class="font-bold my-1 text-gray-500">Reservation Details</h6>
                                    <div class="bg-sky-50 p-4 rounded">
                                        <div class="grid lg:grid-cols-2 sm:grid-rows-1 lg:gap-8 px-6">
                                            <div class="flex py-2">
                                                <div class="font-bold">
                                                    <ul>
                                                        <li class="">Reference Code:</li>
                                                        <li class="">Project Name:</li>
                                                        <li class="">Unit Type:</li>
                                                        <li class="mt-3">Total Contract Price:</li>
                                                    </ul>
                                                </div>
                                                <div class="pl-8">
                                                    <ul>
                                                        <li class="">{{ props.booking.reference_code }}</li>
                                                        <li class="">{{ props.booking.order.product.brand }}</li>
                                                        <li class="">{{ props.booking.order.product.unit_type.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ') }}</li>
                                                        <li class="mt-3">₱ {{ props.booking.order.product.price.toLocaleString() }}.00</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="flex py-2">
                                                <div class="font-bold">
                                                   <ul>
                                                        <li>Reservation Fee:</li>
                                                        <li>Payment Term:</li>
                                                        <li>Downpayment</li>
                                                        <li>Balance</li>
                                                   </ul>
                                                </div>
                                                <div class="pl-5">
                                                    <ul>
                                                        <li>₱{{ props.booking.order.product.processing_fee.toLocaleString()}}.00</li>
                                                        <li>Downpayment - {{ props.booking.order.dp_percent }}%</li>
                                                        <li>₱7,500.00</li>
                                                        <li>₱ 2,610,000.00</li>
                                                   </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4 px-6">
                                            <p class="text-primary text-sm">Remaining balance will be paid thru preferred Financing</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <h6 class="font-bold my-1 text-gray-500">Payment Details</h6>
                                    <div class="bg-sky-50 p-4 rounded">
                                        <div class="grid lg:grid-cols-2 sm:grid-rows-1 lg:gap-8 px-8">
                                            <div class="flex py-2">
                                                <div class="font-bold">
                                                    <ul>
                                                        <!-- <li>Mode of Payment:</li> -->
                                                        <li>Payment Due Date:</li>
                                                        <li>Amount to Pay:</li>
                                                    </ul>
                                                </div>
                                                <div class="pl-8">
                                                    <ul>
                                                        <!-- <li>Gcash</li> -->
                                                        <li>&nbsp;</li>
                                                        <li class="text-primary font-bold">₱{{ props.booking.order.product.processing_fee.toLocaleString() }}.00</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4" v-else-if="props.booking.order.dp_percent === 30">
                                <div class="">
                                    <h6 class="font-bold my-1 text-gray-500">Client Details</h6>
                                    <div class="bg-sky-50 p-4 rounded">
                                        <div class="grid lg:grid-cols-2 sm:grid-rows-1 lg:gap-8 px-8">
                                            <div class="flex gap-6">
    
                                                <div class="font-bold ">
                                                    <ul>
                                                        <li>Name:</li>
                                                    </ul>
                                                </div>
                                                <div class="pl-8 w-full lg:text-left lg:pr-7">
                                                    <p>{{ props.booking.order.buyer.name }}</p>
                                                </div>
                                            </div>
                                            <div class="flex">
                                                <div class="font-bold">
                                                <p>Contact Number:</p>
                                                </div>
                                                <div class="pl-8">
                                                    <p>{{ props.booking.order.buyer.mobile }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <h6 class="font-bold my-1 text-gray-500">Reservation Details</h6>
                                    <div class="bg-sky-50 p-4 rounded">
                                        <div class="grid lg:grid-cols-2 sm:grid-rows-1 lg:gap-8 px-6">
                                            <div class="flex py-2">
                                                <div class="font-bold">
                                                    <ul>
                                                        <li class="">Reference Code:</li>
                                                        <li class="">Project Name:</li>
                                                        <li class="">Unit Type:</li>
                                                        <li class="mt-3">Total Contract Price:</li>
                                                    </ul>
                                                </div>
                                                <div class="pl-8">
                                                    <ul>
                                                        <li class="">{{ props.booking.reference_code }}</li>
                                                        <li class="">{{ props.booking.order.product.brand }}</li>
                                                        <li class="">{{ props.booking.order.product.unit_type.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ') }}</li>
                                                        <li class="mt-3">₱ {{ props.booking.order.product.price.toLocaleString() }}.00</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="flex py-2">
                                                <div class="font-bold">
                                                   <ul>
                                                        <li>Reservation Fee:</li>
                                                        <li>Payment Term:</li>
                                                        <li>Downpayment</li>
                                                        <li>Balance</li>
                                                   </ul>
                                                </div>
                                                <div class="pl-5">
                                                    <ul>
                                                        <li>₱{{ props.booking.order.product.processing_fee.toLocaleString()}}.00</li>
                                                        <li>Downpayment - {{ props.booking.order.dp_percent }}%</li>
                                                        <li>₱23,611.11</li>
                                                        <li>₱ 2,030,000.00</li>
                                                   </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4 px-6">
                                            <p class="text-primary text-sm">Remaining balance will be paid thru preferred Financing</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <h6 class="font-bold my-1 text-gray-500">Payment Details</h6>
                                    <div class="bg-sky-50 p-4 rounded">
                                        <div class="grid lg:grid-cols-2 sm:grid-rows-1 lg:gap-8 px-8">
                                            <div class="flex py-2">
                                                <div class="font-bold">
                                                    <ul>
                                                        <!-- <li>Mode of Payment:</li> -->
                                                        <li>Payment Due Date:</li>
                                                        <li>Amount to Pay:</li>
                                                    </ul>
                                                </div>
                                                <div class="pl-8">
                                                    <ul>
                                                        <!-- <li>Gcash</li> -->
                                                        <li>&nbsp;</li>
                                                        <li class="text-primary font-bold">₱{{ props.booking.order.product.processing_fee.toLocaleString() }}.00</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4" v-else>
                                <div class="">
                                    <h6 class="font-bold my-1 text-gray-500">Client Details</h6>
                                    <div class="bg-sky-50 p-4 rounded">
                                        <div class="grid lg:grid-cols-2 sm:grid-rows-1 lg:gap-8 px-8">
                                            <div class="flex gap-6">
    
                                                <div class="font-bold ">
                                                    <ul>
                                                        <li>Name:</li>
                                                    </ul>
                                                </div>
                                                <div class="pl-8 w-full lg:text-left lg:pr-7">
                                                    <p>{{ props.buyer.name }}</p>
                                                </div>
                                            </div>
                                            <div class="flex">
                                                <div class="font-bold">
                                                <p>Contat Number:</p>
                                                </div>
                                                <div class="pl-8">
                                                    <p>{{ props.buyer.mobile }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <h6 class="font-bold my-1 text-gray-500">Reservation Details</h6>
                                    <div class="bg-sky-50 p-4 rounded">
                                        <div class="grid lg:grid-cols-2 sm:grid-rows-1 lg:gap-8 px-6">
                                            <div class="flex py-2">
                                                <div class="font-bold">
                                                    <ul>
                                                        <li class="">Reference Code:</li>
                                                        <li class="">Project Name:</li>
                                                        <li class="">Unit Type:</li>
                                                        <li class="mt-3">Total Contract Price:</li>
                                                    </ul>
                                                </div>
                                                <div class="pl-8">
                                                    <ul>
                                                        <li class="">{{ props.booking.reference_code }}</li>
                                                        <li class="">{{ props.booking.order.product.brand }}</li>
                                                        <li class="">{{ props.booking.order.product.unit_type.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ') }}</li>
                                                        <li class="mt-3">₱ {{ props.booking.order.product.price.toLocaleString() }}.00</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="flex py-2">
                                                <div class="font-bold">
                                                   <ul>
                                                        <li>Reservation Fee:</li>
                                                        <li>Payment Term:</li>
                                                        <li>Downpayment</li>
                                                        <li>Balance</li>
                                                   </ul>
                                                </div>
                                                <div class="pl-8">
                                                    <ul>
                                                        <li>₱{{ props.booking.order.product.processing_fee.toLocaleString()}}.00</li>
                                                        <li>Spotcash - 100%</li>
                                                        <li>₱00.00</li>
                                                        <li>₱ 2,880,000.00</li>
                                                   </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4 px-6">
                                            <p class="text-primary text-sm">Remaining balance will be paid thru preferred Financing</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <h6 class="font-bold my-1 text-gray-500">Payment Details</h6>
                                    <div class="bg-sky-50 p-4 rounded">
                                        <div class="grid lg:grid-cols-2 sm:grid-rows-1 lg:gap-8 px-8">
                                            <div class="flex py-2">
                                                <div class="font-bold">
                                                    <ul>
                                                        <!-- <li>Mode of Payment:</li> -->
                                                        <li>Payment Due Date:</li>
                                                        <li>Amount to Pay:</li>
                                                    </ul>
                                                </div>
                                                <div class="pl-8">
                                                    <ul>
                                                        <!-- <li>MOD Data</li> -->
                                                        <li>&nbsp;</li>
                                                        <li class="text-primary font-bold">₱{{ props.booking.order.product.processing_fee.toLocaleString() }}.00</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="grid lg:grid-cols-6">
                                    <div class="py-4 px-2 lg:col-span-4">
                                        <p>To ensure the seamless processing of your reservation, we kindly request that you complete the payment within the next 3 working days.If you have already made the payment, kindly disregard this message</p>
                                    </div>
                                    <!-- <div class="py-4 px-1 lg:col-span-2 place-self-center">
                                        <Link
                                        href="/invoice" 
                                        class="border p-4 rounded-lg bg_rli-primary text-white text-sm">Proceed to Billing Statement</Link>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
               
               
        </template>
        <template v-else>
            <AuthenticationCard> 
                <template #logo>
                    <!-- <AuthenticationCardLogo /> -->
                </template>
                <div class="text-center py-6 dark:text-white light:text-black">
                    Take note of the reservation code:
                    <div class="font-extrabold text-blue-500">{{ props.voucherCode }}</div>
                    <!-- <div class="font-extrabold text-blue-500">{{ props.booking.reference_code }}</div> -->
                    Scan the QR code below to authenticate (eKYC)
                    <div class="mt-4 mb-2 p-2 inline-block bg-white center" v-html="qrCode" />
                    <!-- <div><button class="bg-gray-500 text-white"><a :href="url">Or click this ugly button to authenticate (eKYC)</a></button></div> -->
                    <div>
                        <ButtonPrimary>
                            <a :href="url" class="p-5 dark:text-white light:text-black">Proceed to Authenticate</a>
                        </ButtonPrimary>
                        <!-- <button class="bg-gray-500 text-white">
                            <a :href="url" class="border border-black text-white bg-black mt-4 py-2 px-6 rounded">Proceed to Authenticate</a>
                        </button> -->
                    </div>
                </div>
            </AuthenticationCard> 
        </template>
        
    </template>
    <style>
    .block_div-content{
        position: absolute;
        top: 35%;
        left: 11%;
        width: 80%;
    }
    .bg_rli-primary{
        background: linear-gradient(268deg, #FCB115 7.47%, #CC035C 98.92%);
    }
    .text-primary{
        color: #CC035C;
    }
    
    @media screen and (min-width: 320px) {
        .block_div-content{
            width: 100%;
            left: 0;
            /* overflow: hidden; */
        }
    }
    @media screen and (min-width: 760px){
        /* .block_div-content{
    
        } */
    }
    
    @media screen and (min-width: 1028px) {
        .block_div-content{
            position: absolute;
            top: 35%;
            left: 11%;
            width: 80%;
        }
    }
    </style>
    <!-- <template>
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
                    <div>
                        <button class="bg-gray-500 text-white">
                            <a :href="url" class="border border-black text-white bg-black mt-4 py-2 px-6 rounded">Proceed to Authenticate</a>
                        </button>
                    </div>
                </div>
                <div> {{ booking }} </div>
    
            </template>
        </AuthenticationCard>
    </template> -->
    