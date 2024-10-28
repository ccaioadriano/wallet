<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Transacao extends Model
{
    protected $table = "transacoes";

    protected $fillable = [
        "data",
        "descricao",
        "categoria",
        "tipo",
        "valor",
        "user_id"
    ];

    public $timestamps = false;

    public function getValorFormatado()
    {
        return 'R$ ' . number_format($this->valor, 2, ',', '.');
    }

    public function getDataFormatada()
    {
        return Carbon::parse($this->data)->format('d/m/Y');
    }
}
