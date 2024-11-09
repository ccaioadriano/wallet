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
        $color = $request->color;
        $user = Auth::user();

        $categorias = $user->categorias ?? [];

        //add uma nova categoria na lista
        $categorias[] = ['nome' => $categoria, 'color'=> $color];

       // atualiza a lista do usuario com a nova lista
        $user->categorias = $categorias;

        //verifica se o usuario atingiu o limite de categorias
        if(count($user->categorias) >= 10) {
            return redirect()->route('configuracao-index')->with('erro', 'Você atingiu o limite de categorias.');
        }

        $user->save();

        return redirect()->route('configuracao-index')->with('success', 'Categoria cadastrada com sucesso.');
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
