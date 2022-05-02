<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProveedorRequest;
use App\Pais;
use App\Provincia;
use App\Localidad;
use App\Persona;
use App\TipoPersona;
use App\Contacto;

use Illuminate\Support\Facades\Log;


class ProveedorController extends Controller
{
    public function index()
    {
        $id_tipo_persona = TipoPersona::where('name','Proveedor')->value('id');
        $proveedores = Persona::where('tipo_persona_id',$id_tipo_persona)->get();
        return view('proveedor/proveedores',['proveedores'=>$proveedores]);
    }

    public function create()
    {
        //Obtener paises
        $paises = Pais::all();
        return view('proveedor/create',['paises'=>$paises]);
    }

    public function store(ProveedorRequest $request)
    {
        $id_tipo_persona = TipoPersona::where('name','Proveedor')->value('id');
        $proveedor = Persona::create([
            'name'=>$request->name,
            'direccion'=>$request->direccion,
            'cuil'=>$request->cuil,
            'condicion_iva'=>$request->condicion_iva,
            'ingresos_brutos'=>$request->ingresos_brutos,
            'localidad_id'=>$request->localidad_id,
            'tipo_persona_id'=>$id_tipo_persona,
            'user_id' => auth()->user()->id
        ]);

        //Alta Contactos
        if (isset($request->name_cont)){
            $cant_cont = count($request->name_cont);
            for($i = 1; $i <= $cant_cont; $i++){
                $this->crear_contacto($request->name_cont[$i],$request->email_cont[$i],$request->tel_cont[$i],$proveedor->id);
            }
        }
        return redirect()->route('proveedores.index');
    }

    public function show($id)
    {
        $proveedor = Persona::findOrFail($id);

        return view('proveedor.show',['proveedor'=>$proveedor]);
    }

    public function edit($id)
    {
        $proveedor = Persona::findOrFail($id);
        $provincias = Provincia::where('pais_id',$proveedor->localidad->provincia->pais->id)->get();
        $localidades = Localidad::where('provincia_id',$proveedor->localidad->provincia->id)->get();
        return view('proveedor.edit',
        ['proveedor'=>$proveedor,
        'paises'=>Pais::all(),
        'provincias'=>$provincias,
        'localidades'=>$localidades]);
    }

    public function update($id,ProveedorRequest $request)
    {
        $proveedor = Persona::findOrFail($id);

        $proveedor->name = $request->name;
        $proveedor->direccion = $request->direccion;
        $proveedor->cuil = $request->cuil;
        $proveedor->ingresos_brutos = $request->ingresos_brutos;
        $proveedor->condicion_iva = $request->condicion_iva;
        $proveedor->localidad_id = $request->localidad_id;

        $proveedor->save();

        //Obtener contactos en Base de datos
        $contactos_actuales = $proveedor->contactos;
        //Edicion y creacion de contactos
        if (isset($request->id_contacto_real)){
            $len_contactos_nuevos = count($request->id_contacto_real);
            for ($i = 1; $i<=$len_contactos_nuevos;$i++){
                if ($request->id_contacto_real[$i]===null){
                    $this->crear_contacto($request->name_cont[$i],$request->email_cont[$i],$request->tel_cont[$i],$proveedor->id);
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


        return redirect()->route('proveedores.index');
    }

    public function destroy($id)
    {
        $proveedor = Persona::findOrFail($id);

        //Project::destroy($id)
        try{
            $proveedor->delete();
            return redirect()->route('proveedores.index');
        } catch(\Exception $e) {
            return redirect()->route('proveedores.index')->with('alert', 'No se puede borrar el proveedor porque está siendo referenciado por otra instancia.');
        }
    }

    public function crear_contacto($nombre,$email,$telefono,$proveedor_id)
    {
        //Alta Contactos
        Contacto::create([
            'name' => $nombre,
            'telefono' => $telefono,
            'email' => $email,
            'persona_id' => $proveedor_id,
        ]);
    }
}
