@extends('backend.master')

@section('content')
    <style>
        .booking-header-card {
            background: linear-gradient(135deg, #1e1b4b 0%, #3730a3 60%, #4f46e5 100%);
            border-radius: 16px;
            padding: 32px 36px;
            margin-bottom: 28px;
            position: relative;
            overflow: hidden;
        }
        .booking-header-card::before {
            content: '';
            position: absolute;
            top: -40px; right: -40px;
            width: 220px; height: 220px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }
        .booking-header-card::after {
            content: '';
            position: absolute;
            bottom: -60px; left: 30%;
            width: 300px; height: 160px;
            background: rgba(255,255,255,0.04);
            border-radius: 50%;
        }
        .booking-header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            z-index: 1;
        }
        .booking-header-left { display: flex; align-items: center; gap: 20px; }
        .booking-icon-wrapper {
            width: 64px; height: 64px;
            background: rgba(255,255,255,0.15);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 28px;
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.2);
        }
        .booking-header-title { font-size: 24px; font-weight: 700; color: #fff; margin: 0 0 4px; }
        .booking-header-subtitle { font-size: 14px; color: rgba(255,255,255,0.7); margin: 0; }
        .booking-type-badge {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            color: #fff;
            font-size: 12px; font-weight: 600;
            letter-spacing: 1px; text-transform: uppercase;
            padding: 6px 16px; border-radius: 50px;
            backdrop-filter: blur(8px);
        }
        .booking-main-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #f1f1f4;
            box-shadow: 0 4px 24px rgba(0,0,0,0.06);
            overflow: hidden;
        }
        .form-section {
            padding: 28px 32px;
            border-bottom: 1px solid #f1f1f4;
        }
        .form-section:last-child { border-bottom: none; }
        .section-header { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
        .section-title { font-size: 14px; font-weight: 700; color: #1e1b4b; margin: 0; text-transform: uppercase; letter-spacing: 0.5px; }
        .section-icon-wrap {
            width: 32px; height: 32px;
            background: #eff6ff; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
        }
        .modern-label {
            display: block; font-size: 12px; font-weight: 600;
            color: #78788c; margin-bottom: 8px;
            text-transform: uppercase; letter-spacing: 0.5px;
        }
        .required { color: #f1416c; margin-left: 2px; }
        .modern-input, .modern-select {
            width: 100%; height: 44px;
            border: 1.5px solid #e9e9ef; border-radius: 10px;
            background: #fafafa; font-size: 14px; color: #1e1e2d;
            padding: 0 14px;
            transition: all 0.2s ease; outline: none; font-family: inherit;
        }
        .modern-input:focus, .modern-select:focus {
            border-color: #4f46e5; background: #fff;
            box-shadow: 0 0 0 3px rgba(79,70,229,0.08);
        }
        .modern-input.has-icon { padding-left: 42px; }
        .input-with-icon { position: relative; }
        .input-icon {
            position: absolute; left: 14px; top: 50%;
            transform: translateY(-50%);
            color: #a1a5b7; pointer-events: none; font-size: 16px;
        }
        .form-hint { font-size: 11px; color: #a1a5b7; margin-top: 5px; display: block; }
        .room-options-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 12px; }
        .room-radio { display: none; }
        .room-card-label { cursor: pointer; display: block; }
        .room-card-box {
            border: 1.5px solid #e9e9ef; border-radius: 12px;
            padding: 18px 14px; text-align: center;
            transition: all 0.2s ease; background: #fafafa; position: relative;
        }
        .room-card-box:hover { border-color: #4f46e5; background: #f5f4ff; }
        .room-radio:checked + .room-card-label .room-card-box {
            border-color: #4f46e5; background: #f5f4ff;
            box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
        }
        .room-radio:checked + .room-card-label .room-check-dot { display: flex; }
        .room-check-dot {
            display: none; position: absolute; top: 10px; right: 10px;
            width: 20px; height: 20px;
            background: #4f46e5; border-radius: 50%;
            align-items: center; justify-content: center;
            color: #fff; font-size: 10px;
        }
        .room-type-name { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; color: #a1a5b7; margin-bottom: 6px; }
        .room-type-price { font-size: 18px; font-weight: 700; color: #1e1e2d; line-height: 1; }
        .room-type-unit { font-size: 11px; color: #a1a5b7; margin-top: 4px; }
        .dp-alert-block {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            border: 1px solid #f59e0b; border-radius: 12px;
            padding: 18px 20px;
            display: flex; align-items: center; justify-content: space-between; gap: 12px;
        }
        .dp-alert-left { display: flex; align-items: center; gap: 12px; }
        .dp-icon {
            width: 40px; height: 40px;
            background: #f59e0b; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 18px; flex-shrink: 0;
        }
        .dp-label { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #92400e; margin-bottom: 2px; }
        .dp-desc { font-size: 12px; color: #b45309; }
        .dp-amount { font-size: 22px; font-weight: 800; color: #92400e; white-space: nowrap; }
        .package-info-strip {
            background: #f8f9ff; border: 1px solid #e8e8f5; border-radius: 12px;
            padding: 16px 20px; display: flex; flex-wrap: wrap; gap: 16px;
            margin-bottom: 24px;
        }
        .pkg-info-item { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #4b5563; }
        .pkg-info-item i { color: #4f46e5; }
        .pkg-info-item strong { color: #1e1e2d; }
        .booking-form-footer {
            padding: 24px 32px;
            background: #fafafa; border-top: 1px solid #f1f1f4;
            display: flex; align-items: center; justify-content: space-between; gap: 16px;
            border-radius: 0 0 16px 16px;
        }
        .btn-back {
            display: inline-flex; align-items: center; gap: 8px;
            height: 44px; padding: 0 20px;
            background: #f1f1f4; color: #5e6278;
            border: none; border-radius: 10px;
            font-size: 14px; font-weight: 600;
            cursor: pointer; text-decoration: none;
            transition: all 0.2s ease;
        }
        .btn-back:hover { background: #e9e9ef; color: #1e1e2d; text-decoration: none; }
        .btn-submit-booking {
            display: inline-flex; align-items: center; gap: 8px;
            height: 44px; padding: 0 28px;
            background: linear-gradient(135deg, #4f46e5, #6d28d9);
            color: #fff; border: none; border-radius: 10px;
            font-size: 14px; font-weight: 600; cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(79,70,229,0.3);
        }
        .btn-submit-booking:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(79,70,229,0.4); }
        /* Jamaah cards */
        .jamaah-summary-bar {
            background: linear-gradient(135deg, #1e1b4b 0%, #3730a3 100%);
            border-radius: 12px; padding: 14px 20px;
            display: flex; align-items: center;
            margin-bottom: 20px; flex-wrap: wrap;
        }
        .jsb-item { flex: 1; text-align: center; min-width: 100px; }
        .jsb-divider { width: 1px; height: 36px; background: rgba(255,255,255,0.15); flex-shrink: 0; }
        .jsb-label { font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: .6px; color: rgba(255,255,255,0.55); margin-bottom: 4px; }
        .jsb-value { font-size: 15px; font-weight: 700; color: #fff; }
        #jamaah-container { display: flex; flex-direction: column; gap: 12px; }
        .jamaah-card {
            border: 1.5px solid #e9e9ef; border-radius: 12px; overflow: hidden;
            animation: jcSlideIn .22s ease-out; transition: box-shadow .2s;
        }
        .jamaah-card:hover { box-shadow: 0 4px 20px rgba(79,70,229,0.08); }
        @keyframes jcSlideIn { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }
        .jamaah-card-header {
            background: linear-gradient(135deg, #312e81 0%, #4f46e5 100%);
            padding: 12px 18px; display: flex; align-items: center; justify-content: space-between;
        }
        .jch-left { display: flex; align-items: center; gap: 10px; }
        .jch-num {
            width: 26px; height: 26px;
            background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700; color: #fff;
        }
        .jch-title { font-size: 13px; font-weight: 700; color: #fff; }
        .jch-sub { font-size: 11px; color: rgba(255,255,255,0.6); margin-top: 1px; }
        .jch-remove {
            width: 28px; height: 28px;
            background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.25);
            border-radius: 7px; display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 13px; cursor: pointer; transition: background .2s; line-height: 1;
        }
        .jch-remove:hover { background: rgba(255,255,255,0.25); }
        .jamaah-card-body { background: #fff; padding: 18px; display: flex; flex-direction: column; gap: 16px; }
        .btn-add-jamaah {
            width: 100%; margin-top: 14px; padding: 12px;
            border: 2px dashed #c7c7f0; border-radius: 12px;
            background: transparent; color: #4f46e5; font-family: inherit;
            font-size: 13px; font-weight: 700; cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            transition: all .2s;
        }
        .btn-add-jamaah:hover { background: #f5f4ff; border-color: #4f46e5; }
        .btn-add-jamaah .baj-icon {
            width: 22px; height: 22px;
            background: #4f46e5; color: #fff; border-radius: 6px;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; line-height: 1; flex-shrink: 0;
        }
        @media (max-width: 576px) {
            .form-section { padding: 20px 18px; }
            .booking-form-footer { flex-direction: column; }
            .btn-submit-booking, .btn-back { width: 100%; justify-content: center; }
            .room-options-grid { grid-template-columns: 1fr; }
            .booking-header-content { flex-direction: column; align-items: flex-start; gap: 16px; }
            .dp-alert-block { flex-direction: column; align-items: flex-start; }
            .jsb-divider { display: none; }
        }
    </style>

    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-lg-column py-3 py-lg-6">
            <div class="page-title d-flex align-items-center gap-1 me-3">
                <h1 class="text-gray-900 fw-bolder fs-2x mb-1 lh-1">Booking</h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-base ms-3">
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                        <a href="#" class="text-gray-700 text-hover-primary">
                            <i class="ki-duotone ki-home fs-3 text-gray-500 ms-2"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-4 text-gray-700 mx-n2"></i></li>
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Paket</li>
                    <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-4 text-gray-700 mx-n2"></i></li>
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                        <a href="" class="text-gray-700 text-hover-primary">{{ ucfirst($package->type) }}</a>
                    </li>
                    <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-4 text-gray-700 mx-n2"></i></li>
                    <li class="breadcrumb-item text-gray-500">Booking</li>
                </ul>
            </div>
            <div class="app-toolbar-container-separator separator d-none d-lg-flex"></div>
        </div>
    </div>
    <!--end::Toolbar-->

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">

            {{-- Header Card --}}
            <div class="booking-header-card">
                <div class="booking-header-content">
                    <div class="booking-header-left">
                        <div class="booking-icon-wrapper">🕌</div>
                        <div>
                            <h2 class="booking-header-title">{{ $package->name }}</h2>
                            <p class="booking-header-subtitle">Lengkapi formulir untuk mengkonfirmasi reservasi Anda</p>
                        </div>
                    </div>
                    <div class="booking-type-badge">{{ strtoupper($package->type) }}</div>
                </div>
            </div>

            {{-- Package Summary Strip --}}
            <div class="package-info-strip">
                <div class="pkg-info-item">
                    <i class="mdi mdi-calendar"></i>
                    <span>Keberangkatan: <strong>{{ \Carbon\Carbon::parse($package->departure_date)->translatedFormat('d F Y') }}</strong></span>
                </div>
                <div class="pkg-info-item">
                    <i class="mdi mdi-clock-outline"></i>
                    <span>Durasi: <strong>{{ $package->program_days }} Hari</strong></span>
                </div>
                <div class="pkg-info-item">
                    <i class="mdi mdi-airplane"></i>
                    <span>Maskapai: <strong>{{ $package->airline }}</strong></span>
                </div>
                <div class="pkg-info-item">
                    <i class="mdi mdi-account-group"></i>
                    <span>Tersedia: <strong>{{ $package->quota - $package->quota_used }} seat</strong></span>
                </div>
            </div>

            {{-- Main Form Card --}}
            <div class="booking-main-card">
                <form method="POST" action="{{ route('booking.store', [$package->type, $package->id]) }}" id="bookingForm">
                    @csrf

                    {{-- Section 1: Data Pemesan --}}
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-icon-wrap">
                                <i class="mdi mdi-account-circle text-primary" style="font-size:18px;"></i>
                            </div>
                            <h6 class="section-title">Data Pemesan</h6>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="modern-label">Nama Lengkap <span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <i class="mdi mdi-account input-icon"></i>
                                    <input type="text" name="full_name"
                                        class="modern-input has-icon @error('full_name') border-danger @enderror"
                                        placeholder="Masukkan nama lengkap" value="{{ old('full_name') }}" required>
                                </div>
                                @error('full_name')<span class="form-hint text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="modern-label">No. Handphone <span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <i class="mdi mdi-phone input-icon"></i>
                                    <input type="tel" name="phone"
                                        class="modern-input has-icon @error('phone') border-danger @enderror"
                                        placeholder="Contoh: 081234567890" value="{{ old('phone') }}" required>
                                </div>
                                @error('phone')<span class="form-hint text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-12">
                                <label class="modern-label">Tipe Kamar <span class="required">*</span></label>
                                <div class="room-options-grid">
                                    <input type="radio" name="room_type" value="quad" id="room_quad" class="room-radio" required>
                                    <label for="room_quad" class="room-card-label">
                                        <div class="room-card-box">
                                            <div class="room-check-dot">✓</div>
                                            <div class="room-type-name">Quad</div>
                                            <div class="room-type-price">Rp {{ number_format($package->price / 1000000, 1) }}Jt</div>
                                            <div class="room-type-unit">per orang / 4 pax</div>
                                        </div>
                                    </label>
                                    <input type="radio" name="room_type" value="triple" id="room_triple" class="room-radio">
                                    <label for="room_triple" class="room-card-label">
                                        <div class="room-card-box">
                                            <div class="room-check-dot">✓</div>
                                            <div class="room-type-name">Triple</div>
                                            <div class="room-type-price">Rp {{ number_format($package->price_triple / 1000000, 1) }}Jt</div>
                                            <div class="room-type-unit">per orang / 3 pax</div>
                                        </div>
                                    </label>
                                    <input type="radio" name="room_type" value="double" id="room_double" class="room-radio">
                                    <label for="room_double" class="room-card-label">
                                        <div class="room-card-box">
                                            <div class="room-check-dot">✓</div>
                                            <div class="room-type-name">Double</div>
                                            <div class="room-type-price">Rp {{ number_format($package->price_double / 1000000, 1) }}Jt</div>
                                            <div class="room-type-unit">per orang / 2 pax</div>
                                        </div>
                                    </label>
                                </div>
                                @error('room_type')<span class="form-hint text-danger mt-2 d-block">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- Section 2: Data Jamaah --}}
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-icon-wrap">
                                <i class="mdi mdi-account-multiple text-primary" style="font-size:18px;"></i>
                            </div>
                            <h6 class="section-title">Data Jamaah</h6>
                        </div>
                        <div class="jamaah-summary-bar">
                            <div class="jsb-item">
                                <div class="jsb-label">Jumlah Jamaah</div>
                                <div class="jsb-value" id="jsb-count">1 Orang</div>
                            </div>
                            <div class="jsb-divider"></div>
                            <div class="jsb-item">
                                <div class="jsb-label">Total DP</div>
                                <div class="jsb-value" id="jsb-dp">Rp {{ number_format($package->dp) }}</div>
                            </div>
                            <div class="jsb-divider"></div>
                            <div class="jsb-item">
                                <div class="jsb-label">Kamar Terpilih</div>
                                <div class="jsb-value" id="jsb-room">—</div>
                            </div>
                        </div>
                        <div id="jamaah-container">
                            <div class="jamaah-card" data-index="1">
                                <div class="jamaah-card-header">
                                    <div class="jch-left">
                                        <div class="jch-num">1</div>
                                        <div>
                                            <div class="jch-title">Jamaah 1</div>
                                            <div class="jch-sub">Data utama jamaah</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="jamaah-card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="modern-label">Nama Jamaah <span class="required">*</span></label>
                                            <div class="input-with-icon">
                                                <i class="mdi mdi-account input-icon"></i>
                                                <input type="text" name="jamaah[0][name]" class="modern-input has-icon" placeholder="Nama lengkap jamaah" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="modern-label">No. Handphone <span class="required">*</span></label>
                                            <div class="input-with-icon">
                                                <i class="mdi mdi-phone input-icon"></i>
                                                <input type="tel" name="jamaah[0][phone]" class="modern-input has-icon" placeholder="08xxxxxxxxxx" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn-add-jamaah" id="addJamaahBtn">
                            <span class="baj-icon">+</span>
                            Tambah Jamaah
                        </button>
                    </div>

                    {{-- Section 3: Info DP --}}
                    <div class="form-section">
                        <div class="dp-alert-block">
                            <div class="dp-alert-left">
                                <div class="dp-icon">💰</div>
                                <div>
                                    <div class="dp-label">Down Payment (DP) per Jamaah</div>
                                    <div class="dp-desc">Bayar DP terlebih dahulu untuk mengamankan seat Anda</div>
                                </div>
                            </div>
                            <div class="dp-amount">Rp {{ number_format($package->dp) }}</div>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="booking-form-footer">
                        <a href="{{ url()->previous() }}" class="btn-back">
                            ← Kembali
                        </a>
                        <button type="submit" class="btn-submit-booking">
                            ✓ Konfirmasi Booking
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script>
        (function () {
            const dpPerJamaah = {{ $package->dp }};
            const container   = document.getElementById('jamaah-container');
            const addBtn      = document.getElementById('addJamaahBtn');
            const jsbCount    = document.getElementById('jsb-count');
            const jsbDP       = document.getElementById('jsb-dp');
            const jsbRoom     = document.getElementById('jsb-room');
            const roomLabels  = { quad: 'Quad', triple: 'Triple', double: 'Double' };
            let count = 1;

            const fmt = n => 'Rp ' + new Intl.NumberFormat('id-ID').format(n);

            function updateSummary() {
                const n = container.querySelectorAll('.jamaah-card').length;
                jsbCount.textContent = n + ' Orang';
                jsbDP.textContent    = fmt(n * dpPerJamaah);
                const checked = document.querySelector('input[name="room_type"]:checked');
                jsbRoom.textContent  = checked ? roomLabels[checked.value] : '—';
            }

            document.querySelectorAll('input[name="room_type"]').forEach(r =>
                r.addEventListener('change', updateSummary)
            );

            function buildCard(index) {
                const idx  = index - 1;
                const card = document.createElement('div');
                card.className   = 'jamaah-card';
                card.dataset.index = index;
                card.innerHTML = `
                    <div class="jamaah-card-header">
                        <div class="jch-left">
                            <div class="jch-num">${index}</div>
                            <div>
                                <div class="jch-title">Jamaah ${index}</div>
                                <div class="jch-sub">Data jamaah tambahan</div>
                            </div>
                        </div>
                        <button type="button" class="jch-remove" title="Hapus">✕</button>
                    </div>
                    <div class="jamaah-card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="modern-label">Nama Jamaah <span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <i class="mdi mdi-account input-icon"></i>
                                    <input type="text" name="jamaah[${idx}][name]" class="modern-input has-icon" placeholder="Nama lengkap jamaah" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="modern-label">No. Handphone <span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <i class="mdi mdi-phone input-icon"></i>
                                    <input type="tel" name="jamaah[${idx}][phone]" class="modern-input has-icon" placeholder="08xxxxxxxxxx" required>
                                </div>
                            </div>
                        </div>
                    </div>`;
                card.querySelector('.jch-remove').addEventListener('click', function () {
                    card.style.transition = 'opacity .18s, transform .18s';
                    card.style.opacity    = '0';
                    card.style.transform  = 'translateY(-8px)';
                    setTimeout(() => { card.remove(); reNumber(); updateSummary(); }, 180);
                });
                return card;
            }

            function reNumber() {
                container.querySelectorAll('.jamaah-card').forEach((c, i) => {
                    c.querySelector('.jch-num').textContent   = i + 1;
                    c.querySelector('.jch-title').textContent = 'Jamaah ' + (i + 1);
                });
                count = container.querySelectorAll('.jamaah-card').length;
            }

            addBtn.addEventListener('click', function () {
                count++;
                const card = buildCard(count);
                container.appendChild(card);
                card.querySelector('input[type=text]').focus();
                updateSummary();
            });

            updateSummary();
        })();
    </script>
@endsection