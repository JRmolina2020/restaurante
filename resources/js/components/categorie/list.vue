<template>
  <div>
    <input class="form-control" placeholder="Buscar categoria" v-model="filters.name.value" />
    <v-table
      :data="categorie"
      :filters="filters"
      :currentPage.sync="currentPage"
      :pageSize="7"
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
              v-on:click.prevent="Desactivar(row)"
              class="btn btn-success btn-sm"
            >
              <i class="fas fa-power-off"></i>
            </button>
            <button
              v-else
              type="button"
              v-on:click.prevent="Activar(row)"
              class="btn btn-danger btn-sm"
            >
              <i class="fas fa-power-off"></i>
            </button>
          </td>
          <td>
            <button type="button" class="btn btn-warning btn-sm" @click="$emit('show',row)">Editar</button>
            <button
              type="button"
              v-on:click.prevent="Eliminar(row)"
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
