<template>
    <div class="container">
        <div v-for="rand in random">
            {{ rand }}
        </div>
    </div>
  </template>
  
  
  <script>
  import axios from 'axios'
import { getRandomValues } from 'crypto';
  export default {
    data(){
      return{
        random: [],
      }
    },
    methods:{
        async getRandom(){
            axios.post("",{
                idCategory: 1,
                quantity: 5,
            })
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