<?php if (isset($msg)) echo $msg; ?>

<div id="fluxo" class="modal bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="fluxo" aria-hidden="true">
	<div class="vertical-alignment-helper">
		<div class="modal-dialog modal-sm vertical-align-center">
			<div class="modal-content">
				<div class="modal-body text-center">
					<div class="form-group">
						<div class="row">
							<div class="col-md-12 col-lg-12">
								<label for="">Agendamento:</label>
								<div class="form-group">
									<?php if ($_SESSION['log']['idSis_Empresa'] != 5 ) { ?>				
									<div class="row">
										<button type="button" id="MarcarConsulta" onclick="redirecionar(2)" class="btn btn-primary"> Com Cliente
										</button>
									</div>
									<?php } ?>
									<br>
									<div class="row">
										<button type="button" id="AgendarEvento" onclick="redirecionar(1)" class="btn btn-info"> Outro Evento
										</button>
									</div>
										<input type="hidden" id="start" />
										<input type="hidden" id="end" />
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="col-md-3">
	<?php echo validation_errors(); ?>
	<div class="panel panel-primary">
		<div class="panel-heading">
			
			<?php echo form_open('agenda', 'role="form"'); ?>
			<!--	
			<button class="btn btn-sm btn-info" name="pesquisar" value="0" type="submit">
				<span class="glyphicon glyphicon-search"></span> Pesq.
			</button>
			-->
			<div class=" btn btn-primary" type="button" data-toggle="collapse" data-target="#Tarefas" aria-expanded="false" aria-controls="Tarefas">
				<span class="glyphicon glyphicon-pencil"></span><?php echo $titulo1; ?> 
			</div>
			<button  class="btn btn-sm btn-info" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
				<span class="glyphicon glyphicon-search"></span>Pesquisar 
			</button>
			<!--<a class="btn btn-sm btn-warning" href="<?php echo base_url() ?>relatorio/alterarprocedimento" role="button"> 
				<span class="glyphicon glyphicon-ok"></span> Edit Todas
			</a>-->											
			<a class="btn btn-sm btn-danger" href="<?php echo base_url() ?>procedimento/cadastrar" role="button"> 
				<span class="glyphicon glyphicon-plus"></span> Nova
			</a>
		
		</div>
		<div <?php echo $collapse; ?> id="Tarefas">	
			<div class="panel-body">
				<div class="row">																
					<div class="modal fade bs-excluir-modal2-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
						<div class="modal-dialog modal-md" role="document">
							<div class="modal-content">
								<div class="modal-header bg-danger">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtro de Tarefas</h4>
								</div>
								<div class="modal-footer">
									<div class="form-group">	
										<div class="row">	
																									
											<div class="col-md-3 text-left">
												<label for="ConcluidoProcedimento">Concluido?</label>
												<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block"
														id="ConcluidoProcedimento" name="ConcluidoProcedimento">
													<?php
													foreach ($select['ConcluidoProcedimento'] as $key => $row) {
														if ($query['ConcluidoProcedimento'] == $key) {
															echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
														} else {
															echo '<option value="' . $key . '">' . $row . '</option>';
														}
													}
													?>
												</select>
											</div>
											<div class="col-md-3 text-left" >
												<label for="Ordenamento">Dia:</label>
												<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
														id="Dia" name="Dia">
													<?php
													foreach ($select['Dia'] as $key => $row) {
														if ($query['Dia'] == $key) {
															echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
														} else {
															echo '<option value="' . $key . '">' . $row . '</option>';
														}
													}
													?>
												</select>
											</div>
											<div class="col-md-3 text-left" >
												<label for="Ordenamento">Mês:</label>
												<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
														id="Mesvenc" name="Mesvenc">
													<?php
													foreach ($select['Mesvenc'] as $key => $row) {
														if ($query['Mesvenc'] == $key) {
															echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
														} else {
															echo '<option value="' . $key . '">' . $row . '</option>';
														}
													}
													?>
												</select>
											</div>
											<div class="col-md-3 text-left" >
												<label for="Ordenamento">Ano:</label>
												<div>
													<input type="text" class="form-control Numero" maxlength="4" placeholder="AAAA"
														   autofocus name="Ano" value="<?php echo set_value('Ano', $query['Ano']); ?>">
												</div>
											</div>
										</div>
										<div class="row">
											<br>
											<div class="form-group col-md-3 text-left">
												<div class="form-footer ">
													<button class="btn btn-success btn-block" name="pesquisar" value="0" type="submit">
														<span class="glyphicon glyphicon-filter"></span> Filtrar
													</button>
												</div>
											</div>
											<div class="form-group col-md-3 text-left">
												<div class="form-footer ">
													<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">
														<span class="glyphicon glyphicon-remove"> Fechar
													</button>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-9 text-left">
												<label for="Ordenamento">Ordenamento:</label>
												<div class="form-group btn-block">
													<div class="row">
														<div class="col-md-8">
															<select data-placeholder="Selecione uma opção..." class="form-control Chosen" onchange="this.form.submit()"
																	id="Campo" name="Campo">
																<?php
																foreach ($select['Campo'] as $key => $row) {
																	if ($query['Campo'] == $key) {
																		echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																	} else {
																		echo '<option value="' . $key . '">' . $row . '</option>';
																	}
																}
																?>
															</select>
														</div>
														<div class="col-md-4">
															<select data-placeholder="Selecione uma opção..." class="form-control Chosen" onchange="this.form.submit()"
																	id="Ordenamento" name="Ordenamento">
																<?php
																foreach ($select['Ordenamento'] as $key => $row) {
																	if ($query['Ordenamento'] == $key) {
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
									</div>											
								</div>
							</div>
						</div>
					</div>
				</div>
				
				</form>
				
				<?php echo (isset($list1)) ? $list1 : FALSE ?>
				
			</div>
		</div>
	</div>
	

	<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
			
	<?php echo validation_errors(); ?>
	<div class="panel panel-primary">
		<div class="panel-heading">
			
			<?php echo form_open('agenda', 'role="form"'); ?>
			<!--	
			<button class="btn btn-sm btn-info" name="pesquisar" value="0" type="submit">
				<span class="glyphicon glyphicon-search"></span> Pesq.
			</button>
			-->
			<div class=" btn btn-primary" type="button" data-toggle="collapse" data-target="#Procedimento" aria-expanded="false" aria-controls="Procedimento">
				<span class="glyphicon glyphicon-pencil"></span>Cliente<?php #echo $titulo2; ?> 
			</div>
			<button  class="btn btn-sm btn-info" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal3-sm">
				<span class="glyphicon glyphicon-search"></span>Pesquisar 
			</button>
			<!--<a class="btn btn-sm btn-warning" href="<?php echo base_url() ?>relatorio/alterarprocedimento" role="button"> 
				<span class="glyphicon glyphicon-ok"></span> Edit Todas
			</a>-->											
			<a class="btn btn-sm btn-danger" href="<?php echo base_url() ?>procedimento/cadastrarcli" role="button"> 
				<span class="glyphicon glyphicon-plus"></span> Novo
			</a>
		
		</div>
		<div <?php echo $collapse; ?> id="Procedimento">	
			<div class="panel-body">
				<div class="row">																
					<div class="modal fade bs-excluir-modal3-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
						<div class="modal-dialog modal-md" role="document">
							<div class="modal-content">
								<div class="modal-header bg-danger">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtro de Procedimentos</h4>
								</div>
								<div class="modal-footer">
									<div class="form-group">	
										<div class="row">	
											<div class="col-md-3 text-left">
												<label for="Ordenamento">Cliente:</label>
												<select data-placeholder="Selecione uma opção..." class="form-control Chosen" 
														id="NomeCliente" autofocus name="NomeCliente">
													<?php
													foreach ($select['NomeCliente'] as $key => $row) {
														if ($query['NomeCliente'] == $key) {
															echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
														} else {
															echo '<option value="' . $key . '">' . $row . '</option>';
														}
													}
													?>
												</select>
											</div>														
											<div class="col-md-3 text-left">
												<label for="ConcluidoProcedimento">Concluido?</label>
												<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block"
														id="ConcluidoProcedimento" name="ConcluidoProcedimento">
													<?php
													foreach ($select['ConcluidoProcedimento'] as $key => $row) {
														if ($query['ConcluidoProcedimento'] == $key) {
															echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
														} else {
															echo '<option value="' . $key . '">' . $row . '</option>';
														}
													}
													?>
												</select>
											</div>
											<div class="col-md-3 text-left" >
												<label for="Ordenamento">Dia:</label>
												<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
														id="Dia" name="Dia">
													<?php
													foreach ($select['Dia'] as $key => $row) {
														if ($query['Dia'] == $key) {
															echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
														} else {
															echo '<option value="' . $key . '">' . $row . '</option>';
														}
													}
													?>
												</select>
											</div>
											<div class="col-md-3 text-left" >
												<label for="Ordenamento">Mês:</label>
												<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
														id="Mesvenc" name="Mesvenc">
													<?php
													foreach ($select['Mesvenc'] as $key => $row) {
														if ($query['Mesvenc'] == $key) {
															echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
														} else {
															echo '<option value="' . $key . '">' . $row . '</option>';
														}
													}
													?>
												</select>
											</div>
											<div class="col-md-3 text-left" >
												<label for="Ordenamento">Ano:</label>
												<div>
													<input type="text" class="form-control Numero" maxlength="4" placeholder="AAAA"
														   autofocus name="Ano" value="<?php echo set_value('Ano', $query['Ano']); ?>">
												</div>
											</div>
										</div>
										<div class="row">
											<br>
											<div class="form-group col-md-3 text-left">
												<div class="form-footer ">
													<button class="btn btn-success btn-block" name="pesquisar" value="0" type="submit">
														<span class="glyphicon glyphicon-filter"></span> Filtrar
													</button>
												</div>
											</div>
											<div class="form-group col-md-3 text-left">
												<div class="form-footer ">
													<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">
														<span class="glyphicon glyphicon-remove"> Fechar
													</button>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-9 text-left">
												<label for="Ordenamento">Ordenamento:</label>
												<div class="form-group btn-block">
													<div class="row">
														<div class="col-md-8">
															<select data-placeholder="Selecione uma opção..." class="form-control Chosen" onchange="this.form.submit()"
																	id="Campo" name="Campo">
																<?php
																foreach ($select['Campo'] as $key => $row) {
																	if ($query['Campo'] == $key) {
																		echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																	} else {
																		echo '<option value="' . $key . '">' . $row . '</option>';
																	}
																}
																?>
															</select>
														</div>
														<div class="col-md-4">
															<select data-placeholder="Selecione uma opção..." class="form-control Chosen" onchange="this.form.submit()"
																	id="Ordenamento" name="Ordenamento">
																<?php
																foreach ($select['Ordenamento'] as $key => $row) {
																	if ($query['Ordenamento'] == $key) {
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
									</div>											
								</div>
							</div>
						</div>
					</div>
				</div>
				
				</form>
				
				<?php echo (isset($list2)) ? $list2 : FALSE ?>
				
			</div>
		</div>
	</div>
	
	<?php } ?>
</div>

<div class="col-md-6">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<?php echo form_open('agenda', 'role="form"'); ?>		
			<?php if ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['log']['Permissao'] <= 2 ) { ?>	
				
			<div class="col-md-6 text-left">
				<label class="sr-only" for="Ordenamento">Agenda dos Prof.:</label>
				<select data-placeholder="Selecione uma opção..." class="form-control Chosen" onchange="this.form.submit()"
						id="NomeUsuario" name="NomeUsuario">
					<?php
					foreach ($select['NomeUsuario'] as $key => $row) {
						if ($query['NomeUsuario'] == $key) {
							echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
						} else {
							echo '<option value="' . $key . '">' . $row . '</option>';
						}
					}
					?>
				</select>
			</div>	
			<?php } ?>
			<div class=" btn btn-primary" type="button" data-toggle="collapse" data-target="#Agenda" aria-expanded="false" aria-controls="Agenda">
				<span class="glyphicon glyphicon-pencil"> Agenda</span>
			</div>
			<div class=" btn btn-info" type="button" data-toggle="collapse" data-target="#Calendario" aria-expanded="false" aria-controls="Calendario">
				<span class="glyphicon glyphicon-calendar"></span>
			</div>
			
		</div>
		<div <?php echo $collapse; ?> id="Agenda">
			<div class="panel-body">
				<div class="text-right">
					<div <?php echo $collapse1; ?> id="Calendario">
							<div class="form-group" id="datepickerinline" class="col-md-12" >
							</div>
					</div>
				</div>
				<div class="form-group">
					<div  style="overflow: auto; height: 456px; "> 
							<table id="calendar" class="table table-condensed table-striped "></table>
					</div>
				</div>
			</div>
		</div>	
	</div>
</div>

<div class="col-md-3">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<div class=" btn btn-primary" type="button" data-toggle="collapse" data-target="#Empresa" aria-expanded="false" aria-controls="Empresa">
				<span class="glyphicon glyphicon-pencil">Mensagens</span>
			</div>
			<a class="btn btn-sm btn-info" href="<?php echo base_url() ?>relatorio/procedimentocli" role="button">
				<span class="glyphicon glyphicon-search"></span>Pesq.
			</a>
			<a class="btn btn-sm btn-danger" href="<?php echo base_url() ?>empresacli/cadastrarproc2" role="button">
				<span class="glyphicon glyphicon-plus"></span>Nova
			</a>
		</div>		
		<div <?php echo $collapse; ?> id="Empresa">
			<div class="panel-body">
				<div class="form-group">
					<div class="row">
						<div class="col-md-12">
							<div style="overflow: auto; height: 410px; ">
								<table class="table table-condensed table-bordered table-striped" >
									<tr>
										<th class="active">Resp.</th>
										<!--<th class="active">id</th>-->
										<th class="active">Emissor</th>
										<th class="active">Empresa</th>
										<th class="active">Pergunta</th>
										<th class="active">DtEnv</th>
										<!--<th class="active">Conc.</th>-->
										<th class="active">Empresa</th>
										<!--<th class="active">Recptor</th>-->
										<th class="active">Resposta</th>
										<th class="active">DtRes</th>
									</tr>
									<?php
									if ($query['procedempresa'] != FALSE) {

										foreach ($query['procedempresa']->result_array() as $row) {
											$url = base_url() . 'orcatrata/alterarprocedempresa/' . $row['idSis_Empresa'];

											echo '<tr class="clickable-row" data-href="' . $url . '" data-original-title="' . $row['Idade'] . ' anos" data-container="body"
													data-toggle="tooltip" data-placement="right" title="">';
												echo '<td>' . $row['ConcluidoProcedimento'] . '</td>';
												#echo '<td>' . $row['idApp_Procedimento'] . '</td>';
												echo '<td>' . $row['NomeCli'] . '</td>';
												echo '<td>' . $row['NomeEmpresaCli'] . '</td>';
												echo '<td>' . $row['ProcedimentoCli'] . '</td>';
												echo '<td>' . $row['DataProcedimentoCli'] . '</td>';
												#echo '<td>' . $row['ConcluidoProcedimentoCli'] . '</td>';
												echo '<td>' . $row['NomeEmpresa'] . '</td>';
												#echo '<td>' . $row['Nome'] . '</td>';
												echo '<td>' . $row['Procedimento'] . '</td>';
												echo '<td>' . $row['DataProcedimento'] . '</td>';
												
											echo '</tr>';

										}

									}
									?>
								</table>
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>	
	</div>
</div>
