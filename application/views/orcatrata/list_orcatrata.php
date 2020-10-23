<?php if (isset($msg)) echo $msg; ?>

<div class="container-fluid">
	<div class="row">
	
		<div class="col-md-2"></div>
		<div class="col-md-8 ">
			<?php if ( !isset($evento) && isset($_SESSION['Cliente'])) { ?>
				<?php if ($_SESSION['Cliente']['idApp_Cliente'] != 1 ) { ?>
					<nav class="navbar navbar-inverse navbar-fixed" role="banner">
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
										<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
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
								</li>
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
									<div class="btn-group">
										<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
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
								</li>								
								<?php if ($_SESSION['Cliente']['idSis_Empresa'] == $_SESSION['log']['idSis_Empresa'] ) { ?>
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
									<div class="btn-group">
										<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-usd"></span> Or�s. <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/orcatrata\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
													<a href="<?php echo base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-usd"></span> Lista de Or�amentos
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/orcatrata\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'orcatrata/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-plus"></span> Novo Or�amento
													</a>
												</a>
											</li>
										</ul>
									</div>
								</li>
								<?php } ?>	
							</ul>
						</div>
					  </div>
					</nav>
				<?php } ?>
			<?php } ?>			

			<div class="row">
				<div class="col-md-12 col-lg-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<strong>Or�amentos do Cliente: </strong>
							<?php echo '<small>' . $_SESSION['Cliente']['NomeCliente'] . '</small> - <small>' . $_SESSION['Cliente']['idApp_Cliente'] . '.</small>' ?>
						</div>
						<div class="panel-body">

							<div>

								<!-- Nav tabs -->
								<ul class="nav nav-tabs" role="tablist">
									<li role="presentation" class="active" ><a href="#proxima" aria-controls="proxima" role="tab" data-toggle="tab">Aprovados</a></li>
									<li role="presentation" ><a href="#anterior" aria-controls="anterior" role="tab" data-toggle="tab">N�o Aprovados</a></li>
									<li role="presentation" ><a href="#finalizado" aria-controls="finalizado" role="tab" data-toggle="tab">Finalizado</a></li>
									<!--<li role="presentation" ><a href="#naofinalizado" aria-controls="naofinalizado" role="tab" data-toggle="tab">N�o Finalizado</a></li>-->
									<li role="presentation" ><a href="#cancelado" aria-controls="cancelado" role="tab" data-toggle="tab">Cancelado</a></li>
									<!--<li role="presentation" ><a href="#naocancelado" aria-controls="naocancelado" role="tab" data-toggle="tab">N�o Cancelado</a></li>-->
								</ul>

								<!-- Tab panes -->
								<div class="tab-content">

									<!-- Aprovados -->
									<div role="tabpanel" class="tab-pane active " id="proxima">

										<?php
										if ($aprovado) {

											foreach ($aprovado->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-success" id=callout-overview-not-both>

											<a class="btn btn-success" href="<?php echo base_url() . 'orcatrata/alterar/' . $row['idApp_OrcaTrata'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados
											</a>
											
												
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Vers�o para Impress�o
											</a>
											

											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>N� Or�.:</b> <?php echo $row['idApp_OrcaTrata']; ?>
											</h4>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Or�amento:</b> <?php echo $row['DataOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data da Entrega:</b> <?php echo $row['DataEntregaOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Venc.:</b> <?php echo $row['DataVencimentoOrca']; ?>
											</h5>
											
											<p>
												<?php if ($row['ProfissionalOrca']) { ?>
												<span class="glyphicon glyphicon-user"></span> <b>Profissional:</b> <?php echo $row['ProfissionalOrca']; ?> -
												<?php } if ($row['AprovadoOrca']) { ?>
												<span class="glyphicon glyphicon-thumbs-up"></span> <b>Or�. Aprovado?</b> <?php echo $row['AprovadoOrca']; ?>
												<?php } ?>

											</p>
											<p>
												<?php if ($row['ConcluidoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Or�. Conclu�do?</b> <?php echo $row['ConcluidoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['QuitadoOrca']) { ?>
												<span class="glyphicon glyphicon-usd"></span> <b>Or�. Quitado?</b> <?php echo $row['QuitadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['FinalizadoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Or�. Finalizado?</b> <?php echo $row['FinalizadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['CanceladoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Or�. Cancelado?</b> <?php echo $row['CanceladoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Motivo:</b> <?php echo nl2br($row['ObsOrca']); ?>
											</p>

										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

									<!-- N�o Aprovados -->
									<div role="tabpanel" class="tab-pane " id="anterior">

										<?php
										if ($naoaprovado) {

											foreach ($naoaprovado->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-danger" id=callout-overview-not-both>

											<a class="btn btn-danger" href="<?php echo base_url() . 'orcatrata/alterar/' . $row['idApp_OrcaTrata'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados
											</a>
											
											<a class="btn btn-md btn-info" href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Vers�o para Impress�o
											</a>

											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>N� Or�.:</b> <?php echo $row['idApp_OrcaTrata']; ?>
											</h4>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Or�amento:</b> <?php echo $row['DataOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data da Entrega:</b> <?php echo $row['DataEntregaOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Venc.:</b> <?php echo $row['DataVencimentoOrca']; ?>
											</h5>

											<p>
												<?php if ($row['ProfissionalOrca']) { ?>
												<span class="glyphicon glyphicon-user"></span> <b>Profissional:</b> <?php echo $row['ProfissionalOrca']; ?> -
												<?php } if ($row['AprovadoOrca']) { ?>
												<span class="glyphicon glyphicon-thumbs-down"></span> <b>Or�. Aprovado?</b> <?php echo $row['AprovadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['ConcluidoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Or�. Conclu�do?</b> <?php echo $row['ConcluidoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['QuitadoOrca']) { ?>
												<span class="glyphicon glyphicon-usd"></span> <b>Or�. Quitado?</b> <?php echo $row['QuitadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['FinalizadoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Or�. Finalizado?</b> <?php echo $row['FinalizadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['CanceladoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Or�. Cancelado?</b> <?php echo $row['CanceladoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Motivo:</b> <?php echo nl2br($row['ObsOrca']); ?>
											</p>

										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

									<!-- Finalizados -->
									<div role="tabpanel" class="tab-pane " id="finalizado">

										<?php
										if ($finalizado) {

											foreach ($finalizado->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-success" id=callout-overview-not-both>

											<a class="btn btn-success" href="<?php echo base_url() . 'orcatrata/alterar/' . $row['idApp_OrcaTrata'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados
											</a>
											
											<a class="btn btn-md btn-info" href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Vers�o para Impress�o
											</a>

											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>N� Or�.:</b> <?php echo $row['idApp_OrcaTrata']; ?>
											</h4>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Or�amento:</b> <?php echo $row['DataOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data da Entrega:</b> <?php echo $row['DataEntregaOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Venc.:</b> <?php echo $row['DataVencimentoOrca']; ?>
											</h5>

											<p>
												<?php if ($row['ProfissionalOrca']) { ?>
												<span class="glyphicon glyphicon-user"></span> <b>Profissional:</b> <?php echo $row['ProfissionalOrca']; ?> -
												<?php } if ($row['AprovadoOrca']) { ?>
												<span class="glyphicon glyphicon-thumbs-up"></span> <b>Or�. Aprovado?</b> <?php echo $row['AprovadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['ConcluidoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Or�. Conclu�do?</b> <?php echo $row['ConcluidoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['QuitadoOrca']) { ?>
												<span class="glyphicon glyphicon-usd"></span> <b>Or�. Quitado?</b> <?php echo $row['QuitadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['FinalizadoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Or�. Finalizado?</b> <?php echo $row['FinalizadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['CanceladoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Or�. Cancelado?</b> <?php echo $row['CanceladoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Motivo:</b> <?php echo nl2br($row['ObsOrca']); ?>
											</p>

										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

									<!-- N�o Finalizados -->
									<div role="tabpanel" class="tab-pane " id="naofinalizado">

										<?php
										if ($naofinalizado) {

											foreach ($naofinalizado->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-danger" id=callout-overview-not-both>

											<a class="btn btn-danger" href="<?php echo base_url() . 'orcatrata/alterar/' . $row['idApp_OrcaTrata'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados
											</a>
											
											<a class="btn btn-md btn-info" href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Vers�o para Impress�o
											</a>

											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>N� Or�.:</b> <?php echo $row['idApp_OrcaTrata']; ?>
											</h4>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Or�amento:</b> <?php echo $row['DataOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data da Entrega:</b> <?php echo $row['DataEntregaOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Venc.:</b> <?php echo $row['DataVencimentoOrca']; ?>
											</h5>

											<p>
												<?php if ($row['ProfissionalOrca']) { ?>
												<span class="glyphicon glyphicon-user"></span> <b>Profissional:</b> <?php echo $row['ProfissionalOrca']; ?> -
												<?php } if ($row['AprovadoOrca']) { ?>
												<span class="glyphicon glyphicon-thumbs-up"></span> <b>Or�. Aprovado?</b> <?php echo $row['AprovadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['ConcluidoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Or�. Conclu�do?</b> <?php echo $row['ConcluidoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['QuitadoOrca']) { ?>
												<span class="glyphicon glyphicon-usd"></span> <b>Or�. Quitado?</b> <?php echo $row['QuitadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['FinalizadoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Or�. Finalizado?</b> <?php echo $row['FinalizadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['CanceladoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Or�. Cancelado?</b> <?php echo $row['CanceladoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Motivo:</b> <?php echo nl2br($row['ObsOrca']); ?>
											</p>

										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

									<!-- Cancelado -->
									<div role="tabpanel" class="tab-pane " id="cancelado">

										<?php
										if ($cancelado) {

											foreach ($cancelado->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-success" id=callout-overview-not-both>

											<a class="btn btn-success" href="<?php echo base_url() . 'orcatrata/alterar/' . $row['idApp_OrcaTrata'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados
											</a>
											
											<a class="btn btn-md btn-info" href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Vers�o para Impress�o
											</a>

											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>N� Or�.:</b> <?php echo $row['idApp_OrcaTrata']; ?>
											</h4>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Or�amento:</b> <?php echo $row['DataOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data da Entrega:</b> <?php echo $row['DataEntregaOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Venc.:</b> <?php echo $row['DataVencimentoOrca']; ?>
											</h5>

											<p>
												<?php if ($row['ProfissionalOrca']) { ?>
												<span class="glyphicon glyphicon-user"></span> <b>Profissional:</b> <?php echo $row['ProfissionalOrca']; ?> -
												<?php } if ($row['AprovadoOrca']) { ?>
												<span class="glyphicon glyphicon-thumbs-up"></span> <b>Or�. Aprovado?</b> <?php echo $row['AprovadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['ConcluidoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Or�. Conclu�do?</b> <?php echo $row['ConcluidoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['QuitadoOrca']) { ?>
												<span class="glyphicon glyphicon-usd"></span> <b>Or�. Quitado?</b> <?php echo $row['QuitadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['FinalizadoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Or�. Finalizado?</b> <?php echo $row['FinalizadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['CanceladoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Or�. Cancelado?</b> <?php echo $row['CanceladoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Motivo:</b> <?php echo nl2br($row['ObsOrca']); ?>
											</p>

										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

									<!-- N�o Cancelado -->
									<div role="tabpanel" class="tab-pane " id="naocancelado">

										<?php
										if ($naocancelado) {

											foreach ($naocancelado->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-danger" id=callout-overview-not-both>

											<a class="btn btn-danger" href="<?php echo base_url() . 'orcatrata/alterar/' . $row['idApp_OrcaTrata'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados
											</a>
											
											<a class="btn btn-md btn-info" href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Vers�o para Impress�o
											</a>

											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>N� Or�.:</b> <?php echo $row['idApp_OrcaTrata']; ?>
											</h4>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Or�amento:</b> <?php echo $row['DataOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data da Entrega:</b> <?php echo $row['DataEntregaOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Venc.:</b> <?php echo $row['DataVencimentoOrca']; ?>
											</h5>

											<p>
												<?php if ($row['ProfissionalOrca']) { ?>
												<span class="glyphicon glyphicon-user"></span> <b>Profissional:</b> <?php echo $row['ProfissionalOrca']; ?> -
												<?php } if ($row['AprovadoOrca']) { ?>
												<span class="glyphicon glyphicon-thumbs-up"></span> <b>Or�. Aprovado?</b> <?php echo $row['AprovadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['ConcluidoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Or�. Conclu�do?</b> <?php echo $row['ConcluidoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['QuitadoOrca']) { ?>
												<span class="glyphicon glyphicon-usd"></span> <b>Or�. Quitado?</b> <?php echo $row['QuitadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['FinalizadoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Or�. Finalizado?</b> <?php echo $row['FinalizadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['CanceladoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Or�. Cancelado?</b> <?php echo $row['CanceladoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Motivo:</b> <?php echo nl2br($row['ObsOrca']); ?>
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
