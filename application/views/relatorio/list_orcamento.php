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
						<?php if($metodo == 1 || $metodo == 2) { ?>
							<th colspan="17" class="active"></th>
							<th colspan="1" class="active text-right">Total:R$ <?php echo $report->soma->somaorcamento ?> </th>
							<th colspan="1" class="active text-right">Total:R$ <?php echo $report->soma->somacomissao ?> </th>
						<?php } ?>
						<!--<th colspan="4" class="active"> <?php echo $report->soma->quantidade ?> Produtos Vendidos</th>
						<th colspan="1" class="active">Total: <?php echo $report->soma->somasubtotal ?> </th>-->
					</tr>
				</thead>
				
				<thead>						
					<tr>
						<!--<th class="active">EdtOrç</th>-->
						<th class="active">Imp.</th>
						<?php if($editar == 1) { ?>
							<?php if($metodo == 3) { ?>
								<th class="active">Baixa</th>
							<?php } ?>
						<?php }elseif($editar == 2) {?>
							<th class="active">Editar</th>
						<?php } ?>
						<th class="active">Cont.</th>							
						<th class="active">Pedido</th>
						<th class="active"><?php echo $nome ?></th>
						<th class="active">Tipo</th>
						<th class="active"><?php echo $nomeusuario ?></th>
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
						<?php if($metodo == 1 || $metodo == 2) { ?>
							<th class="active">Prd/Srv</th>
							<th class="active">Comissao</th>
							<th class="active">Paga?</th>
						<?php } ?>
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
							echo '<td class="notclickable">
									<a class="btn btn-md btn-' . $panel . ' notclickable" href="' . base_url() . $imprimir . $row['idApp_OrcaTrata'] . '">
										<span class="glyphicon glyphicon-print notclickable"></span>
									</a>
									
								</td>';
							if($editar == 1){	
								if($metodo == 3){
									if($row['CanceladoOrca'] == "Não"){	
										if($row['QuitadoOrca'] == "Sim" && $row['ConcluidoOrca'] == "Sim"){
											echo '<td class="notclickable">
													<a class="btn btn-md btn-danger notclickable">
														<span class="glyphicon glyphicon-ok notclickable"></span>
													</a>
												</td>';
										}else{
											echo '<td class="notclickable">
													<a class="btn btn-md btn-success notclickable" href="' . base_url() . $baixa . $row['idApp_OrcaTrata'] . '">
														<span class="glyphicon glyphicon-ok notclickable"></span>
													</a>
												</td>';
										}
									}else{
										echo '<td class="notclickable">
													<a class="btn btn-md btn-danger notclickable">
														<span class="glyphicon glyphicon-ok notclickable"></span>
													</a>
												</td>';
									}
								}
							}else if($editar == 2){
								echo '<td class="notclickable">
										<a class="btn btn-md btn-success notclickable" href="' . base_url() . $edit . $row['idApp_OrcaTrata'] . '">
											<span class="glyphicon glyphicon-edit notclickable"></span>
										</a>
									</td>';
							}	
							echo '<td>' . $count . '</td>';
							echo '<td>' . $row['idApp_OrcaTrata'] . '</td>';
							echo '<td>' . $row['Nome' . $nome] . '</td>';
							echo '<td>' . $row['TipoFinanceiro'] . '</td>';
							echo '<td>' . $row[$nomeusuario] . '</td>';
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
							if($metodo == 1 || $metodo == 2){
								echo '<td>' . $row['ValorRestanteOrca'] . '</td>';	
								echo '<td>' . $row['ValorComissao'] . '</td>';
								echo '<td>' . $row[$status] . '</td>';
							}
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
						<?php if($metodo == 1 || $metodo == 2) { ?>
							<th colspan="17" class="active"></th>
							<!--<th colspan="2" class="active"> <?php echo $report->soma->quantidade ?> Produtos</th>-->
							<th colspan="1" class="active text-right">Total:R$ <?php echo $report->soma->somaorcamento ?> </th>
							<th colspan="1" class="active text-right">Total:R$ <?php echo $report->soma->somacomissao ?> </th>
						<?php } ?>	
					</tr>
				</tfoot>
				
			</table>
		</div>
	</div>
</div>
