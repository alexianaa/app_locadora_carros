<template>
  <table class="table table-hover">
    <thead>
      <tr>
        <th v-for="t, index in titulos" :key="index" scope="col" class="text-uppercase">{{ t.titulo }}</th>
        <th v-if="visualizar.visivel || editar.visivel || excluir.visivel"></th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="obj,chave in dadosFiltrados" :key="chave">
        <td v-for="valor,chaveValor in obj" :key="chaveValor">
          <span v-if="titulos[chaveValor].dado == 'img'"> <img :src="'/storage/'+valor" width="30" height="30" > </span> 
          <span v-else>{{ valor }}</span> 
        </td>

        <td>
          <button 
            v-if="visualizar.visivel" 
            class="btn btn-outline-primary btn-sm" 
            :data-bs-toggle=visualizar.dataToggle 
            :data-bs-target=visualizar.dataTarget 
            @click="setStore(obj)"
          >
            Visualizar
          </button>
        </td>

        <td>
          <button 
          v-if="editar.visivel" 
          class="btn btn-outline-primary btn-sm" 
          :data-bs-toggle=editar.dataToggle 
          :data-bs-target=editar.dataTarget 
          @click="setStore(obj)"
          >
            Editar
          </button>
        </td>

        <td>
          <button 
          v-if="excluir.visivel" 
          class="btn btn-outline-danger btn-sm" 
          :data-bs-toggle=excluir.dataToggle 
          :data-bs-target=excluir.dataTarget
          @click="setStore(obj)"
          >
            Excluir
          </button>
        </td>

      </tr> 
    </tbody>
  </table>
</template>

<script>
  export default {
    props: ['dados', 'titulos', 'visualizar', 'editar', 'excluir'],
    methods: {
      setStore(obj){
        this.$store.state.item = obj;
      }
    },
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
