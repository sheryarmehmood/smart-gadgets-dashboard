@extends('adminlte::page')

@section('title', 'Create Product')

@section('content_header')
    <h1>Create Product</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Add a New Product</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Image Preview -->
                <div class="col-md-6 text-center">
                    <div class="main-product-image">
                        <img id="product-image-preview"
                             src=""
                             alt="Product Image Preview" 
                             class="img-fluid rounded shadow-sm d-none"
                             style="max-width: 100%; height: 400px; object-fit: cover;">
                    </div>
                </div>

                <!-- Product Form -->
                <div class="col-md-6">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" name="price" id="price" class="form-control" step="0.01" required>
                        </div>

                        <div class="form-group">
                            <label for="image">Product Image</label>
                            <input type="file" name="image" id="image" class="form-control" accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
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
        // Image Preview Before Upload
        document.getElementById('image').addEventListener('change', function(event) {
            let preview = document.getElementById('product-image-preview');
            let reader = new FileReader();

            reader.onload = function() {
                preview.src = reader.result;
                preview.classList.remove('d-none'); // Show image after selection
            };

            if (event.target.files.length > 0) {
                reader.readAsDataURL(event.target.files[0]);
            } else {
                preview.src = "";
                preview.classList.add('d-none'); // Hide image if no file is selected
            }
        });
    </script>
@stop
