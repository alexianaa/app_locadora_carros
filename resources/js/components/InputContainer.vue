<template>
  <div class="form-group">
    <label :for="id" class="form-label">{{ titulo }}</label>
    <slot></slot>
    <div :id="help" class="form-text text-muted">{{ textoAjuda }}</div>
  </div>
</template>
<script>
  export default { 
    props: ['id', 'titulo', 'help', 'textoAjuda']
   }
</script>