@extends('template.HomeView', ['title' => 'Home'])

@section('content')
    <section id="hero">
        <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>

            <div class="carousel-inner" role="listbox">
                @for ($slide = 1; $slide <= 3; $slide++)
                    <div class="carousel-item {{ $slide === 1 ? 'active' : '' }}"
                        style="background-image: url('{{ asset($siteSettings['banner_' . $slide . '_path']) }}')">
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
        <section id="featured-services" class="featured-services section-bg">
            <div class="container">
                <div class="row no-gutters">
                    @php
                        $featureIcons = ['bi-laptop', 'bi-briefcase', 'bi-calendar4-week'];
                    @endphp
                    @for ($feature = 1; $feature <= 3; $feature++)
                        <div class="col-lg-4 col-md-6">
                            <div class="icon-box">
                                <div class="icon"><i class="bi {{ $featureIcons[$feature - 1] }}"></i></div>
                                <h4 class="title">{{ $siteSettings['feature_' . $feature . '_title'] }}</h4>
                                <p class="description">{{ $siteSettings['feature_' . $feature . '_description'] }}</p>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="section-title">
                    <h2>{{ $siteSettings['about_title'] }}</h2>
                    <p>{{ $siteSettings['about_description'] }}</p>
                </div>

                <div class="row align-items-center">
                    <div class="col-lg-6 order-1 order-lg-2">
                        <img src="{{ asset($siteSettings['about_image_path']) }}" class="img-fluid"
                            alt="{{ $siteSettings['campus_name'] }}">
                    </div>
                    <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content">
                        <h3>Program Studi {{ $siteSettings['campus_name'] }}</h3>
                        <p class="fst-italic">
                            Daftar program studi yang terdaftar pada
                            <strong>{{ $siteSettings['system_name'] ?: $siteSettings['campus_name'] }}</strong>.
                        </p>
                        <ul>
                            @foreach ($data['p'] as $i)
                                <li>
                                    <i class="bi bi-check-circled"></i>
                                    <a href="{{ url('diagram/' . $i->kode) }}">
                                        {{ $i->name }} - <b>{{ $i->kode }}</b>
                                        @if ($i->jenjang)
                                            ({{ $i->jenjang->kode }})
                                        @endif
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
