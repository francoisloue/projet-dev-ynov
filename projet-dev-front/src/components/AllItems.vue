<template>
  <div class="filterPart">
    <h1>Filter by Category</h1>
    <select v-model="this.categoryFilter" style="width:80%">
          <option selected>No Filter</option>
          <option  v-for="category in this.categories" v-bind:key="category.id" v-bind:value="category.id">
            {{ category.name }}
          </option>
        </select>
        <h1>Hello {{ this.curentUser.username }}</h1>
  </div>
    <div class="allItems">
        <div class="card" v-for="item in this.items" v-bind:key="item.id">
            <div class="card-image">
                <img v-bind:src="item.imageURL" alt="Product Image">
            </div>
            <div class="card-content">
                <h2 class="card-title">{{ item.name }}</h2>
                <p class="card-price">{{ item.price }}€</p>
            </div>
            <div class="button-section">
                <button  v-on:click="goToItemPage(item.id)">More Info</button>

                  <button v-if="curentUser.userType==1 && item.quantityCart<=0" v-on:click="addToCart(item.id)">Add To Cart</button>

                  <div class="addOrRemoveItem" v-if="curentUser.userType==1 && item.quantityCart>=1">
                    <button v-on:click="updateQuantityInCart(false,item)">-</button>
                    <p>Current: {{ item.quantityCart }}</p>
                    <button v-on:click="updateQuantityInCart(true,item)">+</button>
                  </div>


                <button v-if="curentUser.userType==2" v-on:click="deleteItem(item.id)">Delete this object of the store</button>

            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
  export default {
    data(){
      return{
        idUser:"",
        items:[],
        categories: [],
        categoryFilter: "",
        curentUser:{},
      }
    },
    methods:{
        async getAllItems(){
            const req = await axios.get("http://localhost/items");
            const res = await req.data
            this.items = await res;
        },
        async goToItemPage(idItem){
          this.$router.push({ path: '/itemProfil', query: { id: idItem }})
        },
        // `async addToCart(idItem)` is a method that adds an item to the user's cart. It creates an
        // object `data` with the `idUser`, `idItem`, and `quantity` properties, and sends an HTTP POST
        // request to the server with the URL "http://localhost/cart" and the `data` object as the
        // request body. It then retrieves the response data using `await req.data`, logs it to the
        // console, and updates the `this.items` array by calling the `getAllItems()` and
        // `getItemsCart()` methods.
        async addToCart(idItem){
            const data = {
                "idUser": localStorage.getItem("userID"),
                "idItem":idItem,
                "quantity":1,
            }
            const req = await axios.post("http://localhost/cart",data);
            const res = await req.data;
            console.log(await res)
            await this.getAllItems();
            await this.getItemsCart();
        },
        async getAllCategories(){
          const req = await axios.get("http://localhost/category")
          const res = await req.data
          this.categories = res
        },

        async setFilter(){
          if(!isNaN(parseInt(this.categoryFilter))){
            const req = await axios.get("http://localhost/items/category/"+this.categoryFilter)
            const res = await req.data
            this.items = await res
          } else {
            this.getAllItems()
          }
        },
        async deleteItem(itemId){
          const req = await axios.delete("http://localhost/items/"+itemId)
          const res = await req.data
          if(res==true){
            await this.getAllItems();
          } else {
            alert("error while removing items")
          }
        },
        // `async redirectUsers()` is a method that checks if there is a user ID stored in the local
        // storage. If there is, it sends an HTTP GET request to the server to retrieve the user
        // information using the user ID. It then sets the `curentUser` data property to the retrieved
        // user information. If the user type is 999 (admin), it redirects the user to the admin panel
        // page. If there is no user ID stored in the local storage, it redirects the user to the login
        // page.
        async redirectUsers(){
          if("null"!=localStorage.getItem("userID")){
            const userID = localStorage.getItem("userID")
            const req = await axios.get("http://localhost/users/"+userID)
            const res = await req.data
            this.curentUser = await res
            if(this.curentUser.userType==999){
              this.$router.push({ path: '/adminPannel'})
            }
          } else {
            this.$router.push({ path: '/login'})
          }
        },
        // `async getItemsCart()` is a method that retrieves the items in the user's cart from the
        // server using an HTTP GET request to the URL "http://localhost/cart/" + this.idUser. It then
        // updates the `quantityCart` and `idItemCart` properties of each item in the `this.items`
        // array based on the items retrieved from the server. Finally, it updates the `this.items`
        // array with the updated values.
        async getItemsCart(){
          const req = await axios.get("http://localhost/cart/"+this.idUser)
          const res = await req.data
          const itemsInCart = await res
          let allItems = this.items
          allItems.forEach(item => {
            item.quantityCart = 0
            item.idItemCart = 0
            itemsInCart.forEach(itemCart => {
              if(itemCart.productID==item.id){
                item.quantityCart = itemCart.quantity
                item.idItemCart = itemCart.id
              }
            });
          });
          this.items = allItems
        },
        // `async updateQuantityInCart(isAdding,item)` is a method that updates the quantity of an item
        // in the user's cart. It takes two parameters: `isAdding`, a boolean value that indicates
        // whether the quantity should be increased or decreased, and `item`, the item object that
        // needs to be updated.
        async updateQuantityInCart(isAdding,item){
          let urlChange = ""
          console.log(isAdding)
          if(isAdding){
            urlChange = "addOne"
          }else{
            urlChange = "removeOne"
          }
          const url = "http://localhost/cart/"+urlChange+"/"+item.idItemCart
          const req = await axios.put(url)
          const res = await req.data
          console.log(res)
          await this.getAllItems();
          await this.getItemsCart();
        }
    },
    async mounted(){
      this.idUser = localStorage.getItem("userID")
      await this.redirectUsers();
      await this.getAllItems();
      await this.getAllCategories();
      await this.getItemsCart();
    },
    watch:{
      categoryFilter(newFilter){
        this.categoryFilter = newFilter
        this.setFilter()
      }
    }
  }
</script>

<style>
.allItems{
	display: flex;
	flex-direction: row;
	flex-wrap: wrap;
	justify-content: center;
	align-items: stretch;
	align-content: stretch;
    width: 100%;
    height: 100%;
    margin-top: 5%;
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

.filterPart{
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  margin-top: 10%;
}
</style>