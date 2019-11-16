<?php if (isset($msg)) echo $msg; ?>


<div class="container-fluid">
	
	<div class="row">

		<div class="col-md-2"></div>
		<div class="col-md-8 ">

			<div class="row">

				<div class="col-md-12 col-lg-12">
				
					<?php echo validation_errors(); ?>
					<?php echo form_open_multipart($form_open_path); ?>

					<div class="panel panel-<?php echo $panel; ?>">
						<div class="panel-heading"><strong><?php echo $titulo; ?> - </strong><?php echo $orcatrata['idApp_OrcaTrata'] ?></div>
						<div class="panel-body">
							<div style="overflow: auto; height: 450px; ">

								<div class="panel-group">	
									
										<div <?php echo $collapse; ?> id="Orcamento">
												
													<div class="panel panel-primary">
														<div class="panel-heading">
															<div class="form-group">
																<div class="row">
																	<div class="col-md-4">
																		<label for="TipoFinanceiro">Tipo de Receita</label>
																		<select data-placeholder="Selecione uma op��o..." class="form-control" <?php echo $readonly; ?>
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
																	<?php if ($_SESSION['log']['NivelEmpresa'] >= 3 ) { ?>
																	<div class="col-md-4">
																		<label for="idApp_Cliente">Cliente *</label>
																		<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" <?php echo $readonly; ?>
																				id="idApp_Cliente" autofocus name="idApp_Cliente">
																			<option value="">-- Sel. um Cliente --</option>
																			<?php
																			foreach ($select['idApp_Cliente'] as $key => $row) {
																					(!$orcatrata['idApp_Cliente']) ? $orcatrata['idApp_Cliente'] = '1' : FALSE;
																				if ($orcatrata['idApp_Cliente'] == $key) {
																					echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																				} else {
																					echo '<option value="' . $key . '">' . $row . '</option>';
																				}
																			}
																			?>
																		</select>
																	</div>
																	<?php } else { ?>
																	<div class="col-md-4"></div>																	
																	<?php } ?>
																	
																	<div class="col-md-4">
																		<label for="Descricao">Descri��o/ Obs.:</label><br>
																		<input type="text" class="form-control" maxlength="200"
																				name="Descricao" value="<?php echo $orcatrata['Descricao'] ?>">
																	</div>
																</div>	
																<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
																<div class="row">	
																	<div class="panel-body">
																		<div <?php echo $collapse; ?> id="Entregues">
																			<div class="panel-body">
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
																					<div class="panel panel-info">
																						<div class="panel-heading">
																							<div class="row">
																								<div class="col-md-2">
																									<label for="QtdProduto">Qtd<?php echo $i ?>:</label>
																									<input type="text" class="form-control Numero" maxlength="3" id="QtdProduto<?php echo $i ?>" placeholder="0"
																											onkeyup="calculaSubtotal(this.value,this.name,'<?php echo $i ?>','QTD','Produto'),calculaQtdSoma('QtdProduto','QtdSoma','ProdutoSoma',0,0,'CountMax',0,'ProdutoHidden')"
																											autofocus name="QtdProduto<?php echo $i ?>" value="<?php echo $produto[$i]['QtdProduto'] ?>">
																								</div>
																								<div class="col-md-6">
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
																									<label for="ValorProduto">Valor:</label>
																									<div class="input-group">
																										<span class="input-group-addon" id="basic-addon1">R$</span>
																										<input type="text" class="form-control Valor" id="idTab_Produto<?php echo $i ?>" maxlength="10" placeholder="0,00"
																											onkeyup="calculaSubtotal(this.value,this.name,'<?php echo $i ?>','VP','Produto')"
																											name="ValorProduto<?php echo $i ?>" value="<?php echo $produto[$i]['ValorProduto'] ?>">
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
																								<div class="col-md-5"></div>
																								<div class="col-md-3">
																									<label for="ObsProduto<?php echo $i ?>">Obs:</label><br>
																									<input type="text" class="form-control" id="ObsProduto<?php echo $i ?>" maxlength="250"
																										   name="ObsProduto<?php echo $i ?>" value="<?php echo $produto[$i]['ObsProduto'] ?>">
																								</div>																				
																								<div class="col-md-2">
																									<label for="DataValidadeProduto<?php echo $i ?>">Validade:</label>
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
																											onclick="calculaQtdSoma('QtdProduto','QtdSoma','ProdutoSoma',1,<?php echo $i ?>,'CountMax',0,'ProdutoHidden')">
																										<span class="glyphicon glyphicon-trash"></span>
																									</button>
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

																				<div class="panel panel-info">
																					<div class="panel-heading text-left">

																							<div class="row">

																								<div class="col-md-3">
																									<a class="add_field_button9 btn btn-info"
																											onclick="calculaQtdSoma('QtdProduto','QtdSoma','ProdutoSoma',0,0,'CountMax',1,0)">
																										<span class="glyphicon glyphicon-plus"></span> Produtos
																									</a>
																								</div>
																								<div class="col-md-3">	
																									<b>Produtos: <span id="QtdSoma"><?php echo $QtdSoma ?></span></b>
																								</div>
																								<div class="col-md-3">	
																									<b>Linhas: <span id="ProdutoSoma"><?php echo $ProdutoSoma ?></span></b><br />
																								</div>
																								<div class="col-md-3 text-right">
																									<a class="btn btn-sm btn-warning" type="button" data-toggle="collapse" data-target="#Devolvidos" aria-expanded="false" aria-controls="Devolvidos">
																										<span class="glyphicon glyphicon-menu-down"></span> Devolu��o
																									</a>
																								</div>																				
																								<!--
																								<div class="col-md-3 text-left">																							
																									<a class="accordion-toggle btn btn-heading  collapsed" role="tab" id="heading5" data-toggle="collapse" data-parent="#accordion5" data-target="#collapse5" aria-expanded="false">
																										<span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span>
																										Entregues
																									</a>
																									<a class="btn btn-success" type="button" data-toggle="collapse" data-target="#Entregues" aria-expanded="false" aria-controls="Entregues">
																										<span class="glyphicon glyphicon-menu-up"></span> Entregues
																									</a>
																								</div>
																								-->
																							</div>
																				
																					</div>
																				</div>
																				<input type="hidden" name="CountMax" id="CountMax" value="<?php echo $ProdutoSoma ?>">
																			</div>
																		</div>
																		<?php if ($_SESSION['log']['NivelEmpresa'] >= 10 ) { ?>	
																		<div <?php echo $collapse1; ?> id="Devolvidos">
																			<div class="panel-body">
																																		
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
																								<div class="col-md-2">
																									<label for="QtdServico">Qtd:</label>
																									<input type="text" class="form-control Numero" maxlength="3" id="QtdServico<?php echo $i ?>" placeholder="0"
																											onkeyup="calculaSubtotalDev(this.value,this.name,'<?php echo $i ?>','QTD','Servico'),calculaQtdSomaDev('QtdServico','QtdSomaDev','ServicoSoma',0,0,'CountMax2',0,'ServicoHidden')"
																											autofocus name="QtdServico<?php echo $i ?>" value="<?php echo $servico[$i]['QtdServico'] ?>">
																								</div>
																								<div class="col-md-6">
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
																									<label for="ValorServico">Valor:</label>
																									<div class="input-group">
																										<span class="input-group-addon" id="basic-addon1">R$</span>
																										<input type="text" class="form-control Valor" id="idTab_Servico<?php echo $i ?>" maxlength="10" placeholder="0,00"
																											onkeyup="calculaSubtotalDev(this.value,this.name,'<?php echo $i ?>','VP','Servico')"
																											name="ValorServico<?php echo $i ?>" value="<?php echo $servico[$i]['ValorServico'] ?>">
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
																								<div class="col-md-5"></div>
																								<div class="col-md-3">
																									<label for="ObsServico<?php echo $i ?>">Obs:</label><br>
																									<input type="text" class="form-control" id="ObsServico<?php echo $i ?>" maxlength="250"
																										   name="ObsServico<?php echo $i ?>" value="<?php echo $servico[$i]['ObsServico'] ?>">
																								</div>																				
																								<div class="col-md-2">
																									<label for="DataValidadeServico<?php echo $i ?>">Validade:</label>
																									<div class="input-group <?php echo $datepicker; ?>">
																										<span class="input-group-addon" disabled>
																											<span class="glyphicon glyphicon-calendar"></span>
																										</span>
																										<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																											   name="DataValidadeServico<?php echo $i ?>" value="<?php echo $servico[$i]['DataValidadeServico']; ?>">																				
																									</div>
																								</div>
																								<div class="col-md-1">
																									<label><br></label><br>
																									<button type="button" id="<?php echo $i ?>" class="remove_field10 btn btn-danger"
																										onclick="calculaQtdSomaDev('QtdServico','QtdSomaDev','ServicoSoma',1,<?php echo $i ?>,'CountMax2',0,'ServicoHidden')">
																										<span class="glyphicon glyphicon-trash"></span>
																									</button>
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
																				
																				<div class="panel panel-warning">
																					<div class="panel-heading text-left">
																							
																							<div class="row">	

																								<div class="col-md-3 text-left">
																									<a class="add_field_button10  btn btn-warning" 
																											onclick="calculaQtdSomaDev('QtdServico','QtdSomaDev','ServicoSoma',0,0,'CountMax2',1,0)">
																										<span class="glyphicon glyphicon-minus"></span> Produtos
																									</a>
																								</div>
																								<div class="col-md-3">	
																									<b>Produtos: <span id="QtdSomaDev"><?php echo $QtdSomaDev ?></span></b>
																								</div>
																								<div class="col-md-3">	
																									<b>Linhas: <span id="ServicoSoma"><?php echo $ServicoSoma ?></span></b><br />
																								</div>
																								
																								<div class="col-md-3 text-left">																							
																									<!--
																									<a class="accordion-toggle btn btn-heading  collapsed" role="tab" id="heading6" data-toggle="collapse" data-parent="#accordion6" data-target="#collapse6" aria-expanded="false">
																										<span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span>
																										Devolvidos
																									</a>
																									
																									<a class="btn btn-danger" type="button" data-toggle="collapse" data-target="#Devolvidos" aria-expanded="false" aria-controls="Devolvidos">
																										<span class="glyphicon glyphicon-menu-up"></span> Devolvidos
																									</a>
																									-->
																								</div>
																							</div>
																						
																					</div>
																				</div>
																				<input type="hidden" name="CountMax2" id="CountMax2" value="<?php echo $ServicoSoma ?>">
																			</div>
																		</div>
																		<?php } ?>
																	</div>
																</div>	
																<?php } ?>																	
																<div class="row">	
																	<div <?php echo $visivel; ?>>
																		<div class="col-md-4">
																			<label for="ValorOrca">Or�amento:</label><br>
																			<div class="input-group" id="txtHint">
																				<span class="input-group-addon" id="basic-addon1">R$</span>
																				<input type="text" class="form-control Valor" id="ValorOrca" maxlength="10" placeholder="0,00" 
																					   onkeyup="calculaResta(this.value)"
																					   name="ValorOrca" value="<?php echo $orcatrata['ValorOrca'] ?>">
																			</div>
																		</div>
																		<div class="col-md-4">
																			<label for="ValorDev">Desconto:</label><br>
																			<div class="input-group" id="txtHint">
																				<span class="input-group-addon" id="basic-addon1">R$</span>
																				<input type="text" class="form-control Valor" id="ValorDev" maxlength="10" placeholder="0,00"
																					   onkeyup="calculaResta(this.value)" 
																					   name="ValorDev" value="<?php echo $orcatrata['ValorDev'] ?>">
																			</div>
																		</div>
																	</div>
																	<div class="col-md-4">
																		<label for="ValorRestanteOrca">Total:</label><br>
																		<div class="input-group" id="txtHint">
																			<span class="input-group-addon" id="basic-addon1">R$</span>
																			<input type="text" class="form-control Valor" id="ValorRestanteOrca" maxlength="10" placeholder="0,00"
																				   data-toggle="collapse" onkeyup="calculaParcelas()" onchange="calculaParcelas()" onkeydown="calculaParcelas()"
																					data-target="#Parcelas" aria-expanded="false" aria-controls="Parcelas"
																				   name="ValorRestanteOrca" value="<?php echo $orcatrata['ValorRestanteOrca'] ?>">
																		</div>
																	</div>
																</div>
															
															</div>
															
															<div class="row">
																<div class="col-md-4">
																	<label for="FormaPagamento">Pago com:</label>
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
																<div class="col-md-4">
																	<label for="DataVencimentoOrca">1� Venc.</label>
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
																<div class="col-md-4">
																	<label for="AVAP">� Vista/ Prazo</label><br>
																	<div class="btn-block" data-toggle="buttons">
																		<?php
																		foreach ($select['AVAP'] as $key => $row) {
																			if (!$orcatrata['AVAP'])
																				$orcatrata['AVAP'] = 'V';

																			($key == 'P') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																			if ($orcatrata['AVAP'] == $key) {
																				echo ''
																				. '<label class="btn btn-warning active" name="AVAP_' . $hideshow . '">'
																				. '<input type="radio" name="AVAP" id="' . $hideshow . '" '
																				. 'onchange="calculaParcelas()" '
																				. 'autocomplete="off" value="' . $key . '" checked>' . $row
																				. '</label>'
																				;
																			} else {
																				echo ''
																				. '<label class="btn btn-default" name="AVAP_' . $hideshow . '">'
																				. '<input type="radio" name="AVAP" id="' . $hideshow . '" '
																				. 'onchange="calculaParcelas()" '
																				. 'autocomplete="off" value="' . $key . '" >' . $row
																				. '</label>'
																				;
																			}
																		}
																		?>

																	</div>
																	<?php echo form_error('AVAP'); ?>
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
												
												<div > <!-- Gatilho deslidado - id="AVAP" <?php #echo $div['AVAP']; ?> -  -->															
													<br>
													
														<div class="panel panel-primary">
															<div class="panel-heading">
																<div class="row">
																	<div class="col-md-2">
																		<label for="QtdParcelasOrca">Parcelas</label><br>
																		<input type="text" class="form-control Numero" id="QtdParcelasOrca" maxlength="3" placeholder="0"
																			   data-toggle="collapse" onkeyup="calculaParcelas()"
																					data-target="#Parcelas" aria-expanded="false" aria-controls="Parcelas"
																			   name="QtdParcelasOrca" value="<?php echo $orcatrata['QtdParcelasOrca'] ?>">
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

																					. 'autocomplete="off" value="' . $key . '" checked>' . $row
																					. '</label>'
																					;
																				} else {
																					echo ''
																					. '<label class="btn btn-default" name="radiobutton_Modalidade" id="radiobutton_Modalidade' .  $key . '">'
																					. '<input type="radio" name="Modalidade" id="radiobuttondinamico" '

																					. 'autocomplete="off" value="' . $key . '" >' . $row
																					. '</label>'
																					;
																				}
																			}
																			?>
																		</div>
																	</div>															
																</div>
																<br>
																<!--App_parcelasRec-->
																<div class="panel-body">
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
																								<label for="Parcela">Parcela:</label><br>
																								<input type="text" class="form-control" maxlength="6" 
																									   name="Parcela<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['Parcela'] ?>">
																							</div>
																							<div class="col-md-3">
																								<label for="ValorParcela">Valor:</label><br>
																								<div class="input-group" id="txtHint">
																									<span class="input-group-addon" id="basic-addon1">R$</span>
																									<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" id="ValorParcela<?php echo $i ?>"
																										   name="ValorParcela<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['ValorParcela'] ?>">
																								</div>
																							</div>
																							<div class="col-md-3">
																								<label for="DataVencimento">Vencimento</label>
																								<div class="input-group DatePicker">
																									<span class="input-group-addon" disabled>
																										<span class="glyphicon glyphicon-calendar"></span>
																									</span>
																									<input type="text" class="form-control Date" id="DataVencimento<?php echo $i ?>" maxlength="10" placeholder="DD/MM/AAAA"
																										   name="DataVencimento<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['DataVencimento'] ?>">																
																								</div>
																							</div>
																							<div class="col-md-3">
																								<label for="Quitado">Parc. Quitada?</label><br>
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
																							<div class="col-md-1">
																								<label><br></label><br>
																								<button type="button" id="<?php echo $i ?>" class="remove_field21 btn btn-danger">
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
																
																	<div class="panel panel-warning">
																		<div class="panel-heading">										
																				
																				<div class="row">	
																					<div class="col-md-2 text-left">
																						<button class="btn btn-warning" type="button" data-toggle="collapse" onclick="adicionaParcelas()"
																								data-target="#Parcelas" aria-expanded="false" aria-controls="Parcelas">
																							<span class="glyphicon glyphicon-plus"></span> Adicionar Parcelas
																						</button>
																					</div>
																				</div>
																				
																		</div>
																	</div>
																</div>
															</div>	
														</div>
														<br>
													
														<div class="panel panel-primary">
															<div class="panel-heading">
																<div class="form-group">
																	<div class="row">
																		<?php if ($_SESSION['log']['NivelEmpresa'] >= 10 ) { ?>
																		<div class="col-md-4 form-inline">
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
																		<div class="col-md-4 form-inline">
																			<label for="ConcluidoOrca">Conclu�do?</label><br>
																			<div class="form-group">
																				<div class="btn-group" data-toggle="buttons">
																					<?php
																					foreach ($select['ConcluidoOrca'] as $key => $row) {
																						if (!$orcatrata['ConcluidoOrca'])
																							$orcatrata['ConcluidoOrca'] = 'N';

																						($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

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
																		<?php } ?>
																		<div class="col-md-4 form-inline">
																			<label for="QuitadoOrca">Quitado?</label><br>
																			<div class="form-group">
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
																
																<div class="form-group ">
																	<div class="row">
																		<div id="AprovadoOrca" <?php echo $div['AprovadoOrca']; ?>>
																			<div class="col-md-4">
																				<label for="DataOrca">Or�ado em:</label>
																				<div class="input-group <?php echo $datepicker; ?>">
																					<span class="input-group-addon" disabled>
																						<span class="glyphicon glyphicon-calendar"></span>
																					</span>
																					<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																							name="DataOrca" value="<?php echo $orcatrata['DataOrca']; ?>">
																				</div>
																			</div>
																		</div>
																		<?php if ($_SESSION['log']['NivelEmpresa'] >= 10 ) { ?>
																		<div id="ConcluidoOrca" <?php echo $div['ConcluidoOrca']; ?>>
																			<div class="col-md-4">
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
																		<div id="QuitadoOrca" <?php echo $div['QuitadoOrca']; ?>>
																			<div class="col-md-4">
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
																		<?php } ?>
																	</div>
																</div>
																
																<!--
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
																		<div class="col-md-6">
																			<label for="ObsOrca">OBS:</label>
																			<textarea class="form-control" id="ObsOrca" <?php echo $readonly; ?>
																					  name="ObsOrca"><?php echo $orcatrata['ObsOrca']; ?></textarea>
																		</div>
																	</div>
																</div>
																-->
															</div>
														</div>																									

												
												</div>
												
										</div>
									
								</div>
								
								<?php if ($_SESSION['log']['NivelEmpresa'] >= 5 ) { ?>
								<div class="panel-group">	
									<div class="panel panel-primary">

										<div class="panel-heading text-left">
											<a class="btn btn-primary" type="button" data-toggle="collapse" data-target="#Procedimentos" aria-expanded="false" aria-controls="Procedimentos">
												<span class="glyphicon glyphicon-menu-down"></span> Procedimentos
											</a>
										</div>
										
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
								<?php } ?>
								
								</form>
							</div>
							<br>
							<div class="form-group">
								<div class="row">
									<!--<input type="hidden" name="idApp_Cliente" value="<?php echo $_SESSION['Cliente']['idApp_Cliente']; ?>">-->
									<input type="hidden" name="idApp_OrcaTrata" value="<?php echo $orcatrata['idApp_OrcaTrata']; ?>">
									<?php if ($metodo > 1) { ?>
									<!--<input type="hidden" name="idApp_Procedimento" value="<?php echo $procedimento['idApp_Procedimento']; ?>">
									<input type="hidden" name="idApp_ParcelasRec" value="<?php echo $parcelasrec['idApp_ParcelasRec']; ?>">-->
									<?php } ?>
									<?php if ($metodo == 2) { ?>

										<div class="col-md-6">
											<button class="btn btn-md btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
												<span class="glyphicon glyphicon-save"></span> Salvar
											</button>
										</div>
										<div class="col-md-6 text-right">
											<button  type="button" class="btn btn-md btn-danger" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
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
															<a class="btn btn-danger" href="<?php echo base_url() . 'orcatrata/excluir2/' . $orcatrata['idApp_OrcaTrata'] ?>" role="button">
																<span class="glyphicon glyphicon-trash"></span> Confirmar Exclus�o
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									<?php } else { ?>
										<div class="col-md-6">
											<button class="btn btn-md btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
												<span class="glyphicon glyphicon-save"></span> Salvar
											</button>
										</div>

									<?php } ?>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-2"></div>
	</div>
</div>
