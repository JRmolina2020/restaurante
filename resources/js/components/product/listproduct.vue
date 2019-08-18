<template>
  <div>
    <input class="form-control" placeholder="Buscar categoria" v-model="filters.name.value" />
    <v-table
      :data="product"
      :filters="filters"
      :currentPage.sync="currentPage"
      :pageSize="4"
      @totalPagesChanged="totalPages = $event"
      class="table table-bordered mt-3"
    >
      <thead slot="head">
        <th>Nombre</th>
        <th>Precio</th>
        <th>Descripcion</th>
        <th>Categoria</th>
        <th>Estado</th>
        <th>Opciones</th>
      </thead>
      <tbody slot="body" slot-scope="{displayData}">
        <tr v-for="row in displayData" :key="row.id">
          <td>{{ row.name }}</td>
          <td>{{ row.price }}</td>
          <td>
            <!-- description -->
            <button
              type="button"
              class="btn btn-primary btn-sm"
              data-toggle="modal"
              data-target="#modeldescription"
              @click="infodescription(row)"
            >
              <i class="material-icons md-18">keyboard_arrow_up</i>
            </button>
            <!-- end description -->
          </td>
          <td>{{row.name_categorie}}</td>
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
            <button type="button" class="btn btn-warning btn-sm" @click="$emit('show',row)">
              <i class="material-icons md-18">edit</i>
            </button>
            <button type="button" v-on:click.prevent="destroy(row)" class="btn btn-danger btn-sm">
              <i class="material-icons md-18">delete_sweep</i>
            </button>
          </td>
        </tr>
      </tbody>
    </v-table>
    <smart-pagination :currentPage.sync="currentPage" :totalPages="totalPages" />
    <!-- Modal info description start -->
    <div
      class="modal fade"
      id="modeldescription"
      tabindex="-1"
      role="dialog"
      aria-labelledby="modelTitleId"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <h5 class="text-center">{{info.name}}</h5>
            <img v-bind:src="info.image" class="img-fluid mx-auto d-block" />
            <p class="text-center">{{info.description}}</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">cancelar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- end modal description info -->
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
    return {
      filters: {
        name: { value: "", keys: ["name", "is_active"] }
      },
      currentPage: 1,
      totalPages: 0,
      info: {
        name: null,
        description: null,
        image: null
      }
    };
  },
  computed: {
    ...mapState(["product"])
  },
  mounted() {
    this.List();
  },
  methods: {
    List() {
      this.$store.dispatch("Listarproducto");
    },
    destroy(item) {
      let url = "Producto/" + item.id;
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
      let url = "Producto/activar/" + item.id;
      axios.put(url).then(response => {
        this.List();
      });
    },

    deactivate(item) {
      let url = "Producto/desactivar/" + item.id;
      axios.put(url).then(response => {
        this.List();
        
      });
    },
    infodescription(item) {
      this.info.name = item.name;
      this.info.description = item.description;
      this.info.image = item.image;
    }
  }
};
</script>


