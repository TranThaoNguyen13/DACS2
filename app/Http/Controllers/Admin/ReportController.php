<?php

// app/Http/Controllers/Admin/ReportController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;  // Thêm model Category
use App\Models\Product;   // Thêm model Product
use App\Models\Order;     // Thêm model Order
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // Lấy tổng doanh thu
        $totalRevenue = Order::sum('total');
        $categories = Category::all();
        $salesData = [];
        // Lấy doanh thu theo danh mục
        $categoryRevenue = Category::with(['products' => function ($query) {
            $query->join('orders', 'products.id', '=', 'orders.product_id')
                  ->selectRaw('sum(orders.total) as total_revenue, products.category_id')
                  ->groupBy('products.category_id');
        }])->get();
        foreach ($categories as $category) {
            $totalSales = Order::join('products', 'orders.product_id', '=', 'products.id')
                               ->where('products.category_id', $category->id)
                               ->sum('orders.total');
            $salesData[] = [
                'category' => $category->name,
                'total_sales' => $totalSales
            ];
        }


        return view('admin.reports.index', compact('totalRevenue', 'categoryRevenue', 'salesData'));
    }
   
}
