<div class="card shadow-lg">
  <div class="card-header card-header-gradient">
    <i class="bi bi-bar-chart-line me-2"></i> Reportes de Ventas
  </div>
  
  <div class="card-body">
    <div class="alert alert-info d-flex align-items-center mb-4">
      <i class="bi bi-info-circle me-2"></i>
      Visualiza las tendencias de ventas mensuales.
</div>

    <!-- Gráfica de Ventas -->
    <h5 class="fw-bold">Ventas por Mes</h5>
    <canvas id="ventasChart" class="mb-5"></canvas>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Ventas por mes
  const ventasCtx = document.getElementById('ventasChart');
  new Chart(ventasCtx, {
    type: 'bar',
    data: {
      labels: <?= json_encode($meses) ?>,
      datasets: [{
        label: 'Total Ventas',
        data: <?= json_encode($totales) ?>,
        backgroundColor: 'rgba(13, 110, 253, 0.7)'
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false }
      }
    }
  });
</script>
