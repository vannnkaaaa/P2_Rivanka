@extends('backend.master')

@section('content')
<div class="container-fluid">

    {{-- Page Title --}}
    <div class="page-title-box">
        <div>
            <h4>Management Jemaah</h4>
            <ol class="breadcrumb p-0 m-0">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item">Management User</li>
                <li class="breadcrumb-item active">Jemaah</li>
            </ol>
        </div>
    </div>

    <div class="card m-b-30">
        <div class="card-body">

            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="header-title mt-0">Daftar Jemaah</h5>
                    <p class="text-muted mb-0">Kelola semua data jemaah travel</p>
                </div>
                <div class="d-flex align-items-center">
                    <input type="text" id="searchInput" class="form-control form-control-sm mr-2"
                        placeholder="Cari nama, no. registrasi..." style="width:220px;">
                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalAddJemaah">
                        <i class="mdi mdi-plus"></i> Tambah Jemaah
                    </button>
                </div>
            </div>

            {{-- Filter Status --}}
            <div class="mb-3">
                <button class="btn btn-sm btn-primary mr-1 tab-btn active" onclick="filterTab(this,'all')">
                    Semua <span class="badge badge-light text-dark">{{ $jamaahs->count() }}</span>
                </button>
                @foreach(['draft','booked','paid','documents_verified','ready','departed'] as $st)
                <button class="btn btn-sm btn-outline-secondary mr-1 tab-btn" onclick="filterTab(this,'{{ $st }}')">
                    {{ ucfirst(str_replace('_',' ',$st)) }}
                    <span class="badge badge-light text-dark">{{ $jamaahs->where('status',$st)->count() }}</span>
                </button>
                @endforeach
            </div>

            {{-- Alerts --}}
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

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th width="40"><input type="checkbox" onchange="toggleAll(this)"></th>
                            <th>#</th>
                            <th>Jemaah</th>
                            <th>No. Registrasi</th>
                            <th>Paket</th>
                            <th>Grup</th>
                            <th>Keberangkatan</th>
                            <th>Pembayaran</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @forelse ($jamaahs as $index => $jamaah)
                        @php
                            $person     = $jamaah->people;
                            $fullname   = $person->fullname ?? '-';
                            $phone      = $person->phone ?? '-';
                            $reg_number = $jamaah->registration_number ?? '-';
                            $departure  = $jamaah->departure_date
                                ? \Carbon\Carbon::parse($jamaah->departure_date)->format('d M Y')
                                : '-';
                            $group_name  = $jamaah->group->name ?? 'Tanpa Grup';
                            $package_name = $jamaah->package->name ?? '-';

                            $status_map = [
                                'draft'               => 'secondary',
                                'booked'              => 'info',
                                'paid'                => 'primary',
                                'documents_verified'  => 'warning',
                                'ready'               => 'success',
                                'departed'            => 'dark',
                            ];
                            $status_badge = $status_map[$jamaah->status ?? 'draft'] ?? 'secondary';
                            $status_label = ucfirst(str_replace('_', ' ', $jamaah->status ?? 'draft'));

                            $payments  = $jamaah->payments;
                            $total_paid = $payments->where('status','paid')->sum('amount');
                            $all_paid   = $payments->count() > 0 && $payments->every(fn($p) => $p->status === 'paid');
                            $has_paid   = $total_paid > 0;
                            $pay_label  = $all_paid ? 'Lunas' : ($has_paid ? 'DP' : 'Belum Bayar');
                            $pay_badge  = $all_paid ? 'success' : ($has_paid ? 'warning' : 'danger');

                            $palette   = ['#8b5cf6','#4f46e5','#3b82f6','#ec4899','#10b981','#f59e0b','#6366f1'];
                            $avatar_bg = $palette[abs(crc32($fullname)) % count($palette)];
                            $parts     = explode(' ', trim($fullname));
                            $initials  = strtoupper(substr($parts[0],0,1).(isset($parts[1]) ? substr($parts[1],0,1) : ''));
                        @endphp
                        <tr data-status="{{ $jamaah->status }}"
                            data-name="{{ strtolower($fullname) }}"
                            data-reg="{{ strtolower($reg_number) }}">
                            <td><input type="checkbox" class="row-check"></td>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle mr-2 d-flex align-items-center justify-content-center text-white font-weight-bold"
                                        style="width:38px;height:38px;background:{{ $avatar_bg }};font-size:14px;flex-shrink:0;">
                                        {{ $initials }}
                                    </div>
                                    <div>
                                        <div class="font-weight-semibold small text-dark">{{ $fullname }}</div>
                                        <div class="text-muted small"><i class="mdi mdi-phone"></i> {{ $phone }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><code class="small">{{ $reg_number }}</code></td>
                            <td class="small">{{ $package_name }}</td>
                            <td class="small">{{ $group_name }}</td>
                            <td class="text-muted small">{{ $departure }}</td>
                            <td><span class="badge badge-{{ $pay_badge }}">{{ $pay_label }}</span></td>
                            <td><span class="badge badge-{{ $status_badge }}">{{ $status_label }}</span></td>
                            <td>
                                <button class="btn btn-info btn-xs mr-1" data-toggle="modal"
                                    data-target="#modalViewJamaah{{ $jamaah->id }}">
                                    <i class="mdi mdi-eye"></i>
                                </button>
                                <button class="btn btn-warning btn-xs mr-1" data-toggle="modal"
                                    data-target="#modalUpdateJamaah{{ $jamaah->id }}">
                                    <i class="mdi mdi-pencil"></i>
                                </button>
                                <button class="btn btn-danger btn-xs"
                                    data-id="{{ $jamaah->id }}"
                                    data-name="{{ $fullname }}"
                                    onclick="confirmDelete(this)">
                                    <i class="mdi mdi-delete"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">Belum ada data jemaah</td>
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

    {{-- ===== MODAL TAMBAH JEMAAH ===== --}}
    <div class="modal fade" id="modalAddJemaah" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="mdi mdi-account-plus mr-1"></i> Tambah Jemaah Baru</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                    @endif
                    <form id="addJemaahForm" method="POST" action="{{ route('jemaah.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-muted border-bottom pb-2 mb-3">Akun Login</h6>
                                <div class="form-group"><label>Username *</label><input type="text" name="username" class="form-control" required></div>
                                <div class="form-group"><label>Email *</label><input type="email" name="email" class="form-control" required></div>
                                <div class="form-group"><label>Password *</label><input type="password" name="password" class="form-control" required minlength="8"><small class="text-muted">Minimal 8 karakter</small></div>
                                <div class="form-group"><label>Konfirmasi Password *</label><input type="password" name="password_confirmation" class="form-control" required></div>

                                <h6 class="text-muted border-bottom pb-2 mb-3 mt-4">Data Pribadi</h6>
                                <div class="form-group"><label>Nama Lengkap *</label><input type="text" name="fullname" class="form-control" required></div>
                                <div class="form-group"><label>Jenis Kelamin *</label>
                                    <select name="gender" class="form-control" required>
                                        <option value="">Pilih</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group"><label>No. Telepon *</label><input type="tel" name="phone" class="form-control" required placeholder="08xxxxxxxxxx"></div>
                                <div class="form-group"><label>Tempat Lahir *</label><input type="text" name="birth_place" class="form-control" required></div>
                                <div class="form-group"><label>Tanggal Lahir *</label><input type="date" name="birth_date" class="form-control" required></div>
                                <div class="form-group"><label>Alamat *</label><textarea name="address" class="form-control" rows="2" required></textarea></div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted border-bottom pb-2 mb-3">Data Booking</h6>
                                <div class="form-group"><label>Tipe Paket *</label>
                                    <select name="package_type" id="packageType" class="form-control" required>
                                        <option value="">-- Pilih Tipe --</option>
                                        @foreach($package_types as $type)
                                        <option value="{{ strtolower($type) }}">{{ ucfirst($type) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group"><label>Paket *</label>
                                    <select name="package_id" id="packageSelect" class="form-control" required disabled>
                                        <option value="">-- Pilih Tipe Dulu --</option>
                                    </select>
                                </div>
                                <div class="form-group"><label>Grup</label>
                                    <select name="group_id" id="groupSelect" class="form-control" disabled>
                                        <option value="">-- Pilih Paket Dulu --</option>
                                    </select>
                                </div>
                                <div class="form-group"><label>Tanggal Keberangkatan *</label>
                                    <input type="date" name="departure_date" id="departureDate" class="form-control" required>
                                    <small class="text-muted">Otomatis terisi saat memilih paket</small>
                                </div>
                                <div class="form-group"><label>Status *</label>
                                    <select name="status" class="form-control" required>
                                        <option value="draft" selected>Draft</option>
                                        <option value="booked">Booked</option>
                                        <option value="paid">Paid</option>
                                        <option value="documents_verified">Documents Verified</option>
                                        <option value="ready">Ready</option>
                                        <option value="departed">Departed</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" form="addJemaahForm" class="btn btn-success">Simpan Jemaah</button>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== MODAL VIEW & EDIT per jemaah ===== --}}
    @foreach($jamaahs as $jamaah)

    {{-- Modal View --}}
    <div class="modal fade" id="modalViewJamaah{{ $jamaah->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title"><i class="mdi mdi-eye mr-1"></i> Detail Jemaah</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nama:</strong> {{ $jamaah->people->fullname ?? '-' }}</p>
                            <p><strong>Telepon:</strong> {{ $jamaah->people->phone ?? '-' }}</p>
                            <p><strong>Gender:</strong> {{ ($jamaah->people->gender ?? '') == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                            <p><strong>Alamat:</strong> {{ $jamaah->people->address ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>No. Registrasi:</strong> <code>{{ $jamaah->registration_number ?? '-' }}</code></p>
                            <p><strong>Paket:</strong> {{ $jamaah->package->name ?? '-' }}</p>
                            <p><strong>Grup:</strong> {{ $jamaah->group->name ?? 'Tanpa Grup' }}</p>
                            <p><strong>Keberangkatan:</strong>
                                {{ $jamaah->departure_date ? \Carbon\Carbon::parse($jamaah->departure_date)->format('d M Y') : '-' }}
                            </p>
                            <p><strong>Status:</strong>
                                <span class="badge badge-{{ ['draft'=>'secondary','booked'=>'info','paid'=>'primary','documents_verified'=>'warning','ready'=>'success','departed'=>'dark'][$jamaah->status ?? 'draft'] ?? 'secondary' }}">
                                    {{ ucfirst(str_replace('_',' ', $jamaah->status ?? '-')) }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div class="modal fade" id="modalUpdateJamaah{{ $jamaah->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title"><i class="mdi mdi-pencil mr-1"></i> Edit Jemaah</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="updateJamaahForm{{ $jamaah->id }}" method="POST" action="{{ route('jemaah.update', $jamaah->id) }}">
                        @csrf @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-muted border-bottom pb-2 mb-3">Data Pribadi</h6>
                                <div class="form-group"><label>Nama Lengkap *</label><input type="text" name="fullname" class="form-control" value="{{ $jamaah->people->fullname ?? '' }}" required></div>
                                <div class="form-group"><label>No. Telepon *</label><input type="tel" name="phone" class="form-control" value="{{ $jamaah->people->phone ?? '' }}" required></div>
                                <div class="form-group"><label>Alamat</label><textarea name="address" class="form-control" rows="2">{{ $jamaah->people->address ?? '' }}</textarea></div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted border-bottom pb-2 mb-3">Data Booking</h6>
                                <div class="form-group"><label>Paket</label>
                                    <select name="package_id" class="form-control">
                                        @foreach($packages as $p)
                                        <option value="{{ $p->id }}" {{ $jamaah->package_id == $p->id ? 'selected' : '' }}>
                                            [{{ strtoupper($p->type) }}] {{ $p->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group"><label>Grup</label>
                                    <select name="group_id" class="form-control">
                                        <option value="">-- Tanpa Grup --</option>
                                        @foreach($groups as $g)
                                        <option value="{{ $g->id }}" {{ $jamaah->group_id == $g->id ? 'selected' : '' }}>{{ $g->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group"><label>Tanggal Keberangkatan</label>
                                    <input type="date" name="departure_date" class="form-control" value="{{ $jamaah->departure_date }}">
                                </div>
                                <div class="form-group"><label>Status *</label>
                                    <select name="status" class="form-control" required>
                                        @foreach(['draft','booked','paid','documents_verified','ready','departed'] as $st)
                                        <option value="{{ $st }}" {{ $jamaah->status == $st ? 'selected' : '' }}>
                                            {{ ucfirst(str_replace('_',' ',$st)) }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" form="updateJamaahForm{{ $jamaah->id }}" class="btn btn-warning">Update</button>
                </div>
            </div>
        </div>
    </div>

    @endforeach

</div>

@push('scripts')
<script>
// Data dari Laravel untuk dynamic select
const packagesData = @json($packages);
const groupsData   = @json($groups);

// Filter tab
function filterTab(el, filter) {
    document.querySelectorAll('.tab-btn').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    applyVisibility();
}

// Search
document.getElementById('searchInput').addEventListener('input', applyVisibility);

function applyVisibility() {
    var q = document.getElementById('searchInput').value.toLowerCase();
    var active = document.querySelector('.tab-btn.active');
    var filter = 'all';
    if (active) {
        var m = active.getAttribute('onclick').match(/'([^']+)'/g);
        if (m && m[1]) filter = m[1].replace(/'/g,'');
    }
    var rows = document.querySelectorAll('#tableBody tr[data-status]');
    var count = 0;
    rows.forEach(function(row) {
        var matchF = filter === 'all' || row.dataset.status === filter;
        var matchS = row.dataset.name.includes(q) || row.dataset.reg.includes(q);
        row.style.display = (matchF && matchS) ? '' : 'none';
        if (matchF && matchS) count++;
    });
    document.getElementById('showCount').textContent = count;
}

function toggleAll(cb) {
    document.querySelectorAll('.row-check').forEach(c => c.checked = cb.checked);
}

// Delete
function confirmDelete(el) {
    var id   = el.dataset.id;
    var name = el.dataset.name;
    if (!confirm('Hapus jemaah "' + name + '"?')) return;

    fetch('/jemaah/delete/' + id, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(r => r.json())
    .then(() => location.reload())
    .catch(() => alert('Gagal menghapus jemaah'));
}

// Dynamic package & group select (modal tambah)
document.addEventListener('DOMContentLoaded', function() {
    var packageType   = document.getElementById('packageType');
    var packageSelect = document.getElementById('packageSelect');
    var groupSelect   = document.getElementById('groupSelect');
    var departureDate = document.getElementById('departureDate');

    if (!packageType) return;

    packageType.addEventListener('change', function() {
        var type = this.value;
        packageSelect.innerHTML = '<option value="">-- Pilih Paket --</option>';
        packageSelect.disabled = true;
        groupSelect.innerHTML  = '<option value="">-- Pilih Paket Dulu --</option>';
        groupSelect.disabled   = true;
        departureDate.value    = '';
        if (!type) return;

        var filtered = packagesData.filter(p =>
            p.type.toLowerCase() === type && p.status.toLowerCase() === 'published'
        );
        filtered.forEach(p => {
            var opt = document.createElement('option');
            opt.value = p.id;
            opt.textContent = p.name + ' - Rp ' + Number(p.price).toLocaleString('id-ID');
            opt.dataset.departure = p.departure_date;
            packageSelect.appendChild(opt);
        });
        packageSelect.disabled = filtered.length === 0;
    });

    packageSelect.addEventListener('change', function() {
        var id  = this.value;
        groupSelect.innerHTML = '<option value="">-- Tanpa Grup --</option>';
        groupSelect.disabled  = true;
        departureDate.value   = '';
        if (!id) return;

        var pkg = packagesData.find(p => p.id == id);
        if (pkg) departureDate.value = pkg.departure_date;

        var relGroups = groupsData.filter(g => g.package_id == id);
        relGroups.forEach(g => {
            var opt = document.createElement('option');
            opt.value = g.id;
            opt.textContent = g.name;
            groupSelect.appendChild(opt);
        });
        groupSelect.disabled = false;
    });
});
</script>
@endpush
@endsection