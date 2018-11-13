<?php if (isset($msg)) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Cliente'])) { ?>

<div class="container-fluid">
	<div class="row">
	
		<div class="col-md-2"></div>
		<div class="col-md-8 ">

			<?php if ($_SESSION['Cliente']['idApp_Cliente'] != 1 ) { ?>
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
						<?php if ($_SESSION['Empresa']['NivelEmpresa'] >= 4 ) { ?>
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
						<?php } ?>
					</ul>

				</div>
			  </div>
			</nav>
			<?php } ?>		
<?php } ?>
			<div class="row">
			
				<div class="col-md-12 col-lg-12">

					<div class="panel panel-<?php echo $panel; ?>">

						<div class="panel-heading"><strong>Agendamentos</strong></div>
						<div class="panel-body">

							<div>

								<!-- Nav tabs -->
								<ul class="nav nav-tabs" role="tablist">
									<li role="presentation" ><a href="#anterior" aria-controls="anterior" role="tab" data-toggle="tab">Hist. de Agend.</a></li>
									<li role="presentation" class="active"><a href="#proxima" aria-controls="proxima" role="tab" data-toggle="tab">Próx. Agend.</a></li>
								   
								</ul>

								<!-- Tab panes -->
								<div class="tab-content">
									
									<!-- Histórico de Consultas -->
									<div role="tabpanel" class="tab-pane" id="anterior">

										<?php
										if ($anterior) {

											foreach ($anterior->result_array() as $row) {

												$row['DataInicio'] = explode(' ', $row['DataInicio']);
												$row['DataFim'] = explode(' ', $row['DataFim']);

												($row['Paciente'] == 'D') ? 
													$row['NomePaciente'] = '<b>ContatoCliente</b> - ' . $row['NomeContatoCliente'] : 
													$row['NomePaciente'] = 'O Próprio ';
												
												echo '<div data-href="' . base_url() . 'consulta/alterar/' . $row['idApp_Cliente'] . '/' . $row['idApp_Consulta'] . '" '
												. 'class="clickable-row bs-callout bs-callout-' . $this->basico->tipo_status_cor($row['idTab_Status']) . '">';
												echo '<h4><b>Status: ' . $row['Status'] . '</b></h4>';
												echo '<p><b>Data:</b> ' . $this->basico->mascara_data($row['DataInicio'][0], 'barras') . ' '
												. 'das ' . substr($row['DataInicio'][1], 0, 5) . ' às ' . substr($row['DataFim'][1], 0, 5) . '</p>';
												#echo '<p><b>Fregues:</b> ' . $row['NomePaciente'] . '</p>';
												echo '<p><b>Profissional:</b> ' . $row['Nome'] . '</p>';                                
												echo '<p><b>Obs:</b><br> ' . nl2br($row['Obs']) . '</p>';
												echo '</div>';                                
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhuma consulta registrada</b></div>';
										}
										?>            

									</div>
									
									<!-- Próximas Consultas -->
									<div role="tabpanel" class="tab-pane active" id="proxima">

										<?php
										if ($proxima) {

											foreach ($proxima->result_array() as $row) {

												$row['DataInicio'] = explode(' ', $row['DataInicio']);
												$row['DataFim'] = explode(' ', $row['DataFim']);

												($row['Paciente'] == 'D') ? 
													$row['NomePaciente'] = '<b>ContatoCliente</b> - ' . $row['NomeContatoCliente'] : 
													$row['NomePaciente'] = 'O Próprio ';
												
												echo '<div data-href="' . base_url() . 'consulta/alterar/' . $row['idApp_Cliente'] . '/' . $row['idApp_Consulta'] . '" '
												. 'class="clickable-row bs-callout bs-callout-' . $this->basico->tipo_status_cor($row['idTab_Status']) . '">';
												echo '<h4><b>Status: ' . $row['Status'] . '</b></h4>';
												echo '<p><b>Data:</b> ' . $this->basico->mascara_data($row['DataInicio'][0], 'barras') . ' '
												. 'das ' . substr($row['DataInicio'][1], 0, 5) . ' às ' . substr($row['DataFim'][1], 0, 5) . '</p>';
												#echo '<p><b>Fregues:</b> ' . $row['NomePaciente'] . '</p>';
												echo '<p><b>Profissional:</b> ' . $row['Nome'] . '</p>';                                
												echo '<p><b>Obs:</b><br> ' . nl2br($row['Obs']) . '</p>';
												echo '</div>';
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhuma consulta registrada</b></div>';
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

	
