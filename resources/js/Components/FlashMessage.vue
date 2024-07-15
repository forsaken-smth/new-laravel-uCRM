<script setup>

</script>

<template>
    <div v-if="$page.props.flash.status === 'success'"
    class="bg-blue-300 text-white p-4 font-bold tracking-wider">
        {{ $page.props.flash.message }}
    </div>
    <div v-if="$page.props.flash.status === 'denger'"
    class="bg-red-500 text-white p-4 font-bold tracking-wider">
        {{ $page.props.flash.message }}
    </div>
</template>