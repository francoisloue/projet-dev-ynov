<template>
    <div>
      <h1>Login</h1>
      <label for="mail">Adresse mail :</label>  
      <input id="mail" type="text" v-model="email">
      <label for="mdp">Mots de passe :</label>  
      <input id="mdp" type="password" v-model="password"/>
      <input type="button" value="Login" v-on:click="login()"/>
    </div>
</template>


<script>
import axios from 'axios';

export default {
  data(){
    return{
      email:"",
      password:"",
    }

  },
  methods:{
    async login(){
      const req = await axios.post("http://localhost/48h_back/login.php",JSON.stringify({
        "email":this.email,
        "password":this.password,
      }))
      const res = await req.data
      if(res != false){
        console.log("sucessfull login")
      }else{
        console.log("Bad password")
      }  
    }
  }
}
</script>

<style>


</style>