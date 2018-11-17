<?php if ($msg) echo $msg; ?>


	<div class="col-md-2"></div>
	<div class="col-md-8">
		
		<div class="row">

			<div class="main">

				<?php echo validation_errors(); ?>

				<div class="panel panel-primary">

					<div class="panel-heading">
						<?php echo form_open('relatorio/despesaspag', 'role="form"'); ?>
						<?php echo $titulo; ?>
						
						<button  class="btn btn-sm btn-info" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
							<span class="glyphicon glyphicon-search"></span> Pesquisar
						</button>
						<button  class="btn btn-sm btn-danger" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
							<span class="glyphicon glyphicon-plus"></span> Nova
						</button>					
					</div>
					<div class="panel-body">
												
							<div class="modal fade bs-excluir-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header bg-danger">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h4 class="modal-title">Para NÃO Cadastrar uma<br>
																	Despesa REPETIDA, "Pesquise"<br>
																	as Despesas Cadastradas!</h4>
										</div>
										<!--
										<div class="modal-body">
											<p>Ao confirmar esta operação todos os dados serão excluídos permanentemente do sistema. 
												Esta operação é irreversível.</p>
										</div>
										-->
										<div class="modal-footer text-left">
											<!--
											<div class="form-group text-left">
												<div class="row">		
													<div class="col-md-6 text-left">
														<a class="btn  btn-md btn-warning btn-block text-left" href="<?php echo base_url() ?>relatorio/despesas" role="button"> 
															<span class="glyphicon glyphicon-list"></span> Desp. Mensais Cads.
														</a>
													</div>
												</div>
											</div>
											-->
											<div class="form-group col-md-4 text-left">
												<div class="form-footer">
													<!--<button class="btn btn-success btn-block" name="pesquisar" value="0" type="submit">
														<span class="glyphicon glyphicon-filter"></span> Filtrar
													</button>-->
													<button  class="btn btn-info btn-block" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
														<span class="glyphicon glyphicon-search"></span> Pesquisar
													</button>
												</div>
											</div>
											<div class="form-group col-md-4 text-left">
												<div class="form-footer">		
													<a class="btn btn-danger btn-block " href="<?php echo base_url() ?>despesas/cadastrar" role="button">
														<span class="glyphicon glyphicon-plus"></span> Nova Despesa
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
													<div class="col-md-3 text-left">
														<label for="QuitadoPagaveis">Parc. Quit.?</label>
														<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
																id="QuitadoPagaveis" name="QuitadoPagaveis">
															<?php
															foreach ($select['QuitadoPagaveis'] as $key => $row) {
																if ($query['QuitadoPagaveis'] == $key) {
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
														<div class="form-footer">
															<button class="btn btn-success btn-block" name="pesquisar" value="0" type="submit">
																<span class="glyphicon glyphicon-filter"></span> Pesquisar
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
												<!--
												<div class="row">
													
													<div class="col-md-4 text-left" >
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
													<div class="col-md-4 text-left">
														<label for="QuitadoDespesas">Despesa Quit?</label>
														<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block " 
																id="QuitadoDespesas" name="QuitadoDespesas">
															<?php
															foreach ($select['QuitadoDespesas'] as $key => $row) {
																if ($query['QuitadoDespesas'] == $key) {
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
													<div class="col-md-3 text-left" >
														<label for="Ordenamento">Tipo de Desp.:</label>
														<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
																id="TipoDespesa" name="TipoDespesa">
															<?php
															foreach ($select['TipoDespesa'] as $key => $row) {
																if ($query['TipoDespesa'] == $key) {
																	echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																} else {
																	echo '<option value="' . $key . '">' . $row . '</option>';
																}
															}
															?>
														</select>
													</div>
													<div class="col-md-3 text-left">
														<label for="ModalidadeDespesas">Modalidade</label>
														<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block " 
																id="ModalidadeDespesas" name="ModalidadeDespesas">
															<?php
															foreach ($select['ModalidadeDespesas'] as $key => $row) {
																if ($query['ModalidadeDespesas'] == $key) {
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
														<div class="form-group btn-block">
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
																<div class="col-md-6">
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
												
												<!--
												<div class="row">	
													<div class="col-md-3  text-left">
														<label for="DataInicio">Venc.- Data Inc.</label>
														<div class="input-group DatePicker btn-block">
															<span class="input-group-addon" disabled>
																<span class="glyphicon glyphicon-calendar"></span>
															</span>
															<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
																	name="DataInicio" value="<?php echo set_value('DataInicio', $query['DataInicio']); ?>">
															
														</div>
													</div>	
													<div class="col-md-3 text-left">
														<label for="DataFim">Venc.- Data Fim</label>
														<div class="input-group DatePicker btn-block">
															<span class="input-group-addon" disabled>
																<span class="glyphicon glyphicon-calendar"></span>
															</span>
															<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
																	name="DataFim" value="<?php echo set_value('DataFim', $query['DataFim']); ?>">
															
														</div>
													</div>														
													<div class="col-md-3 text-left">
														<label for="DataInicio2">Pagam.- Data Inc.</label>
														<div class="input-group DatePicker btn-block">
															<span class="input-group-addon" disabled>
																<span class="glyphicon glyphicon-calendar"></span>
															</span>
															<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
																   autofocus name="DataInicio2" value="<?php echo set_value('DataInicio2', $query['DataInicio2']); ?>">
															
														</div>
													</div>	
													<div class="col-md-3 text-left">
														<label for="DataFim2">Pagam.- Data Fim</label>
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
					</div>
					</form>	
					<?php echo (isset($list)) ? $list : FALSE ?>
					
				</div>
					
			</div>

		</div>
	</div>
	<div class="col-md-2"></div>

