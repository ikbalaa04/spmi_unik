@extends('template.HomeView', ['title' => 'Akreditasi Program Studi'])

@section('content')
    <main id="main">
        <section class="accreditation-section">
            <div class="container">
                <div class="accreditation-heading">
                    <span>Informasi Mutu</span>
                    <h1>Akreditasi Program Studi</h1>
                    <p>
                        Informasi peringkat, surat keputusan, dan sertifikat akreditasi program studi
                        {{ $siteSettings['campus_name'] }}.
                    </p>
                </div>

                <div class="accreditation-table-card">
                    <div class="accreditation-table-header">
                        <div>
                            <h2>Daftar Akreditasi</h2>
                            <p>Gunakan kolom pencarian untuk menemukan program studi.</p>
                        </div>
                        <span>{{ $akreditasis->count() }} Program Studi</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table accreditation-table" id="accreditationTable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kode Prodi</th>
                                    <th>Nama Program Studi</th>
                                    <th>Fakultas</th>
                                    <th>Akreditasi</th>
                                    <th>Download Sertifikat</th>
                                    <th>No. SK</th>
                                    <th>Tanggal Akreditasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($akreditasis as $akreditasi)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><strong>{{ $akreditasi->prodi->kode }}</strong></td>
                                        <td>
                                            <span class="accreditation-program-name">
                                                {{ $akreditasi->prodi->name }}
                                            </span>
                                            @if ($akreditasi->prodi->jenjang)
                                                <small>{{ $akreditasi->prodi->jenjang->kode }}</small>
                                            @endif
                                        </td>
                                        <td>{{ $akreditasi->fakultas }}</td>
                                        <td>
                                            <span class="accreditation-rank">{{ $akreditasi->peringkat }}</span>
                                        </td>
                                        <td>
                                            @if ($akreditasi->sertifikat_url)
                                                <a href="{{ $akreditasi->sertifikat_url }}" target="_blank"
                                                    rel="noopener noreferrer" class="accreditation-download">
                                                    <i class="bi bi-download"></i>
                                                    Download Sertifikat
                                                </a>
                                            @else
                                                <span class="accreditation-unavailable">Belum tersedia</span>
                                            @endif
                                        </td>
                                        <td>{{ $akreditasi->nomor_sk }}</td>
                                        <td data-order="{{ $akreditasi->tanggal_akreditasi->format('Y-m-d') }}">
                                            {{ $akreditasi->tanggal_akreditasi->format('d-m-Y') }}
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

@section('script')
    <script>
        $(function() {
            $('#accreditationTable').DataTable({
                pageLength: 20,
                lengthMenu: [
                    [10, 20, 50, 100, -1],
                    [10, 20, 50, 100, 'Semua']
                ],
                order: [
                    [2, 'asc']
                ],
                columnDefs: [{
                    orderable: false,
                    targets: [5]
                }],
                language: {
                    search: 'Cari:',
                    lengthMenu: 'Tampilkan _MENU_ data',
                    info: 'Menampilkan _START_–_END_ dari _TOTAL_ data',
                    infoEmpty: 'Belum ada data akreditasi',
                    zeroRecords: 'Data akreditasi tidak ditemukan',
                    paginate: {
                        previous: 'Sebelumnya',
                        next: 'Berikutnya'
                    }
                }
            });
        });
    </script>
@endsection
