<template>
  <div>
    <input class="form-control" placeholder="Buscar categoria" v-model="filters.name.value" />
    <v-table
      :data="categorie"
      :filters="filters"
      :currentPage.sync="currentPage"
      :pageSize="6"
      @totalPagesChanged="totalPages = $event"
      class="table table-bordered mt-3"
    >
      <thead slot="head">
        <th>Nombre</th>
        <th>Estado</th>
        <th>Opciones</th>
      </thead>
      <tbody slot="body" slot-scope="{displayData}">
        <tr v-for="row in displayData" :key="row.id">
          <td>{{ row.name }}</td>
          <td>
            <button
              v-if="row.is_active"
              type="button"
              v-on:click.prevent="deactivate(row)"
              class="btn btn-success btn-sm"
            >
              <i class="material-icons md-18">power_settings_new</i>
            </button>
            <button
              v-else
              type="button"
              v-on:click.prevent="activate(row)"
              class="btn btn-danger btn-sm"
            >
              <i class="material-icons md-18">power_settings_new</i>
            </button>
          </td>
          <td>
            <button type="button" class="btn btn-warning btn-sm" @click="$emit('show',row)">Editar</button>
            <button
              type="button"
              v-on:click.prevent="destroy(row)"
              class="btn btn-danger btn-sm"
            >Eliminar</button>
          </td>
        </tr>
      </tbody>
    </v-table>
    <center>
      <smart-pagination :currentPage.sync="currentPage" :totalPages="totalPages" />
    </center>
  </div>
</template>
<script>
import { mapState, mapMutations, mapActions } from "vuex";
import search from "../search.vue";
import spinner from "../spinner.vue";
import SmartTable from "vuejs-smart-table";
Vue.use(SmartTable);

export default {
  name: "list",
  components: {
    search,
    spinner
  },
  data() {
    return {
      filters: {
        name: { value: "", keys: ["name", "is_active"] }
      },
      currentPage: 1,
      totalPages: 0
    };
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
    destroy(item) {
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
              Swal.fire({
                type: "error",
                title: "Oops...",
                text: `${item.name} tiene productos asignados`
              });
            });
        }
      });
    },
    activate(item) {
      let url = "/Categoria/activar/" + item.id;
      axios.put(url).then(response => {
        this.List();
      });
    },

    deactivate(item) {
      let url = "/Categoria/desactivar/" + item.id;
      axios.put(url).then(response => {
        this.List();
      });
    }
  }
};
</script>
