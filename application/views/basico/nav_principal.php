<nav class="navbar navbar-inverse navbar-fixed-top " role="banner">
	<div class="container-fluid">
		<div class="row">

			<div class="col-sm-offset-1 col-md-11 ">
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
									<li><a href="<?php echo base_url() ?>relatorio/produtos"><span class="glyphicon glyphicon-list-alt"></span> Lista</a></li>
									<li role="separator" class="divider"></li>							
									<li><a href="<?php echo base_url() ?>relatorio/estoque"><span class="glyphicon glyphicon-list-alt"></span> Estoque</a></li>
								</ul>
							</div>																				
							<?php } ?>
						</li>
						<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">
							<div class="btn-group " role="group" aria-label="...">
								<a href="<?php echo base_url(); ?>orcatrata/cadastrar3">
									<button type="button" class="btn btn-sm btn-primary ">
										<span class="glyphicon glyphicon-pencil"></span>Receitas
									</button>
								</a>
							</div>
							<div class="btn-group " role="group" aria-label="...">
								<a href="<?php echo base_url(); ?>orcatrata/cadastrardesp">
									<button type="button" class="btn btn-sm btn-danger ">
										<span class="glyphicon glyphicon-pencil"></span>Despesas
									</button>
								</a>
							</div>							
							<div class="btn-group " role="group" aria-label="...">
								<a href="<?php echo base_url(); ?>relatorio/financeiro">
									<button type="button" class="btn btn-sm btn-warning ">
										<span class="glyphicon glyphicon-usd"></span>Relat�rio
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
									<?php if ($_SESSION['log']['NivelEmpresa'] >= 3 ) { ?>
									<li><a href="<?php echo base_url() ?>relatorio/empresas"><span class="glyphicon glyphicon-pencil"></span> Dicas de Neg�cios</a></li>
									<li role="separator" class="divider"></li>									
									<?php } ?>
									<li><a href="<?php echo base_url() ?>relatorio/empresas"><span class="glyphicon glyphicon-home"></span> Outras Empresas</a></li>
								</ul>
							</div>
							<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) && ($_SESSION['log']['idSis_Empresa'] != 5))  { ?>
							<div class="btn-group" role="group" aria-label="...">
								<a href="<?php echo base_url(); ?>relatorio/loginempresa"> 	
									<button type="button" class="btn btn-sm active ">Renovar em: 
										<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); $intervalo = $data1->diff($data2); echo $intervalo->format('%a dias'); ?>
									</button>
								</a>	
							</div>
							<?php } else if ($_SESSION['log']['idSis_Empresa'] != 5){?>
							<div class="btn-group" role="group" aria-label="...">
								<a href="<?php echo base_url(); ?>relatorio/loginempresa"> 	
									<button type="button" class="btn btn-sm active ">Renovar Assinatura 
										
									</button>
								</a>	
							</div>
							<?php } ?>
							<div class="btn-group " role="group" aria-label="...">
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
		</div>
	</div>
</nav>
<br>
