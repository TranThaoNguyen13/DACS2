@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Clinic & Spa</h1>
    <div class="row">
        @forelse ($clinicSpas as $clinicSpa)
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="{{ asset('images/' . $clinicSpa->image) }}" class="card-img-top" alt="{{ $clinicSpa->name }}">
                    <div class="card-body">
    <h5 class="card-title">{{ $clinicSpa->name }}</h5>
    <p class="card-text">{{ $clinicSpa->description }}</p>
    <p class="card-text"><strong>Thời lượng:</strong> {{ $clinicSpa->durationtype }}</p>
    <p class="card-text"><strong>Giá:</strong> {{ number_format($clinicSpa->price, 0, ',', '.') }} VNĐ</p>
</div>

                </div>
            </div>
        @empty
            <p>Không có mục nào trong Clinic & Spa.</p>
        @endforelse
    </div>
</div>
@endsection
