<script setup>

import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { onMounted, ref, watch, computed } from 'vue';
import ButtonPrimary from '@/MyComponents/ButtonPrimary.vue';
import EditOrder from '@/MyComponents/EditOrder.vue';
import RLICard from '@/MyComponents/RLICard.vue';
import RLICardv2 from '@/MyComponents/RLICardv2.vue';
import Calculator from '@/MyComponents/Calculator.vue';

const props = defineProps({
    voucherCode: String,
    order: Object,
    property_code: String
});
const selectedTerm = ref('Downpayment - 0.10');
const selectedDownpayment = ref(0.10);
const selectedMonths = ref(36);

const form = useForm({
    // property_code: props.order?.property_code,
    // dp_percent: '10',
    // dp_months: '24',
     property_code: props.property_code,
    dp_percent: selectedDownpayment.value * 100,
    dp_months: selectedMonths.value
});
const handleDownpaymentChanges = (newValue) => {
    selectedDownpayment.value = newValue;
    form.dp_percent = newValue * 100;
  };

  const handleMonthsChanges = (newValue) => {
    selectedMonths.value = newValue;
    form.dp_months = newValue;
  };

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

    <RLICard v-if="props.property_code">
        <template #contentLeft>
            <form @submit.prevent="submit">
                <!-- <div class="mt-4">
    
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
                <div class="">
                    <div class="hidden md:block">
                        <div class="text-2xl font-bold">
                        <h1>{{ props.order.product.name }}</h1>
                        </div>
                        <div class="flex gap-1 mt-3 items-center">
                            <p class="font-bold text-lg mb-0">Reservation Code:</p>
                            <p class="text-sky-600 text-2xl">{{ props.voucherCode }}</p>
                        </div>    
                    </div>
                    <div class="my-3 sm:block md:hidden">
                        <div class="text-2xl font-bold">
                        <h1>{{ props.order.product.name }}</h1>
                        </div>
                        <div class="flex gap-1 mt-3 items-center">
                            <p class="font-bold text-lg mb-0">Reservation Code:</p>
                            <p class="text-sky-600 text-2xl">{{ props.voucherCode }}</p>
                        </div>    
                        <div class="flex gap-1 mt-4">
                            <p class="text-sm font-bold">Total Contract Price:</p>
                            <p class="text-sm font-bold">₱2,900,000.00</p>
                        </div>
                        <div class="mt-2">
                            <p class="font-bold">Reservation Fee:</p>
                            <p class="text-4xl font-bold text-primary_color">₱{{ props.order.product.processing_fee.toLocaleString() }}.00</p>
                        </div>
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
              
                <div 
                v-if="props.property_code"
                :class="{'block': (props.property_code)}"
                class="mt-4">
                    <EditOrder 
                    :propertyCode="props.property_code" 
                    :order="props.order" 
                    >
                        <input 
                            id="property_code"
                            v-model="form.property_code"
                            type="text"
                            class="block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 font-bold" 
                            placeholder="e.g., PC-001, PC-002"
                            autofocus>
                        <button
                            target="_blank"
                            @click="navigateToMapLink"
                            class="absolute inset-y-0 right-0 flex items-center justify-center px-4 border border-rose-600 text-rose-600 hover:bg-rose-600 hover:text-white rounded-full"
                        >
                            Change Unit
                        </button>
                    </EditOrder>
                </div>
                <div class="block md:hidden">
                    <div class="my-2">
                        <h1 class="font-bold text-2xl">Calculate Financial Scheme</h1>
                    </div>
                    <Calculator 
                    :voucherCode="props.voucherCode" 
                    :order="props.order" 
                    :property_code="props.property_code"
                    @downpayment-changed="handleDownpaymentChanges"
                    @months-changed="handleMonthsChanges"
                    >
                        <template #buttons>
                                <ButtonPrimary class="ms-4 px-6 py-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="submit()">
                                    Submit
                                </ButtonPrimary>
                        </template>
                    </Calculator>
                </div>
            </form>
        </template>
        <template #contentRight>
            <div class="my-4 font-bold text-2xl">
                <p>Calculate Financial Scheme</p>
            </div>

            <Calculator 
            :voucherCode="props.voucherCode" 
            :order="props.order" 
            :property_code="props.property_code"
            @downpayment-changed="handleDownpaymentChanges"
            @months-changed="handleMonthsChanges"
            >
                <template #buttons>
                        <ButtonPrimary class="ms-4 px-6 py-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="submit()">
                            Submit
                        </ButtonPrimary>
                </template>
            </Calculator>
        </template>
    </RLICard>
    <RLICardv2 v-else>
        <div>
            <img src="../../../img/Agapeya_img.png">
        </div>
        <form @submit.prevent="submit">
            <div class="mt-4">

            </div>

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
            <div>
                <div class="text-3xl font-bold">
                    <h1>{{ props.order.product.name }}</h1>
                </div>
                <div class="flex gap-1 mt-3 items-center">
                    <p class="font-bold text-lg mb-0">Reservation Code:</p>
                    <p class="text-sky-600 text-2xl">{{ props.voucherCode }}</p>
                </div>
            </div>
            <div class="mt-4">
                <label for="property_code" class="block font-medium leading-6 text-gray-900">Property Code</label>
                <!-- <div class="mt-2 flex rounded-md shadow-sm relative">
                    <div class="relative flex flex-grow items-stretch focus-within:z-10">
                    <input 
                    id="property_code"
                    v-model="form.property_code"
                    type="text"
                    class="block w-full rounded-none rounded-l-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" 
                    placeholder="e.g., PC-001, PC-002, PC-003, PC-004, PC-005"
                     autofocus>
                    </div>
                    <button
                    target="_blank"
                    @click="navigateToMapLink"
                    class="border border-rose-600 text-rose-600 px-6 py-2 rounded-lg"
                    >
                        Change Unit
                    </button>
                </div> -->
                <div class="mt-2 relative">
                    <div class="flex rounded-md shadow-sm">
                        <input 
                            id="property_code"
                            v-model="form.property_code"
                            type="text"
                            class="block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" 
                            placeholder="e.g., PC-001, PC-002"
                            autofocus>
                        <button
                            target="_blank"
                            @click="navigateToMapLink"
                            class="absolute inset-y-0 right-0 flex items-center justify-center px-4 border border-rose-600 text-rose-600 hover:bg-rose-600 hover:text-white rounded-full"
                        >
                           Choose Unit
                        </button>
                    </div>
                    <!-- Optional: Add additional styling for the button as needed -->
                    <!-- For example, you might want to adjust padding and border -->
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
                <!-- <button :disabled="!(selectedTerm && selectedDownpayment && selectedMonths)" -->
               
                <ButtonPrimary class="px-6 py-3 w-full" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="submit()">
                    Submit
                </ButtonPrimary>
            </div>
        </form>
    </RLICardv2>

</template>

<style>

.bg_rli-primary{
    background: linear-gradient(268deg, #FCB115 7.47%, #CC035C 98.92%);
}
.text-primary_color{
    color: #CC035C;
}
</style>
