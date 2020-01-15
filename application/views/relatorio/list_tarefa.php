<div style="overflow: auto; height: 550px; ">	
	<div class="container-fluid">
		<div class="row">

			<div>
				<table class="table table-bordered table-condensed table-striped">	
					<tfoot>
						<tr>
							<th colspan="3" class="active">Total encontrado: <?php echo $report->num_rows(); ?> resultado(s)</th>
						</tr>
					</tfoot>
				</table>
				<table class="table table-bordered table-condensed table-striped">

					<thead>
						<tr>                       											
							<!--<th class="active">Respons�vel da Tarefa</th>-->
							<th class="active">N�</th>
							<th class="active">Tarefa</th>																	                       
							<th class="active">Data da Cria��o:</th>
							<th class="active">Prazo da Conclus�o</th>
							<th class="active">Tarefa Conclu�da?</th>
							<th class="active">Prioridade?</th>
							<th class="active">A��o</th>
							<th class="active">A��o Conclu�da?</th>
							<!--<th class="active">Data da Conclus�o da Tarefa</th>
							<th class="active">Rotina?:</th>
							<th class="active">Respons�vel da A��o</th>						
							<th class="active">Data da A��o</th>-->																	
							
																			
							
						</tr>
					</thead>

					<tbody>

						<?php
						$cont_sim = 0;
						$cont_nao = 0;
						$cont_nao_infor = 0;
						foreach ($report->result_array() as $row) {

							#echo '<tr>';
							echo '<tr class="clickable-row" data-href="' . base_url() . 'tarefa/alterar/' . $row['idApp_Procedimento'] . '">';
							   
								#echo '<td>' . $row['NomeProfissional'] . '</td>';
								echo '<td>' . $row['idApp_Procedimento'] . '</td>';
								echo '<td>' . $row['Procedimento'] . '</td>'; //  = Tarefa
								echo '<td>' . $row['DataProcedimento'] . '</td>';
								echo '<td>' . $row['DataProcedimentoLimite'] . '</td>';
								echo '<td>' . $row['ConcluidoProcedimento'] . '</td>'; // = Tarefa Conclu�da?
								echo '<td>' . $row['Prioridade'] . '</td>'; // = Prioridade
								echo '<td>' . $row['SubProcedimento'] . '</td>';
								echo '<td>' . $row['ConcluidoSubProcedimento'] . '</td>';
								#echo '<td>' . $row['DataConclusao'] . '</td>';
								#echo '<td>' . $row['Rotina'] . '</td>'; // = Rotina
								#echo '<td>' . $row['Profissional'] . '</td>';							
								#echo '<td>' . $row['DataSubProcedimento'] . '</td>';
							echo '</tr>';
							
							if($row['ConcluidoSubProcedimento'] == 'Sim')
								$cont_sim++;
							else if ($row['ConcluidoSubProcedimento'] == 'N�o')
								$cont_nao++;
							else 
								$cont_nao_infor++;
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

					["Concluido", "Quantidade", { role: "style" } ],
					["Sim", <?php echo $cont_sim; ?>, "#b87333"],
					["N�o", <?php echo $cont_nao; ?>, "silver"],
					["Nao Inform", <?php echo $cont_nao_infor; ?>, "color: #e5e4e2"]
					]);

					var options = {
					  title: 'Teste de Concluido'
					};

					var chart = new google.visualization.PieChart(document.getElementById('piechart'));

					chart.draw(data, options);
				  }
				</script>
				<div id="piechart" style="width: 900px; height: 500px;"></div>
			</div>
		</div>
	</div>
</div>
