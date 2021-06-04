@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-5">
        <div class="col">
            <a class="btn btn-primary" href="{{ route('products.index') }}">Daftar Produk</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('products.update', $product->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input name="title" type="text" class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title') ?? $product->title }}">

                            @include('layouts.partials._error', [
                            'name' => 'title'
                            ])
                        </div>

                        <div class="form-group">
                            <label for="lang">Lang</label>
                            <input name="lang" type="text" class="form-control @error('lang') is-invalid @enderror"
                                value="{{ old('lang') ?? $product->lang }}">

                            @include('layouts.partials._error', [
                            'name' => 'lang'
                            ])
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="1" {{ $product->status == '1' ? 'selected': '' }}>Tersedia</option>
                                <option value="0" {{ $product->status == '0' ? 'selected': '' }}>Kosong
                                </option>
                            </select>

                            @include('layouts.partials._error', [
                            'name' => 'status'
                            ])
                        </div>

                        <div class="form-group">
                            <label for="type">Tipe</label>
                            <select name="type" id="type" class="form-control">
                                <option value="6" {{ $product->type == '6' ? 'selected': '' }}>Preview</option>
                            </select>

                            @include('layouts.partials._error', [
                            'name' => 'type'
                            ])
                        </div>

                        <div class="form-group">
                            <label for="count">Count</label>
                            <input name="count" type="number" class="form-control @error('count') is-invalid @enderror"
                                value="{{ old('count') ?? $product->count}}">

                            @include('layouts.partials._error', [
                            'name' => 'count'
                            ])
                        </div>

                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select id="category_id" class="form-control @error('category_id') is-invalid @enderror"
                                name="category_id">
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $product->categories[0]->id == $category->id  ? "selected" : "" }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>

                            @include('layouts.partials._error', [
                            'name' => 'category_id'
                            ])
                        </div>

                        <div class="form-group">
                            <label for="content">Image</label>
                            <input type="file" class="form-control-file @error('content') is-invalid @enderror"
                                id="content" name="content">

                            @include('layouts.partials._error', [
                            'name' => 'content'
                            ])
                        </div>

                        <div class="form-group">
                            <label for="price">Price</label>
                            <input name="price" type="number" class="form-control @error('price') is-invalid @enderror"
                                value="{{ old('price') ??  $product->price->price }}">

                            @include('layouts.partials._error', [
                            'name' => 'price'
                            ])
                        </div>

                        <div class="form-group">
                            <label for="stock">Stock</label>
                            <input name="stock" type="number" class="form-control @error('stock') is-invalid @enderror"
                                value="{{ old('stock')?? $product->stock->stock  }}">

                            @include('layouts.partials._error', [
                            'name' => 'stock'
                            ])
                        </div>

                        <button type="submit" class="btn btn-sm btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection