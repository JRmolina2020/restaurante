<template>
  <div>
    <div class="row">
      <div class="col-lg-12">
        <form method="POST" v-on:submit.prevent="create">
          <div class="form-group">
            <input
              type="text"
              class="form-control"
              v-model="form.name"
              a
              placeholder="nombre categoria"
            />
            <small class="form-text text-muted">nombre categoria</small>
          </div>
          <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "form_categorie",
  data() {
    return {
      form: {
        name: null
      }
    };
  },
  methods: {
    create() {
      var url = "Categoria";
      axios
        .post(url, {
          name: this.form.name
        })
        .then(response => {
          this.$store.dispatch("Listarcategorie");
          this.form.name = "";
        })
        .catch(error => {
          console.log(error.response.data);
        });
    }
  }
};
</script>
