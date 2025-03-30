<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Type\Integer;  
use Illuminate\Http\Request;
use App\Http\Requests\StoreMarcaRequest;
use App\Http\Requests\UpdateMarcaRequest;
use App\Repositories\MarcaRepository;

class MarcaController extends Controller
{
    private $marca;

    public function __construct(Marca $marca){
        $this->marca = $marca;
    }
    /**
     * Display a listing of the resource.
     * @param Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $marcaRepository = new MarcaRepository($this->marca);

        if($request->has('atributos_modelos')){
            $atributos_modelos = "modelos:id,$request->atributos_modelos";
            $marcaRepository->selectAtributosRelacionados($atributos_modelos);
        }else{ $marcaRepository->selectAtributosRelacionados("modelos"); }

        if($request->has('filtro')) $marcaRepository->filtro($request->filtro);

        if($request->has('atributos')) $marcaRepository->selectAtributos($request->atributos); 

        return response()->json($marcaRepository->getResultadoPag(5), 200); 
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

        $marca->fill($request->all());

        $image = $request->file('imagem');
        if($image){
            Storage::disk('public')->delete($marca->imagem);
            $marca->imagem = $image->store('imagens/marcas','public'); 
        }

        $marca->save();
        return response()->json(['msg' => 'A atualização foi realizada com sucesso', 'marca' => $marca],200);
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
