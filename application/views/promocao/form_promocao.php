
			
<div class="col-md-12 ">	
<?php #echo validation_errors(); ?>

	<div class="panel panel-<?php echo $panel; ?>">
		<div class="panel-heading">
			<?php echo $titulo; ?>
			<a class="btn btn-sm btn-info" href="<?php echo base_url() ?>relatorio/produtos" role="button">
				<span class="glyphicon glyphicon-search"></span> Lista de Produtos
			</a>
			
			<a class="btn btn-sm btn-info" href="<?php echo base_url() ?>relatorio/promocao" role="button">
				<span class="glyphicon glyphicon-search"></span> Lista de Promocoes
			</a>
			
			<a class="btn btn-sm btn-danger" href="<?php echo base_url() ?>promocao/cadastrar" role="button">
				<span class="glyphicon glyphicon-search"></span> Cadastrar Promoção
			</a>
		</div>			
		<div class="panel-body">

			<?php echo form_open_multipart($form_open_path); ?>
			<div class="row">
				<div class="col-md-12">
					<div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">	
						<?php if (isset($msg)) echo $msg; ?>
						<div class="panel panel-primary">
							<div class="panel-heading" role="tab" id="heading2" data-toggle="collapse" data-parent="#accordion2" data-target="#collapse2">
								<h4 class="panel-title">
									<a class="accordion-toggle">
										<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
										Dados da Promoção: 
									</a>
								</h4>
							</div>
							<div id="collapse2" class="panel-collapse" role="tabpanel" aria-labelledby="heading2" aria-expanded="false">
								<div class="panel panel-success">
									<div class="panel-heading">
										<div class="form-group">	
											<div class="row">
												<div class="col-md-1 text-center" >
													<?php if ($metodo > 1) { ?>
														<?php 
															if($metodo == 3) { 
																$url = '';
															}elseif($metodo == 2){
																$url = base_url() . 'promocao/alterarlogo/' . $_SESSION['Promocao']['idTab_Promocao'];
															}
														?>
														<a class="notclickable" href="<?php echo $url ;?>">
															<img  alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/miniatura/' . $_SESSION['Promocao']['Arquivo'] . ''; ?> "class="img-circle img-responsive" width='100'>
														</a>
													<?php } ?>		
												</div>
												<div class="col-md-3">
													<label for="Promocao">Título / Promoção:*</label><br>
													<?php if ($metodo == 3) { ?>
														<input type="text" class="form-control" readonly="" value="<?php echo $_SESSION['Promocao']['Promocao']; ?>">
													<?php }else { ?>
														<input type="text" class="form-control" maxlength="200" name="Promocao" id="Promocao" value="<?php echo $promocao['Promocao']; ?>">
													<?php } ?>
													<?php echo form_error('Promocao'); ?>
												</div>
												<div class="col-md-4">
													<label for="Descricao">Descrição:*</label><br>
													<?php if ($metodo == 3) { ?>
														<textarea type="text" class="form-control" readonly="" value="<?php echo $_SESSION['Promocao']['Descricao']; ?>"><?php echo $_SESSION['Promocao']['Descricao']; ?></textarea>
													<?php }else { ?>
														<textarea type="text" class="form-control" maxlength="200" name="Descricao" id="Descricao" value="<?php echo $promocao['Descricao']; ?>"><?php echo $promocao['Descricao']; ?></textarea>
													<?php } ?>
													<?php echo form_error('Descricao'); ?>
												</div>
												<?php if ($metodo > 1) { ?>
													<div class="col-md-2 text-left">
														<label for="DataInicioProm">Data do Inicio</label>
														<div class="input-group <?php echo $datepicker; ?>">
															<span class="input-group-addon" disabled>
																<span class="glyphicon glyphicon-calendar"></span>
															</span>
															<?php if ($metodo == 3) { ?>
																<input type="text" class="form-control Date" readonly="" value="<?php echo $_SESSION['Promocao']['DataInicioProm']; ?>">
															<?php }else { ?>
																<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																		id="DataInicioProm" name="DataInicioProm" value="<?php echo $promocao['DataInicioProm']; ?>">
															<?php } ?>
														</div>
														<?php echo form_error('DataInicioProm'); ?>
													</div>
													<div class="col-md-2 text-left">
														<label for="DataFimProm">Data do Fim</label>
														<div class="input-group <?php echo $datepicker; ?>">
															<span class="input-group-addon" disabled>
																<span class="glyphicon glyphicon-calendar"></span>
															</span>
															<?php if ($metodo == 3) { ?>
																<input type="text" class="form-control Date" readonly="" value="<?php echo $_SESSION['Promocao']['DataFimProm']; ?>">
															<?php }else { ?>
																<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA" 
																		id="DataFimProm" name="DataFimProm" value="<?php echo $promocao['DataFimProm']; ?>">
															<?php } ?>			
														</div>
														<?php echo form_error('DataFimProm'); ?>
													</div>
												<?php } ?>	
											</div>	
										</div>
										
										<div class="form-group">	
											<div class="row">
												<div class="col-md-1"></div>
											</div>
										</div>
												
										<!--
										<div class="row">	
											
											<div class="col-md-3 text-left">
												<label for="ValorPromocao">Valor Promoção:</label><br>
												<div class="input-group">
													<span class="input-group-addon" id="basic-addon1">R$</span>
													<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"
															name="ValorPromocao" value="<?php echo $promocao['ValorPromocao'] ?>">
												</div>
											</div>
											
											<div class="col-md-3 text-left">
												<label for="Ativo">Preço Ativo?</label><br>
												<div class="btn-group" data-toggle="buttons">
													<?php
													foreach ($select['Ativo'] as $key => $row) {
														if (!$promocao['Ativo']) $promocao['Ativo'] = 'N';

														($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

														if ($promocao['Ativo'] == $key) {
															echo ''
															. '<label class="btn btn-warning active" name="Ativo_' . $hideshow . '">'
															. '<input type="radio" name="Ativo" id="' . $hideshow . '" '
															. 'autocomplete="off" value="' . $key . '" checked>' . $row
															. '</label>'
															;
														} else {
															echo ''
															. '<label class="btn btn-default" name="Ativo_' . $hideshow . '">'
															. '<input type="radio" name="Ativo" id="' . $hideshow . '" '
															. 'autocomplete="off" value="' . $key . '" >' . $row
															. '</label>'
															;
														}
													}
													?>
												</div>
											</div>
											<div class="col-md-3 text-left">
												<label for="VendaBalcao">Aparecer no Balcão?</label><br>
												<div class="btn-group" data-toggle="buttons">
													<?php
													foreach ($select['VendaBalcao'] as $key => $row) {
														if (!$promocao['VendaBalcao']) $promocao['VendaBalcao'] = 'S';

														($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

														if ($promocao['VendaBalcao'] == $key) {
															echo ''
															. '<label class="btn btn-warning active" name="VendaBalcao_' . $hideshow . '">'
															. '<input type="radio" name="VendaBalcao" id="' . $hideshow . '" '
															. 'autocomplete="off" value="' . $key . '" checked>' . $row
															. '</label>'
															;
														} else {
															echo ''
															. '<label class="btn btn-default" name="VendaBalcao_' . $hideshow . '">'
															. '<input type="radio" name="VendaBalcao" id="' . $hideshow . '" '
															. 'autocomplete="off" value="' . $key . '" >' . $row
															. '</label>'
															;
														}
													}
													?>
												</div>
											</div>
											<div class="col-md-3 text-left">
												<label for="VendaSite">Aparecer no Site?</label><br>
												<div class="btn-group" data-toggle="buttons">
													<?php
													foreach ($select['VendaSite'] as $key => $row) {
														if (!$promocao['VendaSite']) $promocao['VendaSite'] = 'S';

														($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

														if ($promocao['VendaSite'] == $key) {
															echo ''
															. '<label class="btn btn-warning active" name="VendaSite_' . $hideshow . '">'
															. '<input type="radio" name="VendaSite" id="' . $hideshow . '" '
															. 'autocomplete="off" value="' . $key . '" checked>' . $row
															. '</label>'
															;
														} else {
															echo ''
															. '<label class="btn btn-default" name="VendaSite_' . $hideshow . '">'
															. '<input type="radio" name="VendaSite" id="' . $hideshow . '" '
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
										<?php if ($metodo > 1) { ?>
											<div class="col-md-12">
												<div class="row">
													<div class="col-md-2">
														<div class="panel panel-default">
															<div class="panel-heading">
																<div class="row">
																	<div class="col-md-12 text-left">
																		<label for="TodoDiaProm">Todo Dia?</label><br>
																		<?php if ($metodo == 3) { ?>
																			<input type="text" class="form-control text-left" readonly="" value="<?php echo $_SESSION['Promocao']['TodoDiaProm'] ?>">
																		<?php }elseif ($metodo == 2) { ?>
																			<div class="btn-group" data-toggle="buttons">
																				<?php
																				foreach ($select['TodoDiaProm'] as $key => $row) {
																					if (!$promocao['TodoDiaProm'])$promocao['TodoDiaProm'] = 'S';

																					($key == 'N') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																					if ($promocao['TodoDiaProm'] == $key) {
																						echo ''
																						. '<label class="btn btn-warning active" name="TodoDiaProm_' . $hideshow . '">'
																						. '<input type="radio" name="TodoDiaProm" id="' . $hideshow . '" '
																						. 'autocomplete="off" value="' . $key . '" checked>' . $row
																						. '</label>'
																						;
																					} else {
																						echo ''
																						. '<label class="btn btn-default" name="TodoDiaProm_' . $hideshow . '">'
																						. '<input type="radio" name="TodoDiaProm" id="' . $hideshow . '" '
																						. 'autocomplete="off" value="' . $key . '" >' . $row
																						. '</label>'
																						;
																					}
																				}
																				?>
																			</div>
																		<?php } ?>	
																	</div>
																</div>
															</div>
														</div>
													</div>	
													<div id="TodoDiaProm" <?php echo $div['TodoDiaProm']; ?>>
														<?php for ($i=1; $i <= $count['DiaCount']; $i++) { ?>
															<div class="col-md-2">
																<input type="hidden" name="DiaCount" id="DiaCount" value="<?php echo $count['DiaCount']; ?>"/>
																<?php if ($metodo > 1) { ?>
																<input type="hidden" name="idTab_Dia_Prom<?php echo $i ?>" value="<?php echo $dia_promocao[$i]['idTab_Dia_Prom']; ?>"/>
																<?php } ?>
																<div class="panel panel-default">
																	<div class="panel-heading">
																		<div class="row">
																			<div class="col-md-12">
																				<label for="Dia_Semana_Prom"><?php echo $_SESSION['Dia_Promocao'][$i]['Dia_Semana_Prom']; ?></label><br>
																				<?php if ($metodo == 3) { ?>
																					<input type="text" class="form-control text-left" readonly="" value="<?php echo $_SESSION['Dia_Promocao'][$i]['Aberto_Prom'] ?>">
																				<?php }elseif ($metodo == 2) { ?>
																					
																						<div class="btn-group" data-toggle="buttons">
																							<?php
																							foreach ($select['Aberto_Prom'] as $key => $row) {
																								(!$dia_promocao[$i]['Aberto_Prom']) ? $dia_promocao[$i]['Aberto_Prom'] = 'S' : FALSE;

																								if ($dia_promocao[$i]['Aberto_Prom'] == $key) {
																									echo ''
																									. '<label class="btn btn-warning active" name="radiobutton_Aberto_Prom' . $i . '" id="radiobutton_Aberto_Prom' . $i .  $key . '">'
																									. '<input type="radio" name="Aberto_Prom' . $i . '" id="radiobuttondinamico" '
																									. 'autocomplete="off" value="' . $key . '" checked>' . $row
																									. '</label>'
																									;
																								} else {
																									echo ''
																									. '<label class="btn btn-default" name="radiobutton_Aberto_Prom' . $i . '" id="radiobutton_Aberto_Prom' . $i .  $key . '">'
																									. '<input type="radio" name="Aberto_Prom' . $i . '" id="radiobuttondinamico" '
																									. 'autocomplete="off" value="' . $key . '" >' . $row
																									. '</label>'
																									;
																								}
																							}
																							?>
																						</div>
																					
																				<?php } ?>
																			</div>
																		</div>
																	</div>	
																</div>
															</div>
														<?php } ?>
													</div>	
												</div>
											</div>
										
											<div class="col-md-12">
												<div class="row">
													<div class="panel-body">

														<input type="hidden" name="PTCount" id="PTCount" value="<?php echo $count['PTCount']; ?>"/>

														<div class="input_fields_wrap3">

														<?php
														for ($i=1; $i <= $count['PTCount']; $i++) {
														?>

														<?php if ($metodo > 1) { ?>
														<input type="hidden" name="idTab_Valor<?php echo $i ?>" value="<?php echo $item_promocao[$i]['idTab_Valor']; ?>"/>
														<?php } ?>

														<div class="form-group" id="3div<?php echo $i ?>">
															<div class="panel panel-info">
																<div class="panel-heading">			
																	<div class="row">
																		<div class="col-md-6">
																			<label for="idTab_Produtos<?php echo $i ?>">Item <?php echo $i ?>:*</label>
																			<?php if ($metodo == 3) { ?>
																				<input type="text" class="form-control text-left" readonly="" value="<?php echo $_SESSION['Item_Promocao'][$i]['Nome_Prod'] ?>">
																			<?php }elseif ($metodo == 2) { ?>
																				<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?>
																						 id="listadinamicad<?php echo $i ?>" name="idTab_Produtos<?php echo $i ?>">
																					<option value="">-- Selecione uma opção --</option>
																					<?php
																					foreach ($select['idTab_Produtos'] as $key => $row) {
																						if ($item_promocao[$i]['idTab_Produtos'] == $key) {
																							echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																						} else {
																							echo '<option value="' . $key . '">' . $row . '</option>';
																						}
																					}
																					?>
																					</select>
																			<?php } ?>	
																		</div>
																	</div>	
																	<div class="row">																					
																		<div class="col-md-1">
																			<label for="QtdProdutoDesconto">QtdPrd*:</label>
																			<?php if ($metodo == 3) { ?>
																				<input type="text" class="form-control text-left" readonly="" value="<?php echo $_SESSION['Item_Promocao'][$i]['QtdProdutoDesconto'] ?>">
																			<?php }elseif ($metodo == 2) { ?>
																			<input type="text" class="form-control Numero" maxlength="10"  placeholder="0"
																				id="QtdProdutoDesconto<?php echo $i ?>"	name="QtdProdutoDesconto<?php echo $i ?>" value="<?php echo $item_promocao[$i]['QtdProdutoDesconto'] ?>">
																			<?php } ?>
																		</div>
																		<div class="col-md-1">
																			<label for="QtdProdutoIncremento">QtdEmb*:</label>
																			<?php if ($metodo == 3) { ?>
																				<input type="text" class="form-control text-left" readonly="" value="<?php echo $_SESSION['Item_Promocao'][$i]['QtdProdutoIncremento'] ?>">
																			<?php }elseif ($metodo == 2) { ?>
																				<input type="text" class="form-control Numero" maxlength="10"  placeholder="0"
																					id="QtdProdutoIncremento<?php echo $i ?>" name="QtdProdutoIncremento<?php echo $i ?>" value="<?php echo $item_promocao[$i]['QtdProdutoIncremento'] ?>">
																			<?php } ?>
																		</div>
																		<div class="col-md-2">
																			<label for="ValorProduto">ValorEmbal*:</label>
																			<div class="input-group">
																				<span class="input-group-addon" id="basic-addon1">R$</span>
																				<?php if ($metodo == 3) { ?>
																					<input type="text" class="form-control Valor text-left" readonly="" value="<?php echo $_SESSION['Item_Promocao'][$i]['ValorProduto'] ?>">
																				<?php }elseif ($metodo == 2) { ?>	
																				<input type="text" class="form-control Valor text-left"  maxlength="10" placeholder="0,00"
																						id="ValorProduto<?php echo $i ?>" name="ValorProduto<?php echo $i ?>" value="<?php echo $item_promocao[$i]['ValorProduto'] ?>">
																				<?php } ?>		
																			</div>
																		</div>
																		<div class="col-md-2">
																			<label for="ComissaoVenda">Comissao:</label>
																			<div class="input-group">
																			<?php if ($metodo == 3) { ?>
																				<input type="text" class="form-control Valor text-right" readonly="" value="<?php echo $_SESSION['Item_Promocao'][$i]['ComissaoVenda'] ?>">
																			<?php }elseif ($metodo == 2) { ?>	
																				<input type="text" class="form-control Valor text-right" maxlength="10" placeholder="0,00" 
																				id="ComissaoVenda<?php echo $i ?>" name="ComissaoVenda<?php echo $i ?>" value="<?php echo $item_promocao[$i]['ComissaoVenda'] ?>">
																			<?php } ?>	
																				<span class="input-group-addon" id="basic-addon1">%</span>
																			</div>
																		</div>
																		<div class="col-md-2">
																			<label for="TempoDeEntrega">Tempo De Entrega:</label>
																			<div class="input-group">
																			<?php if ($metodo == 3) { ?>
																				<input type="text" class="form-control text-right" readonly="" value="<?php echo $_SESSION['Item_Promocao'][$i]['TempoDeEntrega'] ?>">
																			<?php }elseif ($metodo == 2) { ?>	
																				<input type="text" class="form-control Numero text-right" maxlength="3" placeholder="0" 
																				id="TempoDeEntrega<?php echo $i ?>" name="TempoDeEntrega<?php echo $i ?>" value="<?php echo $item_promocao[$i]['TempoDeEntrega'] ?>">
																			<?php } ?>	
																				<span class="input-group-addon" id="basic-addon1">Dia(s)</span>
																			</div>
																		</div>
																		<div class="col-md-2">
																			<label for="Convdesc">Desc. Embal:</label>
																			<?php if ($metodo == 3) { ?>
																				<textarea type="text" class="form-control" readonly="" <?php echo $readonly; ?>
																					value="<?php echo $_SESSION['Item_Promocao'][$i]['Convdesc']; ?>"><?php echo $_SESSION['Item_Promocao'][$i]['Convdesc']; ?></textarea>
																			<?php }elseif ($metodo == 2) { ?>
																				<textarea type="text" class="form-control" <?php echo $readonly; ?>
																					id="Convdesc<?php echo $i ?>" name="Convdesc<?php echo $i ?>" value="<?php echo $item_promocao[$i]['Convdesc']; ?>"><?php echo $item_promocao[$i]['Convdesc']; ?></textarea>
																			<?php } ?>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-2">
																			<label for="AtivoPreco">Ativo?</label><br>
																			<?php if ($metodo == 3) { ?>
																				<input type="text" class="form-control text-left" readonly="" value="<?php echo $_SESSION['Item_Promocao'][$i]['AtivoPreco'] ?>">
																			<?php }elseif ($metodo == 2) { ?>
																				<div class="form-group">
																					<div class="btn-group" data-toggle="buttons">
																						<?php
																						foreach ($select['AtivoPreco'] as $key => $row) {
																							(!$item_promocao[$i]['AtivoPreco']) ? $item_promocao[$i]['AtivoPreco'] = 'N' : FALSE;

																							if ($item_promocao[$i]['AtivoPreco'] == $key) {
																								echo ''
																								. '<label class="btn btn-warning active" name="radiobutton_AtivoPreco' . $i . '" id="radiobutton_AtivoPreco' . $i .  $key . '">'
																								. '<input type="radio" name="AtivoPreco' . $i . '" id="radiobuttondinamico" '
																								. 'autocomplete="off" value="' . $key . '" checked>' . $row
																								. '</label>'
																								;
																							} else {
																								echo ''
																								. '<label class="btn btn-default" name="radiobutton_AtivoPreco' . $i . '" id="radiobutton_AtivoPreco' . $i .  $key . '">'
																								. '<input type="radio" name="AtivoPreco' . $i . '" id="radiobuttondinamico" '
																								. 'autocomplete="off" value="' . $key . '" >' . $row
																								. '</label>'
																								;
																							}
																						}
																						?>
																					</div>
																				</div>
																			<?php } ?>
																		</div>
																		<div class="col-md-2">
																			<label for="VendaBalcaoPreco">VendaBalcao?</label><br>
																			<?php if ($metodo == 3) { ?>
																				<input type="text" class="form-control text-left" readonly="" value="<?php echo $_SESSION['Item_Promocao'][$i]['VendaBalcaoPreco'] ?>">
																			<?php }elseif ($metodo == 2) { ?>
																				<div class="form-group">
																					<div class="btn-group" data-toggle="buttons">
																						<?php
																						foreach ($select['VendaBalcaoPreco'] as $key => $row) {
																							(!$item_promocao[$i]['VendaBalcaoPreco']) ? $item_promocao[$i]['VendaBalcaoPreco'] = 'N' : FALSE;

																							if ($item_promocao[$i]['VendaBalcaoPreco'] == $key) {
																								echo ''
																								. '<label class="btn btn-warning active" name="radiobutton_VendaBalcaoPreco' . $i . '" id="radiobutton_VendaBalcaoPreco' . $i .  $key . '">'
																								. '<input type="radio" name="VendaBalcaoPreco' . $i . '" id="radiobuttondinamico" '
																								. 'autocomplete="off" value="' . $key . '" checked>' . $row
																								. '</label>'
																								;
																							} else {
																								echo ''
																								. '<label class="btn btn-default" name="radiobutton_VendaBalcaoPreco' . $i . '" id="radiobutton_VendaBalcaoPreco' . $i .  $key . '">'
																								. '<input type="radio" name="VendaBalcaoPreco' . $i . '" id="radiobuttondinamico" '
																								. 'autocomplete="off" value="' . $key . '" >' . $row
																								. '</label>'
																								;
																							}
																						}
																						?>
																					</div>
																				</div>
																			<?php } ?>	
																		</div>
																		<div class="col-md-2">
																			<label for="VendaSitePreco">VendaSite?</label><br>
																			<?php if ($metodo == 3) { ?>
																				<input type="text" class="form-control text-left" readonly="" value="<?php echo $_SESSION['Item_Promocao'][$i]['VendaSitePreco'] ?>">
																			<?php }elseif ($metodo == 2) { ?>
																				<div class="form-group">
																					<div class="btn-group" data-toggle="buttons">
																						<?php
																						foreach ($select['VendaSitePreco'] as $key => $row) {
																							(!$item_promocao[$i]['VendaSitePreco']) ? $item_promocao[$i]['VendaSitePreco'] = 'N' : FALSE;

																							if ($item_promocao[$i]['VendaSitePreco'] == $key) {
																								echo ''
																								. '<label class="btn btn-warning active" name="radiobutton_VendaSitePreco' . $i . '" id="radiobutton_VendaSitePreco' . $i .  $key . '">'
																								. '<input type="radio" name="VendaSitePreco' . $i . '" id="radiobuttondinamico" '
																								. 'autocomplete="off" value="' . $key . '" checked>' . $row
																								. '</label>'
																								;
																							} else {
																								echo ''
																								. '<label class="btn btn-default" name="radiobutton_VendaSitePreco' . $i . '" id="radiobutton_VendaSitePreco' . $i .  $key . '">'
																								. '<input type="radio" name="VendaSitePreco' . $i . '" id="radiobuttondinamico" '
																								. 'autocomplete="off" value="' . $key . '" >' . $row
																								. '</label>'
																								;
																							}
																						}
																						?>
																					</div>
																				</div>
																			<?php } ?>
																		</div>
																		<div class="col-md-2 text-right"></div>											
																		<?php if ($metodo == 2) { ?>
																			<div class="col-md-1 text-right">
																				<label><br></label><br>
																				<button type="button" id="<?php echo $i ?>" class="remove_field3 btn btn-danger">
																					<span class="glyphicon glyphicon-trash"></span>
																				</button>
																			</div>
																		<?php } ?>
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
										<?php } ?>
										<?php if ($metodo > 1) { ?>
											<input type="hidden" name="idTab_Promocao" id="idTab_Promocao" value="<?php echo $promocao['idTab_Promocao']; ?>">
										<?php } ?>
										<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) || ($_SESSION['log']['idSis_Empresa'] == 5))  { ?>
											
										<div class="form-group">
											<div class="row">
												<div class="col-md-12">
													<?php if ($metodo > 1) { ?>
													<!--<input type="hidden" name="idTab_Valor" value="<?php echo $item_promocao['idTab_Valor']; ?>">
													<input type="hidden" name="idApp_ParcelasRec" value="<?php echo $parcelasrec['idApp_ParcelasRec']; ?>">-->
													<?php } ?>
													<?php if ($metodo > 1) { ?>
														<?php if ($metodo == 3) { ?>
															<!--<div class="col-md-1"></div>-->
															<div class="col-md-2">
																<a class="btn btn-md btn-warning btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" href="<?php echo base_url() . 'promocao/alterar/' . $promocao['idTab_Promocao'] ?>" role="button">
																	<span class="glyphicon glyphicon-edit"></span> Editar Promoçao
																</a>
															</div>
														<?php }elseif ($metodo == 2) { ?>
															<!--<div class="col-md-1"></div>-->
															<?php if ($metodo == 2) { ?>
																<div class="col-md-2">
																	<a class="btn btn-md btn-danger btn-block" name="submeter5" id="submeter5" onclick="adiciona_item_promocao()">
																		<span class="glyphicon glyphicon-plus"></span> Adiciona Produto
																	</a>
																</div>
															<?php } ?>
															<div class="col-md-2">
																<button type="submit" class="btn btn-md btn-primary btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." >
																	<span class="glyphicon glyphicon-save"></span> Salvar
																</button>
															</div>
															<div class="col-md-2 text-right">
																<button  type="button" class="btn btn-md btn-danger btn-block" name="submeter2" id="submeter2" onclick="DesabilitaBotao(this.name)" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
																	<span class="glyphicon glyphicon-trash"></span> Excluir Promoção
																</button>
															</div>
														<?php } ?>	
														<div class="modal fade bs-excluir-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
															<div class="modal-dialog" role="document">
																<div class="modal-content">
																	<div class="modal-header bg-danger">
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																		<h4 class="modal-title">Tem certeza que deseja excluir?</h4>
																	</div>
																	<div class="modal-body">
																		<p>Ao confirmar a exclusão todos os dados serão excluídos do banco de dados. Esta operação é irreversível.</p>
																	</div>
																	<div class="modal-footer">
																		<div class="col-md-6 text-left">
																			<button type="button" class="btn btn-warning" onclick="DesabilitaBotao()" data-dismiss="modal" >
																				<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
																			</button>
																		</div>
																		<div class="col-md-6 text-right">
																			<a class="btn btn-danger" href="<?php echo base_url() . 'promocao/excluir/' . $promocao['idTab_Promocao'] ?>" role="button">
																				<span class="glyphicon glyphicon-trash"></span> Confirmar Exclusão
																			</a>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													<?php } else { ?>
														<!--<div class="col-md-1"></div>-->
														<div class="col-md-2">
															<button class="btn btn-lg btn-primary btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." type="submit">
																<span class="glyphicon glyphicon-save"></span> Salvar
															</button>
														</div>
													<?php } ?>
												</div>
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
			<?php if ($metodo == 1) { ?>
				<?php if (isset($list_promocoes)) echo $list_promocoes; ?>
			<?php } elseif($metodo > 1) { ?>
				<?php if (isset($list_itens_promocao)) echo $list_itens_promocao; ?>
			<?php } ?>
			</form>
		</div>
	</div>
</div>	