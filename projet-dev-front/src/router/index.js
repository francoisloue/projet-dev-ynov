import { createWebHistory, createRouter } from "vue-router"
import App from "@/views/App.vue"
import Register from "@/views/RegisterPage.vue"
import Login from "@/views/LoginPage.vue"
import SellerPannel from "@/views/SellerPannelPage.vue"
import AdminPannel from "@/views/AdminPannelPage.vue"
import Profil from "@/views/ProfilPage.vue"
import testRandom from "@/views/testRandom.vue"
import NewCategory from "@/views/NewCategory.vue"
import NewItem from "@/views/NewItemPage.vue"
import AllItems from "@/views/AllItemsPage.vue"
import ItemPage from "@/views/ItemProfilPage.vue"
import CartPage from "@/views/CartPage.vue"
import RedirectMain from "@/components/RedirectMain.vue"

const routes=[
    {
        path: "/",
        name: "redirect main",
        component: RedirectMain,
    },
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
    },
    {
        path: "/testRandom",
        name: "testRandom",
        component: testRandom,
    },
    {
        path: "/newCategory",
        name: "newCategory",
        component: NewCategory
    },
    {
        path: "/allItems",
        name: "allItems" ,
        component: AllItems,
    },
    {
        path: "/itemProfil",
        name : "itemProfil",
        component: ItemPage,
    },
    {
        path: "/cart",
        name: "cart",
        component: CartPage,
    }
]


const router = createRouter({
    history: createWebHistory(),
    routes
  })
  
  export default router