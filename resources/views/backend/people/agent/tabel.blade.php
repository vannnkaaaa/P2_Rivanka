@extends('backend.master')

@section('content')
<div class="container-fluid">

    {{-- Page Title --}}
    <div class="page-title-box">
        <div>
            <h4>Management Agent</h4>
            <ol class="breadcrumb p-0 m-0">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item">Management User</li>
                <li class="breadcrumb-item active">Agent</li>
            </ol>
        </div>
    </div>

    <div class="card m-b-30">
        <div class="card-body">

            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="header-title mt-0">Daftar Agent</h5>
                    <p class="text-muted mb-0">Kelola semua akun agent travel</p>
                </div>
                <div class="d-flex align-items-center">
                    <input type="text" id="searchInput" class="form-control form-control-sm mr-2"
                        placeholder="Cari nama, email..." style="width:200px;">
                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahAgent">
                        <i class="mdi mdi-plus"></i> Tambah Agent
                    </button>
                </div>
            </div>

            {{-- Filter Tab --}}
            <div class="mb-3">
                <button class="btn btn-sm btn-primary mr-1 tab-btn active" onclick="filterTab(this,'all')">
                    Semua <span class="badge badge-light text-dark">{{ $agents->count() }}</span>
                </button>
                <button class="btn btn-sm btn-outline-success mr-1 tab-btn" onclick="filterTab(this,'active')">
                    Aktif <span class="badge badge-light text-dark">{{ $agents->filter(fn($a) => optional($a->user)->is_active == 1)->count() }}</span>
                </button>
                <button class="btn btn-sm btn-outline-danger tab-btn" onclick="filterTab(this,'inactive')">
                    Tidak Aktif <span class="badge badge-light text-dark">{{ $agents->filter(fn($a) => optional($a->user)->is_active == 0)->count() }}</span>
                </button>
            </div>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="userTable">
                    <thead class="thead-dark">
                        <tr>
                            <th width="40"><input type="checkbox" onchange="toggleAll(this)"></th>
                            <th>#</th>
                            <th>User</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Last Active</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @forelse ($agents as $index => $agent)
                        @php
                            $person   = $agent->people;
                            $user     = $agent->user;
                            $fullname = $person->fullname ?? '-';
                            $username = $user->username ?? '-';
                            $email    = $user->email ?? '-';

                            $role_name  = ($user && $user->roles->count()) ? strtolower($user->roles->first()->name) : 'agent';
                            $role_label = ucfirst($role_name);
                            $role_badge = ['admin'=>'danger','super admin'=>'dark','agent'=>'warning'][$role_name] ?? 'secondary';

                            $is_active   = $user && $user->is_active == 1;
                            $status_key  = $is_active ? 'active' : 'inactive';
                            $status_text = $is_active ? 'Aktif' : 'Tidak Aktif';
                            $status_cls  = $is_active ? 'success' : 'danger';

                            $last_active = ($user && $user->last_login_at)
                                ? \Carbon\Carbon::parse($user->last_login_at)->diffForHumans()
                                : 'Belum login';

                            $palette    = ['#8b5cf6','#4f46e5','#3b82f6','#ec4899','#10b981','#f59e0b','#6366f1'];
                            $avatar_bg  = $palette[abs(crc32($fullname)) % count($palette)];
                            $parts      = explode(' ', trim($fullname));
                            $initials   = strtoupper(substr($parts[0],0,1).(isset($parts[1]) ? substr($parts[1],0,1) : ''));
                        @endphp
                        <tr data-status="{{ $status_key }}"
                            data-name="{{ strtolower($fullname) }}"
                            data-username="{{ strtolower($username) }}"
                            data-email="{{ strtolower($email) }}">
                            <td><input type="checkbox" class="row-check"></td>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle mr-2 d-flex align-items-center justify-content-center text-white font-weight-bold"
                                        style="width:38px;height:38px;background:{{ $avatar_bg }};font-size:14px;flex-shrink:0;">
                                        {{ $initials }}
                                    </div>
                                    <div>
                                        <div class="font-weight-semibold small text-dark">{{ $username }}</div>
                                        <div class="text-muted small">{{ $fullname }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="small">{{ $email }}</td>
                            <td><span class="badge badge-{{ $role_badge }}">{{ $role_label }}</span></td>
                            <td><span class="badge badge-{{ $status_cls }}">{{ $status_text }}</span></td>
                            <td class="text-muted small">{{ $last_active }}</td>
                            <td>
                                <button class="btn btn-info btn-xs mr-1" data-toggle="modal"
                                    data-target="#modalViewAgent{{ $agent->id }}">
                                    <i class="mdi mdi-eye"></i>
                                </button>
                                <button class="btn btn-warning btn-xs mr-1" data-toggle="modal"
                                    data-target="#modalUpdateAgent{{ $agent->id }}">
                                    <i class="mdi mdi-pencil"></i>
                                </button>
                                <button class="btn btn-danger btn-xs"
                                    data-id="{{ $agent->id }}"
                                    data-name="{{ $fullname }}"
                                    onclick="confirmDelete(this)">
                                    <i class="mdi mdi-delete"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">Belum ada data agent</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Info --}}
            <div class="d-flex justify-content-between align-items-center mt-2">
                <small class="text-muted">
                    Menampilkan <strong id="showCount">{{ $agents->count() }}</strong> data
                </small>
            </div>

        </div>
    </div>

    {{-- ===== MODAL TAMBAH ===== --}}
    <div class="modal fade" id="modalTambahAgent" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="mdi mdi-account-plus mr-1"></i> Tambah Agent Baru</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="addAgentForm" method="POST" action="{{ route('agent.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-muted border-bottom pb-2 mb-3">Akun Login</h6>
                                <div class="form-group"><label>Username *</label><input type="text" name="username" class="form-control" required></div>
                                <div class="form-group"><label>Email *</label><input type="email" name="email" class="form-control" required></div>
                                <div class="form-group"><label>Password *</label><input type="password" name="password" class="form-control" required minlength="8"></div>
                                <div class="form-group"><label>Konfirmasi Password *</label><input type="password" name="password_confirmation" class="form-control" required></div>

                                <h6 class="text-muted border-bottom pb-2 mb-3 mt-4">Data Pribadi</h6>
                                <div class="form-group"><label>Nama Lengkap *</label><input type="text" name="fullname" class="form-control" required></div>
                                <div class="form-group"><label>Jenis Kelamin *</label>
                                    <select name="sex" class="form-control" required>
                                        <option value="">Pilih</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group"><label>No. Telepon *</label><input type="text" name="phone" class="form-control" required></div>
                                <div class="form-group"><label>Tempat Lahir *</label><input type="text" name="pob" class="form-control" required></div>
                                <div class="form-group"><label>Tanggal Lahir *</label><input type="date" name="bod" class="form-control" required></div>
                                <div class="form-group"><label>Alamat *</label><textarea name="address" class="form-control" rows="2" required></textarea></div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted border-bottom pb-2 mb-3">Perusahaan</h6>
                                <div class="form-group"><label>Perusahaan</label>
                                    <select name="company_id" id="companySelect" class="form-control">
                                        <option value="">-- Pilih --</option>
                                        @foreach($companies as $c)
                                        <option value="{{ $c->id }}" data-name="{{ $c->name }}" data-address="{{ $c->main_address ?? '' }}"
                                            data-ppiu="{{ $c->ppiu_license_number ?? '' }}" data-pihk="{{ $c->pihk_license_number ?? '' }}">
                                            {{ $c->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group"><label>Cabang</label>
                                    <select name="office_id" id="officeSelect" class="form-control">
                                        <option value="">-- Pilih --</option>
                                        @foreach($offices as $o)
                                        <option value="{{ $o->id }}" data-company="{{ $o->company_id }}" data-address="{{ $o->address }}">{{ $o->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group"><label>Nama Perusahaan *</label><input type="text" name="company_name" id="company_name" class="form-control" required></div>
                                <div class="form-group"><label>Asosiasi</label>
                                    <select name="association_id" class="form-control">
                                        <option value="">-- Pilih --</option>
                                        @foreach($associations as $a)<option value="{{ $a->id }}">{{ $a->name }}</option>@endforeach
                                    </select>
                                </div>
                                <div class="form-group"><label>Alamat Perusahaan *</label><textarea name="company_address" id="company_address" class="form-control" rows="2" required></textarea></div>
                                <div class="form-group"><label>Alamat Cabang *</label><textarea name="office_address" id="office_address" class="form-control" rows="2" required></textarea></div>

                                <h6 class="text-muted border-bottom pb-2 mb-3 mt-4">Lisensi</h6>
                                <div class="form-group"><label>No. PPIU</label><input type="text" name="ppiu_license_number" id="ppiu_license_number" class="form-control"></div>
                                <div class="form-group"><label>No. PIHK</label><input type="text" name="pihk_license_number" id="pihk_license_number" class="form-control"></div>

                                <h6 class="text-muted border-bottom pb-2 mb-3 mt-4">Status</h6>
                                <div class="form-group"><label>Status Aktif *</label>
                                    <select name="is_active" class="form-control" required>
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" form="addAgentForm" class="btn btn-success">Simpan Agent</button>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== MODAL EDIT & VIEW (per agent) ===== --}}
    @foreach ($agents as $agent)

    {{-- Modal Edit --}}
    <div class="modal fade" id="modalUpdateAgent{{ $agent->id }}" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title"><i class="mdi mdi-pencil mr-1"></i> Edit Data Agent</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="updateAgentForm{{ $agent->id }}" method="POST" action="{{ route('agent.update', $agent->id) }}">
                        @csrf @method('PUT')
                        <input type="hidden" name="agent_id" value="{{ $agent->id }}">
                        <input type="hidden" name="user_id" value="{{ $agent->user->id ?? '' }}">
                        <input type="hidden" name="people_id" value="{{ $agent->people->id ?? '' }}">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-muted border-bottom pb-2 mb-3">Akun Login</h6>
                                <div class="form-group"><label>Username</label><input type="text" name="username" class="form-control" value="{{ $agent->user->username ?? '' }}" readonly></div>
                                <div class="form-group"><label>Email</label><input type="email" name="email" class="form-control" value="{{ $agent->user->email ?? '' }}" readonly></div>
                                <div class="form-group"><label>Password Baru</label><input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah" minlength="8"></div>
                                <div class="form-group"><label>Konfirmasi Password</label><input type="password" name="password_confirmation" class="form-control" minlength="8"></div>

                                <h6 class="text-muted border-bottom pb-2 mb-3 mt-4">Data Pribadi</h6>
                                <div class="form-group"><label>Nama Lengkap *</label><input type="text" name="fullname" class="form-control" value="{{ $agent->people->fullname ?? '' }}" required></div>
                                <div class="form-group"><label>Jenis Kelamin *</label>
                                    <select name="sex" class="form-control" required>
                                        <option value="L" {{ ($agent->people->gender ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ ($agent->people->gender ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group"><label>No. Telepon *</label><input type="text" name="phone" class="form-control" value="{{ $agent->people->phone ?? '' }}" required></div>
                                <div class="form-group"><label>Tempat Lahir</label><input type="text" name="pob" class="form-control" value="{{ $agent->people->birth_place ?? '' }}" readonly></div>
                                <div class="form-group"><label>Tanggal Lahir</label><input type="date" name="bod" class="form-control" value="{{ $agent->people->birth_date ?? '' }}" readonly></div>
                                <div class="form-group"><label>Alamat *</label><textarea name="address" class="form-control" rows="2" required>{{ $agent->people->address ?? '' }}</textarea></div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted border-bottom pb-2 mb-3">Perusahaan</h6>
                                <div class="form-group"><label>Perusahaan</label>
                                    <select name="company_id" class="form-control">
                                        <option value="">-- Pilih --</option>
                                        @foreach($companies as $c)
                                        <option value="{{ $c->id }}" {{ ($agent->company_id ?? '') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group"><label>Cabang</label>
                                    <select name="office_id" class="form-control">
                                        <option value="">-- Pilih --</option>
                                        @foreach($offices as $o)
                                        <option value="{{ $o->id }}" {{ ($agent->office_id ?? '') == $o->id ? 'selected' : '' }}>{{ $o->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group"><label>Nama Perusahaan *</label><input type="text" name="company_name" class="form-control" value="{{ $agent->company->name ?? '' }}" required></div>
                                <div class="form-group"><label>Asosiasi</label>
                                    <select name="association_id" class="form-control">
                                        <option value="">-- Pilih --</option>
                                        @foreach($associations as $a)
                                        <option value="{{ $a->id }}" {{ ($agent->association_id ?? '') == $a->id ? 'selected' : '' }}>{{ $a->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group"><label>Alamat Perusahaan *</label><textarea name="company_address" class="form-control" rows="2" required>{{ $agent->company->main_address ?? '' }}</textarea></div>
                                <div class="form-group"><label>Alamat Cabang *</label><textarea name="office_address" class="form-control" rows="2" required>{{ $agent->office->address ?? '' }}</textarea></div>

                                <h6 class="text-muted border-bottom pb-2 mb-3 mt-4">Lisensi</h6>
                                <div class="form-group"><label>No. PPIU</label><input type="text" name="ppiu_license_number" class="form-control" value="{{ $agent->ppiu_license_number ?? '' }}"></div>
                                <div class="form-group"><label>No. PIHK</label><input type="text" name="pihk_license_number" class="form-control" value="{{ $agent->pihk_license_number ?? '' }}"></div>

                                <h6 class="text-muted border-bottom pb-2 mb-3 mt-4">Status</h6>
                                <div class="form-group"><label>Status Aktif *</label>
                                    <select name="is_active" class="form-control" required>
                                        <option value="1" {{ ($agent->user->is_active ?? 0) == 1 ? 'selected' : '' }}>Aktif</option>
                                        <option value="0" {{ ($agent->user->is_active ?? 0) == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" form="updateAgentForm{{ $agent->id }}" class="btn btn-warning">Update</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal View --}}
    <div class="modal fade" id="modalViewAgent{{ $agent->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title"><i class="mdi mdi-eye mr-1"></i> Detail Agent</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nama:</strong> {{ $agent->people->fullname ?? '-' }}</p>
                            <p><strong>Username:</strong> {{ $agent->user->username ?? '-' }}</p>
                            <p><strong>Email:</strong> {{ $agent->user->email ?? '-' }}</p>
                            <p><strong>Telepon:</strong> {{ $agent->people->phone ?? '-' }}</p>
                            <p><strong>Jenis Kelamin:</strong> {{ ($agent->people->gender ?? '') == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Perusahaan:</strong> {{ $agent->company->name ?? '-' }}</p>
                            <p><strong>Cabang:</strong> {{ $agent->office->name ?? '-' }}</p>
                            <p><strong>No. PPIU:</strong> {{ $agent->ppiu_license_number ?? '-' }}</p>
                            <p><strong>No. PIHK:</strong> {{ $agent->pihk_license_number ?? '-' }}</p>
                            <p><strong>Status:</strong>
                                <span class="badge badge-{{ ($agent->user->is_active ?? 0) ? 'success' : 'danger' }}">
                                    {{ ($agent->user->is_active ?? 0) ? 'Aktif' : 'Tidak Aktif' }}
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

    @endforeach

</div>{{-- end container-fluid --}}

@push('scripts')
<script>
// Filter tab
function filterTab(el, filter) {
    document.querySelectorAll('.tab-btn').forEach(t => {
        t.classList.remove('active','btn-primary','btn-success','btn-danger');
        t.classList.add('btn-outline-' + (t.dataset.color || 'secondary'));
    });
    el.classList.add('active');
    applyVisibility();
}

// Search + filter
document.getElementById('searchInput').addEventListener('input', applyVisibility);

function applyVisibility() {
    var q = document.getElementById('searchInput').value.toLowerCase();
    var active = document.querySelector('.tab-btn.active');
    var filter = 'all';
    if (active) {
        var match = active.getAttribute('onclick').match(/'([^']+)'/g);
        if (match && match[1]) filter = match[1].replace(/'/g,'');
    }
    var rows = document.querySelectorAll('#tableBody tr[data-status]');
    var count = 0;
    rows.forEach(function(row) {
        var matchF = filter === 'all' || row.dataset.status === filter;
        var matchS = row.dataset.name.includes(q) || row.dataset.username.includes(q) || row.dataset.email.includes(q);
        row.style.display = (matchF && matchS) ? '' : 'none';
        if (matchF && matchS) count++;
    });
    document.getElementById('showCount').textContent = count;
}

// Checkbox select all
function toggleAll(cb) {
    document.querySelectorAll('.row-check').forEach(c => c.checked = cb.checked);
}

// Delete
function confirmDelete(el) {
    var id   = el.dataset.id;
    var name = el.dataset.name;
    if (!confirm('Hapus agent "' + name + '"?')) return;

    fetch('/agent/delete/' + id, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(r => r.json())
    .then(data => { location.reload(); })
    .catch(() => alert('Gagal menghapus agent'));
}

// Auto-fill company info saat pilih perusahaan
document.addEventListener('DOMContentLoaded', function() {
    var cs = document.getElementById('companySelect');
    var os = document.getElementById('officeSelect');
    if (!cs) return;

    cs.addEventListener('change', function() {
        var opt = this.options[this.selectedIndex];
        document.getElementById('company_name').value    = opt.dataset.name    || '';
        document.getElementById('company_address').value = opt.dataset.address || '';
        document.getElementById('ppiu_license_number').value = opt.dataset.ppiu || '';
        document.getElementById('pihk_license_number').value = opt.dataset.pihk || '';
        os.selectedIndex = 0;
        document.getElementById('office_address').value = '';
    });

    os.addEventListener('change', function() {
        var opt = this.options[this.selectedIndex];
        document.getElementById('office_address').value = opt.dataset.address || '';
    });
});
</script>
@endpush
@endsection