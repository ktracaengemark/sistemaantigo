<nav class="navbar navbar-inverse navbar-fixed-top " role="banner">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-9 ">
				<div class="navbar-header ">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar1">
						<span class="sr-only">MENU</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?php echo base_url() ?>acesso/index"> 
						 <?php echo $_SESSION['log']['Nome2']; ?>./<?php echo $_SESSION['log']['NomeEmpresa2']; ?>.
					</a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar1">

					<ul class="nav navbar-nav navbar-center">
						<!--
						<li>
							<?php echo form_open(base_url() . 'consultor/pesquisar', 'class="navbar-form navbar-left"'); ?>
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
						-->
						<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
							<div class="btn-group " role="group" aria-label="...">
								<a href="<?php echo base_url(); ?>agenda">
									<button type="button" class="btn btn-md btn-info ">
										<span class="glyphicon glyphicon-calendar"></span>Agenda
									</button>
								</a>
							</div>
							
						</li>
						

						<?php if ($_SESSION['log']['NivelEmpresa'] >= 3 ) { ?>
						<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
							<div class="btn-group " role="group" aria-label="...">
								<a href="<?php echo base_url(); ?>relatorio/clientes">
									<button type="button" class="btn btn-md btn-success ">
										<span class="glyphicon glyphicon-user"></span> Clientes
									</button>
								</a>
							</div>
							
						</li>
						<?php } ?>
						
						<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
							<div class="btn-group">
								<button type="button" class="btn btn-md btn-warning dropdown-toggle" data-toggle="dropdown">
									<span class="glyphicon glyphicon-usd"></span> Finanças <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">							
									<li><a href="<?php echo base_url() ?>relatorio/receitas"><span class="glyphicon glyphicon-pencil"></span> Receitas</a></li>
									<li role="separator" class="divider"></li>							
									<li><a href="<?php echo base_url() ?>relatorio/despesas"><span class="glyphicon glyphicon-pencil"></span> Despesas</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatorio/balanco"><span class="glyphicon glyphicon-usd"></span> Balanço</a></li>
								</ul>
							</div>
							
						</li>
						
						<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
							<div class="btn-group">
								<button type="button" class="btn btn-md btn-primary dropdown-toggle" data-toggle="dropdown">
									<span class="glyphicon glyphicon-home"></span>Encontre aqui<span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">							
									<li><a href="<?php echo base_url() ?>relatorio/empresas"><span class="glyphicon glyphicon-home"></span> Empresas</a></li>
									<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
									<li role="separator" class="divider"></li>							
									<li><a href="<?php echo base_url() ?>relatorio/produtos"><span class="glyphicon glyphicon-pencil"></span> Produtos</a></li>
									<?php } ?>
									<?php if ($_SESSION['log']['NivelEmpresa'] >= 3 ) { ?>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatorio/empresas"><span class="glyphicon glyphicon-pencil"></span> Dicas</a></li>
									<?php } ?>
									<!--<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>login/sair"><span class="glyphicon glyphicon-log-out"></span> Sair</a></li>-->
								</ul>
							</div>
							
						</li>
						
						<li class="btn-toolbar navbar-form navbar-right" role="toolbar" aria-label="...">
							<div class="btn-group" role="group" aria-label="...">
								<a href="<?php echo base_url(); ?>login/sair">
									<button type="button" class="btn btn-md btn-danger ">
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
