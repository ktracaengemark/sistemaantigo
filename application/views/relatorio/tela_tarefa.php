<?php if ($msg) echo $msg; ?>
<div class="col-sm-offset-2 col-md-8 ">	
	<?php echo validation_errors(); ?>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<div class="btn-group " role="group" aria-label="...">
				<div class="row text-left">	
					<div class="col-md-12">
						<button  class="btn btn-md btn-warning" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
							<span class="glyphicon glyphicon-filter"></span> Filtrar Tarefa
						</button>
					</div>
				</div>	
			</div>			
		</div>		
		<div class="form-group">
			<div class="row">
				<div class="col-md-12 text-left">			
					<div class="panel-body">
						<?php echo (isset($list)) ? $list : FALSE ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo form_open('relatorio/tarefa', 'role="form"'); ?>
<div class="modal fade bs-excluir-modal2-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header bg-danger">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtros</h4>
			</div>
			<div class="modal-footer">
				<div class="form-group">	
					<div class="row text-left">
						<div class="col-md-4 text-left">
							<label for="Ordenamento">Categoria:</label>
							<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block" 
									id="Categoria" name="Categoria">
								<?php
								foreach ($select['Categoria'] as $key => $row) {
									if ($query['Categoria'] == $key) {
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
							<label for="Prioridade">Prior</label>
							<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
									id="Prioridade" name="Prioridade">
								<?php
								foreach ($select['Prioridade'] as $key => $row) {
									if ($query['Prioridade'] == $key) {
										echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
									} else {
										echo '<option value="' . $key . '">' . $row . '</option>';
									}
								}
								?>
							</select>
						</div>
						<div class="col-md-4">
							<label for="Statustarefa">StatusTRF</label>
							<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
									id="Statustarefa" name="Statustarefa">
								<?php
								foreach ($select['Statustarefa'] as $key => $row) {
									if ($query['Statustarefa'] == $key) {
										echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
									} else {
										echo '<option value="' . $key . '">' . $row . '</option>';
									}
								}
								?>
							</select>
						</div>						
						<div class="col-md-4">
							<label for="SubPrioridade">SubPri</label>
							<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
									id="SubPrioridade" name="SubPrioridade">
								<?php
								foreach ($select['SubPrioridade'] as $key => $row) {
									if ($query['SubPrioridade'] == $key) {
										echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
									} else {
										echo '<option value="' . $key . '">' . $row . '</option>';
									}
								}
								?>
							</select>
						</div>
						<div class="col-md-4">
							<label for="Statussubtarefa">SubSts</label>
							<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
									id="Statussubtarefa" name="Statussubtarefa">
								<?php
								foreach ($select['Statussubtarefa'] as $key => $row) {
									if ($query['Statussubtarefa'] == $key) {
										echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
									} else {
										echo '<option value="' . $key . '">' . $row . '</option>';
									}
								}
								?>
							</select>
						</div>
						-->
						<div class="col-md-3">
							<label for="ConcluidoProcedimento">Conclu�da?</label>
							<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
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
						<!--
						<div class="col-md-3">
							<label for="ConcluidoSubProcedimento">St SubTarefa </label>
							<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
									id="ConcluidoSubProcedimento" name="ConcluidoSubProcedimento">
								<?php
								foreach ($select['ConcluidoSubProcedimento'] as $key => $row) {
									if ($query['ConcluidoSubProcedimento'] == $key) {
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
						<div class="col-md-12 text-left">
							<label for="Ordenamento">Tarefa</label>
							<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
									id="Procedimento" name="Procedimento">
								<?php
								foreach ($select['Procedimento'] as $key => $row) {
									if ($query['Procedimento'] == $key) {
										echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
									} else {
										echo '<option value="' . $key . '">' . $row . '</option>';
									}
								}
								?>
							</select>
						</div>						
					</div>
					
					<div class="row text-left">
						<br>
						<div class="form-group col-md-4">
							<div class="form-footer ">
								<button class="btn btn-warning btn-block" name="pesquisar" value="0" type="submit">
									<span class="glyphicon glyphicon-filter"></span> Filtrar
								</button>
							</div>
						</div>					
						<div class="form-group col-md-4">
							<div class="form-footer ">
								<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">
									<span class="glyphicon glyphicon-remove"></span> Fechar
								</button>
							</div>
						</div>
					</div>					
					<div class="row text-left">
						<div class="col-md-4">
							<label for="DataInicio">Data In�cio:</label>
							<div class="input-group DatePicker">
								<span class="input-group-addon" disabled>
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
								<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
									   autofocus name="DataInicio" value="<?php echo set_value('DataInicio', $query['DataInicio']); ?>">
								
							</div>
						</div>
						<div class="col-md-4">
							<label for="DataFim">Data Fim:</label>
							<div class="input-group DatePicker">
								<span class="input-group-addon" disabled>
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
								<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
									   autofocus name="DataFim" value="<?php echo set_value('DataFim', $query['DataFim']); ?>">
								
							</div>
						</div>								
					</div>
					<div class="row">	
						<div class="col-md-12 text-left">
							<label for="Ordenamento">Ordenamento:</label>
							<div class="form-group">
								<div class="row">
									<div class="col-md-4">
										<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" 
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
										<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" 
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
