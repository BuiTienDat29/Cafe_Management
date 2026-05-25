@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3>Hóa đơn</h3>

    @if(!$order)
        <div class="alert alert-warning">Không có đơn</div>
    @else

        <p><strong>Bàn:</strong> {{ $order->table_id }}</p>
        <p><strong>Trạng thái:</strong> {{ $order->status }}</p>

        <table class="table">
            <thead>
                <tr>
                    <th>Món</th>
                    <th>SL</th>
                    <th>Giá</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price) }}đ</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <h4>Tổng: {{ number_format($order->total_price) }}đ</h4>

        {{-- 🔥 NÚT THANH TOÁN XONG --}}
        @if($order->status == 'pending')
        <form method="POST" action="/orders/complete/{{ $order->id }}">
            @csrf
            <button class="btn btn-success">
                Thanh toán xong
            </button>
        </form>
        @endif

    @endif

</div>
@endsection