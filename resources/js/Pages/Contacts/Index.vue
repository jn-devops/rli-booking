<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import RLICardv2 from '@/MyComponents/RLICardv2.vue';
import DefaultLayout from '@/MyComponents/DefaultLayout.vue';
import SearchLogo from '@/MyComponents/SearchLogo.vue';
import DefaultSecondaryButton from '@/MyComponents/DefaultSecondaryButton.vue';
import ChevronLeftLogo from '@/MyComponents/ChevronLeftLogo.vue';
import ChevronRightLogo from '@/MyComponents/ChevronRightLogo.vue';
import { ref, computed } from 'vue';
const props = defineProps({
    contacts: Object
})

console.log('contacts: ', props.contacts);
console.log('contacts: ', props.contacts);

const contacts = ref(props.contacts);
const searchFilter = ref('');
const currentPage = ref(1);

const filteredContacts = computed(() => {
  return contacts.value.filter(contact => {
    const fullName = `${contact.profile.first_name} ${contact.profile.last_name}`;
    return fullName.toLowerCase().includes(searchFilter.value.toLowerCase());
  });
});

const searchFilterFunc = (event) => {
  searchFilter.value = event.target.value;
};

// const paginatedContacts = computed(() => {
//   const startIndex = (currentPage.value - 1) * 5;
//   const endIndex = startIndex + 5;
//   return filteredContacts.value.slice(startIndex, endIndex);
// });

// const totalPages = computed(() => {
//   return Math.ceil(filteredContacts.value.length / 5);
// });


// const setCurrentPage = (pageNumber) => {
//   currentPage.value = pageNumber;
// };

const paginatedContacts = computed(() => {
  const startIndex = (currentPage.value - 1) * 5;
  const endIndex = startIndex + 5;
  return filteredContacts.value.slice(startIndex, endIndex);
});

const startIndex = computed(() => {
  return (currentPage.value - 1) * 5 + 1;
});

const endIndex = computed(() => {
  const lastContactIndex = currentPage.value * 5;
  return Math.min(lastContactIndex, filteredContacts.value.length);
});

const totalPages = computed(() => {
  return Math.ceil(filteredContacts.value.length / 5);
});

const setCurrentPage = (pageNumber) => {
  currentPage.value = pageNumber;
};

const goToPreviousPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--;
  }
};
const goToNextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
  }
};
</script>

