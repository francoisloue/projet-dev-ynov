<template>
    <div>
      <h1>Login</h1>
      <label for="mail">Adresse mail :</label>  
      <input id="mail" type="text" v-model="mail">
      <label for="mdp">Mots de passe :</label>  
      <input id="mdp" type="password" v-model="password"/>
      <input type="button" value="Login" v-on:click="login()"/>
      <p v-if="errorLogin">{{ errorLogin }}</p>
    </div>
</template>


<script>
import axios from 'axios';

export default {
  data(){
    return{
        mail:"",
        password:"",
        errorLogin: "",
    }
  },
  methods:{
    async login(){
      const req = await axios.post("http://localhost/users/login",JSON.stringify({
        "mail":this.mail,
        "password":this.password,
      }))
      const res = await req.data
      if(res != false){
        localStorage.setItem("userID",res)
        this.$router.push("/allItems")
      }else{
        this.errorLogin = "Error with your Email or password"
      }  
    }
  },
  async mounted(){
    if(localStorage.getItem("userID")!="null")this.$router.push("/allItems");
  }
}
</script>

<style>


</style>