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
    order: Object,
    property_code: String
});
const selectedTerm = ref('Selected');
const selectedDownpayment = ref(null);
const selectedMonths = ref(null);
const selectedValues = ref({});
const tcp = ref(2700000);
const rFee = ref(27000);

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
     property_code: props.property_code,
    dp_percent: selectedDownpayment.value,
    dp_months: selectedMonths.value
});


const viewAmortizationModal = ref(null);
const openViewAmortization = () =>{
    viewAmortizationModal.value = !viewAmortizationModal.value;
}


const downPayment = (percentage) =>{
    // console.log('downPayment Function: ',  percentage);
    // console.log('downPayment Function: ',  tcp.value * percentage);
    return Number(tcp.value * percentage - 27000);
}


const resultDP = computed(() => {
    return downPayment((selectedDownpayment.value / 100).toFixed(2));
  });


//   const resultToPay = new Array();
  const monthsToPay = (months) =>{
    // console.log(`DP Staggered / ${months} months: `, resultDP.value / months);
    // return resultDP.value / months;
    const resultToPay = [];
    let resultVal = resultDP.value / months;
    // let resultVal1 = resultDP.value - resultVal ;
    for(let i = 0; i <= months; i++){
        // resultToPay[i] = i;
        // resultToPay[i] =  resultVal;
        let additionalData = resultDP.value - resultVal * i;
        resultToPay[i] = { value: resultVal, additionalData: additionalData };
    }
    // console.log(resultToPay);
    return resultToPay.slice(1);


    // return parseInt(resultDP / months);
  }

  const resultMonthstoPay = computed(() =>{
    // console.log('testing: ', monthsToPay(selectedMonths.value));
    return monthsToPay(selectedMonths.value);
    
  });

const totalDP = (dpParam) =>{
    // console.log('dpParam: ',2700000 * dpParam);
    let totDp = tcp.value * dpParam;
    // console.log('totDp: ',totDp);
    // console.log('totDp1: ',2700000 - totDp);
    let overTotDp = tcp.value - totDp;

    // console.log('overTotDp: ', overTotDp);
    return overTotDp;
}
const overAllTot = computed(() =>{
    return totalDP((selectedDownpayment.value / 100).toFixed(2));
})

const DPComputation = (downpayment) =>{
    let dpTotal = tcp.value * downpayment;
    // console.log('computation: ', dpTotal);
    return dpTotal;
}

const DPComputationTotal = computed(() =>{
    return DPComputation((selectedDownpayment.value / 100).toFixed(2));
});


// Spotcash functions
const spotCash = () =>{
    let spotPay = tcp.value - rFee.value;
    // let totalSpot = spotPay - 
    return spotPay;
}

const totalSpotCash = computed(() =>{
    return spotCash((selectedDownpayment.value / 100).toFixed(2));
});
const submit = () => {
    form.post(route('update-order', { voucher: props.voucherCode }), {
        onFinish: () => form.reset('property_code'),
    });
};

