@extends ('auth.Auth')
@section('title')
<title>Register | Aplikasi Layanan Umrah</title>
@endsection
@section('form')
<div class="login-container">
    <!-- Left Side - Hero Section -->
    <div class="login-left">
        <div class="hero-content">
            <div class="kaaba-icon">
                <i class="fas fa-kaaba" style="font-size: 4rem; color: white;"></i>
            </div>

            <h1>Daftar Sekarang</h1>
            <p>Bergabunglah bersama ribuan jamaah yang telah mempercayai kami</p>

            <ul class="feature-list">
                <li>
                    <i class="fas fa-check-circle"></i>
                    <strong>Proses Pendaftaran Mudah</strong>
                </li>
                <li>
                    <i class="fas fa-shield-alt"></i>
                    <strong>Data Aman & Terlindungi</strong>
                </li>
                <li>
                    <i class="fas fa-gift"></i>
                    <strong>Penawaran Paket Spesial</strong>
                </li>
                <li>
                    <i class="fas fa-headset"></i>
                    <strong>Konsultasi Gratis 24/7</strong>
                </li>
            </ul>
        </div>
    </div>

    <!-- Right Side - Register Form -->
    <div class="login-right">
        <div class="login-box">
            <div class="login-header">
                <h2>Buat Akun Baru</h2>
                <p>Isi formulir di bawah untuk mendaftar</p>
            </div>
            <form class="form w-100" action="{{ route('jemaah.register.submit') }}" method="POST">
                @csrf


                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope"></i> Email
                    </label>
                    <input
                        class="form-control"
                        type="email"
                        id="email"
                        name="email"
                        required
                        placeholder="contoh@email.com" />
                </div>

                <div class="form-group">
                    <label for="username">
                        <i class="fas fa-user-circle"></i> Username
                    </label>
                    <input
                        class="form-control"
                        type="text"
                        id="username"
                        name="username"
                        required
                        placeholder="Pilih username unik" />
                </div>

                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock"></i> Password
                    </label>
                    <input
                        class="form-control"
                        type="password"
                        id="password"
                        name="password"
                        required
                        placeholder="Minimal 8 karakter" />
                </div>

                <div class="form-group">
                    <label for="password_confirmation">
                        <i class="fas fa-lock"></i> Konfirmasi Password
                    </label>
                    <input
                        class="form-control"
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        required
                        placeholder="Minimal 8 karakter" />
                </div>


                <div class="form-group" style="margin-bottom: 0.8rem;">
                    <div class="custom-control custom-checkbox">
                        <input
                            type="checkbox"
                            class="custom-control-input"
                            id="terms"
                            name="terms"
                            required />
                        <label class="custom-control-label" for="terms">
                            Saya menyetujui <a href="#" target="_blank">Syarat & Ketentuan</a> yang berlaku
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-user-plus"></i> Daftar Sekarang
                </button>

                <div class="footer-links">
                    Sudah punya akun?
                    <a href="/login">
                        <i class="fas fa-sign-in-alt"></i> Login di sini
                    </a>
                </div>
            </form>



        </div>
    </div>
</div>
@endsection