<?php if ($msg) echo $msg; ?>
<div class="col-md-2"></div>
<div class="col-md-8 ">		
	
	<div class="row">

		<div class="main">

			<?php echo validation_errors(); ?>

			<div class="panel panel-primary">

				<div class="panel-heading">
					<?php echo form_open('relatorio/despesas', 'role="form"'); ?>
					<?php #echo $titulo; ?>

					<button  class="btn btn-sm btn-info" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
						<span class="glyphicon glyphicon-search"></span>Despesas
					</button>											
					<a class="btn btn-sm btn-warning" href="<?php echo base_url() ?>relatorio/despesasparc" role="button">
						<span class="glyphicon glyphicon-ok"></span>Parcelas
					</a>
					<!--<a class="btn btn-sm btn-warning" href="<?php echo base_url() ?>orcatrata/alterarparceladesp" role="button">
						<span class="glyphicon glyphicon-ok"></span>Parcelas
					</a>-->
					<button  class="btn btn-sm btn-danger" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
						<span class="glyphicon glyphicon-plus"></span>Nova
					</button>		
					
				</div>
				<div class="panel-body">
					<div class="modal fade bs-excluir-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header bg-danger">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title">Evite cadastrar Receitas REPETIDAS!<br>
															"Pesquise"as Receitas Cadastradas!</h4>
								</div>
								<!--
								<div class="modal-body">
									<p>Ao confirmar esta operação todos os dados serão excluídos permanentemente do sistema. 
										Esta operação é irreversível.</p>
								</div>
								-->
								<div class="modal-footer">
									<div class="form-group col-md-4 text-left">
										<div class="form-footer">
											<button  class="btn btn-info btn-block"" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
												<span class="glyphicon glyphicon-search"></span> Pesquisar
											</button>
										</div>
									</div>
									<div class="form-group col-md-4 text-right">
										<div class="form-footer">		
											<a class="btn btn-danger btn-block" href="<?php echo base_url() ?>orcatrata/cadastrardesp" role="button">
												<span class="glyphicon glyphicon-plus"></span> Despesas
											</a>
										</div>	
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="modal fade bs-excluir-modal2-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header bg-danger">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtros das Despesas</h4>
								</div>
								<div class="modal-footer">
									<div class="row">
										<div class="col-md-3 text-left" >
											<label for="Ordenamento">Mês do Vencimento:</label>
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
											<label for="Ordenamento">Mês do Pagamento:</label>
											<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
													id="Mespag" name="Mespag">
												<?php
												foreach ($select['Mespag'] as $key => $row) {
													if ($query['Mespag'] == $key) {
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
										<div class="col-md-3 text-left">
											<label for="Ordenamento">Tipo de Receita:</label>
											<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
													id="TipoReceita" name="TipoReceita">
												<?php
												foreach ($select['TipoReceita'] as $key => $row) {
													if ($query['TipoReceita'] == $key) {
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
										
										<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
										
										<div class="col-md-3 text-left">
											<label for="AprovadoOrca">Aprovado</label>
											<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block " 
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
										<div class="col-md-3 text-left">
											<label for="ServicoConcluido">Entregue</label>
											<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
													id="ServicoConcluido" name="ServicoConcluido">
												<?php
												foreach ($select['ServicoConcluido'] as $key => $row) {
													if ($query['ServicoConcluido'] == $key) {
														echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
													} else {
														echo '<option value="' . $key . '">' . $row . '</option>';
													}
												}
												?>
											</select>
										</div>
										<div class="col-md-3 text-left">
											<label for="QuitadoOrca">Quitado</label>
											<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block " 
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
										
										<?php } ?>
										
										<div class="col-md-3 text-left">
											<label for="QuitadoRecebiveis">Parc. Quit.</label>
											<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
													id="QuitadoRecebiveis" name="QuitadoRecebiveis">
												<?php
												foreach ($select['QuitadoRecebiveis'] as $key => $row) {
													if ($query['QuitadoRecebiveis'] == $key) {
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
										<div class="form-group col-md-3 text-left">
											<div class="form-footer">		
												<a class="btn btn-warning btn-block" href="<?php echo base_url() ?>relatorio/despesasparc" role="button">
													<span class="glyphicon glyphicon-plus"></span> Editar Parcelas
												</a>
											</div>	
										</div>
									</div>
									
									<div class="row">	
										<div class="col-md-3 text-left">
											<label for="Modalidade">Modalidade</label>
											<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block " 
													id="Modalidade" name="Modalidade">
												<?php
												foreach ($select['Modalidade'] as $key => $row) {
													if ($query['Modalidade'] == $key) {
														echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
													} else {
														echo '<option value="' . $key . '">' . $row . '</option>';
													}
												}
												?>
											</select>
										</div>
										<div class="col-md-6 text-left">
											<label for="Ordenamento">Ordenamento:</label>
											<div class="form-group">
												<div class="row">
													<div class="col-md-6">
														<select data-placeholder="Selecione uma opção..." class="form-control btn-block Chosen " 
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

													<div class="col-md-6">
														<select data-placeholder="Selecione uma opção..." class="form-control btn-block Chosen" 
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
									<!--
									<div class="row">
										
										<div class="col-md-3">
											<label for="DataInicio3">Orç.- Data Inc.</label>
											<div class="input-group DatePicker btn-block">
												<span class="input-group-addon" disabled>
													<span class="glyphicon glyphicon-calendar"></span>
												</span>
												<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
														name="DataInicio3" value="<?php echo set_value('DataInicio3', $query['DataInicio3']); ?>">
												
											</div>
										</div>
										<div class="col-md-3">
											<label for="DataFim3">Orç.- Data Fim</label>
											<div class="input-group DatePicker btn-block">
												<span class="input-group-addon" disabled>
													<span class="glyphicon glyphicon-calendar"></span>
												</span>
												<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
														name="DataFim3" value="<?php echo set_value('DataFim3', $query['DataFim3']); ?>">
												
											</div>
										</div>
										
										<div class="col-md-3">
											<label for="DataInicio">Venc Dt Inc</label>
											<div class="input-group DatePicker btn-block">
												<span class="input-group-addon" disabled>
													<span class="glyphicon glyphicon-calendar"></span>
												</span>
												<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
														name="DataInicio" value="<?php echo set_value('DataInicio', $query['DataInicio']); ?>">
												
											</div>
										</div>
										<div class="col-md-3">
											<label for="DataFim">Venc Dt Fim</label>
											<div class="input-group DatePicker btn-block">
												<span class="input-group-addon" disabled>
													<span class="glyphicon glyphicon-calendar"></span>
												</span>
												<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
														name="DataFim" value="<?php echo set_value('DataFim', $query['DataFim']); ?>">
												
											</div>
										</div>
										<div class="col-md-3">
											<label for="DataInicio2">Pago Dt. Inc</label>
											<div class="input-group DatePicker btn-block">
												<span class="input-group-addon" disabled>
													<span class="glyphicon glyphicon-calendar"></span>
												</span>
												<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
														name="DataInicio2" value="<?php echo set_value('DataInicio2', $query['DataInicio2']); ?>">
												
											</div>
										</div>
										<div class="col-md-3">
											<label for="DataFim2">Pago Dt. Fim</label>
											<div class="input-group DatePicker btn-block">
												<span class="input-group-addon" disabled>
													<span class="glyphicon glyphicon-calendar"></span>
												</span>
												<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
														name="DataFim2" value="<?php echo set_value('DataFim2', $query['DataFim2']); ?>">
												
											</div>
										</div>
									</div>
									-->
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
<div class="col-md-2"></div>	

