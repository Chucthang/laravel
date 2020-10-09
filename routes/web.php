<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CallApi;
use App\Http\Controllers\MyControllers;



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

// Route::get('/', function () {
//     return view('welcome');
// });



Route::get('test/{name}', function ($name) {
   
    return 'name: ' .$name;
});



//-------------------- lấy tất cả---------------
Route::prefix('ajax')->group(function () {

                Route::get('limit/{data}', [MyControllers::class, 'Paginate']);
                Route::get('search={data}', [MyControllers::class, 'SearchClick']);
                Route::post('insert', [MyControllers::class, 'InsertData']);
                Route::delete('delete={id}', [MyControllers::class, 'DeleteData']);
                Route::get('update/user={id}', [MyControllers::class, 'OneUSer']);
                Route::post('update/edit', [MyControllers::class, 'EditUSer']);

});

//------------------------ refesh phân trang-----------------
Route::get('/page={numb}', [MyControllers::class, 'Paginate_pageload']);
Route::get('searchempty', [MyControllers::class, 'Search_Empty']);

//----------------------------search---------------------------
Route::get('search',[MyControllers::class, 'MultipleSearch']);
Route::get('tsearch={fulltext}', [MyControllers::class, 'RefeshSearch']);

 Route::get('/', [MyControllers::class, 'All_Limit']);


 