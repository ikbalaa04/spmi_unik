@extends('template.HomeView', ['title' => "$p->name"])

@section('content')
    <main id="main">
        <section class="public-document-section">
            <div class="container">
                <div class="public-page-heading">
                    <span>Dokumen Mutu</span>
                    <h2>{{ $p->name }}</h2>
                    <p>Daftar elemen asesmen dan dokumen pendukung yang tersedia untuk program studi ini.</p>
                </div>

                <div class="public-table-card">
                    <div class="public-table-card-header">
                        <div>
                            <h3>Daftar Elemen</h3>
                            <p>Gunakan pencarian untuk menemukan elemen atau indikator tertentu.</p>
                        </div>
                        <span class="public-count-pill">
                            <i class="bi bi-list-check"></i>
                            {{ $e->count() }} Elemen
                        </span>
                    </div>

                    <div class="table-responsive">
                        <table class="table public-document-table" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Element</th>
                                    <th width="170px">Berkas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($e as $i)
                                    <tr>
                                        <td>
                                            <span class="public-row-number">{{ $loop->iteration }}</span>
                                        </td>
                                        <td>
                                            <div class="public-element-content">
                                                <strong>{{ $i->l1->name }}</strong>

                                                @if ($i->l3_id == 0 && $i->l4_id == 0 && $i->l2_id != 0)
                                                    <span>{{ $i->l2->name }}</span>
                                                @elseif($i->l4_id == 0 && $i->l3_id != 0)
                                                    <span>{{ $i->l2->name }}</span>
                                                    <span>{{ $i->l3->name }}</span>
                                                @elseif($i->l4_id != 0)
                                                    <span>{{ $i->l2->name }}</span>
                                                    <span>{{ $i->l3->name }}</span>
                                                    <span>{{ $i->l4->name }}</span>
                                                @endif

                                                <div>{!! $i->indikator->dec !!}</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="dropdown public-file-dropdown">
                                                <button class="btn public-file-button dropdown-toggle" type="button"
                                                    id="triggerId{{ $i->id }}" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    <i class="bi bi-folder2-open"></i>
                                                    Berkas
                                                </button>
                                                <div class="dropdown-menu public-file-menu"
                                                    aria-labelledby="triggerId{{ $i->id }}">
                                                    <a class="dropdown-item" href="{{ url('tabel/berkas/' . $i->id) }}">
                                                        <span class="public-file-menu-label">
                                                            <i class="bi bi-eye"></i>
                                                            Lihat Berkas
                                                        </span>
                                                        <span class="public-file-menu-count">{{ $i->count_berkas }}</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
