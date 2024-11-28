<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkoutSelected(Request $request)
    {
        $selectedProducts = $request->input('selected_products');
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

        return view('checkout', compact('cartItems', 'total'));
    }

    public function checkout()
    {
        $cartItems = session()->get('cart', []);
        return view('checkout', compact('cartItems'));
    }
}
