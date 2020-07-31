<?php if (isset($msg)) echo $msg; ?>

<div class="col-md-8 ">
	<div class="row">
		<div class="col-md-12 col-lg-12">
			<?php echo validation_errors(); ?>
			<?php echo form_open_multipart($form_open_path); ?>
			<div class="panel panel-<?php echo $panel; ?>">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-8">	
							<h4 class="text-center"><b><?php echo $titulo; ?> - <?php echo $orcatrata['idApp_OrcaTrata'] ?></b></h4>
						</div>	
						<div class="col-md-4">	
							<div class="row">
								<div class="col-md-6">
									<a class="btn btn-sm btn-info text-right" href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $orcatrata['idApp_OrcaTrata']; ?>">
										<span class="glyphicon glyphicon-print"></span> Imprimir										
									</a>
								</div>	
								<div class="col-md-6">	
									<a class="btn btn-sm btn-info text-right" href="<?php echo base_url() . 'orcatrata/alterar2/' . $orcatrata['idApp_OrcaTrata']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Editar										
									</a>
								</div>	
							</div>
						</div>
					</div>
					<div style="overflow: auto; height: auto; ">
						<div class="panel-group">	
							<input type="hidden" name="DataOrca" value="<?php echo $orcatrata['DataOrca'] ?>">
							<input type="hidden" name="Cadastrar" value="<?php echo $cadastrar['Cadastrar'] ?>">
							<input type="hidden" name="idApp_Cliente" value="<?php echo $orcatrata['idApp_Cliente'] ?>">
							<input type="hidden" name="TipoFinanceiro" value="<?php echo $orcatrata['TipoFinanceiro'] ?>">
							<input type="hidden" name="Descricao" value="<?php echo $orcatrata['Descricao'] ?>">

							<div <?php echo $visivel; ?>>								
							

										
								<input type="hidden" name="Negocio" id="Negocio" value="1"/>
								<input type="hidden" name="Empresa" id="Empresa" value="<?php echo $_SESSION['log']['idSis_Empresa']; ?>"/>
								<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
								<input type="hidden" name="PCount" id="PCount" value="<?php echo $count['PCount']; ?>"/>
									<div class="input_fields_wrap9">
										
										<?php
										$QtdSoma = $ProdutoSoma = 0;
										for ($i=1; $i <= $count['PCount']; $i++) {
										?>

										<?php if ($metodo > 1) { ?>
										<input type="hidden" name="idApp_Produto<?php echo $i ?>" value="<?php echo $produto[$i]['idApp_Produto']; ?>"/>
										<?php } ?>

										<input type="hidden" name="ProdutoHidden" id="ProdutoHidden<?php echo $i ?>" value="<?php echo $i ?>">

										<div class="form-group" id="9div<?php echo $i ?>">
											
											<input type="hidden" name="QtdProduto<?php echo $i ?>" value="<?php echo $produto[$i]['QtdProduto'] ?>">
											<input type="hidden" name="QtdIncrementoProduto<?php echo $i ?>" value="<?php echo $produto[$i]['QtdIncrementoProduto'] ?>">
											<input type="hidden" name="idTab_Valor_Produto<?php echo $i ?>" value="<?php echo $produto[$i]['idTab_Valor_Produto'] ?>">
											<input type="hidden" name="idTab_Produtos_Produto<?php echo $i ?>" value="<?php echo $produto[$i]['idTab_Produtos_Produto'] ?>">			
											<input type="hidden" name="idTab_Produto<?php echo $i ?>" value="<?php echo $produto[$i]['idTab_Produto'] ?>">
											<input type="hidden" name="ValorProduto<?php echo $i ?>" value="<?php echo $produto[$i]['ValorProduto'] ?>">
											
											<input type="hidden" name="idSis_Usuario<?php echo $i ?>" value="<?php echo $produto[$i]['idSis_Usuario'] ?>">
											<input type="hidden" name="DataValidadeProduto<?php echo $i ?>" value="<?php echo $produto[$i]['DataValidadeProduto'] ?>">
											<input type="hidden" name="ObsProduto<?php echo $i ?>" value="<?php echo $produto[$i]['ObsProduto'] ?>">
											<input type="hidden" name="ConcluidoProduto<?php echo $i ?>" value="<?php echo $produto[$i]['ConcluidoProduto'] ?>">
											<input type="hidden" name="DevolvidoProduto<?php echo $i ?>" value="<?php echo $produto[$i]['DevolvidoProduto'] ?>">
													
										</div>

										<?php
										$QtdSoma+=$produto[$i]['QtdProduto'];
										$ProdutoSoma++;
										}
										?>
										<input type="hidden" name="CountMax" id="CountMax" value="<?php echo $ProdutoSoma ?>">
									</div>
								
									<input type="hidden" name="SCount" id="SCount" value="<?php echo $count['SCount']; ?>"/>

									<div class="input_fields_wrap10">

										<?php
										$QtdSomaDev = $ServicoSoma = 0;
										for ($i=1; $i <= $count['SCount']; $i++) {
										?>

										<?php if ($metodo > 1) { ?>
										<input type="hidden" name="idApp_Servico<?php echo $i ?>" value="<?php echo $servico[$i]['idApp_Servico']; ?>"/>
										<?php } ?>

										<input type="hidden" name="ServicoHidden" id="ServicoHidden<?php echo $i ?>" value="<?php echo $i ?>">
										
										<div class="form-group" id="10div<?php echo $i ?>">
											
											<input type="hidden" name="QtdServico<?php echo $i ?>" value="<?php echo $servico[$i]['QtdServico'] ?>">
											<input type="hidden" name="QtdIncrementoServico<?php echo $i ?>" value="<?php echo $servico[$i]['QtdIncrementoServico'] ?>">
											<input type="hidden" name="idTab_Valor_Servico<?php echo $i ?>" value="<?php echo $servico[$i]['idTab_Valor_Servico'] ?>">
											<input type="hidden" name="idTab_Produtos_Servico<?php echo $i ?>" value="<?php echo $servico[$i]['idTab_Produtos_Servico'] ?>">
											<input type="hidden" name="idTab_Servico<?php echo $i ?>" value="<?php echo $servico[$i]['idTab_Servico'] ?>">
											<input type="hidden" name="ValorServico<?php echo $i ?>" value="<?php echo $servico[$i]['ValorServico'] ?>">
											
											<input type="hidden" name="ObsServico<?php echo $i ?>" value="<?php echo $servico[$i]['ObsServico'] ?>">
											<input type="hidden" name="DataValidadeServico<?php echo $i ?>" value="<?php echo $servico[$i]['DataValidadeServico'] ?>">
											<input type="hidden" name="ConcluidoServico<?php echo $i ?>" value="<?php echo $servico[$i]['ConcluidoServico'] ?>">
											<input type="hidden" name="ProfissionalServico<?php echo $i ?>" value="<?php echo $servico[$i]['ProfissionalServico'] ?>">
										</div>

										<?php
										$QtdSomaDev+=$servico[$i]['QtdServico'];
										$ServicoSoma++;
										}
										?>
									</div>

									<input type="hidden" name="CountMax2" id="CountMax2" value="<?php echo $ServicoSoma ?>">

								<?php } ?>

											

								<input type="hidden" name="QtdPrdOrca" value="<?php echo $orcatrata['QtdPrdOrca'] ?>">
								<input type="hidden" name="ValorOrca" value="<?php echo $orcatrata['ValorOrca'] ?>">
								<input type="hidden" name="ValorDev" value="<?php echo $orcatrata['ValorDev'] ?>">
								<input type="hidden" name="ValorRestanteOrca" value="<?php echo $orcatrata['ValorRestanteOrca'] ?>">
								<input type="hidden" name="ObsOrca" value="<?php echo $orcatrata['ObsOrca'] ?>">
								<input type="hidden" name="TipoFrete" value="<?php echo $orcatrata['TipoFrete'] ?>">
								
								<input type="hidden" name="Cep" value="<?php echo $orcatrata['Cep'] ?>">
								<input type="hidden" name="Logradouro" value="<?php echo $orcatrata['Logradouro'] ?>">
								<input type="hidden" name="Numero" value="<?php echo $orcatrata['Numero'] ?>">
								<input type="hidden" name="Complemento" value="<?php echo $orcatrata['Complemento'] ?>">
								<input type="hidden" name="Bairro" value="<?php echo $orcatrata['Bairro'] ?>">
								<input type="hidden" name="Cidade" value="<?php echo $orcatrata['Cidade'] ?>">
								<input type="hidden" name="Estado" value="<?php echo $orcatrata['Estado'] ?>">
								<input type="hidden" name="Referencia" value="<?php echo $orcatrata['Referencia'] ?>">
								
								<input type="hidden" name="ValorFrete" value="<?php echo $orcatrata['ValorFrete'] ?>">
								<input type="hidden" name="CombinadoFrete" value="<?php echo $orcatrata['CombinadoFrete'] ?>">
								<input type="hidden" name="ValorTotalOrca" value="<?php echo $orcatrata['ValorTotalOrca'] ?>">
								<input type="hidden" name="PrazoEntrega" value="<?php echo $orcatrata['PrazoEntrega'] ?>">
								<input type="hidden" name="DataEntregaOrca" value="<?php echo $orcatrata['DataEntregaOrca'] ?>">
								<input type="hidden" name="HoraEntregaOrca" value="<?php echo $orcatrata['HoraEntregaOrca'] ?>">
								
							</div>	
							<input type="hidden" name="AVAP" value="<?php echo $orcatrata['AVAP'] ?>">
							<input type="hidden" name="FormaPagamento" value="<?php echo $orcatrata['FormaPagamento'] ?>">
							<input type="hidden" name="ValorDinheiro" value="<?php echo $orcatrata['ValorDinheiro'] ?>">
							<input type="hidden" name="ValorTroco" value="<?php echo $orcatrata['ValorTroco'] ?>">
							
							<input type="hidden" name="QtdParcelasOrca" value="<?php echo $orcatrata['QtdParcelasOrca'] ?>">
							<input type="hidden" name="DataVencimentoOrca" value="<?php echo $orcatrata['DataVencimentoOrca'] ?>">
							<input type="hidden" name="Modalidade" value="<?php echo $orcatrata['Modalidade'] ?>">

							<input type="hidden" name="PRCount" id="PRCount" value="<?php echo $count['PRCount']; ?>"/>
							
							<div class="input_fields_wrap21">

								<?php
								for ($i=1; $i <= $count['PRCount']; $i++) {
								?>

									<?php if ($metodo > 1) { ?>
									<input type="hidden" name="idApp_Parcelas<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['idApp_Parcelas']; ?>"/>
									<?php } ?>

									<div id="21div<?php echo $i ?>">		
										<input type="hidden" name="Parcela<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['Parcela'] ?>">
										<input type="hidden" name="ValorParcela<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['ValorParcela'] ?>">
										<input type="hidden" name="DataVencimento<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['DataVencimento'] ?>">																
										<input type="hidden" name="Quitado<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['Quitado'] ?>">
										<input type="hidden" name="idSis_Usuario<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['idSis_Usuario'] ?>">
									</div>

								<?php
								}
								?>
							</div>
							
							
							<div class="panel panel-info">
								<div class="panel-heading">		
									<!-- Corrigir o nome do cliente-->
																	
									<!--<h5 class="text-left"><b>Cliente</b>: <?php echo '' . $_SESSION['Cliente']['NomeCliente'] . ' - ' . $_SESSION['Cliente']['idApp_Cliente'] . '' ?></h5>-->
									
									<h4 class="text-left"><b>Cliente</b>: <?php echo '' . $orcatrata['NomeCliente'] . '' ?> - <?php echo '' . $orcatrata['idApp_Cliente'] . '' ?></h4>
									
									<table class="table table-bordered table-condensed table-striped">
										<thead>
											<tr>
												
												<th class="col-md-2" scope="col">Data</th>
												<th class="col-md-8" scope="col">Desc.</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												
												<td><?php echo $orcatrata['DataOrca'] ?></td>
												<td><?php echo $orcatrata['Descricao'] ?></td>
											</tr>
										</tbody>
									</table>
									
									<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
									<?php if( isset($count['PCount']) ) { ?>
									<h4 class="text-left"><b>Produtos</b></h4>
										
									<table class="table table-bordered table-condensed table-striped">
										<thead>
											<tr>
												<th class="col-md-2" scope="col">Qtd</th>																																
												<th class="col-md-6" scope="col">Produto</th>							
												<th class="col-md-1" scope="col">Valor</th>
												<th class="col-md-1" scope="col">Subtotal</th>
											</tr>	
											<!--
											<tr>
												<th class="col-md-2" scope="col"></th>
												<th class="col-md-6" scope="col">Data / Obs.:</th>	
												<th class="col-md-1" scope="col"></th>
												<th class="col-md-1" scope="col"></th>
											</tr>
											-->
										</thead>

										<tbody>

											<?php
											for ($i=1; $i <= $count['PCount']; $i++) {
												#echo $produto[$i]['QtdProduto'];
											?>

											<tr>
												<td><?php echo $produto[$i]['QtdProduto'] ?> X <?php echo $produto[$i]['QtdIncrementoProduto'] ?> = <b><?php echo $produto[$i]['SubTotalQtd'] ?></b></td>
												<td><?php echo $produto[$i]['Produto'] ?></td>							
												<td><?php echo number_format($produto[$i]['ValorProduto'], 2, ',', '.') ?></td>
												<td><?php echo number_format($produto[$i]['Subtotal_Produto'], 2, ',', '.') ?></td>
											</tr>						
											<!--
											<tr>
												<td></td>
												<td>Data: <?php echo $produto[$i]['DataValidadeProduto'] ?> - Obs: <?php echo $produto[$i]['ObsProduto'] ?></td>
												<td>Ent: <?php echo $produto[$i]['ConcluidoProduto'] ?></td>
												<td>Dev: <?php echo $produto[$i]['DevolvidoProduto'] ?></td>
											</tr>
											-->
											
											<?php
											}
											?>
											<tr>
												<td class="text-right">Total: <b><?php echo $orcatrata['QtdPrdOrca'] ?></b></td>
											</tr>
										</tbody>
									</table>
									<?php } else echo '<h3 class="text-left">S/Produtos Entregues </h3>';{?>
									<?php } ?>
									<?php } ?>
									
									<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
									<?php if( isset($count['SCount']) ) { ?>							
									<h4 class="text-left"><b>Serviços</b></h4>
									<table class="table table-bordered table-condensed table-striped">
										<thead>
											<tr>
												<th class="col-md-2" scope="col">Qtd</th>																															
												<th class="col-md-6" scope="col">Serviço</th>							
												<th class="col-md-1" scope="col">Valor</th>
												<th class="col-md-1" scope="col">Subtotal</th>
											</tr>	
											<!--
											<tr>
												<th class="col-md-2" scope="col"></th>
												<th class="col-md-7" scope="col">Ent-Obs.:</th>	
												<th class="col-md-1" scope="col">Data</th>							
											</tr>
											-->
										</thead>
										<tbody>

											<?php
											for ($i=1; $i <= $count['SCount']; $i++) {
												#echo $produto[$i]['QtdProduto'];
											?>

											<tr>
												<td><?php echo $servico[$i]['QtdServico'] ?></td>																			
												<td><?php echo $servico[$i]['Servico'] ?></td>							
												<td><?php echo number_format($servico[$i]['ValorServico'], 2, ',', '.') ?></td>
												<td><?php echo number_format($servico[$i]['Subtotal_Servico'], 2, ',', '.') ?></td>
											</tr>						
											<!--
											<tr>
												<td></td>
												
												<td><?php echo $servico[$i]['DataValidadeServico'] ?></td>							
											</tr>
											-->
											<?php
											}
											?>

										</tbody>
									</table>
									<?php } else echo '<h3 class="text-left">S/Serviços </h3>';{?>
									<?php } ?>							
									<?php } ?>								
									
									<h4 class="text-left"><b>Entrega</b></h4>
									<table class="table table-bordered table-condensed table-striped">
										<thead>
											<tr>
												<th class="col-md-3" scope="col">Forma</th>
												<th class="col-md-3" scope="col">Ent.</th>
												<th class="col-md-3" scope="col">Data</th>
												<th class="col-md-3" scope="col">Hora</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td><?php echo $orcatrata['TipoFrete'] ?></td>
												<td><?php echo $orcatrata['Nome'] ?></td>
												<!--<td><?php echo number_format($orcatrata['ValorFrete'], 2, ',', '.') ?></td>-->
												<td><?php echo $orcatrata['DataEntregaOrca'] ?></td>
												<td><?php echo $orcatrata['HoraEntregaOrca'] ?></td>
											</tr>
										</tbody>
									</table>
									<table class="table table-bordered table-condensed table-striped">
										<thead>
											<tr>
												<th class="col-md-2" scope="col">Cep</th>
												<th class="col-md-4" scope="col">End.</th>
												<th class="col-md-2" scope="col">Número</th>
												<th class="col-md-4" scope="col">Compl.</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td><?php echo $orcatrata['Cep'] ?></td>
												<td><?php echo $orcatrata['Logradouro'] ?></td>
												<td><?php echo $orcatrata['Numero'] ?></td>
												<td><?php echo $orcatrata['Complemento'] ?></td>
											</tr>
										</tbody>
										<thead>
											<tr>
												<th class="col-md-2" scope="col">Bairro</th>
												<th class="col-md-4" scope="col">Cidade</th>
												<th class="col-md-2" scope="col">Estado</th>
												<th class="col-md-4" scope="col">Ref.</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td><?php echo $orcatrata['Bairro'] ?></td>
												<td><?php echo $orcatrata['Cidade'] ?></td>
												<td><?php echo $orcatrata['Estado'] ?></td>
												<td><?php echo $orcatrata['Referencia'] ?></td>
											</tr>
										</tbody>
									</table>					
									<table class="table table-bordered table-condensed table-striped">
										<thead>
											<tr>
												<th class="col-md-4" scope="col">Nome</th>
												<th class="col-md-4" scope="col">Tel.</th>
												<th class="col-md-4" scope="col">Paren</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td><?php echo $orcatrata['NomeRec'] ?></td>
												<td><?php echo $orcatrata['TelefoneRec'] ?></td>
												<td><?php echo $orcatrata['ParentescoRec'] ?></td>
											</tr>
										</tbody>
										<thead>
											<tr>
												<th class="col-md-4" scope="col">Aux1</th>
												<th class="col-md-4" scope="col">Aux2</th>
												<th class="col-md-4" scope="col">ObsEnt.</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td><?php echo $orcatrata['Aux1Entrega'] ?></td>
												<td><?php echo $orcatrata['Aux2Entrega'] ?></td>
												<td><?php echo $orcatrata['ObsEntrega'] ?></td>
											</tr>
										</tbody>
									</table>

									<h4 class="text-left"><b>Pagamento</b></h4>
									<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
									<table class="table table-bordered table-condensed table-striped">
										<thead>
											<tr>	
												
												<th class="col-md-3" scope="col">Total</th>
												<th class="col-md-3" scope="col">Forma</th>
												<th class="col-md-3" scope="col">TrcP/</th>
												<th class="col-md-3" scope="col">Trc</th>
											</tr>
										</thead>
										<tbody>
											<tr>	
												<td>R$ <?php echo number_format($orcatrata['ValorTotalOrca'], 2, ',', '.') ?></td>
												<td><?php echo $orcatrata['FormaPag'] ?></td>
												<td>R$ <?php echo number_format($orcatrata['ValorDinheiro'], 2, ',', '.') ?></td>
												<td>R$ <?php echo number_format($orcatrata['ValorTroco'], 2, ',', '.') ?></td>
											</tr>
										</tbody>
									</table>
									<?php } ?>
								</div>
							</div>
							<br>	
							<div class="panel panel-info">
								<div class="panel-heading">
									<h4 class="mb-3"><b>Status do Pedido</b></h4>
									<div class="row">
										<div class="col-md-4">
											<div class="panel panel-danger">
												<div class="panel-heading">
													<div class="row">
														<div class="col-md-12 text-left">
															<label for="AprovadoOrca">Aprovado?</label><br>
															<div class="btn-group" data-toggle="buttons">
																<?php
																foreach ($select['AprovadoOrca'] as $key => $row) {
																	if (!$orcatrata['AprovadoOrca'])$orcatrata['AprovadoOrca'] = 'S';

																	($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																	if ($orcatrata['AprovadoOrca'] == $key) {
																		echo ''
																		. '<label class="btn btn-warning active" name="AprovadoOrca_' . $hideshow . '">'
																		. '<input type="radio" name="AprovadoOrca" id="' . $hideshow . '" '
																		. 'autocomplete="off" value="' . $key . '" checked>' . $row
																		. '</label>'
																		;
																	} else {
																		echo ''
																		. '<label class="btn btn-default" name="AprovadoOrca_' . $hideshow . '">'
																		. '<input type="radio" name="AprovadoOrca" id="' . $hideshow . '" '
																		. 'autocomplete="off" value="' . $key . '" >' . $row
																		. '</label>'
																		;
																	}
																}
																?>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-12 text-right">
															<label for="ProntoOrca">Pronto P/Entrega?</label><br>
															<div class="btn-group" data-toggle="buttons">
																<?php
																foreach ($select['ProntoOrca'] as $key => $row) {
																	if (!$orcatrata['ProntoOrca'])
																		$orcatrata['ProntoOrca'] = 'N';

																	($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																	if ($orcatrata['ProntoOrca'] == $key) {
																		echo ''
																		. '<label class="btn btn-warning active" name="ProntoOrca_' . $hideshow . '">'
																		. '<input type="radio" name="ProntoOrca" id="' . $hideshow . '" '
																		. 'autocomplete="off" value="' . $key . '" checked>' . $row
																		. '</label>'
																		;
																	} else {
																		echo ''
																		. '<label class="btn btn-default" name="ProntoOrca_' . $hideshow . '">'
																		. '<input type="radio" name="ProntoOrca" id="' . $hideshow . '" '
																		. 'autocomplete="off" value="' . $key . '" >' . $row
																		. '</label>'
																		;
																	}
																}
																?>
															</div>
														</div>
														<!--
														<div class="col-md-12 text-right">
															<label for="FinalizadoOrca">Finalizado?</label><br>
															<div class="btn-group" data-toggle="buttons">
																<?php
																foreach ($select['FinalizadoOrca'] as $key => $row) {
																	if (!$orcatrata['FinalizadoOrca'])$orcatrata['FinalizadoOrca'] = 'N';

																	($key == 'N') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																	if ($orcatrata['FinalizadoOrca'] == $key) {
																		echo ''
																		. '<label class="btn btn-warning active" name="FinalizadoOrca_' . $hideshow . '">'
																		. '<input type="radio" name="FinalizadoOrca" id="' . $hideshow . '" '
																		. 'autocomplete="off" value="' . $key . '" checked>' . $row
																		. '</label>'
																		;
																	} else {
																		echo ''
																		. '<label class="btn btn-default" name="FinalizadoOrca_' . $hideshow . '">'
																		. '<input type="radio" name="FinalizadoOrca" id="' . $hideshow . '" '
																		. 'autocomplete="off" value="' . $key . '" >' . $row
																		. '</label>'
																		;
																	}
																}
																?>
															</div>
														</div>
														-->
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="panel panel-success">
												<div class="panel-heading">
													<div class="row">
														<div class="col-md-12 text-left">
															<label  for="Entregador">Entregador</label>
															<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?>
																	id="Entregador" name="Entregador">
																<option value="">-- Sel. o Entregador --</option>
																<?php
																foreach ($select['Entregador'] as $key => $row) {
																		#(!$orcatrata['Entregador']) ? $orcatrata['Entregador'] = '1' : FALSE;
																	if ($orcatrata['Entregador'] == $key) {
																		echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																	} else {
																		echo '<option value="' . $key . '">' . $row . '</option>';
																	}
																	}
																?>
															</select>
														</div>
													</div>
													<div class="row">		
														<div class="col-md-12 text-right">
															<label for="EnviadoOrca">Enviado? </label><br>
															<div class="btn-group" data-toggle="buttons">
																<?php
																foreach ($select['EnviadoOrca'] as $key => $row) {
																	(!$orcatrata['EnviadoOrca']) ? $orcatrata['EnviadoOrca'] = 'N' : FALSE;

																	if ($orcatrata['EnviadoOrca'] == $key) {
																		echo ''
																		. '<label class="btn btn-warning active" name="radiobutton_EnviadoOrca" id="radiobutton_EnviadoOrca' .  $key . '">'
																		. '<input type="radio" name="EnviadoOrca" id="radiobuttondinamico" '
																		. 'autocomplete="off" value="' . $key . '" checked>' . $row
																		. '</label>'
																		;
																	} else {
																		echo ''
																		. '<label class="btn btn-default" name="radiobutton_EnviadoOrca" id="radiobutton_EnviadoOrca' .  $key . '">'
																		. '<input type="radio" name="EnviadoOrca" id="radiobuttondinamico" '
																		. 'autocomplete="off" value="' . $key . '" >' . $row
																		. '</label>'
																		;
																	}
																}
																?>
															</div>
														</div>													
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="panel panel-warning">
												<div class="panel-heading">
													<div class="row">
														<div class="col-md-12 text-left">
															<label for="ConcluidoOrca">Prds.Entregues?</label><br>
															<div class="btn-group" data-toggle="buttons">
																<?php
																foreach ($select['ConcluidoOrca'] as $key => $row) {
																	if (!$orcatrata['ConcluidoOrca'])$orcatrata['ConcluidoOrca'] = 'N';

																	($key == 'N') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																	if ($orcatrata['ConcluidoOrca'] == $key) {
																		echo ''
																		. '<label class="btn btn-warning active" name="ConcluidoOrca_' . $hideshow . '">'
																		. '<input type="radio" name="ConcluidoOrca" id="' . $hideshow . '" '
																		. 'autocomplete="off" value="' . $key . '" checked>' . $row
																		. '</label>'
																		;
																	} else {
																		echo ''
																		. '<label class="btn btn-default" name="ConcluidoOrca_' . $hideshow . '">'
																		. '<input type="radio" name="ConcluidoOrca" id="' . $hideshow . '" '
																		. 'autocomplete="off" value="' . $key . '" >' . $row
																		. '</label>'
																		;
																	}
																}
																?>
															</div>
														</div>
													</div>
													<div class="row">		
														<div class="col-md-12 text-right">
															<label for="QuitadoOrca">Prds.Pagos?</label><br>
															<div class="btn-group" data-toggle="buttons">
																<?php
																foreach ($select['QuitadoOrca'] as $key => $row) {
																	if (!$orcatrata['QuitadoOrca'])
																		$orcatrata['QuitadoOrca'] = 'N';

																	($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																	if ($orcatrata['QuitadoOrca'] == $key) {
																		echo ''
																		. '<label class="btn btn-warning active" name="QuitadoOrca_' . $hideshow . '">'
																		. '<input type="radio" name="QuitadoOrca" id="' . $hideshow . '" '
																		. 'autocomplete="off" value="' . $key . '" checked>' . $row
																		. '</label>'
																		;
																	} else {
																		echo ''
																		. '<label class="btn btn-default" name="QuitadoOrca_' . $hideshow . '">'
																		. '<input type="radio" name="QuitadoOrca" id="' . $hideshow . '" '
																		. 'autocomplete="off" value="' . $key . '" >' . $row
																		. '</label>'
																		;
																	}
																}
																?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>	
									<!--
									<div class="form-group ">
										<div class="row">
											<div class="col-md-4">
												<div id="ConcluidoOrca" <?php echo $div['ConcluidoOrca']; ?>>	
													<label for="DataConclusao">Concluído em:</label>
													<div class="input-group <?php echo $datepicker; ?>">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
														<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
															   name="DataConclusao" value="<?php echo $orcatrata['DataConclusao']; ?>">
													</div>
													
												</div>
											</div>
											<div class="col-md-4">
												<div id="QuitadoOrca" <?php echo $div['QuitadoOrca']; ?>>	
													<label for="DataQuitado">Quitado em:</label>
													<div class="input-group <?php echo $datepicker; ?>">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
														<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
															   name="DataQuitado" value="<?php echo $orcatrata['DataQuitado']; ?>">																				
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-md-3">
												<label for="DataRetorno">Retornar em:</label>
												<div class="input-group <?php echo $datepicker; ?>">
													<span class="input-group-addon" disabled>
														<span class="glyphicon glyphicon-calendar"></span>
													</span>
													<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
														   name="DataRetorno" value="<?php echo $orcatrata['DataRetorno']; ?>">
												</div>
											</div>
										</div>
									</div>
									-->
								</div>
							</div>
							
							<?php if ($_SESSION['log']['NivelEmpresa'] >= 20 ) { ?>
							<br>
							<div class="panel-group">	
								<div class="panel panel-success">
									<div class="panel-heading text-left">
										<!--
										<a class="btn btn-primary" type="button" data-toggle="collapse" data-target="#Procedimentos" aria-expanded="false" aria-controls="Procedimentos">
											<span class="glyphicon glyphicon-menu-down"></span> Procedimentos
										</a>
										-->
										<div <?php echo $collapse; ?> id="Procedimentos">
											<div class="panel-body">

												<input type="hidden" name="PMCount" id="PMCount" value="<?php echo $count['PMCount']; ?>"/>

												<div class="input_fields_wrap3">

												<?php
												for ($i=1; $i <= $count['PMCount']; $i++) {
												?>

												<?php if ($metodo > 1) { ?>
												<input type="hidden" name="idApp_Procedimento<?php echo $i ?>" value="<?php echo $procedimento[$i]['idApp_Procedimento']; ?>"/>
												<?php } ?>

												<div class="form-group" id="3div<?php echo $i ?>">
													<div class="panel panel-success">
														<div class="panel-heading">
															<div class="row">
																<div class="col-md-4">
																	<label for="Procedimento<?php echo $i ?>">Procedimento <?php echo $i ?>:</label>
																	<textarea class="form-control" id="Procedimento<?php echo $i ?>" <?php echo $readonly; ?>
																			  name="Procedimento<?php echo $i ?>"><?php echo $procedimento[$i]['Procedimento']; ?></textarea>
																</div>
																<div class="col-md-2">
																	<label for="Prioridade<?php echo $i ?>">Prioridade:</label>
																	<?php if ($i == 1) { ?>
																	<?php } ?>
																	<select data-placeholder="Selecione uma opção..." class="form-control" 
																			 id="listadinamicac<?php echo $i ?>" name="Prioridade<?php echo $i ?>">
																		
																		<?php
																		foreach ($select['Prioridade'] as $key => $row) {
																			if ($procedimento[$i]['Prioridade'] == $key) {
																				echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																			} else {
																				echo '<option value="' . $key . '">' . $row . '</option>';
																			}
																		}
																		?>
																	</select>
																</div>
																<div class="col-md-3">
																	<label for="DataProcedimentoLimite<?php echo $i ?>">Limite</label>
																	<div class="input-group <?php echo $datepicker; ?>">
																		<span class="input-group-addon" disabled>
																			<span class="glyphicon glyphicon-calendar"></span>
																		</span>
																		<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																			   name="DataProcedimentoLimite<?php echo $i ?>" value="<?php echo $procedimento[$i]['DataProcedimentoLimite']; ?>">
																	</div>
																</div>
																<div class="col-md-3">
																	<label for="DataProcedimento<?php echo $i ?>">Data do Proced.:</label>
																	<div class="input-group <?php echo $datepicker; ?>">
																		<span class="input-group-addon" disabled>
																			<span class="glyphicon glyphicon-calendar"></span>
																		</span>
																		<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																			   name="DataProcedimento<?php echo $i ?>" value="<?php echo $procedimento[$i]['DataProcedimento']; ?>">
																	</div>
																</div>																
															</div>	
															<div class="row">
																<div class="col-md-6"></div>
																<div class="col-md-3">
																	<label for="idSis_Usuario<?php echo $i ?>">Profissional:</label>
																	<?php if ($i == 1) { ?>
																	<?php } ?>
																	<select data-placeholder="Selecione uma opção..." class="form-control" readonly=""
																			 id="listadinamicac<?php echo $i ?>" name="idSis_Usuario<?php echo $i ?>">
																		<!--<option value="">-- Selecione uma opção --</option>-->
																		<?php
																		foreach ($select['idSis_Usuario'] as $key => $row) {
																			if ($procedimento[$i]['idSis_Usuario'] == $key) {
																				echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																			} else {
																				echo '<option value="' . $key . '">' . $row . '</option>';
																			}
																		}
																		?>
																	</select>
																</div>
																<div class="col-md-2">
																	<label for="ConcluidoProcedimento">Proc. Concl.? </label><br>
																	<div class="form-group">
																		<div class="btn-group" data-toggle="buttons">
																			<?php
																			foreach ($select['ConcluidoProcedimento'] as $key => $row) {
																				(!$procedimento[$i]['ConcluidoProcedimento']) ? $procedimento[$i]['ConcluidoProcedimento'] = 'N' : FALSE;

																				if ($procedimento[$i]['ConcluidoProcedimento'] == $key) {
																					echo ''
																					. '<label class="btn btn-warning active" name="radiobutton_ConcluidoProcedimento' . $i . '" id="radiobutton_ConcluidoProcedimento' . $i .  $key . '">'
																					. '<input type="radio" name="ConcluidoProcedimento' . $i . '" id="radiobuttondinamico" '
																					. 'autocomplete="off" value="' . $key . '" checked>' . $row
																					. '</label>'
																					;
																				} else {
																					echo ''
																					. '<label class="btn btn-default" name="radiobutton_ConcluidoProcedimento' . $i . '" id="radiobutton_ConcluidoProcedimento' . $i .  $key . '">'
																					. '<input type="radio" name="ConcluidoProcedimento' . $i . '" id="radiobuttondinamico" '
																					. 'autocomplete="off" value="' . $key . '" >' . $row
																					. '</label>'
																					;
																				}
																			}
																			?>
																		</div>
																	</div>
																</div>
																<div class="col-md-1">
																	<label><br></label><br>
																	<button type="button" id="<?php echo $i ?>" class="remove_field3 btn btn-danger">
																		<span class="glyphicon glyphicon-trash"></span>
																	</button>
																</div>
															</div>
														</div>
													</div>
												</div>

												<?php
												}
												?>

												</div>
												<div class="row">
													<div class="col-md-4">
														<a class="add_field_button3 btn btn btn-warning" onclick="adicionaProcedimento()">
															<span class="glyphicon glyphicon-plus"></span> Adic. Procedimento
														</a>
													</div>
												</div>
											</div>
										</div>
									</div>	
								</div>
							</div>
							<?php } ?>
							<br>
							<div class="panel panel-info">
								<div class="panel-heading">
									<input type="hidden" name="idApp_OrcaTrata" value="<?php echo $orcatrata['idApp_OrcaTrata']; ?>">
									<!--<input type="hidden" name="idApp_Cliente" value="<?php echo $_SESSION['Cliente']['idApp_Cliente']; ?>">-->
									<h4 class="mb-3"><b>Pedido</b></h4>
									<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) || ($_SESSION['log']['idSis_Empresa'] == 5))  { ?>
										<div class="row">
											<div class="col-md-8">
												<?php if ($metodo > 1) { ?>
												<!--<input type="hidden" name="idApp_Procedimento" value="<?php echo $procedimento['idApp_Procedimento']; ?>">
												<input type="hidden" name="idApp_ParcelasRec" value="<?php echo $parcelasrec['idApp_ParcelasRec']; ?>">-->
												<?php } ?>
												<?php if ($metodo == 2) { ?>

													<div class="col-md-6">
														<label></label>
														<!--
														<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
															<span class="glyphicon glyphicon-save"></span> Salvar
														</button>
														-->
														<button type="submit" class="btn btn-lg btn-primary" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." value="1" >
															<span class="glyphicon glyphicon-save"></span> Salvar
														</button>														
													</div>
													<div class="col-md-6 text-right">
														<label></label>
														<button  type="button" class="btn btn-md btn-danger" name="submeter2" id="submeter2" onclick="DesabilitaBotao(this.name)" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
															<span class="glyphicon glyphicon-trash"></span> Excluir
														</button>
													</div>

													<div class="modal fade bs-excluir-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
														<div class="modal-dialog" role="document">
															<div class="modal-content">
																<div class="modal-header bg-danger">
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																	<h4 class="modal-title">Tem certeza que deseja excluir?</h4>
																</div>
																<div class="modal-body">
																	<p>Ao confirmar esta operação todos os dados serão excluídos permanentemente do sistema.
																		Esta operação é irreversível.</p>
																</div>
																<div class="modal-footer">
																	<div class="col-md-6 text-left">
																		<button type="button" class="btn btn-warning" name="submeter4" id="submeter4" onclick="DesabilitaBotao()" data-dismiss="modal">
																			<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
																		</button>
																	</div>
																	<div class="col-md-6 text-right">
																		<a class="btn btn-danger" name="submeter3" id="submeter3" onclick="DesabilitaBotaoExcluir(this.name)" href="<?php echo base_url() . 'orcatrata/excluir2/' . $orcatrata['idApp_OrcaTrata'] ?>" role="button">
																			<span class="glyphicon glyphicon-trash"></span> Confirmar Exclusão
																		</a>
																	</div>
																</div>
															</div>
														</div>
													</div>
												<?php } else { ?>
													<div class="col-md-6 text-left">
														<label></label>
														<!--
														<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
															<span class="glyphicon glyphicon-save"></span> Salvar
														</button>
														-->
														<button type="submit" class="btn btn-lg btn-primary" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name),calculaQtdSoma('QtdProduto','QtdSoma','ProdutoSoma',0,0,'CountMax',1,0)" data-loading-text="Aguarde..." value="1" >
															<span class="glyphicon glyphicon-save"></span> Salvar
														</button>														
													</div>
												<?php } ?>
												
												
											</div>
										
											<div class="col-md-4">
												<div class="panel panel-primary">
													<div class="panel-heading">
														<div class="row">
															<div class="col-md-12 text-left">
																<label for="CanceladoOrca">Cancelado?</label><br>
																<div class="btn-group" data-toggle="buttons">
																	<?php
																	foreach ($select['CanceladoOrca'] as $key => $row) {
																		if (!$orcatrata['CanceladoOrca'])$orcatrata['CanceladoOrca'] = 'N';

																		($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																		if ($orcatrata['CanceladoOrca'] == $key) {
																			echo ''
																			. '<label class="btn btn-warning active" name="CanceladoOrca_' . $hideshow . '">'
																			. '<input type="radio" name="CanceladoOrca" id="' . $hideshow . '" '
																			. 'autocomplete="off" value="' . $key . '" checked>' . $row
																			. '</label>'
																			;
																		} else {
																			echo ''
																			. '<label class="btn btn-default" name="CanceladoOrca_' . $hideshow . '">'
																			. '<input type="radio" name="CanceladoOrca" id="' . $hideshow . '" '
																			. 'autocomplete="off" value="' . $key . '" >' . $row
																			. '</label>'
																			;
																		}
																	}
																	?>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										
										</div>
									<?php } ?>
								</div>
							</div>							
						</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="col-md-4">
	<div class="panel panel-info ">
		<div class="panel-heading">
			<div class="text-center" type="button" data-toggle="collapse" data-target="#StatusOrç" aria-expanded="false" aria-controls="StatusOrç">
				 <h4><b>Status dos Pedidos</b></h4>
			</div>		
		
			<div <?php echo $collapse; ?> id="StatusOrç">
						
					<div class="row">
					<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>	
						<div class="col-md-12">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<div type="button" data-toggle="collapse" data-target="#Combinar" aria-expanded="false" aria-controls="Combinar">
										 Aguardando <b>Combinar Entrega e Pagamento</b>
									</div>					
								</div>
								<div <?php echo $collapse; ?> id="Combinar">
									<div class="panel-body">

										<?php if (isset($list7)) echo $list7; ?>

									</div>
								</div>	
							</div>
						</div>
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<div type="button" data-toggle="collapse" data-target="#Pagamentoonline" aria-expanded="false" aria-controls="Pagamentoonline">
										 <b>Pagamento OnLine</b>
									</div>					
								</div>
								<div <?php echo $collapse; ?> id="Pagamentoonline">
									<div class="panel-body">

										<?php if (isset($list8)) echo $list8; ?>

									</div>
								</div>	
							</div>
						</div>
						<div class="col-md-12">
							<div class="panel panel-danger">
								<div class="panel-heading">
									<div type="button" data-toggle="collapse" data-target="#NaoEntreguesBalcao" aria-expanded="false" aria-controls="NaoEntreguesBalcao">
										 Aguardando <b>Produção</b>
									</div>					
								</div>
								<div <?php echo $collapse; ?> id="NaoEntreguesBalcao">
									<div class="panel-body">

										<?php if (isset($list1)) echo $list1; ?>

									</div>
								</div>	
							</div>
						</div>
						<div class="col-md-12">
							<div class="panel panel-success">
								<div class="panel-heading">
									<div type="button" data-toggle="collapse" data-target="#NaoDevolvidos" aria-expanded="false" aria-controls="NaoDevolvidos">
										Aguardando <b>Envio</b>
									</div>			
								</div>
								<div <?php echo $collapse; ?> id="NaoDevolvidos">				
									<div class="panel-body">

										<?php if (isset($list3)) echo $list3; ?>

									</div>
								</div>	
							</div>
						</div>
						<div class="col-md-12">
							<div class="panel panel-warning">
								<div class="panel-heading">
									<div type="button" data-toggle="collapse" data-target="#NaoEntreguesOnline" aria-expanded="false" aria-controls="NaoEntreguesOnline">
										Aguardando <b>Entrega</b>
									</div>					
								</div>
								<div <?php echo $collapse; ?> id="NaoEntreguesOnline">
									<div class="panel-body">

										<?php if (isset($list5)) echo $list5; ?>

									</div>
								</div>	
							</div>
						</div>
						<div class="col-md-12">
							<div class="panel panel-warning">
								<div class="panel-heading">
									<div type="button" data-toggle="collapse" data-target="#NaoDevolvidosOnline" aria-expanded="false" aria-controls="NaoDevolvidosOnline">
										Aguardando <b>Pagamento</b>
									</div>			
								</div>
								<div <?php echo $collapse; ?> id="NaoDevolvidosOnline">				
									<div class="panel-body">

										<?php if (isset($list6)) echo $list6; ?>

									</div>
								</div>	
							</div>
						</div>
						<!--
						<div class="col-md-12">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<div class=" btn btn-info" type="button" data-toggle="collapse" data-target="#NaoRecebidos" aria-expanded="false" aria-controls="NaoRecebidos">
										<span class="glyphicon glyphicon-chevron-up"></span> Não Recebidos
									</div>
									<a class="btn btn-md btn-warning" href="<?php #echo base_url() ?>relatorio/fiadorec" role="button">
										<span class="glyphicon glyphicon-search"></span> Fiado
									</a>
								</div>
								<div <?php #echo $collapse1; ?> id="NaoRecebidos">	
									<div class="panel-body">

										<?php #if (isset($list2)) echo $list2; ?>

									</div>
								</div>	
							</div>
						</div>
						-->	
					<?php } else { ?>
							
						<div class="col-md-12">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<div class=" btn btn-info" type="button" data-toggle="collapse" data-target="#NaoRecebidos" aria-expanded="false" aria-controls="NaoRecebidos">
										Resumo <span class="glyphicon glyphicon-chevron-down"></span>
									</div>					
									<a class="btn btn-md btn-warning" href="<?php echo base_url() ?>relatorio/parcelasrec" role="button">
										<span class="glyphicon glyphicon-search"></span> Rel. das Receitas
									</a>					
								</div>
								<div <?php echo $collapse1; ?> id="NaoRecebidos">
									<div class="panel-body">

										<?php if (isset($list4)) echo $list4; ?>

									</div>
								</div>	
							</div>
						</div>
						
					<?php } ?>
					</div>
									
			</div>	
		</div>
	</div>		
</div>
