<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;
    protected $fillable=['nome','imagem'];

    public function regras() {
        return [
            "nome"=>"required|unique:marcas",
            "imagem"=>"required"
        ];
    }

    public function feedback() {
        return [
            "required"=>"O campo :attribute é obrigatório",
            "nome.unique"=>"A Marca indicada já existe"
        ];
    }
}
