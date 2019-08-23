<?php



Route::get('/', function () {
    return view('home');
});

Route::get('categoria', function () {
    return view('categorie.index');
});
Route::get('producto', function () {
    return view('product.index');
});

Route::resource('Categoria', 'CategorieController')->except([
    'show', 'create', 'edit'
]);


Route::get('Categoria/select','CategorieController@selectCategorie');
Route::put('Categoria/activar/{id}', 'CategorieController@activar');
Route::put('Categoria/desactivar/{id}', 'CategorieController@desactivar');


Route::resource('Producto', 'ProductController')->except([
    'show', 'create', 'edit'
]);
Route::get('Producto/filter','ProductController@productfilter');
Route::put('Producto/activar/{id}', 'ProductController@activar');
Route::put('Producto/desactivar/{id}', 'ProductController@desactivar');
