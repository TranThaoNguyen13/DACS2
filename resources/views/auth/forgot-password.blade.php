@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header bg-gradient-primary text-white text-center">
                    <h3 class="mb-0">{{ __('Đặt lại mật khẩu') }}</h3>
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
                            <label for="username" class="form-label">{{ __('Tên đăng nhập') }}</label>
                            <input id="username" type="text" 
                                class="form-control @error('username') is-invalid @enderror" 
                                name="username" value="{{ old('username') }}" 
                                required autocomplete="username" autofocus>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Mật khẩu mới') }}</label>
                            <input id="password" type="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                name="password" required autocomplete="new-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password-confirm" class="form-label">{{ __('Xác nhận mật khẩu') }}</label>
                            <input id="password-confirm" type="password" 
                                class="form-control" name="password_confirmation" 
                                required autocomplete="new-password">
                        </div>

                        <div class="d-flex flex-column align-items-center">
<button type="submit" class="btn btn-primary btn-block btn-lg mb-3">
                                {{ __('Đặt lại mật khẩu') }}
                            </button>
                            <a href="{{ route('login') }}" class="text-decoration-underline text-muted">
                                {{ __('Quay lại đăng nhập') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection