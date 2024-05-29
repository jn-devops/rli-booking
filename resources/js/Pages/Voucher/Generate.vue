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
import { ref, computed, watch , reactive, onMounted, onUnmounted, provide  } from 'vue';
import ButtonPrimary from '@/MyComponents/ButtonPrimary.vue';
import RLICardLayout from '@/MyComponents/RLICardLayout.vue';
import RLICardv2 from "@/MyComponents/RLICardv2.vue";
import UserIconLogo from '@/MyComponents/UserIconLogo.vue';
import RLICard from "@/MyComponents/RLICard.vue";
import RLICardv3 from "@/MyComponents/RLICardv3.vue";
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
import ProductList from '@/MyComponents/ProductList.vue';
import ShareLogo from '@/MyComponents/ShareLogo.vue';

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
// const productDetails = ref({
//   brand: props.products[2].brand,
//   category: props.products[2].category,
//   floor_area: props.products[2].floor_area,
//   lot_area: props.products[2].lot_area,
//   name: props.products[2].name,
//   price: props.products[2].price,
//   processing_fee: props.products[2].processing_fee,
//   sku: props.products[2].sku,
//   type: props.products[2].type,
//   unit_type: props.products[2].unit_type,
//   url_links: props.products[2].url_links
// });

const productDetails = ref(null);
// const defaultSKU = ref(props.products[1].sku);
const form = useForm({
  email: seller,
  discount: '0',
  sku: sku
});

// form.sku = productDetails.value.sku;
// console.log('productDetails:', productDetails.value);
// console.log('sku:', form.sku);
// console.log('product:', props.products);
const showingProductDetails = ref(false);

const closeModal = () => {
  showingProductDetails.value = false;
}

const validSKU = ref(false);
const product = ref(null);
const leadGenerationLink = ref(null);
const showingInfoDetails = ref(false);
const selectedProduct = ref(null);
const createLink = (newParameter) => {
  // console.log('createLink:', newParameter);
  form.sku = newParameter.sku;
  selectedProduct.value = newParameter;
  leadGenerationLink.value = null;
  let title = 'Lead Generation: ' + seller + ' (' + form.sku + ')';
  router.post(route('create-link', { sku: form.sku, title: title }));
  setTimeout(function(){
    showingInfoDetails.value = true
  },2500);
  
};

const showProductDetails = () => {
  if (leadGenerationLink.value.length > 0)
    showingProductDetails.value = true;
}

// watch (() => form.sku, (newValue) => {
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

