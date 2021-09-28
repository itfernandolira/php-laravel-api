<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ModeloController extends Controller
{

    public function __construct(Modelo $modelo)
    {
        $this->modelo=$modelo;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modelos=$this->modelo->with('marca')->get();
        // all()-> criar um obj de consulta + get() = collection
        // get()-> modificar a consulta -> collection

        return response()->json($modelos,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->modelo->regras(),$this->modelo->feedback());
        
        $imagem=$request->file('imagem');
        $imagem_urn=$imagem->store('imagens/modelos','public');

        $modelo=$this->modelo->create([
            "marca_id"=>$request->marca_id,
            "nome"=>$request->nome,
            "imagem"=>$imagem_urn,
            "numero_portas"=>$request->numero_portas,
            "lugares"=>$request->lugares,
            "air_bag"=>$request->air_bag,
            "abs"=>$request->abs
        ]);
        
        return response()->json($modelo,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $modelo=$this->modelo->with('marca')->find($id);
        if ($modelo===null)
            return response()->json(["erro"=>"O Modelo pesquisado não existe!"],404);
        else
        return response()->json($modelo,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function edit(Modelo $modelo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $modelo=$this->modelo->find($id);
        if ($modelo===null)
            return response()->json(["erro"=>"O Modelo pesquisado não existe!"],404);
        else {
            
            if ($request->method() === 'PATCH') {
                $regrasDinamicas=array();

                //Percorrer todas as regras do Model
                foreach($modelo->regras() as $input=>$regra)  {
                    //adiciona no array regrasdinamicas as regras correspondentes aos campos submetidos
                    if(array_key_exists($input,$request->all()))
                        $regrasDinamicas[$input]=$regra;
                }
                $request->validate($regrasDinamicas,$this->modelo->feedback());
            }
            else
                $request->validate($this->modelo->regras($id),$this->modelo->feedback());

            //se é enviado novo ficheiro, o antigo é apagado
            if ($request->file('imagem')) {
                Storage::disk('public')->delete($modelo->imagem);

                $imagem=$request->file('imagem');
                $imagem_urn=$imagem->store('imagens/modelos','public');
            }

            //preeencher os objetos modificados com os dados do request
            $modelo->fill($request->all());
            if ($request->file('imagem'))
                $modelo->imagem=$imagem_urn;
                
            //O Laravel distingue o save se o model tiver o id preenchido, transformando em update
            $modelo->save();
    
            /* $modelo->update([
                "marca_id"=>$request->marca_id,
                "nome"=>$request->nome,
                "imagem"=>$imagem_urn,
                "numero_portas"=>$request->numero_portas,
                "lugares"=>$request->lugares,
                "air_bag"=>$request->air_bag,
                "abs"=>$request->abs
            ]); */
            return response()->json($modelo,200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $modelo=$this->modelo->find($id);
        if ($modelo===null)
            return response()->json(["erro"=>"O Modelo pesquisado não existe!"],404);
        else {

            
            Storage::disk('public')->delete($modelo->imagem);

            $modelo->delete();
            
            return response()->json(["msg"=>"O Modelo foi apagado com sucesso!"],200);
        }
    }
}
