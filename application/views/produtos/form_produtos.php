
			
<div class="col-md-12 ">	
<?php #echo validation_errors(); ?>

	<div class="panel panel-<?php echo $panel; ?>">
		
		<div class="panel-heading">
			<?php echo $titulo; ?>
			<?php if ($metodo >= 2) { ?>
				<a class="btn btn-sm btn-info" href="<?php echo base_url() ?>relatorio/produtos" role="button">
					<span class="glyphicon glyphicon-search"></span> Produtos/Servicos
				</a>
				<a class="btn btn-sm btn-warning" href="<?php echo base_url() ?>relatorio/estoque" role="button">
					<span class="glyphicon glyphicon-search"></span> Estoque
				</a>
				<a class="btn btn-sm btn-danger" href="<?php echo base_url() ?>produtos/cadastrar" role="button">
					<span class="glyphicon glyphicon-plus"></span> Cadastrar Produto
				</a>
			<?php } ?>
		</div>
		
		<div class="panel-body">

			<?php echo form_open_multipart($form_open_path); ?>
			
				<!--Tab_Produtos-->
	
				<div class="row">
					<div class="col-md-12">
						<div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">	
							<?php if (isset($msg)) echo $msg; ?>
							<div class="panel panel-primary">
								<div class="panel-heading" role="tab" id="heading2" data-toggle="collapse" data-parent="#accordion2" data-target="#collapse2">
									<h4 class="panel-title">
										<a class="accordion-toggle">
											<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
											Dados do Produto: 
										</a>
									</h4>
								</div>
								
								<div id="collapse2" class="panel-collapse" role="tabpanel" aria-labelledby="heading2" aria-expanded="false">
									<div class="panel panel-success">
										<div class="panel-heading">
											<?php if ($metodo < 4) { ?>	
												<div class="row">
													<div class="col-md-2 text-left">
														<label for="Cadastrar">Encontrou?</label><br>
														<div class="btn-group" data-toggle="buttons">
															<?php
															foreach ($select['Cadastrar'] as $key => $row) {
																if (!$cadastrar['Cadastrar']) $cadastrar['Cadastrar'] = 'S';
															
																($key == 'N') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																if ($cadastrar['Cadastrar'] == $key) {
																	echo ''
																	. '<label class="btn btn-warning active" name="Cadastrar_' . $hideshow . '">'
																	. '<input type="radio" name="Cadastrar" id="' . $hideshow . '" '
																	. 'onchange="codigo()" '
																	. 'autocomplete="off" value="' . $key . '" checked>' . $row
																	. '</label>'
																	;
																} else {
																	echo ''
																	. '<label class="btn btn-default" name="Cadastrar_' . $hideshow . '">'
																	. '<input type="radio" name="Cadastrar" id="' . $hideshow . '" '
																	. 'onchange="codigo()" '
																	. 'autocomplete="off" value="' . $key . '" >' . $row
																	. '</label>'
																	;
																}
															}
															?>

														</div>
													</div>
													<div class="col-md-10 text-left" id="Cadastrar" <?php echo $div['Cadastrar']; ?>>
														<div class="row">
															<div class="col-md-2 text-left">	
																<label >Categoria</label><br>
																<button type="button" class="btn btn-success" data-toggle="modal" data-target="#addCatprodModal">
																	Cadastrar
																</button>
															</div>
															<?php if ($metodo >= 2) { ?>
															<div class="col-md-2 text-left">	
																<label >Produto</label><br>
																<button type="button" class="btn btn-success" data-toggle="modal" data-target="#addProdutoModal">
																	Cadastrar
																</button>
															</div>
															<?php } ?>
															<?php if ($metodo >= 2) { ?>
																<div class="col-md-2 text-left">	
																	<label >Atributos</label><br>
																	<button type="button" class="btn btn-success" data-toggle="modal" data-target="#addAtributoModal">
																		Cadastrar
																	</button>
																</div>	
																<div class="col-md-2 text-left">
																	<label >Opcao</label><br>
																	<button type="button" class="btn btn-success" data-toggle="modal" data-target="#addOpcaoModal">
																		Cadastrar
																	</button>
																</div>
															<?php } ?>	
															<div class="col-md-2 text-left">
																<label >Recarregar</label><br>
																<button class="btn btn-md btn-primary"  id="inputDb" data-loading-text="Aguarde..." type="submit">
																		<span class="glyphicon glyphicon-refresh"></span>Recarregar
																</button>
															</div>	
															<span id="msg"></span>
														</div>	
														<?php echo form_error('Cadastrar'); ?>
													</div>
												</div>
											<?php } ?>	
												<div class="row">
													<div class="col-md-3">
														<label for="idTab_Catprod">Categoria *</label>
														<?php if ($metodo < 2) { ?>
															<select data-placeholder="Selecione uma Categoria..." class="form-control Chosen" 
																	id="idTab_Catprod" name="idTab_Catprod">
																<option value="">-- Selecione uma Categoria --</option>
																<?php
																foreach ($select['idTab_Catprod'] as $key => $row) {
																	if ($produtos['idTab_Catprod'] == $key) {
																		echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																	} else {
																		echo '<option value="' . $key . '">' . $row . '</option>';
																	}
																}
																?>
															</select>
														<?php } else { ?>
															<input type="hidden" id="idTab_Catprod" name="idTab_Catprod" value="<?php echo $_SESSION['Produtos']['idTab_Catprod']; ?>">
															<input class="form-control"readonly="" value="<?php echo $_SESSION['Produtos']['Catprod']; ?>">
														<?php } ?>
														
														<?php echo form_error('idTab_Catprod'); ?>
													</div>
													
													<div class="col-md-3">
														<?php if ($metodo >= 2) { ?>
															<label for="idTab_Produto">Produto Base*</label>
															<?php if ($metodo == 2) { ?>
																<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" id="idTab_Produto" name="idTab_Produto" onchange="codigo()">
																	<option value="">-- Selecione uma op��o --</option>
																	<?php
																	foreach ($select['idTab_Produto'] as $key => $row) {
																		if ($produtos['idTab_Produto'] == $key) {
																			echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																		} else {
																			echo '<option value="' . $key . '">' . $row . '</option>';
																		}
																	}
																	?>
																</select>
															<?php }else{ ?>
																<input type="hidden" id="idTab_Produto" name="idTab_Produto" value="<?php echo $_SESSION['Produtos']['idTab_Produto']; ?>">
																<input class="form-control"readonly="" value="<?php echo $_SESSION['Produtos']['Produtos']; ?>">
															<?php } ?>
															<?php echo form_error('idTab_Produto'); ?>
														<?php } ?>
													</div>
													
													<?php if ($metodo >= 2) { ?>
														
															<div class="col-md-3">
																
																<?php if ($_SESSION['Atributo'][1]['idTab_Atributo']) { ?>
																	<label for="Opcao_Atributo_1"><?php echo $_SESSION['Atributo'][1]['Atributo']; ?></label>
																	<?php if ($metodo == 2) { ?>
																		<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" id="Opcao_Atributo_1" name="Opcao_Atributo_1" onchange="codigo()">
																			<option value="">-- Selecione uma op��o --</option>
																			<?php
																			foreach ($select['Opcao_Atributo_1'] as $key => $row) {
																				if ($produtos['Opcao_Atributo_1'] == $key) {
																					echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																				} else {
																					echo '<option value="' . $key . '">' . $row . '</option>';
																				}
																			}
																			?>
																		</select>
																		<?php echo form_error('Opcao_Atributo_1'); ?>
																	<?php }else{ ?>
																		<input type="hidden" id="Opcao_Atributo_1" name="Opcao_Atributo_1" value="<?php echo $_SESSION['Produtos']['Opcao_Atributo_1']; ?>">
																		<input class="form-control"readonly="" value="<?php echo $_SESSION['Produtos']['Opcao1']; ?>">
																	<?php } ?>
																<?php }else{ ?>
																	<label for="Opcao_Atributo_1">N�o existe Atributo1</label>
																	<input type="text" class="form-control"readonly="" name="Opcao_Atributo_1" id="Opcao_Atributo_1" value="0">
																<?php } ?>
															
															</div>
														
													<?php } ?>
													
													
													
													<?php if ($metodo >= 2) { ?>		
															<div class="col-md-3">
																<?php if ($_SESSION['Atributo'][2]['idTab_Atributo']) { ?>
																	<label for="Opcao_Atributo_2"><?php echo $_SESSION['Atributo'][2]['Atributo']; ?></label>
																	<?php if ($metodo == 2) { ?>
																		<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" id="Opcao_Atributo_2" name="Opcao_Atributo_2" onchange="codigo()">
																			<option value="">-- Selecione uma op��o --</option>
																			<?php
																			foreach ($select['Opcao_Atributo_2'] as $key => $row) {
																				if ($produtos['Opcao_Atributo_2'] == $key) {
																					echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																				} else {
																					echo '<option value="' . $key . '">' . $row . '</option>';
																				}
																			}
																			?>
																		</select>
																		<?php echo form_error('Opcao_Atributo_2'); ?>
																	<?php }else{ ?>
																		<input type="hidden" id="Opcao_Atributo_2" name="Opcao_Atributo_2" value="<?php echo $_SESSION['Produtos']['Opcao_Atributo_2']; ?>">
																		<input class="form-control"readonly="" value="<?php echo $_SESSION['Produtos']['Opcao2']; ?>">
																	<?php } ?>
																<?php }else{ ?>
																	<label for="Opcao_Atributo_2">N�o existe Atributo2</label>
																	<input type="text" class="form-control"readonly=""  name="Opcao_Atributo_2" id="Opcao_Atributo_2" value="0">
																<?php } ?>
															</div>
													<?php } ?>		
													<?php if ($metodo >= 2) { ?>		
														<div class="col-md-2">
															<label for="id">id</label>
															<input type="text" class="form-control" readonly="" value="<?php echo $produtos['idTab_Produtos']; ?>">
														</div>		
														<div class="col-md-2">
															<label for="Cod_Prod">Codigo *</label>
															<input type="text" class="form-control" readonly="" id="Cod_Prod" name="Cod_Prod" value="<?php echo $produtos['Cod_Prod']; ?>">
															<?php echo form_error('Cod_Prod'); ?>
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
				
				<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) || ($_SESSION['log']['idSis_Empresa'] == 5))  { ?>
				
				<div class="row">
					<div class="col-md-12">
						<input type="hidden" name="idTab_Produtos" id="idTab_Produtos" value="<?php echo $produtos['idTab_Produtos']; ?>">
						<?php if ($metodo > 1) { ?>
							<?php if ($metodo != 4) { ?>
								<div class="col-md-6">
									<button type="submit" class="btn btn-lg btn-primary" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." >
										<span class="glyphicon glyphicon-save"></span> Salvar
									</button>
								</div>
							<?php } ?>	
							<?php if ($metodo == 2) { ?>	
								<div class="col-md-6 text-right">
									<button  type="button" class="btn btn-lg btn-danger" name="submeter2" id="submeter2" onclick="DesabilitaBotao(this.name)" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
										<span class="glyphicon glyphicon-trash"></span> Excluir
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
											<p>Ao confirmar a exclus�o todos os dados ser�o exclu�dos do banco de dados. Esta opera��o � irrevers�vel.</p>
										</div>
										<div class="modal-footer">
											<div class="col-md-6 text-left">
												<button type="button" class="btn btn-warning" data-dismiss="modal">
													<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
												</button>
											</div>
											<div class="col-md-6 text-right">
												<a class="btn btn-danger" href="<?php echo base_url() . 'produtos/excluir/' . $produtos['idTab_Produtos'] ?>" role="button">
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
						<div id="msgCadSucesso" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header bg-success text-center">
										<h4 class="modal-title" id="visulUsuarioModalLabel">Cadastrado realizado com sucesso!</h4>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										  <span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-footer">
										<div class="col-md-6">	
											<button class="btn btn-success btn-block" name="botaoFechar2" id="botaoFechar2" onclick="DesabilitaBotaoFechar(this.name)" value="0" type="submit">
												<span class="glyphicon glyphicon-filter"></span> Fechar
											</button>
											<div class="col-md-12 alert alert-warning aguardar2" role="alert" >
												Aguarde um instante! Estamos processando sua solicita��o!
											</div>
										</div>
										<!--<button type="button" class="btn btn-outline-info" data-dismiss="modal">Fechar</button>-->
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
				<?php if ($metodo >= 3) { ?>
					<?php if (isset($list)) echo $list; ?>
				<?php } ?>
			</form>
		</div>
	</div>
</div>

<div id="addCatprodModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addCatprodModalLabel">Cadastrar Categoria</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<span id="msg-error-catprod"></span>
				<form method="post" id="insert_catprod_form">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Tipo</label>
						<div class="col-sm-10">
							<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" <?php echo $readonly; ?>
									id="TipoCatprod" name="TipoCatprod">
								<option value="">-- Selecione uma op��o --</option>
								<?php
								foreach ($select['TipoCatprod'] as $key => $row) {
									if ($cadastrar['TipoCatprod'] == $key) {
										echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
									} else {
										echo '<option value="' . $key . '">' . $row . '</option>';
									}
								}
								?>
							</select>
						</div>	
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Categoria</label>
						<div class="col-sm-10">
							<input name="Novo_Catprod" type="text" class="form-control" id="Novo_Catprod" placeholder="Nome da Categoria">
						</div>
					</div>
					<div class="form-group row">	
						<div class="col-sm-6">
							<br>
							<button type="submit" class="btn btn-success btn-block" name="botaoCadCatprod" id="botaoCadCatprod" >
								<span class="glyphicon glyphicon-plus"></span> Cadastrar
							</button>
						</div>
						<div class="col-sm-6">
							<br>
							<button type="button" class="btn btn-primary btn-block" data-dismiss="modal" name="botaoFecharCatprod" id="botaoFecharCatprod">
								<span class="glyphicon glyphicon-remove"></span> Fechar
							</button>
						</div>	
						<div class="col-md-12 alert alert-warning aguardarCatprod" role="alert" >
							Aguarde um instante! Estamos processando sua solicita��o!
						</div>
					</div>
				</form>
				<?php if (isset($list1)) echo $list1; ?>
			</div>
		</div>
	</div>
</div>

<div id="addAtributoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addAtributoModalLabel">Cadastrar Atributo</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<span id="msg-error-atributo"></span>
				<form method="post" id="insert_atributo_form">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Categoria</label>
						<div class="col-sm-10">
							<input type="hidden" name="idCat_Atributo" id="idCat_Atributo" value="<?php echo $_SESSION['Produtos']['idTab_Catprod']; ?>">
							<input class="form-control"readonly="" value="<?php echo $_SESSION['Produtos']['Catprod']; ?>">
						</div>	
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Atributo</label>
						<div class="col-sm-10">
							<input name="Novo_Atributo" type="text" class="form-control" id="Novo_Atributo" placeholder="Atributo">
						</div>
					</div>
					<div class="form-group row">	
						<div class="col-sm-6">
							<br>
							<button type="submit" class="btn btn-success btn-block" name="botaoCadAtributo" id="botaoCadAtributo" >
								<span class="glyphicon glyphicon-plus"></span> Cadastrar
							</button>
						</div>
						<div class="col-sm-6">
							<br>
							<button type="button" class="btn btn-primary btn-block" data-dismiss="modal" name="botaoFecharAtributo" id="botaoFecharAtributo">
								<span class="glyphicon glyphicon-remove"></span> Fechar
							</button>
						</div>	
						<div class="col-md-12 alert alert-warning aguardarAtributo" role="alert" >
							Aguarde um instante! Estamos processando sua solicita��o!
						</div>
					</div>
				</form>
				<?php if (isset($list3)) echo $list3; ?>
			</div>
		</div>
	</div>
</div>

<div id="addOpcaoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addOpcaoModalLabel">Cadastrar Opcao</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<span id="msg-error-opcao"></span>
				<form method="post" id="insert_opcao_form">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Categoria</label>
						<div class="col-sm-10">
							<input type="hidden" name="idCat_Opcao" id="idCat_Opcao" value="<?php echo $_SESSION['Produtos']['idTab_Catprod']; ?>">
							<input class="form-control"readonly="" value="<?php echo $_SESSION['Produtos']['Catprod']; ?>">
						</div>	
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Atributo</label>
						<div class="col-sm-10">
							<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
									id="idAtributo_Opcao" name="idAtributo_Opcao">
								<option value="">-- Selecione uma op��o --</option>
								<?php
								foreach ($select['idAtributo_Opcao'] as $key => $row) {
									if ($cadastrar['idAtributo_Opcao'] == $key) {
										echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
									} else {
										echo '<option value="' . $key . '">' . $row . '</option>';
									}
								}
								?>
							</select>
						</div>	
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Opcao</label>
						<div class="col-sm-10">
							<input name="Novo_Opcao" type="text" class="form-control" id="Novo_Opcao" placeholder="Opcao">
						</div>
					</div>
					<div class="form-group row">	
						<div class="col-sm-6">
							<br>
							<button type="submit" class="btn btn-success btn-block" name="botaoCadOpcao" id="botaoCadOpcao" >
								<span class="glyphicon glyphicon-plus"></span> Cadastrar
							</button>
						</div>
						<div class="col-sm-6">
							<br>
							<button type="button" class="btn btn-primary btn-block" data-dismiss="modal" name="botaoFecharOpcao" id="botaoFecharOpcao">
								<span class="glyphicon glyphicon-remove"></span> Fechar
							</button>
						</div>	
						<div class="col-md-12 alert alert-warning aguardarOpcao" role="alert" >
							Aguarde um instante! Estamos processando sua solicita��o!
						</div>
					</div>
				</form>
				<?php if (isset($list4)) echo $list4; ?>
			</div>
		</div>
	</div>
</div>

<div id="addProdutoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addProdutoModalLabel">Cadastrar Produto</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<span id="msg-error-produto"></span>
				<form method="post" id="insert_produto_form">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Categoria</label>
						<div class="col-sm-10">
							<input type="hidden" name="idCat_Produto" id="idCat_Produto" value="<?php echo $_SESSION['Produtos']['idTab_Catprod']; ?>">
							<input class="form-control"readonly="" value="<?php echo $_SESSION['Produtos']['Catprod']; ?>">
							<!--
							<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" <?php echo $readonly; ?>
									id="idCat_Produto" name="idCat_Produto">
								<option value="">-- Selecione uma op��o --</option>
								<?php
								/*
								foreach ($select['idCat_Produto'] as $key => $row) {
									if ($cadastrar['idCat_Produto'] == $key) {
										echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
									} else {
										echo '<option value="' . $key . '">' . $row . '</option>';
									}
								}
								*/
								?>
							</select>
							-->
						</div>	
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Produto</label>
						<div class="col-sm-10">
							<input name="Novo_Produto" type="text" class="form-control" id="Novo_Produto" placeholder="Produto">
						</div>
					</div>
					<!--
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Descri��o</label>
						<div class="col-sm-10">
							<input name="Desc_Produto" type="text" class="form-control" id="Desc_Produto" placeholder="Descri��o">
						</div>
					</div>
					-->
					<div class="form-group row">	
						<div class="col-sm-6">
							<br>
							<button type="submit" class="btn btn-success btn-block" name="botaoCad" id="botaoCad" >
								<span class="glyphicon glyphicon-plus"></span> Cadastrar
							</button>
						</div>
						<div class="col-sm-6">
							<br>
							<button type="button" class="btn btn-primary btn-block" data-dismiss="modal" name="botaoFechar" id="botaoFechar">
								<span class="glyphicon glyphicon-remove"></span> Fechar
							</button>
						</div>	
						<div class="col-md-12 alert alert-warning aguardar1" role="alert" >
							Aguarde um instante! Estamos processando sua solicita��o!
						</div>
					</div>
				</form>
				<?php if (isset($list2)) echo $list2; ?>
			</div>
		</div>
	</div>
</div>