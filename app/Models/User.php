<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        ];
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

    public function addSaldo($valor) {
        $this->increment('saldo', $valor);
        $this->save();

    }

    public function decrementaSaldo($valor) {
        $this->decrement('saldo', $valor);
        $this->save();
    }

    public function getTotalDespesa(){
        return 'R$ ' . number_format($this->transacoes()->where("tipo", "despesa")->sum('valor'), 2, ',', '.');
    }

    public function getTotalReceita(){
        return 'R$ ' . number_format($this->transacoes()->where("tipo", "receita")->sum('valor'), 2, ',', '.');
    }
}
