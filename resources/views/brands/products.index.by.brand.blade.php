@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1>Sản phẩm của thương hiệu: {{ $brand->name }}</h1>

        @if($products->isEmpty())
            <p>Không có sản phẩm nào của thương hiệu này.</p>
        @else
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-md-3">
                        <div class="card">
                            <img src="{{ asset('images/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ $product->description }}</p>
                                <a href="{{ route('product.show', ['id' => $product->id]) }}" class="btn btn-primary">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
