<template>
  <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
          <!-- BUSCA DE MARCAS -->
           <card-component titulo="Buscar marcas">
              <template v-slot:conteudo>
                <div class="row">
                    <div class="col mb-3">
                      <input-component 
                        titulo="ID" 
                        id="inputId"
                        help="idHelp"
                        texto-ajuda="Opcional. Informe o ID da Marca"
                      > 
                        <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID" v-model="busca.id">
                      </input-component>
                    </div>
                    <div class="col mb-3">
                      <input-component 
                        titulo="Nome" 
                        id="inputNome"
                        help="nomeHelp"
                        texto-ajuda="Opcional. Informe o Nome da marca"
                      > 
                        <input type="text" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="Nome da Marca" v-model="busca.nome">
                      </input-component>
                    </div>
                </div>
              </template>
              <template v-slot:rodape>
                <button type="submit" class="btn btn-primary btn-sm float-end" @click="pesquisar()">Pesquisar</button>
              </template>
           </card-component>

            <!-- LISTAGEM DE MARCAS -->
            <card-component titulo="Relação de marcas">
              <template v-slot:conteudo>
                <table-component 
                  :dados="marcas.data" 
                  :visualizar="{visivel: true, dataToggle: 'modal', dataTarget: '#modalMarcaVisualizar'}"
                  :editar="{visivel: true, dataToggle: 'modal', dataTarget: '#modalMarcaEditar'}"
                  :excluir="{visivel: true, dataToggle: 'modal', dataTarget: '#modalMarcaExcluir'}"
                  :titulos="{
                    id: {titulo: 'ID', dado: 'text'},
                    nome: {titulo: 'NOME', dado: 'text'},
                    imagem: {titulo: 'IMAGEM', dado: 'img'},
                    created_at: {titulo: 'DATA DE CRIAÇÃO', dado: 'date'},
                  }"></table-component>
              </template>
              <template v-slot:rodape>
                <div class="row">
                  <div class="col-10">
                    <paginate-component>
                      <li :class="l.active? 'page-item active' : 'page-item'" v-for="l, number in marcas.links" :key="number" @click="paginacao(l)">
                        <a class="page-link" href="#" v-html="l.label"></a>
                      </li>
                    </paginate-component>
                  </div>
                  <div class="col">
                    <button type="submit" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalMarca" >Adicionar</button>
                  </div>
                </div>
              </template>
            </card-component>
        </div>
    </div>

    <!-- MODAL ADICIONA MARCA -->
    <modal-component id="modalMarca" titulo="Adicionar Marca">

      <template v-slot:alertas>
        <alert-component 
          message="Marca adicionada com sucesso." 
          :detalhes="detalhes" 
          v-if="transacaoStatus == 'success'" 
          :type="transacaoStatus">
        </alert-component>

        <alert-component 
          message="Erro ao adicionar marca: " 
          :detalhes="detalhes" 
          v-if="transacaoStatus == 'danger'" 
          :type="transacaoStatus">
        </alert-component>
      </template>

      <template v-slot:conteudo>
        <div class="form-group">
          <input-component 
            titulo="Nome" 
            id="novoNome"
            help="novoNomeHelp"
            texto-ajuda="Opcional. Informe o Nome da marca"
          > 
            <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp" placeholder="Nome" v-model="nomeMarca">
          </input-component>
        </div>
  
        <div class="form-group">
          <input-component 
            titulo="Imagem" 
            id="novoImagem"
            help="novoImagemHelp"
            texto-ajuda="Opcional. Selecione uma imagem png, jpeg ou jpg."
          > 
            <input type="file" class="form-control" id="novoImagem" aria-describedby="novoImagemHelp" placeholder="Selecione uma imagem" @change="carregarImagem($event)">
          </input-component>
        </div>
      </template>
      <template v-slot:rodape>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
      </template>
    </modal-component>

    <!-- MODAL VER MARCA -->
    <modal-component id="modalMarcaVisualizar" titulo="Visualizar Marca">
      <template v-slot:alertas></template>
      <template v-slot:conteudo>
        <input-component titulo="ID">
          <input type="text" class="form-control mb-3" :value="$store.state.item.id" disabled>
        </input-component>
        <input-component titulo="Nome">
          <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
        </input-component>
        <input-component titulo="Imagem">
          <img v-if="$store.state.item.imagem" :src="'/storage/'+$store.state.item.imagem">
        </input-component>
        <input-component titulo="Data de criação">
          <input type="text" class="form-control" :value="$store.state.item.created_at" disabled>
        </input-component>
      </template>
      <template v-slot:rodape></template>
    </modal-component>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        urlBase: 'http://localhost:8000/api/v1/marca',
        urlPaginacao: '',
        urlFiltro: '',
        nomeMarca: '',
        arquivoImagem: [],
        transacaoStatus: '',
        detalhes: {},
        marcas: {
          data: []
        },
        busca: {
          id: '',
          nome: ''
        }
      }
    },
    mounted() {
      this.carregarLista();
    },
    computed: {
      token() {
        let token = document.cookie
          .split(';')
          .find(index => { return index.includes('token')})
          .split('=');
          
        return 'Bearer ' + token[1]
      }
    },
    methods: {
      pesquisar(){
        let filtro = ''
        for(let chave in this.busca) {
          if(this.busca[chave]){
            if(filtro != '') filtro += ';'
            filtro += chave + ':like:%' + this.busca[chave] + '%'
          }
        }
        if(filtro){
          this.urlFiltro = '&filtro=' + filtro;
          this.urlPaginacao = 'page=1';
        }
        else this.urlFiltro = ''
        this.carregarLista();
      },
      paginacao(l){
        if(l.url) {
          this.urlPaginacao = l.url.split('?')[1];
          this.carregarLista();
        }
      },
      carregarLista(){
        let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro
        console.log(url)

        let config = {
          headers: {
            'Accept': 'application/json',
            'Authorization': this.token
          }
        }

        axios.get(url, config)
          .then(response => {this.marcas = response.data})
          .catch(erro => {console.log(erro)})
      },
      carregarImagem(e){
        this.arquivoImagem = e.target.files
      },
      salvar(){
        let formData = new FormData();
        formData.append('nome',this.nomeMarca);  
        formData.append('imagem',this.arquivoImagem[0]);  

        let config = {
          headers: {
            'Conotent-Type': 'multipart/form-data',
            'Accept': 'application/json',
            'Authorization': this.token
          }
        }
        axios.post(this.urlBase, formData, config)
          .then(response => {
            this.transacaoStatus = 'success';
            this.detalhes = {
              mensagem: "ID do registro: " + response.data.id
            }; 
          })
          .catch(erros => {
            this.transacaoStatus = 'danger';
            this.detalhes = {
              mensagem: erros.response.data.message,
              dados: erros.response.data.errors
            }
          });
      }
    }
  }
</script>
