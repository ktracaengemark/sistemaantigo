<div style="overflow: auto; height: 550px; ">		
	<div class="panel panel-danger">
		<div class="panel-heading">
			<div class="row">
				
				<div class="col-md-4">
					<label for="DataFim"><?php echo $titulo2; ?> Total:</label>
					<div class="input-group">
						<span class="input-group-addon">R$</span>
						<input type="text" class="form-control" disabled aria-label="Total de Saídas" value="<?php echo $report->soma->somareceber ?>">
					</div>
				</div>
				<div class="col-md-4">
					<label for="DataFim">Pago:</label>
					<div class="input-group">
						<span class="input-group-addon">R$</span>
						<input type="text" class="form-control" disabled aria-label="Total Pago" value="<?php echo $report->soma->somarecebido ?>">
					</div>
				</div>
				<div class="col-md-4">
					<label for="DataFim">à Pagar</label>
					<div class="input-group">
						<span class="input-group-addon">R$</span>
						<input type="text" class="form-control" disabled aria-label="Total a Pagar" value="<?php echo $report->soma->balanco ?>">
					</div>
				</div>			
				
			</div>
		</div>		
	</div>

	<div class="container-fluid">
		<div class="row">
			<div>
				<table class="table table-bordered table-condensed table-striped">	
					<tfoot>
						<tr>
							<th colspan="3" class="active">Total de Parcelas: <?php echo $report->num_rows(); ?> resultado(s)</th>
						</tr>
					</tfoot>
				</table>            
				<table class="table table-bordered table-condensed table-striped">
					<thead>
						<tr>
							<!--<th class="active">Ed.Orç</th>
							<th class="active">Ed.Prc</th>-->
							<th class="active">Imp.</th>
							<th class="active">Orç.</th>
							<th class="col-md-3 active" scope="col">Despesa</th>	
							<th class="active">Pc</th>
							<th class="active">Dt Venc</th>
							<th class="active">Pagar</th>
							<th class="active">Qt</th>
							<!--<th class="active">Dt Pag.</th>
							<th class="active">Pago</th>
							<th class="active">Valor Recebido</th>
							<th class="active">Data do Orç.</th>
							<th class="active">Orç.</th>
							<th class="active">Prod. Entr.?</th>-->						
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($report->result_array() as $row) {
							echo '<tr>';
							#echo '<tr class="clickable-row" data-href="' . base_url() . 'Orcatrata/alterardesp/' . $row['idApp_OrcaTrata'] . '">';
							#echo '<tr class="clickable-row" data-href="' . base_url() . 'orcatrata/alterarparceladesp/' . $row['idSis_Empresa'] . '">';
								
								/*echo '<td class="notclickable">
										<a class="btn btn-md btn-danger notclickable" href="' . base_url() . 'Orcatrata/alterardesp/' . $row['idApp_OrcaTrata'] . '">
											<span class="glyphicon glyphicon-edit notclickable"></span>
										</a>
									</td>';
									
								echo '<td class="notclickable">
										<a class="btn btn-md btn-warning notclickable" href="' . base_url() . 'orcatrata/alterarparceladesp/' . $row['idSis_Empresa'] . '">
											<span class="glyphicon glyphicon-edit notclickable"></span>
										</a>
									</td>';	
								*/
								echo '<td class="notclickable">
										<a class="btn btn-md btn-info notclickable" href="' . base_url() . 'OrcatrataPrintDesp/imprimirdesp/' . $row['idApp_OrcaTrata'] . '">
											<span class="glyphicon glyphicon-print notclickable"></span>
										</a>
										
									</td>';								
								echo '<td>' . $row['idApp_OrcaTrata'] . '</td>';
								echo '<td>' . $row['TipoFinanceiro'] . '</td>';
								echo '<td>' . $row['Parcela'] . '</td>';
								echo '<td>' . $row['DataVencimento'] . '</td>';
								echo '<td class="text-left">' . $row['ValorParcela'] . '</td>';
								echo '<td>' . $row['Quitado'] . '</td>';
								#echo '<td>' . $row['DataPago'] . '</td>';
								#echo '<td class="text-left">' . $row['ValorPago'] . '</td>';
								#echo '<td class="text-left">R$ ' . $row['ValorPago'] . '</td>';
								#echo '<td>' . $row['DataOrca'] . '</td>';
								#echo '<td>' . $row['ConcluidoOrca'] . '</td>';						
							echo '</tr>';
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>