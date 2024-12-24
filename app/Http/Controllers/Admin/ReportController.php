<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request; 

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Lấy tổng doanh thu
        $totalRevenue = Order::sum('total');

        // Lấy doanh thu theo ngày, tuần, tháng, năm
        $salesData = [];

        // Doanh thu theo ngày
        $salesData['daily'] = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as total_sales'))
                                    ->groupBy(DB::raw('DATE(created_at)'))
                                    ->orderBy('date', 'desc')
                                    ->limit(7)  // Lấy 7 ngày gần nhất
                                    ->get();

        // Doanh thu theo tuần
        $salesData['weekly'] = Order::select(DB::raw('WEEK(created_at) as week'), DB::raw('SUM(total) as total_sales'))
                                     ->groupBy(DB::raw('WEEK(created_at)'))
                                     ->orderBy('week', 'desc')
                                     ->limit(4)  // Lấy 4 tuần gần nhất
                                     ->get();

        // Doanh thu theo tháng
        $salesData['monthly'] = Order::select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total) as total_sales'))
                                      ->groupBy(DB::raw('MONTH(created_at)'))
                                      ->orderBy('month', 'desc')
                                      ->limit(12)  // Lấy 12 tháng gần nhất
                                      ->get();

        // Doanh thu theo năm
        $salesData['yearly'] = Order::select(DB::raw('YEAR(created_at) as year'), DB::raw('SUM(total) as total_sales'))
                                     ->groupBy(DB::raw('YEAR(created_at)'))
                                     ->orderBy('year', 'desc')
                                     ->limit(5)  // Lấy 5 năm gần nhất
                                     ->get();

        return view('admin.reports.index', compact('totalRevenue', 'salesData'));
    }
}
