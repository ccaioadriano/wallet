<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class ConfiguracaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('configuracoes.index');
    }

    public function addCategoria(Request $request)
    {
        $categoria = $request->categoriaNome;
        $user = Auth::user();

        // Obtenha as categorias atuais ou inicialize um array vazio se estiver nulo
        $categorias = $user->categorias ?? [];

        // Adicione a nova categoria ao array de categorias
        $categorias[] = ['nome' => $categoria];

        // Atualize o campo 'categorias' no usuário e salve
        $user->categorias = $categorias;

        //TODO: Sempre antes de salvar é necessário testar para verificar se o usuario já possui o limite de categorias cadastrado
        $user->save();
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
