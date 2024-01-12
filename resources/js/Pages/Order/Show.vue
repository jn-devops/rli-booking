<script setup>

import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Checkbox from '@/Components/Checkbox.vue';

const props = defineProps({
    order: Object,
});

</script>

<template>
    <Head title="RLI Wizard" />

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>
        {{ props.order}}
    </AuthenticationCard>
</template>
