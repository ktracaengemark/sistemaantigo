<?php if ($msg) echo $msg; ?>
<?php echo form_open($form_open_path, 'role="form"'); ?>
<div class="col-md-12">
<?php echo validation_errors(); ?>
	<div class="row">
		<div class="col-md-12 ">
			<div class="panel panel-<?php echo $panel; ?>">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-2 text-left">
							<label><?php echo $titulo1;?></label>
							<div class="input-group">
								<span class="input-group-btn">
									<button class="btn btn-<?php echo $panel; ?> btn-md" type="submit">
										<span class="glyphicon glyphicon-search"></span> 
									</button>
								</span>
								<input type="text" placeholder="Pesquisar Pedido" class="form-control Numero btn-sm" name="Orcamento" value="<?php echo set_value('Orcamento', $query['Orcamento']); ?>">
							</div>
						</div>	
						<?php if($_SESSION['log']['idSis_Empresa'] != "5") {?>
							<div class="col-md-2 text-left">	
								<label>.</label>
								<div class="input-group">
									<span class="input-group-btn">
										<button class="btn btn-<?php echo $panel; ?> btn-md" type="submit">
											<span class="glyphicon glyphicon-search"></span> 
										</button>
									</span>
									<?php if($metodo == 2) {?>	
										<input type="text" placeholder="Pesquisar <?php echo $nome; ?>" class="form-control Numero btn-sm" name="<?php echo $nome; ?>" id="<?php echo $nome; ?>" value="<?php echo set_value($nome, $query[$nome]); ?>">
										<input type="hidden" name="Fornecedor" id="Fornecedor" value="">
									<?php }elseif($metodo == 1){ ?>	
										<input type="text" placeholder="Pesquisar <?php echo $nome; ?>" class="form-control Numero btn-sm" name="<?php echo $nome; ?>" id="<?php echo $nome; ?>" value="<?php echo set_value($nome, $query[$nome]); ?>">
										<input type="hidden" name="Cliente" id="Cliente" value="">
									<?php } ?>
								</div>
							</div>	
						<?php }else{ ?>
							<input type="hidden" name="Cliente" id="Cliente" value=""/>
							<input type="hidden" name="Fornecedor" id="Fornecedor" value=""/>
						<?php } ?>
						<input type="hidden" name="idTab_TipoRD" id="idTab_TipoRD" value="<?php echo $TipoRD; ?>"/>
						<div class="col-md-3 text-left">
							<label for="Ordenamento">Colaborador:</label>
							<div class="input-group">
								<span class="input-group-btn">
									<button class="btn btn-<?php echo $panel; ?> btn-md" type="submit">
										<span class="glyphicon glyphicon-search"></span> 
									</button>
								</span>
								<select data-placeholder="Selecione uma op��o..." class="form-control" 
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
						</div>
						<div class="col-md-2">
							<div class="col-md-6">
								<label>Filtros</label>
								<button class="btn btn-warning btn-md btn-block" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
									<span class="glyphicon glyphicon-filter"></span>
								</button>
							</div>
							<?php if ($editar == 1) { ?>
								<?php if ($print == 1) { ?>	
									<div class="col-md-4">
										<label>Imprimir</label>
										<a href="<?php echo base_url() . $imprimirlista . $_SESSION['log']['idSis_Empresa']; ?>">
											<button class="btn btn-<?php echo $panel; ?> btn-md btn-block" type="button">
												<span class="glyphicon glyphicon-print"></span>
											</button>
										</a>
									</div>
								<?php } ?>	
								<div class="col-md-4">
									<label>Baixa</label>
									<a href="<?php echo base_url() . $alterarparc . $_SESSION['log']['idSis_Empresa']; ?>">
										<button class="btn btn-success btn-md btn-block" type="button">
											<span class="glyphicon glyphicon-edit"></span>
										</button>
									</a>
								</div>	
							<?php } ?>	
						</div>
					</div>	
				</div>
			</div>
		</div>	
	</div>	
	<!--
	<div class="row">
		<div class="main">
			<div class="panel panel-primary">
				<div class="panel-heading">
					
						
					<button class="btn btn-sm btn-info" name="pesquisar" value="0" type="submit">
						<span class="glyphicon glyphicon-search"></span> Pesq.
					</button>
					
					<button  class="btn btn-sm btn-info" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
						<span class="glyphicon glyphicon-search"></span> <?php echo $titulo1; ?>
					</button>
					<a class="btn btn-sm btn-warning" href="<?php echo base_url() ?>relatorio/alterarprocedimento" role="button"> 
						<span class="glyphicon glyphicon-ok"></span> Edit Todas
					</a>											
					<a class="btn btn-sm btn-danger" href="<?php echo base_url() ?>procedimento/cadastrar" role="button"> 
						<span class="glyphicon glyphicon-plus"></span> Nova
					</a>
				
				</div>
			</div>
		</div>
	</div>
	-->
	<div class="row">	
		<div class="col-md-12 ">
			<div style="overflow: auto; height: 550px; ">
				<?php echo (isset($list)) ? $list : FALSE ?>
			</div>
		</div>
	</div>
</div>
<div class="modal fade bs-excluir-modal2-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header bg-danger">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtrar Individual</h4>
			</div>
			<div class="modal-footer">
				<div class="form-group">	
					<div class="row">	
																				
						<div class="col-md-3 text-left">
							<label for="ConcluidoProcedimento">Concluido?</label>
							<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block"
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
							<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block" 
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
							<label for="Ordenamento">M�s:</label>
							<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block" 
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
										<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" onchange="this.form.submit()"
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
										<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" onchange="this.form.submit()"
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

