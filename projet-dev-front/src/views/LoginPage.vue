<template>
    <NavBar />
    <Login />
    <div>
    </div>
</template>


<script>
import NavBar from "@/components/NavBar.vue"
import Login from "@/components/Login.vue"

export default {
  data(){
    return{
      
    }

  },
  methods:{

  },
  components:{
    NavBar,
    Login,
  }
}
</script>

<style>
.container{
  padding-top: 10%;
    display: flex;
      flex-direction: column;
      flex-wrap: nowrap;
      justify-content: flex-start;
      align-items: stretch;
      align-content: stretch;
  }
</style>