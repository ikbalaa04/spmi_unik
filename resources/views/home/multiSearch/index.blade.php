@extends('template.HomeView', ['title' => 'Pencarian Berkas'])

@section('content')
    <main id="main">
        <section class="document-search-section">
            <div class="container">
                <div class="document-search-intro">
                    <span class="document-search-eyebrow">Pusat Dokumen Mutu</span>
                    <h2>Pencarian Berkas Terstruktur</h2>
                    <p>Telusuri dokumen berdasarkan program studi dan hierarki kriteria penjaminan mutu.</p>
                </div>

                <div class="document-search-card">
                    <div class="document-search-card-header">
                        <div class="document-search-header-icon">
                            <i class="bi bi-folder2-open"></i>
                        </div>
                        <div>
                            <h3>Filter Dokumen</h3>
                            <p>Pilih jenjang dan program studi terlebih dahulu, lalu persempit berdasarkan kriteria.</p>
                        </div>
                    </div>

                    <form action="{{ url('multi-search/hasil') }}" method="post" class="document-search-form">
                        @csrf

                        <div class="document-search-step">
                            <div class="document-search-step-number">1</div>
                            <div class="document-search-step-content">
                                <h4>Lingkup Program Studi</h4>
                                <p>Tentukan unit pendidikan tempat dokumen dikelola.</p>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="document-field">
                                            <label for="jen">
                                                <i class="bi bi-mortarboard"></i>
                                                Jenjang Pendidikan
                                                <span>Wajib</span>
                                            </label>
                                            <select class="form-control" name="jenjang_id" id="jen" required>
                                                <option value="">Memuat jenjang...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="document-field">
                                            <label for="pro">
                                                <i class="bi bi-building"></i>
                                                Program Studi
                                                <span>Wajib</span>
                                            </label>
                                            <select class="form-control" name="prodi_id" id="pro" required disabled>
                                                <option value="">Pilih jenjang terlebih dahulu</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="document-search-step">
                            <div class="document-search-step-number">2</div>
                            <div class="document-search-step-content">
                                <h4>Hierarki Kriteria</h4>
                                <p>Bagian ini opsional. Pilih satu atau beberapa kriteria untuk hasil yang lebih spesifik.</p>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="document-field">
                                            <label for="l1"><i class="bi bi-list-check"></i> Kriteria Utama</label>
                                            <select class="form-control" name="l1_id[]" id="l1" multiple disabled></select>
                                            <small>Contoh: Tata Pamong, Mahasiswa, atau Sumber Daya Manusia.</small>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="document-field">
                                            <label for="l2"><i class="bi bi-diagram-2"></i> Subkriteria</label>
                                            <select class="form-control" name="l2_id[]" id="l2" multiple disabled></select>
                                            <small>Tersedia setelah Kriteria Utama dipilih.</small>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="document-field">
                                            <label for="l3"><i class="bi bi-card-checklist"></i> Butir Kriteria</label>
                                            <select class="form-control" name="l3_id[]" id="l3" multiple disabled></select>
                                            <small>Tersedia setelah Subkriteria dipilih.</small>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="document-field">
                                            <label for="l4"><i class="bi bi-node-plus"></i> Subbutir Kriteria</label>
                                            <select class="form-control" name="l4_id[]" id="l4" multiple disabled></select>
                                            <small>Tingkat paling rinci dalam klasifikasi dokumen.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="document-search-actions">
                            <button type="button" class="document-search-reset" id="reset-search">
                                <i class="bi bi-arrow-counterclockwise"></i> Reset Filter
                            </button>
                            <button class="document-search-submit" type="submit">
                                <i class="bi bi-search"></i> Cari Berkas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
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

            $('#reset-search').on('click', function() {
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
