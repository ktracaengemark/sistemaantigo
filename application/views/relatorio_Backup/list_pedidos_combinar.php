<div style="overflow: auto; height: 550px; ">
	<div class="container-fluid">
		<div class="row">
			<div>
				<table class="table table-bordered table-condensed table-striped">
					<tfoot>
						<tr>
							<th colspan="3" class="active">Total encontrado: <?php echo $report_combinar->num_rows(); ?> resultado(s)</th>
						</tr>
					</tfoot>
				</table>
				<table class="table table-bordered table-condensed table-striped">
					<thead>
						<tr>
							<th class="active">Pedido</th>
							<th class="active">Cliente</th>
							<th class="active">Entrega</th>
							<th class="active">Dt.Ent.</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($report_combinar->result_array() as $row) {
							#echo '<tr>';
							echo '<tr class="clickable-row" data-href="' . base_url() . 'statuspedido/alterarstatus/' . $row['idApp_OrcaTrata'] . '">';

								#echo '<div class="clickable-row" data-href="' . base_url() . 'orcatrata/alterar2/' . $row['idApp_OrcaTrata'] . '">';
								
								echo '<td>' . $row['idApp_OrcaTrata'] . '</td>';	
								echo '<td>' . $row['NomeCliente'] . '</td>';
								echo '<td>' . $row['TipoFrete'] . '</td>';
								echo '<td>' . $row['DataEntregaOrca'] . '</td>';
							echo '</tr>';
						}
						?>
					</tbody>

				</table>
			</div>
		</div>
	</div>
</div>