<template>
  <link rel="stylesheet" href="css/pico.min.css">
    <div class="navbar">
        <ul>
          <div v-if="!isConnected">
            <li><a href="/login"> Login</a></li>
            <li><a href="/register">Register</a></li>
          </div>
          <div v-else>
            <div v-if="this.userInfo.userType==1">
              <li><a href="/allItems">Products</a></li>
              <li><a href="/Cart">Cart</a></li>
            </div>
            <div v-else-if="this.userInfo.userType==2">
              <li><a href="/newItem">Seller Pannel</a></li>
            </div>
            <div v-else>
              <li><a href="/adminPannel">Admin Pannel</a></li>
            </div>
            <li v-on:click="disconnect"><a href="/login">Log Out</a></li>
          </div>
        </ul>    
    </div>
</template>

<script>
import axios from 'axios';

  export default {
    data(){
      return{
        isConnected: false,
        userId:"",
        userInfo: {},
      }
    },
    methods:{
        async disconnect(){
          localStorage.setItem("userID",null);
        },
        async getInfoCurrentUser(){
          const req = await axios.get("http://localhost/users/"+this.userId)
          const res = await req.data
          this.userInfo = await res
          console.log(this.userInfo.userType)
        },
    },
    async mounted(){
        if(localStorage.getItem("userID")!="null"){
          this.isConnected = true
          this.userId = localStorage.getItem("userID")
          await this.getInfoCurrentUser();
        }
    },
    watch:{
      
    }
  }
</script>

<style>
.navbar ul {
    position: fixed !important;
    list-style-type: none !important;
    margin: 0 !important;
    top: 0 !important;
    right: 0 !important;
    left: 0 !important;
    padding: 0 !important;
    overflow: hidden !important;
    background-color: #333 !important;
    list-style-type: none !important;  
  }
.navbar li {
  float: left !important;
  list-style-type: none !important;
}
.navbar li a {
  display: block !important;
  color: white !important;
  text-align: center !important;
  padding: 14px 16px !important;
  text-decoration: none !important;
  list-style-type: none !important;  
}
</style>