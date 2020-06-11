<?php if (isset($msg)) echo $msg; ?>
			
<div class="col-md-12 ">	
<?php #echo validation_errors(); ?>

	<div class="panel panel-<?php echo $panel; ?>">
		<div class="panel-heading">
			<?php echo $titulo; ?> Produtos
			<a class="btn btn-sm btn-info" href="<?php echo base_url() ?>relatorio/produtos" role="button">
				<span class="glyphicon glyphicon-search"></span> Produtos
			</a>
			<a class="btn btn-sm btn-warning" href="<?php echo base_url() ?>relatorio/estoque" role="button">
				<span class="glyphicon glyphicon-search"></span> Estoque
			</a>
		</div>			
		<div class="panel-body">

			<?php echo form_open_multipart($form_open_path); ?>
			
				<!--Tab_Produto-->
	
				<div class="row">	
					<div class="col-md-6">
						<div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">	
							<div class="panel panel-primary">
								<div class="panel-heading" role="tab" id="heading2" data-toggle="collapse" data-parent="#accordion2" data-target="#collapse2">
									<h4 class="panel-title">
										<a class="accordion-toggle">
											<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
											Dados do Produto
										</a>
									</h4>
								</div>
								<div id="collapse2" class="panel-collapse" role="tabpanel" aria-labelledby="heading2" aria-expanded="false">
									<div class="panel panel-success">
										<div class="panel-heading">
											<!--
											<div class="row">
												<div class="col-md-4 text-left">
													<label for="Cadastrar">Mod/Cat/Tipo/Esp</label><br>
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
												<div class="col-md-8 text-left" id="Cadastrar" <?php echo $div['Cadastrar']; ?>>
													<label></label><br>
													<a class="btn btn-md btn-info"   target="_blank" href="<?php echo base_url() ?>prodaux42/cadastrar3/" role="button"> 
														<span class="glyphicon glyphicon-plus"></span> Mod
													</a>
													<label></label>
													<a class="btn btn-md btn-info"   target="_blank" href="<?php echo base_url() ?>prodaux32/cadastrar3" role="button"> 
														<span class="glyphicon glyphicon-plus"></span> Cat
													</a>									
													<label></label>
													<a class="btn btn-md btn-info"   target="_blank" href="<?php echo base_url() ?>prodaux22/cadastrar3/" role="button"> 
														<span class="glyphicon glyphicon-plus"></span> Tipo
													</a>
													<label></label>
													<a class="btn btn-md btn-info"   target="_blank" href="<?php echo base_url() ?>prodaux12/cadastrar3/" role="button"> 
														<span class="glyphicon glyphicon-plus"></span> Esp
													</a>
													<label></label>
													<a class="btn btn-md btn-info"   target="_blank" href="<?php echo base_url() ?>fornecedor2/cadastrar3/" role="button"> 
														<span class="glyphicon glyphicon-plus"></span> Fornec
													</a>
													<label></label>									
													<button class="btn btn-md btn-primary"  id="inputDb" data-loading-text="Aguarde..." type="submit">
															<span class="glyphicon glyphicon-refresh"></span> Ref.
													</button>
													<?php echo form_error('Cadastrar'); ?>
												</div>
											</div>											
											<div class="row">
												<div class="col-md-3">
													<label for="Prodaux4">Modelo</label>								
													<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" <?php echo $readonly; ?>
															id="Prodaux4" name="Prodaux4">
														<option value="">-- Selecione uma op��o --</option>
														<?php
														foreach ($select['Prodaux4'] as $key => $row) {
															if ($produtos['Prodaux4'] == $key) {
																echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
															} else {
																echo '<option value="' . $key . '">' . $row . '</option>';
															}
														}
														?>
													</select>
													<?php echo form_error('Prodaux4'); ?>
												</div>
												<div class="col-md-3">
													<label for="Prodaux2">Tipo:</label>								
													<select data-placeholder="Selecione uma op��o..." class="form-control" <?php echo $readonly; ?>
															id="Prodaux2" name="Prodaux2">
														<option value="">-- Selecione uma op��o --</option>
														<?php
														foreach ($select['Prodaux2'] as $key => $row) {
															if ($produtos['Prodaux2'] == $key) {
																echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
															} else {
																echo '<option value="' . $key . '">' . $row . '</option>';
															}
														}
														?>
													</select>
													<?php echo form_error('Prodaux2'); ?>
												</div>
												<div class="col-md-3">
													<label for="Prodaux1">Esp.:</label>									
													<select data-placeholder="Selecione uma op��o..." class="form-control" <?php echo $readonly; ?>
															id="Prodaux1" name="Prodaux1">
														<option value="">-- Selecione uma op��o --</option>
														<?php
														foreach ($select['Prodaux1'] as $key => $row) {
															if ($produtos['Prodaux1'] == $key) {
																echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
															} else {
																echo '<option value="' . $key . '">' . $row . '</option>';
															}
														}
														?>
													</select>
													<?php echo form_error('Prodaux1'); ?>
												</div>
											</div>
											-->
											<div class="row">	
												<div class="col-md-4">
													<label for="Prodaux3">Categoria*</label>								
													<select data-placeholder="Selecione uma op��o..." class="form-control" <?php echo $readonly; ?>
															id="Prodaux3" name="Prodaux3">
														<option value="">-- Selecione uma op��o --</option>
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
												<div class="col-md-4"></div>
												<div class="col-md-4">
													<label for="Cadastrar">Cat.Cad?</label><br>
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
												
												<!--
												<div class="col-md-3">
													<label for="CodProd">C�digo:</label><br>
													<input type="text" class="form-control" maxlength="25" readonly=""
															name="CodProd" id="CodProd" value="<?php echo $produtos['CodProd'] ?>">
													<?php echo form_error('CodProd'); ?>
												</div>
												-->
											</div>
											
											<div class="row">
												<div class="col-md-8">	
													<label for="Produtos">Modelo*</label><br>
													<input type="text" class="form-control" maxlength="200"
															name="Produtos" id="Produtos" value="<?php echo $produtos['Produtos'] ?>">
													<?php echo form_error('Produtos'); ?>
												</div>
												<div class="col-md-4 text-left" id="Cadastrar" <?php echo $div['Cadastrar']; ?>>
													<label></label><br>
													<a class="btn btn-sm btn-info"   target="_blank" href="<?php echo base_url() ?>prodaux32/cadastrar3" role="button"> 
														<span class="glyphicon glyphicon-plus"></span> Cat
													</a>
													<!--
													<label></label>
													<a class="btn btn-md btn-info"   target="_blank" href="<?php echo base_url() ?>prodaux42/cadastrar3/" role="button"> 
														<span class="glyphicon glyphicon-plus"></span> Mod
													</a>									
													<label></label>
													<a class="btn btn-md btn-info"   target="_blank" href="<?php echo base_url() ?>prodaux22/cadastrar3/" role="button"> 
														<span class="glyphicon glyphicon-plus"></span> Tipo
													</a>
													<label></label>
													<a class="btn btn-md btn-info"   target="_blank" href="<?php echo base_url() ?>prodaux12/cadastrar3/" role="button"> 
														<span class="glyphicon glyphicon-plus"></span> Esp
													</a>
													<label></label>
													<a class="btn btn-md btn-info"   target="_blank" href="<?php echo base_url() ?>fornecedor2/cadastrar3/" role="button"> 
														<span class="glyphicon glyphicon-plus"></span> Fornec
													</a>
													-->
													<label></label>									
													<button class="btn btn-sm btn-primary"  id="inputDb" data-loading-text="Aguarde..." type="submit">
															<span class="glyphicon glyphicon-refresh"></span> Ref.
													</button>
													<?php echo form_error('Cadastrar'); ?>
												</div>
											</div>
											
											<div class="row">				
												<div class="col-md-4">
													<label for="TipoProduto">Venda/Cons/Alug:</label>
													<select data-placeholder="Selecione uma op��o..." class="form-control" <?php echo $readonly; ?>
															id="TipoProduto" name="TipoProduto">
														<option value="">-- Selecione uma op��o --</option>
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
												<div class="col-md-4">
													<label for="UnidadeProduto">Unidade:</label>
													<select data-placeholder="Selecione uma op��o..." class="form-control" <?php echo $readonly; ?>
															id="UnidadeProduto" name="UnidadeProduto">
														<option value="">-- Selecione uma op��o --</option>
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
												
												<div class="col-md-4 text-left">
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
											</div>
											<div class="row">
												<div class="col-md-4">
													<label for="Comissao">Comiss�o:</label><br>
													<div class="input-group">
														<span class="input-group-addon" id="basic-addon1">(%)</span>
														<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"
																name="Comissao" value="<?php echo $produtos['Comissao'] ?>">
													</div>
												</div>
												<div class="col-md-4">
													<label for="PesoProduto">Peso:</label><br>
													<div class="input-group">
														<span class="input-group-addon" id="basic-addon1">(kg)</span>
														<input type="text" class="form-control Peso" maxlength="10" placeholder="0,000"
																name="PesoProduto" value="<?php echo $produtos['PesoProduto'] ?>">
													</div>
												</div>

												<div id="Ativo" <?php echo $div['Ativo']; ?>>	
													<div class="col-md-4 text-left">
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
										</div>
									</div>
								</div>
							</div>
						</div>	
					</div>
					<div class="col-md-3">	
						<div class="panel-group" id="accordion5" role="tablist" aria-multiselectable="true">
							<div class="panel panel-primary">
								 <div class="panel-heading" role="tab" id="heading5" data-toggle="collapse" data-parent="#accordion5" data-target="#collapse5">
									<h4 class="panel-title">
										<a class="accordion-toggle">
											<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
											Tipo / Cor / Sabor
										</a>
									</h4>
								</div>

								<div id="collapse5" class="panel-collapse" role="tabpanel" aria-labelledby="heading5" aria-expanded="false">
									<div class="panel panel-success">
										<div class="panel-heading">
											<input type="hidden" name="PCount" id="PCount" value="<?php echo $count['PCount']; ?>"/>

											<div class="input_fields_wrap92">
												
												<?php
												$QtdSoma = $ProdutoSoma = 0;
												for ($i=1; $i <= $count['PCount']; $i++) {
												?>

												<?php if ($metodo > 1) { ?>
												<input type="hidden" name="idTab_Cor_Prod<?php echo $i ?>" value="<?php echo $produto[$i]['idTab_Cor_Prod']; ?>"/>
												<?php } ?>

												<input type="hidden" name="ProdutoHidden" id="ProdutoHidden<?php echo $i ?>" value="<?php echo $i ?>">

												<div class="form-group" id="92div<?php echo $i ?>">
													<div class="panel panel-warning">
														<div class="panel-heading">
															<!--
															<div class="row">
																<div class="col-md-12">
																	<label for="idTab_Promocao<?php echo $i ?>">Promocao <?php echo $i ?></label>
																	<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" <?php echo $readonly; ?>
																			 id="listadinamicai<?php echo $i ?>" name="idTab_Promocao<?php echo $i ?>">
																		<option value="">-- Selecione uma op��o --</option>
																		<?php
																		foreach ($select['idTab_Promocao'] as $key => $row) {
																			if ($produto[$i]['idTab_Promocao'] == $key) {
																				echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																			} else {
																				echo '<option value="' . $key . '">' . $row . '</option>';
																			}
																		}
																		?>
																	</select>
																</div>
															</div>
															-->
															<div class="row">
																<div class="col-md-9">
																	<label for="Nome_Cor_Prod">Tipo/Cor/Sabor <?php echo $i ?></label>
																	<div class="input-group">
																		<input type="text" class="form-control" id="Nome_Cor_Prod<?php echo $i ?>"
																			name="Nome_Cor_Prod<?php echo $i ?>" value="<?php echo $produto[$i]['Nome_Cor_Prod'] ?>">
																	</div>
																</div>
																<!--
																<div class="col-md-10">
																	<label for="Cor_Prod<?php echo $i ?>">Tipo / Cor / Sabor <?php echo $i ?></label>
																	<?php if ($i == 1) { ?>
																	<?php } ?>
																	<select data-placeholder="Sel. Cor" class="form-control Chosen" <?php echo $readonly; ?>
																			 id="listadinamicaf<?php echo $i ?>" name="Cor_Prod<?php echo $i ?>">
																		<option value="">-- Sel. Cor --</option>
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
																
																<div class="col-md-4">
																	<label for="Valor_Cor_Prod">Valor <?php echo $i ?></label>
																	<div class="input-group">
																		<span class="input-group-addon" id="basic-addon1">R$</span>
																		<input type="text" class="form-control Valor" id="Valor_Cor_Prod<?php echo $i ?>" maxlength="10" placeholder="0,00"
																			name="Valor_Cor_Prod<?php echo $i ?>" value="<?php echo $produto[$i]['Valor_Cor_Prod'] ?>">
																	</div>
																</div>
																-->
																<div class="col-md-1">
																	<label><br></label><br>
																	<button type="button" id="<?php echo $i ?>" class="remove_field92 btn btn-danger"
																			onclick="calculaQtdSoma('Cor_Prod','QtdSoma','ProdutoSoma',1,<?php echo $i ?>,'CountMax',0,'ProdutoHidden')">
																		<span class="glyphicon glyphicon-trash"></span>
																	</button>
																</div>																											
															</div>
														</div>
													</div>
												</div>

												<?php
												$QtdSoma+=$produto[$i]['Cor_Prod'];
												$ProdutoSoma++;
												}
												?>
												<input type="hidden" name="CountMax" id="CountMax" value="<?php echo $ProdutoSoma ?>">

											</div>
										
											<div class="panel panel-warning">
												<div class="panel-heading text-left">
													<div class="row">
														<div class="col-md-3">
															
															<a class="add_field_button92 btn btn-success"
																	onclick="calculaQtdSoma('Cor_Prod','QtdSoma','ProdutoSoma',0,0,'CountMax',1,0)">
																<span class="glyphicon glyphicon-arrow-up"></span> Adicionar Tipo/ Cor/ Sabor
															</a>
														</div>
														<!--
														<div class="col-md-2 text-center">	
															
															<b>Produtos: <span id="QtdSoma"><?php echo $QtdSoma ?></span></b>
														</div>
														<div class="col-md-2 text-center">	
															
															<b>Linhas: <span id="ProdutoSoma"><?php echo $ProdutoSoma ?></span></b><br />
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
					</div>	
					<div class="col-md-3">	
						<div class="panel-group" id="accordion6" role="tablist" aria-multiselectable="true">
							<div class="panel panel-primary">
								 <div class="panel-heading" role="tab" id="heading6" data-toggle="collapse" data-parent="#accordion6" data-target="#collapse6">
									<h4 class="panel-title">
										<a class="accordion-toggle">
											<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
											Tamanho
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
															<!--
															<div class="row">
																<div class="col-md-12">
																	<label for="idTab_Promocao<?php echo $i ?>">Promocao <?php echo $i ?></label>
																	<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" <?php echo $readonly; ?>
																			 id="listadinamicaj<?php echo $i ?>" name="idTab_Promocao<?php echo $i ?>">
																		<option value="">-- Selecione uma op��o --</option>
																		<?php
																		foreach ($select['idTab_Promocao'] as $key => $row) {
																			if ($procedimento[$i]['idTab_Promocao'] == $key) {
																				echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																			} else {
																				echo '<option value="' . $key . '">' . $row . '</option>';
																			}
																		}
																		?>
																	</select>
																</div>
															</div>
															-->
															<div class="row">
																<div class="col-md-9">
																	<label for="Nome_Tam_Prod">Esp/Tamanho <?php echo $i ?></label>
																	<div class="input-group">
																		<input type="text" class="form-control Valor" id="Nome_Tam_Prod<?php echo $i ?>"
																			name="Nome_Tam_Prod<?php echo $i ?>" value="<?php echo $procedimento[$i]['Nome_Tam_Prod'] ?>">
																	</div>
																</div>
																<!--
																<div class="col-md-10">
																	<label for="Tam_Prod">Tamanho / Esp <?php echo $i ?></label>
																	<?php if ($i == 1) { ?>
																	<?php } ?>
																	<select data-placeholder="Sel. Tamanho" class="form-control"
																			 id="listadinamicag<?php echo $i ?>" name="Tam_Prod<?php echo $i ?>">
																		<option value="">-- Sel. Tamanho --</option>
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
																
																<div class="col-md-4">
																	<label for="Fator_Tam_Prod">Fator <?php echo $i ?></label>
																	<div class="input-group">
																		<span class="input-group-addon" id="basic-addon1">X</span>
																		<input type="text" class="form-control Valor" id="Fator_Tam_Prod<?php echo $i ?>" maxlength="10" placeholder="0,00"
																			name="Fator_Tam_Prod<?php echo $i ?>" value="<?php echo $procedimento[$i]['Fator_Tam_Prod'] ?>">
																	</div>
																</div>
																-->
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
																
															<a class="add_field_button91 btn btn-success"
																	onclick="calculaQtdSoma('Tam_Prod','QtdSoma','ProdutoSoma',0,0,'CountMax',1,0)">
																<span class="glyphicon glyphicon-arrow-up"></span> Adicionar Tamanho
															</a>
														</div>
														<!--
														<div class="col-md-2 text-center">	
															
															<b>Produtos: <span id="QtdSoma"><?php echo $QtdSoma ?></span></b>
														</div>
														<div class="col-md-2 text-center">	
															
															<b>Linhas: <span id="ProdutoSoma"><?php echo $ProdutoSoma ?></span></b><br />
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
					</div>
					<!-- essa parte, depois, vai virar departamentos-->
					<!-- 
					<div class="col-md-5 panel-body">
						<div class="panel-group" id="accordion4" role="tablist" aria-multiselectable="true">
							<div class="panel panel-primary">
								 <div class="panel-heading" role="tab" id="heading4" data-toggle="collapse" data-parent="#accordion4" data-target="#collapse4">
									<h4 class="panel-title">
										<a class="accordion-toggle">
											<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
											Categoria
										</a>
									</h4>
								</div>

								<div id="collapse4" class="panel-collapse" role="tabpanel" aria-labelledby="heading4" aria-expanded="false">
									<div class="panel panel-success">
										<div class="panel-heading">
											<input type="hidden" name="SCount" id="SCount" value="<?php echo $count['SCount']; ?>"/>

											<div class="input_fields_wrap93">
												
												<?php
												$QtdSoma = $ProdutoSoma = 0;
												for ($i=1; $i <= $count['SCount']; $i++) {
												?>

												<?php if ($metodo > 1) { ?>
												<input type="hidden" name="idTab_Cat_Prod<?php echo $i ?>" value="<?php echo $servico[$i]['idTab_Cat_Prod']; ?>"/>
												<?php } ?>

												<input type="hidden" name="ProdutoHidden" id="ProdutoHidden<?php echo $i ?>" value="<?php echo $i ?>">

												<div class="form-group" id="93div<?php echo $i ?>">
													<div class="panel panel-warning">
														<div class="panel-heading">
															<div class="row">
																<div class="col-md-10">
																	<label for="Cat_Prod">Categoria <?php echo $i ?></label>
																	<?php if ($i == 1) { ?>
																	<?php } ?>
																	<select data-placeholder="Sel. Categoria" class="form-control"
																			 id="listadinamicah<?php echo $i ?>" name="Cat_Prod<?php echo $i ?>">
																		<option value="">-- Sel. Categoria --</option>
																		<?php
																		foreach ($select['Cat_Prod'] as $key => $row) {
																			if ($servico[$i]['Cat_Prod'] == $key) {
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
																	<button type="button" id="<?php echo $i ?>" class="remove_field93 btn btn-danger"
																			onclick="calculaQtdSoma('Cat_Prod','QtdSoma','ProdutoSoma',1,<?php echo $i ?>,'CountMax',0,'ProdutoHidden')">
																		<span class="glyphicon glyphicon-trash"></span>
																	</button>
																</div>																											
															</div>
														</div>
													</div>
												</div>

												<?php
												$QtdSoma+=$servico[$i]['Cat_Prod'];
												$ProdutoSoma++;
												}
												?>
												<input type="hidden" name="CountMax" id="CountMax" value="<?php echo $ProdutoSoma ?>">
											</div>
										
											<div class="panel panel-warning">
												<div class="panel-heading text-left">
													<div class="row">
														<div class="col-md-3">
															
															<a class="add_field_button93 btn btn-success"
																	onclick="calculaQtdSoma('Cat_Prod','QtdSoma','ProdutoSoma',0,0,'CountMax',1,0)">
																<span class="glyphicon glyphicon-arrow-up"></span> Adicionar Categoria
															</a>
														</div>
														
														<div class="col-md-2 text-center">	
															
															<b>Produtos: <span id="QtdSoma"><?php echo $QtdSoma ?></span></b>
														</div>
														<div class="col-md-2 text-center">	
															
															<b>Linhas: <span id="ProdutoSoma"><?php echo $ProdutoSoma ?></span></b><br />
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
					-->
				
				</div>
				
				<div class="row">														
					<div class="panel-body">	
						
							<div class="panel-body">
								<input type="hidden" name="PDCount" id="PDCount" value="<?php echo $count['PDCount']; ?>"/>

								<div class="input_fields_wrap97">

									<?php
									$QtdSoma = $ProdutoSoma = 0;
									for ($i=1; $i <= $count['PDCount']; $i++) {
									?>

									<?php if ($metodo > 1) { ?>
									<input type="hidden" name="idApp_Produto<?php echo $i ?>" value="<?php echo $produto[$i]['idApp_Produto']; ?>"/>
									<?php } ?>

									<input type="hidden" name="ProdutoHidden" id="ProdutoHidden<?php echo $i ?>" value="<?php echo $i ?>">

									<div class="form-group" id="97div<?php echo $i ?>">
										<div class="panel panel-success">
											<div class="panel-heading">
												<div class="row">
													<div class="col-md-2">
														<label for="QtdProduto">Qtd <?php echo $i ?>:</label>
														<input type="text" class="form-control Numero" maxlength="10" id="QtdProduto<?php echo $i ?>" placeholder="0"
																onkeyup="calculaSubtotal(this.value,this.name,'<?php echo $i ?>','QTD','Produto'),calculaQtdSoma('QtdProduto','QtdSoma','ProdutoSoma',0,0,'CountMax',0,'ProdutoHidden')"
																name="QtdProduto<?php echo $i ?>" value="<?php echo $produto[$i]['QtdProduto'] ?>">
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
															<!--<option value="">-- Selecione uma op��o --</option>-->
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
													<div class="col-md-1"></div>
													<div class="col-md-1">
														<label><br></label><br>
														<button type="button" id="<?php echo $i ?>" class="remove_field97 btn btn-danger"
																onclick="calculaQtdSoma('QtdProduto','QtdSoma','ProdutoSoma',1,<?php echo $i ?>,'CountMax',0,'ProdutoHidden')">
															<span class="glyphicon glyphicon-trash"></span>
														</button>
													</div>
													<div class="col-md-2">
														<label for="idSis_Usuario<?php echo $i ?>">Profissional:</label>
														<?php if ($i == 1) { ?>
														<?php } ?>
														<select data-placeholder="Selecione uma op��o..." class="form-control"
																 id="listadinamicac<?php echo $i ?>" name="idSis_Usuario<?php echo $i ?>">
															<option value="">-- Sel.Profis. --</option>
															<?php
															foreach ($select['idSis_Usuario'] as $key => $row) {
																(!$produto['idSis_Usuario']) ? $produto['idSis_Usuario'] = $_SESSION['log']['id']: FALSE;
																if ($produto[$i]['idSis_Usuario'] == $key) {
																	echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																} else {
																	echo '<option value="' . $key . '">' . $row . '</option>';
																}
															}
															?>
														</select>
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
													<div class="col-md-2">
														<label for="ObsProduto<?php echo $i ?>">Obs: <?php echo $i ?>:</label>
														<textarea class="form-control" id="ObsProduto<?php echo $i ?>" <?php echo $readonly; ?>
																  name="ObsProduto<?php echo $i ?>"><?php echo $produto[$i]['ObsProduto']; ?></textarea>
													</div>																				
													<div class="col-md-2 panel-body">
														<div class="panel panel-primary">
															<div class="panel-heading">
																<div class="row">				
																	<div class="col-md-12">
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
																</div>
															</div>
														</div>
													</div>	
													<div class="col-md-2 panel-body">
														<div class="panel panel-danger">
															<div class="panel-heading">
																<div class="row">				
																	<div class="col-md-12">
																		<label for="DevolvidoProduto">Devolvido? </label><br>
																		<div class="btn-group" data-toggle="buttons">
																			<?php
																			foreach ($select['DevolvidoProduto'] as $key => $row) {
																				(!$produto[$i]['DevolvidoProduto']) ? $produto[$i]['DevolvidoProduto'] = 'N' : FALSE;

																				if ($produto[$i]['DevolvidoProduto'] == $key) {
																					echo ''
																					. '<label class="btn btn-warning active" name="radiobutton_DevolvidoProduto' . $i . '" id="radiobutton_DevolvidoProduto' . $i .  $key . '">'
																					. '<input type="radio" name="DevolvidoProduto' . $i . '" id="radiobuttondinamico" '
																					. 'autocomplete="off" value="' . $key . '" checked>' . $row
																					. '</label>'
																					;
																				} else {
																					echo ''
																					. '<label class="btn btn-default" name="radiobutton_DevolvidoProduto' . $i . '" id="radiobutton_DevolvidoProduto' . $i .  $key . '">'
																					. '<input type="radio" name="DevolvidoProduto' . $i . '" id="radiobuttondinamico" '
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
								<div class="row">
									<div class="col-md-12 panel-body ">
										<div class="panel panel-success">
											<div class="panel-heading text-left">
												<div class="row">
													<div class="col-md-4">
														<label></label>
														<a class="add_field_button97 btn btn-success"
																onclick="calculaQtdSoma('QtdProduto','QtdSoma','ProdutoSoma',0,0,'CountMax',1,0)">
															<span class="glyphicon glyphicon-arrow-up"></span> Adicionar Derivado
														</a>
													</div>
													<!--
													<div class="col-md-2 text-center">	
														
														<b>Produtos: <span id="QtdSoma"><?php echo $QtdSoma ?></span></b>
													</div>
													<div class="col-md-2 text-center">	
														
														<b>Linhas: <span id="ProdutoSoma"><?php echo $ProdutoSoma ?></span></b><br />
													</div>
													<div class="col-md-4 text-right">
														<label></label>
														<a class="btn btn-md btn-danger" target="_blank" href="<?php echo base_url() ?>relatorio2/produtos2" role="button"> 
															<span class="glyphicon glyphicon-plus"></span> Novo/ Editar/ Estoque
														</a>
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
				
				<?php if (($_SESSION['log']['TabelasEmpresa'] == 1)) { ?>						
				<div class="row">	
					<div class="col-md-6">
						<div class="panel-group" id="accordion3" role="tablist" aria-multiselectable="true">
							<div class="panel panel-primary">
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
														
														<div class="col-md-3">
															<label for="ValorProduto">Valor no Balc�o:</label>
															<div class="input-group">
																<span class="input-group-addon" id="basic-addon1">R$</span>
																<input type="text" class="form-control Valor" id="ValorProduto<?php echo $i ?>" maxlength="10" placeholder="0,00"
																	name="ValorProduto<?php echo $i ?>" value="<?php echo $valor[$i]['ValorProduto'] ?>">
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
											<div class="row">
												<div class="col-md-4">
													<a class="btn btn-xs btn-danger" onclick="adicionaValor()">
														<span class="glyphicon glyphicon-plus"></span> Adicionar Valor
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
				
				<?php } else {?>
				
				<div class="row">	
					<div class="col-md-12">
						<div class="panel-group" id="accordion3" role="tablist" aria-multiselectable="true">
							<div class="panel panel-primary">
								 <div class="panel-heading" role="tab" id="heading3" data-toggle="collapse" data-parent="#accordion3" data-target="#collapse3">
									<h4 class="panel-title">
										<a class="accordion-toggle">
											<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
											Pre�os & Promo��es
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
														<div class="col-md-2">
															<label for="QtdProdutoDesconto">Qtd <?php echo $i ?>:</label>
															<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoDesconto<?php echo $i ?>" placeholder="0"
																	name="QtdProdutoDesconto<?php echo $i ?>" value="<?php echo $valor[$i]['QtdProdutoDesconto'] ?>">
														</div>											

														<div class="col-md-4">
															<label for="Convdesc">Descri��o <?php echo $i ?></label>
															<input type="text" class="form-control"  id="Convdesc<?php echo $i ?>" <?php echo $readonly; ?>
																	  name="Convdesc<?php echo $i ?>" value="<?php echo $valor[$i]['Convdesc']; ?>">
														</div>
														
														<div class="col-md-2">
															<label for="ValorProduto">Valor <?php echo $i ?></label>
															<div class="input-group">
																<span class="input-group-addon" id="basic-addon1">R$</span>
																<input type="text" class="form-control Valor" id="ValorProduto<?php echo $i ?>" maxlength="10" placeholder="0,00"
																	name="ValorProduto<?php echo $i ?>" value="<?php echo $valor[$i]['ValorProduto'] ?>">
															</div>
														</div>
														<div class="col-md-3">
															<label for="Desconto">Tipo de Desconto <?php echo $i ?></label>
															<?php if ($i == 1) { ?>
															<?php } ?>
															<select data-placeholder="Selecione uma op��o..." class="form-control" readonly=''
																	 id="listadinamicad<?php echo $i ?>" name="Desconto<?php echo $i ?>">
																<option value="">-- Selecione uma op��o --</option>
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
						<!--<input type="hidden" name="idApp_Cliente" value="<?php echo $_SESSION['Cliente']['idApp_Cliente']; ?>">-->
						<input type="hidden" name="idTab_Produto" value="<?php echo $produtos['idTab_Produto']; ?>">
						<?php if ($metodo > 1) { ?>
						<!--<input type="hidden" name="idTab_Valor" value="<?php echo $valor['idTab_Valor']; ?>">
						<input type="hidden" name="idApp_ParcelasRec" value="<?php echo $parcelasrec['idApp_ParcelasRec']; ?>">-->
						<?php } ?>
						<?php if ($metodo == 2) { ?>

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
											<p>Ao confirmar a exclus�o todos os dados ser�o exclu�dos do banco de dados. Esta opera��o � irrevers�vel.</p>
										</div>
										<div class="modal-footer">
											<div class="col-md-6 text-left">
												<button type="button" class="btn btn-warning" data-dismiss="modal">
													<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
												</button>
											</div>
											<div class="col-md-6 text-right">
												<a class="btn btn-danger" href="<?php echo base_url() . 'produtos/excluir/' . $produtos['idTab_Produto'] ?>" role="button">
													<span class="glyphicon glyphicon-trash"></span> Confirmar Exclus�o
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
				
				<?php } ?>
			
			</form>

		</div>

	</div>

</div>	