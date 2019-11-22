<?php if (isset($msg)) echo $msg; ?>


<div class="col-md-4">
	<?php echo validation_errors(); ?>
	<div class="panel panel-primary">

		<div class="panel-heading">
			<?php echo form_open('relatorio/parcelas', 'role="form"'); ?>
			
			<!--<button  class="btn btn-sm btn-success" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal11-sm">
				<span class="glyphicon glyphicon-plus"></span>Rec.<?php #echo $titulo1; ?>
			</button>-->			
			
			<button  class="btn btn-sm btn-info" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
				<span class="glyphicon glyphicon-filter"></span>Filtrar<?php #echo $titulo1; ?>
			</button>
			<a href="<?php echo base_url() . 'orcatrata/alterarparcelarec/' . $_SESSION['log']['idSis_Empresa']; ?>">
				<button type="button" class="btn btn-sm btn-info">
					<span class="glyphicon glyphicon-edit"></span>
				</button>
			</a>
			<a class="btn btn-sm btn-warning" href="<?php echo base_url() ?>relatorio/financeiro" role="button">
				<span class="glyphicon glyphicon-search"></span>Relatório
			</a>			
			<a class="btn btn-sm btn-success" href="<?php echo base_url() ?>relatorio/balanco" role="button">
				<span class="glyphicon glyphicon-search"></span>Balanço 
			</a>

		</div>
															
		<div class="modal fade bs-excluir-modal11-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header bg-danger">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Evite cadastrar RECEITAS Repetidas!<br>
												"Pesquise"as Receitas Cadastradas!</h4>
					</div>
					<!--
					<div class="modal-body">
						<p>Ao confirmar esta operação todos os dados serão excluídos permanentemente do sistema. 
							Esta operação é irreversível.</p>
					</div>
					-->
					<div class="modal-footer">
						<!--<div class="form-group col-md-3 text-left">
							<div class="form-footer">
								<button  class="btn btn-warning btn-block"" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
									<span class="glyphicon glyphicon-search"></span> Pesquisar
								</button>
							</div>
						</div>-->
						<div class="form-group col-md-3 text-right">
							<div class="form-footer">		
								<a class="btn btn-warning btn-block" href="<?php echo base_url() ?>relatorio/financeiro" role="button">
									<span class="glyphicon glyphicon-search"></span> Pesquisar
								</a>
							</div>	
						</div>
						<!--
						<div class="form-group col-md-3 text-left">
							<div class="form-footer ">
								<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">
									<span class="glyphicon glyphicon-remove"> Fechar
								</button>
							</div>
						</div>
						-->
						<div class="form-group col-md-3 text-right">
							<div class="form-footer">		
								<a class="btn btn-success btn-block" href="<?php echo base_url() ?>orcatrata/cadastrar2" role="button">
									<span class="glyphicon glyphicon-plus"></span> Receitas
								</a>
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade bs-excluir-modal2-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			<div class="modal-dialog modal-md" role="document">
				<div class="modal-content">
					<div class="modal-header bg-danger">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtros das Receitas</h4>
					</div>
					<div class="modal-footer">
						<div class="row">								
							<div class="col-md-3 text-left" >
								<label for="Ordenamento">Dia do Venc.:</label>
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
								<label for="Ordenamento">Mês do Venc.:</label>
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
								<label for="Ordenamento">Ano do Venc.:</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
										id="Ano" name="Ano">
									<?php
									foreach ($select['Ano'] as $key => $row) {
										if ($query['Ano'] == $key) {
											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
										} else {
											echo '<option value="' . $key . '">' . $row . '</option>';
										}
									}
									?>
								</select>
							</div>
							<div class="col-md-3 text-left">
								<label for="Quitado">Parc. Quit.</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
										id="Quitado" name="Quitado">
									<?php
									foreach ($select['Quitado'] as $key => $row) {
										if ($query['Quitado'] == $key) {
											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
										} else {
											echo '<option value="' . $key . '">' . $row . '</option>';
										}
									}
									?>
								</select>
							</div>								
							<!--
							<div class="col-md-3 text-left" >
								<label for="Ordenamento">Ano do Venc.:</label>
								<div>
									<input type="text" class="form-control Numero" maxlength="4" placeholder="AAAA"
										   autofocus name="Ano" value="<?php echo set_value('Ano', $query['Ano']); ?>">
								</div>
							</div>
							-->
						</div>
						<br>
						<div class="row">
							<div class="form-group col-md-3 text-left">
								<div class="form-footer ">
									<button class="btn btn-info btn-block" name="pesquisar" value="0" type="submit">
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
							<div class="form-group col-md-3 text-left">
								<div class="form-footer">		
									<a class="btn btn-success btn-block" href="<?php echo base_url() ?>relatorio/financeiro" role="button">
										<span class="glyphicon glyphicon-search"></span> Receitas
									</a>
								</div>	
							</div>
						</div>
						<div class="row">
							<div class="col-md-3 text-left" >
								<label for="Ordenamento">Orçam.:</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
										id="Orcarec" name="Orcarec">
									<?php
									foreach ($select['Orcarec'] as $key => $row) {
										if ($query['Orcarec'] == $key) {
											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
										} else {
											echo '<option value="' . $key . '">' . $row . '</option>';
										}
									}
									?>
								</select>
							</div>
							<div class="col-md-3 text-left">
								<label for="Ordenamento">Tipo de Receita:</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
										id="TipoFinanceiroR" name="TipoFinanceiroR">
									<?php
									foreach ($select['TipoFinanceiroR'] as $key => $row) {
										if ($query['TipoFinanceiroR'] == $key) {
											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
										} else {
											echo '<option value="' . $key . '">' . $row . '</option>';
										}
									}
									?>
								</select>
							</div>
							<?php if ($_SESSION['log']['idSis_Empresa'] != 5 ) { ?>
							<div class="col-md-3 text-left">
								<label for="Ordenamento">Nome do Cliente:</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
										id="NomeCliente" name="NomeCliente">
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
							<?php } ?>									
						</div>
						<br>
						<div class="row">
							<div class="form-group col-md-3 text-left">
								<div class="form-footer ">
									<button class="btn btn-info btn-block" name="pesquisar" value="0" type="submit">
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
							<div class="form-group col-md-3 text-left">
								<div class="form-footer">		
									<a class="btn btn-success btn-block" href="<?php echo base_url() ?>relatorio/financeiro" role="button">
										<span class="glyphicon glyphicon-search"></span> Receitas
									</a>
								</div>	
							</div>
						</div>							
					</div>
				</div>									
											
			</div>
		</div>		
	
		</form>		
		
		<div <?php echo $collapse; ?> id="Tarefas">	
			<div class="panel-body">
				<?php echo (isset($list1)) ? $list1 : FALSE ?>
			</div>
		</div>
	</div>
	

	<?php if ($_SESSION['log']['NivelEmpresa'] >= 10 ) { ?>
			
	<?php echo validation_errors(); ?>
	<div class="panel panel-primary">
		<div class="panel-heading">
			
			<?php echo form_open('agenda', 'role="form"'); ?>

			<div class=" btn btn-primary" type="button" data-toggle="collapse" data-target="#Tarefas2" aria-expanded="false" aria-controls="Tarefas2">
				<span class="glyphicon glyphicon-pencil"></span><?php echo $titulo2; ?> 
			</div>
			<button  class="btn btn-sm btn-info" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal3-sm">
				<span class="glyphicon glyphicon-filter"></span>Filtrar 
			</button>
			<!--<a class="btn btn-sm btn-warning" href="<?php echo base_url() ?>relatorio/alterarprocedimento" role="button"> 
				<span class="glyphicon glyphicon-ok"></span> Edit Todas
			</a>-->
			<a href="<?php echo base_url() . 'orcatrata/alterarprocedimentocli/' . $_SESSION['log']['idSis_Empresa']; ?>">
				<button type="button" class="btn btn-sm btn-info">
					<span class="glyphicon glyphicon-edit"></span>
				</button>
			</a>			
			<a class="btn btn-sm btn-danger" href="<?php echo base_url() ?>procedimento/cadastrarcli" role="button"> 
				<span class="glyphicon glyphicon-plus"></span> Novo
			</a>
		
		</div>
																
		<div class="modal fade bs-excluir-modal3-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			<div class="modal-dialog modal-md" role="document">
				<div class="modal-content">
					<div class="modal-header bg-danger">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtro de Clientes</h4>
					</div>
					<div class="modal-footer">
						<div class="form-group">	
							<div class="row">														
								<div class="col-md-3 text-left">
									<label for="Concluidocli">Concluido</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block"
											id="Concluidocli" name="Concluidocli">
										<?php
										foreach ($select['Concluidocli'] as $key => $row) {
											if ($query['Concluidocli'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<div class="col-md-3 text-left" >
									<label for="Ordenamento">Dia Retorno:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
											id="Diacli" name="Diacli">
										<?php
										foreach ($select['Diacli'] as $key => $row) {
											if ($query['Diacli'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<div class="col-md-3 text-left" >
									<label for="Ordenamento">Mês Retorno:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
											id="Mesvenccli" name="Mesvenccli">
										<?php
										foreach ($select['Mesvenccli'] as $key => $row) {
											if ($query['Mesvenccli'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<div class="col-md-3 text-left" >
									<label for="Ordenamento">Ano Retorno:</label>
									<div>
										<input type="text" class="form-control Numero" maxlength="4" placeholder="AAAA"
											   autofocus name="Anocli" value="<?php echo set_value('Anocli', $query['Anocli']); ?>">
									</div>
								</div>
							</div>

							<div class="row">
								<br>
								<div class="form-group col-md-3 text-left">
									<div class="form-footer ">
										<button class="btn btn-info btn-block" name="pesquisar" value="0" type="submit">
											<span class="glyphicon glyphicon-filter"></span> Filtrar
										</button>
									</div>
								</div>
								<!--
								<div class="form-group col-md-3 text-left">
									<div class="form-footer ">
										<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">
											<span class="glyphicon glyphicon-remove"> Fechar
										</button>
									</div>
								</div>
								-->
							</div>
							<div class="row">	
								<div class="col-md-6 text-left">
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
							</div>
							<br>
							<div class="row">	
								<div class="col-md-12 text-left">
									<label for="Ordenamento">Ordenamento:</label>
									<div class="form-group">
										<div class="row">
											<div class="col-md-6">
												<select data-placeholder="Selecione uma opção..." class="form-control Chosen" 
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
												<select data-placeholder="Selecione uma opção..." class="form-control Chosen" 
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
		
		</form>		
		
		<div <?php echo $collapse; ?> id="Tarefas2">	
			<div class="panel-body">
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
				<span class="glyphicon glyphicon-pencil"></span> Agenda
			</div>
			<div class=" btn btn-info" type="button" data-toggle="collapse" data-target="#Calendario" aria-expanded="false" aria-controls="Calendario">
				<span class="glyphicon glyphicon-calendar"></span> Calendário
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
		<?php if ($_SESSION['log']['NivelEmpresa'] >= 10 ) { ?>
	<?php echo validation_errors(); ?>
	<div class="panel panel-primary">
		<div class="panel-heading">
			
			<?php echo form_open('agenda', 'role="form"'); ?>

			<div class=" btn btn-primary" type="button" data-toggle="collapse" data-target="#Mensagem" aria-expanded="false" aria-controls="Mensagem">
				<span class="glyphicon glyphicon-pencil"></span><?php echo $titulo3; ?> 
			</div>
			<button  class="btn btn-sm btn-info" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target="#bs-excluir-modal4-sm" aria-controls="bs-excluir-modal4-sm">
				<span class="glyphicon glyphicon-filter"></span>Filtrar
			</button>
			<!--<a class="btn btn-sm btn-warning" href="<?php echo base_url() ?>relatorio/alterarprocedempresa" role="button"> 
				<span class="glyphicon glyphicon-ok"></span> Edit Todas
			</a>-->											
			<a class="btn btn-sm btn-danger" href="<?php echo base_url() ?>empresacli/cadastrarproc2" role="button"> 
				<span class="glyphicon glyphicon-plus"></span> Nova
			</a>
		
		</div>

		<div class="modal fade " id="bs-excluir-modal4-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			<div class="modal-dialog modal-md" role="document">
				<div class="modal-content">
					<div class="modal-header bg-danger">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Mensagens Enviadas</h4>
					</div>
					<div class="modal-footer">
						<div class="form-group">	
							<div class="row">	
								<div class="col-md-3 text-left">
									<label for="Concluidoemp">Respondido</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block"
											id="Concluidoemp" autofocus name="Concluidoemp">
										<?php
										foreach ($select['Concluidoemp'] as $key => $row) {
											if ($query['Concluidoemp'] == $key) {
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
											id="Diaemp" name="Diaemp">
										<?php
										foreach ($select['Diaemp'] as $key => $row) {
											if ($query['Diaemp'] == $key) {
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
											id="Mesvencemp" name="Mesvencemp">
										<?php
										foreach ($select['Mesvencemp'] as $key => $row) {
											if ($query['Mesvencemp'] == $key) {
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
											   name="Anoemp" value="<?php echo set_value('Anoemp', $query['Anoemp']); ?>">
									</div>
								</div>
							</div>

							<div class="row">
								<br>
								<div class="form-group col-md-3 text-left">
									<div class="form-footer ">
										<button class="btn btn-info btn-block" name="pesquisar" value="0" type="submit">
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
								<!--
								<div class="col-md-6 text-left">
									<label for="Ordenamento">Enviado por:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen" 
											id="NomeEmpresaCli" autofocus name="NomeEmpresaCli">
										<?php
										foreach ($select['NomeEmpresaCli'] as $key => $row) {
											if ($query['NomeEmpresaCli'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								-->
								<div class="col-md-6 text-left">
									<label for="Ordenamento">Enviadas para:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen" 
											id="NomeEmpresa" autofocus name="NomeEmpresa">
										<?php
										foreach ($select['NomeEmpresa'] as $key => $row) {
											if ($query['NomeEmpresa'] == $key) {
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
	
		</form>

		<div <?php echo $collapse; ?> id="Mensagem">	
			<div class="panel-body">
				<?php echo (isset($list3)) ? $list3 : FALSE ?>
			</div>
		</div>
	</div>
	

	<?php echo validation_errors(); ?>
	<div class="panel panel-primary">
		<div class="panel-heading">
			
			<?php echo form_open('agenda', 'role="form"'); ?>

			<div class=" btn btn-primary" type="button" data-toggle="collapse" data-target="#Mensagem2" aria-expanded="false" aria-controls="Mensagem2">
				<span class="glyphicon glyphicon-pencil"></span><?php echo $titulo4; ?> 
			</div>
			<button  class="btn btn-sm btn-info" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target="#bs-excluir-modal5-sm" aria-controls="bs-excluir-modal5-sm">
				<span class="glyphicon glyphicon-filter"></span>Filtrar
			</button>
			<!--<a class="btn btn-sm btn-warning" href="<?php echo base_url() ?>relatorio/alterarprocedempresa" role="button"> 
				<span class="glyphicon glyphicon-ok"></span> Edit Todas
			</a>										
			<a class="btn btn-sm btn-danger" href="<?php echo base_url() ?>empresacli/cadastrarproc2" role="button"> 
				<span class="glyphicon glyphicon-plus"></span> Nova
			</a>	
			-->
		</div>

		<div class="modal fade " id="bs-excluir-modal5-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			<div class="modal-dialog modal-md" role="document">
				<div class="modal-content">
					<div class="modal-header bg-danger">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Mensagens Recebidas</h4>
					</div>
					<div class="modal-footer">
						<div class="form-group">	
							<div class="row">	
								<div class="col-md-3 text-left">
									<label for="Concluidoemp">Respondido</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block"
											id="Concluidoemp" autofocus name="Concluidoemp">
										<?php
										foreach ($select['Concluidoemp'] as $key => $row) {
											if ($query['Concluidoemp'] == $key) {
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
											id="Diaemp" name="Diaemp">
										<?php
										foreach ($select['Diaemp'] as $key => $row) {
											if ($query['Diaemp'] == $key) {
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
											id="Mesvencemp" name="Mesvencemp">
										<?php
										foreach ($select['Mesvencemp'] as $key => $row) {
											if ($query['Mesvencemp'] == $key) {
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
											   name="Anoemp" value="<?php echo set_value('Anoemp', $query['Anoemp']); ?>">
									</div>
								</div>
							</div>

							<div class="row">
								<br>
								<div class="form-group col-md-3 text-left">
									<div class="form-footer ">
										<button class="btn btn-info btn-block" name="pesquisar" value="0" type="submit">
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
								<?php if ($_SESSION['log']['idSis_Empresa'] != 5 ) { ?>
								<div class="col-md-6 text-left">
									<label for="Ordenamento">Enviadas por:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen" 
											id="NomeEmpresaCli" autofocus name="NomeEmpresaCli">
										<?php
										foreach ($select['NomeEmpresaCli'] as $key => $row) {
											if ($query['NomeEmpresaCli'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<?php } ?>
								<!--
								<div class="col-md-6 text-left">
									<label for="Ordenamento">Enviadas para:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen" 
											id="NomeEmpresa" autofocus name="NomeEmpresa">
										<?php
										foreach ($select['NomeEmpresa'] as $key => $row) {
											if ($query['NomeEmpresa'] == $key) {
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
					</div>
				</div>
			</div>
		</div>
	
		</form>

		<div <?php echo $collapse; ?> id="Mensagem2">	
			<div class="panel-body">
				<?php echo (isset($list4)) ? $list4 : FALSE ?>
			</div>
		</div>
	</div>	

	<?php } ?>
</div>