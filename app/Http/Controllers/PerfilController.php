<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth');   
    }

    public function index()
    {
        return view('perfil.index');
    }

    public function store(Request $request)
    {   
        // Modificar el Request
        $request->request->add(['username' => Str::slug($request->username)]);

        $this->validate($request, [
            'username' => ['required','unique:users,username,' . auth()->user()->id,'min:3','max:30','not_in:twitter,editar-perfil'],
        ]);

        // Comprobar si hay y almacenar imagen minimizada
        if($request->imagen) {
            $imagen = $request->file('imagen');

            // Imagen en memoria
            $nombreImagen = Str::uuid() . "." . $imagen->extension();
    
            // Imagen en servidor
            $imagenServidor = Image::make($imagen);
            $imagenServidor->fit(1000,1000);
    
            $imagenPath = public_path('perfiles') . '/' . $nombreImagen;
            $imagenServidor->save($imagenPath);
        }

        // Guardar Cambios
        $usuario = User::find(auth()->user()->id);
        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;
        $usuario->save();

        //Redireccion 
        return redirect()->route('posts.index', $usuario->username);
    }
}
