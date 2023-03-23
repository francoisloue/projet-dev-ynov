import { createWebHistory, createRouter } from "vue-router"
import App from "@/views/App.vue"
import Test from "@/views/test.vue"


const routes=[
    {
        path: "/main",
        name: "main",
        component: App,
    },
    {
        path: "/test",
        name: "test",
        component: Test,
    },
]


const router = createRouter({
    history: createWebHistory(),
    routes
  })
  
  export default router