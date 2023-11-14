
import {createApp} from 'vue'
import './bootstrap'
import App from './App.vue'
import  CurrencyConverter  from '../components/CurrencyConverter.vue'

const app = createApp({
    components:{
        App,
        CurrencyConverter
    }
})

app.mount('#app')

