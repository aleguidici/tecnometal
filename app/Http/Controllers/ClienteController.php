<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveClienteRequest;
use App\Http\Requests\SaveContactoRequest;
use App\Persona;
use App\Contacto;
use App\Pais;
use App\Provincia;
use App\TipoPersona;
use App\Localidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClienteController extends Controller
{
    public function index()
    {
        return view('clientes.index', [
            'clientes' => Persona::where('tipo_persona_id', '=', 1)->orderBy('created_at', 'DESC')->get()
            //Persona::where('id', '=', 1)->orderBy('created_at', 'DESC')->get()
        ]);
    }

    public function create()
    {
        return view('clientes.create', [
            'paises' => Pais::get()
        ]);
    }

    public function store(SaveClienteRequest $request)
    {
        //dd($request);
        $tipo_cliente = TipoPersona::where('name','Cliente')->value('id');

        $cliente = Persona::create([
            'name'=> $request->name,
            'direccion'=> $request->direccion,
            'cuil'=> $request->cuil,
            'ingresos_brutos' => $request->ingresos_brutos,
            'condicion_iva' => $request->condicion_iva,
            'localidad_id' => $request->localidad_id,
            'tipo_persona_id' => $tipo_cliente,
            'user_id' => auth()->user()->id,
        ]);

        //Alta Contactos
        if(isset($request->name_cont)){
            $cant_cont = count($request->name_cont);
            for($i = 1; $i <= $cant_cont; $i++){
                $this->crear_contacto($request->name_cont[$i],$request->email_cont[$i],$request->tel_cont[$i],$cliente->id);
            }
        }

        return redirect()->route('clientes.index');
    }

    public function show($id)
    {
        $cliente = Persona::findOrFail($id);

        return view('clientes.show', [
            'cliente' => $cliente
        ]);
    }

    public function edit($id)
    {
        $cliente = Persona::findOrFail($id);
        $provincias = Provincia::where('pais_id',$cliente->localidad->provincia->pais->id)->get();
        $localidades = Localidad::where('provincia_id',$cliente->localidad->provincia->id)->get();
        return view('clientes.edit', [
            'cliente' => $cliente,
            'paises' => Pais::all(),
            'provincias'=>$provincias,
            'localidades'=>$localidades]);
    }

    public function update($id,SaveClienteRequest $request)
    {
        $cliente = Persona::findOrFail($id);

        $cliente->name = $request->name;
        $cliente->direccion = $request->direccion;
        $cliente->cuil = $request->cuil;
        $cliente->ingresos_brutos = $request->ingresos_brutos;
        $cliente->condicion_iva = $request->condicion_iva;
        $cliente->localidad_id = $request->localidad_id;

        $cliente->save();

        //Obtener contactos en Base de datos
        $contactos_actuales = $cliente->contactos;
        //Edicion y creacion de contactos
        if(isset($request->id_contacto_real)){
            $len_contactos_nuevos = count($request->id_contacto_real);
            for ($i = 1; $i<=$len_contactos_nuevos;$i++){
                if ($request->id_contacto_real[$i]===null){
                    $this->crear_contacto($request->name_cont[$i],$request->email_cont[$i],$request->tel_cont[$i],$cliente->id);
                }else{
                    $contacto = Contacto::find($request->id_contacto_real[$i]);
                    $contacto->name = $request->name_cont[$i];
                    $contacto->telefono = $request->tel_cont[$i];
                    $contacto->email = $request->email_cont[$i];
                    $contacto->save();
                }
            }
        }
        //Eliminación de contactos
        foreach ($contactos_actuales as $cont){
            if (isset($request->id_contacto_real)){
                if (!in_array($cont->id,$request->id_contacto_real)){
                    $contacto = Contacto::find($cont->id);
                    $contacto->delete();
                }
            }else{
                $contacto = Contacto::find($cont->id);
                $contacto->delete();
            }
        }


        return redirect()->route('clientes.index');
    }


    public function destroy($id)
    {
        $cliente = Persona::findOrFail($id);

        //Project::destroy($id)
        try{
            $cliente->delete();
            return redirect()->route('clientes.index');
        } catch(\Exception $e) {
            return redirect()->route('clientes.index')->with('alert', 'No se puede borrar el cliente porque está siendo referenciado por otra instancia.');
        }
    }

    public function crear_contacto($nombre,$email,$telefono,$cliente_id)
    {
        //Alta Contactos
        Contacto::create([
            'name' => $nombre,
            'telefono' => $telefono,
            'email' => $email,
            'persona_id' => $cliente_id,
        ]);
    }
}
