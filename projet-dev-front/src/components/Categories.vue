<template>
    <div class="allCategories">
        <div class="category" v-for="category in this.allCategories" v-bind:key="category.id">
            <div>
                <p>Name : {{ category.name }}</p>
            </div>
            <button v-on:click="deleteCategory(category.id)" style="width: 10%;"><v-icon name="bi-trash" scale="1" /></button>
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
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
.category {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    width: 50%;
    border-bottom: solid;
    padding: 1%;
    margin: 1%;
}
</style>