<template>
    <div>
      <h1>Register</h1>
      <label for="mail">mail :</label>  
      <input id="email" type="text" v-model="mail">
      <label for="username">username :</label>  
      <input id="username" type="text" v-model="username">
      <label for="password">Password :</label>  
      <input id="password" type="password" v-model="password"/>
      <label for="confPassword">Confirm Password :</label>  
      <input id="confPassword" type="password" v-model="confirmPassword"/>
      <label for="address">Adresse :</label>
      <input id="address" type="text" v-model="address"/>
      <label for="type"></label>
      <input type="button" value="Sign-in" v-on:click="register()"/>
      <h1>{{ errorMessage }}</h1>
    </div>
</template>
<script>
import axios from 'axios';

export default {
  data(){
    return{
        username:"",
        mail:"",
        password:"",
        confirmPassword:"",
        address:"",
        errorMessage:"",
    }
  },
  methods:{
    async register(){
      if(!this.username||!this.password||!this.mail||!this.address){
        this.errorMessage="Please fill all fields ."
      }
      else{
        const post = await axios.post("http://localhost/projet-dev-ynov/projet-dev-back/createUser.php",JSON.stringify({
            "username": this.username,
            "password":this.password,
            "mail":this.mail,
            "address":this.address,
        }))
        const res = await post.data
        console.log(await res)
      }
    }
  },
  watch:{

  }
}
</script>

<style>
.navbar ul {
    position: fixed;
    list-style-type: none;
    margin: 0;
    top: 0;
    right: 0;
    left: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333;
  }
.navbar li {
  float: left;
}

.navbar li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}
</style>