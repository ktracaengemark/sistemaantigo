<?php if ($msg) echo $msg; ?>
<div class="col-md-2"></div>
<div class="col-md-8 ">		
	
	<div class="row">

		<div class="main">

			<?php echo validation_errors(); ?>

			<div class="panel panel-primary">

				<div class="panel-heading">
					<?php echo form_open('relatorio/receitasparc', 'role="form"'); ?>
					<?php #echo $titulo; ?>

					<button  class="btn btn-sm btn-warning" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
						<span class="glyphicon glyphicon-search"></span>Pc.Rec
					</button>											
					<a class="btn btn-sm btn-info" href="<?php echo base_url() ?>relatorio/balanco" role="button">
						<span class="glyphicon glyphicon-search"></span>Balan�o
					</a>
					<button  class="btn btn-sm btn-success" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
						<span class="glyphicon glyphicon-plus"></span>Receita
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
									<div class="form-group col-md-4 text-left">
										<div class="form-footer">
											<button  class="btn btn-info btn-block"" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
												<span class="glyphicon glyphicon-search"></span> Pesquisar
											</button>
										</div>
									</div>
									<div class="form-group col-md-4 text-right">
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
									<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtros das Parcelas</h4>
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
										<!--
										<div class="col-md-3 text-left" >
											<label for="Ordenamento">Dia do Venc.:</label>
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
										-->
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
											<label for="Ordenamento">Ano do Venc.:</label>
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
												<a class="btn btn-warning btn-block" href="<?php echo base_url() ?>relatorio/receitas" role="button">
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
				<?php echo (isset($list)) ? $list : FALSE ?>
				</div>
			</div>
		</div>
	</div>		
</div>
<div class="col-md-2"></div>	
