<template>
  <div>
    <search text="text"></search>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Categoria</th>
          <th>Estado</th>
          <th>Opciones</th>
        </tr>
      </thead>
      <tbody id="myTable">
        <tr v-for="(item, index) in categorie" :key="index">
          <td>{{item.name}}</td>
          <td>
            <button
              v-if="item.is_active"
              type="button"
              v-on:click.prevent="Desactivar(item)"
              class="btn btn-success btn-sm"
            >
              <i class="fas fa-power-off"></i>
            </button>
            <button
              v-else
              type="button"
              v-on:click.prevent="Activar(item)"
              class="btn btn-danger btn-sm"
            >
              <i class="fas fa-power-off"></i>
            </button>
          </td>

          <td>
            <button type="button" class="btn btn-warning btn-sm">Editar</button>
            <button
              type="button"
              v-on:click.prevent="Eliminar(item)"
              class="btn btn-danger btn-sm"
            >Eliminar</button>
          </td>
        </tr>
      </tbody>
    </table>
    <nav></nav>
  </div>
</template>
<script>
import { mapState, mapMutations, mapActions } from "vuex";
import search from "../search.vue";
import spinner from "../spinner.vue";
export default {
  name: "list",
  components: {
    search,
    spinner
  },
  data() {
    return {};
  },
  computed: {
    ...mapState(["categorie"])
  },
  mounted() {
    this.List();
  },
  methods: {
    List() {
      this.$store.dispatch("Listarcategorie");
    },
    Eliminar(item) {
      let url = "Categoria/" + item.id;
      Swal.fire({
        title: `Esta seguro de eliminar ha ${item.name}`,
        text: "Una vez eliminado el registro no se podra recuperar!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, eliminar!"
      }).then(result => {
        if (result.value) {
          axios
            .delete(url)
            .then(response => {
              Swal.fire(
                `${item.name} ha sido eliminado`,
                "Transaccion exitosa.",
                "success"
              );
              this.List();
            })
            .catch(err => {
              Swal.fire("No se puede eliminar!", "success");
            });
        }
      });
    },
    Activar(item) {
      let url = "/Categoria/activar/" + item.id;
      axios.put(url).then(response => {
        this.List();
        console.log(response.data);
      });
    },
    Desactivar(item) {
      let url = "/Categoria/desactivar/" + item.id;
      axios.put(url).then(response => {
        this.List();
        console.log(response.data);
      });
    }
  }
};
</script>
