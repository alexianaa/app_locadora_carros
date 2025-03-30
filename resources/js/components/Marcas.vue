<template>
  <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Buscar de marcas</div>

                <div class="card-body">
                  <div class="mb-3">
                    <label for="inputID" class="form-label">ID</label>
                    <input type="number" class="form-control" id="inputID" aria-describedby="idHelp" placeholder="ID">
                    <div id="idHelp" class="form-text">Opcional. Informe o ID do registro</div>
                  </div>
                  <div class="mb-3">
                    <label for="inputNome" class="form-label">Nome</label>
                    <input type="number" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Nome da marca">
                    <div id="nomeHelp" class="form-text">Opcional. Informe o nome da marca</div>
                  </div>
                  <button type="submit" class="btn btn-primary btn-sm">Pesquisar</button>
                </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script>

</script>
