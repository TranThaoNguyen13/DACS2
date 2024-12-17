<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        dd(session('cart', []));
        // Kiểm tra giỏ hàng có rỗng hay không
        $cartItems = session('cart', []);
        if (empty($cartItems)) {
            return redirect()->route('checkout')->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        // Tính tổng số tiền
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['new_price'] * $item['quantity'];
        }

        // Tạo đơn hàng mới
        $order = new Order();
        $order->user_id = Auth::id(); // Lấy ID người dùng đã đăng nhập
        $order->total = $total;
        $order->status = 'Pending'; // Trạng thái ban đầu
        $order->save();

        // Xóa giỏ hàng sau khi đặt hàng thành công
        session()->forget('cart');
        session()->flash('success', 'Bạn đã đặt hàng thành công!');

        // Chuyển hướng về trang giỏ hàng hoặc trang xác nhận đặt hàng
        return redirect()->route('customer.home');
        
    }


    public function checkout(Order $order)
    {
        if ($order->status !== 'pending') {
            return redirect()->route('order.success')->with('error', 'Đơn hàng đã được thanh toán.');
        }
    
        // Lấy sản phẩm liên quan (cùng category)
        $relatedProducts = Product::where('category_id', $order->product->category_id)
                                  ->where('id', '!=', $order->product_id)
                                  ->take(16)
                                  ->get();
    
        return view('order.checkout', compact('order', 'relatedProducts'));
    }
    
    // Trong model Order.php
public function product()
{
    return $this->belongsTo(Product::class, 'product_id');
}

    
public function cancelOrder($orderId)
{
    // Lấy thông tin đơn hàng
    $order = Order::findOrFail($orderId);

    // Kiểm tra nếu đơn hàng chưa được thanh toán (trạng thái Pending)
    if ($order->status == 'Pending') {
        $order->status = 'Cancelled'; // Đặt trạng thái là "Cancelled"
        $order->save();

        // Thông báo thành công
        return redirect()->route('order.history')->with('success', 'Đơn hàng đã được hủy.');
    }

    // Nếu không thể hủy đơn hàng, thông báo lỗi
    return redirect()->route('order.history')->with('error', 'Không thể hủy đơn hàng đã thanh toán.');
}



public function processPayment(Request $request, Order $order)
{
    // Validate dữ liệu
    $request->validate([
        'address' => 'required|string|max:255',
        'phone' => 'required|string|max:15',
        'email' => 'required|email|max:255',
        'username' => 'required|string|max:255',
        'payment_method' => 'required|string|max:255',
    ]);

    // Cập nhật thông tin thanh toán cho đơn hàng
    $order->address = $request->input('address');
    $order->phone = $request->input('phone');
    $order->email = $request->input('email');
    $order->username = $request->input('username');
    $order->payment_method = $request->input('payment_method');
    $order->status = 'chờ xác nhận'; // Đặt trạng thái đã thanh toán


    // Lưu lại thông tin thanh toán
    $order->save();

    // Lưu thông tin các sản phẩm trong đơn hàng vào bảng trung gian order_product
    foreach ($order->products as $product) {
        $product->sold += $product->pivot->quantity; // Cập nhật số lượng đã bán
        $product->save();  // Lưu thay đổi vào cơ sở dữ liệu

        // Đảm bảo rằng thông tin đơn hàng và sản phẩm được lưu vào bảng trung gian
        $order->products()->updateExistingPivot($product->id, [
            'quantity' => $product->pivot->quantity,
            'price' => $product->pivot->price
        ]);
    }

    // Thêm thông báo thành công và quay lại trang chủ
    session()->flash('success', 'Thanh toán thành công!');

    // Quay lại trang chủ
    return redirect()->route('customer.home');
}

public function store(Request $request)
{
    // Validate dữ liệu
    $validated = $request->validate([
        'username' => 'required|string',
        'email' => 'required|email',
        'phone' => 'required|string',
        'address' => 'required|string',
        'payment_method' => 'required|string',
    ]);

    // Lấy các sản phẩm trong giỏ hàng
    $cartItems = json_decode($request->input('selected_products'), true); // Chuyển đổi JSON thành mảng
    $totalPrice = $request->input('total');

    // Kiểm tra nếu giỏ hàng trống
    if (empty($cartItems)) {
        return redirect()->back()->with('error', 'Giỏ hàng trống. Vui lòng chọn sản phẩm trước khi thanh toán.');
    }

    // Tạo đơn hàng
    $order = new Order();
    $order->user_id = auth()->user()->id;
    $order->total = $totalPrice;
    $order->status = 'chờ xác nhần';
    $order->username = $validated['username'];
    $order->email = $validated['email'];
    $order->phone = $validated['phone'];
    $order->address = $validated['address'];
    $order->payment_method = $validated['payment_method'];
    $order->save();

    // Lưu các sản phẩm trong giỏ hàng vào bảng order_product
    foreach ($cartItems as $productId => $quantity) {
        $product = Product::find($productId);
        if ($product) {
            $order->products()->attach($productId, [
                'quantity' => $quantity,
                'price' => $product->new_price,
            ]);
        } else {
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại.');
        }
    }

    // Xóa giỏ hàng sau khi đặt
    session()->forget('cart.index');

    // Quay lại trang chủ với thông báo thành công
    return redirect()->route('customer.home')->with('success', 'Đặt hàng thành công');
}

public function showOrderHistory()
{
    // Giả sử bạn có một hệ thống xác thực người dùng, bạn có thể lấy các đơn hàng của người dùng đang đăng nhập
    $userId = auth()->id(); // Lấy ID người dùng đang đăng nhập

    // Lấy tất cả đơn hàng của người dùng
    $orders = Order::where('user_id', $userId)->get();

    return view('order_history', compact('orders'));
}

public function history(Request $request)
    {
        $status = $request->get('status', 'all'); // Lấy trạng thái từ query string, mặc định là 'all'

        // Lọc đơn hàng dựa trên trạng thái
        if ($status === 'all') {
            $orders = Order::all(); // Hiển thị tất cả đơn hàng
        } else {
            $orders = Order::where('status', $status)->get();
        }

        return view('orders.history', compact('orders', 'status'));
    }

public function buyNow(Request $request)
{
    $productId = $request->input('product_id');
    $quantity = $request->input('quantity', 1); // Mặc định là 1 nếu không có quantity

    // Kiểm tra xem sản phẩm có tồn tại không
    $product = Product::find($productId);
    if (!$product) {
        return redirect()->route('customer.home')->with('error', 'Sản phẩm không tồn tại.');
    }

    // Tính tổng tiền cho sản phẩm đã chọn
    $total = $product->new_price * $quantity;

    // Tạo đơn hàng mới chỉ cho sản phẩm này
    $order = new Order();
    $order->user_id = Auth::id(); // Lấy ID người dùng hiện tại
    $order->total = $total;
    $order->product_id = $productId;
    $order->quantity = $quantity; // Thêm số lượng sản phẩm trong đơn hàng
    $order->status = 'pending'; // Trạng thái mặc định là chờ xử lý
    $order->save();

    // Cập nhật số lượng đã bán trong sản phẩm
    $product->sold += $quantity;  // Tăng số lượng đã bán theo số lượng trong đơn hàng
    $product->save();  // Lưu thay đổi vào cơ sở dữ liệu

    // Chuyển hướng đến trang thanh toán cho đơn hàng vừa tạo
    return redirect()->route('order.checkout', ['order' => $order->id]);
}





}

