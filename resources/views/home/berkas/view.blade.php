@extends('template.HomeView', ['title' => " $b->file_name "])
@section('content')
    <main id="main">
        <section class="public-document-section">
            <div class="container">
                <div class="public-page-heading">
                    <span>Preview Dokumen</span>
                    <h2>{{ $b->file_name }}</h2>
                    <p>{!! $b->dec ?: 'Detail dokumen pendukung mutu program studi.' !!}</p>
                </div>

                <div class="public-preview-card">
                    <div class="public-preview-header">
                        <div>
                            <h3>{{ $b->file_name }}</h3>
                            <p>Disusun oleh {{ optional($b->user)->name ?? 'Pengelola Dokumen' }}</p>
                        </div>
                        <a href="{{ asset('document/' . $b->file) }}" target="_blank" class="public-file-link">
                            <i class="fa fa-download"></i>
                            <span>Unduh / Buka File</span>
                        </a>
                    </div>

                    <div class="public-preview-frame">
                        <iframe src="{{ asset('document/' . $b->file) }}" allowfullscreen></iframe>
                    </div>

                    <div class="public-preview-meta">
                        <div>
                            <span>Elemen</span>
                            <div class="public-element-content">
                                @if (optional($b->l1)->name)
                                    <strong>{{ $b->l1->name }}</strong>
                                @endif
                                @if ($b->l2_id != 0 && optional($b->l2)->name)
                                    <span>{{ $b->l2->name }}</span>
                                @endif
                                @if ($b->l3_id != 0 && optional($b->l3)->name)
                                    <span>{{ $b->l3->name }}</span>
                                @endif
                                @if ($b->l4_id != 0 && optional($b->l4)->name)
                                    <span>{{ $b->l4->name }}</span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <span>Program Studi</span>
                            <strong>{{ optional($b->prodi)->name ?? '-' }}</strong>
                            <small>{{ optional($b->prodi)->kode ?? '-' }}</small>
                        </div>
                        <div>
                            <span>Nilai</span>
                            <strong class="public-score-badge">{{ $b->score ?? '-' }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
