<script setup>
import AddressIcon from '@/Components/AddressIcon.vue';
import ContactIcon from '@/Components/ContactIcon.vue';
import DownloadIcon from '@/Components/DownloadIcon.vue';
import EmalIcon from '@/Components/EmalIcon.vue';
import ShareIcon from '@/Components/ShareIcon.vue';
import CheckBillingIcon from '@/Components/CheckBillingIcon.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const modalActive = ref(true);
const toggleModal = () =>{
    modalActive.value = !modalActive.value;
}

</script>
<template>
      <Head title="Billing Statement" />
     <!-- <div class="bg-red-100 footer">
        <h1>Sample waves</h1>
        <p>asdasasdasdasdd</p>
      
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
       
        <linearGradient id="myGradient" x1="0%" y1="0%" x2="100%" y2="0%">
        <stop offset="23.87%" style="stop-color: #CC035C" />
        <stop offset="94.16%" style="stop-color: #FCB115" />
        </linearGradient>

       
        <path fill="url(#myGradient)" fill-opacity="1" d="M0,96L120,90.7C240,85,480,75,720,69.3C960,64,1200,64,1320,64L1440,64L1440,320L1320,320C1200,320,960,320,720,320C480,320,240,320,120,320L0,320Z"></path>
        </svg>
    </div> -->

    <div class="bg-gray-50 h-max">
        <!-- Desktop -->
        <div class="hidden md:grid lg:grid md:grid-rows-1 lg:grid-cols-3">   
            <div class="lg:col-span-1">
                <div class="mt-10 text-center mx-auto w-full">
                    <img src="../../img/RaemulanLandsLogo.png" alt="" class="mx-auto">
                </div>
                <div class="bg_custom-img md:hidden lg:block">
                    <!-- <img src="../../img/ImageStatementpng.png" alt="" class="mx-auto w-full"> -->
                </div>
            </div>
             <!--end:: 1st column -->
            <div class="lg:col-span-2 px-4">
                <div class="bg-white lg:mt-10 max-w-screen-lg dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg p-6 layout_content">
                   <div class="grid grid-cols-2 my-3">
                        <div class="">
                            <h1 class="font-bold text-3xl">Billing Statement</h1>
                        </div>
                        <div class="grid grid-cols-3 gap-3 sm:mt-2">
                            <div class="col-span-2">
                                <p class="text-sm md:text-right sm:text-left">Billing Date: Jan 25, 2023</p>
                                <p class="text-sm md:text-right sm:text-left">Due Date: Feb 1, 2023</p>
                            </div>
                            <div class="col-span-1">
                                <div class="grid grid-cols-2  place-content-center justify-items-center">
                                    <div>
                                        <DownloadIcon class="place-self-center w-18 h-10"/>
                                    </div>
                                    <div>
                                        <ShareIcon class="place-self-center w-18 h-10"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                   </div>

                   <div class="grid sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 my-3">
                        <div class="py-4">
                            <div>
                                <p>Property Details</p>
                            </div>
                            <div>
                                <p class="font-bold">Zaya Studio Condominium Standard Inner Unit</p>
                            </div>
                            <div>
                                <p class="font-bold">Reservation Code: <span class="font-normal">JN-B011FB</span></p>
                            </div>
                            <div>
                                <p class="font-bold">Location: <span class="font-normal">Brgy. Balibago, Sta. Rosa City, Laguna</span></p>
                            </div>
                            <div>
                                <p class="font-bold text-primary_color">TCP: ₱2,309,987.00</p>
                            </div>
                        </div>
                        <div class="py-4">
                            <div>
                                <p>Bill To:</p>
                            </div>
                            <div>
                                <p class="font-bold">Name: <span class="font-normal">Charles Ley Baldemor</span></p>
                            </div>
                            <div>
                                <p class="font-bold">Reference Number: <span class="font-normal">123-233</span></p>
                            </div>
                            <div>
                                <p class="font-bold">Mode of Payment: <span class="font-normal">E-wallet - GCash</span></p>
                            </div>
                        </div>
                   </div>
                   <!--  -->
                   <div class="py-2">
                        <p>Reservation Fee:</p>
                        <p class="font-bold text-primary_color text-5xl">₱10,000.00</p>
                   </div>

                   <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="">
                            <div class="mx-auto">
                                <img src="../../img/Qrpng.png" alt="" class="w-full">
                            </div>
                            <div class="bg-orange-300 w-32 h-10  text-center grid self-center mx-auto rounded">
                                <button class="text-primary_color">Pay Now</button>
                            </div>
                        </div>
                        <!--end:: 1st column  -->
                        <div class="col-span-2 grid grid-rows-span-3">
                            <!-- <div class="grid"> -->
                                <div class="self-center">
                                    <p>Heres how to pay</p>
                                    <p class="font-bold">Scan the QRCode to pay the reservation fee</p>
                                </div>

                                <div class="bg-gray-100 rounded p-4 self-start row-span-2">
                                    <p>Kindly ensure settlement within 5 working days to avoid cancellation of your reservation.</p>
                                </div>
                            <!-- </div> -->
                            
                        </div>
                        <!--end:: 2nd column  -->
                   </div>
                </div>
            </div>
             <!--end:: 2nd column -->
        </div>
        <!-- Mobile -->
        <div class="grid md:hidden lg:hidden grid-rows-1 p-4 gap-3">
            <div class="grid grid-cols-3 mb-3">
                <div class="col-span-1 col-start-1">
                    <img src="../../img/RaemulanLandsLogo.png" alt="">
                </div>
                <div class="col-span-2 grid justify-items-end">
                    <div class="grid grid-cols-2 items-center gap-3 p-2">
                        <DownloadIcon  class="p-1"/>
                        <ShareIcon  class="p-1"/>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <div>
                    <h1 class="font-bold text-2xl mb-1">Billing Statement</h1>
                    <p class="font-bold">Billing Date: <span class="font-normal">{Jan 25,2024}</span></p>
                    <p class="font-bold">Due Date: <span class="font-normal">{Feb 01,2024}</span></p>
                </div>

                <div class="my-3">
                    <h1 class="text-1xl mb-1">Property Details</h1>
                    <p class="font-bold">{Zaya Studio Condominium Standard Inner Unit}</p>
                    <p class="font-bold">Reservation Code: <span class="font-normal">{JN-B011FB}</span></p>
                    <p class="font-bold">Location: <span class="font-normal">{Brgy. Balibago, Sta. Rosa City, Laguna}</span></p>
                    <p class="font-bold text-primary_color mt-2">{TCP: ₱2,309,987.00}</p>
                </div>
            </div>

            <div class="mt-3">
                <div>
                    <h1 class="text-1xl mb-1">Bill To:</h1>
                    <p class="font-bold">Name: <span class="font-normal">{Charles Ley Baldemor}</span></p>
                    <p class="font-bold">Reference Number: <span class="font-normal">{123}</span></p>
                    <p class="font-bold">Mode of Payment: <span class="font-normal">{E-wallet - Gcash}</span></p>
                </div>
            </div>

            <div class="mt-3">
                <div>
                    <h1 class="text-1xl mb-1">Reservation Fee:</h1>
                    <p class="text-3xl text-primary_color font-bold">₱10,000.00</p>
                </div>
            </div>

            <div class="grid grid-cols-2 mt-3">
                <div class="p-4 text-center">
                    <img src="../../img/QRpng.png" alt="">
                    <button class="text-1xl px-4 py-2 border bg-orange-300 mt-2 rounded text-primary_color"> Pay Now</button>
                </div>
                <div class="self-center">
                   <div class="mb-3">
                        <h1>Here’s how to pay</h1>
                        <p class="font-bold">Scan the QRCode to pay the reservation fee</p>
                   </div>
                    <div class="bg-gray-200 p-2">
                        <p>Kindly ensure settlement within 5 working days to avoid cancellation of your reservation.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Desktop Footer-->
    <div class="bg-gray-100 footer overflow-hidden  relative w-full hidden md:block">
        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="402" viewBox="0 0 1728 402" fill="none">
            <path d="M-32.0001 67.2682C167.5 191.768 1281.91 -59.1719 1794.65 14.4577L1809.96 175.172L1743 604.268L772.5 604.268L-44.5001 638.768C-80.1504 582.17 -156.999 -10.7386 -32.0001 67.2682Z" fill="url(#paint0_linear_43_780)"/>
            <defs>
                <linearGradient id="paint0_linear_43_780" x1="393.528" y1="664.648" x2="1726.75" y2="80.2366" gradientUnits="userSpaceOnUse">
                <stop stop-color="#CC035C"/>
                <stop offset="1" stop-color="#FCB115"/>
                </linearGradient>
            </defs>
        </svg>

        <div class="content">
          <div class=" grid grid-cols-4 p-6 md:mt-12">
            <div class="">
                
            </div>
            <div class="col-span-3">
                <p>Customer Support</p>
                <div class="grid grid-cols-3 gap-4">
                    <div class="flex gap-3 justify-center">
                        <AddressIcon />
                        <p>7 ADB Ave, Ortigas Center, Pasig, Metro Manila</p>
                    </div>
                    <div class="flex gap-3 justify-center">
                        <EmalIcon />
                        <p>sample@email.com</p>
                    </div>
                    <div class="flex gap-3 justify-center">
                        <ContactIcon />
                        <p>+63 9456677654</p>
                    </div>
                </div>
               <!-- <div class="grid grid-cols-4">
                    <div class="col-span-2 flex">
                        
                        <div>
                            <AddressIcon />
                        </div>
                        <p>7 ADB Ave, Ortigas Center, Pasig, Metro Manila</p>
                       
                    </div>
                    <div>
                        <p>sample@email.com</p>
                    </div>
                    <div>
                        <p>+63 9456677654</p>
                    </div>
               </div> -->
               <div>
                
               </div>
            </div>
            <div class=""></div>
          </div>
        </div>
