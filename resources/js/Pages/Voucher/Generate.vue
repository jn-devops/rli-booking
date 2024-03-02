<script setup>

import SecondaryButton from "@/Components/SecondaryButton.vue";
import ActionMessage from '@/Components/ActionMessage.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { router, useForm, usePage } from '@inertiajs/vue3';
import FormSection from '@/Components/FormSection.vue';
import DialogModal from '@/Components/DialogModal.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import FloorAreaLogo from '@/MyComponents/FloorAreaLogo.vue';
import LotAreaLogo from '@/MyComponents/LotAreaLogo.vue';
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

const showingProductDetails = ref(false);

const closeModal = () => {
  showingProductDetails.value = false;
}

const validSKU = ref(false);
const product = ref(null);
const leadGenerationLink = ref(null);

const createLink = () => {
  leadGenerationLink.value = null;
  let title = 'Lead Generation: ' + seller + ' (' + form.sku + ')';
  router.post(route('create-link', { sku: form.sku, title: title }));
};

const showProductDetails = () => {
  if (leadGenerationLink.value.length > 0)
    showingProductDetails.value = true;
}

watch (() => form.sku, () => {
  leadGenerationLink.value = null;
  if (form.sku.length>0) {
    console.log(form.sku);
    axios.get(route('products-show', {sku: form.sku})).then( response => {
      if (200 === response.status) {
        validSKU.value = true;
        product.value = response.data;
        console.log(validSKU.value);
      }
    }).catch(error => {
      validSKU.value = false;
      console.log(validSKU.value);
      console.log(error.response.status);
    });
  }
});
watch (
    () => usePage().props.flash.event,
    (event) => {
      switch (event?.name) {
        case 'link.created':
          console.log(event?.data);
          leadGenerationLink.value = event?.data.link;
          break;
      }
    },
    { immediate: true }
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
          {{ leadGenerationLink }}
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
        <template v-if="validSKU">
          <SecondaryButton @click = "createLink()">
            Generate
          </SecondaryButton>
          <SecondaryButton @click = "showProductDetails()">
            View
          </SecondaryButton>
        </template>
        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          Start
        </PrimaryButton>
      </div>
      <DialogModal :show="showingProductDetails" @close="closeModal">
        <div class="w-full p-4 text-right">
            <button 
            class="bg-gray-50 text-gray-400 px-3 py-1 rounded-full text-2xl text-right">X</button>
        </div>
        <template #title>
         <div class="flex items-start gap-3 justify-between py-4">
          <div class="text-3xl">{{ product.name }}</div>
          <div class="text-2xl text-gray-300 bg-gray-50 rounded-full px-2">
            <button @click="closeModal">&times;</button>
          </div>
         </div>
        </template>
        <template #content>
          <div class="p-4">
            <div>
              <!-- img -->
              <img src="../../../img/ProductImg.png" alt="" class="w-full">
            </div>

            <div class="flex gap-6 mt-4">
              <div class="flex gap-2">
                  <div>
                      <FloorAreaLogo />
                  </div>
                  <div class="text-1xl">
                      <p class="text-gray-500">Floor Area</p>
                      <p class="mt-1">{{ product.floor_area }}SQM</p>
                  </div>
              </div>
              <div class="flex gap-2">
                  <div>
                      <LotAreaLogo />
                  </div>
                  <div class="text-1xl">
                      <p class="text-gray-500">Lot Area</p>
                      <p class="mt-1">{{ product.lot_area }}SQM</p>
                  </div>
              </div>
            </div>

            <div class="mt-4">
              <div class="font-bold text-xl">
                  <ul>
                    <li class="mt-2">Location: <span class="font-normal">{{ product.location }}</span></li>
                    <li class="mt-2">Category: <span class="font-normal">{{ product.category }}</span></li>
                    <li class="mt-2">Unit Type: <span class="font-normal">{{ product.unit_type.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ') }}</span></li>
                    <li class="mt-2">Total Contract Prize: <span class="font-normal">₱{{ product.price.toLocaleString() }}.00</span></li>
                    <li class="mt-2">Prize: <span class="font-normal">₱{{ product.price.toLocaleString() }}.00</span></li>
                    <li class="mt-2">Processing Fee: <span class="font-normal">₱{{ product.processing_fee.toLocaleString() }}.00</span></li>
                  </ul>
              </div>
              <div>
                <ul>
                  <li></li>
                </ul>
              </div>
            </div>
          </div>
          <!-- {{ product }} -->
        </template>
        <!-- <template #footer class="hidden">
          <SecondaryButton @click="closeModal">
            Close
          </SecondaryButton>
        </template> -->
      </DialogModal>
    </template>
  </FormSection>
</template>

<style scoped>

</style>
