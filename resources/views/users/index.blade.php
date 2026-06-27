@extends('template.BaseView')
@section('content')
    @php
        $roleActions = [
            [
                'label' => 'Admin',
                'description' => 'Akses penuh pengelolaan sistem.',
                'icon' => 'fa-user-shield',
                'route' => 'tambah-admin',
                'admin_only' => true,
            ],
            [
                'label' => 'Ketua LPM',
                'description' => 'Pengelola mutu tingkat lembaga.',
                'icon' => 'fa-award',
                'route' => 'tambah-lpm',
            ],
            [
                'label' => 'Ketua Program Studi',
                'description' => 'Pengelola asesmen per program studi.',
                'icon' => 'fa-user-tie',
                'route' => 'tambah-kaprodi',
            ],
            [
                'label' => 'Dosen',
                'description' => 'Akses pengisian dan validasi asesmen.',
                'icon' => 'fa-chalkboard-teacher',
                'route' => 'tambah-dosen',
            ],
            [
                'label' => 'UPPS',
                'description' => 'Pengelola unit pengelola program studi.',
                'icon' => 'fa-university',
                'route' => 'tambah-upps',
                'admin_only' => true,
            ],
            [
                'label' => 'Mahasiswa / Alumni',
                'description' => 'Akses responden mahasiswa dan alumni.',
                'icon' => 'fa-user-graduate',
                'route' => 'tambah-mhsalm',
            ],
        ];
    @endphp

    <div class="user-management-page">
        <div class="admin-form-heading">
            <div>
                <span class="admin-form-eyebrow">Manajemen Pengguna</span>
                <h1>Data Pengguna</h1>
                <p>Kelola akun, peran akses, dan pengguna yang terhubung dengan sistem mutu.</p>
            </div>
        </div>

        <div class="user-management-grid">
            <div class="user-table-card">
                <div class="user-table-card-header">
                    <div>
                        <h2>Daftar Pengguna</h2>
                        <p>Gunakan kolom pencarian untuk menemukan akun tertentu.</p>
                    </div>
                    <span class="user-count-pill">
                        <i class="fas fa-users"></i>
                        {{ $users->count() }} Pengguna
                    </span>
                </div>

                <div class="user-table-card-body">
                    @if (session()->has('pesan'))
                        {!! session()->get('pesan') !!}
                    @endif

                    <div class="table-responsive">
                        <table class="table modern-data-table" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Pengguna</th>
                                    <th>Role</th>
                                    <th width="150px">Aksi</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Pengguna</th>
                                    <th>Role</th>
                                    <th width="150px">Aksi</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($users as $i)
                                    <tr>
                                        <td>
                                            <div class="user-name-cell">
                                                <span class="user-avatar-initial">
                                                    {{ strtoupper(substr($i->name, 0, 1)) }}
                                                </span>
                                                <div>
                                                    <strong>{{ $i->name }}</strong>
                                                    <span>{{ $i->email }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="user-role-badge">
                                                <i class="fas fa-id-badge"></i>
                                                {{ $i->role }}
                                            </span>
                                        </td>
                                        <td width="150px">
                                            <div class="user-action-buttons">
                                                <a href="{{ url('users/edit/' . $i->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-pen"></i>
                                                    Edit
                                                </a>
                                                <form action="users/hapus/{{ $i->id }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <aside class="user-role-card">
                <div class="user-role-card-header">
                    <div>
                        <h2>Tambah Pengguna</h2>
                        <p>Pilih role akun yang akan dibuat.</p>
                    </div>
                    <span class="user-count-pill">
                        <i class="fas fa-plus"></i>
                    </span>
                </div>

                <div class="user-role-card-body">
                    <div class="user-role-list">
                        @foreach ($roleActions as $roleAction)
                            @if (!($roleAction['admin_only'] ?? false) || Auth::user()->role == 'Admin')
                                <a href="{{ route($roleAction['route']) }}" class="user-role-link">
                                    <span class="user-role-icon">
                                        <i class="fas {{ $roleAction['icon'] }}"></i>
                                    </span>
                                    <span class="user-role-text">
                                        <strong>{{ $roleAction['label'] }}</strong>
                                        <span>{{ $roleAction['description'] }}</span>
                                    </span>
                                    <i class="fas fa-arrow-right user-role-arrow"></i>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </div>
@endsection
