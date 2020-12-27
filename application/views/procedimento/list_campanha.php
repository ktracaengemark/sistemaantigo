<?php if (isset($msg)) echo $msg; ?>

<div class="container-fluid">
	<div class="row">
	
		<div class="col-md-1"></div>
		<div class="col-md-10 ">
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
							<div class="navbar-form btn-group">
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
							<!--
							<a class="navbar-brand" href="<?php #echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
								<?php #echo '<small>' . $_SESSION['Cliente']['idApp_Cliente'] . '</small> - <small>' . $_SESSION['Cliente']['NomeCliente'] . '.</small>' ?> 
							</a>
							-->
						</div>
						<div class="collapse navbar-collapse" id="myNavbar">
							<ul class="nav navbar-nav navbar-center">
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
											<span class="glyphicon glyphicon-pencil"></span> SAC <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/procedimento\/listarproc\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
													<a href="<?php echo base_url() . 'procedimento/listarproc/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-pencil"></span> Lista de Chamadas
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/procedimento\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'procedimento/cadastrarproc/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-plus"></span> Nova Chamada
													</a>
												</a>
											</li>
										</ul>
									</div>
								</li>
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
									<div class="btn-group">
										<button type="button" class="btn btn-md btn-warning  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-pencil"></span> Marketing <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/procedimento\/listarcampanha\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
													<a href="<?php echo base_url() . 'procedimento/listarcampanha/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-pencil"></span> Lista de Campanhas
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/procedimento\/campanha\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'procedimento/campanha/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-plus"></span> Nova Campanha
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
							<?php echo '<small>' . $titulo . '</small> <strong>' . $_SESSION['Cliente']['NomeCompleto'] . '</strong> - <small>' . $_SESSION['Cliente']['idApp_Cliente'] . '</small>' ?>
						</div>
						<div class="panel-body">

							<div>

								<!-- Nav tabs -->
								<ul class="nav nav-tabs" role="tablist">
									<li role="presentation"><a style="color:green" href="#atualizacao_concl" aria-controls="atualizacao_concl" role="tab" data-toggle="tab">Atualiz. <?php echo $atualizacao_concl->num_rows(); ?></a></li>
									<li role="presentation"><a style="color:green" href="#pesquisa_concl" aria-controls="pesquisa_concl" role="tab" data-toggle="tab">Pesquisa <?php echo $pesquisa_concl->num_rows(); ?></a></li>
									<li role="presentation"><a style="color:green" href="#retorno_concl" aria-controls="retorno_concl" role="tab" data-toggle="tab">Retorno <?php echo $retorno_concl->num_rows(); ?></a></li>
									<li role="presentation"><a style="color:green" href="#promocao_concl" aria-controls="promocao_concl" role="tab" data-toggle="tab">Promo��o <?php echo $promocao_concl->num_rows(); ?></a></li>
									<li role="presentation"><a style="color:green" href="#felicitacao_concl" aria-controls="felicitacao_concl" role="tab" data-toggle="tab">Felicitacao <?php echo $felicitacao_concl->num_rows(); ?></a></li>
									<li role="presentation"	class="active"><a style="color:red" href="#atualizacao_nao_concl" aria-controls="atualizacao_nao_concl" role="tab" data-toggle="tab">Atualiz. <?php echo $atualizacao_nao_concl->num_rows(); ?></a></li>
									<li role="presentation"><a style="color:red" href="#pesquisa_nao_concl" aria-controls="pesquisa_nao_concl" role="tab" data-toggle="tab">Pesquisa <?php echo $pesquisa_nao_concl->num_rows(); ?></a></li>
									<li role="presentation"><a style="color:red" href="#retorno_nao_concl" aria-controls="retorno_nao_concl" role="tab" data-toggle="tab">Retorno <?php echo $retorno_nao_concl->num_rows(); ?></a></li>
									<li role="presentation"><a style="color:red" href="#promocao_nao_concl" aria-controls="promocao_nao_concl" role="tab" data-toggle="tab">Promocao <?php echo $promocao_nao_concl->num_rows(); ?></a></li>
									<li role="presentation"><a style="color:red" href="#felicitacao_nao_concl" aria-controls="felicitacao_nao_concl" role="tab" data-toggle="tab">Felicitacao <?php echo $felicitacao_nao_concl->num_rows(); ?></a></li>
								</ul>

								<!-- Tab panes -->
								<div class="tab-content">

									<!-- atualizacao_concl-->
									<div role="tabpanel" class="tab-pane" id="atualizacao_concl">

										<?php
										if ($atualizacao_concl) {

											foreach ($atualizacao_concl->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-success" id=callout-overview-not-both>

											<a class="btn btn-success" href="<?php echo base_url() . 'procedimento/alterarcampanha/' . $row['idApp_Procedimento'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Campanha
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
												<?php if ($row['DataProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastrado em:</b> <?php echo $row['DataProcedimento']; ?>
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
											<p>
												<?php if ($row['DataConcluidoProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Conclu�do em:</b> <?php echo $row['DataConcluidoProcedimento']; ?>
												<?php } ?>
											</p>
										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

									<!-- atualizacao_nao_concl -->
									<div role="tabpanel" class="tab-pane active" id="atualizacao_nao_concl">

										<?php
										if ($atualizacao_nao_concl) {

											foreach ($atualizacao_nao_concl->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-danger" id=callout-overview-not-both>

											<a class="btn btn-danger" href="<?php echo base_url() . 'procedimento/alterarcampanha/' . $row['idApp_Procedimento'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Campanha
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
												<?php if ($row['DataProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastrado em:</b> <?php echo $row['DataProcedimento']; ?>
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
											<p>
												<?php if ($row['DataConcluidoProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Conclu�do em:</b> <?php echo $row['DataConcluidoProcedimento']; ?>
												<?php } ?>
											</p>
										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

									<!-- pesquisa_concl-->
									<div role="tabpanel" class="tab-pane" id="pesquisa_concl">

										<?php
										if ($pesquisa_concl) {

											foreach ($pesquisa_concl->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-success" id=callout-overview-not-both>

											<a class="btn btn-success" href="<?php echo base_url() . 'procedimento/alterarcampanha/' . $row['idApp_Procedimento'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Campanha
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
												<?php if ($row['DataProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastrado em:</b> <?php echo $row['DataProcedimento']; ?>
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
											<p>
												<?php if ($row['DataConcluidoProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Conclu�do em:</b> <?php echo $row['DataConcluidoProcedimento']; ?>
												<?php } ?>
											</p>
										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

									<!-- pesquisa_nao_concl -->
									<div role="tabpanel" class="tab-pane" id="pesquisa_nao_concl">

										<?php
										if ($pesquisa_nao_concl) {

											foreach ($pesquisa_nao_concl->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-danger" id=callout-overview-not-both>

											<a class="btn btn-danger" href="<?php echo base_url() . 'procedimento/alterarcampanha/' . $row['idApp_Procedimento'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Campanha
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
												<?php if ($row['DataProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastrado em:</b> <?php echo $row['DataProcedimento']; ?>
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
											<p>
												<?php if ($row['DataConcluidoProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Conclu�do em:</b> <?php echo $row['DataConcluidoProcedimento']; ?>
												<?php } ?>
											</p>
										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

									<!-- retorno_concl-->
									<div role="tabpanel" class="tab-pane" id="retorno_concl">

										<?php
										if ($retorno_concl) {

											foreach ($retorno_concl->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-success" id=callout-overview-not-both>

											<a class="btn btn-success" href="<?php echo base_url() . 'procedimento/alterarcampanha/' . $row['idApp_Procedimento'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Campanha
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
												<?php if ($row['DataProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastrado em:</b> <?php echo $row['DataProcedimento']; ?>
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
											<p>
												<?php if ($row['DataConcluidoProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Conclu�do em:</b> <?php echo $row['DataConcluidoProcedimento']; ?>
												<?php } ?>
											</p>
										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

									<!-- retorno_nao_concl -->
									<div role="tabpanel" class="tab-pane" id="retorno_nao_concl">

										<?php
										if ($retorno_nao_concl) {

											foreach ($retorno_nao_concl->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-danger" id=callout-overview-not-both>

											<a class="btn btn-danger" href="<?php echo base_url() . 'procedimento/alterarcampanha/' . $row['idApp_Procedimento'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Campanha
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
												<?php if ($row['DataProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastrado em:</b> <?php echo $row['DataProcedimento']; ?>
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
											<p>
												<?php if ($row['DataConcluidoProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Conclu�do em:</b> <?php echo $row['DataConcluidoProcedimento']; ?>
												<?php } ?>
											</p>
										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

									<!-- promocao_concl-->
									<div role="tabpanel" class="tab-pane" id="promocao_concl">

										<?php
										if ($promocao_concl) {

											foreach ($promocao_concl->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-success" id=callout-overview-not-both>

											<a class="btn btn-success" href="<?php echo base_url() . 'procedimento/alterarcampanha/' . $row['idApp_Procedimento'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Campanha
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
												<?php if ($row['DataProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastrado em:</b> <?php echo $row['DataProcedimento']; ?>
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
											<p>
												<?php if ($row['DataConcluidoProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Conclu�do em:</b> <?php echo $row['DataConcluidoProcedimento']; ?>
												<?php } ?>
											</p>
										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

									<!-- promocao_nao_concl -->
									<div role="tabpanel" class="tab-pane" id="promocao_nao_concl">

										<?php
										if ($promocao_nao_concl) {

											foreach ($promocao_nao_concl->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-danger" id=callout-overview-not-both>

											<a class="btn btn-danger" href="<?php echo base_url() . 'procedimento/alterarcampanha/' . $row['idApp_Procedimento'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Campanha
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
												<?php if ($row['DataProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastrado em:</b> <?php echo $row['DataProcedimento']; ?>
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
											<p>
												<?php if ($row['DataConcluidoProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Conclu�do em:</b> <?php echo $row['DataConcluidoProcedimento']; ?>
												<?php } ?>
											</p>
										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

									<!-- felicitacao_concl-->
									<div role="tabpanel" class="tab-pane" id="felicitacao_concl">

										<?php
										if ($felicitacao_concl) {

											foreach ($felicitacao_concl->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-success" id=callout-overview-not-both>

											<a class="btn btn-success" href="<?php echo base_url() . 'procedimento/alterarcampanha/' . $row['idApp_Procedimento'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Campanha
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
												<?php if ($row['DataProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastrado em:</b> <?php echo $row['DataProcedimento']; ?>
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
											<p>
												<?php if ($row['DataConcluidoProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Conclu�do em:</b> <?php echo $row['DataConcluidoProcedimento']; ?>
												<?php } ?>
											</p>
										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

									<!-- felicitacao_nao_concl -->
									<div role="tabpanel" class="tab-pane" id="felicitacao_nao_concl">

										<?php
										if ($felicitacao_nao_concl) {

											foreach ($felicitacao_nao_concl->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-danger" id=callout-overview-not-both>

											<a class="btn btn-danger" href="<?php echo base_url() . 'procedimento/alterarcampanha/' . $row['idApp_Procedimento'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Campanha
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
												<?php if ($row['DataProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastrado em:</b> <?php echo $row['DataProcedimento']; ?>
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
											<p>
												<?php if ($row['DataConcluidoProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Conclu�do em:</b> <?php echo $row['DataConcluidoProcedimento']; ?>
												<?php } ?>
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
		<div class="col-md-1"></div>
	</div>	
</div>
