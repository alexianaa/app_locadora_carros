<template>
  <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Buscar de marcas</div>

                <div class="card-body">
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

                </div>

                <div class="card-footer d-grid d-md-flex justify-content-md-end"> 
                    <button type="submit" class="btn btn-primary btn-sm">Pesquisar</button>
                </div>

            </div>
        </div>
    </div>
  </div>
</template>

<script>

</script>
