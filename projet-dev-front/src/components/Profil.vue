<template>
    <div class="container">
        <h1>Username :{{ userInfo.username }}</h1>
        <ul>
            <li>id: {{ userInfo.id }}</li>
            <li>mail: {{ userInfo.mail }}</li>
            <li>registration Date: {{ userInfo.registrationDate }}</li>
            <li>address: {{ userInfo.address }}</li>
            <p>Change the type of user with this menu</p>
            <div class="changeUserType">
                <select v-model="chosenType">
                    <option v-for="typeUser in userTypes"  v-bind:value="typeUser.id" v-bind:key="typeUser.id">{{ typeUser.name }}</option>
                </select>
                <button v-on:click="this.changeUserType()">Confirm</button>
            </div>
        </ul>
    </div>
</template>


<script>
import axios from 'axios';

export default {
  data(){
    return{
        idFromQuery: "",
        userInfo: {},
        userTypes: [],
        chosenType: "",
    }
  },
  methods:{
    async getAllInfoUser(){
        const req = await axios.get("http://localhost/users/" + this.idFromQuery)
        const res = await req.data
        this.userInfo = await res
    },
    async getAllUserType(){
          const req = await axios.get("http://localhost/users/userType")
          this.userTypes = await req.data
    },
    async changeUserType(){
        const req = await axios.put("http://localhost/users/changeType",{
            "userId": this.userInfo.id,
            "userType": this.chosenType,
        })
        const res = await req.data
        if(res==true)console.log("completely changed")
    },
    async redirectUser(){
        if("null"!=localStorage.getItem("userID")){
            const userID = localStorage.getItem("userID")
            console.log(userID)
            if(userID==2){
              this.$router.push({ path: '/newItem'})
            }else if(userID==1){
                this.$router.push({ path: '/allItems'})
            }
          } else {
            this.$router.push({ path: '/login'})
          }
    }
},
    async mounted(){
        this.redirectUser();
        this.idFromQuery = this.$route.query.id
        await this.getAllUserType();
        await this.getAllInfoUser()
    },

}
</script>

<style>


</style>