<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NhanVien;

class NhanVienController extends Controller
{
    public function index()
    {
        $nhanviens = NhanVien::all(); // Lấy tất cả nhân viên từ CSDL
        return view('admin.nhanvien.index', compact('nhanviens'));
    }
    public function show($id)
{
    $nhanvien = NhanVien::findOrFail($id);
    return view('admin.nhanvien.show', compact('nhanvien'));
}

    public function create()
    {
        return view('admin.nhanvien.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'birthday' => 'required|date',
            'phone' => 'required',
            'email' => 'required|email|unique:nhanviens',
            'address' => 'required',
            'function' => 'required',
           
            'wage' => 'required|numeric',
        ]);

        NhanVien::create($request->all());

        return redirect()->route('admin.nhanvien.index')->with('success', 'Nhân viên được thêm thành công.');
    }

    public function edit($id)
    {
        $nhanvien = NhanVien::findOrFail($id);
        return view('admin.nhanvien.edit', compact('nhanvien'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'birthday' => 'required|date',
            'phone' => 'required',
            'email' => 'required|email|unique:nhanviens,email,' . $id,
            'address' => 'required',
            'function' => 'required',
        
            'wage' => 'required|numeric',
        ]);

        $nhanvien = NhanVien::findOrFail($id);
        $nhanvien->update($request->all());

        return redirect()->route('admin.nhanvien.index')->with('success', 'Cập nhật nhân viên thành công.');
    }

    public function destroy($id)
    {
        NhanVien::findOrFail($id)->delete();
        return redirect()->route('admin.nhanvien.index')->with('success', 'Xóa nhân viên thành công.');
    }
}
