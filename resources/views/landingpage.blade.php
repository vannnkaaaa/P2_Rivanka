<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Rivanka | Travel Umrah & Haji</title>

    <link rel="apple-touch-icon" sizes="180x180" href="assets2/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets2/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets2/img/favicons/favicon-16x16.png">
    <link rel="shortcut icon" type="image/x-icon" href="assets2/img/favicons/favicon.ico">
    <meta name="theme-color" content="#ffffff">

    <link href="{{ asset('assets2/vendors/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets2/vendors/hamburgers/hamburgers.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets2/vendors/loaders.css/loaders.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets2/css/theme.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets2/css/user.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets2/css/custom.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/haji-packages.css') }}" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600&family=Jost:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        /* ── CSS VARIABLES ── */
        :root {
            --emerald: #1a6b52;
            --emerald-mid: #2a8a69;
            --emerald-light: #e8f5f0;
            --emerald-pale: #f2faf7;
            --gold: #F59E0B;
            --ink: #111827;
            --ink-mid: #374151;
            --ink-soft: #6b7280;
            --ink-faint: #9ca3af;
            --border: #e5e7eb;
            --bg: #f9fafb;
            --white: #ffffff;
            --radius-card: 18px;
            --radius-sm: 10px;
            --radius-xs: 6px;
            --shadow-sm: 0 1px 4px rgba(0, 0, 0, 0.06), 0 4px 16px rgba(0, 0, 0, 0.05);
            --shadow-hover: 0 8px 40px rgba(0, 0, 0, 0.13);
            --transition: 0.28s cubic-bezier(0.22, 0.68, 0, 1.2);
        }

        /* ── SECTION HAJI HEADER ── */
        .haji-section-header {
            text-align: center;
            padding: 60px 0 20px;
        }

        .haji-section-label {
            display: inline-block;
            background: var(--emerald-light);
            color: var(--emerald);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            padding: 5px 14px;
            border-radius: 100px;
            margin-bottom: 14px;
        }

        .haji-section-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 2rem;
            font-weight: 800;
            color: var(--ink);
            margin-bottom: 10px;
            letter-spacing: -0.02em;
        }

        .haji-section-desc {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.95rem;
            color: var(--ink-soft);
            margin-bottom: 0;
        }

        /* ── FILTER BAR ── */
        .haji-filter-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            padding: 24px 0 8px;
        }

        .haji-filter-left {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.85rem;
            color: var(--ink-soft);
        }

        .haji-filter-left b {
            color: var(--ink);
            font-weight: 700;
        }

        .haji-filter-right {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .haji-filter-chip {
            padding: 6px 14px;
            border-radius: 100px;
            border: 1.5px solid var(--border);
            background: var(--white);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--ink-mid);
            cursor: pointer;
            transition: all 0.18s;
            text-decoration: none;
        }

        .haji-filter-chip:hover,
        .haji-filter-chip.active {
            background: var(--emerald);
            border-color: var(--emerald);
            color: #fff;
        }

        /* ── CARDS GRID ── */
        .haji-cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 24px;
            padding: 24px 0 48px;
        }

        /* ── EMPTY STATE ── */
        .haji-empty {
            grid-column: 1 / -1;
            text-align: center;
            padding: 80px 20px;
        }

        .haji-empty-icon {
            font-size: 4rem;
            margin-bottom: 16px;
            display: block;
        }

        .haji-empty-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 8px;
        }

        .haji-empty-desc {
            font-size: 0.875rem;
            color: var(--ink-soft);
        }

        /* ── BTN DETAIL (landing — solid green) ── */
        .haji-btn-detail {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 100%;
            padding: 13px 20px;
            background: var(--emerald);
            color: #fff !important;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.875rem;
            font-weight: 700;
            border: none;
            border-radius: var(--radius-sm);
            cursor: pointer;
            text-decoration: none !important;
            transition: opacity 0.2s, transform 0.15s;
        }

        .haji-btn-detail::after {
            content: '→';
            transition: transform 0.2s;
        }

        .haji-btn-detail:hover {
            opacity: 0.88;
            transform: scale(0.99);
        }

        .haji-btn-detail:hover::after {
            transform: translateX(4px);
        }

        /* ── PAGINATION ── */
        .packages-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            padding: 24px 0 48px;
            border-top: 1px solid var(--border);
        }

        .pagination-info {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.82rem;
            color: var(--ink-soft);
        }

        .pagination-info b {
            color: var(--ink);
            font-weight: 700;
        }

        .pagination {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .page-btn {
            padding: 8px 16px;
            border-radius: var(--radius-xs);
            border: 1.5px solid var(--border);
            background: var(--white);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--ink-mid);
            cursor: pointer;
            transition: all 0.18s;
            min-width: 40px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }

        .page-btn:hover:not(.disabled):not(.active) {
            background: var(--emerald-light);
            border-color: var(--emerald);
            color: var(--emerald);
        }

        .page-btn.active {
            background: var(--emerald);
            border-color: var(--emerald);
            color: #fff;
        }

        .page-btn.disabled {
            opacity: 0.4;
            cursor: not-allowed;
            pointer-events: none;
        }

        /* Stars */
        .star-filled {
            color: #F59E0B !important;
            font-size: 1rem;
        }

        .star-empty {
            color: #D1D5DB !important;
            font-size: 1rem;
        }

        @media (max-width: 768px) {
            .haji-cards-grid {
                grid-template-columns: 1fr;
            }

            .haji-section-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="fixed-top">
        <div class="container px-0">
            <nav class="navbar navbar-expand-lg navbar-freya navbar-light">
                <a class="navbar-brand" href="index.html">
                    <div class="freya-logo">
                        <img src="assets2/img/favicons/favicon.ico" alt="Logo"
                            style="width:24px; height:24px; margin-right:8px;">
                        رزقية للسفريات
                    </div>
                </a>
                <button class="navbar-toggler p-0 border-0" type="button" data-bs-toggle="collapse"
                    data-bs-target="#primaryNavbarCollapse" aria-controls="primaryNavbarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="hamburger hamburger--emphatic"><span class="hamburger-box"><span
                                class="hamburger-inner"></span></span></span>
                </button>
                <div class="collapse navbar-collapse" id="primaryNavbarCollapse">
                    <ul class="navbar-nav py-3 py-lg-0 mt-1 mb-2 my-lg-0 ms-lg-n1">
                        <li class="nav-item"><a class="nav-link" href="/">Beranda</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle dropdown-indicator" href="JavaScript:void(0)"
                                role="button" data-bs-toggle="dropdown">Tentang Rivanka Travel</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Tentang Kami</a></li>
                                <li><a class="dropdown-item" href="#">Cabang Kami</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle dropdown-indicator" href="JavaScript:void(0)"
                                role="button" data-bs-toggle="dropdown">Paket Rivanka Travel</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Umrah</a></li>
                                <li><a class="dropdown-item" href="#paket-haji">Haji</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle dropdown-indicator" href="JavaScript:void(0)"
                                role="button" data-bs-toggle="dropdown">Galleri & Artikel</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Galeri</a></li>
                                <li><a class="dropdown-item" href="#">Artikel</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#">Contact Us</a></li>
                    </ul>
                    <ul class="navbar-nav ms-lg-auto flex-row justify-content-center py-3 py-lg-0 me-n2">
                        <li><a class="nav-link px-2" href="#"><span class="fab fa-facebook-f"></span></a></li>
                        <li><a class="nav-link px-2" href="#"><span class="fab fa-instagram"></span></a></li>
                        <li>
                            <a class="nav-link px-2 d-flex align-items-center" href="{{ route('login') }}">
                                <span class="fas fa-sign-in-alt me-1"></span>
                                <span>Login</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>

    <main class="main" id="top">
        <div class="preloader" id="preloader">
            <div class="loader-box">
                <div class="loader"></div>
            </div>
        </div>

        {{-- ── HERO SLIDER ── --}}
        <section class="py-0">
            <div class="swiper theme-slider min-vh-100"
                data-swiper='{"loop":true,"allowTouchMove":false,"autoplay":{"delay":5000},"effect":"fade","speed":800}'>
                <div class="swiper-wrapper">
                    <div class="swiper-slide" data-zanim-timeline="{}">
                        <div class="bg-holder overlay overlay-freya"
                            style="background-image:url(assets2/img/header_1.jpg);" data-parallax="data-parallax"
                            data-rellax-speed="-3"></div>
                        <div class="container">
                            <div class="row min-vh-100 justify-content-start align-items-end pt-11 pb-6 text-white"
                                data-zanim-timeline="{}">
                                <div class="col">
                                    <div class="row align-items-end">
                                        <div class="col-lg">
                                            <div class="overflow-hidden">
                                                <p class="mb-1 text-uppercase ls"
                                                    data-zanim-xs='{"from":{"opacity":0,"x":-30},"to":{"opacity":1,"x":0},"delay":0.1}'>
                                                    Rivanka Travel</p>
                                            </div>
                                            <div class="overflow-hidden">
                                                <h2 class="text-white fw-normal mb-4 mb-lg-0"
                                                    data-zanim-xs='{"from":{"opacity":0,"x":-30},"to":{"opacity":1,"x":0},"delay":0}'>
                                                    Perjalanan Suci Terpercaya</h2>
                                            </div>
                                        </div>
                                        <div class="col text-lg-end">
                                            <div class="overflow-hidden">
                                                <div
                                                    data-zanim-xs='{"from":{"opacity":0,"x":-30},"to":{"opacity":1,"x":0},"delay":0.2}'>
                                                    <a class="btn btn-sm btn-outline-white" href="#paket-haji">Lihat
                                                        Paket Haji</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide" data-zanim-timeline="{}">
                        <div class="bg-holder overlay overlay-freya"
                            style="background-image:url(assets2/img/header_2.jpg);" data-parallax="data-parallax"
                            data-rellax-speed="-3"></div>
                        <div class="container">
                            <div class="row min-vh-100 justify-content-start align-items-end pt-11 pb-6 text-white"
                                data-zanim-timeline="{}">
                                <div class="col">
                                    <div class="row align-items-end">
                                        <div class="col-lg">
                                            <div class="overflow-hidden">
                                                <p class="mb-1 text-uppercase ls"
                                                    data-zanim-xs='{"from":{"opacity":0,"x":-30},"to":{"opacity":1,"x":0},"delay":0.1}'>
                                                    Haji Plus</p>
                                            </div>
                                            <div class="overflow-hidden">
                                                <h2 class="text-white fw-normal mb-4 mb-lg-0"
                                                    data-zanim-xs='{"from":{"opacity":0,"x":-30},"to":{"opacity":1,"x":0},"delay":0}'>
                                                    Ibadah Nyaman & Berkesan</h2>
                                            </div>
                                        </div>
                                        <div class="col text-lg-end">
                                            <div class="overflow-hidden">
                                                <div
                                                    data-zanim-xs='{"from":{"opacity":0,"x":-30},"to":{"opacity":1,"x":0},"delay":0.2}'>
                                                    <a class="btn btn-sm btn-outline-white" href="#paket-haji">Lihat
                                                        Paket</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide" data-zanim-timeline="{}">
                        <div class="bg-holder overlay overlay-freya"
                            style="background-image:url(assets2/img/header_3.jpg);" data-parallax="data-parallax"
                            data-rellax-speed="-3"></div>
                        <div class="container">
                            <div class="row min-vh-100 justify-content-start align-items-end pt-11 pb-6 text-white"
                                data-zanim-timeline="{}">
                                <div class="col">
                                    <div class="row align-items-end">
                                        <div class="col-lg">
                                            <div class="overflow-hidden">
                                                <p class="mb-1 text-uppercase ls"
                                                    data-zanim-xs='{"from":{"opacity":0,"x":-30},"to":{"opacity":1,"x":0},"delay":0.1}'>
                                                    VIP Package</p>
                                            </div>
                                            <div class="overflow-hidden">
                                                <h2 class="text-white fw-normal mb-4 mb-lg-0"
                                                    data-zanim-xs='{"from":{"opacity":0,"x":-30},"to":{"opacity":1,"x":0},"delay":0}'>
                                                    Layanan Premium Kelas Dunia</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-nav">
                    <div class="swiper-button-prev"><span class="fas fa-chevron-left"></span></div>
                    <div class="swiper-button-next"><span class="fas fa-chevron-right"></span></div>
                </div>
            </div>
        </section>

        {{-- ── ABOUT SECTION ── --}}
        <section class="bg-white text-center">
            <div class="container-fluid px-0">
                <div class="row justify-content-center">
                    <div class="col-md-10 text-center">
                        <div class="mb-4">
                            <span class="company-badge">PT. Tian Sukses Aamiin</span>
                        </div>
                        <h1 class="main-headline mb-4">
                            Menyempurnakan Perjalanan Suci<br>
                            <span class="highlight-text">dengan Pelayanan Berkelas</span>
                        </h1>
                        <p class="description-text">
                            Kami menghadirkan layanan Umrah & Haji yang dirancang modern, aman, dan nyaman.<br>
                            Dengan pembimbing berpengalaman serta sistem pelayanan profesional,<br>
                            setiap detail perjalanan dipersiapkan agar Anda dapat beribadah dengan tenang.
                        </p>
                        <div class="features-container mt-5">
                            <div class="feature-item">
                                <div class="feature-icon">✓</div>
                                <div class="feature-label">Terpercaya</div>
                            </div>
                            <div class="feature-divider">•</div>
                            <div class="feature-item">
                                <div class="feature-icon">✓</div>
                                <div class="feature-label">Profesional</div>
                            </div>
                            <div class="feature-divider">•</div>
                            <div class="feature-item">
                                <div class="feature-icon">✓</div>
                                <div class="feature-label">Berpengalaman</div>
                            </div>
                        </div>
                        <div class="stats-section mt-5 pt-4">
                            <div class="row justify-content-center g-4">
                                <div class="col-md-3 col-6">
                                    <div class="stat-box">
                                        <div class="stat-number">1000+</div>
                                        <div class="stat-label">Jamaah Terlayani</div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="stat-box">
                                        <div class="stat-number">15+</div>
                                        <div class="stat-label">Tahun Pengalaman</div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="stat-box">
                                        <div class="stat-number">100%</div>
                                        <div class="stat-label">Kepuasan Jamaah</div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="stat-box">
                                        <div class="stat-number">24/7</div>
                                        <div class="stat-label">Layanan Support</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ── PAKET HAJI SECTION ── --}}
        <section id="paket-haji" style="background: var(--bg); padding: 0 0 60px;">
            <div class="container">

                {{-- Section Header --}}
                <div class="haji-section-header">
                    <span class="haji-section-label">🕌 Tersedia Sekarang</span>
                    <h2 class="haji-section-title">Paket Haji Pilihan</h2>
                    <p class="haji-section-desc">Wujudkan impian ibadah haji Anda bersama Rivanka Travel</p>
                </div>

                {{-- Filter Bar --}}
                <div class="haji-filter-bar">
                    <div class="haji-filter-left">
                        Menampilkan <b>{{ $hajiPackages->total() }}</b> paket haji tersedia
                    </div>
                    <div class="haji-filter-right">
                        <a href="{{ url('/') }}"
                            class="haji-filter-chip {{ !request('haji_type') ? 'active' : '' }}">Semua</a>
                        <a href="{{ url('/?haji_type=haji') }}"
                            class="haji-filter-chip {{ request('haji_type') == 'haji' ? 'active' : '' }}">Reguler</a>
                        <a href="{{ url('/?haji_type=Haji Plus') }}"
                            class="haji-filter-chip {{ request('haji_type') == 'Haji Plus' ? 'active' : '' }}">Haji
                            Plus</a>
                        <a href="{{ url('/?haji_type=VIP') }}"
                            class="haji-filter-chip {{ request('haji_type') == 'VIP' ? 'active' : '' }}">VIP</a>
                    </div>
                </div>

                {{-- Cards Grid --}}
                <div class="haji-cards-grid">
                    @forelse ($hajiPackages as $package)
                        @php
                            $availableSeat = $package->quota - $package->quota_used;
                            $isScarce = $availableSeat <= 10;
                            $gradient = match (true) {
                                $package->type === 'VIP' => 'linear-gradient(140deg, #6D28D9 0%, #4F46E5 100%)',
                                $package->type === 'Haji Plus' => 'linear-gradient(140deg, #92400E 0%, #C4973B 100%)',
                                default => 'linear-gradient(140deg, #0D7377 0%, #1A6B52 100%)',
                            };
                        @endphp

                        <div class="haji-package-card">
                            {{-- Banner --}}
                            <div class="haji-card-banner" style="background: {{ $gradient }};">
                                <div class="haji-banner-pattern"></div>
                                <div class="haji-badge-container">
                                    <span class="haji-badge primary">{{ strtoupper($package->type) }}</span>
                                    <span class="haji-badge gold">DP {{ number_format($package->dp / 1000000, 1) }}
                                        JT</span>
                                </div>
                                <div class="haji-program-label">Program {{ $package->program_days }} Hari</div>
                                <h2 class="haji-package-title">{{ $package->name }} {{ $package->year }}</h2>
                                <div class="haji-departure-date">
                                    ✈ Keberangkatan:
                                    {{ \Carbon\Carbon::parse($package->departure_date)->translatedFormat('d F Y') }}
                                </div>
                                <div class="haji-price-boxes">
                                    @foreach ([['Quad', $package->price], ['Triple', $package->price_triple], ['Double', $package->price_double]] as [$label, $price])
                                        <div class="haji-price-box">
                                            <div class="haji-price-type">{{ $label }}</div>
                                            <div class="haji-price">{{ number_format($price / 1000000, 1) }} Jt</div>
                                            <div class="haji-price-unit">/pax</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Info Body --}}
                            <div class="haji-card-body">
                                <div class="haji-info-grid">
                                    <div class="haji-info-row">
                                        <div class="haji-info-icon">📅</div>
                                        <div class="haji-info-content">
                                            <div class="haji-info-label">Jadwal Berangkat</div>
                                            <div class="haji-info-value">
                                                {{ \Carbon\Carbon::parse($package->departure_date)->translatedFormat('d F Y') }},
                                                {{ \Carbon\Carbon::parse($package->departure_time)->format('H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="haji-info-row">
                                        <div class="haji-info-icon">⏱</div>
                                        <div class="haji-info-content">
                                            <div class="haji-info-label">Durasi Perjalanan</div>
                                            <div class="haji-info-value">{{ $package->duration_days }} Hari</div>
                                        </div>
                                    </div>
                                    <div class="haji-info-row">
                                        <div class="haji-info-icon">🏨</div>
                                        <div class="haji-info-content">
                                            <div class="haji-info-label">Kelas Hotel</div>
                                            <div class="haji-info-value">
                                                {!! str_repeat('<span class="star-filled">★</span>', $package->hotel_rating) .
                                                    str_repeat('<span class="star-empty">★</span>', 5 - $package->hotel_rating) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="haji-info-row">
                                        <div class="haji-info-icon">👥</div>
                                        <div class="haji-info-content">
                                            <div class="haji-info-label">Available Seat</div>
                                            <div class="haji-info-value">
                                                <span
                                                    class="haji-availability-badge {{ $isScarce ? 'limited' : 'available' }}">
                                                    {{ $availableSeat }} pax {{ $isScarce ? 'tersisa' : 'tersedia' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="haji-info-row">
                                        <div class="haji-info-icon">📍</div>
                                        <div class="haji-info-content">
                                            <div class="haji-info-label">Berangkat dari</div>
                                            <div class="haji-info-value">{{ $package->departure_city }}</div>
                                        </div>
                                    </div>
                                    <div class="haji-info-row">
                                        <div class="haji-info-icon">✈️</div>
                                        <div class="haji-info-content">
                                            <div class="haji-info-label">Maskapai</div>
                                            <div class="haji-info-value">{{ $package->airline }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- CTA --}}
                            <div class="haji-card-footer">
                                <a href="{{ route('package.view', [$package->type, $package->id]) }}"
                                    class="haji-btn-detail">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="haji-empty">
                            <span class="haji-empty-icon">🕌</span>
                            <div class="haji-empty-title">Belum ada paket tersedia</div>
                            <div class="haji-empty-desc">Paket haji sedang dipersiapkan. Silakan cek kembali nanti.
                            </div>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if ($hajiPackages->hasPages())
                    <div class="packages-footer">
                        <div class="pagination-info">
                            Menampilkan <b>{{ $hajiPackages->firstItem() }}</b>–<b>{{ $hajiPackages->lastItem() }}</b>
                            dari <b>{{ $hajiPackages->total() }}</b> paket
                        </div>
                        <nav class="pagination">
                            @if ($hajiPackages->onFirstPage())
                                <span class="page-btn disabled">← Prev</span>
                            @else
                                <a href="{{ $hajiPackages->previousPageUrl() }}#paket-haji" class="page-btn">←
                                    Prev</a>
                            @endif

                            @foreach ($hajiPackages->getUrlRange(1, $hajiPackages->lastPage()) as $page => $url)
                                @if ($page == $hajiPackages->currentPage())
                                    <span class="page-btn active">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}#paket-haji"
                                        class="page-btn">{{ $page }}</a>
                                @endif
                            @endforeach

                            @if ($hajiPackages->hasMorePages())
                                <a href="{{ $hajiPackages->nextPageUrl() }}#paket-haji" class="page-btn">Next →</a>
                            @else
                                <span class="page-btn disabled">Next →</span>
                            @endif
                        </nav>
                    </div>
                @endif

            </div>
        </section>

        {{-- ── PAKET UMRAH SECTION ── --}}
        <section id="paket-umrah" style="background: var(--bg); padding: 0 0 60px;">
            <div class="container">

                {{-- Section Header --}}
                <div class="haji-section-header">
                    <span class="haji-section-label">🕋 Program Umrah</span>
                    <h2 class="haji-section-title">Paket Umrah Pilihan</h2>
                    <p class="haji-section-desc">Mulai perjalanan spiritual Anda dengan paket umrah terbaik</p>
                </div>

                {{-- Filter Bar --}}
                <div class="haji-filter-bar">
                    <div class="haji-filter-left">
                        Menampilkan <b>{{ $umrahPackages->total() }}</b> paket umrah tersedia
                    </div>
                    <div class="haji-filter-right">
                        <a href="{{ url('/') }}"
                            class="haji-filter-chip {{ !request('umrah_type') ? 'active' : '' }}">Semua</a>
                        <a href="{{ url('/?umrah_type=umrah_reguler') }}"
                            class="haji-filter-chip {{ request('umrah_type') == 'umrah_reguler' ? 'active' : '' }}">Reguler</a>
                        <a href="{{ url('/?umrah_type=umrah_premium') }}"
                            class="haji-filter-chip {{ request('umrah_type') == 'umrah_premium' ? 'active' : '' }}">Premium</a>
                        <a href="{{ url('/?umrah_type=umrah_vip') }}"
                            class="haji-filter-chip {{ request('umrah_type') == 'umrah_vip' ? 'active' : '' }}">VIP</a>
                    </div>
                </div>

                {{-- Cards Grid --}}
                <div class="haji-cards-grid">
                    @forelse ($umrahPackages as $package)
                        @php
                            $availableSeat = $package->quota - $package->quota_used;
                            $isScarce = $availableSeat <= 10;
                            $gradient = match (true) {
                                $package->type === 'umrah_vip' => 'linear-gradient(140deg, #7C3AED 0%, #5B21B6 100%)',
                                $package->type === 'umrah_premium'
                                    => 'linear-gradient(140deg, #059669 0%, #047857 100%)',
                                default => 'linear-gradient(140deg, #0891B2 0%, #0E7490 100%)',
                            };
                        @endphp

                        <div class="haji-package-card">
                            {{-- Banner --}}
                            <div class="haji-card-banner" style="background: {{ $gradient }};">
                                <div class="haji-banner-pattern"></div>
                                <div class="haji-badge-container">
                                    <span class="haji-badge primary">
                                        {{ strtoupper(str_replace('umrah_', '', $package->type)) }}</span>
                                    <span class="haji-badge gold">DP {{ number_format($package->dp / 1000000, 1) }}
                                        JT</span>
                                </div>
                                <div class="haji-program-label">Program {{ $package->program_days }} Hari</div>
                                <h2 class="haji-package-title">{{ $package->name }}</h2>
                                <div class="haji-departure-date">
                                    ✈ Keberangkatan:
                                    {{ \Carbon\Carbon::parse($package->departure_date)->translatedFormat('d F Y') }}
                                </div>
                                <div class="haji-price-boxes">
                                    @foreach ([['Quad', $package->price], ['Triple', $package->price_triple], ['Double', $package->price_double]] as [$label, $price])
                                        <div class="haji-price-box">
                                            <div class="haji-price-type">{{ $label }}</div>
                                            <div class="haji-price">{{ number_format($price / 1000000, 1) }} Jt</div>
                                            <div class="haji-price-unit">/pax</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Info Body (sama dengan haji) --}}
                            <div class="haji-card-body">
                                <div class="haji-info-grid">
                                    <div class="haji-info-row">
                                        <div class="haji-info-icon">📅</div>
                                        <div class="haji-info-content">
                                            <div class="haji-info-label">Jadwal Berangkat</div>
                                            <div class="haji-info-value">
                                                {{ \Carbon\Carbon::parse($package->departure_date)->translatedFormat('d F Y') }},
                                                {{ \Carbon\Carbon::parse($package->departure_time)->format('H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="haji-info-row">
                                        <div class="haji-info-icon">⏱</div>
                                        <div class="haji-info-content">
                                            <div class="haji-info-label">Durasi Perjalanan</div>
                                            <div class="haji-info-value">{{ $package->duration_days }} Hari</div>
                                        </div>
                                    </div>
                                    <div class="haji-info-row">
                                        <div class="haji-info-icon">🏨</div>
                                        <div class="haji-info-content">
                                            <div class="haji-info-label">Kelas Hotel</div>
                                            <div class="haji-info-value">
                                                {!! str_repeat('<span class="star-filled">★</span>', $package->hotel_rating) .
                                                    str_repeat('<span class="star-empty">★</span>', 5 - $package->hotel_rating) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="haji-info-row">
                                        <div class="haji-info-icon">👥</div>
                                        <div class="haji-info-content">
                                            <div class="haji-info-label">Available Seat</div>
                                            <div class="haji-info-value">
                                                <span
                                                    class="haji-availability-badge {{ $isScarce ? 'limited' : 'available' }}">
                                                    {{ $availableSeat }} pax {{ $isScarce ? 'tersisa' : 'tersedia' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="haji-info-row">
                                        <div class="haji-info-icon">📍</div>
                                        <div class="haji-info-content">
                                            <div class="haji-info-label">Berangkat dari</div>
                                            <div class="haji-info-value">{{ $package->departure_city }}</div>
                                        </div>
                                    </div>
                                    <div class="haji-info-row">
                                        <div class="haji-info-icon">✈️</div>
                                        <div class="haji-info-content">
                                            <div class="haji-info-label">Maskapai</div>
                                            <div class="haji-info-value">{{ $package->airline }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- CTA --}}
                            <div class="haji-card-footer">
                                <a href="{{ route('package.view', [$package->type, $package->id]) }}"
                                    class="haji-btn-detail">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="haji-empty">
                            <span class="haji-empty-icon">🕋</span>
                            <div class="haji-empty-title">Belum ada paket umrah tersedia</div>
                            <div class="haji-empty-desc">Paket umrah sedang dipersiapkan. Silakan cek kembali nanti.
                            </div>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if ($umrahPackages->hasPages())
                    <div class="packages-footer">
                        <div class="pagination-info">
                            Menampilkan
                            <b>{{ $umrahPackages->firstItem() }}</b>–<b>{{ $umrahPackages->lastItem() }}</b>
                            dari <b>{{ $umrahPackages->total() }}</b> paket
                        </div>
                        <nav class="pagination">
                            @if ($umrahPackages->onFirstPage())
                                <span class="page-btn disabled">← Prev</span>
                            @else
                                <a href="{{ $umrahPackages->previousPageUrl() }}#paket-umrah" class="page-btn">←
                                    Prev</a>
                            @endif

                            @foreach ($umrahPackages->getUrlRange(1, $umrahPackages->lastPage()) as $page => $url)
                                @if ($page == $umrahPackages->currentPage())
                                    <span class="page-btn active">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}#paket-umrah"
                                        class="page-btn">{{ $page }}</a>
                                @endif
                            @endforeach

                            @if ($umrahPackages->hasMorePages())
                                <a href="{{ $umrahPackages->nextPageUrl() }}#paket-umrah" class="page-btn">Next →</a>
                            @else
                                <span class="page-btn disabled">Next →</span>
                            @endif
                        </nav>
                    </div>
                @endif

            </div>
        </section>


        <section class="wcu-section" id="mengapa-kami">
            <div class="wcu-bg-layer"></div>

            <div class="container position-relative">

                {{-- Header --}}
                <div class="wcu-header">
                    <span class="wcu-eyebrow">Keunggulan Kami</span>
                    <h2 class="wcu-title">Mengapa Memilih<br><em>Rivanka Travel?</em></h2>
                    <p class="wcu-subtitle">Kami hadir untuk memastikan setiap langkah perjalanan suci Anda<br>terasa
                        aman, nyaman, dan penuh keberkahan.</p>
                </div>

                {{-- Cards Grid --}}
                <div class="wcu-grid">

                    <div class="wcu-card wcu-card--large">
                        <div class="wcu-card-inner">
                            <div class="wcu-icon-wrap">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                </svg>
                            </div>
                            <h3 class="wcu-card-title">Terpercaya &amp; Resmi</h3>
                            <p class="wcu-card-desc">Terdaftar dan berizin resmi dari Kemenag RI. Lebih dari 15 tahun
                                kami telah membuktikan kepercayaan ribuan jamaah dalam melaksanakan ibadah haji dan
                                umrah.</p>
                            <div class="wcu-card-tag">Izin Kemenag RI</div>
                        </div>
                        <div class="wcu-card-deco"></div>
                    </div>

                    <div class="wcu-card">
                        <div class="wcu-card-inner">
                            <div class="wcu-icon-wrap">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                                </svg>
                            </div>
                            <h3 class="wcu-card-title">Amanah</h3>
                            <p class="wcu-card-desc">Dana jamaah dikelola secara transparan dan bertanggung jawab
                                sesuai prinsip syariah.</p>
                        </div>
                    </div>

                    <div class="wcu-card">
                        <div class="wcu-card-inner">
                            <div class="wcu-icon-wrap">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10" />
                                    <path d="M12 6v6l4 2" />
                                </svg>
                            </div>
                            <h3 class="wcu-card-title">Pembimbing Berpengalaman</h3>
                            <p class="wcu-card-desc">Didampingi ustadz & pembimbing bersertifikat yang siap membimbing
                                setiap langkah ibadah Anda.</p>
                        </div>
                    </div>

                    <div class="wcu-card">
                        <div class="wcu-card-inner">
                            <div class="wcu-icon-wrap">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                    <circle cx="9" cy="7" r="4" />
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                </svg>
                            </div>
                            <h3 class="wcu-card-title">Sesuai Syariat</h3>
                            <p class="wcu-card-desc">Seluruh program ibadah dirancang sesuai tuntunan Al-Qur'an dan
                                Sunnah Rasulullah SAW.</p>
                        </div>
                    </div>

                    <div class="wcu-card">
                        <div class="wcu-card-inner">
                            <div class="wcu-icon-wrap">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <rect x="1" y="3" width="15" height="13" />
                                    <polygon points="16 8 20 8 23 11 23 16 16 16 16 8" />
                                    <circle cx="5.5" cy="18.5" r="2.5" />
                                    <circle cx="18.5" cy="18.5" r="2.5" />
                                </svg>
                            </div>
                            <h3 class="wcu-card-title">Fasilitas Premium</h3>
                            <p class="wcu-card-desc">Hotel bintang 4–5 dekat Masjidil Haram & Masjid Nabawi,
                                transportasi eksklusif, dan konsumsi berkualitas.</p>
                        </div>
                    </div>

                    <div class="wcu-card wcu-card--accent">
                        <div class="wcu-card-inner">
                            <div class="wcu-icon-wrap">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.4 2 2 0 0 1 3.6 1.22h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.77a16 16 0 0 0 6.29 6.29l.96-.88a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" />
                                </svg>
                            </div>
                            <h3 class="wcu-card-title">Layanan 24/7</h3>
                            <p class="wcu-card-desc">Tim kami siap membantu Anda kapan saja, sebelum, selama, dan
                                setelah perjalanan ibadah.</p>
                            <a href="#" class="wcu-cta-link">Hubungi Kami →</a>
                        </div>
                    </div>

                </div>

                {{-- Bottom CTA strip --}}
                <div class="wcu-strip">
                    <span class="wcu-strip-text">Siap melangkah menuju tanah suci?</span>
                    <a href="#paket-haji" class="wcu-strip-btn">Lihat Paket Tersedia</a>
                </div>

            </div>
        </section>


        {{-- ══════════════════════════════════════════
     MODAL: DETAIL PAKET
══════════════════════════════════════════ --}}
        <div id="modalDetail" class="pmodal-overlay" role="dialog" aria-modal="true"
            aria-labelledby="modalDetailTitle">
            <div class="pmodal-wrap">

                {{-- Close --}}
                <button class="pmodal-close" onclick="closeModal('modalDetail')" aria-label="Tutup">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M15 5L5 15M5 5l10 10" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" />
                    </svg>
                </button>

                {{-- Hero Banner --}}
                <div class="pmodal-hero" id="detailHeroBanner">
                    <div class="pmodal-hero-pattern"></div>
                    <div class="pmodal-hero-badges">
                        <span class="pmodal-badge-type" id="detailBadgeType">HAJI PLUS</span>
                        <span class="pmodal-badge-dp" id="detailBadgeDp">DP 25 JT</span>
                    </div>
                    <div class="pmodal-hero-program" id="detailProgram">Program 40 Hari</div>
                    <h2 class="pmodal-hero-title" id="modalDetailTitle">Nama Paket</h2>
                    <p class="pmodal-hero-date" id="detailDeparture">✈ Keberangkatan: —</p>

                    {{-- Price Boxes --}}
                    <div class="pmodal-price-row">
                        <div class="pmodal-price-box">
                            <div class="ppb-type">Quad</div>
                            <div class="ppb-price" id="detailPriceQuad">—</div>
                            <div class="ppb-unit">/pax</div>
                        </div>
                        <div class="pmodal-price-box">
                            <div class="ppb-type">Triple</div>
                            <div class="ppb-price" id="detailPriceTriple">—</div>
                            <div class="ppb-unit">/pax</div>
                        </div>
                        <div class="pmodal-price-box">
                            <div class="ppb-type">Double</div>
                            <div class="ppb-price" id="detailPriceDouble">—</div>
                            <div class="ppb-unit">/pax</div>
                        </div>
                    </div>
                </div>

                {{-- Body --}}
                <div class="pmodal-body">

                    {{-- Info Grid --}}
                    <div class="pmodal-info-grid">
                        <div class="pmodal-info-item">
                            <span class="pmodal-info-icon">📅</span>
                            <div>
                                <div class="pmodal-info-label">Jadwal Berangkat</div>
                                <div class="pmodal-info-val" id="detailSchedule">—</div>
                            </div>
                        </div>
                        <div class="pmodal-info-item">
                            <span class="pmodal-info-icon">⏱</span>
                            <div>
                                <div class="pmodal-info-label">Durasi</div>
                                <div class="pmodal-info-val" id="detailDuration">—</div>
                            </div>
                        </div>
                        <div class="pmodal-info-item">
                            <span class="pmodal-info-icon">🏨</span>
                            <div>
                                <div class="pmodal-info-label">Kelas Hotel</div>
                                <div class="pmodal-info-val" id="detailHotel">—</div>
                            </div>
                        </div>
                        <div class="pmodal-info-item">
                            <span class="pmodal-info-icon">👥</span>
                            <div>
                                <div class="pmodal-info-label">Seat Tersedia</div>
                                <div class="pmodal-info-val" id="detailSeat">—</div>
                            </div>
                        </div>
                        <div class="pmodal-info-item">
                            <span class="pmodal-info-icon">📍</span>
                            <div>
                                <div class="pmodal-info-label">Berangkat Dari</div>
                                <div class="pmodal-info-val" id="detailCity">—</div>
                            </div>
                        </div>
                        <div class="pmodal-info-item">
                            <span class="pmodal-info-icon">✈️</span>
                            <div>
                                <div class="pmodal-info-label">Maskapai</div>
                                <div class="pmodal-info-val" id="detailAirline">—</div>
                            </div>
                        </div>
                    </div>

                    {{-- Hotel Info --}}
                    <div class="pmodal-hotel-strip">
                        <div class="pmodal-hotel-item">
                            <span class="pmodal-hotel-icon">🕌</span>
                            <div>
                                <div class="pmodal-info-label">Hotel Makkah</div>
                                <div class="pmodal-info-val" id="detailHotelMakkah">—</div>
                            </div>
                        </div>
                        <div class="pmodal-hotel-divider"></div>
                        <div class="pmodal-hotel-item">
                            <span class="pmodal-hotel-icon">🕋</span>
                            <div>
                                <div class="pmodal-info-label">Hotel Madinah</div>
                                <div class="pmodal-info-val" id="detailHotelMadinah">—</div>
                            </div>
                        </div>
                    </div>

                    {{-- Includes / Excludes --}}
                    <div class="pmodal-two-col" id="detailIncludesWrap" style="display:none;">
                        <div class="pmodal-col-card pmodal-col-include">
                            <div class="pmodal-col-title">✅ Termasuk</div>
                            <div class="pmodal-col-body" id="detailIncludes"></div>
                        </div>
                        <div class="pmodal-col-card pmodal-col-exclude">
                            <div class="pmodal-col-title">❌ Tidak Termasuk</div>
                            <div class="pmodal-col-body" id="detailExcludes"></div>
                        </div>
                    </div>

                    {{-- Itinerary --}}
                    <div id="detailItineraryWrap" style="display:none;">
                        <div class="pmodal-section-label">🗺 Itinerary Perjalanan</div>
                        <div class="pmodal-itinerary-list" id="detailItineraryList"></div>
                    </div>

                    {{-- Terms --}}
                    <div id="detailTermsWrap" style="display:none;">
                        <div class="pmodal-section-label">📋 Syarat & Ketentuan</div>
                        <div class="pmodal-terms-box" id="detailTerms"></div>
                    </div>

                </div>

                {{-- Footer CTA --}}
                <div class="pmodal-footer">
                    <button class="pmodal-btn-wa" id="detailBtnWa" onclick="openWhatsApp()">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                        </svg>
                        Tanya via WhatsApp
                    </button>
                    <button class="pmodal-btn-book" id="detailBtnBook" onclick="openBookingModal()">
                        Booking Sekarang →
                    </button>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════
     MODAL: BOOKING
══════════════════════════════════════════ --}}
        <div id="modalBooking" class="pmodal-overlay" role="dialog" aria-modal="true"
            aria-labelledby="bookingModalTitle">
            <div class="pmodal-wrap pmodal-wrap--sm">

                <button class="pmodal-close" onclick="closeModal('modalBooking'); openModal('modalDetail')"
                    aria-label="Kembali">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M12 4L4 12M4 4l8 8" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            transform="rotate(45 10 10)" />
                        <path d="M15 5L5 15M5 5l10 10" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" />
                    </svg>
                </button>

                {{-- Booking Header --}}
                <div class="pbooking-header">
                    <div class="pbooking-header-icon">🕌</div>
                    <div>
                        <h3 class="pbooking-title" id="bookingModalTitle">Booking Paket</h3>
                        <p class="pbooking-subtitle" id="bookingPackageName">—</p>
                    </div>
                    <span class="pbooking-type-badge" id="bookingTypeBadge">HAJI</span>
                </div>

                {{-- Summary Strip --}}
                <div class="pbooking-strip">
                    <div class="pbooking-strip-item">📅 <span id="bookingDeparture">—</span></div>
                    <div class="pbooking-strip-item">✈️ <span id="bookingAirline">—</span></div>
                    <div class="pbooking-strip-item">👥 <span id="bookingSeats">—</span> seat</div>
                </div>

                {{-- DP Alert --}}
                <div class="pbooking-dp-box">
                    <div class="pbooking-dp-left">
                        <div class="pbooking-dp-icon">💰</div>
                        <div>
                            <div class="pbooking-dp-label">Down Payment (DP)</div>
                            <div class="pbooking-dp-desc">Bayar DP untuk mengamankan seat Anda</div>
                        </div>
                    </div>
                    <div class="pbooking-dp-amount" id="bookingDp">—</div>
                </div>

                {{-- Form --}}
                <form id="landingBookingForm" method="POST" action="">
                    @csrf

                    <div class="pbooking-form-body">

                        {{-- Nama --}}
                        <div class="pbooking-field">
                            <label class="pbooking-label">Nama Lengkap <span class="req">*</span></label>
                            <div class="pbooking-input-wrap">
                                <span class="pbooking-input-icon">👤</span>
                                <input type="text" name="full_name" id="bookingName" class="pbooking-input"
                                    placeholder="Masukkan nama lengkap sesuai KTP" required>
                            </div>
                        </div>

                        {{-- No HP --}}
                        <div class="pbooking-field">
                            <label class="pbooking-label">No. WhatsApp / HP <span class="req">*</span></label>
                            <div class="pbooking-input-wrap">
                                <span class="pbooking-input-icon">📱</span>
                                <input type="tel" name="phone" id="bookingPhone" class="pbooking-input"
                                    placeholder="Contoh: 081234567890" required>
                            </div>
                        </div>

                        {{-- Tipe Kamar --}}
                        <div class="pbooking-field">
                            <label class="pbooking-label">Tipe Kamar <span class="req">*</span></label>
                            <div class="pbooking-room-grid">

                                <input type="radio" name="room_type" value="quad" id="broom_quad"
                                    class="proom-radio" required>
                                <label for="broom_quad" class="proom-label">
                                    <div class="proom-box">
                                        <div class="proom-check">✓</div>
                                        <div class="proom-name">Quad</div>
                                        <div class="proom-price" id="broomPriceQuad">— Jt</div>
                                        <div class="proom-unit">/ 4 pax</div>
                                    </div>
                                </label>

                                <input type="radio" name="room_type" value="triple" id="broom_triple"
                                    class="proom-radio">
                                <label for="broom_triple" class="proom-label">
                                    <div class="proom-box">
                                        <div class="proom-check">✓</div>
                                        <div class="proom-name">Triple</div>
                                        <div class="proom-price" id="broomPriceTriple">— Jt</div>
                                        <div class="proom-unit">/ 3 pax</div>
                                    </div>
                                </label>

                                <input type="radio" name="room_type" value="double" id="broom_double"
                                    class="proom-radio">
                                <label for="broom_double" class="proom-label">
                                    <div class="proom-box">
                                        <div class="proom-check">✓</div>
                                        <div class="proom-name">Double</div>
                                        <div class="proom-price" id="broomPriceDouble">— Jt</div>
                                        <div class="proom-unit">/ 2 pax</div>
                                    </div>
                                </label>

                            </div>
                        </div>

                    </div>

                    {{-- Footer --}}
                    <div class="pbooking-footer">
                        <button type="button" class="pbooking-btn-back"
                            onclick="closeModal('modalBooking'); openModal('modalDetail')">
                            ← Kembali ke Detail
                        </button>
                        <button type="submit" class="pbooking-btn-submit">
                            ✅ Konfirmasi Booking
                        </button>
                    </div>
                </form>

            </div>
        </div>


    </main>

    {{-- Footer --}}
    <section class="bg-300 py-4 fs-1 text-center">
        <div class="container">
            <a class="d-inline-block px-2 text-900 fs-1" href="#"><span class="fab fa-facebook-f"></span></a>
            <a class="d-inline-block px-2 text-900 fs-1" href="#"><span class="fab fa-twitter"></span></a>
            <a class="d-inline-block px-2 text-900 fs-1" href="#"><span class="fab fa-instagram"></span></a>
        </div>
    </section>

    <footer class="modern-footer">
        <div class="container">
            <div class="row py-5">
                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                    <h5 class="footer-brand mb-3">PT. Tiann Sukses Aamiin</h5>
                    <p class="footer-description">Mitra terpercaya perjalanan ibadah Umrah & Haji Anda dengan pelayanan
                        profesional dan amanah.</p>
                    <div class="social-links mt-4">
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-whatsapp"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                    <h6 class="footer-title">Layanan</h6>
                    <ul class="footer-links">
                        <li><a href="#">Paket Umrah</a></li>
                        <li><a href="#paket-haji">Paket Haji</a></li>
                        <li><a href="#">Visa Umrah</a></li>
                        <li><a href="#">Perlengkapan</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                    <h6 class="footer-title">Perusahaan</h6>
                    <ul class="footer-links">
                        <li><a href="#">Tentang Kami</a></li>
                        <li><a href="#">Galeri</a></li>
                        <li><a href="#">Testimoni</a></li>
                        <li><a href="#">Artikel</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h6 class="footer-title">Hubungi Kami</h6>
                    <ul class="footer-contact">
                        <li><i class="fas fa-map-marker-alt"></i><span>Jl. Contoh No. 123, Jakarta Selatan</span></li>
                        <li><i class="fas fa-phone"></i><span>+62 812-3456-7890</span></li>
                        <li><i class="fas fa-envelope"></i><span>info@rivankaaauliah.com</span></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                        <p class="copyright-text mb-0">© 2024 PT. Tiann Sukses Aamiin. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <div class="footer-legal">
                            <a href="#">Syarat & Ketentuan</a>
                            <span class="separator">|</span>
                            <a href="#">Kebijakan Privasi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('assets2/vendors/popper/popper.min.js') }}"></script>
    <script src="{{ asset('assets2/vendors/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets2/vendors/is/is.min.js') }}"></script>
    <script src="{{ asset('assets2/vendors/bigpicture/BigPicture.js') }}"></script>
    <script src="{{ asset('assets2/vendors/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets2/vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('assets2/vendors/rellax/rellax.min.js') }}"></script>
    <script src="{{ asset('assets2/vendors/lodash/lodash.min.js') }}"></script>
    <script src="{{ asset('assets2/vendors/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets2/vendors/gsap/gsap.js') }}"></script>
    <script src="{{ asset('assets2/vendors/gsap/customEase.js') }}"></script>
    <script src="{{ asset('assets2/js/theme.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const scrollContainer = document.getElementById('packagesScroll');
            if (scrollContainer) {
                scrollContainer.innerHTML += scrollContainer.innerHTML;
                let isDown = false,
                    startX, scrollLeft;
                scrollContainer.addEventListener('mousedown', (e) => {
                    isDown = true;
                    startX = e.pageX - scrollContainer.offsetLeft;
                    scrollLeft = scrollContainer.scrollLeft;
                    scrollContainer.style.cursor = 'grabbing';
                });
                scrollContainer.addEventListener('mouseleave', () => {
                    isDown = false;
                    scrollContainer.style.cursor = 'grab';
                });
                scrollContainer.addEventListener('mouseup', () => {
                    isDown = false;
                    scrollContainer.style.cursor = 'grab';
                });
                scrollContainer.addEventListener('mousemove', (e) => {
                    if (!isDown) return;
                    e.preventDefault();
                    const x = e.pageX - scrollContainer.offsetLeft;
                    scrollContainer.scrollLeft = scrollLeft - (x - startX) * 2;
                });
            }
        });
    </script>

</body>

</html>
