<?php if (isset($msg)) echo $msg; ?>
<div class="container-fluid">
	<div class="row">	
		<div class="col-md-12 ">
			<?php if ( !isset($evento) && ($_SESSION['log']['idSis_Empresa'] != 5 || $_SESSION['log']['idSis_Empresa'] == $orcatrata['idSis_Empresa'])) { ?>
				<?php if ($_SESSION['Cliente']['idApp_Cliente'] != 150001 && $_SESSION['Cliente']['idApp_Cliente'] != 1 && $_SESSION['Cliente']['idApp_Cliente'] != 0) { ?>
					<nav class="navbar navbar-inverse navbar-fixed" role="banner">
					  <div class="container-fluid">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span> 
							</button>
							<div class="navbar-form btn-group">
								<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
									<span class="glyphicon glyphicon-user"></span>
										<?php echo '<small>' . $_SESSION['Cliente']['NomeCliente'] . '</small> - <small>' . $_SESSION['Cliente']['idApp_Cliente'] . '</small>' ?> 
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li>
										<a <?php if (preg_match("/cliente\/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
											<a href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
												<span class="glyphicon glyphicon-file"></span> Ver Dados do Cliente
											</a>
										</a>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a <?php if (preg_match("/cliente\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
											<a href="<?php echo base_url() . 'cliente/alterar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados do Cliente
											</a>
										</a>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
											<a href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
												<span class="glyphicon glyphicon-user"></span> Contatos do Cliente
											</a>
										</a>
									</li>
								</ul>
							</div>
							<!--
							<a class="navbar-brand" href="<?php #echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
								<?php #echo '<small>' . $_SESSION['Cliente']['idApp_Cliente'] . '</small> - <small>' . $_SESSION['Cliente']['NomeCliente'] . '.</small>' ?> 
							</a>
							-->
						</div>
						<div class="collapse navbar-collapse" id="myNavbar">
							<ul class="nav navbar-nav navbar-center">
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
									<div class="btn-group">
										<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-calendar"></span> Agenda <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/consulta\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
													<a href="<?php echo base_url() . 'consulta/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-calendar"></span> Lista de Agendamentos
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/consulta\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'consulta/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-plus"></span> Novo Agendamento
													</a>
												</a>
											</li>
										</ul>
									</div>									
								</li>								
								<?php if ($_SESSION['Cliente']['idSis_Empresa'] == $_SESSION['log']['idSis_Empresa'] ) { ?>
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
									<div class="btn-group">
										<button type="button" class="btn btn-md btn-warning  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-usd"></span> Or�s. <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/orcatrata\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
													<a href="<?php echo base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-usd"></span> Lista de Or�amentos
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/orcatrata\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'orcatrata/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>" onclick="buscaEnderecoCliente(<?php echo $_SESSION['Cliente']['idApp_Cliente'];?>)">
														<span class="glyphicon glyphicon-plus" ></span> Novo Or�amento
													</a>
												</a>
											</li>
										</ul>
									</div>
								</li>
								<?php } ?>
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
									<div class="btn-group">
										<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-pencil"></span> SAC <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/procedimento\/listar_Sac\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
													<a href="<?php echo base_url() . 'procedimento/listar_Sac/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-pencil"></span> Lista de Chamadas
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/procedimento\/cadastrar_Sac\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'procedimento/cadastrar_Sac/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-plus"></span> Nova Chamada
													</a>
												</a>
											</li>
										</ul>
									</div>
								</li>
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
									<div class="btn-group">
										<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-pencil"></span> Marketing <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/procedimento\/listar_Marketing\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
													<a href="<?php echo base_url() . 'procedimento/listar_Marketing/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-pencil"></span> Lista de Campanhas
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/procedimento\/cadastrar_Marketing\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'procedimento/cadastrar_Marketing/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-plus"></span> Nova Campanha
													</a>
												</a>
											</li>
										</ul>
									</div>
								</li>	
							</ul>
						</div>
					  </div>
					</nav>
				<?php } ?>
			<?php } ?>

			<div class="row">
				<div class="col-sm-offset-1 col-md-10 ">
					<?php echo validation_errors(); ?>
					<?php echo form_open_multipart($form_open_path); ?>
					<div class="panel panel-<?php echo $panel; ?>">
						<div class="panel-heading">
							<h4 class="text-center"><b>Colaborador: <?php echo $_SESSION['Orcatrata']['Nome'] ?> - <?php echo $titulo; ?> - <?php echo $orcatrata['idApp_OrcaTrata'] ?></b></h4>
								<div style="overflow: auto; height: auto; ">
									<div class="panel-group">
										
											<div class="panel panel-success">
												<div class="panel-heading">
													<input type="hidden" name="Negocio" id="Negocio" value="1"/>
													<input type="hidden" name="Empresa" id="Empresa" value="<?php echo $_SESSION['log']['idSis_Empresa']; ?>"/>
													<input type="hidden" name="NivelEmpresa" id="NivelEmpresa" value="<?php echo $_SESSION['log']['NivelEmpresa']; ?>"/>
													<h4 class="mb-3"><b>Editar Receita</b></h4>
													<div class="form-group">	
														<div class="row">
															<div class="col-md-4">
																<label for="TipoFinanceiro">Tipo de Receita</label>
																<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" <?php echo $readonly; ?>
																		id="TipoFinanceiro" name="TipoFinanceiro">
																	<option value="">-- Selecione uma op��o --</option>
																	<?php
																	foreach ($select['TipoFinanceiro'] as $key => $row) {
																		(!$orcatrata['TipoFinanceiro']) ? $orcatrata['TipoFinanceiro'] = '31' : FALSE;
																		if ($orcatrata['TipoFinanceiro'] == $key) {
																			echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																		} else {
																			echo '<option value="' . $key . '">' . $row . '</option>';
																		}
																	}
																	?>
																</select>
															</div>
															<div class="col-md-4 text-left">
																<label for="DataOrca">Data do Pedido</label>
																<div class="input-group <?php echo $datepicker; ?>">
																	<span class="input-group-addon" disabled>
																		<span class="glyphicon glyphicon-calendar"></span>
																	</span>
																	<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA" onchange="dateDiff()"
																			id="DataOrca" name="DataOrca" value="<?php echo $orcatrata['DataOrca']; ?>">
																</div>
															</div>
															<div class="col-md-2 text-left"></div>
															<div class="col-md-2 text-left">
																<label for="Prd_Srv_Orca">Com Prd & Srv?</label><br>
																<div class="btn-group" data-toggle="buttons">
																	<?php
																	foreach ($select['Prd_Srv_Orca'] as $key => $row) {
																		if (!$orcatrata['Prd_Srv_Orca'])$orcatrata['Prd_Srv_Orca'] = 'S';

																		($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																		if ($orcatrata['Prd_Srv_Orca'] == $key) {
																			echo ''
																			. '<label class="btn btn-warning active" name="Prd_Srv_Orca_' . $hideshow . '">'
																			. '<input type="radio" name="Prd_Srv_Orca" id="' . $hideshow . '" '
																			. 'autocomplete="off" value="' . $key . '" checked>' . $row
																			. '</label>'
																			;
																		} else {
																			echo ''
																			. '<label class="btn btn-default" name="Prd_Srv_Orca_' . $hideshow . '">'
																			. '<input type="radio" name="Prd_Srv_Orca" id="' . $hideshow . '" '
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
													<div <?php echo $visivel; ?>>
															<div class="row">
																<div class="col-md-12">
																	<h4 class="text-left"><b>Cliente</b>: <?php echo '' . $_SESSION['Orcatrata']['NomeCliente'] . '' ?> - <?php echo '' . $orcatrata['idApp_Cliente'] . '' ?></h4>
																</div>
															</div>
													</div>
												<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
													<div id="Prd_Srv_Orca" <?php echo $div['Prd_Srv_Orca']; ?>>	
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
																			<div class="col-md-8">
																				<div class="row">
																					<input type="hidden" class="form-control " id="idTab_Valor_Produto<?php echo $i ?>" name="idTab_Valor_Produto<?php echo $i ?>" value="<?php echo $produto[$i]['idTab_Valor_Produto'] ?>">
																					<input type="hidden" class="form-control " id="idTab_Produtos_Produto<?php echo $i ?>" name="idTab_Produtos_Produto<?php echo $i ?>" value="<?php echo $produto[$i]['idTab_Produtos_Produto'] ?>">
																					<input type="hidden" class="form-control " id="Prod_Serv_Produto<?php echo $i ?>" name="Prod_Serv_Produto<?php echo $i ?>" value="<?php echo $produto[$i]['Prod_Serv_Produto'] ?>">
																					<input type="hidden" class="form-control " id="ComissaoProduto<?php echo $i ?>" name="ComissaoProduto<?php echo $i ?>" value="<?php echo $produto[$i]['ComissaoProduto'] ?>">
																					<!--<input type="hidden" class="form-control " id="NomeProduto<?php echo $i ?>" name="NomeProduto<?php echo $i ?>" value="<?php echo $produto[$i]['NomeProduto'] ?>">-->
																					<input type="hidden" class="form-control " name="idTab_Produto<?php echo $i ?>" value="<?php echo $produto[$i]['idTab_Produto'] ?>">
																					<div class="col-md-12">
																						<label for="NomeProduto">Produto <?php echo $i ?></label>
																						<input type="text" class="form-control text-left"  readonly="" id="NomeProduto<?php echo $i ?>"
																							   name="NomeProduto<?php echo $i ?>" value="<?php echo $produto[$i]['NomeProduto'] ?>">
																					</div>
																				</div>
																				<!--
																				<div class="row">
																					<input type="hidden" class="form-control " id="NomeProduto<?php echo $i ?>" name="NomeProduto<?php echo $i ?>" value="<?php echo $produto[$i]['NomeProduto'] ?>">
																					<input type="hidden" class="form-control " id="idTab_Valor_Produto<?php echo $i ?>" name="idTab_Valor_Produto<?php echo $i ?>" value="<?php echo $produto[$i]['idTab_Valor_Produto'] ?>">
																					<input type="hidden" class="form-control " id="idTab_Produtos_Produto<?php echo $i ?>" name="idTab_Produtos_Produto<?php echo $i ?>" value="<?php echo $produto[$i]['idTab_Produtos_Produto'] ?>">
																					<input type="hidden" class="form-control " id="Prod_Serv_Produto<?php echo $i ?>" name="Prod_Serv_Produto<?php echo $i ?>" value="<?php echo $produto[$i]['Prod_Serv_Produto'] ?>">
																					<input type="hidden" class="form-control " id="ComissaoProduto<?php echo $i ?>" name="ComissaoProduto<?php echo $i ?>" value="<?php echo $produto[$i]['ComissaoProduto'] ?>">
																					<div class="col-md-12">
																						<label for="idTab_Produto">Produto <?php echo $i ?></label>
																						<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" onchange="buscaValor1Tabelas(this.value,this.name,'Valor',<?php echo $i ?>,'Produto')" <?php echo $readonly; ?>
																								 id="listadinamicab<?php echo $i ?>" name="idTab_Produto<?php echo $i ?>">
																							<option value="">-- Selecione uma op��o --</option>
																							<?php
																							/*
																							foreach ($select['Produto'] as $key => $row) {
																								if ($produto[$i]['idTab_Produto'] == $key) {
																									echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																								} else {
																									echo '<option value="' . $key . '">' . $row . '</option>';
																								}
																							}
																							*/
																							?>
																						</select>
																					</div>
																				</div>
																				-->
																				<div class="row">
																					<div class="col-md-2">
																						<label for="QtdProduto">Qtd.Item</label>
																						<input type="text" class="form-control Numero" maxlength="10" id="QtdProduto<?php echo $i ?>" placeholder="0"
																								onkeyup="calculaSubtotal(this.value,this.name,'<?php echo $i ?>','QTD','Produto'),calculaQtdSoma('QtdProduto','QtdSoma','ProdutoSoma',0,0,'CountMax',0,'ProdutoHidden')"
																								name="QtdProduto<?php echo $i ?>" value="<?php echo $produto[$i]['QtdProduto'] ?>">
																					</div>
																					<div class="col-md-2">
																						<label for="QtdIncrementoProduto">Qtd.na Embl</label>
																						<input type="text" class="form-control Numero" id="QtdIncrementoProduto<?php echo $i ?>" placeholder="0"
																							onkeyup="calculaSubtotal(this.value,this.name,'<?php echo $i ?>','QTDINC','Produto'),calculaQtdSoma('QtdProduto','QtdSoma','ProdutoSoma',0,0,'CountMax',0,'ProdutoHidden')"
																							name="QtdIncrementoProduto<?php echo $i ?>" value="<?php echo $produto[$i]['QtdIncrementoProduto'] ?>">
																					</div>
																					<input type="hidden" class="form-control " id="SubtotalComissaoProduto<?php echo $i ?>" name="SubtotalComissaoProduto<?php echo $i ?>" value="<?php echo $produto[$i]['SubtotalComissaoProduto'] ?>">
																					<div class="col-md-2">
																						<label for="SubtotalQtdProduto">Sub.Qtd.Prod</label>
																						<input type="text" class="form-control Numero text-left" maxlength="10" readonly="" id="SubtotalQtdProduto<?php echo $i ?>"
																							   name="SubtotalQtdProduto<?php echo $i ?>" value="<?php echo $produto[$i]['SubtotalQtdProduto'] ?>">
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
																					<div class="col-md-3">
																						<label for="SubtotalProduto">Sub.Valor.Prod.</label>
																						<div class="input-group">
																							<span class="input-group-addon" id="basic-addon1">R$</span>
																							<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" readonly="" id="SubtotalProduto<?php echo $i ?>"
																								   name="SubtotalProduto<?php echo $i ?>" value="<?php echo $produto[$i]['SubtotalProduto'] ?>">
																						</div>
																					</div>
																				</div>
																				<div class="row">
																					<div class="col-md-12">
																						<label for="ObsProduto">Observacao</label>
																						<input type="text" class="form-control" maxlength="200" id="ObsProduto<?php echo $i ?>" placeholder="Observacao"
																								 name="ObsProduto<?php echo $i ?>" value="<?php echo $produto[$i]['ObsProduto'] ?>">
																					</div>
																				</div>
																			</div>
																			<div class="col-md-4">
																				<div class="row">
																					<div class="col-md-1 text-left">
																						<label><br></label><br>
																						<button type="button" id="<?php echo $i ?>" class="remove_field9 btn btn-danger"
																								onclick="calculaQtdSoma('QtdProduto','QtdSoma','ProdutoSoma',1,<?php echo $i ?>,'CountMax',0,'ProdutoHidden')">
																							<span class="glyphicon glyphicon-trash"></span>
																						</button>
																					</div>
																				</div>
																				<div class="row">
																					<div class="col-md-6 text-left">
																						<label for="ConcluidoProduto">Entregue? </label><br>
																						<?php if ($_SESSION['Usuario']['Bx_Prd'] == "S") { ?>
																							<div class="btn-group" data-toggle="buttons">
																								<?php
																								foreach ($select['ConcluidoProduto'] as $key => $row) {
																									if (!$produto[$i]['ConcluidoProduto'])$produto[$i]['ConcluidoProduto'] = 'N';
																									($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																									if ($produto[$i]['ConcluidoProduto'] == $key) {
																										echo ''
																										. '<label class="btn btn-warning active" name="ConcluidoProduto' . $i . '_' . $hideshow . '">'
																										. '<input type="radio" name="ConcluidoProduto' . $i . '" id="' . $hideshow . '" '
																										. 'onchange="carregaEntreguePrd(this.value,this.name,'.$i.',0)" '
																										. 'autocomplete="off" value="' . $key . '" checked>' . $row
																										. '</label>'
																										;
																									} else {
																										echo ''
																										. '<label class="btn btn-default" name="ConcluidoProduto' . $i . '_' . $hideshow . '">'
																										. '<input type="radio" name="ConcluidoProduto' . $i . '" id="' . $hideshow . '" '
																										. 'onchange="carregaEntreguePrd(this.value,this.name,'.$i.',0)" '
																										. 'autocomplete="off" value="' . $key . '" >' . $row
																										. '</label>'
																										;
																									}
																								}
																								?>
																							</div>
																						<?php }else{ ?>
																							<input type="hidden" name="ConcluidoProduto<?php echo $i ?>" id="ConcluidoProduto<?php echo $i ?>"  value="<?php echo $produto[$i]['ConcluidoProduto']; ?>"/>
																							<span>
																								<?php 
																									if($produto[$i]['ConcluidoProduto'] == "S") {
																											echo 'Sim';
																									} elseif($produto[$i]['ConcluidoProduto'] == "N"){
																										echo 'N�o';
																									}else{
																										echo 'N�o';
																									}
																								?>
																							</span>
																						<?php } ?>
																					</div>
																				</div>
																				<div id="ConcluidoProduto<?php echo $i ?>" <?php echo $div['ConcluidoProduto' . $i]; ?>>
																					<div class="row">
																						<div class="col-md-6">
																							<label for="DataConcluidoProduto">Data Entregue</label>
																							<div class="input-group DatePicker">
																								<span class="input-group-addon" disabled>
																									<span class="glyphicon glyphicon-calendar"></span>
																								</span>
																								<input type="text" class="form-control Date" id="DataConcluidoProduto<?php echo $i ?>" maxlength="10" placeholder="DD/MM/AAAA"
																									   name="DataConcluidoProduto<?php echo $i ?>" value="<?php echo $produto[$i]['DataConcluidoProduto'] ?>">
																							</div>
																						</div>
																						<div class="col-md-6">
																							<label for="HoraConcluidoProduto">Hora Entregue:</label>
																							<div class="input-group <?php echo $timepicker; ?>">
																								<span class="input-group-addon">
																									<span class="glyphicon glyphicon-time"></span>
																								</span>
																								<input type="text" class="form-control Time" <?php echo $readonly; ?> maxlength="5"  placeholder="HH:MM"
																									   accept="" name="HoraConcluidoProduto<?php echo $i ?>" id="HoraConcluidoProduto<?php echo $i ?>" value="<?php echo $produto[$i]['HoraConcluidoProduto']; ?>">
																							</div>
																						</div>
																					</div>
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
															
														</div>
														
														<input type="hidden" name="CountMax" id="CountMax" value="<?php echo $ProdutoSoma ?>">
														
														<input type="hidden" name="SCount" id="SCount" value="<?php echo $count['SCount']; ?>"/>

														<div class="input_fields_wrap10">

															<?php
															$QtdSomaDev = $ServicoSoma = 0;
															for ($i=1; $i <= $count['SCount']; $i++) {
															?>

															<?php if ($metodo > 1) { ?>
															<input type="hidden" name="idApp_Servico<?php echo $i ?>" value="<?php echo $servico[$i]['idApp_Produto']; ?>"/>
															<?php } ?>

															<input type="hidden" name="ServicoHidden" id="ServicoHidden<?php echo $i ?>" value="<?php echo $i ?>">
															
															<div class="form-group" id="10div<?php echo $i ?>">
																<div class="panel panel-danger">
																	<div class="panel-heading">
																		<div class="row">
																			<div class="col-md-8">
																				<div class="row">
																					<input type="hidden" class="form-control " id="idTab_Valor_Servico<?php echo $i ?>" name="idTab_Valor_Servico<?php echo $i ?>" value="<?php echo $servico[$i]['idTab_Valor_Produto'] ?>">
																					<input type="hidden" class="form-control " id="idTab_Produtos_Servico<?php echo $i ?>" name="idTab_Produtos_Servico<?php echo $i ?>" value="<?php echo $servico[$i]['idTab_Produtos_Produto'] ?>">
																					<input type="hidden" class="form-control " id="Prod_Serv_Servico<?php echo $i ?>" name="Prod_Serv_Servico<?php echo $i ?>" value="<?php echo $servico[$i]['Prod_Serv_Produto'] ?>">
																					<input type="hidden" class="form-control " id="ComissaoServico<?php echo $i ?>" name="ComissaoServico<?php echo $i ?>" value="<?php echo $servico[$i]['ComissaoProduto'] ?>">
																					<!--<input type="hidden" class="form-control " id="NomeServico<?php echo $i ?>" name="NomeServico<?php echo $i ?>" value="<?php echo $servico[$i]['NomeProduto'] ?>">-->
																					<input type="hidden" class="form-control " name="idTab_Servico<?php echo $i ?>" value="<?php echo $servico[$i]['idTab_Produto'] ?>">
																					
																					<div class="col-md-12">
																						<label for="NomeServico">Servi�o <?php echo $i ?>:</label>
																						<input type="text" class="form-control " readonly="" id="NomeServico<?php echo $i ?>"
																							   name="NomeServico<?php echo $i ?>" value="<?php echo $servico[$i]['NomeProduto'] ?>">
																					</div>
																				</div>
																				<!--
																				<div class="row">
																					<input type="hidden" class="form-control " id="idTab_Valor_Servico<?php echo $i ?>" name="idTab_Valor_Servico<?php echo $i ?>" value="<?php echo $servico[$i]['idTab_Valor_Produto'] ?>">
																					<input type="hidden" class="form-control " id="idTab_Produtos_Servico<?php echo $i ?>" name="idTab_Produtos_Servico<?php echo $i ?>" value="<?php echo $servico[$i]['idTab_Produtos_Produto'] ?>">
																					<input type="hidden" class="form-control " id="Prod_Serv_Servico<?php echo $i ?>" name="Prod_Serv_Servico<?php echo $i ?>" value="<?php echo $servico[$i]['Prod_Serv_Produto'] ?>">
																					<input type="hidden" class="form-control " id="ComissaoServico<?php echo $i ?>" name="ComissaoServico<?php echo $i ?>" value="<?php echo $servico[$i]['ComissaoProduto'] ?>">
																					<input type="hidden" class="form-control " id="NomeServico<?php echo $i ?>" name="NomeServico<?php echo $i ?>" value="<?php echo $servico[$i]['NomeProduto'] ?>">
																					<div class="col-md-12">
																						<label for="idTab_Servico">Servi�o <?php echo $i ?>:</label>
																						<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" onchange="buscaValor1Tabelas(this.value,this.name,'Valor',<?php echo $i ?>,'Servico')" <?php echo $readonly; ?>
																								id="listadinamica<?php echo $i ?>" name="idTab_Servico<?php echo $i ?>">																					
																							<option value="">-- Selecione uma op��o --</option>
																							<?php
																							/*
																							foreach ($select['Servico'] as $key => $row) {
																								if ($servico[$i]['idTab_Produto'] == $key) {
																									echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																								} else {
																									echo '<option value="' . $key . '">' . $row . '</option>';
																								}
																							}
																							*/
																							?>
																						</select>
																					</div>
																				</div>
																				-->
																				<div class="row">
																					<div class="col-md-2">
																						<label for="QtdServico">Qtd</label>
																						<input type="text" class="form-control Numero" maxlength="10" id="QtdServico<?php echo $i ?>" placeholder="0"
																								onkeyup="calculaSubtotal(this.value,this.name,'<?php echo $i ?>','QTD','Servico'),calculaQtdSomaDev('QtdServico','QtdSomaDev','ServicoSoma',0,0,'CountMax2',0,'ServicoHidden')"
																								 name="QtdServico<?php echo $i ?>" value="<?php echo $servico[$i]['QtdProduto'] ?>">
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
																								if ($servico[$i]['ProfissionalProduto'] == $key) {
																									echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																								} else {
																									echo '<option value="' . $key . '">' . $row . '</option>';
																								}
																							}
																							?>
																						</select>
																					</div>
																					<input type="hidden" class="form-control Numero" id="QtdIncrementoServico<?php echo $i ?>" name="QtdIncrementoServico<?php echo $i ?>" value="<?php echo $servico[$i]['QtdIncrementoProduto'] ?>">
																					<input type="hidden" class="form-control " id="SubtotalComissaoServico<?php echo $i ?>" name="SubtotalComissaoServico<?php echo $i ?>" value="<?php echo $servico[$i]['SubtotalComissaoProduto'] ?>">
																					<input type="hidden" class="form-control " id="SubtotalQtdServico<?php echo $i ?>" name="SubtotalQtdServico<?php echo $i ?>" value="<?php echo $servico[$i]['SubtotalQtdProduto'] ?>">
																					<div class="col-md-3">
																						<label for="ValorServico">Valor do Servi�o</label>
																						<div class="input-group">
																							<span class="input-group-addon" id="basic-addon1">R$</span>
																							<input type="text" class="form-control Valor" id="idTab_Servico<?php echo $i ?>" maxlength="10" placeholder="0,00"
																								onkeyup="calculaSubtotal(this.value,this.name,'<?php echo $i ?>','VP','Servico')"
																								name="ValorServico<?php echo $i ?>" value="<?php echo $servico[$i]['ValorProduto'] ?>">
																						</div>
																					</div>
																					<div class="col-md-3">
																						<label for="SubtotalServico">Sub.Valor.Serv:</label>
																						<div class="input-group">
																							<span class="input-group-addon" id="basic-addon1">R$</span>
																							<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" readonly="" id="SubtotalServico<?php echo $i ?>"
																								   name="SubtotalServico<?php echo $i ?>" value="<?php echo $servico[$i]['SubtotalProduto'] ?>">
																						</div>
																					</div>
																				</div>
																				<div class="row">
																					<div class="col-md-12">
																						<label for="ObsServico">Observacao</label>
																						<input type="text" class="form-control" maxlength="200" id="ObsServico<?php echo $i ?>" placeholder="Observacao"
																								 name="ObsServico<?php echo $i ?>" value="<?php echo $servico[$i]['ObsProduto'] ?>">
																					</div>
																				</div>
																			</div>
																			<div class="col-md-4">
																				<div class="row">
																					<div class="col-md-1 text-left">
																						<label><br></label><br>
																						<button type="button" id="<?php echo $i ?>" class="remove_field10 btn btn-danger"
																							onclick="calculaQtdSomaDev('QtdServico','QtdSomaDev','ServicoSoma',1,<?php echo $i ?>,'CountMax2',0,'ServicoHidden')">
																							<span class="glyphicon glyphicon-trash"></span>
																						</button>
																					</div>
																				</div>
																				<div class="row">
																					<div class="col-md-6 text-left">
																						<label for="ConcluidoServico">Entregue? </label><br>
																						<?php if ($_SESSION['Usuario']['Bx_Prd'] == "S") { ?>
																							<div class="btn-group" data-toggle="buttons">
																								<?php
																								foreach ($select['ConcluidoServico'] as $key => $row) {
																									if (!$servico[$i]['ConcluidoProduto'])$servico[$i]['ConcluidoProduto'] = 'N';
																									($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																									if ($servico[$i]['ConcluidoProduto'] == $key) {
																										echo ''
																										. '<label class="btn btn-warning active" name="ConcluidoServico' . $i . '_' . $hideshow . '">'
																										. '<input type="radio" name="ConcluidoServico' . $i . '" id="' . $hideshow . '" '
																										. 'onchange="carregaEntregueSrv(this.value,this.name,'.$i.',0)" '
																										. 'autocomplete="off" value="' . $key . '" checked>' . $row
																										. '</label>'
																										;
																									} else {
																										echo ''
																										. '<label class="btn btn-default" name="ConcluidoServico' . $i . '_' . $hideshow . '">'
																										. '<input type="radio" name="ConcluidoServico' . $i . '" id="' . $hideshow . '" '
																										. 'onchange="carregaEntregueSrv(this.value,this.name,'.$i.',0)" '
																										. 'autocomplete="off" value="' . $key . '" >' . $row
																										. '</label>'
																										;
																									}
																								}
																								?>
																							</div>
																						<?php }else{ ?>
																							<input type="hidden" name="ConcluidoServico<?php echo $i ?>" id="ConcluidoServico<?php echo $i ?>"  value="<?php echo $servico[$i]['ConcluidoProduto']; ?>"/>
																							<span>
																								<?php 
																									if($servico[$i]['ConcluidoProduto'] == "S") {
																											echo 'Sim';
																									} elseif($servico[$i]['ConcluidoProduto'] == "N"){
																										echo 'N�o';
																									}else{
																										echo 'N�o';
																									}
																								?>
																							</span>
																						<?php } ?>
																					</div>
																				</div>
																				<div id="ConcluidoServico<?php echo $i ?>" <?php echo $div['ConcluidoServico' . $i]; ?>>
																					<div class="row">
																						<div class="col-md-6">
																							<label for="DataConcluidoServico">Data Entregue</label>
																							<div class="input-group DatePicker">
																								<span class="input-group-addon" disabled>
																									<span class="glyphicon glyphicon-calendar"></span>
																								</span>
																								<input type="text" class="form-control Date" id="DataConcluidoServico<?php echo $i ?>" maxlength="10" placeholder="DD/MM/AAAA"
																									   name="DataConcluidoServico<?php echo $i ?>" value="<?php echo $servico[$i]['DataConcluidoProduto'] ?>">
																							</div>
																						</div>
																						<div class="col-md-6">
																							<label for="HoraConcluidoServico">Hora Entregue</label>
																							<div class="input-group <?php echo $timepicker; ?>">
																								<span class="input-group-addon">
																									<span class="glyphicon glyphicon-time"></span>
																								</span>
																								<input type="text" class="form-control Time" <?php echo $readonly; ?> maxlength="5"  placeholder="HH:MM"
																									   accept="" name="HoraConcluidoServico<?php echo $i ?>" id="HoraConcluidoServico<?php echo $i ?>" value="<?php echo $servico[$i]['HoraConcluidoProduto']; ?>">
																							</div>
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>

															<?php
															$QtdSomaDev+=$servico[$i]['QtdProduto'];
															$ServicoSoma++;
															}
															?>
														</div>
														
														<input type="hidden" name="CountMax2" id="CountMax2" value="<?php echo $ServicoSoma ?>">
														
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
																								<div  id="txtHint">
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
														<div class="panel panel-default">
															<div class="panel-heading text-left">
																<div class="row">
																	
																	<div class="col-md-3 text-center">
																		
																		<a class="add_field_button10  btn btn-danger" 
																				onclick="calculaQtdSomaDev('QtdServico','QtdSomaDev','ServicoSoma',0,0,'CountMax2',1,0)">
																			<span class="glyphicon glyphicon-arrow-up"></span> Adicionar Servi�os
																		</a>
																		
																	</div>
																	
																	<div class="col-md-3 text-center">	
																		<b>Linhas: <span id="ServicoSoma"><?php echo $ServicoSoma ?></span></b><br />
																	</div>
																	<div class="col-md-6">
																		<div class="panel panel-danger">
																			<div class="panel-heading">
																				<div class="row">
																					<!--
																					<div class="col-md-6">
																						<div class="row">
																							<div class="col-md-12 text-left">	
																								<b>Servi�os: <span class="text-right" id="QtdSomaDev"><?php echo $QtdSomaDev ?></span> </b>
																							</div>
																						</div>
																					</div>
																					-->
																					<div class="col-md-6">
																						<div class="row">
																							<div class="col-md-4 text-left">	
																								<b>Servi�os: </b> 
																							</div>
																							<div class="col-md-8">
																								<div  id="txtHint">
																									<input type="text" class="form-control text-right Numero" id="QtdSrvOrca" maxlength="10" readonly=""
																										   name="QtdSrvOrca" value="<?php echo $orcatrata['QtdSrvOrca'] ?>">
																										   
																								</div>
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
														
														<br>
													</div>
												<?php } ?>

													<!-- soma dos produtos, servi�os e total do or�amento-->
													
													<div class="row">
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
														<div class="col-md-4">
															<div class="panel panel-default">
																<div class="panel-heading">
																	<div class="row">
																		<div class="col-md-6">
																			<label for="ValorExtraOrca">Outros:</label>
																			<div class="input-group" id="txtHint">
																				<span class="input-group-addon " id="basic-addon1">R$</span>
																				<input type="text" class="form-control Valor" id="ValorExtraOrca" maxlength="10" placeholder="0,00" 
																					   data-toggle="collapse" onkeyup="calculaParcelas(),calculaTotal(this.value)" onchange="calculaParcelas(),calculaTotal(this.value)" onkeydown="calculaParcelas(),calculaTotal(this.value)"
																						data-target="#Parcelas" aria-expanded="false" aria-controls="Parcelas"
																					   name="ValorExtraOrca" value="<?php echo $orcatrata['ValorExtraOrca'] ?>">
																			</div>
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
																		<div class="col-md-6">
																			<label for="ValorRestanteOrca">Prd + Srv:</label><br>
																			<div class="input-group" id="txtHint">
																				<span class="input-group-addon" id="basic-addon1">R$</span>
																				<input type="text" class="form-control Valor" id="ValorRestanteOrca" maxlength="10" placeholder="0,00" readonly=''
																					   data-toggle="collapse" onkeyup="calculaParcelas(),calculaTotal(this.value)" onchange="calculaParcelas()" onkeydown="calculaParcelas()"
																						data-target="#Parcelas" aria-expanded="false" aria-controls="Parcelas"
																					   name="ValorRestanteOrca" value="<?php echo $orcatrata['ValorRestanteOrca'] ?>">
																			</div>
																		</div>
																		<div class="col-md-6">
																			<label for="ValorSomaOrca">Extra + Prd + Srv:</label><br>
																			<div class="input-group" id="txtHint">
																				<span class="input-group-addon" id="basic-addon1">R$</span>
																				<input type="text" class="form-control Valor" id="ValorSomaOrca" maxlength="10" placeholder="0,00" readonly=''
																					   data-toggle="collapse" onkeyup="calculaParcelas(),calculaTotal(this.value)" onchange="calculaParcelas()" onkeydown="calculaParcelas()"
																						data-target="#Parcelas" aria-expanded="false" aria-controls="Parcelas"
																					   name="ValorSomaOrca" value="<?php echo $orcatrata['ValorSomaOrca'] ?>">
																			</div>
																		</div>
																	</div>	
																</div>
															</div>
														</div>
														<?php }else{ ?>
															<input type="hidden" name="ValorRestanteOrca" id="ValorRestanteOrca" value="<?php echo $orcatrata['ValorRestanteOrca'] ?>"/>
															<input type="hidden" name="ValorSomaOrca" id="ValorSomaOrca" value="<?php echo $orcatrata['ValorSomaOrca'] ?>"/>
														<?php } ?>
													</div>
												</div>
											</div>
										<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
										<br>
										<div class="panel panel-info">
											<div class="panel-heading">	
												<h4 class="mb-3"><b>Entrega</b></h4>
												<div class="row">
													<div class="col-md-8 text-left">
														<label for="TipoFrete">Forma de Entrega:</label><br>
														<div class="btn-block" data-toggle="buttons">
															<?php
															foreach ($select['TipoFrete'] as $key => $row) {
																(!$orcatrata['TipoFrete']) ? $orcatrata['TipoFrete'] = '1' : FALSE;
																#if (!$orcatrata['TipoFrete'])$orcatrata['TipoFrete'] = 1;
																($key == '1') ? $hideshow = 'hideradio' : $hideshow = 'showradio';
																if ($orcatrata['TipoFrete'] == $key) {
																	echo ''
																	. '<label class="btn btn-default active" name="radio" id="radio' . $key . '">'
																	. '<input type="radio" name="TipoFrete" id="' . $hideshow . '" '
																	. 'autocomplete="off" value="' . $key . '" checked>' . $row
																	. '</label>'
																	;
																} else {
																	echo ''
																	. '<label class="btn btn-default" name="radio" id="radio' . $key . '">'
																	. '<input type="radio" name="TipoFrete" id="' . $hideshow . '"'
																	. 'autocomplete="off" value="' . $key . '" >' . $row
																	. '</label>'
																	;
																}
															}
															?>
														</div>
													</div>
													<div class="col-md-4 text-left">
														<label for="DetalhadaEntrega">Personalizada?</label><br>
														<div class="btn-group" data-toggle="buttons">
															<?php
															foreach ($select['DetalhadaEntrega'] as $key => $row) {
																if (!$orcatrata['DetalhadaEntrega']) $orcatrata['DetalhadaEntrega'] = 'N';

																($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																if ($orcatrata['DetalhadaEntrega'] == $key) {
																	echo ''
																	. '<label class="btn btn-warning active" name="DetalhadaEntrega_' . $hideshow . '">'
																	. '<input type="radio" name="DetalhadaEntrega" id="' . $hideshow . '" '
																	. 'onchange="calculaParcelas(),formaPag(this.value)" '
																	. 'autocomplete="off" value="' . $key . '" checked>' . $row
																	. '</label>'
																	;
																} else {
																	echo ''
																	. '<label class="btn btn-default" name="DetalhadaEntrega_' . $hideshow . '">'
																	. '<input type="radio" name="DetalhadaEntrega" id="' . $hideshow . '" '
																	. 'onchange="calculaParcelas(),formaPag(this.value)" '
																	. 'autocomplete="off" value="' . $key . '" >' . $row
																	. '</label>'
																	;
																}
															}
															?>
														</div>
														<?php echo form_error('DetalhadaEntrega'); ?>
													</div>
												</div>
												<br>
												<div id="TipoFrete" <?php echo $div['TipoFrete']; ?>>
												
													<input type="hidden" name="CepOrigem" id="CepOrigem" placeholder="CepOrigem" value="<?php echo $_SESSION['Empresa']['CepEmpresa'];?>">
													<input type="hidden" name="Peso" id="Peso" placeholder="Peso" value="1">
													<input type="hidden" name="Formato" id="Formato" placeholder="Formato" value="1">
													<input type="hidden" name="Comprimento" id="Comprimento" placeholder="Comprimento" value="30">
													<input type="hidden" name="Largura" id="Largura" placeholder="Largura" value="15">									
													<input type="hidden" name="Altura" id="Altura" placeholder="Altura" value="5">
													<input type="hidden" name="Diametro" id="Diametro" placeholder="Diametro" value="0">		
													<input type="hidden" name="MaoPropria" id="MaoPropria" placeholder="MaoPropria" value="N">
													<input type="hidden" name="ValorDeclarado" id="ValorDeclarado" placeholder="ValorDeclarado" value="0">
													<input type="hidden" name="AvisoRecebimento" id="AvisoRecebimento" placeholder="AvisoRecebimento" value="N">
										
													<div class="row ">
														<div class="col-md-2 mb-3 ">	
															<label >Buscar End.</label>
															<!--<button class=" form-control btn btn-lg btn-success" type="button" onclick="Procuraendereco(), LoadFrete(), calculaTotal(), calculaParcelas()" >Buscar</button>-->
															<button class=" form-control btn btn-lg btn-success" type="button" onclick="Procuraendereco(), calculaTotal(), calculaParcelas()" >Buscar</button>
														</div>
														<div class="col-md-2 ">
															<label class="" for="Cep">Cep:</label>
															<input type="text" class="form-control " id="Cep" maxlength="8" <?php echo $readonly; ?>
																   name="Cep" value="<?php echo $orcatrata['Cep']; ?>">
														</div>
														<div class="col-md-4 ">
															<label class="" for="Logradouro">Endre�o:</label>
															<input type="text" class="form-control " id="Logradouro" maxlength="100" <?php echo $readonly; ?>
																   name="Logradouro" value="<?php echo $orcatrata['Logradouro']; ?>">
														</div>
														<div class="col-md-2 ">
															<label class="" for="Numero">N�mero:</label>
															<input type="text" class="form-control " id="Numero" maxlength="100" <?php echo $readonly; ?>
																   name="Numero" value="<?php echo $orcatrata['Numero']; ?>">
														</div>
														<div class="col-md-2 ">
															<label class="" for="Complemento">Complemento:</label>
															<input type="text" class="form-control " id="Complemento" maxlength="100" <?php echo $readonly; ?>
																   name="Complemento" value="<?php echo $orcatrata['Complemento']; ?>">
														</div>
														<div class="col-md-4 ">
															<label class="" for="Bairro">Bairro:</label>
															<input type="text" class="form-control " id="Bairro" maxlength="100" <?php echo $readonly; ?>
																   name="Bairro" value="<?php echo $orcatrata['Bairro']; ?>">
														</div>
														<div class="col-md-4 ">
															<label class="" for="Cidade">Cidade:</label>
															<input type="text" class="form-control " id="Cidade" maxlength="100" <?php echo $readonly; ?>
																   name="Cidade" value="<?php echo $orcatrata['Cidade']; ?>">
														</div>
														<div class="col-md-2 ">
															<label class="" for="Estado">Estado:</label>
															<input type="text" class="form-control " id="Estado" maxlength="2" <?php echo $readonly; ?>
																   name="Estado" value="<?php echo $orcatrata['Estado']; ?>">
														</div>
														<div class="col-md-2 ">
															<label class="" for="Referencia">Referencia:</label>
															<textarea class="form-control " id="Referencia" <?php echo $readonly; ?>
																	  name="Referencia"><?php echo $orcatrata['Referencia']; ?>
															</textarea>
														</div>
													</div>	
													<div class="row ">
														<div class="col-md-8 text-left"></div>
														<div class="col-md-4 text-left">
															<label for="AtualizaEndereco">Atualizar End.?</label><br>
															<div class="btn-group" data-toggle="buttons">
																<?php
																foreach ($select['AtualizaEndereco'] as $key => $row) {
																	if (!$cadastrar['AtualizaEndereco'])$cadastrar['AtualizaEndereco'] = 'N';

																	($key == 'N') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																	if ($cadastrar['AtualizaEndereco'] == $key) {
																		echo ''
																		. '<label class="btn btn-warning active" name="AtualizaEndereco_' . $hideshow . '">'
																		. '<input type="radio" name="AtualizaEndereco" id="' . $hideshow . '" '
																		. 'autocomplete="off" value="' . $key . '" checked>' . $row
																		. '</label>'
																		;
																	} else {
																		echo ''
																		. '<label class="btn btn-default" name="AtualizaEndereco_' . $hideshow . '">'
																		. '<input type="radio" name="AtualizaEndereco" id="' . $hideshow . '" '
																		. 'autocomplete="off" value="' . $key . '" >' . $row
																		. '</label>'
																		;
																	}
																}
																?>
															</div>
														</div>
														<!--
														<div class="col-md-3">
															<label for="Municipio">Munic�pio:</label><br>
															<select data-placeholder="Selecione um Munic�pio..." class="form-control" <?php echo $disabled; ?>
																	id="Municipio" name="Municipio">
																<option value="">-- Selec.um Munic�pio --</option>
																<?php
																foreach ($select['Municipio'] as $key => $row) {
																	if ($orcatrata['Municipio'] == $key) {
																		echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																	} else {
																		echo '<option value="' . $key . '">' . $row . '</option>';
																	}
																}
																?>
															</select>
														</div>
														-->
														
													</div>
													<br>
												</div>
												<div id="DetalhadaEntrega" <?php echo $div['DetalhadaEntrega']; ?>>
													<div class="row">	
														<div class="col-md-4 ">
															<label class="" for="NomeRec">Nome Recebedor:</label>
															<input type="text" class="form-control " id="NomeRec" maxlength="100" <?php echo $readonly; ?>
																   name="NomeRec" value="<?php echo $orcatrata['NomeRec']; ?>">
														</div>
														<div class="col-md-4 ">
															<label class="" for="TelefoneRec">Telefone:</label>
															<input type="text" class="form-control Celular CelularVariavel" id="TelefoneRec" maxlength="11" <?php echo $readonly; ?>
																   name="TelefoneRec" placeholder="(XX)999999999" value="<?php echo $orcatrata['TelefoneRec']; ?>">
														</div>
														<div class="col-md-4 ">
															<label class="" for="ParentescoRec">Parentesco:</label>
															<input type="text" class="form-control " id="ParentescoRec" maxlength="100" <?php echo $readonly; ?>
																   name="ParentescoRec" value="<?php echo $orcatrata['ParentescoRec']; ?>">
														</div>
													</div>	
													<div class="row">	
														<div class="col-md-4 ">
															<label class="" for="Aux1Entrega">Aux1:</label>
															<input type="text" class="form-control " id="Aux1Entrega" maxlength="100" <?php echo $readonly; ?>
																   name="Aux1Entrega" value="<?php echo $orcatrata['Aux1Entrega']; ?>">
														</div>
														<div class="col-md-4 ">
															<label class="" for="Aux2Entrega">Aux2:</label>
															<input type="text" class="form-control " id="Aux2Entrega" maxlength="100" <?php echo $readonly; ?>
																   name="Aux2Entrega" value="<?php echo $orcatrata['Aux2Entrega']; ?>">
														</div>
														<div class="col-md-4 ">
															<label class="" for="ObsEntrega">Obs Entrega:</label>
															<textarea class="form-control " id="ObsEntrega" <?php echo $readonly; ?>
																	  name="ObsEntrega"><?php echo $orcatrata['ObsEntrega']; ?>
															</textarea>
														</div>
													</div>
													<br>
												</div>
												<div class="row">
													<div class="col-md-4">
														<div class="panel panel-default">
															<div class="panel-heading">
																<div class="row">
																	<div class="col-md-12 mb-3">
																		<label for="DataEntregaOrca">Data da Entrega</label>
																		<div class="input-group <?php echo $datepicker; ?>">
																			<span class="input-group-addon" disabled>
																				<span class="glyphicon glyphicon-calendar"></span>
																			</span>
																			<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA" onchange="dateDiff()"
																		id="DataEntregaOrca" name="DataEntregaOrca" value="<?php echo $orcatrata['DataEntregaOrca']; ?>">
																		</div>
																	</div>
																</div>	
															</div>
														</div>
													</div>
													<div class="col-md-4">
														<div class="row">
															<div class="col-md-12">
																<div class="panel panel-default">
																	<div class="panel-heading">
																		<div class="row">
																			<div class="col-md-6 mb-3">
																				<label for="PrazoEntrega">Prazo (em dias)</label>
																				<input type="text" class="form-control " id="PrazoEntrega" maxlength="100" <?php echo $readonly; ?> readonly=""
																					   name="PrazoEntrega" value="<?php echo $orcatrata['PrazoEntrega']; ?>">
																			</div>	
																			<div class="col-md-6 mb-3">
																				<label for="HoraEntregaOrca">Hora da Entrega:</label>
																				<div class="input-group <?php echo $timepicker; ?>">
																					<span class="input-group-addon">
																						<span class="glyphicon glyphicon-time"></span>
																					</span>
																					<input type="text" class="form-control Time" <?php echo $readonly; ?> maxlength="5"  placeholder="HH:MM"
																						   accept=""name="HoraEntregaOrca" value="<?php echo $orcatrata['HoraEntregaOrca']; ?>">
																				</div>
																			</div>
																		</div>	
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="col-md-4">
														<div class="panel panel-default">
															<div class="panel-heading">
																<div class="row">
																	<div class="col-md-12">
																		<label for="ValorFrete">Taxa de Entrega:</label><br>
																		<div class="input-group" id="txtHint">
																			<span class="input-group-addon" id="basic-addon1">R$</span>
																			<input type="text" class="form-control Valor" id="ValorFrete" maxlength="10" placeholder="0,00" 
																				   onkeyup="calculaTotal(this.value),calculaParcelas(),calculaTroco()"
																				   name="ValorFrete" value="<?php echo $orcatrata['ValorFrete'] ?>">
																		</div>
																	</div>																
																</div>	
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<?php }else{ ?>
											<input type="hidden" name="ValorFrete" id="ValorFrete" value="<?php echo $orcatrata['ValorFrete'] ?>"/>
										<?php } ?>													
										<br>	
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
																		<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" 
																				onchange="exibirTroco(this.value),dateDiff()"<?php echo $readonly; ?>
																				id="FormaPagamento" name="FormaPagamento">
																			<option value="">-- Selecione uma op��o --</option>
																			<?php
																			foreach ($select['FormaPagamento'] as $key => $row) {
																				if ($orcatrata['FormaPagamento'] == $key) {
																					echo'<option value="' . $key . '" selected="selected">' . $row . '</option>';
																				} else {
																					echo'<option value="' . $key . '">' . $row . '</option>';
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
																				($key != 'V') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
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
													<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
													
													<div class="col-md-4">
														<div class="panel panel-default">
															<div class="panel-heading">
																<div class="row">
																	<div class="col-md-6">
																		<label for="ValorTotalOrca">Total do Pedido:</label><br>
																		<div class="input-group" id="txtHint">
																			<span class="input-group-addon" id="basic-addon1">R$</span>
																			<input type="text" class="form-control Valor" id="ValorTotalOrca" maxlength="10" placeholder="0,00" readonly=''
																				   data-toggle="collapse" onkeyup="calculaParcelas(),calculaTotal(this.value),calculaTroco()" onchange="calculaParcelas(),calculaTotal(this.value),calculaTroco()" onkeydown="calculaParcelas(),calculaTotal(this.value),calculaTroco()"
																					data-target="#Parcelas" aria-expanded="false" aria-controls="Parcelas"
																				   name="ValorTotalOrca" value="<?php echo $orcatrata['ValorTotalOrca'] ?>">
																		</div>
																	</div>
																	<div class="col-md-6 text-left">
																		<label for="BrindeOrca">Permitir Total= 0,00 ?</label><br>
																		<div class="btn-group" data-toggle="buttons">
																			<?php
																			foreach ($select['BrindeOrca'] as $key => $row) {
																				if (!$orcatrata['BrindeOrca'])$orcatrata['BrindeOrca'] = 'N';

																				($key == 'N') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																				if ($orcatrata['BrindeOrca'] == $key) {
																					echo ''
																					. '<label class="btn btn-warning active" name="BrindeOrca_' . $hideshow . '">'
																					. '<input type="radio" name="BrindeOrca" id="' . $hideshow . '" '
																					. 'autocomplete="off" value="' . $key . '" checked>' . $row
																					. '</label>'
																					;
																				} else {
																					echo ''
																					. '<label class="btn btn-default" name="BrindeOrca_' . $hideshow . '">'
																					. '<input type="radio" name="BrindeOrca" id="' . $hideshow . '" '
																					. 'autocomplete="off" value="' . $key . '" >' . $row
																					. '</label>'
																					;
																				}
																			}
																			?>
																		</div>
																	</div>																
																</div>
																<div id="BrindeOrca" <?php echo $div['BrindeOrca']; ?>>
																<?php echo form_error('BrindeOrca'); ?>
																</div>
																<div class="row">	
																	<div class="col-md-6">
																		<label for="ValorDinheiro">Troco para:</label><br>
																		<div class="input-group" id="txtHint">
																			<span class="input-group-addon" id="basic-addon1">R$</span>
																			<input type="text" class="form-control Valor" id="ValorDinheiro" maxlength="10" placeholder="0,00" 
																				   onkeyup="calculaTroco(this.value)" onchange="calculaTroco(this.value)"
																				   name="ValorDinheiro" value="<?php echo $orcatrata['ValorDinheiro'] ?>">
																		</div>
																	</div>	
																	<div class="col-md-6">
																		<label for="ValorTroco">Troco:</label><br>
																		<div class="input-group" id="txtHint">
																			<span class="input-group-addon" id="basic-addon1">R$</span>
																			<input type="text" class="form-control Valor" id="ValorTroco" maxlength="10" placeholder="0,00" 
																					
																				   name="ValorTroco" value="<?php echo $orcatrata['ValorTroco'] ?>">
																		</div>
																	</div>
																</div>	
															</div>
														</div>
													</div>
													<?php } ?>											
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
												<div class="row">
												<input type="hidden" name="Modalidade" value="<?php echo $orcatrata['Modalidade'] ?>"/>
													<div class="col-md-3">
														<label>Dividido/ Mensal</label><br>
														<span>
															<?php 
																if($orcatrata['Modalidade'] == "P") {
																	echo 'Dividido';
																} elseif($orcatrata['Modalidade'] == "M"){
																	echo 'Mensal';
																}else{
																	echo 'Mensal';
																}
															?>
														</span>
													</div>
													<input type="hidden" name="QtdParcelasOrca" id="QtdParcelasOrca" value="<?php echo $orcatrata['QtdParcelasOrca'] ?>"/>
													<input type="hidden" name="DataVencimentoOrca" id="DataVencimentoOrca" value="<?php echo $orcatrata['DataVencimentoOrca'] ?>"/>																
												</div>
												<!--App_parcelasRec-->
												<br>
												<?php echo form_error('ValorTotalOrca');?>
												
												<input type="hidden" name="PRCount" id="PRCount" value="<?php echo $count['PRCount']; ?>"/>
												<div class="input_fields_wrap21">
														<?php
														for ($i=1; $i <= $count['PRCount']; $i++) {
														?>

															<?php if ($metodo > 1) { ?>
															<input type="hidden" name="idApp_Parcelas<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['idApp_Parcelas']; ?>"/>
															<?php } ?>

															<div class="form-group" id="21div<?php echo $i ?>">
																<div class="panel panel-warning">
																	<div class="panel-heading">
																		<div class="row">
																			<div class="col-md-2">
																				<label for="Parcela">Parcela <?php echo $i ?>:</label><br>
																				<input type="text" class="form-control" maxlength="6" 
																					   name="Parcela<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['Parcela'] ?>">
																			</div>
																			<div class="col-md-2">
																				<label for="ValorParcela">Valor:</label><br>
																				<div class="input-group" id="txtHint">
																					<span class="input-group-addon" id="basic-addon1">R$</span>
																					<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" id="ValorParcela<?php echo $i ?>"
																						   name="ValorParcela<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['ValorParcela'] ?>">
																				</div>
																			</div>
																			<div class="col-md-2">
																				<label for="DataVencimento">Vencimento</label>
																				<div class="input-group DatePicker">
																					<span class="input-group-addon" disabled>
																						<span class="glyphicon glyphicon-calendar"></span>
																					</span>
																					<input type="text" class="form-control Date" id="DataVencimento<?php echo $i ?>" maxlength="10" placeholder="DD/MM/AAAA"
																						   name="DataVencimento<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['DataVencimento'] ?>">																
																				</div>
																			</div>
																			<div class="col-md-2">
																				<label for="Quitado">Parc. Paga?</label><br>
																				<?php if ($_SESSION['Usuario']['Bx_Pag'] == "S") { ?>
																					<div class="btn-group" data-toggle="buttons">
																						<?php
																						/*
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
																						*/
																						foreach ($select['Quitado'] as $key => $row) {
																							if (!$parcelasrec[$i]['Quitado'])$parcelasrec[$i]['Quitado'] = 'N';
																							($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																							if ($parcelasrec[$i]['Quitado'] == $key) {
																								echo ''
																								. '<label class="btn btn-warning active" name="Quitado' . $i . '_' . $hideshow . '">'
																								. '<input type="radio" name="Quitado' . $i . '" id="' . $hideshow . '" '
																								. 'onchange="carregaQuitado(this.value,this.name,'.$i.')" '
																								. 'autocomplete="off" value="' . $key . '" checked>' . $row
																								. '</label>'
																								;
																							} else {
																								echo ''
																								. '<label class="btn btn-default" name="Quitado' . $i . '_' . $hideshow . '">'
																								. '<input type="radio" name="Quitado' . $i . '" id="' . $hideshow . '" '
																								. 'onchange="carregaQuitado(this.value,this.name,'.$i.')" '
																								. 'autocomplete="off" value="' . $key . '" >' . $row
																								. '</label>'
																								;
																							}
																						}
																						?>
																					</div>
																				<?php }else{ ?>
																					<input type="hidden" name="Quitado<?php echo $i ?>" id="Quitado<?php echo $i ?>"  value="<?php echo $parcelasrec[$i]['Quitado']; ?>"/>
																					<span><?php if($parcelasrec[$i]['Quitado'] == "S") {
																									echo 'Sim';
																								} elseif($parcelasrec[$i]['Quitado'] == "N"){
																									echo 'N�o';
																								}else{
																									echo 'N�o';
																								}?>
																					</span>
																				<?php } ?>
																			</div>
																			<div class="col-md-2">
																				<div id="Quitado<?php echo $i ?>" <?php echo $div['Quitado' . $i]; ?>>
																					<label for="DataPago">Pagamento</label>
																					<div class="input-group DatePicker">
																						<span class="input-group-addon" disabled>
																							<span class="glyphicon glyphicon-calendar"></span>
																						</span>
																						<input type="text" class="form-control Date" id="DataPago<?php echo $i ?>" maxlength="10" placeholder="DD/MM/AAAA" 
																								<?php if ($_SESSION['Usuario']['Bx_Pag'] == "N") echo 'readonly=""' ?>
																							   name="DataPago<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['DataPago'] ?>">
																						
																					</div>
																				</div>
																			</div>
																			<!--
																			<div class="col-md-2">
																				<label for="idSis_Usuario<?php echo $i ?>">Cobrador:</label>
																				<?php if ($i == 1) { ?>
																				<?php } ?>
																				<select data-placeholder="Selecione uma op��o..." class="form-control"
																						 id="listadinamicac<?php echo $i ?>" name="idSis_Usuario<?php echo $i ?>">
																					<option value="">-- Sel.Profis. --</option>
																					<?php
																					/*
																					foreach ($select['idSis_Usuario'] as $key => $row) {
																						(!$parcelasrec['idSis_Usuario']) ? $parcelasrec['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario']: FALSE;
																						if ($parcelasrec[$i]['idSis_Usuario'] == $key) {
																							echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																						} else {
																							echo '<option value="' . $key . '">' . $row . '</option>';
																						}
																					}
																					*/
																					?>
																				</select>
																			</div>
																			
																			<div class="col-md-1">
																				<label><br></label><br>
																				<button type="button" id="<?php echo $i ?>" class="remove_field21 btn btn-danger">
																					<span class="glyphicon glyphicon-trash"></span>
																				</button>
																			</div>
																			-->
																		</div>
																	</div>
																</div>
															</div>

														<?php
														}
														?>
												</div>
												<div class="panel panel-warning">
													<div class="panel-heading text-left">
														<div class="row">
															<div class="col-md-3 form-inline">
																<label></label>
																<button class="btn btn-warning" type="button" data-toggle="collapse" onclick="adicionaParcelas()"
																		data-target="#Parcelas" aria-expanded="false" aria-controls="Parcelas">
																	<span class="glyphicon glyphicon-plus"></span> Adic. Parcelas
																</button>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
											<br>
											<div class="panel panel-default">
												<div class="panel-heading text-left">
													<h4 class="mb-3"><b>Procedimentos</b></h4>
													<!--
													<a class="btn btn-primary" type="button" data-toggle="collapse" data-target="#Procedimentos" aria-expanded="false" aria-controls="Procedimentos">
														<span class="glyphicon glyphicon-menu-down"></span> Procedimentos
													</a>
													-->
													<div <?php echo $collapse; ?> id="Procedimentos">
														

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
																			<input type="hidden" name="idSis_Usuario<?php echo $i ?>" id="idSis_Usuario<?php echo $i ?>" value="<?php echo $procedimento[$i]['idSis_Usuario'] ?>"/>
																			<label for="Procedimento<?php echo $i ?>">
																				Proced. <?php echo $i ?>: 
																				<?php if ($procedimento[$i]['idSis_Usuario']) { ?>
																					<?php echo $_SESSION['Procedimento'][$i]['Nome'];?>
																				<?php } ?>
																			</label>
																			<textarea class="form-control" id="Procedimento<?php echo $i ?>" <?php echo $readonly; ?>
																					  name="Procedimento<?php echo $i ?>"><?php echo $procedimento[$i]['Procedimento']; ?></textarea>
																		</div>
																		<div class="col-md-4">
																			<label for="Compartilhar<?php echo $i ?>">Quem Fazer:</label>
																			<?php if ($i == 1) { ?>
																			<?php } ?>
																			<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" 
																					 id="listadinamica_comp<?php echo $i ?>" name="Compartilhar<?php echo $i ?>">
																				<option value="">-- Selecione uma op��o --</option>
																				<?php
																				foreach ($select['Compartilhar'] as $key => $row) {
																					if ($procedimento[$i]['Compartilhar'] == $key) {
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
																		<div class="col-md-2">
																			<label for="DataProcedimento<?php echo $i ?>">Data do Proced.:</label>
																			<div class="input-group <?php echo $datepicker; ?>">
																				<span class="input-group-addon" disabled>
																					<span class="glyphicon glyphicon-calendar"></span>
																				</span>
																				<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																					   name="DataProcedimento<?php echo $i ?>" id="DataProcedimento<?php echo $i ?>" value="<?php echo $procedimento[$i]['DataProcedimento']; ?>">
																			</div>
																		</div>
																		<div class="col-md-2">
																			<label for="HoraProcedimento<?php echo $i ?>">Hora Concl</label>
																			<div class="input-group <?php echo $timepicker; ?>">
																				<span class="input-group-addon" disabled>
																					<span class="glyphicon glyphicon-time"></span>
																				</span>
																				<input type="text" class="form-control Time" <?php echo $readonly; ?> maxlength="5" placeholder="HH:MM"
																					   name="HoraProcedimento<?php echo $i ?>" id="HoraProcedimento<?php echo $i ?>" value="<?php echo $procedimento[$i]['HoraProcedimento']; ?>">
																			</div>
																		</div>
																		<div class="col-md-2 text-left">
																			<label for="ConcluidoProcedimento">Concluido? </label><br>
																			<?php if ($_SESSION['Usuario']['Bx_Prc'] == "S") { ?>
																				<div class="btn-group" data-toggle="buttons">
																					<?php
																					foreach ($select['ConcluidoProcedimento'] as $key => $row) {
																						if (!$procedimento[$i]['ConcluidoProcedimento'])$procedimento[$i]['ConcluidoProcedimento'] = 'N';
																						($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																						if ($procedimento[$i]['ConcluidoProcedimento'] == $key) {
																							echo ''
																							. '<label class="btn btn-warning active" name="ConcluidoProcedimento' . $i . '_' . $hideshow . '">'
																							. '<input type="radio" name="ConcluidoProcedimento' . $i . '" id="' . $hideshow . '" '
																							. 'onchange="carregaConclProc(this.value,this.name,'.$i.',0)" '
																							. 'autocomplete="off" value="' . $key . '" checked>' . $row
																							. '</label>'
																							;
																						} else {
																							echo ''
																							. '<label class="btn btn-default" name="ConcluidoProcedimento' . $i . '_' . $hideshow . '">'
																							. '<input type="radio" name="ConcluidoProcedimento' . $i . '" id="' . $hideshow . '" '
																							. 'onchange="carregaConclProc(this.value,this.name,'.$i.',0)" '
																							. 'autocomplete="off" value="' . $key . '" >' . $row
																							. '</label>'
																							;
																						}
																					}
																					?>
																				</div>
																			<?php }else{ ?>
																				<input type="hidden" name="ConcluidoProcedimento<?php echo $i ?>" id="ConcluidoProcedimento<?php echo $i ?>"  value="<?php echo $procedimento[$i]['ConcluidoProcedimento']; ?>"/>
																				<span>
																					<?php 
																						if($procedimento[$i]['ConcluidoProcedimento'] == "S") {
																								echo 'Sim';
																						} elseif($procedimento[$i]['ConcluidoProcedimento'] == "N"){
																							echo 'N�o';
																						}else{
																							echo 'N�o';
																						}
																					?>
																				</span>
																			<?php } ?>
																		</div>
																		<div class="col-md-4">
																			<div class="row">
																				<div id="ConcluidoProcedimento<?php echo $i ?>" <?php echo $div['ConcluidoProcedimento' . $i]; ?>>
																					<div class="col-md-6">
																						<label for="DataConcluidoProcedimento<?php echo $i ?>">Data Concl</label>
																						<div class="input-group <?php echo $datepicker; ?>">
																							<span class="input-group-addon" disabled>
																								<span class="glyphicon glyphicon-calendar"></span>
																							</span>
																							<input type="text" class="form-control Date" readonly="" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																								   name="DataConcluidoProcedimento<?php echo $i ?>" id="DataConcluidoProcedimento<?php echo $i ?>" value="<?php echo $procedimento[$i]['DataConcluidoProcedimento']; ?>">
																						</div>
																					</div>
																					<div class="col-md-6">
																						<label for="HoraConcluidoProcedimento<?php echo $i ?>">Hora Concl.</label>
																						<div class="input-group <?php echo $timepicker; ?>">
																							<span class="input-group-addon" disabled>
																								<span class="glyphicon glyphicon-time"></span>
																							</span>
																							<input type="text" class="form-control Time" readonly="" <?php echo $readonly; ?> maxlength="5" placeholder="HH:MM"
																								   name="HoraConcluidoProcedimento<?php echo $i ?>" id="HoraConcluidoProcedimento<?php echo $i ?>" value="<?php echo $procedimento[$i]['HoraConcluidoProcedimento']; ?>">
																						</div>
																					</div>
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
											<br>
										<?php } ?>
										<div id="CanceladoOrca" <?php echo $div['CanceladoOrca']; ?>>
											<div class="panel panel-default">
												<div class="panel-heading">
													<h4 class="mb-3"><b>Status do Pedido</b></h4>
													<div class="row">
														<div class="col-md-3">
															<div class="panel panel-primary">
																<div class="panel-heading">
																	<div class="row">
																		<div class="col-md-12 text-left">
																			<label for="CombinadoFrete">Tudo Combinado?</label><br>
																			<div class="btn-group" data-toggle="buttons">
																				<?php
																				foreach ($select['CombinadoFrete'] as $key => $row) {
																					if (!$orcatrata['CombinadoFrete'])$orcatrata['CombinadoFrete'] = 'S';

																					($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																					if ($orcatrata['CombinadoFrete'] == $key) {
																						echo ''
																						. '<label class="btn btn-warning active" name="CombinadoFrete_' . $hideshow . '">'
																						. '<input type="radio" name="CombinadoFrete" id="' . $hideshow . '" '
																						. 'autocomplete="off" value="' . $key . '" checked>' . $row
																						. '</label>'
																						;
																					} else {
																						echo ''
																						. '<label class="btn btn-default" name="CombinadoFrete_' . $hideshow . '">'
																						. '<input type="radio" name="CombinadoFrete" id="' . $hideshow . '" '
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
																			<label for="FinalizadoOrca">Finalizado?</label><br>
																			<?php if ($_SESSION['Usuario']['Bx_Prd'] == "S" && $_SESSION['Usuario']['Bx_Pag'] == "S") { ?>
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
																			<?php }else{ ?>
																				<input type="hidden" name="FinalizadoOrca" id="FinalizadoOrca"  value="<?php echo $orcatrata['FinalizadoOrca']; ?>"/>
																				<span>
																					<?php 
																						if($orcatrata['FinalizadoOrca'] == "S") {
																							echo 'Sim';
																						} elseif($orcatrata['FinalizadoOrca'] == "N"){
																							echo 'N�o';
																						}else{
																							echo 'N�o';
																						}
																					?>
																				</span>
																			<?php } ?>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div id="FinalizadoOrca" <?php echo $div['FinalizadoOrca']; ?>>
															<div id="CombinadoFrete" <?php echo $div['CombinadoFrete']; ?>>
																<div class="col-md-3">
																	<div class="panel panel-info">
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
																			</div>
																		</div>
																	</div>
																</div>
																<div id="AprovadoOrca" <?php echo $div['AprovadoOrca']; ?>>
																	<div class="col-md-3">
																		<div id="ProntoOrca" <?php echo $div['ProntoOrca']; ?>>
																			<div class="panel panel-success">
																				<div class="panel-heading">
																					<div class="row">				
																						<div class="col-md-12 text-left">
																							<label for="Entregador">Entregador</label>
																							<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" <?php echo $readonly; ?>
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
																							<label for="EnviadoOrca">Enviado?</label><br>
																							<div class="btn-group" data-toggle="buttons">
																								<?php
																								foreach ($select['EnviadoOrca'] as $key => $row) {
																									if (!$orcatrata['EnviadoOrca'])
																										$orcatrata['EnviadoOrca'] = 'N';

																									($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																									if ($orcatrata['EnviadoOrca'] == $key) {
																										echo ''
																										. '<label class="btn btn-warning active" name="EnviadoOrca_' . $hideshow . '">'
																										. '<input type="radio" name="EnviadoOrca" id="' . $hideshow . '" '
																										. 'autocomplete="off" value="' . $key . '" checked>' . $row
																										. '</label>'
																										;
																									} else {
																										echo ''
																										. '<label class="btn btn-default" name="EnviadoOrca_' . $hideshow . '">'
																										. '<input type="radio" name="EnviadoOrca" id="' . $hideshow . '" '
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
																	<div class="col-md-3">
																		<div class="panel panel-warning">
																			<div class="panel-heading">																						
																				<div class="row">
																					<div class="col-md-12 text-left">
																						<label for="ConcluidoOrca">Prds & Srvs. Entregues?</label><br>
																						<?php if ($_SESSION['Usuario']['Bx_Prd'] == "S") { ?>
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
																						<?php }else{ ?>
																							<input type="hidden" name="ConcluidoOrca" id="ConcluidoOrca"  value="<?php echo $orcatrata['ConcluidoOrca']; ?>"/>
																							<span>
																								<?php 
																									if($orcatrata['ConcluidoOrca'] == "S") {
																										echo 'Sim';
																									} elseif($orcatrata['ConcluidoOrca'] == "N"){
																										echo 'N�o';
																									}else{
																										echo 'N�o';
																									}
																								?>
																							</span>
																						<?php } ?>
																					</div>
																				</div>
																				<div class="row">		
																					<div class="col-md-12 text-right">
																						<label for="QuitadoOrca">Parcelas Pagas?</label><br>
																						<?php if ($_SESSION['Usuario']['Bx_Pag'] == "S") { ?>
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
																						<?php }else{ ?>
																							<input type="hidden" name="QuitadoOrca" id="QuitadoOrca"  value="<?php echo $orcatrata['QuitadoOrca']; ?>"/>
																							<span>
																								<?php 
																									if($orcatrata['QuitadoOrca'] == "S") {
																										echo 'Sim';
																									} elseif($orcatrata['QuitadoOrca'] == "N"){
																										echo 'N�o';
																									}else{
																										echo 'N�o';
																									}
																								?>
																							</span>
																						<?php } ?>
																					</div>
																				</div>
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
											<br>
										</div>
										<div class="panel panel-default">
											<div class="panel-heading">
												<input type="hidden" name="idApp_OrcaTrata" value="<?php echo $orcatrata['idApp_OrcaTrata']; ?>">
												<input type="hidden" name="Tipo_Orca"  id="Tipo_Orca" value="<?php echo $orcatrata['Tipo_Orca']; ?>">
												<input type="hidden" name="idApp_Cliente" value="<?php echo $_SESSION['Cliente']['idApp_Cliente']; ?>">
												<h4 class="mb-3"><b>Pedido</b></h4>
												<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) || ($_SESSION['log']['idSis_Empresa'] == 5))  { ?>
													<div class="row">
														<div class="col-md-9">
															<?php if ($metodo > 1) { ?>
															<!--<input type="hidden" name="idApp_Procedimento" value="<?php echo $procedimento['idApp_Procedimento']; ?>">
															<input type="hidden" name="idApp_ParcelasRec" value="<?php echo $parcelasrec['idApp_ParcelasRec']; ?>">-->
															<?php } ?>
															<?php if ($metodo == 2) { ?>

																<div class="btn-block">
																	<span class="input-group-btn">
																		<!--
																		<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
																			<span class="glyphicon glyphicon-save"></span> Salvar
																		</button>
																		-->
																		<button type="submit" class="btn btn-lg btn-primary" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." value="1" >
																			<span class="glyphicon glyphicon-save"></span>Save
																		</button>
																	</span>
																	<span class="input-group-btn">
																		<a class="btn btn-lg btn-info" name="submeter2" id="submeter2" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $orcatrata['idApp_OrcaTrata']; ?>">
																			<span class="glyphicon glyphicon-print"></span>										
																		</a>
																	</span>
																	<span class="input-group-btn">	
																		<a class="btn btn-lg btn-warning" name="submeter5" id="submeter5" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." href="<?php echo base_url() . 'orcatrata/alterarstatus/' . $orcatrata['idApp_OrcaTrata']; ?>">
																			<span class="glyphicon glyphicon-pencil"></span>Stt
																		</a>
																	</span>
																</div>
																<div class="col-md-12 alert alert-warning aguardar" role="alert" >
																	Aguarde um instante! Estamos processando sua solicita��o!
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
																					<button type="button" class="btn btn-warning" name="submeter4" id="submeter4" onclick="DesabilitaBotaoExcluir()" data-dismiss="modal">
																						<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
																					</button>
																				</div>
																				<div class="col-md-6 text-right">
																					<a class="btn btn-danger" name="submeter3" id="submeter3" onclick="DesabilitaBotaoExcluir(this.name)" href="<?php echo base_url() . 'orcatrata/excluir/' . $orcatrata['idApp_OrcaTrata'] ?>" role="button">
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
													
														<div class="col-md-3">
															<div class="panel panel-primary">
																<div class="panel-heading">
																	<div class="row">
																		<div class="col-md-12 text-left">
																			<label for="CanceladoOrca">Cancelado?</label><br>
																			<div class="btn-group" data-toggle="buttons">
																				<?php
																				foreach ($select['CanceladoOrca'] as $key => $row) {
																					if (!$orcatrata['CanceladoOrca'])$orcatrata['CanceladoOrca'] = 'N';

																					($key == 'N') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

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
																		<div class="col-md-12">
																			<label for="ObsOrca"></label>
																			<textarea class="form-control" id="ObsOrca" <?php echo $readonly; ?> placeholder="Motivo do Cancelamento:"
																					  name="ObsOrca"><?php echo $orcatrata['ObsOrca']; ?></textarea>
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
	</div>
</div>