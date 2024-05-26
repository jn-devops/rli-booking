<script setup>
import { ref } from 'vue';
    const comissions = ref([
    {
    id: 1,
    name: 'Maria Teresa',
    code: '002942', 
    rate: 2,
    gross: '51,785.71',
    withholding: '51,785.71',
    net: '46,607.14' 
    },
    {
    id: 2,
    name: 'Flor Esteban', 
    code: '002942', 
    rate: 4,
    gross: '103,571.43',
    withholding: '10,357.14',
    net: '93,214.29' 
    },
    {
    id: 3,        
    name: 'Bento Gento', 
    code: '002942', 
    rate: 3,
    gross: '51,785.71',
    withholding: '5,178.57',
    net: '46,607.14'
    },
    ]);
    // console.log('comission:' , comission.value)
</script>
<template>
<div class="px-4 sm:px-6 lg:px-8">
    <div class="mt-8 flow-root">
      <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-4 lg:px-2">
          <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-3 py-3.5 text-center border-l-2 text-sm font-semibold text-gray-900">Seller Name</th>
                  <th scope="col" class="px-3 py-3.5 text-center border-l-2 text-sm font-semibold text-gray-900">Comission <br />Rate(Percentage)</th>
                  <th scope="col" class="px-3 py-3.5 text-center border-l-2 text-sm font-semibold text-gray-900">Gross Comission</th>
                  <th scope="col" class="px-3 py-3.5 text-center border-l-2 text-sm font-semibold text-gray-900">Witholding Tax</th>
                  <th scope="col" class="px-3 py-3.5 text-center border-l-2 text-sm font-semibold text-gray-900">Net Comission</th>
                  <!-- <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                    <span class="sr-only">Edit</span>
                  </th> -->
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white">
                <tr 
                v-for="comission in comissions" :key="comission.id"
                class="text-center">
                  <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-900 border-l-2 sm:pl-6">
                    <div class="flex flex-col">
                        <p class="font-semibold text-lg">{{ comission.name }}</p>
                        <p class="text-gray-400">Code: {{ comission.code }}</p>
                    </div>
                  </td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900 border-l-2"> {{ comission.rate }}</td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900 border-l-2">{{ comission.gross }}</td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900 border-l-2">{{ comission.withholding }}</td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900 border-l-2">{{ comission.net }}</td>
                  <!-- <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                    <a href="#" class="text-indigo-600 hover:text-indigo-900"
                      >Edit<span class="sr-only"></span></a
                    >
                  </td> -->
                </tr>
                <tr class="text-center font-bold">
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900 border-l-2">Total:</td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900 border-l-2">8%</td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900 border-l-2">₱ 207,142.86</td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900 border-l-2">₱ 20,714.2</td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900 border-l-2">₱ 186,428.57</td>
                </tr>
              </tbody>
            </table>
          
          </div>
        </div>
      </div>
    </div>
  </div>
</template>