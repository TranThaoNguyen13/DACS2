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
        // Lấy giỏ hàng từ session
        $cartItems = session('cart', []);
        if (empty($cartItems)) {
            return redirect()->route('checkout')->with('error', 'Giỏ hàng của bạn đang trống!');
        }
    
        // Tính tổng số tiền cho đơn hàng
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['new_price'] * $item['quantity'];
        }
    
        // Sử dụng giao dịch để đảm bảo tính toàn vẹn của dữ liệu
        DB::transaction(function () use ($cartItems, $total) {
            // Tạo đơn hàng mới
            $order = new Order();
            $order->user_id = Auth::id();
            $order->total = $total;
            $order->status = 'Pending';
            $order->save();
    
            // Lưu các sản phẩm trong giỏ hàng vào bảng order_product
            foreach ($cartItems as $key => $item) {
                $product = Product::find($item['id']);
                if (!$product) {
                    throw new \Exception('Sản phẩm không tồn tại.');
                }
    
                // Gắn sản phẩm vào đơn hàng thông qua bảng trung gian
                $order->products()->attach($product->id, [
                    'quantity' => $item['quantity'],
                    'price' => $product->new_price, // Lưu giá tiền sản phẩm
                ]);
    
                // Cập nhật số lượng đã bán
                $product->sold += $item['quantity'];
                $product->save();
    
                // Cập nhật trạng thái sản phẩm trong giỏ hàng là "completed" nếu đã thanh toán
                $cartItems[$key]['status'] = 'completed';
            }
    
            // **Quan trọng: Lưu lại giỏ hàng vào session sau khi thanh toán thành công**
            // Cập nhật lại giỏ hàng trong session: chỉ giữ lại những sản phẩm chưa thanh toán
            $cartItems = array_filter($cartItems, function ($item) {
                return $item['status'] !== 'completed'; // Giữ lại sản phẩm chưa thanh toán
            });
    
            // Lưu giỏ hàng đã cập nhật vào session
            session(['cart' => $cartItems]);
    
            // Cập nhật trạng thái đơn hàng
            $order->status = 'Completed';
            $order->save();
        });
    
        return redirect()->route('orders.index')->with('success', 'Đơn hàng đã được tạo thành công!');
    }


    public function checkout(Order $order)
    {
        // Kiểm tra nếu người dùng chưa đăng nhập
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập trước khi thêm sản phẩm vào giỏ hàng.');
        }
        if ($order->status !== 'Chờ xác nhận') {
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
    if ($order->status == 'Chờ xác nhận') {
        $order->status = 'Đã huỷ'; // Đặt trạng thái là "Cancelled"
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
    $order->status = 'Chờ xác nhận'; // Đặt trạng thái đã thanh toán


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
        // Kiểm tra nếu người dùng chưa đăng nhập
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập trước khi mua hàng.');
        }
        // Kiểm tra nếu người dùng chưa đăng nhập
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập trước khi đặt hàng.');
        }

        // Debug toàn bộ dữ liệu từ form
        \Log::info('Request Data (raw):', $request->all());

        // Validate dữ liệu
        $validated = $request->validate([
            'username' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        // Debug dữ liệu sau khi validate
        \Log::info('Validated Data:', $validated);

        // Lấy các sản phẩm trong giỏ hàng từ session
        $cartItems = session('cart', []);

        // Debug giỏ hàng
        \Log::info('Cart Items:', $cartItems);

        if (empty($cartItems)) {
            return redirect()->back()->with('error', 'Giỏ hàng trống. Vui lòng chọn sản phẩm trước khi thanh toán.');
        }

        // Tính tổng tiền
        $totalPrice = array_reduce($cartItems, function ($carry, $item) {
            return $carry + ($item['new_price'] * $item['quantity']);
        }, 0);

        \Log::info('Total Price:', ['total' => $totalPrice]);

        // Tạo đơn hàng
        $order = Order::create([
            'user_id' => auth()->id(),
            'total' => $totalPrice,
            'status' => 'Chờ xác nhận',
            'username' => $validated['username'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'payment_method' => $validated['payment_method'],
        ]);

        \Log::info('Order Created:', $order->toArray());

        foreach ($cartItems as $productId => $item) {
            $product = Product::find($productId);
            if (!$product) {
                \Log::error('Product Not Found:', ['product_id' => $productId]);
                return redirect()->back()->with('error', 'Sản phẩm không tồn tại.');
            }

            $order->products()->attach($productId, [
                'quantity' => $item['quantity'],
                'price' => $product->new_price,
            ]);
        }

        // Xóa giỏ hàng
        session()->forget('cart');

        return redirect()->route('customer.home')->with('success', 'Đặt hàng thành công!');
    }
public function showOrderHistory(Request $request)
{
    // Lấy ID người dùng đang đăng nhập
    $userId = auth()->id(); 

    // Lấy trạng thái đơn hàng từ query string (?status=Đã xác nhận)
    $status = $request->input('status');

    // Lọc đơn hàng theo user_id và trạng thái (nếu có)
    $query = Order::where('user_id', $userId);

    if ($status) {
        $query->where('status', $status);
    }

    // Lấy danh sách đơn hàng
    $orders = $query->get();

    // Trả về view và truyền dữ liệu
    return view('order_history', compact('orders', 'status'));
}



public function buyNow(Request $request)
{
    // Kiểm tra nếu người dùng chưa đăng nhập
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Vui lòng đăng nhập trước khi thêm sản phẩm vào giỏ hàng.');
    }
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
    $order->status = 'Chờ xác nhận'; // Trạng thái mặc định là chờ xử lý
    $order->save();

    // Cập nhật số lượng đã bán trong sản phẩm
    $product->sold += $quantity;  // Tăng số lượng đã bán theo số lượng trong đơn hàng
    $product->save();  // Lưu thay đổi vào cơ sở dữ liệu

    // Chuyển hướng đến trang thanh toán cho đơn hàng vừa tạo
    return redirect()->route('order.checkout', ['order' => $order->id]);
}


public function return($id)
{
    // Tìm đơn hàng theo ID
    $order = Order::findOrFail($id);
    
    // Kiểm tra trạng thái đơn hàng là 'Đã nhận'
    if ($order->status == 'Đã nhận') {
        // Cập nhật trạng thái đơn hàng
        $order->status = 'Trả đơn/Hoàn hàng'; // Hoặc trạng thái bạn muốn
        $order->save();

        // Trả về trang lịch sử đơn hàng với thông báo thành công
        return redirect()->route('order.history')->with('success', 'Đơn hàng đã được trả/hoàn');
    }

    // Nếu trạng thái không phải 'Đã nhận', trả về thông báo lỗi
    return redirect()->route('order.history')->with('error', 'Không thể trả/hoàn đơn hàng này');
}





}

