<template>
    <div class="container">
        <h1>List of all Users</h1>
        <div v-for="user in this.users" class="user" v-bind:key="user.id">
          {{ user }}
          <select>
            <option v-for="userType in this.usersType" v-bind:key="userType.id">
              {{ userType.name }}
            </option>
          </select>
          <button v-on:click="this.changeUserType()">Confirm</button>
        </div>
    </div>
  </template>
  
  
  <script>
  import axios from 'axios'
  export default {
    data(){
      return{
        users:[],
        usersType:[],
      }
    },
    methods:{
        async getAllUsers(){
            const req = await axios.get("http://localhost/projet-dev-ynov/projet-dev-back/getAllUsers.php",JSON.stringify())
            this.users = await req.data
        },
        async getAllUserType(){
          const req = await axios.get("http://localhost/projet-dev-ynov/projet-dev-back/getAllUserType.php",JSON.stringify())
          this.usersType = await req.data
        },
        async changeUserType(idUser,idUserType){
          console.log(idUser,idUserType)
        }
    },
    async mounted(){
        await this.getAllUserType();
        await this.getAllUsers();
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