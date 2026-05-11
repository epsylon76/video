<script src="/includes/js/chartjs/dist/chart.umd.js" type="text/javascript"></script>

<div class="container-fluid p-0">
    <div class="d-flex flex-column flex-xl-row justify-content-between align-items-xl-center mb-4 gap-3">
        <h2 class="h5 mb-0 text-muted text-uppercase fw-bold">
            <i class="fas fa-chart-area me-2 text-primary"></i>Flux de données
        </h2>

        <div class="d-flex flex-column flex-md-row gap-2 align-items-md-center">
            <div class="btn-group btn-group-sm shadow-sm" role="group" aria-label="Période">
                <button type="button" class="btn btn-outline-secondary btn_period" data-period="6h">6H</button>
                <button type="button" class="btn btn-outline-secondary btn_period" data-period="12h">12H</button>
                <button type="button" class="btn btn-primary btn_period" data-period="24h">24H</button>
                <button type="button" class="btn btn-outline-secondary btn_period" data-period="7d">7J</button>
                <button type="button" class="btn btn-outline-secondary btn_period" data-period="30d">30J</button>
                <button type="button" class="btn btn-outline-secondary btn_period" data-period="12w">12 sem.</button>
                <button type="button" class="btn btn-outline-secondary btn_period" data-period="all">Tout</button>
            </div>

            <div class="btn-group btn-group-sm shadow-sm" role="group" aria-label="Mesure">
                <button type="button" class="btn btn-primary btn_mode" data-mode="mbps">Mbps</button>
                <button type="button" class="btn btn-outline-secondary btn_mode" data-mode="volume">Go</button>
                <button type="button" class="btn btn-outline-secondary btn_mode" data-mode="actions">Actions</button>
                <button type="button" class="btn btn-outline-secondary btn_mode" data-mode="average">Moy.</button>
            </div>
        </div>
    </div>

    <div id="chart-summary" class="row g-3 mb-4"></div>

    <div class="d-flex flex-wrap gap-2 mb-3" id="chart-type-filters"></div>

    <div class="row g-4">
        <div class="col-xl-8">
            <div class="position-relative border rounded-3 bg-white p-3" style="height:48vh; min-height:360px;">
                <div id="chart-loader" class="position-absolute top-0 start-0 w-100 h-100 justify-content-center align-items-center bg-white bg-opacity-75" style="z-index: 10; display: none;">
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status"></div>
                        <div class="mt-2 small fw-bold text-primary text-uppercase">Chargement...</div>
                    </div>
                </div>

                <canvas id="chart" style="display:block; width:100%; height:100%;"></canvas>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="border rounded-3 bg-white p-3 h-100">
                <h3 class="h6 text-muted text-uppercase fw-bold mb-3">Top journées</h3>
                <div id="chart-top-days" class="d-flex flex-column gap-2"></div>
            </div>
        </div>
    </div>

    <div class="border rounded-3 bg-white p-3 mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="h6 text-muted text-uppercase fw-bold mb-0">Répartition horaire</h3>
            <span class="small text-muted" id="chart-hourly-unit"></span>
        </div>
        <div id="chart-hourly" class="d-grid gap-2" style="grid-template-columns: repeat(24, minmax(22px, 1fr));"></div>
    </div>
</div>

