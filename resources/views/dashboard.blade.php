@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Dashboard</h4>

        <a href="{{ route('products.index') }}" class="btn btn-primary">
            Quản lý sản phẩm
        </a>
    </div>

    <!-- ===== THỐNG KÊ 5 CỘT ===== -->
    <div class="row g-3">

        <div class="col-md-2">
            <div class="card stat-card bg-primary text-white">
                <div class="card-body">
                    <small>Tổng sản phẩm</small>
                    <h4>{{ $totalProducts }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card stat-card bg-success text-white">
                <div class="card-body">
                    <small>Danh mục</small>
                    <h4>{{ $totalCategories }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card stat-card bg-warning text-dark">
                <div class="card-body">
                    <small>Tổng bàn</small>
                    <h4>{{ $totalTables }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card stat-card bg-danger text-white">
                <div class="card-body">
                    <small>Bàn đang dùng</small>
                    <h4>{{ $occupiedTables }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card stat-card bg-info text-white">
                <div class="card-body">
                    <small>Bàn trống</small>
                    <h4>{{ $emptyTables }}</h4>
                </div>
            </div>
        </div>

    </div>

    <!-- ===== BIỂU ĐỒ DANH MỤC (CÁI BẠN MUỐN) ===== -->
    <div class="card mt-5 shadow-sm">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Sản phẩm theo danh mục</h5>

            <canvas id="categoryChart" height="100"></canvas>
        </div>
    </div>

</div>

@endsection


@section('scripts')

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
new Chart(document.getElementById('categoryChart'), {
    type: 'bar',
    data: {
        labels: @json($labelsCategory),
        datasets: [{
            label: 'Số sản phẩm',
            data: @json($counts),
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

@endsection


<style>
.stat-card {
    border-radius: 12px;
    padding: 10px;
    transition: 0.2s;
}
.stat-card:hover {
    transform: translateY(-4px);
}
</style>