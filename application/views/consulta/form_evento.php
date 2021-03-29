<?php if (isset($msg)) echo $msg; ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<?php #echo validation_errors(); ?>
			<div class="panel panel-<?php echo $panel; ?>">
				<div class="panel-heading">
					<?php echo $titulo; ?>
					<a class="btn btn-sm btn-info" href="<?php echo base_url() ?>agenda" role="button">
						<span class="glyphicon glyphicon-calendar"></span>Agenda
					</a>
				</div>
				<div class="panel-body">
					<div class="panel panel-info">
						<div class="panel-heading">
						<?php echo form_open_multipart($form_open_path); ?>
							
							<div class="row">
								<div class="col-md-4">
									<label class="sr-only" for="idApp_Agenda">Agenda do Profis.:*</label>
									<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" <?php echo $readonly; ?>
											id="idApp_Agenda" name="idApp_Agenda">
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
							</div>
							<br>
							<div class="row">	
								<div class="col-md-4 text-left">
									<div class="panel panel-warning">
										<div class="panel-heading">
											<div class="row">
												<div class="col-md-12 text-left">
													<label for="Obs">Evento:</label>
													<textarea class="form-control" id="Obs"
															  name="Obs"><?php echo $query['Obs']; ?></textarea>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">	
													<label for="Data">Data In�cio : </label>												
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
													<label for="Hora">D�s :</label>
													<div class="input-group <?php echo $timepicker; ?>">
														<span class="input-group-addon">
															<span class="glyphicon glyphicon-time"></span>
														</span>
														<input type="text" class="form-control Time" <?php echo $readonly; ?> maxlength="5"  placeholder="HH:MM"
															   accept=""name="HoraInicio" value="<?php echo $query['HoraInicio']; ?>">
													</div>
													<?php echo form_error('HoraInicio'); ?>
												</div>
											</div>
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
													<label for="Hora">�s :</label>
													<div class="input-group <?php echo $timepicker; ?>">
														<span class="input-group-addon">
															<span class="glyphicon glyphicon-time"></span>
														</span>
														<input type="text" class="form-control Time" <?php echo $readonly; ?> maxlength="5" placeholder="HH:MM"
															   accept=""name="HoraFim" value="<?php echo $query['HoraFim']; ?>">
													</div>
												<?php echo form_error('HoraFim'); ?>
												</div>
											</div>
										</div>
									</div>
								</div>
								<?php if ($metodo == 1) { ?>
									<div class="col-md-4 text-left">
										<div class="panel panel-warning">
											<div class="panel-heading">
												<div class="row text-left">
													<div class="col-md-8 ">
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
																	. 'onchange="ocorrencias(this.value)" '
																	. 'autocomplete="off" value="' . $key . '" checked>' . $row
																	. '</label>'
																	;
																} else {
																	echo ''
																	. '<label class="btn btn-default" name="Repetir_' . $hideshow . '">'
																	. '<input type="radio" name="Repetir" id="' . $hideshow . '" '
																	. 'onchange="ocorrencias(this.value)" '
																	. 'autocomplete="off" value="' . $key . '" >' . $row
																	. '</label>'
																	;
																}
															}
															?>

														</div>
													</div>
													<div class="col-md-4">	
														<label for="Recorrencias">Ocorr�ncias: </label>
															<input type="text" class="form-control" name="Recorrencias" id="Recorrencias" value="<?php echo $query['Recorrencias']; ?>" onkeyup="ocorrencias()">
														<?php echo form_error('Recorrencias'); ?>	
													</div>
												</div>	
												<div class="row text-left">	
													<div class="col-md-12 text-left" id="Repetir" <?php echo $div['Repetir']; ?>>
														<br>
														<div class="row">	
															<div class="col-md-4">
																<label for="Intervalo">Repetir a cada:</label><br>
																<input type="text" class="form-control Numero" id="Intervalo" maxlength="3" placeholder="Ex: '5' dias."
																	   name="Intervalo" onkeyup="ocorrencias()" value="<?php echo $query['Intervalo'] ?>">
																<?php echo form_error('Intervalo'); ?>		
															</div>
															<div class="col-md-4 ">
																<label for="Tempo">Per�odo</label>
																<select data-placeholder="Selecione uma op��o..." class="form-control" <?php echo $readonly; ?>
																		id="Tempo" name="Tempo" onchange="ocorrencias()">
																	<!--<option value="">-- Selecione uma op��o --</option>-->
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
																<label for="DataMinima">Pr�xima: </label>
																	<input type="text" class="form-control Date" readonly="" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																		   name="DataMinima" id="DataMinima" value="<?php echo $cadastrar['DataMinima']; ?>" >
																<?php echo form_error('DataMinima'); ?>	
															</div>
														</div>	
														<div class="row">	
															<div class="col-md-4">
																<label for="Periodo">Durante:</label><br>
																<input type="text" class="form-control Numero" id="Periodo" maxlength="3" placeholder="Ex: '30' dias."
																	   name="Periodo" value="<?php echo $query['Periodo'] ?>" onkeyup="dateTermina()">
																<?php echo form_error('Periodo'); ?>		
															</div>
															<div class="col-md-4 ">
																<label for="Tempo2">Per�odo</label>
																<select data-placeholder="Selecione uma op��o..." class="form-control" <?php echo $readonly; ?>
																		id="Tempo2" name="Tempo2" onchange="dateTermina()">
																	<!--<option value="">-- Selecione uma op��o --</option>-->
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
																<label for="DataTermino">�ltima: </label>
																	<input type="text" class="form-control Date" readonly="" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																		   name="DataTermino" id="DataTermino" value="<?php echo $query['DataTermino']; ?>" >
																<?php echo form_error('DataTermino'); ?>	
															</div>
														</div>
														<?php echo form_error('Repetir'); ?>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php } else { ?>
									<div class="col-md-4">
										<div class="panel panel-warning">
											<div class="panel-heading">
												<div class="row text-left">	
													<div class="col-md-4">
														<label>Ocorr�ncia</label>
														<input class="form-control"<?php echo $readonly; ?> readonly="" value="<?php echo $_SESSION['Consulta']['Recorrencia']; ?>">
													</div>	
													<div class="col-md-4">
														<label>Termina em</label>
														<input class="form-control"<?php echo $readonly; ?> readonly="" value="<?php echo $_SESSION['Consulta']['DataTermino']; ?>">
													</div>
													<div class="col-md-4 ">
														<label for="Quais">Alterar Quais?</label>
														<select data-placeholder="Selecione uma op��o..." class="form-control" <?php echo $readonly; ?>
																id="Quais" name="Quais">
															<!--<option value="">-- Selecione uma op��o --</option>-->
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
										</div>
									</div>
								<?php } ?>									
								<div class="col-md-4 text-left">
									<div class="panel panel-warning">
										<div class="panel-heading">
											<div class="row">
												<div class="col-md-12 text-left">
													<label for="idTab_Status">Status:</label><br>
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
								</div>
							</div>

							<div class="row">
								<input type="hidden" name="idApp_Consulta" value="<?php echo $query['idApp_Consulta']; ?>">
								<!--<input type="hidden" name="idApp_Agenda" value="<?php echo $_SESSION['log']['Agenda']; ?>">-->
								<input type="hidden" name="Evento" value="1">
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
											<form method="POST" action="">
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
															<a class="btn btn-danger" href="<?php echo base_url() . 'consulta/excluir/' . $query['idApp_Consulta'] . '?repeticao=' . $query['Repeticao'] . '&quais=' . $alterar['Quais'] . '&dataini=' . $query['Data']  ?>" role="button">
																<span class="glyphicon glyphicon-trash"></span> Confirmar Exclus�o
															</a>
														</div>
														
													</div>
												</div>
											</form>
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
						
							
							</form>
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
		<form method="POST" action="../excluir/<?php echo $query['idApp_Consulta'];?>">
			<div class="modal-content">
				<div class="modal-header bg-danger">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Tem certeza que deseja excluir?</h4>
				</div>
				<div class="modal-body">
					<p>Ao confirmar esta opera��o os dados ser�o exclu�dos permanentemente do sistema.
						Esta opera��o � irrevers�vel.</p>
				</div>
				<div class="modal-footer">
					<div class="row text-left">	
						<div class="col-md-3">
							<label>Ocorr�ncia</label>
							<input class="form-control"<?php echo $readonly; ?> readonly="" value="<?php echo $_SESSION['Consulta']['Recorrencia']; ?>">
						</div>	
						<div class="col-md-4">
							<label>Termina em</label>
							<input class="form-control"<?php echo $readonly; ?> readonly="" value="<?php echo $_SESSION['Consulta']['DataTermino']; ?>">
						</div>
						<div class="col-md-5 text-left">
							<label for="Quais">Excluir Quais?</label>
							<select data-placeholder="Selecione uma op��o..." class="form-control" <?php echo $readonly; ?>
									id="Quais" name="Quais">
								<!--<option value="">-- Selecione uma op��o --</option>-->
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