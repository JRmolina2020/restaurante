<template>
  <div>
    <div class="row">
      <div class="col-lg-12">
        <form method="POST" @submit.prevent="create(form.id)" autocomplete="off">
          <div class="form-group">
            <input
              v-model="form.name"
              v-validate="'required|max:15|min:4|alpha_spaces'"
              type="text"
              name="name"
              class="form-control"
              :class="{ 'is-invalid': submitted && errors.has('name') }"
              placeholder="nombre categoria"
            />
            <small class="form-text text-muted">Nombre categoria</small>
            <div
              v-if="submitted && errors.has('name')"
              class="invalid-feedback"
            >{{ errors.first('name') }}</div>
          </div>
          <button
            v-if="form.id==null"
            :disabled="errors.any()"
            type="submit"
            class="btn btn-primary btn-sm"
          >Guardar</button>
          <button v-else :disabled="errors.any()" type="submit" class="btn btn-warning btn-sm">
            <i class="material-icons">edit</i>
          </button>
          <button type="button" v-on:click.prevent="clear" class="btn btn-danger btn-sm">Cancelar</button>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  $_veeValidate: {
    validator: "new"
  },

  data() {
    return {
      form: {
        id: null,
        name: null
      },
      submitted: true
    };
  },

  methods: {
    create(id) {
      this.$validator.validate().then(valid => {
        if (valid) {
          if (id) {
            let url = "Categoria/" + id;
            axios.put(url, this.form).then(response => {
              this.clear();
              this.$store.dispatch("Listarcategorie");
              Swal.fire("Editar!", "Editado con exito!", "success");
            });
          } else {
            var url = "Categoria";
            axios
              .post(url, {
                name: this.form.name
              })
              .then(response => {
                this.$store.dispatch("Listarcategorie");
                this.clear();
              })
              .catch(error => {
                console.log(error.response.data);
              });
          }
        }
      });
    },
    show(item) {
      this.form.id = item.id;
      this.form.name = item.name;
    },
    clear() {
      this.form.name = null;
      this.form.id = null;
      this.$validator.reset();
    }
  }
};
</script>
