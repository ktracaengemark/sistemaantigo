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
							
							<a class="navbar-brand" href="<?php #echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
								<?php #echo '<small>' . $_SESSION['Cliente']['idApp_Cliente'] . '</small> - <small>' . $_SESSION['Cliente']['NomeCliente'] . '.</small>' ?> 
							</a>
							
						</div>
						<div class="collapse navbar-collapse" id="myNavbar">
							<ul class="nav navbar-nav navbar-center">
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
									<div class="btn-group">
										<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-user"></span>
												<?php echo '<small>' . $_SESSION['Cliente']['NomeCliente'] . '</small> - <small>' . $_SESSION['Cliente']['idApp_Cliente'] . '</small>' ?> 
											<span class="caret"></span>
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
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
									<div class="btn-group">
										<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-pencil"></span> Proc. <span class="caret"></span>
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
						<div class="panel-heading">
							<?php echo '<strong>' . $_SESSION['Cliente']['NomeCompleto'] . '</strong> - <small>' . $_SESSION['Cliente']['idApp_Cliente'] . '.</small>' ?>
						</div>
						<div class="panel-body">

							<div>

								<!-- Nav tabs -->
								<ul class="nav nav-tabs" role="tablist">
									<li role="presentation"><a href="#concluido" aria-controls="concluido" role="tab" data-toggle="tab">Concl S/Or�</a></li>
									<li role="presentation"	class="active"><a href="#nao_concluido" aria-controls="nao_concluido" role="tab" data-toggle="tab">N�o Concl S/Or�</a></li>
									<li role="presentation"><a href="#concluido_orc" aria-controls="concluido_orc" role="tab" data-toggle="tab">Concl C/Or�</a></li>
									<li role="presentation"><a href="#nao_concluido_orc" aria-controls="nao_concluido_orc" role="tab" data-toggle="tab">N�o Concl C/Or�</a></li>
								</ul>

								<!-- Tab panes -->
								<div class="tab-content">

									<!-- Concluido-Or� -->
									<div role="tabpanel" class="tab-pane " id="concluido">

										<?php
										if ($concluido) {

											foreach ($concluido->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-success" id=callout-overview-not-both>

											<a class="btn btn-success" href="<?php echo base_url() . 'procedimento/alterarproc/' . $row['idApp_Procedimento'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados
											</a>
											
											<!--	
											<a class="btn btn-md btn-info" target="_blank" href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_Procedimento']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Vers�o para Impress�o
											</a>
											-->

											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Procd.:</b> <?php echo $row['idApp_Procedimento']; ?>
											</h4>
											<br>
											<p>
												
												<?php if ($row['DataProcedimentoLimite']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Retorno</b> <?php echo $row['DataProcedimentoLimite']; ?>
												<?php } ?>

											</p>											
											<p>
												
												<?php if ($row['DataProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastro</b> <?php echo $row['DataProcedimento']; ?>
												<?php } ?>

											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Procedimento:</b> <?php echo nl2br($row['Procedimento']); ?>
											</p>
											<p>
												<?php if ($row['ConcluidoProcedimento']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Conclu�do:</b> <?php echo $row['ConcluidoProcedimento']; ?>
												<?php }?>
											</p>
										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

									<!-- N�o Concluido-Or� -->
									<div role="tabpanel" class="tab-pane active" id="nao_concluido">

										<?php
										if ($nao_concluido) {

											foreach ($nao_concluido->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-danger" id=callout-overview-not-both>

											<a class="btn btn-danger" href="<?php echo base_url() . 'procedimento/alterarproc/' . $row['idApp_Procedimento'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados
											</a>
											<!--
											<a class="btn btn-md btn-info" target="_blank" href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_Procedimento']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Vers�o para Impress�o
											</a>
											-->
											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Procd.:</b> <?php echo $row['idApp_Procedimento']; ?>
											</h4>
											<br>
											<p>
												
												<?php if ($row['DataProcedimentoLimite']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Retorno</b> <?php echo $row['DataProcedimentoLimite']; ?>
												<?php } ?>

											</p>											
											<p>
												
												<?php if ($row['DataProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastro</b> <?php echo $row['DataProcedimento']; ?>
												<?php } ?>

											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Procedimento:</b> <?php echo nl2br($row['Procedimento']); ?>
											</p>
											<p>
												<?php if ($row['ConcluidoProcedimento']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Conclu�do:</b> <?php echo $row['ConcluidoProcedimento']; ?>
												<?php }?>
											</p>
										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

									<!-- Concluido-Or� -->
									<div role="tabpanel" class="tab-pane " id="concluido_orc">

										<?php
										if ($concluido_orc) {

											foreach ($concluido_orc->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-success" id=callout-overview-not-both>

											<a class="btn btn-success" href="<?php echo base_url() . 'orcatrata/alterar/' . $row['idApp_OrcaTrata'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados
											</a>
											
											<!--	
											<a class="btn btn-md btn-info" target="_blank" href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_Procedimento']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Vers�o para Impress�o
											</a>
											-->

											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Procd.:</b> <?php echo $row['idApp_Procedimento']; ?> -
												<span class="glyphicon glyphicon-tags"></span> <b>Or�am.:</b> <?php echo $row['idApp_OrcaTrata']; ?>
											</h4>
											<br>
											<p>
												
												<?php if ($row['DataProcedimentoLimite']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Retorno</b> <?php echo $row['DataProcedimentoLimite']; ?>
												<?php } ?>

											</p>											
											<p>
												
												<?php if ($row['DataProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastro</b> <?php echo $row['DataProcedimento']; ?>
												<?php } ?>

											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Procedimento:</b> <?php echo nl2br($row['Procedimento']); ?>
											</p>
											<p>
												<?php if ($row['ConcluidoProcedimento']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Conclu�do:</b> <?php echo $row['ConcluidoProcedimento']; ?>
												<?php }?>
											</p>
										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

									<!-- N�o Concluido-Or� -->
									<div role="tabpanel" class="tab-pane " id="nao_concluido_orc">

										<?php
										if ($nao_concluido_orc) {

											foreach ($nao_concluido_orc->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-danger" id=callout-overview-not-both>

											<a class="btn btn-danger" href="<?php echo base_url() . 'orcatrata/alterar/' . $row['idApp_OrcaTrata'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados
											</a>
											<!--
											<a class="btn btn-md btn-info" target="_blank" href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_Procedimento']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Vers�o para Impress�o
											</a>
											-->
											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Procd.:</b> <?php echo $row['idApp_Procedimento']; ?> -
												<span class="glyphicon glyphicon-tags"></span> <b>Or�am.:</b> <?php echo $row['idApp_OrcaTrata']; ?>
											</h4>
											<br>
											<p>
												
												<?php if ($row['DataProcedimentoLimite']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Retorno</b> <?php echo $row['DataProcedimentoLimite']; ?>
												<?php } ?>

											</p>											
											<p>
												
												<?php if ($row['DataProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastro</b> <?php echo $row['DataProcedimento']; ?>
												<?php } ?>

											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Procedimento:</b> <?php echo nl2br($row['Procedimento']); ?>
											</p>
											<p>
												<?php if ($row['ConcluidoProcedimento']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Conclu�do:</b> <?php echo $row['ConcluidoProcedimento']; ?>
												<?php }?>
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
