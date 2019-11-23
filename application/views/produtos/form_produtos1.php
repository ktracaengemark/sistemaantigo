<?php if (isset($msg)) echo $msg; ?>
<div class="container-fluid">
	<div class="row">			
		<div class="col-md-2"></div>
		<div class="col-md-8 ">
			<?php echo validation_errors(); ?>

			<div class="panel panel-<?php echo $panel; ?>">
				<div class="panel-heading">
					<?php echo $titulo; ?>
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

					<div class="form-group">
						<div class="panel panel-info">
							<div class="panel-heading">	
								<div class="form-group">	
									<div class="row">
										<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
										<div class="col-md-3">
											<label for="TipoProduto">Venda/Cons:</label>
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
										</div>									
										<div class="col-md-3">
											<label for="Categoria">Prod/Serv:</label>
											<select data-placeholder="Selecione uma op��o..." class="form-control" <?php echo $readonly; ?>
													id="Categoria" autofocus name="Categoria">
												<option value="">-- Selecione uma op��o --</option>
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
										<!--
										<div class="col-md-2">
											<label for="Fornecedor">Fornecedor</label>
											<select data-placeholder="Selecione uma op��o..." class="form-control" <?php echo $readonly; ?>
													id="Fornecedor" name="Fornecedor">
												<option value="">-- Selecione uma op��o --</option>
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
										</div>
										<div class="col-md-2">
											<label for="Prodaux2">Aux2:</label>
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
										</div>
										-->
										<?php } ?>
									</div>
								</div>
								<div class="row">									
									<div class="col-md-3">
										<label for="Prodaux3">Categoria</label>
											<a class="btn btn-xs btn-info" href="<?php echo base_url() ?>prodaux3/cadastrar" role="button"> 
												<span class="glyphicon glyphicon-plus"></span> <b>Cat.</b>
											</a>
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
									</div>																		
									<div class="col-md-3">
										<label for="CodProd">C�digo:</label><br>
										<input type="text" class="form-control" maxlength="25"
												name="CodProd" value="<?php echo $produtos['CodProd'] ?>">
									</div>
									<div class="col-md-4">
										<label for="Produtos">Produto:*</label><br>
										<input type="text" class="form-control" maxlength="200"
												name="Produtos" value="<?php echo $produtos['Produtos'] ?>">
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

											
					<div class="panel-group" id="accordion3" role="tablist" aria-multiselectable="true">
						<div class="panel panel-primary">


							<div id="collapse3" class="panel-collapse" role="tabpanel" aria-labelledby="heading3" aria-expanded="false">
								<div class="panel-body">
									<div class="form-group">
										<div class="panel panel-info">
											<div class="panel-heading">			
												<div class="row">									
													<div class="col-md-3">
														<label for="ValorProduto">Valor:</label><br>
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
		<div class="col-md-2"></div>
	</div>
</div>	