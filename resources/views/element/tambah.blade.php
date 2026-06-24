@extends('template.BaseView', ['title' => 'Tambah Elemen Asesmen'])

@section('content')
    <div class="admin-form-heading">
        <div>
            <span class="admin-form-eyebrow">Manajemen Asesmen</span>
            <h1>Tambah Elemen Asesmen</h1>
            <p>Hubungkan program studi, hierarki kriteria, indikator, dan bobot penilaian.</p>
        </div>
    </div>

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

    <form action="{{ url('element/store') }}" method="post" class="admin-form-card">
        @csrf

        <div class="admin-form-card-header">
            <div class="admin-form-header-icon"><i class="fas fa-layer-group"></i></div>
            <div>
                <h2>Informasi Elemen</h2>
                <p>Field bertingkat akan aktif setelah pilihan induknya tersedia.</p>
            </div>
        </div>

        <div class="admin-form-body">
            <div class="admin-form-step">
                <div class="admin-form-step-number">1</div>
                <div class="admin-form-step-content">
                    <h3>Lingkup Program Studi</h3>
                    <p>Pilih jenjang dan program studi yang akan menerima elemen asesmen.</p>

                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <label for="jen"><i class="fas fa-graduation-cap"></i> Jenjang Pendidikan</label>
                            @if ($selectedProdi)
                                <input type="hidden" name="jenjang_id" value="{{ $selectedProdi->jenjang_id }}">
                                <select class="form-control" id="jen" disabled>
                                    <option value="{{ $selectedProdi->jenjang_id }}" selected>
                                        {{ $selectedProdi->jenjang ? $selectedProdi->jenjang->name : 'Jenjang terpilih' }}
                                    </option>
                                </select>
                                <small class="form-text text-muted">Terisi otomatis dari program studi aktif.</small>
                            @else
                                <select class="form-control" name="jenjang_id" id="jen" required>
                                    <option value="">Memuat jenjang...</option>
                                </select>
                            @endif
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="pro"><i class="fas fa-university"></i> Program Studi</label>
                            @if ($selectedProdi)
                                <input type="hidden" name="prodi_id" value="{{ $selectedProdi->id }}">
                                <select class="form-control" id="pro" disabled>
                                    <option value="{{ $selectedProdi->id }}" selected>
                                        {{ $selectedProdi->kode }} — {{ $selectedProdi->name }}
                                    </option>
                                </select>
                                <small class="form-text text-muted">Elemen akan ditambahkan ke program studi ini.</small>
                            @else
                                <select class="form-control" name="prodi_id" id="pro" required disabled>
                                    <option value="">Pilih jenjang terlebih dahulu</option>
                                </select>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="admin-form-step">
                <div class="admin-form-step-number">2</div>
                <div class="admin-form-step-content">
                    <h3>Hierarki Kriteria</h3>
                    <p>Pilih klasifikasi elemen dari kriteria utama hingga subbutir yang dibutuhkan.</p>

                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <label for="l1"><i class="fas fa-list-check"></i> Kriteria Utama</label>
                            <select class="form-control" name="l1_id[]" id="l1" multiple required disabled></select>
                            <small class="form-text text-muted">Minimal satu Kriteria Utama wajib dipilih.</small>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="l2"><i class="fas fa-sitemap"></i> Subkriteria</label>
                            <select class="form-control" name="l2_id[]" id="l2" multiple disabled></select>
                            <small class="form-text text-muted">Opsional, tersedia setelah Kriteria Utama dipilih.</small>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="l3"><i class="fas fa-stream"></i> Butir Kriteria</label>
                            <select class="form-control" name="l3_id[]" id="l3" multiple disabled></select>
                            <small class="form-text text-muted">Opsional, tersedia setelah Subkriteria dipilih.</small>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="l4"><i class="fas fa-code-branch"></i> Subbutir Kriteria</label>
                            <select class="form-control" name="l4_id[]" id="l4" multiple disabled></select>
                            <small class="form-text text-muted">Tingkat klasifikasi paling rinci.</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="admin-form-step">
                <div class="admin-form-step-number">3</div>
                <div class="admin-form-step-content">
                    <h3>Parameter Penilaian</h3>
                    <p>Tentukan indikator penilaian dan bobot kontribusi elemen.</p>

                    <div class="form-row">
                        <div class="form-group col-lg-8">
                            <label for="ind"><i class="fas fa-chart-line"></i> Indikator Penilaian</label>
                            <select class="form-control" name="ind_id" id="ind" required disabled>
                                <option value="">Pilih jenjang terlebih dahulu</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="bobot"><i class="fas fa-weight-hanging"></i> Bobot Elemen</label>
                            <div class="admin-weight-input">
                                <input type="number" class="form-control" id="bobot" name="bobot"
                                    value="{{ old('bobot') }}" min="0" step="0.01" placeholder="3.50" required>
                                <span>poin</span>
                            </div>
                            <small class="form-text text-muted">Gunakan angka desimal, contoh 3.50.</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="admin-form-actions">
                <button type="button" class="btn admin-btn-secondary" id="reset-element">
                    <i class="fas fa-undo-alt mr-1"></i> Reset
                </button>
                <button class="btn admin-btn-primary" type="submit">
                    <i class="fas fa-save mr-1"></i> Simpan Elemen
                </button>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var hasSelectedProdi = @json((bool) $selectedProdi);
            var selectedJenjangId = @json($selectedProdi ? $selectedProdi->jenjang_id : null);

            var fields = {
                jen: $('#jen'),
                pro: $('#pro'),
                l1: $('#l1'),
                l2: $('#l2'),
                l3: $('#l3'),
                l4: $('#l4'),
                ind: $('#ind')
            };

            var placeholders = {
                jen: 'Pilih jenjang pendidikan',
                pro: 'Pilih program studi',
                l1: 'Pilih kriteria utama',
                l2: 'Pilih subkriteria',
                l3: 'Pilih butir kriteria',
                l4: 'Pilih subbutir kriteria',
                ind: 'Pilih indikator penilaian'
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

            if (hasSelectedProdi) {
                loadOptions('l1', '{{ route('l1') }}', {
                    jenjang_id: selectedJenjangId
                });
                loadOptions('ind', '{{ route('getInd') }}', {
                    jenjang_id: selectedJenjangId
                });
            } else {
                loadOptions('jen', '{{ route('getJen') }}');
            }

            if (!hasSelectedProdi) {
                fields.jen.on('change', function() {
                    clearField('pro', 'Pilih jenjang terlebih dahulu');
                    clearField('l1');
                    clearField('l2');
                    clearField('l3');
                    clearField('l4');
                    clearField('ind', 'Pilih jenjang terlebih dahulu');

                    if (this.value) {
                        loadOptions('pro', '{{ route('getPro') }}', { jenjang_id: this.value });
                        loadOptions('ind', '{{ route('getInd') }}', { jenjang_id: this.value });
                    }
                });
            }

            if (!hasSelectedProdi) {
                fields.pro.on('change', function() {
                    clearField('l1');
                    clearField('l2');
                    clearField('l3');
                    clearField('l4');

                    if (this.value) {
                        loadOptions('l1', '{{ route('l1') }}', { jenjang_id: fields.jen.val() });
                    }
                });
            }

            fields.l1.on('change', function() {
                clearField('l2');
                clearField('l3');
                clearField('l4');

                if ($(this).val() && $(this).val().length) {
                    loadOptions('l2', '{{ route('l2') }}', { l1_id: $(this).val().join(',') });
                }
            });

            fields.l2.on('change', function() {
                clearField('l3');
                clearField('l4');

                if ($(this).val() && $(this).val().length) {
                    loadOptions('l3', '{{ route('l3') }}', { l2_id: $(this).val().join(',') });
                }
            });

            fields.l3.on('change', function() {
                clearField('l4');

                if ($(this).val() && $(this).val().length) {
                    loadOptions('l4', '{{ route('l4') }}', { l3_id: $(this).val().join(',') });
                }
            });

            $('#reset-element').on('click', function() {
                if (hasSelectedProdi) {
                    fields.l1.val(null).trigger('change');
                    fields.ind.val(null).trigger('change');
                } else {
                    fields.jen.val(null).trigger('change');
                }
                $('#bobot').val('');
            });
        });
    </script>
@endsection
