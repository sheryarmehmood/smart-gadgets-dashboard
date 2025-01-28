@extends('adminlte::page')

@section('title', 'Variation Details')

@section('content_header')
    <h1>Variation Details for Product: {{ $product->name }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Variation Information</h3>
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $variation->id }}</p>
            <p><strong>Color:</strong> {{ $variation->color }}</p>
            <p><strong>Size:</strong> {{ $variation->size }}</p>
            <p><strong>Price:</strong> ${{ number_format($variation->price, 2) }}</p>
            <p><strong>Created At:</strong> {{ $variation->created_at }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('products.variations.index', $product->id) }}" class="btn btn-secondary">Back to Variations</a>
        </div>
    </div>
@stop

@section('css')
    {{-- Add any specific CSS if needed --}}
@stop

@section('js')
    {{-- Add any specific JS if needed --}}
@stop
