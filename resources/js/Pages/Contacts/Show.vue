<script setup>
import CollapsibleDetails from '@/MyComponents/CollapsibleDetails.vue';
import CardLayout from '@/MyComponents/CardLayout.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import DefaultPrimaryButton from '@/MyComponents/DefaultPrimaryButton.vue';
import DefaultSecondaryButton from '@/MyComponents/DefaultSecondaryButton.vue';
import DocumentLogo from '@/MyComponents/DocumentLogo.vue';
import ViewLogo from '@/MyComponents/ViewLogo.vue';
import DownloadLogo from '@/MyComponents/DownloadLogo.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import LotAreaLogo from '@/MyComponents/LotAreaLogo.vue';
import FloorAreaLogo from '@/MyComponents/FloorAreaLogo.vue';
import UnitTypeLogo from '@/MyComponents/UnitTypeLogo.vue';
import ToiletBathLogo from '@/MyComponents/ToiletBathLogo.vue';
import CarparkLogo from '@/MyComponents/CarparkLogo.vue';
import EditLogo from '@/MyComponents/EditLogo.vue';
import DialogModal from '@/Components/DialogModal.vue';
import ContactModalDetails from '@/MyComponents/ContactModalDetails.vue';
import ChevronDownLogo from '@/MyComponents/ChevronDownLogo.vue';
import CustomDropdown from '@/MyComponents/CustomDropdown.vue';
import Dropdown from '@/Components/Dropdown.vue';
import ComisionComputation from '@/MyComponents/ComisionComputation.vue';
import ContactReservationDetails from '@/MyComponents/ContactReservationDetails.vue';
import { ref, watch } from 'vue';

const props = defineProps({
    contact: Object,
    products: Object,
    product: {
        type: Object,
        default:{
            brand: 'Pasinaraw',
            category: 'Pasinaraw, House 1',
            floor_area: 50,
            lot_area: 70,
            name: 'Pasinaraw Duplex House and Lot (Slant Green)',
            price: 2900000,
            processing_fee: 15000,
            sku: 'JN-AGM-CL-HLDUS-PUR',
            type: 'variant',
            unit_type: 'house and lot'
        }
    },
    projects:{
        type: Object,
        default:[
            {
                id: 0,
                project_name: 'Pasinaraw',
                block_lot: 50
            },
            {
                id: 1,
                project_name: 'Pasinaya',
                block_lot: 70
            },
            {
                id: 2,
                project_name: 'Pagsinag',
                block_lot: 60
            }
        ]
    },
    sellerInfo:{
        type: Object,
        default:[
            {
                id: 0,
                seller_code: 'JN-001',
                seller_name: 'John Doe'
            },
            {
                id: 1,
                seller_code: 'JN-002',
                seller_name: 'Jane Doe'
            },
            {
                id: 2,
                seller_code: 'JN-003',
                seller_name: 'Mark Doe'
            },
        ]
    }
})
const collapsed = ref(true);

console.log('contact:', props.contact);
console.log('products:', props.products);
const today = new Date();
const birthDate = new Date(props.contact.profile.date_of_birth);
const age = today.getFullYear() - birthDate.getFullYear();
// console.log('age today: ', age);

// const sellerCode = ref('JN-AGM-1000');
const sellerCode = ref('');


const showModal = ref(null);
const details =ref('');
const openDefaultModal = (parameter) =>{
    showModal.value = !showModal.value;
    details.value = parameter;
    // console.log("parameter: ", parameter);
}


const projectName = ref('Select Project Name');


const chooseProject = (e) =>{
    projectName.value = e.target.value;
    // console.log('project Name: ', projectName.value);
}

const blockLot = ref('Select Block Lot');

console.log('initial block lot:', blockLot.value);
const chooseBlockLot = (e) =>{
    blockLot.value = e.target.value;
    // console.log('block and lot: ', blockLot.value);
}
// console.log('product: ', props.product);
// console.log('projects: ', props.projects);

const selectedOption = ref('');
const isOpen = ref(false);

const options = [
  'Option 1',
  'Option 2',
  'Option 3'
];

const placeholder = 'Select or type option';

function toggleDropdown() {
  isOpen.value = !isOpen.value;
}

