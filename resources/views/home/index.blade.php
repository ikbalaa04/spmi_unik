@extends('template.HomeView', ['title' => 'Home'])

@section('content')
    <section id="hero">
        <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>

            <div class="carousel-inner" role="listbox">
                @for ($slide = 1; $slide <= 3; $slide++)
                    <div class="carousel-item {{ $slide === 1 ? 'active' : '' }}"
                        style="background-image: url('{{ \App\SiteSetting::imageUrl($siteSettings, 'banner_' . $slide . '_path') }}')">
                        <div class="carousel-container">
                            <div class="container">
                                <h2 class="animate__animated animate__fadeInDown">
                                    {{ $siteSettings['hero_' . $slide . '_title'] }}
                                </h2>
                                <p class="animate__animated animate__fadeInUp">
                                    {{ $siteSettings['hero_' . $slide . '_description'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

            <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
            </a>
            <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
            </a>
        </div>
    </section>

    <main id="main">
        <section class="program-study-section">
            <div class="container">
                <div class="program-study-heading text-center">
                    <span class="program-study-eyebrow">Program Pendidikan</span>
                    <h3>Program Studi {{ $siteSettings['campus_name'] }}</h3>
                    <p>Pilih program studi untuk melihat diagram pencapaian dan informasi asesmen.</p>
                </div>

                <div class="row program-study-grid">
                    @forelse ($data['p'] as $index => $i)
                        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mb-4">
                            <a href="{{ url('diagram/' . $i->kode) }}" class="program-study-card">
                                <span class="program-study-icon">
                                    <i class="bi {{ $index % 2 === 0 ? 'bi-mortarboard-fill' : 'bi-building' }}"></i>
                                </span>
                                <span class="program-study-content">
                                    <span class="program-study-code">{{ $i->kode }}</span>
                                    <strong>{{ $i->name }}</strong>
                                    @if ($i->jenjang)
                                        <small>{{ $i->jenjang->name }} ({{ $i->jenjang->kode }})</small>
                                    @endif
                                </span>
                                <i class="bi bi-arrow-right program-study-arrow"></i>
                            </a>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="program-study-empty">
                                Belum ada program studi yang ditampilkan.
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    </main>
@endsection
