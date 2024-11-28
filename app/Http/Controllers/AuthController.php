<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    $credentials = $request->only('username', 'password');
    
    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        
        // Kiểm tra nếu user là admin
        if ($user->role == 1) {
            return redirect()->route('admin.dashboard'); // Chuyển hướng tới trang quản trị
        } else {
            return redirect()->route('customer.home'); // Chuyển hướng tới trang khách hàng
        }
    }

    return redirect()->route('login')->withErrors([
        'login_failed' => 'Thông tin đăng nhập không đúng hoặc tài khoản không tồn tại. Vui lòng đăng ký tài khoản.',
    ]);
}


public function showChangePasswordForm()
{
    return view('change_password');
}

// Xử lý đổi mật khẩu
public function changePassword(Request $request)
{
    // Xác thực dữ liệu
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:8',
        'confirm_password' => 'required|same:new_password',
    ]);

    // Kiểm tra mật khẩu hiện tại
    if (!Hash::check($request->current_password, Auth::user()->password)) {
        return back()->with('error', 'Mật khẩu hiện tại không đúng.');
    }

    // Cập nhật mật khẩu mới
    $user = Auth::user();
    $user->password = Hash::make($request->new_password);
    $user->save();

    return back()->with('success', 'Đổi mật khẩu thành công!');
}
    
    public function adminDashboard()
    {
        return view('admin.dashboard');
    }

    public function customerHome()
    {
        return view('customer.home');
    }
    public function logout()
{
    Auth::logout();
    return redirect()->route('login');
}
public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->integer('role')->default(0); // Thêm cột role với giá trị mặc định là 0 (khách hàng)
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('role');
    });
}
public function register(Request $request)
{
    $request->validate([
        'username' => 'required|unique:users', // Kiểm tra username
        'email' => 'required|email|unique:users',
        'password' => 'required|confirmed|min:6',
    ]);

    $user = User::create([
        'username' => $request->input('username'), // Đảm bảo trường này được cung cấp
        'password' => bcrypt($request->input('password')),
        'email' => $request->input('email'),
        'role' => 0 // hoặc giá trị phù hợp
    ]);
    

    return redirect()->route('customer.home');
}
public function showRegisterForm()
{
    return view('auth.register');
}

}

  
        

  
 
    


