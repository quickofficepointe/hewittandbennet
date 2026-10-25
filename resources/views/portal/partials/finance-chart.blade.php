{{-- Grouped bar chart: income vs expenses vs payroll per month. Needs $canvas (element id) and $monthly (FinanceStats::monthly). --}}
<script>
    (function () {
        const data = @json($monthly);
        const el = document.getElementById(@json($canvas));
        if (!el || typeof Chart === 'undefined') return;
        new Chart(el, {
            type: 'bar',
            data: {
                labels: data.map(r => r.month),
                datasets: [
                    { label: 'Fee income', data: data.map(r => r.income), backgroundColor: '#1E3A8A', borderRadius: 4 },
                    { label: 'Expenses', data: data.map(r => r.expenses), backgroundColor: '#F59E0B', borderRadius: 4 },
                    { label: 'Salaries paid', data: data.map(r => r.payroll), backgroundColor: '#94A3B8', borderRadius: 4 },
                ],
            },
            options: {
                responsive: true,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { position: 'bottom', labels: { boxWidth: 12 } },
                    tooltip: { callbacks: { label: c => c.dataset.label + ': KES ' + Number(c.raw).toLocaleString() } },
                },
                scales: {
                    x: { grid: { display: false } },
                    y: { beginAtZero: true, ticks: { callback: v => 'KES ' + (v >= 1000 ? (v / 1000) + 'k' : v) } },
                },
            },
        });
    })();
</script>
