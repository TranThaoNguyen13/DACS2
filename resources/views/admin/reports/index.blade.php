@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Báo Cáo Doanh Thu</h1>

    <!-- Thanh điều hướng -->
    <nav class="nav">
        <a class="nav-link active" id="dailyTab" href="#">Doanh Thu Theo Ngày</a>
        <a class="nav-link" id="weeklyTab" href="#">Doanh Thu Theo Tuần</a>
        <a class="nav-link" id="monthlyTab" href="#">Doanh Thu Theo Tháng</a>
        <a class="nav-link" id="yearlyTab" href="#">Doanh Thu Theo Năm</a>
    </nav>

    <!-- Hiển thị tổng doanh thu -->
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Tổng Doanh Thu</h5>
            <p class="card-text">
                Tổng doanh thu: <strong>{{ number_format($totalRevenue, 0, ',', '.') }}.000 VNĐ</strong>
            </p>
        </div>
    </div>

    <!-- Biểu đồ doanh thu theo ngày -->
    <h3 id="dailyTitle" class="mt-4">Doanh Thu Theo Ngày</h3>
    <canvas id="dailyChart"></canvas>

    <!-- Biểu đồ doanh thu theo tuần -->
    <h3 id="weeklyTitle" class="mt-4" style="display: none;">Doanh Thu Theo Tuần</h3>
    <canvas id="weeklyChart" style="display: none;"></canvas>

    <!-- Biểu đồ doanh thu theo tháng -->
    <h3 id="monthlyTitle" class="mt-4" style="display: none;">Doanh Thu Theo Tháng</h3>
    <canvas id="monthlyChart" style="display: none;"></canvas>

    <!-- Biểu đồ doanh thu theo năm -->
    <h3 id="yearlyTitle" class="mt-4" style="display: none;">Doanh Thu Theo Năm</h3>
    <canvas id="yearlyChart" style="display: none;"></canvas>

    <script>
        // Biểu đồ doanh thu theo ngày
        var dailyCtx = document.getElementById('dailyChart').getContext('2d');
        var dailyChart = new Chart(dailyCtx, {
            type: 'line',
            data: {
                labels: @json($salesData['daily']->pluck('date')),
                datasets: [{
                    label: 'Tổng doanh thu',
                    data: @json($salesData['daily']->pluck('total_sales')),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Biểu đồ doanh thu theo tuần
        var weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
        var weeklyChart = new Chart(weeklyCtx, {
            type: 'bar',
            data: {
                labels: @json($salesData['weekly']->pluck('week')),
                datasets: [{
                    label: 'Tổng doanh thu',
                    data: @json($salesData['weekly']->pluck('total_sales')),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Biểu đồ doanh thu theo tháng
        var monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
        var monthlyChart = new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: @json($salesData['monthly']->pluck('month')),
                datasets: [{
                    label: 'Tổng doanh thu',
                    data: @json($salesData['monthly']->pluck('total_sales')),
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Biểu đồ doanh thu theo năm
        var yearlyCtx = document.getElementById('yearlyChart').getContext('2d');
        var yearlyChart = new Chart(yearlyCtx, {
            type: 'bar',
            data: {
                labels: @json($salesData['yearly']->pluck('year')),
                datasets: [{
                    label: 'Tổng doanh thu',
                    data: @json($salesData['yearly']->pluck('total_sales')),
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Xử lý sự kiện khi người dùng chọn tab
        document.getElementById('dailyTab').addEventListener('click', function() {
            showChart('daily');
        });
        document.getElementById('weeklyTab').addEventListener('click', function() {
            showChart('weekly');
        });
        document.getElementById('monthlyTab').addEventListener('click', function() {
            showChart('monthly');
        });
        document.getElementById('yearlyTab').addEventListener('click', function() {
            showChart('yearly');
        });

        function showChart(chartType) {
            // Ẩn tất cả biểu đồ
            document.getElementById('dailyChart').style.display = 'none';
            document.getElementById('weeklyChart').style.display = 'none';
            document.getElementById('monthlyChart').style.display = 'none';
            document.getElementById('yearlyChart').style.display = 'none';

            // Ẩn tất cả tiêu đề
            document.getElementById('dailyTitle').style.display = 'none';
            document.getElementById('weeklyTitle').style.display = 'none';
            document.getElementById('monthlyTitle').style.display = 'none';
            document.getElementById('yearlyTitle').style.display = 'none';

            // Hiển thị biểu đồ và tiêu đề tương ứng
            if (chartType === 'daily') {
                document.getElementById('dailyChart').style.display = 'block';
                document.getElementById('dailyTitle').style.display = 'block';
            } else if (chartType === 'weekly') {
                document.getElementById('weeklyChart').style.display = 'block';
                document.getElementById('weeklyTitle').style.display = 'block';
            } else if (chartType === 'monthly') {
                document.getElementById('monthlyChart').style.display = 'block';
                document.getElementById('monthlyTitle').style.display = 'block';
            } else if (chartType === 'yearly') {
                document.getElementById('yearlyChart').style.display = 'block';
                document.getElementById('yearlyTitle').style.display = 'block';
            }

            // Cập nhật active class cho các tab
            document.querySelectorAll('.nav-link').forEach(function(tab) {
                tab.classList.remove('active');
            });
            document.getElementById(chartType + 'Tab').classList.add('active');
        }

        // Mặc định hiển thị biểu đồ theo ngày
        showChart('daily');
    </script>
</div>
@endsection
