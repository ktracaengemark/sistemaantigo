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
				<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
					<div class="btn-group " role="group" aria-label="...">
						<a href="<?php echo base_url(); ?>relatorioempresa/funcionario">
							<button type="button" class="btn btn-lg btn-warning ">
								<span class="glyphicon glyphicon-plus"></span> Funcionários
							</button>
						</a>
					</div>					
				</li>
				<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">				
					<div class="btn-group " role="group" aria-label="...">
						<a href="<?php echo base_url(); ?>relatorioempresa/login">
							<button type="button" class="btn btn-lg btn-info ">
								<span class="glyphicon glyphicon-log-in"></span> Acesso Empresa
							</button>
						</a>
					</div>
				</li>
				<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
					<div class="btn-group " role="group" aria-label="...">
						<a href="<?php echo base_url(); ?>relatorioempresa/associado">
							<button type="button" class="btn btn-lg btn-warning ">
								<span class="glyphicon glyphicon-plus"></span> Indicações
							</button>
						</a>
					</div>
				</li>				
				<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">								
					<div class="btn-group">
						<button type="button" class="btn btn-lg btn-default dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-home"></span> enkontraki
							<span class="caret"></span>
							<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) && ($_SESSION['log']['idSis_Empresa'] != 5))  { ?>
								<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); $intervalo = $data1->diff($data2); echo $intervalo->format('%a dias'); ?>
							<?php } else if ($_SESSION['log']['idSis_Empresa'] != 5){?>
								Renovar !!!
							<?php } ?>
						</button>
						<ul class="dropdown-menu" role="menu">							
							<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
							<li><a href="<?php echo base_url() ?>relatorioempresa/sistemaempresa"><span class="glyphicon glyphicon-pencil"></span> Renovar Assinatura</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url() ?>relatorio/empresas"><span class="glyphicon glyphicon-pencil"></span> Dicas de Negócios</a></li>
							<li role="separator" class="divider"></li>									
							<?php } ?>
							<li><a href="<?php echo base_url() ?>relatorio/empresas"><span class="glyphicon glyphicon-home"></span> Outras Empresas</a></li>
						</ul>
					</div>
				</li>				
				<li class="btn-toolbar navbar-form navbar-left" role="toolbar" aria-label="...">
					<div class="btn-group" role="group" aria-label="...">
						<a href="<?php echo base_url(); ?>login/sair">
							<button type="button" class="btn btn-sm btn-danger ">
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
