<?php if (isset($msg)) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Empresa'])) { ?>

<div class="container-fluid">
	<div class="row">
	
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<?php echo form_open_multipart($form_open_path); ?>
			<div class="panel panel-primary">
				
				<div class="panel-heading">
				
				<?php echo '<small>' . $_SESSION['Empresa']['NomeEmpresa'] . '</small> - <small>Id.: ' . $_SESSION['Empresa']['idSis_Empresa'] . '</small>' ?>
				
				<a class="btn btn-sm btn-success" href="<?php echo base_url() . 'empresa/prontuario/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
					<span class="glyphicon glyphicon-file"> </span> Ver <span class="sr-only">(current)</span>
				</a>
				<a class="btn btn-sm btn-warning" href="<?php echo base_url() . 'empresa/alterar/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
					<span class="glyphicon glyphicon-edit"></span> Edit.
				</a>
				</div>
<?php } ?>				
				<div class="panel-body">

					<div class="row">
						<div class="col-md-12">	
							
							<?php echo validation_errors(); ?>

							<div class="panel panel-<?php echo $panel; ?>">

								<div class="panel-heading">Empresa</div>
								
								<div class="panel-body">
									<div style="overflow: auto; height: 400px; ">
										<?php echo form_open_multipart($form_open_path); ?>
										<h4 class="text-left">Dados do Administrador  </h4>
										<div class="form-group">
											<div class="row">
												<div class="col-md-3">
													<label for="NomeAdmin">Nome do Admin.:</label>
													<input type="text" class="form-control" id="NomeAdmin" maxlength="45" 
															name="NomeAdmin" autofocus value="<?php echo $query['NomeAdmin']; ?>">
												</div>																		
												<div class="col-md-3">
													<label for="Celular">Tel. Admin.</label>
													<input type="text" class="form-control Celular CelularVariavel" id="Celular" maxlength="11" <?php echo $readonly; ?>
														   name="Celular" placeholder="(XX)999999999" value="<?php echo $query['Celular']; ?>">
												</div>
												<div class="col-md-3">
													<label for="Email">E-mail Admin.:</label>
													<input type="text" class="form-control" id="Bairro" maxlength="100" <?php echo $readonly; ?>
														   name="Email" value="<?php echo $query['Email']; ?>">
												</div>
											</div>
										</div>

										<h4 class="text-left">Dados da Empresa  </h4>									
										<div class="form-group">
											<div class="row">										
												<div class="col-md-3">
													<label for="Cnpj">Cnpj:</label>
													<input type="text" class="form-control Cnpj" maxlength="18" <?php echo $readonly; ?>
														   name="Cnpj" placeholder="99.999.999/9999-98" value="<?php echo $query['Cnpj']; ?>">
												</div>
												<div class="col-md-3">
													<label for="InscEstadual">Insc.Estadual:</label>
													<input type="text" class="form-control" maxlength="11" <?php echo $readonly; ?>
														   name="InscEstadual" value="<?php echo $query['InscEstadual']; ?>">
												</div>
												<div class="col-md-3">
													<label for="Telefone">Tel.Empresa:</label>
													<input type="text" class="form-control Celular CelularVariavel" id="Telefone" maxlength="11" <?php echo $readonly; ?>
														   name="Telefone" placeholder="(XX)999999999" value="<?php echo $query['Telefone']; ?>">
												</div>																				
											</div>
										</div>
										
										<div class="form-group">
											<div class="row">
												<div class="col-md-3">
													<label for="Endereco">Endre�o:</label>
													<input type="text" class="form-control" maxlength="200" <?php echo $readonly; ?>
														   name="Endereco" value="<?php echo $query['Endereco']; ?>">
												</div>
												<div class="col-md-3">
													<label for="Bairro">Bairro:</label>
													<input type="text" class="form-control" maxlength="100" <?php echo $readonly; ?>
														   name="Bairro" value="<?php echo $query['Bairro']; ?>">
												</div>
												<div class="col-md-3">
													<label for="Municipio">Municipio:</label>
													<input type="text" class="form-control" maxlength="100" <?php echo $readonly; ?>
														   name="Municipio" value="<?php echo $query['Municipio']; ?>">
												</div>												
												<div class="col-md-1">
													<label for="Estado">Estado:</label>
													<input type="text" class="form-control" maxlength="2" <?php echo $readonly; ?>
														   name="Estado" value="<?php echo $query['Estado']; ?>">
												</div>
												<div class="col-md-2">
													<label for="Cep">Cep:</label>
													<input type="text" class="form-control" maxlength="8" <?php echo $readonly; ?>
														   name="Cep" value="<?php echo $query['Cep']; ?>">
												</div>
											</div>
										</div>

										<div class="form-group">
											<div class="row">
												<div class="col-md-3">
													<label for="CategoriaEmpresa">Categoria:*</label>
													<select data-placeholder="Selecione uma op��o..." class="form-control" <?php echo $readonly; ?>
															id="CategoriaEmpresa" name="CategoriaEmpresa">
														<option value="">-- Selec. uma Categoria --</option>
														<?php
														foreach ($select['CategoriaEmpresa'] as $key => $row) {
															if ($query['CategoriaEmpresa'] == $key) {
																echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
															} else {
																echo '<option value="' . $key . '">' . $row . '</option>';
															}
														}
														?>   
													</select>          
												</div>
												<div class="col-md-6">
													<label for="Atuacao">Atua��o:</label>
													<textarea class="form-control" id="Atuacao" <?php echo $readonly; ?>
															  name="Atuacao"><?php echo $query['Atuacao']; ?></textarea>
												</div>
												<div class="col-md-3">
													<label for="Site">Site:</label>
													<input type="text" class="form-control" maxlength="50" <?php echo $readonly; ?>
														   name="Site" value="<?php echo $query['Site']; ?>">
												</div>
											</div>
										</div>
										</form>
									</div>
								</div>
							</div>							
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<input type="hidden" name="idSis_Empresa" value="<?php echo $query['idSis_Empresa']; ?>">
							<?php if ($metodo == 2) { ?>

								<div class="col-md-6">
									<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
										<span class="glyphicon glyphicon-save"></span> Salvar
									</button>
								</div>
								<!--
								<div class="col-md-6 text-right">
									<button  type="button" class="btn btn-lg btn-danger" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
										<span class="glyphicon glyphicon-trash"></span> Excluir
									</button>
								</div>
								-->
								<div class="modal fade bs-excluir-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header bg-danger">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												<h4 class="modal-title">Tem certeza que deseja excluir?</h4>
											</div>
											<div class="modal-body">
												<p>Ao confirmar esta opera��o todos os dados ser�o exclu�dos permanentemente do sistema.
													Esta opera��o � irrevers�vel.</p>
											</div>
											<div class="modal-footer">
												<div class="col-md-6 text-left">
													<button type="button" class="btn btn-warning" data-dismiss="modal">
														<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
													</button>
												</div>
												<div class="col-md-6 text-right">
													<a class="btn btn-danger" href="<?php echo base_url() . 'empresa/excluir/' . $query['idSis_Empresa'] ?>" role="button">
														<span class="glyphicon glyphicon-trash"></span> Confirmar Exclus�o
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>

							<?php } elseif ($metodo == 3) { ?>
								<div class="col-md-12 text-center">
									<!--
									<button class="btn btn-lg btn-danger" id="inputDb" data-loading-text="Aguarde..." name="submit" value="1" type="submit">
										<span class="glyphicon glyphicon-trash"></span> Excluir
									</button>
									-->
									<button class="btn btn-lg btn-warning" id="inputDb" onClick="history.go(-1);
											return true;">
										<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
									</button>
								</div>
							<?php } else { ?>
								<div class="col-md-6">
									<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." name="submit" value="1" type="submit">
										<span class="glyphicon glyphicon-save"></span> Salvar
									</button>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>	
			</div>		
		</div>
	</div>	
</div>
