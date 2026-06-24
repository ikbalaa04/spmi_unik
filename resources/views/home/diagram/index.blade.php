@extends('template.HomeView', ['title' => 'Diagram Pencapaian'])

@section('content')
    <main id="main">
        <section class="achievement-section">
            <div class="container">
                <div class="achievement-heading">
                    <span>Ringkasan Mutu</span>
                    <h2>Diagram Pencapaian Program Studi</h2>
                    <p>
                        Perbandingan nilai asesmen seluruh program studi di
                        {{ $siteSettings['campus_name'] }}.
                    </p>
                </div>

                <div class="achievement-summary">
                    <div class="achievement-summary-item">
                        <i class="bi bi-building"></i>
                        <div>
                            <strong>{{ $programs->count() }}</strong>
                            <span>Program Studi</span>
                        </div>
                    </div>
                    <div class="achievement-summary-item">
                        <i class="bi bi-ui-checks-grid"></i>
                        <div>
                            <strong>{{ $programs->sum('element_count') }}</strong>
                            <span>Total Elemen</span>
                        </div>
                    </div>
                    <div class="achievement-summary-item">
                        <i class="bi bi-graph-up-arrow"></i>
                        <div>
                            <strong>{{ number_format($programs->sum('score'), 2) }}</strong>
                            <span>Total Pencapaian</span>
                        </div>
                    </div>
                </div>

                <div class="achievement-card">
                    <div class="achievement-card-header">
                        <div>
                            <h3>Nilai Asesmen Tercapai</h3>
                            <p>Klik batang diagram untuk membuka detail program studi.</p>
                        </div>
                        <span class="achievement-live-badge">
                            <i class="bi bi-database-check"></i> Data Dinamis
                        </span>
                    </div>

                    @if ($programs->isEmpty())
                        <div class="achievement-empty">
                            <i class="bi bi-bar-chart"></i>
                            <h4>Belum ada data program studi</h4>
                            <p>Diagram akan tampil setelah program studi dan elemen asesmen tersedia.</p>
                        </div>
                    @else
                        <div class="achievement-chart-wrap">
                            <canvas id="barChart"></canvas>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>
@endsection

@section('script')
    @if ($programs->isNotEmpty())
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
        <script>
            const labels = @json($programs->pluck('name')->values());
            const scores = @json($programs->pluck('score')->map(function ($score) {
                return (float) $score;
            })->values());
            const links = @json($programs->map(function ($program) {
                return url('diagram/' . $program->kode);
            })->values());
            const palette = [
                ['rgba(92, 184, 116, .68)', '#5cb874'],
                ['rgba(23, 77, 114, .68)', '#174d72'],
                ['rgba(61, 164, 171, .68)', '#3da4ab'],
                ['rgba(246, 177, 63, .68)', '#f6b13f'],
                ['rgba(120, 102, 190, .68)', '#7866be'],
                ['rgba(225, 111, 121, .68)', '#e16f79']
            ];

            const backgroundColors = labels.map((label, index) => palette[index % palette.length][0]);
            const borderColors = labels.map((label, index) => palette[index % palette.length][1]);
            const canvas = document.getElementById('barChart');

            new Chart(canvas, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Nilai Asesmen',
                        data: scores,
                        backgroundColor: backgroundColors,
                        borderColor: borderColors,
                        borderWidth: 1.5,
                        borderRadius: 9,
                        maxBarThickness: 72
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'nearest',
                        intersect: true
                    },
                    onHover: function(event, elements) {
                        event.native.target.style.cursor = elements.length ? 'pointer' : 'default';
                    },
                    onClick: function(event, elements) {
                        if (elements.length) {
                            window.location.href = links[elements[0].index];
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                afterLabel: function(context) {
                                    return 'Klik untuk melihat detail';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#66757c',
                                maxRotation: 35,
                                minRotation: 0
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(23, 77, 114, .08)'
                            },
                            ticks: {
                                color: '#7b898f'
                            }
                        }
                    }
                }
            });
        </script>
    @endif
@endsection