<template>
  <AppLayout>
    <DefaultLayout>
      <template #title>
          <div class="flex justify-between items-center">
              <div class="font-bold text-2xl md:text-3xl">
                <h1>Contacts</h1>
              </div>
              <div class="relative flex items-center">
                <input 
                    id="propertyCode"
                    @input="searchFilterFunc"
                    type="text"
                    class="block w-full rounded-xl border-0 py-3 pl-5 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 font-semibold" 
                    placeholder="Search"
                    autofocus>
                    <SearchLogo class="absolute inset-y-3 right-2 w-6 h-6"/>
                <!-- <button
                    target="_blank"
                    @click="navigateToMapLink"
                    class="absolute inset-y-0 right-0 flex items-center justify-center px-4 underline border border-rose-600 text-rose-600 hover:bg-rose-600 hover:text-white rounded-full"
                >
                    Change Unit
                </button> -->
              </div>
          </div>
      </template>
      <template #content>
        <!-- Title Head -->
        <!-- <div class="grid grid-cols-5 bg-gray-200 font-bold py-4 px-4 justify-items-center mt-4">
          <div>Name</div>
          <div>Seller</div>
          <div>Project Details</div>
          <div>Status</div>
          <div>Actions</div>
        </div> -->
        <!-- List -->
        <!-- <div class="mt-2">
          <div 
          v-for="contact in paginatedContacts" :key="contact.id" 
          class="grid grid-cols-5 justify-items-center place-items-center bg-white p-6 mt-2 hover:outline hover:outline-blue-500/50 rounded-lg ">
              <div class="font-bold">{{ contact.profile.first_name }} {{ contact.profile.last_name }}</div>
              <div class="font-bold"></div>
              <div class="grid grid-cols-2 gap-4">
                <div class="text-gray-500 text-xs">
                  <p>Project Name:</p>
                  <p class="py-1">Total Contract Price:</p>
                  <p>Phase Block Lot:</p>
                </div>
                <div class="font-bold text-xs">
                  <p>Pasinaraw</p>
                  <p class="py-1">₱2,000,000</p>
                  <p>Not yet selected</p>
                </div>
              </div>
              <div class="bg-gray-100 rounded-full h-10 px-6 py-2 text-gray-600 font-semibold">
                <p>Without Payment</p>
              </div>
              <div class="">
                <a :href="`/contacts/${contact.uid}`">
                <DefaultSecondaryButton class="hover:bg-rose-500 hover:text-white hover:font-bold">
                  <template #textSecondary>
                      View Details
                  </template>
                </DefaultSecondaryButton>
                </a>
              </div>
          </div>
        
          <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6 mt-1">
          <div class="flex flex-1 justify-between sm:hidden">
            <a href="#" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
            <a href="#" class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
          </div>
          <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
              <p class="text-sm text-gray-700">
                Showing
                {{ ' ' }}
                <span class="font-medium">{{ startIndex }}</span>
                {{ ' ' }}
                to
                {{ ' ' }}
                <span class="font-medium">{{ endIndex }}</span>
                {{ ' ' }}
                of
                {{ ' ' }}
                <span class="font-medium">{{ filteredContacts.length }}</span>
                {{ ' ' }}
                results
              </p>
            </div>
            <div>
              <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                <a href="#"
                @click="goToPreviousPage"
                class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                  <span class="sr-only">Previous</span>
                  <ChevronLeftLogo class="h-5 w-5" aria-hidden="true" />
                </a>
                <a 
                  href="#" 
                  v-for="pageNumber in totalPages"
                  :key="pageNumber"
                  @click="setCurrentPage(pageNumber)"
                  :class="{ 'font-semibold bg-gray-300': currentPage === pageNumber }"
                  class="relative z-10 inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
                >
                  {{ pageNumber }}
                </a>
            
                <a href="#" 
                @click="goToNextPage"
                class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                  <span class="sr-only">Next</span>
                  <ChevronRightLogo class="h-5 w-5" aria-hidden="true" />
                </a>
              </nav>
            </div>
          </div>
        </div>

        </div> -->

        <div class="px-4 sm:px-6 lg:px-8">
          <div class="mt-2 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
              <div class="inline-block min-w-full py-2 align-middle sm:px-4 lg:px-2">
                <div class="sm:rounded-lg">
                  <table class="min-w-full border-none border-separate border-spacing-y-2">
                    <thead class="bg-gray-50">
                      <tr class="p-4">
                        <th scope="col" class="p-4 text-center text-sm font-semibold text-gray-900">Name</th>
                        <th scope="col" class="p-4 text-center text-sm font-semibold text-gray-900">Seller</th>
                        <th scope="col" class="p-4 text-center text-sm font-semibold text-gray-900">Project Details</th>
                        <th scope="col" class="p-4 text-center text-sm font-semibold text-gray-900">Status</th>
                        <th scope="col" class="p-4 text-center text-sm font-semibold text-gray-900">Action</th>
                        <!-- <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                          <span class="sr-only">Edit</span>
                        </th> -->
                      </tr>
                    </thead>
                    <tbody class=" bg-white">
                      <tr 
                      v-for="contact in paginatedContacts" :key="contact.id" 
                      class="text-center hover:outline hover:outline-blue-500/50 rounded-lg border">
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900 w-1/5"> {{ contact.profile.first_name }} {{ contact.profile.last_name }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900 w-1/5"></td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900 flex gap-3 w-1/5">
                          <div class="text-gray-500 text-xs text-right">
                              <p>Project Name:</p>
                              <p class="py-1">Total Contract Price:</p>
                              <p>Phase Block Lot:</p>
                            </div>
                            <div class="font-bold text-xs text-left">
                              <p>Pasinaraw</p>
                              <p class="py-1">₱2,000,000</p>
                              <p>Not yet selected</p>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900 w-1/5">
                          <div class="bg-gray-100 rounded-full h-10 px-6 py-2 text-gray-600 font-semibold">
                            <p>Without Payment</p>
                          </div>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900 w-1/5">
                          <div class="">
                            <a :href="`/contacts/${contact.uid}`">
                            <DefaultSecondaryButton class="hover:bg-rose-500 hover:text-white hover:font-bold">
                              <template #textSecondary>
                                  View Details
                              </template>
                            </DefaultSecondaryButton>
                            </a>
                          </div>
                        </td>
                        <!-- <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                          <a href="#" class="text-indigo-600 hover:text-indigo-900"
                            >Edit<span class="sr-only"></span></a
                          >
                        </td> -->
                      </tr>
                      <!-- <tr class="text-center font-bold">
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900 border-l-2">{{ contact.profile.first_name }} {{ contact.profile.last_name }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900 border-l-2">8%</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900 border-l-2">₱ 207,142.86</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900 border-l-2">₱ 20,714.2</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900 border-l-2">₱ 186,428.57</td>
                      </tr> -->
                    </tbody>
                  </table>
                
                </div>
                <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6 mt-1">
                <div class="flex flex-1 justify-between sm:hidden">
                  <a href="#" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
                  <a href="#" class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
                </div>
                <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                  <div>
                    <p class="text-sm text-gray-700">
                      Showing
                      {{ ' ' }}
                      <span class="font-medium">{{ startIndex }}</span>
                      {{ ' ' }}
                      to
                      {{ ' ' }}
                      <span class="font-medium">{{ endIndex }}</span>
                      {{ ' ' }}
                      of
                      {{ ' ' }}
                      <span class="font-medium">{{ filteredContacts.length }}</span>
                      {{ ' ' }}
                      results
                    </p>
                  </div>
                  <div>
                    <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                      <a href="#"
                      @click="goToPreviousPage"
                      class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                        <span class="sr-only">Previous</span>
                        <ChevronLeftLogo class="h-5 w-5" aria-hidden="true" />
                      </a>
                      <a 
                        href="#" 
                        v-for="pageNumber in totalPages"
                        :key="pageNumber"
                        @click="setCurrentPage(pageNumber)"
                        :class="{ 'font-semibold bg-gray-300': currentPage === pageNumber }"
                        class="relative z-10 inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
                      >
                        {{ pageNumber }}
                      </a>
                  
                      <a href="#" 
                      @click="goToNextPage"
                      class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                        <span class="sr-only">Next</span>
                        <ChevronRightLogo class="h-5 w-5" aria-hidden="true" />
                      </a>
                    </nav>
                  </div>
                </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </template>
      
    </DefaultLayout>
  </AppLayout>
</template>

<style scoped>

</style>