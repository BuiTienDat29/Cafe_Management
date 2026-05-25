@extends('layouts.app')

@section('content')
<div class="container-fluid mt-3">

<div class="row">

    {{-- ===== LEFT (MENU) ===== --}}
    <div class="col-md-8">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold">Menu</h4>
        </div>

        {{-- ===== DANH MỤC ===== --}}
        <div class="mb-3 d-flex gap-2 flex-wrap">

            <a href="{{ route('orders.create') }}"
               class="btn {{ !request('category_id') ? 'btn-dark' : 'btn-outline-dark' }}">
               Tất cả
            </a>

            @foreach($categories as $cate)
                <a href="?category_id={{ $cate->id }}"
                   class="btn {{ request('category_id') == $cate->id ? 'btn-dark' : 'btn-outline-dark' }}">
                    {{ $cate->name }}
                </a>
            @endforeach

        </div>

        {{-- ===== CHỌN BÀN ===== --}}
        <div class="mb-3">
            <label class="fw-bold mb-2">Chọn bàn</label>

            <div class="d-flex flex-wrap gap-2">
                @foreach($tables as $table)

                    @if($table->status == 'occupied')
                        <a href="/orders/table/{{ $table->id }}" class="btn btn-danger">
                            Bàn {{ $table->id }}
                        </a>
                    @else
                        <button type="button"
                                class="btn btn-success table-btn"
                                data-id="{{ $table->id }}">
                            Bàn {{ $table->id }}
                        </button>
                    @endif

                @endforeach
            </div>
        </div>

        {{-- ===== PRODUCTS ===== --}}
        <div class="row">

            @foreach($products as $product)

            <div class="col-md-3 mb-3">
                <div class="card product-card add-to-cart"
                     data-id="{{ $product->id }}"
                     data-name="{{ $product->name }}"
                     data-price="{{ $product->price }}">

                    <img src="{{ asset($product->image) }}"
                         class="card-img-top"
                         style="height:140px; object-fit:cover;">

                    <div class="card-body text-center p-2">
                        <h6 class="mb-1">{{ $product->name }}</h6>
                        <small class="text-success fw-bold">
                            {{ number_format($product->price) }} đ
                        </small>
                    </div>

                </div>
            </div>

            @endforeach

        </div>

        {{-- ===== PAGINATION ===== --}}
        <div class="d-flex justify-content-center">
            {{ $products->withQueryString()->links() }}
        </div>

    </div>

    {{-- ===== RIGHT (CART) ===== --}}
    <div class="col-md-4">

        <div class="card p-3 shadow-sm">

            <h5 class="fw-bold">Giỏ hàng</h5>

            <p>Bàn: <strong id="selected-table">Chưa chọn</strong></p>

            <div id="cart-items"></div>

            <hr>

            <h5>Tổng: <span id="total-price">0đ</span></h5>

            <form method="POST" action="/orders" id="order-form">
                @csrf
                <input type="hidden" name="table_id" id="table_id_input">
                <div id="hidden-inputs"></div>

                <button class="btn btn-success w-100 mt-3">
                    Đặt hàng
                </button>
            </form>

        </div>

    </div>

</div>

</div>
@endsection


@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {

    let cart = {};
    let selectedTable = null;

    // ===== CHỌN BÀN =====
    document.querySelectorAll('.table-btn').forEach(btn => {
        btn.onclick = function() {

            document.querySelectorAll('.table-btn').forEach(b => {
                b.classList.remove('btn-dark');
                b.classList.add('btn-success');
            });

            this.classList.remove('btn-success');
            this.classList.add('btn-dark');

            selectedTable = this.dataset.id;

            document.getElementById('table_id_input').value = selectedTable;
            document.getElementById('selected-table').innerText = "Bàn " + selectedTable;
        };
    });

    // ===== ADD TO CART =====
    document.querySelectorAll('.add-to-cart').forEach(card => {
        card.onclick = function() {

            let id = this.dataset.id;

            if (!cart[id]) {
                cart[id] = {
                    name: this.dataset.name,
                    price: parseFloat(this.dataset.price),
                    quantity: 1
                };
            } else {
                cart[id].quantity++;
            }

            renderCart();
        };
    });

    // ===== RENDER CART =====
    function renderCart() {
        let html = '';
        let total = 0;
        let hidden = '';

        for (let id in cart) {
            let item = cart[id];

            total += item.price * item.quantity;

            html += `
                <div class="d-flex justify-content-between align-items-center mb-2 border-bottom pb-2">

                    <div>
                        <strong>${item.name}</strong><br>
                        <small>${item.price.toLocaleString()} đ</small>
                    </div>

                    <div class="d-flex align-items-center gap-2">

                        <button class="btn btn-sm btn-outline-secondary minus-btn" data-id="${id}">-</button>

                        <span>${item.quantity}</span>

                        <button class="btn btn-sm btn-outline-secondary plus-btn" data-id="${id}">+</button>

                        <button class="btn btn-sm btn-danger remove-btn" data-id="${id}">x</button>

                    </div>
                </div>
            `;

            hidden += `<input type="hidden" name="products[${id}]" value="${item.quantity}">`;
        }

        document.getElementById('cart-items').innerHTML = html;
        document.getElementById('total-price').innerText = total.toLocaleString() + "đ";
        document.getElementById('hidden-inputs').innerHTML = hidden;

        attachEvents();
    }

    // ===== EVENTS + - X =====
    function attachEvents() {

        document.querySelectorAll('.plus-btn').forEach(btn => {
            btn.onclick = function() {
                let id = this.dataset.id;
                cart[id].quantity++;
                renderCart();
            };
        });

        document.querySelectorAll('.minus-btn').forEach(btn => {
            btn.onclick = function() {
                let id = this.dataset.id;

                if (cart[id].quantity > 1) {
                    cart[id].quantity--;
                } else {
                    delete cart[id];
                }

                renderCart();
            };
        });

        document.querySelectorAll('.remove-btn').forEach(btn => {
            btn.onclick = function() {
                let id = this.dataset.id;
                delete cart[id];
                renderCart();
            };
        });

    }

    // ===== VALIDATE =====
    document.getElementById('order-form').addEventListener('submit', function(e){

        if (!selectedTable) {
            e.preventDefault();
            alert("Chưa chọn bàn!");
        }

        if (Object.keys(cart).length === 0) {
            e.preventDefault();
            alert("Giỏ hàng trống!");
        }

    });

});
</script>

<style>
.product-card {
    border-radius: 12px;
    cursor: pointer;
    transition: 0.2s;
}

.product-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.15);
}
</style>

@endsection