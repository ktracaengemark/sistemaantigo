<div style="overflow: auto; height: 550px; ">		
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="row">	
				
				<div class="col-md-4">
					<label for="DataFim"><?php echo $titulo1; ?> Total:</label>
					<div class="input-group">
						<span class="input-group-addon">R$</span>
						<input type="text" class="form-control" disabled aria-label="Total de Entradas" value="<?php echo $report->soma->somareceber ?>">
					</div>
				</div>
				<div class="col-md-4">
					<label for="DataFim">Recebido:</label>
					<div class="input-group">
						<span class="input-group-addon">R$</span>
						<input type="text" class="form-control" disabled aria-label="Total Recebido" value="<?php echo $report->soma->somarecebido ?>">
					</div>
				</div>
				<div class="col-md-4">
					<label for="DataFim">à Receber:</label>
					<div class="input-group">
						<span class="input-group-addon">R$</span>
						<input type="text" class="form-control" disabled aria-label="Total a Receber" value="<?php echo $report->soma->balanco ?>">
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
							<th class="col-md-3 active" scope="col">Receita</th>	
							<th class="active">Pc</th>
							<th class="active">Dt.Venc</th>
							<th class="active">Receber</th>
							<th class="active">Qt</th>
							<!--<th class="active">Dt.Pag</th>
							<th class="active">Recebido</th>
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
							#echo '<tr class="clickable-row" data-href="' . base_url() . 'Orcatrata/alterar2/' . $row['idApp_OrcaTrata'] . '">';
							#echo '<tr class="clickable-row" data-href="' . base_url() . 'orcatrata/alterarparcelarec/' . $row['idSis_Empresa'] . '">';
								
								/*echo '<td class="notclickable">
										<a class="btn btn-md btn-success notclickable" href="' . base_url() . 'Orcatrata/alterar2/' . $row['idApp_OrcaTrata'] . '">
											<span class="glyphicon glyphicon-edit notclickable"></span>
										</a>
									</td>';								
								
								echo '<td class="notclickable">
										<a class="btn btn-md btn-warning notclickable" href="' . base_url() . 'orcatrata/alterarparcelarec/' . $row['idSis_Empresa'] . '">
											<span class="glyphicon glyphicon-edit notclickable"></span>
										</a>
									</td>';
								*/
								echo '<td class="notclickable">
										<a class="btn btn-md btn-info notclickable" href="' . base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_OrcaTrata'] . '">
											<span class="glyphicon glyphicon-print notclickable"></span>
										</a>
										
									</td>';									
								echo '<td>' . $row['idApp_OrcaTrata'] . '</td>';
								echo '<td>' . $row['Descricao'] . '</td>';
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