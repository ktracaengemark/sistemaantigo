<div style="overflow: auto; height: 183px; ">
	<div class="container-fluid">
		<div class="row">

			
				<table class="table table-bordered table-condensed table-striped">	
					<tfoot>
						<tr>
							<th colspan="9" class="active">Total: <?php echo $report->num_rows(); ?> resultado(s)</th>
						</tr>
					</tfoot>
				</table>	
				<table class="table table-bordered table-condensed table-striped">								
					<thead>
						<tr>
							<th class="active">Concl.</th>
							<th class="active">Prior.</th>
							<th class="active">Tarefa</th>
							<!--<th class="active">Data</th>-->
						</tr>
					</thead>

					<tbody>

						<?php
						foreach ($report->result_array() as $row) {

							#echo '<tr>';
							#echo '<tr class="clickable-row" data-href="' . base_url() . 'procedimento/alterar/' . $row['idApp_Procedimento'] . '">';
							echo '<tr class="clickable-row" data-href="' . base_url() . 'orcatrata/alterarprocedimento/' . $row['idSis_Empresa'] . '">';
								echo '<td>' . $row['ConcluidoProcedimento'] . '</td>';
								echo '<td>' . $row['Prioridade'] . '</td>';
								echo '<td>' . $row['Procedimento'] . '</td>';
								#echo '<td>' . $row['DataProcedimento'] . '</td>';							
							echo '</tr>';
						}
						?>

					</tbody>

				</table>

			

		</div>

	</div>
</div>