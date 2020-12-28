<?php if ($msg) echo $msg; ?>

<div class="col-sm-offset-2 col-md-8 ">	
	
	<?php echo validation_errors(); ?>

	<div class="panel panel-primary">

		<div class="panel-heading">
			<?php echo form_open('relatorio/receitas', 'role="form"'); ?>
			
			<button  class="btn btn-sm btn-info" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
				<span class="glyphicon glyphicon-search"></span><?php echo $titulo; ?>
			</button>											
			<a class="btn btn-sm btn-warning" href="<?php echo base_url() ?>relatorio/parcelas" role="button">
				<span class="glyphicon glyphicon-search"></span>Parcelas
			</a>
			<button  class="btn btn-sm btn-success" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
				<span class="glyphicon glyphicon-plus"></span>Rec.
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
							<p>Ao confirmar esta opera��o todos os dados ser�o exclu�dos permanentemente do sistema. 
								Esta opera��o � irrevers�vel.</p>
						</div>
						-->
						<div class="modal-footer">
							<div class="form-group col-md-3 text-left">
								<div class="form-footer">
									<button  class="btn btn-info btn-block"" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
										<span class="glyphicon glyphicon-search"></span> Pesquisar
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
							<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtros da Receitas</h4>
						</div>
						<div class="modal-footer">
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
								<div class="col-md-3 text-left" >
									<label for="Ordenamento">M�s do Venc.:</label>
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
									<label for="Ordenamento">M�s do Pag.:</label>
									<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block" 
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
										<a class="btn btn-warning btn-block" href="<?php echo base_url() ?>relatorio/parcelas" role="button">
											<span class="glyphicon glyphicon-search"></span> Parcelas
										</a>
									</div>	
								</div>
							</div>
							<div class="row">
								
								<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
								
								<div class="col-md-3 text-left">
									<label for="AprovadoOrca">Aprovado</label>
									<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block " 
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
									<label for="ConcluidoOrca">Entregue</label>
									<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block" 
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
								<div class="col-md-3 text-left">
									<label for="QuitadoOrca">Quitado</label>
									<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block " 
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
									<label for="Ordenamento">Tipo de Receita:</label>
									<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block" 
											id="TipoFinanceiro" name="TipoFinanceiro">
										<?php
										foreach ($select['TipoFinanceiro'] as $key => $row) {
											if ($query['TipoFinanceiro'] == $key) {
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
									<label for="Ordenamento">Nome do Cliente:</label>
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
								<?php } ?>
								<div class="col-md-3 text-left">
									<label for="Modalidade">Modalidade</label>
									<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block " 
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
						</div>									
					</div>								
				</div>
			</div>																				
		</form>
		<?php echo (isset($list)) ? $list : FALSE ?>
		</div>
	</div>

</div>
	
