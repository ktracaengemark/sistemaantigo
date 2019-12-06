<div style="overflow: auto; height: 550px; ">	
	<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>

		<div class="container-fluid">
			<div class="row">
				<div>
					<table class="table table-bordered table-condensed table-striped">
						<tfoot>
							<tr>
								<th colspan="3" class="active">Receitas: <?php echo $report->num_rows(); ?> resultado(s)</th>
							</tr>
						</tfoot>
					</table>
					<table class="table table-bordered table-condensed table-striped">
						<thead>
							<tr>
								<!--<th class="active">EdtOr�</th>-->
								<th class="active">Imp.</th>							
								<th class="active">Or�.</th>
								<th class="active">Cliente</th>
								<th class="active">Receita</th>
								<!--<th class="active">Valid. do Or�am.</th>
								<th class="active">Prazo de Entrega</th>-->
								<th class="active">Or�am.</th>
								<th class="active">Desconto</th>
								<th class="active">Receber</th>					
								<th class="active">FormaPagm.</th>
								<!--<th class="active">Qtd.Prc.</th>
								<th class="active">Mod.</th>
								<th class="active">Forma de Pag.</th>-->
								<th class="active">Apv.</th>
								<th class="active">Dt.Or�.</th>
								<th class="active">Dt.Venc.</th>
								<th class="active">Remover</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($report->result_array() as $row) {
								echo '<tr>';
								#echo '<tr class="clickable-row" data-href="' . base_url() . 'orcatrata/alterar2/' . $row['idApp_OrcaTrata'] . '">';
									/*
									echo '<td class="notclickable">
											<a class="btn btn-md btn-success notclickable" href="' . base_url() . 'Orcatrata/alterar2/' . $row['idApp_OrcaTrata'] . '">
												<span class="glyphicon glyphicon-edit notclickable"></span>
											</a>
										</td>';
										
									echo '<td class="notclickable">
											<a class="btn btn-md btn-info notclickable" target="_blank" href="' . base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_OrcaTrata'] . '">
												<span class="glyphicon glyphicon-print notclickable"></span>
											</a>
											
										</td>';
									*/	
									echo '<td class="notclickable">
											<a class="btn btn-md btn-info notclickable" href="' . base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_OrcaTrata'] . '">
												<span class="glyphicon glyphicon-print notclickable"></span>
											</a>
											
										</td>';										
									echo '<td>' . $row['idApp_OrcaTrata'] . '- ' . $row['TipoFinanceiro'] . '</td>';
									echo '<td>' . $row['NomeCliente'] . '</td>';
									echo '<td>' . $row['Descricao'] . '</td>';
									#echo '<td>' . $row['DataEntradaOrca'] . '</td>';
									#echo '<td>' . $row['DataPrazo'] . '</td>';
									echo '<td class="text-right">' . $row['ValorOrca'] . '</td>';
									echo '<td class="text-right">' . $row['ValorDev'] . '</td>';
									echo '<td class="text-right">' . $row['ValorRestanteOrca'] . '</td>';
									echo '<td>' . $row['Modalidade'] . ' - ' . $row['Abrev3'] . ' - ' . $row['QtdParcelasOrca'] . ' X - ' . $row['FormaPag'] . '</td>';
									#echo '<td>' . $row['QtdParcelasOrca'] . '</td>';
									#echo '<td>' . $row['Modalidade'] . '</td>';
									#echo '<td>' . $row['FormaPag'] . '</td>';
									echo '<td>' . $row['AprovadoOrca'] . '</td>';
									echo '<td>' . $row['DataOrca'] . '</td>';							
									echo '<td>' . $row['DataVencimentoOrca'] . '</td>';
									echo '<td class="notclickable">
											<a class="btn btn-md btn-info notclickable" href="' . base_url() . 'orcatrata/excluir2/' . $row['idApp_OrcaTrata'] . '">
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
					<label for="DataFim">Total A Receber:</label>
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
								<th colspan="3" class="active">Receitas: <?php echo $report->num_rows(); ?> resultado(s)</th>
							</tr>
						</tfoot>
					</table>
					<table class="table table-bordered table-condensed table-striped">
						<thead>
							<tr>
								<!--<th class="active">EdtOr�</th>-->							
								<th class="active">Imp.</th>								
								<th class="active">Or�.</th>
								<th class="col-md-3 active" scope="col">Receita</th>
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
								echo '<tr class="clickable-row" data-href="' . base_url() . 'orcatrata/alterar2/' . $row['idApp_OrcaTrata'] . '">';
									/*
									echo '<td class="notclickable">
											<a class="btn btn-md btn-success notclickable" href="' . base_url() . 'Orcatrata/alterar2/' . $row['idApp_OrcaTrata'] . '">
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
									echo '<td class="text-right">' . $row['ValorRestanteOrca'] . '</td>';
									echo '<td>' . $row['Modalidade'] . ' - ' . $row['Abrev3'] . ' - ' . $row['QtdParcelasOrca'] . ' X ' . $row['FormaPag'] . '</td>';
									echo '<td>' . $row['DataVencimentoOrca'] . '</td>';
									echo '<td>' . $row['QuitadoOrca'] . '</td>';
									echo '<td class="notclickable">
											<a class="btn btn-md btn-info notclickable" href="' . base_url() . 'orcatrata/excluir2/' . $row['idApp_OrcaTrata'] . '">
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