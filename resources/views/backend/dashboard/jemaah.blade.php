@extends('backend.master')

@section('content')
<div class="container-fluid">

    {{-- Page Title --}}
    <div class="page-title-box">
        <div>
            <h4>Dashboard Jemaah</h4>
            <ol class="breadcrumb p-0 m-0">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </div>

    @php
    $user = auth()->user();
    $person = $user->userable; // ambil dari userable (People)
    $nama = $person->fullname ?? $user->username;

    // Cari jamaah via people_id
    $jamaah = $person ? \App\Models\Jamaah::where('people_id', $person->id)->first() : null;
    $package = $jamaah?->package ?? null;
    $group = $jamaah?->group ?? null;

    $payments = $jamaah?->payments ?? collect();
    $totalPaid = $payments->where('status','paid')->sum('amount');
    $allPaid = $payments->count() > 0 && $payments->every(fn($p) => $p->status === 'paid');
    $hasPaid = $totalPaid > 0;
    $payLabel = $allPaid ? 'Lunas' : ($hasPaid ? 'DP' : 'Belum Bayar');
    $payBadge = $allPaid ? 'success' : ($hasPaid ? 'warning' : 'danger');

    $statusMap = [
    'draft' => ['label' => 'Draft', 'badge' => 'secondary'],
    'booked' => ['label' => 'Terdaftar', 'badge' => 'info'],
    'paid' => ['label' => 'Lunas', 'badge' => 'primary'],
    'documents_verified' => ['label' => 'Dokumen Verified', 'badge' => 'warning'],
    'ready' => ['label' => 'Siap Berangkat', 'badge' => 'success'],
    'departed' => ['label' => 'Sudah Berangkat', 'badge' => 'dark'],
    ];
    $stKey = $jamaah->status ?? 'draft';
    $stLabel = $statusMap[$stKey]['label'] ?? ucfirst($stKey);
    $stBadge = $statusMap[$stKey]['badge'] ?? 'secondary';

    $departure = $jamaah?->departure_date
    ? \Carbon\Carbon::parse($jamaah->departure_date)
    : null;
    $hariLagi = $departure ? now()->diffInDays($departure, false) : null;
    @endphp 

    {{-- Welcome Banner --}}
    <div class="alert border-0 mb-4" style="background:linear-gradient(135deg,#667eea,#764ba2);color:#fff;">
        <h5 class="mb-1"><i class="mdi mdi-hand-wave mr-2"></i>Assalamu'alaikum, {{ $nama }}! 🕌</h5>
        <p class="mb-0 small">Semoga ibadah Umrah/Haji kamu dimudahkan. Berikut informasi perjalananmu.</p>
    </div>

    {{-- Stats Cards --}}
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded mr-3 d-flex align-items-center justify-content-center text-primary"
                            style="width:50px;height:50px;background:rgba(52,144,220,0.15);">
                            <i class="mdi mdi-ticket-confirmation" style="font-size:24px;"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 font-weight-bold">{{ $jamaah->registration_number ?? '-' }}</h6>
                            <p class="text-muted mb-0 small">No. Registrasi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded mr-3 d-flex align-items-center justify-content-center text-{{ $payBadge }}"
                            style="width:50px;height:50px;background:rgba(0,0,0,0.06);">
                            <i class="mdi mdi-cash-check" style="font-size:24px;"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 font-weight-bold">
                                <span class="badge badge-{{ $payBadge }}">{{ $payLabel }}</span>
                            </h6>
                            <p class="text-muted mb-0 small">Status Pembayaran</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded mr-3 d-flex align-items-center justify-content-center text-info"
                            style="width:50px;height:50px;background:rgba(54,185,204,0.15);">
                            <i class="mdi mdi-airplane-takeoff" style="font-size:24px;"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 font-weight-bold">
                                {{ $departure ? $departure->format('d M Y') : '-' }}
                            </h6>
                            <p class="text-muted mb-0 small">Tanggal Berangkat</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded mr-3 d-flex align-items-center justify-content-center text-{{ $hariLagi > 0 ? 'success' : 'danger' }}"
                            style="width:50px;height:50px;background:rgba(28,200,138,0.15);">
                            <i class="mdi mdi-timer-sand" style="font-size:24px;"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 font-weight-bold">
                                @if($hariLagi === null) -
                                @elseif($hariLagi > 0) {{ $hariLagi }} hari
                                @else Sudah Berangkat
                                @endif
                            </h4>
                            <p class="text-muted mb-0 small">Hari Lagi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        {{-- Info Booking --}}
        <div class="col-lg-5">
            <div class="card m-b-20">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="mdi mdi-clipboard-list mr-1"></i> Info Booking Saya</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted small" width="40%">Nama Lengkap</td>
                            <td class="small font-weight-semibold">{{ $person->fullname ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted small">No. Telepon</td>
                            <td class="small">{{ $person->phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted small">Email</td>
                            <td class="small">{{ auth()->user()->email }}</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <hr class="my-1">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted small">Paket</td>
                            <td class="small font-weight-semibold">{{ $package->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted small">Tipe</td>
                            <td><span class="badge badge-info small">{{ strtoupper($package->type ?? '-') }}</span></td>
                        </tr>
                        <tr>
                            <td class="text-muted small">Grup</td>
                            <td class="small">{{ $group->name ?? 'Tanpa Grup' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted small">Keberangkatan</td>
                            <td class="small">{{ $departure ? $departure->format('d M Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted small">Status</td>
                            <td><span class="badge badge-{{ $stBadge }}">{{ $stLabel }}</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- Detail Paket --}}
        <div class="col-lg-7">
            <div class="card m-b-20">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="mdi mdi-bag-suitcase mr-1"></i> Detail Paket</h5>
                </div>
                <div class="card-body">
                    @if($package)
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="mb-1">{{ $package->name }}</h5>
                            <span class="badge badge-info mr-1">{{ strtoupper($package->type) }}</span>
                            <span class="badge badge-success">{{ ucfirst($package->status) }}</span>
                        </div>
                        <h5 class="text-primary mb-0">Rp {{ number_format($package->price, 0, ',', '.') }}</h5>
                    </div>
                    <p class="text-muted small mb-3">{{ $package->description ?? 'Tidak ada deskripsi.' }}</p>
                    <hr>
                    <div class="row text-center">
                        <div class="col-4">
                            <p class="text-muted small mb-1">Durasi</p>
                            <p class="font-weight-bold mb-0">{{ $package->duration_days ?? '-' }} Hari</p>
                        </div>
                        <div class="col-4">
                            <p class="text-muted small mb-1">Hotel Makkah</p>
                            <p class="font-weight-bold mb-0 small">{{ $package->hotel_makkah ?? '-' }}</p>
                        </div>
                        <div class="col-4">
                            <p class="text-muted small mb-1">Hotel Madinah</p>
                            <p class="font-weight-bold mb-0 small">{{ $package->hotel_madinah ?? '-' }}</p>
                        </div>
                    </div>
                    @else
                    <p class="text-muted text-center py-3">Belum ada paket yang dipilih.</p>
                    @endif
                </div>
            </div>

            {{-- Riwayat Pembayaran --}}
            <div class="card m-b-20">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="mdi mdi-cash-multiple mr-1"></i> Riwayat Pembayaran</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payments as $i => $pay)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td class="small">{{ \Carbon\Carbon::parse($pay->created_at)->format('d M Y') }}</td>
                                    <td class="small font-weight-semibold">Rp {{ number_format($pay->amount, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge badge-{{ $pay->status === 'paid' ? 'success' : 'warning' }}">
                                            {{ ucfirst($pay->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">Belum ada pembayaran</td>
                                </tr>
                                @endforelse
                            </tbody>
                            @if($payments->count() > 0)
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="2" class="text-right small font-weight-bold">Total Dibayar:</td>
                                    <td class="small font-weight-bold text-success">Rp {{ number_format($totalPaid, 0, ',', '.') }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection