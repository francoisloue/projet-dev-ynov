<template>
  <link rel="stylesheet" href="css/pico.min.css">
    <div class="navbar">
        <ul>
          <div v-if="!isConnected">
            <li><a href="/login"> Login</a></li>
            <li><a href="/register">Register</a></li>
          </div>
          <div v-else>
            <li><a href="/allItems">Products</a></li>
            <li><a href="/Cart">Cart</a></li>
            <li v-on:click="disconnect"><a href="/login">Log Out</a></li>
          </div>
        </ul>    
    </div>
</template>

<script>
  export default {
    data(){
      return{
        isConnected: false, 
      }
    },
    methods:{
        async disconnect(){
          localStorage.setItem("userID",null);
        }
    },
    async mounted(){
        if(localStorage.getItem("userID")!="null")this.isConnected = true
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