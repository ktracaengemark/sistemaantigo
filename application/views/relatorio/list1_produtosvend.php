<div style="overflow: auto; height: 550px; ">	
	<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>

		<div class="container-fluid">
			<div class="row">
				<div>
					<!--
					<table class="table table-bordered table-condensed table-striped">
						<tfoot>
							<tr>
								<th colspan="3" class="active">Receitas: <?php echo $report->num_rows(); ?> resultado(s)</th>
							</tr>
						</tfoot>
					</table>
					-->
					<table class="table table-bordered table-condensed table-striped">
						<thead>
							<tr>
								<th colspan="4" class="active">Vendas: <?php echo $report->num_rows(); ?> resultado(s)</th>
								<th colspan="7" class="active"> <?php echo $report->soma->quantidade ?> Produtos Vendidos</th>
								<!--<th colspan="1" class="active">Total: <?php echo $report->soma->somasubtotal ?> </th>-->
							</tr>
						</thead>						
						<thead>						
							<tr>
								<!--<th class="active">EdtOrç</th>-->
								<th class="active">Imp.</th>							
								<th class="active">Orç.</th>
								<th class="active">Receita</th>
								<!--<th class="active">Valid. do Orçam.</th>
								<th class="active">Prazo de Entrega</th>
								<th class="active">Orçamento</th>
								<th class="active">Desconto</th>
								<th class="active">Receb</th>-->					
								<!--<th class="active">FormaPagm.</th>
								<th class="active">Qtd.Prc.</th>
								<th class="active">Mod.</th>
								<th class="active">Forma de Pag.</th>-->
								<th class="active">Concl/Quit</th>
								<!--<th class="active">Dt.Concl.</th>
								<th class="active">Dt.Quit.</th>
								<th class="active">Dt.Retor.</th>
								<th class="active">Dt.Venc.</th>
								<th class="active">Obs.</th>-->
								<th class="active">Qtd</th>								
								<th class="active">Categoria</th>
								<th class="active">Tipo</th>
								<th class="active">Esp</th>
								<th class="active">Produto</th>
								<th class="active">Valor</th>
								<th class="active">Dt.Prd.</th>
								<!--<th class="active">Remover</th>-->
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
									echo '<td>' . $row['idApp_OrcaTrata'] . '</td>';
									echo '<td>' . $row['Descricao'] . '</td>';
									#echo '<td>' . $row['DataEntradaOrca'] . '</td>';
									#echo '<td>' . $row['DataPrazo'] . '</td>';
									#echo '<td class="text-right">' . $row['ValorOrca'] . '</td>';
									#echo '<td class="text-right">' . $row['ValorDev'] . '</td>';
									#echo '<td class="text-right">' . $row['ValorRestanteOrca'] . '</td>';
									#echo '<td>' . $row['Modalidade'] . ' - ' . $row['Abrev3'] . ' - ' . $row['QtdParcelasOrca'] . ' X - ' . $row['FormaPag'] . '</td>';
									#echo '<td>' . $row['QtdParcelasOrca'] . '</td>';
									#echo '<td>' . $row['Modalidade'] . '</td>';
									#echo '<td>' . $row['FormaPag'] . '</td>';
									echo '<td>' . $row['ConcluidoOrca'] . ' - ' . $row['QuitadoOrca'] . '</td>';
																
									#echo '<td>' . $row['DataConclusao'] . '</td>';
									#echo '<td>' . $row['DataQuitado'] . '</td>';
									#echo '<td>' . $row['DataRetorno'] . '</td>';
									#echo '<td>' . $row['DataVencimentoOrca'] . '</td>';
									#echo '<td>' . $row['ObsOrca'] . '</td>';
									echo '<td>' . $row['QtdProduto'] . '</td>';
									echo '<td>' . $row['Prodaux3'] . '</td>';
									echo '<td>' . $row['Prodaux2'] . '</td>';
									echo '<td>' . $row['Prodaux1'] . '</td>';
									echo '<td>' . $row['Produtos'] . '</td>';
									echo '<td>' . $row['ValorProduto'] . '</td>';
									echo '<td>' . $row['DataValidadeProduto'] . '</td>';
									/*
									echo '<td class="notclickable">
											<a class="btn btn-md btn-info notclickable" href="' . base_url() . 'orcatrata/excluir2/' . $row['idApp_OrcaTrata'] . '">
												<span class="glyphicon glyphicon-trash notclickable"></span>
											</a>
										</td>';	
									*/	
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
								<!--<th class="active">EdtOrç</th>-->							
								<th class="active">Imp.</th>								
								<th class="active">Orç.</th>
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