<template>
    <div class="container">
        <h1>Username :{{ userInfo.username }}</h1>
        <ul>
            <li>id: {{ userInfo.id }}</li>
            <li>mail: {{ userInfo.mail }}</li>
            <li>registration Date: {{ userInfo.registrationDate }}</li>
            <li>address: {{ userInfo.address }}</li>
            <div class="changeUserType">
                <select v-model="chosenType">
                    <option v-for="typeUser in userTypes"  v-bind:value="typeUser.id" v-bind:key="typeUser.id">{{ typeUser.name }}</option>
                </select>
                <button v-on:click="this.changeUserType()">Confirm</button>
                {{chosenType}}
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
        const req = axios.get("http://localhost/users/" + this.idFromQuery)
        const res = await (await req).data
        this.userInfo = await res[0]
    },
    async getAllUserType(){
          const req = await axios.get("http://localhost/users/userType")
          this.userTypes = await req.data
    },
    async changeUserType(){
        console.log(this.userInfo.id)
        const req = await axios.post("http://localhost/projet-dev-ynov/projet-dev-back/changeUserType.php",{
            "userId": this.userInfo.id,
            "userType": this.chosenType,
        })
        console.log(req)
    },
},
    async mounted(){
        this.idFromQuery = this.$route.query.id
        await this.getAllUserType();
        await this.getAllInfoUser()
    },

}
</script>

<style>


</style>