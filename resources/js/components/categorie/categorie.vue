<template>
  <div class="row">
    <div class="col-lg-6 mt-3">
      <form_categorie></form_categorie>
    </div>
    <div class="col-lg-6 mt-3">
      <list></list>
    </div>
  </div>
</template>
<script>
import list from "./list.vue";
import form_categorie from "./form_categorie.vue";
export default {
  name: "categorie",
  components: {
    list,
    form_categorie
  }
};
</script>
