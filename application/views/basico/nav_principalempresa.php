<nav class="navbar navbar-inverse navbar-fixed-top " role="banner">

	<div class="col-sm-offset-2 col-md-8">
		<div class="navbar-header ">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar1">
				<span class="sr-only">MENU</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo base_url() ?>empresa/prontuario/<?php echo $_SESSION['log']['id']; ?>"> 
				<?php echo $_SESSION['log']['NomeEmpresa2']; ?>.
			</a>
			<!--<a class="navbar-brand" href="https://www.enkontraki.com"> Melhor loja</a>-->
		</div>
		<div class="collapse navbar-collapse" id="myNavbar1">

			<ul class="nav navbar-nav navbar-center">				
				<!--
				<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
					<div class="btn-group " role="group" aria-label="...">
						<a href="<?php echo base_url(); ?>relatorioempresa/funcionario">
							<button type="button" class="btn btn-md btn-primary ">
								<span class="glyphicon glyphicon-user"></span> Usuarios
							</button>
						</a>
					</div>
				</li>
				-->
				<li class="btn-toolbar navbar-form navbar-left" role="toolbar" aria-label="...">
					<div class="btn-group" role="group" aria-label="...">
						<a href="<?php echo base_url(); ?>relatorioempresa/sistemaempresa"> 	
							<button type="button" class="btn btn-md active "> Renovar em 
								<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); $intervalo = $data1->diff($data2); echo $intervalo->format('%a dias'); ?>
							</button>
						</a>	
					</div>
				</li>
				<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">
					<div class="btn-group">
						<button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-home"></span> enkontraki <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">							
							<li><a href="<?php echo base_url() ?>relatorioempresa/empresas"><span class="glyphicon glyphicon-home"></span> Empresas</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorioempresa/empresas"><span class="glyphicon glyphicon-pencil"></span> Dicas de Negócios</a></li>
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
</nav>
<br>
