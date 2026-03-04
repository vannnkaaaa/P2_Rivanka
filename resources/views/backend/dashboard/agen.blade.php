@extends('backend.master')

@section('content')
<div class="container-fluid">

    {{-- Page Title --}}
    <div class="page-title-box">
        <div>
            <h4>Dashboard Agen</h4>
            <ol class="breadcrumb p-0 m-0">
                <li class="breadcrumb-item"><a href="{{ route('agent.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </div>

    @php
    $agent = auth()->user()->userable ?? null;
    $person = $agent->people ?? null;
    $nama = $person->fullname ?? auth()->user()->username;
    @endphp

    {{-- Welcome Banner --}}
    <div class="alert border-0 mb-4" style="background:linear-gradient(135deg,#1abc9c,#16a085);color:#fff;">
        <h5 class="mb-1"><i class="mdi mdi-hand-wave mr-2"></i>Selamat Datang, {{ $nama }}! 👋</h5>
        <p class="mb-0 small">Berikut ringkasan aktivitas jemaah yang kamu kelola.</p>
    </div>

    {{-- Stats Cards --}}
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded mr-3 d-flex align-items-center justify-content-center text-primary"
                            style="width:50px;height:50px;background:rgba(52,144,220,0.15);">
                            <i class="mdi mdi-account-group" style="font-size:24px;"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 font-weight-bold">{{ $totalJemaah ?? 0 }}</h4>
                            <p class="text-muted mb-0 small">Total Jemaah</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded mr-3 d-flex align-items-center justify-content-center text-success"
                            style="width:50px;height:50px;background:rgba(28,200,138,0.15);">
                            <i class="mdi mdi-check-circle" style="font-size:24px;"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 font-weight-bold">{{ $jemaahLunas ?? 0 }}</h4>
                            <p class="text-muted mb-0 small">Pembayaran Lunas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded mr-3 d-flex align-items-center justify-content-center text-warning"
                            style="width:50px;height:50px;background:rgba(246,194,62,0.15);">
                            <i class="mdi mdi-clock-alert" style="font-size:24px;"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 font-weight-bold">{{ $jemaahBelumLunas ?? 0 }}</h4>
                            <p class="text-muted mb-0 small">Belum Lunas</p>
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
                            <i class="mdi mdi-airplane" style="font-size:24px;"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 font-weight-bold">{{ $paketAktif ?? 0 }}</h4>
                            <p class="text-muted mb-0 small">Paket Aktif</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        {{-- Profil Agen --}}
        <div class="col-lg-4">
            <div class="card m-b-20">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="mdi mdi-account-card-details mr-1"></i> Profil Saya</h5>
                </div>
                <div class="card-body text-center">
                    @php
                    $palette = ['#8b5cf6','#4f46e5','#3b82f6','#ec4899','#10b981','#f59e0b'];
                    $bg = $palette[abs(crc32($nama)) % count($palette)];
                    $parts = explode(' ', trim($nama));
                    $initials = strtoupper(substr($parts[0],0,1).(isset($parts[1]) ? substr($parts[1],0,1) : ''));
                    @endphp
                    <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center text-white font-weight-bold"
                        style="width:72px;height:72px;background:{{ $bg }};font-size:26px;">
                        {{ $initials }}
                    </div>
                    <h5 class="mb-1">{{ $nama }}</h5>
                    <p class="text-muted small mb-3">{{ auth()->user()->email }}</p>
                    <hr>
                    <div class="text-left">
                        <p class="mb-2 small"><i class="mdi mdi-domain mr-1 text-muted"></i><strong>Perusahaan:</strong> {{ $agent->company->name ?? '-' }}</p>
                        <p class="mb-2 small"><i class="mdi mdi-office-building mr-1 text-muted"></i><strong>Cabang:</strong> {{ $agent->office->name ?? '-' }}</p>
                        <p class="mb-2 small"><i class="mdi mdi-certificate mr-1 text-muted"></i><strong>No. PPIU:</strong> {{ $agent->ppiu_license_number ?? '-' }}</p>
                        <p class="mb-2 small"><i class="mdi mdi-certificate mr-1 text-muted"></i><strong>No. PIHK:</strong> {{ $agent->pihk_license_number ?? '-' }}</p>
                        <p class="mb-0 small"><i class="mdi mdi-phone mr-1 text-muted"></i><strong>Telepon:</strong> {{ $person->phone ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Jemaah Terbaru --}}
        <div class="col-lg-8">
            <div class="card m-b-20">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0"><i class="mdi mdi-account-multiple mr-1"></i> Jemaah Saya</h5>
                    <a href="{{ route('jemaah.tabel') }}" class="btn btn-sm btn-primary">
                        <i class="mdi mdi-eye mr-1"></i> Lihat Semua
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Paket</th>
                                    <th>Keberangkatan</th>
                                    <th>Bayar</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentJemaah ?? [] as $i => $j)
                                @php
                                $payments = $j->payments;
                                $allPaid = $payments->count() > 0 && $payments->every(fn($p) => $p->status === 'paid');
                                $hasPaid = $payments->where('status','paid')->sum('amount') > 0;
                                $payLabel = $allPaid ? 'Lunas' : ($hasPaid ? 'DP' : 'Belum');
                                $payBadge = $allPaid ? 'success' : ($hasPaid ? 'warning' : 'danger');
                                $stBadge = ['draft'=>'secondary','booked'=>'info','paid'=>'primary','documents_verified'=>'warning','ready'=>'success','departed'=>'dark'][$j->status ?? 'draft'] ?? 'secondary';
                                @endphp
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>
                                        <div class="font-weight-semibold small">{{ $j->people->fullname ?? '-' }}</div>
                                        <div class="text-muted" style="font-size:11px;">{{ $j->people->phone ?? '' }}</div>
                                    </td>
                                    <td class="small">{{ $j->package->name ?? '-' }}</td>
                                    <td class="small text-muted">
                                        {{ $j->departure_date ? \Carbon\Carbon::parse($j->departure_date)->format('d M Y') : '-' }}
                                    </td>
                                    <td><span class="badge badge-{{ $payBadge }}">{{ $payLabel }}</span></td>
                                    <td><span class="badge badge-{{ $stBadge }}">{{ ucfirst(str_replace('_',' ',$j->status ?? '-')) }}</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-3">Belum ada jemaah</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Paket Tersedia --}}
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="mdi mdi-bag-suitcase mr-1"></i> Paket Tersedia</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nama Paket</th>
                                    <th>Tipe</th>
                                    <th>Harga</th>
                                    <th>Keberangkatan</th>
                                    <th>Sisa Seat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($packages ?? [] as $i => $p)
                                @php $sisa = $p->quota - $p->quota_used; @endphp
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td class="font-weight-semibold small">{{ $p->name }}</td>
                                    <td><span class="badge badge-info">{{ strtoupper($p->type) }}</span></td>
                                    <td class="small">Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                                    <td class="small text-muted">
                                        {{ $p->departure_date ? \Carbon\Carbon::parse($p->departure_date)->format('d M Y') : '-' }}
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $sisa <= 10 ? 'warning' : 'success' }}">
                                            {{ $sisa }} seat
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('package.view', [$p->type, $p->id]) }}"
                                            class="btn btn-xs btn-outline-info mr-1">
                                            <i class="mdi mdi-eye"></i> Detail
                                        </a>
                                        @if($sisa > 0)
                                        <a href="{{ route('package.booking', [$p->type, $p->id]) }}"
                                            class="btn btn-xs btn-primary">
                                            <i class="mdi mdi-calendar-check"></i> Booking
                                        </a>
                                        @else
                                        <span class="btn btn-xs btn-secondary disabled">Penuh</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-3">Tidak ada paket aktif</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection