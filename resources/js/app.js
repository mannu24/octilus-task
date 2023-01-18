import './bootstrap';
import { createApp } from 'vue';
import VueProgressBar from "@aacassandra/vue3-progressbar";
import Swal from 'sweetalert2'
import { createRouter, createWebHistory } from 'vue-router'

//Components
import UserDetails from './components/UserDetails.vue';
import Addresses from './components/Addresses.vue';
import ThankYou from './components/ThankYou.vue';

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 1500,
})

window.Swal = Swal
window.toast = Toast

const Vue = createApp();
Vue.use(VueProgressBar, { color: 'rgb(0,107,180)', failedColor: 'red', height: '15px' })

const routes = [
    //Front Routes
    { path: '/', name: UserDetails, component: UserDetails },
    { path: '/addresses', name: Addresses, component: Addresses},
    { path: '/thank-you', name: ThankYou, component: ThankYou},
]
const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) { return savedPosition }
        else { return { top: 0, behavior: 'smooth' } }
    }
})

Vue.use(router)
Vue.mount('#root');


