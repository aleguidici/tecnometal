<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Provincia;


class ProvinciaController extends Controller
{


    public function get_provincias(Request $request){
        $provincias = Provincia::where('pais_id',$request->pais_id)->get();
        return response()->json(['status'=>TRUE,'data'=>$provincias]);
    }

}
