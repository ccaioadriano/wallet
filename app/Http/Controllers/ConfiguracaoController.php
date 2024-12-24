<?php

namespace App\Http\Controllers;

use App\Utils\FileUtils;
use Auth;
use Illuminate\Http\Request;
use Storage;

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
        $categorias[] = ['nome' => $categoria, 'color' => $color];

        // atualiza a lista do usuario com a nova lista
        $user->categorias = $categorias;

        //verifica se o usuario atingiu o limite de categorias
        if (count($user->categorias) >= 10) {
            return redirect()->route('configuracao-index')->with('erro', 'Você atingiu o limite de categorias.');
        }

        $user->save();

        return redirect()->route('configuracao-index')->with('success', 'Categoria cadastrada com sucesso.');
    }

    public function updateProfileImage(Request $request)
    {
        try {
            // Obtém o usuário autenticado
            $user = Auth::user();
            if (!$request->hasFile('profile_image')) {
                \Log::error('Nenhuma imagem foi enviada.');
                return redirect()->route('configuracao-index')->with('error', 'Nenhuma imagem foi enviada.');
            }

            // Processa o upload da imagem
            $file = $request->file('profile_image');
            $fileNameToStore = FileUtils::generateFileName($user->name, $file->getClientOriginalExtension());

            FileUtils::deleteOldProfileImage($user->profile_image);

            // Salva a nova imagem
            $file->storeAs('profile_images', $fileNameToStore, 'public');

            // Atualiza o registro do usuário
            $user->update(['profile_image' => $fileNameToStore]);

            return redirect()->route('configuracao-index')->with('success', 'Perfil atualizado com sucesso.');
        } catch (\Throwable $th) {
            \Log::error('Erro ao fazer upload da imagem de perfil: ' . $th->getMessage());
            return redirect()->route('configuracao-index')->with('error', 'Erro ao fazer upload da imagem de perfil.');
        }
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
