<script setup>
    const props = defineProps({
        contact: Object
    })
</script>

<template>
<div>
    <h3>Show Contact</h3> <br>

    {{ props.contact }}
</div>
</template>

<style scoped>

</style>