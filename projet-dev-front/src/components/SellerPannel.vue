<template>
    <div class="container">
  
      <h1>Panel commercant</h1>
      <div class="createCategory">
        <h1>Create a category</h1>
        <label for="createCategoryname">CategoryName: </label>
        <input id="createCategoryname" class="text" type="text" v-model="createCategoryName"/>
        <input type="button" value="create Category" />
      </div>
      <div class="createProduct">
  
        
        <h2>Ajouter produit</h2>
        <label for="image">Image :</label>
        <input id="image" class="text" type="text" v-model="imageURL"/>
        <label for="nom">Nom :</label>
        <input id="nom" class="text" type="text" v-model="name"/>
        <label for="description">Description :</label>
        <textarea id="description" class="text" v-model="description"></textarea>
        <label for="prix">Prix :</label>
        <input id="prix" class="text" type="number" v-model="price"/>
        <label for="stock">Stock :</label>
        <input id="stock" class="text" type="number" v-model="stock"/>
        <input class="panier" type="button" value="Add"/>
      </div>
    </div>
  </template>
  
  
  <script>
  
  export default {
    data(){
      return{
        createCategoryName:"",
        category:[],
        imageURL:"",
        name:"",
        description:"",
        price:"",
        stock:"",
        categoryID:"",
        tmpCategory:"",
      }
    },
    methods:{

      
    },
    async mounted(){
      console.log(localStorage.getItem("userID"))
    },
    watch:{
      
    }
  }
  </script>
  
  <style>
  
  .createProduct {
      display: inline-block;
      margin-left: auto;
      margin-right: auto;
      border: 3px solid !important;
      border-radius: 20px !important;
      border-color: white !important;
      width: 30%;
      margin-top: 20%;
  }
  .createCategory{
    display: inline-block;
    margin-left: auto;
    margin-right: auto;
    border: 3px solid !important;
    border-radius: 20px !important;
    border-color: white !important;
    width: 30%;
  }
  
  .card .panier{
      width: 80%;
  }
  .container{
    display: flex;
      flex-direction: column;
      flex-wrap: nowrap;
      justify-content: flex-start;
      align-items: stretch;
      align-content: stretch;
  }
  </style>