<script>
$(document).ready(function() {
    let maChart;
    let chartRequest = null;
    let selectedPeriod = '24h';
    let selectedMode = 'mbps';
    let selectedTypes = [];
    let knownTypes = [];

    const $loader = $('#chart-loader');
    const $summary = $('#chart-summary');
    const $filters = $('#chart-type-filters');
    const $topDays = $('#chart-top-days');
    const $hourly = $('#chart-hourly');
    const $hourlyUnit = $('#chart-hourly-unit');

    function showLoader() {
        $loader.css('display', 'flex');
    }

    function hideLoader() {
        $loader.css('display', 'none');
    }

    function escapeHtml(value) {
        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function formatNumber(value, decimals = 1) {
        return Number(value || 0).toLocaleString('fr-FR', {
            minimumFractionDigits: 0,
            maximumFractionDigits: decimals
        });
    }

    function formatMetric(value, unit) {
        if (unit === 'Actions') {
            return formatNumber(value, 0);
        }
        return formatNumber(value, value >= 100 ? 0 : 2) + ' ' + unit;
    }

    function setButtonState(selector, dataName, value) {
        $(selector).each(function() {
            const $btn = $(this);
            const active = $btn.data(dataName) === value;
            $btn.toggleClass('btn-primary', active);
            $btn.toggleClass('btn-outline-secondary', !active);
        });
    }

    function renderSummary(response) {
        const topType = response.summary.top_type ? response.summary.top_type.label : 'Aucun';
        const cards = [
            { label: 'Volume total', value: response.summary.volume_human, icon: 'fa-database', tone: 'primary' },
            { label: 'Actions', value: formatNumber(response.summary.actions, 0), icon: 'fa-bolt', tone: 'success' },
            { label: 'Moyenne/action', value: response.summary.average_human, icon: 'fa-gauge-high', tone: 'warning' },
            { label: 'Pic ' + response.meta.unit, value: formatMetric(response.summary.peak_value, response.meta.unit), icon: 'fa-arrow-trend-up', tone: 'danger' },
            { label: 'Type dominant', value: topType, icon: 'fa-layer-group', tone: 'secondary' }
        ];

        $summary.html(cards.map(card => `
            <div class="col-6 col-lg">
                <div class="border rounded-3 bg-white p-3 h-100">
                    <div class="d-flex align-items-center gap-2 text-${card.tone} mb-2">
                        <i class="fas ${card.icon}"></i>
                        <span class="small text-muted text-uppercase fw-bold">${card.label}</span>
                    </div>
                    <div class="h5 mb-0 text-truncate" title="${escapeHtml(card.value)}">${escapeHtml(card.value)}</div>
                </div>
            </div>
        `).join(''));
    }

    function renderFilters(types) {
        knownTypes = types;
        if (selectedTypes.length === 0) {
            selectedTypes = types.filter(type => type.selected).map(type => type.key);
        }

        $filters.html(types.map(type => {
            const checked = selectedTypes.includes(type.key) ? 'checked' : '';
            return `
                <label class="btn btn-sm border rounded-pill bg-white d-flex align-items-center gap-2 px-3">
                    <input class="form-check-input m-0 chart-type-toggle" type="checkbox" value="${escapeHtml(type.key)}" ${checked}>
                    <span style="width:10px;height:10px;border-radius:50%;background:${type.color};display:inline-block;"></span>
                    <span>${escapeHtml(type.label)}</span>
                    <span class="text-muted small">${escapeHtml(type.volume_human)}</span>
                </label>
            `;
        }).join(''));
    }

    function renderTopDays(days) {
        if (!days.length) {
            $topDays.html('<div class="text-muted small">Aucune donnée sur cette période.</div>');
            return;
        }

        const maxVolume = Math.max(...days.map(day => day.volume), 1);
        $topDays.html(days.map(day => {
            const width = Math.max(3, (day.volume / maxVolume) * 100);
            return `
                <div>
                    <div class="d-flex justify-content-between small mb-1">
                        <strong>${escapeHtml(day.jour)}</strong>
                        <span class="text-muted">${escapeHtml(day.volume_human)} / ${formatNumber(day.actions, 0)} actions</span>
                    </div>
                    <div class="progress" style="height:8px;">
                        <div class="progress-bar bg-primary" style="width:${width}%;"></div>
                    </div>
                </div>
            `;
        }).join(''));
    }

    function renderHourly(hours, unit) {
        const maxValue = Math.max(...hours.map(hour => hour.value), 1);
        $hourlyUnit.text(unit);
        $hourly.html(hours.map(hour => {
            const opacity = Math.max(0.08, hour.value / maxValue);
            const title = `${hour.label} - ${formatMetric(hour.value, unit)} - ${hour.volume_human} - ${formatNumber(hour.actions, 0)} actions`;
            return `
                <div class="text-center" title="${escapeHtml(title)}">
                    <div class="rounded-2 border" style="height:42px;background:rgba(37,99,235,${opacity});"></div>
                    <div class="small text-muted mt-1">${escapeHtml(hour.label.replace('h', ''))}</div>
                </div>
            `;
        }).join(''));
    }

    function buildDatasets(response) {
        const datasets = response.types
            .filter(type => selectedTypes.includes(type.key))
            .map(type => ({
                type: 'bar',
                label: type.label,
                data: response.series.map(row => row[type.key] || 0),
                backgroundColor: type.color,
                borderColor: type.color,
                borderRadius: 4,
                stack: 'traffic',
                order: 2
            }));

        datasets.push({
            type: 'line',
            label: 'Total',
            data: response.series.map(row => row.total || 0),
            borderColor: '#111827',
            backgroundColor: '#111827',
            borderWidth: 2,
            pointRadius: 0,
            pointHitRadius: 8,
            tension: 0.25,
            order: 1
        });

        return datasets;
    }

    function renderChart(response) {
        const ctx = document.getElementById('chart').getContext('2d');
        const labels = response.series.map(row => row.periode);
        const datasets = buildDatasets(response);

        if (maChart) {
            maChart.data.labels = labels;
            maChart.data.datasets = datasets;
            maChart.options.scales.y.title.text = response.meta.unit;
            maChart.update('none');
            return;
        }

        maChart = new Chart(ctx, {
            data: { labels, datasets },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { position: 'bottom', labels: { usePointStyle: true, padding: 16 } },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.dataset.label}: ${formatMetric(context.raw, context.chart.options.scales.y.title.text)}`;
                            }
                        }
                    }
                },
                scales: {
                    x: { stacked: true, grid: { display: false }, ticks: { maxRotation: 0, autoSkip: true, maxTicksLimit: 12 } },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        grid: { borderDash: [5, 5] },
                        title: { display: true, text: response.meta.unit }
                    }
                }
            }
        });
    }

    function renderAll(response) {
        renderSummary(response);
        renderFilters(response.types);
        renderChart(response);
        renderTopDays(response.top_days);
        renderHourly(response.hourly, response.meta.unit);
    }

    function loadChartData() {
        if (chartRequest) {
            chartRequest.abort();
        }

        const request = $.ajax({
            url: '/ajax/ajax_chart.php',
            type: 'POST',
            data: {
                period: selectedPeriod,
                mode: selectedMode,
                types: selectedTypes
            },
            dataType: 'json',
            beforeSend: showLoader,
            success: function(response) {
                try {
                    renderAll(response);
                } catch (error) {
                    console.error('Erreur de rendu du graphique', error);
                }
            },
            error: function(xhr, status) {
                if (status !== 'abort') {
                    console.error('Erreur de chargement du graphique', xhr.responseText);
                }
            }
        });

        chartRequest = request;
        request.always(function() {
            if (chartRequest === request) {
                chartRequest = null;
                setTimeout(hideLoader, 200);
            }
        });
    }

    $('.btn_period').on('click', function() {
        selectedPeriod = $(this).data('period');
        setButtonState('.btn_period', 'period', selectedPeriod);
        loadChartData();
    });

    $('.btn_mode').on('click', function() {
        selectedMode = $(this).data('mode');
        setButtonState('.btn_mode', 'mode', selectedMode);
        loadChartData();
    });

    $filters.on('change', '.chart-type-toggle', function() {
        selectedTypes = $('.chart-type-toggle:checked').map(function() {
            return $(this).val();
        }).get();
        if (selectedTypes.length === 0) {
            selectedTypes = knownTypes.map(type => type.key);
        }
        loadChartData();
    });

    loadChartData();
});
</script>
