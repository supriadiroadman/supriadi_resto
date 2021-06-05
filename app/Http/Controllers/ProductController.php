<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\Exports\ProductExport;
use App\Exports\UsersExport;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Builder;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(request()->category_id);
        if (request()->category_id && request()->jumlah_data) {
            $products = Product::whereHas('categories', function (Builder $query) {
                $query->where('id', request()->category_id);
            })->paginate(request()->jumlah_data);
        } elseif (request()->category_id) {
            $products = Product::whereHas('categories', function (Builder $query) {
                $query->where('id', request()->category_id);
            })->paginate(2);
        } elseif (request()->jumlah_data) {
            $products = Product::paginate(request()->jumlah_data);
        } else {
            $products = Product::paginate(2);
        }
        $categories = Category::all();
        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required',
            'lang' => 'required',
            'status' => 'required',
            'type' => 'required',
            'count' => 'required',
            'category_id' => 'required',
            'content' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);

        $slug = Str::slug($request->title);
        if ($request->hasFile('content')) {
            $file = $request->file('content');

            $slug = Str::slug(substr($request->title, 0, 15));
            $ext = $file->getClientOriginalExtension();
            $filename = $slug . '-' . time() . '.' . $ext;

            // Store image
            $file->storeAs('public/products', $filename);

            $filename = 'storage/products/' . $filename;
        }

        $product =  Product::create([
            'title' => $request->title,
            'slug' => $slug,
            'lang' => $request->lang,
            'auth_id' => auth()->user()->id,
            'status' => $request->status,
            'type' => $request->type,
            'count' => $request->count,
        ]);

        $product->categories()->attach($request->category_id);
        $product->price()->create([
            'price' => $request->price
        ]);
        $product->stock()->create([
            'stock' => $request->stock
        ]);
        $product->preview()->create([
            'type' => $request->type,
            'content' => $filename
        ]);

        return redirect()->route('products.index')->with('success', "Berhasil Menambah Produk " .
            substr($request->title, 0, 20) . " ...");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
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
        $product = Product::findOrFail($id);
        // dd($request->all());
        $request->validate([
            'title' => 'required',
            'lang' => 'required',
            'status' => 'required',
            'type' => 'required',
            'count' => 'required',
            'category_id' => 'required',
            'content' => 'nullable',
            'price' => 'required',
            'stock' => 'required',
        ]);

        $slug = Str::slug($request->title);
        if ($request->hasFile('content')) {

            $image_path = $product->preview->content;
            if (file_exists($image_path)) {
                @unlink($image_path);
            }

            $file = $request->file('content');

            $slug = Str::slug(substr($request->title, 0, 15));
            $ext = $file->getClientOriginalExtension();
            $filename = $slug . '-' . time() . '.' . $ext;

            // Store image
            $file->storeAs('public/products', $filename);

            $filename = 'storage/products/' . $filename;
        }

        $product->update([
            'title' => $request->title,
            'slug' => $slug,
            'lang' => $request->lang,
            'auth_id' => auth()->user()->id,
            'status' => $request->status,
            'type' => $request->type,
            'count' => $request->count,
        ]);

        $product->categories()->sync([$request->category_id]);
        $product->price()->update([
            'price' => $request->price
        ]);
        $product->stock()->update([
            'stock' => $request->stock
        ]);
        $product->preview()->update([
            'type' => $request->type,
            'content' => $filename ?? $product->preview->content
        ]);

        return redirect()->route('products.index')->with('success', "Berhasil Mengupdate Produk " .
            substr($request->title, 0, 20) . " ...");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $image_path = $product->preview->content;
        if (file_exists($image_path)) {
            @unlink($image_path);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', "Berhasil Menghapus Produk " .
            substr($product->title, 0, 20) . " ...");
    }

    public function export()
    {
        return Excel::download(new ProductExport, 'products.xlsx');
    }
}
