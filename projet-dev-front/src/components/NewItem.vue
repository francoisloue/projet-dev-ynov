<template>
  <div style="display: flex; justify-content: center;">
    <div class="item-form">
      <h1>Create a new Item to sell</h1>
      <label for="name">* Item name :</label>
      <input type="text" placeholder="enter the item name" v-model="itemName" />
      <label for="description">Item description :</label>
      <input
        type="text"
        placeholder="enter the item description"
        v-model="itemDescription"
      />
      <label for="price">* Item Price :</label>
      <input
        type="text"
        placeholder="enter the item price"
        v-model="itemPrice"
      />
      <label for="categroyID">* Item Category :</label>
      <div class="category-div">
        <select v-model="itemCategory" style="width: 75%" id="selectedCategory">
          <option selected disabled hidden>Choose a Category</option>
          <option v-for="category in this.categories" :value="category.id" v-bind:key="category.id">{{ category.name }}</option>
        </select>
        <input
          type="button"
          value="New Category"
          v-on:click="($event) => ShowForm()"
          style="width: 22%"
        />
      </div>
      <div id="newCategory">
        <input type="text" placeholder="Category Name" v-model="categoryName"> 
      </div>
      <h3>{{ categoryErrorMessage }}</h3>
      <label for="imageURL">Item Illustration :</label>
      <input
        type="url"
        placeholder="place here your image URL"
        v-model="itemImageURL"
      />
      <input type="submit" v-on:click="($event) => CreatNewItem()" />
      <h3>{{ errorMessage }}</h3>
    </div>
    <div class="item-render">
      <div class="new-item">
        <p>{{ itemName }}</p>
      </div>
  </div>
  </div>
</template>
<script>
import axios from "axios";

export default {
  data() {
    return {
      itemName: "",
      itemDescription: "",
      itemCategory: "",
      itemPrice: "",
      itemImageURL: "",
      errorMessage: "",
      categoryName: "",
      categoryErrorMessage: "",
      categories: null,
      isShown: false
    };
  },
  methods: {
    async CreatNewItem() {
      if (!this.itemName || !this.itemPrice) {
        this.errorMessage = "One of the required fields is empty";
      } else {
        if(!this.categoryName || this.itemCategory) {
          this.categoryErrorMessage="Please specify a category or create a new one"
        } else if(this.categoryName) {
          let categoryList=await this.CreatNewCategory();
          if(this.categoryErrorMessage) {
            return
          }
          categoryList.forEach(element => { 
            if (element.name == this.categoryName) {
              this.itemCategory=element.id;
            }
            console.log(this.itemCategory, this.categoryName);
          });
          console.log(this.itemCategory, this.categoryName);
        }
        let data = JSON.stringify({
          itemName: this.itemName,
          itemDescription: this.itemDescription,
          itemCategory: this.itemCategory,
          itemPrice: this.itemPrice,
          itemImageURL: this.itemImageURL,
        });
        const toCreate = axios.post("http://localhost/items", data);
        const res = await toCreate.data;
        console.log(await res);
      }
    },

    async CreatNewCategory() {
        if (!this.categoryName) {
          this.categoryErrorMessage = "Please specify a category Name";
        } else {
          console.log(this.categoryName);
          let data = JSON.stringify({
            categoryName: this.categoryName,
          });
          let toCreate = await axios.post("http://localhost/category", data);
          let res = await toCreate.data;
          return await res;
        }
      },
      async ShowForm() {
        let select = document.getElementById("selectedCategory");
        if (this.isShown) {
          document.getElementById("newCategory").style.display="none";
          this.isShown=false;
          select.value="";
          select.disabled=false;
        } else {
          document.getElementById("newCategory").style.display="block";
          this.isShown=true;
          select.value="";
          select.disabled=true;
        }
      },
    },

  async mounted() {
    this.categories = await(await axios.get("http://localhost/category")).data
  },
};

</script>
<style>
.category-div {
  display: flex;
  flex-direction: row;
  width: 100%;
  justify-content: space-between;
}

.item-form {
  display: flex;
  flex-direction: column;
  width: 45%;
  margin: 4%;
}

div[id="newCategory"] {
  display: none;
}

.new-item {
  margin: 4%;
  border: solid;
  border-color: white;
  justify-content: center;
  align-items: center;
  height: 50%;
  width: 100%;
  min-height: 200px ;
}
.item-render {
  display: flex; 
  flex-direction:column; 
  align-items:center; 
  justify-content: center; 
  width:45%; 
  height:100%
}
</style>
