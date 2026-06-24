@extends('template.BaseView', ['title' => 'Identitas Situs'])

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">Identitas dan Halaman Home</h1>
            <p class="mb-0 text-muted">Kelola nama sistem, identitas kampus, banner, dan konten halaman publik.</p>
        </div>
        <a href="{{ route('home') }}" target="_blank" class="btn btn-sm btn-outline-primary">
            <i class="fas fa-external-link-alt mr-1"></i> Lihat Home
        </a>
    </div>

    @if (session('pesan'))
        <div class="alert alert-success">{{ session('pesan') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Data belum dapat disimpan.</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('site-settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Identitas Utama</h6>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Nama Sistem</label>
                        <input type="text" name="system_name" class="form-control"
                            value="{{ old('system_name', $settings['system_name']) }}">
                        <small class="text-muted">Boleh dikosongkan jika header hanya menampilkan logo.</small>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Nama Kampus</label>
                        <input type="text" name="campus_name" class="form-control"
                            value="{{ old('campus_name', $settings['campus_name']) }}" required>
                    </div>
                </div>

                <div class="form-group mb-0">
                    <label>Logo</label>
                    <div class="d-flex align-items-center">
                        <img src="{{ \App\SiteSetting::imageUrl($settings, 'logo_path') }}"
                            onerror="this.onerror=null;this.src='{{ asset('home/img/favicon.png') }}';" alt=""
                            class="mr-3 border rounded p-2"
                            style="width: 90px; height: 90px; object-fit: contain;">
                        <div class="flex-grow-1">
                            <input type="file" name="logo" class="form-control-file" accept=".jpg,.jpeg,.png,.webp">
                            <small class="text-muted">PNG/WebP transparan disarankan. Maksimal 4 MB.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Banner Utama</h6>
            </div>
            <div class="card-body">
                @for ($slide = 1; $slide <= 3; $slide++)
                    <div class="border rounded p-3 mb-4">
                        <h6 class="font-weight-bold">Slide {{ $slide }}</h6>
                        <img src="{{ \App\SiteSetting::imageUrl($settings, 'banner_' . $slide . '_path') }}"
                            onerror="this.onerror=null;this.src='{{ asset('home/img/slide/slide-' . $slide . '.jpg') }}';"
                            class="img-fluid rounded mb-3" alt="" style="width: 100%; max-height: 240px; object-fit: cover;">
                        <div class="form-group">
                            <label>Gambar Banner</label>
                            <input type="file" name="banner_{{ $slide }}" class="form-control-file"
                                accept=".jpg,.jpeg,.png,.webp">
                        </div>
                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text" name="hero_{{ $slide }}_title" class="form-control"
                                value="{{ old('hero_' . $slide . '_title', $settings['hero_' . $slide . '_title']) }}"
                                required>
                        </div>
                        <div class="form-group mb-0">
                            <label>Deskripsi</label>
                            <textarea name="hero_{{ $slide }}_description" class="form-control" rows="2" required>{{ old('hero_' . $slide . '_description', $settings['hero_' . $slide . '_description']) }}</textarea>
                        </div>
                    </div>
                @endfor
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Bagian Informasi</h6>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Judul Bagian</label>
                    <input type="text" name="about_title" class="form-control"
                        value="{{ old('about_title', $settings['about_title']) }}" required>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="about_description" class="form-control" rows="3" required>{{ old('about_description', $settings['about_description']) }}</textarea>
                </div>
                <div class="form-group mb-0">
                    <label>Gambar Pendukung</label>
                    <div class="row align-items-center">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <img src="{{ \App\SiteSetting::imageUrl($settings, 'about_image_path') }}"
                                onerror="this.onerror=null;this.src='{{ asset('home/img/about.png') }}';"
                                class="img-fluid rounded border" alt="">
                        </div>
                        <div class="col-md-8">
                            <input type="file" name="about_image" class="form-control-file"
                                accept=".jpg,.jpeg,.png,.webp">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-right mb-5">
            <button type="submit" class="btn btn-primary px-4">
                <i class="fas fa-save mr-1"></i> Simpan Pengaturan
            </button>
        </div>
    </form>
@endsection
