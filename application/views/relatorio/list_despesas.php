<div style="overflow: auto; height: 350px; ">		
	<div class="panel panel-default">
		<div class="panel-body">

			<div class="col-md-1"></div>
			<div class="col-md-3">
				<label for="DataFim">Total:</label>
				<div class="input-group">
					<span class="input-group-addon">R$</span>
					<input type="text" class="form-control" disabled aria-label="Total Entrada" value="<?php echo $report->soma->balanco ?>">
				</div>
			</div>		
			<div class="col-md-3">
				<label for="DataFim">Recebido:</label>
				<div class="input-group">
					<span class="input-group-addon">R$</span>
					<input type="text" class="form-control" disabled aria-label="Total Pago" value="<?php echo $report->soma->somarecebido ?>">
				</div>
			</div>
			<div class="col-md-3">
				<label for="DataFim">� Receber:</label>
				<div class="input-group">
					<span class="input-group-addon">R$</span>
					<input type="text" class="form-control" disabled aria-label="Total a receber" value="<?php echo $report->soma->somareceber ?>">
				</div>
			</div>
			<div class="col-md-1"></div>
		</div>		
	</div>

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
							<th class="active">Empresa</th>
							<th class="active">Despesa</th>	
							<th class="active">Parc</th>
							<th class="active">Venc</th>
							<!--<th class="active">Valor � Receber</th>-->
							
							<th class="active">Pago</th>
							<!--<th class="active">Valor Recebido</th>
							<th class="active">Data do Or�.</th>
							<th class="active">Or�.</th>
							<th class="active">Prod. Entr.?</th>-->						
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($report->result_array() as $row) {
							#echo '<tr>';
							echo '<tr class="clickable-row" data-href="' . base_url() . 'orcatrata/alterardesp/' . $row['idApp_OrcaTrata'] . '">';
								echo '<td>' . $row['idApp_OrcaTrata'] . '</td>';
								echo '<td>' . $row['TipoDespesa'] . '</td>';
								echo '<td>' . $row['ParcelaRecebiveis'] . '</td>';
								echo '<td>' . $row['DataVencimentoRecebiveis'] . ' R$' . $row['ValorParcelaRecebiveis'] . '</td>';
								#echo '<td class="text-left">R$ ' . $row['ValorParcelaRecebiveis'] . '</td>';
								
								echo '<td>' . $row['DataPagoRecebiveis'] . ' R$' . $row['ValorPagoRecebiveis'] . '</td>';
								#echo '<td class="text-left">R$ ' . $row['ValorPagoRecebiveis'] . '</td>';
								#echo '<td>' . $row['DataOrca'] . '</td>';
								#echo '<td>' . $row['idApp_OrcaTrata'] . '</td>';
								#echo '<td>' . $row['ServicoConcluido'] . '</td>';						
							echo '</tr>';
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>