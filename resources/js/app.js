import './bootstrap';

import Alpine from 'alpinejs';
import { createApp } from 'vue'
import HomeCategoryList from './components/HomeCategoryList.vue'

window.Alpine = Alpine;

Alpine.start();

const app = createApp({})

app.component('home-category-list', HomeCategoryList)

app.mount('#app')
