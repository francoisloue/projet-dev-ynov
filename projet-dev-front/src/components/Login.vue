<template>
    <div>
      <h1>Login</h1>
      <label for="mail">Adresse mail :</label>  
      <input id="mail" type="text" v-model="mail">
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
        mail:"",
        password:"",
    }

  },
  methods:{
    async login(){
      const req = await axios.post("http://localhost/projet-dev-ynov/projet-dev-back/login.php",JSON.stringify({
        "mail":this.mail,
        "password":this.password,
      }))
      const res = await req.data
      if(res != false || res!="error"){
        localStorage.setItem("userID",res)
      }else{
        console.log("Bad password")
      }  
    }
  }
}
</script>

<style>


</style>