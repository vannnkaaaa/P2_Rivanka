@extends('auth.Auth') 

@section('title')
    <title>Login | Aplikasi Layanan Umrah</title>
@endsection
@section('form')
  <div class="login-container">
    <!-- Left Side - Hero Section -->
    <div class="login-left">
      <div class="hero-content">
        <div class="kaaba-icon">
          <i class="fas fa-kaaba" style="font-size: 4rem; color: white;"></i>
        </div>

        <h1>Sistem Layanan Umrah & Haji</h1>
        <p>Wujudkan impian ibadah Anda bersama kami</p>

        <ul class="feature-list">
          <li>
            <i class="mdi mdi-shield-check-outline"></i>
            <strong>Terpercaya & Berizin Resmi</strong>
          </li>
          <li>
            <i class="mdi mdi-account-group-outline"></i>
            <strong>Bimbingan Profesional</strong>
          </li>
          <li>
            <i class="mdi mdi-airplane-takeoff"></i>
            <strong>Paket Umrah Terlengkap</strong>
          </li>
          <li>
            <i class="mdi mdi-headset"></i>
            <strong>Customer Support 24/7</strong>
          </li>
        </ul>
      </div>
    </div>

    <!-- Right Side - Login Form -->
    <div class="login-right">
      <div class="login-box">
        <div class="login-header">
          <h2>Selamat Datang</h2>
          <p>Silakan login untuk mengakses dashboard</p>
        </div>

        <form action="{{ route('login') }}" method="POST">
          @csrf

          <div class="form-group">
            <label for="username">
              <i class="mdi mdi-account-outline"></i> Username atau Email
            </label>
            <input
              class="form-control"
              type="text"
              id="email"
              name="email"
              required
              placeholder="Masukkan email" />
          </div>

          <div class="form-group">
            <label for="password">
              <i class="mdi mdi-lock-outline"></i> Password
            </label>
            <input
              class="form-control"
              type="password"
              id="password"
              name="password"
              required
              placeholder="Masukkan password" />
          </div>

          <div class="form-group">
            <div class="custom-control custom-checkbox">
              <input
                type="checkbox"
                class="custom-control-input"
                id="remember"
                name="remember" />
              <label class="custom-control-label" for="remember">
                Ingat saya di perangkat ini
              </label>
            </div>
          </div>

          <button type="submit" class="btn-login">
            <i class="mdi mdi-login"></i> Masuk ke Sistem
          </button>

          <div class="footer-links">
            <a href="/forgot-password">
              <i class="mdi mdi-lock-question"></i> Lupa Password?
            </a>
            <a href="{{ route('register') }}" class="register-link">
              <i class="mdi mdi-account-plus"></i> Daftar Akun
            </a>
          </div>
        </form>


        
      </div>
    </div>
  </div>

@endsection
