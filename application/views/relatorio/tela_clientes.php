<?php if ($msg) echo $msg; ?>
<?php if ($msg) echo $msg; ?>
<div class="col-md-1"></div>
<div class="col-md-10">		
	<div class="row">
		<div class="main">
			<?php echo validation_errors(); ?>
			<div class="panel panel-primary">
				<div class="panel-heading">
					<?php echo form_open('relatorio/clientes', 'role="form"'); ?>
					
					<button  class="btn btn-sm btn-info" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
						<span class="glyphicon glyphicon-search"></span> <?php echo $titulo; ?>
					</button>
																
					<a class="btn btn-sm btn-danger" href="<?php echo base_url() ?>cliente/cadastrar" role="button"> 
						<span class="glyphicon glyphicon-plus"></span> Novo
					</a>
				</div>
				<div class="panel-body">
					<div class="modal fade bs-excluir-modal2-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header bg-danger">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtros</h4>
								</div>
								<div class="modal-footer">
									<div class="form-group">
										<div class="row">
											<div class="col-md-8 text-left">
												<label for="Ordenamento">Nome do Cliente:</label>
												<div class="form-group">
													<div class="row">
														<div class="col-md-12">
															<select data-placeholder="Selecione uma opção..." class="form-control Chosen" onchange="this.form.submit()"
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
												</div>
											</div>
											<div class="col-md-4 text-left">
												<label for="Ativo">Ativo?</label>
												<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block"
														id="Ativo" name="Ativo">
													<?php
													foreach ($select['Ativo'] as $key => $row) {
														if ($query['Ativo'] == $key) {
															echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
														} else {
															echo '<option value="' . $key . '">' . $row . '</option>';
														}
													}
													?>
												</select>
											</div>														
											<div class="col-md-12 text-left">
												<label for="Ordenamento">Ordenamento:</label>
												<div class="form-group">
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
									</div>
								
								</div>
							</div>
						</div>
					</div>
				</form>
				<?php echo (isset($list)) ? $list : FALSE ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="col-md-1"></div>	

