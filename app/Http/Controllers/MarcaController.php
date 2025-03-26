<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;  
use Ramsey\Uuid\Type\Integer;  
use App\Http\Requests\StoreMarcaRequest;
use App\Http\Requests\UpdateMarcaRequest;

class MarcaController extends Controller
{
    private $marca;

    public function __construct(Marca $marca){
        $this->marca = $marca;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $marcas = $this->marca->all();
        return response()->json($marcas); 
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreMarcaRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreMarcaRequest $request)
    {
        $request->validated();

        $image = $request->file('imagem');
        $image_urn = $image->store('imagens','public'); 

        $marca = $this->marca->create([
            'nome' => $request->nome,
            'imagem' => $image_urn
        ]);

        return response()->json($marca);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $marca = $this->marca->find($id);
        if($marca === null){
            return response()->json(['erro' => 'esta marca não existe'])->setStatusCode(404);
        }
        return response()->json($marca);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateMarcaRequest  $request
     * @param  Integer
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateMarcaRequest $request, $id)
    {
        $request->validated();

        $marca = $this->marca->find($id);
        if($marca === null){
            return response()->json(['erro' => 'Impossível realizar atualização, recurso pesquisado não existe'], 404);
        }

        $marca->update($request->all());
        return response()->json(['msg' => 'A atualização foi realizada com sucesso'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $marca = $this->marca->find($id);
        if($marca === null){
            return response()->json(['erro' => 'Impossível realizar a exclusão, recurso pesquisado não existe'])->setStatusCode(404);
        }
        $marca->delete();
        return response()->json(['msg' => 'A exclusão foi realizada com sucesso'],200);
    }
}
