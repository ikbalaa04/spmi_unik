@extends('template.BaseView', ['title' => $pageTitle])

@section('content')
    <div class="admin-form-heading">
        <div>
            <span class="admin-form-eyebrow">Ketentuan Pencapaian</span>
            <h1>{{ $pageTitle }}</h1>
            <p>Tentukan nilai minimum yang harus dicapai oleh elemen asesmen ini.</p>
        </div>
        <a href="{{ route('element-' . $element->prodi->kode) }}" class="btn admin-btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Elemen
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger admin-alert">
            <strong>Nilai belum dapat disimpan.</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ $formAction }}" method="POST" class="admin-form-card requirement-form-card">
        @csrf
        @method('PUT')

        <div class="admin-form-card-header">
            <div class="admin-form-header-icon"><i class="{{ $headerIcon }}"></i></div>
            <div>
                <h2>{{ $pageTitle }}</h2>
                <p>{{ $headerDescription }}</p>
            </div>
        </div>

        <div class="admin-form-body">
            <div class="requirement-context">
                <div class="requirement-context-icon">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div>
                    <span>{{ $element->prodi->kode }} · {{ $element->prodi->name }}</span>
                    <h3>{{ optional($element->l1)->name ?: 'Elemen Asesmen' }}</h3>
                    @if ($element->l2_id && optional($element->l2)->name)
                        <p>{{ $element->l2->name }}</p>
                    @endif
                    @if ($element->l3_id && optional($element->l3)->name)
                        <p>{{ $element->l3->name }}</p>
                    @endif
                    @if ($element->l4_id && optional($element->l4)->name)
                        <p>{{ $element->l4->name }}</p>
                    @endif
                </div>
            </div>

            <div class="requirement-indicator">
                <span>Indikator Penilaian</span>
                <div>{!! optional($element->indikator)->dec !!}</div>
            </div>

            <div class="requirement-score-grid">
                <div class="requirement-current-score">
                    <span>Nilai Tercapai Saat Ini</span>
                    <strong>{{ number_format((float) $element->score_hitung, 2) }}</strong>
                    <small>Dihitung otomatis dari berkas dan bobot elemen.</small>
                </div>

                <div class="form-group requirement-minimum-input">
                    <label for="minimum-score">
                        <i class="fas fa-bullseye"></i> Nilai Minimum {{ $rankLabel }}
                    </label>
                    <div class="admin-weight-input">
                        <input type="number" class="form-control" id="minimum-score" name="min"
                            value="{{ old('min', $currentMinimum > 0 ? $currentMinimum : '') }}" min="0"
                            step="0.01" placeholder="Contoh: 3.50" required autofocus>
                        <span>poin</span>
                    </div>
                    <small class="form-text text-muted">
                        Status akan dihitung ulang setelah nilai minimum disimpan.
                    </small>
                </div>
            </div>

            <div class="admin-form-actions">
                <a href="{{ route('element-' . $element->prodi->kode) }}" class="btn admin-btn-secondary">
                    Batal
                </a>
                <button class="btn admin-btn-primary" type="submit">
                    <i class="fas fa-save mr-1"></i> Simpan Ketentuan
                </button>
            </div>
        </div>
    </form>
@endsection
