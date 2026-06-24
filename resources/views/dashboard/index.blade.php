@extends('template.BaseView', ['title' => 'Dashboard'])

@section('content')
    <section class="admin-dashboard">
        <div class="dashboard-welcome">
            <div class="dashboard-welcome-content">
                <span class="dashboard-eyebrow">Dashboard Mutu</span>
                <h1>
                    Selamat datang,
                    <strong>{{ Auth::user()->name }}</strong>
                </h1>

                @if (Auth::user()->prodi_kode == '-')
                    <p>
                        Kelola penilaian, dokumen, dan pencapaian mutu
                        <strong>{{ $p->count() }} program studi</strong> yang terdaftar pada sistem.
                    </p>
                @else
                    <p>
                        Anda bertugas sebagai <strong>{{ Auth::user()->role }}</strong> pada Program Studi
                        <strong>{{ Auth::user()->prodi_name }}</strong>. Kelola peningkatan mutu melalui menu
                        Elemen &amp; Berkas.
                    </p>
                @endif
            </div>

            <div class="dashboard-welcome-visual">
                <div class="dashboard-welcome-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div>
                    <strong>{{ $siteSettings['system_name'] ?: 'Sistem Penjaminan Mutu' }}</strong>
                    <span>{{ $siteSettings['campus_name'] }}</span>
                </div>
            </div>
        </div>

        @if (Auth::user()->prodi_kode == '-')
            <div class="dashboard-section-heading">
                <div>
                    <span>Program Pendidikan</span>
                    <h2>Program Studi Terdaftar</h2>
                    <p>Pilih program studi untuk membuka penilaian, diagram, dan informasi asesmen.</p>
                </div>
                <div class="dashboard-count">
                    <strong>{{ $p->count() }}</strong>
                    <span>Program Studi</span>
                </div>
            </div>

            <div class="dashboard-program-grid">
                @forelse ($p as $i)
                    <a href="{{ url('prodi/' . $i->kode) }}" class="dashboard-program-card">
                        <div class="dashboard-program-icon">
                            <i class="{{ $loop->even ? 'fas fa-university' : 'fas fa-graduation-cap' }}"></i>
                        </div>
                        <div class="dashboard-program-content">
                            <span class="dashboard-program-code">{{ $i->kode }}</span>
                            <h3>{{ $i->name }}</h3>
                            <p>{{ $i->jenjang ? $i->jenjang->name . ' (' . $i->jenjang->kode . ')' : 'Program Studi' }}</p>
                        </div>
                        <i class="fas fa-arrow-right dashboard-program-arrow"></i>
                    </a>
                @empty
                    <div class="dashboard-empty">
                        <i class="fas fa-university"></i>
                        <h3>Belum ada program studi</h3>
                        <p>Tambahkan program studi melalui menu Pengaturan.</p>
                    </div>
                @endforelse
            </div>
        @else
            <div class="dashboard-role-card">
                <div class="dashboard-program-icon">
                    <i class="fas fa-university"></i>
                </div>
                <div>
                    <span>Program Studi Anda</span>
                    <h2>{{ Auth::user()->prodi_name }}</h2>
                    <p>Gunakan navigasi di samping untuk mengelola data penjaminan mutu.</p>
                </div>
            </div>
        @endif
    </section>
@endsection
