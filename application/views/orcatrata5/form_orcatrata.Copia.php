<?php if (isset($msg)) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Consultor'])) { ?>

<div class="container-fluid">
	<div class="row">

		<div class="col-md-1"></div>
		<div class="col-md-10 ">

					<nav class="navbar navbar-inverse">
					  <div class="container-fluid">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span> 
							</button>
							<a class="navbar-brand" href="<?php echo base_url() . 'consultor/prontuario/' . $_SESSION['Consultor']['idApp_Consultor']; ?>">
								<?php echo '<small>' . $_SESSION['Consultor']['NomeConsultor'] . '</small> - <small>' . $_SESSION['Consultor']['idApp_Consultor'] . '</small>' ?> 
							</a>
						</div>
						<div class="collapse navbar-collapse" id="myNavbar">

							<ul class="nav navbar-nav navbar-center">
								<li>
									<a href="<?php echo base_url() . 'consultor/alterar/' . $_SESSION['Consultor']['idApp_Consultor']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Edit. Consultor
									</a>
								</li>
								<li>
									<a href="<?php echo base_url() . 'orcatrata/listar/' . $_SESSION['Consultor']['idApp_Consultor']; ?>">
										<span class="glyphicon glyphicon-usd"></span> Listar Or�ams.
									</a>
								</li>
								<li>
									<a href="<?php echo base_url() . 'orcatrata/cadastrar/' . $_SESSION['Consultor']['idApp_Consultor']; ?>">
										<span class="glyphicon glyphicon-plus"></span> Cad. Or�am.
									</a>
								</li>
							</ul>

						</div>
					  </div>
					</nav>

					<?php } ?>
					<div class="row">

						<div class="col-md-12 col-lg-12">
							<?php echo validation_errors(); ?>

							<div class="panel panel-<?php echo $panel; ?>">

								<div class="panel-heading"><strong>Or�amentos</strong></div>
								<div class="panel-body">

									<?php echo form_open_multipart($form_open_path); ?>

									<div class="panel-group" id="accordion1" role="tablist" aria-multiselectable="true">
										<div class="panel panel-primary">
											<div class="panel-heading collapsed" role="tab" id="heading1" data-toggle="collapse" data-parent="#accordion1" data-target="#collapse1" aria-expanded="false">								<h4 class="panel-title">
													<a class="accordion-toggle">
														<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
														Produtos & Servi�os
													</a>
												</h4>
											</div>

											<div id="collapse1" class="panel-collapse " role="tabpanel" aria-labelledby="heading1" aria-expanded="false">
												<div class="panel-body">
													<!--#######################################-->														
													<div class="panel-group" id="accordion5" role="tablist" aria-multiselectable="true">
														<div class="panel panel-success">
															<div class="panel-heading collapsed" role="tab" id="heading5" data-toggle="collapse" data-parent="#accordion5" data-target="#collapse5" aria-expanded="false">								
																<h4 class="panel-title">
																	<a class="accordion-toggle">
																		<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
																		Entregues
																	</a>
																</h4>
															</div>

															<div id="collapse5" class="panel-collapse " role="tabpanel" aria-labelledby="heading5" aria-expanded="false">
																<div class="panel-body">
																	<input type="hidden" name="PCount" id="PCount" value="<?php echo $count['PCount']; ?>"/>

																	<div class="input_fields_wrap9">

																	<?php
																	$QtdSoma = $ProdutoSoma = 0;
																	for ($i=1; $i <= $count['PCount']; $i++) {
																	?>

																	<?php if ($metodo > 1) { ?>
																	<input type="hidden" name="idApp_ProdutoVenda<?php echo $i ?>" value="<?php echo $produto[$i]['idApp_ProdutoVenda']; ?>"/>
																	<?php } ?>

																	<input type="hidden" name="ProdutoHidden" id="ProdutoHidden<?php echo $i ?>" value="<?php echo $i ?>">

																	<div class="form-group" id="9div<?php echo $i ?>">
																		<div class="panel panel-info">
																			<div class="panel-heading">
																				<div class="row">
																					<div class="col-md-1">
																						<label for="QtdVendaProduto">Qtd<?php echo $i ?>:</label>
																						<input type="text" class="form-control Numero" maxlength="3" id="QtdVendaProduto<?php echo $i ?>" placeholder="0"
																								onkeyup="calculaSubtotal(this.value,this.name,'<?php echo $i ?>','QTD','Produto'),calculaQtdSoma('QtdVendaProduto','QtdSoma','ProdutoSoma',0,0,'CountMax',0,'ProdutoHidden')"
																								autofocus name="QtdVendaProduto<?php echo $i ?>" value="<?php echo $produto[$i]['QtdVendaProduto'] ?>">
																					</div>
																					<div class="col-md-7">
																						<label for="idTab_Produto">Produto:</label>
																						<?php if ($i == 1) { ?>
																						<!--<a class="btn btn-xs btn-info" href="<?php echo base_url() ?>produto/cadastrar/produto" role="button">
																							<span class="glyphicon glyphicon-plus"></span> <b>Novo Produto</b>
																						</a>-->
																						<?php } ?>
																						<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" onchange="buscaValor2Tabelas(this.value,this.name,'Valor',<?php echo $i ?>,'Produto')" <?php echo $readonly; ?>
																								 id="listadinamicab<?php echo $i ?>" name="idTab_Produto<?php echo $i ?>">
																							<option value="">-- Selecione uma op��o --</option>
																							<?php
																							foreach ($select['Produto'] as $key => $row) {
																								if ($produto[$i]['idTab_Produto'] == $key) {
																									echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																								} else {
																									echo '<option value="' . $key . '">' . $row . '</option>';
																								}
																							}
																							?>
																						</select>
																					</div>

																					<div class="col-md-2">
																						<label for="ValorVendaProduto">Valor do Produto:</label>
																						<div class="input-group">
																							<span class="input-group-addon" id="basic-addon1">R$</span>
																							<input type="text" class="form-control Valor" id="idTab_Produto<?php echo $i ?>" maxlength="10" placeholder="0,00"
																								onkeyup="calculaSubtotal(this.value,this.name,'<?php echo $i ?>','VP','Produto')"
																								name="ValorVendaProduto<?php echo $i ?>" value="<?php echo $produto[$i]['ValorVendaProduto'] ?>">
																						</div>
																					</div>
																					<div class="col-md-2">
																						<label for="SubtotalProduto">Subtotal:</label>
																						<div class="input-group">
																							<span class="input-group-addon" id="basic-addon1">R$</span>
																							<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" readonly="" id="SubtotalProduto<?php echo $i ?>"
																								   name="SubtotalProduto<?php echo $i ?>" value="<?php echo $produto[$i]['SubtotalProduto'] ?>">
																						</div>
																					</div>
																				</div>
																				<div class="row">
																					<div class="col-md-1"></div>
																					<div class="col-md-7">
																						<label for="ObsProduto<?php echo $i ?>">Obs:</label><br>
																						<input type="text" class="form-control" id="ObsProduto<?php echo $i ?>" maxlength="250"
																							   name="ObsProduto<?php echo $i ?>" value="<?php echo $produto[$i]['ObsProduto'] ?>">
																					</div>
																					<div class="col-md-2">
																						<label for="DataValidadeProduto<?php echo $i ?>">Val. do Produto:</label>
																						<div class="input-group <?php echo $datepicker; ?>">
																							<span class="input-group-addon" disabled>
																								<span class="glyphicon glyphicon-calendar"></span>
																							</span>
																							<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																								   name="DataValidadeProduto<?php echo $i ?>" value="<?php echo $produto[$i]['DataValidadeProduto']; ?>">
																							
																						</div>
																					</div>
																					<div class="col-md-1">
																						<label><br></label><br>
																						<button type="button" id="<?php echo $i ?>" class="remove_field9 btn btn-danger"
																								onclick="calculaQtdSoma('QtdVendaProduto','QtdSoma','ProdutoSoma',1,<?php echo $i ?>,'CountMax',0,'ProdutoHidden')">
																							<span class="glyphicon glyphicon-trash"></span>
																						</button>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>

																	<?php
																	$QtdSoma+=$produto[$i]['QtdVendaProduto'];
																	$ProdutoSoma++;
																	}
																	?>

																	</div>

																	<div class="panel panel-success">
																		<div class="panel-heading text-left">
																			<div class="form-group">
																				<div class="row">
																					<br>
																					<div class="col-md-3">
																						<a class="add_field_button9 btn btn-success"
																								onclick="calculaQtdSoma('QtdVendaProduto','QtdSoma','ProdutoSoma',0,0,'CountMax',1,0)">
																							<span class="glyphicon glyphicon-plus"></span> Adic. Prod. Entregues
																						</a>
																					</div>
																					<div class="col-md-2">	
																						<b>Linhas: <span id="ProdutoSoma"><?php echo $ProdutoSoma ?></span></b><br />
																					</div>
																					<div class="col-md-3">	
																						<b>Prod. Entregues: <span id="QtdSoma"><?php echo $QtdSoma ?></span></b>
																					</div>
																					<div class="col-md-3 text-left">																							
																						<a class="accordion-toggle btn btn-heading  collapsed" role="tab" id="heading5" data-toggle="collapse" data-parent="#accordion5" data-target="#collapse5" aria-expanded="false">
																							<span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span>
																							Entregues
																						</a>																							
																					</div>
																				</div>
																			</div>																
																		</div>
																	</div>
																	<input type="hidden" name="CountMax" id="CountMax" value="<?php echo $ProdutoSoma ?>">
																</div>
															</div>
														</div>
													</div>	
													<div class="panel-group" id="accordion6" role="tablist" aria-multiselectable="true">
														<div class="panel panel-danger">
															<div class="panel-heading collapsed" role="tab" id="heading6" data-toggle="collapse" data-parent="#accordion6" data-target="#collapse6" aria-expanded="false">
																<h4 class="panel-title">
																	<a class="accordion-toggle">
																		<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
																		Devolvidos
																	</a>
																</h4>
															</div>

															<div id="collapse6" class="panel-collapse " role="tabpanel" aria-labelledby="heading6" aria-expanded="false">
																<div class="panel-body">
																															
																	<input type="hidden" name="SCount" id="SCount" value="<?php echo $count['SCount']; ?>"/>

																	<div class="input_fields_wrap10">

																	<?php
																	$QtdSomaDev = $ServicoSoma = 0;
																	for ($i=1; $i <= $count['SCount']; $i++) {
																	?>

																	<?php if ($metodo > 1) { ?>
																	<input type="hidden" name="idApp_ServicoVenda<?php echo $i ?>" value="<?php echo $servico[$i]['idApp_ServicoVenda']; ?>"/>
																	<?php } ?>

																	<input type="hidden" name="ServicoHidden" id="ServicoHidden<?php echo $i ?>" value="<?php echo $i ?>">
																	
																	<div class="form-group" id="10div<?php echo $i ?>">
																		<div class="panel panel-danger">
																			<div class="panel-heading">
																				<div class="row">
																					<div class="col-md-1">
																						<label for="QtdVendaServico">Qtd:</label>
																						<input type="text" class="form-control Numero" maxlength="3" id="QtdVendaServico<?php echo $i ?>" placeholder="0"
																								onkeyup="calculaSubtotalDev(this.value,this.name,'<?php echo $i ?>','QTD','Servico'),calculaQtdSomaDev('QtdVendaServico','QtdSomaDev','ServicoSoma',0,0,'CountMax2',0,'ServicoHidden')"
																								autofocus name="QtdVendaServico<?php echo $i ?>" value="<?php echo $servico[$i]['QtdVendaServico'] ?>">
																					</div>
																					<div class="col-md-7">
																						<label for="idTab_Servico">Produto:</label>
																						<?php if ($i == 1) { ?>
																						<!--<a class="btn btn-xs btn-info" href="<?php echo base_url() ?>servico/cadastrar/servico" role="button">
																							<span class="glyphicon glyphicon-plus"></span> <b>Novo Servi�o</b>
																						</a>-->
																						<?php } ?>
																						<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" onchange="buscaValorDevTabelas(this.value,this.name,'Valor',<?php echo $i ?>,'Produto')" <?php echo $readonly; ?>
																								id="listadinamica<?php echo $i ?>" name="idTab_Servico<?php echo $i ?>">																					
																							<option value="">-- Selecione uma op��o --</option>
																							<?php
																							foreach ($select['Servico'] as $key => $row) {
																								if ($servico[$i]['idTab_Servico'] == $key) {
																									echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																								} else {
																									echo '<option value="' . $key . '">' . $row . '</option>';
																								}
																							}
																							?>
																						</select>
																					</div>
																					<div class="col-md-2">
																						<label for="ValorVendaServico">Valor do Produto:</label>
																						<div class="input-group">
																							<span class="input-group-addon" id="basic-addon1">R$</span>
																							<input type="text" class="form-control Valor" id="idTab_Servico<?php echo $i ?>" maxlength="10" placeholder="0,00"
																								onkeyup="calculaSubtotalDev(this.value,this.name,'<?php echo $i ?>','VP','Servico')"
																								name="ValorVendaServico<?php echo $i ?>" value="<?php echo $servico[$i]['ValorVendaServico'] ?>">
																						</div>
																					</div>
																					<div class="col-md-2">
																						<label for="SubtotalServico">Subtotal:</label>
																						<div class="input-group">
																							<span class="input-group-addon" id="basic-addon1">R$</span>
																							<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" readonly="" id="SubtotalServico<?php echo $i ?>"
																								   name="SubtotalServico<?php echo $i ?>" value="<?php echo $servico[$i]['SubtotalServico'] ?>">
																						</div>
																					</div>
																				</div>
																				<div class="row">
																					<div class="col-md-1"></div>
																					<div class="col-md-7">
																						<label for="ObsServico<?php echo $i ?>">Obs:</label><br>
																						<input type="text" class="form-control" id="ObsServico<?php echo $i ?>" maxlength="250"
																							   name="ObsServico<?php echo $i ?>" value="<?php echo $servico[$i]['ObsServico'] ?>">
																					</div>
																					<div class="col-md-2">
																						<label for="DataValidadeServico<?php echo $i ?>">Valid. do Prod.:</label>
																						<div class="input-group <?php echo $datepicker; ?>">
																							<span class="input-group-addon" disabled>
																								<span class="glyphicon glyphicon-calendar"></span>
																							</span>
																							<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																								   name="DataValidadeServico<?php echo $i ?>" value="<?php echo $servico[$i]['DataValidadeServico']; ?>">																				
																						</div>
																					</div>
																					<!--
																					<div class="col-md-3">
																						<label for="ConcluidoServico">Conclu�do? </label><br>
																						<div class="form-group">
																							<div class="btn-group" data-toggle="buttons">
																								<?php
																								foreach ($select['ConcluidoServico'] as $key => $row) {
																									(!$servico[$i]['ConcluidoServico']) ? $servico[$i]['ConcluidoServico'] = 'N' : FALSE;

																									if ($servico[$i]['ConcluidoServico'] == $key) {
																										echo ''
																										. '<label class="btn btn-warning active" name="radiobutton_ConcluidoServico' . $i . '" id="radiobutton_ConcluidoServico' . $i .  $key . '">'
																										. '<input type="radio" name="ConcluidoServico' . $i . '" id="radiobuttondinamico" '
																										. 'autocomplete="off" value="' . $key . '" checked>' . $row
																										. '</label>'
																										;
																									} else {
																										echo ''
																										. '<label class="btn btn-default" name="radiobutton_ConcluidoServico' . $i . '" id="radiobutton_ConcluidoServico' . $i .  $key . '">'
																										. '<input type="radio" name="ConcluidoServico' . $i . '" id="radiobuttondinamico" '
																										. 'autocomplete="off" value="' . $key . '" >' . $row
																										. '</label>'
																										;
																									}
																								}
																								?>
																							</div>
																						</div>
																					</div>
																					-->
																					<div class="col-md-1">
																						<label><br></label><br>
																						<button type="button" id="<?php echo $i ?>" class="remove_field10 btn btn-danger"
																							onclick="calculaQtdSomaDev('QtdVendaServico','QtdSomaDev','ServicoSoma',1,<?php echo $i ?>,'CountMax2',0,'ServicoHidden')">
																							<span class="glyphicon glyphicon-trash"></span>
																						</button>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>

																	<?php
																	$QtdSomaDev+=$servico[$i]['QtdVendaServico'];
																	$ServicoSoma++;
																	}
																	?>

																	</div>
																	
																	<div class="panel panel-danger">
																		<div class="panel-heading text-left">
																			<div class="form-group">	
																				<div class="row">	
																					<br>																
																					<div class="col-md-3 text-left">
																						<a class="add_field_button10  btn btn-danger" 
																								onclick="calculaQtdSomaDev('QtdVendaServico','QtdSomaDev','ServicoSoma',0,0,'CountMax2',1,0)">
																							<span class="glyphicon glyphicon-minus"></span> Retr. Prod. Devolvidos
																						</a>
																					</div>
																					<div class="col-md-2">	
																						<b>Linhas: <span id="ServicoSoma"><?php echo $ServicoSoma ?></span></b><br />
																					</div>
																					<div class="col-md-3">	
																						<b>Prod. Devolvidos: <span id="QtdSomaDev"><?php echo $QtdSomaDev ?></span></b>
																					</div>
																					<div class="col-md-3 text-left">																							
																						<a class="accordion-toggle btn btn-heading  collapsed" role="tab" id="heading6" data-toggle="collapse" data-parent="#accordion6" data-target="#collapse6" aria-expanded="false">
																							<span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span>
																							Devolvidos
																						</a>																							
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																	<input type="hidden" name="CountMax2" id="CountMax2" value="<?php echo $ServicoSoma ?>">
																</div>
															</div>
														</div>
													</div>
													
												</div>
											</div>
										</div>
									</div>
							<!--#######################################-->
									<div class="panel-group" id="accordion4" role="tablist" aria-multiselectable="true">
										<div class="panel panel-primary">
											<div class="panel-heading collapsed" role="tab" id="heading4" data-toggle="collapse" data-parent="#accordion4" data-target="#collapse4" aria-expanded="false">								<h4 class="panel-title">
													<a class="accordion-toggle">
														<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
														Or�amento & Forma de Pagam.
													</a>
												</h4>
											</div>

											<div id="collapse4" class="panel-collapse" role="tabpanel" aria-labelledby="heading4" aria-expanded="false">
												<div class="panel-body">													
													<div class="panel panel-info">
														<div class="panel-heading">
															<div class="col-md-1"></div>
															<div class="form-group">
																<div class="row">
																	<div class="col-md-2">
																		<label for="ValorOrca">Or�amento:</label><br>
																		<div class="input-group" id="txtHint">
																			<span class="input-group-addon" id="basic-addon1">R$</span>
																			<input type="text" class="form-control Valor" id="ValorOrca" maxlength="10" placeholder="0,00"
																				   onkeyup="calculaResta(this.value)" name="ValorOrca" value="<?php echo $orcatrata['ValorOrca'] ?>">
																		</div>
																	</div>
																	
																	<div class="col-md-2">
																		<label for="ValorDev">Devol./ Desc.:</label><br>
																		<div class="input-group" id="txtHint">
																			<span class="input-group-addon" id="basic-addon1">R$</span>
																			<input type="text" class="form-control Valor" id="ValorDev" maxlength="10" placeholder="0,00"
																				   onkeyup="calculaResta(this.value)" name="ValorDev" value="<?php echo $orcatrata['ValorDev'] ?>">
																		</div>
																	</div>
																	<!--
																	<div class="col-md-3">
																		<label for="ValorEntradaOrca">Desconto</label><br>
																		<div class="input-group" id="txtHint">
																			<span class="input-group-addon" id="basic-addon1">R$</span>
																			<input type="text" class="form-control Valor" id="ValorEntradaOrca" maxlength="10" placeholder="0,00"
																				onkeyup="calculaResta(this.value)"
																				name="ValorEntradaOrca" value="<?php echo $orcatrata['ValorEntradaOrca'] ?>">
																		</div>
																	</div>
																	-->
																	<div class="col-md-2">
																		<label for="ValorRestanteOrca">Resta Pagar:</label><br>
																		<div class="input-group" id="txtHint">
																			<span class="input-group-addon" id="basic-addon1">R$</span>
																			<input type="text" class="form-control Valor" id="ValorRestanteOrca" maxlength="10" placeholder="0,00" readonly=""
																				   data-toggle="collapse" onkeyup="calculaParcelas()"
																					data-target="#Parcelas" aria-expanded="false" aria-controls="Parcelas"
																				   name="ValorRestanteOrca" value="<?php echo $orcatrata['ValorRestanteOrca'] ?>">
																		</div>
																	</div>																		
																</div>
															</div>
															<div class="col-md-1"></div>
															<div class="form-group">
																<div class="row">
																	<div class="col-md-2">
																		<label for="FormaPagamento">Forma de Pagam.:</label>
																		<select data-placeholder="Selecione uma op��o..." class="form-control" <?php echo $readonly; ?>
																				id="FormaPagamento" name="FormaPagamento">
																			<!--<option value="">-- Selecione uma op��o --</option>-->
																			<?php
																			foreach ($select['FormaPagamento'] as $key => $row) {
																				if ($orcatrata['FormaPagamento'] == $key) {
																					echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																				} else {
																					echo '<option value="' . $key . '">' . $row . '</option>';
																				}
																			}
																			?>
																		</select>
																	</div>	
																	<div class="col-md-2">
																		<label for="DataVencimentoOrca">1� Venc.</label>
																		<div class="input-group <?php echo $datepicker; ?>">
																			<span class="input-group-addon" disabled>
																				<span class="glyphicon glyphicon-calendar"></span>
																			</span>
																			<input type="text" class="form-control Date" id="DataVencimentoOrca" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																				   name="DataVencimentoOrca" value="<?php echo $orcatrata['DataVencimentoOrca']; ?>">																			
																		</div>
																	</div>
																	<div class="col-md-2">
																		<label for="QtdParcelasOrca">Qtd. Parc.:</label><br>
																		<input type="text" class="form-control Numero" id="QtdParcelasOrca" maxlength="3" placeholder="0"
																			   data-toggle="collapse" onkeyup="calculaParcelas()"
																					data-target="#Parcelas" aria-expanded="false" aria-controls="Parcelas"
																			   name="QtdParcelasOrca" value="<?php echo $orcatrata['QtdParcelasOrca'] ?>">
																	</div>																																			
																	<div class="col-md-3">
																		<label for="Modalidade">Modalidade</label><br>
																		<div class="form-group">
																			<div class="btn-block" data-toggle="buttons">
																				<?php
																				foreach ($select['Modalidade'] as $key => $row) {
																					(!$orcatrata['Modalidade']) ? $orcatrata['Modalidade'] = 'P' : FALSE;

																					if ($orcatrata['Modalidade'] == $key) {
																						echo ''
																						. '<label class="btn btn-warning active" name="radiobutton_Modalidade" id="radiobutton_Modalidade' .  $key . '">'
																						. '<input type="radio" name="Modalidade" id="radiobuttondinamico" '
																						. 'onchange="calculaParcelas()" '
																						. 'autocomplete="off" value="' . $key . '" checked>' . $row
																						. '</label>'
																						;
																					} else {
																						echo ''
																						. '<label class="btn btn-default" name="radiobutton_Modalidade" id="radiobutton_Modalidade' .  $key . '">'
																						. '<input type="radio" name="Modalidade" id="radiobuttondinamico" '
																						. 'onchange="calculaParcelasMensais()" '
																						. 'autocomplete="off" value="' . $key . '" >' . $row
																						. '</label>'
																						;
																					}
																				}
																				?>
																			</div>
																		</div>
																	</div>
																	<!--
																	<br>
																	<div class="form-group">
																		<div class="col-md-2 text-left">
																			<button class="btn btn-danger" type="button" data-toggle="collapse" onclick="calculaParcelas()"
																					data-target="#Parcelas" aria-expanded="false" aria-controls="Parcelas">
																				<span class="glyphicon glyphicon-menu-down"></span> Gerar Parcelas
																			</button>
																		</div>
																	</div>
																	-->
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
										<div class="panel panel-primary">
											<div class="panel-heading" role="tab" id="heading2" data-toggle="collapse" data-parent="#accordion2" data-target="#collapse2">
												<h4 class="panel-title">
													<a class="accordion-toggle">
														<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
														Parcelas
													</a>
												</h4>
											</div>
											<div id="collapse2" class="panel-collapse" role="tabpanel" aria-labelledby="heading2" aria-expanded="false">
												<div class="panel-body">
													<!--App_parcelasRec-->
													<div class="input_fields_parcelas">

													<?php
													for ($i=1; $i <= $orcatrata['QtdParcelasOrca']; $i++) {
													?>

														<?php if ($metodo > 1) { ?>
														<input type="hidden" name="idApp_ParcelasRecebiveis<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['idApp_ParcelasRecebiveis']; ?>"/>
														<?php } ?>


														<div class="form-group">
															<div class="panel panel-info">
																<div class="panel-heading">
																	<div class="row">
																		<div class="col-md-2">
																			<label for="ParcelaRecebiveis">Parcela:</label><br>
																			<input type="text" class="form-control" maxlength="6" readonly=""
																				   name="ParcelaRecebiveis<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['ParcelaRecebiveis'] ?>">
																		</div>
																		<div class="col-md-2">
																			<label for="ValorParcelaRecebiveis">Valor Parcela:</label><br>
																			<div class="input-group" id="txtHint">
																				<span class="input-group-addon" id="basic-addon1">R$</span>
																				<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" id="ValorParcelaRecebiveis<?php echo $i ?>"
																					   name="ValorParcelaRecebiveis<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['ValorParcelaRecebiveis'] ?>">
																			</div>
																		</div>
																		<div class="col-md-2">
																			<label for="DataVencimentoRecebiveis">Data Venc. Parc.</label>
																			<div class="input-group DatePicker">
																				<input type="text" class="form-control Date" id="DataVencimentoRecebiveis<?php echo $i ?>" maxlength="10" placeholder="DD/MM/AAAA"
																					   name="DataVencimentoRecebiveis<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['DataVencimentoRecebiveis'] ?>">
																				<span class="input-group-addon" disabled>
																					<span class="glyphicon glyphicon-calendar"></span>
																				</span>
																			</div>
																		</div>
																		<div class="col-md-2">
																			<label for="ValorPagoRecebiveis">Valor Pago:</label><br>
																			<div class="input-group" id="txtHint">
																				<span class="input-group-addon" id="basic-addon1">R$</span>
																				<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" id="ValorPagoRecebiveis<?php echo $i ?>"
																					   name="ValorPagoRecebiveis<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['ValorPagoRecebiveis'] ?>">
																			</div>
																		</div>
																		<div class="col-md-2">
																			<label for="DataPagoRecebiveis">Data Pag.</label>
																			<div class="input-group DatePicker">
																				<input type="text" class="form-control Date" id="DataPagoRecebiveis<?php echo $i ?>" maxlength="10" placeholder="DD/MM/AAAA"
																					   name="DataPagoRecebiveis<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['DataPagoRecebiveis'] ?>">
																				<span class="input-group-addon" disabled>
																					<span class="glyphicon glyphicon-calendar"></span>
																				</span>
																			</div>
																		</div>
																		<div class="col-md-2">
																			<label for="QuitadoRecebiveis">Quitado????</label><br>
																			<div class="form-group">
																				<div class="btn-group" data-toggle="buttons">
																					<?php
																					foreach ($select['QuitadoRecebiveis'] as $key => $row) {
																						(!$parcelasrec[$i]['QuitadoRecebiveis']) ? $parcelasrec[$i]['QuitadoRecebiveis'] = 'N' : FALSE;

																						if ($parcelasrec[$i]['QuitadoRecebiveis'] == $key) {
																							echo ''
																							. '<label class="btn btn-warning active" name="radiobutton_QuitadoRecebiveis' . $i . '" id="radiobutton_QuitadoRecebiveis' . $i .  $key . '">'
																							. '<input type="radio" name="QuitadoRecebiveis' . $i . '" id="radiobuttondinamico" '
																							. 'onchange="carregaQuitado(this.value,this.name,'.$i.')" '
																							. 'autocomplete="off" value="' . $key . '" checked>' . $row
																							. '</label>'
																							;
																						} else {
																							echo ''
																							. '<label class="btn btn-default" name="radiobutton_QuitadoRecebiveis' . $i . '" id="radiobutton_QuitadoRecebiveis' . $i .  $key . '">'
																							. '<input type="radio" name="QuitadoRecebiveis' . $i . '" id="radiobuttondinamico" '
																							. 'onchange="carregaQuitado(this.value,this.name,'.$i.')" '
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

													<?php
													}
													?>
													</div>

												</div>
											</div>
										</div>
									</div>

									<div class="panel-group" id="accordion8" role="tablist" aria-multiselectable="true">
										<div class="panel panel-primary">
											<div class="panel-heading collapsed" role="tab" id="heading8" data-toggle="collapse" data-parent="#accordion8" data-target="#collapse8" aria-expanded="false">								<h4 class="panel-title">
													<a class="accordion-toggle">
														<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
														Status do Or�amento
													</a>
												</h4>
											</div>

											<div id="collapse8" class="panel-collapse" role="tabpanel" aria-labelledby="heading8" aria-expanded="false">
												<div class="panel-body">
													<div class="form-group">
														<div class="panel panel-info">
															<div class="panel-heading">
																<div class="col-md-1"></div>
																<div class="form-group text-left">
																	<div class="row">
																		<div class="col-md-3 form-inline">
																			<label for="AprovadoOrca">Aprovado?</label><br>
																			<div class="form-group">
																				<div class="btn-group" data-toggle="buttons">
																					<?php
																					foreach ($select['AprovadoOrca'] as $key => $row) {
																						if (!$orcatrata['AprovadoOrca'])
																							$orcatrata['AprovadoOrca'] = 'N';

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
																		<div class="col-md-3 form-inline">
																			<label for="ServicoConcluido">Conclu�do?</label><br>
																			<div class="form-group">
																				<div class="btn-group" data-toggle="buttons">
																					<?php
																					foreach ($select['ServicoConcluido'] as $key => $row) {
																						(!$orcatrata['ServicoConcluido']) ? $orcatrata['ServicoConcluido'] = 'N' : FALSE;

																						if ($orcatrata['ServicoConcluido'] == $key) {
																							echo ''
																							. '<label class="btn btn-warning active" name="radiobutton_ServicoConcluido" id="radiobutton_ServicoConcluido' . $key . '">'
																							. '<input type="radio" name="ServicoConcluido" id="radiobutton" '
																							. 'autocomplete="off" value="' . $key . '" checked>' . $row
																							. '</label>'
																							;
																						} else {
																							echo ''
																							. '<label class="btn btn-default" name="radiobutton_ServicoConcluido" id="radiobutton_ServicoConcluido' . $key . '">'
																							. '<input type="radio" name="ServicoConcluido" id="radiobutton" '
																							. 'autocomplete="off" value="' . $key . '" >' . $row
																							. '</label>'
																							;
																						}
																					}
																					?>
																				</div>
																			</div>
																		</div>
																		<div class="col-md-3 form-inline">
																			<label for="QuitadoOrca">Quitado?</label><br>
																			<div class="form-group">
																				<div class="btn-group" data-toggle="buttons">
																					<?php
																					foreach ($select['QuitadoOrca'] as $key => $row) {
																						(!$orcatrata['QuitadoOrca']) ? $orcatrata['QuitadoOrca'] = 'N' : FALSE;

																						if ($orcatrata['QuitadoOrca'] == $key) {
																							echo ''
																							. '<label class="btn btn-warning active" name="radiobutton_QuitadoOrca" id="radiobutton_QuitadoOrca' . $key . '">'
																							. '<input type="radio" name="QuitadoOrca" id="radiobutton" '
																							. 'autocomplete="off" value="' . $key . '" checked>' . $row
																							. '</label>'
																							;
																						} else {
																							echo ''
																							. '<label class="btn btn-default" name="radiobutton_QuitadoOrca" id="radiobutton_QuitadoOrca' . $key . '">'
																							. '<input type="radio" name="QuitadoOrca" id="radiobutton" '
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
																<div class="col-md-1"></div>
																<div class="form-group text-left">
																	<div class="row">
																		<div class="col-md-3">
																			<label for="DataOrca">Or�ado em:</label>
																			<div class="input-group <?php echo $datepicker; ?>">
																				<span class="input-group-addon" disabled>
																					<span class="glyphicon glyphicon-calendar"></span>
																				</span>
																				<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																						name="DataOrca" value="<?php echo $orcatrata['DataOrca']; ?>">
																			</div>
																		</div>
																		<div class="col-md-3">
																			<label for="DataConclusao">Conclu�do em:</label>
																			<div class="input-group <?php echo $datepicker; ?>">
																				<span class="input-group-addon" disabled>
																					<span class="glyphicon glyphicon-calendar"></span>
																				</span>
																				<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																					   name="DataConclusao" value="<?php echo $orcatrata['DataConclusao']; ?>">
																			</div>
																		</div>
																		<div class="col-md-3">
																			<label for="DataQuitado">Quitado em:</label>
																			<div class="input-group <?php echo $datepicker; ?>">
																				<span class="input-group-addon" disabled>
																					<span class="glyphicon glyphicon-calendar"></span>
																				</span>
																				<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																					   name="DataQuitado" value="<?php echo $orcatrata['DataQuitado']; ?>">																				
																			</div>
																		</div>

																		<!--
																		<div class="form-group text-center">
																			<div id="AprovadoOrca" <?php echo $div['AprovadoOrca']; ?>>
																				<div class="col-md-3 form-inline">
																					<label for="QuitadoOrca">Or�am. Quitado?</label><br>
																					<div class="form-group">
																						<div class="btn-group" data-toggle="buttons">
																							<?php
																							foreach ($select['QuitadoOrca'] as $key => $row) {
																								(!$orcatrata['QuitadoOrca']) ? $orcatrata['QuitadoOrca'] = 'N' : FALSE;

																								if ($orcatrata['QuitadoOrca'] == $key) {
																									echo ''
																									. '<label class="btn btn-warning active" name="radiobutton_QuitadoOrca" id="radiobutton_QuitadoOrca' . $key . '">'
																									. '<input type="radio" name="QuitadoOrca" id="radiobutton" '
																									. 'autocomplete="off" value="' . $key . '" checked>' . $row
																									. '</label>'
																									;
																								} else {
																									echo ''
																									. '<label class="btn btn-default" name="radiobutton_QuitadoOrca" id="radiobutton_QuitadoOrca' . $key . '">'
																									. '<input type="radio" name="QuitadoOrca" id="radiobutton" '
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
																		-->
																	</div>
																</div>
																<div class="col-md-1"></div>
																<div class="form-group text-left">
																	<div class="row">
																		<div class="col-md-6">
																			<label for="ObsOrca">OBS:</label>
																			<textarea class="form-control" id="ObsOrca" <?php echo $readonly; ?>
																					  name="ObsOrca"><?php echo $orcatrata['ObsOrca']; ?></textarea>
																		</div>
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
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									
									<div class="panel-group" id="accordion3" role="tablist" aria-multiselectable="true">
										<div class="panel panel-primary">
											 <div class="panel-heading" role="tab" id="heading3" data-toggle="collapse" data-parent="#accordion3" data-target="#collapse3">
												<h4 class="panel-title">
													<a class="accordion-toggle">
														<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
														Procedimentos
													</a>
												</h4>
											</div>

											<div id="collapse3" class="panel-collapse" role="tabpanel" aria-labelledby="heading3" aria-expanded="false">
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
														<div class="panel panel-info">
															<div class="panel-heading">
																<div class="row">
																	<div class="col-md-4">
																		<label for="Procedimento<?php echo $i ?>">Procedimento:</label>
																		<textarea class="form-control" id="Procedimento<?php echo $i ?>" <?php echo $readonly; ?>
																				  name="Procedimento<?php echo $i ?>"><?php echo $procedimento[$i]['Procedimento']; ?></textarea>
																	</div>
																	<div class="col-md-2">
																		<label for="DataProcedimento<?php echo $i ?>">Data do Proced.:</label>
																		<div class="input-group <?php echo $datepicker; ?>">
																			<span class="input-group-addon" disabled>
																				<span class="glyphicon glyphicon-calendar"></span>
																			</span>
																			<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																				   name="DataProcedimento<?php echo $i ?>" value="<?php echo $procedimento[$i]['DataProcedimento']; ?>">
																		</div>
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
																	<div class="col-md-3">
																		<label for="idSis_Usuario<?php echo $i ?>">Profissional:</label>
																		<?php if ($i == 1) { ?>
																		<?php } ?>
																		<select data-placeholder="Selecione uma op��o..." class="form-control" readonly=""
																				 id="listadinamicac<?php echo $i ?>" name="idSis_Usuario<?php echo $i ?> readonly="" ">
																			<!--<option value="">-- Selecione uma op��o --</option>-->
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
																</div>
															</div>
														</div>
													</div>

													<?php
													}
													?>

													</div>

													<div class="form-group">
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

									<!--
									<div class="form-group">
										<div class="row">
											<div class="col-md-3">
												<label for="DataEntradaOrca">Validade do Or�.:</label>
												<div class="input-group <?php echo $datepicker; ?>">
													<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
														   name="DataEntradaOrca" value="<?php echo $orcatrata['DataEntradaOrca']; ?>">
													<span class="input-group-addon" disabled>
														<span class="glyphicon glyphicon-calendar"></span>
													</span>
												</div>
											</div>
											<div class="col-md-3">
												<label for="DataPrazo">Prazo de Entrega:</label>
												<div class="input-group <?php echo $datepicker; ?>">
													<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
															name="DataPrazo" value="<?php echo $orcatrata['DataPrazo']; ?>">
													<span class="input-group-addon" disabled>
														<span class="glyphicon glyphicon-calendar"></span>
													</span>
												</div>
											</div>

										</div>
									</div>

									<hr>
									-->

									<div class="form-group">
										<div class="row">
											<input type="hidden" name="idApp_Consultor" value="<?php echo $_SESSION['Consultor']['idApp_Consultor']; ?>">
											<input type="hidden" name="idApp_OrcaTrata" value="<?php echo $orcatrata['idApp_OrcaTrata']; ?>">
											<?php if ($metodo > 1) { ?>
											<!--<input type="hidden" name="idApp_Procedimento" value="<?php echo $procedimento['idApp_Procedimento']; ?>">
											<input type="hidden" name="idApp_ParcelasRec" value="<?php echo $parcelasrec['idApp_ParcelasRec']; ?>">-->
											<?php } ?>
											<?php if ($metodo == 2) { ?>
												<!--
												<div class="col-md-12 text-center">
													<button class="btn btn-lg btn-danger" id="inputDb" data-loading-text="Aguarde..." name="submit" value="1" type="submit">
														<span class="glyphicon glyphicon-trash"></span> Excluir
													</button>
													<button class="btn btn-lg btn-warning" id="inputDb" onClick="history.go(-1);
																return true;">
														<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
													</button>
												</div>
												<button type="button" class="btn btn-danger">
													<span class="glyphicon glyphicon-trash"></span> Confirmar Exclus�o
												</button>                        -->

												<div class="col-md-6">
													<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
														<span class="glyphicon glyphicon-save"></span> Salvar
													</button>
												</div>
												<div class="col-md-6 text-right">
													<button  type="button" class="btn btn-lg btn-danger" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
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
																<p>Ao confirmar esta opera��o todos os dados ser�o exclu�dos permanentemente do sistema.
																	Esta opera��o � irrevers�vel.</p>
															</div>
															<div class="modal-footer">
																<div class="col-md-6 text-left">
																	<button type="button" class="btn btn-warning" data-dismiss="modal">
																		<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
																	</button>
																</div>
																<div class="col-md-6 text-right">
																	<a class="btn btn-danger" href="<?php echo base_url() . 'orcatrata/excluir/' . $orcatrata['idApp_OrcaTrata'] ?>" role="button">
																		<span class="glyphicon glyphicon-trash"></span> Confirmar Exclus�o
																	</a>
																</div>
															</div>
														</div>
													</div>
												</div>
											<?php } else { ?>
												<div class="col-md-6">
													<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
														<span class="glyphicon glyphicon-save"></span> Salvar
													</button>
												</div>

											<?php } ?>
										</div>
									</div>

									</form>

								</div>
							</div>
						</div>

					</div>


		</div>
		<div class="col-md-1"></div>
	</div>
</div>
