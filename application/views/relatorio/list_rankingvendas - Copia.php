<div style="overflow: auto; height: 550px; ">	
	<div class="container-fluid">
		<div class="row">

			<div>
				<table class="table table-bordered table-condensed table-striped">
					
					<thead>
						<tr>
							<th class="active text-center">CLIENTE</th>
							<th class="active text-center">PAGO</th>
						</tr>
					</thead>
					<thead>
						<tr>						
							<th colspan="1" class="active">Total :</th>
							<th colspan="1" class="active"><?php echo $report->soma->somaqtdparc ?></th>												
						</tr>
					</thead>
					<tbody>

						<?php

						foreach ($report as $row) {
						#for($i=0;$i<count($report);$i++) {

							if(isset($row->NomeCliente)) {
							echo '<tr>';
							#echo '<tr class="clickable-row" data-href="' . base_url() . 'cliente/prontuario/' . $row->idApp_Cliente . '">';
							#echo '<tr class="clickable-row" data-href="' . base_url() . 'cliente/prontuario/' . $row->NomeCliente . '">';
								#echo '<td>' . $row->idApp_Cliente . '</td>';
								echo '<td>' . $row->NomeCliente . '</td>';
								echo '<td>' . $row->QtdParc . '</td>';							

							echo '</tr>';
							}
						}
						?>

					</tbody>
					<tfoot>
						<tr>						
							<th colspan="1" class="active">Total:</th>
							<th colspan="1" class="active"><?php echo $report->soma->somaqtdparc ?></th>						
						</tr>
					</tfoot>

				</table>

			</div>

		</div>

	</div>
</div>