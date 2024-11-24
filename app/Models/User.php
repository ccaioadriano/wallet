<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Storage;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'saldo',
        'categorias',
        'profile_image'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'categorias' => 'array',
        ];
    }

    public function getProfileImage()
    {
        return $this->profile_image != null
            ? Storage::url("profile_images/$this->profile_image")
            : asset('images/profile_default.png');
    }

    public function transacoes()
    {
        return $this->hasMany(Transacao::class);
    }

    public function getSaldo()
    {
        $totalDespesas = $this->transacoes()->where("tipo", "despesa")->sum("valor");
        $totalReceita = $this->transacoes()->where("tipo", "receita")->sum("valor");
        $this->saldo = $totalReceita - $totalDespesas;
        $this->save();
        return $this->saldo;
    }

    public function getSaldoFormatado()
    {
        return 'R$ ' . number_format($this->getSaldo(), 2, ',', '.');
    }

    public function addSaldo($valor)
    {
        $this->increment('saldo', $valor);
        $this->save();

    }

    public function decrementaSaldo($valor)
    {
        $this->decrement('saldo', $valor);
        $this->save();
    }

    /**
     * Retorna o valor total da transação pelo tipo já formatada
     * @param string $tipo
     * @return string
     */
    public function getTotalTransacaoByTipo(string $tipo)
    {

        return match ($tipo) {
            'despesa' => 'R$ ' . number_format($this->transacoes()->where("tipo", "despesa")->sum('valor'), 2, ',', '.'),
            'receita' => 'R$ ' . number_format($this->transacoes()->where("tipo", "receita")->sum('valor'), 2, ',', '.'),
        };
    }

    /**
     * Agrupa totas as categorias e retorna o total de despesa por categoria
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTotalDespesaByCategoria()
    {
        return $this->transacoes()
            ->select('categoria', DB::raw('SUM(valor) as total'))
            ->where('tipo', '=', 'despesa')
            ->groupBy('categoria')->get();
    }
}
