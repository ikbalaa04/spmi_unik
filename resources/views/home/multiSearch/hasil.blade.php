@extends('template.HomeView', ['title' => 'Hasil Pencarian'])
@section('content')
    <main id="main">
        <section class="public-document-section">
            <div class="container">
                <div class="public-page-heading">
                    <span>Hasil Pencarian</span>
                    <h2>Hasil Pencarian Dokumen</h2>
                    <p>Menampilkan <b>{{ $berkas->count() }}</b> berkas dokumen berdasarkan kata kunci pencarian yang telah
                        ditentukan.</p>
                </div>

                <div class="public-table-card">
                    <div class="public-table-card-header">
                        <div>
                            <h3>Daftar Dokumen</h3>
                            <p>Dokumen yang cocok dengan kriteria pencarian.</p>
                        </div>
                        <span class="public-count-pill">
                            <i class="fa fa-search"></i>
                            {{ $berkas->count() }} Hasil
                        </span>
                    </div>

                    <div class="table-responsive">
                        <table class="table public-document-table" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th style="width: 48%;">Elemen</th>
                                    <th>Berkas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($berkas as $i)
                                    <tr>
                                        <td>
                                            <div class="public-element-content">
                                                @if (optional($i->l1)->name)
                                                    <strong>{{ $i->l1->name }}</strong>
                                                @endif
                                                @if (optional($i->l2)->name)
                                                    <span>{{ $i->l2->name }}</span>
                                                @endif
                                                @if (optional($i->l3)->name)
                                                    <span>{{ $i->l3->name }}</span>
                                                @endif
                                                @if (optional($i->l4)->name)
                                                    <span>{{ $i->l4->name }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ url('tabel/view/' . $i->id) }}" target="_blank"
                                                class="public-file-link">
                                                <i class="fa fa-file-text-o"></i>
                                                <span>{{ $i->file_name }}</span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2">
                                            <div class="public-empty-state">
                                                <i class="fa fa-search"></i>
                                                <strong>Dokumen tidak ditemukan</strong>
                                                <span>Coba ubah kata kunci atau filter pencarian.</span>
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
