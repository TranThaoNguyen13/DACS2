<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 25px;
            font-size: 24px;
        }
        .alert {
            color: #e74c3c;
            background: #fdecea;
            border: 1px solid #e74c3c;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input[type="text"],
        input[type="password"] {
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            width: 100%;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }
        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
        }
        button {
            background: #3498db;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background: #2980b9;
        }
        .additional-links {
            margin-top: 15px;
            text-align: center;
            font-size: 14px;
        }
        .additional-links a {
            color: #3498db;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .additional-links a:hover {
            color: #2980b9;
            text-decoration: underline;
        }
        .invalid-feedback {
            color: #e74c3c;
            font-size: 13px;
            margin-top: -10px;
            margin-bottom: 10px;
        }
        .btn-block {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow-lg">
                        <div class="card-header bg-gradient-primary text-white text-center">
                            <h1 class="mb-0">{{ __('Đặt lại mật khẩu') }}</h1>
                        </div>

                        <div class="card-body p-4">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf

                                <div class="mb-3">
                                    <input id="username" type="text" 
                                        class="form-control @error('username') is-invalid @enderror" 
                                        name="username" value="{{ old('username') }}" 
                                        required autocomplete="username" autofocus
                                        placeholder="Tên đăng nhập">
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <input id="password" type="password" 
                                        class="form-control @error('password') is-invalid @enderror" 
                                        name="password" required autocomplete="new-password" placeholder="Mật khẩu mới">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <input id="password-confirm" type="password" 
                                        class="form-control" name="password_confirmation" 
                                        required autocomplete="new-password" placeholder="Nhập lại mật khẩu">
                                </div>

                                <div class="d-flex flex-column align-items-center">
                                    <button type="submit" class="btn btn-primary btn-block btn-lg mb-3">
                                        {{ __('Đặt lại mật khẩu') }}
                                    </button>
                                    <div class="additional-links">
                                    <a href="{{ route('login') }}" class="text-decoration-underline text-muted">
                                        {{ __('Quay lại đăng nhập') }}
                                    </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
