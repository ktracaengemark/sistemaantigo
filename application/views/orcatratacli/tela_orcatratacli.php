<?php if ($msg) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Usuario'])) { ?>

<div class="container-fluid">
	<div class="row">
	
		<div class="col-md-2"></div>
		<div class="col-md-8 ">
		

				


				
					<nav class="navbar navbar-inverse">
					  <div class="container-fluid">
						<div class="navbar-header">
						  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span> 
						  </button>
						  <a class="navbar-brand" href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Usuario']['idApp_Cliente']; ?>">
							<?php echo '<small>' . $_SESSION['Usuario']['Nome'] . '</small> - <small>Id.: ' . $_SESSION['Usuario']['idApp_Cliente'] . '</small>' ?>
						  </a>
						</div>
						<div class="collapse navbar-collapse" id="myNavbar">

							<ul class="nav navbar-nav navbar-center">
								<li>
									<a href="<?php echo base_url() . 'cliente/alterar/' . $_SESSION['Usuario']['idApp_Cliente']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Editar Usuario
									</a>
								</li>
								
								<li>
									<a href="<?php echo base_url() . 'cliente/acomp/' . $_SESSION['Usuario']['idApp_Cliente']; ?>">
										<span class="glyphicon glyphicon-pencil"></span> Anota��es
									</a>
								</li>								

								<li>
									<a href="<?php echo base_url() . 'orcatratacli/listar/' . $_SESSION['Usuario']['idApp_Cliente']; ?>">
										<span class="glyphicon glyphicon-usd"></span> Ver Or�ams.
									</a>
								</li>

								<li>
									<a href="<?php echo base_url() . 'orcatratacli/cadastrar/' . $_SESSION['Usuario']['idApp_Cliente']; ?>">
										<span class="glyphicon glyphicon-plus"></span> Cad. Or�am.
									</a>
								</li>
							</ul>

						</div>
					  </div>
					</nav>

					<?php } ?>
					<div class="row">
					
						<div class="col-md-12 col-lg-12">

							<div class="panel panel-primary">

								<div class="panel-heading"><strong>Or�amentos</strong></div>
								<div class="panel-body">				
								
									<?php
									if (!$list) {
									?>
										<a class="btn btn-lg btn-warning" href="<?php echo base_url() ?>orcatratacli/cadastrar" role="button">
											<span class="glyphicon glyphicon-plus"></span> Cadastrar Novo Or�amento
										</a>
										<br><br>
										<div class="alert alert-info" role="alert"><b>Nenhum or�amento cadastrado</b></div>
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