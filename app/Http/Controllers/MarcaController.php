<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Support\Facades\Storage;
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
        $marcas = $this->marca->with('modelos')->get();
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
        $image_urn = $image->store('imagens/marcas','public'); 

        $marca = $this->marca->create([
            'nome' => $request->nome,
            'imagem' => $image_urn
        ]);

        return response()->json($marca, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $marca = $this->marca->with('modelos')->find($id);
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

        $image = $request->file('imagem');
        if($image){
            Storage::disk('public')->delete($marca->imagem);
            $image_urn = $image->store('imagens/marcas','public'); 
            $marca->update(['imagem' => $image_urn]);
        }

        if($request->nome) {
            $marca->update(['nome' => $request->nome]);
        }

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

        if($marca->imagem) Storage::disk('public')->delete($marca->imagem);
        $marca->delete();
        return response()->json(['msg' => 'A exclusão foi realizada com sucesso'],200);
    }
}
