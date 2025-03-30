<template>
  <div :class="estilo" role="alert">
   {{ message }}
   <hr>
   <div v-if="detalhes.data.id">ID do registro: {{ detalhes.data.id }}</div>
   <ul v-if="detalhes.data.errors">
    <li v-for="e, key in detalhes.data.errors" :key="key">{{ e[0] }}</li>
   </ul>
  </div>
</template>

<script>
    export default {
      props: ['message', 'type', 'detalhes'],
      computed: {
        estilo() {
          return "alert alert-" + this.type;
        }
      }
    }
</script>
