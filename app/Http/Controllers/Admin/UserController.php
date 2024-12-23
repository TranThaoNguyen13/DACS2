<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
{
    // Lấy giá trị tìm kiếm từ form
    $query = $request->get('query', '');

    // Kiểm tra nếu có giá trị tìm kiếm, thực hiện truy vấn tìm kiếm
    if ($query) {
        // Tìm kiếm người dùng theo tên hoặc email
        $users = User::where('username', 'like', '%' . $query . '%')
                     ->orWhere('email', 'like', '%' . $query . '%')
                     ->paginate(10); // Phân trang 10 người dùng mỗi trang
    } else {
        $users = User::paginate(10); // Nếu không có tìm kiếm, trả về tất cả người dùng
    }

    // Trả về view với các người dùng và tham số tìm kiếm
    return view('admin.users.index', compact('users', 'query'));
}


    public function create()
    {
        return view('admin.users.create');
    }
    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username', // Kiểm tra tính duy nhất của username
            'email' => 'required|email|unique:users,email', // Kiểm tra tính duy nhất của email
            'password' => 'required|string|min:8|confirmed', // Kiểm tra mật khẩu và xác nhận mật khẩu
            'role' => 'required|in:0,1', // Kiểm tra giá trị của role (0 cho user, 1 cho admin)
        ]);
    
        // Tạo mới người dùng
        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Mã hóa mật khẩu
            'role' => $request->role, // Lưu giá trị role (0 hoặc 1)
        ]);
    
        // Chuyển hướng và thông báo thành công
        return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được thêm thành công!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|string|in:admin,user',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Thông tin người dùng đã được cập nhật.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
$user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được xóa.');
    }
}