<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contacto;

class ContactoController extends Controller
{

    public function get_contactos(Request $request){
        $contactos = Contacto::where('persona_id',$request->cliente_id)->get();
        return response()->json(['status'=>TRUE,'data'=>$contactos]);
    }

}