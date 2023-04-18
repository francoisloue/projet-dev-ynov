<template>
    <div class="container">
        <div class="info">
            <h1>{{ item.name }}</h1>
            <img v-bind:src="item.imageURL" v-bind:alt="item.name +' image' "/>
            <p>Price : {{ item.price }}</p>
            <p>Description: {{ item.description }}</p>
            <p>Category: {{ category.name }}</p>
            <button>Add To Cart</button>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
  export default {
    data(){
      return{
        item:{},
        idFromQuery: 0,
        category:{},
      }
    },
    methods:{
        async getInfoItem(){
            const req = await axios.get("http://localhost/items/" + this.idFromQuery);
            const res = await req.data
            this.item = await res;
        },
        async getCategory(){
            const req = await axios.get("http://localhost/category/" + this.item.categoryID)
            const res = await req.data;
            this.category  = await res
        }
    },
    async mounted(){
        this.idFromQuery = this.$route.query.id;
        await this.getInfoItem();
        await this.getCategory();
    },
    watch:{
      
    }
  }
</script>

<style>
.container{
	display: flex;
	flex-direction: row;
	flex-wrap: nowrap;
	justify-content: center;
	align-items: stretch;
	align-content: stretch;
    width: 100%;
    height: 100%;
}

</style>