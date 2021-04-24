<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Libro;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;

class LibroController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Libro::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user=auth()->user();
        //dd($user->name);
        $libro = Libro::create([
            'subidoPor'=>$user->id,
            'editadoPor'=>$user->id,
            'titulo'=>$request->titulo,
            'autor'=>$request->autor,
            'descripcion'=>$request->descripcion,
            'paginas'=>$request->paginas,
            'tapaDura'=>$request->tapaDura,
            'ref'=>$request->ref,
            'precio'=>$request->precio
            ]);

        return response()->json($libro, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Libro::where('id', $id)->get(); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //dd($request);
        $libro=Libro::find($id);
        $user=auth()->user();
        $libro->update([
        'subidoPor'=>$libro->subidoPor,
        'editadoPor'=>$user->id,
        'titulo'=>$request->titulo,
        'autor'=>$request->autor,
        'descripcion'=>$request->descripcion,
        'paginas'=>$request->paginas,
        'tapaDura'=>$request->tapaDura,
        'ref'=>$request->ref,
        'precio'=>$request->precio]);

        return Libro::where('id', $id)->get();  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $libro=Libro::find($id);
        $libro->delete();
        return response()->json(null, 204);
    }
}
