<template>
    <div class="container">
        <div v-if="this.items.length">
            <div class="cart" v-for="item in this.items" v-bind:key="item.id">
                <h1>Your Cart</h1>
                <h1 v-on:click="this.goToArticle(item.productID)">Go to profil Item</h1>
                <p>name : {{ item.name }}</p>
                <p>quantity {{ item.quantity }}</p>
                <p>unit price : {{ item.price }}</p>
                <button v-on:click="this.removeArticle(item.id)">Remove</button>
            </div>
            <h1>Total Cart : {{ this.totalPrice }}</h1>
        </div>
        <div v-else>
            <h1>No Item for now</h1>
            <button v-on:click="goShopping">Start Shopping Now</button>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
  export default {
    data(){
      return{
        items:[],
        idUser:0,
        totalPrice: 0,
      }
    },
    methods:{
        async getAllItems(){
            const req = await axios.get("http://localhost/cart/"+this.idUser)
            const res = await req.data
            this.items = await res;
            await this.calcTotalPrice();
        },
        async goToArticle(idItem){
            this.$router.push({ path: '/itemProfil', query: { id: idItem }})
        },
        async removeArticle(idItem){
            const req = await axios.delete("http://localhost/cart/" + idItem);
            const res = await req.data;
            if(res==true)this.getAllItems();
            
        },
        async calcTotalPrice(){
            this.totalPrice = 0;
            this.items.forEach(item=>this.totalPrice+=item.price)
        },
        async goShopping(){
            this.$router.push({ path: '/allItems'})
        }
    },
    async mounted(){
        this.idUser = localStorage.getItem("userID");
        await this.getAllItems();
    },
    watch:{
      
    }
  }
</script>

<style>
.container{
	display: flex;
	flex-direction: row;
	flex-wrap: nowrap;
	justify-content: center;
	align-items: stretch;
	align-content: stretch;
    width: 100%;
    height: 100%;
}
.cart{
    display: flex;
	flex-direction:column;
	flex-wrap: nowrap;
	justify-content: center;
	align-items: stretch;
	align-content: stretch;
    margin: 5%;
}
</style>