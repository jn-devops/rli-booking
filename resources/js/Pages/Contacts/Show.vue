<script setup>
    const props = defineProps({
        contact: Object,
        products: Object
    })
</script>

<template>
<div>
    <h3>Show Contact</h3> <br>

    {{ props.contact }}

    ***********************************************************

    {{ props.products }}
</div>
</template>

<style scoped>

</style>
