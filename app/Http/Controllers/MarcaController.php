<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Psr\Http\Message\ResponseInterface;

class MarcaController extends Controller
{

    public function __construct(Marca $marca)
    {
        $this->marca=$marca;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Lista todos as Marcas
        //return ("Chegamos até aqui - Marcas");

        //$marcas=Marca::all();
        $marcas=$this->marca->with('modelos')->get();
        //return $marcas;
        return response()->json($marcas,200);
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
        
        //Fazer post com postman e verificar o request
        //dd($request->all());

        $request->validate($this->marca->regras(),$this->marca->feedback());
        
        $imagem=$request->file('imagem');
        $imagem_urn=$imagem->store('imagens','public');

        $marca=$this->marca->create([
            "nome"=>$request->nome,
            "imagem"=>$imagem_urn
        ]);
        
        return response()->json($marca,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $marca=$this->marca->with('modelos')->find($id);
        if ($marca===null)
            //return  ["erro"=>"A Marca pesquisada não existe!"];
            return response()->json(["erro"=>"A Marca pesquisada não existe!"],404);
        else
        return response()->json($marca,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function edit(Marca $marca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        /* print_r($request->all()); //dados novos
        echo "<hr>";
        print_r($marca->getAttributes()); //dados antigos */

        //$marca->update($request->all());
        $marca=$this->marca->find($id);
        if ($marca===null)
            //return  ["erro"=>"A Marca pesquisada não existe!"];
            return response()->json(["erro"=>"A Marca pesquisada não existe!"],404);
        else {
            
            if ($request->method() === 'PATCH') {
                $regrasDinamicas=array();

                //Percorrer todas as regras do Model
                foreach($marca->regras() as $input=>$regra)  {
                    //adiciona no array regrasdinamicas as regras correspondentes aos campos submetidos
                    if(array_key_exists($input,$request->all()))
                        $regrasDinamicas[$input]=$regra;
                }
                $request->validate($regrasDinamicas,$this->marca->feedback());
            }
            else
                $request->validate($this->marca->regras($id),$this->marca->feedback());

            //se é enviado novo ficheiro, o antigo é apagado
            if ($request->file('imagem')) {
                Storage::disk('public')->delete($marca->imagem);

                $imagem=$request->file('imagem');
                $imagem_urn=$imagem->store('imagens','public');
            }

            //preeencher os objetos modificados com os dados do request
            $marca->fill($request->all());
            if ($request->file('imagem'))
                $marca->imagem=$imagem_urn;
                
            //O Laravel distingue o save se o model tiver o id preenchido, transformando em update
            $marca->save();
    
            /* $marca->update([
                "nome"=>$request->nome,
                "imagem"=>$imagem_urn
            ]); */

            return response()->json($marca,200);
        }
            
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $marca=$this->marca->find($id);
        if ($marca===null)
            //return  ["erro"=>"A Marca pesquisada não existe!"];
            return response()->json(["erro"=>"A Marca pesquisada não existe!"],404);
        else {

            
            Storage::disk('public')->delete($marca->imagem);

            $marca->delete();
            //return(["msg"=>"A Marca foi apagada com sucesso!"]);
            return response()->json(["msg"=>"A Marca foi apagada com sucesso!"],200);
        }
    }
}