const navigateToMapLink = () => {
  

    const currentPath = window.location.pathname; // Get the current path
    const newPath = `/view-map/${props.order.sku}/${props.voucherCode}/${props.order.id}`;

    const newUrl = `${window.location.origin}${newPath}`;

    // Use replaceState to change the URL without adding a new entry to the browser history
    window.location.replace(newUrl);

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
                    target="_blank"
                    @click="navigateToMapLink"
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
                <div class="mt-4" v-if="selectedTerm === 'Downpayment' && selectedDownpayment && selectedMonths">
                    <div class="mt-4">
                        <InputLabel for="rDate" value="Reservation Date" />
                        <input 
                        id="rDate"
                        type="text"
                        class="block w-full rounded-none rounded-l-md border-0 py-1.5 text-black ring-1 ring-inset ring-gray-300 placeholder:text-black focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 bg-gray-100" 
                        placeholder="January 1, 2024"
                        disabled>
                    </div>
                    <div class="mt-4">
                        <InputLabel for="rDueDate" value="Reservation Due Date" />
                        <input 
                    id="rDueDate"
                        type="text"
                        class="block w-full rounded-none rounded-l-md border-0 py-1.5 text-black ring-1 ring-inset ring-gray-300 placeholder:text-black focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 bg-gray-100" 
                        placeholder="January 10, 2024"
                        disabled>
                    </div>
                    <div class="mt-4">
                        <InputLabel for="rFee" value="Reservation Fee" />
                        <input 
                        id="rFee"
                        type="text"
                        class="block w-full rounded-none rounded-l-md border-0 py-1.5 text-black ring-1 ring-inset ring-gray-300 placeholder:text-black focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 bg-gray-100" 
                        placeholder="₱27,000.00"
                        disabled>
                    </div>
                    <div class="mt-4">
                        <InputLabel for="dp" value="Downpayment" />
                        <input 
                        id="dp"
                        type="text"
                        class="block w-full rounded-none rounded-l-md border-0 py-1.5 text-black ring-1 ring-inset ring-gray-300 placeholder:text-black focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 bg-gray-100" 
                        disabled
                        :value="`₱${resultMonthstoPay[0].value.toLocaleString()}.00`">
                    </div>
                    <div class="mt-4">
                        <InputLabel for="bal" value="Balance" />
                        <input 
                    id="bal"
                        type="text"
                        class="block w-full rounded-none rounded-l-md border-0 py-1.5 text-black ring-1 ring-inset ring-gray-300 placeholder:text-black focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 bg-gray-100" 
                        disabled
                        :value="`₱${overAllTot.toLocaleString()}.00`">
                    </div>
                </div>
                <div class="mt-4" v-else-if="selectedTerm === 'Spotcash' && selectedDownpayment && selectedMonths">
                    <div class="mt-4">
                        <InputLabel for="rDate" value="Reservation Date" />
                        <input 
                        id="rDate"
                        type="text"
                        class="block w-full rounded-none rounded-l-md border-0 py-1.5 text-black ring-1 ring-inset ring-gray-300 placeholder:text-black focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 bg-gray-100" 
                        placeholder="January 1, 2024"
                        disabled>
                    </div>
                    <div class="mt-4">
                        <InputLabel value="Reservation Due Date" />
                        <input 
                    
                        type="text"
                        class="block w-full rounded-none rounded-l-md border-0 py-1.5 text-black ring-1 ring-inset ring-gray-300 placeholder:text-black focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 bg-gray-100" 
                        placeholder="January 10, 2024"
                        disabled>
                    </div>
                    <div class="mt-4">
                        <InputLabel value="Reservation Due Date" />
                        <input 
                        
                        type="text"
                        class="block w-full rounded-none rounded-l-md border-0 py-1.5 text-black ring-1 ring-inset ring-gray-300 placeholder:text-black focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 bg-gray-100" 
                        placeholder="₱27,000.00"
                        disabled>
                    </div>
                    <div class="mt-4">
                        <InputLabel  value="Reservation Due Date" />
                        <input 
                    
                        type="text"
                        class="block w-full rounded-none rounded-l-md border-0 py-1.5 text-black ring-1 ring-inset ring-gray-300 placeholder:text-black focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 bg-gray-100" 
                        disabled
                        :value="`₱${totalSpotCash.toLocaleString()}.00`">
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
                <button :disabled="!(selectedTerm && selectedDownpayment && selectedMonths)"
                @click="openViewAmortization"
                :class="{'hover:text-blue-400' : (selectedTerm && selectedDownpayment && selectedMonths)}"
                class="bg-gray-200 px-6 py-2 rounded">View Amortization</button>
                
                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="submit()">
                Reserve
                </PrimaryButton>
            </div>
        </form>
    </AuthenticationCard>

    <!-- View Amortization Modal -->
    <div v-show="viewAmortizationModal"
    class="fixed inset-0 bg-black bg-opacity-30 top-0 left-0 flex justify-center p-6 z-10  overflow-y-auto">
        <div
        v-if="viewAmortizationModal" 
        class="p-4 bg-white self-start max-w-screen-md rounded">
            <div class="w-full p-4 text-right">
                <button 
                @click="openViewAmortization"
                class="bg-gray-50 text-gray-400 px-3 py-1 rounded-full text-2xl text-right">X</button>
            </div>
            <div class="py-2 mb-3">
                <img src="../../../img/Elnvital_Logo.png" alt="Logo" class="mx-auto">
            </div>

            <div v-if="selectedTerm === 'Downpayment'">
                <!-- <p>Downpayment</p> -->
                <div class="mt-4">
                    <div class="bg_rli-primary p-3 rounded-t-lg text-white font-bold text-1xl">
                        <p>Reservation Details</p>
                    </div>
                    <div class="border-b-2 border-l-2 border-r-2 rounded p-4">
                        <div class="grid lg:grid-cols-2 md:grid-cols-2">
                            <div class="">
                                <div>
                                    <div class="flex">
                                        <p class="font-bold">Property Name: </p>
                                        <!-- <p class="ml-2">details.property_name</p> -->
                                        <p class="ml-2">ZAYA-1A-BO1-1FB</p>
                                    </div>
                                    <div class="flex">
                                        <p class="font-bold">Location: </p>
                                        <!-- <p class="ml-2">details.location</p> -->
                                        <p class="ml-2">Brgy. Balibago, Sta. Rosa City, Laguna</p>
                                    </div>
                                    <div class="flex flex-wrap">
                                        <p class="font-bold">Unit Type/House Model: </p>
                                        <p class="ml-2">Studio</p>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div>
                                    <div class="flex flex-wrap">
                                        <p class="font-bold">Block / Floor Number: </p>
                                        <!-- <p class="ml-2">details.block_floor_number</p> -->
                                        <p class="ml-2">1</p>
                                    </div>
                                    <div class="flex flex-wrap">
                                        <p class="font-bold">Lot / Unit Number: </p>
                                        <!-- <p class="ml-2">details.lot_unit_number</p> -->
                                        <p class="ml-2">2</p>
                                    </div>
                                    <div class="flex flex-wrap">
                                        <p class="font-bold">Lot Area: </p>
                                        <!-- <p class="ml-2">details.lot_area</p> -->
                                        <p class="ml-2">23SQM</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Terms -->
                    <div class="mt-4 text-2xl font-bold">
                        <p class="">Term Details</p>
                        <!-- <p class="text-primary_color font-normal text-sm">TCP: <span class="font-bold text-md">{{ tcp.toLocaleString() }}.00</span></p> -->
                        <p class="text-primary_color font-normal text-sm mt-4">Remaining balance will be paid thru preferred Financing</p>
                    </div>
                    <div class="overflow-x-auto">
                    <div class="w-full">
                        <div class="mt-4">
                            <div class="grid grid-cols-6 text-center w-full">
                                <div class="bg-sky-100 py-4 border border-r-gray border-b-0 rounded-tl-lg">
                                    <p class="text-xs sm:text-sm lg:text-sm font-bold">Payment Category</p>
                                </div>
                                <div class="bg-sky-100 py-4 border border-r-gray border-b-0">
                                    <p class="text-xs sm:text-sm lg:text-sm font-bold">Payment Term</p>
                                </div>
                                <div class="bg-sky-100 py-4 border border-r-gray border-b-0">
                                    <p class="text-xs sm:text-sm lg:text-sm font-bold">Start Date</p>
                                </div>
                                <div class="bg-sky-100 py-4 border border-r-gray border-b-0">
                                    <p class="text-xs sm:text-sm lg:text-sm font-bold">End Date</p>
                                </div>
                                <div class="bg-sky-100 py-4 border border-r-gray border-b-0">
                                    <p class="text-xs sm:text-sm lg:text-sm font-bold">Downpayment</p>
                                </div>
                                <div class="bg-sky-100 py-4 border border-b-0 rounded-tr-lg">
                                    <p class="text-xs sm:text-sm lg:text-sm font-bold">Balance</p>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="grid grid-cols-6 text-center">
                                <div class="py-4 border border-r-gray border-t-0 rounded-bl-lg ">
                                    <!-- <p class="text-xs sm:text-sm lg:text-base">details.dp_category</p> -->
                                    <!-- <p class="text-xs sm:text-sm lg:text-sm">Downpayment - {{ selectedDownpayment.slice(2,4)  }}%</p> -->
                                    <p class="text-xs sm:text-sm lg:text-sm">Downpayment - {{ selectedDownpayment  }}%</p>
                                    
                                </div>
                                <div class="py-4 border border-r-gray border-t-0  ">
                                    <!-- <p class="text-xs sm:text-sm lg:text-base">details.term</p> -->
                                    <p class="text-xs sm:text-sm lg:text-sm">{{ selectedMonths }} Months</p>
                                </div>
                                <div class="py-4 border border-r-gray border-t-0  ">
                                    <!-- <p class="text-xs sm:text-sm lg:text-base">details.start_date</p> -->
                                    <p class="text-xs sm:text-sm lg:text-sm">January 1, 2023</p>
                                </div>
                                <div class="py-4 border border-r-gray border-t-0  ">
                                    <!-- <p class="text-xs sm:text-sm lg:text-base">details.end_date</p> -->
                                    <p class="text-xs sm:text-sm lg:text-sm">February 1, 2023</p>
                                </div>
                                <div class="py-4 border border-r-gray border-t-0 ">
                                    <!-- <p class="text-xs sm:text-sm lg:text-base">details.downpayment</p> -->
                                    <!-- <p class="text-xs sm:text-sm lg:text-sm">₱21,750.00</p> -->
                                    <p class="text-xs sm:text-sm lg:text-sm">₱{{ resultMonthstoPay[0].value.toLocaleString() }}.00</p>
                                </div>
                                <div class="py-4 border border-t-0 rounded-br-lg ">
                                    <p class="text-xs sm:text-sm lg:text-sm">₱{{ overAllTot.toLocaleString() }}.00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                
                    <!-- Payment Schedules -->
                    <div class="mt-4 text-2xl font-bold">
                        <p class="">Payment Schedule</p>
                    </div>
                    <div class="overflow-x-auto">
                        <div class="w-full">
                            <div class="mt-4">
                            <div class="grid grid-cols-5 text-center w-full">
                                <div class="bg-sky-100 py-4 border border-r-gray border-b-0 rounded-tl-lg">
                                    <p class="text-xs sm:text-sm lg:text-sm font-bold">No.</p>
                                </div>
                                <div class="bg-sky-100 py-4 border border-r-gray border-b-0">
                                    <p class="text-xs sm:text-sm lg:text-sm font-bold">Particulars</p>
                                </div>
                                <div class="bg-sky-100 py-4 border border-r-gray border-b-0">
                                    <p class="text-xs sm:text-sm lg:text-sm font-bold">Due Date</p>
                                </div>
                                <div class="bg-sky-100 py-4 border border-r-gray border-b-0">
                                    <p class="text-xs sm:text-sm lg:text-sm font-bold">Total Payment</p>
                                </div>
                                <div class="bg-sky-100 py-4 border border-b-0 rounded-tr-lg">
                                    <p class="text-xs sm:text-sm lg:text-sm font-bold">Balance</p>
                                </div>
                            </div>
                            </div>
                            <div class="">
                                <div class="grid grid-cols-5 text-center w-full">
                                    <div class="py-4 border border-r-gray border-t-0">
                                        <!-- <p class="text-xs sm:text-sm lg:text-base font-bold">details.no</p> -->
                                        <p class="text-xs sm:text-sm lg:text-sm font-bold"></p>
                                    </div>
                                    <div class="py-4 border border-r-gray border-t-0">
                                        <!-- <p class="text-xs sm:text-sm lg:text-base font-bold">details.reservation_fee</p> -->
                                        <p class="text-xs sm:text-sm lg:text-sm font-bold">Downpayment - {{ selectedDownpayment }}%</p>
                                    </div>
                                    <div class="py-4 border border-r-gray border-t-0 ">
                                        <!-- <p class="text-xs sm:text-sm lg:text-base font-bold">details.due_date</p> -->
                                        <p class="text-xs sm:text-sm lg:text-sm font-bold"></p>
                                    </div>
                                    <div class="py-4 border border-r-gray border-t-0 ">
                                        <!-- <p class="text-xs sm:text-sm lg:text-base font-bold">details.total_payment</p> -->
                                        <p class="text-xs sm:text-sm lg:text-sm font-bold"></p>
                                    </div>
                                    <div class="py-4 border border-t-0">
                                        <p class="text-xs sm:text-sm lg:text-sm font-bold">₱ {{ DPComputationTotal.toLocaleString() }}.00</p>
                                        <!-- <p class="text-xs sm:text-sm lg:text-sm font-bold">₱{{ resultDP.toLocaleString() }}.00</p> -->
                                        <!-- <p class="text-xs sm:text-sm lg:text-sm font-bold">₱{{ DPComputationTotal.toLocaleString()  }}.00</p> -->
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div class="grid grid-cols-5 text-center w-full">
                                    <div class="py-4 border border-r-gray border-t-0">
                                        <!-- <p class="text-xs sm:text-sm lg:text-base font-bold">details.no</p> -->
                                        <p class="text-xs sm:text-sm lg:text-sm font-bold">0</p>
                                    </div>
                                    <div class="py-4 border border-r-gray border-t-0">
                                        <!-- <p class="text-xs sm:text-sm lg:text-base font-bold">details.reservation_fee</p> -->
                                        <p class="text-xs sm:text-sm lg:text-sm font-bold">Reservation Fee</p>
                                    </div>
                                    <div class="py-4 border border-r-gray border-t-0 ">
                                        <!-- <p class="text-xs sm:text-sm lg:text-base font-bold">details.due_date</p> -->
                                        <p class="text-xs sm:text-sm lg:text-sm font-bold">January 1, 2023</p>
                                    </div>
                                    <div class="py-4 border border-r-gray border-t-0 ">
                                        <!-- <p class="text-xs sm:text-sm lg:text-base font-bold">details.total_payment</p> -->
                                        <p class="text-xs sm:text-sm lg:text-sm font-bold">₱27,000.00</p>
                                    </div>
                                    <div class="py-4 border border-t-0">
                                        <!-- <p class="text-xs sm:text-sm lg:text-sm font-bold">₱ 2,700,000.00</p> -->
                                        <p class="text-xs sm:text-sm lg:text-sm font-bold">₱{{ resultDP.toLocaleString() }}.00</p>
                                        <!-- <p class="text-xs sm:text-sm lg:text-sm font-bold">₱{{ DPComputationTotal.toLocaleString()  }}.00</p> -->
                                    </div>
                                </div>
                            </div>
                            <div class="" v-for="(item,index) in resultMonthstoPay" :key="index">
                                <div class="grid grid-cols-5 text-center w-full">
                                    <div class="py-4 border border-r-gray border-t-0">
                                        <p class="text-xs sm:text-sm lg:text-sm font-bold">{{ index + 1 }}</p>
                                    </div>
                                    <div class="py-4 border border-r-gray border-t-0">
                                        <!-- <p class="text-xs sm:text-sm lg:text-sm font-bold">Monthly Amortization({{ index === resultMonthstoPay.length - 1 ? index : index + 1 }}/{{ selectedMonths }})</p> -->
                                        <p class="text-xs sm:text-sm lg:text-sm font-bold">Downpayment({{  index + 1 }}/{{ selectedMonths }})</p>
                                    </div>
                                    <div class="py-4 border border-r-gray border-t-0 ">
                                        <p class="text-xs sm:text-sm lg:text-sm font-bold">February  1, 2023</p>
                                    </div>
                                    <div class="py-4 border border-r-gray border-t-0 ">
                                        <p class="text-xs sm:text-sm lg:text-sm font-bold">₱{{item.value.toLocaleString()}}.00</p>
                                    </div>
                                    <div class="py-4 border border-r-gray border-t-0">
                                        <p class="text-xs sm:text-sm lg:text-sm font-bold">₱ {{item.additionalData.toLocaleString()}}.00</p>
                                    </div>
                                </div>
                            </div> 
                            <!-- <div class="">
                                <div class="grid grid-cols-5 text-center w-full">
                                    <div class="py-4 border border-r-gray border-t-0 rounded-bl-lg">
                                        <p class="text-xs sm:text-sm lg:text-sm font-bold">1</p>
                                    </div>
                                    <div class="py-4 border border-r-gray border-t-0">
                                        <p class="text-xs sm:text-sm lg:text-sm font-bold">Monthly Amortization(1/36)</p>
                                    </div>
                                    <div class="py-4 border border-r-gray border-t-0 ">
                                        <p class="text-xs sm:text-sm lg:text-sm font-bold">February  1, 2023</p>
                                    </div>
                                    <div class="py-4 border border-r-gray border-t-0 ">
                                        <p class="text-xs sm:text-sm lg:text-sm font-bold">₱2,700,000.00</p>
                                    </div>
                                    <div class="py-4 border border-t-0 rounded-br-lg">
                                        <p class="text-xs sm:text-sm lg:text-sm font-bold">₱ 2,700,000.00</p>
                                    </div>
                                </div>
                            </div>  -->
                        </div>
                    </div>
                
                </div>
            </div>
            <div v-else-if="selectedTerm === 'Spotcash'">
                <div class="mt-4">
                    <div class="bg_rli-primary p-3 rounded-t-lg text-white font-bold text-1xl">
                        <p>Reservation Details</p>
                    </div>
                    <div class="border-b-2 border-l-2 border-r-2 rounded p-4">
                        <div class="grid lg:grid-cols-2 md:grid-cols-2">
                            <div class="">
                                <div>
                                    <div class="flex">
                                        <p class="font-bold">Property Name: </p>
                                        <!-- <p class="ml-2">details.property_name</p> -->
                                        <p class="ml-2">ZAYA-1A-BO1-1FB</p>
                                    </div>
                                    <div class="flex">
                                        <p class="font-bold">Location: </p>
                                        <!-- <p class="ml-2">details.location</p> -->
                                        <p class="ml-2">Brgy. Balibago, Sta. Rosa City, Laguna</p>
                                    </div>
                                    <div class="flex flex-wrap">
                                        <p class="font-bold">Unit Type/House Model: </p>
                                        <!-- <p class="ml-2">details.unit_type_house_model</p> -->
                                        <p class="ml-2">Studio</p>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div>
                                    <div class="flex flex-wrap">
                                        <p class="font-bold">Block / Floor Number: </p>
                                        <!-- <p class="ml-2">details.block_floor_number</p> -->
                                        <p class="ml-2">1</p>
                                    </div>
                                    <div class="flex flex-wrap">
                                        <p class="font-bold">Lot / Unit Number: </p>
                                        <!-- <p class="ml-2">details.lot_unit_number</p> -->
                                        <p class="ml-2">2</p>
                                    </div>
                                    <div class="flex flex-wrap">
                                        <p class="font-bold">Lot Area: </p>
                                        <!-- <p class="ml-2">details.lot_area</p> -->
                                        <p class="ml-2">23SQM</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Terms -->
                    <div class="mt-4 text-2xl font-bold">
                        <p class="">Term Details</p>
                        <!-- <p class="text-primary_color font-normal text-sm">TCP: <span class="font-bold text-md">{{ tcp.toLocaleString() }}.00</span></p> -->
                        <p class="text-primary_color font-normal text-sm mt-4">Remaining balance will be paid thru preferred Financing</p>
                    </div>
                    <div class="overflow-x-auto">
                    <div class="w-full">
                        <div class="mt-4">
                            <div class="grid grid-cols-6 text-center w-full">
                                <div class="bg-sky-100 py-4 border border-r-gray border-b-0 rounded-tl-lg">
                                    <p class="text-xs sm:text-sm lg:text-sm font-bold">Payment Category</p>
                                </div>
                                <div class="bg-sky-100 py-4 border border-r-gray border-b-0">
                                    <p class="text-xs sm:text-sm lg:text-sm font-bold">Payment Term</p>
                                </div>
                                <div class="bg-sky-100 py-4 border border-r-gray border-b-0">
                                    <p class="text-xs sm:text-sm lg:text-sm font-bold">Start Date</p>
                                </div>
                                <div class="bg-sky-100 py-4 border border-r-gray border-b-0">
                                    <p class="text-xs sm:text-sm lg:text-sm font-bold">End Date</p>
                                </div>
                                <div class="bg-sky-100 py-4 border border-r-gray border-b-0">
                                    <p class="text-xs sm:text-sm lg:text-sm font-bold">Amortization</p>
                                </div>
                                <div class="bg-sky-100 py-4 border border-b-0 rounded-tr-lg">
                                    <p class="text-xs sm:text-sm lg:text-sm font-bold">Balance</p>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="grid grid-cols-6 text-center">
                                <div class="py-4 border border-r-gray border-t-0 rounded-bl-lg ">
                                    <!-- <p class="text-xs sm:text-sm lg:text-base">details.spot_cash</p> -->
                                    <p class="text-xs sm:text-sm lg:text-sm">Spotcash - {{ selectedMonths }}00%</p>
                                </div>
                                <div class="py-4 border border-r-gray border-t-0  ">
                                    <!-- <p class="text-xs sm:text-sm lg:text-base">details.term</p> -->
                                    <p class="text-xs sm:text-sm lg:text-sm">1 Month</p>
                                </div>
                                <div class="py-4 border border-r-gray border-t-0  ">
                                    <!-- <p class="text-xs sm:text-sm lg:text-base">details.start_date</p> -->
                                    <p class="text-xs sm:text-sm lg:text-sm">Reservation Fee</p>
                                </div>
                                <div class="py-4 border border-r-gray border-t-0  ">
                                    <!-- <p class="text-xs sm:text-sm lg:text-base">details.end_date</p> -->
                                    <p class="text-xs sm:text-sm lg:text-sm">January 1, 2023</p>
                                </div>
                                <div class="py-4 border border-r-gray border-t-0">
                                    <!-- <p class="text-xs sm:text-sm lg:text-base">details.amortization</p> -->
                                    <p class="text-xs sm:text-sm lg:text-sm">₱ {{ tcp.toLocaleString() }}.00</p>
                                </div>
                                <div class="py-4 border border-t-0 rounded-br-lg ">
                                    <!-- <p class="text-xs sm:text-sm lg:text-base">details.amortization</p> -->
                                    <p class="text-xs sm:text-sm lg:text-sm">₱ 00.00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                
                    <!-- Payment Schedules -->
                    <div class="mt-4 text-2xl font-bold">
                        <p class="">Payment Schedule</p>
                    </div>
                    <div class="overflow-x-auto">
                        <div class="w-full">
                            <div class="mt-4">
                            <div class="grid grid-cols-5 text-center w-full">
                                <div class="bg-sky-100 py-4 border border-r-gray border-b-0 rounded-tl-lg">
                                    <p class="text-xs sm:text-sm lg:text-sm font-bold">No.</p>
                                </div>
                                <div class="bg-sky-100 py-4 border border-r-gray border-b-0">
                                    <p class="text-xs sm:text-sm lg:text-sm font-bold">Particulars</p>
                                </div>
                                <div class="bg-sky-100 py-4 border border-r-gray border-b-0">
                                    <p class="text-xs sm:text-sm lg:text-sm font-bold">Due Date</p>
                                </div>
                                <div class="bg-sky-100 py-4 border border-r-gray border-b-0">
                                    <p class="text-xs sm:text-sm lg:text-sm font-bold">Total Payment</p>
                                </div>
                                <div class="bg-sky-100 py-4 border border-b-0 rounded-tr-lg">
                                    <p class="text-xs sm:text-sm lg:text-sm font-bold">Balance</p>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="grid grid-cols-5 text-center w-full">
                                <div class="py-4 border border-r-gray border-t-0">
                                    <!-- <p class="text-xs sm:text-sm lg:text-base font-bold">details.no</p> -->
                                    <p class="text-xs sm:text-sm lg:text-sm font-bold">0</p>
                                </div>
                                <div class="py-4 border border-r-gray border-t-0">
                                    <p class="text-xs sm:text-sm lg:text-sm font-bold"></p>
                                </div>
                                <div class="py-4 border border-r-gray border-t-0 ">
                                    <p class="text-xs sm:text-sm lg:text-sm font-bold"></p>
                                </div>
                                <div class="py-4 border border-r-gray border-t-0 ">
                                    <p class="text-xs sm:text-sm lg:text-sm font-bold"></p>
                                </div>
                                <div class="py-4 border border-t-0">
                                    <p class="text-xs sm:text-sm lg:text-sm font-bold">₱{{ tcp.toLocaleString() }}.00</p>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="grid grid-cols-5 text-center w-full">
                                <div class="py-4 border border-r-gray border-t-0">
                                    <!-- <p class="text-xs sm:text-sm lg:text-base font-bold">details.no</p> -->
                                    <p class="text-xs sm:text-sm lg:text-sm font-bold">1</p>
                                </div>
                                <div class="py-4 border border-r-gray border-t-0">
                                    <p class="text-xs sm:text-sm lg:text-sm font-bold">Reservation Fee</p>
                                </div>
                                <div class="py-4 border border-r-gray border-t-0 ">
                                    <p class="text-xs sm:text-sm lg:text-sm font-bold">January 1, 2023</p>
                                </div>
                                <div class="py-4 border border-r-gray border-t-0 ">
                                    <p class="text-xs sm:text-sm lg:text-sm font-bold">₱ {{ rFee.toLocaleString() }}.00</p>
                                </div>
                                <div class="py-4 border border-t-0">
                                    <p class="text-xs sm:text-sm lg:text-sm font-bold">₱{{ totalSpotCash.toLocaleString() }}.00</p>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="grid grid-cols-5 text-center w-full">
                                <div class="py-4 border border-r-gray border-t-0 rounded-bl-lg">
                                    <p class="text-xs sm:text-sm lg:text-sm font-bold">2</p>
                                </div>
                                <div class="py-4 border border-r-gray border-t-0">
                                    <p class="text-xs sm:text-sm lg:text-sm font-bold">Downpayment</p>
                                </div>
                                <div class="py-4 border border-r-gray border-t-0 ">
                                    <p class="text-xs sm:text-sm lg:text-sm font-bold">February 1, 2023</p>
                                </div>
                                <div class="py-4 border border-r-gray border-t-0 ">
                                    <p class="text-xs sm:text-sm lg:text-sm font-bold">₱ {{ totalSpotCash.toLocaleString() }}.00</p>
                                </div>
                                <div class="py-4 border border-t-0 rounded-br-lg">
                                    <p class="text-xs sm:text-sm lg:text-sm font-bold">₱00.00</p>
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

<style>

.bg_rli-primary{
    background: linear-gradient(268deg, #FCB115 7.47%, #CC035C 98.92%);
}
.text-primary_color{
    color: #CC035C;
}
</style>
