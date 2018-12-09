<div style="overflow: auto; height: 155px; ">
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
							<!--<th class="active">Empresa</th>-->
							<th class="active">Concl.</th>
							<th class="active">Cliente</th>
							<th class="active">Procedimento</th>
							<th class="active">Data</th>
						</tr>
					</thead>

					<tbody>

						<?php
						foreach ($report->result_array() as $row) {

							#echo '<tr>';
							#echo '<tr class="clickable-row" data-href="' . base_url() . 'procedimento/alterar/' . $row['idApp_Procedimento'] . '">';
							echo '<tr class="clickable-row" data-href="' . base_url() . 'orcatrata/alterarprocedimentocli/' . $row['idSis_Empresa'] . '">';
								#echo '<td>' . $row['idSis_Empresa'] . '</td>';
								echo '<td>' . $row['ConcluidoProcedimento'] . '</td>';
								echo '<td>' . $row['NomeCliente'] . '</td>';
								echo '<td>' . $row['Procedimento'] . '</td>';
								echo '<td>' . $row['DataProcedimento'] . '</td>';							
							echo '</tr>';
						}
						?>

					</tbody>

				</table>

			

		</div>

	</div>
</div>