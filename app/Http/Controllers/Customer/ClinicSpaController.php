<?php

namespace App\Http\Controllers\Customer;

use App\Models\ClinicSpa;
use Illuminate\Http\Request;

class ClinicSpaController extends Controller
{
    public function index()
    {
        $clinicSpas = ClinicSpa::all(); // Lấy tất cả các dịch vụ ClinicSpa
        return view('customer.home', compact('clinicSpas')); // Truyền biến $clinicSpas tới view customer.home
    }
    public function showClinicSpas()
{
    // Fetch the clinic spas data from your database or any other source
    $clinicSpas = ClinicSpa::all(); // Example query to get data

    // Pass $clinicSpas to the view
    return view('customer.home', compact('clinicSpas'));
}
public function show($id)
{
    $clinicSpa = ClinicSpa::findOrFail($id); // Lấy thông tin của Clinic & Spa
    return view('clinicSpa.show', compact('clinicSpa'));
}

}
