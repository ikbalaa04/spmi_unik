@extends('template.BaseView', ['title' => 'Akreditasi Program Studi'])

@section('content')
    <div class="admin-form-heading">
        <div>
            <span class="admin-form-eyebrow">Data Institusi</span>
            <h1>Akreditasi Program Studi</h1>
            <p>Kelola peringkat, nomor SK, tanggal, dan link sertifikat setiap program studi.</p>
        </div>
        <a href="{{ route('akreditasi.public') }}" target="_blank" class="btn admin-btn-secondary">
            <i class="fas fa-external-link-alt mr-1"></i> Lihat Halaman Publik
        </a>
    </div>

    @if (session('pesan'))
        <div class="alert alert-success admin-alert">{{ session('pesan') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger admin-alert">
            <strong>Data belum dapat disimpan.</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="admin-form-card">
        <div class="admin-form-card-header">
            <div class="admin-form-header-icon"><i class="fas fa-award"></i></div>
            <div>
                <h2>Tambah Data Akreditasi</h2>
                <p>Satu program studi hanya dapat memiliki satu data akreditasi aktif.</p>
            </div>
        </div>

        <form action="{{ route('akreditasi.admin.store') }}" method="POST" class="admin-form-body pt-4">
            @csrf
            <div class="form-row">
                <div class="form-group col-lg-6">
                    <label for="prodi_id"><i class="fas fa-university"></i> Program Studi</label>
                    <select name="prodi_id" id="prodi_id" class="form-control admin-select2" required>
                        <option value="">Pilih program studi</option>
                        @foreach ($prodis as $prodi)
                            @if (!$prodi->akreditasi)
                                <option value="{{ $prodi->id }}" {{ old('prodi_id') == $prodi->id ? 'selected' : '' }}>
                                    {{ $prodi->kode }} — {{ $prodi->name }}
                                    {{ $prodi->jenjang ? '(' . $prodi->jenjang->kode . ')' : '' }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-lg-6">
                    <label for="fakultas"><i class="fas fa-building"></i> Fakultas</label>
                    <input type="text" name="fakultas" id="fakultas" class="form-control"
                        value="{{ old('fakultas') }}" placeholder="Contoh: Fakultas Teknik" required>
                </div>
                <div class="form-group col-lg-4">
                    <label for="peringkat"><i class="fas fa-medal"></i> Peringkat Akreditasi</label>
                    <input type="text" name="peringkat" id="peringkat" class="form-control"
                        value="{{ old('peringkat') }}" placeholder="Contoh: Unggul" required>
                </div>
                <div class="form-group col-lg-4">
                    <label for="nomor_sk"><i class="fas fa-file-signature"></i> Nomor SK</label>
                    <input type="text" name="nomor_sk" id="nomor_sk" class="form-control"
                        value="{{ old('nomor_sk') }}" placeholder="Contoh: 123/SK/BAN-PT/2026" required>
                </div>
                <div class="form-group col-lg-4">
                    <label for="tanggal_akreditasi"><i class="fas fa-calendar-alt"></i> Tanggal Akreditasi</label>
                    <input type="date" name="tanggal_akreditasi" id="tanggal_akreditasi" class="form-control"
                        value="{{ old('tanggal_akreditasi') }}" required>
                </div>
                <div class="form-group col-12">
                    <label for="sertifikat_url"><i class="fas fa-link"></i> Link Download Sertifikat</label>
                    <input type="url" name="sertifikat_url" id="sertifikat_url" class="form-control"
                        value="{{ old('sertifikat_url') }}" placeholder="https://example.ac.id/sertifikat.pdf">
                    <small class="form-text text-muted">
                        URL tidak ditampilkan langsung di halaman publik; pengunjung hanya melihat tombol download.
                    </small>
                </div>
            </div>

            <div class="admin-form-actions pt-2">
                <button type="reset" class="btn admin-btn-secondary">
                    <i class="fas fa-undo-alt mr-1"></i> Reset
                </button>
                <button type="submit" class="btn admin-btn-primary">
                    <i class="fas fa-save mr-1"></i> Simpan Akreditasi
                </button>
            </div>
        </form>
    </div>

    <div class="card shadow mb-4 accreditation-admin-table-card">
        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Akreditasi</h6>
            <span class="badge badge-light">{{ $akreditasis->count() }} data</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="accreditationAdminTable" width="100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Program Studi</th>
                            <th>Fakultas</th>
                            <th>Peringkat</th>
                            <th>No. SK</th>
                            <th>Tanggal</th>
                            <th>Sertifikat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($akreditasis as $akreditasi)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <strong>{{ $akreditasi->prodi->kode }}</strong><br>
                                    <small>{{ $akreditasi->prodi->name }}</small>
                                </td>
                                <td>{{ $akreditasi->fakultas }}</td>
                                <td><span class="badge badge-success">{{ $akreditasi->peringkat }}</span></td>
                                <td>{{ $akreditasi->nomor_sk }}</td>
                                <td>{{ $akreditasi->tanggal_akreditasi->format('d-m-Y') }}</td>
                                <td>
                                    @if ($akreditasi->sertifikat_url)
                                        <a href="{{ $akreditasi->sertifikat_url }}" target="_blank"
                                            rel="noopener noreferrer" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    <button type="button" class="btn btn-sm btn-warning" data-toggle="modal"
                                        data-target="#editAkreditasi{{ $akreditasi->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                        data-target="#hapusAkreditasi{{ $akreditasi->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            <div class="modal fade" id="editAkreditasi{{ $akreditasi->id }}" tabindex="-1"
                                role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <form action="{{ route('akreditasi.admin.update', $akreditasi) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Akreditasi</h5>
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label>Program Studi</label>
                                                        <select name="prodi_id" class="form-control" required>
                                                            @foreach ($prodis as $prodi)
                                                                @if (!$prodi->akreditasi || $prodi->id === $akreditasi->prodi_id)
                                                                    <option value="{{ $prodi->id }}"
                                                                        {{ $prodi->id === $akreditasi->prodi_id ? 'selected' : '' }}>
                                                                        {{ $prodi->kode }} — {{ $prodi->name }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Fakultas</label>
                                                        <input type="text" name="fakultas" class="form-control"
                                                            value="{{ $akreditasi->fakultas }}" required>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label>Peringkat</label>
                                                        <input type="text" name="peringkat" class="form-control"
                                                            value="{{ $akreditasi->peringkat }}" required>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label>Nomor SK</label>
                                                        <input type="text" name="nomor_sk" class="form-control"
                                                            value="{{ $akreditasi->nomor_sk }}" required>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label>Tanggal Akreditasi</label>
                                                        <input type="date" name="tanggal_akreditasi"
                                                            class="form-control"
                                                            value="{{ $akreditasi->tanggal_akreditasi->format('Y-m-d') }}"
                                                            required>
                                                    </div>
                                                    <div class="form-group col-12 mb-0">
                                                        <label>Link Download Sertifikat</label>
                                                        <input type="url" name="sertifikat_url" class="form-control"
                                                            value="{{ $akreditasi->sertifikat_url }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="modal fade" id="hapusAkreditasi{{ $akreditasi->id }}" tabindex="-1"
                                role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form action="{{ route('akreditasi.admin.destroy', $akreditasi) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Hapus Data Akreditasi</h5>
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Hapus data akreditasi
                                                <strong>{{ $akreditasi->prodi->name }}</strong>?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function() {
            $('.admin-select2').select2({
                width: '100%',
                placeholder: 'Pilih program studi'
            });

            $('#accreditationAdminTable').DataTable({
                pageLength: 10,
                order: [
                    [1, 'asc']
                ],
                columnDefs: [{
                    orderable: false,
                    targets: [6, 7]
                }]
            });
        });
    </script>
@endsection
