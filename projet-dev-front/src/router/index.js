import { createWebHistory, createRouter } from "vue-router"
import App from "@/views/App.vue"
import Register from "@/views/RegisterPage.vue"
import NewItem from "@/views/NewItemPage.vue"

const routes=[
    {
        path: "/main",
        name: "main",
        component: App,
    },
    {
        path: "/register",
        name: "register",
        component: Register,
    },
    {
        path: "/new-item",
        name: "newItem",
        component: NewItem,
    }

]


const router = createRouter({
    history: createWebHistory(),
    routes
  })
  
  export default router