<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Models\Category;
use App\Models\Product;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    $credentials = $request->validate([
        'username' => 'required',
        'password' => 'required',
    ], [
        'username.required' => 'Vui lòng nhập tên đăng nhập',
        'password.required' => 'Vui lòng nhập mật khẩu',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        // Kiểm tra role và chuyển hướng
        $user = Auth::user(); // Lấy thông tin người dùng đã đăng nhập

        if ($user->role === 1) { // Kiểm tra nếu là admin
            return redirect()->intended('admin/dashboard');
        }

        // Nếu không phải admin, chuyển hướng về trang khách hàng
        return redirect()->route('customer.home');
    }

    return back()->withErrors([
        'username' => 'Tên đăng nhập hoặc mật khẩu không chính xác.',
    ])->withInput($request->only('username'));
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

public function showForgotPasswordForm()
{
    return view('auth.forgot-password');
}

public function sendResetLink(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users',
    ], [
        'email.required' => 'Vui lòng nhập email',
        'email.email' => 'Email không hợp lệ',
        'email.exists' => 'Email không tồn tại trong hệ thống'
    ]);

    // Chuyển thẳng đến trang reset password
    return redirect()->route('password.reset')
        ->with('email', $request->email)
        ->with('info', 'Vui lòng nhập mật khẩu mới của bạn.');
}

public function showResetPasswordForm()
{
    return view('auth.reset-password');
}

public function resetPassword(Request $request)
{
    $request->validate([
        'username' => 'required|exists:users,username',
        'password' => 'required|min:6|confirmed',
    ], [
        'username.required' => 'Vui lòng nhập tên đăng nhập',
        'username.exists' => 'Tên đăng nhập không tồn tại trong hệ thống',
        'password.required' => 'Vui lòng nhập mật khẩu mới',
        'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
        'password.confirmed' => 'Xác nhận mật khẩu không khớp'
    ]);

    // Cập nhật mật khẩu mới
    $user = User::where('username', $request->username)->first();
    $user->password = Hash::make($request->password);
    $user->save();

    // Redirect về route home
    return redirect()->route('customer.home')
        ->with('success', 'Mật khẩu đã được cập nhật thành công!');
}

}