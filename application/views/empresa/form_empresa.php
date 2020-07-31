<?php if (isset($msg)) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Empresa'])) { ?>

<div class="container-fluid">
	<div class="row">
	
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<?php echo form_open_multipart($form_open_path); ?>
			<div class="panel panel-primary">
				
				<div class="panel-heading">
					<div class="btn-group">
						<button type="button" class="btn btn-sm btn-default  dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-file"></span> <?php echo '<small>' . $_SESSION['Empresa']['NomeEmpresa'] . '</small> - <small>Id.: ' . $_SESSION['Empresa']['idSis_Empresa'] . '</small>' ?> <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li>
								<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
									<a href="<?php echo base_url() . 'empresa/prontuario/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
										<span class="glyphicon glyphicon-file"> </span>Ver Dados da Empresa
									</a>
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<li>
								<a <?php if (preg_match("/empresa\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
									<a href="<?php echo base_url() . 'empresa/alterar/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Editar Dados da Empresa
									</a>
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<li>
								<a <?php if (preg_match("/empresa\/alterarlogo\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
									<a href="<?php echo base_url() . 'empresa/alterarlogo/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Alterar Logo
								</a>
							</li>							
						</ul>
					</div>
				</div>
								
				<div class="panel-body">
					<div class="row">	
						<div class="col-md-12">	
						
							<?php echo validation_errors(); ?>

							<div class="panel panel-info">
								<div class="panel-heading">
									<h3 class="text-left">Dados do Administrador  </h3>
									<div class="form-group">
										<div class="row">
											<div class="col-md-3">
												<label for="NomeAdmin">Nome do Admin.:</label>
												<input type="text" class="form-control" id="NomeAdmin" maxlength="45" 
														name="NomeAdmin" autofocus value="<?php echo $query['NomeAdmin']; ?>">
											</div>
											<div class="col-md-3">
												<label for="DataNascimento">Data do Aniver.:</label>
												<input type="text" class="form-control Date" maxlength="10" <?php echo $readonly; ?>
													   name="DataNascimento" placeholder="DD/MM/AAAA" value="<?php echo $query['DataNascimento']; ?>">
											</div>	
										</div>
									</div>
									<!--
									<div class="form-group">
										<div class="row">											
											<div class="col-md-3">
												<label for="CelularAdmin">Celular /(Login)</label>
												<input type="text" class="form-control Celular CelularVariavel" id="CelularAdmin" maxlength="11" <?php echo $readonly; ?>
													   name="CelularAdmin" placeholder="(XX)999999999" value="<?php echo $query['CelularAdmin']; ?>">
											</div>
											<div class="col-md-3">
												<label for="Senha">Senha:</label>
												<input type="password" class="form-control" id="Senha" maxlength="45"
													   name="Senha" value="<?php #echo $query['Senha']; ?>">
												<?php echo form_error('Senha'); ?>
											</div>
											<div class="col-md-3">
												<label for="Senha">Confirmar Senha:</label>
												<input type="password" class="form-control" id="Confirma" maxlength="45"
													   name="Confirma" value="<?php #echo $query['Senha']; ?>">
												<?php echo form_error('Confirma'); ?>
											</div>											
										</div>
									</div>
									-->
									<h3 class="text-left">Dados da Empresa  </h3>									
									<div class="form-group">
										<div class="row">
											<div class="col-md-3 "> 
												<label>Logo Marca</label>
												<img alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['AdminEmpresa']['idSis_Empresa'] . '/documentos/' . $_SESSION['AdminEmpresa']['Arquivo'] . ''; ?>" 
												class="img-circle img-responsive">
											</div>											
											<div class="col-md-3">
												<label for="NomeEmpresa">Nome da Empresa:</label>
												<input type="text" class="form-control" id="NomeEmpresa" maxlength="45" 
														name="NomeEmpresa" autofocus value="<?php echo $query['NomeEmpresa']; ?>">
											</div>
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
											<div class="col-md-3">
												<label for="Atuacao">Atua��o:</label>
												<textarea class="form-control" id="Atuacao" <?php echo $readonly; ?>
														  name="Atuacao"><?php echo $query['Atuacao']; ?></textarea>
											</div>
											<!--
											<div class="col-md-3">
												<label for="Site">Site:</label>
												<input type="text" class="form-control" maxlength="50" <?php echo $readonly; ?>
													   name="Site" value="<?php echo $query['Site']; ?>">
											<?php echo form_error('Site'); ?>
											</div>
											-->
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
													<label for="Email">E-mail Admin.:</label>
													<input type="text" class="form-control" id="BairroEmpresa" maxlength="100" <?php echo $readonly; ?>
														   name="Email" value="<?php echo $query['Email']; ?>">
												</div>												
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
												<div class="col-md-4">
													<label for="EnderecoEmpresa">Endre�o:</label>
													<input type="text" class="form-control" maxlength="200" <?php echo $readonly; ?>
														   name="EnderecoEmpresa" value="<?php echo $query['EnderecoEmpresa']; ?>">
												</div>
												<div class="col-md-2">
													<label for="NumeroEmpresa">Numero:</label>
													<input type="text" class="form-control" maxlength="200" <?php echo $readonly; ?>
														   name="NumeroEmpresa" value="<?php echo $query['NumeroEmpresa']; ?>">
												</div>
												<div class="col-md-3">
													<label for="ComplementoEmpresa">Complemento:</label>
													<input type="text" class="form-control" maxlength="100" <?php echo $readonly; ?>
														   name="ComplementoEmpresa" value="<?php echo $query['ComplementoEmpresa']; ?>">
												</div>
												<div class="col-md-3">
													<label for="BairroEmpresa">Bairro:</label>
													<input type="text" class="form-control" maxlength="100" <?php echo $readonly; ?>
														   name="BairroEmpresa" value="<?php echo $query['BairroEmpresa']; ?>">
												</div>
											</div>	
											<div class="row">	
												<div class="col-md-3">
													<label for="MunicipioEmpresa">Municipio:</label>
													<input type="text" class="form-control" maxlength="100" <?php echo $readonly; ?>
														   name="MunicipioEmpresa" value="<?php echo $query['MunicipioEmpresa']; ?>">
												</div>												
												<div class="col-md-3">
													<label for="EstadoEmpresa">Estado:</label>
													<input type="text" class="form-control" maxlength="2" <?php echo $readonly; ?>
														   name="EstadoEmpresa" value="<?php echo $query['EstadoEmpresa']; ?>">
												</div>
												<div class="col-md-3">
													<label for="CepEmpresa">Cep:</label>
													<input type="text" class="form-control" maxlength="8" <?php echo $readonly; ?>
														   name="CepEmpresa" value="<?php echo $query['CepEmpresa']; ?>">
												</div>
											</div>
										</div>
										<h3 class="text-left">Dados do E-Comerce</h3>
										<div class="form-group">
											<div class="row">
												<div class="col-md-3 text-left">
													<label for="EComerce">E-Comerce Ativo?</label><br>
													<div class="btn-group" data-toggle="buttons">
														<?php
														foreach ($select['EComerce'] as $key => $row) {
															if (!$query['EComerce'])$query['EComerce'] = 'S';

															($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

															if ($query['EComerce'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="EComerce_' . $hideshow . '">'
																. '<input type="radio" name="EComerce" id="' . $hideshow . '" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="EComerce_' . $hideshow . '">'
																. '<input type="radio" name="EComerce" id="' . $hideshow . '" '
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
										<div id="EComerce" <?php echo $div['EComerce']; ?>>
											<div class="form-group">
												<div class="row">
													<div class="col-md-3">
														<h3 class="text-left">Entrega:</h3>
													</div>
													<div class="col-md-3">
														<label for="RetirarLoja">Retirar na Loja?</label><br>
														<div class="form-group">
															<div class="btn-group" data-toggle="buttons">
																<?php
																foreach ($select['RetirarLoja'] as $key => $row) {
																	(!$query['RetirarLoja']) ? $query['RetirarLoja'] = 'S' : FALSE;

																	if ($query['RetirarLoja'] == $key) {
																		echo ''
																		. '<label class="btn btn-warning active" name="radiobutton_RetirarLoja" id="radiobutton_RetirarLoja' . $key . '">'
																		. '<input type="radio" name="RetirarLoja" id="radiobutton" '
																		. 'autocomplete="off" value="' . $key . '" checked>' . $row
																		. '</label>'
																		;
																	} else {
																		echo ''
																		. '<label class="btn btn-default" name="radiobutton_RetirarLoja" id="radiobutton_RetirarLoja' . $key . '">'
																		. '<input type="radio" name="RetirarLoja" id="radiobutton" '
																		. 'autocomplete="off" value="' . $key . '" >' . $row
																		. '</label>'
																		;
																	}
																}
																?>
															</div>
														</div>
													</div>
													<div class="col-md-3">
														<label for="MotoBoy">Moto Boy?</label><br>
														<div class="form-group">
															<div class="btn-group" data-toggle="buttons">
																<?php
																foreach ($select['MotoBoy'] as $key => $row) {
																	(!$query['MotoBoy']) ? $query['MotoBoy'] = 'S' : FALSE;

																	if ($query['MotoBoy'] == $key) {
																		echo ''
																		. '<label class="btn btn-warning active" name="radiobutton_MotoBoy" id="radiobutton_MotoBoy' . $key . '">'
																		. '<input type="radio" name="MotoBoy" id="radiobutton" '
																		. 'autocomplete="off" value="' . $key . '" checked>' . $row
																		. '</label>'
																		;
																	} else {
																		echo ''
																		. '<label class="btn btn-default" name="radiobutton_MotoBoy" id="radiobutton_MotoBoy' . $key . '">'
																		. '<input type="radio" name="MotoBoy" id="radiobutton" '
																		. 'autocomplete="off" value="' . $key . '" >' . $row
																		. '</label>'
																		;
																	}
																}
																?>
															</div>
														</div>
													</div>
													<div class="col-md-3">
														<label for="Correios">Correios?</label><br>
														<div class="form-group">
															<div class="btn-group" data-toggle="buttons">
																<?php
																foreach ($select['Correios'] as $key => $row) {
																	(!$query['Correios']) ? $query['Correios'] = 'S' : FALSE;

																	if ($query['Correios'] == $key) {
																		echo ''
																		. '<label class="btn btn-warning active" name="radiobutton_Correios" id="radiobutton_Correios' . $key . '">'
																		. '<input type="radio" name="Correios" id="radiobutton" '
																		. 'autocomplete="off" value="' . $key . '" checked>' . $row
																		. '</label>'
																		;
																	} else {
																		echo ''
																		. '<label class="btn btn-default" name="radiobutton_Correios" id="radiobutton_Correios' . $key . '">'
																		. '<input type="radio" name="Correios" id="radiobutton" '
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
											<div class="form-group">
												<div class="row">
													<div class="col-md-3">
														<h3 class="text-left">Pagamento:</h3>
													</div>
													<div class="col-md-3">
														<label for="Boleto">Boleto?</label><br>
														<div class="form-group">
															<div class="btn-group" data-toggle="buttons">
																<?php
																foreach ($select['Boleto'] as $key => $row) {
																	(!$query['Boleto']) ? $query['Boleto'] = 'S' : FALSE;

																	if ($query['Boleto'] == $key) {
																		echo ''
																		. '<label class="btn btn-warning active" name="radiobutton_Boleto" id="radiobutton_Boleto' . $key . '">'
																		. '<input type="radio" name="Boleto" id="radiobutton" '
																		. 'autocomplete="off" value="' . $key . '" checked>' . $row
																		. '</label>'
																		;
																	} else {
																		echo ''
																		. '<label class="btn btn-default" name="radiobutton_Boleto" id="radiobutton_Boleto' . $key . '">'
																		. '<input type="radio" name="Boleto" id="radiobutton" '
																		. 'autocomplete="off" value="' . $key . '" >' . $row
																		. '</label>'
																		;
																	}
																}
																?>
															</div>
														</div>
													</div>
													<div class="col-md-3">
														<label for="Debito">Debito?</label><br>
														<div class="form-group">
															<div class="btn-group" data-toggle="buttons">
																<?php
																foreach ($select['Debito'] as $key => $row) {
																	(!$query['Debito']) ? $query['Debito'] = 'S' : FALSE;

																	if ($query['Debito'] == $key) {
																		echo ''
																		. '<label class="btn btn-warning active" name="radiobutton_Debito" id="radiobutton_Debito' . $key . '">'
																		. '<input type="radio" name="Debito" id="radiobutton" '
																		. 'autocomplete="off" value="' . $key . '" checked>' . $row
																		. '</label>'
																		;
																	} else {
																		echo ''
																		. '<label class="btn btn-default" name="radiobutton_Debito" id="radiobutton_Debito' . $key . '">'
																		. '<input type="radio" name="Debito" id="radiobutton" '
																		. 'autocomplete="off" value="' . $key . '" >' . $row
																		. '</label>'
																		;
																	}
																}
																?>
															</div>
														</div>
													</div>
													<div class="col-md-3">
														<label for="Cartao">Cartao?</label><br>
														<div class="form-group">
															<div class="btn-group" data-toggle="buttons">
																<?php
																foreach ($select['Cartao'] as $key => $row) {
																	(!$query['Cartao']) ? $query['Cartao'] = 'S' : FALSE;

																	if ($query['Cartao'] == $key) {
																		echo ''
																		. '<label class="btn btn-warning active" name="radiobutton_Cartao" id="radiobutton_Cartao' . $key . '">'
																		. '<input type="radio" name="Cartao" id="radiobutton" '
																		. 'autocomplete="off" value="' . $key . '" checked>' . $row
																		. '</label>'
																		;
																	} else {
																		echo ''
																		. '<label class="btn btn-default" name="radiobutton_Cartao" id="radiobutton_Cartao' . $key . '">'
																		. '<input type="radio" name="Cartao" id="radiobutton" '
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
					</div>		
					<div class="form-group">
						<div class="row">
							<input type="hidden" name="idSis_Empresa" value="<?php echo $query['idSis_Empresa']; ?>">
							<?php if ($metodo == 2) { ?>

								<div class="col-md-6">
									<button class="btn btn-sm btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
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
									<button class="btn btn-sm btn-warning" id="inputDb" onClick="history.go(-1);
											return true;">
										<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
									</button>
								</div>
							<?php } else { ?>
								<div class="col-md-6">
									<button class="btn btn-sm btn-primary" id="inputDb" data-loading-text="Aguarde..." name="submit" value="1" type="submit">
										<span class="glyphicon glyphicon-save"></span> Salvar
									</button>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>	
			</div>
			</form>
		</div>
	</div>	
</div>
<?php } ?>