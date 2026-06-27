@extends('template.AuthBase')
@section('auth')
    @php
        $systemName = $siteSettings['system_name'] ?: 'Sistem Penjaminan Mutu Internal';
        $campusName = $siteSettings['campus_name'] ?: 'Perguruan Tinggi';
    @endphp

    <main class="spmi-login-shell">
        <section class="spmi-login-hero">
            <div class="spmi-login-nav">
                <a href="{{ route('home') }}" class="spmi-login-logo">
                    <img src="{{ \App\SiteSetting::imageUrl($siteSettings, 'logo_path') }}"
                        onerror="this.onerror=null;this.src='{{ asset('home/img/favicon.png') }}';"
                        alt="Logo {{ $campusName }}">
                    <span>{{ $systemName }}</span>
                </a>
                <a href="{{ route('home') }}" class="spmi-login-back">
                    <i class="fas fa-home"></i>
                    Kembali ke Home
                </a>
            </div>

            <div class="spmi-login-hero-content">
                <span class="spmi-login-eyebrow">Portal Mutu Internal</span>
                <h1>{{ $systemName }}</h1>
                <p>
                    Masuk untuk mengelola data asesmen, dokumen akreditasi, diagram pencapaian, dan informasi mutu
                    {{ $campusName }}.
                </p>

                <div class="spmi-login-benefits">
                    <div>
                        <i class="fas fa-chart-pie"></i>
                        <span>Monitoring pencapaian</span>
                    </div>
                    <div>
                        <i class="fas fa-file-alt"></i>
                        <span>Arsip dokumen terpusat</span>
                    </div>
                    <div>
                        <i class="fas fa-medal"></i>
                        <span>Data akreditasi prodi</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="spmi-login-panel">
            <div class="spmi-login-card">
                <div class="spmi-login-card-header">
                    <div>
                        <span class="spmi-login-eyebrow">Area Administrator</span>
                        <h2>Login Admin</h2>
                        <p>Gunakan akun yang sudah terdaftar di sistem.</p>
                    </div>
                    <div class="spmi-login-card-icon">
                        <i class="fas fa-user-shield"></i>
                    </div>
                </div>

                @if (session()->has('pesan'))
                    <div class="spmi-login-message">
                        {!! session()->get('pesan') !!}
                    </div>
                @endif

                <form action="{{ url('proses') }}" method="POST" class="spmi-login-form">
                    @csrf
                    <div class="form-group">
                        <label for="login-email">Email</label>
                        <div class="spmi-login-input">
                            <i class="fas fa-envelope"></i>
                            <input type="email" class="form-control" id="login-email" placeholder="nama@email.ac.id"
                                name="email" autocomplete="email" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="login-password">Password</label>
                        <div class="spmi-login-input">
                            <i class="fas fa-lock"></i>
                            <input type="password" class="form-control" id="login-password" placeholder="Masukkan password"
                                name="password" autocomplete="current-password" required>
                            <button type="button" class="spmi-login-password-toggle" id="toggle-login-password"
                                aria-label="Lihat password" aria-pressed="false">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="spmi-login-submit">
                        Masuk Dashboard
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </form>

                <div class="spmi-login-footnote">
                    <strong>{{ $campusName }}</strong>
                    <span>© {{ date('Y') }} {{ $systemName }}</span>
                </div>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var passwordInput = document.getElementById('login-password');
            var toggleButton = document.getElementById('toggle-login-password');

            if (!passwordInput || !toggleButton) {
                return;
            }

            toggleButton.addEventListener('click', function() {
                var isVisible = passwordInput.getAttribute('type') === 'text';

                passwordInput.setAttribute('type', isVisible ? 'password' : 'text');
                toggleButton.setAttribute('aria-pressed', isVisible ? 'false' : 'true');
                toggleButton.setAttribute('aria-label', isVisible ? 'Lihat password' : 'Sembunyikan password');
                toggleButton.innerHTML = '<i class="fas ' + (isVisible ? 'fa-eye' : 'fa-eye-slash') + '"></i>';
            });
        });
    </script>
@endsection
