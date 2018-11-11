<?php if (isset($msg)) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Cliente'])) { ?>

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
					<a class="navbar-brand" href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
						<?php echo '<small>' . $_SESSION['Cliente']['idApp_Cliente'] . '</small> - <small>' . $_SESSION['Cliente']['NomeCliente'] . '.</small>' ?> 
					</a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
					<ul class="nav navbar-nav navbar-center">
						<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
							<div class="btn-group">
								<button type="button" class="btn btn-sm btn-default  dropdown-toggle" data-toggle="dropdown">
									<span class="glyphicon glyphicon-user"></span> Cliente <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li>
										<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
											<a href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
												<span class="glyphicon glyphicon-calendar"></span> Ver
											</a>
										</a>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a <?php if (preg_match("/cliente\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
											<a href="<?php echo base_url() . 'cliente/alterar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
												<span class="glyphicon glyphicon-plus"></span> Editar
											</a>
										</a>
									</li>
								</ul>
							</div>
							<div class="btn-group" role="group" aria-label="..."> </div>
						</li>
						<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
							<div class="btn-group">
								<button type="button" class="btn btn-sm btn-default  dropdown-toggle" data-toggle="dropdown">
									<span class="glyphicon glyphicon-calendar"></span> Agendamentos <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li>
										<a <?php if (preg_match("/consulta\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
											<a href="<?php echo base_url() . 'consulta/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
												<span class="glyphicon glyphicon-calendar"></span> Listar
											</a>
										</a>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a <?php if (preg_match("/consulta\/cadastrar1\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
											<a href="<?php echo base_url() . 'consulta/cadastrar1/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
												<span class="glyphicon glyphicon-plus"></span> Cadastrar
											</a>
										</a>
									</li>
								</ul>
							</div>
							<div class="btn-group" role="group" aria-label="..."> </div>
						</li>
						<?php if ($_SESSION['Cliente']['idSis_Empresa'] == $_SESSION['log']['idSis_Empresa'] ) { ?>
						<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
							<div class="btn-group">
								<button type="button" class="btn btn-sm btn-default  dropdown-toggle" data-toggle="dropdown">
									<span class="glyphicon glyphicon-usd"></span> Orçamentos <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li>
										<a <?php if (preg_match("/orcatrata\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
											<a href="<?php echo base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
												<span class="glyphicon glyphicon-usd"></span> Listar
											</a>
										</a>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a <?php if (preg_match("/orcatrata\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
											<a href="<?php echo base_url() . 'orcatrata/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
												<span class="glyphicon glyphicon-plus"></span> Cadastrar
											</a>
										</a>
									</li>
								</ul>
							</div>
							<div class="btn-group" role="group" aria-label="..."> </div>
						</li>
						<?php } ?>
						<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
							<div class="btn-group">
								<button type="button" class="btn btn-sm btn-default  dropdown-toggle" data-toggle="dropdown">
									<span class="glyphicon glyphicon-pencil"></span> Procedimentos <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li>
										<a <?php if (preg_match("/procedimento\/listarproc\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
											<a href="<?php echo base_url() . 'procedimento/listarproc/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
												<span class="glyphicon glyphicon-pencil"></span> Listar
											</a>
										</a>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a <?php if (preg_match("/procedimento\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
											<a href="<?php echo base_url() . 'procedimento/cadastrarproc/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
												<span class="glyphicon glyphicon-plus"></span> Cadastrar
											</a>
										</a>
									</li>
								</ul>
							</div>
							<div class="btn-group" role="group" aria-label="..."> </div>
						</li>
					</ul>

				</div>
			  </div>
			</nav>

			<?php } ?>
					
			<div class="row">
				<div class="col-md-12 col-lg-12">
					<div class="panel panel-primary">
						<div class="panel-heading"><strong>Orçamentos</strong></div>
						<div class="panel-body">

							<div>

								<!-- Nav tabs -->
								<ul class="nav nav-tabs" role="tablist">
									<li role="presentation"><a href="#proxima" aria-controls="proxima" role="tab" data-toggle="tab">Aprovados</a></li>
									<li role="presentation" class="active"><a href="#anterior" aria-controls="anterior" role="tab" data-toggle="tab">Não Aprovados</a></li>
								</ul>

								<!-- Tab panes -->
								<div class="tab-content">

									<!-- Próximas Consultas -->
									<div role="tabpanel" class="tab-pane" id="proxima">

										<?php
										if ($aprovado) {

											foreach ($aprovado->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-success" id=callout-overview-not-both>

											<a class="btn btn-success" href="<?php echo base_url() . 'orcatrata4/alterar/' . $row['idApp_OrcaTrata'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados
											</a>
											
												
											<a class="btn btn-md btn-info" target="_blank" href="<?php echo base_url() . 'OrcatrataPrintDev/imprimir/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão para Impressão
											</a>
											

											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Nº Dev.:</b> <?php echo $row['idApp_OrcaTrata']; ?>
											</h4>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data da Devolução:</b> <?php echo $row['DataOrca']; ?>
											</h5>

											<p>
												<?php if ($row['ProfissionalOrca']) { ?>
												<span class="glyphicon glyphicon-user"></span> <b>Profissional:</b> <?php echo $row['ProfissionalOrca']; ?> -
												<?php } if ($row['AprovadoOrca']) { ?>
												<span class="glyphicon glyphicon-thumbs-up"></span> <b>Orç. Aprovado?</b> <?php echo $row['AprovadoOrca']; ?>
												<?php } ?>

											</p>
											<p>
												<?php if ($row['ServicoConcluido']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Concluído?</b> <?php echo $row['ServicoConcluido']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['QuitadoOrca']) { ?>
												<span class="glyphicon glyphicon-usd"></span> <b>Orç. Quitado?</b> <?php echo $row['QuitadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Obs:</b> <?php echo nl2br($row['ObsOrca']); ?>
											</p>

										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

									<!-- Histórico de Consultas -->
									<div role="tabpanel" class="tab-pane active" id="anterior">

										<?php
										if ($naoaprovado) {

											foreach ($naoaprovado->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-danger" id=callout-overview-not-both>

											<a class="btn btn-danger" href="<?php echo base_url() . 'orcatrata4/alterar/' . $row['idApp_OrcaTrata'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados
											</a>
											
											<a class="btn btn-md btn-info" target="_blank" href="<?php echo base_url() . 'OrcatrataPrintDev/imprimir/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão para Impressão
											</a>

											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Nº Dev.:</b> <?php echo $row['idApp_OrcaTrata']; ?>
											</h4>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data da Devolução:</b> <?php echo $row['DataOrca']; ?>
											</h5>

											<p>
												<?php if ($row['ProfissionalOrca']) { ?>
												<span class="glyphicon glyphicon-user"></span> <b>Profissional:</b> <?php echo $row['ProfissionalOrca']; ?> -
												<?php } if ($row['AprovadoOrca']) { ?>
												<span class="glyphicon glyphicon-thumbs-up"></span> <b>Orç. Aprovado?</b> <?php echo $row['AprovadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['ServicoConcluido']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Concluído?</b> <?php echo $row['ServicoConcluido']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['QuitadoOrca']) { ?>
												<span class="glyphicon glyphicon-usd"></span> <b>Orç. Quitado?</b> <?php echo $row['QuitadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Obs:</b> <?php echo nl2br($row['ObsOrca']); ?>
											</p>

										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

								</div>

							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
		<div class="col-md-2"></div>
	</div>	
</div>
