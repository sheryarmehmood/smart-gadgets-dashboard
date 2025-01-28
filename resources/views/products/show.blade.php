@extends('adminlte::page')

@section('title', 'Product Details')

@section('content_header')
    <h1>Product Details</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Product: {{ $product->name }}</h3>
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $product->id }}</p>
            <p><strong>Name:</strong> {{ $product->name }}</p>
            <p><strong>Description:</strong> {{ $product->description }}</p>
            <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
            <p><strong>Created At:</strong> {{ $product->created_at }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to Products</a>
        </div>
    </div>
@stop
