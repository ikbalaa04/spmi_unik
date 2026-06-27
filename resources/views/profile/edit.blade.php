@extends('template.BaseView')

@section('content')
    <div class="admin-form-page">
        <div class="admin-form-heading">
            <div>
                <span class="admin-form-eyebrow">Akun Pengguna</span>
                <h1>Profil Saya</h1>
                <p>Perbarui nama, email, dan password akun yang sedang digunakan.</p>
            </div>
        </div>

        @if (session()->has('pesan'))
            {!! session()->get('pesan') !!}
        @endif

        @if ($errors->any())
            <div class="alert alert-danger admin-alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" class="admin-form-card">
            @csrf
            @method('PUT')

            <div class="admin-form-card-header">
                <span class="admin-form-header-icon">
                    <i class="fas fa-user-cog"></i>
                </span>
                <div>
                    <h2>Informasi Profil</h2>
                    <p>Kosongkan password baru jika tidak ingin mengganti password.</p>
                </div>
            </div>

            <div class="admin-form-body">
                <div class="admin-form-step">
                    <span class="admin-form-step-number">1</span>
                    <div class="admin-form-step-content">
                        <h3>Identitas Akun</h3>
                        <p>Nama dan email digunakan sebagai identitas login.</p>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="profile-name"><i class="fas fa-user"></i> Nama</label>
                                    <input type="text" name="name" id="profile-name" class="form-control"
                                        value="{{ old('name', $user->name) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="profile-email"><i class="fas fa-envelope"></i> Email</label>
                                    <input type="email" name="email" id="profile-email" class="form-control"
                                        value="{{ old('email', $user->email) }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="admin-form-step">
                    <span class="admin-form-step-number">2</span>
                    <div class="admin-form-step-content">
                        <h3>Ubah Password</h3>
                        <p>Isi bagian ini hanya ketika password perlu diganti.</p>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="current-password"><i class="fas fa-key"></i> Password Saat Ini</label>
                                    <input type="password" name="current_password" id="current-password"
                                        class="form-control" autocomplete="current-password">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="new-password"><i class="fas fa-lock"></i> Password Baru</label>
                                    <input type="password" name="password" id="new-password" class="form-control"
                                        autocomplete="new-password">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="confirm-password"><i class="fas fa-check-circle"></i> Konfirmasi</label>
                                    <input type="password" name="password_confirmation" id="confirm-password"
                                        class="form-control" autocomplete="new-password">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="admin-form-actions">
                    <a href="{{ route('dashboard') }}" class="btn admin-btn-secondary">Batal</a>
                    <button type="submit" class="btn admin-btn-primary">
                        <i class="fas fa-save mr-1"></i>
                        Simpan Profil
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
