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
						<th class="active">N�</th>
						<th class="active">Categoria</th>
						<th class="active">Prior</th>
						<th class="active">StatusTRF</th>
						<th class="active">Tarefa</th>
						<!--<th class="active">Tarefa Concl.?</th>-->
						<th class="active">Inicia em:</th>
						<th class="active">Conc. em:</th>
						<th class="active">SubPri</th>
						<th class="active">SubSts</th>
						<th class="active">SubTarefa</th>
						<!--<th class="active">A��o Concl.?</th>-->
						<th class="active">Inicio em:</th>
						<th class="active">Fim em:</th>
						
					</tr>
					
				</thead>

				<tbody>

					<?php
					$cliente = array ();
					$valor = array();
					$i = 0;
					$cont_fazer = 0;
					$cont_fazendo = 0;
					$cont_feito = 0;
					$cont_nao_infor = 0;
					$cont_fazer2 = 0;
					$cont_fazendo2 = 0;
					$cont_feito2 = 0;
					$cont_nao_infor2 = 0;
					foreach ($report->result_array() as $row) {
						
						#echo '<tr>';
						echo '<tr class="clickable-row" data-href="' . base_url() . 'tarefa/alterar2/' . $row['idApp_Procedimento'] . '">';
							
							echo '<td>' . $row['idApp_Procedimento'] . '</td>';
							echo '<td>' . $row['Categoria'] . '</td>';
							echo '<td>' . $row['Prioridade'] . '</td>';
							echo '<td>' . $row['Statustarefa'] . '</td>';
							echo '<td>' . $row['Procedimento'] . '</td>';
							#echo '<td>' . $row['ConcluidoProcedimento'] . '</td>';
							echo '<td>' . $row['DataProcedimento'] . '</td>';
							echo '<td>' . $row['DataProcedimentoLimite'] . '</td>';
							echo '<td>' . $row['SubPrioridade'] . '</td>';
							echo '<td>' . $row['Statussubtarefa'] . '</td>';
							echo '<td>' . $row['SubProcedimento'] . '</td>';
							#echo '<td>' . $row['ConcluidoSubProcedimento'] . '</td>';
							echo '<td>' . $row['DataSubProcedimento'] . '</td>';
							echo '<td>' . $row['DataSubProcedimentoLimite'] . '</td>';
							
						echo '</tr>';
						
						$nomecliente = $row['Procedimento'];
						$valorcliente = $row['Prioridade'];
						$cliente[$i] = $nomecliente;
						$valor[$i] = $valorcliente;
						$i = $i + 1;
						
						if($row['Statussubtarefa'] == 'Fazer')
							$cont_fazer++;
						else if ($row['Statussubtarefa'] == 'Fazendo')
							$cont_fazendo++;
						else if ($row['Statussubtarefa'] == 'Feito')
							$cont_feito++;
						else 
							$cont_nao_infor++;
						
						if($row['Statustarefa'] == 'Fazer')
							$cont_fazer2++;
						else if ($row['Statustarefa'] == 'Fazendo')
							$cont_fazendo2++;
						else if ($row['Statustarefa'] == 'Feito')
							$cont_feito2++;
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

				["StsTrf", "Quantidade", { role: "style" } ],
				["Fazer", <?php echo $cont_fazer2; ?>, "#b87333"],
				["Fazendo", <?php echo $cont_fazendo2; ?>, "silver"],
				["Feito", <?php echo $cont_feito2; ?>, "silver"],
				["Nao Inform", <?php echo $cont_nao_infor2; ?>, "color: #e5e4e2"]
				]);

				var options = {
				  title: 'Porcentagem do Status das Tarefas'
				};

				var chart = new google.visualization.PieChart(document.getElementById('piechart3'));

				chart.draw(data, options);
			  }
			</script>						
			<script type="text/javascript">
			  google.charts.load('current', {'packages':['corechart']});
			  google.charts.setOnLoadCallback(drawChart);

			  function drawChart() {

				var data = google.visualization.arrayToDataTable([

				["StsSubTrf", "Quantidade", { role: "style" } ],
				["Fazer", <?php echo $cont_fazer; ?>, "#b87333"],
				["Fazendo", <?php echo $cont_fazendo; ?>, "silver"],
				["Feito", <?php echo $cont_feito; ?>, "silver"],
				["Nao Inform", <?php echo $cont_nao_infor; ?>, "color: #e5e4e2"]
				]);

				var options = {
				  title: 'Porcentagem do Status das Sub-Tarefas'
				};

				var chart = new google.visualization.PieChart(document.getElementById('piechart2'));

				chart.draw(data, options);
			  }
			</script>			
		</div>
	</div>
</div>