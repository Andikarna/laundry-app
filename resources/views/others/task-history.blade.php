@extends('layouts')

@section('title', 'Riwayat Task Operator')

@section('content')
<div class="container py-4">

    <h3 class="mb-4 text-primary fw-bold"><i class="bi bi-clock-history"></i> Riwayat Task</h3>

    @if ($tasks->count() > 0)
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-hover table-striped align-middle mb-0" style="background-color:#1e1e2f; color:#f1f1f1;">
                <thead style="background-color:#2c2c3e; color:#ffffff;">
                    <tr>
                        <th>No</th>
                        <th>Customer</th>
                        <th>Layanan</th>
                        <th>Berat</th>
                        <th>Status</th>
                        <th>Diupdate</th>
                        <th>Estimasi Selesai</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $index => $task)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $task->user->name ?? '-' }}</td>
                            <td>{{ $task->service->name ?? '-' }}</td>
                            <td>{{ $task->weight ?? '-' }} Kg</td>
                            <td>
                                @php
                                    $statusClass = match (strtolower($task->status)) {
                                        'selesai' => 'bg-success text-white',
                                        'proses' => 'bg-warning text-dark',
                                        'pending' => 'bg-danger text-white',
                                        'aktif' => 'bg-info text-white',
                                        'menunggu' => 'bg-secondary text-white',
                                        default => 'bg-light text-dark',
                                    };
                                @endphp
                                <span class="badge {{ $statusClass }} rounded-pill px-3 py-1" style="font-size:13px;">
                                    {{ ucfirst($task->status) }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($task->updated_at)->translatedFormat('d/m/Y H:i') }}</td>
                            <td>
                                @if ($task->service && $task->service->order_time)
                                    @php
                                        $estimate_finish = \Carbon\Carbon::parse($task->created_at)
                                            ->addMinutes($task->service->order_time);
                                    @endphp
                                    {{ $estimate_finish->translatedFormat('d/m/Y H:i') }}
                                    <br>
                                    <small class="text-muted">
                                        (selesai {{ $estimate_finish->diffForHumans(null, true, false) }})
                                    </small>
                                @else
                                    -
                                @endif
                            </td>
                            <td>Rp {{ number_format($task->total_price, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="d-flex justify-content-center align-items-center" style="height: 50vh;">
            <div class="text-center">
                <i class="bi bi-exclamation-circle" style="font-size: 80px; color: #ff6b6b;"></i>
                <h2 class="mt-4 fw-bold">Belum Ada Task</h2>
                <p class="lead text-muted">Sepertinya belum ada riwayat task yang selesai atau sedang dikerjakan.</p>
                <a href="{{ url()->previous() }}" class="btn btn-primary mt-3">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    @endif

</div>

<style>
    /* Hover ringan */
    table.table-hover tbody tr:hover {
        background-color: #2a2a3c !important;
        transition: background-color 0.3s;
    }

    /* Badge shadow untuk lebih menonjol */
    .badge {
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }

    /* Responsive untuk tampilan mobile */
    @media (max-width: 768px) {
        table.table thead {
            display: none;
        }
        table.table tbody tr {
            display: block;
            margin-bottom: 15px;
            background-color: #2c2c3e;
            border-radius: 8px;
            padding: 10px;
        }
        table.table tbody td {
            display: flex;
            justify-content: space-between;
            padding: 5px 10px;
        }
        table.table tbody td::before {
            content: attr(data-label);
            font-weight: bold;
            color: #adb5bd;
        }
    }
</style>
@endsection
