@extends('layouts.app')

@section('title', 'Order #'.$order->id.' - PreloveX')

@section('content')
<div class="container py-4">
    {{-- Flash Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
                <i class="bi bi-arrow-left me-1"></i>Back to Orders
            </a>
            <h2 class="fw-bold mb-1">Order #{{ $order->id }}</h2>
            <p class="text-muted mb-0">Placed on {{ $order->created_at->format('d M Y, H:i') }}</p>
        </div>
        @php
            $status = $order->status;
            $badge = match($status) {
                'pending' => 'bg-warning text-dark',
                'processing' => 'bg-info text-dark',
                'shipped' => 'bg-primary',
                'delivered' => 'bg-success',
                'cancelled' => 'bg-danger',
                default => 'bg-secondary',
            };
        @endphp
        <span class="badge {{ $badge }} px-3 py-2">{{ ucfirst($status) }}</span>
    </div>

    {{-- LOGIC PEMBAYARAN: Tampilkan PERMANEN (Kecuali Cancelled) --}}
    {{-- PERUBAHAN DI SINI: Syarat 'unpaid' dihapus agar tetap muncul walau sudah lunas --}}
    @if($order->status != 'cancelled')
    <div class="card mb-4 shadow-sm {{ $order->payment_status == 'paid' ? 'border-success' : 'border-warning' }}">
        
        {{-- Header dinamis: Hijau jika lunas, Kuning jika belum --}}
        <div class="card-header {{ $order->payment_status == 'paid' ? 'bg-success text-white' : 'bg-warning bg-opacity-10 border-warning' }}">
            <h5 class="mb-0 fw-bold {{ $order->payment_status == 'paid' ? '' : 'text-dark' }}">
                <i class="bi bi-wallet2 me-2"></i>
                {{-- Judul berubah sesuai status --}}
                {{ $order->payment_status == 'paid' ? 'Info Pembayaran (LUNAS)' : 'Instruksi Pembayaran' }}
            </h5>
        </div>

        <div class="card-body">
            
            {{-- 1. BANK TRANSFER --}}
            @if($order->payment_method == 'bank_transfer')
                <div class="alert {{ $order->payment_status == 'paid' ? 'alert-success' : 'alert-info' }} mb-0">
                    <h6 class="fw-bold">Metode: Bank Transfer</h6>
                    <p class="mb-2">Silakan transfer sejumlah <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong> ke rekening berikut:</p>
                    
                    {{-- Kotak Rekening --}}
                    <div class="p-3 bg-white rounded border mb-3 text-dark">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Bank BCA</span>
                            <span class="fw-bold fs-5">123-456-7890</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span>A.n PreloveX Official</span>
                            <button class="btn btn-sm btn-outline-primary" onclick="navigator.clipboard.writeText('1234567890')">Salin</button>
                        </div>
                    </div>
                    <small class="text-muted">*Mohon sertakan Nomor Order <strong>#{{ $order->id }}</strong> pada berita transfer.</small>
                    
                    {{-- Tombol Konfirmasi (Hanya muncul jika belum lunas) --}}
                    @if($order->payment_status != 'paid')
                    <div class="mt-3">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmPaymentModal">
                            Konfirmasi Pembayaran
                        </button>
                    </div>
                    @endif
                </div>

            {{-- 2. COD (CASH ON DELIVERY) --}}
            @elseif($order->payment_method == 'cod')
                <div class="alert {{ $order->payment_status == 'paid' ? 'alert-success' : 'alert-light border-secondary' }} mb-0">
                    <h6 class="fw-bold text-success"><i class="bi bi-truck me-2"></i>Metode: Cash On Delivery (COD)</h6>
                    
                    @if($order->payment_status == 'paid')
                        <p class="mb-0">Pembayaran COD telah selesai diterima.</p>
                    @else
                        <p>Pesanan Anda akan segera diproses. Mohon siapkan uang tunai pas saat kurir tiba.</p>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total yang harus dibayar ke kurir:</span>
                            <span class="text-danger fs-5">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    @endif
                </div>

            {{-- 3. REKENING BERSAMA / E-WALLET --}}
            @elseif($order->payment_method == 'e_wallet')
                <div class="alert {{ $order->payment_status == 'paid' ? 'alert-success' : 'alert-info' }} mb-0">
                    <h6 class="fw-bold">Metode: E-Wallet / QRIS (Rekber)</h6>
                    
                    @if($order->payment_status == 'paid')
                        <p class="mb-0">Terima kasih, pembayaran via E-Wallet telah kami terima.</p>
                    @else
                        <p class="mb-2">Silakan scan QR Code di bawah atau transfer ke E-Wallet admin:</p>
                        <div class="row align-items-center">
                            <div class="col-md-3 text-center mb-3 mb-md-0">
                                <div class="bg-white p-2 d-inline-block border rounded">
                                    <img src="https://via.placeholder.com/150?text=QRIS+Code" alt="QRIS" class="img-fluid">
                                </div>
                            </div>
                            <div class="col-md-9">
                                <ul class="list-group mb-3">
                                    <li class="list-group-item d-flex justify-content-between align-items-center text-dark">
                                        <span><i class="bi bi-phone me-2"></i>Gopay / OVO / Dana</span>
                                        <span class="fw-bold">0812-3456-7890</span>
                                    </li>
                                </ul>
                                <small class="text-muted">Dana akan diamankan oleh PreloveX hingga barang Anda terima.</small>
                            </div>
                        </div>
                        
                        {{-- Tombol Konfirmasi (Hanya muncul jika belum lunas) --}}
                        <div class="mt-3">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmPaymentModal">
                                Saya Sudah Bayar
                            </button>
                        </div>
                        
                        {{-- Tombol Konfirmasi Penerimaan Barang (Hanya jika sudah bayar & barang dalam perjalanan) --}}
                        @if($order->payment_status === 'paid' && in_array($order->status, ['processing', 'shipped']))
                        <div class="mt-2">
                            <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#confirmReceiptModal">
                                <i class="bi bi-check2 me-1"></i>Konfirmasi Penerimaan Barang
                            </button>
                        </div>
                        @elseif($order->escrow_status === 'completed')
                        <div class="mt-2 alert alert-success mb-0">
                            <i class="bi bi-check-circle me-2"></i>Barang dikonfirmasi diterima. Dana akan dilepaskan ke penjual.
                        </div>
                        @endif
                    @endif
                </div>
            @endif

        </div>
    </div>
    @endif

    <div class="row g-4">
        {{-- Kolom Kiri: Daftar Barang --}}
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold">Items</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                    @php $subtotal = $item->price * $item->quantity; @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $item->item->image ? asset('storage/'.$item->item->image) : 'https://via.placeholder.com/60' }}"
                                                     class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;" alt="">
                                                <div>
                                                    <div class="fw-semibold">{{ $item->item->name }}</div>
                                                    <small class="text-muted">SKU: {{ $item->item->sku }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Rp {{ number_format($item->price,0,',','.') }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="text-end fw-semibold">Rp {{ number_format($subtotal,0,',','.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Subtotal</th>
                                    <th class="text-end">Rp {{ number_format($order->total_amount - $order->shipping_cost - $order->tax, 0, ',', '.') }}</th>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-end">Shipping Cost</th>
                                    <th class="text-end">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</th>
                                </tr>
                                <tr class="table-light">
                                    <th colspan="3" class="text-end">Total</th>
                                    <th class="text-end text-primary fs-5">Rp {{ number_format($order->total_amount,0,',','.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Info Order & Shipping --}}
        <div class="col-lg-4">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-white">
                    <h6 class="mb-0 fw-bold">Order Info</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <div class="text-muted small">Order ID</div>
                        <div class="fw-semibold">#{{ $order->id }}</div>
                    </div>
                    <div class="mb-2">
                        <div class="text-muted small">Date</div>
                        <div class="fw-semibold">{{ $order->created_at->format('d M Y, H:i') }}</div>
                    </div>
                    <div class="mb-2">
                        <div class="text-muted small">Payment Method</div>
                        <div class="fw-bold text-dark">
                            @if($order->payment_method == 'bank_transfer') Bank Transfer
                            @elseif($order->payment_method == 'cod') Cash On Delivery
                            @elseif($order->payment_method == 'e_wallet') Rekber / E-Wallet
                            @else {{ $order->payment_method }}
                            @endif
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="text-muted small">Payment Status</div>
                        @if($order->payment_status == 'paid')
                            <span class="badge bg-success">PAID</span>
                        @else
                            <span class="badge bg-warning text-dark">UNPAID</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-3">
                <div class="card-header bg-white">
                    <h6 class="mb-0 fw-bold">Shipping Details</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="text-muted small">Recipient</div>
                        <div class="fw-semibold">{{ $order->shipping_name }}</div>
                    </div>
                    <div class="mb-3">
                        <div class="text-muted small">Address</div>
                        <div>{{ $order->shipping_address }}</div>
                        <div>{{ $order->shipping_city }}, {{ $order->shipping_province }} {{ $order->shipping_postal_code }}</div>
                    </div>
                    @if($order->shipping_phone)
                        <div class="mb-2">
                            <div class="text-muted small">Phone</div>
                            <div>{{ $order->shipping_phone }}</div>
                        </div>
                    @endif
                    @if($order->notes)
                        <div class="mt-3 pt-3 border-top">
                            <div class="text-muted small">Notes</div>
                            <div class="fst-italic">"{{ $order->notes }}"</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Pembayaran -->
<div class="modal fade" id="confirmPaymentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-check-circle me-2"></i>Konfirmasi Pembayaran</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('orders.confirmPayment', $order) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <strong><i class="bi bi-info-circle me-2"></i>Perhatian!</strong><br>
                        Anda mengkonfirmasi bahwa pembayaran sebesar <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong> 
                        sudah dilakukan melalui <strong>{{ $order->payment_method == 'bank_transfer' ? 'Bank Transfer' : 'E-Wallet' }}</strong>.
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Nomor Referensi Transfer <span class="text-danger">*</span></label>
                        <input type="text" name="reference_number" class="form-control" placeholder="Contoh: TRF20260126001" required>
                        <small class="text-muted">Masukkan nomor referensi atau bukti transfer Anda</small>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="agreeCheck" name="agree" required>
                            <label class="form-check-label" for="agreeCheck">
                                Saya menyatakan bahwa pembayaran sudah dilakukan sesuai dengan detail rekening yang diberikan
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-2"></i>Konfirmasi Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection