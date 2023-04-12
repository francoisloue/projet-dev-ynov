<template>
    <input type="text" placeholder="Category Name" v-model="categoryName"> 
    <h3>{{ categoryErrorMessage }}</h3>
</template>
  
  <script>
  import axios from "axios";
  
  export default {
    data() {
      return {
        categoryErrorMessage:"",
        categoryName: "",
      };
    },
    methods: {
      async CreatNewCategory() {
        if (!this.categoryName) {
          this.errorMessage = "Please specify a category Name";
        } else {
          let data = JSON.stringify({
            categoryName: this.categoryName,
          });
          const toCreate = axios.post("http://localhost/category", data);
          const res = await toCreate.data;
          console.log(await res);
        }
      },

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
    width: 50%;
    margin-top: 4%;
  }
  </style>
  