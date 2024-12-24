<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $fileNameToStore = null;

        // Verifica se o arquivo foi enviado no request
        if (request()->hasFile('profile_image')) {
            try {
                $file = request()->file('profile_image');
                $extension = $file->getClientOriginalExtension();

                // Gera um nome único para o arquivo
                $fileNameToStore = 'perfil_'.$data['name'] . '_' . time() . '.' . $extension;
                // Faz o upload para a pasta 'public/img_itens'
                $file->storeAs('profile_images', $fileNameToStore, 'public');
            } catch (\Exception $e) {
                \Log::error('File upload error: ' . $e->getMessage());
                return response()->json(['error' => 'Erro ao fazer upload da imagem de perfil.'], 500);
            }
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'profile_image' => $fileNameToStore,
            'password' => Hash::make($data['password']),
        ]);
    }
}
