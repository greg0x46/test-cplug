<template>
    <app-layout>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Resumo Operação Cripto
                </h2>

                <div class="mt-5 md:mt-0 p-4 md:col-span-2 border-solid border-4">
                    <form @submit.prevent="submit">
                        <div class="col-span-6 sm:col-span-4 m-5">
                            <label class="block font-medium text-sm text-gray-700">
                                <span>Moeda</span>
                            </label>

                            <select
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full mt-1"
                                v-model="form.coin"
                            >
                                <option v-for="coin in coins" :value="coin" v-bind:value="coin">{{ coin }}</option>
                            </select>
                            <div v-if="formErrors.coin"><p class="text-sm text-red-600">{{ formErrors.coin }}</p>
                            </div>
                        </div>

                        <div class="col-span-6 sm:col-span-4 m-5">
                            <label class="block font-medium text-sm text-gray-700">
                                <span>Quantidade</span>
                            </label>
                            <input required
                                   class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full mt-1"
                                   v-model="form.quantidade" step=".000001" type="number">
                            <div v-if="formErrors.quantidade"><p class="text-sm text-red-600">{{
                                    formErrors.quantidade
                                }}</p></div>
                        </div>

                        <div class="col-span-6 sm:col-span-4 m-5">
                            <label class="block font-medium text-sm text-gray-700">
                                <span>Data de Compra</span>
                            </label>
                            <input required
                                   class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full mt-1"
                                   v-model="form.dataCompra" type="date">
                            <div v-if="formErrors.dataCompra"><p class="text-sm text-red-600">{{
                                    formErrors.dataCompra
                                }}</p></div>
                        </div>

                        <div class="col-span-6 sm:col-span-4 m-5">
                            <label class="block font-medium text-sm text-gray-700">
                                <span>Data de Venda</span>
                            </label>
                            <input required
                                   class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full mt-1"
                                   v-model="form.dataVenda" type="date">
                            <div v-if="formErrors.dataVenda"><p class="text-sm text-red-600">{{
                                    formErrors.dataVenda
                                }}</p></div>
                        </div>

                        <div
                            class="flex items-center justify-end px-4 py-3 text-right sm:px-6">
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                                Enviar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8" v-if="form.result">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Resultado
                </h2>

                <div class="mt-5 md:mt-0 md:col-span-2 border-solid border-4">
                    <div class="col-span-6 sm:col-span-4 m-5">
                        <label class="block font-medium text-sm text-gray-700">
                            <span>Valor da Compra</span>
                        </label>
                        <span><strong>R$ {{ form.result.valor_da_compra }}</strong></span>
                    </div>

                    <div class="col-span-6 sm:col-span-4 m-5">
                        <label class="block font-medium text-sm text-gray-700">
                            <span>Valor da Venda</span>
                        </label>
                        <span><strong>R$ {{ form.result.valor_da_venda }}</strong></span>
                    </div>

                    <div class="col-span-6 sm:col-span-4 m-5">
                        <label class="block font-medium text-sm text-gray-700">
                            <span>Lucro</span>
                        </label>
                        <span><strong>R$ {{ form.result.lucro }}</strong></span>
                    </div>

                    <div class="col-span-6 sm:col-span-4 m-5">
                        <label class="block font-medium text-sm text-gray-700">
                            <span>Lucro Percentual</span>
                        </label>
                        <span><strong>{{ form.result.lucro_percentual }} %</strong></span>
                    </div>

                    <div class="col-span-6 sm:col-span-4 m-5">
                        <label class="block font-medium text-sm text-gray-700">
                            <span>Intervalo em Dias</span>
                        </label>
                        <span><strong>{{ form.result.intervalo_em_dias }}</strong></span>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import {defineComponent} from 'vue'
import AppLayout from "../Layouts/AppLayout";

export default defineComponent({
    components: {
        AppLayout
    },
    data() {
        return {
            form: {
                coin: null,
                dataCompra: null,
                dataVenda: null,
            },
            formErrors: {},
            coins: [
                "BCH", "BTC", "CAIFT", "CHZ", "ETH", "GALFT", "IMOB01", "JUVFT", "LINK", "LTC", "OGFT", "PAXG", "PSGFT", "USDC", "WBX", "XRP"
            ],
            result: null
        }
    },
    methods: {
        submit() {
            if(!this.form.coin){
                this.formErrors.coin = "The Coin field is required."
                return;
            }

            var url = 'api/crypto/' + this.form.coin
            axios.post(url, this.form).then(res => this.form.result = res.data).catch(function (error) {
                if(error.response.status == 422){
                    this.formErrors.dataCompra = error.response.data?.errors?.dataCompra?.[0];
                    this.formErrors.dataVenda = error.response.data?.errors?.dataVenda?.[0];
                    this.formErrors.quantidade = error.response.data?.errors?.quantidade?.[0];
                }else{
                    alert("Desculpe, ocorreu um erro inesperado.")
                }

            }.bind(this))
        },
    },
})
</script>

<style scoped>

</style>

