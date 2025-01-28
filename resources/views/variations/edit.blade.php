@extends('adminlte::page')

@section('title', 'Edit Variation')

@section('content_header')
    <h1>Edit Variation for Product: {{ $product->name }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('products.variations.update', [$product->id, $variation->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="color">Color</label>
                    <input type="text" name="color" id="color" class="form-control" value="{{ $variation->color }}" required>
                </div>
                <div class="form-group">
                    <label for="size">Size</label>
                    <input type="text" name="size" id="size" class="form-control" value="{{ $variation->size }}" required>
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" name="price" id="price" class="form-control" value="{{ $variation->price }}" step="0.01" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('products.variations.index', $product->id) }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@stop
