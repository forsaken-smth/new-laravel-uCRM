<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { reactive } from "vue"
import { router } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue';
import { Core as YubinBangoCore } from "yubinbango-core2";

defineProps({
    errors: Object
})

const form = reactive({
    name: null, kana: null, tel: null, email: null, postcode: null,
    address: null, birthday: null, gender: null, memo: null
})

const storeCustomer = () =>{
    router.post('/customers', form)
}

const fetchAddress = () => {
 new YubinBangoCore(String(form.postcode), (value) => {
    form.address = value.region + value.locality + value.street
 })
}
</script>

<template>
    <Head title="顧客登録" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">顧客登録</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <section class="text-gray-600 body-font relative">
                            <form @submit.prevent="storeCustomer">
                                <div class="container px-5 py-24 mx-auto">
                                    <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                    <div class="flex flex-wrap -m-2">
                                        <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="name" class="leading-7 text-sm text-gray-600">氏名</label>
                                            <input type="text" id="name" name="name" v-model="form.name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            <InputError class="mt-2" :message="errors.name" />
                                        </div>
                                        </div>
                                        <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="kana" class="leading-7 text-sm text-gray-600">カナ</label>
                                            <input type="text" id="kana" name="kana" v-model="form.kana" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            <InputError class="mt-2" :message="errors.kana" />
                                        </div>
                                        </div>
                                        <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="tel" class="leading-7 text-sm text-gray-600">電話番号</label>
                                            <input type="tel" id="tel" name="tel" v-model="form.tel" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            <InputError class="mt-2" :message="errors.tel" />
                                        </div>
                                        </div>
                                        <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="name" class="leading-7 text-sm text-gray-600">メールアドレス</label>
                                            <input type="email" id="email" name="email" v-model="form.email" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            <InputError class="mt-2" :message="errors.email" />
                                        </div>
                                        </div>
                                        <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="postcode" class="leading-7 text-sm text-gray-600">郵便番号</label>
                                            <input type="number" id="postcode" name="postcode" @change="fetchAddress" v-model="form.postcode" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            <InputError class="mt-2" :message="errors.postcode" />
                                        </div>
                                        </div>
                                        <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="address" class="leading-7 text-sm text-gray-600">住所</label>
                                            <input type="text" id="address" name="address" v-model="form.address" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            <InputError class="mt-2" :message="errors.address" />
                                        </div>
                                        </div>
                                        <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="birthday" class="leading-7 text-sm text-gray-600">生年月日</label>
                                            <input type="date" id="birthday" name="birthday" v-model="form.birthday" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            <InputError class="mt-2" :message="errors.birthday" />
                                        </div>
                                        </div>
                                        <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="gender" class="leading-7 text-sm text-gray-600">性別</label>
                                            <label for="male" class="leading-7 ml-4 text-sm text-gray-600">男性</label>
                                            <input type="radio" class="ml-2" id="male" name="male" v-model="form.gender" value="0">
                                            <label for="female" class="leading-7 ml-4 text-sm text-gray-600">女性</label>
                                            <input type="radio" class="ml-2" id="female" name="female" v-model="form.gender" value="1">
                                            <label for="other" class="leading-7 ml-4 text-sm text-gray-600">その他</label>
                                            <input type="radio" class="ml-2" id="other" name="other" v-model="form.gender" value="2">
                                            <InputError class="mt-2" :message="errors.gender" />
                                        </div>
                                        </div>
                                        <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="memo" class="leading-7 text-sm text-gray-600">メモ</label>
                                            <textarea id="memo" name="memo" v-model="form.memo" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                            <InputError class="mt-2" :message="errors.memo" />
                                        </div>
                                        </div>
                                        <div class="p-2 w-full">
                                        <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録する</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>