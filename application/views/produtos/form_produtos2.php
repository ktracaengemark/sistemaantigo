<nav class="navbar navbar-inverse navbar-fixed-top " role="banner">
  <div class="container-fluid">
		<li class="navbar-form">

				<a <?php if (preg_match("/relatorio\/produtos2\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
					<a href="<?php echo base_url() . 'relatorio/produtos2/'; ?>">
						<button type="button" class="btn btn-lg btn-info ">
							<span class="glyphicon glyphicon-search"></span> Pesquisar
						</button>										
					</a>
				</a>

				<a href="javascript:window.close()">
					<button type="button" class="btn btn-lg btn-default ">
						<span class="glyphicon glyphicon-remove"></span> Fechar
					</button>
				</a>
							
		</li>
  </div>
</nav>
<br>
<?php if (isset($msg)) echo $msg; ?>			

<div class="col-sm-offset-2 col-md-8 ">	

<?php echo validation_errors(); ?>

	<div class="panel panel-<?php echo $panel; ?>">
		<div class="panel-heading">
			<?php echo $titulo; ?> Produtos
			<a class="btn btn-sm btn-info" href="<?php echo base_url() ?>relatorio/produtos2" role="button">
				<span class="glyphicon glyphicon-search"></span> Produtos Cadastrados
			</a>
			<!--
			<a class="btn btn-sm btn-warning" href="<?php echo base_url() ?>relatorio/estoque" role="button">
				<span class="glyphicon glyphicon-search"></span> Estoque
			</a>
			-->
		
		</div>			
		<div class="panel-body">

			<?php echo form_open_multipart($form_open_path); ?>

			<!--Tab_Produto-->

			<div class="form-group">
				<div class="panel panel-info">
					<div class="panel-heading">	
						<div class="form-group">	
							<div class="row">
								<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
								<div class="col-md-3">
									<label for="TipoProduto">Venda/Cons:</label>
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
								</div>									
								<div class="col-md-3">
									<label for="Categoria">Prod/Serv:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
											id="Categoria" autofocus name="Categoria">
										<option value="">-- Selecione uma opção --</option>
										<?php
										foreach ($select['Categoria'] as $key => $row) {
											if ($produtos['Categoria'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<div class="col-md-3">
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
								<!--
								<div class="col-md-2">
									<label for="Fornecedor">Fornecedor</label>
									<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
											id="Fornecedor" name="Fornecedor">
										<option value="">-- Selecione uma opção --</option>
										<?php
										foreach ($select['Fornecedor'] as $key => $row) {
											if ($produtos['Fornecedor'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<div class="col-md-2">
									<label for="Prodaux1">Aux1:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
											id="Prodaux1" name="Prodaux1">
										<option value="">-- Selecione uma opção --</option>
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
								</div>
								-->
								<?php } ?>
							</div>
						</div>
						<div class="row">									
							<div class="col-md-3">
								<label for="Prodaux3">Categ.</label>
								<a class="btn btn-xs btn-info" target="_blank" href="<?php echo base_url() ?>prodaux3/cadastrar3" role="button"> 
									<span class="glyphicon glyphicon-plus"></span> <b>Cat.</b>
								</a>
								<button class="btn btn-xs btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
									<span class="glyphicon glyphicon-refresh"></span> Recarregar
								</button>
								<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
										id="Prodaux3" name="Prodaux3">
									<option value="">-- Selecione uma opção --</option>
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
							</div>
							<div class="col-md-2">
								<label for="Prodaux2">Tipo:</label>
									<a class="btn btn-xs btn-info" target="_blank" href="<?php echo base_url() ?>prodaux2/cadastrar3" role="button"> 
										<span class="glyphicon glyphicon-plus"></span> <b>Tipo</b>
									</a>								
								<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
										id="Prodaux2" name="Prodaux2">
									<option value="">-- Selecione uma opção --</option>
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
							</div>							
							<div class="col-md-4">
								<label for="Produtos">Produto:*</label><br>
								<input type="text" class="form-control" maxlength="200"
										name="Produtos" value="<?php echo $produtos['Produtos'] ?>">
							</div>							
							<div class="col-md-3">
								<label for="CodProd">Código:</label><br>
								<input type="text" class="form-control" maxlength="25"
										name="CodProd" value="<?php echo $produtos['CodProd'] ?>">
							</div>
							<!--
							<div class="col-md-2">
								<label for="ValorCompraProduto">Custo:</label><br>
								<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">R$</span>
									<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"
											name="ValorCompraProduto" value="<?php echo $produtos['ValorCompraProduto'] ?>">
								</div>
							</div>

							<div class="col-md-2">
								<label for="ValorProduto">Venda:</label><br>
								<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">R$</span>
									<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"
											name="ValorProduto" value="<?php echo $produtos['ValorProduto'] ?>">
								</div>
							</div>
							-->
						</div>
					</div>	
				</div>		
			</div>


			
			<?php if (($_SESSION['log']['NivelEmpresa'] >= 4) AND ($_SESSION['log']['NivelEmpresa'] <= 6 )) { ?>						
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
												<label for="ValorProduto">Valor :</label>
												<div class="input-group">
													<span class="input-group-addon" id="basic-addon1">R$</span>
													<input type="text" class="form-control Valor" id="ValorProduto<?php echo $i ?>" maxlength="10" placeholder="0,00"
														name="ValorProduto<?php echo $i ?>" value="<?php echo $valor[$i]['ValorProduto'] ?>">
												</div>
											</div>													
											<!--
											<div class="col-md-1">
												<label><br></label><br>
												<button type="button" id="<?php echo $i ?>" class="remove_field3 btn btn-danger">
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
							<!--
							<div class="form-group">
								<div class="row">
									<div class="col-md-4">
										<a class="btn btn-xs btn-danger" onclick="adicionaValor()">
											<span class="glyphicon glyphicon-plus"></span> Adicionar Valor
										</a>
									</div>
								</div>
							</div>
							-->
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
			
			<?php if (($_SESSION['log']['NivelEmpresa'] >= 7) AND ($_SESSION['log']['NivelEmpresa'] <= 10 )) { ?>						
			<div class="panel-group" id="accordion3" role="tablist" aria-multiselectable="true">
				<div class="panel panel-primary">
					 <div class="panel-heading" role="tab" id="heading3" data-toggle="collapse" data-parent="#accordion3" data-target="#collapse3">
						<h4 class="panel-title">
							<a class="accordion-toggle">
								<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
								Valor 
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
											<div class="col-md-4">
												<label for="Fornecedor<?php echo $i ?>">Fornecedor:</label>
												<?php if ($i == 1) { ?>
												<?php } ?>
												<select data-placeholder="Selecione uma opção..." class="form-control"
														 id="listadinamicad<?php echo $i ?>" name="Fornecedor<?php echo $i ?>">
													<option value="">-- Selecione uma opção --</option>
													<?php
													foreach ($select['Fornecedor'] as $key => $row) {
														if ($valor[$i]['Fornecedor'] == $key) {
															echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
														} else {
															echo '<option value="' . $key . '">' . $row . '</option>';
														}
													}
													?>
												</select>
											</div>
											<div class="col-md-4">
												<label for="Convdesc<?php echo $i ?>">Descrição do Valor:</label>
												<input type="text" class="form-control"  id="Convdesc<?php echo $i ?>" <?php echo $readonly; ?>
														  name="Convdesc<?php echo $i ?>" value="<?php echo $valor[$i]['Convdesc']; ?>">
											</div>													
											<!--
											<div class="col-md-2">
												<label for="ValorProduto<?php echo $i ?>">Valor :</label>
												<textarea class="form-control" id="ValorProduto<?php echo $i ?>" <?php echo $readonly; ?>
														  name="ValorProduto<?php echo $i ?>"><?php echo $valor[$i]['ValorProduto']; ?></textarea>
											</div>
											-->
											<div class="col-md-3">
												<label for="ValorProduto">Valor :</label>
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
								<a class="add_field_button3 btn btn-xs btn-danger" onclick="adicionaValor2()">
									<span class="glyphicon glyphicon-arrow-up"></span> Adicionar Valor
								</a>
								<a class="btn btn-xs btn-info" target="_blank" href="<?php echo base_url() ?>fornecedor/cadastrar3" role="button"> 
									<span class="glyphicon glyphicon-plus"></span><b> Cad.Forn.</b>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
			<hr>

			<div class="form-group">
				<div class="row">
					<!--<input type="hidden" name="idApp_Cliente" value="<?php echo $_SESSION['Cliente']['idApp_Cliente']; ?>">-->
					<input type="hidden" name="idTab_Produto" value="<?php echo $produtos['idTab_Produto']; ?>">
					<?php if ($metodo > 1) { ?>
					<!--<input type="hidden" name="idTab_Valor" value="<?php echo $valor['idTab_Valor']; ?>">
					<input type="hidden" name="idApp_ParcelasRec" value="<?php echo $parcelasrec['idApp_ParcelasRec']; ?>">-->
					<?php } ?>
					<?php if ($metodo == 2) { ?>

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
<?php echo form_open('relatorio/produtos', 'role="form"'); ?>
<div class="modal fade bs-excluir-modal2-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header bg-danger">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtros dos Produtos</h4>
			</div>
			<div class="modal-footer">
				
				<div class="row text-left">
					
					<div class="col-md-6">
						<label for="Ordenamento">Desccrição</label>
						<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
								id="Produtos" name="Produtos">
							<?php
							foreach ($select['Produtos'] as $key => $row) {
								if ($query['Produtos'] == $key) {
									echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
								} else {
									echo '<option value="' . $key . '">' . $row . '</option>';
								}
							}
							?>
						</select>
					</div>

					<div class="col-md-6">
						<label for="Ordenamento">Ordenamento:</label>

						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
											id="Campo" name="Campo">
										<?php
										foreach ($select['Campo'] as $key => $row) {
											if ($query['Campo'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>

								<div class="col-md-6">
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
											id="Ordenamento" name="Ordenamento">
										<?php
										foreach ($select['Ordenamento'] as $key => $row) {
											if ($query['Ordenamento'] == $key) {
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
				<div class="row text-left">
					<div class="col-md-4">
						<label for="Ordenamento">Categoria</label>
						<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
								id="Prodaux33" name="Prodaux33">
							<?php
							foreach ($select['Prodaux33'] as $key => $row) {
								if ($query['Prodaux33'] == $key) {
									echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
								} else {
									echo '<option value="' . $key . '">' . $row . '</option>';
								}
							}
							?>
						</select>
					</div>
					<div class="col-md-4">
						<label for="Ordenamento">Aux1</label>
						<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
								id="Prodaux1" name="Prodaux1">
							<?php
							foreach ($select['Prodaux1'] as $key => $row) {
								if ($query['Prodaux1'] == $key) {
									echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
								} else {
									echo '<option value="' . $key . '">' . $row . '</option>';
								}
							}
							?>
						</select>
					</div>
					<div class="col-md-4">
						<label for="Ordenamento">Aux2</label>
						<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
								id="Prodaux2" name="Prodaux2">
							<?php
							foreach ($select['Prodaux2'] as $key => $row) {
								if ($query['Prodaux2'] == $key) {
									echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
								} else {
									echo '<option value="' . $key . '">' . $row . '</option>';
								}
							}
							?>
						</select>
					</div>
				</div>
				<?php } ?>
				<div class="row text-left">
					<br>
					<div class="form-group col-md-4">
						<div class="form-footer ">
							<button class="btn btn-success btn-block" name="pesquisar" value="0" type="submit">
								<span class="glyphicon glyphicon-filter"></span> Filtrar
							</button>
						</div>
					</div>
					<!--
					<div class="form-group col-md-4">
						<div class="form-footer">		
							<a class="btn btn-warning btn-block" href="<?php echo base_url() ?>relatorio/estoque" role="button">
								<span class="glyphicon glyphicon-search"></span> Estoque
							</a>
						</div>	
					</div>
					-->
					<div class="form-group col-md-4">
						<div class="form-footer">		
							<button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
								<span class="glyphicon glyphicon-plus"></span> Novo Produto
							</button>							
						</div>	
					</div>					
					<div class="form-group col-md-4">
						<div class="form-footer ">
							<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">
								<span class="glyphicon glyphicon-remove"></span> Fechar
							</button>
						</div>
					</div>
				</div>
			</div>									
		</div>								
	</div>
</div>

<div class="modal fade bs-excluir-modal6-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header bg-danger">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Evite cadastrar Produtos REPETIDOS!<br>
										"Pesquise" os Produtos Cadastradas!</h4>
			</div>
			<!--
			<div class="modal-body">
				<p>Pesquise os Produtos Cadastrados!!</p>
			</div>
			-->
			<div class="modal-footer">
				<div class="form-group col-md-4 text-left">
					<div class="form-footer">
						<button  class="btn btn-info btn-block"" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
							<span class="glyphicon glyphicon-search"></span> Pesquisar
						</button>
					</div>
				</div>
				<?php if (($_SESSION['log']['NivelEmpresa'] >= 4) AND ($_SESSION['log']['NivelEmpresa'] <= 6 )) { ?>
				<div class="form-group col-md-4 text-right">
					<div class="form-footer">		
						<a class="btn btn-danger btn-block" href="<?php echo base_url() ?>produtos/cadastrar1" role="button">
							<span class="glyphicon glyphicon-plus"></span> Produtos
						</a>
					</div>	
				</div>
				<?php } else {?>
				<div class="form-group col-md-4 text-right">
					<div class="form-footer">		
						<a class="btn btn-danger btn-block" href="<?php echo base_url() ?>produtos/cadastrar" role="button">
							<span class="glyphicon glyphicon-plus"></span> Produtos
						</a>
					</div>	
				</div>
				<?php } ?>
				<div class="form-group col-md-4">
					<div class="form-footer ">
						<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">
							<span class="glyphicon glyphicon-remove"></span> Fechar
						</button>
					</div>
				</div>									
			</div>
		</div>
	</div>
</div>
	