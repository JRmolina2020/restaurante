<template>
  <div>
    <input class="form-control" id="myInput" type="text" placeholder="Buscar" />
    <br />
  </div>
</template>
<script>
export default {
  name: "search",
  props: ["text"],
  data() {
    return {};
  },
  mounted() {
    $(document).ready(function() {
      $("#myInput").on("keyup", function() {
        var value = $(this)
          .val()
          .toLowerCase();
        $("#myTable tr").filter(function() {
          $(this).toggle(
            $(this)
              .text()
              .toLowerCase()
              .indexOf(value) > -1
          );
        });
      });
    });
  }
};
</script>
