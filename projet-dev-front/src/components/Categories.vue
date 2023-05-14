<template>
    <div class="allCategories">
        <div class="category" v-for="category in this.allCategories" v-bind:key="category.id">
            <h1>Category Name: {{ category.name }}</h1>
            <button v-on:click="deleteCategory(category.id)">Delete</button>
        </div>
    </div>
</template>


<script>
import axios from 'axios';

export default {
  data(){
    return{
        allCategories: [],
        currentUser: {},
    }
  },
  methods:{
    async getAllCategories(){
        const req = await axios.get("http://localhost/category")
        const res = await req.data
        this.allCategories = await res
    },
    async getUserInfo(){
        if(localStorage.getItem("userID")!="null"){
            const req = await axios.get("http://localhost/users/"+localStorage.getItem("userID"))
            const res = await req.data
            this.currentUser = await res
            if(this.currentUser.userType!=2){
                this.$router.push({path: "/allItems"})
            }
        } else {
            this.$router.push({path: "/login"});
        }
    },
    async deleteCategory(categoryID){
        const req = await axios.delete("http://localhost/category/" + categoryID)
        const res = await req.data
        if(res!=true)alert("Error while deleting category")
        await this.getAllCategories();
        }
  },
  async mounted(){
    await this.getUserInfo();
    await this.getAllCategories();
  }
}
</script>

<style>

.allCategories{
    margin-top:5%;
    display: flex;
	flex-direction: column !important;
	flex-wrap: wrap;
	justify-content: center;
	align-items: stretch;
	align-content: stretch;
    width: 100%;
    height: 100%;
}
</style>