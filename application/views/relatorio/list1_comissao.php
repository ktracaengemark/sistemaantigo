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
						<thead>
							<tr>
								<th colspan="3" class="active">Receitas: <?php echo $report->num_rows(); ?> resultado(s)</th>
							</tr>
						</thead>
					</table>
					-->
					<table class="table table-bordered table-condensed table-striped">
						
						<thead>
							<tr>
								<th colspan="3" class="active"> <?php echo $report->num_rows(); ?> resultado(s)</th>
								<th colspan="17" class="active"></th>
								<th colspan="1" class="active text-right">Total:R$ <?php echo $report->soma->somaorcamento ?> </th>
								<th colspan="1" class="active text-right">Total:R$ <?php echo $report->soma->somacomissao ?> </th>
								<!--<th colspan="4" class="active"> <?php echo $report->soma->quantidade ?> Produtos Vendidos</th>
								<th colspan="1" class="active">Total: <?php echo $report->soma->somasubtotal ?> </th>-->
							</tr>
						</thead>
						
						<thead>						
							<tr>
								<!--<th class="active">EdtOrç</th>-->
								<th class="active">Imp.</th>
								<th class="active">Cont.</th>							
								<th class="active">Pedido</th>
								<th class="active">Cliente</th>
								<th class="active">Tipo</th>
								<th class="active">Colaborador</th>
								<!--<th class="active">Associado</th>-->
								<th class="active">Comb.</th>
								<th class="active">Apr.</th>
								<th class="active">Entr.</th>
								<th class="active">Pago</th>
								<th class="active">Final.</th>
								<th class="active">Canc.</th>
								<th class="active">Compra</th>
								<th class="active">Entrega</th>
								<th class="active">Pagam.</th>
								<th class="active">Form.Pag.</th>
								<th class="active">DtPedido</th>
								<th class="active">DtEntrega</th>
								<th class="active">DtVnc</th>
								<th class="active">DtVncPrc</th>
								<th class="active">ValorTotal</th>
								<th class="active">Comissao</th>
								<th class="active">Paga?</th>								
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
							$count = 1;
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
											<a class="btn btn-md btn-info notclickable" href="' . base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_OrcaTrata'] . '">
												<span class="glyphicon glyphicon-print notclickable"></span>
											</a>
											
										</td>';
									*/	
									echo '<td class="notclickable">
											<a class="btn btn-md btn-info notclickable" href="' . base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_OrcaTrata'] . '">
												<span class="glyphicon glyphicon-print notclickable"></span>
											</a>
											
										</td>';
									echo '<td>' . $count . '</td>';
									echo '<td>' . $row['idApp_OrcaTrata'] . '</td>';
									echo '<td>' . $row['NomeCliente'] . '</td>';
									echo '<td>' . $row['TipoFinanceiro'] . '</td>';
									echo '<td>' . $row['NomeColaborador'] . '</td>';
									#echo '<td>' . $row['Associado'] . '</td>';
									echo '<td>' . $row['CombinadoFrete'] . '</td>';
									echo '<td>' . $row['AprovadoOrca'] . '</td>';
									echo '<td>' . $row['ConcluidoOrca'] . '</td>';
									echo '<td>' . $row['QuitadoOrca'] . '</td>';
									echo '<td>' . $row['FinalizadoOrca'] . '</td>';
									echo '<td>' . $row['CanceladoOrca'] . '</td>';
									echo '<td>' . $row['Tipo_Orca'] . '</td>';
									echo '<td>' . $row['TipoFrete'] . '</td>';
									echo '<td>' . $row['AVAP'] . '</td>';
									echo '<td>' . $row['FormaPag'] . '</td>';
									echo '<td>' . $row['DataOrca'] . '</td>';
									echo '<td>' . $row['DataEntregaOrca'] . '</td>';
									echo '<td>' . $row['DataVencimentoOrca'] . '</td>';
									echo '<td>' . $row['DataVencimento'] . '</td>';
									echo '<td>' . $row['ValorRestanteOrca'] . '</td>';	
									echo '<td>' . $row['ValorComissao'] . '</td>';	
									echo '<td>' . $row['StatusComissaoOrca'] . '</td>';											
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
								$count++;
							}
							?>
						</tbody>
						
						<tfoot>
							<tr>
								<th colspan="3" class="active"> <?php echo $report->num_rows(); ?> resultado(s)</th>
								<th colspan="17" class="active"></th>
								<!--<th colspan="2" class="active"> <?php echo $report->soma->quantidade ?> Produtos</th>-->
								<th colspan="1" class="active text-right">Total:R$ <?php echo $report->soma->somaorcamento ?> </th>
								<th colspan="1" class="active text-right">Total:R$ <?php echo $report->soma->somacomissao ?> </th>
							</tr>
						</tfoot>
						
					</table>
				</div>
			</div>
		</div>
		
	<?php } else { ?>

	<?php } ?>
</div>