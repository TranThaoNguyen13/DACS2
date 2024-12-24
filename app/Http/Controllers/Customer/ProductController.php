<?php
namespace App\Http\Controllers\Customer;

use App\Models\Product;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Http\Request;

// use Illuminate\Support\Facades\Log;
use App\Models\Brand;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all(); // Lấy tất cả sản phẩm
        return view('products.index', compact('products')); 
    }
    public function getBestSellers()
    {
        // Lấy 10 sản phẩm bán chạy nhất dựa trên cột `sold`
        $bestSellers = Product::orderBy('sold', 'desc')->limit(10)->get();

        return view('customer.home', compact('bestSellers')); // giả sử đây là trang chủ
    }
    public function indexByCategory($categoryId)
    {
        // Log::info("Category ID: " . $categoryId);
        $category = Category::findOrFail($categoryId);
        $products = Product::where('category_id', $categoryId)->paginate(8) ; // Phân trang 6 sản phẩm
        // Log::info("Number of products found: " . $products->count());
        
        return view('products.index', compact('products', 'category'));
    }
    public function show($id)
    {
        $product = Product::find($id);
        
        // Kiểm tra xem sản phẩm có tồn tại không
        if (!$product) {
            return redirect()->route('home')->with('error', 'Sản phẩm không tồn tại.');
        }
        
        // Tìm các sản phẩm liên quan (ví dụ: cùng danh mục)
        $relatedProducts = Product::where('category_id', $product->category_id)
                                    ->where('id', '!=', $product->id) // Loại trừ sản phẩm hiện tại
                                    ->take(8) // Lấy tối đa 8 sản phẩm liên quan
                                    ->get();
        
        // Truyền đúng các biến: product và relatedProducts
        return view('products.detail', compact('product', 'relatedProducts'));
    }
    
    
public function indexByBrand($brandId)
{
    // Lấy thương hiệu theo $brandId
    $brand = Brand::findOrFail($brandId);

    // Lấy tất cả sản phẩm thuộc thương hiệu này
    $products = Product::where('brand_id', $brand->id)->get();

    // Trả về view với danh sách sản phẩm
    return view('products.index', compact('products', 'brand'));
}
public function showProductsByBrand($brandId)
{
    // Lấy thương hiệu theo ID
    $brand = Brand::findOrFail($brandId);

    // Lấy tất cả sản phẩm của thương hiệu này
    $products = Product::where('brand_id', $brandId)->get();

    // Kiểm tra xem có sản phẩm không
    if ($products->isEmpty()) {
        return redirect()->route('customer.home')->with('error', 'Không có sản phẩm của thương hiệu này.');
    }

    // Tìm các sản phẩm liên quan (ví dụ: cùng danh mục)
    // Dùng danh mục của sản phẩm đầu tiên (ví dụ: sản phẩm cùng danh mục với sản phẩm đầu tiên)
    $relatedProducts = Product::where('category_id', $products->first()->category_id)
                             ->where('brand_id', '!=', $brandId) // Loại trừ các sản phẩm cùng thương hiệu
                             ->take(8) // Lấy tối đa 8 sản phẩm liên quan
                             ->get();

    // Trả về view với dữ liệu
    return view('customer.products_by_brand', compact('brand', 'products', 'relatedProducts'));
}

public function showByBrand($brandId)
{
    // Lấy tất cả sản phẩm của thương hiệu theo brandId
    $products = Product::where('brand_id', $brandId)->get();

    // Trả về view với danh sách sản phẩm của thương hiệu
    return view('products.brand', compact('products'));
}
public function addComment(Request $request, $productId)
{
    $request->validate([
        'content' => 'required|max:500|min:5',
    ], [
        'content.required' => 'Vui lòng nhập...',
        'content.min' => 'Vui lòng nhập 5 kí tự'
    ]);

    Comment::create([
        'product_id' => $productId,
        'user_id' => auth()->id(),
        'content' => $request->content,
    ]);

    return redirect()->back()->with('success', 'Bình luận của bạn đã được thêm!');
}


}
