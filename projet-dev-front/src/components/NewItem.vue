<template>
  <div style="display: flex; justify-content: center">
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
        <select v-model="itemCategory" style="width: 75%">
          <option selected disabled hidden>Choose a Category</option>
          <option value="test">test</option>
        </select>
        <input
          type="button"
          value="New Category"
          v-on:click="($event) => ShowForm()"
          style="width: 22%"
        />
      </div>
      <NewCategory />
      <label for="imageURL">Item Illustration :</label>
      <input
        type="url"
        placeholder="place here your image URL"
        v-model="itemImageURL"
      />
      <input type="submit" v-on:click="($event) => CreatNewItem()" />
      <h3>{{ errorMessage }}</h3>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import NewCategory from "@/components/NewCategory.vue";

export default {
  data() {
    return {
      itemName: "",
      itemDescription: "",
      itemCategory: "",
      itemPrice: "",
      itemImageURL: "",
      errorMessage: "",
      categoryErrorMessage:"",
      CategoryComponent: NewCategory,
      categoryName: NewCategory.categoryName,

    };
  },
  methods: {
    async CreatNewItem() {
      if (!this.itemName || !this.itemPrice) {
        this.errorMessage = "One of the required fields is empty";
      } else {
        if (!this.itemCategory) {
          if (!this.categoryName) {
            this.errorMessage =
              "Please specify a category name or create a new one";
          } else {
            this.itemCategory = this.categoryName;
            console.log(this.itemCategory);
            // this.CategoryComponent.methods.CreatNewCategory();
          }
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
  },
  components: { NewCategory },
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
  width: 50%;
  margin-top: 4%;
}
</style>
