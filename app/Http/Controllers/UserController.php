<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\SaveUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ADMIN = 1;
        if (auth()->user()->tipo_usuario == $ADMIN){
            return view('usuario.index',['usuarios'=>User::all()]);
        }else{
            return redirect()->route('home')->with('alert', 'No tiene autorización para ingresar a esta sección.');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ADMIN = 1;
        if (auth()->user()->tipo_usuario == $ADMIN){
            return view('usuario.create');
        }else{
            return redirect()->route('home')->with('alert', 'No tiene autorización para ingresar a esta sección.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveUserRequest $request)
    {
        $ADMIN = 1;
        if (auth()->user()->tipo_usuario == $ADMIN){
            User::create([
                'name'=>$request->name,
                'password'=>Hash::make($request->password),
                'tipo_usuario'=>$request->tipo_usuario,
                'email'=>$request->email
            ]);

            return redirect()->route('usuarios.index');
        }else{
            return redirect()->route('home')->with('alert', 'No tiene autorización para ingresar a esta sección.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ADMIN = 1;
        if (auth()->user()->tipo_usuario == $ADMIN){
            return view('usuario.edit',['usuario'=>User::findOrFail($id)]);
        }else{
            return redirect()->route('home')->with('alert', 'No tiene autorización para ingresar a esta sección.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $ADMIN = 1;
        if (auth()->user()->tipo_usuario == $ADMIN){
            $user = User::findOrfail($id);

            $user->name=$request->name;
            if ($request->exists('password')){
                if($request->password){
                    $user->password=Hash::make($request->password);
                }
            }
            $user->email=$request->email;
            $user->tipo_usuario=$request->tipo_usuario;
            $user->save();

            return redirect()->route('usuarios.index');
        }else{
            return redirect()->route('home')->with('alert', 'No tiene autorización para ingresar a esta sección.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ADMIN = 1;
        if (auth()->user()->tipo_usuario == $ADMIN){
            $usuario = User::findOrfail($id);
            try{
                $usuario->delete();
                return redirect()->route('usuarios.index');
            } catch(\Exception $e) {
                return redirect()->route('usuarios.index')->with('alert', 'No se puede borrar al usuario porque está siendo referenciado por otra instancia.');
            }
        }else{
            return redirect()->route('home')->with('alert', 'No tiene autorización para ingresar a esta sección.');
        }
    }
}
