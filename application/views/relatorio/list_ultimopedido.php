<div class="container-fluid">
	<div class="row">
		<div>
			<table class="table table-bordered table-condensed table-striped">
				<thead>
					<tr>
						<th colspan="4" class="active"> <?php echo $report->num_rows(); ?> resultado(s)</th>
					</tr>
				</thead>
				<thead>						
					<tr>
						<th class="active">Cont.</th>
						<th class="active">id_Cliente</th>
						<th class="active">id_Pedido</th>
						<th class="active">Dt_Pedido</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$count = 1;
					foreach ($report->result_array() as $row) {
						echo '<tr>';
							echo '<td>' . $count . '</td>';
							echo '<td>' . $row['idApp_Cliente'] . '</td>';
							echo '<td>' . $row['idApp_OrcaTrata'] . '</td>';
							echo '<td>' . $row['DataOrca'] . '</td>';
						echo '</tr>';
						$count++;
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
