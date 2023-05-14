import { createApp } from 'vue'
import App from './App.vue'
import router from "./router"
import { OhVueIcon, addIcons } from "oh-vue-icons";
import * as BiIcons from "oh-vue-icons/icons/bi";

const Bi = Object.values({ ...BiIcons });
addIcons(...Bi);
createApp(App).use(router).component("v-icon", OhVueIcon).mount('#app');