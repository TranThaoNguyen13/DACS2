@extends('layouts.admin')

@section('content')
    <h1>Kết quả tìm kiếm cho: "{{ $query }}"</h1>
    @if($results->isEmpty())
        <div class="alert alert-danger">Không tìm thấy kết quả nào phù hợp.</div>
    @else
        <div class="alert alert-success">Tìm thấy {{ $results->count() }} kết quả phù hợp.</div>
        <ul class="list-group">
            @foreach($results as $result)
                <li class="list-group-item">
                    <strong>{{ $result->name }}</strong> - Giá: {{ number_format($result->price, 0, ',', '.') }} VND
                </li>
            @endforeach
        </ul>
    @endif
@endsection
