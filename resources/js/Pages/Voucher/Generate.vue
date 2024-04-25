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
import { ref, computed, watch , reactive, onMounted, onUnmounted  } from 'vue';
import ButtonPrimary from '@/MyComponents/ButtonPrimary.vue';
import RLICardLayout from '@/MyComponents/RLICardLayout.vue';
import RLICardv2 from "@/MyComponents/RLICardv2.vue";
import UserIconLogo from '@/MyComponents/UserIconLogo.vue';
import RLICard from "@/MyComponents/RLICard.vue";
import Carousel from '@/MyComponents/Carousel.vue';
import FloorLogo from '@/MyComponents/FloorLogo.vue';                 
import CarparkLogo from '@/MyComponents/CarparkLogo.vue';
import ToiletBathLogo from '@/MyComponents/ToiletBathLogo.vue';
import InfoDetails from "@/MyComponents/InfoDetails.vue";
import CopyLogo from "@/MyComponents/CopyLogo.vue";
import CopyButton from '@/MyComponents/CopyButton.vue';
import DefaultSecondaryButton from "@/MyComponents/DefaultSecondaryButton.vue";
import DefaultPrimaryButton from "@/MyComponents/DefaultPrimaryButton.vue";
import Dropdown from "@/Components/Dropdown.vue";
import UnitTypeLogo from "@/MyComponents/UnitTypeLogo.vue";

let params = new URLSearchParams(window.location.search)

const seller = params.get('seller') || usePage().props.auth.user.email;
const sellerName = params.get('seller') || usePage().props.auth.user.name;
const reference = params.get('reference');
const sku = params.get('sku');

const props = defineProps({
  products: Object,
  closeable: {
        type: Boolean,
        default: true,
    }
})
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
    // console.log(form.sku);
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


// console.log('details', details);
// console.log('products', product);

// Watcher example
// watch(newDetails, (newValue) => {
//   details = newValue;
//   console.log('jsonDetails: ', details);
// });

const showingInfoDetails = ref(false);

const closeModalInfo = () =>{
  showingInfoDetails.value = false;
}

const showInfoDetail = () =>{
  showingInfoDetails.value = true;
}
const copyToClipboard = (leadParams) =>{
  navigator.clipboard.writeText(leadParams);
  console.log("copied: ", leadParams);
}


const selectedProperty = ref('');
const displayValue = ref('');

const updateDisplayValue = () => {
  if (form.sku && form.sku.includes('AGM')) {
    displayValue.value = 'Agapeya';
  } else if (form.sku && form.sku.includes('ZYA')) {
    displayValue.value = 'Zaya';
  } else {
    displayValue.value = '';
  }
};
const productDetails = ref({});
watch(() => form.sku, updateDisplayValue);
// const displayValue = computed(() => {
//   if (form.sku && form.sku.includes('AGM')) { 
//     return 'Agapeya';
//   } else if (form.sku && form.sku.includes('ZYA')) {  
//     return 'Zaya';
//   } else {
//     return '';
//   }
// });

// Watch for changes in displayValue and update selectedProperty
watch(displayValue, () => {
  if (displayValue.value === 'Agapeya') {
    property.value = 'Agapeya';
  } else if (displayValue.value === 'Zaya') {
    property.value = 'Zaya';
  }
});

// Handle change event for dropdown
const onChange = (e) => {
  // Update selectedProperty based on displayValue
  if (displayValue.value === 'Agapeya') {
    property.value = 'Agapeya';
    property.value = e.target.value;
  } else if (displayValue.value === 'Zaya') {
    property.value = 'Zaya';
    property.value = e.target.value;
  }
}

// console.log("form.sku:", form.sku);


const showingDropdown = ref(false);


const dropDown = () =>{
  showingDropdown.value = !showingDropdown.value;
}

const dropDownItem = (skuParams, index) =>{
  // console.log('sku:', newDetails.value);
  showingDropdown.value = !showingDropdown.value;
  form.sku = skuParams.sku;
  productDetails.value = skuParams;
  // console.log('index: ',index, 'skuParams:', productDetails.value);

  // console.log('index: ',index, 'skuParams:', productDetails.value.brand);
}
const handleClickOutside = (event) => {
  if (showingDropdown.value) {
    if (!event.target.closest('.bg-white')) {
      showingDropdown.value = false;
    }
  }
};

onMounted(() => {
  document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside);
});
const property = ref('');
// const displayValue = ref('');

// const onChange = (e) =>{
//   property.value = e.target.value;
//   console.log('property: ' ,property.value);
// }

