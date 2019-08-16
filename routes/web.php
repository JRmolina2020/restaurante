<?php



Route::get('/', function () {
    return view('home');
});

Route::get('categoria', function () {
    return view('categorie.index');
});

Route::resource('Categoria', 'CategorieController')->except([
    'show', 'create', 'edit'
]);

Route::put('/Categoria/activar/{id}', 'CategorieController@activar');
Route::put('/Categoria/desactivar/{id}', 'CategorieController@desactivar');