</div>
    <!-- Mobile Footer -->
    <div class="grid md:hidden lg:hidden bg_custom-footer p-4 text-white">
        <div class="px-6 py-3 row-span-2 relative footer_content overflow-hidden">
            <div class="content-container">
                <h1 class="text-xl mb-2">Customer Support</h1>
                <div class="flex items-center gap-2 py-1">
                    <div class="flex gap-2">
                        <AddressIcon class=""/>
                        <div class="">
                            <p>7 ADB Ave, Ortigas Center, Pasig, 
                            <br />Metro Manila</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-2 py-1">
                    <EmalIcon />
                    <p class="text-md">sample@email.com</p>
                </div>
                <div class="flex items-center gap-2 py-1">
                    <ContactIcon />
                    <p class="text-md">+63 9456677654</p>
                </div>
            </div>
            
        </div>
    </div>
    <!-- Modal -->
   <div
   v-show="modalActive"
    class="fixed inset-0 bg-black bg-opacity-30 top-0 left-0 flex justify-center p-8 z-10 ">
        <div
        v-if="modalActive" 
        class="p-4 bg-white self-start mt-32 max-w-screen-md rounded overflow-hidden">
            <div class="w-full p-4">
                <CheckBillingIcon class=" mx-auto"/>
            </div>
            <div class="text-center p-4">
                <p class="sm:text-2xl font-bold">We have successfully generated a Billing Statement for you. </p>
            </div>
            <div class="text-center p-4">
                <p><p class="sm:text-2xl font-bold">Kindly ensure settlement within 5 calendar days to avoid cancellation of your reservation.</p></p>
            </div>
            <div class="text-center p-4">
                <button @click="toggleModal" class="bg_rli-primary btnCheckBilling p-4 rounded text-white">Check Billing Statement</button>
            </div>
        </div>
   </div>
