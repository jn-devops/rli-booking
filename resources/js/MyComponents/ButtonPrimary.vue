<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button :type="type" class="px-4 py-3 btn_bgprimary dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 capitalize tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
        <slot />
    </button>
</template>


<style>
.btn_bgprimary{
    /* background: linear-gradient(268deg, #FCB115 7.47%, #CC035C 98.92%); */
    background: linear-gradient(265deg, #FCB115 -39.42%, #CC035C 103.73%)
}
</style>