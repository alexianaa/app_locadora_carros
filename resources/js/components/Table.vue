<template>
  <table class="table table-hover">
    <thead>
      <tr>
        <th v-for="t, index in titulos" :key="index" scope="col" class="text-uppercase">{{ t.titulo }}</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="obj,chave in dadosFiltrados" :key="chave">
        <td v-for="valor,chaveValor in obj" :key="chaveValor">
          <span v-if="titulos[chaveValor].dado == 'img'"> <img :src="'/storage/'+valor" width="30" height="30" > </span> 
          <span v-else>{{ valor }}</span> 
        </td>
      </tr> 
    </tbody>
  </table>
</template>

<script>
  export default {
    props: ['dados', 'titulos'],
    computed: {
      dadosFiltrados(){
        let dadosFiltrados = []
        let colunas = Object.keys(this.titulos);

        this.dados.map((item,chave) => {
          let itemFiltrado = {};
          colunas.forEach(campo => {
            itemFiltrado[campo] = item[campo];
          })
          dadosFiltrados.push(itemFiltrado);
        })
        
        return dadosFiltrados;
      }
    }
  }
</script>
