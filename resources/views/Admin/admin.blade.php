@extends('layouts')

@section('title', 'Manajemen Order')

@section('content')

    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <style>
        body {
            background: linear-gradient(to bottom right, #eef2ff, #e0e7ff);
            font-family: 'Poppins', sans-serif;
        }

        .page-title {
            font-weight: 700;
            color: #3730a3;
        }

        .nav-tabs .nav-link {
            border: none;
            color: #4b5563;
            font-weight: 500;
            transition: 0.3s;
        }

        .nav-tabs .nav-link.active {
            background-color: #4f46e5;
            color: white;
            border-radius: 10px;
        }

        .card-order {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            padding: 20px;
            transition: 0.3s;
            margin-top: 15px;
        }

        .table thead {
            background-color: #4f46e5;
            color: #fff;
        }

        .badge-status {
            font-size: 12px;
            padding: 5px 10px;
            border-radius: 8px;
            font-weight: 500;
        }

        .badge-success {
            background-color: #dcfce7;
            color: #166534;
        }

        .badge-warning {
            background-color: #fef3c7;
            color: #92400e;
        }

        .badge-secondary {
            background-color: #e2e8f0;
            color: #475569;
        }

        .action-btn {
            background: linear-gradient(to right, #4f46e5, #6366f1);
            color: white;
            padding: 6px 12px;
            border-radius: 8px;
            border: none;
            font-weight: 500;
            transition: 0.3s;
        }

        .action-btn:hover {
            box-shadow: 0 5px 15px rgba(99, 102, 241, 0.3);
            transform: translateY(-2px);
        }
    </style>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif


    <div class="container-fluid py-3">
        <h3 class="page-title mb-4"><i class="bi bi-clipboard-data"></i> Manajemen Order</h3>

        <!-- Tabs -->
        <ul class="nav nav-tabs" id="orderTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" id="new-tab" data-bs-toggle="tab" data-bs-target="#newOrders"
                    type="button">
                    <i class="bi bi-cart-check"></i> Pesanan Baru
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="progress-tab" data-bs-toggle="tab" data-bs-target="#progressOrders"
                    type="button">
                    <i class="bi bi-gear-wide-connected"></i> Proses & Selesai
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="payment-tab" data-bs-toggle="tab" data-bs-target="#paymentOrders"
                    type="button">
                    <i class="bi bi-credit-card-2-front"></i> Pembayaran & Pengambilan
                </button>
            </li>
        </ul>

        <div class="tab-content" id="orderTabsContent">

            <!-- ========== PESANAN BARU ========== -->
            <div class="tab-pane fade show active" id="newOrders" role="tabpanel">
                <div class="card-order">
                    <h5><i class="bi bi-cart-plus"></i> Daftar Pesanan Baru</h5>
                    @if ($newOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Customer</th>
                                        <th>Layanan</th>
                                        <th>Berat</th>
                                        <th>Tanggal</th>
                                        <th>Total</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($newOrders as $index => $order)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $order->user->name ?? '-' }}</td>
                                            <td>{{ $order->service->name ?? '-' }}</td>
                                            <td>{{ $order->weight ?? '-' }} Kg</td>
                                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                            <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                            <td>
                                                <button type="button" class="action-btn btn-assign"
                                                    data-order-id="{{ $order->id }}">
                                                    <i class="bi bi-person-plus"></i> Tugaskan
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted fst-italic">Belum ada pesanan baru.</p>
                    @endif
                </div>
            </div>

            <!-- ========== PROSES & SELESAI ========== -->
            <div class="tab-pane fade" id="progressOrders" role="tabpanel">
                <div class="card-order">
                    <h5><i class="bi bi-hourglass-split"></i> Pesanan Sedang Dikerjakan</h5>
                    @if ($inProgressOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Operator</th>
                                        <th>Customer</th>
                                        <th>Layanan</th>
                                        <th>Status</th>
                                        <th>Update</th>
                                        <th>Total</th>
                                        <th>Estimasi Selesai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($inProgressOrders as $index => $order)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $order->operator->name ?? '-' }}</td>
                                            <td>{{ $order->user->name ?? '-' }}</td>
                                            <td>{{ $order->service->name ?? '-' }}</td>
                                            <td><span class="badge-status badge-warning">Proses</span></td>
                                            <td>{{ $order->updated_at->format('d/m/Y') }}</td>
                                            <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                            <td>
                                                @if ($order->estimate_finish)
                                                    {{ $order->estimate_finish->translatedFormat('d/m/Y H:i') }}
                                                    <br>
                                                    <small class="text-muted">(selesai
                                                        {{ $order->estimate_finish->diffForHumans(null, true, false) }})</small>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted fst-italic">Belum ada pesanan dalam proses.</p>
                    @endif
                </div>

                <div class="card-order">
                    <h5><i class="bi bi-check2-circle"></i> Pesanan Selesai</h5>

                    @if ($completedOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Customer</th>
                                        <th>Layanan</th>
                                        <th>Berat</th>
                                        <th>Total</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($completedOrders as $index => $order)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $order->user->name ?? '-' }}</td>
                                            <td>{{ $order->service->name ?? '-' }}</td>
                                            <td>{{ $order->weight }} Kg</td>
                                            <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                            <td>{{ $order->updated_at->format('d/m/Y') }}</td>
                                            <td>
                                                @if ($order->status == 'Pembayaran')
                                                    <span class="badge bg-warning text-dark">
                                                        Pembayaran
                                                    </span>
                                                @else
                                                    <button class="action-btn btn-recalculate"
                                                        data-order-id="{{ $order->id }}"
                                                        data-service-price="{{ $order->service->price }}"
                                                        data-current-weight="{{ $order->weight }}">
                                                        <i class="bi bi-pencil-square"></i> Update & Bayar
                                                    </button>
                                                @endif
                                            </td>


                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted fst-italic">Belum ada pesanan yang selesai.</p>
                    @endif
                </div>
            </div>

            <!-- ========== PEMBAYARAN ========== -->
            <div class="tab-pane fade" id="paymentOrders" role="tabpanel">
                <div class="card-order">
                    <h5><i class="bi bi-wallet2"></i> Pembayaran & Pengambilan Barang</h5>
                    @if ($paymentOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Customer</th>
                                        <th>Layanan</th>
                                        <th>Total</th>
                                        <th>Metode Pembayaran</th>
                                        <th>Status Pembayaran</th>
                                        <th>Dokument Barang</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($paymentOrders as $index => $order)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $order->order->user->name ?? '-' }}</td>
                                            <td>{{ $order->order->service->name ?? '-' }}</td>
                                            <td>Rp {{ number_format($order->order->total_price, 0, ',', '.') }}</td>
                                            <td>
                                                @if ($order->payment_method == 'QRIS')
                                                    <button class="btn btn-sm btn-info show-qris-btn"
                                                        data-qris="{{ asset('images/QRIS.jpg') }}">
                                                        <i class="bi bi-qr-code"></i> Lihat QRIS
                                                    </button>
                                                @elseif($order->payment_method == 'Cash')
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-cash-stack"></i> Cash
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">Metode Tidak Dikenal</span>
                                                @endif
                                            </td>

                                            <td>
                                                <span
                                                    class="badge-status {{ $order->status == 'Lunas' ? 'badge-success' : 'badge-warning' }}">
                                                    {{ $order->status ?? 'Belum Bayar' }}
                                                </span>
                                            </td>

                                            <td>
                                                @if ($order->document_path)
                                                    <a href="{{ route('payment.proof', $order->document_path) }}"
                                                        target="_blank">
                                                        Lihat Bukti
                                                    </a>
                                                @else
                                                    <form
                                                        action="{{ route('admin.order.uploadPaymentProof', $order->id) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="file" name="payment_proof" accept="image/*" required
                                                            class="form-control form-control-sm mb-1">
                                                        <button type="submit" class="btn btn-sm btn-primary">
                                                            <i class="bi bi-upload"></i> Upload
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>

                                            <td>
                                                @if ($order->status == 'Pembayaran')
                                                    <form action="{{ route('admin.order.updateStatus', $order->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="action" value="lunas">
                                                        <button class="action-btn">
                                                            <i class="bi bi-cash-stack"></i> Tandai Lunas
                                                        </button>
                                                    </form>
                                                @elseif($order->status == 'Pengambilan' || $order->status == 'Lunas')
                                                    <form action="{{ route('admin.order.updateStatus', $order->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="action" value="diambil">
                                                        <button class="action-btn">
                                                            <i class="bi bi-box-arrow-up"></i> Tandai Diambil
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-success fw-semibold">
                                                        <i class="bi bi-check-circle"></i> Selesai
                                                    </span>
                                                @endif

                                                {{-- Tombol Hapus Pembayaran --}}
                                                <form action="{{ route('admin.order.deletePayment', $order->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus pembayaran ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger ms-2">
                                                        <i class="bi bi-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted fst-italic">Belum ada pesanan pembayaran/pengambilan.</p>
                    @endif
                </div>
            </div>



        </div>

        <div class="modal fade" id="qrisModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-4" style="border-radius: 16px; text-align: center;">

                    <h5 class="mb-3 fw-semibold">QRIS Pembayaran</h5>

                    <div class="d-flex justify-content-center">
                        <img id="qrisImage" src="" class="img-fluid rounded shadow mb-3"
                            style="max-width: 280px;">
                    </div>

                    <div class="text-center">
                        <button class="btn btn-secondary px-4" data-bs-dismiss="modal">
                            Tutup
                        </button>
                    </div>

                </div>
            </div>
        </div>


    </div>


    <!-- SweetAlert + Modal Pilih Operator -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.btn-assign').forEach(button => {
            button.addEventListener('click', function() {
                const orderId = this.getAttribute('data-order-id');
                Swal.fire({
                    title: 'Pilih Operator',
                    html: `
            <form id="assignForm" action="/admin/${orderId}" method="POST">
                @csrf
                @method('PUT')

                <h5 class="text-primary mb-2">🧾 Penugasan Order</h5>
                <p class="text-muted mb-3">
                    Pilih operator yang akan menangani order ini. Pastikan operator tersedia dan sesuai dengan jenis layanan pelanggan.
                </p>

                <select name="operator_id" class="form-select mt-2" required>
                    <option value="">— Pilih Operator yang Tersedia —</option>
                    @foreach ($operators as $operator)
                        <option value="{{ $operator->id }}">{{ $operator->name }}</option>
                    @endforeach
                </select>
            </form>
        `,

                    confirmButtonText: 'Tugaskan',
                    showCancelButton: true,
                    confirmButtonColor: '#4f46e5',
                    cancelButtonColor: '#6b7280',
                    preConfirm: () => {
                        const form = Swal.getHtmlContainer().querySelector('#assignForm');
                        if (!form.operator_id.value) {
                            Swal.showValidationMessage('Pilih operator terlebih dahulu');
                            return false;
                        }
                        form.submit();
                    }
                });
            });
        });
    </script>

    <script>
        document.querySelectorAll('.btn-recalculate').forEach(button => {
            button.addEventListener('click', function() {

                const orderId = this.getAttribute('data-order-id');
                const pricePerKg = this.getAttribute('data-service-price');
                const currentWeight = this.getAttribute('data-current-weight');


                Swal.fire({
                    title: 'Update Berat & Pembayaran',
                    html: `
                <form id="swalForm" action="/admin/payment/${orderId}" method="POST">
                    @csrf
                    <label class="fw-semibold">Berat (Kg)</label>
                    <input type="number" name="weight" id="newWeight" class="form-control mb-3" 
                        value="${currentWeight}" min="1" required>

                  <label class="fw-semibold">Harga / Kg</label>
                    <input type="text" name="price" readonly class="form-control mb-3" 
                        value="${(pricePerKg).toLocaleString()}">

                    <label class="fw-semibold">Total Harga</label>
                    <input type="text" name="total" id="calculatedTotal" readonly class="form-control mb-3"
                        value="${(currentWeight * pricePerKg).toLocaleString()}">


                    <label class="fw-semibold">Metode Pembayaran</label>
                    <select name="payment_method" id="paymentMethod" class="form-select mb-1" required>
                        <option value="">— Pilih Metode Pembayaran —</option>
                        <option value="Cash">💵 Cash</option>
                        <option value="QRIS">📱 QRIS</option>
                    </select>
                </form>
            `,
                    focusConfirm: false,
                    showCancelButton: true,
                    confirmButtonColor: '#4f46e5',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Simpan & Bayar',
                    didOpen: () => {
                        const newWeightInput = Swal.getHtmlContainer().querySelector(
                            '#newWeight');
                        const totalInput = Swal.getHtmlContainer().querySelector(
                            '#calculatedTotal');

                        newWeightInput.addEventListener('input', function() {
                            const newWeight = parseFloat(this.value) || 0;
                            const total = newWeight * pricePerKg;
                            totalInput.value = total; // value number, bukan format Rp
                        });
                    },
                    preConfirm: () => {
                        const form = Swal.getHtmlContainer().querySelector('#swalForm');
                        const newWeight = form.weight.value;
                        const paymentMethod = form.payment_method.value;

                        if (!newWeight || newWeight < 1) {
                            Swal.showValidationMessage(
                                'Berat tidak boleh kosong atau kurang dari 1 Kg!');
                            return false;
                        }

                        if (!paymentMethod) {
                            Swal.showValidationMessage(
                                'Pilih metode pembayaran terlebih dahulu!');
                            return false;
                        }

                        // submit form langsung
                        form.submit();
                    }
                });
            });
        });
    </script>

    <script>
        document.querySelectorAll('.show-qris-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const qrisUrl = this.getAttribute('data-qris');

                if (!qrisUrl) {
                    Swal.fire("QRIS tidak tersedia!", "", "warning");
                    return;
                }

                document.getElementById('qrisImage').src = qrisUrl;

                const qrisModal = new bootstrap.Modal(document.getElementById('qrisModal'));
                qrisModal.show();
            });
        });
    </script>



@endsection
