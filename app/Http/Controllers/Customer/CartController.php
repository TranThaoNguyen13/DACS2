<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    // Thêm sản phẩm vào giỏ hàng
    public function addToCart(Request $request)
    {
        
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1); // Mặc định số lượng là 1
    
        if ($quantity <= 0) {
            return response()->json(['error' => 'Số lượng không hợp lệ!']);
        }
    
        $product = Product::find($productId);
    
        if (!$product) {
            return response()->json(['error' => 'Sản phẩm không tồn tại!']);
        }
    
        // Lấy giỏ hàng từ session
        $cart = session()->get('cart', []);
    
        // Kiểm tra sản phẩm đã tồn tại trong giỏ hàng chưa
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity; // Cộng dồn số lượng
        } else {
            $cart[$productId] = [
                'name' => $product->name,
                'quantity' => $quantity,
                'new_price' => $product->new_price,
                'old_price' => $product->old_price,
                'image' => $product->image,
            ];
        }
    
        // Lưu giỏ hàng vào session
        session()->put('cart', $cart);
    
        // Kiểm tra lại giỏ hàng trong session
        Log::info('Giỏ hàng sau khi thêm sản phẩm: ', $cart);
    
        return response()->json(['success' => 'Sản phẩm đã được thêm vào giỏ hàng!']);
    }
    

    // Hiển thị giỏ hàng
    public function index()
    {
        // Lấy giỏ hàng từ session
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return view('cart.index', ['cart' => [], 'totalQuantity' => 0, 'totalPrice' => 0]);
        }

        // Tính tổng số lượng và tổng giá trị giỏ hàng
        $totalQuantity = array_sum(array_column($cart, 'quantity'));
        $totalPrice = array_sum(array_map(function ($item) {
            return $item['new_price'] * $item['quantity'];
        }, $cart));

        // Trả về view với dữ liệu giỏ hàng
        return view('cart.index', compact('cart', 'totalQuantity', 'totalPrice'));
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function update(Request $request)
    {
        $cart = session()->get('cart', []);

        // Lấy số lượng của các sản phẩm từ form gửi lên
        foreach ($request->input('quantities', []) as $productId => $quantity) {
            // Kiểm tra và cập nhật số lượng nếu sản phẩm có trong giỏ
            if (isset($cart[$productId])) {
                // Đảm bảo số lượng không nhỏ hơn 1
                $cart[$productId]['quantity'] = max(1, (int)$quantity);
            }
        }

        // Lưu lại giỏ hàng vào session
        session()->put('cart', $cart);

        // Kiểm tra lại giỏ hàng trong session
        Log::info('Giỏ hàng sau khi cập nhật: ', $cart);

        return redirect()->route('cart.index')->with('success', 'Cập nhật giỏ hàng thành công!');
    }
    public function updatee(Request $request)
    {
        $cart = session()->get('cart', []);

        // Lấy số lượng của các sản phẩm từ form gửi lên
        foreach ($request->input('quantities', []) as $productId => $quantity) {
            // Kiểm tra và cập nhật số lượng nếu sản phẩm có trong giỏ
            if (isset($cart[$productId])) {
                // Đảm bảo số lượng không nhỏ hơn 1
                $cart[$productId]['quantity'] = max(1, (int)$quantity);
            }
        }

        // Lưu lại giỏ hàng vào session
        session()->put('cart', $cart);

        // Kiểm tra lại giỏ hàng trong session
        Log::info('Giỏ hàng sau khi cập nhật: ', $cart);

        return redirect()->route('checkout')->with('success', 'Cập nhật giỏ hàng thành công!');
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function remove($productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        // Nếu giỏ hàng trống thì xóa giỏ hàng khỏi session
        if (empty($cart)) {
            session()->forget('cart');
        }

        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng!');
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        // Tính tổng số tiền của giỏ hàng
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['new_price'] * $item['quantity'];
        }

        // Cập nhật số lượng đã bán trong database (Chỉ thực hiện sau khi thanh toán)
        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);

            if ($product) {
                $product->sold += $item['quantity']; // Cập nhật số lượng đã bán
                $product->save(); // Lưu thay đổi vào database
            }
        }

        // Lấy lại thông tin sản phẩm đã được cập nhật
        $productsUpdated = Product::whereIn('id', array_keys($cart))->get();

        // Trả về view với thông tin cập nhật
        return view('checkout', compact('cart', 'total', 'productsUpdated'));
    }

    // Phương thức xử lý thanh toán các sản phẩm đã chọn
    public function checkoutAll(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        // Tính tổng số tiền của giỏ hàng
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['new_price'] * $item['quantity'];
        }

        // Cập nhật số lượng đã bán trong database (Chỉ thực hiện sau khi thanh toán)
        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);

            if ($product) {
                $product->sold += $item['quantity']; // Cập nhật số lượng đã bán
                $product->save(); // Lưu thay đổi vào database
            }
        }

        // Lấy lại thông tin sản phẩm đã được cập nhật
        $productsUpdated = Product::whereIn('id', array_keys($cart))->get();

        // Trả về view với thông tin cập nhật
        return view('checkout', compact('cart', 'total', 'productsUpdated'));
    }
// Thanh toán các sản phẩm được chọn
public function checkoutSelected(Request $request)
{
    // Lấy thông tin các sản phẩm được chọn từ form gửi lên
    $selectedProducts = $request->input('selected_products', []); 

    // Kiểm tra nếu không có sản phẩm nào được chọn
    if (empty($selectedProducts)) {
        return redirect()->route('cart.index')->with('error', 'Vui lòng chọn ít nhất một sản phẩm để thanh toán.');
    }

    // Lấy giỏ hàng từ session
    $cart = session()->get('cart', []);
    $selectedItems = [];
    $total = 0;

    // Kiểm tra và tính tổng tiền cho các sản phẩm được chọn
    foreach ($selectedProducts as $productId) {
        if (isset($cart[$productId])) {
            $selectedItems[$productId] = $cart[$productId];
            $total += $cart[$productId]['new_price'] * $cart[$productId]['quantity'];
        }
    }

    // Kiểm tra nếu không có sản phẩm nào hợp lệ được chọn
    if (empty($selectedItems)) {
        return redirect()->route('cart.index')->with('error', 'Sản phẩm được chọn không hợp lệ hoặc đã bị xóa khỏi giỏ hàng.');
    }

    // Cập nhật số lượng bán cho các sản phẩm đã chọn trong database
    foreach ($selectedItems as $productId => $item) {
        $product = Product::find($productId);

        if ($product) {
            // Cập nhật số lượng bán chỉ cho những sản phẩm đã được chọn thanh toán
            $product->sold += $item['quantity'];
            $product->save(); // Lưu thay đổi vào cơ sở dữ liệu
        }
    }

    // // Xóa các sản phẩm đã thanh toán khỏi giỏ hàng
    // foreach ($selectedProducts as $productId) {
    //     if (isset($cart[$productId])) {
    //         unset($cart[$productId]); // Xóa sản phẩm đã thanh toán khỏi giỏ hàng
    //     }
    // }

    // Cập nhật lại giỏ hàng trong session sau khi xóa các sản phẩm đã thanh toán
    session()->put('cart', $cart);

    // Trả về view với giỏ hàng đã chọn và tổng tiền
    return view('checkout', ['cart' => $selectedItems, 'total' => $total]);
}
}