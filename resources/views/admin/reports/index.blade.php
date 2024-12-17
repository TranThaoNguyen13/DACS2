<!-- resources/views/admin/reports/index.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Báo Cáo Doanh Thu Theo Danh Mục</h1>

    <!-- Hiển thị tổng doanh thu -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Tổng Doanh Thu</h5>
            <p class="card-text">
                Tổng doanh thu: <strong>{{ number_format($totalRevenue, 0, ',', '.') }} VNĐ</strong>
            </p>
        </div>
    </div>

    <!-- Biểu đồ doanh thu -->
    <canvas id="salesChart"></canvas>

    <script>
        var ctx = document.getElementById('salesChart').getContext('2d');
        var salesChart = new Chart(ctx, {
            type: 'bar', // Hoặc bạn có thể chọn các loại biểu đồ khác như line, pie, ...
            data: {
                labels: @json(array_column($salesData, 'category')),
                datasets: [{
                    label: 'Tổng doanh thu',
                    data: @json(array_column($salesData, 'total_sales')),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
