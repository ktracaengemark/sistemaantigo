<?php if (isset($msg)) echo $msg; ?>
			
<div class="col-md-12 ">	
<?php #echo validation_errors(); ?>

	<div class="panel panel-<?php echo $panel; ?>">
		<div class="panel-heading">
			<?php echo $titulo; ?>
			<a class="btn btn-sm btn-info" href="<?php echo base_url() ?>relatorio/precopromocao" role="button">
				<span class="glyphicon glyphicon-search"></span> Lista de Preços
			</a>
			<a class="btn btn-sm btn-info" href="<?php echo base_url() ?>relatorio/promocao" role="button">
				<span class="glyphicon glyphicon-search"></span> Lista de Promocoes
			</a>
			<a class="btn btn-sm btn-warning" href="<?php echo base_url() ?>produtos/cadastrar_promocao" role="button">
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
												<?php if ($metodo > 1) { ?>
													<div class="col-md-1 text-center" >
														<a class="notclickable" href="<?php echo base_url() . 'produtos/alterarlogopromocao/' . $_SESSION['Promocao']['idTab_Promocao'] . ''; ?>">
															<img  alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/miniatura/' . $_SESSION['Promocao']['Arquivo'] . ''; ?> "class="img-circle img-responsive" width='100'>
														</a>
													</div>
												<?php } ?>	
												<div class="col-md-3">
													<label for="Promocao">Título / Promoção:*</label><br>
													<input type="text" class="form-control" maxlength="200"
															name="Promocao" value="<?php echo $promocao['Promocao']; ?>">
													<?php echo form_error('Promocao'); ?>
												</div>
												<div class="col-md-6">
													<label for="Descricao">Descrição:*</label><br>
													<input type="text" class="form-control" maxlength="200"
															name="Descricao" value="<?php echo $promocao['Descricao']; ?>">
													<?php echo form_error('Descricao'); ?>
												</div>
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
																		<div class="col-md-1">
																			<label for="QtdProdutoDesconto">QtdPrd <?php echo $i ?>:</label>
																			<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoDesconto<?php echo $i ?>" placeholder="0"
																					name="QtdProdutoDesconto<?php echo $i ?>" value="<?php echo $item_promocao[$i]['QtdProdutoDesconto'] ?>">
																		</div>
																		<div class="col-md-6">
																			<label for="idTab_Produtos<?php echo $i ?>">Item <?php echo $i ?>*</label>
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
																		</div>
																		<div class="col-md-2">
																			<label for="Convdesc">Desc. Embal <?php echo $i ?></label>
																			<textarea type="text" class="form-control"  id="Convdesc<?php echo $i ?>" <?php echo $readonly; ?>
																					  name="Convdesc<?php echo $i ?>" value="<?php echo $item_promocao[$i]['Convdesc']; ?>"><?php echo $item_promocao[$i]['Convdesc']; ?></textarea>
																		</div>
																		<div class="col-md-1">
																			<label for="QtdProdutoIncremento">QtdEmb<?php echo $i ?>:</label>
																			<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoIncremento<?php echo $i ?>" placeholder="0"
																					name="QtdProdutoIncremento<?php echo $i ?>" value="<?php echo $item_promocao[$i]['QtdProdutoIncremento'] ?>">
																		</div>
																		<div class="col-md-2">
																			<label for="ValorProduto">ValorEmbal <?php echo $i ?>*</label>
																			<div class="input-group">
																				<span class="input-group-addon" id="basic-addon1">R$</span>
																				<input type="text" class="form-control Valor" id="ValorProduto<?php echo $i ?>" maxlength="10" placeholder="0,00"
																					name="ValorProduto<?php echo $i ?>" value="<?php echo $item_promocao[$i]['ValorProduto'] ?>">
																			</div>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-1 text-left"></div>
																		<div class="col-md-2">
																			<label for="AtivoPreco">Ativo?</label><br>
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
																		</div>
																		<div class="col-md-2">
																			<label for="VendaBalcaoPreco">VendaBalcao?</label><br>
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
																		</div>
																		<div class="col-md-2">
																			<label for="VendaSitePreco">VendaSite?</label><br>
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
																		</div>
																		<div class="col-md-2">
																			<label for="ComissaoVenda">Comissao<?php echo $i ?>*</label>
																			<div class="input-group">
																				<input type="text" class="form-control Valor text-right" id="ComissaoVenda<?php echo $i ?>" maxlength="10" placeholder="0,00"
																					name="ComissaoVenda<?php echo $i ?>" value="<?php echo $item_promocao[$i]['ComissaoVenda'] ?>">
																				<span class="input-group-addon" id="basic-addon1">%</span>
																			</div>
																		</div>
																		<div class="col-md-2 text-right"></div>											
																		
																		<div class="col-md-1 text-right">
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

														<div class="form-group">
															<a class="btn btn-xs btn-danger" onclick="adiciona_item_promocao()">
																<span class="glyphicon glyphicon-arrow-up"></span> Adiciona Itens 1
															</a>
														</div>
													</div>
												</div>
											</div>
										<?php } ?>	
										<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) || ($_SESSION['log']['idSis_Empresa'] == 5))  { ?>
										<div class="form-group">
											<div class="row">
												<!--<input type="hidden" name="idApp_Cliente" value="<?php echo $_SESSION['Cliente']['idApp_Cliente']; ?>">-->
												<input type="hidden" name="idTab_Promocao" value="<?php echo $promocao['idTab_Promocao']; ?>">
												<?php if ($metodo > 1) { ?>
												<!--<input type="hidden" name="idTab_Valor" value="<?php echo $item_promocao['idTab_Valor']; ?>">
												<input type="hidden" name="idApp_ParcelasRec" value="<?php echo $parcelasrec['idApp_ParcelasRec']; ?>">-->
												<?php } ?>
												<?php if ($metodo > 1) { ?>

													<div class="col-md-6">
														<button type="submit" class="btn btn-lg btn-primary" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." >
															<span class="glyphicon glyphicon-save"></span> Salvar
														</button>
													</div>
													<div class="col-md-6 text-right">
														<button  type="button" class="btn btn-lg btn-danger" name="submeter2" id="submeter2" onclick="DesabilitaBotao(this.name)" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
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
																	<p>Ao confirmar a exclusão todos os dados serão excluídos do banco de dados. Esta operação é irreversível.</p>
																</div>
																<div class="modal-footer">
																	<div class="col-md-6 text-left">
																		<button type="button" class="btn btn-warning" data-dismiss="modal">
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
													<div class="col-md-6">
														<button class="btn btn-lg btn-primary" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." type="submit">
															<span class="glyphicon glyphicon-save"></span> Salvar
														</button>
													</div>
												<?php } ?>
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