@extends('layouts')

@section('title', 'Tugas Saya')

@section('content')
    <style>
        .task-card {
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            background: #fff;
            transition: all 0.3s ease;
        }

        .task-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .task-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .task-header h5 {
            color: #1e293b;
            font-weight: 600;
        }

        .badge-status {
            font-size: 13px;
            padding: 6px 10px;
            border-radius: 8px;
        }

        .badge-success {
            background: #dcfce7;
            color: #166534;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-secondary {
            background: #e2e8f0;
            color: #475569;
        }

        .action-btn {
            background: linear-gradient(to right, #4f46e5, #6366f1);
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 10px;
            font-weight: 500;
            cursor: pointer;
            transition: 0.3s;
        }

        .action-btn:hover {
            box-shadow: 0 5px 15px rgba(99, 102, 241, 0.3);
            transform: translateY(-2px);
        }

        .card-section-title {
            font-weight: 600;
            color: #334155;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-section-title i {
            color: #4f46e5;
        }
    </style>

    <div class="container-fluid">
        <h3 class="text-primary mb-4"><i class="bi bi-list-check"></i> Tugas Saya</h3>

        {{-- Bagian Tugas Aktif --}}
        <div class="mb-4">
            <h5 class="card-section-title"><i class="bi bi-hourglass-split"></i> Sedang Dikerjakan</h5>
            @if ($activeTask != null)
                <div class="task-card">
                    <div class="task-header">
                        <h5>#{{ $activeTask->invoice_code ?? 'INV-XXXX' }}</h5>
                        <span class="badge-status badge-warning">{{ $activeTask->status }}</span>
                    </div>
                    <p><strong>Pelanggan:</strong> {{ $activeTask->user->name ?? '-' }}</p>
                    <p><strong>Layanan:</strong> {{ $activeTask->service->name ?? '-' }}</p>
                    <p><strong>Berat:</strong> {{ $activeTask->weight ?? 'N/A' }} Kg</p>
                    <p><strong>Total:</strong> Rp {{ number_format($activeTask->total_price, 0, ',', '.') }}</p>
                    <p><strong>Tanggal:</strong> {{ $activeTask->created_at->translatedFormat('d M Y') }}</p>

                    <form action="{{ route('operator.finish', $activeTask->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="button" class="action-btn"
                            onclick="openConfirm('Apakah Anda yakin ingin menandai tugas ini sebagai selesai?', this.form)">

                            <i class="bi bi-check-circle"></i> Tandai Selesai
                        </button>
                    </form>

                </div>
            @else
                <div class="text-muted fst-italic">Belum ada tugas yang sedang dikerjakan.</div>
            @endif
        </div>

        {{-- Bagian Tugas yang Belum Dikerjakan --}}
        <div>
            <h5 class="card-section-title"><i class="bi bi-clipboard2"></i> Daftar Tugas Belum Dikerjakan</h5>
            @if ($pendingTasks->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>Nama Pelanggan</th>
                                <th>Layanan</th>
                                <th>Berat (Kg)</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendingTasks as $index => $task)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $task->user->name ?? '-' }}</td>
                                    <td>{{ $task->service->name ?? '-' }}</td>
                                    <td>{{ $task->weight ?? '-' }}</td>
                                    <td>Rp {{ number_format($task->total_price, 0, ',', '.') }}</td>
                                    <td>
                                        @php
                                            $statusClass = match ($task->status) {
                                                'Menunggu' => 'badge-secondary',
                                                'Proses' => 'badge-warning',
                                                'Selesai' => 'badge-success',
                                                default => 'badge-secondary',
                                            };
                                        @endphp
                                        <span class="badge-status {{ $statusClass }}">{{ $task->status }}</span>
                                    </td>
                                    <td>{{ $task->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <form action="{{ route('operator.start', $task->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="button" class="action-btn"
                                                onclick="openConfirm('Mulai kerjakan tugas ini sekarang?', this.form)">

                                                <i class="bi bi-play-circle"></i> Kerjakan
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted fst-italic">Tidak ada tugas baru saat ini.</p>
            @endif
        </div>

        <!-- Modal Konfirmasi Profesional -->
        <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 18px;">
                    <div class="modal-header" style="border-bottom: none;">
                        <h5 class="modal-title" id="confirmModalLabel">
                            <i class="bi bi-exclamation-circle text-warning"></i> Konfirmasi Tindakan
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body text-center">
                        <p id="confirmMessage" style="font-size: 16px; color: #475569;"></p>
                    </div>

                    <div class="modal-footer" style="border-top: none;">
                        <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary px-3" id="confirmYesBtn">Ya, Lanjutkan</button>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection

@section('scripts')

    <script>
        let formToSubmit = null;

        function openConfirm(message, form) {
            formToSubmit = form;
            document.getElementById("confirmMessage").innerText = message;

            const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
            modal.show();
        }

        document.getElementById("confirmYesBtn").addEventListener('click', function() {
            if (formToSubmit) formToSubmit.submit();
        });
    </script>

@endsection
