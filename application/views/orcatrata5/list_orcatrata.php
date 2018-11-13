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
								<?php echo '<small>' . $_SESSION['Cliente']['NomeCliente'] . '</small> - <small>' . $_SESSION['Cliente']['idApp_Cliente'] . '</small>' ?> 
							</a>
						</div>
						<div class="collapse navbar-collapse" id="myNavbar">

							<ul class="nav navbar-nav navbar-center">
								<li>
									<a href="<?php echo base_url() . 'cliente/alterar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Edit. Cliente
									</a>
								</li>
								<li>
									<a href="<?php echo base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
										<span class="glyphicon glyphicon-usd"></span> Listar Or�ams.
									</a>
								</li>
								<li>
									<a href="<?php echo base_url() . 'orcatrata/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
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

									<div>

										<!-- Nav tabs -->
										<ul class="nav nav-tabs" role="tablist">
											<li role="presentation" class="active" ><a href="#proxima" aria-controls="proxima" role="tab" data-toggle="tab">Aprovados</a></li>
											<li role="presentation" ><a href="#anterior" aria-controls="anterior" role="tab" data-toggle="tab">N�o Aprovados</a></li>
										</ul>

										<!-- Tab panes -->
										<div class="tab-content">

											<!-- Pr�ximas Consultas -->
											<div role="tabpanel" class="tab-pane active " id="proxima">

												<?php
												if ($aprovado) {

													foreach ($aprovado->result_array() as $row) {
												?>

												<div class="bs-callout bs-callout-success" id=callout-overview-not-both>

													<a class="btn btn-success" href="<?php echo base_url() . 'orcatrata/alterar/' . $row['idApp_OrcaTrata'] ?>" role="button">
														<span class="glyphicon glyphicon-edit"></span> Editar Dados
													</a>
													
														
													<a class="btn btn-md btn-info" target="_blank" href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_OrcaTrata']; ?>" role="button">
														<span class="glyphicon glyphicon-print"></span> Vers�o para Impress�o
													</a>
													

													<br><br>

													<h4>
														<span class="glyphicon glyphicon-tags"></span> <b>N� Or�.:</b> <?php echo $row['idApp_OrcaTrata']; ?>
													</h4>
													<br>
													<p>
														<?php if ($row['ProfissionalOrca']) { ?>
														<span class="glyphicon glyphicon-user"></span> <b>Profissional:</b> <?php echo $row['ProfissionalOrca']; ?> -
														<?php } if ($row['AprovadoOrca']) { ?>
														<span class="glyphicon glyphicon-thumbs-up"></span> <b>Or�. Aprov.?</b> <?php echo $row['AprovadoOrca']; ?> -
														<?php } if ($row['DataOrca']) { ?>
														<span class="glyphicon glyphicon-calendar"></span> <b>Dt. Or�.</b> <?php echo $row['DataOrca']; ?>
														<?php } ?>

													</p>
													<p>
														<?php if ($row['ServicoConcluido']) { ?>
														<span class="glyphicon glyphicon-ok"></span> <b>Or�. Concl.?</b> <?php echo $row['ServicoConcluido']; ?> -
														<?php } if ($row['DataConclusao']) { ?>
														<span class="glyphicon glyphicon-calendar"></span> <b>Dt. Concl.</b> <?php echo $row['DataConclusao']; ?>
														<?php } ?>
													</p>
													<p>
														<?php if ($row['QuitadoOrca']) { ?>
														<span class="glyphicon glyphicon-usd"></span> <b>Or�. Quit.?</b> <?php echo $row['QuitadoOrca']; ?> -
														<?php } if ($row['DataQuitado']) { ?>
														<span class="glyphicon glyphicon-calendar"></span> <b>Dt. Quit.</b> <?php echo $row['DataQuitado']; ?>
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

											<!-- Hist�rico de Consultas -->
											<div role="tabpanel" class="tab-pane " id="anterior">

												<?php
												if ($naoaprovado) {

													foreach ($naoaprovado->result_array() as $row) {
												?>

												<div class="bs-callout bs-callout-danger" id=callout-overview-not-both>

													<a class="btn btn-danger" href="<?php echo base_url() . 'orcatrata/alterar/' . $row['idApp_OrcaTrata'] ?>" role="button">
														<span class="glyphicon glyphicon-edit"></span> Editar Dados
													</a>
													
													<a class="btn btn-md btn-info" target="_blank" href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_OrcaTrata']; ?>" role="button">
														<span class="glyphicon glyphicon-print"></span> Vers�o para Impress�o
													</a>

													<br><br>

													<h4>
														<span class="glyphicon glyphicon-tags"></span> <b>N� Or�.:</b> <?php echo $row['idApp_OrcaTrata']; ?>
													</h4>
													<br>
													<p>
														<?php if ($row['ProfissionalOrca']) { ?>
														<span class="glyphicon glyphicon-user"></span> <b>Profissional:</b> <?php echo $row['ProfissionalOrca']; ?> -
														<?php } if ($row['AprovadoOrca']) { ?>
														<span class="glyphicon glyphicon-thumbs-up"></span> <b>Or�. Aprov.?</b> <?php echo $row['AprovadoOrca']; ?> -
														<?php } if ($row['DataOrca']) { ?>
														<span class="glyphicon glyphicon-calendar"></span> <b>Dt. Or�.</b> <?php echo $row['DataOrca']; ?>
														<?php } ?>

													</p>
													<p>
														<?php if ($row['ServicoConcluido']) { ?>
														<span class="glyphicon glyphicon-ok"></span> <b>Or�. Concl.?</b> <?php echo $row['ServicoConcluido']; ?> -
														<?php } if ($row['DataConclusao']) { ?>
														<span class="glyphicon glyphicon-calendar"></span> <b>Dt. Concl.</b> <?php echo $row['DataConclusao']; ?>
														<?php } ?>
													</p>
													<p>
														<?php if ($row['QuitadoOrca']) { ?>
														<span class="glyphicon glyphicon-usd"></span> <b>Or�. Quit.?</b> <?php echo $row['QuitadoOrca']; ?> -
														<?php } if ($row['DataQuitado']) { ?>
														<span class="glyphicon glyphicon-calendar"></span> <b>Dt. Quit.</b> <?php echo $row['DataQuitado']; ?>
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
