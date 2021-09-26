<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;
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
        $marcas=$this->marca->all();
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

        //$marca= Marca::create($request->all());
        $marca=$this->marca->create($request->all());
        //return $marca;
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
        $marca=$this->marca->find($id);
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
            $marca->update($request->all());
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
            $marca->delete();
            //return(["msg"=>"A Marca foi apagada com sucesso!"]);
            return response()->json(["msg"=>"A Marca foi apagada com sucesso!"],200);
        }
    }
}
