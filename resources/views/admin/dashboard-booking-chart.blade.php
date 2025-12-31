<div class="card" style="margin:36px 0 48px 0;padding:32px 32px 24px 32px;box-shadow:0 8px 32px rgba(99,102,241,0.08);border-radius:18px;background:#fff;max-width:1200px;width:100%;margin-left:auto;margin-right:auto;">
    <div style="display:flex;align-items:center;gap:18px;margin-bottom:18px;flex-wrap:wrap;">
        <label for="chartYear" style="font-weight:500;">Tahun:</label>
        <select id="chartYear" style="padding:6px 12px;border-radius:6px;border:1px solid #ccc;">
            @for($y=date('Y')-3;$y<=date('Y');$y++)
                <option value="{{ $y }}" @if($y==date('Y'))selected @endif>{{ $y }}</option>
            @endfor
        </select>
    </div>
    <div style="position: relative; height: 400px; width: 100%;">
        <canvas id="bookingChart"></canvas>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script>
    let bookingChart;
    function loadChart(year) {
        fetch(`{{ route('admin.dashboard.bookingdata') }}?year=${year}`)
            .then(res => res.json())
            .then(data => {
                const ctx = document.getElementById('bookingChart').getContext('2d');
                if(bookingChart) bookingChart.destroy();
                // Cari nilai maksimum
                const maxVal = Math.max(
                    ...data.tiket,
                    ...data.artclass,
                    ...data.educlass
                );
                bookingChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [
                            {
                                label: 'Tiket Wisata',
                                data: data.tiket,
                                borderColor: '#6366f1',
                                backgroundColor: 'rgba(99,102,241,0.10)',
                                fill: true,
                                tension: 0.4,
                                pointRadius: 4,
                                pointBackgroundColor: '#6366f1',
                                datalabels: {
                                    color: '#6366f1',
                                    anchor: 'end',
                                    align: 'top',
                                    font: { weight: 'bold', size: 13 },
                                }
                            },
                            {
                                label: 'Art Class',
                                data: data.artclass,
                                borderColor: '#10b981',
                                backgroundColor: 'rgba(16,185,129,0.10)',
                                fill: true,
                                tension: 0.4,
                                pointRadius: 4,
                                pointBackgroundColor: '#10b981',
                                datalabels: {
                                    color: '#10b981',
                                    anchor: 'end',
                                    align: 'top',
                                    font: { weight: 'bold', size: 13 },
                                }
                            },
                            {
                                label: 'Edu Class',
                                data: data.educlass,
                                borderColor: '#f59e42',
                                backgroundColor: 'rgba(245,158,66,0.10)',
                                fill: true,
                                tension: 0.4,
                                pointRadius: 4,
                                pointBackgroundColor: '#f59e42',
                                datalabels: {
                                    color: '#f59e42',
                                    anchor: 'end',
                                    align: 'top',
                                    font: { weight: 'bold', size: 13 },
                                }
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'top', labels: { font: { size: 16 } } },
                            title: { display: true, text: 'Tren Booking & Tiket', font: { size: 20 } },
                            datalabels: {
                                display: true,
                                formatter: function(value) {
                                    return value > 0 ? value : '';
                                }
                            }
                        },
                        layout: { padding: { left: 12, right: 12, top: 12, bottom: 12 } },
                        scales: {
                            x: { title: { display: true, text: 'Bulan', font: { size: 15 } }, grid: { color: '#e5e7eb' }, ticks: { font: { size: 13 } } },
                            y: {
                                title: { display: true, text: 'Jumlah Booking/Tiket', font: { size: 15 } },
                                beginAtZero: true,
                                grid: { color: '#e5e7eb' },
                                ticks: { font: { size: 13 } },
                                suggestedMax: maxVal < 10 ? 10 : undefined
                            }
                        }
                    },
                    plugins: [ChartDataLabels]
                });
            });
    }
    document.getElementById('chartYear').addEventListener('change', function() {
        loadChart(this.value);
    });
    // Initial load
    loadChart(document.getElementById('chartYear').value);
</script>