// Property options array
const propertyOptions = ref([
  { label: 'Agapeya', value: 'Agapeya' },
  { label: 'Zaya', value: 'Zaya' },
]);

const newDetails = ref({});
// let details = {};
let vDetails = ref({});

let details = reactive({
  name: '',
  sku: '',
  location: '',
  category: '',
  price: '',
  processing_fee: '',
  image: ''
});


const handleDetails = (newParameter) =>{
  // productDetails.value = {}
  // form.sku = newDetails.value.sku;
  // productDetails.value = newParameter;
  // productDetails.value = {}
  // console.log('viewDetails: ', newDetails.value);
  // vDetails = newDetails.value;

  // details.name = newDetails.value.name;
  // details.sku = newDetails.value.sku;
  // details.location = newDetails.value.location;
  // details.category = newDetails.value.category;
  // details.price = newDetails.value.price;
  // details.processing_fee = newDetails.value.processing_fee;
  // details.image = newDetails.value.url_links.facade;

  // details = Object.assign({}, newDetails.value);
  console.log('new Parameter: ', newParameter);
  productDetails.value = newParameter;
  form.sku = newParameter.sku;
  // form.sku = '';
  // return details;
}
// const skuList = ref([
//   'JN-AGM-CL-HLDUS-GRN',
//   'JN-AGM-CL-HLDUS-PUR',
//   'JN-AGM-CL-HLDUS-PIN',
//   'JN-AGM-CL-HLDUS-YEL',
//   'JN-AGM-CL-HLDUF-GRN',
//   'JN-AGM-CL-HLDUF-PUR',
//   'JN-AGM-CL-HLDUF-PIN',
//   'JN-AGM-CL-HLDUF-YEL',
//   'JN-ZYA-SRL-CB-SEU-R',
//   'JN-ZYA-SRL-CB-SIU-R',
//   'JN-ZYA-SRL-CS-SEU-R',
//   'JN-ZYA-SRL-CS-SIU-R',
//   'JN-ZYA-SRL-CV-SEU-R',
//   'JN-ZYA-SRL-CV-SIU-R'
// ])
// Remove duplicates based on the 'brand' property
const uniqueBrands = [...new Set(props.products.map(product => product.brand))];

// Create a new array of unique products based on the unique brands
const uniqueProductsBrand = uniqueBrands.map(brand => {
  return props.products.find(product => product.brand === brand);
});


console.log("brand:", property.value);
// console.log("sku:", props.products.sku);
</script>

