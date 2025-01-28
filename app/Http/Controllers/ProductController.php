<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;


class ProductController extends Controller
{
    public function index(Request $request)
{
    if ($request->ajax()) {
        $products = Product::query();

        return DataTables::of($products)
            ->addColumn('actions', function ($product) {
                return '
                    <a href="' . route('products.show', $product->id) . '" class="btn btn-primary btn-sm">View</a>
                    <a href="' . route('products.edit', $product->id) . '" class="btn btn-warning btn-sm">Edit</a>
                    <button class="btn btn-danger btn-sm delete-product" data-id="' . $product->id . '">Delete</button>
                    <a href="' . route('products.variations.index', $product->id) . '" class="btn btn-info btn-sm">Variations</a>';
                    
            })
            ->rawColumns(['actions']) // Allow raw HTML for the actions column
            ->make(true);
    }

    return view('products.index');
}


    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);

        Product::create($validated);
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }


    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);

        $product = Product::findOrFail($id);
        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