</template>


<style>
.bg_rli-primary{
    background: linear-gradient(268deg, #FCB115 7.47%, #CC035C 98.92%);
}
/* .btnCheckBilling{
    p
} */
 .footer {
  position: relative;
  /* top: -80px;
  overflow-y: hidden;
  height: 100%; */
}

/* svg {
  position: relative;
}

.content {
  position: absolute;
  z-index: 0;
  top: 0;
  left: 0;
  width: 100%;
} */
.text-primary_color{
    color: #CC035C;
}
.bg_custom-img{
   /* Set the background image */
   background: url("../../img/ImageStatementpng.png") no-repeat;
    /* padding: 20px; */
    background-size: cover;
    height: 78vh;
    position: relative;
    left: 5%;
    bottom: -90px;
    z-index: 5;
 
    
}

.layout_content{
    position: relative;
    z-index: 4;
    /* left: -30px; */
    bottom: -90px;
}
.content{
    position: relative;
    /* top: -100px; */
    z-index: 2;
    color: #fff;
    padding: 10% 0 5% 0;
}
.footer > svg{
    position: absolute;
    z-index: 1;
}
.bg_custom-footer{
    background: linear-gradient(268deg, #FCB115 7.47%, #CC035C 98.92%);
}
.footer_content {
    position: relative;
    overflow: hidden;
}
.footer_content::before{
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url('../../img/ImageStatementpng.png');
    background-position: center;
    background-size: cover;
    opacity: 0.5; /* Adjust the opacity as needed */
    z-index: -1; /* Send the pseudo-element to the background */

}
.content-container {
    z-index: 1; /* Bring the content to the foreground */
    position: relative; /* Ensure the content is positioned relative to the container */
    color: white; /* Set text color as needed */
}
@media  screen and(min-width: 640px) {
        .bg_custom-img{
            display: none !important;
        }
        .layout_content{
        left: 0 !important; 
    }
}
@media  screen and(min-width: 768px){
    .layout_content{
        left: 0 !important; 
    }
}
</style>