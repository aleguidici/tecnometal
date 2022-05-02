<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveGastoPreestRequest;
use Illuminate\Http\Request;
use App\GastoPreest;

use Illuminate\Support\Facades\Log;

class GastosPreestController extends Controller
{
    public function index()
    {
        return view('gastos_preest.index', [
            'gastos_preest' => GastoPreest::get()
            //Persona::where('id', '=', 1)->orderBy('created_at', 'DESC')->get()
        ]);
    }

    public function edit($id)
    {
        $gasto = GastoPreest::findOrFail($id);
        return view('gastos_preest.edit',
        ['gasto_preest'=>$gasto]);
    }

    public function update(Request $request, $id)
    {
        $gasto = GastoPreest::findOrFail($id);
        $gasto->update(['valor' => $request->valor/100]);
        return redirect()->route('gastos_preest.index');
    }

    public function store(Request $request)
    {

        $gasto = GastoPreest::create([
            'descripcion' => $request->desc,
            'valor' => $request->perc/100,
        ]);

        return response()->json(['status'=>TRUE]);
    }
}
