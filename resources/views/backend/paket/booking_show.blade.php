@extends('backend.master')

@section('content')
<div class="container-fluid">

    <div class="page-title-box">
        <div>
            <h4>Detail Booking</h4>
            <ol class="breadcrumb p-0 m-0">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('booking.tabel') }}">Booking</a></li>
                <li class="breadcrumb-item active">{{ $jamaah->registration_number }}</li>
            </ol>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
    @endif

    <div class="row">

        {{-- Kolom Kiri --}}
        <div class="col-lg-8">

            {{-- Info Utama --}}
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">
                            <i class="mdi mdi-account-circle mr-1 text-primary"></i>
                            Informasi Jamaah
                        </h5>
                        <div>
                            <span class="badge badge-{{ ['draft'=>'secondary','booked'=>'info','paid'=>'primary','documents_verified'=>'warning','ready'=>'success','departed'=>'dark'][$jamaah->status ?? 'draft'] ?? 'secondary' }} mr-2">
                                {{ ucfirst(str_replace('_',' ', $jamaah->status ?? '-')) }}
                            </span>
                            <code class="small">{{ $jamaah->registration_number ?? '-' }}</code>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <th width="140" class="text-muted small">Nama Lengkap</th>
                                    <td class="small">{{ $jamaah->people->fullname ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted small">No. Telepon</th>
                                    <td class="small">{{ $jamaah->people->phone ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted small">Jenis Kelamin</th>
                                    <td class="small">{{ ($jamaah->people->gender ?? '') == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted small">Tempat Lahir</th>
                                    <td class="small">{{ $jamaah->people->birth_place ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted small">Tanggal Lahir</th>
                                    <td class="small">{{ $jamaah->people->birth_date ? \Carbon\Carbon::parse($jamaah->people->birth_date)->format('d M Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted small">Alamat</th>
                                    <td class="small">{{ $jamaah->people->address ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <th width="140" class="text-muted small">Paket</th>
                                    <td class="small">{{ $jamaah->package->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted small">Tipe Paket</th>
                                    <td class="small">{{ strtoupper($jamaah->package->type ?? '-') }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted small">Grup</th>
                                    <td class="small">{{ $jamaah->group->name ?? 'Tanpa Grup' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted small">Agent</th>
                                    <td class="small">{{ $jamaah->agent->people->fullname ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted small">Keberangkatan</th>
                                    <td class="small">{{ $jamaah->departure_date ? \Carbon\Carbon::parse($jamaah->departure_date)->format('d M Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted small">Terdaftar</th>
                                    <td class="small">{{ $jamaah->created_at->format('d M Y') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Jamaah Sebatch --}}
            @if($batchJamaahs->count() > 1)
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        <i class="mdi mdi-account-group mr-1 text-primary"></i>
                        Jamaah dalam 1 Booking ({{ $batchJamaahs->count() }} orang)
                    </h5>
                    <table class="table table-sm table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>No. Registrasi</th>
                                <th>Nama</th>
                                <th>Telepon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($batchJamaahs as $i => $bj)
                            <tr class="{{ $bj->id === $jamaah->id ? 'table-primary' : '' }}">
                                <td>{{ $i + 1 }}</td>
                                <td><code class="small">{{ $bj->registration_number }}</code></td>
                                <td class="small">{{ $bj->people->fullname ?? '-' }}</td>
                                <td class="small">{{ $bj->people->phone ?? '-' }}</td>
                                <td>
                                    @if($bj->id !== $jamaah->id)
                                    <a href="{{ route('booking.show', $bj->id) }}" class="btn btn-xs btn-info">
                                        <i class="mdi mdi-eye"></i>
                                    </a>
                                    @else
                                    <span class="badge badge-primary">Ini</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            {{-- Pembayaran --}}
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        <i class="mdi mdi-cash-multiple mr-1 text-success"></i> Riwayat Pembayaran
                    </h5>
                    @if($jamaah->payments && $jamaah->payments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th>Tipe</th>
                                    <th>Metode</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jamaah->payments as $i => $pay)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td class="small">{{ $pay->payment_date ? \Carbon\Carbon::parse($pay->payment_date)->format('d M Y') : '-' }}</td>
                                    <td class="small">{{ ucfirst($pay->payment_type ?? '-') }}</td>
                                    <td class="small">{{ $pay->paymentMethod->name ?? '-' }}</td>
                                    <td class="small font-weight-semibold">Rp {{ number_format($pay->amount) }}</td>
                                    <td><span class="badge badge-{{ $pay->status === 'paid' ? 'success' : 'warning' }}">{{ ucfirst($pay->status) }}</span></td>
                                    <td class="small text-muted">{{ $pay->notes ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="thead-light">
                                <tr>
                                    <td colspan="4" class="text-right font-weight-bold small">Total Dibayar</td>
                                    <td class="font-weight-bold small text-success">Rp {{ number_format($jamaah->payments->where('status','paid')->sum('amount')) }}</td>
                                    <td colspan="2"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    @else
                    <p class="text-muted small">Belum ada pembayaran.</p>
                    @endif
                </div>
            </div>

            {{-- Dokumen --}}
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        <i class="mdi mdi-file-document mr-1 text-warning"></i> Dokumen
                    </h5>
                    @if($jamaah->documents && $jamaah->documents->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Tipe Dokumen</th>
                                    <th>Tgl Terbit</th>
                                    <th>Tgl Expired</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jamaah->documents as $i => $doc)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td class="small">{{ ucfirst(str_replace('_',' ', $doc->document_type)) }}</td>
                                    <td class="small">{{ $doc->issued_date ? \Carbon\Carbon::parse($doc->issued_date)->format('d M Y') : '-' }}</td>
                                    <td class="small">
                                        @if($doc->expiry_date)
                                        @php $exp = \Carbon\Carbon::parse($doc->expiry_date); @endphp
                                        <span class="{{ $exp->isPast() ? 'text-danger' : '' }}">
                                            {{ $exp->format('d M Y') }}
                                            {{ $exp->isPast() ? '(Expired)' : '' }}
                                        </span>
                                        @else -
                                        @endif
                                    </td>
                                    <td class="small text-muted">{{ $doc->notes ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-muted small">Belum ada dokumen.</p>
                    @endif
                </div>
            </div>

            {{-- Kesehatan --}}
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        <i class="mdi mdi-heart-pulse mr-1 text-danger"></i> Riwayat Kesehatan
                    </h5>
                    @if($jamaah->health && $jamaah->health->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Tipe</th>
                                    <th>Deskripsi</th>
                                    <th>Tanggal Dicatat</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jamaah->health as $i => $health)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td class="small">{{ ucfirst(str_replace('_',' ', $health->health_type)) }}</td>
                                    <td class="small">{{ $health->description ?? '-' }}</td>
                                    <td class="small">{{ $health->recorded_at ? \Carbon\Carbon::parse($health->recorded_at)->format('d M Y') : '-' }}</td>
                                    <td class="small text-muted">{{ $health->notes ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-muted small">Belum ada data kesehatan.</p>
                    @endif
                </div>
            </div>

        </div>

        {{-- Kolom Kanan --}}
        <div class="col-lg-4">

            {{-- Update Status --}}
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        <i class="mdi mdi-update mr-1 text-warning"></i> Update Status
                    </h5>
                    <form method="POST" action="{{ route('booking.update-status', $jamaah->id) }}">
                        @csrf @method('PATCH')
                        <div class="form-group">
                            <select name="status" class="form-control" required>
                                @foreach(['draft'=>'Draft','booked'=>'Terdaftar','paid'=>'Lunas','documents_verified'=>'Dokumen Verified','ready'=>'Siap Berangkat','departed'=>'Sudah Berangkat'] as $val => $lbl)
                                <option value="{{ $val }}" {{ $jamaah->status === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-warning btn-block btn-sm">Update Status</button>
                    </form>
                </div>
            </div>

            {{-- Ringkasan Pembayaran --}}
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        <i class="mdi mdi-cash mr-1 text-success"></i> Ringkasan Pembayaran
                    </h5>
                    @php
                    $payments = $jamaah->payments ?? collect();
                    $totalPaid = $payments->where('status','paid')->sum('amount');
                    $hargaPaket = $jamaah->package->price ?? 0;
                    $sisaBayar = max(0, $hargaPaket - $totalPaid);
                    $allPaid = $hargaPaket > 0 && $totalPaid >= $hargaPaket;
                    @endphp
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td class="text-muted small">Harga Paket</td>
                            <td class="small font-weight-semibold text-right">Rp {{ number_format($hargaPaket) }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted small">Total Dibayar</td>
                            <td class="small font-weight-semibold text-success text-right">Rp {{ number_format($totalPaid) }}</td>
                        </tr>
                        <tr class="border-top">
                            <td class="small font-weight-bold">Sisa Bayar</td>
                            <td class="small font-weight-bold text-{{ $allPaid ? 'success' : 'danger' }} text-right">
                                {{ $allPaid ? 'LUNAS' : 'Rp ' . number_format($sisaBayar) }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Info Paket --}}
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        <i class="mdi mdi-package-variant mr-1 text-primary"></i> Info Paket
                    </h5>
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td class="text-muted small">Nama</td>
                            <td class="small">{{ $jamaah->package->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted small">Tipe</td>
                            <td class="small">{{ strtoupper($jamaah->package->type ?? '-') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted small">Durasi</td>
                            <td class="small">{{ $jamaah->package->program_days ?? '-' }} Hari</td>
                        </tr>
                        <tr>
                            <td class="text-muted small">Maskapai</td>
                            <td class="small">{{ $jamaah->package->airline ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted small">Keberangkatan</td>
                            <td class="small">{{ $jamaah->departure_date ? \Carbon\Carbon::parse($jamaah->departure_date)->format('d M Y') : '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <a href="{{ route('booking.tabel') }}" class="btn btn-secondary btn-block btn-sm">
                <i class="mdi mdi-arrow-left mr-1"></i> Kembali ke Daftar
            </a>

        </div>
    </div>



</div>
@endsection