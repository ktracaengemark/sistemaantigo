<?php if ($msg) echo $msg; ?>
<?php echo form_open('relatorio/cobrancas', 'role="form"'); ?>	
<div class="col-md-12">		
	<?php echo validation_errors(); ?>
	<div class="panel panel-info">
		<div class="panel-heading">
			<h4><?php echo $titulo1; ?></h4>
			<div class="input-group col-md-3">
				<span class="input-group-btn">
					<button class="btn btn-info btn-md" type="submit">
						<span class="glyphicon glyphicon-search"></span> 
					</button>
				</span>
				<input type="text" placeholder="Pesquisar Pedido" class="form-control Numero btn-sm" name="Orcamento" value="<?php echo set_value('Orcamento', $query['Orcamento']); ?>">
				<span class="input-group-btn">	
					<button class="btn btn-warning btn-md" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
						<span class="glyphicon glyphicon-filter"></span>
					</button>
				</span>
				<span class="input-group-btn">
					<a href="<?php echo base_url() . 'OrcatrataPrintCobranca/imprimir/' . $_SESSION['log']['idSis_Empresa']; ?>">
						<button class="btn btn-success btn-md" type="button">
							<span class="glyphicon glyphicon-print"></span>
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
				<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtros das Cobran�as</h4>
			</div>
			<div class="modal-footer">
				<div class="panel panel-info">
					<div class="panel-heading text-left">
					<!--								
						<div class="row">	
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
								<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block" 
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
						</div>
					-->
						<div class="row">
							<div class="col-md-4">
								<label for="AprovadoOrca">Aprovado?</label>
								<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
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
							<div class="col-md-4">
								<label for="ConcluidoOrca">Entregue?</label>
								<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
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
							<div class="col-md-4">
								<label for="QuitadoOrca">Pago?</label>
								<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
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
							<div class="col-md-4 text-left">
								<label for="Quitado">Status das Parcelas:</label>
								<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block" 
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
							<div class="col-md-4">
								<label for="FinalizadoOrca">Finalizado?</label>
								<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
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
							<div class="col-md-4">
								<label for="CanceladoOrca">Cancelado?</label>
								<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
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
								<label for="Ordenamento">Local de Compra</label>
								<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
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
								<label for="Ordenamento">Local de Pag.</label>
								<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
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
								<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
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
							<div class="col-md-3">
								<label for="Ordenamento">Forma de Ent.</label>
								<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
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
						</div>
						<!--
						<div class="row">
							<div class="col-md-3 text-left">
								<label for="Ordenamento">Tipo Receita:</label>
								<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block" 
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
						-->
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
								<label for="DataInicio3">Venc.Parc.Inc.</label>
								<div class="input-group DatePicker">
									<span class="input-group-addon" disabled>
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											name="DataInicio3" value="<?php echo set_value('DataInicio3', $query['DataInicio3']); ?>">
								</div>
							</div>
							<div class="col-md-3">
								<label for="DataFim3">Venc.Parc.Fim</label>
								<div class="input-group DatePicker">
									<span class="input-group-addon" disabled>
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											name="DataFim3" value="<?php echo set_value('DataFim3', $query['DataFim3']); ?>">
								</div>
							</div>
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
			</div>
		</div>									
	</div>
</div>
</form>
