import { createWebHistory, createRouter } from "vue-router"
import App from "@/views/App.vue"
import Register from "@/views/RegisterPage.vue"
import Login from "@/views/LoginPage.vue"
import SellerPannel from "@/views/SellerPannelPage.vue"
import AdminPannel from "@/views/AdminPannelPage.vue"
import Profil from "@/views/ProfilPage.vue"



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
        path: "/login",
        name: "login",
        component: Login,
    },
    {
        path:"/sellerPannel",
        name: "sellerPannel",
        component: SellerPannel,
    },
    {
        path: "/adminPannel",
        name: "adminPannel",
        component: AdminPannel,
    },
    {
        path: "/profil",
        name: "profil",
        component: Profil,
    },
    {
        path: "/newItem",
        name: "newItem",
        component: NewItem,
    }
]


const router = createRouter({
    history: createWebHistory(),
    routes
  })
  
  export default router