<template>
    <div class="user-container">
        <h1>List of all Users</h1>
        <div v-for="user in this.users" class="user" v-bind:key="user">
          <h1>{{ user.username }}</h1>
          <p>Email: {{ user.mail }}</p>
          <p>Id: {{ user.id }}</p>
          <button v-on:click="goToProfil(user.id)">Profile of {{ user.username }}</button>
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
        currentUser:{},
      }
    },
    methods:{
        async getAllUsers(){
            const req = await axios.get("http://localhost/users",JSON.stringify())
            this.users = await req.data
        },
        async changeUserType(idUser,idUserType){
          console.log(idUser,idUserType)
        },
        async goToProfil(idUser){
          this.$router.push({ path: '/profil', query: { id: idUser }})
        },
        // `async getInfoCurrentUser()` is a method that is called during the `mounted()` lifecycle
        // hook. It checks if there is a `userID` stored in the `localStorage`. If there is, it sends a
        // GET request to the server to retrieve the user data for that `userID`. If the user is not an
        // admin (userType is not 999), it redirects to the All Items page. If the user is an admin, it
        // sets the `currentUser` data property to the retrieved user data. If there is no `userID`
        // stored in the `localStorage`, it redirects to the login page.
        async getInfoCurrentUser(){
          if(localStorage.getItem("userID")){
            const req = await axios.get("http://localhost/users/" + localStorage.getItem("userID"))
            const res = await req.data

            // if the user is not a Admin, redirect to All item page
            if(res.userType!=999){
              this.$router.push({ path: '/allItems' })
            }
            this.currentUser = await res
          } else {
            this.$router.push({ path: '/login' })
          }
        },
    },
    async mounted(){
      await this.getInfoCurrentUser();
      await this.getAllUsers();
    },
    watch:{
      
    }
  }
  </script>
  
  <style>
  .user-container{
    margin-top: 10%;
    display: flex;
    flex-direction: column;
  }
  </style>