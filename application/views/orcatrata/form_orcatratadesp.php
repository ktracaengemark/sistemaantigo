<?php if (isset($msg)) echo $msg; ?>

<div class="col-md-8 ">
	<div class="row">
		<div class="col-md-12 col-lg-12">			
			<?php #echo validation_errors(); ?>
			<?php echo form_open_multipart($form_open_path); ?>
			<div class="panel panel-<?php echo $panel; ?>">
				<div class="panel-heading">
					<h4 class="text-center"><b><?php echo $titulo; ?></b></h4>
					<div style="overflow: auto; height: auto; ">
						<div class="panel-group">
							<div <?php echo $visivel; ?>>
								<div class="panel panel-success">
									<div class="panel-heading">
										<input type="hidden" name="Negocio" id="Negocio" value="2"/>
										<input type="hidden" name="Empresa" id="Empresa" value="<?php echo $_SESSION['log']['idSis_Empresa']; ?>"/>
										<h4 class="mb-3"><b>Or�amento</b></h4>
										<div <?php echo $visivel; ?>>
											<div class="row">
												<div class="col-md-12 mb-3">
													<div class="row">
														<div class="col-md-6 text-left">	
															<label for="idApp_Fornecedor">Fornecedor</label>
															<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" <?php echo $readonly; ?>
																	id="idApp_Fornecedor" name="idApp_Fornecedor">
																<option value="">-- Sel. Fornecedor --</option>
																<?php
																foreach ($select['idApp_Fornecedor'] as $key => $row) {
																		(!$orcatrata['idApp_Fornecedor']) ? $orcatrata['idApp_Fornecedor'] = '1' : FALSE;
																	if ($orcatrata['idApp_Fornecedor'] == $key) {
																		echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																	} else {
																		echo '<option value="' . $key . '">' . $row . '</option>';
																	}
																}
																?>
															</select>
															<?php echo form_error('idApp_Fornecedor'); ?>
														</div>
														<div class="col-md-3 text-left">
															<label for="Cadastrar">Forn. encontrado?</label>
															<div class="btn-group" data-toggle="buttons">
																<?php
																foreach ($select['Cadastrar'] as $key => $row) {
																	if (!$cadastrar['Cadastrar']) $cadastrar['Cadastrar'] = 'S';

																	($key == 'N') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																	if ($cadastrar['Cadastrar'] == $key) {
																		echo ''
																		. '<label class="btn btn-warning active" name="Cadastrar_' . $hideshow . '">'
																		. '<input type="radio" name="Cadastrar" id="' . $hideshow . '" '
																		. 'autocomplete="off" value="' . $key . '" checked>' . $row
																		. '</label>'
																		;
																	} else {
																		echo ''
																		. '<label class="btn btn-default" name="Cadastrar_' . $hideshow . '">'
																		. '<input type="radio" name="Cadastrar" id="' . $hideshow . '" '
																		. 'autocomplete="off" value="' . $key . '" >' . $row
																		. '</label>'
																		;
																	}
																}
																?>

															</div>
														</div>										
														<div class="col-md-3 text-left" id="Cadastrar" <?php echo $div['Cadastrar']; ?>>
															<label for="Cadastrar">Cadastrar/ Editar Forn.</label>
															<a class="btn btn-md btn-info"   target="_blank" href="<?php echo base_url() ?>fornecedor2/cadastrar3/" role="button"> 
																<span class="glyphicon glyphicon-plus"></span>Fornec
															</a>
															
															<button class="btn btn-md btn-primary"  id="inputDb" data-loading-text="Aguarde..." type="submit">
																	<span class="glyphicon glyphicon-refresh"></span>Ref.
															</button>
															<?php echo form_error('Cadastrar'); ?>
														</div>
													</div>
												</div>
											</div>
										</div>

										<h5 class="mb-3"><b>Produtos & Servi�os</b></h5>
										
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
													<div class="panel panel-warning">
														<div class="panel-heading">
															<div class="row">
																<input type="hidden" class="form-control " id="NomeProduto<?php echo $i ?>" name="NomeProduto<?php echo $i ?>" value="<?php echo $produto[$i]['NomeProduto'] ?>">
																<input type="hidden" class="form-control " id="idTab_Produtos_Produto<?php echo $i ?>" name="idTab_Produtos_Produto<?php echo $i ?>" value="<?php echo $produto[$i]['idTab_Produtos_Produto'] ?>">
																<input type="hidden" class="form-control " id="ComissaoProduto<?php echo $i ?>" name="ComissaoProduto<?php echo $i ?>" value="<?php echo $produto[$i]['ComissaoProduto'] ?>">			
																<div class="col-md-9">
																	<label for="idTab_Produto">Produto <?php echo $i ?></label>
																	<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" onchange="buscaValor2Tabelas(this.value,this.name,'Produtos',<?php echo $i ?>,'Produto')" <?php echo $readonly; ?>
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
																<div class="col-md-2 text-left">
																	<label for="ConcluidoProduto">Entregue? </label><br>
																	<div class="btn-group" data-toggle="buttons">
																		<?php
																		foreach ($select['ConcluidoProduto'] as $key => $row) {
																			(!$produto[$i]['ConcluidoProduto']) ? $produto[$i]['ConcluidoProduto'] = 'N' : FALSE;

																			if ($produto[$i]['ConcluidoProduto'] == $key) {
																				echo ''
																				. '<label class="btn btn-warning active" name="radiobutton_ConcluidoProduto' . $i . '" id="radiobutton_ConcluidoProduto' . $i .  $key . '">'
																				. '<input type="radio" name="ConcluidoProduto' . $i . '" id="radiobuttondinamico" '
																				. 'autocomplete="off" value="' . $key . '" checked>' . $row
																				. '</label>'
																				;
																			} else {
																				echo ''
																				. '<label class="btn btn-default" name="radiobutton_ConcluidoProduto' . $i . '" id="radiobutton_ConcluidoProduto' . $i .  $key . '">'
																				. '<input type="radio" name="ConcluidoProduto' . $i . '" id="radiobuttondinamico" '
																				. 'autocomplete="off" value="' . $key . '" >' . $row
																				. '</label>'
																				;
																			}
																		}
																		?>
																	</div>
																</div>
																<div class="col-md-1">
																	<label><br></label><br>
																	<button type="button" id="<?php echo $i ?>" class="remove_field9 btn btn-danger"
																			onclick="calculaQtdSoma('QtdProduto','QtdSoma','ProdutoSoma',1,<?php echo $i ?>,'CountMax',0,'ProdutoHidden')">
																		<span class="glyphicon glyphicon-trash"></span>
																	</button>
																</div>
															</div>
															<div class="row">
																<div class="col-md-2">
																	<label for="QtdProduto">Qtd.Item</label>
																	<input type="text" class="form-control Numero" maxlength="10" id="QtdProduto<?php echo $i ?>" placeholder="0"
																			onkeyup="calculaSubtotal(this.value,this.name,'<?php echo $i ?>','QTD','Produto'),calculaQtdSoma('QtdProduto','QtdSoma','ProdutoSoma',0,0,'CountMax',0,'ProdutoHidden')"
																			name="QtdProduto<?php echo $i ?>" value="<?php echo $produto[$i]['QtdProduto'] ?>">
																</div>
																<div class="col-md-2">
																	<label for="QtdIncrementoProduto">Qtd.na Embl</label>
																	<div class="input-group">
																		<input type="text" class="form-control Numero" id="QtdIncrementoProduto<?php echo $i ?>" placeholder="0"
																			onkeyup="calculaSubtotal(this.value,this.name,'<?php echo $i ?>','QTDINC','Produto'),calculaQtdSoma('QtdProduto','QtdSoma','ProdutoSoma',0,0,'CountMax',0,'ProdutoHidden')"
																			name="QtdIncrementoProduto<?php echo $i ?>" value="<?php echo $produto[$i]['QtdIncrementoProduto'] ?>">
																	</div>
																</div>
																<div class="col-md-3">
																	<label for="ValorProduto">Valor da Embl</label>
																	<div class="input-group">
																		<span class="input-group-addon" id="basic-addon1">R$</span>
																		<input type="text" class="form-control Valor" id="idTab_Produto<?php echo $i ?>" maxlength="10" placeholder="0,00"
																			onkeyup="calculaSubtotal(this.value,this.name,'<?php echo $i ?>','VP','Produto')"
																			name="ValorProduto<?php echo $i ?>" value="<?php echo $produto[$i]['ValorProduto'] ?>">
																	</div>
																</div>
																<input type="hidden" class="form-control " id="SubtotalComissaoProduto<?php echo $i ?>" name="SubtotalComissaoProduto<?php echo $i ?>" value="<?php echo $produto[$i]['SubtotalComissaoProduto'] ?>">
																<div class="col-md-2">
																	<label for="SubtotalQtdProduto">Sub.Qtd.Prod</label>
																	<div class="input-group">
																		<input type="text" class="form-control Numero text-left" maxlength="10" readonly="" id="SubtotalQtdProduto<?php echo $i ?>"
																			   name="SubtotalQtdProduto<?php echo $i ?>" value="<?php echo $produto[$i]['SubtotalQtdProduto'] ?>">
																	</div>
																</div>
																<div class="col-md-3">
																	<label for="SubtotalProduto">Sub.Valor.Prod.</label>
																	<div class="input-group">
																		<span class="input-group-addon" id="basic-addon1">R$</span>
																		<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" readonly="" id="SubtotalProduto<?php echo $i ?>"
																			   name="SubtotalProduto<?php echo $i ?>" value="<?php echo $produto[$i]['SubtotalProduto'] ?>">
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>

												<?php
												$QtdSoma+=$produto[$i]['QtdProduto'];
												$ProdutoSoma++;
												}
												?>
												<input type="hidden" name="CountMax" id="CountMax" value="<?php echo $ProdutoSoma ?>">
											</div>
										
											<div class="panel panel-default">
												<div class="panel-heading">
													<div class="row">
														<div class="col-md-3 text-center">	
															<a class="add_field_button9 btn btn-warning"
																	autofocus onclick="calculaQtdSoma('QtdProduto','QtdSoma','ProdutoSoma',0,0,'CountMax',1,0)">
																<span class="glyphicon glyphicon-arrow-up"></span> Adicionar Produtos
															</a>
														</div>
														<!--
														<div class="col-md-3 text-center">	
															
															<b>Produtos: <span id="QtdSoma"><?php echo $QtdSoma; ?></span></b>
														</div>
														-->
														<div class="col-md-3 text-center">
															<b>Linhas: <span id="ProdutoSoma"><?php echo $ProdutoSoma; ?></span></b><br />
														</div>
														<div class="col-md-6">
															<div class="panel panel-warning">
																<div class="panel-heading">
																	<div class="row">
																		<div class="col-md-6">
																			<div class="row">
																				<div class="col-md-4 text-left">	
																					<b>Produtos: </b> 
																				</div>
																				<div class="col-md-8">
																					<div class="input-group" id="txtHint">
																						<input type="text" class="form-control text-right Numero" id="QtdPrdOrca" maxlength="10" readonly=""
																							   name="QtdPrdOrca" value="<?php echo $orcatrata['QtdPrdOrca'] ?>">
																							   
																					</div>
																				</div>
																			</div>
																		</div>
																		<input type="hidden" name="ValorComissao" id="ValorComissao" value="<?php echo $orcatrata['ValorComissao'] ?>">
																		<div class="col-md-6">
																			<!--<label for="ValorOrca">Valor em Produtos:</label><br>-->
																			<div class="input-group" id="txtHint">
																				<span class="input-group-addon" id="basic-addon1">R$</span>
																				<input type="text" class="form-control text-right Valor" id="ValorOrca" maxlength="10" placeholder="0,00" readonly=""
																					   onkeyup="calculaResta(this.value),calculaTotal(this.value),calculaTroco(this.value)" onchange="calculaResta(this.value),calculaTotal(this.value),calculaTroco(this.value)"
																					   name="ValorOrca" value="<?php echo $orcatrata['ValorOrca'] ?>">
																			</div>
																		</div>
																	</div>	
																</div>
															</div>
														</div>
														<!--
														<div class="col-md-3 text-center">
															<label></label>
															<a class="btn btn-md btn-danger" target="_blank" href="<?php echo base_url() ?>relatorio2/produtos2" role="button"> 
																<span class="glyphicon glyphicon-plus"></span> Novo/ Editar/ Estoque
															</a>
														</div>
														-->
													</div>
												</div>
											</div>
											<br>		
										
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
													<div class="panel panel-danger">
														<div class="panel-heading">
															<div class="row">
																<input type="hidden" class="form-control " id="idTab_Valor_Servico<?php echo $i ?>" name="idTab_Valor_Servico<?php echo $i ?>" value="<?php echo $servico[$i]['idTab_Valor_Servico'] ?>">
																<input type="hidden" class="form-control " id="idTab_Produtos_Servico<?php echo $i ?>" name="idTab_Produtos_Servico<?php echo $i ?>" value="<?php echo $servico[$i]['idTab_Produtos_Servico'] ?>">
																<div class="col-md-9">
																	<label for="idTab_Servico">Servi�o <?php echo $i ?>:</label>
																	<?php if ($i == 1) { ?>
																	<!--<a class="btn btn-xs btn-info" href="<?php echo base_url() ?>servico/cadastrar/servico" role="button">
																		<span class="glyphicon glyphicon-plus"></span> <b>Novo Servi�o</b>
																	</a>-->
																	<?php } ?>
																	<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" onchange="buscaValor2Tabelas(this.value,this.name,'Valor',<?php echo $i ?>,'Servico')" <?php echo $readonly; ?>
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
																<div class="col-md-2 text-left">
																	<label for="ConcluidoServico">Entregue? </label><br>
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
																<div class="col-md-1">
																	<label><br></label><br>
																	<button type="button" id="<?php echo $i ?>" class="remove_field10 btn btn-danger"
																		onclick="calculaQtdSomaDev('QtdServico','QtdSomaDev','ServicoSoma',1,<?php echo $i ?>,'CountMax2',0,'ServicoHidden')">
																		<span class="glyphicon glyphicon-trash"></span>
																	</button>
																</div>
															</div>
															<div class="row">
																<div class="col-md-2">
																	<label for="QtdServico">Qtd</label>
																	<input type="text" class="form-control Numero" maxlength="10" id="QtdServico<?php echo $i ?>" placeholder="0"
																			onkeyup="calculaSubtotal(this.value,this.name,'<?php echo $i ?>','QTD','Servico'),calculaQtdSomaDev('QtdServico','QtdSomaDev','ServicoSoma',0,0,'CountMax2',0,'ServicoHidden')"
																			 name="QtdServico<?php echo $i ?>" value="<?php echo $servico[$i]['QtdServico'] ?>">
																</div>
																<input type="hidden" class="form-control Numero" id="QtdIncrementoServico<?php echo $i ?>" name="QtdIncrementoServico<?php echo $i ?>" value="<?php echo $servico[$i]['QtdIncrementoServico'] ?>">
																<div class="col-md-3">
																	<label for="ValorServico">Valor do Servi�o</label>
																	<div class="input-group">
																		<span class="input-group-addon" id="basic-addon1">R$</span>
																		<input type="text" class="form-control Valor" id="idTab_Servico<?php echo $i ?>" maxlength="10" placeholder="0,00"
																			onkeyup="calculaSubtotal(this.value,this.name,'<?php echo $i ?>','VP','Servico')"
																			name="ValorServico<?php echo $i ?>" value="<?php echo $servico[$i]['ValorServico'] ?>">
																	</div>
																</div>
																<div class="col-md-4">
																	<label for="ProfissionalServico<?php echo $i ?>">Profissional</label>
																	<?php if ($i == 1) { ?>
																	<?php } ?>
																	<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
																			 id="listadinamica_prof<?php echo $i ?>" name="ProfissionalServico<?php echo $i ?>">
																		<option value="">-- Sel.Profis. --</option>
																		<?php
																		foreach ($select['ProfissionalServico'] as $key => $row) {
																			(!$servico['ProfissionalServico']) ? $servico['ProfissionalServico'] = $_SESSION['log']['ProfissionalServico']: FALSE;
																			if ($servico[$i]['ProfissionalServico'] == $key) {
																				echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																			} else {
																				echo '<option value="' . $key . '">' . $row . '</option>';
																			}
																		}
																		?>
																	</select>
																</div>
																<div class="col-md-3">
																	<label for="SubtotalServico">Sub.Valor.Serv:</label>
																	<div class="input-group">
																		<span class="input-group-addon" id="basic-addon1">R$</span>
																		<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" readonly="" id="SubtotalServico<?php echo $i ?>"
																			   name="SubtotalServico<?php echo $i ?>" value="<?php echo $servico[$i]['SubtotalServico'] ?>">
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>

												<?php
												$QtdSomaDev+=$servico[$i]['QtdServico'];
												$ServicoSoma++;
												}
												?>
											</div>
																														
											<div class="panel panel-default">
												<div class="panel-heading text-left">
													<div class="row">
														<div class="col-md-3 text-center">
															<!--
															<a class="add_field_button10  btn btn-danger" 
																	onclick="calculaQtdSomaDev('QtdServico','QtdSomaDev','ServicoSoma',0,0,'CountMax2',1,0)">
																<span class="glyphicon glyphicon-arrow-up"></span> Adicionar Servi�os
															</a>
															-->
														</div>
														<div class="col-md-3 text-center">	
															<b>Linhas: <span id="ServicoSoma"><?php echo $ServicoSoma ?></span></b><br />
														</div>
														<div class="col-md-6">
															<div class="panel panel-danger">
																<div class="panel-heading">
																	<div class="row">
																		<div class="col-md-6">
																			<div class="row">
																				<div class="col-md-12 text-left">	
																					<b>Servi�os: <span class="text-right" id="QtdSomaDev"><?php echo $QtdSomaDev ?></span> </b>
																				</div>
																			</div>
																		</div>
																		<div class="col-md-6">
																			<div class="input-group" id="txtHint">
																				<span class="input-group-addon" id="basic-addon1">R$</span>
																				<input type="text" class="form-control text-right Valor" id="ValorDev" maxlength="10" placeholder="0,00" readonly=""
																					   onkeyup="calculaResta(this.value),calculaTotal(this.value),calculaTroco(this.value)" onchange="calculaResta(this.value),calculaTotal(this.value),calculaTroco(this.value)"
																					   name="ValorDev" value="<?php echo $orcatrata['ValorDev'] ?>">
																			</div>
																		</div>
																	</div>	
																</div>		
															</div>			
														</div>
													</div>
												</div>
											</div>
											
											<input type="hidden" name="CountMax2" id="CountMax2" value="<?php echo $ServicoSoma ?>">

										
										<!-- soma dos produtos, servi�os e total do or�amento-->
										<br>
										<div class="row">
											<div class="col-md-4">
												<div class="panel panel-default">
													<div class="panel-heading">
														<div class="row">
															<div class="col-md-12 text-left">
																<label for="DataOrca">Data do Pedido</label>
																<div class="input-group <?php echo $datepicker; ?>">
																	<span class="input-group-addon" disabled>
																		<span class="glyphicon glyphicon-calendar"></span>
																	</span>
																	<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																			name="DataOrca" value="<?php echo $orcatrata['DataOrca']; ?>">
																</div>
															</div>
														</div>
														<div class="row">														
															<div class="col-md-12">
																<label for="TipoFinanceiro">Tipo de Despesa</label>
																<select data-placeholder="Selecione uma op��o..." class="form-control" <?php echo $readonly; ?>
																		id="TipoFinanceiro" name="TipoFinanceiro">
																	<option value="">-- Selecione uma op��o --</option>
																	<?php
																	foreach ($select['TipoFinanceiro'] as $key => $row) {
																		(!$orcatrata['TipoFinanceiro']) ? $orcatrata['TipoFinanceiro'] = '12' : FALSE;
																		if ($orcatrata['TipoFinanceiro'] == $key) {
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
											<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
											<div class="col-md-4">
												<div class="panel panel-default">
													<div class="panel-heading">	
														<div class="row">	
															<div class="col-md-12">
																<label for="Descricao">Obs/Descri��o:</label>
																<textarea class="form-control" id="Descricao" <?php echo $readonly; ?> placeholder="Observa�oes:"
																		  name="Descricao"><?php echo $orcatrata['Descricao']; ?></textarea>
															</div>
														</div>
													</div>
												</div>
											</div>
											<?php } ?>
											<div class="col-md-4">
												<div class="panel panel-default">
													<div class="panel-heading">
														<div class="row">			
															<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
															<div class="col-md-12">
																<label for="ValorRestanteOrca">Total do Or�amento:</label><br>
																<div class="input-group" id="txtHint">
																	<span class="input-group-addon" id="basic-addon1">R$</span>
																	<input type="text" class="form-control Valor" id="ValorRestanteOrca" maxlength="10" placeholder="0,00" 
																		   data-toggle="collapse" onkeyup="calculaParcelas(),calculaTotal(this.value),calculaTroco(this.value)" onchange="calculaParcelas(),calculaTroco(this.value)" onkeydown="calculaParcelas(),calculaTroco(this.value)"
																			data-target="#Parcelas" aria-expanded="false" aria-controls="Parcelas"
																		   name="ValorRestanteOrca" value="<?php echo $orcatrata['ValorRestanteOrca'] ?>">
																</div>
															</div>
															<?php }elseif ($_SESSION['log']['NivelEmpresa'] <= 3 ) { ?>
															<div class="col-md-12">
																<label for="ValorRestanteOrca">Total:</label><br>
																<div class="input-group" id="txtHint">
																	<span class="input-group-addon" id="basic-addon1">R$</span>
																	<input type="text" class="form-control Valor" id="ValorRestanteOrca" maxlength="10" placeholder="0,00"
																		   data-toggle="collapse" onkeyup="calculaParcelas(),calculaTroco(this.value)" onchange="calculaParcelas(),calculaTroco(this.value)" onkeydown="calculaParcelas(),calculaTroco(this.value)"
																			data-target="#Parcelas" aria-expanded="false" aria-controls="Parcelas"
																		   name="ValorRestanteOrca" value="<?php echo $orcatrata['ValorRestanteOrca'] ?>">
																</div>
															</div>																
															<?php } ?>																
														</div>	
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<br>
							<div class="panel panel-info">
								<div class="panel-heading">	
									<h4 class="mb-3"><b>Entrega</b></h4>	
									<div class="row">	
										<div class="col-md-8 mb-3"></div>
										<div class="col-md-4">
											<div class="panel panel-default">
												<div class="panel-heading">
													<div class="row">
														<div class="col-md-12">
															<label for="ValorFrete">Taxa de Entrega:</label><br>
															<div class="input-group" id="txtHint">
																<span class="input-group-addon" id="basic-addon1">R$</span>
																<input type="text" class="form-control Valor" id="ValorFrete" maxlength="10" placeholder="0,00" 
																	   onkeyup="calculaTotal(this.value),calculaParcelas(),calculaTroco(this.value)"
																	   name="ValorFrete" value="<?php echo $orcatrata['ValorFrete'] ?>">
															</div>
														</div>																
													</div>
													<div class="row">
														<div class="col-md-12">
															<label for="ValorTotalOrca">Total do Pedido:</label><br>
															<div class="input-group" id="txtHint">
																<span class="input-group-addon" id="basic-addon1">R$</span>
																<input type="text" class="form-control Valor" id="ValorTotalOrca" maxlength="10" placeholder="0,00" readonly=''
																	   data-toggle="collapse" onkeyup="calculaParcelas(),calculaTotal(this.value),calculaTroco(this.value)" onchange="calculaParcelas(),calculaTotal(this.value),calculaTroco(this.value)" onkeydown="calculaParcelas(),calculaTotal(this.value),calculaTroco(this.value)"
																		data-target="#Parcelas" aria-expanded="false" aria-controls="Parcelas"
																	   name="ValorTotalOrca" value="<?php echo $orcatrata['ValorTotalOrca'] ?>">
															</div>
														</div>																
													</div>	
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<br>
							<div class="panel-group">	
								<div class="panel panel-success">
									<div class="panel-heading">
										<h4 class="mb-3"><b>Pagamento</b></h4>
										<div class="row">
											<div class="col-md-4">
												<div class="panel panel-default">
													<div class="panel-heading">
														<div class="row">
															<div class="col-md-12">
																<label for="FormaPagamento">Forma de Pagamento</label>
																<select data-placeholder="Selecione uma op��o..." class="form-control" <?php echo $readonly; ?>
																		id="FormaPagamento" name="FormaPagamento">
																	<option value="">-- Selecione uma op��o --</option>
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
																<?php echo form_error('FormaPagamento'); ?>
															</div>																	
														</div>	
													</div>
												</div>
											</div>	
											<div class="col-md-4">
												<div class="panel panel-primary">
													<div class="panel-heading">
														<div class="row">
															<div class="col-md-12 text-left">
																<label for="AVAP">Pagamento:</label><br>
																<div class="btn-block" data-toggle="buttons">
																	<?php
																	foreach ($select['AVAP'] as $key => $row) {
																		(!$orcatrata['AVAP']) ? $orcatrata['AVAP'] = 'V' : FALSE;
																		#if (!$orcatrata['AVAP'])$orcatrata['AVAP'] = V;
																		($key == 'P') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																		if ($orcatrata['AVAP'] == $key) {
																			echo ''
																			. '<label class="btn btn-default active" name="radio" id="radio' . $key . '">'
																			. '<input type="radio" name="AVAP" id="' . $hideshow . '" '
																			. 'onchange="calculaParcelas(),formaPag(this.value)" '
																			. 'autocomplete="off" value="' . $key . '" checked>' . $row
																			. '</label>'
																			;
																		} else {
																			echo ''
																			. '<label class="btn btn-default" name="radio" id="radio' . $key . '">'
																			. '<input type="radio" name="AVAP" id="' . $hideshow . '"'
																			. 'onchange="calculaParcelas(),formaPag(this.value)" '
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
										<div id="AVAP" <?php echo $div['AVAP']; ?>>		
											<br>
											<div class="form-group">	
												<div class="row">																
													<div class="col-md-2">
														<label for="QtdParcelasOrca">Parcelas</label><br>
														<input type="text" class="form-control Numero" id="QtdParcelasOrca" maxlength="3" placeholder="0"
															   data-toggle="collapse" onkeyup="calculaParcelas()"
																	data-target="#Parcelas" aria-expanded="false" aria-controls="Parcelas"
															   name="QtdParcelasOrca" value="<?php echo $orcatrata['QtdParcelasOrca'] ?>">
														<?php echo form_error('QtdParcelasOrca'); ?>		
													</div>
													<div class="col-md-3">
														<label for="DataVencimentoOrca">Venc.</label>
														<div class="input-group <?php echo $datepicker; ?>">
															<span class="input-group-addon" disabled>
																<span class="glyphicon glyphicon-calendar"></span>
															</span>
															<input type="text" class="form-control Date" id="DataVencimentoOrca" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																   data-toggle="collapse" onkeyup="calculaParcelas()" onchange="calculaParcelas()"
																	data-target="#Parcelas" aria-expanded="false" aria-controls="Parcelas"
																   name="DataVencimentoOrca" value="<?php echo $orcatrata['DataVencimentoOrca']; ?>">																			
														</div>
													</div>
													<div class="col-md-3">
														<label for="Modalidade">Dividido/ Mensal</label><br>
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
											</div>
											<!--App_parcelasRec-->	
											<div class="input_fields_parcelas">

												<?php
												for ($i=1; $i <= $orcatrata['QtdParcelasOrca']; $i++) {
												?>

												<?php if ($metodo > 1) { ?>
												<input type="hidden" name="idApp_Parcelas<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['idApp_Parcelas']; ?>"/>
												<?php } ?>

												<div class="form-group">
													<div class="panel panel-warning">
														<div class="panel-heading">
															<div class="row">
																<div class="col-md-2">
																	<label for="Parcela">Parcela <?php echo $i ?>:</label><br>
																	<input type="text" class="form-control" maxlength="6" readonly=""
																		   name="Parcela<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['Parcela'] ?>">
																</div>
																<div class="col-md-2">
																	<label for="ValorParcela">Valor Parcela:</label><br>
																	<div class="input-group" id="txtHint">
																		<span class="input-group-addon" id="basic-addon1">R$</span>
																		<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" id="ValorParcela<?php echo $i ?>"
																			   name="ValorParcela<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['ValorParcela'] ?>">
																	</div>
																</div>
																<div class="col-md-2">
																	<label for="DataVencimento">Data Venc. Parc.</label>
																	<div class="input-group DatePicker">
																		<input type="text" class="form-control Date" id="DataVencimento<?php echo $i ?>" maxlength="10" placeholder="DD/MM/AAAA"
																			   name="DataVencimento<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['DataVencimento'] ?>">
																		<span class="input-group-addon" disabled>
																			<span class="glyphicon glyphicon-calendar"></span>
																		</span>
																	</div>
																</div>
																<div class="col-md-2">
																	<label for="Quitado">Parc. Paga?</label><br>
																	<div class="form-group">
																		<div class="btn-group" data-toggle="buttons">
																			<?php
																			foreach ($select['Quitado'] as $key => $row) {
																				(!$parcelasrec[$i]['Quitado']) ? $parcelasrec[$i]['Quitado'] = 'N' : FALSE;

																				if ($parcelasrec[$i]['Quitado'] == $key) {
																					echo ''
																					. '<label class="btn btn-warning active" name="radiobutton_Quitado' . $i . '" id="radiobutton_Quitado' . $i .  $key . '">'
																					. '<input type="radio" name="Quitado' . $i . '" id="radiobuttondinamico" '
																					. 'onchange="carregaQuitado(this.value,this.name,'.$i.')" '
																					. 'autocomplete="off" value="' . $key . '" checked>' . $row
																					. '</label>'
																					;
																				} else {
																					echo ''
																					. '<label class="btn btn-default" name="radiobutton_Quitado' . $i . '" id="radiobutton_Quitado' . $i .  $key . '">'
																					. '<input type="radio" name="Quitado' . $i . '" id="radiobuttondinamico" '
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
								
								<div class="panel panel-info">
									<div class="panel-heading">
										<h4 class="mb-3"><b>Status</b></h4>
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
															<!--
																<div class="col-md-12 text-right">
																<label for="ProntoOrca">Pronto pra Entrega?</label><br>
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
															
															<div class="col-md-12 text-right">
																<label class="col-md-12 text-left" for="FinalizadoOrca">Finalizado?</label><br>
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
											<div class="col-md-4"></div>
											<div class="col-md-4">
												<div class="panel panel-warning">
													<div class="panel-heading">
														<div class="row">
															<div class="col-md-12 text-left">
																<label for="ConcluidoOrca">Entregue?</label><br>
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
																<label class="col-md-6"></label><label class="col-md-6 text-left" for="QuitadoOrca">Pago?</label><br>
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
														<label for="DataConclusao">Conclu�do em:</label>
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
								
								<div class="panel panel-info">
									<div class="panel-heading">
										<input type="hidden" name="idApp_OrcaTrata" value="<?php echo $orcatrata['idApp_OrcaTrata']; ?>">
										<!--<input type="hidden" name="idApp_Cliente" value="<?php echo $_SESSION['Cliente']['idApp_Cliente']; ?>">-->
										<h4 class="mb-3"><b>Despesa</b></h4>
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
																		<p>Ao confirmar esta opera��o todos os dados ser�o exclu�dos permanentemente do sistema.
																			Esta opera��o � irrevers�vel.</p>
																	</div>
																	<div class="modal-footer">
																		<div class="col-md-6 text-left">
																			<button type="button" class="btn btn-warning" name="submeter4" id="submeter4" onclick="DesabilitaBotao()" data-dismiss="modal">
																				<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
																			</button>
																		</div>
																		<div class="col-md-6 text-right">
																			<a class="btn btn-danger" name="submeter3" id="submeter3" onclick="DesabilitaBotaoExcluir(this.name)" href="<?php echo base_url() . 'orcatrata/excluirdesp/' . $orcatrata['idApp_OrcaTrata'] ?>" role="button">
																				<span class="glyphicon glyphicon-trash"></span> Confirmar Exclus�o
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
											</div>
										<?php } ?>
									</div>
								</div>
						
								<?php if ($_SESSION['log']['NivelEmpresa'] >= 20 ) { ?>
								<div class="panel-group">	
									<div class="panel panel-danger">

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
																		<select data-placeholder="Selecione uma op��o..." class="form-control" 
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
							
							</div>
						</div>
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>
</div>

<div class="col-md-4">
	<div class="panel panel-danger ">
		<div class="panel-heading">
			<div class="text-center" type="button" data-toggle="collapse" data-target="#StatusOr�" aria-expanded="false" aria-controls="StatusOr�">
				 <h4><b>Status dos Pedidos</b></h4>
			</div>		
		
			<div <?php echo $collapse; ?> id="StatusOr�">
						
					<div class="row">
					<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
						<div class="col-md-12">	
							<div class="panel panel-danger">
								<div class="panel-heading">
									<div type="button" data-toggle="collapse" data-target="#NaoEntregues" aria-expanded="false" aria-controls="NaoEntregues">
										Aguardando <b>Aprova��o</b>
									</div>
									
								</div>
								<div <?php echo $collapse; ?> id="NaoEntregues">	
									<div class="panel-body">
										
										<?php if (isset($list1)) echo $list1; ?>

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

										<?php if (isset($list11)) echo $list11; ?>

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

										<?php if (isset($list12)) echo $list12; ?>

									</div>
								</div>	
							</div>
						</div>		
						<!--
						<div class="col-md-12">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<div class=" btn btn-info" type="button" data-toggle="collapse" data-target="#NaoRecebidos" aria-expanded="false" aria-controls="NaoRecebidos">
										<span class="glyphicon glyphicon-chevron-up"></span> N�o Recebidos
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


