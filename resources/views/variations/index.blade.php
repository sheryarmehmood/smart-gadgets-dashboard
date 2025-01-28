@extends('adminlte::page')

@section('title', 'Product Variations')

@section('content_header')
    <h1>Variations for Product: {{ $product->name }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Variation Management</h3>
            <a href="{{ route('products.variations.create', $product->id) }}" class="btn btn-success btn-sm float-right">Add Variation</a>
        </div>
        <div class="card-body">
            <table id="variations-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Color</th>
                        <th>Size</th>
                        <th>Price</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            const table = $('#variations-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('products.variations.index', $product->id) }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'color', name: 'color' },
                    { data: 'size', name: 'size' },
                    { data: 'price', name: 'price' },
                    { data: 'created_at', name: 'created_at' },
                    { 
                        data: 'actions', 
                        name: 'actions', 
                        orderable: false, 
                        searchable: false 
                    }
                ]
            });

            $('#variations-table').on('click', '.delete-variation', function () {
                const variationId = $(this).data('id');
                const productId = $(this).data('product-id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/products/${productId}/variations/${variationId}`,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function (response) {
                                Swal.fire(
                                    'Deleted!',
                                    response.message,
                                    'success'
                                );
                                table.ajax.reload();
                            },
                            error: function () {
                                Swal.fire(
                                    'Error!',
                                    'An error occurred while deleting the variation.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
@stop
