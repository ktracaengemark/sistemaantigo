<div style="overflow: auto; height: 550px; ">	
	<!--
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="col-md-1"></div>
			<div class="col-md-3">
				<label for="DataFim">Or�amento:</label>
				<div class="input-group">
					<span class="input-group-addon">R$</span>
					<input type="text" class="form-control" disabled aria-label="Orcamento" value="<?php #echo $report->soma->somarestante ?>">
				</div>
			</div>
			<div class="col-md-3">
				<label for="DataFim">Frete:</label>
				<div class="input-group">
					<span class="input-group-addon">R$</span>
					<input type="text" class="form-control" disabled aria-label="Frete" value="<?php #echo $report->soma->somafrete ?>">
				</div>
			</div>
			<div class="col-md-3">
				<label for="DataFim">Total:</label>
				<div class="input-group">
					<span class="input-group-addon">R$</span>
					<input type="text" class="form-control" disabled aria-label="Total" value="<?php #echo $report->soma->somatotal ?>">
				</div>
			</div>
			<div class="col-md-1"></div>
		</div>
	</div>
	-->
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
							<th class="active">Print</th>
							<th class="active">Editar</th>
							<th class="active">Cont.</th>
							<th class="active">Pedido</th>
							<?php if($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
								<th class="active">Fornecedor</th>
							<?php } ?>
							<th class="active">Desp</th>
							<?php if($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
								<th class="active">Prd+Srv</th>
								<th class="active">Frete</th>
								<th class="active">Total</th>
								<th class="active">Comb.</th>
								<th class="active">Apv.</th>
								<th class="active">Entr.</th>
							<?php } ?>
							<th class="active">Pago</th>
							<?php if($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
								<th class="active">Final.</th>
								<th class="active">Cancel.</th>
								<th class="active">Compra</th>
								<th class="active">Entrega</th>
							<?php } ?>
							<th class="active">Pagam.</th>
							<th class="active">Form.Pag</th>
							<th class="active">Dt.Or�.</th>
							<?php if($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
								<th class="active">Dt.Ent.</th>
							<?php } ?>
							<th class="active">Dt.Vnc.</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$count = 1;
						foreach ($report->result_array() as $row) {
							echo '<tr>';
							#echo '<tr class="clickable-row" data-href="' . base_url() . 'orcatrata/alterar2/' . $row['idApp_OrcaTrata'] . '">';

								#echo '<div class="clickable-row" data-href="' . base_url() . 'orcatrata/alterar2/' . $row['idApp_OrcaTrata'] . '">';
								
								echo '<td class="notclickable">
										<a class="btn btn-md btn-danger notclickable" href="' . base_url() . 'OrcatrataPrint/imprimirdesp/' . $row['idApp_OrcaTrata'] . '">
											<span class="glyphicon glyphicon-print notclickable"></span>
										</a>
									</td>';
								echo '<td class="notclickable">
										<a class="btn btn-md btn-warning notclickable" href="' . base_url() . 'Orcatrata/alterardesp/' . $row['idApp_OrcaTrata'] . '">
											<span class="glyphicon glyphicon-edit notclickable"></span>
										</a>
									</td>';
								echo '<td>' . $count . '</td>';	
								echo '<td>' . $row['idApp_OrcaTrata'] . ' - ' . $row['TipoFinanceiro'] . ' - ' . $row['Descricao'] . '</td>';
								#echo '<td>' . $row['DataEntradaOrca'] . '</td>';
								#echo '<td>' . $row['DataPrazo'] . '</td>';
								if($_SESSION['log']['NivelEmpresa'] >= 4 ){
									echo '<td>' . $row['NomeFornecedor'] . '</td>';
								}
								echo '<td class="text-left">' . $row['ValorExtraOrca'] . '</td>';
								if($_SESSION['log']['NivelEmpresa'] >= 4 ){
									echo '<td class="text-left">' . $row['ValorRestanteOrca'] . '</td>';
									echo '<td class="text-left">' . $row['ValorFrete'] . '</td>';
									echo '<td class="text-left">' . $row['ValorTotalOrca'] . '</td>';
									echo '<td>' . $row['CombinadoFrete'] . '</td>';
									echo '<td>' . $row['AprovadoOrca'] . '</td>';
									echo '<td>' . $row['ConcluidoOrca'] . '</td>';
								}
								echo '<td>' . $row['QuitadoOrca'] . '</td>';
								if($_SESSION['log']['NivelEmpresa'] >= 4 ){
									echo '<td>' . $row['FinalizadoOrca'] . '</td>';
									echo '<td>' . $row['CanceladoOrca'] . '</td>';
									echo '<td>' . $row['Tipo_Orca'] . '</td>';
									echo '<td>' . $row['TipoFrete'] . '</td>';
								}
								echo '<td>' . $row['AVAP'] . '</td>';
								echo '<td>' . $row['FormaPag'] . '</td>';
								echo '<td>' . $row['DataOrca'] . '</td>';
								if($_SESSION['log']['NivelEmpresa'] >= 4 ){
									echo '<td>' . $row['DataEntregaOrca'] . '</td>';
								}	
								echo '<td>' . $row['DataVencimentoOrca'] . '</td>';
								#echo '<td>' . $row['Descricao'] . '</td>';
								#echo '<td>' . $row['Nome'] . '</td>';
								#echo '</div>';
							echo '</tr>';
							$count++;
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>