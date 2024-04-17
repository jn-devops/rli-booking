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
import ButtonPrimary from '@/MyComponents/ButtonPrimary.vue';
import RLICardLayout from '@/MyComponents/RLICardLayout.vue';
import RLICardv2 from "@/MyComponents/RLICardv2.vue";
import UserIconLogo from '@/MyComponents/UserIconLogo.vue';

let params = new URLSearchParams(window.location.search)

const seller = params.get('seller') || usePage().props.auth.user.email;
const sellerName = params.get('seller') || usePage().props.auth.user.name;
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
  
  
  <form @submit.prevent="generateVoucher">
    <RLICardv2 class="items-start">
      
     <template #title>
       <h1 class="font-bold text-3xl"> Sales Reservation</h1>
     </template>
     <div class="bg-gray-100 w-72 mx-auto py-2 my-6 rounded-lg">
      <div class="flex items-center gap-2">
          <div v-if="$page.props.jetstream.managesProfilePhotos">
            <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
          </div>
          <div v-else class="">
            <!-- <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#cfcfcf"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12ZM15 9C15 10.6569 13.6569 12 12 12C10.3431 12 9 10.6569 9 9C9 7.34315 10.3431 6 12 6C13.6569 6 15 7.34315 15 9ZM12 20.5C13.784 20.5 15.4397 19.9504 16.8069 19.0112C17.4108 18.5964 17.6688 17.8062 17.3178 17.1632C16.59 15.8303 15.0902 15 11.9999 15C8.90969 15 7.40997 15.8302 6.68214 17.1632C6.33105 17.8062 6.5891 18.5963 7.19296 19.0111C8.56018 19.9503 10.2159 20.5 12 20.5Z" fill="#cfcfcf"></path> </g></svg>
             -->
             <UserIconLogo class="h-20 w-20 py-2"/>
          </div>
          <div class="text-sm">
              <p class="text-lg font-bold">{{sellerName}}</p>
              <p>{{seller}}</p>
              <p class="bg_text capitalize">seller</p>
          </div>
      </div>
     </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="sku" value="Product SKU" class="font-bold text-lg" />
        <TextInput
            id="sku"
            v-model="form.sku"
            type="text"
            class="mt-1 block w-full rounded-full"
            placeholder="Enter value"
            required
            autofocus
        />
        <div class="text-gray-700 dark:text-gray-300 text-xs">
          {{ leadGenerationLink }}
        </div>
        <InputError :message="form.errors.sku" class="mt-2" />
      </div>

      
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

      <div>
      <ActionMessage :on="form.recentlySuccessful" class="me-3">
        Customized.
      </ActionMessage>

      <div class="flex items-center justify-end space-x-4 px-4 py-3">
        <template v-if="validSKU">
          <SecondaryButton @click = "createLink()">
            Generate
          </SecondaryButton>
          <SecondaryButton @click = "showProductDetails()">
            View
          </SecondaryButton>
        </template>
        <ButtonPrimary :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          Start
        </ButtonPrimary>
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
        </template>
      </DialogModal>
      </div>
    </RLICardv2>
  </form>
</template>

<style scoped>
.bg_text{
  color: #CD045D;
}
</style>
