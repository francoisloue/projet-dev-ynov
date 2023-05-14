<template>
  <div style="display: flex; justify-content: center; align-items: center;">
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
        type="number"
        placeholder="enter the item price"
        v-model="itemPrice"
        min="0"
      />
      <label for="categroyID">* Item Category :</label>
      <div class="category-div">
        <select v-model="itemCategory" style="width: 75%" id="selectedCategory">
          <option selected disabled hidden>Choose a Category</option>
          <option
            v-for="category in this.categories"
            :value="category.id"
            v-bind:key="category.id"
          >
            {{ category.name }}
          </option>
        </select>
        <input
          type="button"
          value="New Category"
          v-on:click="($event) => ShowForm()"
          style="width: 22%"
        />
      </div>
      <div id="newCategory">
        <input type="text" placeholder="Category Name" v-model="categoryName" />
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
    <div class="card">
      <p>Item Preview : </p>
      <h2 class="card-title">{{ itemName }}</h2>
      <div class="card-image">
        <img v-bind:src="itemImageURL" alt="Product Image" v-if="itemImageURL!=''"/>
        <img src="https://cdn0.iconfinder.com/data/icons/cosmo-layout/40/box-512.png" alt="Product Image" v-else/>
      </div>
      <div class="card-bottom">
        <div class="card-content">
          <p class="card-price">{{ itemDescription }}</p>
        </div>
        <div class="card-content" style="display: flex; flex-direction: column; align-items: end;">
          <p class="card-price">{{ categoryChoosen }}</p>
            <p class="card-price" v-if="itemPrice != ''">{{ itemPrice }}€</p>
            <p class="card-price" v-else>0€</p>
        </div>
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
      isShown: false,
      categoryChoosen: "",
    };
  },
  methods: {
    async CreatNewItem() {
      if (!this.itemName || !this.itemPrice || !this.itemCategory && !this.categoryName) {
        this.errorMessage = "One of the required fields is empty";
      } else {
        if (!this.categoryName && !this.itemCategory) {
          this.categoryErrorMessage =
            "Please specify a category or create a new one";
        } else if (this.categoryName) {
          let categoryList = await this.CreatNewCategory();
          if (this.categoryErrorMessage) {
            return;
          }
          categoryList.forEach((element) => {
            if (element.name == this.categoryName) {
              this.itemCategory = element.id;
            }
          });
          console.log("Here" + this.itemCategory);
        }
        console.log(this.itemCategory);
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
      this.$router.push({ path: '/allItems'})
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
        document.getElementById("newCategory").style.display = "none";
        this.isShown = false;
        select.value = "";
        select.disabled = false;
      } else {
        document.getElementById("newCategory").style.display = "block";
        this.isShown = true;
        select.value = "";
        select.disabled = true;
      }
    },
  },

  async mounted() {
    this.categories = await (await axios.get("http://localhost/category")).data;
  },
  watch: {
    itemCategory(newValue) {
      this.categories.forEach(category => {
      if (category.id == newValue) {
        this.categoryChoosen = category.name
      }
    });
    }
  }
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
  justify-content: center;
  align-items: center;
  height: 50%;
  width: 100%;
  min-height: 200px;
}
.item-render {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: 45%;
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
  width: 50%;
  margin-top: 10px;
}
.card-bottom {
  display: flex;
  flex-direction: row;
}
.card-title {
  text-align: center;
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
