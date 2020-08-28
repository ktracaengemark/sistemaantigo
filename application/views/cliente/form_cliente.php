<?php if (isset($msg)) echo $msg; ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8 ">
			<?php if ( !isset($evento) && isset($_SESSION['Cliente'])) { ?>
				<?php if ($_SESSION['Cliente']['idApp_Cliente'] != 1 ) { ?>
					<nav class="navbar navbar-inverse navbar-fixed" role="banner">
					  <div class="container-fluid">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span> 
							</button>
							
							<a class="navbar-brand" href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
								<?php echo '<small>' . $_SESSION['Cliente']['idApp_Cliente'] . '</small> - <small>' . $_SESSION['Cliente']['NomeCliente'] . '.</small>' ?> 
							</a>
						</div>
						<div class="collapse navbar-collapse" id="myNavbar">
							<ul class="nav navbar-nav navbar-center">
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
									<div class="btn-group">
										<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-user"></span> Cliente <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/cliente\/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-file"></span> Ver Dados do Cliente
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/cliente\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'cliente/alterar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-edit"></span> Editar Dados do Cliente
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
													<a href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-user"></span> Contatos do Cliente
													</a>
												</a>
											</li>
										</ul>
									</div>									
								</li>
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
									<div class="btn-group">
										<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-calendar"></span> Agenda <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/consulta\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
													<a href="<?php echo base_url() . 'consulta/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-calendar"></span> Lista de Agendamentos
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/consulta\/cadastrar1\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'consulta/cadastrar1/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-plus"></span> Novo Agendamento
													</a>
												</a>
											</li>
										</ul>
									</div>									
								</li>								
								<?php if ($_SESSION['Cliente']['idSis_Empresa'] == $_SESSION['log']['idSis_Empresa'] ) { ?>
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
									<div class="btn-group">
										<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-usd"></span> Orçs. <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/orcatrata\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
													<a href="<?php echo base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-usd"></span> Lista de Orçamentos
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/orcatrata\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'orcatrata/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-plus"></span> Novo Orçamento
													</a>
												</a>
											</li>
										</ul>
									</div>
								</li>
								<?php } ?>	
							</ul>
						</div>
					  </div>
					</nav>
				<?php } ?>
			<?php } ?>			
					
			<div class="row">
				<div class="col-md-12 col-lg-12">	
					<?php echo form_open_multipart($form_open_path); ?>
					<?php echo validation_errors(); ?>

					<div class="panel panel-<?php echo $panel; ?>">

						<div class="panel-heading">
							<strong>Cliente
								<label for="idSis_Empresa" class="sr-only col-md-4">Empresa:</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?> readonly=""
										id="idSis_Empresa" autofocus name="idSis_Empresa">

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
							</strong>
						</div>
						<div class="panel-body">
							<div class="form-group">
								<div class="row">
									<div class="col-md-4">
										<label for="NomeCliente">Nome do Cliente: *</label>
										<input type="text" class="form-control" id="NomeCliente" maxlength="255" <?php echo $readonly; ?>
											   name="NomeCliente" autofocus value="<?php echo $query['NomeCliente']; ?>">
										<?php echo form_error('NomeCliente'); ?>
									</div>
									<div class="col-md-3">
										<label for="CelularCliente">Celular*</label>
										<input type="text" class="form-control Celular" id="CelularCliente" maxlength="11" <?php echo $readonly; ?>
											   name="CelularCliente" placeholder="(XX)999999999" value="<?php echo $query['CelularCliente']; ?>">
										<?php echo form_error('CelularCliente'); ?>
									</div>
									<div class="col-md-3">
										<label for="DataNascimento">Data de Nascimento:</label>
										<input type="text" class="form-control Date" maxlength="10" <?php echo $readonly; ?>
											   name="DataNascimento" placeholder="DD/MM/AAAA" value="<?php echo $query['DataNascimento']; ?>">
									</div>						
									<div class="col-md-2">
										<label for="Sexo">Sexo:</label>
										<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
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
									<div class="col-md-2">
										<label for="CepCliente">Cep:</label>
										<input type="text" class="form-control" id="CepCliente" maxlength="8" <?php echo $readonly; ?>
											   name="CepCliente" value="<?php echo $query['CepCliente']; ?>">
									</div>
									<div class="col-md-5">
										<label for="EnderecoCliente">Endreço:</label>
										<input type="text" class="form-control" id="EnderecoCliente" maxlength="100" <?php echo $readonly; ?>
											   name="EnderecoCliente" value="<?php echo $query['EnderecoCliente']; ?>">
									</div>
									<div class="col-md-2">
										<label for="NumeroCliente">Numero:</label>
										<input type="text" class="form-control" id="NumeroCliente" maxlength="100" <?php echo $readonly; ?>
											   name="NumeroCliente" value="<?php echo $query['NumeroCliente']; ?>">
									</div>
									<div class="col-md-3">
										<label for="ComplementoCliente">Complemento:</label>
										<input type="text" class="form-control" id="ComplementoCliente" maxlength="100" <?php echo $readonly; ?>
											   name="ComplementoCliente" value="<?php echo $query['ComplementoCliente']; ?>">
									</div>
								</div>	
								<div class="row">	
									<div class="col-md-3">
										<label for="BairroCliente">Bairro:</label>
										<input type="text" class="form-control" id="BairroCliente" maxlength="100" <?php echo $readonly; ?>
											   name="BairroCliente" value="<?php echo $query['BairroCliente']; ?>">
									</div>
									<div class="col-md-3">
										<label for="CidadeCliente">Município:</label>
										<input type="text" class="form-control" id="CidadeCliente" maxlength="100" <?php echo $readonly; ?>
											   name="CidadeCliente" value="<?php echo $query['CidadeCliente']; ?>">
									</div>
									<div class="col-md-2">
										<label for="EstadoCliente">Estado:</label>
										<input type="text" class="form-control" id="EstadoCliente" maxlength="2" <?php echo $readonly; ?>
											   name="EstadoCliente" value="<?php echo $query['EstadoCliente']; ?>">
									</div>
									<!--
									<div class="col-md-3">
										<label for="MunicipioCliente">Município:</label><br>
										<select data-placeholder="Selecione um Município..." class="form-control Chosen" <?php echo $disabled; ?>
												id="MunicipioCliente" name="MunicipioCliente">
											<option value="">-- Selec.um Município --</option>
											<?php
											foreach ($select['MunicipioCliente'] as $key => $row) {
												if ($query['MunicipioCliente'] == $key) {
													echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
												} else {
													echo '<option value="' . $key . '">' . $row . '</option>';
												}
											}
											?>
										</select>
									</div>
									-->
									<div class="col-md-3 ">
										<label class="" for="ReferenciaCliente">Referencia:</label>
										<textarea class="form-control " id="ReferenciaCliente" <?php echo $readonly; ?>
												  name="ReferenciaCliente"><?php echo $query['ReferenciaCliente']; ?>
										</textarea>
									</div>
								</div>
							</div>
							
							<!--
							<div class="col-md-2">
								<label for="Associado">Associado?</label><br>
								<div class="form-group">
									<div class="btn-group" data-toggle="buttons">
										<?php
										foreach ($select['Associado'] as $key => $row) {
											(!$query['Associado']) ? $query['Associado'] = 'N' : FALSE;

											if ($query['Associado'] == $key) {
												echo ''
												. '<label class="btn btn-warning active" name="radiobutton_Associado" id="radiobutton_Associado' . $key . '">'
												. '<input type="radio" name="Associado" id="radiobutton" '
												. 'autocomplete="off" value="' . $key . '" checked>' . $row
												. '</label>'
												;
											} else {
												echo ''
												. '<label class="btn btn-default" name="radiobutton_Associado" id="radiobutton_Associado' . $key . '">'
												. '<input type="radio" name="Associado" id="radiobutton" '
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
											<label for="CpfCliente">CPF:</label>
											<input type="text" class="form-control" maxlength="11" <?php echo $readonly; ?>
												   name="CpfCliente" value="<?php echo $query['CpfCliente']; ?>">
											<?php echo form_error('CpfCliente'); ?>
										</div>
										<div class="col-md-3">
											<label for="Telefone">Tel.1 - Fixo ou Celular:</label>
											<input type="text" class="form-control Celular CelularVariavel" id="Telefone" maxlength="11" <?php echo $readonly; ?>
												   name="Telefone" placeholder="(XX)999999999" value="<?php echo $query['Telefone']; ?>">
										</div>
										<div class="col-md-3">
											<label for="Telefone2">Tel.2 - Fixo ou Celular:</label>
											<input type="text" class="form-control Celular CelularVariavel" id="Telefone2" maxlength="11" <?php echo $readonly; ?>
												   name="Telefone2" placeholder="(XX)999999999" value="<?php echo $query['Telefone2']; ?>">
										</div>
										<div class="col-md-3">
											<label for="Telefone3">Tel.3 - Fixo ou Celular:</label>
											<input type="text" class="form-control Celular CelularVariavel" id="Telefone3" maxlength="11" <?php echo $readonly; ?>
												   name="Telefone3" placeholder="(XX)999999999" value="<?php echo $query['Telefone3']; ?>">
										</div>												
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										
										<div class="col-md-3">
											<label for="Rg">RG:</label>
											<input type="text" class="form-control" maxlength="9" <?php echo $readonly; ?>
												   name="Rg" value="<?php echo $query['Rg']; ?>">
										</div>
										<div class="col-md-3">
											<label for="OrgaoExp">Orgão Exp.:</label>
											<input type="text" class="form-control" maxlength="45" <?php echo $readonly; ?>
												   name="OrgaoExp" value="<?php echo $query['OrgaoExp']; ?>">
										</div>
										<div class="col-md-3">
											<label for="EstadoExp">Estado Emissor:</label>
											<input type="text" class="form-control" maxlength="2" <?php echo $readonly; ?>
												   name="EstadoExp" value="<?php echo $query['EstadoExp']; ?>">
										</div>
										<div class="col-md-3">
											<label for="DataEmissao">Data de Emissão:</label>
											<input type="text" class="form-control Date" maxlength="10" <?php echo $readonly; ?>
												   name="DataEmissao" placeholder="DD/MM/AAAA" value="<?php echo $query['DataEmissao']; ?>">
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">							
										<div class="col-md-3">
											<label for="Email">E-mail:</label>
											<input type="text" class="form-control" maxlength="100" <?php echo $readonly; ?>
												   name="Email" value="<?php echo $query['Email']; ?>">
										</div>											
										<!--
										<div class="col-md-3">
											<label for="DataCadastroCliente">Cadastrado em:</label>													
											<input type="text" class="form-control Date"  maxlength="10" <?php echo $readonly; ?>
												   name="DataCadastroCliente" placeholder="DD/MM/AAAA" value="<?php echo $query['DataCadastroCliente']; ?>">													
										</div>
										-->
										<div class="col-md-3">
											<label for="RegistroFicha">Ficha Nº:</label>
											<input type="text" class="form-control" maxlength="45" <?php echo $readonly; ?>
												   name="RegistroFicha" value="<?php echo $query['RegistroFicha']; ?>">
										</div>
										<div class="col-md-4">
											<label for="Obs">OBS:</label>
											<textarea class="form-control" id="Obs" <?php echo $readonly; ?>
													  name="Obs"><?php echo $query['Obs']; ?></textarea>
										</div>
										<div class="col-md-2">
											<label for="Ativo">Ativo?</label><br>
											<div class="form-group">
												<div class="btn-group" data-toggle="buttons">
													<?php
													foreach ($select['Ativo'] as $key => $row) {
														(!$query['Ativo']) ? $query['Ativo'] = 'S' : FALSE;

														if ($query['Ativo'] == $key) {
															echo ''
															. '<label class="btn btn-warning active" name="radiobutton_Ativo" id="radiobutton_Ativo' . $key . '">'
															. '<input type="radio" name="Ativo" id="radiobutton" '
															. 'autocomplete="off" value="' . $key . '" checked>' . $row
															. '</label>'
															;
														} else {
															echo ''
															. '<label class="btn btn-default" name="radiobutton_Ativo" id="radiobutton_Ativo' . $key . '">'
															. '<input type="radio" name="Ativo" id="radiobutton" '
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

							<br>
							<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) || ($_SESSION['log']['idSis_Empresa'] == 5))  { ?>
							<div class="form-group">
								<div class="row">
									<input type="hidden" name="idApp_Cliente" value="<?php echo $query['idApp_Cliente']; ?>">
									<?php if ($metodo == 2) { ?>

										<div class="col-md-6">
											<!--
											<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
												<span class="glyphicon glyphicon-save"></span> Salvar
											</button>
											-->
											<button type="submit" class="btn btn-lg btn-primary" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." value="1" >
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
														<p>Ao confirmar esta operação todos os dados serão excluídos permanentemente do sistema.
															Esta operação é irreversível.</p>
													</div>
													<div class="modal-footer">
														<div class="col-md-6 text-left">
															<button type="button" class="btn btn-warning" name="submeter4" id="submeter4" onclick="DesabilitaBotao()" data-dismiss="modal">
																<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
															</button>
														</div>
														<div class="col-md-6 text-right">
															<a class="btn btn-danger" name="submeter3" id="submeter3" onclick="DesabilitaBotaoExcluir(this.name)" href="<?php echo base_url() . 'cliente/excluir/' . $query['idApp_Cliente'] ?>" role="button">
																<span class="glyphicon glyphicon-trash"></span> Confirmar Exclusão
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
											<!--
											<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." name="submit" value="1" type="submit">
												<span class="glyphicon glyphicon-save"></span> Salvar
											</button>
											-->
											<button type="submit" class="btn btn-lg btn-primary" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." value="1" >
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
			</div>
	
		</div>
		<div class="col-md-2"></div>
	</div>	
</div>
