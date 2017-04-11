<div class="col-md-6 col-sm-6 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Rencana Distribusi Tahun <?php echo date('Y') ?></h2>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <canvas id="ChartRencanaDistribusi"></canvas>
    </div>
  </div>
</div>
<div class="col-md-6 col-sm-6 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Realisasi Distribusi Tahun <?php echo date('Y') ?></h2>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <canvas id="ChartRealisasiDistribusi"></canvas>
    </div>
  </div>
</div>
<?php for ($i=0; $i < count($realisasi_majalah_id) ; $i++) { ?>
<div class="col-md-4 col-sm-4 col-xs-6">
  <div class="x_panel">
    <div class="x_title">
      <h2><?php echo $realisasi_majalah[$i].' Tahun '.date('Y') ?></h2>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <canvas id="<?php echo $realisasi_majalah_id[$i]?>"></canvas>
    </div>
  </div>
</div>
<?php } ?>


    <!-- Chart.js -->
    <script src="<?php echo base_url()?>assets/gentelella/vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- Chart.js -->
    <script>
      Chart.defaults.global.legend = {
        enabled: false
      };

      // Bar chart Untuk Rencana Distribusi
      var ctx = document.getElementById("ChartRencanaDistribusi");
      var ChartRencanaDistribusi = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: <?php echo isset($rencana_majalah) ? $rencana_majalah:'' ?>,
          datasets: [{
            label: '# Rencana ',
            backgroundColor: "#26B99A",
            data: <?php echo isset($rencana_total) ? $rencana_total : '' ?>
          }]
        },

        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          }
        }
      });

      // Bar chart Untuk Realisasi Distribusi
      var ctx = document.getElementById("ChartRealisasiDistribusi");
      var ChartRealisasiDistribusi = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: <?php echo isset($realisasi_majalah) ? json_encode($realisasi_majalah) : '' ?>,
          datasets: [{
            label: '# Realisasi ',
            backgroundColor: "#26B99A",
            data: <?php echo isset($realisasi_total) ? json_encode($realisasi_total) : '' ?>
          }]
        },

        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          }
        }
      });

      <?php for ($i=0; $i < count($realisasi_majalah_id) ; $i++) { ?>
        // Pie chart
        var ctx = document.getElementById(<?php echo $realisasi_majalah_id[$i] ?>);
        var data = {
          datasets: [{
            data: [<?php echo $realisasi_total[$i]?>, <?php echo $realisasi_return[$i]?>],
            backgroundColor: [
              "#26B99A",
              "#455C73"
            ],
            label: 'My dataset' // for legend
          }],
          labels: [
            "Realisasi Distribusi",
            "Retur"
          ]
        };

        var pieChart = new Chart(ctx, {
          data: data,
          type: 'pie',
          otpions: {
            legend: false
          }
        });
      <?php } ?>
    </script>
    <!-- /Chart.js -->