<?php if (isset($msg)) echo $msg; ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-offset-2 col-md-8">
		<?php echo form_open_multipart($form_open_path); ?>
			<div class="panel panel-primary">
				
				<div class="panel-heading">
					<label class="sr-only" for="idSis_Empresa">Empresa:*</label>
					<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" <?php echo $readonly; ?> readonly=""
							id="idSis_Empresa" name="idSis_Empresa">

						<?php
						foreach ($select['idSis_Empresa'] as $key => $row) {
							if ($query['idSis_Empresa'] == $key) {
								echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
							} else {
								echo '<option value="' . $key . '">' . $row . '</option>';
							}
						}
						?>
					</select>
				</div>
				<div class="panel-body">
					
					<div class="row">
						<div class="col-md-12">	
							
							<?php echo validation_errors(); ?>

							<div class="panel panel-<?php echo $panel; ?>">

								<div class="panel-heading"><strong>Usu�rio</strong></div>
								<div class="panel-body">
									<div class="panel panel-info">
										<div class="panel-heading">
											<div class="form-group">
												<div class="row">
													<div class="col-md-3">
														<label for="Nome">Nome do Usu�rio:</label>
														<input type="text" class="form-control" id="Nome" maxlength="45" 
																autofocus name="Nome"  value="<?php echo $query['Nome']; ?>">
													</div>																		
													<div class="col-md-3">
														<label for="Celular">Tel.- Fixo ou Celular*</label>
														<input type="text" class="form-control Celular CelularVariavel" id="Celular" maxlength="11" <?php echo $readonly; ?>
															   name="Celular" placeholder="(XX)999999999" value="<?php echo $query['Celular']; ?>">
													</div>
													<div class="col-md-3">
														<label for="DataNascimento">Data de Nascimento:</label>
														<input type="text" class="form-control Date" maxlength="10" <?php echo $readonly; ?>
															   name="DataNascimento" placeholder="DD/MM/AAAA" value="<?php echo $query['DataNascimento']; ?>">
													</div>						
													<div class="col-md-3">
														<label for="Sexo">Sexo:</label>
														<select data-placeholder="Selecione uma op��o..." class="form-control" <?php echo $readonly; ?>
																id="Sexo" name="Sexo">
															<option value="">--Selec. o Sexo--</option>
															<?php
															foreach ($select['Sexo'] as $key => $row) {
																if ($query['Sexo'] == $key) {
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
											<div class="form-group">
												<div class="row">
													<div class="col-md-3">
														<label for="Funcao">Funcao:*</label>
														<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
														<a class="btn btn-xs btn-info" href="<?php echo base_url() ?>funcao/cadastrar/funcao" role="button"> 
															<span class="glyphicon glyphicon-plus"></span> <b>Nova Funcao</b>
														</a>
														<?php } ?>
														<select data-placeholder="Selecione uma op��o..." class="form-control" <?php echo $readonly; ?>
																id="Funcao" name="Funcao">
															<option value="">-- Selecione uma Funcao --</option>
															<?php
															foreach ($select['Funcao'] as $key => $row) {
																if ($query['Funcao'] == $key) {
																	echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																} else {
																	echo '<option value="' . $key . '">' . $row . '</option>';
																}
															}
															?>   
														</select>          
													</div>
													<div class="col-md-3">
														<label for="Permissao">Acesso �s Agendas:*</label>
														<select data-placeholder="Selecione uma op��o..." class="form-control" <?php echo $readonly; ?>
																id="Permissao" name="Permissao">
															<option value="">-- Selecione uma Permissao --</option>
															<?php
															foreach ($select['Permissao'] as $key => $row) {
																if ($query['Permissao'] == $key) {
																	echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																} else {
																	echo '<option value="' . $key . '">' . $row . '</option>';
																}
															}
															?>   
														</select>          
													</div>
													<div class="col-md-2">
														<label for="Inativo">Ativo?</label><br>
														<div class="form-group">
															<div class="btn-group" data-toggle="buttons">
																<?php
																foreach ($select['Inativo'] as $key => $row) {
																	(!$query['Inativo']) ? $query['Inativo'] = '0' : FALSE;

																	if ($query['Inativo'] == $key) {
																		echo ''
																		. '<label class="btn btn-warning active" name="radiobutton_Inativo" id="radiobutton_Inativo' . $key . '">'
																		. '<input type="radio" name="Inativo" id="radiobutton" '
																		. 'autocomplete="off" value="' . $key . '" checked>' . $row
																		. '</label>'
																		;
																	} else {
																		echo ''
																		. '<label class="btn btn-default" name="radiobutton_Inativo" id="radiobutton_Inativo' . $key . '">'
																		. '<input type="radio" name="Inativo" id="radiobutton" '
																		. 'autocomplete="off" value="' . $key . '" >' . $row
																		. '</label>'
																		;
																	}
																}
																?>
															</div>
														</div>
													</div>
													<!--
													<div class="col-md-2">
														<label for="CompAgenda">Comp. Agenda?</label><br>
														<div class="form-group">
															<div class="btn-group" data-toggle="buttons">
																<?php
																foreach ($select['CompAgenda'] as $key => $row) {
																	(!$query['CompAgenda']) ? $query['CompAgenda'] = 'N' : FALSE;

																	if ($query['CompAgenda'] == $key) {
																		echo ''
																		. '<label class="btn btn-warning active" name="radiobutton_Ativo" id="radiobutton_Ativo' . $key . '">'
																		. '<input type="radio" name="CompAgenda" id="radiobutton" '
																		. 'autocomplete="off" value="' . $key . '" checked>' . $row
																		. '</label>'
																		;
																	} else {
																		echo ''
																		. '<label class="btn btn-default" name="radiobutton_Ativo" id="radiobutton_Ativo' . $key . '">'
																		. '<input type="radio" name="CompAgenda" id="radiobutton" '
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
												</div>
											</div>
											<div class="form-group">
												<div class="row">
													<div class="col-md-3">
														<label for="CpfUsuario">Cpf:</label>
														<input type="text" class="form-control" maxlength="11" <?php echo $readonly; ?>
															   name="CpfUsuario" value="<?php echo $query['CpfUsuario']; ?>">
													<?php echo form_error('CpfUsuario'); ?>
													</div>
													<div class="col-md-3">
														<label for="Senha">Senha:</label>
														<input type="password" class="form-control" id="Senha" maxlength="45"
															   name="Senha" value="<?php echo $query['Senha']; ?>">
														<?php echo form_error('Senha'); ?>
													</div>
													<div class="col-md-3">
														<label for="Senha">Confirmar Senha:</label>
														<input type="password" class="form-control" id="Confirma" maxlength="45"
															   name="Confirma" value="<?php echo $query['Confirma']; ?>">
														<?php echo form_error('Confirma'); ?>
													</div>
													<div class="col-md-3">
														<label for="Email">E-mail:</label>
														<input type="text" class="form-control" id="Bairro" maxlength="100" <?php echo $readonly; ?>
															   name="Email" value="<?php echo $query['Email']; ?>">
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="row">
													<div class="col-md-12 text-center">
														<button class="btn btn-info" type="button" data-toggle="collapse" data-target="#DadosComplementares" aria-expanded="false" aria-controls="DadosComplementares">
															<span class="glyphicon glyphicon-menu-down"></span> Completar Dados
														</button>
													</div>
												</div>
											</div>

											<div <?php echo $collapse; ?> id="DadosComplementares">
												<div class="form-group">
													<div class="row">		
														<div class="col-md-3">
															<label for="RgUsuario">RG:</label>
															<input type="text" class="form-control" maxlength="9" <?php echo $readonly; ?>
																   name="RgUsuario" value="<?php echo $query['RgUsuario']; ?>">
														</div>
														<div class="col-md-3">
															<label for="OrgaoExpUsuario">Org�o Exp.:</label>
															<input type="text" class="form-control" maxlength="45" <?php echo $readonly; ?>
																   name="OrgaoExpUsuario" value="<?php echo $query['OrgaoExpUsuario']; ?>">
														</div>
														<div class="col-md-3">
															<label for="DataEmUsuario">Data de Emiss�o:</label>
															<input type="text" class="form-control Date" maxlength="10" <?php echo $readonly; ?>
																   name="DataEmUsuario" placeholder="DD/MM/AAAA" value="<?php echo $query['DataEmUsuario']; ?>">
														</div>
														<div class="col-md-1">
															<label for="EstadoEmUsuario">Est.:</label>
															<input type="text" class="form-control" maxlength="2" <?php echo $readonly; ?>
																   name="EstadoEmUsuario" value="<?php echo $query['EstadoEmUsuario']; ?>">
														</div>
													</div>
												</div>	
												<div class="form-group">
													<div class="row">
														<div class="col-md-3">
															<label for="EnderecoUsuario">Endre�o:</label>
															<input type="text" class="form-control" maxlength="100" <?php echo $readonly; ?>
																   name="EnderecoUsuario" value="<?php echo $query['EnderecoUsuario']; ?>">
														</div>
														<div class="col-md-3">
															<label for="BairroUsuario">Bairro:</label>
															<input type="text" class="form-control"  maxlength="100" <?php echo $readonly; ?>
																   name="BairroUsuario" value="<?php echo $query['BairroUsuario']; ?>">
														</div>
														<div class="col-md-3">
															<label for="MunicipioUsuario">Municipio:</label>
															<input type="text" class="form-control" maxlength="100" <?php echo $readonly; ?>
																   name="MunicipioUsuario" value="<?php echo $query['MunicipioUsuario']; ?>">
														</div>												
														<div class="col-md-1">
															<label for="EstadoUsuario">Estado:</label>
															<input type="text" class="form-control" maxlength="2" <?php echo $readonly; ?>
																   name="EstadoUsuario" value="<?php echo $query['EstadoUsuario']; ?>">
														</div>
														<div class="col-md-2">
															<label for="CepUsuario">Cep:</label>
															<input type="text" class="form-control" maxlength="8" <?php echo $readonly; ?>
																   name="CepUsuario" value="<?php echo $query['CepUsuario']; ?>">
														</div>
													</div>
												</div>
												<!--
												<div class="form-group">
													<div class="row">		
														
														<div class="col-md-3">
															<label for="Usuario">Usu�rio:</label>
															<input type="text" class="form-control" id="Usuario" maxlength="45" 
																   name="Usuario" value="<?php echo $query['Usuario']; ?>">
															<?php #echo form_error('Usuario'); ?>
														</div>
														
													</div>
												</div>
												-->
											</div>	
											<br>
											<div class="form-group">
												<div class="row">
													<input type="hidden" name="idSis_Usuario" value="<?php echo $query['idSis_Usuario']; ?>">
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
																			<a class="btn btn-danger" href="<?php echo base_url() . 'usuario/excluir/' . $query['idSis_Usuario'] ?>" role="button">
																				<span class="glyphicon glyphicon-trash"></span> Confirmar Exclus�o
																			</a>
																		</div>
																	</div>
																</div>
															</div>
														</div>

													<?php } elseif ($metodo == 3) { ?>
														<div class="col-md-12 text-center">
															<button class="btn btn-lg btn-danger" id="inputDb" data-loading-text="Aguarde..." name="submit" value="1" type="submit">
																<span class="glyphicon glyphicon-trash"></span> Excluir
															</button>
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

										</form>
								
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
