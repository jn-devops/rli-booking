<script setup>

import SecondaryButton from "@/Components/SecondaryButton.vue";
import ActionMessage from '@/Components/ActionMessage.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';

let params = new URLSearchParams(window.location.search)

const seller = params.get('seller') || usePage().props.auth.user.email;
const reference = params.get('reference');
const sku = params.get('sku');

const form = useForm({
    email: seller,
    discount: '0',
    sku: sku
});

const affiliate_link = computed(
    () => form.sku ? route('affiliate-reserve', {email: seller, sku: form.sku}) :  '',
);

const generateVoucher = () => {
    form.post(route('generate-voucher'), {
        errorBag: 'generateVoucher',
        preserveScroll: true,
    });
};
</script>

<template>
    <FormSection @submitted="generateVoucher">
        <template #title>
            Select a Product to Sell
        </template>

        <template #description>
            Enter the Product SKU that you intend to offer to your prospect. You may also give a discount on the processing.
        </template>

        <template #form>
            <!-- Product SKU -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="sku" value="Product SKU" />
                <TextInput
                    id="sku"
                    v-model="form.sku"
                    type="text"
                    class="mt-1 block w-full"
                    placeholder="e.g., JN-AGM-CL-HLDUS-GRN, JN-AGM-CL-HLDUS-PUR"
                    required
                    autofocus
                />
                <div class="text-gray-700 dark:text-gray-300 text-xs">
                  {{ affiliate_link }}
                </div>
                <InputError :message="form.errors.sku" class="mt-2" />
            </div>

            <!-- Percent Discount -->
            <div class="col-span-6 sm:col-span-4 hidden">
                <InputLabel for="discount" value="Percent Discount" />
                <TextInput
                    id="name"
                    v-model="form.discount"
                    type="number"
                    min="0"
                    max="100"
                    class="mt-1 block w-full"
                />
                <div class="text-xs text-gray-600 dark:text-gray-400">on processing fee</div>
                <InputError :message="form.errors.discount" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <ActionMessage :on="form.recentlySuccessful" class="me-3">
                Customized.
            </ActionMessage>

            <div class="flex items-center space-x-4 px-4 py-3">
                <SecondaryButton>
                    Share
                </SecondaryButton>

                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Generate
                </PrimaryButton>
            </div>
        </template>
    </FormSection>
</template>

<style scoped>

</style>
