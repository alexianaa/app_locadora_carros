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
                <button type="submit" class="btn btn-primary btn-sm">Adicionar</button>
              </template>
            </card-component>
        </div>
    </div>
  </div>
</template>

<script>

</script>
