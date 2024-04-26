<script setup>
    const props = defineProps({
        contact: Object
    })
</script>

<template>
<div>
    <h3>Edit Contact</h3> <br>

    {{ props.contact }}
</div>
</template>

<style scoped>

</style>