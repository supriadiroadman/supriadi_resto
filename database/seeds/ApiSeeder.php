<?php

use App\Category;
use App\Preview;
use App\Price;
use App\Product;
use App\Stock;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class ApiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $response = Http::get('https://portal.panelo.co/paneloresto/api/productlist/18');
        $response =  json_decode($response->body());

        foreach ($response->products as $category) {
            Category::create([
                'id' => $category->id,
                'name' => $category->name,
                'user_id' => $category->user_id,
            ]);

            foreach ($category->products as $product) {
                Price::create([
                    'term_id' => $product->id,
                    'price' => $product->price->price
                ]);

                Preview::create([
                    'term_id' => $product->id,
                    'type' => $product->preview->type,
                    'content' => $product->preview->content
                ]);

                Stock::create([
                    'term_id' => $product->id,
                    'stock' => $product->stock->stock,
                ]);

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

                $product->categories()->attach([$category->id]);
            }
        }
    }
}
