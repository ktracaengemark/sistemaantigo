<div style="overflow: auto; height: 100px; ">		
	<div class="panel panel-default">
		<div class="panel-body">

			<div class="col-md-1"></div>
			<!--
			<div class="col-md-3">
				<label for="DataFim"><?php echo $titulo2; ?> Total:</label>
				<div class="input-group">
					<span class="input-group-addon">R$</span>
					<input type="text" class="form-control" disabled aria-label="Total Entrada" value="<?php echo $report->soma->balanco ?>">
				</div>
			</div>		
			<div class="col-md-3">
				<label for="DataFim">� Pagar:</label>
				<div class="input-group">
					<span class="input-group-addon">R$</span>
					<input type="text" class="form-control" disabled aria-label="Total a receber" value="<?php echo $report->soma->somareceber ?>">
				</div>
			</div>
			-->
			<div class="col-md-10">
				<label for="DataFim">Pago dia: <?php echo '<small>' . $_SESSION['FiltroBalanco']['Diapag'] . '</small>' ?></label>
				<div class="input-group">
					<span class="input-group-addon">R$</span>
					<input type="text" class="form-control" disabled aria-label="Total Pago" value="<?php echo $report->soma->somarecebido ?>">
				</div>
			</div>
			
			<div class="col-md-1"></div>
		</div>		
	</div>
	<!--
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

							<th class="active">Despesa</th>	
							<th class="active">Pc/Qt</th>
							<th class="active">Dt Venc</th>
							<th class="active">� Pagar</th>
							<th class="active">Dt Pag.</th>
							<th class="active">Pago</th>
					
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($report->result_array() as $row) {
							#echo '<tr>';
							echo '<tr class="clickable-row" data-href="' . base_url() . 'orcatrata/alterarparceladesp/' . $row['idSis_Empresa'] . '">';

								echo '<td>' . $row['TipoDespesa'] . '</td>';
								echo '<td>' . $row['Parcela'] . '  ' . $row['Quitado'] . '</td>';
								echo '<td>' . $row['DataVencimento'] . '</td>';
								echo '<td class="text-left">' . $row['ValorParcela'] . '</td>';
								echo '<td>' . $row['DataPago'] . '</td>';
								echo '<td class="text-left">' . $row['ValorPago'] . '</td>';
					
							echo '</tr>';
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	-->
</div>