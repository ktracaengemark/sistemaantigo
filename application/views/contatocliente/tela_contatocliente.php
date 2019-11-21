<?php if (isset($msg)) echo $msg; ?>


<div class="container-fluid">
	<div class="row">
	
		<div class="col-md-2"></div>
		<div class="col-md-8 ">
			<?php if ( !isset($evento) && isset($_SESSION['Cliente'])) { ?>
				<?php if ($_SESSION['Cliente']['idApp_Cliente'] != 1 ) { ?>
					<nav class="navbar navbar-inverse navbar-fixed-top " role="banner">
					  <div class="container-fluid">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span> 
							</button>
							<a class="navbar-brand" href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
								<?php echo '<small>' . $_SESSION['Cliente']['idApp_Cliente'] . '</small> - <small>' . $_SESSION['Cliente']['NomeCliente'] . '.</small>' ?> 
							</a>
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
										<a href="<?php echo base_url(); ?>orcatrata/cadastrar3">
											<button type="button" class="btn btn-sm btn-primary ">
												<span class="glyphicon glyphicon-plus"></span>Receitas
											</button>
										</a>
									</div>
									<div class="btn-group " role="group" aria-label="...">
										<a href="<?php echo base_url(); ?>orcatrata/cadastrardesp">
											<button type="button" class="btn btn-sm btn-danger ">
												<span class="glyphicon glyphicon-plus"></span>Despesas
											</button>
										</a>
									</div>							
									<div class="btn-group " role="group" aria-label="...">
										<a href="<?php echo base_url(); ?>relatorio/financeiro">
											<button type="button" class="btn btn-sm btn-success ">
												<span class="glyphicon glyphicon-usd"></span>Relatório
											</button>
										</a>
									</div>																		
								</li>								
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
									<div class="btn-group">
										<button type="button" class="btn btn-sm btn-default  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-user"></span> Cliente <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/cliente\/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-file"></span> Ver Dados do Cliente
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/cliente\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'cliente/alterar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-edit"></span> Editar Dados do Cliente
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
													<a href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-user"></span> Contatos do Cliente
													</a>
												</a>
											</li>
										</ul>
									</div>
									<div class="btn-group">
										<button type="button" class="btn btn-sm btn-default  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-calendar"></span> Agenda <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/consulta\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
													<a href="<?php echo base_url() . 'consulta/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-calendar"></span> Lista de Agendamentos
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/consulta\/cadastrar1\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'consulta/cadastrar1/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-plus"></span> Novo Agendamento
													</a>
												</a>
											</li>
										</ul>
									</div>

									<?php if ($_SESSION['Cliente']['idSis_Empresa'] == $_SESSION['log']['idSis_Empresa'] ) { ?>
									<div class="btn-group">
										<button type="button" class="btn btn-sm btn-default  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-usd"></span> Orçs. <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/orcatrata\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
													<a href="<?php echo base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-usd"></span> Lista de Orçamentos
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/orcatrata\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'orcatrata/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-plus"></span> Novo Orçamento
													</a>
												</a>
											</li>
										</ul>
									</div>
									<?php } ?>									
								</li>
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
									<?php if ($_SESSION['log']['NivelEmpresa'] >= 10 ) { ?>
									<div class="btn-group">
										<button type="button" class="btn btn-sm btn-default  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-pencil"></span> Proced. <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/procedimento\/listarproc\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
													<a href="<?php echo base_url() . 'procedimento/listarproc/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-pencil"></span> Lista de Procedimentos
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/procedimento\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'procedimento/cadastrarproc/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-plus"></span> Novo Procedimento
													</a>
												</a>
											</li>
										</ul>
									</div>
									<?php } ?>
									<div class="btn-group " role="group" aria-label="...">
										<a <?php if (preg_match("/agenda/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
											<a href="<?php echo base_url() . 'agenda/'; ?>">
												<button type="button" class="btn btn-sm btn-active ">
													<span class="glyphicon glyphicon-remove"></span> Fechar
												</button>										
											</a>
										</a>
									</div>
								</li>
							</ul>
						</div>
					  </div>
					</nav>
				<?php } ?>
			<?php } ?>
					
			<div class="row">
			
				<div class="col-md-12 col-lg-12">

					<div class="panel panel-primary">

						<div class="panel-heading"><strong>Contato</strong></div>
						<div class="panel-body">

								<?php
								if (!$list) {
								?>
									<a class="btn btn-lg btn-warning" href="<?php echo base_url() ?>contatocliente/cadastrar" role="button">
										<span class="glyphicon glyphicon-plus"></span> Cad.
									</a>
									<br><br>
									<div class="alert alert-info" role="alert"><b>Nenhum Cad. </b></div>
								<?php
								} else {
									echo $list;
								}
								?>
							
						</div>
					</div>
				</div>	
			</div>	
	
		</div>
		<div class="col-md-2"></div>
	</div>	
</div>


