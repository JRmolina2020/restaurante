<template>
  <div>
    <form
      method="POST"
      @submit.prevent="create(form.id)"
      autocomplete="off"
      enctype="multipart/form-data"
    >
      <!-- start name -->
      <div class="form-group">
        <input
          v-model="form.name"
          v-validate="'required|max:30|min:4|alpha_spaces'"
          type="text"
          name="nombre"
          class="form-control"
          :class="{ 'is-invalid': submitted && errors.has('nombre') }"
          placeholder="nombre producto"
        />
        <small class="form-text text-muted">Nombre producto</small>
        <div
          v-if="submitted && errors.has('nombre')"
          class="invalid-feedback"
        >{{ errors.first('nombre') }}</div>
      </div>
      <!-- end name -->
      <!-- start price -->
      <div class="form-group">
        <input
          v-model="form.price"
          v-validate="'required|max:9|min:3|numeric'"
          type="number"
          name="precio"
          class="form-control"
          :class="{ 'is-invalid': submitted && errors.has('precio') }"
          placeholder="precio del producto"
        />
        <small class="form-text text-muted">Precio del producto</small>
        <div
          v-if="submitted && errors.has('precio')"
          class="invalid-feedback"
        >{{ errors.first('precio') }}</div>
      </div>
      <!-- end price -->
      <!-- start description -->
      <div class="form-group">
        <textarea
          v-model="form.description"
          v-validate.continues="'required|max:200|min:10|'"
          type="text"
          rows="2"
          name="descripcion"
          class="form-control"
          :class="{ 'is-invalid': submitted && errors.has('descripcion') }"
          placeholder="Descripcion"
        />
        <small class="form-text text-muted">Descripcion del producto</small>
        <div
          v-if="submitted && errors.has('descripcion')"
          class="invalid-feedback"
        >{{ errors.first('descripcion') }}</div>
      </div>
      <!-- end description -->
      <!-- start categorie_id -->
      <div class="form-group">
        <select
          v-model="form.categorie_id"
          v-validate="'required|'"
          name="categoria"
          class="form-control"
          :class="{ 'is-invalid': submitted && errors.has('categoria') }"
        >
          <option
            v-for="(item, index) in selectCategorie"
            :key="index"
            :value="item.id"
          >{{item.name}}</option>
        </select>
        <small class="form-text text-muted">Categoria</small>
        <div
          v-if="submitted && errors.has('categoria')"
          class="invalid-feedback"
        >{{ errors.first('categoria') }}</div>
      </div>
      <!-- end categorie_id -->
      <!-- start image -->
      <div class="form-group">
        <input
          name="imagen"
          id="imagen"
          v-validate="'ext:jpeg,jpg,png,PNG,JPG'"
          @change="getImage"
          accept="image/*"
          class="form-control"
          type="file"
          :class="{ 'is-invalid': submitted && errors.has('imagen') }"
          placeholder="Imagen del producto"
        />
        <small class="form-text text-muted">Imagen del producto</small>
        <div
          v-if="submitted && errors.has('imagen')"
          class="invalid-feedback"
        >{{ errors.first('imagen') }}</div>
      </div>
      <!-- end image -->
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
        name: null,
        price: null,
        description: null,
        image: null,
        categorie_id: null
      },
      submitted: true,
      selectCategorie: null
    };
  },
  mounted() {
    this.getSelectdata();
  },
  methods: {
    create(id) {
      this.$validator.validate().then(valid => {
        if (valid) {
          if (id) {
            let url = "Producto/" + id;
            axios.put(url, this.form).then(response => {
              this.clear();
              this.$store.dispatch("Listarproducto");
              Swal.fire("Editar!", "Editado con exito!", "success");
            });
          } else {
            let url = "Producto/";
            var data = new FormData();
            data.append("name", this.form.name);
            data.append("price", this.form.price);
            data.append("description", this.form.description);
            data.append("image", this.form.image);
            data.append("categorie_id", this.form.categorie_id);
            axios
              .post(url, data)
              .then(response => {
                this.$store.dispatch("Listarproducto");
                this.clear();
              })
              .catch(error => {
                console.log(error.response);
              });
          }
        }
      });
    },
    getImage(event) {
      //Asignamos la imagen a  nuestra data
      this.form.image = event.target.files[0];
    },
    getSelectdata() {
      axios
        .get("Categoria/select")
        .then(response => {
          this.selectCategorie = response.data;
        })
        .catch(e => {
          console.log(e);
        });
    },
    show(item) {
      this.form.id = item.id;
      this.form.name = item.name;
      this.form.price = item.price;
      this.form.description = item.description;
      this.form.categorie_id = item.idc;
      this.form.image = item.image;
    },

    clear() {
      this.form.name = null;
      this.form.price = null;
      this.form.description = null;
      this.form.id = null;
      this.form.categorie_id = null;
      this.$validator.reset();
      $("#imagen").val("");
    }
  }
};
</script>
