<nav class="navbar navbar-inverse navbar-fixed-top " role="banner">
	<div class="container-fluid">
		<div class="navbar-header ">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="sr-only">MENU</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a type="button" class="navbar-toggle btn btn-lg btn-primary  " href="javascript:window.close()">
				<span class="glyphicon glyphicon-remove"></span> Fechar
			</a>			
		</div>
		<div class="collapse navbar-collapse" id="myNavbar">		
			<ul class="nav navbar-nav navbar-center">
				<li class="btn-toolbar btn-lg navbar-form" role="toolbar" aria-label="...">
					<div class="btn-group " role="group" aria-label="...">
						<a href="<?php echo base_url(); ?>relatorio2/promocao2" role="button">
							<button type="button" class="btn btn-lg btn-warning ">
								<span class="glyphicon glyphicon-calendar"></span>Valores
							</button>
						</a>						
					</div>					
				</li>
				<li class="btn-toolbar btn-lg navbar-form" role="toolbar" aria-label="...">
					<div class="btn-group " role="group" aria-label="...">
						<a href="<?php echo base_url(); ?>relatorio2/estoque2" role="button">
							<button type="button" class="btn btn-lg btn-success ">
								<span class="glyphicon glyphicon-calendar"></span>Estoque
							</button>
						</a>						
					</div>					
				</li>				
				<li class="btn-toolbar btn-lg navbar-form" role="toolbar" aria-label="...">
					<div class="btn-group " role="group" aria-label="...">
						<a type="button" class="btn btn-lg btn-default " href="javascript:window.close()">
							<span class="glyphicon glyphicon-remove"></span>Fechar
						</a>
					</div>					
				</li>				
			</ul>			
		</div>
	</div>
</nav>
<br>
<?php if (isset($msg)) echo $msg; ?>

<div class="col-sm-offset-1 col-md-10 ">
				
