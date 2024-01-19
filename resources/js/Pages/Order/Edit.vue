<script setup>

import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

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
            <div class="mt-4">
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
            </div>

            <!-- Percent DownPayment -->
            <div class="mt-4">
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
            </div>

            <!-- Months to Pay DownPayment -->
            <div class="mt-4">
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
            </div>
        </form>
    </AuthenticationCard>
</template>
