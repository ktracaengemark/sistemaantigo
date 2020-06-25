<?php if (isset($msg)) echo $msg; ?>
			
<div class="col-md-12 ">	
<?php #echo validation_errors(); ?>

	<div class="panel panel-<?php echo $panel; ?>">
		
		<div class="panel-heading">
			<?php echo $titulo; ?> Produtos
			<?php if ($metodo != 2) { ?>
				<a class="btn btn-sm btn-info" href="<?php echo base_url() ?>relatorio/produtos" role="button">
					<span class="glyphicon glyphicon-search"></span> Produtos
				</a>
				<a class="btn btn-sm btn-warning" href="<?php echo base_url() ?>relatorio/estoque" role="button">
					<span class="glyphicon glyphicon-search"></span> Estoque
				</a>
			<?php } ?>
		</div>
		
		<div class="panel-body">

			<?php echo form_open_multipart($form_open_path); ?>
			
				<!--Tab_Produto-->
	
				<div class="row">
					<div class="col-md-12">
						<div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">	
							<div class="panel panel-primary">
								<div class="panel-heading" role="tab" id="heading2" data-toggle="collapse" data-parent="#accordion2" data-target="#collapse2">
									<h4 class="panel-title">
										<a class="accordion-toggle">
											<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
											Dados do Modelo
										</a>
									</h4>
								</div>
								<div id="collapse2" class="panel-collapse" role="tabpanel" aria-labelledby="heading2" aria-expanded="false">
									<div class="panel panel-success">
										<div class="panel-heading">
											<div class="row">	
												<div class="col-md-6">
													<label for="Prodaux3">Categoria*</label>								
													<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?> 
															id="Prodaux3" name="Prodaux3">
														<option value="">-- Sel.uma Categoria --</option>
														<?php
														foreach ($select['Prodaux3'] as $key => $row) {
															if ($produtos['Prodaux3'] == $key) {
																echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
															} else {
																echo '<option value="' . $key . '">' . $row . '</option>';
															}
														}
														?>
													</select>
													<?php echo form_error('Prodaux3'); ?>
												</div>												
												<div class="col-md-5">
													<label for="Cadastrar">Cadastrar 
														<?php if ($metodo == 1) { ?>
															Cat.
														<?php } else { ?>
															Tam.
														<?php } ?>
													</label><br>
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
												
											</div>
											
											<div class="row">
												<div class="col-md-12 text-left" id="Cadastrar" <?php echo $div['Cadastrar']; ?>>
													<?php if ($metodo == 1) { ?>
													<label></label><br>
													<a class="btn btn-sm btn-info"   target="_blank" href="<?php echo base_url() ?>prodaux32/cadastrar3" role="button"> 
														<span class="glyphicon glyphicon-plus"></span> Cat
													</a>
													<?php } else { ?>
													<label></label><br>
													<a class="btn btn-sm btn-info"   target="_blank" href="<?php echo base_url() ?>prodaux22/cadastrar3/" role="button"> 
														<span class="glyphicon glyphicon-plus"></span> Tipo
													</a>
													<label></label>
													<a class="btn btn-sm btn-info"   target="_blank" href="<?php echo base_url() ?>prodaux12/cadastrar3/" role="button"> 
														<span class="glyphicon glyphicon-plus"></span> Tam
													</a>
													<?php } ?>
													<!--
													<label></label>
													<a class="btn btn-md btn-info"   target="_blank" href="<?php echo base_url() ?>prodaux42/cadastrar3/" role="button"> 
														<span class="glyphicon glyphicon-plus"></span> Mod
													</a>									
													
													
													<label></label>
													<a class="btn btn-md btn-info"   target="_blank" href="<?php echo base_url() ?>fornecedor2/cadastrar3/" role="button"> 
														<span class="glyphicon glyphicon-plus"></span> Fornec
													</a>
													-->
													<label></label>									
													<button class="btn btn-sm btn-primary"  id="inputDb" data-loading-text="Aguarde..." type="submit">
															<span class="glyphicon glyphicon-refresh"></span> Recarregar
													</button>
													<?php echo form_error('Cadastrar'); ?>
												</div>
											</div>
											<?php if ($metodo > 1) { ?>
												<div class="row">
													<div class="col-md-12">	
														<label for="Produtos">Modelo*</label><br>
														<input type="text" class="form-control" maxlength="200"
																name="Produtos" id="Produtos" value="<?php echo $produtos['Produtos'] ?>">
														<?php echo form_error('Produtos'); ?>
													</div>
												</div>
												<div class="row">				
													<div class="col-md-6">
														<label for="TipoProduto">Venda/Cons/Alug:</label>
														<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
																id="TipoProduto" name="TipoProduto">
															<option value="">-- Selecione uma opção --</option>
															<?php
															foreach ($select['TipoProduto'] as $key => $row) {
																if ($produtos['TipoProduto'] == $key) {
																	echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																} else {
																	echo '<option value="' . $key . '">' . $row . '</option>';
																}
															}
															?>
														</select>
														<?php echo form_error('TipoProduto'); ?>
													</div>
													<div class="col-md-6">
														<label for="UnidadeProduto">Unidade:</label>
														<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
																id="UnidadeProduto" name="UnidadeProduto">
															<option value="">-- Selecione uma opção --</option>
															<?php
															foreach ($select['UnidadeProduto'] as $key => $row) {
																if ($produtos['UnidadeProduto'] == $key) {
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
													<div class="col-md-6">
														<label for="ValorProduto">A Partir de:</label><br>
														<div class="input-group">
															<span class="input-group-addon" id="basic-addon1">R$</span>
															<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"
																	name="ValorProduto" value="<?php echo $produtos['ValorProduto'] ?>">
														</div>
													</div>
													<div class="col-md-6">
														<label for="Comissao">Comissão:</label><br>
														<div class="input-group">
															<span class="input-group-addon" id="basic-addon1"> % </span>
															<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"
																	name="Comissao" value="<?php echo $produtos['Comissao'] ?>">
														</div>
													</div>
													<!--
													<div class="col-md-4">
														<label for="PesoProduto">Peso:</label><br>
														<div class="input-group">
															<span class="input-group-addon" id="basic-addon1">(kg)</span>
															<input type="text" class="form-control Peso" maxlength="10" placeholder="0,000"
																	name="PesoProduto" value="<?php echo $produtos['PesoProduto'] ?>">
														</div>
													</div>
													-->	
												</div>
												<div class="row">
													<div class="col-md-6 text-left">
														<label for="Ativo">Produto Ativo?</label><br>
														<div class="btn-group" data-toggle="buttons">
															<?php
															foreach ($select['Ativo'] as $key => $row) {
																if (!$produtos['Ativo']) $produtos['Ativo'] = 'N';

																($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																if ($produtos['Ativo'] == $key) {
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
													<div id="Ativo" <?php echo $div['Ativo']; ?>>	
														<div class="col-md-6 text-left">
															<label for="VendaSite">Vender no Site?</label><br>
															<div class="btn-group" data-toggle="buttons">
																<?php
																foreach ($select['VendaSite'] as $key => $row) {
																	if (!$produtos['VendaSite']) $produtos['VendaSite'] = 'N';

																	($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																	if ($produtos['VendaSite'] == $key) {
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
														<div id="VendaSite" <?php echo $div['VendaSite']; ?>>	
															
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
					
					
				<div class="row">
					<?php if ($metodo > 1) { ?>
						<div class="col-md-4">
							<div class="panel-group" id="accordion7" role="tablist" aria-multiselectable="true">
								<div class="panel panel-primary">
									 <div class="panel-heading" role="tab" id="heading7" data-toggle="collapse" data-parent="#accordion7" data-target="#collapse7">
										<h4 class="panel-title">
											<a class="accordion-toggle">
												<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
												Atributos
											</a>
										</h4>
									</div>

									<div id="collapse7" class="panel-collapse" role="tabpanel" aria-labelledby="heading7" aria-expanded="false">
										<div class="panel-body">
									
											<input type="hidden" name="SCount" id="SCount" value="<?php echo $count['SCount']; ?>"/>

											<div class="input_fields_wrap105">

												<?php
												for ($i=1; $i <= $count['SCount']; $i++) {
												?>

													<?php if ($metodo > 1) { ?>
														<input type="hidden" name="idTab_Atributo_Select<?php echo $i ?>" value="<?php echo $servico[$i]['idTab_Atributo_Select']; ?>"/>
													<?php } ?>

													<input type="hidden" name="ServicoHidden" id="ServicoHidden<?php echo $i ?>" value="<?php echo $i ?>">
													
													<div class="form-group" id="105div<?php echo $i ?>">
														<div class="panel panel-warning">
															<div class="panel-heading">
																<div class="row">
																	<div class="col-md-10">
																		<label for="idTab_Atributo">Atributo<?php echo $i ?></label>
																		<?php if ($i == 1) { ?>
																		<!--<a class="btn btn-xs btn-info" href="<?php echo base_url() ?>servico/cadastrar/servico" role="button">
																			<span class="glyphicon glyphicon-plus"></span> <b>Novo Serviço</b>
																		</a>-->
																		<?php } ?>
																		<select data-placeholder="Selecione uma opção..." class="form-control Chosen"<?php echo $readonly; ?>
																				id="listadinamica<?php echo $i ?>" name="idTab_Atributo<?php echo $i ?>">																					
																			<option value="">-- Selecione uma opção --</option>
																			<?php
																			foreach ($select['idTab_Atributo'] as $key => $row) {
																				if ($servico[$i]['idTab_Atributo'] == $key) {
																					echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																				} else {
																					echo '<option value="' . $key . '">' . $row . '</option>';
																				}
																			}
																			?>
																		</select>
																	</div>		
																	<div class="col-md-1">
																		<label><br></label><br>
																		<button type="button" id="<?php echo $i ?>" class="remove_field105 btn btn-danger">
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
											<div class="col-md-2 text-left">
												<a class="add_field_button105 btn btn-warning">
													<span class="glyphicon glyphicon-arrow-up"></span> Adicionar Atributo
												</a>
											</div>											
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
					<?php if ($metodo > 2) { ?>
						<div class="col-md-4">
							<div class="panel-group" id="accordion7" role="tablist" aria-multiselectable="true">
								<div class="panel panel-primary">
									 <div class="panel-heading" role="tab" id="heading7" data-toggle="collapse" data-parent="#accordion7" data-target="#collapse7">
										<h4 class="panel-title">
											<a class="accordion-toggle">
												<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
												Atributo1
											</a>
										</h4>
									</div>

									<div id="collapse7" class="panel-collapse" role="tabpanel" aria-labelledby="heading7" aria-expanded="false">
										<div class="panel-body">

											<input type="hidden" name="TCount" id="TCount" value="<?php echo $count['TCount']; ?>"/>

											<div class="input_fields_wrap99">

											<?php
											for ($i=1; $i <= $count['TCount']; $i++) {
											?>

											<?php if ($metodo > 1) { ?>
											<input type="hidden" name="idTab_Cor_Prod<?php echo $i ?>" value="<?php echo $produto[$i]['idTab_Cor_Prod']; ?>"/>
											<?php } ?>
											<div class="form-group" id="99div<?php echo $i ?>">
												<div class="panel panel-warning">
													<div class="panel-heading">
														<div class="row">
															<div class="col-md-10">
																<label for="Cor_Prod">Opcao <?php echo $i ?></label>
																<?php if ($i == 1) { ?>
																<?php } ?>
																<select data-placeholder="Sel. Tipo" class="form-control Chosen"
																		 id="listadinamica99<?php echo $i ?>" name="Cor_Prod<?php echo $i ?>">
																	<option value="">-- Sel. Opcao --</option>
																	<?php
																	foreach ($select['Cor_Prod'] as $key => $row) {
																		if ($produto[$i]['Cor_Prod'] == $key) {
																			echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																		} else {
																			echo '<option value="' . $key . '">' . $row . '</option>';
																		}
																	}
																	?>
																</select>
															</div>
															<div class="col-md-1">
																<label><br></label><br>
																<button type="button" id="<?php echo $i ?>" class="remove_field99 btn btn-danger">
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
												<a class="btn btn-xs btn-danger" onclick="adicionaTipo()">
													<span class="glyphicon glyphicon-arrow-up"></span> Adicionar Opcao
												</a>
											</div>
											
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-md-4">	
							<div class="panel-group" id="accordion6" role="tablist" aria-multiselectable="true">
								<div class="panel panel-primary">
									 <div class="panel-heading" role="tab" id="heading6" data-toggle="collapse" data-parent="#accordion6" data-target="#collapse6">
										<h4 class="panel-title">
											<a class="accordion-toggle">
												<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
												Atributo2
											</a>
										</h4>
									</div>

									<div id="collapse6" class="panel-collapse" role="tabpanel" aria-labelledby="heading6" aria-expanded="false">
										<div class="panel panel-success">
											<div class="panel-heading">

												<input type="hidden" name="PMCount" id="PMCount" value="<?php echo $count['PMCount']; ?>"/>

												<div class="input_fields_wrap91">
													
													<?php
													$QtdSoma = $ProdutoSoma = 0;
													for ($i=1; $i <= $count['PMCount']; $i++) {
													?>

													<?php if ($metodo > 1) { ?>
													<input type="hidden" name="idTab_Tam_Prod<?php echo $i ?>" value="<?php echo $procedimento[$i]['idTab_Tam_Prod']; ?>"/>
													<?php } ?>

													<input type="hidden" name="ProdutoHidden" id="ProdutoHidden<?php echo $i ?>" value="<?php echo $i ?>">

													<div class="form-group" id="91div<?php echo $i ?>">
														
														<div class="panel panel-warning">
															<div class="panel-heading">
																<div class="row">
																	<div class="col-md-10">
																		<label for="Tam_Prod">Opcao <?php echo $i ?></label>
																		<?php if ($i == 1) { ?>
																		<?php } ?>
																		<select data-placeholder="Sel. Tamanho" class="form-control Chosen"
																				 id="listadinamicag<?php echo $i ?>" name="Tam_Prod<?php echo $i ?>">
																			<option value="">-- Sel. Opcao --</option>
																			<?php
																			foreach ($select['Tam_Prod'] as $key => $row) {
																				if ($procedimento[$i]['Tam_Prod'] == $key) {
																					echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																				} else {
																					echo '<option value="' . $key . '">' . $row . '</option>';
																				}
																			}
																			?>
																		</select>
																	</div>
																	<div class="col-md-1">
																		<label><br></label><br>
																		<button type="button" id="<?php echo $i ?>" class="remove_field91 btn btn-danger"
																				onclick="calculaQtdSoma('Tam_Prod','QtdSoma','ProdutoSoma',1,<?php echo $i ?>,'CountMax',0,'ProdutoHidden')">
																			<span class="glyphicon glyphicon-trash"></span>
																		</button>
																	</div>
																	
																</div>
															</div>
														</div>
													</div>

													<?php
													$QtdSoma+=$procedimento[$i]['Tam_Prod'];
													$ProdutoSoma++;
													}
													?>
													<input type="hidden" name="CountMax" id="CountMax" value="<?php echo $ProdutoSoma ?>">
												</div>
											
												<div class="panel panel-warning">
													<div class="panel-heading text-left">
														<div class="row">
															<div class="col-md-3">
																	
																<a class="add_field_button91 btn btn-success">
																	<span class="glyphicon glyphicon-arrow-up"></span> Adicionar Opcao
																</a>
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
					
					<?php } ?>
				</div>
					
				
				<?php if ($metodo > 2) { ?>
					<div class="row">
						<div class="col-md-12">	
							<div class="panel-group" id="accordion7" role="tablist" aria-multiselectable="true">
								<div class="panel panel-primary">
									 <div class="panel-heading" role="tab" id="heading7" data-toggle="collapse" data-parent="#accordion7" data-target="#collapse7">
										<h4 class="panel-title">
											<a class="accordion-toggle">
												<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
												Produtos Derivados
											</a>
										</h4>
									</div>	
							
									<div id="collapse7" class="panel-collapse" role="tabpanel" aria-labelledby="heading7" aria-expanded="false">
										<div class="panel panel-success">
											<div class="panel-heading">
												<input type="hidden" name="PDCount" id="PDCount" value="<?php echo $count['PDCount']; ?>"/>

												<div class="input_fields_wrap97">

													<?php
													$QtdSoma = $ProdutoSoma = 0;
													for ($i=1; $i <= $count['PDCount']; $i++) {
													?>

													<?php if ($metodo > 1) { ?>
													<input type="hidden" name="idTab_Produtos<?php echo $i ?>" value="<?php echo $derivados[$i]['idTab_Produtos']; ?>"/>
													<?php } ?>

													<input type="hidden" name="ProdutoHidden" id="ProdutoHidden<?php echo $i ?>" value="<?php echo $i ?>">

													<div class="form-group" id="97div<?php echo $i ?>">
														<div class="panel panel-warning">
															<div class="panel-heading">
																<div class="row">
																	<div class="col-md-4">
																		<label for="Nome_Prod">Produto <?php echo $i ?></label>
																		<input type="text" class="form-control"  id="Nome_Prod<?php echo $i ?>" <?php echo $readonly; ?> readonly = ""
																				  name="Nome_Prod<?php echo $i ?>" value="<?php echo $derivados[$i]['Nome_Prod']; ?>">
																	</div>
																	<div class="col-md-3">
																		<label for="Cor_Prod_Aux2">Tipo <?php echo $i ?></label>
																		<?php if ($i == 1) { ?>
																		<?php } ?>
																		<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?>
																				 id="listadinamicam<?php echo $i ?>" name="Cor_Prod_Aux2<?php echo $i ?>">
																			<option value="">-- Sel. Tipo --</option>
																			<?php
																			foreach ($select['Cor_Prod_Aux2'] as $key => $row) {
																				if ($derivados[$i]['Cor_Prod_Aux2'] == $key) {
																					echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																				} else {
																					echo '<option value="' . $key . '">' . $row . '</option>';
																				}
																			}
																			?>
																		</select>
																	</div>
																	<div class="col-md-2">
																		<label for="Tam_Prod_Aux1<?php echo $i ?>">Tam. <?php echo $i ?></label>
																		<?php if ($i == 1) { ?>
																		<?php } ?>
																		<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?>
																				 id="listadinamican<?php echo $i ?>" name="Tam_Prod_Aux1<?php echo $i ?>">
																			<option value="">-- Sel.Tamanho --</option>
																			<?php
																			foreach ($select['Tam_Prod_Aux1'] as $key => $row) {
																				if ($derivados[$i]['Tam_Prod_Aux1'] == $key) {
																					echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																				} else {
																					echo '<option value="' . $key . '">' . $row . '</option>';
																				}
																			}
																			?>
																		</select>
																	</div>
																	<div class="col-md-2">
																		<label for="Valor_Produto">Valor Custo <?php echo $i ?></label>
																		<div class="input-group">
																			<span class="input-group-addon" id="basic-addon1">R$</span>
																			<input type="text" class="form-control Valor" id="Valor_Produto<?php echo $i ?>" maxlength="10" placeholder="0,00"
																				name="Valor_Produto<?php echo $i ?>" value="<?php echo $derivados[$i]['Valor_Produto'] ?>">
																		</div>
																	</div>
																	<div class="col-md-1">
																		<label><br></label><br>
																		<button type="button" id="<?php echo $i ?>" class="remove_field97 btn btn-danger">
																			<span class="glyphicon glyphicon-trash"></span>
																		</button>
																	</div>
																</div>
															</div>
														</div>
													</div>

													<?php
													//$QtdSoma+=$derivados[$i]['QtdProduto'];
													//$ProdutoSoma++;
													}
													?>
													<input type="hidden" name="CountMax" id="CountMax" value="<?php echo $ProdutoSoma ?>">
												</div>
												
												<div class="panel panel-warning">
													<div class="panel-heading text-left">
														<div class="row">
															<div class="col-md-4">
																<label></label>
																<a class="add_field_button97 btn btn-success">
																	<span class="glyphicon glyphicon-arrow-up"></span> Adicionar Derivados
																</a>
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
				<?php } ?>	
				<?php if ($metodo > 3) { ?>	
					<div class="row">	
						<div class="col-md-12">
							<div class="panel-group" id="accordion3" role="tablist" aria-multiselectable="true">
								<div class="panel panel-primary">
									 <div class="panel-heading" role="tab" id="heading3" data-toggle="collapse" data-parent="#accordion3" data-target="#collapse3">
										<h4 class="panel-title">
											<a class="accordion-toggle">
												<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
												Preços de Venda
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
											<input type="hidden" name="idTab_Valor<?php echo $i ?>" value="<?php echo $valor[$i]['idTab_Valor']; ?>"/>
											<?php } ?>

											<div class="form-group" id="3div<?php echo $i ?>">
												<div class="panel panel-info">
													<div class="panel-heading">			
														<div class="row">																					
															<div class="col-md-1">
																<label for="QtdProdutoDesconto">QtdPrd <?php echo $i ?>:</label>
																<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoDesconto<?php echo $i ?>" placeholder="0"
																		name="QtdProdutoDesconto<?php echo $i ?>" value="<?php echo $valor[$i]['QtdProdutoDesconto'] ?>">
															</div>
															<div class="col-md-1">
																<label for="QtdProdutoIncremento">QtdInc <?php echo $i ?>:</label>
																<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoIncremento<?php echo $i ?>" placeholder="0"
																		name="QtdProdutoIncremento<?php echo $i ?>" value="<?php echo $valor[$i]['QtdProdutoIncremento'] ?>">
															</div>
															<div class="col-md-4">
																<label for="idTab_Produtos<?php echo $i ?>">Produto <?php echo $i ?></label>
																<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?>
																		 id="listadinamicad<?php echo $i ?>" name="idTab_Produtos<?php echo $i ?>">
																	<option value="">-- Selecione uma opção --</option>
																	<?php
																	foreach ($select['idTab_Produtos'] as $key => $row) {
																		if ($valor[$i]['idTab_Produtos'] == $key) {
																			echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																		} else {
																			echo '<option value="' . $key . '">' . $row . '</option>';
																		}
																	}
																	?>
																</select>
															</div>
															<div class="col-md-2">
																<label for="ValorProduto">Preço de Venda <?php echo $i ?></label>
																<div class="input-group">
																	<span class="input-group-addon" id="basic-addon1">R$</span>
																	<input type="text" class="form-control Valor" id="ValorProduto<?php echo $i ?>" maxlength="10" placeholder="0,00"
																		name="ValorProduto<?php echo $i ?>" value="<?php echo $valor[$i]['ValorProduto'] ?>">
																</div>
															</div>
															<div class="col-md-2">
																<label for="Desconto">TipoValor <?php echo $i ?></label>
																<?php if ($i == 1) { ?>
																<?php } ?>
																<select data-placeholder="Selecione uma opção..." class="form-control" readonly=""
																		 id="listadinamicad<?php echo $i ?>" name="Desconto<?php echo $i ?>">
																	<option value="">-- Selecione uma opção --</option>
																	<?php
																	foreach ($select['Desconto'] as $key => $row) {
																		if ($valor[$i]['Desconto'] == $key) {
																			echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																		} else {
																			echo '<option value="' . $key . '">' . $row . '</option>';
																		}
																	}
																	?>
																</select>
															</div>											
															<div class="col-md-1">
																<label for="idTab_Promocao">Prom. <?php echo $i ?></label>
																<input type="text" class="form-control"  id="idTab_Promocao<?php echo $i ?>" <?php echo $readonly; ?>
																		readonly=""  name="idTab_Promocao<?php echo $i ?>" value="<?php echo $valor[$i]['idTab_Promocao']; ?>">
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
												<a class="add_field_button3 btn btn-xs btn-danger" onclick="adicionaValorDesconto()">
													<span class="glyphicon glyphicon-arrow-up"></span> Adicionar Valor
												</a>
											</div>
											
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>	
				

				<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) || ($_SESSION['log']['idSis_Empresa'] == 5))  { ?>
				
				<div class="row">
					<div class="col-md-12">
						<!--<input type="hidden" name="idApp_Cliente" value="<?php echo $_SESSION['Cliente']['idApp_Cliente']; ?>">-->
						<input type="hidden" name="idTab_Produto" value="<?php echo $produtos['idTab_Produto']; ?>">
						<?php if ($metodo > 1) { ?>
						<!--<input type="hidden" name="idTab_Valor" value="<?php echo $valor['idTab_Valor']; ?>">
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
												<a class="btn btn-danger" href="<?php echo base_url() . 'produtos/excluir/' . $produtos['idTab_Produto'] ?>" role="button">
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