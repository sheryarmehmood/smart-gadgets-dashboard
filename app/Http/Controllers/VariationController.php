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
                ->addColumn('action', function ($variation) use ($product) {
                    $editUrl = route('products.variations.edit', [$product->id, $variation->id]);
                    $deleteUrl = route('products.variations.destroy', [$product->id, $variation->id]);
                    return '
                        <a href="' . $editUrl . '" class="btn btn-sm btn-primary">Edit</a>
                        <form action="' . $deleteUrl . '" method="POST" style="display:inline;">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                        </form>
                    ';
                })
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

        return redirect()->route('products.variations.index', $product->id)
            ->with('success', 'Variation deleted successfully.');
    }
}
