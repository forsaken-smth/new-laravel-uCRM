<script setup>
import { getToday } from '@/common';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { reactive, onMounted } from 'vue';
import Chart from '@/Components/Chart.vue'

onMounted(() => {
    form.startDate = getToday()
    form.endDate = getToday()
})

const form = reactive({
    startDate: null,
    endDate: null,
    type: 'PerDay'
})

const data = reactive({}) 

const getData = async () => {
    try {
        await axios.get('/api/analysis/', {
            params: {
                startDate: form.startDate,
                endDate: form.endDate,
                type: form.type
            }
        }).then( res => {
            data.data = res.data.data
            data.labels = res.data.labels
            data.totals = res.data.totals
            console.log(res.data)
            })
    } catch (e) {
        console.log(e.message)
    }
}
</script>

<template>

    <Head title="データ分析" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">データ分析</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <section class="text-gray-600 body-font">
                        <div class="container px-5 py-10 mx-auto">
                            <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                            <form @submit.prevent="getData">
                                <span>分析方法</span><br>
                                <input type="radio" id="perDay" v-model="form.type" value="PerDay" class="ml-2" checked><label for="perDay" class="ml-2">日別</label>
                                <input type="radio" id="perMonth" v-model="form.type" value="PerMonth" class="ml-2"><label for="perMonth" class="ml-2">月別</label>
                                <input type="radio" id="perYear" v-model="form.type" value="PerYear" class="ml-2"><label for="perYear" class="ml-2">年別</label>
                                <br>

                                <div class="mt-2">
                                    <label>From:</label><input type="date" name="startDate" id="startDate" v-model="form.startDate">
                                    <label>To:</label><input type="date" name="endDate" id="endDate" v-model="form.endDate">
                                </div>
                                <button
                                    class="flex mx-auto text-white bg-indigo-500 border-0 my-4 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">分析する</button>
                            </form>

                            <Chart v-show="data.data" :data="data"/>
                            
                            <table v-show="data.data" class="table-auto w-full text-left whitespace-no-wrap">
                                <thead>
                                    <tr>
                                        <th
                                            class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                                            年月日</th>
                                        <th
                                            class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                            金額
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in data.data" :key="item.date">
                                        <td class="px-4 py-3">{{ item.date }}</td>
                                        <td class="px-4 py-3">{{ item.total }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
