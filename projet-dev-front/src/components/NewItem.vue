<template>
    <div style="margin-top: 4%;">
        <h1>Create a new Item to sell</h1>
        <label for="name">* Item name :</label>
        <input type="text" placeholder="enter the item name" v-model="itemName">
        <label for="description">Item description :</label>
        <input type="text" placeholder="enter the item description" v-model="itemDescription">
        <label for="price">* Item Price :</label>
        <input type="text" placeholder="enter the item price" v-model="itemPrice">
        <label for="categroyID">* Item Category :</label>
        <select v-model="itemCategory">
            <option value="test">test</option>
        </select>
        <label for="imageURL">Item Illustration :</label>
        <input type="url" placeholder="place here your image URL" v-model="itemImageURL">
        <input type="submit" v-on:click="$event=> CreatNewItem()">
        <h3>{{ errorMessage }}</h3>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return{
            itemName:"",
            itemDescription:"",
            itemCategory:"",
            itemPrice:"",
            itemImageURL:"",
            errorMessage:""
        }
    },
    methods: {
        async CreatNewItem() {
            if(!this.itemCategory||!this.itemName||!this.itemPrice) {
                this.errorMessage = "One of the required fields is empty"
            } else {
                let data = JSON.stringify({
                    "itemName": this.itemName,
                    "itemDescription": this.itemDescription,
                    "itemCategory": this.itemCategory,
                    "itemPrice": this.itemPrice,
                    "itemImageURL": this.itemImageURL
                });
                const toCreate = axios.post("http://localhost/items", data)
                const res = await toCreate.data
                console.log(await res)
            }
        }
    }
}


</script>