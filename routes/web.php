<?php

use App\User;
use App\Product;
use App\Category;
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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');







Route::any('seeder', function () {
    $response = Http::get('https://portal.panelo.co/paneloresto/api/productlist/18');
    $response =  json_decode($response->body());

    foreach ($response->products as $category) {
        // Category::create([
        //     'id' => $category->id,
        //     'name' => $category->name,
        //     'user_id' => $category->user_id,
        // ]);
        foreach ($category->products as $product) {

            // dump($product->price->price);
            $product =   Product::create([
                "id" => $product->id,
                "title" => $product->title,
                "slug" => $product->slug,
                "lang" => $product->lang,
                "auth_id" => $product->auth_id,
                "status" => $product->status,
                "type" => $product->type,
                "count" => $product->count,
            ]);

            // dump($product->price->price);
            $product->categories()->attach([$category->id]);

            Price::create([
                'term_id' => $product->id,
                'price' => $product->price->price
            ]);
        }
    }
});













Route::get('coba', function () {
    return Category::with('products', 'products.price', 'products.preview', 'products.stock')->get();
});
