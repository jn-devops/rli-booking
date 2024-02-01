<script setup>

import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import FloorLogo from '@/Components/FloorLogo.vue';
import UnitLogo from '@/Components/UnitLogo.vue';
import FloorAreaLogo from '@/Components/FloorAreaLogo.vue';
import PaymentsModal from '@/Components/PaymentsModal.vue';
import { ref } from 'vue'
import ArrowIcon from '@/Components/ArrowIcon.vue';

const props = defineProps({
    voucherCode: String,
    order: Object
});

const form = useForm({
    property_code: null,
    dp_percent: '10',
    dp_months: '24',
});

const submit = () => {
    form.post(route('update-order', { voucher: props.voucherCode }), {
        onFinish: () => form.reset('property_code'),
    });

};

const modalActive = ref(null);
const toggleModal = () =>{
    modalActive.value = !modalActive.value;
}

const moreDetails = ref('rotate-0');
const showContent = ref(false);

const toggleMoreDetails = () => {
  moreDetails.value = moreDetails.value === 'rotate-0' ? 'rotate-180' : 'rotate-0';
  showContent.value = !showContent.value;
};
</script>

<template>
    <Head title="RLI Wizard" />

    <!-- <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template> -->


        <!-- <form @submit.prevent="submit">
            <div class="mt-4">

            </div> -->

            <!-- References -->
            <!-- <div class="col-span-6">
                <InputLabel :value="props.voucherCode" class="text-blue-500 dark:text-blue-200 font-extrabold"/>
                <div class="flex items-center">
                    <div class="ms-4 leading-tight">
                        <div class="text-gray-700 dark:text-gray-300 text-sm">
                            seller: {{ props.order.seller.name }} ({{ props.order.seller.email}})
                        </div>
                    </div>
                </div>
            </div> -->

            <!-- Property Code -->
            <!-- <div class="mt-4">
                <InputLabel for="property_code" value="Property Code" />
                <TextInput
                    id="property_code"
                    v-model="form.property_code"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    placeholder="e.g., PC-001, PC-002, PC-003, PC-004, PC-005"
                    autofocus
                />
                <div class="text-xs text-gray-600 dark:text-gray-400">{{ props.order.product.name }} ({{ props.order.product.sku }})}</div>
                <InputError class="mt-2" :message="form.errors.property_code" />
            </div> -->

            <!-- Percent DownPayment -->
            <!-- <div class="mt-4">
                <InputLabel for="dp_percent" value="Downpayment" />
                <TextInput
                    id="dp_percent"
                    v-model="form.dp_percent"
                    type="number"
                    min="0"
                    max="12"
                    class="mt-1 block w-full"
                    required
                    placeholder="e.g., 0-20"
                />
                <div class="text-xs text-gray-600 dark:text-gray-400">% of total contract price</div>
                <InputError class="mt-2" :message="form.errors.dp_percent" />
            </div> -->

            <!-- Months to Pay DownPayment -->
            <!-- <div class="mt-4">
                <InputLabel for="dp_months" value="Months" />
                <TextInput
                    id="dp_months"
                    v-model="form.dp_months"
                    type="number"
                    min="0"
                    max="24"
                    class="mt-1 block w-full"
                    required
                    placeholder="e.g., 0-24"
                />
                <div class="text-xs text-gray-600 dark:text-gray-400">to pay downpayment</div>
                <InputError class="mt-2" :message="form.errors.dp_months" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link :href="route('login')" class="ms-4 underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                    Select Property
                </Link>

                <Link :href="route('login')" class="ms-4 underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                    Choose Payment Terms
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Reserve
                </PrimaryButton>
            </div> -->
        <!-- </form> -->

        

    <!-- </AuthenticationCard> -->


    <!-- Kevin Changes 01/29/2024 -->
    <AuthenticationCard>

        <div class="">
            <div>
                <h1 class="font-bold text-2xl px-4">Zaya Studio Condominium Standard Inner Unit</h1>
            </div>
        </div>
        
        <div class="">
            <div class="grid grid-rows-1 md:grid-cols-2 lg:grid-cols-2">
                <div class="p-4">
                    <div class="mb-3">
                        <p class="text-sm font-bold">Reservation Code: <span class="text-lg font-bold text-sky-700">{{ props.voucherCode }}</span></p>
                    </div>
                    <div>
                        <img src="../../../img/Rectangle 39.png" alt="image" srcset="">
                    </div>
                    <div class="flex mt-3">
                        <div class="flex">
                            <FloorLogo />
                            <div class="mx-2">
                                <p class="text-gray-600">Floor</p>
                                <p>1st Floor</p>
                            </div>
                        </div>
                        <div class="flex mx-4 ">
                           <UnitLogo />
                           <div class="mx-2">
                                <p class="text-gray-600">Unit</p>
                                <p>B</p>
                            </div>
                        </div>
                        <div class="flex">
                            <FloorAreaLogo />
                            <div class="mx-2">
                                <p class="text-gray-600">Floor Area</p>
                                <p>24 SQM</p>
                            </div>
                        </div>
                        
                    </div>
                    <div class="md:hidden flex">
                            <button @click="toggleMoreDetails" class="border p-2 rounded flex justify-center items-center gap-2 text-1xl" id="more-details">More Details<ArrowIcon :class="moreDetails"/></button>
                    </div>

                    <div class="md:hidden lg:hidden"
                    v-if="showContent"
                    >
                        <div class="my-6">
                            <div class="border-b-2 pb-4">
                                <div class="font-bold leading-loose">
                                    <p class="">Property Code: <span class="">ZAYA-1A-BO1-1FB</span></p>
                                    <p>Location: <span class="font-normal">Brgy. Balibago, Sta. Rosa City, Laguna</span></p>
                                    <p>Bedrooms: <span class="font-normal">Studio</span></p>
                                    <p>Toilet and Bath: <span class="font-normal">1</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="my-6">
                            <div class="pb-4">
                                <div class="font-bold leading-loose">
                                    <p class="">Seller Details:</p>
                                    <p>Name: <span class="font-normal">Charles Ley Baldmor</span></p>
                                    <p>Email: <span class="font-normal">cbbaldemor@joy-nostalg.com</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="my-6">
                            <div class="border-b-2 pb-4">
                                <div class="font-bold leading-loose">
                                    <p class="">Property Code: <span class="">ZAYA-1A-BO1-1FB</span></p>
                                    <p>Location: <span class="font-normal">Brgy. Balibago, Sta. Rosa City, Laguna</span></p>
                                    <p>Bedrooms: <span class="font-normal">Studio</span></p>
                                    <p>Toilet and Bath: <span class="font-normal">1</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="my-6">
                            <div class="pb-4">
                                <div class="font-bold leading-loose">
                                    <p class="">Seller Details:</p>
                                    <p>Name: <span class="font-normal">Charles Ley Baldmor</span></p>
                                    <p>Email: <span class="font-normal">cbbaldemor@joy-nostalg.com</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                  

                    <!-- Mobile -->
                    <!-- <div v-if="showContent">
                        <h1>Hello World</h1>
                    </div> -->
                    <!-- <div class="wrapper w-5/6">
                        <div class="tab bg-white px-5 py-3 shadow-lg rounded-md relative">
                            <input type="checkbox" name="faq" id="faq1" class="appearance-none peer opacity-0">
                            <label for="faq1" class="flex items-center text-lg  font-semibold after:absolute after:content-['>'] after:right-5 after:text-2xl after:text-gray-400 hover:after:text-gray-900 peer-checked:after:transform peer-checked:after:rotate-45">
                                <h2 class="mr-2 h-8 w-8 bg-cyan-400 grid place-items-center text-white rounded full">02</h2>
                                <h3>What is Tailwind CSS?</h3>
                            </label>
                            <div class="answer mt-5 h-0 overflow-hidden transition ease-in-out duration-500 peer-checked:h-full">
                                <p>Sample tailwind </p>
                            </div>
                        </div>
                    </div> -->
                </div>
                
                <div class="p-4">
                    <div class="mb-4 pb-4">
                        <p class="font-bold">Total Contract Price:</p>
                        <p>₱2,700,000.00</p>
                    </div>
                    <div class="border-t-2 pt-4 pb-0">
                        <p class="text-sm">Calculate Financial Scheme</p>
                        <div class="">
                            <p class="font-bold py-3">Select Downpayment Rate: 20%</p>
                            <div class="slidecontainer py-1">
                                <input type="range" min="0" max="100" value="50" class="slider" id="myRange">
                                <p class="py-2">₱540,000.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="border-b-2 py-4">
                        <div class="">
                            <p class="font-bold py-3">Select Downpayment Term: 24 Months</p>
                            <div class="slidecontainer py-1">
                                <input type="range" min="0" max="100" value="25" class="slider" id="myRange">
                                
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-4">
                        <p class="font-bold">Monthly Amortization</p>
                        <p class="text-primary_color text-3xl">₱22,500.00</p>
                    </div>

                    <div class="grid grid-rows-1 xl:grid-cols-3 mt-6 gap-2">
                        <div class="col-span-2">
                            <p class="font-bold text-2xl">Reservation Fee:</p>
                            <p class="text-primary_color text-5xl font-bold">₱10,000.00</p>
                        </div>
                        <div class="grid items-center">
                            <button class="border border-red-300 btnReserve p-5" @click="toggleModal">Reserve Now</button>
                        </div>
                    </div>
                    <div class="mt-3">
                        <p>The remaining 80% of the total contract price will be paid through financial institution.</p>
                    </div>
                </div>
                
                <div>
                    <PaymentsModal :modalActive="modalActive" @close-modal="toggleModal"/>
                </div>
            </div>
        </div>

    </AuthenticationCard>

