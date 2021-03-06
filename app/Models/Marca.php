<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;
    protected $fillable=['nome','imagem'];

    /* 
        Parametros unique
        1 - nome da tabela
        2 - nome do campo a pesquisar (geralemente igual do form e por isso omitido)
        3 - id do registo que não será considerado na pesquisa
    */
    public function regras($id=-1) {
        return [
            "nome"=>"required|unique:marcas,nome,$id",
            "imagem"=>"required|file|mimes:png,jpg,jpeg"
        ];
    }

    public function feedback() {
        return [
            "required"=>"O campo :attribute é obrigatório",
            "nome.unique"=>"A Marca indicada já existe",
            "imagem.mimes"=>"O ficheiro deve ser uma imagem do tipo PNG ou JPG"
        ];
    }

    public function modelos() {
        //UMA marca possui MUITOS modelos - nome do método no plural
        return $this->hasMany('App\Models\Modelo');
    }
}
