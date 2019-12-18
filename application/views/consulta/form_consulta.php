<?php if (isset($msg)) echo $msg; ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-offset-3 col-md-6">

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
								<div class="form-group">
									<div class="row">
										<div class="col-md-6">
											<label for="idApp_Agenda">Profissional:*</label>
											<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" <?php echo $readonly; ?>
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
										<div class="col-md-6">
											<div class="row">
												<div class="col-md-12 text-left">	
													<label  for="idApp_Cliente">Cliente:</label>
													<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" <?php echo $readonly; ?>
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
													<a class="btn btn-md btn-info"   target="_blank" href="<?php echo base_url() ?>cliente/cadastrar3/" role="button"> 
														<span class="glyphicon glyphicon-plus"></span>Cliente
													</a>
													
													<button class="btn btn-md btn-primary"  id="inputDb" data-loading-text="Aguarde..." type="submit">
															<span class="glyphicon glyphicon-refresh"></span>Ref.
													</button>
													<?php echo form_error('Cadastrar'); ?>
												</div>
											</div>
										</div>										
										<!--
										<div class="col-md-6">
											<label for="idApp_Cliente">Cliente:*</label>
											<a class="btn btn-xs btn-info" target="_blank" href="<?php echo base_url() ?>cliente/cadastrar3" role="button">
												<span class="glyphicon glyphicon-plus"></span> <b>Cliente</b>
											</a>
											<button class="btn btn-xs btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
												<span class="glyphicon glyphicon-refresh"></span> Recarregar
											</button>
											<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" <?php echo $readonly; ?>
													id="idApp_Cliente" autofocus name="idApp_Cliente">
												<option value="">-- Selecione um Cliente --</option>
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
										
										<div class="col-md-6">
											<label for="idSis_EmpresaFilial">Unidade: *</label>
											<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" <?php echo $readonly; ?>
													id="idSis_EmpresaFilial" name="idSis_EmpresaFilial">
												<option value="">-- Selecione uma Unidade --</option>
												<?php
												foreach ($select['idSis_EmpresaFilial'] as $key => $row) {
													if ($query['idSis_EmpresaFilial'] == $key) {
														echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
													} else {
														echo '<option value="' . $key . '">' . $row . '</option>';
													}
												}
												?>
											</select>
										</div>
										-->
									</div>
								</div>
								<div class="form-group">
									<div class="row">										
										<div class="col-md-12 form-group text-left">
											<label for="Obs">Obs:</label>
											<textarea class="form-control" id="Obs"
													  name="Obs"><?php echo $query['Obs']; ?></textarea>
										</div>
									</div>
								</div>	
								<div class="form-group">
									<div class="row">		
										<div class="col-md-6">	
											<label for="Data">Data In�cio : </label>												
											<div class="input-group <?php echo $datepicker; ?>">
												<span class="input-group-addon" disabled>
													<span class="glyphicon glyphicon-calendar"></span>
												</span>
												<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
													   name="Data" value="<?php echo $query['Data']; ?>">
											</div>
											<?php echo form_error('Data'); ?>
										</div>	
										
										<div class="col-md-6">
											<label for="Hora">D�s :</label>
											<!--<div class="input-group <?php echo $timepicker; ?>">-->
												<input type="text" class="form-control Time" <?php echo $readonly; ?> maxlength="5"  placeholder="HH:MM"
													   accept=""name="HoraInicio" value="<?php echo $query['HoraInicio']; ?>">
												<!--<span class="input-group-addon">
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
													   name="Data2" value="<?php echo $query['Data2']; ?>">
											</div>
											<?php echo form_error('Data2'); ?>
										</div>
									
										<div class="col-md-6">		
											<label for="Hora">�s :</label>
											<!--<div class="input-group <?php echo $timepicker; ?>">-->
												<input type="text" class="form-control Time" <?php echo $readonly; ?> maxlength="5" placeholder="HH:MM"
													   accept=""name="HoraFim" value="<?php echo $query['HoraFim']; ?>">
												<!--<span class="input-group-addon">
													<span class="glyphicon glyphicon-time"></span>
												</span>
											</div>-->
										<?php echo form_error('HoraFim'); ?>
										</div>
									</div>
								</div>																						
								<div class="form-group">
									<div class="row">
										<div class="col-md-6 form-inline text-left">
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
									</div>
								</div>	
								<div class="form-group">
									<div class="row">		
										<div class="col-md-12 form-inline text-left">
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
								<div class="form-group">
									<div class="row">
										<input type="hidden" name="idApp_Consulta" value="<?php echo $query['idApp_Consulta']; ?>">
										<!--<input type="hidden" name="idApp_Agenda" value="<?php echo $_SESSION['log']['Agenda']; ?>">
										<input type="hidden" name="Evento" value="1">-->
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
																<a class="btn btn-danger" href="<?php echo base_url() . 'consulta/excluir/' . $query['idApp_Consulta'] ?>" role="button">
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
		</div>
	</div>
</div>
