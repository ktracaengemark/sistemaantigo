<?php if ($msg) echo $msg; ?>

<div class="container-fluid">
    <div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8 ">


			<?php echo validation_errors(); ?>

			<div class="panel panel-primary">

				<div class="panel-heading">
				
					<?php echo form_open('relatorio/produtos', 'role="form"'); ?>
				
					<button  class="btn btn-sm btn-warning" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
						<span class="glyphicon glyphicon-filter"></span>Filtro <!--<?php #echo $titulo; ?>-->
					</button>											
					<a class="btn btn-sm btn-default" href="<?php echo base_url() ?>relatorio/estoque" role="button">
						<span class="glyphicon glyphicon-search"></span>Estoque
					</a>
					<button  class="btn btn-sm btn-default" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
						<span class="glyphicon glyphicon-plus"></span>Produto
					</button>

				</div>
				<div class="panel-body">

					<div class="modal fade bs-excluir-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header bg-danger">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title">Evite cadastrar Produtos REPETIDOS!<br>
															"Pesquise" os Produtos Cadastradas!</h4>
								</div>
								<!--
								<div class="modal-body">
									<p>Pesquise os Produtos Cadastrados!!</p>
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
									<?php if ($_SESSION['log']['TabelasEmpresa'] == 1) { ?>
									<div class="form-group col-md-4 text-right">
										<div class="form-footer">		
											<a class="btn btn-danger btn-block" href="<?php echo base_url() ?>produtos/cadastrar1" role="button">
												<span class="glyphicon glyphicon-plus"></span> Produtos
											</a>
										</div>	
									</div>
									<?php } else {?>
									<div class="form-group col-md-4 text-right">
										<div class="form-footer">		
											<a class="btn btn-danger btn-block" href="<?php echo base_url() ?>produtos/cadastrar" role="button">
												<span class="glyphicon glyphicon-plus"></span> Produtos
											</a>
										</div>	
									</div>
									<?php } ?>
									<div class="form-group col-md-4">
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

					<div class="modal fade bs-excluir-modal2-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
						<div class="modal-dialog modal-md" role="document">
							<div class="modal-content">
								<div class="modal-header bg-danger">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtros dos Produtos</h4>
								</div>
								<div class="modal-footer">
									
									<div class="row text-left">
										
										<div class="col-md-6">
											<label for="Ordenamento">Desccrição</label>
											<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
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
			
										<div class="col-md-6">
											<label for="Ordenamento">Ordenamento:</label>

											<div class="form-group">
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

									<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
									<div class="row text-left">
										<div class="col-md-4">
											<label for="Ordenamento">Categoria</label>
											<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
													id="Prodaux3" name="Prodaux3">
												<?php
												foreach ($select['Prodaux3'] as $key => $row) {
													if ($query['Prodaux3'] == $key) {
														echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
													} else {
														echo '<option value="' . $key . '">' . $row . '</option>';
													}
												}
												?>
											</select>
										</div>
										<div class="col-md-4">
											<label for="Ordenamento">Aux1</label>
											<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
													id="Prodaux1" name="Prodaux1">
												<?php
												foreach ($select['Prodaux1'] as $key => $row) {
													if ($query['Prodaux1'] == $key) {
														echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
													} else {
														echo '<option value="' . $key . '">' . $row . '</option>';
													}
												}
												?>
											</select>
										</div>
										<div class="col-md-4">
											<label for="Ordenamento">Aux2</label>
											<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
													id="Prodaux2" name="Prodaux2">
												<?php
												foreach ($select['Prodaux2'] as $key => $row) {
													if ($query['Prodaux2'] == $key) {
														echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
													} else {
														echo '<option value="' . $key . '">' . $row . '</option>';
													}
												}
												?>
											</select>
										</div>
									</div>
									<?php } ?>
									<div class="row text-left">
										<br>
										<div class="form-group col-md-4">
											<div class="form-footer ">
												<button class="btn btn-success btn-block" name="pesquisar" value="0" type="submit">
													<span class="glyphicon glyphicon-filter"></span> Filtrar
												</button>
											</div>
										</div>
										<div class="form-group col-md-4">
											<div class="form-footer">		
												<a class="btn btn-warning btn-block" href="<?php echo base_url() ?>relatorio/estoque" role="button">
													<span class="glyphicon glyphicon-search"></span> Estoque
												</a>
											</div>	
										</div>
										<div class="form-group col-md-4">
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

					</form>

				<?php echo (isset($list)) ? $list : FALSE ?>
				</div>
			</div>

		</div>	
		<div class="col-md-2"></div>			
    </div>
</div>
