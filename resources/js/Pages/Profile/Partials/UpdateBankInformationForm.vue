<script setup>
import SecondaryButton from '@/Components/SecondaryButton.vue';
import ActionMessage from "@/Components/ActionMessage.vue";
import PrimaryButton from '@/Components/PrimaryButton.vue';
import FormSection from '@/Components/FormSection.vue';
import DialogModal from '@/Components/DialogModal.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, usePage } from "@inertiajs/vue3";
import { ref, watch } from 'vue';

const props = defineProps({
  seller: Object,
});

const form = useForm({
  bank_code: props.seller.bank_code,
  account_number: props.seller.account_number,
  account_name: props.seller.account_name,
});

const update = () => {
  form.post(route('update-bank'), {
    errorBag: 'update-bank',
    preserveScroll: true
  });
};
</script>

<template>
  <FormSection @submitted="update">
    <template #title>
      Account Disbursement
    </template>

    <template #description>
      Add you disbursement details.
    </template>

    <template #form>
      <!-- Bank Code -->
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="bank" value="Bank Account Name" />
        <TextInput
            id="bank"
            v-model="form.bank_code"
            type="text"
            class="mt-1 block w-full"
            required
            autocomplete="bank"
        />
        <InputError :message="form.errors.bank_code" class="mt-2" />
      </div>

      <!-- Account Number -->
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="account_number" value="Bank Account Number" />
        <TextInput
            id="account_number"
            v-model="form.account_number"
            type="text"
            class="mt-1 block w-full"
            required
        />
        <InputError :message="form.errors.account_number" class="mt-2" />
      </div>

      <!-- Account Name -->
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="account_name" value="Account Holder Name" />
        <TextInput
            id="account_name"
            v-model="form.account_name"
            type="text"
            class="mt-1 block w-full"
        />
        <InputError :message="form.errors.account_name" class="mt-2" />
      </div>
    </template>

    <template #actions>
      <ActionMessage :on="form.recentlySuccessful" class="me-3">
        Saved.
      </ActionMessage>

      <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
        Save
      </PrimaryButton>
    </template>

  </FormSection>
</template>

<style scoped>

</style>
