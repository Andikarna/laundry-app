@extends('layouts')

@section('title', 'Dashboard')

@section('content')
    <style>
        .badge {
            transition: all 0.25s ease-in-out;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }

        .badge:hover {
            transform: scale(1.05);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.12);
        }

        .bg-warning {
            background-color: #facc15 !important;
        }

        .bg-info {
            background-color: #3b82f6 !important;
        }

        .bg-danger {
            background-color: #ef4444 !important;
        }
        
    </style>


    <div class="container-fluid">
        <!-- Cards Summary -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card p-3 shadow-sm">
                    <h6 class="text-secondary">Total Pesanan</h6>
                    <p class="h4 text-primary">{{ $totalOrders }}</p>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card p-3 shadow-sm">
                    <h6 class="text-secondary">Pesanan Selesai</h6>
                    <p class="h4 text-primary">{{ $completedOrders }}</p>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card p-3 shadow-sm">
                    <h6 class="text-secondary">Pesanan Pending</h6>
                    <p class="h4 text-primary">{{ $pendingOrders }}</p>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card p-3 shadow-sm">
                    <h6 class="text-secondary">Pelanggan Baru</h6>
                    <p class="h4 text-primary">{{ $newCustomers }}</p>
                </div>
            </div>
        </div>

        <!-- Recent Orders Table -->
        <div class="row">
            <div class="col-12">
                <div class="card p-3 shadow-sm">
                    <h5 class="mb-3 text-primary">Pesanan Terbaru</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Layanan</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentOrders as $index => $order)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $order->user->name ?? '-' }}</td>
                                        <td>{{ $order->service->name ?? '-' }}</td>
                                        <td>
                                            @php
                                                $statusClass = match (strtolower($order->status)) {
                                                    'selesai' => 'bg-success text-white',
                                                    'proses' => 'bg-warning text-dark',
                                                    'pending' => 'bg-danger text-white',
                                                    'aktif' => 'bg-info text-white',
                                                    'menunggu' => 'bg-secondary text-white',
                                                    default => 'bg-light text-dark',
                                                };
                                            @endphp
                                            <span class="badge {{ $statusClass }}"
                                                style="padding:8px 12px; border-radius:10px; font-size:13px; font-weight:500;">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-3">Belum ada pesanan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Tambahkan jika ada script tambahan -->
@endsection
