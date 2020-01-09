<div style="overflow: auto; height: 400px;">
	<div class="container-fluid">
		<div class="row">

			<table class="table table-bordered table-condensed table-striped">

				<thead>
					<tr>
						<th class="active text-center"><?php echo '<small>' . $_SESSION['FiltroBalanco']['Ano'] . '</small>' ?></th>
						<th class="active text-center">JAN</th>
						<th class="active text-center">FEV</th>
						<th class="active text-center">MAR</th>
						<th class="active text-center">ABR</th>
						<th class="active text-center">MAI</th>
						<th class="active text-center">JUN</th>
						<th class="active text-center">JUL</th>
						<th class="active text-center">AGO</th>
						<th class="active text-center">SET</th>
						<th class="active text-center">OUT</th>
						<th class="active text-center">NOV</th>
						<th class="active text-center">DEZ</th>
						<th class="active text-center">TOTAL</th>
					</tr>
				</thead>

				<tbody>				
					
						<?php
						$mes[1] = "JAN";
						$mes[2] = "FEV";
						$mes[3] = "MAR";
						$mes[4] = "ABR";
						$mes[5] = "MAI";
						$mes[6] = "JUN";
						$mes[7] = "JUL";
						$mes[8] = "AGO";
						$mes[9] = "SET";
						$mes[10] = "OUT";
						$mes[11] = "NOV";
						$mes[12] = "DEZ";
						$i = 1;
						?>
					<tr>
						<?php
						echo '<td><b>' . $report['RecPagar'][0]->Balancopagar . '</b></td>';
						for($i=1;$i<=12;$i++) {
							$bgcolor = ($report['RecPagar'][0]->{'M'.$i} <= 0) ? 'bg-info' : 'bg-info';
							echo '<td class="text-right ' . $bgcolor . '">' . $report['RecPagar'][0]->{'M'.$i} . '</td>';
						}
						$bgcolor = ($report['TotalGeralpagar']->RecPagar <= 0) ? 'bg-info' : 'bg-info';
						echo '<td class="text-right ' . $bgcolor . '">' . $report['TotalGeralpagar']->RecPagar . '</td>';
						?>
					</tr>
					<tr>
						<?php
						echo '<td><b>' . $report['DesPagar'][0]->Balancopagar . '</b></td>';
						for($i=1;$i<=12;$i++) {
							$bgcolor = ($report['DesPagar'][0]->{'M'.$i} <= 0) ? 'bg-danger' : 'bg-danger';
							echo '<td class="text-right ' . $bgcolor . '">' . $report['DesPagar'][0]->{'M'.$i} . '</td>';
						}
						$bgcolor = ($report['TotalGeralpagar']->DesPagar <= 0) ? 'bg-danger' : 'bg-danger';
						echo '<td class="text-right ' . $bgcolor . '">' . $report['TotalGeralpagar']->DesPagar . '</td>';
						?>
					</tr>
					
					<tr>
						<?php
						echo '<td><b>' . $report['RecPago'][0]->Balancopago . '</b></td>';
						for($i=1;$i<=12;$i++) {
							$bgcolor = ($report['RecPago'][0]->{'M'.$i} <= 0) ? 'bg-info' : 'bg-info';
							echo '<td class="text-right ' . $bgcolor . '">' . $report['RecPago'][0]->{'M'.$i} . '</td>';
						}
						$bgcolor = ($report['TotalGeralpago']->RecPago <= 0) ? 'bg-info' : 'bg-info';
						echo '<td class="text-right ' . $bgcolor . '">' . $report['TotalGeralpago']->RecPago . '</td>';
						?>
					</tr>
					<tr>
						<?php
						echo '<td><b>' . $report['DesPago'][0]->Balancopago . '</b></td>';
						for($i=1;$i<=12;$i++) {
							$bgcolor = ($report['DesPago'][0]->{'M'.$i} <= 0) ? 'bg-danger' : 'bg-danger';
							echo '<td class="text-right ' . $bgcolor . '">' . $report['DesPago'][0]->{'M'.$i} . '</td>';
						}
						$bgcolor = ($report['TotalGeralpago']->DesPago <= 0) ? 'bg-danger' : 'bg-danger';
						echo '<td class="text-right ' . $bgcolor . '">' . $report['TotalGeralpago']->DesPago . '</td>';
						?>
					</tr>

					<tr>
						<?php
						echo '<td><b>' . $report['TotalPago']->Balancopago . '</b></td>';
						for($i=1;$i<=12;$i++) {
							$bgcolor = ($report['TotalPago']->{'M'.$i} < 0) ? 'bg-danger' : 'bg-info';
							echo '<td class="text-right ' . $bgcolor . '">' . $report['TotalPago']->{'M'.$i} . '</td>';
						}
						$bgcolor = ($report['TotalGeralpago']->BalancoGeralpago < 0) ? 'bg-danger' : 'bg-info';
						echo '<td class="text-right ' . $bgcolor . '">' . $report['TotalGeralpago']->BalancoGeralpago . '</td>';
						?>
					</tr>

				</tbody>
				
			</table>
			<div id="columnchart_material" style="width: auto; "></div>
		</div>
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script type="text/javascript">
		  google.charts.load('current', {'packages':['bar']});
		  google.charts.setOnLoadCallback(drawChart);

		  function drawChart() {
			var data = google.visualization.arrayToDataTable([
			  ["Mes", "Receita", "Despesa", "Lucro"],
				<?php 
				$k = 12;
				for ($i = 1; $i <= $k; $i++){?>
						
				['<?php echo $mes[$i] ?>', (<?php echo $report['RecPago'][0]->{'M'.$i} ?>), (<?php echo $report['DesPago'][0]->{'M'.$i} ?>), (<?php echo $report['TotalPago']->{'M'.$i} ?>)],

				<?php } ?>
			]);

			var options = {
			  chart: {
				title: 'Performance da Empresa',
				subtitle: 'Receitas, Despesas, e Lucro: <?php echo '' . $_SESSION['FiltroBalanco']['Ano'] . '' ?>',
			  },
			  vAxis: {format: 'decimal'},
			  height: 400,
			};

			var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

			chart.draw(data, google.charts.Bar.convertOptions(options));
		  }
		</script>		
	</div>

</div>
