<script setup>
import ActionMessage from '@/Components/ActionMessage.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, usePage } from '@inertiajs/vue3';

const form = useForm({
    email: usePage().props.auth.user.email,
    sku: null,
    callback_url: 'https://eomuckur5juqabu.m.pipedream.net',
    discount: '0'
});

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
            Reference
        </template>

        <template #description>
            A control number for this sales transaction.
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
                    placeholder="e.g., ABC-123, DEF-456"
                    required
                    autofocus
                />

                <InputError :message="form.errors.sku" class="mt-2" />
            </div>

            <!-- Callback URL -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="callback_url" value="Callback URL" />
                <TextInput
                    id="sku"
                    v-model="form.callback_url"
                    type="text"
                    class="mt-1 block w-full"
                    required
                />

                <InputError :message="form.errors.callback_url" class="mt-2" />
            </div>

            <!-- Percent Discount -->
            <div class="col-span-6 sm:col-span-4">
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
                Generated.
            </ActionMessage>

            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Generate
            </PrimaryButton>
        </template>
    </FormSection>
</template>

<style scoped>

</style>
