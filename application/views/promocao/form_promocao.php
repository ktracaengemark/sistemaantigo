<?php if (isset($msg)) echo $msg; ?>
			
<div class="col-md-12 ">	
<?php #echo validation_errors(); ?>

	<div class="panel panel-<?php echo $panel; ?>">
		<div class="panel-heading">
			<?php echo $titulo; ?> Promocao
			<a class="btn btn-sm btn-info" href="<?php echo base_url() ?>relatorio/promocao" role="button">
				<span class="glyphicon glyphicon-search"></span> Promocao
			</a>
			<a class="btn btn-sm btn-warning" href="<?php echo base_url() ?>relatorio/estoque" role="button">
				<span class="glyphicon glyphicon-search"></span> Estoque
			</a>
		</div>			
		<div class="panel-body">

			<?php echo form_open_multipart($form_open_path); ?>

			<!--Tab_Promocao-->

			<div class="form-group">
				<div class="panel panel-info">
					<div class="panel-heading">	
						<div class="row">
							<div class="col-md-3">
								<label for="Desconto">Tipo</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?>
										id="Desconto" name="Desconto">
									<option value="">-- Sel. uma opção --</option>
									<?php
									foreach ($select['Desconto'] as $key => $row) {
										if ($promocao['Desconto'] == $key) {
											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
										} else {
											echo '<option value="' . $key . '">' . $row . '</option>';
										}
									}
									?>
								</select>
								<?php echo form_error('Desconto'); ?>
							</div>
							
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
								<label for="Ativo">Promoção Ativa?</label><br>
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
					</div>	
				</div>		
			</div>
			<?php if ($metodo > 1) { ?>
				<div class="row">
					<div class="col-md-4">
						<div class="row">
							<div class="col-md-12">
								<div class="panel-group" id="accordion1" role="tablist" aria-multiselectable="true">	
									<div class="panel panel-primary">
										<div class="panel-heading" role="tab" id="heading1" data-toggle="collapse" data-parent="#accordion1" data-target="#collapse1">
											<h4 class="panel-title">
												<a class="accordion-toggle">
													<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
													Produto 1
												</a>
											</h4>
										</div>
										<div id="collapse1" class="panel-collapse" role="tabpanel" aria-labelledby="heading1" aria-expanded="false">
											<div class="panel panel-success">
												<div class="panel-heading">
													<div class="row">	
														<div class="col-md-6">
															<label for="Cat_1">Categoria1*</label>								
															<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?> 
																	id="Cat_1" name="Cat_1">
																<option value="">-- Sel.uma Categoria --</option>
																<?php
																foreach ($select['Cat_1'] as $key => $row) {
																	if ($promocao['Cat_1'] == $key) {
																		echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																	} else {
																		echo '<option value="' . $key . '">' . $row . '</option>';
																	}
																}
																?>
															</select>
															<?php echo form_error('Cat_1'); ?>
														</div>
													</div>
													<?php if ($metodo > 2) { ?>
														<div class="row">
															<div class="col-md-12">
																<label for="Mod_1">Modelo1*</label>								
																<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?> 
																		id="Mod_1" name="Mod_1">
																	<option value="">-- Sel.um Modelo --</option>
																	<?php
																	foreach ($select['Mod_1'] as $key => $row) {
																		if ($promocao['Mod_1'] == $key) {
																			echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																		} else {
																			echo '<option value="' . $key . '">' . $row . '</option>';
																		}
																	}
																	?>
																</select>
																<?php echo form_error('Mod_1'); ?>
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
					
					<?php if ($promocao['Desconto'] == 2) { ?>
						<div class="col-md-4">
							<div class="row">
								<div class="col-md-12">
									<div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">	
										<div class="panel panel-primary">
											<div class="panel-heading" role="tab" id="heading2" data-toggle="collapse" data-parent="#accordion2" data-target="#collapse2">
												<h4 class="panel-title">
													<a class="accordion-toggle">
														<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
														Produto 2
													</a>
												</h4>
											</div>
											<div id="collapse2" class="panel-collapse" role="tabpanel" aria-labelledby="heading2" aria-expanded="false">
												<div class="panel panel-success">
													<div class="panel-heading">
														<div class="row">	
															<div class="col-md-6">
																<label for="Cat_2">Categoria2*</label>								
																<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?> 
																		id="Cat_2" name="Cat_2">
																	<option value="">-- Sel.uma Categoria --</option>
																	<?php
																	foreach ($select['Cat_2'] as $key => $row) {
																		if ($promocao['Cat_2'] == $key) {
																			echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																		} else {
																			echo '<option value="' . $key . '">' . $row . '</option>';
																		}
																	}
																	?>
																</select>
																<?php echo form_error('Cat_2'); ?>
															</div>
														</div>
														<?php if ($metodo > 2) { ?>
															<div class="row">
																<div class="col-md-12">
																	<label for="Mod_2">Modelo2*</label>								
																	<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?> 
																			id="Mod_2" name="Mod_2">
																		<option value="">-- Sel.um Modelo --</option>
																		<?php
																		foreach ($select['Mod_2'] as $key => $row) {
																			if ($promocao['Mod_2'] == $key) {
																				echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																			} else {
																				echo '<option value="' . $key . '">' . $row . '</option>';
																			}
																		}
																		?>
																	</select>
																	<?php echo form_error('Mod_2'); ?>
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
						<div class="col-md-4">
							<div class="row">	
								<div class="col-md-12">
									<div class="panel-group" id="accordion3" role="tablist" aria-multiselectable="true">	
										<div class="panel panel-primary">
											<div class="panel-heading" role="tab" id="heading3" data-toggle="collapse" data-parent="#accordion3" data-target="#collapse3">
												<h4 class="panel-title">
													<a class="accordion-toggle">
														<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
														Produto 3
													</a>
												</h4>
											</div>
											<div id="collapse3" class="panel-collapse" role="tabpanel" aria-labelledby="heading3" aria-expanded="false">
												<div class="panel panel-success">
													<div class="panel-heading">
														<div class="row">	
															<div class="col-md-6">
																<label for="Cat_3">Categoria3*</label>								
																<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?> 
																		id="Cat_3" name="Cat_3">
																	<option value="">-- Sel.uma Categoria --</option>
																	<?php
																	foreach ($select['Cat_3'] as $key => $row) {
																		if ($promocao['Cat_3'] == $key) {
																			echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																		} else {
																			echo '<option value="' . $key . '">' . $row . '</option>';
																		}
																	}
																	?>
																</select>
																<?php echo form_error('Cat_3'); ?>
															</div>
														</div>
														<?php if ($metodo > 2) { ?>
															<div class="row">
																<div class="col-md-12">
																	<label for="Mod_3">Modelo3*</label>								
																	<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?> 
																			id="Mod_3" name="Mod_3">
																		<option value="">-- Sel.um Modelo --</option>
																		<?php
																		foreach ($select['Mod_3'] as $key => $row) {
																			if ($promocao['Mod_3'] == $key) {
																				echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																			} else {
																				echo '<option value="' . $key . '">' . $row . '</option>';
																			}
																		}
																		?>
																	</select>
																	<?php echo form_error('Mod_3'); ?>
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
					
					<?php } ?>
				</div>	
				<?php if ($metodo > 3) { ?>
					
					<div class="row">
						<div class="col-md-12">
							<div class="panel-group" id="accordion3" role="tablist" aria-multiselectable="true">
								<div class="panel panel-primary">
									 <div class="panel-heading" role="tab" id="heading3" data-toggle="collapse" data-parent="#accordion3" data-target="#collapse3">
										<h4 class="panel-title">
											<a class="accordion-toggle">
												<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
												Produtos 1
											</a>
										</h4>
									</div>

									<div id="collapse3" class="panel-collapse" role="tabpanel" aria-labelledby="heading3" aria-expanded="false">
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
															<div class="col-md-1">
																<label for="QtdProdutoIncremento">QtdInc <?php echo $i ?>:</label>
																<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoIncremento<?php echo $i ?>" placeholder="0"
																		name="QtdProdutoIncremento<?php echo $i ?>" value="<?php echo $item_promocao[$i]['QtdProdutoIncremento'] ?>">
															</div>
															<div class="col-md-5">
																<label for="idTab_Produtos<?php echo $i ?>">Item <?php echo $i ?></label>
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
																<label for="ValorProduto">Valor <?php echo $i ?></label>
																<div class="input-group">
																	<span class="input-group-addon" id="basic-addon1">R$</span>
																	<input type="text" class="form-control Valor" id="ValorProduto<?php echo $i ?>" maxlength="10" placeholder="0,00"
																		name="ValorProduto<?php echo $i ?>" value="<?php echo $item_promocao[$i]['ValorProduto'] ?>">
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

											<div class="form-group">
												<a class="btn btn-xs btn-danger" onclick="adiciona_item_promocao()">
													<span class="glyphicon glyphicon-arrow-up"></span> Adiciona Itens 1
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>			
						</div>
					</div>
					
					<?php if ($promocao['Desconto'] == 2) { ?>
						<div class="row">		
							<div class="col-md-12">
								<div class="panel-group" id="accordion3" role="tablist" aria-multiselectable="true">
									<div class="panel panel-primary">
										 <div class="panel-heading" role="tab" id="heading3" data-toggle="collapse" data-parent="#accordion3" data-target="#collapse3">
											<h4 class="panel-title">
												<a class="accordion-toggle">
													<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
													Produtos 2
												</a>
											</h4>
										</div>

										<div id="collapse3" class="panel-collapse" role="tabpanel" aria-labelledby="heading3" aria-expanded="false">
											<div class="panel-body">

												<input type="hidden" name="PT2Count" id="PT2Count" value="<?php echo $count['PT2Count']; ?>"/>

												<div class="input_fields_wrap32">

												<?php
												for ($i=1; $i <= $count['PT2Count']; $i++) {
												?>

												<?php if ($metodo > 1) { ?>
												<input type="hidden" name="idTab_Valor2<?php echo $i ?>" value="<?php echo $item_promocao2[$i]['idTab_Valor']; ?>"/>
												<?php } ?>

												<div class="form-group" id="32div<?php echo $i ?>">
													<div class="panel panel-info">
														<div class="panel-heading">			
															<div class="row">																					
																<div class="col-md-1">
																	<label for="QtdProdutoDesconto2">QtdPrd <?php echo $i ?>:</label>
																	<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoDesconto2<?php echo $i ?>" placeholder="0"
																			name="QtdProdutoDesconto2<?php echo $i ?>" value="<?php echo $item_promocao2[$i]['QtdProdutoDesconto'] ?>">
																</div>
																<div class="col-md-1">
																	<label for="QtdProdutoIncremento2">QtdInc <?php echo $i ?>:</label>
																	<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoIncremento2<?php echo $i ?>" placeholder="0"
																			name="QtdProdutoIncremento2<?php echo $i ?>" value="<?php echo $item_promocao2[$i]['QtdProdutoIncremento'] ?>">
																</div>
																<div class="col-md-5">
																	<label for="idTab_Produtos2<?php echo $i ?>">Item <?php echo $i ?></label>
																	<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?>
																			 id="listadinamica3<?php echo $i ?>" name="idTab_Produtos2<?php echo $i ?>">
																		<option value="">-- Selecione uma opção --</option>
																		<?php
																		foreach ($select['idTab_Produtos2'] as $key => $row) {
																			if ($item_promocao2[$i]['idTab_Produtos'] == $key) {
																				echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																			} else {
																				echo '<option value="' . $key . '">' . $row . '</option>';
																			}
																		}
																		?>
																	</select>
																</div>
																<div class="col-md-2">
																	<label for="ValorProduto2">Valor <?php echo $i ?></label>
																	<div class="input-group">
																		<span class="input-group-addon" id="basic-addon1">R$</span>
																		<input type="text" class="form-control Valor" id="ValorProduto2<?php echo $i ?>" maxlength="10" placeholder="0,00"
																			name="ValorProduto2<?php echo $i ?>" value="<?php echo $item_promocao2[$i]['ValorProduto'] ?>">
																	</div>
																</div>											
																<div class="col-md-1">
																	<label><br></label><br>
																	<button type="button" id="<?php echo $i ?>" class="remove_field32 btn btn-danger">
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
													<a class="btn btn-xs btn-danger" onclick="adiciona_item_promocao2()">
														<span class="glyphicon glyphicon-arrow-up"></span> Adiciona Itens 2
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>	
						</div>
						<div class="row">		
							<div class="col-md-12">
								<div class="panel-group" id="accordion3" role="tablist" aria-multiselectable="true">
									<div class="panel panel-primary">
										 <div class="panel-heading" role="tab" id="heading3" data-toggle="collapse" data-parent="#accordion3" data-target="#collapse3">
											<h4 class="panel-title">
												<a class="accordion-toggle">
													<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
													Produtos 3
												</a>
											</h4>
										</div>

										<div id="collapse3" class="panel-collapse" role="tabpanel" aria-labelledby="heading3" aria-expanded="false">
											<div class="panel-body">

												<input type="hidden" name="PT3Count" id="PT3Count" value="<?php echo $count['PT3Count']; ?>"/>

												<div class="input_fields_wrap33">

												<?php
												for ($i=1; $i <= $count['PT3Count']; $i++) {
												?>

												<?php if ($metodo > 1) { ?>
												<input type="hidden" name="idTab_Valor3<?php echo $i ?>" value="<?php echo $item_promocao3[$i]['idTab_Valor']; ?>"/>
												<?php } ?>

												<div class="form-group" id="33div<?php echo $i ?>">
													<div class="panel panel-info">
														<div class="panel-heading">			
															<div class="row">																					
																<div class="col-md-1">
																	<label for="QtdProdutoDesconto3">QtdPrd <?php echo $i ?>:</label>
																	<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoDesconto3<?php echo $i ?>" placeholder="0"
																			name="QtdProdutoDesconto3<?php echo $i ?>" value="<?php echo $item_promocao3[$i]['QtdProdutoDesconto'] ?>">
																</div>
																<div class="col-md-1">
																	<label for="QtdProdutoIncremento3">QtdInc <?php echo $i ?>:</label>
																	<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoIncremento3<?php echo $i ?>" placeholder="0"
																			name="QtdProdutoIncremento3<?php echo $i ?>" value="<?php echo $item_promocao3[$i]['QtdProdutoIncremento'] ?>">
																</div>
																<div class="col-md-5">
																	<label for="idTab_Produtos3<?php echo $i ?>">Item <?php echo $i ?></label>
																	<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?>
																			 id="listadinamica3<?php echo $i ?>" name="idTab_Produtos3<?php echo $i ?>">
																		<option value="">-- Selecione uma opção --</option>
																		<?php
																		foreach ($select['idTab_Produtos3'] as $key => $row) {
																			if ($item_promocao3[$i]['idTab_Produtos'] == $key) {
																				echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																			} else {
																				echo '<option value="' . $key . '">' . $row . '</option>';
																			}
																		}
																		?>
																	</select>
																</div>
																<div class="col-md-2">
																	<label for="ValorProduto3">Valor <?php echo $i ?></label>
																	<div class="input-group">
																		<span class="input-group-addon" id="basic-addon1">R$</span>
																		<input type="text" class="form-control Valor" id="ValorProduto3<?php echo $i ?>" maxlength="10" placeholder="0,00"
																			name="ValorProduto3<?php echo $i ?>" value="<?php echo $item_promocao3[$i]['ValorProduto'] ?>">
																	</div>
																</div>											
																<div class="col-md-1">
																	<label><br></label><br>
																	<button type="button" id="<?php echo $i ?>" class="remove_field33 btn btn-danger">
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
													<a class="btn btn-xs btn-danger" onclick="adiciona_item_promocao3()">
														<span class="glyphicon glyphicon-arrow-up"></span> Adiciona Itens 3
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>	
						</div>
					<?php } ?>
					
				<?php } ?>	
				
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
					<?php if ($metodo == 4) { ?>

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
			</form>
		</div>
	</div>
</div>	