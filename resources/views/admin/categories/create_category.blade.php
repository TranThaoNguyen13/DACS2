<!-- resources/views/admin/create_category.blade.php -->
<h2>Thêm danh mục mới</h2>

@if($errors->any())
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ route('admin.categories.store') }}" method="POST">
    @csrf
    <div>
        <label for="name">Tên danh mục</label>
        <input type="text" name="name" id="name" required>
    </div>
    <div>
        <label for="imade" >Hình ảnh</label>
        <textarea name="image" id="image"></textarea>
    </div>
    <button type="submit">Thêm danh mục</button>
</form>


