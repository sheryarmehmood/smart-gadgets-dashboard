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
        $products = Product::select(['id', 'name', 'price', 'image', 'created_at']);

        return DataTables::of($products)
            ->addColumn('image', function ($product) {
                $imagePath = asset($product->image);
                
                return '<img src="' . $imagePath . '" alt="' . $product->name . '" width="50" height="50">';
            })
            ->addColumn('actions', function ($product) {
                return '
                    <a href="' . route('products.show', $product->id) . '" class="btn btn-primary btn-sm">View</a>
                    <a href="' . route('products.edit', $product->id) . '" class="btn btn-warning btn-sm">Edit</a>
                    <button class="btn btn-danger btn-sm delete-product" data-id="' . $product->id . '">Delete</button>
                    <a href="' . route('products.variations.index', $product->id) . '" class="btn btn-info btn-sm">Variations</a>';
            })
            ->rawColumns(['image', 'actions']) // Allow raw HTML for image and actions column
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle Image Upload
        if ($request->hasFile('image')) {
        $filename = str_replace(' ', '_', $request->image->getClientOriginalName());
        $imagePath = 'images/' . $filename;

        // Move the uploaded image to 'public/images', overwriting if exists
        $request->image->move(public_path('images'), $filename);

        // Assign the image path to be saved in the database
        $validated['image'] = $imagePath;
        }

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);
        // Handle Image Upload
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($product->image && file_exists(public_path('images/' . $product->image))) {
                unlink(public_path('images/' . $product->image));
            }

            // Store new image
            $imageName = 'images/' . ' ' . $request->image->getClientOriginalName();
            $request->image->move(public_path('images'), $imageName);
            $validated['image'] = $imageName;
         
        }

       

        // $product->update($validated);
        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        
        return response()->json(['success' => 'Product deleted successfully!']);
}
