<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NhanVien;

class NhanVienController extends Controller
{
    public function index()
    {
        $nhanvien = NhanVien::all(); // Lấy tất cả nhân viên từ CSDL
        return view('admin.nhanvien.index', compact('nhanvien'));
    }

    public function create()
    {
        return view('admin.nhanvien.create');
    }

    public function store(Request $request)
    {
        // Xác thực dữ liệu nhập vào
        $request->validate([
            'name' => 'required|string|max:255',
            'birthday' => 'required|date',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|unique:nhanvien,email',
            'address' => 'required|string|max:255',
            'function' => 'required|string|max:255',
            'wage' => 'required|numeric|min:0',
        ], [
            'email.unique' => 'Email bị trùng, vui lòng nhập lại.' // Thông báo tùy chỉnh khi email trùng
    
        ]);

        try {
            // Thêm nhân viên mới vào cơ sở dữ liệu
            NhanVien::create([
                'name' => $request->name,
                'birthday' => $request->birthday,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'function' => $request->function,
                'wage' => $request->wage,
            ]);

            // Quay lại trang danh sách nhân viên với thông báo thành công
            return redirect()->route('admin.nhanvien.index')->with('success', 'Nhân viên được thêm thành công.');

        } catch (\Exception $e) {
            // Xử lý lỗi
            return back()->withErrors(['error' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
        }
    }

    public function show($id)
{
    $nhanvien = NhanVien::findOrFail($id);
    return view('admin.nhanvien.show', compact('nhanvien'));
}


    public function edit($id)
    {
        $nhanvien = NhanVien::findOrFail($id);
        return view('admin.nhanvien.edit', compact('nhanvien'));
    }

    public function update(Request $request, $id)
{
    // Xác thực dữ liệu nhập vào
    $request->validate([
        'name' => 'required|string|max:255',
        'birthday' => 'required|date',
        'phone' => 'required|string|max:15',
        'email' => 'required|email|unique:nhanvien,email,' . $id, // Đảm bảo email duy nhất trừ nhân viên hiện tại
        'address' => 'required|string|max:255',
        'function' => 'required|string|max:255',
        'wage' => 'required|numeric|min:0',
    ]);

    // Tìm nhân viên theo ID và cập nhật
    $nhanvien = NhanVien::findOrFail($id);
    $nhanvien->update([
        'name' => $request->name,
        'birthday' => $request->birthday,
        'phone' => $request->phone,
        'email' => $request->email,
        'address' => $request->address,
        'function' => $request->function,
        'wage' => $request->wage,
    ]);

    // Quay lại trang danh sách nhân viên với thông báo thành công
    return redirect()->route('admin.nhanvien.index')->with('success', 'Cập nhật nhân viên thành công.');
}

    public function destroy($id)
    {
        NhanVien::findOrFail($id)->delete();
        return redirect()->route('admin.nhanvien.index')->with('success', 'Xóa nhân viên thành công.');
    }
}