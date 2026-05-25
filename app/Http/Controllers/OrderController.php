<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Table;
use App\Models\Category;

class OrderController extends Controller
{
    // ================== POS PAGE ==================
    public function create(Request $request)
    {
        // 📂 Lấy danh mục
        $categories = Category::all();

        // 🛒 Query sản phẩm
        $query = Product::query();

        // 🔍 LỌC THEO DANH MỤC
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // 🔥 PHÂN TRANG (8 sản phẩm / trang)
        $products = $query->paginate(8);

        // 🪑 Bàn
        $tables = Table::all();

        return view('orders.create', compact(
            'products',
            'tables',
            'categories'
        ));
    }

    // ================== TẠO ORDER ==================
    public function store(Request $request)
    {
        $request->validate([
            'table_id' => 'required|exists:tables,id',
            'products' => 'required|array'
        ]);

        $total = 0;

        // ✅ tạo order
        $order = Order::create([
            'table_id' => $request->table_id,
            'total_price' => 0,
            'status' => 'pending'
        ]);

        foreach ($request->products as $productId => $qty) {

            if ($qty > 0) {

                $product = Product::find($productId);

                if (!$product) continue; // tránh lỗi

                $subtotal = $product->price * $qty;
                $total += $subtotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $qty,
                    'price' => $product->price
                ]);
            }
        }

        // ✅ update tổng tiền
        $order->update([
            'total_price' => $total
        ]);

        // ✅ đổi trạng thái bàn
        Table::where('id', $request->table_id)
            ->update(['status' => 'occupied']);

        return redirect()->back()->with('success', 'Đặt đơn thành công!');
    }

    // ================== XEM ORDER THEO BÀN ==================
    public function showByTable($id)
    {
        $order = Order::where('table_id', $id)
            ->where('status', 'pending')
            ->with('items.product', 'table')
            ->first();

        return view('orders.table', compact('order'));
    }

    // ================== THANH TOÁN ==================
    public function complete($id)
    {
        $order = Order::findOrFail($id);

        // ✅ đổi trạng thái order
        $order->update([
            'status' => 'paid'
        ]);

        // ✅ reset bàn
        Table::where('id', $order->table_id)
            ->update(['status' => 'empty']);

        return redirect('/orders/create')->with('success', 'Thanh toán xong!');
    }
}