# API DE LOCADORA DE CARROS

![Postman](./postman.png)

A aplicação serve como um estudo de CRUD e criação de API com laravel php, não há interface apenas o back end. 

É possível acessar a documentação para importar no postman usando o arquivo **locadora.postman_collection.json**.

## Funcionalidades

Simulador de locadora de carros

1. Marca
2. Modelo
3. Carro
4. Cliente
5. Locacao

Para cada um acima é possível:

1. Criar
2. Pesquisar todos
3. Pesquisar todos com filtros
4. Pesquisar um
5. Cadastrar
6. Atualizar
7. Excluir

## Relacionamentos

1. Uma marca pode ter 1 ou mais modelos
2. Um modelo tem apenas uma marca
3. Um carro tem apenas 1 modelo
4. Uma locacao tem apenas 1 cliente
5. Uma locacao tem apenas 1 carro
