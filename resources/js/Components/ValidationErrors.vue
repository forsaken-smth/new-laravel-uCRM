<script setup>
import { computed, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
    errors: Object
})

</script>

<template>
    <div v-if="Object.keys(props.errors).length > 0">
        <div class="font-medium text-red-600">問題が発生しました。</div>

        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            <li v-for="error in errors" :key="error.key">{{ error }}</li>
        </ul>
    </div>
</template>