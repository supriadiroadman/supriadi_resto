<?php

use App\User;
use App\Product;
use App\Category;
use App\Http\Controllers\ProductController;
use App\Price;

use function GuzzleHttp\json_decode;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

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
    return redirect()->route('products.index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('products', 'ProductController');

Route::get('product/export/{catid}', 'ProductController@export')->name('product.export');
Route::get('product/export_xml/{catid}', 'ProductController@export_xml')->name('product.export_xml');
