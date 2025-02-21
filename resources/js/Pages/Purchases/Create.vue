<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, Head } from '@inertiajs/vue3';
import { onMounted, reactive, ref, computed } from 'vue'
import InputError from '@/Components/InputError.vue';
import ValidationErrors from '@/Components/ValidationErrors.vue';
import { getToday } from '@/common'
import MicroModal from '@/Components/MicroModal.vue';

const props = defineProps({
    'errors': Object,
    'items': Array
}) 

onMounted(() => {
    form.date = getToday()
    props.items.forEach(item => {
        itemList.value.push({
            id: item.id, name: item.name, price: item.price, quantity: 0
        })
    })
}) 

const setCustomerId = id => { form.customer_id = id } 
const itemList = ref([])
const quantity = [ "0", "1", "2", "3", "4", "5", "6", "7", "8", "9"]

const form = reactive({
    date: null,
    customer_id: null,
    status: true,
    items: []
})

const totalPrice = computed(() => {
    let total = 0
    itemList.value.forEach(item => {
        total += item.price * item.quantity
    })
    return total
}) 


const storePurchase = () => {
    itemList.value.forEach(item => {
        if (item.quantity > 0) // 0より大きいものだけ追加
            form.items.push({ id: item.id, quantity: item.quantity })
    })
    router.post(route('purchases.store'), form)
}
</script>

<template>

    <Head title="購入画面" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">購入画面</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <section class="text-gray-600 body-font relative">
                        <div class="container px-5 py-24 mx-auto">
                            <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                <ValidationErrors :errors="errors" />
                                <form @submit.prevent="storePurchase">
                                    <div class="flex flex-wrap -m-2">
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="date" class="leading-7 text-sm text-gray-600">日付</label>
                                                <input type="date" v-model="form.date" id="date" name="date" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            </div>
                                        </div>
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="customer" class="leading-7 text-sm text-gray-600">顧客氏名</label>
                                                <MicroModal @customerId="setCustomerId" />
                                                <InputError :message="errors.customer_id"/>
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
                                            <button class="flex mx-auto text-white bg-indigo-500 border-0 mt-6 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">
                                                登録する
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
