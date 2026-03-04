@extends('backend.master')

@section('content')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-lg-column py-3 py-lg-6">
            <div class="page-title d-flex align-items-center gap-1 me-3">
                <h1 class="text-gray-900 fw-bolder fs-2x mb-1 lh-1">Paket {{ ucfirst($type) }}</h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-base ms-3">
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                        <a href="#" class="text-gray-700 text-hover-primary">
                            <i class="ki-duotone ki-home fs-3 text-gray-500 ms-2"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-4 text-gray-700 mx-n2"></i></li>
                    <li class="breadcrumb-item text-gray-500">Paket {{ ucfirst($type) }}</li>
                </ul>
            </div>
            <div class="app-toolbar-container-separator separator d-none d-lg-flex"></div>
        </div>
    </div>
    <!--end::Toolbar-->

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">

            {{-- Header --}}
            <div class="card mb-4" style="background:linear-gradient(135deg,#1e1b4b,#4f46e5);border-radius:16px;border:none;">
                <div class="card-body d-flex align-items-center justify-content-between py-4 px-5">
                    <div>
                        <h4 class="text-white font-weight-bold mb-1">Paket {{ ucfirst($type) }} 📦</h4>
                        <p class="text-white-50 mb-0 small">Kelola dan pilih paket perjalanan terbaik</p>
                    </div>
                    @if(!in_array($type, ['haji','umrah']))
                    <button class="btn btn-light btn-sm font-weight-bold" data-toggle="modal" data-target="#modalAddPackage">
                        <i class="mdi mdi-plus mr-1"></i> Tambah Paket
                    </button>
                    @endif
                </div>
            </div>

            {{-- Search Bar --}}
            <div class="card mb-4">
                <div class="card-body py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="mdi mdi-magnify"></i></span>
                                </div>
                                <input type="text" id="searchPackages" class="form-control" placeholder="Cari paket...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Cards Grid --}}
            <div class="row" id="packagesGrid">
                @foreach($packages as $package)
                @php
                    $availableSeat = $package->quota - $package->quota_used;
                    $isScarce = $availableSeat <= 10;
                    $gradient = match(true) {
                        $package->type === 'VIP'       => 'linear-gradient(140deg,#6D28D9,#4F46E5)',
                        $package->type === 'Haji Plus'  => 'linear-gradient(140deg,#92400E,#C4973B)',
                        default                         => 'linear-gradient(140deg,#0D7377,#1A6B52)',
                    };
                @endphp
                <div class="col-xl-4 col-lg-6 mb-4 package-item">
                    <div class="card h-100" style="border-radius:16px;border:none;box-shadow:0 4px 20px rgba(0,0,0,0.08);overflow:hidden;">

                        {{-- Banner --}}
                        <div style="background:{{ $gradient }};padding:24px 20px 20px;position:relative;overflow:hidden;">
                            {{-- Decorative circle --}}
                            <div style="position:absolute;top:-30px;right:-30px;width:120px;height:120px;background:rgba(255,255,255,0.07);border-radius:50%;"></div>

                            {{-- Badges --}}
                            <div class="mb-2">
                                <span class="badge mr-1" style="background:rgba(255,255,255,0.2);color:#fff;font-size:11px;letter-spacing:1px;">{{ strtoupper($package->type) }}</span>
                                <span class="badge" style="background:#f59e0b;color:#fff;font-size:11px;">DP {{ number_format($package->dp/1000000,1) }} JT</span>
                            </div>

                            <div class="text-white-50 small mb-1">
                                <i class="mdi mdi-calendar mr-1"></i>Program {{ $package->program_days }} Hari
                            </div>
                            <h5 class="text-white font-weight-bold mb-1">{{ $package->name }} {{ $package->year }}</h5>
                            <div class="text-white-50 small mb-3">
                                <i class="mdi mdi-airplane mr-1"></i>
                                Keberangkatan: {{ \Carbon\Carbon::parse($package->departure_date)->translatedFormat('d F Y') }}
                            </div>

                            {{-- Price Strip --}}
                            <div class="d-flex" style="gap:8px;">
                                @foreach([['Quad',$package->price],['Triple',$package->price_triple],['Double',$package->price_double]] as [$label,$price])
                                <div style="flex:1;background:rgba(255,255,255,0.15);border-radius:10px;padding:10px 8px;text-align:center;">
                                    <div class="text-white-50" style="font-size:10px;font-weight:600;letter-spacing:.5px;">{{ $label }}</div>
                                    <div class="text-white font-weight-bold" style="font-size:15px;">{{ number_format($price/1000000,1) }} Jt</div>
                                    <div class="text-white-50" style="font-size:10px;">/pax</div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Info Body --}}
                        <div class="card-body py-3 px-4">
                            <div class="row">
                                <div class="col-6 mb-2">
                                    <div class="small text-muted">Jadwal</div>
                                    <div class="small font-weight-semibold">
                                        {{ \Carbon\Carbon::parse($package->departure_date)->format('d M Y') }},
                                        {{ \Carbon\Carbon::parse($package->departure_time)->format('H:i') }}
                                    </div>
                                </div>
                                <div class="col-6 mb-2">
                                    <div class="small text-muted">Durasi</div>
                                    <div class="small font-weight-semibold">{{ $package->duration_days }} Hari</div>
                                </div>
                                <div class="col-6 mb-2">
                                    <div class="small text-muted">Hotel</div>
                                    <div class="small font-weight-semibold">
                                        @for($s=0;$s<$package->hotel_rating;$s++)<span class="text-warning">★</span>@endfor
                                        @for($s=$package->hotel_rating;$s<5;$s++)<span class="text-muted">★</span>@endfor
                                    </div>
                                </div>
                                <div class="col-6 mb-2">
                                    <div class="small text-muted">Seat Tersedia</div>
                                    <div>
                                        <span class="badge badge-{{ $isScarce ? 'warning' : 'success' }} small">
                                            {{ $availableSeat }} pax {{ $isScarce ? 'tersisa' : 'tersedia' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-6 mb-2">
                                    <div class="small text-muted">Berangkat dari</div>
                                    <div class="small font-weight-semibold">{{ $package->departure_city }}</div>
                                </div>
                                <div class="col-6 mb-2">
                                    <div class="small text-muted">Maskapai</div>
                                    <div class="small font-weight-semibold">{{ $package->airline }}</div>
                                </div>
                            </div>
                        </div>

                        {{-- Status Bar --}}
                        <div class="px-4 pb-2">
                            <form method="POST" action="{{ route('package.set-status', [$package->type, $package->id]) }}" class="d-flex" style="gap:6px;">
                                @csrf
                                @method('PATCH')
                                @foreach(['draft'=>'secondary','published'=>'success','closed'=>'danger'] as $st => $color)
                                <button type="submit" name="status" value="{{ $st }}"
                                    class="btn btn-sm {{ $package->status === $st ? 'btn-'.$color : 'btn-outline-'.$color }}"
                                    style="flex:1;font-size:11px;padding:4px 0;">
                                    {{ ucfirst($st) }}
                                </button>
                                @endforeach
                            </form>
                        </div>

                        {{-- Footer --}}
                        <div class="card-footer bg-white border-top-0 pt-0 pb-3 px-4">
                            <a href="{{ route('package.view', [$package->type, $package->id]) }}"
                               class="btn btn-primary btn-block btn-sm mt-2">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="text-muted small">
                    Menampilkan <b>{{ $packages->firstItem() }}</b> sampai <b>{{ $packages->lastItem() }}</b>
                    dari <b>{{ $packages->total() }}</b> paket
                </div>
                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item {{ $packages->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $packages->previousPageUrl() }}">Previous</a>
                        </li>
                        @foreach($packages->getUrlRange(1, $packages->lastPage()) as $page => $url)
                        <li class="page-item {{ $page == $packages->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                        @endforeach
                        <li class="page-item {{ !$packages->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $packages->nextPageUrl() }}">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>

        </div>
    </div>

    {{-- ============================================================
         MODAL ADD PACKAGE — Bootstrap 4 (data-toggle / data-dismiss)
    ============================================================ --}}
    <div class="modal fade" id="modalAddPackage" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content" style="border-radius:16px;border:none;overflow:hidden;">

                {{-- Modal Header --}}
                <div class="modal-header" style="background:linear-gradient(135deg,#1e1b4b,#4f46e5);border:none;">
                    <div class="d-flex align-items-center">
                        <div class="rounded mr-3 d-flex align-items-center justify-content-center text-white"
                             style="width:44px;height:44px;background:rgba(255,255,255,0.15);">
                            <i class="mdi mdi-package-variant" style="font-size:22px;"></i>
                        </div>
                        <div>
                            <h5 class="modal-title text-white font-weight-bold mb-0">Tambah Paket Baru</h5>
                            <p class="text-white-50 small mb-0">Lengkapi informasi paket Haji atau Umroh</p>
                        </div>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                {{-- Modal Body --}}
                <div class="modal-body p-0" style="max-height:75vh;overflow-y:auto;">
                    <form id="addPackageForm" method="POST">
                        @csrf

                        {{-- Section: Informasi Dasar --}}
                        <div class="border-bottom p-4">
                            <h6 class="text-uppercase text-muted font-weight-bold small mb-3">
                                <i class="mdi mdi-information-outline mr-1"></i> Informasi Dasar Paket
                            </h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="small font-weight-bold text-muted text-uppercase">Tipe Paket <span class="text-danger">*</span></label>
                                    <select name="type" id="packageType" class="form-control" required>
                                        <option value="">Pilih Tipe</option>
                                        <option value="umrah">Umrah</option>
                                        <option value="haji">Haji</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="small font-weight-bold text-muted text-uppercase">Kode Paket</label>
                                    <input type="text" id="packageCodePreview" class="form-control" readonly>
                                    <input type="hidden" name="code" id="packageCodeReal">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="small font-weight-bold text-muted text-uppercase">Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control" required>
                                        <option value="">Pilih Status</option>
                                        <option value="draft">Draft</option>
                                        <option value="published">Published</option>
                                        <option value="closed">Closed</option>
                                    </select>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="small font-weight-bold text-muted text-uppercase">Nama Paket <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="packageName" class="form-control" placeholder="Contoh: Paket Haji Reguler 1446H" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="small font-weight-bold text-muted text-uppercase">Slug (URL)</label>
                                    <input type="text" name="slug" id="packageSlug" class="form-control" placeholder="Auto-generated dari nama paket" readonly>
                                    <small class="text-muted">Otomatis dibuat dari nama paket</small>
                                </div>
                            </div>
                        </div>

                        {{-- Section: Harga & Kuota --}}
                        <div class="border-bottom p-4">
                            <h6 class="text-uppercase text-muted font-weight-bold small mb-3">
                                <i class="mdi mdi-currency-usd mr-1"></i> Harga & Kuota
                            </h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="small font-weight-bold text-muted text-uppercase">Harga Quad <span class="text-danger">*</span></label>
                                    <input type="number" name="price" class="form-control" placeholder="45500000" required min="0" step="100000">
                                    <small class="text-muted">Harga per orang (Quad)</small>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="small font-weight-bold text-muted text-uppercase">Harga Triple <span class="text-danger">*</span></label>
                                    <input type="number" name="price_triple" class="form-control" placeholder="47200000" required min="0" step="100000">
                                    <small class="text-muted">Harga per orang (Triple)</small>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="small font-weight-bold text-muted text-uppercase">Harga Double <span class="text-danger">*</span></label>
                                    <input type="number" name="price_double" class="form-control" placeholder="49800000" required min="0" step="100000">
                                    <small class="text-muted">Harga per orang (Double)</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="small font-weight-bold text-muted text-uppercase">Down Payment (DP) <span class="text-danger">*</span></label>
                                    <input type="number" name="dp" class="form-control" placeholder="5000000" required min="0" step="100000">
                                    <small class="text-muted">Minimal pembayaran awal per orang</small>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="small font-weight-bold text-muted text-uppercase">Kuota Total <span class="text-danger">*</span></label>
                                    <input type="number" name="quota" class="form-control" placeholder="120" required min="1">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="small font-weight-bold text-muted text-uppercase">Kuota Terpakai</label>
                                    <input type="number" name="quota_used" class="form-control" placeholder="0" value="0" min="0">
                                </div>
                            </div>
                        </div>

                        {{-- Section: Jadwal & Durasi --}}
                        <div class="border-bottom p-4">
                            <h6 class="text-uppercase text-muted font-weight-bold small mb-3">
                                <i class="mdi mdi-calendar mr-1"></i> Jadwal & Durasi
                            </h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="small font-weight-bold text-muted text-uppercase">Tgl Keberangkatan <span class="text-danger">*</span></label>
                                    <input type="date" name="departure_date" id="departureDate" class="form-control" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="small font-weight-bold text-muted text-uppercase">Waktu Keberangkatan <span class="text-danger">*</span></label>
                                    <input type="time" name="departure_time" class="form-control" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="small font-weight-bold text-muted text-uppercase">Durasi (Hari) <span class="text-danger">*</span></label>
                                    <input type="number" name="duration_days" id="durationDays" class="form-control" placeholder="9" required min="1">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="small font-weight-bold text-muted text-uppercase">Tgl Kepulangan <span class="text-danger">*</span></label>
                                    <input type="date" name="return_date" id="returnDate" class="form-control" required>
                                    <small class="text-muted">Otomatis dari tgl berangkat + durasi</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="small font-weight-bold text-muted text-uppercase">Waktu Kepulangan <span class="text-danger">*</span></label>
                                    <input type="time" name="return_time" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        {{-- Section: Transportasi --}}
                        <div class="border-bottom p-4">
                            <h6 class="text-uppercase text-muted font-weight-bold small mb-3">
                                <i class="mdi mdi-airplane mr-1"></i> Transportasi
                            </h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="small font-weight-bold text-muted text-uppercase">Kota Keberangkatan <span class="text-danger">*</span></label>
                                    <input type="text" name="departure_city" class="form-control" placeholder="Jakarta (CGK)" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="small font-weight-bold text-muted text-uppercase">Kota Tujuan <span class="text-danger">*</span></label>
                                    <input type="text" name="destination_city" class="form-control" placeholder="Jeddah (JED)" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="small font-weight-bold text-muted text-uppercase">Maskapai <span class="text-danger">*</span></label>
                                    <input type="text" name="airline" class="form-control" placeholder="Garuda Indonesia" required>
                                </div>
                            </div>
                        </div>

                        {{-- Section: Hotel --}}
                        <div class="border-bottom p-4">
                            <h6 class="text-uppercase text-muted font-weight-bold small mb-3">
                                <i class="mdi mdi-home-city mr-1"></i> Akomodasi Hotel
                            </h6>
                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label class="small font-weight-bold text-muted text-uppercase">Hotel Makkah <span class="text-danger">*</span></label>
                                    <input type="text" name="hotel_makkah" class="form-control" placeholder="Nama Hotel Makkah" required>
                                </div>
                                <div class="col-md-5 mb-3">
                                    <label class="small font-weight-bold text-muted text-uppercase">Hotel Madinah <span class="text-danger">*</span></label>
                                    <input type="text" name="hotel_madinah" class="form-control" placeholder="Nama Hotel Madinah" required>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="small font-weight-bold text-muted text-uppercase">Rating <span class="text-danger">*</span></label>
                                    <select name="hotel_rating" class="form-control" required>
                                        <option value="">★</option>
                                        <option value="3">★★★</option>
                                        <option value="4">★★★★</option>
                                        <option value="5">★★★★★</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <div class="alert alert-info py-2 small">
                                        <i class="mdi mdi-information-outline mr-1"></i>
                                        Tipe kamar <b>(Quad / Triple / Double)</b> dipilih jamaah saat proses <b>booking</b>.
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Section: Detail (Opsional) --}}
                        <div class="border-bottom p-4">
                            <h6 class="text-uppercase text-muted font-weight-bold small mb-3">
                                <i class="mdi mdi-file-document-outline mr-1"></i> Detail Paket (Opsional)
                            </h6>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="small font-weight-bold text-muted text-uppercase">Deskripsi</label>
                                    <textarea name="description" class="form-control" rows="3" placeholder="Deskripsi singkat tentang paket ini..."></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="small font-weight-bold text-muted text-uppercase">Fasilitas Termasuk</label>
                                    <textarea name="includes" class="form-control" rows="4" placeholder="- Tiket pesawat PP&#10;- Hotel bintang 4&#10;- Makan 3x sehari"></textarea>
                                    <small class="text-muted">Pisahkan dengan enter</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="small font-weight-bold text-muted text-uppercase">Tidak Termasuk</label>
                                    <textarea name="excludes" class="form-control" rows="4" placeholder="- Kelebihan bagasi&#10;- Pengeluaran pribadi"></textarea>
                                    <small class="text-muted">Pisahkan dengan enter</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="small font-weight-bold text-muted text-uppercase">Syarat & Ketentuan</label>
                                    <textarea name="terms" class="form-control" rows="3" placeholder="Syarat dan ketentuan..."></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="small font-weight-bold text-muted text-uppercase">Catatan Tambahan</label>
                                    <textarea name="notes" class="form-control" rows="3" placeholder="Catatan penting..."></textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Section: Itinerary --}}
                        <div class="p-4">
                            <h6 class="text-uppercase text-muted font-weight-bold small mb-3">
                                <i class="mdi mdi-map-outline mr-1"></i> Itinerary Perjalanan (Opsional)
                            </h6>
                            <div id="itineraryContainer">
                                <div class="border rounded p-3 mb-3 itinerary-item" data-day="1">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge badge-primary px-3 py-1">Hari 1</span>
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-remove-itinerary" style="display:none;" onclick="removeItinerary(1)">
                                            <i class="mdi mdi-trash-can-outline mr-1"></i> Hapus
                                        </button>
                                    </div>
                                    <input type="hidden" name="itinerary[0][day_number]" value="1">
                                    <div class="mb-2">
                                        <label class="small font-weight-bold text-muted text-uppercase">Judul Kegiatan</label>
                                        <input type="text" name="itinerary[0][title]" class="form-control" placeholder="Contoh: Keberangkatan dari Jakarta">
                                    </div>
                                    <div>
                                        <label class="small font-weight-bold text-muted text-uppercase">Deskripsi</label>
                                        <textarea name="itinerary[0][description]" class="form-control" rows="2" placeholder="Deskripsi detail..."></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="addItinerary()">
                                <i class="mdi mdi-plus-circle-outline mr-1"></i> Tambah Hari Berikutnya
                            </button>
                        </div>

                    </form>
                </div>

                {{-- Modal Footer --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" form="addPackageForm">
                        <i class="mdi mdi-check-circle-outline mr-1"></i> Simpan Paket
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-generate slug
        document.getElementById('packageName').addEventListener('input', function () {
            const slug = this.value.toLowerCase().trim()
                .replace(/[^\w\s-]/g, '').replace(/[\s_-]+/g, '-').replace(/^-+|-+$/g, '');
            document.getElementById('packageSlug').value = slug;
        });

        // Auto-calculate return date
        function calculateReturnDate() {
            const dep  = document.getElementById('departureDate').value;
            const days = parseInt(document.getElementById('durationDays').value);
            if (dep && days) {
                const d = new Date(dep);
                d.setDate(d.getDate() + days - 1);
                document.getElementById('returnDate').value = d.toISOString().split('T')[0];
            }
        }
        document.getElementById('departureDate').addEventListener('change', calculateReturnDate);
        document.getElementById('durationDays').addEventListener('input', calculateReturnDate);

        // Itinerary
        let itineraryCount = 1;
        function addItinerary() {
            itineraryCount++;
            const idx = itineraryCount - 1;
            const html = `
                <div class="border rounded p-3 mb-3 itinerary-item" data-day="${itineraryCount}">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge badge-primary px-3 py-1">Hari ${itineraryCount}</span>
                        <button type="button" class="btn btn-sm btn-outline-danger btn-remove-itinerary" onclick="removeItinerary(${itineraryCount})">
                            <i class="mdi mdi-trash-can-outline mr-1"></i> Hapus
                        </button>
                    </div>
                    <input type="hidden" name="itinerary[${idx}][day_number]" value="${itineraryCount}">
                    <div class="mb-2">
                        <label class="small font-weight-bold text-muted text-uppercase">Judul Kegiatan</label>
                        <input type="text" name="itinerary[${idx}][title]" class="form-control" placeholder="Contoh: Tawaf & Sai">
                    </div>
                    <div>
                        <label class="small font-weight-bold text-muted text-uppercase">Deskripsi</label>
                        <textarea name="itinerary[${idx}][description]" class="form-control" rows="2" placeholder="Deskripsi detail..."></textarea>
                    </div>
                </div>`;
            document.getElementById('itineraryContainer').insertAdjacentHTML('beforeend', html);
            if (itineraryCount > 1) {
                const btn = document.querySelector('.itinerary-item[data-day="1"] .btn-remove-itinerary');
                if (btn) btn.style.display = 'inline-flex';
            }
        }
        function removeItinerary(day) {
            const el = document.querySelector(`.itinerary-item[data-day="${day}"]`);
            if (el) { el.remove(); itineraryCount--; }
            const items = document.querySelectorAll('.itinerary-item');
            if (items.length === 1) {
                const btn = items[0].querySelector('.btn-remove-itinerary');
                if (btn) btn.style.display = 'none';
            }
        }

        // Form submit
        document.getElementById('addPackageForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const fd = new FormData(this);
            if (parseInt(fd.get('quota_used')) > parseInt(fd.get('quota'))) {
                alert('Kuota terpakai tidak boleh lebih dari kuota total!');
                return;
            }
            this.submit();
        });

        // Package type → fetch code + set form action
        document.getElementById('packageType').addEventListener('change', function () {
            const type = this.value;
            if (!type) return;
            document.getElementById('addPackageForm').action = "/package/" + type + "/store";
            fetch("{{ url('/package/get-next-code') }}/" + type)
                .then(r => r.json())
                .then(d => {
                    document.getElementById('packageCodePreview').value = d.code ?? '';
                    document.getElementById('packageCodeReal').value    = d.code ?? '';
                })
                .catch(console.error);
        });

        // Search
        document.getElementById('searchPackages').addEventListener('input', function () {
            const q = this.value.toLowerCase();
            document.querySelectorAll('.package-item').forEach(card => {
                card.style.display = card.innerText.toLowerCase().includes(q) ? '' : 'none';
            });
        });
    </script>
@endsection