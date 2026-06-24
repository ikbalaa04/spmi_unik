@extends('template.BaseView', ['title' => 'Pencarian Berkas'])

@section('content')
    <div class="admin-form-heading">
        <div>
            <span class="admin-form-eyebrow">Pusat Dokumen Mutu</span>
            <h1>Pencarian Berkas</h1>
            <p>Telusuri dokumen berdasarkan program studi dan hierarki kriteria penjaminan mutu.</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger admin-alert">
            <strong>Filter pencarian belum valid.</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ url('berkas/hasil') }}" method="POST" class="admin-form-card">
        @csrf

        <div class="admin-form-card-header">
            <div class="admin-form-header-icon"><i class="fas fa-folder-open"></i></div>
            <div>
                <h2>Filter Dokumen</h2>
                <p>Pilih program studi terlebih dahulu, kemudian persempit pencarian jika diperlukan.</p>
            </div>
        </div>

        <div class="admin-form-body">
            <div class="admin-form-step">
                <div class="admin-form-step-number">1</div>
                <div class="admin-form-step-content">
                    <h3>Lingkup Program Studi</h3>
                    <p>Tentukan jenjang pendidikan dan program studi tempat dokumen dikelola.</p>

                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <label for="jen"><i class="fas fa-graduation-cap"></i> Jenjang Pendidikan</label>
                            <select class="form-control" name="jenjang_id" id="jen" required>
                                <option value="">Memuat jenjang...</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="pro"><i class="fas fa-university"></i> Program Studi</label>
                            <select class="form-control" name="prodi_id" id="pro" required disabled>
                                <option value="">Pilih jenjang terlebih dahulu</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="admin-form-step">
                <div class="admin-form-step-number">2</div>
                <div class="admin-form-step-content">
                    <h3>Hierarki Kriteria</h3>
                    <p>Filter berikut bersifat opsional. Pilih satu atau beberapa klasifikasi untuk hasil lebih spesifik.</p>

                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <label for="l1"><i class="fas fa-list-ul"></i> Kriteria Utama</label>
                            <select class="form-control" name="l1_id[]" id="l1" multiple disabled></select>
                            <small class="form-text text-muted">Tersedia setelah program studi dipilih.</small>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="l2"><i class="fas fa-sitemap"></i> Subkriteria</label>
                            <select class="form-control" name="l2_id[]" id="l2" multiple disabled></select>
                            <small class="form-text text-muted">Tersedia setelah Kriteria Utama dipilih.</small>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="l3"><i class="fas fa-stream"></i> Butir Kriteria</label>
                            <select class="form-control" name="l3_id[]" id="l3" multiple disabled></select>
                            <small class="form-text text-muted">Tersedia setelah Subkriteria dipilih.</small>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="l4"><i class="fas fa-code-branch"></i> Subbutir Kriteria</label>
                            <select class="form-control" name="l4_id[]" id="l4" multiple disabled></select>
                            <small class="form-text text-muted">Tingkat klasifikasi dokumen paling rinci.</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="admin-form-actions">
                <button type="button" class="btn admin-btn-secondary" id="reset-document-search">
                    <i class="fas fa-undo-alt mr-1"></i> Reset Filter
                </button>
                <button class="btn admin-btn-primary" type="submit">
                    <i class="fas fa-search mr-1"></i> Cari Berkas
                </button>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script>
        $(function() {
            var fields = {
                jen: $('#jen'),
                pro: $('#pro'),
                l1: $('#l1'),
                l2: $('#l2'),
                l3: $('#l3'),
                l4: $('#l4')
            };

            var placeholders = {
                jen: 'Pilih jenjang pendidikan',
                pro: 'Pilih program studi',
                l1: 'Pilih kriteria utama',
                l2: 'Pilih subkriteria',
                l3: 'Pilih butir kriteria',
                l4: 'Pilih subbutir kriteria'
            };

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.each(fields, function(key, field) {
                field.select2({
                    width: '100%',
                    placeholder: placeholders[key],
                    allowClear: key !== 'jen' && key !== 'pro'
                });
            });

            function clearField(key, message) {
                fields[key].html(message ? '<option value="">' + message + '</option>' : '')
                    .val(null)
                    .prop('disabled', true)
                    .trigger('change.select2');
            }

            function loadOptions(key, url, data) {
                fields[key].prop('disabled', true).trigger('change.select2');

                return $.ajax({
                    type: 'POST',
                    url: url,
                    data: data || {},
                    cache: false
                }).done(function(html) {
                    fields[key].html(html).prop('disabled', false).trigger('change.select2');
                }).fail(function() {
                    clearField(key, 'Data tidak dapat dimuat');
                });
            }

            loadOptions('jen', '{{ route('getJen') }}');

            fields.jen.on('change', function() {
                clearField('pro', 'Pilih jenjang terlebih dahulu');
                clearField('l1');
                clearField('l2');
                clearField('l3');
                clearField('l4');

                if (this.value) {
                    loadOptions('pro', '{{ route('getPro') }}', {
                        jenjang_id: this.value
                    });
                }
            });

            fields.pro.on('change', function() {
                clearField('l1');
                clearField('l2');
                clearField('l3');
                clearField('l4');

                if (this.value) {
                    loadOptions('l1', '{{ route('l1') }}', {
                        jenjang_id: fields.jen.val()
                    });
                }
            });

            fields.l1.on('change', function() {
                clearField('l2');
                clearField('l3');
                clearField('l4');

                if ($(this).val() && $(this).val().length) {
                    loadOptions('l2', '{{ route('l2') }}', {
                        l1_id: $(this).val().join(',')
                    });
                }
            });

            fields.l2.on('change', function() {
                clearField('l3');
                clearField('l4');

                if ($(this).val() && $(this).val().length) {
                    loadOptions('l3', '{{ route('l3') }}', {
                        l2_id: $(this).val().join(',')
                    });
                }
            });

            fields.l3.on('change', function() {
                clearField('l4');

                if ($(this).val() && $(this).val().length) {
                    loadOptions('l4', '{{ route('l4') }}', {
                        l3_id: $(this).val().join(',')
                    });
                }
            });

            $('#reset-document-search').on('click', function() {
                fields.jen.val(null).trigger('change');
                clearField('pro', 'Pilih jenjang terlebih dahulu');
                clearField('l1');
                clearField('l2');
                clearField('l3');
                clearField('l4');
            });
        });
    </script>
@endsection
