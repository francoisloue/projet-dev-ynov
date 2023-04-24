<template>
    <div class="container">
        <div class="card" v-for="item in this.items" v-bind:key="item.id">
            <div class="card-image">
                <img v-bind:src="item.imageURL" alt="Product Image">
            </div>
            <div class="card-content">
                <h2 class="card-title">{{ item.name }}</h2>
                <p class="card-price">{{ item.price }}</p>
            </div>
            <div class="button-section">
                {{ item.id }}
                <button v-on:click="goToItemPage(item.id)">More Info</button>
                <button v-on:click="addToCart(item.id)">Add To Cart</button>
            </div>
    </div>
    </div>
</template>

<script>
import axios from 'axios'
  export default {
    data(){
      return{
        items:[],
      }
    },
    methods:{
        async getAllItems(){
            const req = await axios.get("http://localhost/items");
            const res = await req.data
            this.items = await res;
            console.log(this.items)
        },
        async goToItemPage(idItem){
          this.$router.push({ path: '/itemProfil', query: { id: idItem }})
        },
        async addToCart(idItem){
            const data = {
                "idUser": localStorage.getItem("userID"),
                "idItem":idItem,
                "quantity":1,
            }
            const req = await axios.post("http://localhost/cart",data);
            const res = await req.data;
            console.log(await res)
        }
    },
    async mounted(){
        await this.getAllItems();
        console.log(localStorage.getItem("userID"))
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
.card {
  border: 1px solid #ccc;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  padding: 20px;
  margin: 2%;
  height: 75%;
  width: 25%;
  min-width: 25%;
  display: flex; 
  flex-direction: column;
  flex-wrap: nowrap;
  justify-content: center;
  align-items: stretch;
  align-content: stretch;
}

.card-image {
  height: 25%;
  max-height: 25%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.card-image img {
  width: 200px;
  height: 200px;
  object-fit: cover;
}

.card-content {
  margin-top: 10px;
}

.card-title {
  font-size: 20px;
  font-weight: bold;
  margin: 0;
}

.card-price {
  font-size: 16px;
  font-weight: bold;
  margin: 10px 0 0 0;
}

</style>