<?php echo validation_errors(); ?>

	<div class="panel panel-<?php echo $panel; ?>">
		<div class="panel-heading">
			<?php echo $titulo; ?> Promocao
			<a class="btn btn-sm btn-info" href="<?php echo base_url() ?>relatorio2/promocao2" role="button">
				<span class="glyphicon glyphicon-search"></span> Promocao Cadastrados
			</a>
			<!--
			<a class="btn btn-sm btn-warning" href="<?php echo base_url() ?>relatorio/estoque" role="button">
				<span class="glyphicon glyphicon-search"></span> Estoque
			</a>
			-->
		</div>			
		<div class="panel-body">

			<?php echo form_open_multipart($form_open_path); ?>

			<!--Tab_Promocao-->

			<div class="form-group">
				<div class="panel panel-info">
					<div class="panel-heading">	
						<div class="form-group">	
							<div class="row">
								<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
								<div class="col-md-2">
									<label for="TipoProduto">Venda/Cons/Alug:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
											id="TipoProduto" name="TipoProduto">
										<option value="">-- Selecione uma opção --</option>
										<?php
										foreach ($select['TipoProduto'] as $key => $row) {
											if ($promocao['TipoProduto'] == $key) {
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
									<label for="Categoria">Prod/Serv:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
											id="Categoria" autofocus name="Categoria">
										<option value="">-- Selecione uma opção --</option>
										<?php
										foreach ($select['Categoria'] as $key => $row) {
											if ($promocao['Categoria'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								-->
								<div class="col-md-2">
									<label for="UnidadeProduto">Unidade:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
											id="UnidadeProduto" name="UnidadeProduto">
										<option value="">-- Selecione uma opção --</option>
										<?php
										foreach ($select['UnidadeProduto'] as $key => $row) {
											if ($promocao['UnidadeProduto'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<div class="col-md-2 text-left">
									<label for="Cadastrar">Cat/Tipo/Esp/Forn</label><br>
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
																					
								<div class="col-md-6 text-left" id="Cadastrar" <?php echo $div['Cadastrar']; ?>>
									<label></label><br>
									<a class="btn btn-md btn-info"   target="_blank" href="<?php echo base_url() ?>prodaux32/cadastrar3" role="button"> 
										<span class="glyphicon glyphicon-plus"></span> Cat.
									</a>
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
									<label></label>									
									<button class="btn btn-md btn-primary"  id="inputDb" data-loading-text="Aguarde..." type="submit">
											<span class="glyphicon glyphicon-refresh"></span> Ref.
									</button>
									<?php echo form_error('Cadastrar'); ?>
								</div>								
								<!--
								<div class="col-md-2">
									<label for="Fornecedor">Fornecedor</label>
									<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
											id="Fornecedor" name="Fornecedor">
										<option value="">-- Selecione uma opção --</option>
										<?php
										foreach ($select['Fornecedor'] as $key => $row) {
											if ($promocao['Fornecedor'] == $key) {
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
								<label for="Prodaux3">Categoria:</label>								
								<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
										id="Prodaux3" name="Prodaux3">
									<option value="">-- Selecione uma opção --</option>
									<?php
									foreach ($select['Prodaux3'] as $key => $row) {
										if ($promocao['Prodaux3'] == $key) {
											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
										} else {
											echo '<option value="' . $key . '">' . $row . '</option>';
										}
									}
									?>
								</select>
							</div>
							<div class="col-md-3">
								<label for="Prodaux4">Modelo</label>								
								<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
										id="Prodaux4" name="Prodaux4">
									<option value="">-- Selecione uma opção --</option>
									<?php
									foreach ($select['Prodaux4'] as $key => $row) {
										if ($promocao['Prodaux4'] == $key) {
											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
										} else {
											echo '<option value="' . $key . '">' . $row . '</option>';
										}
									}
									?>
								</select>
							</div>							
							<div class="col-md-3">
								<label for="Prodaux2">Tipo:</label>								
								<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
										id="Prodaux2" name="Prodaux2">
									<option value="">-- Selecione uma opção --</option>
									<?php
									foreach ($select['Prodaux2'] as $key => $row) {
										if ($promocao['Prodaux2'] == $key) {
											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
										} else {
											echo '<option value="' . $key . '">' . $row . '</option>';
										}
									}
									?>
								</select>
							</div>
							<div class="col-md-3">
								<label for="Prodaux1">Esp.:</label>									
								<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
										id="Prodaux1" name="Prodaux1">
									<option value="">-- Selecione uma opção --</option>
									<?php
									foreach ($select['Prodaux1'] as $key => $row) {
										if ($promocao['Prodaux1'] == $key) {
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
							<div class="col-md-4">
								<label for="Promocao">Produto:*</label><br>
								<input type="text" class="form-control" maxlength="200"
										name="Promocao" value="<?php echo $promocao['Promocao'] ?>">
							</div>							
							<div class="col-md-2">
								<label for="CodProd">Código:</label><br>
								<input type="text" class="form-control" maxlength="25"
										name="CodProd" value="<?php echo $promocao['CodProd'] ?>">
							</div>
							<div class="col-md-3">
								<label for="Comissao">Comissão:</label><br>
								<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">(%)</span>
									<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"
											name="Comissao" value="<?php echo $promocao['Comissao'] ?>">
								</div>
							</div>
							<div class="col-md-3">
								<label for="PesoProduto">Peso:</label><br>
								<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">(kg)</span>
									<input type="text" class="form-control Peso" maxlength="10" placeholder="0,000"
											name="PesoProduto" value="<?php echo $promocao['PesoProduto'] ?>">
								</div>
							</div>							
						</div>
						<div class="row">
							<div class="col-md-2 text-left">
								<label for="Ativo">Produto Ativo?</label><br>
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
							<div id="Ativo" <?php echo $div['Ativo']; ?>>	
								<div class="col-md-2 text-left">
									<label for="VendaSite">Vender no Site?</label><br>
									<div class="btn-group" data-toggle="buttons">
										<?php
										foreach ($select['VendaSite'] as $key => $row) {
											if (!$promocao['VendaSite']) $promocao['VendaSite'] = 'N';

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
								<div id="VendaSite" <?php echo $div['VendaSite']; ?>>	
									
								</div>
							</div>	
						</div>						
					</div>	
				</div>		
			</div>
			<div class="panel-group" id="accordion3" role="tablist" aria-multiselectable="true">
				<div class="panel panel-primary">
					<div id="collapse3" class="panel-collapse" role="tabpanel" aria-labelledby="heading3" aria-expanded="false">
						<div class="panel-body">
							<div class="form-group">
								<div class="panel panel-info">
									<div class="panel-heading">			
										<div class="row">									
											<div class="col-md-3">
												<label for="ValorProduto">Valor Balcao:</label><br>
												<div class="input-group">
													<span class="input-group-addon" id="basic-addon1">R$</span>
													<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"
															name="ValorProduto" value="<?php echo $item_promocao['ValorProduto'] ?>">
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
			<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) || ($_SESSION['log']['idSis_Empresa'] == 5))  { ?>
			<div class="form-group">
				<div class="row">
					<!--<input type="hidden" name="idApp_Cliente" value="<?php echo $_SESSION['Cliente']['idApp_Cliente']; ?>">-->
					<input type="hidden" name="idTab_Promocao" value="<?php echo $promocao['idTab_Promocao']; ?>">
					<?php if ($metodo > 1) { ?>
					<!--<input type="hidden" name="idTab_Valor" value="<?php echo $item_promocao['idTab_Valor']; ?>">
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
										<p>Ao confirmar a exclusão todos os dados serão excluídos do banco de dados. Esta operação é irreversível.</p>
									</div>
									<div class="modal-footer">
										<div class="col-md-6 text-left">
											<button type="button" class="btn btn-warning" data-dismiss="modal">
												<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
											</button>
										</div>
										<div class="col-md-6 text-right">
											<a class="btn btn-danger" href="<?php echo base_url() . 'promocao2/excluir/' . $promocao['idTab_Promocao'] ?>" role="button">
												<span class="glyphicon glyphicon-trash"></span> Confirmar Exclusão
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php } else { ?>
						<div class="col-md-6">
							<button type="submit" class="btn btn-lg btn-primary" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." >
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