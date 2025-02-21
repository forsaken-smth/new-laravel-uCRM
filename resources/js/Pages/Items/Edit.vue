<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, Head } from '@inertiajs/vue3';
import { reactive } from 'vue'
import InputError from '@/Components/InputError.vue';
import ValidationErrors from '@/Components/ValidationErrors.vue';

const props = defineProps({
    errors: Object,
    item: Object
})

const form = reactive({
    id: props.item.id,
    name: props.item.name,
    memo: props.item.memo,
    price: props.item.price,
    is_selling: props.item.is_selling
})

const updateItem = id => {
 router.put(route('items.update', { item: id }), form)
} 
</script>

<template>
    <Head title="商品編集" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">商品編集</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <section class="text-gray-600 body-font relative">
                        <div class="container px-5 py-24 mx-auto">
                            <div class="lg:w-1/2 md:w-2/3 mx-auto">
                            <ValidationErrors :errors="errors"/>
                            <form @submit.prevent="updateItem(form.id)">
                                <div class="flex flex-wrap -m-2">
                                <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="name" class="leading-7 text-sm text-gray-600">商品名</label>
                                    <input type="text" v-model="form.name" id="name" name="name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    <InputError :message="errors.name"/>
                                </div>
                                </div>
                                <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="memo" class="leading-7 text-sm text-gray-600">メモ</label>
                                    <textarea v-model="form.memo" id="memo" name="memo" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                    <InputError :message="errors.memo"/>
                                </div>
                                </div>
                                <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="price" class="leading-7 text-sm text-gray-600">価格</label>
                                    <input type="number" v-model="form.price" id="price" name="price" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    <InputError :message="errors.price"/>
                                </div>
                                </div>
                                <div class="p-2 w-full">
                                <div class="relative">
                                    <label class="leading-7 mr-4 text-sm text-gray-600">ステータス</label>
                                    <input type="radio" id="is_selling" v-model="form.is_selling" value="1">
                                    <label for="is_selling" class="ml-2 mr-4">販売中</label>
                                    <input type="radio" id="is_notselling" v-model="form.is_selling" value="0">
                                    <label for="is_notselling" class="ml-2 mr-4">停止中</label>
                                </div>
                                <div class="p-2 w-full">
                                <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録する</button>
                                </div>
                                </div>
                                </div>
                            </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
