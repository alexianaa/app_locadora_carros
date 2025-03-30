<template>
  <div :class="estilo" role="alert">
   {{ message }}
   <hr>
   <p>{{ detalhes.mensagem }}</p>

   <ul v-if="detalhes.dados">
    <li v-for="e, key in detalhes.dados" :key="key">{{ e[0] }}</li>
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
