<template>
    <div class="item-container">
        <div class="info">
          <div class="left-side">
            <img v-bind:src="item.imageURL" v-bind:alt="item.name +' image' " style="height: 100%; width: 100%;"/>
          </div>
          <div class="right-side">
            <h1>{{ item.name }}</h1>
            <p>Price: {{ item.price }} €</p>
            <p>Description: {{ item.description }}</p>
            <p>Category: {{ category.name }}</p>
            <button v-if="userInfo.userType==1 && item.quantityCart<1" v-on:click="addToCart(item.id)" style="display: flex; justify-content: center; align-items: center;">Add To Cart<v-icon name="bi-cart"/></button>
            

            <div class="addOrRemoveItem" v-if="userInfo.userType==1 && item.quantityCart>=1">
                  <button v-on:click="updateQuantityInCart(false,item)">-</button>
                  <p>Current: {{ item.quantityCart }}</p>
                  <button v-on:click="updateQuantityInCart(true,item)">+</button>
                </div>
            
            
            
            <div style="display: flex; flex-direction: row; align-items: center;">
              <button v-if="userInfo.userType==2" v-on:click="deleteItem(item.id)" style="height:50%;width: 10%;display: flex; justify-content: center;align-items: center;"><v-icon name="bi-trash" scale="3.0"/></button>
            <button v-if="userInfo.userType==2" v-on:click="deleteItem(item.id)" style=" height:50%;width: 10%;display: flex; justify-content: center;align-items: center; margin-left: 10%;"><v-icon name="bi-wrench-adjustable" scale="3.0"/></button>
            </div>
          </div>
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
                <button v-if="userInfo.userType==1 && item.quantityCart<=0" v-on:click="addToCart(item.id)">Add To Cart</button>

                                
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
        },

        // This function is updating the quantity of an item in the user's cart by sending a PUT
        // request to the server with the appropriate URL based on whether the user is adding or
        // removing an item from their cart. It then updates the item information and the user's cart
        // information by calling the `getInfoItem()` and `getItemsCart()` functions respectively.
        async updateQuantityInCart(isAdding,item){
          let urlChange = ""
          if(isAdding){
            urlChange = "addOne"
          }else{
            urlChange = "removeOne"
          }
          const url = "http://localhost/cart/"+urlChange+"/"+item.idItemCart
          const req = await axios.put(url)
          const res = await req.data
          console.log(res)
          await this.getInfoItem()
          await this.getItemsCart()
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
        },
        // This function is making an asynchronous GET request to the server to retrieve the items in
        // the user's cart. It then updates the `quantityCart` property of the `item` object with the
        // quantity of the item in the user's cart, and sets the `idItemCart` property to the ID of the
        // item in the user's cart. This information is used to display the appropriate buttons and
        // information on the item page.
        async getItemsCart(){
          const req = await axios.get("http://localhost/cart/"+this.userInfo.id)
          const res = await req.data
          let itemsInCart = await res
          this.item.quantityCart=0
          itemsInCart.forEach(itemCart => {
            if(itemCart.productID==this.item.id){
              this.item.quantityCart = itemCart.quantity
              this.item.idItemCart = itemCart.id
            }
          });
        },
    },
    async mounted(){
        this.idFromQuery = this.$route.query.id;
        await this.getUserInfo();
        await this.getInfoItem();
        await this.getCategory();
        await this.getRandomCatItems();
        await this.getItemsCart();
    },
    watch:{
      
    }
  }
</script>

<style>
.info {
  display: flex;
  flex-direction: row;
  width: 80%;
}

.left-side {
  padding: 1%;
  width: 50%;
  height: 100%;
}

.right-side {
  display: flex;
  flex-direction: column;
  justify-content: space-around;
  width: 50%;
  padding: 2%;
}

.item-container{
	display: flex;
  margin-top: 5%;
	flex-direction: column !important;
	justify-content: center;
	align-items: center;
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