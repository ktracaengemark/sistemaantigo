<?php if ($msg) echo $msg; ?>

<div class="col-md-6">		
	<?php echo validation_errors(); ?>
	<div class="panel panel-info">

		<div class="panel-heading">
			<?php echo form_open('relatorio/parcelas', 'role="form"'); ?>

				<!--<button  class="btn btn-sm btn-success" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal11-sm">
					<span class="glyphicon glyphicon-plus"></span>Rec.<?php #echo $titulo1; ?>
				</button>-->			
				
				<button  class="btn btn-sm btn-info" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
					<span class="glyphicon glyphicon-filter"></span>Filtrar <?php #echo $titulo1; ?>
				</button>
				<a href="<?php echo base_url() . 'orcatrata/alterarparcelarec/' . $_SESSION['log']['idSis_Empresa']; ?>">
					<button type="button" class="btn btn-sm btn-info">
						<span class="glyphicon glyphicon-edit"></span> Editar
					</button>
				</a>
				
				<button class="btn btn-sm btn-primary" type="button" data-toggle="collapse" data-target="#Receitas" aria-expanded="false" aria-controls="Receitas">
					<span class="glyphicon glyphicon-menu-up"></span> Fechar
				</button>																							
				<!--
				<a class="btn btn-sm btn-warning" href="<?php echo base_url() ?>relatorio/financeiro" role="button">
					<span class="glyphicon glyphicon-search"></span>Relat�rio
				</a>			
				<a class="btn btn-sm btn-success" href="<?php echo base_url() ?>relatorio/balanco" role="button">
					<span class="glyphicon glyphicon-search"></span>Balan�o 
				</a>
				-->
	
		</div>
		<div class="panel-body">
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
							<p>Ao confirmar esta opera��o todos os dados ser�o exclu�dos permanentemente do sistema. 
								Esta opera��o � irrevers�vel.</p>
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
							<?php if ($_SESSION['log']['idSis_Empresa'] != 5 ) { ?>
							<div class="form-group">	
								<div class="row">								
									<div class="col-md-9 text-left">
										<label for="Ordenamento">Cliente:</label>
										<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block" 
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
								</div>
							</div>
							<?php } ?>
							<!--
							<div class="form-group">								
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
							</div>
							-->
							<div class="form-group">
								<div class="row">
									<div class="col-md-3 text-left">
										<label for="Quitado">Parc. Quit.</label>
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
									<div class="col-md-4 text-left">
										<label for="DataInicio">Data In�cio: *</label>
										<div class="input-group DatePicker">
											<span class="input-group-addon" disabled>
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
											<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
												   autofocus name="DataInicio" value="<?php echo set_value('DataInicio', $query['DataInicio']); ?>">
											
										</div>
									</div>
									<div class="col-md-4 text-left">
										<label for="DataFim">Data Fim: (opcional)</label>
										<div class="input-group DatePicker">
											<span class="input-group-addon" disabled>
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
											<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
													name="DataFim" value="<?php echo set_value('DataFim', $query['DataFim']); ?>">
											
										</div>
									</div>											
								</div>
							</div>								
							<div class="form-group">
								<div class="row">
									<!--
									<div class="col-md-3 text-left" >
										<label for="Ordenamento">Or�am.Rec.:</label>
										<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block" 
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
									-->
									<div class="col-md-4 text-left">
										<label for="Ordenamento">Forma Pag.:</label>
										<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block" 
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
									<div class="col-md-4 text-left">
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
							</div>
							<!--
							<div class="row">	
								<div class="col-md-6 text-left">
									<label for="Ordenamento">Ordenamento:</label>
									<div class="form-group">
										<div class="row">
											<div class="col-md-6">
												<select data-placeholder="Selecione uma op��o..." class="form-control btn-block Chosen " 
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
												<select data-placeholder="Selecione uma op��o..." class="form-control btn-block Chosen" 
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
							-->
							<div class="row">
								<div class="form-group col-md-3 text-left">
									<div class="form-footer ">
										<button class="btn btn-info btn-block" name="pesquisar" value="0" type="submit">
											<span class="glyphicon glyphicon-filter"></span> Filtrar
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
			<div <?php echo $collapse; ?> id="Receitas">
				<?php echo (isset($list1)) ? $list1 : FALSE ?>
			</div>
		</div>
	</div>
