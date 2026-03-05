@extends('backend.master')

@section('content')
<div class="container-fluid">

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

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="header-title mt-0">Daftar Jemaah</h5>
                    <p class="text-muted mb-0">Kelola semua data jemaah travel</p>
                </div>
                <div class="d-flex align-items-center">
                    <input type="text" id="searchInput" class="form-control form-control-sm mr-2"
                        placeholder="Cari nama, username..." style="width:220px;">
                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalAddJemaah">
                        <i class="mdi mdi-plus"></i> Tambah Jemaah
                    </button>
                </div>
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
                            <th width="40"><input type="checkbox" onchange="toggleAll(this)"></th>
                            <th>#</th>
                            <th>Jemaah</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>No. Telepon</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @forelse ($users as $index => $user)
                        @php
                            $person   = $user->userable;
                            $fullname = $person->fullname ?? '-';
                            $phone    = $person->phone ?? '-';

                            $status_label = $user->is_active ? 'Aktif' : 'Tidak Aktif';
                            $status_badge = $user->is_active ? 'success' : 'danger';

                            $palette   = ['#8b5cf6','#4f46e5','#3b82f6','#ec4899','#10b981','#f59e0b','#6366f1'];
                            $avatar_bg = $palette[abs(crc32($fullname)) % count($palette)];
                            $parts     = explode(' ', trim($fullname));
                            $initials  = strtoupper(substr($parts[0],0,1).(isset($parts[1]) ? substr($parts[1],0,1) : ''));
                        @endphp
                        <tr data-name="{{ strtolower($fullname) }}"
                            data-username="{{ strtolower($user->username ?? '') }}">
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
                            <td class="small font-weight-semibold">{{ $user->username ?? '-' }}</td>
                            <td class="small text-muted">{{ $user->email ?? '-' }}</td>
                            <td class="small">{{ $phone }}</td>
                            <td><span class="badge badge-{{ $status_badge }}">{{ $status_label }}</span></td>
                            <td>
                                <button class="btn btn-info btn-xs mr-1" data-toggle="modal"
                                    data-target="#modalViewUser{{ $user->id }}">
                                    <i class="mdi mdi-eye"></i>
                                </button>
                                <button class="btn btn-warning btn-xs mr-1" data-toggle="modal"
                                    data-target="#modalUpdateUser{{ $user->id }}">
                                    <i class="mdi mdi-pencil"></i>
                                </button>
                                <button class="btn btn-danger btn-xs"
                                    data-id="{{ $user->id }}"
                                    data-name="{{ $fullname }}"
                                    onclick="confirmDelete(this)">
                                    <i class="mdi mdi-delete"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">Belum ada data jemaah</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-2">
                <small class="text-muted">Menampilkan <strong id="showCount">{{ $users->count() }}</strong> data</small>
            </div>

        </div>
    </div>

    {{-- ===== MODAL TAMBAH JEMAAH ===== --}}
    <div class="modal fade" id="modalAddJemaah" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
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
                        <h6 class="text-muted border-bottom pb-2 mb-3">
                            <i class="mdi mdi-account-key mr-1"></i> Informasi Akun Pengguna
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Username <span class="text-danger">*</span></label>
                                    <input type="text" name="username" class="form-control"
                                        placeholder="Masukkan username" value="{{ old('username') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control"
                                        placeholder="Masukkan email" value="{{ old('email') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control"
                                        placeholder="Minimal 8 karakter" required minlength="8">
                                    <small class="text-muted">Minimal 8 karakter</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Konfirmasi Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                        placeholder="Harus sama dengan password" required>
                                </div>
                            </div>
                        </div>

                        <h6 class="text-muted border-bottom pb-2 mb-3 mt-2">
                            <i class="mdi mdi-account mr-1"></i> Informasi Pribadi
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="fullname" class="form-control"
                                        placeholder="Masukkan nama lengkap" value="{{ old('fullname') }}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select name="gender" class="form-control" required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L" {{ old('gender')=='L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('gender')=='P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Nomor Telepon <span class="text-danger">*</span></label>
                                    <input type="tel" name="phone" class="form-control"
                                        placeholder="08xxxxxxxxxx" value="{{ old('phone') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tempat Lahir <span class="text-danger">*</span></label>
                                    <input type="text" name="birth_place" class="form-control"
                                        placeholder="Masukkan tempat lahir" value="{{ old('birth_place') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" name="birth_date" class="form-control"
                                        value="{{ old('birth_date') }}" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Alamat Lengkap <span class="text-danger">*</span></label>
                                    <textarea name="address" class="form-control" rows="3"
                                        placeholder="Masukkan alamat lengkap sesuai KTP" required>{{ old('address') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" form="addJemaahForm" class="btn btn-success">
                        <i class="mdi mdi-check mr-1"></i> Simpan Jemaah
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== MODAL VIEW & EDIT per user ===== --}}
    @foreach($users as $user)
    @php
        $person = $user->userable;
    @endphp

    {{-- Modal View --}}
    <div class="modal fade" id="modalViewUser{{ $user->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title"><i class="mdi mdi-eye mr-1"></i> Detail Jemaah</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nama:</strong> {{ $person->fullname ?? '-' }}</p>
                            <p><strong>Telepon:</strong> {{ $person->phone ?? '-' }}</p>
                            <p><strong>Gender:</strong> {{ ($person->gender ?? '') == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                            <p><strong>Tempat/Tgl Lahir:</strong>
                                {{ $person->birth_place ?? '-' }},
                                {{ $person->birth_date ? \Carbon\Carbon::parse($person->birth_date)->format('d M Y') : '-' }}
                            </p>
                            <p><strong>Alamat:</strong> {{ $person->address ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Username:</strong> {{ $user->username ?? '-' }}</p>
                            <p><strong>Email:</strong> {{ $user->email ?? '-' }}</p>
                            <p><strong>Status:</strong>
                                <span class="badge badge-{{ $user->is_active ? 'success' : 'danger' }}">
                                    {{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}
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
    <div class="modal fade" id="modalUpdateUser{{ $user->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title"><i class="mdi mdi-pencil mr-1"></i> Edit Jemaah</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="updateUserForm{{ $user->id }}" method="POST"
                        action="{{ route('jemaah.update', $user->id) }}">
                        @csrf @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-muted border-bottom pb-2 mb-3">Data Pribadi</h6>
                                <div class="form-group">
                                    <label>Nama Lengkap *</label>
                                    <input type="text" name="fullname" class="form-control"
                                        value="{{ $person->fullname ?? '' }}" required>
                                </div>
                                <div class="form-group">
                                    <label>No. Telepon *</label>
                                    <input type="tel" name="phone" class="form-control"
                                        value="{{ $person->phone ?? '' }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea name="address" class="form-control" rows="2">{{ $person->address ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted border-bottom pb-2 mb-3">Akun</h6>
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control" value="{{ $user->username }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" value="{{ $user->email }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="is_active" class="form-control">
                                        <option value="1" {{ $user->is_active ? 'selected' : '' }}>Aktif</option>
                                        <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" form="updateUserForm{{ $user->id }}" class="btn btn-warning">Update</button>
                </div>
            </div>
        </div>
    </div>

    @endforeach

</div>

@push('scripts')
<script>
document.getElementById('searchInput').addEventListener('input', function() {
    var q    = this.value.toLowerCase();
    var rows = document.querySelectorAll('#tableBody tr[data-name]');
    var count = 0;
    rows.forEach(function(row) {
        var match = row.dataset.name.includes(q) || row.dataset.username.includes(q);
        row.style.display = match ? '' : 'none';
        if (match) count++;
    });
    document.getElementById('showCount').textContent = count;
});

function toggleAll(cb) {
    document.querySelectorAll('.row-check').forEach(c => c.checked = cb.checked);
}

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

@if($errors->any())
    $('#modalAddJemaah').modal('show');
@endif
</script>
@endpush
@endsection