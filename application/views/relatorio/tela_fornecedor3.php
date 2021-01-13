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
<?php if ($msg) echo $msg; ?>
<div class="col-sm-offset-1 col-md-10">				
	<?php echo validation_errors(); ?>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<?php echo form_open('relatorio2/fornecedor3', 'role="form"'); ?>
			<button  class="btn btn-sm btn-warning" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
				<span class="glyphicon glyphicon-filter"></span> Filtros de Fornecedor<?php #echo $titulo; ?>
			</button>
		</div>				
		<div class="panel-body">
		</form>
		<?php echo (isset($list)) ? $list : FALSE ?>
		</div>
	</div>
</div>
	
<?php echo form_open('relatorio2/fornecedor3', 'role="form"'); ?>
<div class="modal fade bs-excluir-modal2-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header bg-danger">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtros do Fornecedor</h4>
			</div>
			<div class="modal-footer">
				<div class="form-group">
					<div class="row">
						<div class="col-md-8 text-left">
							<label for="Ordenamento">Nome do Fornecedor:</label>
							<div class="form-group">
								<div class="row">
									<div class="col-md-12">
										<select data-placeholder="Selecione uma opção..." class="form-control Chosen" onchange="this.form.submit()"
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
						</div>						
						<div class="col-md-4 text-left">
							<label for="Ativo">Ativo?</label>
							<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block"
									id="Ativo" name="Ativo">
								<?php
								foreach ($select['Ativo'] as $key => $row) {
									if ($query['Ativo'] == $key) {
										echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
									} else {
										echo '<option value="' . $key . '">' . $row . '</option>';
									}
								}
								?>
							</select>
						</div>														
						<div class="col-md-12 text-left">
							<label for="Ordenamento">Ordenamento:</label>
							<div class="form-group">
								<div class="row">
									<div class="col-md-8">
										<select data-placeholder="Selecione uma opção..." class="form-control Chosen" onchange="this.form.submit()"
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
										<select data-placeholder="Selecione uma opção..." class="form-control Chosen" onchange="this.form.submit()"
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
					<div class="row">
						<br>
						<div class="form-group col-md-3 text-left">
							<div class="form-footer ">
								<button class="btn btn-warning btn-block" name="pesquisar" value="0" type="submit">
									<span class="glyphicon glyphicon-filter"></span> Filtrar
								</button>
							</div>
						</div>
						<div class="form-group col-md-3 text-left">
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
</div>

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
				<div class="form-group col-md-4 text-right">
					<div class="form-footer">		
						<a class="btn btn-danger btn-block" href="<?php echo base_url() ?>fornecedor2/cadastrar3" role="button">
							<span class="glyphicon glyphicon-plus"></span> Novo Fornecedor
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
