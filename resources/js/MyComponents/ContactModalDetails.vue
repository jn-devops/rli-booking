<script setup>

const props = defineProps({
    details: String
})
</script>
<template>
    <div v-if="details === 'Personal Details'">
        <p>{{ details }}</p>
    </div>
    <div v-else-if="details === 'Employment Information'">
        <p>{{ details }}</p>
    </div>
    <div v-else-if="details === 'Attachment'">
        <p>{{ details }}</p>
    </div>
    <div v-else>
        <p>{{ details }}</p>
    </div>
</template>