<?php if ($msg) echo $msg; ?>
<!--<?php #echo form_open('relatorio/comissao', 'role="form"'); ?>-->
<?php echo form_open($form_open_path, 'role="form"'); ?>
<div class="col-md-12 ">		
	<?php echo validation_errors(); ?>
	<div class="panel panel-info">
		<div class="panel-heading">
			<h4><?php echo $titulo; ?></h4>
			<div class="input-group col-md-3">
				<span class="input-group-btn">
					<button class="btn btn-info btn-md" type="submit">
						<span class="glyphicon glyphicon-search"></span> 
					</button>
				</span>
				<input type="text" placeholder="Pesquisar Pedido" class="form-control Numero btn-sm" name="Orcamento" value="<?php echo set_value('Orcamento', $query['Orcamento']); ?>">
				<input type="text" placeholder="Pesquisar Cliente" class="form-control Numero btn-sm" name="Cliente" value="<?php echo set_value('Cliente', $query['Cliente']); ?>">
				<span class="input-group-btn">
					<button class="btn btn-warning btn-md" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
						<span class="glyphicon glyphicon-filter"></span>
					</button>
				</span>
				<span class="input-group-btn">
					<a href="<?php echo base_url() . $imprimir . $_SESSION['log']['idSis_Empresa']; ?>">
						<button class="btn btn-success btn-md" type="button">
							<span class="glyphicon glyphicon-print"></span>
						</button>
					</a>
				</span>
				<span class="input-group-btn">
					<a href="<?php echo base_url() . $baixa . $_SESSION['log']['idSis_Empresa']; ?>">
						<button class="btn btn-danger btn-md" type="button">
							<span class="glyphicon glyphicon-edit"></span>
						</button>
					</a>
				</span>
			</div>
		</div>
		<div class="panel-body">
			<div <?php echo $collapse; ?> id="Receitas">
				<?php echo (isset($list1)) ? $list1 : FALSE ?>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bs-excluir-modal2-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bg-info">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtros das <?php echo $titulo; ?></h4>
			</div>
			<div class="modal-footer">
				<div class="panel panel-info">
					<div class="panel-heading text-left">
						<div class="row">	
							<div class="col-md-3">
								<label for="CombinadoFrete">Combinado</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
										id="CombinadoFrete" name="CombinadoFrete">
									<?php
									foreach ($select['CombinadoFrete'] as $key => $row) {
										if ($query['CombinadoFrete'] == $key) {
											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
										} else {
											echo '<option value="' . $key . '">' . $row . '</option>';
										}
									}
									?>
								</select>
							</div>
							<div class="col-md-3">
								<label for="AprovadoOrca">Aprovado</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
										id="AprovadoOrca" name="AprovadoOrca">
									<?php
									foreach ($select['AprovadoOrca'] as $key => $row) {
										if ($query['AprovadoOrca'] == $key) {
											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
										} else {
											echo '<option value="' . $key . '">' . $row . '</option>';
										}
									}
									?>
								</select>
							</div>
							<div class="col-md-3">
								<label for="ConcluidoOrca">Entregue</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
										id="ConcluidoOrca" name="ConcluidoOrca">
									<?php
									foreach ($select['ConcluidoOrca'] as $key => $row) {
										if ($query['ConcluidoOrca'] == $key) {
											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
										} else {
											echo '<option value="' . $key . '">' . $row . '</option>';
										}
									}
									?>
								</select>
							</div>
							<div class="col-md-3">
								<label for="QuitadoOrca">Pago</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
										id="QuitadoOrca" name="QuitadoOrca">
									<?php
									foreach ($select['QuitadoOrca'] as $key => $row) {
										if ($query['QuitadoOrca'] == $key) {
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
							<?php if ($metodo == 1) { ?>
								<div class="col-md-3 text-left">
								<input type="hidden" name="StatusComissaoOrca_Online" id="StatusComissaoOrca_Online" value="0"/>
									<label for="StatusComissaoOrca">Status Comissão:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
											id="StatusComissaoOrca" name="StatusComissaoOrca">
										<?php
										foreach ($select['StatusComissaoOrca'] as $key => $row) {
											if ($query['StatusComissaoOrca'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
							<?php } else if ($metodo == 2) { ?>
								<input type="hidden" name="StatusComissaoOrca" id="StatusComissaoOrca" value="0"/>
								<div class="col-md-3 text-left">
									<label for="StatusComissaoOrca_Online">Status Comissão Online:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
											id="StatusComissaoOrca_Online" name="StatusComissaoOrca_Online">
										<?php
										foreach ($select['StatusComissaoOrca_Online'] as $key => $row) {
											if ($query['StatusComissaoOrca_Online'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
							<?php } ?>	
							<div class="col-md-3 text-left">
								<label for="Quitado">Status das Parcelas</label>
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
							<div class="col-md-3">
								<label for="FinalizadoOrca">Finalizado</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
										id="FinalizadoOrca" name="FinalizadoOrca">
									<?php
									foreach ($select['FinalizadoOrca'] as $key => $row) {
										if ($query['FinalizadoOrca'] == $key) {
											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
										} else {
											echo '<option value="' . $key . '">' . $row . '</option>';
										}
									}
									?>
								</select>
							</div>	
							<div class="col-md-3">
								<label for="CanceladoOrca">Cancelado</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
										id="CanceladoOrca" name="CanceladoOrca">
									<?php
									foreach ($select['CanceladoOrca'] as $key => $row) {
										if ($query['CanceladoOrca'] == $key) {
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
				<div class="panel panel-info">
					<div class="panel-heading text-left">	
						<div class="row">	
							<div class="col-md-3">
								<label for="Ordenamento">Compra</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
										id="Tipo_Orca" name="Tipo_Orca">
									<?php
									foreach ($select['Tipo_Orca'] as $key => $row) {
										if ($query['Tipo_Orca'] == $key) {
											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
										} else {
											echo '<option value="' . $key . '">' . $row . '</option>';
										}
									}
									?>
								</select>
							</div>
							<div class="col-md-3">
								<label for="Ordenamento">Entrega</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
										id="TipoFrete" name="TipoFrete">
									<?php
									foreach ($select['TipoFrete'] as $key => $row) {
										if ($query['TipoFrete'] == $key) {
											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
										} else {
											echo '<option value="' . $key . '">' . $row . '</option>';
										}
									}
									?>
								</select>
							</div>	
							<div class="col-md-3">
								<label for="Ordenamento">Pagamento</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
										id="AVAP" name="AVAP">
									<?php
									foreach ($select['AVAP'] as $key => $row) {
										if ($query['AVAP'] == $key) {
											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
										} else {
											echo '<option value="' . $key . '">' . $row . '</option>';
										}
									}
									?>
								</select>
							</div>	
							<div class="col-md-3">
								<label for="Ordenamento">Forma de Pag.</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
										id="FormaPagamento" name="FormaPagamento">
									<?php
									foreach ($select['FormaPagamento'] as $key => $row) {
										if ($query['FormaPagamento'] == $key) {
											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
										} else {
											echo '<option value="' . $key . '">' . $row . '</option>';
										}
									}
									?>
								</select>
							</div>
							<!--
							<div class="col-md-4">
								<label for="Ordenamento">Entregador:</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
										id="Entregador" name="Entregador">
									<?php
									foreach ($select['Entregador'] as $key => $row) {
										if ($query['Entregador'] == $key) {
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
						<div class="row">
							<div class="col-md-3 text-left">
								<label for="Ordenamento">Tipo Receita:</label>
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
						</div>
					</div>
				</div>
				<div class="panel panel-info">
					<div class="panel-heading text-left">
						<div class="row">
							<div class="col-md-3">
								<label for="DataInicio">Pedido Inc.</label>
								<div class="input-group DatePicker">
									<span class="input-group-addon" disabled>
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											autofocus name="DataInicio" value="<?php echo set_value('DataInicio', $query['DataInicio']); ?>">
								</div>
							</div>
							<div class="col-md-3">
								<label for="DataFim">Pedido Fim</label>
								<div class="input-group DatePicker">
									<span class="input-group-addon" disabled>
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											name="DataFim" value="<?php echo set_value('DataFim', $query['DataFim']); ?>">
								</div>
							</div>
							<div class="col-md-3">
								<label for="DataInicio2">Entrega Inc.</label>
								<div class="input-group DatePicker">
									<span class="input-group-addon" disabled>
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											name="DataInicio2" value="<?php echo set_value('DataInicio2', $query['DataInicio2']); ?>">
								</div>
							</div>
							<div class="col-md-3">
								<label for="DataFim2">Entrega Fim</label>
								<div class="input-group DatePicker">
									<span class="input-group-addon" disabled>
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											name="DataFim2" value="<?php echo set_value('DataFim2', $query['DataFim2']); ?>">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<label for="DataInicio3">Vnc Inc.</label>
								<div class="input-group DatePicker">
									<span class="input-group-addon" disabled>
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											name="DataInicio3" value="<?php echo set_value('DataInicio3', $query['DataInicio3']); ?>">
								</div>
							</div>
							<div class="col-md-3">
								<label for="DataFim3">Vnc Fim</label>
								<div class="input-group DatePicker">
									<span class="input-group-addon" disabled>
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											name="DataFim3" value="<?php echo set_value('DataFim3', $query['DataFim3']); ?>">
								</div>
							</div>
							<div class="col-md-3">
								<label for="DataInicio4">Vnc.Prc.Inc.</label>
								<div class="input-group DatePicker">
									<span class="input-group-addon" disabled>
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											name="DataInicio4" value="<?php echo set_value('DataInicio4', $query['DataInicio4']); ?>">
								</div>
							</div>
							<div class="col-md-3">
								<label for="DataFim4">Vnc.Prc.Fim</label>
								<div class="input-group DatePicker">
									<span class="input-group-addon" disabled>
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											name="DataFim4" value="<?php echo set_value('DataFim4', $query['DataFim4']); ?>">
								</div>
							</div>
						</div>	
					</div>
				</div>
				<div class="panel panel-info">
					<div class="panel-heading text-left">
						<div class="row">
							<?php if ($metodo == 1) { ?>
								<input type="hidden" name="NomeAssociado" id="NomeAssociado" value="0"/>		
								<div class="col-md-6 text-left">
									<label for="Ordenamento">Colaborador:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen" 
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
							<?php } else if ($metodo == 2) { ?>	
								<input type="hidden" name="NomeUsuario" id="NomeUsuario" value="0"/>		
								<div class="col-md-6 text-left">
									<label for="Ordenamento">Associado:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen" 
											id="NomeAssociado" name="NomeAssociado">
										<?php
										foreach ($select['NomeAssociado'] as $key => $row) {
											if ($query['NomeAssociado'] == $key) {
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
					</div>
				</div>
				<div class="panel panel-info">
					<div class="panel-heading text-left">
						<div class="row">
							<div class="form-footer col-md-4">
							<label></label><br>
								<button class="btn btn-warning btn-block" name="pesquisar" value="0" type="submit">
									<span class="glyphicon glyphicon-filter"></span> Filtrar
								</button>
							</div>
							<div class="form-footer col-md-4">
							<label></label><br>
								<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">
									<span class="glyphicon glyphicon-remove"> Fechar
								</button>
							</div>
						</div>
					</div>
				</div>
				<!--
				<div class="panel panel-info">
					<div class="panel-heading text-left">
						
						<div class="row">	
							<div class="col-md-12 text-left">
								<label for="Ordenamento">Produtos:</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
										id="Produtos" name="Produtos">
									<?php
									foreach ($select['Produtos'] as $key => $row) {
										if ($query['Produtos'] == $key) {
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
				-->
			</div>
		</div>									
	</div>
</div>																				




