<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-4">	
				<div id="piechart" style="width: auto; height: 300px;"></div>
			</div>
			<div class="col-md-4">
				<div id="piechart3" style="width: auto; height: 300px;"></div>
			</div>			
			<div class="col-md-4">
				<div id="piechart2" style="width: auto; height: 300px;"></div>
			</div>
		</div>		
		<table class="table table-bordered table-condensed table-striped">	
			<tfoot>
				<tr>
					<th colspan="3" class="active">Total encontrado: <?php echo $report->num_rows(); ?> resultado(s)</th>
				</tr>
			</tfoot>
		</table>
		<div style="overflow: auto; width: auto; height: 550px;">
			<table class="table table-bordered table-condensed table-striped">

				<thead>
					
					<tr>                       											
						<th class="active">Nº</th>
						<th class="active">Categoria</th>
						<th class="active">Tarefa</th>																	                       
						<th class="active">Prioridade</th>
						<th class="active">Tarefa Concl.?</th>
						<th class="active">Inicia em:</th>
						<th class="active">Conc. em:</th>
						<th class="active">Ação</th>
						<th class="active">Ação Concl.?</th>
						<th class="active">Inicio em:</th>
						<th class="active">Fim em:</th>
					</tr>
					
				</thead>

				<tbody>

					<?php
					$cliente = array ();
					$valor = array();
					$i = 0;
					$cont_sim = 0;
					$cont_nao = 0;
					$cont_nao_infor = 0;
					$cont_sim2 = 0;
					$cont_nao2 = 0;
					$cont_nao_infor2 = 0;
					foreach ($report->result_array() as $row) {
						
						#echo '<tr>';
						echo '<tr class="clickable-row" data-href="' . base_url() . 'tarefa/alterar/' . $row['idApp_Procedimento'] . '">';
							
							echo '<td>' . $row['idApp_Procedimento'] . '</td>';
							echo '<td>' . $row['Categoria'] . '</td>';
							echo '<td>' . $row['Procedimento'] . '</td>';
							echo '<td>' . $row['Prioridade'] . '</td>';
							echo '<td>' . $row['ConcluidoProcedimento'] . '</td>';
							echo '<td>' . $row['DataProcedimento'] . '</td>';
							echo '<td>' . $row['DataProcedimentoLimite'] . '</td>';
							echo '<td>' . $row['SubProcedimento'] . '</td>';
							echo '<td>' . $row['ConcluidoSubProcedimento'] . '</td>';
							echo '<td>' . $row['DataSubProcedimento'] . '</td>';
							echo '<td>' . $row['DataSubProcedimentoLimite'] . '</td>';
						echo '</tr>';
						
						$nomecliente = $row['Procedimento'];
						$valorcliente = $row['Prioridade'];
						$cliente[$i] = $nomecliente;
						$valor[$i] = $valorcliente;
						$i = $i + 1;
						
						if($row['ConcluidoSubProcedimento'] == 'Sim')
							$cont_sim++;
						else if ($row['ConcluidoSubProcedimento'] == 'Não')
							$cont_nao++;
						else 
							$cont_nao_infor++;
						
						if($row['ConcluidoProcedimento'] == 'Sim')
							$cont_sim2++;
						else if ($row['ConcluidoProcedimento'] == 'Não')
							$cont_nao2++;
						else 
							$cont_nao_infor2++;
					}
					?>

				</tbody>

			</table>
			<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
			<script type="text/javascript">
			  google.charts.load('current', {'packages':['corechart']});
			  google.charts.setOnLoadCallback(drawChart);

			  function drawChart() {

				var data = google.visualization.arrayToDataTable([
				  ['Tarefas', ''],
					
					<?php 
					$k = $i;
					for ($i = 0; $i < $k; $i++){?>
							
					['<?php echo $cliente[$i] ?>', 1],

					<?php } ?>
				]);

				var options = {
				  title: 'Tarefa Dividida em - <?php echo $report->num_rows(); ?> partes'
				};

				var chart = new google.visualization.PieChart(document.getElementById('piechart'));

				chart.draw(data, options);
			  }
			</script>
			<script type="text/javascript">
			  google.charts.load('current', {'packages':['corechart']});
			  google.charts.setOnLoadCallback(drawChart);

			  function drawChart() {

				var data = google.visualization.arrayToDataTable([

				["Concluido", "Quantidade", { role: "style" } ],
				["Sim", <?php echo $cont_sim; ?>, "#b87333"],
				["Não", <?php echo $cont_nao; ?>, "silver"],
				["Nao Inform", <?php echo $cont_nao_infor; ?>, "color: #e5e4e2"]
				]);

				var options = {
				  title: 'Porcentagem das Sub-Tarefas Concluidas'
				};

				var chart = new google.visualization.PieChart(document.getElementById('piechart2'));

				chart.draw(data, options);
			  }
			</script>
			<script type="text/javascript">
			  google.charts.load('current', {'packages':['corechart']});
			  google.charts.setOnLoadCallback(drawChart);

			  function drawChart() {

				var data = google.visualization.arrayToDataTable([

				["Concluido", "Quantidade", { role: "style" } ],
				["Sim", <?php echo $cont_sim2; ?>, "#b87333"],
				["Não", <?php echo $cont_nao2; ?>, "silver"],
				["Nao Inform", <?php echo $cont_nao_infor2; ?>, "color: #e5e4e2"]
				]);

				var options = {
				  title: 'Porcentagem das Tarefas Concluidas'
				};

				var chart = new google.visualization.PieChart(document.getElementById('piechart3'));

				chart.draw(data, options);
			  }
			</script>			
			
		</div>
	</div>
</div>
