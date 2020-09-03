<div style="overflow: auto; height: 550px; ">	
	<div class="panel panel-default">
		<div class="panel-body">

			<div class="col-md-1"></div>
			<div class="col-md-3">
				<label for="DataFim">Or�amento:</label>
				<div class="input-group">
					<span class="input-group-addon">R$</span>
					<input type="text" class="form-control" disabled aria-label="Orcamento" value="<?php echo $report->soma->somarestante ?>">
				</div>
			</div>
			<div class="col-md-3">
				<label for="DataFim">Frete:</label>
				<div class="input-group">
					<span class="input-group-addon">R$</span>
					<input type="text" class="form-control" disabled aria-label="Frete" value="<?php echo $report->soma->somafrete ?>">
				</div>
			</div>
			<div class="col-md-3">
				<label for="DataFim">Total:</label>
				<div class="input-group">
					<span class="input-group-addon">R$</span>
					<input type="text" class="form-control" disabled aria-label="Total" value="<?php echo $report->soma->somatotal ?>">
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
							<th class="active">Edit</th>
							<th class="active">Cliente</th>
							<th class="active">Pedido</th>
							
							<!--<th class="active">Valid. do Or�am.</th>
							<th class="active">Prazo de Entrega</th>-->
							<th class="active">Or�.</th>
							<th class="active">Frete</th>
							<th class="active">Total</th>					
							<th class="active">Apv.?</th>
							<th class="active">Entr.?</th>
							<th class="active">Pago?</th>
							<th class="active">Pagamento</th>
							<th class="active">Entrega</th>
							<th class="active">Dt. Or�.</th>
							<th class="active">Dt. Ent.</th>
							<th class="active">Dt. Venc.</th>
							<!--<th class="active">Obs.</th>-->
							<th class="active">Entregador</th>
							<th class="active">Print</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($report->result_array() as $row) {
							echo '<tr>';
							#echo '<tr class="clickable-row" data-href="' . base_url() . 'orcatrata/alterar2/' . $row['idApp_OrcaTrata'] . '">';

								#echo '<div class="clickable-row" data-href="' . base_url() . 'orcatrata/alterar2/' . $row['idApp_OrcaTrata'] . '">';
								echo '<td class="notclickable">
										<a class="btn btn-md btn-danger notclickable" href="' . base_url() . 'orcatrata/alterar2/' . $row['idApp_OrcaTrata'] . '">
											<span class="glyphicon glyphicon-edit notclickable"></span>
										</a>
									</td>';
								echo '<td>' . $row['NomeCliente'] . '</td>';
								echo '<td>' . $row['idApp_OrcaTrata'] . '</td>';
								#echo '<td>' . $row['DataEntradaOrca'] . '</td>';
								#echo '<td>' . $row['DataPrazo'] . '</td>';
								echo '<td class="text-left">' . $row['ValorRestanteOrca'] . '</td>';
								echo '<td class="text-left">' . $row['ValorFrete'] . '</td>';
								echo '<td class="text-left">' . $row['ValorTotalOrca'] . '</td>';
								echo '<td>' . $row['AprovadoOrca'] . '</td>';
								echo '<td>' . $row['ConcluidoOrca'] . '</td>';
								echo '<td>' . $row['QuitadoOrca'] . '</td>';
								echo '<td>' . $row['FormaPag'] . '</td>';
								echo '<td>' . $row['TipoFrete'] . '</td>';
								echo '<td>' . $row['DataOrca'] . '</td>';
								echo '<td>' . $row['DataEntregaOrca'] . '</td>';
								echo '<td>' . $row['DataVencimentoOrca'] . '</td>';
								#echo '<td>' . $row['Descricao'] . '</td>';
								echo '<td>' . $row['Nome'] . '</td>';
								#echo '</div>';
								echo '<td class="notclickable">
										<a class="btn btn-md btn-info notclickable" href="' . base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_OrcaTrata'] . '">
											<span class="glyphicon glyphicon-print notclickable"></span>
										</a>
									</td>';
							echo '</tr>';
						}
						?>
					</tbody>

				</table>
			</div>
		</div>
	</div>
</div>