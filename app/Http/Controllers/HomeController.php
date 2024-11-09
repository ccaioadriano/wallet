<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function recuperaInformacaoGrafico(Request $request)
    {
        $data = Auth::user()->transacoes()
            ->select('categoria', DB::raw('SUM(valor) as total'))
            ->where('tipo', 'despesa')
            ->groupBy('categoria')
            ->pluck('total','categoria');

        return response($data);
    }
}
