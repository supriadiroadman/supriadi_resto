@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-5">
        <div class="col">

            <form action="{{ route('products.index') }}" method="get" class="mb-3">
                <div class="form-row ">
                    <div class="col-auto form-group">
                        <select name="category_id" id="" class="form-control mr-4">
                            <option value="">Kategori</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto form-group">
                        <select name="jumlah_data" id="" class="form-control mr-4">
                            <option value="">Jumlah Data</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>

                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Terapkan</button>
                    </div>

                    <div class="col-auto form-group">
                        <a class="btn btn-primary" href="{{ route('products.create') }}">Tambah Produk</a>
                        <a class="btn btn-primary" href="{{ route('product.export') }}">Export to Excel</a>
                    </div>

                </div>
            </form>

        </div>
    </div>

    <div class="row">
        @foreach ($products as $product)
        <div class="col-md-3 mb-3">
            <div class="card">
                <img src="{{ $product->preview->content }}" class="card-img-top" alt="..."
                    style="width:100%; height: 30vh; object-fit: cover">
                <div class="card-body">
                    <h5 class="text-muted">{{ $product->title }}</h5>
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-secondary">{{ $product->price->price }}</p>
                        </div>
                        <div>
                            <div class="d-flex">
                                <a href="{{ route('products.edit', $product->id) }}">
                                    <span><i class="fas fa-pen fa-lg mr-2"></i></span></a>

                                <form action="{{ route('products.destroy', $product->id) }}" method="post"
                                    id="form-delete">
                                    @csrf
                                    @method('DELETE')
                                    <a id="delete" data-name="{{$product->title}}" style="cursor: pointer">
                                        <span><i class="fas fa-trash fa-lg"></i></span></a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

    </div>
    {{ $products->withQueryString()->links() }}
</div>
@endsection