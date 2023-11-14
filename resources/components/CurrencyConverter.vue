<script setup>
import { ref, computed, onMounted } from "vue";

const currencies = ref( [] )
const baseCurrency = ref( 'USD' )
const currency = ref( 'EUR' )
const importe = ref( 1 )
const rate = ref( 0 );

onMounted( () => {
    getCurrencies();
    getConverter();
} )

function getCurrencies () {
    axios
        .get( 'http://localhost:8000/api/list' )
        .then( response => currencies.value = response.data.data );
}

function getConverter () {

    axios.get( 'http://localhost:8000/api/converter', {
        params: {
            base_currency: baseCurrency.value,
            currencies: currency.value
        }
    } )
        .then( response => rate.value = response.data.data );
}

function changeCurrency() {
    const base = baseCurrency.value;
    const curr = currency.value
    baseCurrency.value = curr;
    currency.value = base
    getConverter()
}

function onChangeBase ( { target } ) {
    baseCurrency.value = target.value;
    getConverter();
}

function onChange ( { target } ) {
    currency.value = target.value
    getConverter();
}
</script>

<!-- <script>
    export default {
        data () {
            return {
                currencies: []
            }
        },
        created () {
            this.getCurrencies()
        },
        methods: {
            fetchData () {
                console.log( 'get currencies list' )
            },
            getCurrencies () {
                axios
                    .get( 'http://localhost:8000/api/list' )
                    .then( response => currencies = response.data.data );
            }
        }
    }
</script> -->

<template>
    <div class="grid gap-6 container mx-auto border rounded-md px-10 py-14 shadow-xl bg-white w-10/12">
        <div>
            <form @submit.prevent class="flex justify-between gap-4">
                <div class="flex-1">
                    <p class="font-semibold pb-1">Importe</p>
                    <input v-model=" importe " class="border rounded-md border-gray-300 p-3 w-full" />
                </div>
                <div class="flex-1">
                    <p class="font-semibold pb-1">De:</p>
                    <select v-model=" baseCurrency " @change="onChangeBase( $event )"
                        class="border rounded-md border-gray-300 p-3 w-full">
                        <option v-for=" currency in currencies " :value=" currency.code ">
                            {{ currency.symbol }} - {{ currency.name }}
                        </option>
                    </select>
                </div>
                <div class="grid place-items-end">
                    <button class="rounded-full border border-gray-500 h-14 w-14" @click="changeCurrency" >
                    </button>
                </div>
                <div class="flex-1">
                    <p class="font-semibold pb-1">a</p>
                    <select v-model=" currency " @change="onChange( $event )"
                        class="border rounded-md border-gray-300 p-3 w-full">
                        <option v-for=" currency in currencies " :value=" currency.code ">
                            {{ currency.symbol }} - {{ currency.name }}
                        </option>
                    </select>

                </div>

            </form>
        </div>
        <div class="flex flex-col gap-2">
            <p class="font-semibold text-gray-500">{{ importe }} {{ baseCurrency }} =</p>
            <p class="text-4xl">{{ rate[currency] * importe }} {{ currency }}</p>
            <p class="text-gray-500">1 {{ currency }} = {{ importe /  rate[currency]}} {{baseCurrency}}</p>
        </div>
        <div class="flex justify-between">
            <div class="w-1/2">
                <div class="bg-sky-50 w-10/12 text-xs text-gray-600 p-3 rounded-md">
                    Usamos la tasa del mercado medio para nuestro conversor. Esto solo tiene fines informativos. No
                    recibirás esta tasa cuando envíes dinero. <span class="text-blue-600">Consulta las tasas de
                        envío.</span>
                </div>
            </div>
            <div class="w-1/2 text-right">
                <button class="py-2 px-6 text-white bg-sky-500 rounded-md mb-4" >
                    Ver contizacón de transferencia
                </button>
                <p class="text-xs text-gray-600">Conversión de <span class="text-blue-600">Dólar estadounidense</span> a
                    <span class="text-blue-600">Euro</span> — Última actualización: 12 nov 2023, 23:46 UTC
                </p>
            </div>
        </div>
    </div>
</template>
