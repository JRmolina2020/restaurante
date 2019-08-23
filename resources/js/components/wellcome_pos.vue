<template>
  <div>
    <!-- stars buttons data -->
    <h1 class="text align-center">PACCO EXPRESS</h1>
    <div class="row mt-4">
      <div class="col lg-12">
        <button type="button" @click="selectcategorie=0" class="btn btn-danger">All</button>
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
      <div class="col-lg-8 col-md-6 mt-3">
        <div class="row">
          <div
            class="col-lg-4 mt-3"
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
                <h5 class="card-title">{{prod.name}}</h5>
                <p
                  class="card-text"
                >Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="btn btn-warning">${{prod.price | currency}}</a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4 mt-3">CARRITO DE COMPRA</div>
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
      selectcategorie: 0
    };
  },
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
          console.log(response.data);
        })
        .catch(e => {
          console.log(e);
        });
    },
    filterProduct(id) {
      console.log(id);
    }
  }
};
</script>
