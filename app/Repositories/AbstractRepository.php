<?php

namespace App\Repositories;
use Illuminate\Database\Eloquent\Model; 

abstract class AbstractRepository {

  private $model;
  public function __construct(Model $model){
    $this->model = $model;
  }

  public function selectAtributosRelacionados($atributos){
    $this->model = $this->model->with($atributos);
  }

  public function filtro($filtros){
    $filtros = explode(';',$filtros);
    foreach ($filtros as $key => $filtro) {
        $condicoes = explode(':',$filtro);
        $this->model = $this->model->where($condicoes[0], $condicoes[1], $condicoes[2]);
    }
  }

  public function selectAtributos($atributos) {
    $this->model = $this->model->selectRaw($atributos);
  }

  public function getResultado() {
    return $this->model->get();
  }

  public function getResultadoPag($num) {
    return $this->model->paginate($num);
  }

}