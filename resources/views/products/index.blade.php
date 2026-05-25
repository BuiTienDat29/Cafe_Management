@extends('layouts.app')

@section('content')

<div class="card shadow-sm">
    <div class="card-body">

        <!-- HEADER -->
        <div class="d-flex justify-content-between mb-3 align-items-center">
            <h5 class="fw-bold">Danh sách sản phẩm</h5>

            <a href="{{ route('products.create') }}" class="btn btn-primary">
                + Thêm sản phẩm
            </a>
        </div>

        <!-- SEARCH + FILTER -->
        <form method="GET" class="row mb-3">

            <div class="col-md-4">
                <input type="text" name="search"
                       class="form-control"
                       placeholder="Tìm sản phẩm..."
                       value="{{ request('search') }}">
            </div>

            <div class="col-md-3">
                <select name="category_id" class="form-control">
                    <option value="">Tất cả danh mục</option>
                    @foreach($categories as $cate)
                        <option value="{{ $cate->id }}"
                            {{ request('category_id') == $cate->id ? 'selected' : '' }}>
                            {{ $cate->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary w-100">Lọc</button>
            </div>

        </form>

        <!-- TABLE -->
        <table class="table align-middle table-hover">

            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Ảnh</th>
                    <th>Tên</th>
                    <th>Giá</th>
                    <th>Danh mục</th>
                    <th class="text-end">Hành động</th>
                </tr>
            </thead>

            <tbody>
                @foreach($products as $product)
                <tr id="row-{{ $product->id }}">

                    <td>{{ $product->id }}</td>

                    <!-- ✅ IMAGE FIX -->
                    <td>
                        <img src="{{ asset($product->image) }}"
                             width="50"
                             height="50"
                             style="object-fit:cover; border-radius:8px"
                             onerror="this.src='https://picsum.photos/50'">
                    </td>

                    <td class="fw-semibold">{{ $product->name }}</td>

                    <td class="text-success">
                        {{ number_format($product->price) }} đ
                    </td>

                    <td>{{ $product->category->name ?? '' }}</td>

                    <td class="text-end">

                        <button class="btn btn-sm btn-warning btn-edit"
                            data-id="{{ $product->id }}"
                            data-name="{{ $product->name }}"
                            data-price="{{ $product->price }}"
                            data-image="{{ asset($product->image) }}">
                            Sửa
                        </button>

                        <button class="btn btn-sm btn-danger btn-delete"
                            data-id="{{ $product->id }}">
                            Xóa
                        </button>

                    </td>

                </tr>
                @endforeach
            </tbody>

        </table>

        <!-- PAGINATION -->
        <div class="mt-3">
            {{ $products->withQueryString()->links() }}
        </div>

    </div>
</div>

<!-- MODAL EDIT -->
<div class="modal fade" id="editModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5>Chỉnh sửa sản phẩm</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <input type="hidden" id="edit-id">

                <div class="text-center mb-3">
                    <img id="preview-image" width="80">
                </div>

                <input type="file" id="edit-image" class="form-control mb-2">

                <input type="text" id="edit-name" class="form-control mb-2" placeholder="Tên">

                <input type="number" id="edit-price" class="form-control" placeholder="Giá">

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button class="btn btn-primary" id="btn-update">Cập nhật</button>
            </div>

        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>

const editModal = new bootstrap.Modal(document.getElementById('editModal'));

// ===== EDIT =====
document.querySelectorAll('.btn-edit').forEach(btn => {
    btn.onclick = function() {

        document.getElementById('edit-id').value = this.dataset.id;
        document.getElementById('edit-name').value = this.dataset.name;
        document.getElementById('edit-price').value = this.dataset.price;
        document.getElementById('preview-image').src = this.dataset.image;

        editModal.show();
    };
});

// ===== UPDATE =====
document.getElementById('btn-update').onclick = function() {

    let id = document.getElementById('edit-id').value;

    let formData = new FormData();
    formData.append('name', document.getElementById('edit-name').value);
    formData.append('price', document.getElementById('edit-price').value);
    formData.append('_method', 'PUT');

    let img = document.getElementById('edit-image').files[0];
    if (img) formData.append('image', img);

    fetch('/products/' + id, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {

        let row = document.getElementById('row-' + id);

        row.children[2].innerText = data.name;
        row.children[3].innerText = Number(data.price).toLocaleString() + ' đ';

        if (data.image) {
            row.querySelector('img').src = data.image;
        }

        editModal.hide();
    });
};

// ===== DELETE =====
document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.onclick = function() {

        let id = this.dataset.id;

        if (!confirm('Xóa sản phẩm?')) return;

        fetch('/products/' + id, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(() => {
            document.getElementById('row-' + id).remove();
        });
    };
});

</script>
@endsection