<template>
  
  <RLICard class="items-start relative">
    <!-- Content Left -->
    <template #title>
      <h1 class="font-bold text-3xl"> Sales Reservation</h1>
    </template>
    <template #contentLeft>
      <div class="mb-4">
        <form @submit.prevent="generateVoucher">
         <div class="bg-gray-100 w-full py-2 my-6 rounded-lg">
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
                @click="dropDown()"
                id="sku"
                v-model="form.sku"
                type="text"
                class="mt-1 block w-full rounded-full"
                placeholder="Enter value"
                required
                autofocus
            />
            <!-- <div class="text-gray-700 dark:text-gray-300 text-xs">
              {{ leadGenerationLink }}
            </div> -->
            <InputError :message="form.errors.sku" class="mt-2" />
            <div v-show="showingDropdown"
            @click.outside="() => { showingDropdown = false; }"
            class="bg-white shadow-2xl border rounded-lg py-2 px-3 absolute h-40 z-30 w-1/4 overflow-y-auto"
            >
                <div 
                @click="dropDownItem(skuItem, index)"
                v-for="(skuItem, index) in products"
                class="text-md my-1 hover:bg-gray-100 hover:font-bold py-1">
                 {{ skuItem.sku }}
                </div>
            </div>
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
    
          <!-- <div class="flex items-center justify-end space-x-4 px-4 py-3">
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
          </div> -->
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
                        <li class="mt-2">Price: <span class="font-normal">₱{{ product.price.toLocaleString() }}.00</span></li>
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
        </form>
      </div>
    </template>
    <template #subTitle v-if="form.sku">
      <div class="my-6">
        <div class="flex justify-between items-center">
          <div class="font-semibold text-lg">
            Browse other Properties
          </div>
          <div class="">
            <select class="rounded-lg w-full border-gray-400"
            @change="onChange"
            v-model="property"
            >
            <option 
              v-for="(product, index) in uniqueProductsBrand" 
              :key="index" 
              :value="product.brand"
            >
              {{ product.brand }}
            </option>
              <!-- <option value="Agapeya">Agapaeya</option>
              <option value="zaya">Zaya</option> -->
            </select>
          </div>
        </div>
      </div>
    </template>
    <template #BrowseProperty v-if="form.sku">
      <div class="h-auto dark:text-white">
        <Carousel 
        :products="props.products"
        :property="property"
        @view-details="handleDetails"
        />
        <!-- <Carousel 
        :products="props.products"
        /> -->
      </div>
    </template>
    <!-- content Right -->
    <template #contentRight class="">
      <div v-if="!form.sku" class="h-full">
        <div class="bg-gray-100 h-48 w-full rounded-lg">&nbsp;&nbsp;</div>
        <div class="mt-2 bg-gray-100 h-10 w-full rounded-lg">&nbsp;</div>
        <div class="grid grid-cols-5 gap-3">
          <div class="bg-gray-100 h-14 w-full mt-2 rounded-lg">&nbsp;</div>
          <div class="bg-gray-100 h-14 w-full mt-2 rounded-lg">&nbsp;</div>
          <div class="bg-gray-100 h-14 w-full mt-2 rounded-lg">&nbsp;</div>
          <div class="bg-gray-100 h-14 w-full mt-2 rounded-lg">&nbsp;</div>
          <div class="bg-gray-100 h-14 w-full mt-2 rounded-lg">&nbsp;</div>
        </div>
        <div class="text-transparent h-10">
          <div>
            &nbsp;&nbsp;
          </div>
        </div>
      </div>
      <div v-else-if="form && form.sku && form.sku.length >= 19" class="dark:text-white light:text-black">
        <div>
            <img :src="productDetails.url_links.facade" alt="Item Image1" />
            <div  class="mt-3">
              <h1 class="font-bold text-3xl">{{ productDetails.name }}</h1>
            </div>
            <div class="hidden lg:grid lg:grid-cols-5 mt-4">
                    <div class="flex gap-2 basis-0 grow flex-shrink-0">
                        <LotAreaLogo />
                        <div>
                            <p class="text-gray-400">Lot Area</p>
                            <p>{{ productDetails.lot_area }}</p>
                        </div>
                    </div>
                    <div class="flex gap-2 basis-0 grow flex-shrink-0">
                        <FloorAreaLogo />
                        <div>
                            <p class="text-gray-400">Floor Area</p>
                            <p>{{ productDetails.floor_area }}SQM</p>
                        </div>
                    </div>
                    <div class="flex gap-2 w-auto">
                        <UnitTypeLogo />
                        <div>
                            <p class="text-gray-400">Unit Type</p>
                            <p>{{ productDetails.unit_type.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ') }}</p>
                        </div>
                    </div>
                    <div class="flex gap-2 basis-0 grow flex-shrink-0">
                        <ToiletBathLogo />
                        <div>
                            <p class="text-gray-400">Bedrooms</p>
                            <p>1</p>
                        </div>
                    </div>
                    <div class="flex gap-2 basis-0 grow flex-shrink-0">
                        <CarparkLogo />
                        <div>
                            <p class="text-gray-400">Carpark</p>
                            <p>1</p>
                        </div>
                    </div>
            </div>
            <div class="mt-4 text-lg">
                <div class="pb-4 py-3">
                    <div class="flex gap-1">
                            <p class="font-bold">Product SKU:</p>
                            <p class="font-semibold">{{ form.sku }}</p>
                    </div>
                    <div class="flex gap-1">
                            <p class="font-bold">Location:</p>
                            <p>{{ productDetails.location }}</p>
                    </div>
                    <div class="flex gap-1">
                            <p class="font-bold">Market Segment / Project Name:</p>
                            <p>{{ productDetails.category}}</p>
                    </div>
                    <div class="flex gap-1">
                            <p class="font-bold">Total Contract Price:</p>
                            <p>₱{{ productDetails.price.toLocaleString() }}.00</p>
                    </div>
                    <div class="flex gap-1">
                            <p class="font-bold">Processing Fee:</p>
                            <p>₱{{ productDetails.processing_fee.toLocaleString() }}.00</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-3">
        <form @submit.prevent="generateVoucher" class="flex gap-2">
          <template v-if="validSKU">
            <DefaultSecondaryButton @click.prevent="createLink()">
              <template #textSecondary>
                Generate Link
              </template>
            </DefaultSecondaryButton>
            <!-- <SecondaryButton @click = "showProductDetails()">
              View
            </SecondaryButton> -->
          </template>
          <DefaultPrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="">
            <template #text>
              Start
            </template>
          </DefaultPrimaryButton>
        </form>
        
        </div>
        <div v-if="leadGenerationLink" class="text-gray-700 dark:text-gray-300 text-md bg-gray-200 py-2 px-6 rounded-full">
            <div class="flex justify-between items-center">
              <div>
                <p class="font-bold">Generated Link: 
                  <span class="text-sky-600">{{ leadGenerationLink }}</span>
                </p>
              </div>
              <div class="flex items-center">
                <button 
                @click="showInfoDetail()"
                class="w-10 h-10">
                  <InfoDetails />
                </button>
                <CopyButton @click.prevent="copyToClipboard(leadGenerationLink)">
                  <template #icon>
                    <CopyLogo class="w-4 h-4 mx-auto"/>
                  </template>
                </CopyButton>
              </div>
            </div>
        </div>
      </div>
      <!-- Modal -->
      <div v-show="showingInfoDetails"
      :closeable="closeable"
      @click.prevent="closeModalInfo()"
      class="fixed inset-0 bg-black bg-opacity-30 top-0 left-0 flex justify-center px-6 py-1 z-10  overflow-y-auto"
      >
        <div
        v-if="showingInfoDetails" 
        class="bg-white self-center max-w-screen-lg rounded">
            <!-- <div class="w-full p-4 text-right">
                <button 
                @click="showInfoDetail"
                class="bg-gray-50 text-gray-400 px-3 py-1 rounded-full text-1xl text-right">&times;</button>
            </div> -->
            <!-- <div class="py-2 mb-3 md:flex flex-row gap-4">
                <img src="../../../img/RaemulanLandsLogo.png" alt="Logo" class="mx-auto h-20 mt-2">
                <img src="../../../img/Elnvital_Logo.png" alt="Logo" class="mx-auto h-20 mt-2">
            </div> -->
            <div class="grid grid-cols-2 pt-6 pb-6 gap-2 items-center px-6">
                <div class="px-8">
                  <h1 class="text-3xl font-bold mb-2">{{ product.name }}</h1>
                  <h1 class="bg_text text-2xl font-semibold">Generated Link</h1>
                  <div class="text-md bg-gray-200 py-2 px-4 rounded-full flex justify-between mt-4 items-center">
                    <div>
                      <span class="text-sky-600">{{ leadGenerationLink }}</span>
                    </div>
                    <CopyButton @click.prevent="copyToClipboard(leadGenerationLink)">
                      <template #icon>
                        <CopyLogo class="w-4 h-4 mx-auto"/>
                      </template>
                    </CopyButton>
                    <!-- <button class="bg-white rounded-full w-8 h-8">
                    </button> -->
                  </div>
                  <div class="mt-4 text-md">
                    <p>
                    We've generated a link for you. This link can be shared with anyone or used to create advertising materials for selling the property.
                  </p>
                  </div>
                </div>
                <div class="px-2">
                  <img src="../../../img/InfoImage.png" alt="infoImage" srcset="">
                </div>
              </div>
          
        </div>
      </div>
      <!-- Modal End -->
      <!-- <DialogModal :show="showingInfoDetails" @close="closeModalInfo">
       
            <template #title>
            
            </template>
            <template #content>
              <div class="grid grid-cols-2 pt-10 pb-6 gap-2">
                <div class="mx-2">
                  <h1 class="text-3xl font-bold mb-2">{{ product.name }}</h1>
                  <h1 class="bg_text text-2xl font-semibold">Generated Link</h1>
                  <div class="text-md bg-gray-200 py-2 px-4 rounded-full flex justify-between mt-4 items-center">
                    <div>
                      <span class="text-sky-600">{{ leadGenerationLink }}</span>
                    </div>
                    <CopyButton @click="copyToClipboard(leadGenerationLink)">
                      <template #icon>
                        <CopyLogo class="w-4 h-4 mx-auto"/>
                      </template>
                    </CopyButton>
                 
                  </div>
                  <div class="mt-4 text-md">
                    <p>
                    We've generated a link for you. This link can be shared with anyone or used to create advertising materials for selling the property.
                  </p>
                  </div>
                </div>
                <div>
                  <img src="../../../img/InfoImage.png" alt="infoImage" srcset="">
                </div>
              </div>
               
            </template>
      </DialogModal> -->
    </template>
  </RLICard>
</template>

<style scoped>
.bg_text{
  color: #CD045D;
}
</style>