</div>	
<div class="col-md-6 ">	
	<?php echo validation_errors(); ?>
	<div class="panel panel-danger">

		<div class="panel-heading">
			<?php echo form_open('relatorio/parcelas', 'role="form"'); ?>

				<!--<button  class="btn btn-sm btn-danger" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal13-sm">
					<span class="glyphicon glyphicon-plus"></span>Des.<?php #echo $titulo2; ?>
				</button>-->
				<button  class="btn btn-sm btn-danger" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal4-sm">
					<span class="glyphicon glyphicon-filter"></span>Filtrar <?php #echo $titulo2; ?>
				</button>
				<a href="<?php echo base_url() . 'orcatrata/alterarparceladesp/' . $_SESSION['log']['idSis_Empresa']; ?>">
					<button type="button" class="btn btn-sm btn-danger">
						<span class="glyphicon glyphicon-edit"></span> Editar
					</button>
				</a>
				
				<button class="btn btn-sm btn-primary" type="button" data-toggle="collapse" data-target="#Despesas" aria-expanded="false" aria-controls="Despesas">
					<span class="glyphicon glyphicon-menu-up"></span> Fechar
				</button>			
				<!--
				<a class="btn btn-sm btn-warning" href="<?php echo base_url() ?>relatorio/financeiro" role="button">
					<span class="glyphicon glyphicon-search"></span>Relat�rio
				</a>			
				<a class="btn btn-sm btn-success" href="<?php echo base_url() ?>relatorio/balanco" role="button">
					<span class="glyphicon glyphicon-search"></span>Balan�o
				</a>
				-->
	
		</div>
		<div class="panel-body">
			<div class="modal fade bs-excluir-modal13-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header bg-danger">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">Evite cadastrar DESPESAS Repetidas!<br>
													"Pesquise" as Despesas Cadastradas!</h4>
						</div>
						<!--
						<div class="modal-body">
							<p>Ao confirmar esta opera��o todos os dados ser�o exclu�dos permanentemente do sistema. 
								Esta opera��o � irrevers�vel.</p>
						</div>
						-->
						<div class="modal-footer">
							
							<!--<div class="form-group col-md-3 text-left">
								<div class="form-footer">
									<button  class="btn btn-warning btn-block"" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal4-sm">
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

							<div class="form-group col-md-3 text-right">
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

			<div class="modal fade bs-excluir-modal4-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content">
						<div class="modal-header bg-danger">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtros das Despesas</h4>
						</div>
						<div class="modal-footer">							
							<?php if ($_SESSION['log']['idSis_Empresa'] != 5 ) { ?>
							<div class="form-group">	
								<div class="row">
									<div class="col-md-9 text-left">
										<label for="Ordenamento">Fornecedor:</label>
										<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block" 
												id="NomeFornecedor" name="NomeFornecedor">
											<?php
											foreach ($select['NomeFornecedor'] as $key => $row) {
												if ($query['NomeFornecedor'] == $key) {
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
							<?php } ?>
							<!--
							<div class="form-group">
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
							</div>
							-->
							<div class="form-group">
								<div class="row">
									<div class="col-md-3 text-left">
										<label for="Quitado">Parc. Quit.</label>
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
									<div class="col-md-4 text-left">
										<label for="DataInicio">Data In�cio: *</label>
										<div class="input-group DatePicker">
											<span class="input-group-addon" disabled>
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
											<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
												   autofocus name="DataInicio" value="<?php echo set_value('DataInicio', $query['DataInicio']); ?>">
											
										</div>
									</div>
									<div class="col-md-4 text-left">
										<label for="DataFim">Data Fim: (opcional)</label>
										<div class="input-group DatePicker">
											<span class="input-group-addon" disabled>
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
											<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
													name="DataFim" value="<?php echo set_value('DataFim', $query['DataFim']); ?>">
											
										</div>
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
							</div>	
							<div class="form-group">
								<div class="row">
									<!--
									<div class="col-md-3 text-left" >
										<label for="Ordenamento">Or�am.Desp.:</label>
										<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block" 
												id="Orcades" name="Orcades">
											<?php
											foreach ($select['Orcades'] as $key => $row) {
												if ($query['Orcades'] == $key) {
													echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
												} else {
													echo '<option value="' . $key . '">' . $row . '</option>';
												}
											}
											?>
										</select>
									</div>
									-->
									<div class="col-md-4 text-left">
										<label for="Ordenamento">Forma Pag.:</label>
										<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block" 
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
									<div class="col-md-4 text-left">
										<label for="Ordenamento">Tipo Despesa:</label>
										<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block" 
												id="TipoFinanceiroD" name="TipoFinanceiroD">
											<?php
											foreach ($select['TipoFinanceiroD'] as $key => $row) {
												if ($query['TipoFinanceiroD'] == $key) {
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
							<!--
							<div class="row">	
								<div class="col-md-6 text-left">
									<label for="Ordenamento">Ordenamento:</label>
									<div class="form-group">
										<div class="row">
											<div class="col-md-6">
												<select data-placeholder="Selecione uma op��o..." class="form-control btn-block Chosen " 
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
												<select data-placeholder="Selecione uma op��o..." class="form-control btn-block Chosen" 
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
							-->
							<div class="row">
								<div class="form-group col-md-3 text-left">
									<div class="form-footer ">
										<button class="btn btn-info btn-block" name="pesquisar" value="0" type="submit">
											<span class="glyphicon glyphicon-filter"></span> Filtrar
										</button>
									</div>
								</div>

								<div class="form-group col-md-3 text-left">
									<div class="form-footer">		
										<a class="btn btn-danger btn-block" href="<?php echo base_url() ?>relatorio/financeiro" role="button">
											<span class="glyphicon glyphicon-search"></span> Despesas
										</a>
									</div>	
								</div>
							</div>							
						</div>
					</div>									
												
				</div>
			</div>																				
			</form>
			<div <?php echo $collapse; ?> id="Despesas">
				<?php echo (isset($list2)) ? $list2 : FALSE ?>
			</div>
		</div>
	</div>
</div>

