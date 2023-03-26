<?php

namespace App\Http\Controllers;

use App\Models\Indicator;
use Illuminate\Http\Request;
use App\Http\Requests\IndicatorRequest;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class IndicatorController extends Controller
{
    public function index()
    {
        $endRange = now()->format('Y-m-d');
        $startRange = now()->subDays(10)->format('Y-m-d');
        $endRange = '2021-12-31';
        $startRange = '2021-12-21';
        $graphValues = Indicator::whereBetween('fecha_indicador', [$startRange, $endRange])
            ->orderBy('fecha_indicador', 'asc')
            ->get(['id', 'valor_indicador', 'fecha_indicador']);

        return view('indicators.index', compact('graphValues'));
    }

    // Metodo encargado de enviar datos a datatable
    public function getIndicators()
    {
        $indicators = Indicator::all();
        return response()->json([
            'status' => 200,
            'data'=> $indicators
        ]);
    }


    public function getGraphValues(Request $request)
    {
        $dateA = Carbon::parse($request->date_a)->format('Y-m-d');
        $dateB = Carbon::parse($request->date_b)->format('Y-m-d');
        $desde = $dateA;
        $hasta = $dateB;
        if ($dateA > $dateB) {
            $desde = $dateB;
            $hasta = $dateA;
        }
        $graphValues = Indicator::whereBetween('fecha_indicador', [$desde, $hasta])
            ->orderBy('fecha_indicador', 'asc')
            ->get(['id', 'valor_indicador', 'fecha_indicador']);
        return response()->json(['graphValues' => $graphValues], Response::HTTP_OK);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'valor'=>'numeric',
            'fecha'=>'date',
        ],
        [
            'valor.numeric' => 'Debe ingresar un valor numerico',
            'fecha.date' => 'Debe ingresar una fecha valida'
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
        ]);
        }else{
            $indicator = [
                'nombre_indicador' =>  $request->nombre,
                'codigo_indicador' => $request->codigo,
                'unidad_medida_indicador' => $request->unidadMedida,
                'valor_indicador' => $request->valor,
                'fecha_indicador' => $request->fecha,
                'tiempo_indicador' => $request->tiempo,
                'origen_indicador' => $request->origen
            ];

            Indicator::create($indicator);
            return response()->json([
            'status' => 200
            ]);
        }

    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $indicator = Indicator::find($id);
        if($indicator){
            return response()->json([
                "status" => 200,
                'message' => "",
                "data" => $indicator
            ]);
        }else{
            return response()->json([
                'message'=> "Internal Server Error",
                "code" => 500
            ]);
        }
    }

    public function update(Request $request, Indicator $indicator)
    {
        $indicator = Indicator::find($request->indicator_id);

        $req = [
            'nombre_indicador' =>  $request->edit_nombre,
            'codigo_indicador' => $request->edit_codigo,
            'unidad_medida_indicador' => $request->edit_unidadMedida,
            'valor_indicador' => $request->edit_valor,
            'fecha_indicador' => $request->edit_fecha,
            'tiempo_indicador' => $request->edit_tiempo,
            'origen_indicador' => $request->edit_origen
        ];

        $validator = Validator::make($request->all(),[
            'edit_valor'=>'numeric',
            'edit_fecha'=>'date',
        ],
        [
            'edit_valor.numeric' => 'Debe ingresar un valor numerico',
            'edit_fecha.date' => 'Debe ingresar una fecha valida'
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
        ]);
        }else{
            $indicator->update($req);
            return response()->json([
                'status' => 200,
            ]);
        }



    }

    public function destroy(Request $request)
    {
        $result = Indicator::where('id',$request->id)->delete();
        if($result){
            return response()->json([
                'status' => 200
            ]);
        }else{
            return response()->json([
                'status' => 500
            ]);
        }

    }
}
