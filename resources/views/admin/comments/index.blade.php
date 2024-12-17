@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Quản Lý Bình Luận</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Người Dùng</th>
                <th>Sản Phẩm</th>
                <th>Nội Dung</th>
                <th>Trả Lời</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($comments as $comment)
            <tr>
                <td>{{ $comment->id }}</td>
                <td>{{ $comment->user->username }}</td>
                <td>{{ $comment->product->name }}</td>
                <td>{{ $comment->content }}</td>
                <td>
                    <form action="{{ route('admin.comments.update', $comment->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <textarea name="reply" class="form-control" rows="2" placeholder="Trả lời bình luận...">{{ $comment->reply }}</textarea>
                        <button type="submit" class="btn btn-success btn-sm mt-2">Trả Lời</button>
                    </form>
                </td>
                <td>
                <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
</form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $comments->links() }} <!-- Phân trang -->
</div>
@endsection
