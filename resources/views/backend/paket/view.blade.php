@extends('backend.master')

@section('title')
    <title>Detail Paket {{ ucfirst($package->type) }} | Admin</title>
@endsection

@section('content')
    <style>
        .package-hero {
            background: linear-gradient(135deg, #1e1b4b 0%, #4f46e5 100%);
            color: white; padding: 2.5rem; border-radius: 16px; margin-bottom: 2rem;
            position: relative; overflow: hidden;
        }
        .package-hero::before {
            content: ''; position: absolute; top: -40px; right: -40px;
            width: 200px; height: 200px; background: rgba(255,255,255,0.06); border-radius: 50%;
        }
        .info-card {
            border: none; border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            transition: transform 0.2s, box-shadow 0.2s; height: 100%; overflow: hidden;
        }
        .info-card:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(0,0,0,0.1); }
        .price-strip {
            background: linear-gradient(135deg, #f093fb, #f5576c);
            color: white; padding: 1.75rem; border-radius: 14px; text-align: center;
            box-shadow: 0 4px 15px rgba(245,87,108,0.3);
        }
        .price-strip h2 { font-size: 2.2rem; font-weight: 700; margin: 0; }
        .icon-box {
            width: 56px; height: 56px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.6rem; margin-bottom: 0.75rem;
        }
        .itinerary-item {
            border-left: 4px solid #4f46e5; background: #f8f9fa;
            padding: 1.25rem; border-radius: 8px; margin-bottom: 1.25rem;
            position: relative; transition: all 0.2s;
        }
        .itinerary-item:hover { background: #e9ecef; transform: translateX(4px); }
        .itinerary-item::before {
            content: ''; position: absolute; left: -10px; top: 20px;
            width: 16px; height: 16px;
            background: #4f46e5; border-radius: 50%; border: 3px solid white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.15);
        }
        .feature-list { list-style: none; padding: 0; margin: 0; }
        .feature-list li {
            padding: 0.85rem 0; border-bottom: 1px solid #f1f1f4;
            display: flex; align-items: center;
        }
        .feature-list li:last-child { border-bottom: none; padding-bottom: 0; }
        .feature-list li i { color: #4f46e5; margin-right: 0.85rem; font-size: 1.15rem; }
        .info-row {
            display: flex; align-items: center; margin-bottom: 1rem;
            padding: 0.6rem; border-radius: 8px; transition: background 0.2s;
        }
        .info-row:hover { background: #f8f9fa; }
        .info-row i { width: 32px; color: #4f46e5; font-size: 1.2rem; flex-shrink: 0; }
        .info-row small { font-size: 11px; }
    </style>

    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-lg-column py-3 py-lg-6">
            <div class="page-title d-flex align-items-center gap-1 me-3">
                <h1 class="text-gray-900 fw-bolder fs-2x mb-1 lh-1">
                    Detail Paket {{ ucfirst($package->type) }}
                </h1>
            </div>
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-base">
                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                    <a href="" class="text-gray-700 text-hover-primary">
                        <i class="ki-duotone ki-home fs-3 text-gray-500 ms-2"></i>
                    </a>
                </li>
                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-4 text-gray-700 mx-n2"></i></li>
                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                    <a href="" class="text-gray-700 text-hover-primary">Paket {{ ucfirst($package->type) }}</a>
                </li>
                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-4 text-gray-700 mx-n2"></i></li>
                <li class="breadcrumb-item text-gray-500">Detail</li>
            </ul>
        </div>
    </div>
    <!--end::Toolbar-->

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">

            {{-- Hero --}}
            <div class="package-hero">
                <div class="row align-items-center" style="position:relative;z-index:1;">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center flex-wrap mb-2" style="gap:10px;">
                            <h2 class="text-white font-weight-bold mb-0 mr-2">{{ $package->name }}</h2>
                            <span class="badge badge-pill px-3 py-2 font-weight-bold"
                                style="font-size:12px;
                                
                                @if($package->status=='published') background:#28a745;
                                @elseif($package->status=='draft') background:#ffc107;color:#333;
                                @else background:#dc3545; @endif">
                                {{ strtoupper($package->status) }}
                            </span>
                        </div>
                        <p class="text-white-50 mb-0 small">
                            <i class="mdi mdi-calendar-clock mr-1"></i>
                            Keberangkatan: {{ \Carbon\Carbon::parse($package->departure_date)->format('d M Y') }}
                            <span class="mx-2">|</span>
                            <i class="mdi mdi-timer-sand mr-1"></i>
                            {{ $package->duration_days }} Hari
                        </p>
                    </div>
                    <div class="col-md-4 text-md-right mt-3 mt-md-0">
                        <a href="{{ route('package.booking', [$package->type, $package->id]) }}"
                           class="btn btn-light font-weight-bold mr-2">
                            <i class="mdi mdi-calendar-check mr-1"></i> Booking Sekarang
                        </a>
                        <a href="#" class="btn btn-outline-light">
                            <i class="mdi mdi-pencil"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                {{-- LEFT COLUMN --}}
                <div class="col-lg-8">

                    {{-- Quick Stats --}}
                    <div class="row mb-4">
                        <div class="col-md-4 mb-3">
                            <div class="card info-card text-center p-3">
                                <div class="icon-box mx-auto" style="background:rgba(79,70,229,0.1);">
                                    <i class="mdi mdi-airplane" style="color:#4f46e5;font-size:26px;"></i>
                                </div>
                                <div class="text-muted small mb-1">Maskapai</div>
                                <div class="font-weight-bold">{{ $package->airline }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card info-card text-center p-3">
                                <div class="icon-box mx-auto" style="background:rgba(40,167,69,0.1);">
                                    <i class="mdi mdi-account-group" style="color:#28a745;font-size:26px;"></i>
                                </div>
                                <div class="text-muted small mb-1">Kuota Tersedia</div>
                                <div class="font-weight-bold">{{ $package->quota - ($package->quota_used ?? 0) }} / {{ $package->quota }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card info-card text-center p-3">
                                <div class="icon-box mx-auto" style="background:rgba(255,193,7,0.1);">
                                    <i class="mdi mdi-star" style="color:#ffc107;font-size:26px;"></i>
                                </div>
                                <div class="text-muted small mb-1">Rating Hotel</div>
                                <div class="font-weight-bold">{{ $package->hotel_rating }} ⭐</div>
                            </div>
                        </div>
                    </div>

                    {{-- Detail Info --}}
                    <div class="card info-card mb-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="mb-0 font-weight-bold">
                                <i class="mdi mdi-information-outline text-primary mr-2"></i>Detail Paket
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-row">
                                        <i class="mdi mdi-tag-outline"></i>
                                        <div><small class="text-muted d-block">Kode Paket</small><strong>{{ $package->code }}</strong></div>
                                    </div>
                                    <div class="info-row">
                                        <i class="mdi mdi-link-variant"></i>
                                        <div><small class="text-muted d-block">Slug</small><strong>{{ $package->slug }}</strong></div>
                                    </div>
                                    <div class="info-row">
                                        <i class="mdi mdi-map-marker-outline"></i>
                                        <div><small class="text-muted d-block">Kota Keberangkatan</small><strong>{{ $package->departure_city }}</strong></div>
                                    </div>
                                    <div class="info-row">
                                        <i class="mdi mdi-map-marker-check-outline"></i>
                                        <div><small class="text-muted d-block">Kota Tujuan</small><strong>{{ $package->destination_city }}</strong></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-row">
                                        <i class="mdi mdi-office-building-outline"></i>
                                        <div><small class="text-muted d-block">Hotel Makkah</small><strong>{{ $package->hotel_makkah }}</strong></div>
                                    </div>
                                    <div class="info-row">
                                        <i class="mdi mdi-office-building-outline"></i>
                                        <div><small class="text-muted d-block">Hotel Madinah</small><strong>{{ $package->hotel_madinah }}</strong></div>
                                    </div>
                                    <div class="info-row">
                                        <i class="mdi mdi-calendar-range"></i>
                                        <div><small class="text-muted d-block">Durasi</small><strong>{{ $package->duration_days }} Hari</strong></div>
                                    </div>
                                    <div class="info-row">
                                        <i class="mdi mdi-format-list-bulleted"></i>
                                        <div><small class="text-muted d-block">Tipe Paket</small><strong>{{ ucfirst($package->type) }}</strong></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($package->detail)
                    {{-- Deskripsi --}}
                    <div class="card info-card mb-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="mb-0 font-weight-bold">
                                <i class="mdi mdi-file-document-outline text-primary mr-2"></i>Deskripsi
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-0">{!! nl2br(e($package->detail->description)) !!}</p>
                        </div>
                    </div>

                    {{-- Includes & Excludes --}}
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="card info-card h-100">
                                <div class="card-header bg-white border-bottom py-3">
                                    <h5 class="mb-0 font-weight-bold">
                                        <i class="mdi mdi-check-circle-outline text-success mr-2"></i>Termasuk
                                    </h5>
                                </div>
                                <div class="card-body text-muted">{!! nl2br(e($package->detail->includes)) !!}</div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card info-card h-100">
                                <div class="card-header bg-white border-bottom py-3">
                                    <h5 class="mb-0 font-weight-bold">
                                        <i class="mdi mdi-close-circle-outline text-danger mr-2"></i>Tidak Termasuk
                                    </h5>
                                </div>
                                <div class="card-body text-muted">{!! nl2br(e($package->detail->excludes)) !!}</div>
                            </div>
                        </div>
                    </div>

                    {{-- Syarat --}}
                    <div class="card info-card mb-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="mb-0 font-weight-bold">
                                <i class="mdi mdi-clipboard-check-outline text-primary mr-2"></i>Syarat & Ketentuan
                            </h5>
                        </div>
                        <div class="card-body text-muted">{!! nl2br(e($package->detail->terms)) !!}</div>
                    </div>
                    @endif

                    {{-- Itinerary --}}
                    <div class="card info-card mb-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="mb-0 font-weight-bold">
                                <i class="mdi mdi-map-outline text-primary mr-2"></i>Itinerary Perjalanan
                            </h5>
                        </div>
                        <div class="card-body">
                            @forelse($package->itineraries as $item)
                            <div class="itinerary-item">
                                <span class="badge badge-primary px-3 py-1 mb-2">Hari {{ $item->day_number }}</span>
                                <h6 class="font-weight-bold mb-1">{{ $item->title }}</h6>
                                <p class="text-muted mb-0 small">{{ $item->description }}</p>
                            </div>
                            @empty
                            <div class="text-center py-4">
                                <i class="mdi mdi-inbox-outline text-muted" style="font-size:3rem;"></i>
                                <p class="text-muted mt-2 mb-0">Belum ada itinerary tersedia.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                </div>

                {{-- RIGHT COLUMN --}}
                <div class="col-lg-4">
                    <div class="sticky-top" style="top:80px;">

                        {{-- Main Price --}}
                        <div class="price-strip mb-4">
                            <p class="mb-1 small" style="opacity:.85;">Mulai dari</p>
                            <h2>Rp {{ number_format($package->price) }}</h2>
                            <p class="mb-0 small" style="opacity:.85;">Per Orang (Quad)</p>
                        </div>

                        {{-- Price Detail --}}
                        <div class="card info-card mb-4">
                            <div class="card-header bg-white border-bottom py-3">
                                <h6 class="mb-0 font-weight-bold">Rincian Harga</h6>
                            </div>
                            <div class="card-body p-0">
                                <ul class="feature-list px-3 py-2">
                                    <li>
                                        <i class="mdi mdi-account-multiple-outline"></i>
                                        <div class="flex-grow-1 d-flex justify-content-between">
                                            <span>Harga Quad</span>
                                            <strong>Rp {{ number_format($package->price) }}</strong>
                                        </div>
                                    </li>
                                    <li>
                                        <i class="mdi mdi-account-multiple-outline"></i>
                                        <div class="flex-grow-1 d-flex justify-content-between">
                                            <span>Harga Triple</span>
                                            <strong>Rp {{ number_format($package->price_triple) }}</strong>
                                        </div>
                                    </li>
                                    <li>
                                        <i class="mdi mdi-account-multiple-outline"></i>
                                        <div class="flex-grow-1 d-flex justify-content-between">
                                            <span>Harga Double</span>
                                            <strong>Rp {{ number_format($package->price_double) }}</strong>
                                        </div>
                                    </li>
                                    <li>
                                        <i class="mdi mdi-cash-multiple"></i>
                                        <div class="flex-grow-1 d-flex justify-content-between">
                                            <span>Down Payment (DP)</span>
                                            <strong class="text-primary">Rp {{ number_format($package->dp) }}</strong>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="card info-card mb-4">
                            <div class="card-body">
                                <a href="{{ route('package.booking', [$package->type, $package->id]) }}"
                                   class="btn btn-primary btn-block py-3 font-weight-bold mb-2">
                                    <i class="mdi mdi-calendar-check mr-1"></i> Booking Paket Ini
                                </a>
                                <a href="https://wa.me/{{ config('app.whatsapp_number') }}?text=Halo, saya tertarik dengan paket {{ urlencode($package->name) }}"
                                   target="_blank" class="btn btn-outline-success btn-block mb-2">
                                    <i class="mdi mdi-whatsapp mr-1"></i> Hubungi via WhatsApp
                                </a>
                                <a href="#" class="btn btn-outline-secondary btn-block">
                                    <i class="mdi mdi-download mr-1"></i> Download Brosur
                                </a>
                            </div>
                        </div>

                        {{-- Info Penting --}}
                        <div class="card info-card">
                            <div class="card-header bg-white border-bottom py-3">
                                <h6 class="mb-0 font-weight-bold">
                                    <i class="mdi mdi-information-outline text-primary mr-1"></i> Informasi Penting
                                </h6>
                            </div>
                            <div class="card-body p-0">
                                <ul class="feature-list px-3 py-2">
                                    <li>
                                        <i class="mdi mdi-shield-check-outline"></i>
                                        <small>Harga sudah termasuk tiket pesawat</small>
                                    </li>
                                    <li>
                                        <i class="mdi mdi-office-building-outline"></i>
                                        <small>Hotel bintang {{ $package->hotel_rating }}</small>
                                    </li>
                                    <li>
                                        <i class="mdi mdi-clock-outline"></i>
                                        <small>Free konsultasi 24/7</small>
                                    </li>
                                    <li>
                                        <i class="mdi mdi-medal-outline"></i>
                                        <small>Pembimbing berpengalaman</small>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection