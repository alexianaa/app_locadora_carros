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
                        <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID">
                      </input-component>
                    </div>
                    <div class="col mb-3">
                      <input-component 
                        titulo="Nome" 
                        id="inputNome"
                        help="nomeHelp"
                        texto-ajuda="Opcional. Informe o Nome da marca"
                      > 
                        <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID">
                      </input-component>
                    </div>
                </div>
              </template>
              <template v-slot:rodape>
                <button type="submit" class="btn btn-primary btn-sm">Pesquisar</button>
              </template>
           </card-component>

            <!-- LISTAGEM DE MARCAS -->
            <card-component titulo="Relação de marcas">
              <template v-slot:conteudo>
                <table-component></table-component>
              </template>
              <template v-slot:rodape>
                <button type="submit" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalMarca" >Adicionar</button>
              </template>
            </card-component>
        </div>
    </div>

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
    
  </div>
</template>

<script>
  export default {
    data() {
      return {
        urlBase: 'http://localhost:8000/api/v1/marca',
        nomeMarca: '',
        arquivoImagem: [],
        transacaoStatus: '',
        detalhes: {}
      }
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
