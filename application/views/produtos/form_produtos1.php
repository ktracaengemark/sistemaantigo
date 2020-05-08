<?php if (isset($msg)) echo $msg; ?>

<div class="col-sm-offset-2 col-md-8 ">	
<?php echo validation_errors(); ?>

	<div class="panel panel-<?php echo $panel; ?>">
		<div class="panel-heading">
			<?php echo $titulo; ?> Produtos
			<a class="btn btn-sm btn-info" href="<?php echo base_url() ?>relatorio/produtos" role="button">
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
								<div class="col-md-2">
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
								</div>									
								<!--
								<div class="col-md-2">
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
								-->
								<div class="col-md-2">
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
											if ($produtos['Fornecedor'] == $key) {
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
							<div class="col-md-2">
								<label for="Prodaux3">Categoria:</label>									
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
							<div class="col-md-2">
								<label for="Prodaux1">Esp.:</label>	
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
						</div>
						<div class="row">	
							<div class="col-md-4">
								<label for="Produtos">Produto:*</label><br>
								<input type="text" class="form-control" maxlength="200"
										name="Produtos" value="<?php echo $produtos['Produtos'] ?>">
							</div>							
							<div class="col-md-2">
								<label for="CodProd">Código:</label><br>
								<input type="text" class="form-control" maxlength="25"
										name="CodProd" value="<?php echo $produtos['CodProd'] ?>">
							</div>
							<div class="col-md-3">
								<label for="Comissao">Comissão:</label><br>
								<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">(%)</span>
									<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"
											name="Comissao" value="<?php echo $produtos['Comissao'] ?>">
								</div>
							</div>
							<div class="col-md-3">
								<label for="PesoProduto">Peso:</label><br>
								<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">(kg)</span>
									<input type="text" class="form-control Peso" maxlength="10" placeholder="0,000"
											name="PesoProduto" value="<?php echo $produtos['PesoProduto'] ?>">
								</div>
							</div>							
						</div>
						<div class="row">
							<div class="col-md-2 text-left">
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
								<div class="col-md-2 text-left">
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
															name="ValorProduto" value="<?php echo $valor['ValorProduto'] ?>">
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