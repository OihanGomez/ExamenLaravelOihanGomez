<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Events::all();
        return response()->json($events);
    }

    public function show($id){
        $events = Events::find($id);
        return response()->json($events);
    }

      /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $events = new Events();
        $events->nombre = request('nombre');
        $events->fecha = request('fecha');
        $events->descripcion = request('descripcion');
        $events->save();

        return response()->json($events);
    }

   
    public function edit($id){
        $events = Events::find($id);
        $events->nombre = request('nombre');
        $events->fecha = request('fecha');
        $events->descripcion = request('descripcion');
        $events->save();

        return response()->json($events);
    
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $events = Events::find($id);
        $events->delete();
        $message = 'el evento' . $id . 'ha sido eliminado';
        return response()->json($message);
    }
}
