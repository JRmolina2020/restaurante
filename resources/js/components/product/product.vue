<template>
  <div class="row">
    <div class="col-lg-4 mt-3">
      <h1>formulario</h1>
    </div>
    <div class="col-lg-8 mt-3">
      <listproduct></listproduct>
    </div>
  </div>
</template>
<script>
import listproduct from "./listproduct.vue";
export default {
  name: "product",
  components: {
    listproduct
  }
};
</script>
