<template>
    <div class="container">
        <div v-for="rand in random" v-bind:key="rand.id">
            {{ rand }}
        </div>
    </div>
  </template>
  
  
  <script>
  import axios from 'axios'
  export default {
    data(){
      return{
        random: [],
      }
    },
    methods:{
        async getRandom(){
            const req = await axios.post("http://localhost/projet-dev-ynov/projet-dev-back/getRandomItems.php",{
                idCategory: 1,
                quantity: 5,
            })
            const res = await req.data
            this.random = res
        }
    },
    async mounted(){
        await this.getRandom()
    },
    watch:{
      
    }
  }
  </script>
  
  <style>

  </style>