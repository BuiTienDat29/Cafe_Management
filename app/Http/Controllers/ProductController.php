<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Table;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // ================== LIST ==================
    public function index(Request $request)
    {
        $query = Product::with('category');

        // 🔍 SEARCH
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 📂 FILTER CATEGORY
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->paginate(10);
        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    // ================== CREATE ==================
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    // ================== STORE ==================
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'category_id' => 'required|exists:categories,id'
        ]);

        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();

        $image->move(public_path('storage/products'), $imageName);

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' => 'storage/products/' . $imageName,
            'category_id' => $request->category_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thêm thành công'
        ]);
    }

    // ================== UPDATE ==================
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric'
        ]);

        $data = [
            'name' => $request->name,
            'price' => $request->price
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('storage/products'), $imageName);

            $data['image'] = 'storage/products/' . $imageName;
        }

        $product->update($data);

        return response()->json([
            'name' => $product->name,
            'price' => $product->price,
            'image' => asset($product->image)
        ]);
    }

    // ================== DELETE ==================
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'success' => true
        ]);
    }

    // ================== DASHBOARD ==================
    public function dashboard()
    {
        // ===== THỐNG KÊ =====
        $totalProducts = Product::count();
        $totalCategories = Category::count();

        $totalTables = Table::count();
        $occupiedTables = Table::where('status', 'occupied')->count();
        $emptyTables = Table::where('status', 'empty')->count();

        // ===== LẤY 5 DANH MỤC =====
        $categoryData = Category::withCount('products')
            ->take(5)
            ->get();

        // 👉 DỮ LIỆU CHO CHART
        $labelsCategory = $categoryData->pluck('name');
        $counts = $categoryData->pluck('products_count');

        return view('dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalTables',
            'occupiedTables',
            'emptyTables',
            'labelsCategory',
            'counts'
        ));
    }
}