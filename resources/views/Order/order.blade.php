@extends('layouts')

@section('title', 'Pesanan Laundry Saya')

@section('content')
    <style>
        body {
            background: linear-gradient(to bottom right, #eef4ff, #dbeafe);
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        .order-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            padding: 25px;
            margin: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .header h1 {
            font-size: 22px;
            color: #334155;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .header a {
            background: #4f46e5;
            color: white;
            padding: 10px 16px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }

        .header a:hover {
            background: #4338ca;
        }

        .active-order {
            background: linear-gradient(to right, #eef2ff, #e0e7ff);
            border-left: 6px solid #4f46e5;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .active-order h3 {
            color: #4338ca;
            font-size: 18px;
            font-weight: 600;
        }

        .price {
            color: #111827;
            font-weight: 600;
            font-size: 18px;
        }

        /* Modal Base */
        .modal {
            display: none;
            position: fixed;
            z-index: 50;
            inset: 0;
            background: rgba(15, 23, 42, 0.45);
            backdrop-filter: blur(6px);
            justify-content: center;
            align-items: center;
            animation: fadeInBg 0.3s ease;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            border-radius: 16px;
            padding: 25px;
            width: 90%;
            max-width: 420px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            animation: slideUp 0.3s ease;
            position: relative;
        }

        .close-btn {
            position: absolute;
            top: 12px;
            right: 20px;
            cursor: pointer;
            color: #64748b;
            font-size: 22px;
            transition: 0.2s;
        }

        .close-btn:hover {
            color: #1e293b;
            transform: scale(1.1);
        }

        .modal-content h2 {
            text-align: center;
            color: #1e293b;
            margin-bottom: 20px;
            font-weight: 600;
            background: linear-gradient(to right, #4f46e5, #6366f1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Invoice */
        .invoice-details {
            background: #f8fafc;
            padding: 15px;
            border-radius: 10px;
            margin-top: 10px;
            font-size: 14px;
            color: #334155;
        }

        .invoice-details p {
            margin: 6px 0;
        }

        .total-display {
            text-align: center;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 10px;
            background: #f1f5f9;
            border-radius: 8px;
            padding: 8px 0;
        }

        label {
            display: block;
            font-weight: 500;
            color: #334155;
            margin-bottom: 5px;
            font-size: 14px;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .option-group {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }

        .option-group input[type="radio"] {
            display: none;
        }

        .option-card {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f1f5f9;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px;
            font-size: 14px;
            font-weight: 500;
            color: #334155;
            cursor: pointer;
            transition: 0.3s;
        }

        .option-group input[type="radio"]:checked+.option-card {
            background: linear-gradient(to right, #4f46e5, #6366f1);
            color: white;
            border-color: #4f46e5;
            box-shadow: 0 3px 10px rgba(99, 102, 241, 0.3);
        }

        .option-card:hover {
            transform: scale(1.03);
        }

        @media (max-width: 480px) {
            .option-group {
                grid-template-columns: 1fr;
            }
        }


        button {
            background: linear-gradient(to right, #4f46e5, #6366f1);
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }

        button:hover {
            transform: scale(1.02);
            box-shadow: 0 5px 15px rgba(99, 102, 241, 0.3);
        }

        @keyframes fadeInBg {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 480px) {
            .header h1 {
                font-size: 18px;
            }

            .header a {
                font-size: 14px;
                padding: 8px 14px;
            }

            .active-order h3 {
                font-size: 16px;
            }
        }

        .notif {
            position: fixed;
            top: 20px;
            padding: 12px 18px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            z-index: 1000;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            opacity: 0;
            transform: translateY(-10px);
            animation: slideIn 0.5s forwards, fadeOut 0.5s 3.5s forwards;
        }

        .notif.success {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
        }

        .notif.error {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        @keyframes slideIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeOut {
            to {
                opacity: 0;
                transform: translateY(-10px);
            }
        }

        #detailModal .modal-content {
            max-width: 400px;
            animation: slideUp 0.4s ease;
        }

        #estimateTime {
            background: #1f2937;
            /* abu gelap */
            padding: 10px 14px;
            border-left: 4px solid #10b981;
            /* hijau emerald */
            margin-top: 12px;
            border-radius: 6px;
            font-size: 14px;
            color: #e5e7eb;
            /* abu terang */
            display: none;
        }
    </style>


    @if (session('success'))
        <div id="notif-success" class="notif success">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div id="notif-error" class="notif error">
            <span>{{ session('error') }}</span>
        </div>
    @endif


    <div class="order-container">
        <div class="header">
            <h1><i class="fas fa-shirt"></i> Pesanan Laundry Saya</h1>
            <a id="openModal" style="color: white"><i class="fas fa-plus-circle"></i> Pesan Sekarang</a>
        </div>

        @if ($activeOrders)
            @php
                $estimasi = \Carbon\Carbon::parse($activeOrders->created_at)
                    ->addMinutes($activeOrders->service->order_time)
                    ->translatedFormat('d M Y H:i');
            @endphp

            <div class="active-order">
                <h3>Pesanan Aktif</h3>

                <p>Nomor: <b>#{{ $activeOrders->invoice_code }}</b></p>
                <p>Tanggal: {{ \Carbon\Carbon::parse($activeOrders->created_at)->translatedFormat('d M Y') }}</p>
                <p>Layanan: {{ $activeOrders->service->name }} ({{ $activeOrders->weight }} Kg)</p>
                <p>Operator: {{ $activeOrders->service->user->name ?? '-' }}</p>

                {{-- Estimasi --}}
                <p><b>Estimasi Selesai:</b> {{ $estimasi }}</p>

                <p class="price">Total: Rp {{ number_format($activeOrders->total_price, 0, ',', '.') }}</p>
            </div>
        @else
            <div class="active-order">
                <h3>Pesanan Aktif</h3>
                <p>Tidak ada pesanan aktif saat ini.</p>
            </div>
        @endif



        @if ($orders->count() > 0)
            <div class="past-orders" style="margin-top: 20px;">
                <h3 style="color:#334155; margin-bottom:15px; font-weight:600; font-size:18px;">Riwayat Pesanan</h3>

                <ul style="list-style: none; padding: 0; margin:0;">
                    @foreach ($orders as $order)
                        <li style="
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 15px 20px;
                    border-radius: 12px;
                    background: #ffffff;
                    margin-bottom: 12px;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
                    transition: transform 0.2s, box-shadow 0.2s;
                "
                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.1)';"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.05)';">

                            <div>
                                <p style="margin:0; font-weight:600; color:#1e293b;">#{{ $order->invoice_code }}
                                    <span style="font-weight:400; color:#64748b;">-
                                        {{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('d M Y') }}</span>
                                </p>
                                <p style="margin:4px 0; color:#334155;">
                                    {{ $order->service->name }} ({{ $order->weight }} Kg) - Rp
                                    {{ number_format($order->total_price, 0, ',', '.') }}
                                </p>
                                <p style="margin:2px 0; color:#475569;">Operator: {{ $order->service->user->name ?? '-' }}
                                </p>
                                <p
                                    style="margin:2px 0; font-weight:500; color: {{ $order->status == 'Selesai' ? '#16a34a' : ($order->status == 'Proses' ? '#f59e0b' : '#ef4444') }};">
                                    Status: {{ $order->status }}
                                </p>

                                <p>
                                    @if ($order->document_path)
                                        <a href="{{ route('payment.proof', $order->document_path) }}" target="_blank">
                                            Lihat Bukti
                                        </a>
                                    @else
                                        Tidak ada bukti barang
                                    @endif
                                </p>
                            </div>

                            <div style="display: flex; gap:8px;">
                                <a href="#" class="view-detail" data-id="{{ $order->invoice_code }}"
                                    data-date="{{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('d M Y') }}"
                                    data-service="{{ $order->service->name }}" data-weight="{{ $order->weight }}"
                                    data-operator="{{ $order->service->user->name ?? '-' }}"
                                    data-status="{{ $order->status }}"
                                    data-total="{{ number_format($order->total_price, 0, ',', '.') }}"
                                    style="background:#4f46e5; color:white; padding:6px 12px; border-radius:8px; text-decoration:none; font-size:13px; font-weight:500; transition:0.2s;"
                                    onmouseover="this.style.background='#4338ca';"
                                    onmouseout="this.style.background='#4f46e5';">
                                    Lihat
                                </a>
                                <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="margin:0;"
                                    onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        style="background:#ef4444; color:white; padding:6px 12px; border-radius:8px; border:none; font-size:13px; font-weight:500; cursor:pointer; transition:0.2s;"
                                        onmouseover="this.style.background='#dc2626';"
                                        onmouseout="this.style.background='#ef4444';">
                                        Hapus
                                    </button>
                                </form>
                            </div>

                        </li>
                    @endforeach
                </ul>
            </div>
        @endif


    </div>

    <!-- Modal Pesanan -->
    <div class="modal" id="orderModal">
        <div class="modal-content">
            <span class="close-btn" id="closeModal">&times;</span>
            <h2>Buat Pesanan Baru</h2>

            <form id="orderForm" action="{{ route('orders.create') }}" method="POST">
                @csrf

                <label>Pilih Opsi Berat:</label>
                <div class="option-group">
                    <input type="radio" id="knowWeightYes" name="knowWeight" value="yes" checked>
                    <label for="knowWeightYes" class="option-card">Mengetahui Berat</label>

                    <input type="radio" id="knowWeightNo" name="knowWeight" value="no">
                    <label for="knowWeightNo" class="option-card">Tidak Mengetahui Berat</label>
                </div>


                <label for="type">Tipe Pencucian</label>
                <select id="type" name="service_id" required>
                    <option value="">-- Pilih Layanan --</option>
                    @foreach ($services as $data)
                        {{-- <option value="{{ $data->id }}" data-price="{{ $data->price }}"
                            data-operator="{{ $data->user->name ?? '-' }}">
                            {{ $data->name }} - Rp {{ number_format($data->price, 0, ',', '.') }} / Kg
                        </option> --}}

                        <option value="{{ $data->id }}" data-price="{{ $data->price }}"
                            data-operator="{{ $data->user->name ?? '-' }}" data-order-time="{{ $data->order_time }}">
                            {{ $data->name }} - Rp {{ number_format($data->price, 0, ',', '.') }} / Kg
                        </option>
                    @endforeach
                </select>

                <p id="estimateTime" class="text-info fw-semibold" style="margin-top:10px;"></p>

                <div id="weightContainer">
                    <label for="weight">Berat (Kg)</label>
                    <input type="number" id="weight" min="1" max="50" name="weight"
                        placeholder="Masukkan berat cucian">
                </div>

                <p class="total-display" id="totalText" name="total_price">Total: Rp 0</p>
                <button type="submit">Kirim Pesanan</button>
            </form>
        </div>
    </div>

    <div class="modal" id="detailModal">
        <div class="modal-content">
            <span class="close-btn" id="closeDetail">&times;</span>
            <h2>Detail Pesanan</h2>
            <div class="invoice-details" id="detailContent"></div>
            <button id="closeDetailBtn">Tutup</button>
        </div>
    </div>

    <!-- Modal Invoice -->
    <div class="modal" id="invoiceModal">
        <div class="modal-content">
            <span class="close-btn" id="closeInvoice">&times;</span>
            <h2>Invoice Pesanan</h2>
            <div class="invoice-details" id="invoiceDetails"></div>
            <button id="doneInvoice">Selesai</button>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://kit.fontawesome.com/3f8b45a9b7.js" crossorigin="anonymous"></script>
    <script>
        const openModal = document.getElementById('openModal');
        const closeModal = document.getElementById('closeModal');
        const orderModal = document.getElementById('orderModal');
        const invoiceModal = document.getElementById('invoiceModal');
        const closeInvoice = document.getElementById('closeInvoice');
        const doneInvoice = document.getElementById('doneInvoice');
        const invoiceDetails = document.getElementById('invoiceDetails');
        const typeSelect = document.getElementById('type');
        const weightInput = document.getElementById('weight');
        const totalText = document.getElementById('totalText');
        const knowWeightRadios = document.getElementsByName('knowWeight');
        const weightContainer = document.getElementById('weightContainer');

        openModal.onclick = () => orderModal.classList.add('active');
        closeModal.onclick = () => orderModal.classList.remove('active');
        closeInvoice.onclick = () => invoiceModal.classList.remove('active');
        doneInvoice.onclick = () => invoiceModal.classList.remove('active');

        function updateTotal() {
            const selected = typeSelect.options[typeSelect.selectedIndex];
            const price = selected.dataset.price ? parseInt(selected.dataset.price) : 0;
            const weight = parseFloat(weightInput.value) || 0;
            const total = price * weight;
            totalText.textContent = `Total: Rp ${total.toLocaleString('id-ID')}`;
        }

        typeSelect.addEventListener('change', updateTotal);
        weightInput.addEventListener('input', updateTotal);

        knowWeightRadios.forEach(r => {
            r.addEventListener('change', () => {
                if (r.value === 'yes') {
                    weightContainer.style.display = 'block';
                    totalText.style.display = 'block';
                } else {
                    weightContainer.style.display = 'none';
                    totalText.style.display = 'none';
                    weightInput.value = '';
                }
            });
        });

        document.getElementById('orderForm').addEventListener('submit', (e) => {
            // e.preventDefault();

            const selectedOption = typeSelect.options[typeSelect.selectedIndex];
            const serviceName = selectedOption.text; // nama layanan
            const operatorName = selectedOption.dataset.operator || 'Belum ditentukan';
            const knowsWeight = document.querySelector('input[name="knowWeight"]:checked').value === 'yes';
            const weight = knowsWeight ? `${weightInput.value} Kg` : 'Belum diketahui';
            const pricePerKg = Number(selectedOption.dataset.price) || 0;
            const total = knowsWeight ? (pricePerKg * Number(weightInput.value)) : 'Belum dihitung';

            const orderId = 'LDR-' + Date.now().toString().slice(-6);
            const today = new Date();
            const formattedDate = today.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });

            invoiceDetails.innerHTML = `
                <p><b>ID Pesanan:</b> #${orderId}</p>
                <p><b>Tanggal:</b> ${formattedDate}</p>
                <p><b>Layanan:</b> ${serviceName}</p>
                <p><b>Operator:</b> ${operatorName}</p> 
                <p><b>Berat:</b> ${weight}</p>
                <p><b>Total:</b> ${typeof total === 'number' ? 'Rp ' + total.toLocaleString('id-ID') : total}</p>
            `;

            orderModal.classList.remove('active');
            invoiceModal.classList.add('active');
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notifSuccess = document.getElementById('notif-success');
            const notifError = document.getElementById('notif-error');

            // Auto-hide notifikasi setelah 4 detik
            setTimeout(() => {
                if (notifSuccess) notifSuccess.style.display = 'none';
                if (notifError) notifError.style.display = 'none';
            }, 4000);
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const detailModal = document.getElementById('detailModal');
            const detailContent = document.getElementById('detailContent');
            const closeDetail = document.getElementById('closeDetail');
            const closeDetailBtn = document.getElementById('closeDetailBtn');

            document.querySelectorAll('.view-detail').forEach(btn => {
                btn.addEventListener('click', e => {
                    e.preventDefault();

                    const id = btn.dataset.id;
                    const date = btn.dataset.date;
                    const service = btn.dataset.service;
                    const weight = btn.dataset.weight;
                    const operator = btn.dataset.operator;
                    const status = btn.dataset.status;
                    const total = btn.dataset.total;

                    detailContent.innerHTML = `
                <p><b>ID Pesanan:</b> #${id}</p>
                <p><b>Tanggal:</b> ${date}</p>
                <p><b>Layanan:</b> ${service}</p>
                <p><b>Operator:</b> ${operator}</p>
                <p><b>Berat:</b> ${weight} Kg</p>
                <p><b>Status:</b> <span style="color:${statusColor(status)}">${status}</span></p>
                <p><b>Total:</b> Rp ${total}</p>
            `;

                    detailModal.classList.add('active');
                });
            });

            function statusColor(status) {
                if (status === 'Selesai') return '#16a34a';
                if (status === 'Proses') return '#f59e0b';
                return '#ef4444';
            }

            closeDetail.onclick = () => detailModal.classList.remove('active');
            closeDetailBtn.onclick = () => detailModal.classList.remove('active');
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const serviceSelect = document.getElementById("type");
            const estimateTime = document.getElementById("estimateTime");

            serviceSelect.addEventListener("change", function() {
                const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
                const orderMinutes = parseInt(selectedOption.getAttribute("data-order-time"));

                if (!orderMinutes || isNaN(orderMinutes)) {
                    estimateTime.style.display = "none";
                    estimateTime.innerHTML = "";
                    return;
                }

                // Ambil waktu sekarang
                const now = new Date();

                // Tambahkan menit order_time
                const finishTime = new Date(now.getTime() + orderMinutes * 60000);

                // Format waktu Indonesia
                const options = {
                    weekday: "long",
                    year: "numeric",
                    month: "long",
                    day: "numeric",
                    hour: "2-digit",
                    minute: "2-digit",
                    timeZone: "Asia/Jakarta"
                };

                const formattedFinish = finishTime.toLocaleString("id-ID", options)
                    .replace(".", ":"); // Perbaikan format menit

                estimateTime.innerHTML = `
            <strong>Estimasi selesai:</strong><br>
            ${formattedFinish} WIB
        `;

                estimateTime.style.display = "block";
            });

        });
    </script>



@endsection
