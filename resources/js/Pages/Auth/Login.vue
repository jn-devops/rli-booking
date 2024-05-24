<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import ButtonPrimary from '@/MyComponents/ButtonPrimary.vue';
import AuthenticationLogov2 from '@/MyComponents/AuthenticationLogov2.vue';
import RLICardv2 from '@/MyComponents/RLICardv2.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Log in" />

    <RLICardv2>
        <template #logo>
            <!-- <AuthenticationCardLogo /> -->
            <div class="relative mb-4">
            <img src="../../../img/RaemulanLandsLogo.png" alt="RLI_Logo">
            <!-- <div class="border w-12 rounded-full bg-white shadow absolute bottom-0 -left-12">
                <AuthenticationLogov2  class="h-10 w-12"/>
            </div> -->
           </div>
           <div class="flex items-center justify-center gap-2">
            <img src="https://jn-img.enclaves.ph/Microservices%20Logo/Booking.png?updatedAt=1712900825090" alt="booking_logo"
            class="w-12 h-12"
            >
            <p class="font-semibold text-xl">Booking</p>
           </div>
        </template>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ status }}
        </div>
        <div class="text-center py-4 font-bold text-xl dark:text-white light:text-black">
            <h2>Log in your Account</h2>
        </div>
        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email Address" />
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />
                <TextInput
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="current-password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox v-model:checked="form.remember" name="remember" />
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
                </label>
            </div>
<!-- 
            <div class="flex items-center justify-end mt-4">
                <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                    Forgot your password?
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </PrimaryButton>
            </div> -->

            <div class="mt-4">
                <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                    Forgot your password?
                </Link>
            </div>
            <div class="w-full mt-4 text-center">

                <ButtonPrimary class="text-center w-full dark:text-white light:text-black" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </ButtonPrimary>
            </div>
        </form>
    </RLICardv2>
</template>