</template>

<style>
input[type="range"] {
  /* removing default appearance */
  -webkit-appearance: none;
  appearance: none; 
  /* creating a custom design */
  width: 100%;
  cursor: pointer;
  outline: none;
  /*  slider progress trick  */
  overflow: hidden;
  border-radius: 16px;
}

/* Track: webkit browsers */
input[type="range"]::-webkit-slider-runnable-track {
  height: 20px;
  background: #ccc;
  border-radius: 16px;
}

/* Track: Mozilla Firefox */
input[type="range"]::-moz-range-track {
  height: 20px;
  background: #ccc;
  border-radius: 16px;
}

/* Thumb: webkit */
input[type="range"]::-webkit-slider-thumb {
  /* removing default appearance */
  -webkit-appearance: none;
  appearance: none; 
  /* creating a custom design */
  height: 20px;
  width: 20px;
  background-color: #fff;
  border-radius: 50%;
  border: 2px solid #fff;
  /*  slider progress trick  */
  box-shadow: -407px 0 0 400px #7BA7EA;
}


/* Thumb: Firefox */
input[type="range"]::-moz-range-thumb {
  height: 20px;
  width: 20px;
  background-color: #fff;
  border-radius: 50%;
  border: 1px solid #fff;
  /*  slider progress trick  */
  box-shadow: -407px 0 0 400px #7BA7EA;
}

.text-primary_color{
    color: #CC035C;
}

.btnReserve{
    background: linear-gradient(268deg, #CC035C 7.47%, #FCB115 98.92%);
    color: #fff;
    border-radius: 20px;
    width: 100%;
}
</style>