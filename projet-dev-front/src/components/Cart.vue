<template>
  <div class="container">
    <div class="left-cart-container">
      <h1 style="display:flex;align-items: center; justify-content: center;">Your Cart</h1>
      <div class="cart" v-for="item in this.items" v-bind:key="item.id" v-on:click="this.goToArticle(item.productID)">
        <div style="display: flex; flex-direction: column; width: 50%">
          <p>name : {{ item.name }}</p>
          <p>quantity {{ item.quantity }}</p>
          <p>unit price : {{ item.price }}</p>
          <button v-on:click="this.removeArticle(item.id)" style="width: 50%;">
            <v-icon name="bi-trash" scale="1.5" />
          </button>
        </div>
        <div style="display: flex; width: 50%; justify-items: center; align-items: center; padding: 3%;">
            <img v-bind:src="item.imageURL" v-bind:alt="item.name +' image' " style="height: 100%; width: 100%;" />
        </div>
      </div>
    </div>
    <div class="right-cart-container">
      <div v-if="this.items.length" style="display: flex; flex-direction: column;width: 100%;">
        <div v-for="item in this.items" v-bind:key="item.id" style="border-bottom: solid; display: flex; flex-direction: column; justify-content: center;">
            <h5 style="margin: 0;margin-top: 3%;">{{ item.name }} x {{ item.quantity }} : {{ item.quantity*item.price }}€</h5>
        </div>
        <div>
            <h1 style="margin: 0;">Total Cart : {{ this.totalPrice }}€</h1>
            <button> <v-icon name="bi-credit-card-fill" scale="1.5" /></button>
    </div>
      </div>
      <div v-else>
        <h1>No Item for now</h1>
        <button v-on:click="goShopping">Start Shopping Now</button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      items: [],
      idUser: 0,
      totalPrice: 0,
    };
  },
  methods: {
    async getAllItems() {
      const req = await axios.get("http://localhost/cart/" + this.idUser);
      const res = await req.data;
      this.items = await res;
      await this.calcTotalPrice();
    },
    async goToArticle(idItem) {
      this.$router.push({ path: "/itemProfil", query: { id: idItem } });
    },
    async removeArticle(idItem) {
      const req = await axios.delete("http://localhost/cart/" + idItem);
      const res = await req.data;
      console.log(res);
      if (res == true) this.getAllItems();
    },
    async calcTotalPrice() {
      this.totalPrice = 0;
      this.items.forEach((item) => (this.totalPrice += item.price));
    },
    async goShopping() {
      this.$router.push({ path: "/allItems" });
    },
  },
  async mounted() {
    this.idUser = localStorage.getItem("userID");
    await this.getAllItems();
  },
  watch: {},
};
</script>

<style>
.container {
  display: flex;
  flex-direction: row;
  flex-wrap: nowrap;
  justify-content: center;
  align-items: stretch;
  align-content: stretch;
  width: 100%;
  height: 100%;
}
.cart {
  display: flex;
  flex-direction: row;
  flex-wrap: nowrap;
  justify-content: center;
  align-items: stretch;
  align-content: stretch;
  margin: 5%;
  border: solid;
  padding: 5%;
}
.left-cart-container {
  display: flex;
  flex-direction: column;
  width: 50%;
}
.right-cart-container {
  display: flex;
  width: 50%;
  border-left: solid;
  align-items: center;
  padding: 5%;
}
</style>
