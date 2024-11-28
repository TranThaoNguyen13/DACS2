{/* <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    $(document).ready(function() {
        // Xử lý nút tăng/giảm số lượng
        $('.increment').on('click', function() {
            let quantityInput = $(this).siblings('.quantity');
            let currentQuantity = parseInt(quantityInput.val());
            quantityInput.val(currentQuantity + 1);
        });

        $('.decrement').on('click', function() {
            let quantityInput = $(this).siblings('.quantity');
            let currentQuantity = parseInt(quantityInput.val());
            if (currentQuantity > 1) {
                quantityInput.val(currentQuantity - 1);
            }
        });

        // Xử lý khi thêm vào giỏ hàng
        $('.add-to-cart').on('click', function() {
            let productId = $(this).data('id');
            let quantity = $(this).siblings('.quantity-control').find('.quantity').val();

            $.ajax({
                url: "{{ route('add.to.cart') }}",
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId,
                    quantity: quantity
                },
                success: function(response) {
                    alert(response.success); // Hiển thị thông báo khi thêm vào giỏ hàng thành công
                    updateCartCount(); // Cập nhật số lượng sản phẩm trong giỏ hàng
                },
                error: function(xhr) {
                    alert(xhr.responseJSON.error || 'Có lỗi xảy ra!'); // Hiển thị lỗi nếu có
                }
            });
        });

        function updateCartCount() {
            // Giả sử bạn có một phần tử hiển thị số lượng sản phẩm trong giỏ hàng
            let cartCount = 0;
            // Lấy giỏ hàng từ session (nếu bạn có endpoint để lấy giỏ hàng)
            $.ajax({
                url: "{{ route('cart.index') }}",
                method: "GET",
                success: function(cart) {
                    // Tính tổng số lượng sản phẩm trong giỏ hàng
                    for (let item of cart) {
                        cartCount += item.quantity;
                    }
                    // Cập nhật hiển thị
                    $('#cart-count').text(cartCount);
                }
            });
        }
    });
    */}