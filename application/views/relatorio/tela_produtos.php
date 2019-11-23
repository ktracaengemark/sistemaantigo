<?php if (isset($msg)) echo $msg; ?>

<div class="col-sm-offset-2 col-md-8 ">		
	
	<?php echo validation_errors(); ?>
		
	<nav class="navbar navbar-center navbar-inverse navbar-fixed-top">
	  <div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span> 
			</button>
			<!--
			<a class="navbar-brand" href="<?php echo base_url() ?>orcatrata/cadastrar3/"> 
				 <span class="glyphicon glyphicon-plus"></span> Nova Produto
			</a>
			
			<a  class="navbar-brand" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
				<span class="glyphicon glyphicon-plus"></span>Produto
			</a>
			-->
		</div>
		<div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav navbar-center">
				<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">
					<div class="btn-group " role="group" aria-label="...">
						<a href="<?php echo base_url(); ?>agenda">
							<button type="button" class="btn btn-sm btn-info ">
								<span class="glyphicon glyphicon-calendar"></span> Agenda
							</button>
						</a>
					</div>
					<?php if ($_SESSION['log']['NivelEmpresa'] >= 3 ) { ?>
					<div class="btn-group " role="group" aria-label="...">
						<a href="<?php echo base_url(); ?>relatorio/clientes">
							<button type="button" class="btn btn-sm btn-success ">
								<span class="glyphicon glyphicon-user"></span> Clientes
							</button>
						</a>
					</div>
					<div class="btn-group">
						<button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-gift"></span> Produtos <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">							
							<li><a href="<?php echo base_url() ?>relatorio/produtos"><span class="glyphicon glyphicon-gift"></span> Produtos</a></li>
							<li role="separator" class="divider"></li>							
							<li><a href="<?php echo base_url() ?>relatorio/estoque"><span class="glyphicon glyphicon-list-alt"></span> Estoque</a></li>
						</ul>
					</div>																				
					<?php } ?>
				</li>						
				<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">
					<div class="btn-group " role="group" aria-label="...">
						<a <?php if (preg_match("/orcatrata\/cadastrar3\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
							<a href="<?php echo base_url() . 'orcatrata/cadastrar3/'; ?>">
								<button type="button" class="btn btn-sm btn-primary ">
									<span class="glyphicon glyphicon-plus"></span> Receita
								</button>										
							</a>
						</a>
					</div>
					<div class="btn-group " role="group" aria-label="...">
						<a <?php if (preg_match("/orcatrata\/cadastrardesp\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
							<a href="<?php echo base_url() . 'orcatrata/cadastrardesp/'; ?>">
								<button type="button" class="btn btn-sm btn-danger ">
									<span class="glyphicon glyphicon-plus"></span> Despesa
								</button>										
							</a>
						</a>
					</div>
					<div class="btn-group " role="group" aria-label="...">
						<a <?php if (preg_match("/relatorio\/financeiro\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
							<a href="<?php echo base_url() . 'relatorio/financeiro/'; ?>">
								<button type="button" class="btn btn-sm btn-success ">
									<span class="glyphicon glyphicon-list"></span> Relatório
								</button>										
							</a>
						</a>
					</div>																				
				</li>
				<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">
					<div class="btn-group " role="group" aria-label="...">
						<a href="javascript:window.print()">
							<button type="button" class="btn btn-sm btn-default ">
								<span class="glyphicon glyphicon-print"></span> Imprimir
							</button>
						</a>
					</div>
					<!--
					<div class="btn-group " role="group" aria-label="...">
						<a <?php if (preg_match("/relatorio\/estoque\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
							<a href="<?php echo base_url() . 'relatorio/estoque/'; ?>">
								<button type="button" class="btn btn-sm btn-default ">
									<span class="glyphicon glyphicon-edit"></span> Estoque
								</button>										
							</a>
						</a>
					</div>
					-->
					<div class="btn-group " role="group" aria-label="...">
						<button  class="btn btn-sm btn-default" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
							<span class="glyphicon glyphicon-filter"></span>Filtros
						</button>
					</div>
					<div class="btn-group " role="group" aria-label="...">
						<button  class="btn btn-sm btn-default" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
							<span class="glyphicon glyphicon-plus"></span>Produtos
						</button>
					</div>							
				</li>						
				<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
					<div class="btn-group " role="group" aria-label="...">
						<a <?php if (preg_match("/agenda/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
							<a href="<?php echo base_url() . 'agenda/'; ?>">
								<button type="button" class="btn btn-sm btn-active ">
									<span class="glyphicon glyphicon-remove"></span> Fechar
								</button>										
							</a>
						</a>
					</div>
					<div class="btn-group" role="group" aria-label="..."> </div>							
				</li>						
			</ul>
		</div>
	  </div>
	</nav>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<span class="glyphicon glyphicon-pencil"></span> PRODUTOS
		</div>		
		<?php echo (isset($list)) ? $list : FALSE ?>	
	</div>
</div>
<?php echo form_open('relatorio/produtos', 'role="form"'); ?>
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
				<?php if (($_SESSION['log']['NivelEmpresa'] >= 4) AND ($_SESSION['log']['NivelEmpresa'] <= 6 )) { ?>
				<div class="form-group col-md-4 text-right">
					<div class="form-footer">		
						<a class="btn btn-danger btn-block" href="<?php echo base_url() ?>produtos/cadastrar1" role="button">
							<span class="glyphicon glyphicon-plus"></span> Produtos1
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