<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Variation;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class VariationController extends Controller
{
    public function index(Product $product, Request $request)
    {
        if ($request->ajax()) {
            $variations = $product->variations()->select(['id', 'color', 'size', 'price', 'created_at']);
            return DataTables::of($variations)
                ->addColumn('actions', function ($variation) use ($product) {
                    return '
                        <a href="' . route('products.variations.show', [$product->id, $variation->id]) . '" class="btn btn-primary btn-sm">View</a>
                        <a href="' . route('products.variations.edit', [$product->id, $variation->id]) . '" class="btn btn-warning btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm delete-variation" data-id="' . $variation->id . '" data-product-id="' . $product->id . '">Delete</button>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('variations.index', compact('product'));
    }

    public function create(Product $product)
    {
        return view('variations.create', compact('product'));
    }

    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'color' => 'required|string|max:50',
            'size' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
        ]);

        $product->variations()->create($validated);

        return redirect()->route('products.variations.index', $product->id)
            ->with('success', 'Variation created successfully.');
    }

    public function show(Product $product, $id)
    {
        $variation = $product->variations()->findOrFail($id);
        return view('variations.show', compact('product', 'variation'));
    }

    public function edit(Product $product, $id)
    {
        $variation = $product->variations()->findOrFail($id);
        return view('variations.edit', compact('product', 'variation'));
    }

    public function update(Request $request, Product $product, $id)
    {
        $validated = $request->validate([
            'color' => 'required|string|max:50',
            'size' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
        ]);

        $variation = $product->variations()->findOrFail($id);
        $variation->update($validated);

        return redirect()->route('products.variations.index', $product->id)
            ->with('success', 'Variation updated successfully.');
    }

    public function destroy(Product $product, $id)
    {
        $variation = $product->variations()->findOrFail($id);
        $variation->delete();

        return response()->json(['message' => 'Variation deleted successfully.']);
    }
}
