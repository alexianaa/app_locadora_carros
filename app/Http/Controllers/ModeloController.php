<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use Illuminate\Http\Request;
use App\Http\Requests\StoreModeloRequest;
use Ramsey\Uuid\Type\Integer;  
use Illuminate\Support\Facades\Storage;

class ModeloController extends Controller
{
    private $modelo;

    public function __construct(Modelo $modelo){
        $this->modelo = $modelo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $modelos = $this->modelo->all();
        return response()->json($modelos); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreModeloRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreModeloRequest $request)
    {
        $request->validated();

        $image = $request->file('imagem');
        $image_urn = $image->store('imagens/modelos','public'); 

        $modelo = $this->modelo->create([
            'nome' => $request->nome,
            'imagem' => $image_urn,
            'marca_id' => $request->marca_id,
            'numero_portas' => $request->numero_portas,
            'lugares' => $request->lugares,
            'air_bag' => $request->air_bag,
            'abs' => $request->abs,
        ]);

        return response()->json($modelo, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $modelo = $this->modelo->find($id);
        if($modelo === null){
            return response()->json(['erro' => 'este modelo não existe'])->setStatusCode(404);
        }
        return response()->json($modelo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // $request->validated();

        $modelo = $this->modelo->find($id);
        if($modelo === null){
            return response()->json(['erro' => 'Impossível realizar atualização, recurso pesquisado não existe'], 404);
        }

        $image = $request->file('imagem');
        if($image){
            Storage::disk('public')->delete($modelo->imagem);
            $image_urn = $image->store('imagens/modelos','public'); 
            $modelo->update(['imagem' => $image_urn]);
        }
 
        $modelo->update([
            'nome' => $request->nome,
            'marca_id' => $request->marca_id,
            'numero_portas' => $request->numero_portas,
            'lugares' => $request->lugares,
            'air_bag' => $request->air_bag,
            'abs' => $request->abs,
        ]);
        

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
        $modelo = $this->modelo->find($id);

        if($modelo === null){
            return response()->json(['erro' => 'Impossível realizar a exclusão, recurso pesquisado não existe'])->setStatusCode(404);
        }

        if($modelo->imagem) Storage::disk('public')->delete($modelo->imagem);
        $modelo->delete();
        return response()->json(['msg' => 'A exclusão foi realizada com sucesso'],200);
    }
}
