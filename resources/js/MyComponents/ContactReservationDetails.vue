<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import CustomDropdown from '@/MyComponents/CustomDropdown.vue';
import { ref } from 'vue';
const props = defineProps({
    products: Object,
    projectName: String,
    sellerInfo: Object
});

const projectName = ref('Select Project Name');
// Remove duplicates based on the 'brand' property
const uniqueBrands = [...new Set(props.products.map(product => product.brand))];

// Create a new array of unique products based on the unique brands
const uniqueProductsBrand = uniqueBrands.map(brand => {
  return props.products.find(product => product.brand === brand);
});
// console.log('ContactReservationDetails Product:', props.products);

const emit = defineEmits(['projectName']);
const selectedProject = (e) =>{
    projectName.value = e.target.value;
    emit('projectName', projectName.value);
    // console.log('selected Project Name:', projectName.value);
}

console.log('sellers:', props.sellerInfo);

const sellerCode = ref('');

console.log('project Code: ', sellerCode.value);

props.sellerInfo.forEach(seller => {
    // console.log(seller);
     if(seller.seller_code.includes(sellerCode.value)){
        console.log(true);
     }
});
// const handleSellerNames = () =>{
// }

</script>
<template>
    <div class="border-t-2">
        <div class="container mx-auto p-4">
                <div class="flex flex-wrap gap-2">
                       <div class="grow w-2/5">
                        <InputLabel for="project_name" value="Project Name" class="font-bold text-lg" />
                            <select class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            v-model="projectName"
                            @change="selectedProject"
                            >
                                <option selected disabled>Select Project Name</option>
                                <option v-for="product in uniqueProductsBrand" :key="product.id">
                                    {{ product.brand }}
                                </option>
                            </select>
                       </div>
                       <div class="grow w-2/5">
                        <InputLabel for="tcp" value="Total Contract Price" class="font-bold text-lg" />
                            <TextInput
                                id="seller_code"
                                type="text"
                                class="mt-2 block w-full bg-gray-100 rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6  font-bold"
                                placeholder="Seller Code"
                                required
                                autofocus
                                disabled
                                v-model="sellerCode"
                            />
                       </div>
                </div>
               <div class="grid grid-cols-2">
                <div class="flex gap-2 mt-3">
                    <div class="grow w-2/4">
                            <InputLabel for="seller_code" value="Seller Code" class="font-bold text-lg" />
                            <TextInput
                                id="seller_code"
                                type="text"
                                class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6  font-bold"
                                placeholder="Seller Code"
                                required
                                autofocus
                                v-model="sellerCode"
                            />
                        </div>
                        <div class="grow w-2/4">
                            <InputLabel for="seller_name" value="Seller Name" class="font-bold text-lg" />
                            <TextInput
                                id="seller_name"
                                type="text"
                                class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6 bg-gray-100 font-bold"
                                placeholder="Seller Name"
                                :value="sellerCode"
                                required
                                autofocus
                                disabled
                            />
                        </div>
                    </div>
               </div>
            <div class="flex flex-wrap mt-3 gap-2">
                <div class="grow w-2/5">
                    <CustomDropdown :customData="'Product SKU'" :products="props.products" />
                </div>
                <div class="grow w-2/5">
                    <InputLabel for="seller_name" value="Seller Name" class="font-bold text-lg" />
                    <select class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    v-model="projectName"
                    >
                        <option selected disabled>Select Project Name</option>
                        <option v-for="product in uniqueProductsBrand" :key="product.id">
                            {{ product.brand }}
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</template>