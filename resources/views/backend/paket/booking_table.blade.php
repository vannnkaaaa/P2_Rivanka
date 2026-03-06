@extends('backend.master')

@section('content')
<div class="container-fluid">

    <div class="page-title-box">
        <div>
            <h4>Semua Booking</h4>
            <ol class="breadcrumb p-0 m-0">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Booking</li>
            </ol>
        </div>
    </div>

    <div class="card m-b-30">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="header-title mt-0">Daftar Booking</h5>
                    <p class="text-muted mb-0">Kelola semua data booking jemaah</p>
                </div>
                <input type="text" id="searchInput" class="form-control form-control-sm"
                    placeholder="Cari nama, no. registrasi..." style="width:240px;">
            </div>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>No. Registrasi</th>
                            <th>Nama Jamaah</th>
                            <th>Paket</th>
                            <th>Agent</th>
                            <th>Keberangkatan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @forelse($jamaahs as $index => $jamaah)
                        @php
                        $fullname = $jamaah->people->fullname ?? '-';
                        $package = $jamaah->package->name ?? '-';
                        $agent = $jamaah->agent->people->fullname ?? '-';
                        $departure = $jamaah->departure_date
                        ? \Carbon\Carbon::parse($jamaah->departure_date)->format('d M Y') : '-';

                        
                        // Pembayaran
                        $payments = $jamaah->payments ?? collect();
                        $totalPaid = $payments->where('status','paid')->sum('amount');
                        $allPaid = $payments->count() > 0 && $payments->every(fn($p) => $p->status === 'paid');
                        $hasPaid = $totalPaid > 0;

                        // Status
                        $status_map = [
                        'draft' => 'secondary',
                        'booked' => 'info',
                        'paid' => 'primary',
                        'documents_verified' => 'warning',
                        'ready' => 'success',
                        'departed' => 'dark',
                        ];
                        $badge = $status_map[$jamaah->status ?? 'draft'] ?? 'secondary';
                        $label = ucfirst(str_replace('_', ' ', $jamaah->status ?? 'draft'));
                        @endphp
                        <tr data-name="{{ strtolower($fullname) }}"
                            data-reg="{{ strtolower($jamaah->registration_number ?? '') }}">
                            <td>{{ $index + 1 }}</td>
                            <td><code class="small">{{ $jamaah->registration_number ?? '-' }}</code></td>
                            <td class="small font-weight-semibold">{{ $fullname }}</td>
                            <td class="small">{{ $package }}</td>
                            <td class="small text-muted">{{ $agent }}</td>
                            <td class="small text-muted">{{ $departure }}</td>
                            <td><span class="badge badge-{{ $badge }}">{{ $label }}</span></td>
                            <td>
                                <a href="{{ route('booking.show', $jamaah->id) }}" class="btn btn-info btn-xs mr-1">
                                    <i class="mdi mdi-eye"></i>
                                </a>
                                <button class="btn btn-warning btn-xs" data-toggle="modal"
                                    data-target="#modalUpdateStatus{{ $jamaah->id }}">
                                    <i class="mdi mdi-pencil"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">Belum ada data booking</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-2">
                <small class="text-muted">Menampilkan <strong id="showCount">{{ $jamaahs->count() }}</strong> data</small>
            </div>

        </div>
    </div>

    {{-- Modal View & Update Status --}}
    @foreach($jamaahs as $jamaah)
    @php
    $person = $jamaah->people;
    $payments = $jamaah->payments ?? collect();
    $totalPaid = $payments->where('status','paid')->sum('amount');
    @endphp

    {{-- Modal View --}}
    <div class="modal fade" id="modalViewBooking{{ $jamaah->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title"><i class="mdi mdi-eye mr-1"></i> Detail Booking</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>No. Registrasi:</strong> <code>{{ $jamaah->registration_number ?? '-' }}</code></p>
                            <p><strong>Nama:</strong> {{ $person->fullname ?? '-' }}</p>
                            <p><strong>Telepon:</strong> {{ $person->phone ?? '-' }}</p>
                            <p><strong>Alamat:</strong> {{ $person->address ?? '-' }}</p>
                            <p><strong>Agent:</strong> {{ $jamaah->agent->people->fullname ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Paket:</strong> {{ $jamaah->package->name ?? '-' }}</p>
                            <p><strong>Keberangkatan:</strong>
                                {{ $jamaah->departure_date ? \Carbon\Carbon::parse($jamaah->departure_date)->format('d M Y') : '-' }}
                            </p>
                            <p><strong>Total Dibayar:</strong> Rp {{ number_format($totalPaid) }}</p>
                            <p><strong>Status:</strong>
                                <span class="badge badge-{{ ['draft'=>'secondary','booked'=>'info','paid'=>'primary','documents_verified'=>'warning','ready'=>'success','departed'=>'dark'][$jamaah->status ?? 'draft'] ?? 'secondary' }}">
                                    {{ ucfirst(str_replace('_',' ', $jamaah->status ?? '-')) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    @if($payments->count() > 0)
                    <h6 class="mt-3 border-top pt-3">Riwayat Pembayaran</h6>
                    <table class="table table-sm table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $i => $pay)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td class="small">{{ \Carbon\Carbon::parse($pay->created_at)->format('d M Y') }}</td>
                                <td class="small">Rp {{ number_format($pay->amount) }}</td>
                                <td><span class="badge badge-{{ $pay->status === 'paid' ? 'success' : 'warning' }}">{{ ucfirst($pay->status) }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Update Status --}}
    <div class="modal fade" id="modalUpdateStatus{{ $jamaah->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title"><i class="mdi mdi-pencil mr-1"></i> Update Status</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="updateStatusForm{{ $jamaah->id }}" method="POST"
                        action="{{ route('booking.update-status', $jamaah->id) }}">
                        @csrf @method('PATCH')
                        <div class="form-group">
                            <label>Status Booking</label>
                            <select name="status" class="form-control" required>
                                @foreach(['draft'=>'Draft','booked'=>'Terdaftar','paid'=>'Lunas','documents_verified'=>'Dokumen Verified','ready'=>'Siap Berangkat','departed'=>'Sudah Berangkat'] as $val => $lbl)
                                <option value="{{ $val }}" {{ $jamaah->status === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" form="updateStatusForm{{ $jamaah->id }}" class="btn btn-warning">Update</button>
                </div>
            </div>
        </div>
    </div>

    @endforeach

</div>

@push('scripts')
<script>
    document.getElementById('searchInput').addEventListener('input', function() {
        var q = this.value.toLowerCase();
        var rows = document.querySelectorAll('#tableBody tr[data-name]');
        var count = 0;
        rows.forEach(function(row) {
            var match = row.dataset.name.includes(q) || row.dataset.reg.includes(q);
            row.style.display = match ? '' : 'none';
            if (match) count++;
        });
        document.getElementById('showCount').textContent = count;
    });
</script>
@endpush
@endsection