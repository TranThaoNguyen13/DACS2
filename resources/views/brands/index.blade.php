@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Danh sách thương hiệu</h1>
    <ul>
        @foreach($brands as $brand)
            <li>
                <a href="{{ route('products.index.by.brand', ['brand' => $brand->name]) }}">
                    {{ $brand->name }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
