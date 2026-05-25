@extends('layouts.app')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-6">

        <div class="card shadow p-4">
            <h3 class="mb-4 text-center">➕ Thêm sản phẩm</h3>

            <div id="success-message" class="alert alert-success d-none"></div>

            <form id="product-form" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label>Tên sản phẩm</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Giá</label>
                    <input type="number" name="price" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Ảnh</label>
                    <input type="file" name="image" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Danh mục</label>
                    <select name="category_id" class="form-control" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button class="btn btn-primary w-100">Lưu sản phẩm</button>
            </form>
        </div>

    </div>
</div>
@endsection
@section('scripts')
<script>
document.getElementById('product-form').addEventListener('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch("{{ route('products.store') }}", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('success-message').classList.remove('d-none');
        document.getElementById('success-message').innerText = "✅ Thêm thành công!";

        document.getElementById('product-form').reset();
    })
    .catch(err => console.log(err));
});
</script>
@endsection