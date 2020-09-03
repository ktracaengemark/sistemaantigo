<div style="overflow: auto; height: 550px; ">	
	<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
		<!--
		<div class="panel panel-default">
			<div class="panel-body">

				<div class="col-md-1"></div>
				<div class="col-md-3">
					<label for="DataFim">Total de Vendas:</label>
					<div class="input-group">
						<span class="input-group-addon">R$</span>
						<input type="text" class="form-control" disabled aria-label="Total Restante" value="<?php echo $report->soma->somasubtotal ?>">
					</div>
				</div>
				<div class="col-md-1"></div>
			</div>
		</div>
		-->
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
						<!--
						<thead>
							<tr>
								<th colspan="4" class="active">Vendas: <?php echo $report->num_rows(); ?> resultado(s)</th>
								<th colspan="4" class="active"> <?php echo $report->soma->quantidade ?> Produtos Vendidos</th>
								<th colspan="1" class="active">Total: <?php echo $report->soma->somasubtotal ?> </th>
							</tr>
						</thead>
						-->
						<thead>						
							<tr>
								<!--<th class="active">EdtOrç</th>
								<th class="active">Imp.</th>-->							
								<th class="active">Orç.</th>
								<th class="active">Colaborador</th>
								<th class="active">Cliente</th>
								<th class="active">Dt.Venc.</th>								
								<!--<th class="active">Qtd</th>									
								<th class="active">Produto</th>
								<th class="active">Valor</th>
								<th class="active">SubTotal</th>
								<th class="active">Comissao(%)</th>
								<th class="active">SubComissao</th>
								<th class="active">Paga?</th>-->
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
										
									echo '<td class="notclickable">
											<a class="btn btn-md btn-info notclickable" href="' . base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_OrcaTrata'] . '">
												<span class="glyphicon glyphicon-print notclickable"></span>
											</a>
											
										</td>';
									*/	
									echo '<td>' . $row['idApp_OrcaTrata'] . '</td>';
									echo '<td>' . $row['NomeColaborador'] . '</td>';
									echo '<td>' . $row['NomeCliente'] . '</td>';
									echo '<td>' . $row['DataVencimentoOrca'] . '</td>';									
									//echo '<td>' . $row['QtdProduto'] . '</td>';	
									//echo '<td>' . $row['Produtos'] . '</td>';
									//echo '<td class="text-right">' . $row['ValorProduto'] . '</td>';
									//echo '<td class="text-right">' . $row['SubTotal'] . '</td>';
									//echo '<td class="text-right">' . $row['ComissaoProduto'] . '</td>';
									//echo '<td class="text-right">' . $row['SubComissao'] . '</td>';
									//echo '<td>' . $row['StatusComissao'] . '</td>';

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
						<!--
						<tfoot>
							<tr>
								<th colspan="4" class="active">Vendas: <?php echo $report->num_rows(); ?> resultado(s)</th>
								<th colspan="2" class="active"> <?php echo $report->soma->quantidade ?> Produtos</th>
								<th colspan="2" class="active text-right">Total: R$ <?php echo $report->soma->somasubtotal ?> </th>
								<th colspan="2" class="active text-right">Comissao: R$ <?php echo $report->soma->somasubcomissao ?> </th>
							</tr>
						</tfoot>
						-->
					</table>
				</div>
			</div>
		</div>
		
	<?php } else { ?>

	<?php } ?>
</div>