<nav class="navbar navbar-inverse navbar-fixed-top " role="banner">

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
						<!--
						<li class="btn-toolbar btn-lg navbar-form" role="toolbar" aria-label="...">
							<div class="btn-group " role="group" aria-label="...">
								<a href="<?php echo base_url(); ?>agenda">
									<button type="button" class="btn btn-lg btn-info ">
										<span class="glyphicon glyphicon-calendar"></span> Agendas & Tarefas
									</button>
								</a>
							</div>
						</li>
						-->
						<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
							<div class="btn-group">
								<a type="button" class="btn btn-lg btn-info" role="button" href="<?php echo base_url(); ?>agenda">
									<span class="glyphicon glyphicon-calendar"></span> 
									<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
									Agendas & Tarefas
									<?php } else {?>
									Agenda & Tarefas
									<?php } ?>
								</a>
								<button type="button" class="btn btn-lg btn-info dropdown-toggle dropdown-toggle-split" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">							
									<li><a class="dropdown-item" href="<?php echo base_url() ?>relatorio/tarefa"><span class="glyphicon glyphicon-pencil"></span> Estatística das Tarefas </a></li>
								</ul>
							</div>							
						</li>						
						<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
							<div class="btn-group">
								<a type="button" class="btn btn-lg btn-primary" role="button" href="<?php echo base_url(); ?>orcatrata/cadastrar3">
									<span class="glyphicon glyphicon-plus"></span> 
									<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
									Receitas & Vendas
									<?php } else {?>
									Receitas
									<?php } ?>
								</a>
								<button type="button" class="btn btn-lg btn-primary dropdown-toggle dropdown-toggle-split" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">							
									<li><a class="dropdown-item" href="<?php echo base_url() ?>relatorio/parcelasrec"><span class="glyphicon glyphicon-pencil"></span> Relatório das Receitas</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatorio/rankingreceitas"><span class="glyphicon glyphicon-equalizer"></span> Estatística das Receitas</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatorio/balanco"><span class="glyphicon glyphicon-usd"></span> Balanço</a></li>
									
									<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
									<li role="separator" class="divider"></li>							
									<li><a href="<?php echo base_url() ?>relatorio/fiadorec"><span class="glyphicon glyphicon-usd"></span> Fiado</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatorio/rankingvendas"><span class="glyphicon glyphicon-pencil"></span> Ranking de Vendas</a></li>
									<?php } ?>
									
								</ul>
							</div>							
						</li>
						<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
							<div class="btn-group">
								<a type="button" class="btn btn-lg btn-danger" role="button" href="<?php echo base_url(); ?>orcatrata/cadastrardesp">
									<span class="glyphicon glyphicon-plus"></span> 
									<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
									Despesas & Compras
									<?php } else {?>
									Despesas
									<?php } ?>
								</a>
								<button type="button" class="btn btn-lg btn-danger dropdown-toggle dropdown-toggle-split" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">							
									<li><a class="dropdown-item" href="<?php echo base_url() ?>relatorio/parcelasdesp"><span class="glyphicon glyphicon-pencil"></span> Relatório das Despesas</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatorio/rankingdespesas"><span class="glyphicon glyphicon-equalizer"></span> Estatística das Despesas</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatorio/balanco"><span class="glyphicon glyphicon-usd"></span> Balanço</a></li>
									<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
									<li role="separator" class="divider"></li>							
									<li><a href="<?php echo base_url() ?>relatorio/fiadodesp"><span class="glyphicon glyphicon-usd"></span> Fiado</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatorio/rankingcompras"><span class="glyphicon glyphicon-pencil"></span> Ranking de Compras</a></li>
									<?php } ?>									
								</ul>
							</div>							
						</li>
						<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
						<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">
							<div class="btn-group">
								<button type="button" class="btn btn-lg btn-warning dropdown-toggle" data-toggle="dropdown">
									<span class="glyphicon glyphicon-pencil"></span> Cadastros & Relatórios  <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">							
									<li><a href="<?php echo base_url() ?>relatorio/clientes"><span class="glyphicon glyphicon-user"></span> Clientes </a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatorio/fornecedor"><span class="glyphicon glyphicon-user"></span> Fornecedores </a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>login/registrar2"><span class="glyphicon glyphicon-user"></span> Conta Pessoal</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatorio/produtos"><span class="glyphicon glyphicon-usd"></span> Produtos & Valores </a></li>
									<li role="separator" class="divider"></li>							
									<li><a href="<?php echo base_url() ?>relatorio/estoque"><span class="glyphicon glyphicon-gift"></span> Produtos & Estoque</a></li>							
									<li role="separator" class="divider"></li>							
									<li><a href="<?php echo base_url() ?>relatorio/compvend"><span class="glyphicon glyphicon-pencil"></span> Produtos Comprados </a></li>
									<li role="separator" class="divider"></li>							
									<li><a href="<?php echo base_url() ?>relatorio/compvend"><span class="glyphicon glyphicon-pencil"></span> Produtos Vendidos</a></li>

									<?php if ($_SESSION['log']['idSis_Empresa'] == 2 ) { ?>
									<li role="separator" class="divider"></li>							
									<li><a href="<?php echo base_url() ?>relatorio/clenkontraki"><span class="glyphicon glyphicon-list-alt"></span> Clientes Enkontraki</a></li>									
									<?php } ?>
								</ul>
							</div>
						</li>
						<?php } ?>
						<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">								
							<div class="btn-group">
								<button type="button" class="btn btn-lg btn-default dropdown-toggle" data-toggle="dropdown">
									
									<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) && ($_SESSION['log']['idSis_Empresa'] != 5))  { ?>
										<span class="glyphicon glyphicon-hand-right"></span>
										<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); $intervalo = $data1->diff($data2); echo $intervalo->format('%a dias'); ?> 
										 / <span class="glyphicon glyphicon-home"></span> Admin / Sair
									<?php } else if ($_SESSION['log']['idSis_Empresa'] != 5){?>
										<span class="glyphicon glyphicon-warning-sign"></span> Renovar ! 
										<span class="glyphicon glyphicon-home"></span> Admin / Sair
									<?php } else {?>
										<span class="glyphicon glyphicon-home"></span> enkontraki / Sair
									<?php } ?>
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">							
									<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
									<li><a href="<?php echo base_url() ?>relatorio/loginempresa"><span class="glyphicon glyphicon-pencil"></span> Administração</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatorio/loginempresa"><span class="glyphicon glyphicon-pencil"></span> Funcionários</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatorio/loginempresa"><span class="glyphicon glyphicon-pencil"></span> Renovar Assinatura</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatorio/loginempresa"><span class="glyphicon glyphicon-pencil"></span> Cadastrar Empresa</a></li>
									<li role="separator" class="divider"></li>
									<?php } ?>
									<li><a href="<?php echo base_url() ?>relatorio/empresas"><span class="glyphicon glyphicon-home"></span> Empresas</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>login/sair"><span class="glyphicon glyphicon-log-out"></span> Sair do Sistema</a></li>
								</ul>
							</div>
						</li>	
						<!--
						<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">		
							<div class="btn-group " role="group" aria-label="...">
								<a href="<?php echo base_url(); ?>login/sair">
									<button type="button" class="btn btn-sm btn-active ">
										<span class="glyphicon glyphicon-log-out"></span> Sair
									</button>
								</a>
							</div>							
						</li>
						-->
					</ul>
				</div>			
			</div>

</nav>
<br>