// const generatedSku = ref('');
const generateVoucher = (newParams) => {
  console.log('click');
  form.sku = newParams.sku;
  // generatedVoucher.value = newParams
  console.log('form:', form);
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
const viewDetailed = ref(null);
const showViewDetails = ref(false);
const showingViewDetails = (newPrams) =>{
  console.log('newpParams:', newPrams);
  viewDetailed.value = newPrams;

  console.log('viewDetails:', viewDetailed.value);
  showViewDetails.value = true;
}

const closeModalViewDetail = () =>{
  showViewDetails.value = !true;
}

const closeModalInfo = () =>{
  showingInfoDetails.value = !true;
}


const showInfoDetail = (newParams) =>{
  selectedProduct.value = newParams;
  console.log('newPrams:', selectedProduct.value);
  showingInfoDetails.value = true;
}
const copyToClipboard = (leadParams) =>{
  console.log('leadParams:', leadParams);
  navigator.clipboard.writeText(leadParams.value);
  console.log("copied.value: ", leadParams.value);
}


const handleCopyClick = (event) => {
    event.stopPropagation(); // Prevent event propagation to parent elements
    copyToClipboard(leadGenerationLink); // Call the copyToClipboard function
  };

// const selectedProperty = ref('');
const displayValue = ref('');
const property = ref('');

// const updateDisplayValue = () => {
//   if (form.sku && form.sku.includes('AGM')) {
//     displayValue.value = 'Agapeya';
//     property.value = 'Agapeya';
//   } else if (form.sku && form.sku.includes('ZYA')) {
//     displayValue.value = 'Zaya';
//     property.value = 'Zaya';
//   } else {
//     displayValue.value = '';
//   }
// };

// console.log('productDetails:', productDetails.value);
// watch(() => form.sku, updateDisplayValue, updateDisplayValue());

// console.log('Initial form.sku:', form.sku);
// console.log('Initial displayVal:', displayValue.value);
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
watch(displayValue, (newVal, oldVal) => {
  // console.log('New Value:', newVal);
  // console.log('Old Value:', oldVal);
  if (newVal === 'Agapeya') {
    property.value = 'Agapeya';
  } else if (newVal === 'Zaya') {
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

const dropDownItem = (skuParams) =>{
  // console.log('skuNow:', productDetails.value);
  productDetails.value = {}
  form.sku = null;
  showingDropdown.value = !showingDropdown.value;
  form.sku = skuParams.sku;
  productDetails.value = skuParams;
  highlightedIndex.value = -1;

  // console.log('formSKU: ', form.sku);
  // console.log('index: ',index, 'skuParams:', productDetails.value);

  // console.log("filteredItemsUpdate: ", filteredItems);

  // console.log('index: ',index, 'skuParams:', productDetails.value.brand);
}
const handleClickOutside = (event) => {
  if (showingDropdown.value) {
    if (!event.target.closest('.bg-white')) {
      showingDropdown.value = false;
    }
  }
};

const handleClickOutsideDiv = (event) => {
    if (event.target.classList.contains('bg-opacity-30')) { // Assuming 'bg-opacity-30' is the class of the black area
    closeModalInfo();
    console.log("you've clicked me");
    }
  };



onMounted(() => {
  document.addEventListener('click', handleClickOutside);
  document.addEventListener('click', handleClickOutsideDiv);

});

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside);
  document.removeEventListener('click', handleClickOutsideDiv);
});

// const displayValue = ref('');

// const onChange = (e) =>{
//   property.value = e.target.value;
//   console.log('property: ' ,property.value);
// }

// Property options array
// const propertyOptions = ref([
//   { label: 'Agapeya', value: 'Agapeya' },
//   { label: 'Zaya', value: 'Zaya' },
// ]);

// const newDetails = ref({});
// // let details = {};
// let vDetails = ref({});

// let details = reactive({
//   name: '',
//   sku: '',
//   location: '',
//   category: '',
//   price: '',
//   processing_fee: '',
//   image: ''
// });


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
  // console.log('new Parameter: ', newParameter);
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


const uniqueLocations = [...new Set(props.products.map(product => product.location))];
const uniqueProductsLocation = uniqueLocations.map(location => {
  return props.products.find(product => product.location === location);
});
// console.log('unique', uniqueProductsBrand);
const enterFunction = (skuParam) =>{
  // console.log('parameter SKU:', skuParam);
}
// console.log("brand:", property.value);
// console.log("sku:", props.products.sku);
const prodsku = ref('');
const locationName = ref('Laguna');
const projName = ref('Agapeya');
const items = ref({});
items.value = props.products
const filteredItems = computed(() => {
  if (!items.value) return [];

  return items.value.filter(item => {
    if(productDetails.value){
      const sku = productDetails.value.sku;
      prodsku.value = sku;
      return item.sku.includes(sku) && 
             item.brand.includes(projName.value) && 
             item.location.includes(locationName.value) && 
             !item.type.includes('configurable');
    } else{
      prodsku.value = '';
      // console.log('item.value:', item.value);
      return item.brand.includes(projName.value) && 
             item.location.includes(locationName.value) && 
             !item.type.includes('configurable');
    }
  });
});

// Watch prodsku and clear productDetails when prodsku is cleared
watch(prodsku, (newVal, oldVal) => {
  if (!newVal) {
    productDetails.value = null;
  }
});
const filteredItem = computed(() => {
  // if (!items.value) return [];

  // return items.value.filter(item => {
  //     return item.brand.includes(projName.value) && item.location.includes(locationName.value) && !item.type.includes('configurable')
  // });
  const query = prodsku.value.toLowerCase();
  return filteredItems.value.filter(item =>
    item.name.toLowerCase().includes(query) || item.sku.toLowerCase().includes(query)
  );
});

const filterOptions = () => {

  // inputValue.value = inputValue.value;
  const query = prodsku.value.toLowerCase();
  // if(inputValue.value){
    filteredItems.value.filter(option =>
    option.sku.toLowerCase().includes(query) || option.name.toLowerCase().includes(query)
    );
  // } else{
  //   filteredOptions.value = [];
  // }
};

const selectOption = (option) => {
  prodsku.value = option.sku;
  console.log()
  // showDropdown.value = false;
  // inputValue.value = `${option.sku} - ${option.name}`;
  showingDropdown.value = false;
  highlightedIndex.value = -1;
};

const handleKeydown = (event) => {
  if (!showingDropdown.value) return;

  switch (event.key) {
    case 'ArrowDown':
      event.preventDefault();
      highlightedIndex.value = (highlightedIndex.value + 1) % filteredItem.value.length;
      break;
    case 'ArrowUp':
      event.preventDefault();
      highlightedIndex.value = (highlightedIndex.value - 1 + filteredItem.value.length) % filteredItem.value.length;
      break;
    case 'Enter':
      event.preventDefault();
      if (highlightedIndex.value >= 0 && highlightedIndex.value < filteredItem.value.length) {
        dropDownItem(filteredItem.value[highlightedIndex.value]);
      }
      break;
  }
};

provide('products', filteredItems);
// console.log('filteredItems:', productDetails.value);
// provide('productsDetails', filteredItems);
const highlightedIndex = ref(-1);
const handleBlur = () => {
  //setTimeout(() => {
    showingDropdown.value = false;
  //}, 100); // Delay to allow click event to register
};


</script>

<template>
  
  <RLICardv3 class="items-start relative">
    <!-- Content Left -->
    <template #title>
      <h1 class="dark:text-white light:text-black font-bold text-3xl my-6"> Select property to reserve</h1>
    </template>
    <template #contentLeft>
      <form>
        <div class="grid md:grid-cols-2 sm:grid-rows-1 mt-4">
           <!-- <div class="bg-gray-100 dark:bg-gray-600 w-full py-2 my-6 rounded-lg">
            <div class="flex items-center gap-2">
                <div v-if="$page.props.jetstream.managesProfilePhotos">
                  <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                </div>
                <div v-else class="">
                   <UserIconLogo class="h-20 w-20 py-2"/>
                </div>
                <div class="text-sm dark:text-white light:text-black">
                    <p class="text-lg font-bold">{{sellerName}}</p>
                    <p>{{seller}}</p>
                    <p class="bg_text capitalize">seller</p>
                </div>
            </div>
           </div> -->
            <div class="rounded-full pt-2">
              <InputLabel for="sku" value="Product SKU" class="font-bold text-lg" />
              <TextInput
                  @click="dropDown()"
                  id="sku"
                  v-model="prodsku"
                  @input="filterOptions"
                  @blur="handleBlur"
                  @keydown="handleKeydown"
                  type="text"
                  class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
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
              class="bg-white shadow-2xl border rounded-lg py-2 px-3 absolute h-40 z-30 w-3/4 md:w-5/12 overflow-y-auto"
              >
                  <div 
                  @mousedown="dropDownItem(skuItem)"
                  v-for="(skuItem, index) in filteredItem"
                  :class="{
                    'px-2 py-1 cursor-pointer hover:bg-blue-600 hover:text-white z-50': true,
                    'hover:bg-blue-600 hover:text-white': true,
                    'bg-blue-600 text-white': index === highlightedIndex,
                  }">
                   {{ skuItem.sku }} - {{ skuItem.name }}
                  </div>
              </div>
            </div>
            <div class="flex gap-2 sm:px-0 md:px-4 pt-2 md:ot-0">
                <div class="grow w-1/4">
                  <InputLabel for="location" value="Location" class="font-bold text-lg" />
                          <select class="custom-select mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                          v-model="locationName"
                          >
                              <option selected disabled>Select Project Name</option>
                              <option v-for="product in uniqueProductsLocation" :key="product.id">
                                  {{ product.location }}
                              </option>
                          </select>
                      </div>
                      <div class="grow w-1/4">
                          <InputLabel for="project_name" value="Project Name" class="font-bold text-lg" />
                          <select class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                          v-model="projName"
                          >
                              <option selected disabled>Select Project Name</option>
                              <option v-for="product in uniqueProductsBrand" :key="product.id">
                                  {{ product.brand }}
                              </option>
                          </select>
                      </div>
            </div>
            
            <!-- <div class="hidden">
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
            </ActionMessage> -->
      
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
            <!-- <DialogModal :show="showingProductDetails" @close="closeModal">
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
            </DialogModal> -->
            <!-- </div> -->
         
          
        </div>
      <div class="block mt-12">
        <div class="grid grid-rows-1">
          <ProductList 
          :project-name="projName"
          @product-selected="showInfoDetail"
          >
            <template #buttons="{product}">
              <form @submit.prevent="generateVoucher(product)" class="block xl:flex gap-2 items-center justify-center">
                  <button 
                  :class="{ 'opacity-25': form.processing }" :disabled="form.processing" :key="product.id"
                  class="md:mt-2 w-full xl:mt-0 xl:w-auto border h-10 px-6 py-2 bg_btn text-white font-semibold rounded-full text-sm hover:bg-black hover:opacity-80">Reserve</button>  
                <!-- <button @click.prevent="createLink()" class="hover:text-white hover:bg-rose-500">
                  gener
                </button> -->
                <div class="flex md:hidden items-center gap-2">
                  <button 
                  @click.prevent="showingViewDetails(product)"
                  class="mt-2 w-full xl:mt-0 xl:w-auto border bg_border h-10 sm:px-4 py-2 rounded-full text-xs sm:text-sm hover:text-white hover:bg-rose-500 ">View Details</button>
                  <div 
                  
                  @click.prevent="createLink(product)"
                  class="mt-2 mx-auto xl:mt-0 xl:mx-0 xl: w-8 bg-rose-200 h-8 rounded-full flex items-center cursor-pointer hover:border hover:border-rose-500 hover:bg-white">
                    <ShareLogo class="mx-auto h-4 w-4"/>
                  </div>
                </div>
                <div class="hidden md:flex items-center gap-2">
                  <button 
                  @click.prevent="showingViewDetails(product)"
                  class="mt-2 w-full xl:mt-0 xl:w-auto border bg_border h-10 px-3 py-2 rounded-full text-sm hover:text-white hover:bg-rose-500 ">View Details</button>
                  <div 
                  
                  @click.prevent="createLink(product)"
                  class="mt-2 mx-auto xl:mt-0 xl:mx-0 xl: w-8  bg-rose-200 h-8 rounded-full flex items-center cursor-pointer hover:border hover:border-rose-500 hover:bg-white">
                    <ShareLogo class="mx-auto h-4 w-4"/>
                  </div>
                </div>
              </form>
            </template>
          </ProductList>
        </div>
      </div>
    </form>
    </template>
    
  </RLICardv3>
   <!-- Modal Share-->
  <div v-show="showingInfoDetails"
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
            <div class="">
                <div class="w-full p-4 text-right">
                  <button 
                  @click.prevent="closeModalInfo()"
                  class="bg-gray-50 text-gray-400 px-3 py-1 rounded-full text-xl text-right">&times;</button>
                </div>
                <div class="hidden md:grid grid-cols-2 pt-6 pb-6 gap-2 items-center px-6">
                  <div class="px-8">
                    <h1 class="text-3xl font-bold mb-2">{{ selectedProduct.name }}</h1>
                    <h1 class="bg_text text-2xl font-semibold">Generated Link</h1>
                    <div class="text-md bg-gray-200 py-2 px-4 rounded-full flex justify-between mt-4 items-center">
                      <div>
                        <span class="text-sky-600">{{ leadGenerationLink }}</span>
                      </div>
                      <CopyButton @click.prevent="handleCopyClick">
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
                <div class="md:hidden grid grid-rows-1">
                  <div class="w-60 h-60 mx-auto">
                    <img src="../../../img/InfoImage.png" alt="infoImage" srcset="">
                  </div>
                  <div class="px-8">
                    <h1 class="text-2xl md:text-3xl font-bold mb-2">{{ selectedProduct.name }}</h1>
                    <h1 class="bg_text text-xl md:text-2xl font-semibold">Generated Link</h1>
                    <div class="text-md bg-gray-200 py-2 px-4 rounded-full flex justify-between mt-4 items-center">
                      <div>
                        <span class="text-sky-600 text-sm md:text-md">{{ leadGenerationLink }}</span>
                      </div>
                      <CopyButton @click.prevent="handleCopyClick">
                        <template #icon>
                          <CopyLogo class="w-4 h-4 mx-auto"/>
                        </template>
                      </CopyButton>
                      <!-- <button class="bg-white rounded-full w-8 h-8">
                      </button> -->
                    </div>
                    <div class="mt-4 text-sm md:text-md py-4">
                      <p>
                      We've generated a link for you. This link can be shared with anyone or used to create advertising materials for selling the property.
                    </p>
                    </div>
                  </div>
                </div>
              </div>
          
        </div>
      </div>
      <!-- Modal Details -->
      <div v-show="showViewDetails"
  @click.self="closeModalViewDetail()"
  class="fixed inset-0 bg-black bg-opacity-30 top-0 left-0 flex justify-center px-6 py-1 z-10  overflow-y-auto"
  >
        <div
        v-if="showViewDetails" 
        class="bg-white self-center max-w-screen-xl rounded py-2">
            <!-- <div class="w-full p-4 text-right">
                <button 
                @click="showInfoDetail"
                class="bg-gray-50 text-gray-400 px-3 py-1 rounded-full text-1xl text-right">&times;</button>
            </div> -->
            <!-- <div class="py-2 mb-3 md:flex flex-row gap-4">
                <img src="../../../img/RaemulanLandsLogo.png" alt="Logo" class="mx-auto h-20 mt-2">
                <img src="../../../img/Elnvital_Logo.png" alt="Logo" class="mx-auto h-20 mt-2">
            </div> -->
            <div class="">
                <div class="w-full p-4 text-right">
                  <button 
                  @click.self="closeModalViewDetail()"
                  class="bg-gray-50 text-gray-400 px-3 py-1 rounded-full text-xl text-right">&times;</button>
                </div>
                <div class="grid sm:grid-rows-1 md:grid-cols-2 pt-6 pb-6 gap-4 px-6">
                  <div class="px-2">
                    <img :src="viewDetailed.url_links.facade" class="object-fit w-full h-full" alt="Detail Image" srcset="">
                  </div>
                  <div class="">
                    <h1 class="text-2xl md:text-3xl font-bold mb-2">{{ viewDetailed.name }}</h1>
                    <div class="hidden md:grid lg:grid-cols-5 mt-4">
                        <div class="flex gap-2 basis-0 grow flex-shrink-0 text-sm md:text-md">
                            <LotAreaLogo />
                            <div>
                                <p class="text-gray-400">Lot Area</p>
                                <p>{{ viewDetailed.lot_area }}</p>
                            </div>
                        </div>
                        <div class="flex gap-2 basis-0 grow flex-shrink-0 text-sm md:text-md">
                            <FloorAreaLogo />
                            <div>
                                <p class="text-gray-400">Floor Area</p>
                                <p>{{ viewDetailed.floor_area }}SQM</p>
                            </div>
                        </div>
                        <div class="flex gap-2 w-auto">
                            <UnitTypeLogo />
                            <div>
                                <p class="text-gray-400">Unit Type</p>
                                <p>{{ viewDetailed.unit_type.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ') }}</p>
                            </div>
                        </div>
                        <div class="flex gap-2 basis-0 grow flex-shrink-0 text-sm md:text-md">
                            <ToiletBathLogo />
                            <div>
                                <p class="text-gray-400">Bedrooms</p>
                                <p>1</p>
                            </div>
                        </div>
                        <div class="flex gap-2 basis-0 grow flex-shrink-0 text-sm md:text-md">
                            <CarparkLogo />
                            <div>
                                <p class="text-gray-400">Carpark</p>
                                <p>1</p>
                            </div>
                        </div>
                    </div>
                    <div class="block md:hidden">
                      <div class="grid grid-cols-3 dark:text-white light:text-black">
                        <div class="flex gap-2 text-sm md:text-md">
                            <LotAreaLogo />
                            <div>
                                <p class="text-gray-400">Lot Area</p>
                                <p>{{ viewDetailed.lot_area }}</p>
                            </div>
                        </div>
                        <div class="flex gap-2 text-sm md:text-md">
                            <FloorAreaLogo />
                            <div>
                                <p class="text-gray-400">Floor Area</p>
                                <p>{{ viewDetailed.floor_area }}SQM</p>
                            </div>
                        </div>
                        <div class="flex gap-2 text-sm md:text-md">
                            <UnitTypeLogo />
                            <div>
                                <p class="text-gray-400">Unit Type</p>
                                <p>{{ viewDetailed.unit_type.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 mt-4 dark:text-white light:text-black">
                        <div class="flex gap-2 text-sm md:text-md">
                            <ToiletBathLogo />
                            <div>
                                <p class="text-gray-400">Bedrooms</p>
                                <p>1</p>
                            </div>
                        </div>
                        <div class="flex gap-2 text-sm md:text-md">
                            <CarparkLogo />
                            <div>
                                <p class="text-gray-400">Carparks</p>
                                <p>1</p>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="block md:hidden mt-4 text-lg">
                      <div class="pb-4 py-3">
                          <div class="flex gap-1">
                                  <p class="font-bold text-sm md:text-md">Product SKU:</p>
                                  <p class="font-semibold text-sm md:text-md">{{ viewDetailed.sku }}</p>
                          </div>
                          <div class="flex gap-1">
                                  <p class="font-bold text-sm md:text-md">Location:</p>
                                  <p class="text-sm md:text-md">{{ viewDetailed.location }}</p>
                          </div>
                          <div class="flex gap-1">
                                  <p class="font-bold text-sm md:text-md">Market Segment / Project Name:</p>
                                  <p class="text-sm md:text-md">{{ viewDetailed.category}}</p>
                          </div>
                          <div class="flex gap-1">
                                  <p class="font-bold text-sm md:text-md">Total Contract Price:</p>
                                  <p class="text-sm md:text-md">₱{{ viewDetailed.price.toLocaleString() }}.00</p>
                          </div>
                          <div class="flex gap-1">
                                  <p class="font-bold text-sm md:text-md">Processing Fee:</p>
                                  <p class="text-sm md:text-md">₱{{ viewDetailed.processing_fee.toLocaleString() }}.00</p>
                          </div>
                      </div>
                    </div>
                    <div>
                      <form @submit.prevent="generateVoucher(viewDetailed)" class="flex gap-2 items-center">
                          <button 
                          :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                          class="border w-44 h-14 px-6 py-2 bg_btn text-white font-semibold rounded-full text-sm">Reserve</button>
                          <div   
                          @click.prevent="createLink(viewDetailed)"
                          class="bg-rose-200 w-10 h-10 rounded-full flex items-center cursor-pointer">
                            <ShareLogo class="mx-auto"/>
                          </div>
                        </form>
                    </div>
                  </div>
                
                </div>
              
              </div>
          
        </div>
      </div>
</template>

<style scoped>
.bg_text, .bg_border{
  color: #CD045D;
}
.bg_border:hover{
  color: #ffff;
}
.bg_border{
  border: solid 1px #CD045D;
}
.custom-select::after{
  content: url('../../../img/SelectDropdownIconpng.png');
  position: absolute;
  top: 50%;
  right: 10px;
  transform: translateY(-50%);
  height: 20px;
  width: 20px;
  pointer-events: none;
}
</style>
