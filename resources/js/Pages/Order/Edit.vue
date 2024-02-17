<script setup>

import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { onMounted, ref, watch, computed } from 'vue'

const props = defineProps({
    voucherCode: String,
    order: Object
});
const selectedTerm = ref('Selected');
const selectedDownpayment = ref(null);
const selectedMonths = ref(null);
const selectedValues = ref({});


const onChange = (event) =>{
    selectedTerm.value = event.target.value;
    form.terms = event.target.value;
    selectedDownpayment.value = null;
    selectedMonths.value = null;
}
// Function to handle downpayment change
const handleDownpaymentChange = () => {
    let selectDPVal =  (selectedDownpayment.value / 100).toFixed(2);
    //   console.log('Selected Downpayment:', selectDPVal);
    //   console.log('Selected Downpayment:', selectedDownpayment.value);
  form.dp_percent = selectedDownpayment.value;
//   downPayment(selectDPVal);
//   totalDP(selectDPVal);
//   DPComputation(selectDPVal);
//   console.log('percent: ',form);
};

// Function to handle months change
const handleMonthsChange = () => {
//   console.log('Selected Months:', selectedMonths.value);
  form.dp_months = selectedMonths.value;
//   monthsToPay(selectedMonths.value);
//   return selectedMonths.value;
//   console.log('months: ',form);
};

const form = useForm({
    // property_code: props.order?.property_code,
    // dp_percent: '10',
    // dp_months: '24',
     property_code: props.order?.property_code,
    dp_percent: selectedDownpayment.value,
    dp_months: selectedMonths.value
});
const submit = () => {
    form.post(route('update-order', { voucher: props.voucherCode }), {
        onFinish: () => form.reset('property_code'),
    });
};
</script>

<template>
    <Head title="RLI Wizard" />

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>


        <form @submit.prevent="submit">
            <div class="mt-4">

            </div>

            <!-- References -->
            <div class="col-span-6">
                <InputLabel :value="props.voucherCode" class="text-blue-500 dark:text-blue-200 font-extrabold"/>
                <div class="flex items-center">
                    <div class="ms-4 leading-tight">
                        <div class="text-gray-700 dark:text-gray-300 text-sm">
                            seller: {{ props.order.seller.name }} ({{ props.order.seller.email}})
                        </div>
                    </div>
                </div>
            </div>

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
            <div class="mt-4">
                <label for="property_code" class="block font-medium leading-6 text-gray-900">Property Code</label>
                <div class="mt-2 flex rounded-md shadow-sm">
                    <div class="relative flex flex-grow items-stretch focus-within:z-10">
                    <input 
                    id="property_code"
                    v-model="form.property_code"
                    type="text"
                    class="block w-full rounded-none rounded-l-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" 
                    placeholder="e.g., PC-001, PC-002, PC-003, PC-004, PC-005"
                     autofocus>
                    </div>
                    <!-- <button 
                    @click="showModal"
                    type="button" class="relative -ml-px inline-flex items-center gap-x-1.5 rounded-r-md px-6 py-2 text-sm font-semibold text-white bg-gray-800 ring-1 ring-inset ring-gray-300 hover:bg-gray-600">
                    Choose Unit
                    </button> -->
                    <button
                    @click="openModal"
                    class="bg-gray-800 text-white px-6 py-2 rounded"
                    >
                        Choose Unit
                    </button>
                </div>
               
            </div>

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
            </div> -->
            <div class="mt-4">
                <InputLabel for="terms" value="Terms" />
                <select @change="onChange" id="terms" name="terms" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" v-model="selectedTerm">
                    <option selected disabled value="Selected">Selected</option>
                    <option value="Downpayment">Downpayment</option>
                    <option value="Spotcash">Spotcash</option>
                </select>

                <div v-if="selectedTerm === 'Downpayment'" class="block mt-4">
                    <InputLabel for="downpayment" value="Downpayment" />
                    <select id="downpayment" name="downpayment" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" v-model="selectedDownpayment" @change="handleDownpaymentChange">
                        <option value="10" selected>10%</option>
                        <option value="30">30%</option>
                    </select>

                    <div class="mt-3">
                        <InputLabel for="months" value="Months" />
                        <select id="months" name="months" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" v-model="selectedMonths" @change="handleMonthsChange">
                            <option value="36">36 Months</option>
                            <option value="48">48 Months</option>
                            <option value="60">60 Months</option>
                        </select>
                    </div>
                </div>
                <div v-else class="block mt-4">
                    <InputLabel for="spotcash"  value="Spotcash" />
                    <select id="spotcash" name="spotcash" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" v-model="selectedDownpayment" @change="handleDownpaymentChange">
                        <option value="100">100%</option>
                    </select>

                    <div class="mt-3">
                        <InputLabel for="months" value="Months" />
                        <select id="months" name="months" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" v-model="selectedMonths">
                            <option value="1">1 Month</option>
                        </select>
                    </div>
                    
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <!-- <Link :href="route('login')" class="ms-4 underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                    Select Property
                </Link>

                <Link :href="route('login')" class="ms-4 underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                    Choose Payment Terms
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Reserve
                </PrimaryButton> -->
                <button 
                @click="openViewAmortization"
                class="bg-gray-200 px-6 py-2 rounded">View Amortization</button>
                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="submit()">
                Reserve
                </PrimaryButton>
            </div>
        </form>
    </AuthenticationCard>
</template>
