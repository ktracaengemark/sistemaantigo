<nav class="navbar navbar-inverse navbar-fixed-top " role="banner">
	<div class="container-fluid">
		<div class="row">

			<div class="col-md-12 ">
				<div class="navbar-header ">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar1">
						<span class="sr-only">MENU</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?php echo base_url() ?>usuario2/prontuario/<?php echo $_SESSION['log']['id']; ?>"> 
						 <?php echo $_SESSION['log']['Nome2']; ?>./<?php echo $_SESSION['log']['NomeEmpresa2']; ?>.
					</a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar1">

					<ul class="nav navbar-nav navbar-center">
						<!--
						<li>
							<?php echo form_open(base_url() . 'cliente/pesquisar', 'class="navbar-form navbar-left"'); ?>
							<div class="input-group">
								<span class="input-group-btn">
									<button class="btn btn-info" type="submit">
										<span class="glyphicon glyphicon-search"></span>
									</button>
								</span>
								<input type="text" placeholder="Pesquisar Cliente" class="form-control" name="Pesquisa" value="">
							</div>
							</form>
						</li>
						
						<li>
							<?php echo form_open(base_url() . 'empresacli/pesquisar', 'class="navbar-form navbar-left"'); ?>
							<div class="input-group">
								<span class="input-group-btn">
									<button class="btn btn-info" type="submit">
										<span class="glyphicon glyphicon-search"></span>
									</button>
								</span>
								<input type="text" placeholder="Pesquisar Empresa" class="form-control" name="Pesquisa" value="">
							</div>
							</form>
						</li>
						-->
						<li class="btn-toolbar btn-lg navbar-form" role="toolbar" aria-label="...">
							<div class="btn-group " role="group" aria-label="...">
								<a href="<?php echo base_url(); ?>agenda">
									<button type="button" class="btn btn-lg btn-info ">
										<span class="glyphicon glyphicon-calendar"></span> Agenda
									</button>
								</a>
							</div>
						</li>
						<?php if ($_SESSION['log']['NivelEmpresa'] >= 3 ) { ?>
						<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">
							
							<div class="btn-group " role="group" aria-label="...">
								<a href="<?php echo base_url(); ?>relatorio/clientes">
									<button type="button" class="btn btn-sm btn-warning ">
										<span class="glyphicon glyphicon-user"></span> Clientes
									</button>
								</a>
							</div>
							<div class="btn-group">
								<button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">
									<span class="glyphicon glyphicon-user"></span> Fornecedores <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">							
									<li><a href="<?php echo base_url() ?>relatorio/fornecedor"><span class="glyphicon glyphicon-user"></span> Lista de Fornecedores</a></li>
									<li role="separator" class="divider"></li>							
									<li><a href="<?php echo base_url() ?>atividade/cadastrar"><span class="glyphicon glyphicon-list-alt"></span> Atividade dos Fornecedores</a></li>									
								</ul>
							</div>																				
							
						</li>
						<?php } ?>
						<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">
							<div class="btn-group " role="group" aria-label="...">
								<a href="<?php echo base_url(); ?>orcatrata/cadastrar3">
									<button type="button" class="btn btn-lg btn-primary ">
										<span class="glyphicon glyphicon-plus"></span>Receitas
									</button>
								</a>
							</div>
							<div class="btn-group " role="group" aria-label="...">
								<a href="<?php echo base_url(); ?>orcatrata/cadastrardesp">
									<button type="button" class="btn btn-lg btn-danger ">
										<span class="glyphicon glyphicon-plus"></span>Despesas
									</button>
								</a>
							</div>														
						</li>
						<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">
							<div class="btn-group">
								<button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
									<span class="glyphicon glyphicon-usd"></span> Financeiro <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">							
									<li><a href="<?php echo base_url() ?>relatorio/financeiro"><span class="glyphicon glyphicon-usd"></span> Orçamentos</a></li>
									<li role="separator" class="divider"></li>							
									<li><a href="<?php echo base_url() ?>relatorio/parcelas"><span class="glyphicon glyphicon-usd"></span> Receber X Pagar</a></li>
									<li role="separator" class="divider"></li>							
									<li><a href="<?php echo base_url() ?>relatorio/balanco"><span class="glyphicon glyphicon-usd"></span> Balanço</a></li>
									<?php if ($_SESSION['log']['NivelEmpresa'] >= 3 ) { ?>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatorio/rankingvendas"><span class="glyphicon glyphicon-pencil"></span> Ranking de Vendas</a></li>
									<?php } ?>
								</ul>
							</div>							
							<?php if ($_SESSION['log']['NivelEmpresa'] >= 3 ) { ?>
							<div class="btn-group">
								<button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
									<span class="glyphicon glyphicon-gift"></span> Produtos <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">							
									<li><a href="<?php echo base_url() ?>relatorio/produtos"><span class="glyphicon glyphicon-usd"></span> Produtos & Valores</a></li>
									<li role="separator" class="divider"></li>							
									<li><a href="<?php echo base_url() ?>relatorio/estoque"><span class="glyphicon glyphicon-list-alt"></span> Estoque de Produtos</a></li>
									<li role="separator" class="divider"></li>							
									<li><a href="<?php echo base_url() ?>Prodaux3/cadastrar"><span class="glyphicon glyphicon-list"></span> Lista de Categoria</a></li>										
									<li role="separator" class="divider"></li>										
									<li><a href="<?php echo base_url() ?>relatorio/produtosvend"><span class="glyphicon glyphicon-pencil"></span> Produtos & Cliente</a></li>
									<li role="separator" class="divider"></li>									
									<li><a data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal3-sm"><span class="glyphicon glyphicon-plus"></span> Novo Produto</a></li>
								</ul>
							</div>																				
							<?php } ?>
						</li>
						
						<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">						
							<div class="btn-group">
								<button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
									<span class="glyphicon glyphicon-home"></span> enkontraki <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">							
									<?php if ($_SESSION['log']['NivelEmpresa'] >= 3 ) { ?>
									
									<li><a href="<?php echo base_url() ?>relatorio/empresas"><span class="glyphicon glyphicon-pencil"></span> Dicas de Negócios</a></li>
									<li role="separator" class="divider"></li>									
									<?php } ?>
									<li><a href="<?php echo base_url() ?>relatorio/empresas"><span class="glyphicon glyphicon-home"></span> Outras Empresas</a></li>
								</ul>
							</div>
							<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) && ($_SESSION['log']['idSis_Empresa'] != 5))  { ?>
							<div class="btn-group" role="group" aria-label="...">
								<a href="<?php echo base_url(); ?>relatorio/loginempresa"> 	
									<button type="button" class="btn btn-sm btn-default ">Renovar em: 
										<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); $intervalo = $data1->diff($data2); echo $intervalo->format('%a dias'); ?>
									</button>
								</a>	
							</div>
							<?php } else if ($_SESSION['log']['idSis_Empresa'] != 5){?>
							<div class="btn-group" role="group" aria-label="...">
								<a href="<?php echo base_url(); ?>relatorio/loginempresa"> 	
									<button type="button" class="btn btn-sm btn-default ">Renovar !!! 
										
									</button>
								</a>	
							</div>
							<?php } ?>
						</li>	
						<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">		
							<div class="btn-group " role="group" aria-label="...">
								<a href="<?php echo base_url(); ?>login/sair">
									<button type="button" class="btn btn-sm btn-active ">
										<span class="glyphicon glyphicon-log-out"></span> Sair
									</button>
								</a>
							</div>							
						</li>
					</ul>
				</div>			
			</div>
		</div>
	</div>
</nav>
<br>

<div class="modal fade bs-excluir-modal3-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
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
				<!--
				<div class="form-group col-md-4 text-left">
					<div class="form-footer">
						<button  class="btn btn-info btn-block"" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
							<span class="glyphicon glyphicon-search"></span> Pesquisar
						</button>
					</div>
				</div>
				-->
				<div class="form-group col-md-4 text-right">
					<div class="form-footer">		
						<a class="btn btn-info btn-block" href="<?php echo base_url() ?>relatorio/produtos" role="button">
							<span class="glyphicon glyphicon-search"></span> Pesquisar
						</a>
					</div>	
				</div>				
				<?php if (($_SESSION['log']['NivelEmpresa'] >= 4) AND ($_SESSION['log']['NivelEmpresa'] <= 6 )) { ?>
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
							<span class="glyphicon glyphicon-remove"></span> Fechar
						</button>
					</div>
				</div>									
			</div>
		</div>
	</div>
</div>
