<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    use HasFactory;
    protected $fillable=['marca_id','nome','imagem','numero_portas','lugares','airbag','abs'];

    /* 
        Parametros unique
        1 - nome da tabela
        2 - nome do campo a pesquisar (geralemente igual do form e por isso omitido)
        3 - id do registo que não será considerado na pesquisa
    */
    public function regras($id=-1) {
        return [
            "marca_id"=>"exists:marcas,id",
            "nome"=>"required|unique:modelos,nome,$id",
            "imagem"=>"required|file|mimes:png,jpg,jpeg",
            "numero_portas"=>"required|integer|digits_between:1,5",
            "lugares"=>"required|integer|digits_between:1,20",
            "airbar"=>"required|boolean",
            "abs"=>"required|boolean"
        ];
    }

    public function feedback() {
        return [
            "required"=>"O campo :attribute é obrigatório",
            "nome.unique"=>"O Modelo indicado já existe",
            "imagem.mimes"=>"O ficheiro deve ser uma imagem do tipo PNG ou JPG",
            "numero_portas.integer"=>"O número de portas deve ser um número inteiro",
            "numero_portas.digits_between"=>"O número de portas deve ser um número inteiro entre 1 e 5",
            "lugares.integer"=>"O número de lugares deve ser um número inteiro",
            "lugares.digits_between"=>"O número de lugares deve ser um número inteiro entre 1 e 20"
        ];
    }
}
