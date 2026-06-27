@extends('template.HomeView')
@section('content')
    <main id="main">
        <section class="public-document-section">
            <div class="container">
                <div class="public-page-heading">
                    <span>Dokumen Mutu</span>
                    <h2>{{ optional($e->l1)->name ?? 'Daftar Berkas' }}</h2>
                    <p>{!! optional($e->indikator)->dec ?? 'Daftar dokumen pendukung untuk elemen penilaian.' !!}</p>
                </div>

                <div class="public-table-card">
                    <div class="public-table-card-header">
                        <div>
                            <h3>Berkas dan Nilai</h3>
                            <p>Dokumen pendukung yang terhubung dengan elemen ini.</p>
                        </div>
                        <span class="public-count-pill">
                            <i class="fa fa-file-text-o"></i>
                            {{ $b->count() }} Berkas
                        </span>
                    </div>

                    <div class="table-responsive">
                        <table class="table public-document-table" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th style="width: 54%;">Berkas</th>
                                    <th>Keterangan</th>
                                    <th style="width: 120px;">Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($b as $i)
                                    <tr>
                                        <td>
                                            <a href="{{ url('tabel/view/' . $i->id) }}" target="_blank"
                                                class="public-file-link">
                                                <i class="fa fa-file-text-o"></i>
                                                <span>{{ $i->file_name }}</span>
                                            </a>
                                        </td>
                                        <td>
                                            <div class="public-element-content">
                                                {!! $i->dec ?: '<span>Tidak ada keterangan tambahan.</span>' !!}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="public-score-badge">{{ $i->score ?? '-' }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">
                                            <div class="public-empty-state">
                                                <i class="fa fa-folder-open-o"></i>
                                                <strong>Belum ada berkas</strong>
                                                <span>Dokumen untuk elemen ini belum tersedia.</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
