<template>
    <div class="container">
        <div class="info">
            <h1>{{ item.name }}</h1>
            <img v-bind:src="item.imageURL" v-bind:alt="item.name +' image' "/>
            <p>Price: {{ item.price }}</p>
            <p>Description: {{ item.description }}</p>
            <p>Category: {{ category.name }}</p>
            <button v-if="userInfo.userType==1" v-on:click="addToCart(item.id)">Add To Cart</button>
            <button v-if="userInfo.userType==2" v-on:click="deleteItem(item.id)">Delete this item</button>
        </div>
        <div class="randItem">
          <div class="card" v-for="item in this.itemsCat" v-bind:key="item.id">
            <div class="card-image">
                <img v-bind:src="item.imageURL" alt="Product Image">
            </div>
            <div class="card-content">
                <h2 class="card-title">{{ item.name }}</h2>
                <p class="card-price">Price: {{ item.price }}</p>
            </div>
            <div class="button-section">
                <button  v-on:click="goToItemPage(item.id)">More Info</button>
                <button v-if="userInfo.userType==1" v-on:click="addToCart(item.id)">Add To Cart</button>
                <button v-if="userInfo.userType==2" v-on:click="deleteItem(item.id)">Add To Cart</button>

            </div>
        </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
  export default {
    data(){
      return{
        item:{},
        idFromQuery: 0,
        category:{},
        itemsCat:[],
        userInfo:{},
      }
    },
    methods:{
        async getInfoItem(){
            const req = await axios.get("http://localhost/items/" + this.idFromQuery);
            const res = await req.data
            this.item = await res;
        },
        async getCategory(){
            const req = await axios.get("http://localhost/category/" + this.item.categoryID)
            const res = await req.data;
            this.category  = await res
        }, 
        async getRandomCatItems(){
          const req = await axios.get("http://localhost/items/randomCategory/" + this.item.categoryID)
          const res = await req.data;
          await res.forEach((itemGet,index) => {if(itemGet.id==this.item.id)res.splice(index,1)});
          this.itemsCat = await res
        },
        async getUserInfo(){
          const req = await axios.get("http://localhost/users/"+localStorage.getItem("userID"))
          const res = await req.data
          this.userInfo = await res
        },
        async deleteItem(itemId){
          const req = await axios.delete("http://localhost/items/"+itemId)
          const res = await req.data
          if(res==true){
            this.$router.push({path: "/allItems"})
          } else {
            alert("error while removing items")
          }
        }
    },
    async mounted(){
        this.idFromQuery = this.$route.query.id;
        await this.getUserInfo();
        await this.getInfoItem();
        await this.getCategory();
        await this.getRandomCatItems();
    },
    watch:{
      
    }
  }
</script>

<style>
.container{
	display: flex;
	flex-direction: column !important;
	flex-wrap: nowrap;
	justify-content: center;
	align-items: stretch;
	align-content: stretch;
    width: 100%;
    height: 100%;
}
.randItem{
	display: flex;
	flex-direction: row !important;
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