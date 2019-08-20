<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    $product = Product::join('categories', 'products.categorie_id', '=', 'categories.id')
            ->select(
                'products.id',
                'products.name',
                'products.price',
                'products.description',
                'products.image',
                'products.is_active',
                'categories.name as name_categorie',
                'categories.id as idc'
            )->orderBy('products.id', 'desc')->get();
        return $product;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    if (!$request->ajax()) return redirect('/');
     $product=$request->all();
    if ($request->hasFile('image')) {
    $product['image']=$request->file('image')->store('uploads','public');
    }else{
    $product['image']='uploads/default.png';
    }
    Product::insert($product);
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
     Product::find($id)->update($request->all());
    return;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function destroy(Request $request, $id)
    {
        if (!$request->ajax()) return redirect('/');
        $product = Product::findOrFail($id);
        $product->delete();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activar(Request $request, $id)
    {
        if (!$request->ajax()) return redirect('/');
        $product = Product::findOrFail($id);
        $product->is_active = '1';
        $product->save();
        return $product;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function desactivar(Request $request, $id)
    {
        if (!$request->ajax()) return redirect('/');
        $product = Product::findOrFail($id);
        $product->is_active = '0';
        $product->save();
        return $product;
    }
}
