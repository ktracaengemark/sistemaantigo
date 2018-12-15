<nav class="navbar navbar-inverse navbar-fixed-top " role="banner">

	<div class="col-sm-offset-2 col-md-8">
		<div class="navbar-header ">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar1">
				<span class="sr-only">MENU</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo base_url() ?>empresa/prontuario/<?php echo $_SESSION['log']['id']; ?>"> 
				<?php echo $_SESSION['log']['NomeEmpresa2']; ?>.
			</a>
			<!--<a class="navbar-brand" href="http://www.ktracaengemark.com.br"> Melhor loja</a>-->
		</div>
		<div class="collapse navbar-collapse" id="myNavbar1">

			<ul class="nav navbar-nav navbar-center">				
				<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
					<div class="btn-group " role="group" aria-label="...">
						<a href="<?php echo base_url(); ?>relatorioempresa/funcionario">
							<button type="button" class="btn btn-md btn-primary ">
								<span class="glyphicon glyphicon-user"></span> Usuarios
							</button>
						</a>
					</div>
				</li>
				<li class="btn-toolbar navbar-form navbar-left" role="toolbar" aria-label="...">
					<div class="btn-group" role="group" aria-label="...">
						<a href="<?php echo base_url(); ?>relatorioempresa/sistemaempresa">	
							<button type="button" class="btn btn-md active " id="countdowndiv">Manutenção
								<span class="glyphicon glyphicon-hourglass" id="clock"></span>
							</button>
						</a>	
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
