@extends('adminlte::page')

@section('title', 'Add Variation')

@section('content_header')
    <h1>Add Variation for Product: {{ $product->name }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('products.variations.store', $product->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="color">Color</label>
                    <input type="text" name="color" id="color" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="size">Size</label>
                    <input type="text" name="size" id="size" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" name="price" id="price" class="form-control" step="0.01" required>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('products.variations.index', $product->id) }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@stop
