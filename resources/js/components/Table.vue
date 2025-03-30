<template>
  <table class="table table-hover">
    <thead>
      <tr>
        <th v-for="t, index in titulos" :key="index" scope="col">{{ t }}</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="m in dados" :key="m.id">
        <th scope="row">{{ m.id }}</th>
        <td>{{ m.nome }}</td>
        <td> <img :src="'/storage/'+m.imagem" width="30" height="30"></td>
      </tr> 
    </tbody>
  </table>
</template>

<script>
  export default {
    props: ['dados', 'titulos']
  }
</script>
