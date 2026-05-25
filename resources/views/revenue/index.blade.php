@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between mb-4">
        <h4 class="fw-bold">Doanh thu</h4>

        <select id="filter" class="form-select w-auto">
            <option value="day">Theo ngày</option>
            <option value="week">Theo tuần</option>
        </select>
    </div>

    <!-- CARDS -->
    <div class="row mb-4">

        <div class="col-md-4">
            <div class="card p-3 shadow-sm">
                <small>Tổng doanh thu</small>
                <h4 class="text-success" id="totalRevenue">
                    {{ number_format($totalRevenue) }} đ
                </h4>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3 shadow-sm">
                <small>Hôm nay</small>
                <h4 class="text-primary" id="todayRevenue">
                    {{ number_format($todayRevenue) }} đ
                </h4>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3 shadow-sm">
                <small>Đơn hàng</small>
                <h4 id="totalOrders">{{ $totalOrders }}</h4>
            </div>
        </div>

    </div>

    <!-- CHART -->
    <div class="card p-3 shadow-sm mb-4">
        <h6 class="fw-bold">Biểu đồ doanh thu</h6>
        <canvas id="chart"></canvas>
    </div>

    <!-- TOP -->
    <div class="card p-3 shadow-sm">
        <h6 class="fw-bold">Top sản phẩm</h6>

        <table class="table">
            <thead>
                <tr>
                    <th>Tên</th>
                    <th>Số lượng</th>
                </tr>
            </thead>
            <tbody id="top-products">
                @foreach($topProducts as $item)
                <tr>
                    <td>{{ $item->product->name ?? '' }}</td>
                    <td>{{ $item->total_qty }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</div>

@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

let chart;

// ===== RENDER CHART =====
function renderChart(labels, data) {

    if (chart) chart.destroy();

    chart = new Chart(document.getElementById('chart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Doanh thu',
                data: data,
                borderWidth: 3,
                tension: 0.4,
                fill: true
            }]
        }
    });
}

// INIT
renderChart(@json($labels), @json($revenues));


// ===== FILTER =====
document.getElementById('filter').addEventListener('change', loadData);


// ===== LOAD DATA =====
function loadData() {

    let type = document.getElementById('filter').value;

    fetch('/revenue/data?type=' + type)
        .then(res => res.json())
        .then(data => {

            renderChart(data.labels, data.revenues);

            document.getElementById('totalRevenue').innerText =
                Number(data.totalRevenue).toLocaleString() + ' đ';

            document.getElementById('todayRevenue').innerText =
                Number(data.todayRevenue).toLocaleString() + ' đ';

            document.getElementById('totalOrders').innerText =
                data.totalOrders;
        });
}


// ===== REALTIME =====
setInterval(loadData, 5000);

</script>

@endsection