<div style="overflow: auto; height: auto; ">
	<div class="container-fluid">
		<div class="row">
			<div>
				<table class="table table-hover">
					<thead>
						<tr>
							<th colspan="5" class="active">Total encontrado: <?php echo $report_pagamento->num_rows(); ?> resultado(s)</th>
						</tr>
					</thead>
					<thead>
						<tr>
							<th class="active">Pedido</th>
							<th class="active">Cliente</th>
							<th class="active">Parcela</th>
							<th class="active">Venc.</th>
							<th class="active">Pago?</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($report_pagamento->result_array() as $row) {
							#echo '<tr>';
							echo '<tr class="clickable-row bg-warning" data-href="' . base_url() . 'statuspedido/alterarstatus/' . $row['idApp_OrcaTrata'] . '">';
								echo '<td>' . $row['idApp_OrcaTrata'] . '</td>';	
								echo '<td>' . $row['NomeCliente'] . '</td>';
								echo '<td>' . $row['Parcela'] . '</td>';
								echo '<td>' . $row['DataVencimento'] . '</td>';
								echo '<td>' . $row['Quitado'] . '</td>';
							echo '</tr>';
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>