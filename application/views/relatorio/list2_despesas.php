<div style="overflow: auto; height: 200px; ">	
	<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>	
		<!--
		<div class="panel panel-default">
			<div class="panel-body">

				<div class="col-md-1"></div>
				<div class="col-md-3">
					<label for="DataFim">Total das Despesas:</label>
					<div class="input-group">
						<span class="input-group-addon">R$</span>
						<input type="text" class="form-control" disabled aria-label="Total Orcamentos" value="<?php echo $report->soma->somaorcamento ?>">
					</div>
				</div>
				<div class="col-md-3">
					<label for="DataFim">Total dos Descontos:</label>
					<div class="input-group">
						<span class="input-group-addon">R$</span>
						<input type="text" class="form-control" disabled aria-label="Total Descontos" value="<?php echo $report->soma->somadesconto ?>">
					</div>
				</div>
				<div class="col-md-3">
					<label for="DataFim">Total A Pagar:</label>
					<div class="input-group">
						<span class="input-group-addon">R$</span>
						<input type="text" class="form-control" disabled aria-label="Total Restante" value="<?php echo $report->soma->somarestante ?>">
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
								<!--<th class="active">EdtOrç</th>-->
								<th class="active">Imp.</th>
								<th class="active">Orç.</th>
								<th class="active">Despesa</th>
								<!--<th class="active">Valid. do Orçam.</th>
								<th class="active">Prazo de Entrega</th>-->
								<th class="active">Orçamento</th>
								<th class="active">Desconto</th>
								<th class="active">Pagar</th>					
								<th class="active">FormaPagm.</th>
								<!--<th class="active">Qtd.Prc.</th>
								<th class="active">Mod.</th>
								<th class="active">Forma de Pag.</th>-->
								<th class="active">Apv.Quit.Concl.</th>
								<th class="active">Dt.Orç.</th>
								<th class="active">Dt.Concl.</th>
								<th class="active">Dt.Quit.</th>
								<th class="active">Dt.Retor.</th>
								<th class="active">Dt.Venc.</th>
								<th class="active">Obs.</th>
								<th class="active">Remover</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($report->result_array() as $row) {
								echo '<tr>';
								echo '<tr class="clickable-row" data-href="' . base_url() . 'orcatrata/alterardesp/' . $row['idApp_OrcaTrata'] . '">';
									/*
									echo '<td class="notclickable">
											<a class="btn btn-md btn-danger notclickable" href="' . base_url() . 'Orcatrata/alterardesp/' . $row['idApp_OrcaTrata'] . '">
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
									echo '<td>' . $row['Descricao'] . '</td>';
									#echo '<td>' . $row['DataEntradaOrca'] . '</td>';
									#echo '<td>' . $row['DataPrazo'] . '</td>';
									echo '<td class="text-right">' . $row['ValorOrca'] . '</td>';
									echo '<td class="text-right">' . $row['ValorDev'] . '</td>';
									echo '<td class="text-right">' . $row['ValorRestanteOrca'] . '</td>';
									echo '<td>' . $row['Modalidade'] . ' - ' . $row['Abrev3'] . ' - ' . $row['QtdParcelasOrca'] . ' X ' . $row['FormaPag'] . '</td>';
									#echo '<td>' . $row['QtdParcelasOrca'] . '</td>';
									#echo '<td>' . $row['Modalidade'] . '</td>';
									#echo '<td>' . $row['FormaPag'] . '</td>';
									echo '<td>' . $row['AprovadoOrca'] . ' - ' . $row['QuitadoOrca'] . ' - ' . $row['ConcluidoOrca'] . '</td>';
									echo '<td>' . $row['DataOrca'] . '</td>';							
									echo '<td>' . $row['DataConclusao'] . '</td>';
									echo '<td>' . $row['DataQuitado'] . '</td>';
									echo '<td>' . $row['DataRetorno'] . '</td>';
									echo '<td>' . $row['DataVencimentoOrca'] . '</td>';
									echo '<td>' . $row['ObsOrca'] . '</td>';
									echo '<td class="notclickable">
											<a class="btn btn-md btn-danger notclickable" href="' . base_url() . 'orcatrata/excluirdesp/' . $row['idApp_OrcaTrata'] . '">
												<span class="glyphicon glyphicon-trash notclickable"></span>
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
	<?php } else { ?>	
		<!--
		<div class="panel panel-default">
			<div class="panel-body">

				<div class="col-md-1"></div>
				<div class="col-md-3">
					<label for="DataFim">Total A Pagar:</label>
					<div class="input-group">
						<span class="input-group-addon">R$</span>
						<input type="text" class="form-control" disabled aria-label="Total Restante" value="<?php echo $report->soma->somarestante ?>">
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
								<!--<th class="active">EdtOrç</th>-->
								<th class="active">Imp.</th>							
								<th class="active">Orç.</th>
								<th class="col-md-3 active" scope="col">Despesa</th>
								<th class="col-md-2 active" scope="col">Valor</th>					
								<th class="active">FormaPagm.</th>
								<th class="active">Dt.Venc.</th>
								<th class="active">Quitado</th>
								<th class="active">Remover</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($report->result_array() as $row) {
								echo '<tr>';
								echo '<tr class="clickable-row" data-href="' . base_url() . 'orcatrata/alterardesp/' . $row['idApp_OrcaTrata'] . '">';
									/*
									echo '<td class="notclickable">
											<a class="btn btn-md btn-danger notclickable" href="' . base_url() . 'Orcatrata/alterardesp/' . $row['idApp_OrcaTrata'] . '">
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
									echo '<td>' . $row['Descricao'] . '</td>';
									echo '<td class="text-right">' . $row['ValorRestanteOrca'] . '</td>';
									echo '<td>' . $row['Modalidade'] . ' - ' . $row['Abrev3'] . ' - ' . $row['QtdParcelasOrca'] . ' X  ' . $row['FormaPag'] . '</td>';
									echo '<td>' . $row['DataVencimentoOrca'] . '</td>';
									echo '<td>' . $row['QuitadoOrca'] . '</td>';
									echo '<td class="notclickable">
											<a class="btn btn-md btn-danger notclickable" href="' . base_url() . 'orcatrata/excluirdesp/' . $row['idApp_OrcaTrata'] . '">
												<span class="glyphicon glyphicon-trash notclickable"></span>
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
		
	<?php } ?>
</div>