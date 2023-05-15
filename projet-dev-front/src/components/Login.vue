<template>
  <div style="display: flex; justify-content: center; align-items: center;">
    <div class="login-form">
      <h1>Login</h1>
      <label for="mail">Adresse mail :</label>  
      <input id="mail" type="text" v-model="mail">
      <label for="mdp">Mot de passe :</label>  
      <input id="mdp" type="password" v-model="password"/>
      <input type="button" value="Login" v-on:click="login()"/>
      <p v-if="errorLogin" style="color: red;justify-content: center; align-items: center;"><v-icon name="bi-exclamation-octagon-fill" fill="red" animation="wrench"/>    {{ errorLogin }}</p>
      <p style="display: flex; justify-content: center; align-items: center;">Vous n'avez pas encore de compte ? Créez en un maintenant<v-icon name="bi-arrow-right-short" scale="2.0"/><a href="/register">ici</a></p>
    </div>
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
.login-form {
  padding: 1%;
  display: flex;
  flex-direction: column;
  width: 50%;
  margin-top: 10%;
}
</style>