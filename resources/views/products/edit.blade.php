@extends('adminlte::page')

@section('title', 'Edit Product')

@section('content_header')
    <h1>Edit Product</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Product: {{ $product->name }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('products.update', $product->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4">{{ $product->description }}</textarea>
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" name="price" id="price" class="form-control" value="{{ $product->price }}" step="0.01" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@stop

@section('css')
    {{-- Add any specific CSS if needed --}}
@stop

@section('js')
    {{-- Add any specific JS if needed --}}
@stop
