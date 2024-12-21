@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="clinic-spa-detail">
        <h1>{{ $clinicSpa->name }}</h1>
        <img src="{{ asset('images/' . $clinicSpa->image) }}" class="img-fluid" alt="{{ $clinicSpa->name }}">
        <p>{{ $clinicSpa->description }}</p>
        <!-- Thêm các thông tin chi tiết khác nếu cần -->
    </div>
</div>
@endsection
