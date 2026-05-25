<h2>Sửa sản phẩm</h2>

<form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label>Tên</label>
    <input type="text" name="name" value="{{ $product->name }}">

    <label>Giá</label>
    <input type="number" name="price" value="{{ $product->price }}">

    <label>Ảnh</label>
    <input type="file" name="image">

    <br><br>
    <button type="submit">Cập nhật</button>
</form>