function selectOption(option) {
  selectedOption.value = option;
  isOpen.value = false;
}

function handleInput(event) {
  selectedOption.value = event.target.value;
}

const customData = ref('Seller Code');


const toggleDropdown1 = () => {
  open.value = !open.value;
};

const closeDropdown1 = () => {
  open.value = false;
};

let open = ref(false);

const projName = ref('');

const handleProjectName = (newParameter) =>{
     projName.value = newParameter
    // console.log('new ProjectName: ', projName.value);

}
</script>

    <!-- {{ props.contact }} -->
<template>
    
    <div class="">
        <AppLayout class="">
            <div class="mt-4">
                <div class="container mx-auto sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center gap-1">
                        <div class="">
                            <h1 class="font-bold text-3xl">Contact Details</h1>
                            <!-- <p class="mt-3">Please check all the information to make sure it's right before you send it.</p> -->
                            <div class="flex gap-1 mt-2 text-xl">
                                <a href="/contacts" class="font-bold underline underline-offset-4">
                                    Contacts
                                </a> &nbsp;/&nbsp; 
                                <a :href="`/contacts/${contact.id}`" class="text-gray-400">
                                    Details
                                </a>
                            </div>
                        </div>
                        <div class="">
                            <div class="font-semibold text-xl text-center border border-gray-400 rounded-lg py-1 px-6">
                                Reference Code: JN-0921-001
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form>
                <CardLayout class="">
                    <div class="px-8 py-2">
                        <CollapsibleDetails :collapsed="collapsed">
                            <template #title>
                                <p class="font-bold">Personal Details</p>
                            </template>
                            <template #edit>
                                <EditLogo 
                                @click="openDefaultModal('Personal Details')"
                                class="cursor-pointer"/>
                            </template>
                            <div class="grid sm:grid-rows-1 md:grid-cols-2 border-b-2 py-6">
                                    <div class="grid grid-cols-2 gap-2">
                                        <div class="">
                                        <div class="font-bold">
                                            <p>Full Name:</p>
                                            <p>Date of Birth:</p>
                                            <p>Age:</p>
                                            <p>Nationality:</p>
                                        </div>
                                        </div>
                                        <div class="">
                                            <div>
                                                <p>{{contact.profile.first_name}} {{ contact.profile.last_name }}</p>
                                                <p :class="{ 'text-gray-300': !contact.profile.date_of_birth }">{{ contact.profile.date_of_birth || "No Data" }} </p>
                                                <p :class="{ 'text-gray-300': !age }">{{ age || "No Data" }} </p>
                                                <p :class="{ 'text-gray-300': !contact.profile.nationality }">{{ contact.profile.nationality || "No Data" }} </p>
                                            </div>
                                        </div>
                                    </div>
                                        <div class="grid grid-cols-2 gap-2">
                                        <div class="">
                                        <div class="font-bold">
                                            <p>Gender:</p>
                                            <p>Civil Status:</p>
                                            <p>Email Address:</p>
                                            <p>Mobile Number:</p>
                                        </div>
                                        </div>
                                        <div class="">
                                            <div>
                                                <p :class="{ 'text-gray-300': !contact.profile.sex }">{{ contact.profile.sex || "No Data" }}</p>
                                                <p :class="{ 'text-gray-300': !contact.profile.civil_status }">{{ contact.profile.civil_status || "No Data" }}</p>
                                                <p :class="{ 'text-gray-300': !contact.profile.email }">{{ contact.profile.email || "No Data" }}</p>
                                                <p :class="{ 'text-gray-300': !contact.profile.mobile }">{{ contact.profile.mobile || "No Data" }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid sm:grid-rows-1 md:grid-cols-2 py-2">
                                    <div class="grid grid-cols-2 gap-2">
                                        <div class="grid content-start">
                                        <div class="font-bold">
                                            <p>Address Type:</p>
                                            <p class="mt-1">Full Address:</p>
                                            <!-- <p class="mt-1">House No. / Unit No./Street Address :</p> -->
                                            <!-- <p>Barangay:</p> -->
                                            <!-- <p>City/Municipality:</p> -->
                                            <!-- <p>Province:</p> -->
                                            <!-- <p>Other Location Details(Landmark, House No., Etc.):</p> -->
                                            <p>Country:</p>
                                            <p>City:</p>
                                            <p>Postal Code:</p>
                                        </div>
                                        </div>
                                        <div class=" grid content-start">
                                            <div>
                                                <p>Primary</p>
                                                <p class="text-sm" :class="{ 'text-gray-300': !contact.addresses[0].address1 }">{{ contact.addresses[0].address1 || "No Data" }}</p>
                                                <!-- <p :class="{ 'text-gray-300': !contact.addresses[0].block }">{{ contact.addresses[0].block || "No Data" }}</p> -->
                                                <!-- <p :class="{ 'text-gray-300': !contact.addresses[0].barangay }">{{ contact.addresses[0].barangay || "No Data" }}</p> -->
                                                <!-- <p :class="{ 'text-gray-300': !contact.addresses[0].city }">{{ contact.addresses[0].city || "No Data" }}</p> -->
                                                <p class="text-sm" :class="{ 'text-gray-300': !contact.addresses[0].country }">{{ contact.addresses[0].country || "No Data" }}</p>
                                                <p class="text-sm" :class="{ 'text-gray-300': !contact.addresses[0].locality }">{{ contact.addresses[0].locality || "No Data" }}</p>
                                                <p class="text-sm" :class="{ 'text-gray-300': !contact.addresses[0].postal_code }">{{ contact.addresses[0].postal_code || "No Data" }}</p>
                                                <!-- <p :class="{ 'text-gray-300': !contact.addresses[0].province }">{{ contact.addresses[0].province || "No Data" }}</p> -->
                                                <!-- <p :class="{ 'text-gray-300': !contact.addresses[0].other }">{{ contact.addresses[0].other || "No Data" }}</p> -->
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div class="grid content-start">
                                        <div class="font-bold">
                                            <p>Address Type:</p>
                                            <p class="mt-1">Full Address:</p>
                                            <p>Country:</p>
                                            <p>City:</p>
                                            <p>Postal Code:</p>
                                            <!-- <p class="mt-1">House No. / Unit No./Street Address :</p> -->
                                            <!-- <p>Barangay:</p> -->
                                            <!-- <p>City/Municipality:</p>
                                            <p>Province:</p>
                                            <p>Other Location Details(Landmark, House No., Etc.):</p> -->
                                        </div>
                                        </div>
                                        <div class=" grid content-start">
                                            <div>
                                                <p>Secondary</p>
                                                <p class="text-sm":class="{ 'text-gray-300': !contact.addresses[1].address1 }">{{ contact.addresses[1].address1 || "No Data" }}</p>
                                                <!-- <p :class="{ 'text-gray-300': !contact.addresses[1].block }">{{ contact.addresses[1].block || "No Data" }}</p> -->
                                                <!-- <p :class="{ 'text-gray-300': !contact.addresses[1].barangay }">{{ contact.addresses[1].barangay || "No Data" }}</p> -->
                                                <!-- <p :class="{ 'text-gray-300': !contact.addresses[1].city }">{{ contact.addresses[1].city || "No Data" }}</p> -->
                                                <!-- <p :class="{ 'text-gray-300': !contact.addresses[1].province }">{{ contact.addresses[1].province || "No Data" }}</p> -->
                                                <!-- <p :class="{ 'text-gray-300': !contact.addresses[1].other }">{{ contact.addresses[1].other || "No Data" }}</p> -->
                                                <p class="text-sm" :class="{ 'text-gray-300': !contact.addresses[1].country }">{{ contact.addresses[1].country || "No Data" }}</p>
                                                <p class="text-sm" :class="{ 'text-gray-300': !contact.addresses[1].locality }">{{ contact.addresses[1].locality || "No Data" }}</p>
                                                <p class="text-sm" :class="{ 'text-gray-300': !contact.addresses[1].postal_code }">{{ contact.addresses[1].postal_code || "No Data" }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </CollapsibleDetails>
                    </div>
                </CardLayout>
                <CardLayout>
                    <div class="px-8 py-2">
                        <CollapsibleDetails>
                            <template #title>
                                <p class="font-bold">Employment Information</p>
                            </template>
                            <template #edit>
                                <EditLogo 
                                @click="openDefaultModal('Employment Information')"
                                class="cursor-pointer"/>
                            </template>
                            <div class="grid sm:grid-rows-1 md:grid-cols-2 py-6">
                                    <div class="grid grid-cols-2 gap-2">
                                        <div class="">
                                        <div class="font-bold">
                                            <p>Employment Status:</p>
                                            <p>Work Industry</p>
                                            <p>Gross Income</p>
                                            <p>Nationality</p>
                                            <p>Employment Type:</p>
                                            <p>Current Position:</p>
                                            <p>Employer Name:</p>
                                            <p>Employer Contact Number:</p>
                                            <!-- <p>Employer Address:</p>
                                            <p>Tax Identification Number:</p>
                                            <p>PAG-IBIG Number:</p>
                                            <p>SSS/GSIS Number:</p> -->
                                        </div>
                                        </div>
                                        <div class="">
                                            <div>
                                                <p :class="{ 'text-gray-300': !contact.employment.employment_status}">{{ contact.employment.employment_status.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ') || "No Data" }}</p>
                                                <p :class="{ 'text-gray-300': !contact.employment.employer.industry}">{{ contact.employment.employer.industry || "No Data" }}</p>
                                                <p :class="{ 'text-gray-300': !contact.employment.monthly_gross_income}">{{ contact.employment.monthly_gross_income.toLocaleString() || "No Data" }}</p>
                                                <p :class="{ 'text-gray-300': !contact.employment.employer.nationality}">{{ contact.employment.employer.nationality || "No Data" }}</p>
                                                <p :class="{ 'text-gray-300': !contact.employment.employment_type}">{{ contact.employment.employment_type.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ') || "No Data" }}</p>
                                                <p :class="{ 'text-gray-300': !contact.employment.current_position}">{{ contact.employment.current_position || "No Data" }}</p>
                                                <p :class="{ 'text-gray-300': !contact.employment.employer.name}">{{ contact.employment.employer.name || "No Data" }}</p>
                                                <p :class="{ 'text-gray-300': !contact.employment.employer.contact_no}">{{ contact.employment.employer.contact_no || "No Data" }}</p>
                                            </div>
                                        </div>
                                    </div>
                                        <div class="grid grid-cols-2 gap-2">
                                        <div class="">
                                        <div class="font-bold">
                                             <p>Employer Address</p>
                                            <!-- <p>Blk and lot / unit #:</p> -->
                                            <!-- <p>Street address line 2:</p> -->
                                            <p>City:</p>
                                            <!-- <p>State / province:</p> -->
                                            <p>Postal code / Zip code:</p>
                                            <p>Tax identification number:</p>
                                            <p>PAG-IBIG number:</p>
                                            <p>SSS / GSIS number:</p>
                                        </div>
                                        </div>
                                        <div class="">
                                            <div>
                                                <p :class="{ 'text-gray-300': !contact.employment.employer.address.address1}">{{ contact.employment.employer.address.address1 || "No Data" }}</p>
                                                <!-- <p :class="{ 'text-gray-300': !contact.employment.block_lot}">{{ contact.employment.block_lot || "No Data" }}</p> -->
                                                <!-- <p :class="{ 'text-gray-300': !contact.employment.street_line2}">{{ contact.employment.street_line2 || "No Data" }}</p> -->
                                                <p :class="{ 'text-gray-300': !contact.employment.employer.address.locality}">{{ contact.employment.employer.address.locality || "No Data" }}</p>
                                                <!-- <p :class="{ 'text-gray-300': !contact.employment.province}">{{ contact.employment.province || "No Data" }}</p> -->
                                                <p :class="{ 'text-gray-300': !contact.employment.employer.address.postal_code}">{{ contact.employment.employer.address.postal_code || "No Data" }}</p>
                                                <p :class="{ 'text-gray-300': !contact.employment.id.tin}">{{ contact.employment.id.tin || "No Data" }}</p>
                                                <p :class="{ 'text-gray-300': !contact.employment.id.pagibig}">{{ contact.employment.id.pagibig || "No Data" }}</p>
                                                <p :class="{ 'text-gray-300': !contact.employment.id.sss && !contact.employment.id.gsis}">{{ `${contact.employment.id.sss} / ${contact.employment.id.gsis}` || "No Data" }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </CollapsibleDetails>
                    </div>
                </CardLayout>
                <CardLayout>
                    <div class="px-8 py-2">
                        <CollapsibleDetails>
                            <template #title>
                                <p class="font-bold">Attachment</p>
                            </template>
                            <template #edit>
                                <EditLogo 
                                @click="openDefaultModal('Attachment')"
                                class="cursor-pointer"/>
                            </template>
                            <div class="grid grid-rows-1 border-t-2 py-6">
                                    <div class="w-full">
                                        <div class="">
                                            <div class="font-bold flex items-center justify-between">
                                                <!-- <p>Payslip:</p> -->
                                                <div class="flex items-center">
                                                    <DocumentLogo /> &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <p :class="{ 'text-gray-300': !contact.employment.payslip}">{{ contact.employment.payslip || "No Data" }}</p>
                                                </div>
                                                <div class="flex items-center gap-4">
                                                    <a href="#">
                                                        <ViewLogo />
                                                    </a>
                                                    <a href="#">
                                                        <DownloadLogo />
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 py-2">
                                    <div class="grid grid-rows-1 gap-2">
                                        <div class="grid content-start mt-2">
                                            <div class="font-bold">
                                                <p>Identification:</p>
                                            <img src="../../../img/sample_id.png" class="h-56" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-rows-1 gap-2">
                                        <div class="grid content-start mt-2">
                                            <div class="font-bold">
                                                <p>Selfie:</p>
                                               <img src="../../../img/sample_selfie.png" class="h-52"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </CollapsibleDetails>
                    </div>
                </CardLayout>
                <CardLayout class="relative">
                    <div class="px-8 py-2">
                        <CollapsibleDetails class="">
                            <template #title>
                                <p class="font-bold">Reservation</p>
                            </template>
                            <!-- <template #edit>
                                <EditLogo 
                                @click="openDefaultModal('Reservation')"
                                class="cursor-pointer"/>
                            </template> -->
                            <template #contentDropdown>
                                <ContactReservationDetails 
                                :products="products" 
                                :projectName="projectName"
                                @projectName="handleProjectName" 
                                :sellerInfo="sellerInfo"
                                />
                            </template>
                        </CollapsibleDetails>
                    </div>
                </CardLayout>
                <!-- <CardLayout>
                    <div class="px-8 py-2">
                        <CollapsibleDetails>
                            <template #title>
                                <p class="font-bold">Commission Computation</p>
                            </template>
                            <div class="w-full pb-4">
                                <ComisionComputation />
                            </div>
                        </CollapsibleDetails>
                    </div>
                </CardLayout> -->
                <div class="container px-8 mx-auto text-right pb-3">
                    <DefaultPrimaryButton>
                        <template #text>
                            Save & Continue
                        </template>
                    </DefaultPrimaryButton>
                </div>
            </form>
        </AppLayout>
    </div>
    <DialogModal :show="showModal" @close="openDefaultModal">
        <template #title>
        <div class="flex items-start gap-3 justify-between py-4">
            <div class="">
                <h1 class="text-3xl font-bold">{{ details}}</h1>
                <p class="mt-2 text-md font-normal">Fill-out all the fields</p>
            </div>
            <div class="text-1xl text-gray-400 bg-gray-50 rounded-full px-2">
                <button @click="openDefaultModal" class="bg_cursor text-xl">&times;</button>
            </div>
        </div>
        </template>
        <template #content>
            <ContactModalDetails :details="details" />
        </template>
        <template #footer>
            <div class="flex gap-3">
                <DefaultSecondaryButton @click="openDefaultModal" class="hover:bg-rose-500 hover:text-white">
                    <template #textSecondary>
                        Cancel
                    </template>
                </DefaultSecondaryButton>
                <DefaultPrimaryButton>
                    <template #text>
                        Save & Continue
                    </template>
                </DefaultPrimaryButton>


    <!-- {{ props.products }} -->
            </div>
        </template>
    </DialogModal>
</template>

<style>
.bg_cursor{
    color: #CC035C;
}

/* .bg_layout{
    background: url('../../img/BGLayout.png') center no-repeat ;
    background-size: cover;
    z-index: 1;
} */
</style>
