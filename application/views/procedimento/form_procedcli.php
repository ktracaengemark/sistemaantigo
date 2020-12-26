<?php if (isset($msg)) echo $msg; ?>

<div class="container-fluid">
	<div class="row">
		
		<div class="col-md-1"></div>
		<div class="col-md-10 ">
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
									<li role="separator" class="divider"></li>
									<li>
										<a <?php if (preg_match("/cliente\/alterarlogo\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
											<a href="<?php echo base_url() . 'cliente/alterarlogo/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
												<span class="glyphicon glyphicon-edit"></span> Alterar Foto
											</a>
										</a>
									</li>											
								</ul>
							</div>
							<!--
							<a class="navbar-brand" href="<?php #echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
								<?php #echo '<small>' . $_SESSION['Cliente']['idApp_Cliente'] . '</small> - <small>' . $_SESSION['Cliente']['NomeCliente'] . '</small>' ?> 
							</a>
							-->
						</div>
						<div class="collapse navbar-collapse" id="myNavbar">
							<ul class="nav navbar-nav navbar-center">
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
											<span class="glyphicon glyphicon-usd"></span> Or�s. <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/orcatrata\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
													<a href="<?php echo base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-usd"></span> Lista de Or�amentos
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/orcatrata\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'orcatrata/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-plus"></span> Novo Or�amento
													</a>
												</a>
											</li>
										</ul>
									</div>
								</li>
								<?php } ?>
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
									<div class="btn-group">
										<button type="button" class="btn btn-md btn-<?php echo $botao_sac;?>  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-pencil"></span> SAC <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/procedimento\/listarproc\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
													<a href="<?php echo base_url() . 'procedimento/listarproc/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-pencil"></span> Lista de Chamadas
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/procedimento\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'procedimento/cadastrarproc/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-plus"></span> Nova Chamada
													</a>
												</a>
											</li>
										</ul>
									</div>
								</li>
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
									<div class="btn-group">
										<button type="button" class="btn btn-md btn-<?php echo $botao_mark;?>  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-pencil"></span> Marketing <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/procedimento\/listarcampanha\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
													<a href="<?php echo base_url() . 'procedimento/listarcampanha/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-pencil"></span> Lista de Campanhas
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/procedimento\/campanha\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'procedimento/campanha/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
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

				<div class="col-md-12 col-lg-12">
					<?php echo validation_errors(); ?>

					<div class="panel panel-<?php echo $panel; ?>">

						<div class="panel-heading"><strong><?php echo $titulo; ?> </strong><?php echo $_SESSION['Cliente']['NomeCliente']; ?> - <?php echo $_SESSION['Cliente']['idApp_Cliente']; ?></div>
						<div class="panel-body">

							<?php echo form_open_multipart($form_open_path); ?>
							<!--App_Procedimento-->
							<div class="panel-group">	
								<div class="panel panel-success">
									<div class="panel-heading">
										<div class="row text-left">
												
												<?php if($metodo == 1 || $metodo == 2) { ?>
														
														<div class="col-md-3 " >
															<label for="Sac">Sac: <?php echo $orcatrata['idApp_Procedimento']; ?></label>
															<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block" id="Sac" name="Sac">
																<option value="">- Selec. Sac -</option>	
																<?php
																foreach ($select['Sac'] as $key => $row) {
																	if ($orcatrata['Sac'] == $key) {
																		echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																	} else {
																		echo '<option value="' . $key . '">' . $row . '</option>';
																	}
																}
																?>
															</select>
															<?php echo form_error('Sac'); ?>
														</div>
														
												<?php } elseif($metodo == 3 || $metodo == 4) { ?>	
														
														<div class="col-md-3 " >
															<label for="Campanha">Marketing: <?php echo $orcatrata['idApp_Procedimento']; ?></label>
															<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block" id="Campanha" name="Campanha">
																<option value="">- Selec. Campanha -</option>	
																<?php
																foreach ($select['Campanha'] as $key => $row) {
																	if ($orcatrata['Campanha'] == $key) {
																		echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																	} else {
																		echo '<option value="' . $key . '">' . $row . '</option>';
																	}
																}
																?>
															</select>
															<?php echo form_error('Campanha'); ?>
														</div>
														
												<?php } ?>
												
												
											
											<div class="col-md-6">
												<label for="Procedimento">Procedimento:</label>
												<textarea class="form-control" id="Procedimento" <?php echo $readonly; ?> readonly="" name="Procedimento"><?php echo $orcatrata['Procedimento']; ?></textarea>
												<?php echo form_error('Procedimento'); ?>		  
											</div>
										</div>	
										<div class="row">		
											<div class="col-md-3">
												<label for="DataProcedimento">Cadastrado em:</label>
												<div class="input-group <?php echo $datepicker; ?>">
													<span class="input-group-addon" disabled>
														<span class="glyphicon glyphicon-calendar"></span>
													</span>
													<input type="text" class="form-control Date" <?php echo $readonly; ?> readonly=""
															name="DataProcedimento" id="DataProcedimento" value="<?php echo $orcatrata['DataProcedimento']; ?>">
												</div>
											</div>		
											<div class="col-md-2">
												<label for="HoraProcedimento">�S:</label>
												<div class="input-group <?php echo $timepicker; ?>">
													<span class="input-group-addon" disabled>
														<span class="glyphicon glyphicon-time"></span>
													</span>
													<input type="text" class="form-control Time" <?php echo $readonly; ?> readonly=""
															name="HoraProcedimento" id="HoraProcedimento" value="<?php echo $orcatrata['HoraProcedimento']; ?>">
												</div>
											</div>
											<div class="col-md-2 text-left">
												<label for="ConcluidoProcedimento">Conclu�do?</label><br>
												<div class="btn-group" data-toggle="buttons">
													<?php
													foreach ($select['ConcluidoProcedimento'] as $key => $row) {
														if (!$orcatrata['ConcluidoProcedimento'])$orcatrata['ConcluidoProcedimento'] = 'N';

														($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

														if ($orcatrata['ConcluidoProcedimento'] == $key) {
															echo ''
															. '<label class="btn btn-warning active" name="ConcluidoProcedimento_' . $hideshow . '">'
															. '<input type="radio" name="ConcluidoProcedimento" id="' . $hideshow . '" '
															. 'onchange="carregaConcluido(this.value,this.name,0)" '
															. 'autocomplete="off" value="' . $key . '" checked>' . $row
															. '</label>'
															;
														} else {
															echo ''
															. '<label class="btn btn-default" name="ConcluidoProcedimento_' . $hideshow . '">'
															. '<input type="radio" name="ConcluidoProcedimento" id="' . $hideshow . '" '
															. 'onchange="carregaConcluido(this.value,this.name,0)" '
															. 'autocomplete="off" value="' . $key . '" >' . $row
															. '</label>'
															;
														}
													}
													?>
												</div>
											</div>
											<div id="ConcluidoProcedimento" <?php echo $div['ConcluidoProcedimento']; ?>>
												<div class="col-md-3">
													<label for="DataProcedimentoLimite">Conclu�do em:</label>
													<div class="input-group <?php echo $datepicker; ?>">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
														<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA" readonly=""
																name="DataProcedimentoLimite" id="DataProcedimentoLimite" value="<?php echo $orcatrata['DataProcedimentoLimite']; ?>">
													</div>
													<?php echo form_error('DataProcedimentoLimite'); ?>
												</div>		
												<div class="col-md-2">
													<label for="HoraProcedimentoLimite">�S:</label>
													<div class="input-group <?php echo $timepicker; ?>">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-time"></span>
														</span>
														<input type="text" class="form-control Time" <?php echo $readonly; ?> readonly=""
																name="HoraProcedimentoLimite" id="HoraProcedimentoLimite" value="<?php echo $orcatrata['HoraProcedimentoLimite']; ?>">
													</div>
												</div>
											</div>
										</div>	
										
									</div>
								</div>
							</div>
					
							<div class="panel-group" id="accordion3" role="tablist" aria-multiselectable="true">
								<div class="panel panel-primary">
									 <div class="panel-heading" role="tab" id="heading3" data-toggle="collapse" data-parent="#accordion3" data-target="#collapse3">
										<h4 class="panel-title">
											<a class="accordion-toggle">
												<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
												A��es
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

											<?php if ($metodo == 2 || $metodo == 4) { ?>
											<input type="hidden" name="idApp_SubProcedimento<?php echo $i ?>" value="<?php echo $procedtarefa[$i]['idApp_SubProcedimento']; ?>"/>
											<?php } ?>

											<div class="form-group" id="3div<?php echo $i ?>">
												<div class="panel panel-info">
													<div class="panel-heading">			
														<div class="row">																					
															<!--
															<div class="col-md-3">
																<label for="Profissional<?php echo $i ?>">Profissional:</label>
																<?php if ($i == 1) { ?>
																<?php } ?>
																<select data-placeholder="Selecione uma op��o..." class="form-control"
																		 id="listadinamicac<?php echo $i ?>" name="Profissional<?php echo $i ?>">
																	<option value="">-- Selecione uma op��o --</option>
																	<?php
																	foreach ($select['Profissional'] as $key => $row) {
																		if ($procedtarefa[$i]['Profissional'] == $key) {
																			echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																		} else {
																			echo '<option value="' . $key . '">' . $row . '</option>';
																		}
																	}
																	?>
																</select>
															</div>
															-->
															<div class="col-md-6">
																<label for="SubProcedimento<?php echo $i ?>">A��o:</label>
																<textarea class="form-control" id="SubProcedimento<?php echo $i ?>" <?php echo $readonly; ?> readonly=""
																		  name="SubProcedimento<?php echo $i ?>"><?php echo $procedtarefa[$i]['SubProcedimento']; ?></textarea>
															</div>
														</div>	
														<div class="row">	
															<!--
															<div class="col-md-2">
																<label for="Prioridade<?php echo $i ?>">Prioridade:</label>
																<?php if ($i == 1) { ?>
																<?php } ?>
																<select data-placeholder="Selecione uma op��o..." class="form-control" 
																		 id="listadinamicad<?php echo $i ?>" name="Prioridade<?php echo $i ?>">
																	
																	<?php
																	foreach ($select['Prioridade'] as $key => $row) {
																		if ($procedtarefa[$i]['Prioridade'] == $key) {
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
																<label for="DataSubProcedimento<?php echo $i ?>">Cadastrado em:</label>
																<div class="input-group <?php echo $datepicker; ?>">
																	<span class="input-group-addon" disabled>
																		<span class="glyphicon glyphicon-calendar"></span>
																	</span>															
																	<input type="text" class="form-control Date" <?php echo $readonly; ?> readonly=""
																		   name="DataSubProcedimento<?php echo $i ?>" value="<?php echo $procedtarefa[$i]['DataSubProcedimento']; ?>">
																</div>
															</div>
															<div class="col-md-2">
																<label for="HoraSubProcedimento<?php echo $i ?>">�s</label>
																<div class="input-group <?php echo $timepicker; ?>">
																	<span class="input-group-addon" disabled>
																		<span class="glyphicon glyphicon-time"></span>
																	</span>
																	<input type="text" class="form-control Time" <?php echo $readonly; ?> readonly="" maxlength="5" placeholder="HH:MM"
																		   name="HoraSubProcedimento<?php echo $i ?>" id="HoraSubProcedimento<?php echo $i ?>" value="<?php echo $procedtarefa[$i]['HoraSubProcedimento']; ?>">
																</div>
															</div>
															<div class="col-md-2">
																<label for="ConcluidoSubProcedimento">Conclu�do? </label><br>
																<div class="form-group">
																	<div class="btn-group" data-toggle="buttons">
																		<?php
																		/*
																		foreach ($select['ConcluidoSubProcedimento'] as $key => $row) {
																			(!$procedtarefa[$i]['ConcluidoSubProcedimento']) ? $procedtarefa[$i]['ConcluidoSubProcedimento'] = 'N' : FALSE;

																			if ($procedtarefa[$i]['ConcluidoSubProcedimento'] == $key) {
																				echo ''
																				. '<label class="btn btn-warning active" name="radiobutton_ConcluidoSubProcedimento' . $i . '" id="radiobutton_ConcluidoSubProcedimento' . $i .  $key . '">'
																				. '<input type="radio" name="ConcluidoSubProcedimento' . $i . '" id="radiobuttondinamico" '
																				. 'autocomplete="off" value="' . $key . '" checked>' . $row
																				. '</label>'
																				;
																			} else {
																				echo ''
																				. '<label class="btn btn-default" name="radiobutton_ConcluidoSubProcedimento' . $i . '" id="radiobutton_ConcluidoSubProcedimento' . $i .  $key . '">'
																				. '<input type="radio" name="ConcluidoSubProcedimento' . $i . '" id="radiobuttondinamico" '
																				. 'autocomplete="off" value="' . $key . '" >' . $row
																				. '</label>'
																				;
																			}
																		}
																		*/
																		foreach ($select['ConcluidoSubProcedimento'] as $key => $row) {
																			if (!$procedtarefa[$i]['ConcluidoSubProcedimento'])$procedtarefa[$i]['ConcluidoSubProcedimento'] = 'N';
																			($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																			if ($procedtarefa[$i]['ConcluidoSubProcedimento'] == $key) {
																				echo ''
																				. '<label class="btn btn-warning active" name="ConcluidoSubProcedimento' . $i . '_' . $hideshow . '">'
																				. '<input type="radio" name="ConcluidoSubProcedimento' . $i . '" id="' . $hideshow . '" '
																				. 'onchange="carregaConclSubProc(this.value,this.name,'.$i.',0)" '
																				. 'autocomplete="off" value="' . $key . '" checked>' . $row
																				. '</label>'
																				;
																			} else {
																				echo ''
																				. '<label class="btn btn-default" name="ConcluidoSubProcedimento' . $i . '_' . $hideshow . '">'
																				. '<input type="radio" name="ConcluidoSubProcedimento' . $i . '" id="' . $hideshow . '" '
																				. 'onchange="carregaConclSubProc(this.value,this.name,'.$i.',0)" '
																				. 'autocomplete="off" value="' . $key . '" >' . $row
																				. '</label>'
																				;
																			}
																		}
																		?>
																	</div>
																</div>
															</div>
															<div class="col-md-4">
																<div id="ConcluidoSubProcedimento<?php echo $i ?>" <?php echo $div['ConcluidoSubProcedimento' . $i]; ?>>
																	<div class="row">	
																		<div class="col-md-6">
																			<label for="DataSubProcedimentoLimite<?php echo $i ?>">Data Concl</label>
																			<div class="input-group <?php echo $datepicker; ?>">
																				<span class="input-group-addon" disabled>
																					<span class="glyphicon glyphicon-calendar"></span>
																				</span>
																				<input type="text" class="form-control Date" <?php echo $readonly; ?> readonly="" maxlength="10" placeholder="DD/MM/AAAA"
																					   name="DataSubProcedimentoLimite<?php echo $i ?>" id="DataSubProcedimentoLimite<?php echo $i ?>" value="<?php echo $procedtarefa[$i]['DataSubProcedimentoLimite']; ?>">
																			</div>
																		</div>
																		<div class="col-md-6">
																			<label for="HoraSubProcedimentoLimite<?php echo $i ?>">Hora Concl</label>
																			<div class="input-group <?php echo $timepicker; ?>">
																				<span class="input-group-addon" disabled>
																					<span class="glyphicon glyphicon-time"></span>
																				</span>
																				<input type="text" class="form-control Time" <?php echo $readonly; ?> readonly="" maxlength="5" placeholder="HH:MM"
																					   name="HoraSubProcedimentoLimite<?php echo $i ?>" id="HoraSubProcedimentoLimite<?php echo $i ?>" value="<?php echo $procedtarefa[$i]['HoraSubProcedimentoLimite']; ?>">
																			</div>
																		</div>
																	</div>
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

											<div class="row">
												<div class="col-md-4">
													<a class="btn btn-xs btn-warning" onclick="adicionaSubProcedimento()">
														<span class="glyphicon glyphicon-plus"></span> Adicionar A��o
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<div class="row">
									<input type="hidden" name="idApp_Cliente" value="<?php echo $_SESSION['Cliente']['idApp_Cliente']; ?>">
									<input type="hidden" name="idApp_Procedimento" value="<?php echo $orcatrata['idApp_Procedimento']; ?>">
									<?php if ($metodo > 1) { ?>
									<!--<input type="hidden" name="idApp_Procedimento" value="<?php echo $procedimento['idApp_Procedimento']; ?>">
									<input type="hidden" name="idApp_ParcelasRec" value="<?php echo $parcelasrec['idApp_ParcelasRec']; ?>">-->
									<?php } ?>
									<?php if ($metodo == 2 || $metodo == 4) { ?>
									
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
															<a class="btn btn-danger" href="<?php echo base_url() . 'procedimento/excluirproc/' . $orcatrata['idApp_Procedimento'] ?>" role="button">
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

			</div>

		</div>
		<div class="col-md-1"></div>
	</div>
</div>
