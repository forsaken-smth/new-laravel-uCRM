<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, Head } from '@inertiajs/vue3';
import { onMounted, reactive, ref, computed } from 'vue'
import InputError from '@/Components/InputError.vue';
import ValidationErrors from '@/Components/ValidationErrors.vue';
import dayjs from 'dayjs';

const props = defineProps({
    'errors': Object,
    'items': Array,
    'order': Array
}) 

onMounted(() => {
    console.log(props.items)
    console.log(props.order[0])
    props.items.forEach(item => {
        itemList.value.push({
            id: item.id,
            name: item.name,
            price: item.price,
            quantity: item.quantity
        })
    })
}) 

const itemList = ref([])
const quantity = [ "0", "1", "2", "3", "4", "5", "6", "7", "8", "9"]

const form = reactive({
    id: props.order[0].id,
    date: dayjs(props.order[0].created_at).format('YYYY-MM-DD'),
    customer_id: props.order[0].customer_id,
    status: props.order[0].status,
    items: []
})

const totalPrice = computed(() => {
    let total = 0
    itemList.value.forEach(item => {
        total += item.price * item.quantity
    })
    return total
}) 


const updatePurchase = id => {
    itemList.value.forEach(item => {
        if (item.quantity > 0) // 0より大きいものだけ追加
            form.items.push({ id: item.id, quantity: item.quantity })
    })
    router.put(route('purchases.update', { purchase: id }), form)
}
</script>

<template>

    <Head title="購買履歴 編集画面" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">購買履歴 編集画面</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <section class="text-gray-600 body-font relative">
                        <div class="container px-5 py-24 mx-auto">
                            <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                <ValidationErrors :errors="errors" />
                                <form @submit.prevent="updatePurchase(form.id)">
                                    <div class="flex flex-wrap -m-2">
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="date" class="leading-7 text-sm text-gray-600">日付</label>
                                                <input disabled type="date" :value="form.date" id="date" name="date" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            </div>
                                        </div>
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="customer" class="leading-7 text-sm text-gray-600">顧客氏名</label>
                                                <input disabled type="text"  id="customer" name="customer" :value="props.order[0].customer_name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            </div>
                                        </div>
                                        <table class="table-auto w-full mt-6 text-left whitespace-no-wrap">
                                            <thead>
                                                <tr>
                                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                                                        ID
                                                    </th>
                                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                        商品名
                                                    </th>
                                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                        金額
                                                    </th>
                                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                        数量
                                                    </th>
                                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                        小計
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="item in itemList" :key="item.id">
                                                    <td class="px-4 py-3">{{ item.id }}</td>
                                                    <td class="px-4 py-3">{{ item.name }}</td>
                                                    <td class="px-4 py-3">{{ item.price }}</td>
                                                    <td class="px-4 py-3">
                                                        <select name="quantity" v-model="item.quantity">
                                                            <option v-for="q in quantity" :key="q.id" :value="q">{{ q }}</option>
                                                        </select>
                                                    </td>
                                                    <td class="px-4 py-3">{{ item.price * item.quantity }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="p-2 w-full">
                                            <label for="total" class="leading-7 text-sm text-gray-600">合計金額</label>
                                            <div id="date" name="date" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                {{ totalPrice }}円
                                            </div>
                                        </div>
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label class="leading-7 mr-4 text-sm text-gray-600">ステータス</label>
                                                <input type="radio"  id="true_status" v-model="form.status" name="true_status" value="1">
                                                <label for="true_status" class="ml-2 mr-4">未キャンセル</label>
                                                <input type="radio"  id="false_status" v-model="form.status" name="false_statuss" value="0">
                                                <label for="false_status" class="ml-2 mr-4">キャンセル済み</label>
                                            </div>
                                        </div>
                                        <div class="p-2 w-full">
                                            <button class="flex mx-auto text-white bg-indigo-500 border-0 mt-6 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">
                                                更新する
                                            </button>
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
