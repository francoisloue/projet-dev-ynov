import { createApp } from 'vue'
import App from './App.vue'
import router from "./router"
// import { OhVueIcon } from "oh-vue-icons";
// import * as BiIcons from "oh-vue-icons/icons/bi";

// OhVueIcon.add(BiIcons);
createApp(App).use(router).mount('#app');
// App.component("v-icon", OhVueIcon);