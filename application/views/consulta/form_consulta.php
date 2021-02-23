<?php if (isset($msg)) echo $msg; ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 ">
			<?php if ( !isset($evento) && $_SESSION['log']['idSis_Empresa'] != 5 && isset($_SESSION['Cliente']) && isset($alterarcliente) && $alterarcliente == 2) { ?>
				<?php if ($_SESSION['Cliente']['idApp_Cliente'] != 150001 && $_SESSION['Cliente']['idApp_Cliente'] != 1 && $_SESSION['Cliente']['idApp_Cliente'] != 0) { ?>
					<nav class="navbar navbar-inverse navbar-fixed" role="banner">
					  <div class="container-fluid">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span> 
							</button>
							<div class="navbar-form btn-group">
								<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
									<span class="glyphicon glyphicon-user"></span>
										<?php echo '<small>' . $_SESSION['Cliente']['NomeCliente'] . '</small> - <small>' . $_SESSION['Cliente']['idApp_Cliente'] . '</small>' ?> 
									<span class="caret"></span>
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
							<!--
							<a class="navbar-brand" href="<?php #echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
								<?php #echo '<small>' . $_SESSION['Cliente']['idApp_Cliente'] . '</small> - <small>' . $_SESSION['Cliente']['NomeCliente'] . '.</small>' ?> 
							</a>
							-->
						</div>
						<div class="collapse navbar-collapse" id="myNavbar">
							<ul class="nav navbar-nav navbar-center">
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
									<div class="btn-group">
										<button type="button" class="btn btn-md btn-warning  dropdown-toggle" data-toggle="dropdown">
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
												<a <?php if (preg_match("/consulta\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'consulta/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
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
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
									<div class="btn-group">
										<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-pencil"></span> SAC <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/procedimento\/listar_Sac\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
													<a href="<?php echo base_url() . 'procedimento/listar_Sac/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-pencil"></span> Lista de Chamadas
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/procedimento\/cadastrar_Sac\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'procedimento/cadastrar_Sac/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-plus"></span> Nova Chamada
													</a>
												</a>
											</li>
										</ul>
									</div>
								</li>
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
									<div class="btn-group">
										<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-pencil"></span> Marketing <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/procedimento\/listar_Marketing\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
													<a href="<?php echo base_url() . 'procedimento/listar_Marketing/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-pencil"></span> Lista de Campanhas
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/procedimento\/cadastrar_Marketing\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'procedimento/cadastrar_Marketing/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-plus"></span> Nova Campanha
													</a>
												</a>
											</li>
										</ul>
									</div>
								</li>	
							</ul>
						</div>
					  </div>
					</nav>
				<?php } ?>
			<?php } ?>			
	
			<div class="row">
				<div class="col-sm-offset-1 col-md-10 ">
				<?php #echo validation_errors(); ?>
					<div class="panel panel-<?php echo $panel; ?>">
						<div class="panel-heading">
							<?php echo $titulo; ?>
							<a class="btn btn-sm btn-info" href="<?php echo base_url() ?>agenda" role="button">
								<span class="glyphicon glyphicon-calendar"></span>Agenda
							</a>
						</div>
						<div class="panel-body">
							<div class="form-group">
								<div class="panel panel-info">
									<div class="panel-heading">
									<?php echo form_open_multipart($form_open_path); ?>
										<div class="row">
											<div class="col-md-4">
												<label for="idApp_Agenda">Profissional:*</label>
												<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?>
														id="idApp_Agenda" name="idApp_Agenda">
													<!--<option value="">-- Selecione um Profissional --</option>-->												
													<?php echo $select['option']; ?>
													<?php
													foreach ($select['idApp_Agenda'] as $key => $row) {
														if ($query['idApp_Agenda'] == $key) {
															echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
														} else {
															echo '<option value="' . $key . '">' . $row . '</option>';
														}
													}
													?>
												</select>
												<?php echo form_error('idApp_Agenda'); ?>
											</div>
											<?php if($alterarcliente == 1){?>	
												<div class="col-md-4">
													<div class="row">
														<div class="col-md-12 text-left">	
															<label  for="idApp_Cliente">Cliente:</label>
															<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?>
																	id="idApp_Cliente" name="idApp_Cliente">
																<option value="">-- Sel. Cliente --</option>
																<?php
																foreach ($select['idApp_Cliente'] as $key => $row) {
																	if ($query['idApp_Cliente'] == $key) {
																		echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																	} else {
																		echo '<option value="' . $key . '">' . $row . '</option>';
																	}
																}
																?>
															</select>
															<?php echo form_error('idApp_Cliente'); ?>
														</div>
													</div>	
													<div class="row">
														<div class="col-md-5 text-left">
															<label class="sr-only" for="Cadastrar">Cadastrar no BD</label>
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
																											
														<div class="col-md-7 text-left" id="Cadastrar" <?php echo $div['Cadastrar']; ?>>
															<a class="btn btn-md btn-info"   target="_blank" href="<?php echo base_url() ?>cliente2/cadastrar3/" role="button"> 
																<span class="glyphicon glyphicon-plus"></span>Cliente
															</a>
															
															<button class="btn btn-md btn-primary"  id="inputDb" data-loading-text="Aguarde..." type="submit">
																	<span class="glyphicon glyphicon-refresh"></span>Ref.
															</button>
															<?php echo form_error('Cadastrar'); ?>
														</div>
													</div>
												</div>
											<?php }elseif($alterarcliente == 2){?>	
												<div class="col-md-4">
													<label >Cliente</label>
													<input class="form-control"<?php echo $readonly; ?> readonly="" value="<?php echo $_SESSION['Cliente']['NomeCliente']; ?>">
												</div>	
											<?php } ?>
											<?php if($_SESSION['Empresa']['CadastrarDep'] == "S"){?>
												<div class="col-md-4 text-left">	
													<label  for="idApp_ClienteDep">Dependente:</label>
													<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?>
															id="idApp_ClienteDep" name="idApp_ClienteDep">
														<option value="">-- Sel. Dependente --</option>
														<?php
														foreach ($select['idApp_ClienteDep'] as $key => $row) {
															if ($query['idApp_ClienteDep'] == $key) {
																echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
															} else {
																echo '<option value="' . $key . '">' . $row . '</option>';
															}
														}
														?>
													</select>
													<?php echo form_error('idApp_ClienteDep'); ?>
												</div>
											<?php } ?>
											<?php if($_SESSION['Empresa']['CadastrarPet'] == "S"){?>
												<div class="col-md-4 text-left">	
													<label  for="idApp_ClientePet">Pet:</label>
													<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?>
															id="idApp_ClientePet" name="idApp_ClientePet">
														<option value="">-- Sel. Pet --</option>
														<?php
														foreach ($select['idApp_ClientePet'] as $key => $row) {
															if ($query['idApp_ClientePet'] == $key) {
																echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
															} else {
																echo '<option value="' . $key . '">' . $row . '</option>';
															}
														}
														?>
													</select>
													<?php echo form_error('idApp_ClientePet'); ?>
												</div>
											<?php } ?>
										</div>
										<div class="row">										
											<div class="col-md-12 form-group text-left">
												<label for="Obs">Obs:</label>
												<textarea class="form-control" id="Obs"
														  name="Obs"><?php echo $query['Obs']; ?></textarea>
											</div>
										</div>	
										<div class="form-group">
											<div class="row">		
												<div class="col-md-6">	
													<label for="Data">Data Início : </label>												
													<div class="input-group <?php echo $datepicker; ?>">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
														<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
															   name="Data" id="Data" value="<?php echo $query['Data']; ?>" onchange="dateTermina()" onkeyup="dateTermina()">
													</div>
													<?php echo form_error('Data'); ?>
												</div>	
												
												<div class="col-md-6">
													<label for="Hora">Dàs :</label>
													<!--<div class="input-group <?php echo $timepicker; ?>">-->
														<input type="text" class="form-control Time" <?php echo $readonly; ?> maxlength="5"  placeholder="HH:MM"
															   accept=""name="HoraInicio" value="<?php echo $query['HoraInicio']; ?>">
														<!--
														<span class="input-group-addon">
															<span class="glyphicon glyphicon-time"></span>
														</span>
														
													</div>-->
												<?php echo form_error('HoraInicio'); ?>
												</div>
											</div>
										</div>		
										<div class="form-group">
											<div class="row">		
												<div class="col-md-6">	
													<label for="Data2">Data Fim : </label>												
													<div class="input-group <?php echo $datepicker; ?>">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
														<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
															   name="Data2" id="Data2" value="<?php echo $query['Data2']; ?>">
													</div>
													<?php echo form_error('Data2'); ?>
												</div>
											
												<div class="col-md-6">		
													<label for="Hora">Às :</label>
													<!--<div class="input-group <?php echo $timepicker; ?>">-->
														<input type="text" class="form-control Time" <?php echo $readonly; ?> maxlength="5" placeholder="HH:MM"
															   accept=""name="HoraFim" value="<?php echo $query['HoraFim']; ?>">
														<!--
														<span class="input-group-addon">
															<span class="glyphicon glyphicon-time"></span>
														</span>
														
													</div>-->
													<?php echo form_error('HoraFim'); ?>
												</div>
												
											</div>
										</div>																						
										<div class="form-group">
											<div class="row">
												<div class="col-md-3 form-inline text-left">
													<label for="idTab_TipoConsulta">Tipo de Consulta:</label><br>
													<div class="form-group">
														<div class="btn-block" data-toggle="buttons">
															<?php
															foreach ($select['TipoConsulta'] as $key => $row) {
																(!$query['idTab_TipoConsulta']) ? $query['idTab_TipoConsulta'] = '1' : FALSE;

																if ($query['idTab_TipoConsulta'] == $key) {
																	echo ''
																	. '<label class="btn btn-warning active" name="radio_idTab_TipoConsulta" id="radiogeral' . $key . '">'
																	. '<input type="radio" name="idTab_TipoConsulta" id="radiogeral" '
																	. 'autocomplete="off" value="' . $key . '" checked>' . $row
																	. '</label>'
																	;
																} else {
																	echo ''
																	. '<label class="btn btn-default" name="radio_idTab_TipoConsulta" id="radiogeral' . $key . '">'
																	. '<input type="radio" name="idTab_TipoConsulta" id="radiogeral" '
																		. 'autocomplete="off" value="' . $key . '" >' . $row
																	. '</label>'
																	;
																}
															}
															?>
														</div>
													</div>
												</div>		
												<div class="col-md-9 form-inline text-left">
													<label for="idTab_Status">Status:</label><br>
													<div class="form-group">
														<div class="btn-block" data-toggle="buttons">
															<?php
															foreach ($select['Status'] as $key => $row) {
																if (!$query['idTab_Status'])
																	$query['idTab_Status'] = 1;

																if ($query['idTab_Status'] == $key) {
																	echo ''
																	. '<label class="btn btn-' . $this->basico->tipo_status_cor($key) . ' active" name="radio" id="radio' . $key . '">'
																	. '<input type="radio" name="idTab_Status" id="radio" '
																		. 'autocomplete="off" value="' . $key . '" checked>' . $row
																	. '</label>'
																	;
																} else {
																	echo ''
																	. '<label class="btn btn-default" name="radio" id="radio' . $key . '">'
																	. '<input type="radio" name="idTab_Status" id="radio" class="idTab_Status" '
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
										<?php if ($metodo == 1) { ?>
											<div class="form-group col-md-12">
												<div class="row text-left">
													<div class="col-md-3 ">
														<label for="Repetir">Repetir Agendamento?</label><br>
														<div class="btn-group" data-toggle="buttons">
															<?php
															foreach ($select['Repetir'] as $key => $row) {
																if (!$cadastrar['Repetir']) $cadastrar['Repetir'] = 'N';

																($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																if ($cadastrar['Repetir'] == $key) {
																	echo ''
																	. '<label class="btn btn-warning active" name="Repetir_' . $hideshow . '">'
																	. '<input type="radio" name="Repetir" id="' . $hideshow . '" '
																	. 'onchange="dateTermina()" '
																	. 'autocomplete="off" value="' . $key . '" checked>' . $row
																	. '</label>'
																	;
																} else {
																	echo ''
																	. '<label class="btn btn-default" name="Repetir_' . $hideshow . '">'
																	. '<input type="radio" name="Repetir" id="' . $hideshow . '" '
																	. 'onchange="dateTermina()" '
																	. 'autocomplete="off" value="' . $key . '" >' . $row
																	. '</label>'
																	;
																}
															}
															?>

														</div>
													</div>
													<div class="col-md-9 text-left" id="Repetir" <?php echo $div['Repetir']; ?>>
														<div class="row">	
															<div class="col-md-3">
																<label for="Intervalo">Repetir a cada:</label><br>
																<input type="text" class="form-control Numero" id="Intervalo" maxlength="3" placeholder="Ex: '5' dias."
																	   name="Intervalo" onkeyup="dateTermina()" value="<?php echo $query['Intervalo'] ?>">
																<?php echo form_error('Intervalo'); ?>		
															</div>
															<div class="col-md-3 ">
																<label for="Tempo">.</label>
																<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
																		id="Tempo" name="Tempo" onchange="dateTermina()">
																	<!--<option value="">-- Selecione uma opção --</option>-->
																	<?php
																	foreach ($select['Tempo'] as $key => $row) {
																		if ($query['Tempo'] == $key) {
																			echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																		} else {
																			echo '<option value="' . $key . '">' . $row . '</option>';
																		}
																	}
																	?>
																</select>
															</div>
															<div class="col-md-4">	
																<label for="DataMinima">Primeira Repeticao: </label>												
																<div class="input-group <?php echo $datepicker; ?>">
																	<span class="input-group-addon" disabled>
																		<span class="glyphicon glyphicon-calendar"></span>
																	</span>
																	<input type="text" class="form-control Date" readonly="" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																		   name="DataMinima" id="DataMinima" value="<?php echo $cadastrar['DataMinima']; ?>" >
																</div>
																<?php echo form_error('DataMinima'); ?>	
															</div>
														</div>	
														<div class="row">	
															<div class="col-md-3">
																<label for="Periodo">Durante:</label><br>
																<input type="text" class="form-control Numero" id="Periodo" maxlength="3" placeholder="Ex: '30' dias."
																	   name="Periodo" value="<?php echo $query['Periodo'] ?>" onkeyup="dateTermina()">
																<?php echo form_error('Periodo'); ?>		
															</div>
															<div class="col-md-3 ">
																<label for="Tempo2">.</label>
																<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
																		id="Tempo2" name="Tempo2" onchange="dateTermina()">
																	<!--<option value="">-- Selecione uma opção --</option>-->
																	<?php
																	foreach ($select['Tempo'] as $key => $row) {
																		if ($query['Tempo2'] == $key) {
																			echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																		} else {
																			echo '<option value="' . $key . '">' . $row . '</option>';
																		}
																	}
																	?>
																</select>
															</div>
															
															<div class="col-md-4">	
																<label for="DataTermino">Termina em: </label>												
																<div class="input-group <?php echo $datepicker; ?>">
																	<span class="input-group-addon" disabled>
																		<span class="glyphicon glyphicon-calendar"></span>
																	</span>
																	<input type="text" class="form-control Date" readonly="" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																		   name="DataTermino" id="DataTermino" value="<?php echo $query['DataTermino']; ?>" >
																</div>
																<?php echo form_error('DataTermino'); ?>	
															</div>
															
														</div>	
														<div class="row">
															<div class="col-md-3">	
																<label for="Recorrencias">Ocorrências: </label>												
																<div class="input-group">
																	<input type="text" class="form-control" 
																		   name="Recorrencias" id="Recorrencias" value="<?php echo $query['Recorrencias']; ?>" >
																</div>
																<?php echo form_error('Recorrencias'); ?>	
															</div>
														</div>	
														<?php echo form_error('Repetir'); ?>
													</div>
												</div>
											</div>
										<?php } else { ?>
											<div class="form-group col-md-12">
												<div class="row text-left">	
													<div class="col-md-2">
														<label>Ocorrência</label>
														<input class="form-control"<?php echo $readonly; ?> readonly="" value="<?php echo $_SESSION['Consulta']['Recorrencias']; ?>">
													</div>	
													<div class="col-md-3">
														<label>Termina em</label>
														<input class="form-control"<?php echo $readonly; ?> readonly="" value="<?php echo $_SESSION['Consulta']['DataTermino']; ?>">
													</div>
													<div class="col-md-4 ">
														<label for="Quais">Alterar Quais?</label>
														<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
																id="Quais" name="Quais">
															<!--<option value="">-- Selecione uma opção --</option>-->
															<?php
															foreach ($select['Quais'] as $key => $row) {
																if ($alterar['Quais'] == $key) {
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
										<?php } ?>
										<div class="form-group">
											<div class="row">
												<input type="hidden" name="idApp_Consulta" value="<?php echo $query['idApp_Consulta']; ?>">
												<?php if ($alterarcliente == 2) { ?>
													<input type="hidden" name="idApp_Cliente" id="idApp_Cliente" value="<?php echo $query['idApp_Cliente']; ?>">
												<?php } ?>
												<!--
												<input type="hidden" name="Evento" value="1">
												-->
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
													<!--
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
																		<button type="button" class="btn btn-warning" data-dismiss="modal">
																			<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
																		</button>
																	</div>
																	<div class="col-md-6 text-right">
																		<a class="btn btn-danger" href="<?php #echo base_url() . 'consulta/excluir/' . $query['idApp_Consulta'] ?>" role="button">
																			<span class="glyphicon glyphicon-trash"></span> Confirmar Exclusão
																		</a>
																	</div>
																</div>
															</div>
														</div>
													</div>
													-->
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
						</div>
					</div>
				</div>	
			</div>
		</div>	
	</div>
</div>
<?php if ($metodo == 2) { ?>
<div class="modal fade bs-excluir-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog" role="document">
		<form method="POST" action="../../excluir/<?php echo $query['idApp_Consulta'];?>">
			<div class="modal-content">
				<div class="modal-header bg-danger">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Tem certeza que deseja excluir?</h4>
				</div>
				<div class="modal-body">
					<p>Ao confirmar esta operação os dados serão excluídos permanentemente do sistema.
						Esta operação é irreversível.</p>
				</div>
				<div class="modal-footer">
					<div class="row text-left">	
						<div class="col-md-3">
							<label>Ocorrência</label>
							<input class="form-control"<?php echo $readonly; ?> readonly="" value="<?php echo $_SESSION['Consulta']['Recorrencias']; ?>">
						</div>	
						<div class="col-md-4">
							<label>Termina em</label>
							<input class="form-control"<?php echo $readonly; ?> readonly="" value="<?php echo $_SESSION['Consulta']['DataTermino']; ?>">
						</div>
						<div class="col-md-5 text-left">
							<label for="Quais">Excluir Quais?</label>
							<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
									id="Quais" name="Quais">
								<!--<option value="">-- Selecione uma opção --</option>-->
								<?php
								foreach ($select['Quais'] as $key => $row) {
									if ($alterar['Quais'] == $key) {
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
						<div class="col-md-6 text-left">
							<label ></label><br>
							<button type="button" class="btn btn-warning" data-dismiss="modal">
								<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
							</button>
						</div>
						<div class="col-md-6">
							<label ></label><br>
							<button class="btn btn-md btn-danger" id="inputDb" data-loading-text="Aguarde..." type="submit">
								<span class="glyphicon glyphicon-trash"></span> Excluir
							</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<?php } ?>