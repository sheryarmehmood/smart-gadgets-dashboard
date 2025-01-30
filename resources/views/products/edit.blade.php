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
            <div class="row">
                <!-- Product Image Preview -->
                <div class="col-md-6 text-center">
                    <div class="main-product-image">
                        <img id="product-image-preview"
                             src="{{ asset( $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="img-fluid rounded shadow-sm"
                             style="max-width: 100%; height: 400px; object-fit: cover;">
                    </div>
                </div>

                <!-- Product Edit Form -->
                <div class="col-md-6">
                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
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

                        <div class="form-group">
                            <label for="image">Product Image</label>
                            <input type="file" name="image" id="image" class="form-control" accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Add any specific CSS if needed --}}
@stop

@section('js')
    <script>
        // Preview Image Before Upload
        document.getElementById('image').addEventListener('change', function(event) {
            let reader = new FileReader();
            reader.onload = function() {
                document.getElementById('product-image-preview').src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        });
    </script>
@stop
