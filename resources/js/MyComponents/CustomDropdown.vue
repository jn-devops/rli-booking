<script setup>
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { ref, watchEffect, onUnmounted, onMounted, computed  } from 'vue';

const props = defineProps({
    customData: String,
    products: Object
});

const customDropdown = ref(false);
const dropdown = ref(null)

const customDropdownClick = () =>{
    customDropdown.value = !customDropdown.value;
}

const options = ref([
  'Option 1',
  'Option 2',
  'Option 3',
  'Option 4',
  'Option 5',
  'Option 6',
  'Option 7',
  'Option 8',
  'Option 9',
  'Option 10',
]);
const items = ref({});
items.value = props.products
const filteredItems = computed(() => {
  if (!items.value) return [];

  return items.value.filter(item => {
    return !item.type.includes('configurable');
  });
  // return filteredItems.value.filter(item =>
  //   item.name.toLowerCase().includes(query) || item.sku.toLowerCase().includes(query)
  // );
});


const inputValue = ref('');
const showDropdown = ref(false);
// const filteredOptions = ref(filteredItems);
const highlightedIndex = ref(-1);


const filteredOptions = computed(() => {
  const query = inputValue.value.toLowerCase();
  return filteredItems.value.filter(item =>
    item.name.toLowerCase().includes(query) || item.sku.toLowerCase().includes(query)
  );
});

const filterOptions = () => {
  // inputValue.value = inputValue.value;
  const query = inputValue.value.toLowerCase();
  // if(inputValue.value){
    filteredOptions.value.filter(option =>
    option.sku.toLowerCase().includes(query) || option.name.toLowerCase().includes(query)
    );
  // } else{
  //   filteredOptions.value = [];
  // }
};

const selectOption = (option) => {
  inputValue.value = option.sku;
  // showDropdown.value = false;
  // inputValue.value = `${option.sku} - ${option.name}`;
  showDropdown.value = false;
  highlightedIndex.value = -1;
};

const handleBlur = () => {
  //setTimeout(() => {
    showDropdown.value = false;
  //}, 100); // Delay to allow click event to register
};


// const handleKeydown = (event) => {
//   if (!showDropdown.value) return;

//   switch (event.key) {
//     case 'ArrowDown':
//       event.preventDefault();
//       highlightedIndex.value = (highlightedIndex.value + 1) % filteredOptions.value.length;
//       break;
//     case 'ArrowUp':
//       event.preventDefault();
//       highlightedIndex.value = (highlightedIndex.value - 1 + filteredOptions.value.length) % filteredOptions.value.length;
//       break;
//     case 'Enter':
//       event.preventDefault();
//       if (highlightedIndex.value >= 0 && highlightedIndex.value < filteredOptions.value.length) {
//         selectOption(filterOptions.value[highlightedIndex.value]);
//       }
//       break;
//   }
// };

const handleKeydown = (event) => {
  if (!showDropdown.value) return;

  switch (event.key) {
    case 'ArrowDown':
      event.preventDefault();
      highlightedIndex.value = (highlightedIndex.value + 1) % filteredOptions.value.length;
      break;
    case 'ArrowUp':
      event.preventDefault();
      highlightedIndex.value = (highlightedIndex.value - 1 + filteredOptions.value.length) % filteredOptions.value.length;
      break;
    case 'Enter':
      event.preventDefault();
      if (highlightedIndex.value >= 0 && highlightedIndex.value < filteredOptions.value.length) {
        selectOption(filteredOptions.value[highlightedIndex.value]);
      }
      break;
  }
};



console.log('filteredItems:' , filteredItems);
console.log('filteredOption:' , filteredOptions);
console.log('inputValue:' , inputValue.value);
console.log('itemsValue:' , items.value);

</script>
<template>
      <InputLabel :for="customData" :value="customData" class="font-bold text-lg" />
      <div class="z-50">
          <!-- <TextInput
                :id="customData"
                type="text"
                class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                :placeholder="customData"
                required
                autofocus
                @focus="showDropdown = true"
                @input="filterOptions"
                @blur="handleBlur"
                v-model="inputValue"
            />
            <div class="absolute inset-y-3 right-2 z-30">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 dark:text-white light:text-black">
                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </div>
            <ul
                v-if="showDropdown"
                class="absolute w-full border bg-white rounded mt-1 max-h-48 overflow-y-auto z-10"
                >
                <li
                    v-for="(option, index) in filteredOptions"
                    :key="index"
                    @mousedown="selectOption(option)"
                    class="px-2 py-1 cursor-pointer hover:bg-gray-200"
                >
                    {{ option }}
                </li>
            </ul>
      </div>
    <div v-if="$slots.dropdown && customDropdown" class="bg-green-100 absolute -bottom-15 left-0 right-0 z-50 flex items-center justify-center h-2/4 w-2/4 px-3">
        <slot name="dropdown" />
    </div> -->
    <input
      type="text"
      v-model="inputValue"
      @focus="showDropdown = true"
      @input="filterOptions"
      @keydown="handleKeydown"
      :placeholder="customData"
      @blur="handleBlur"
      class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
    />
     <!-- Teleport the dropdown to the cardLayout element -->
      <ul
          v-if="showDropdown"
          class="absolute -bottom-25 w-5/12 border bg-white rounded mt-0 max-h-48 overflow-y-auto z-50"
      >
          <li
          v-for="(option, index) in filteredOptions"
          :key="index"
          @mousedown="selectOption(option)"
        
          :class="{
            'px-2 py-1 cursor-pointer hover:bg-blue-600 hover:text-white z-50': true,
            'hover:bg-blue-600 hover:text-white': true,
            'bg-blue-600 text-white': index === highlightedIndex,
          }"
          >
          {{ option.sku }} - {{ option.name }}
          </li>
      </ul>
  </div>
</template>