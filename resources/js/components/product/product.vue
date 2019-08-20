<template>
  <div class="row">
    <div class="col-lg-4 mt-3">
      <form_producto ref="form_product"></form_producto>
    </div>
    <div class="col-lg-8 mt-3">
      <listproduct v-on:show="show"></listproduct>
    </div>
  </div>
</template>
<script>
import listproduct from "./listproduct.vue";
import form_producto from "./form_product.vue";
export default {
  name: "product",
  components: {
    listproduct,
    form_producto
  },
  methods: {
    show(item) {
      this.$refs.form_product.show(item);
    }
  }
};
</script>
