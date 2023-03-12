<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function index() 
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // Modificar el Request
        $request->request->add(['username' => Str::slug($request->username)]);

        // Validacion de datos a almacenar
        $this->validate($request, [
            'name' => 'required|max:30|min:3',
            'username' => 'required|unique:users|min:3|max:30',
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|confirmed|min:6',
        ]);

        // Guardar en DB
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // Auntenticar Usuario
        /*  auth()->attempt([
                'email' => $request->email,
                'password'=> $request->password
            ]);
        */
        // Otra Autentificacion de Usuario
        auth()->attempt($request->only('username','password','email'));

        // Redirigir usuario
        return redirect()->route('posts.index', auth()->user()->username);
    }
}
