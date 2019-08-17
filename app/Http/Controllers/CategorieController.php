<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categorie;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // if (!$request->ajax()) return redirect('/');
        $categorie = Categorie::orderBy('id', 'DESC')->get();
         return $categorie;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Categorie::create($request->all());
        return;
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
    Categorie::find($id)->update($request->all());
    return;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function destroy(Request $request, $id)
    {
        if (!$request->ajax()) return redirect('/');
        $categorie = Categorie::findOrFail($id);
        $categorie->delete();
    }
    public function activar(Request $request, $id)
    {
        if (!$request->ajax()) return redirect('/');
        $categorie = Categorie::findOrFail($id);
        $categorie->is_active = '1';
        $categorie->save();
        return $categorie;
    }
    public function desactivar(Request $request, $id)
    {
        if (!$request->ajax()) return redirect('/');
        $categorie = Categorie::findOrFail($id);
        $categorie->is_active = '0';
        $categorie->save();
        return $categorie;
    }
}
