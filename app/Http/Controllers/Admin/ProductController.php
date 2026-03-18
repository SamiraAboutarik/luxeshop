<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Product, Category};
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller {
    public function index() {
        $products = Product::with('category')->latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }
    public function create() {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }
    public function store(Request $request) {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|max:2048',
            'is_active'   => 'boolean',
        ]);
        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }
        Product::create($data);
        return redirect()->route('admin.products.index')->with('success', 'Produit créé avec succès !');
    }
    public function edit(Product $product) {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }
    public function update(Request $request, Product $product) {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|max:2048',
            'is_active'   => 'boolean',
        ]);
        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }
        $product->update($data);
        return redirect()->route('admin.products.index')->with('success', 'Produit mis à jour !');
    }
    public function destroy(Product $product) {
        $product->delete();
        return back()->with('success', 'Produit supprimé.');
    }
}
