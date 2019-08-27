<template>
  <div class="bg">
    <!-- stars buttons data -->
    <h1 class="text align-center">PACCO EXPRESS</h1>
    <div class="row mt-4">
      <div class="col lg-12 d-flex justify-content-around">
        <button type="button" @click="selectcategorie=0" class="btn btn-danger">
          <i class="material-icons md-18">view_headline</i>
        </button>
        <button
          v-for="(item, index) in dataCategorie"
          :key="index"
          type="button"
          @click="selectcategorie=item.id"
          class="btn btn-light"
        >{{item.name}}</button>
      </div>
    </div>
    <!-- end buttons data -->
    <!-- stars data producto card -->
    <div class="row mt-5">
      <div class="col-lg-8 col-md-6 col-xs-6 col-sm-6 mt-3">
        <div class="row">
          <div
            class="col-lg-6 mt-3"
            v-for="(prod, index) in dataProduct"
            :key="index"
            v-show="prod.idc==selectcategorie||selectcategorie==0"
          >
            <div class="card" style="width: 14rem;">
              <img
                class="card-img-top"
                width="200"
                height="200"
                :src="`storage/${prod.image}`"
                alt="Card image"
              />
              <div class="card-body">
                <h5 class="card-title text-center title">{{prod.name}}</h5>
                <center>
                  <span
                    class="badge badge-pill badge-success align-bottom"
                  >${{prod.price | currency}}</span>
                </center>
                <div class="d-flex justify-content-around">
                  <button type="button" class="btn btn-warning btn-sm mt-3" @click="addCart(prod)">
                    <i class="material-icons md-18">shopping_cart</i>
                  </button>
                  <button type="button" class="btn btn-warning btn-sm mt-3">
                    <i class="material-icons md-18">open_in_new</i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-xs-6 col-sm-6 mt-3">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-muted">Carrito</span>
          <span class="badge badge-secondary badge-pill">{{dataCart.length}}</span>
        </h4>
        <ul class="list-group mb-3">
          <li class="list-group-item d-flex justify-content-between lh-condensed">
            <div>
              <h6 class="my-0">Producto</h6>
              <small class="text-muted"></small>
            </div>
          </li>
          <li
            v-for="(cart, index) in dataCart"
            :key="index"
            class="list-group-item d-flex justify-content-between lh-condensed"
          >
            <div>
              <h6 class="my-0">{{cart.name}}</h6>
              <small class="text-muted">{{cart.categorie}}</small>
            </div>

            <div>
              <div>
                <i
                  class="material-icons cursor-pointer"
                  v-on:click="decrement(index)"
                >remove_circle_outline</i>
                <span class="text-muted">{{cart.cant}}</span>
                <i
                  class="material-icons cursor-pointer"
                  v-on:click="increment(index)"
                >add_circle_outline</i>
              </div>
              <span class="text-muted">{{cart.cant * cart.price | currency}}</span>
            </div>

            <i class="material-icons cursor-pointer" v-on:click="deleteItemCart(index)">delete</i>
          </li>

          <li class="list-group-item d-flex justify-content-between">
            <span>Total (PESOS)</span>
            <strong>{{Total |currency}}</strong>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "wellcome_pos",
  data() {
    return {
      dataCategorie: [],
      dataProduct: [],
      selectcategorie: 0,
      //llenadocarrito
      dataCart: []
    };
  },
  computed: {
    Total() {
      let total = 0;
      this.dataCart.map(data => {
        total = total + data.cant * data.price;
      });

      return total;
    }
  },
  created() {},
  mounted() {
    this.getCategoriedata();
    this.getProductdata();
  },
  methods: {
    getCategoriedata() {
      axios
        .get("Categoria/select")
        .then(response => {
          this.dataCategorie = response.data;
        })
        .catch(e => {
          console.log(e);
        });
    },
    getProductdata() {
      axios
        .get("Producto/filter")
        .then(response => {
          this.dataProduct = response.data;
        })
        .catch(e => {
          console.log(e);
        });
    },

    //añadir al carrito method push
    addCart(item) {
      const itemcar = {
        id: item.id,
        name: item.name,
        categorie: item.name_categorie,
        cant: 1,
        price: item.price,
        totunit: item.price ** item.cant
      };
      this.dataCart.push(itemcar);
    },
    //borrar del carrito
    deleteItemCart(i) {
      this.dataCart.splice(i, 1);
    },
    increment(i) {
      if (this.dataCart[i].cant >= 5) {
        console.log("no se puede");
      } else {
        this.dataCart[i].cant++;
      }
    },
    decrement(i) {
      if (this.dataCart[i].cant <= 0) {
        console.log("no se puede");
      } else {
        this.dataCart[i].cant--;
      }
    }
  }
};
</script>
<style>
.cursor-pointer {
  cursor: pointer;
}
</style>

