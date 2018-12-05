<nav class="navbar navbar-inverse navbar-fixed-top " role="banner">

		<div class="col-md-2"></div>
		<div class="col-md-8">
			<div class="navbar-header ">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">MENU</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?php echo base_url() ?>acessoempresa/index"> 
					<?php echo $_SESSION['log']['Nome2']; ?>./ <?php echo $_SESSION['log']['NomeEmpresa2']; ?>.
				</a>
				<!--<a class="navbar-brand" href="http://www.ktracaengemark.com.br"> Melhor loja</a>-->
			</div>
			<div class="collapse navbar-collapse">

				<ul class="nav navbar-nav navbar-center">

					<li class="btn-toolbar navbar-form navbar-left" role="toolbar" aria-label="...">
						<div class="btn-group" role="group" aria-label="...">
							<a href="<?php echo base_url(); ?>relatorioempresa/empresas">
							<!--<a href="<?php #echo base_url(); ?>empresa/prontuario">-->
								<button type="button" class="btn btn-md btn-success ">
									<span class="glyphicon glyphicon-log-in"></span> Empresa
								</button>
							</a>
						</div>												
					</li>
					<li class="btn-toolbar navbar-form navbar-left" role="toolbar" aria-label="...">
						<div class="btn-group">
							<button type="button" class="btn btn-primary  dropdown-toggle" data-toggle="dropdown">
								<span class="glyphicon glyphicon-user"></span> Usuarios <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><a href="<?php echo base_url() ?>funcao/cadastrar"><span class="glyphicon glyphicon-pencil"></span> Funções </a></li>
								<li role="separator" class="divider"></li>
								<li><a href="<?php echo base_url() ?>relatorioempresa/funcionario"><span class="glyphicon glyphicon-user"></span> Usuarios </a></li>

							</ul>
						</div>						
					</li>
					<li class="btn-toolbar navbar-form navbar-left" role="toolbar" aria-label="...">
						<div class="btn-group" role="group" aria-label="...">
							<a href="<?php echo base_url(); ?>relatorioempresa/sistemaempresa">
								<button type="button" class="btn btn-md panel-danger ">
									<span class="glyphicon glyphicon-cog"></span> Pagar Manutenção
								</button>
							</a>
						</div>
					</li>
					<li class="btn-toolbar navbar-form navbar-right" role="toolbar" aria-label="...">
						<div class="btn-group" role="group" aria-label="...">
							<a href="<?php echo base_url(); ?>relatorioempresa/sistemaempresa">	
								<button type="button" class="btn btn-md active " id="countdowndiv">
									<span class="glyphicon glyphicon-hourglass" id="clock"></span>
								</button>
							</a>	
						</div>
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
		<div class="col-md-2"></div>

</nav>
<br>
