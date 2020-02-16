<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


/*Route::get('/about', function () {
    return view('about');
});
*/

/*Route::get('/articles', function () {
    return view('articles');
});
* */

Route::get('/about', 'PageController@about');


// Название сущности в URL во множественном числе, контроллер в единственном
Route::get('/articles', 'ArticleController@index')
  ->name('articles.index'); // имя маршрута, нужно для того, чтобы не создавать ссылки руками

Route::get('/articles/create', 'ArticleController@create')
  ->name('articles.create');

Route::get('/articles/{id}', 'ArticleController@show')
  ->name('articles.show');
  
Route::post('/articles', 'ArticleController@store')
  ->name('articles.store');
  
Route::patch('/articles/{id}', 'ArticleController@update')
  ->name('articles.update');
  
Route::get('/articles/{id}/edit', 'ArticleController@edit')
  ->name('articles.edit');

Route::delete('/articles/{id}', 'ArticleController@destroy')
  ->name('articles.destroy');



