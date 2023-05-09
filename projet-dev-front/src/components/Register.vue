<template>
  <div style="display: flex; justify-content: center; align-items: center;">
    <div class="register-form">
      <h1>Register</h1>
      <label for="mail"><v-icon name="bi-envelope" scale="1.7"/> Adresse Mail :</label>  
      <input id="email" type="text" v-model="mail" placeholder="Ex : michel.dupont@gmail.com">
      <label for="username"><v-icon name="bi-person" scale="2.0"/> Identifiant :</label>  
      <input id="username" type="text" v-model="username" placeholder="Ex : Michel Dupont">
      <label for="password"><v-icon name="bi-shield-lock" scale="1.7"/> Mot de passe :</label>  
      <input id="password" type="password" v-model="password" placeholder="Ex : ***************"/>
      <label for="confPassword"><v-icon name="bi-shield-lock" scale="1.7"/> Confirmer le mot de passe :</label>  
      <input id="confPassword" type="password" v-model="confirmPassword" placeholder="Ex : ***************"/>
      <label for="address"><v-icon name="bi-pin-map" scale="1.7"/> Adresse :</label>
      <input id="address" type="text" v-model="address" placeholder="Ex : 1 rue De la Paix, 49000 Angers"/>
      <label for="type"></label>
      <input type="button" value="Sign-in" v-on:click="register()"/>
      <h1>{{ errorMessage }}</h1>
    </div>
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
        const post = await axios.post("http://localhost/users/register",JSON.stringify({
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
  async mounted(){
    if(localStorage.getItem("userID")!="null")this.$router.push("/allItems");
  },
  watch:{

  }
}
</script>

<style>
.register-form {
  padding: 1%;
  display: flex;
  flex-direction: column;
  width: 50%;
  margin-top: 6%;
}
</style>