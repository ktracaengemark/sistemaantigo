<nav class="navbar navbar-inverse navbar-fixed-top " role="banner">
	<div class="container-fluid">
		<div class="navbar-header ">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="sr-only">MENU</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a type="button" class="navbar-toggle btn btn-lg btn-primary  " href="javascript:window.close()">
				<span class="glyphicon glyphicon-remove"></span> Fechar
			</a>			
		</div>
		<div class="collapse navbar-collapse" id="myNavbar">		
			<ul class="nav navbar-nav navbar-center">
				<li class="btn-toolbar btn-lg navbar-form" role="toolbar" aria-label="...">
					<div class="btn-group " role="group" aria-label="...">
						<a  type="button" class="btn btn-danger btn-lg" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
							<span class="glyphicon glyphicon-plus"></span>Novo
						</a>						
					</div>					
				</li>
				<li class="btn-toolbar btn-lg navbar-form" role="toolbar" aria-label="...">
					<div class="btn-group " role="group" aria-label="...">
						<a href="<?php echo base_url(); ?>relatorio2/produtos2" role="button">
							<button type="button" class="btn btn-lg btn-default ">
								<span class="glyphicon glyphicon-calendar"></span>Valores
							</button>
						</a>						
					</div>					
				</li>
				<li class="btn-toolbar btn-lg navbar-form" role="toolbar" aria-label="...">
					<div class="btn-group " role="group" aria-label="...">
						<a type="button" class="btn btn-lg btn-default " href="javascript:window.close()">
							<span class="glyphicon glyphicon-remove"></span>Fechar
						</a>
					</div>					
				</li>				
			</ul>			
		</div>
	</div>
</nav>	
<br>
<?php if (isset($msg)) echo $msg; ?>

<div class="col-sm-offset-2 col-md-8 ">		
	
	<?php echo validation_errors(); ?>
	
	<div class="panel panel-primary">
		<div class="panel-heading">
			<div class="btn-group " role="group" aria-label="...">
				<div class="row text-left">	
					<div class="col-md-12">
						<button  class="btn btn-sm btn-warning" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
							<span class="glyphicon glyphicon-filter"></span>Filtrar Estoque
						</button>
					</div>
				</div>
			</div>		
		</div>		
		<?php echo (isset($list)) ? $list : FALSE ?>	
	</div>
</div>
<?php echo form_open('relatorio2/estoque2', 'role="form"'); ?>
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
						<a class="btn btn-danger btn-block" href="<?php echo base_url() ?>produtos2/cadastrar3" role="button">
							<span class="glyphicon glyphicon-plus"></span> Novo
						</a>
					</div>	
				</div>
				<?php } else {?>
				<div class="form-group col-md-4 text-right">
					<div class="form-footer">		
						<a class="btn btn-danger btn-block" href="<?php echo base_url() ?>produtos2/cadastrar2" role="button">
							<span class="glyphicon glyphicon-plus"></span> Novo
						</a>
					</div>	
				</div>
				<?php } ?>
				<div class="form-group col-md-4">
					<div class="form-footer ">
						<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">
							<span class="glyphicon glyphicon-remove"></span> Fechar
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
				<div class="form-group">
					<div class="row text-left">
						<div class="col-md-12">
							<label for="Ordenamento">Produto</label>
							<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
									id="Produtos" autofocus name="Produtos">
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
				<div class="form-group">
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
							<label for="Ordenamento">Tipo</label>
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
						<div class="col-md-4">
							<label for="Ordenamento">Esp.</label>
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
					</div>
				</div>				
				<div class="form-group">
					<div class="row text-left">						
						<div class="col-md-8">
							<label for="Ordenamento">Ordenamento:</label>
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
				<div class="form-group">	
					<div class="row text-left">
						<div class="col-md-4">
							<label for="DataInicio">Data Início: *</label>
							<div class="input-group DatePicker">
								<span class="input-group-addon" disabled>
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
								<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
									   name="DataInicio" value="<?php echo set_value('DataInicio', $query['DataInicio']); ?>">
								
							</div>
						</div>
						<div class="col-md-4">
							<label for="DataFim">Data Fim: (opc.)</label>
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
				<?php } ?>
				<div class="row text-left">
					<div class="form-group col-md-4">
						<div class="form-footer ">
							<button class="btn btn-warning btn-block" name="pesquisar" value="0" type="submit">
								<span class="glyphicon glyphicon-filter"></span> Filtrar
							</button>
						</div>
					</div>
					
					<div class="form-group col-md-4">
						<div class="form-footer">		
							<a class="btn btn-default btn-block" href="<?php echo base_url() ?>relatorio2/produtos2" role="button">
								<span class="glyphicon glyphicon-usd"></span> Valores
							</a>
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
			</div>									
		</div>								
	</div>
</div>