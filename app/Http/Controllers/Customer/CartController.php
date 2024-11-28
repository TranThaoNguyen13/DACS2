<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        if ($quantity <= 0) {
            return response()->json(['error' => 'Số lượng không hợp lệ!']);
        }

        $product = Product::find($productId);
        if (!$product) {
            return response()->json(['error' => 'Sản phẩm không tồn tại!']);
        }

        $cart = session()->get('cart', []);
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'name' => $product->name,
                'quantity' => $quantity,
                'new_price' => $product->new_price,
                'old_price' => $product->old_price,
                'image' => $product->image,
            ];
        }

        session()->put('cart', $cart);

        $cartCount = count($cart);
        return response()->json(['success' => 'Sản phẩm đã được thêm vào giỏ hàng!', 'cart_count' => $cartCount]);
    }

    public function update(Request $request)
{
    // Lấy giỏ hàng từ session hoặc database
    $cart = session()->get('cart', []);

    // Cập nhật số lượng cho từng sản phẩm
    foreach ($request->quantities as $key => $quantity) {
        if (isset($cart[$key])) {
            $cart[$key]['quantity'] = $quantity;
        }
    }

    // Lưu lại giỏ hàng vào session
    session()->put('cart', $cart);

    // Chuyển hướng lại trang giỏ hàng với thông báo
    return redirect()->back()->with('success', 'Cập nhật số lượng thành công.');
}



public function checkoutAll(Request $request)
{
    // Lấy giỏ hàng từ session
    $cart = session()->get('cart', []);

    // Kiểm tra nếu giỏ hàng trống
    if (empty($cart)) {
        return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn không có sản phẩm.');
    }

    // Tính tổng tiền của giỏ hàng
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['new_price'] * $item['quantity'];
    }

    // Chuyển dữ liệu giỏ hàng và tổng tiền sang trang thanh toán (checkout)
    return view('checkout', compact('cart', 'total'));
}



public function checkoutSelected(Request $request)
{
    $selectedProducts = $request->input('selected_products', []);

    if (empty($selectedProducts)) {
        return redirect()->route('cart.index')->with('error', 'Vui lòng chọn ít nhất một sản phẩm để thanh toán.');
    }

    $cart = session()->get('cart', []);
    $cartItems = [];
    $total = 0;

    foreach ($selectedProducts as $productId) {
        if (isset($cart[$productId])) {
            $cartItems[] = $cart[$productId];
            $total += $cart[$productId]['new_price'] * $cart[$productId]['quantity'];
        }
    }

    if (empty($cartItems)) {
        return redirect()->route('cart.index')->with('error', 'Không có sản phẩm nào hợp lệ để thanh toán.');
    }

    return view('checkout', compact('cartItems', 'total'));
}

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        if (empty($cart)) {
            session()->forget('cart');
        }

        session()->flash('success', 'Sản phẩm đã được xóa khỏi giỏ hàng!');
        return redirect()->route('cart.index');
    }

    public function index()
{
    $cart = session()->get('cart', []);

    foreach ($cart as $id => $item) {
        // Kiểm tra xem sản phẩm có tồn tại trong cơ sở dữ liệu
        $product = Product::find($id);
        if (!$product) {
            // Nếu sản phẩm không tồn tại, xóa khỏi giỏ hàng
            unset($cart[$id]);
        }
    }

    // Cập nhật giỏ hàng sau khi lọc
    session()->put('cart', $cart);

    $totalQuantity = array_sum(array_column($cart, 'quantity'));
    $totalPrice = array_sum(array_map(function ($item) {
        return $item['new_price'] * $item['quantity'];
    }, $cart));

    return view('cart.index', compact('cart', 'totalQuantity', 'totalPrice'));
}


    public function checkout(Request $request)
    {
        $selectedProducts = $request->input('selected_products', []); // Mặc định là mảng rỗng nếu không có sản phẩm nào được chọn

        // Kiểm tra nếu không có sản phẩm nào được chọn
        if (empty($selectedProducts)) {
            return redirect()->route('cart.index')->with('error', 'Vui lòng chọn ít nhất một sản phẩm để thanh toán.');
        }

        $cartItems = [];
        $total = 0;

        foreach ($selectedProducts as $productId) {
            $product = session()->get("cart.$productId");
            if ($product) {
                $cartItems[] = $product;
                $total += $product['new_price'] * $product['quantity'];
            }
        }

        // Kiểm tra nếu không có sản phẩm nào trong giỏ hàng
        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Không có sản phẩm nào trong giỏ hàng để thanh toán.');
        }

        return view('checkout', compact('cartItems', 'total'));
    }
}





// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\Product;
// use Illuminate\Support\Facades\Session;

// class CartController extends Controller
// {
//     public function addToCart(Request $request)
//     {
//         $productId = $request->input('product_id');
//         $quantity = $request->input('quantity');
    
//         if ($quantity <= 0) {
//             return response()->json(['error' => 'Số lượng không hợp lệ!']);
//         }
    
//         $product = Product::find($productId);
//         if (!$product) {
//             return response()->json(['error' => 'Sản phẩm không tồn tại!']);
//         }
    
//         $cart = session()->get('cart', []);
//         if (isset($cart[$productId])) {
//             $cart[$productId]['quantity'] += $quantity;
//         } else {
//             $cart[$productId] = [
//                 'name' => $product->name,
//                 'quantity' => $quantity,
//                 'new_price' => $product->new_price,
//                 'old_price' => $product->old_price,
//                 'image' => $product->image,
//             ];
//         }
    
//         session()->put('cart', $cart);
    
//         $cartCount = count($cart);
//         return response()->json(['success' => 'Sản phẩm đã được thêm vào giỏ hàng!', 'cart_count' => $cartCount]);
//     }
    

//     public function index()
//     {
//         // Lấy giỏ hàng từ session
//         $cart = session()->get('cart', []);

//         // Trả về view giỏ hàng
//         return view('cart.index', compact('cart'));
//     }

//     public function checkout()
//     {
//         // Lấy giỏ hàng từ session
//         $cartItems = Session::get('cart', []);
//         $totalQuantity = 0;
//         $totalPrice = 0;

//         // Tính tổng số lượng và giá tiền của giỏ hàng
//         foreach ($cartItems as $item) {
//             $totalQuantity += $item['quantity'];
//             $totalPrice += $item['new_price'] * $item['quantity'];
//         }

//         return view('checkout', compact('cartItems', 'totalQuantity', 'totalPrice'));
//     }

//     public function update(Request $request, $id)
// {
//     // Lấy giỏ hàng từ session
//     $cart = session()->get('cart');

//     // Kiểm tra sản phẩm có trong giỏ không
//     if (isset($cart[$id])) {
//         // Cập nhật số lượng sản phẩm
//         $cart[$id]['quantity'] = $request->input('quantity');
//         session()->put('cart', $cart);  // Cập nhật giỏ hàng trong session

//         // Thông báo cập nhật thành công
//         session()->flash('success', 'Giỏ hàng đã được cập nhật!');
//     }

//     // Chuyển hướng về trang giỏ hàng
//     return redirect()->route('cart.index');
// }

//     public function remove($id)
// {
//     // Lấy giỏ hàng từ session
//     $cart = session()->get('cart');

//     // Kiểm tra nếu sản phẩm tồn tại trong giỏ hàng
//     if (isset($cart[$id])) {
//         unset($cart[$id]);  // Xóa sản phẩm khỏi giỏ hàng
//         session()->put('cart', $cart);  // Cập nhật lại giỏ hàng trong session
//     }

//     // Kiểm tra nếu giỏ hàng trống, xóa giỏ hàng khỏi session
//     if (empty($cart)) {
//         session()->forget('cart');
//     }

//     // Đặt thông báo vào session và chuyển hướng về trang giỏ hàng
//     session()->flash('success', 'Sản phẩm đã được xóa khỏi giỏ hàng!');
//     return redirect()->route('cart.index');  // Giả sử route trang giỏ hàng là 'cart.index'
// }
// // public function checkoutSelected(Request $request)
// // {
// //     $selectedProducts = $request->input('selected_products');

// //     // Nếu không có sản phẩm nào được chọn, thông báo lỗi
// //     if (empty($selectedProducts)) {
// //         return redirect()->route('cart.index')->with('error', 'Vui lòng chọn ít nhất một sản phẩm để thanh toán.');
// //     }

// //     // Lấy thông tin sản phẩm từ session
// //     $products = [];
// //     $total = 0;
// //     foreach ($selectedProducts as $productId) {
// //         $product = session()->get("cart.$productId");
// //         if ($product) {
// //             $products[] = $product;
// //             $total += $product['new_price'] * $product['quantity'];
// //         }
// //     }

// //     // Chuyển đến trang thanh toán với danh sách sản phẩm đã chọn
// //     return view('checkout', compact('products', 'total'));
// // }
// public function showCart()
// {
//     $cartItems = Cart::getItems(); // Or however you're retrieving items from the cart
//     return view('cart.index', compact('cartItems'));
// }





// }