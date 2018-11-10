<?php if ($msg) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Cliente'])) { ?>

<div class="container-fluid">
	<div class="row">
	
		<div class="col-md-2"></div>
		<div class="col-md-8">
		
			<nav class="navbar navbar-inverse">
			  <div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span> 
					</button>
					<!--
					<a class="navbar-brand" href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
						<?php echo '<small>' . $_SESSION['Cliente']['NomeCliente'] . '</small> - <small>' . $_SESSION['Cliente']['idApp_Cliente'] . '</small>' ?> 
					</a>
					-->
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
					<ul class="nav navbar-nav navbar-center">
						<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
							<div class="btn-group">
								<button type="button" class="btn btn-sm btn-default  dropdown-toggle" data-toggle="dropdown">
									<span class="glyphicon glyphicon-user"></span> <?php echo '<small>' . $_SESSION['Cliente']['NomeCliente'] . '</small> - <small>' . $_SESSION['Cliente']['idApp_Cliente'] . '</small>' ?> <span class="caret"></span>
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
									<span class="glyphicon glyphicon-usd"></span> Or�amentos <span class="caret"></span>
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

					<div class="panel panel-<?php echo $panel; ?>">

						<div class="panel-heading"><strong>Cliente</strong></div>
						<div class="panel-body">				
																																		 
							<table class="table table-user-information">
								<tbody>
									
									<?php 
									
									if ($query['idSis_Empresa']) {
										
									echo ' 
									<tr>
										<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-home"></span> idSis_Empresa:</td>
										<td>' . $query['idSis_Empresa'] . '</td>
									</tr>  
									';
									
									}
									
									if ($query['RegistroFicha']) {
										
									echo ' 
									<tr>
										<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-user"></span> Ficha N�:</td>
										<td>' . $query['RegistroFicha'] . '</td>
									</tr>  
									';
									
									}
									
									if ($query['DataNascimento']) {
										
									echo '                         
									<tr>
										<td><span class="glyphicon glyphicon-gift"></span> Data de Nascimento:</td>
											<td>' . $query['DataNascimento'] . '</td>
									</tr>
									<tr>
										<td><span class="glyphicon glyphicon-gift"></span> Idade:</td>
											<td>' . $query['Idade'] . ' anos</td>
									</tr>                        
									';
									
									}
									
									if ($query['Telefone']) {
										
									echo '                                                 
									<tr>
										<td><span class="glyphicon glyphicon-phone-alt"></span> Telefone:</td>
										<td>' . $query['Telefone'] . '</td>
									</tr>
									';
									
									}
									
									if ($query['Sexo']) {
										
									echo '                                                 
									<tr>
										<td><span class="glyphicon glyphicon-heart"></span> Sexo:</td>
										<td>' . $query['Sexo'] . '</td>
									</tr>
									';
									
									}
									
									if ($query['Endereco'] || $query['Bairro'] || $query['Municipio']) {
										
									echo '                                                 
									<tr>
										<td><span class="glyphicon glyphicon-home"></span> Endere�o:</td>
										<td>' . $query['Endereco'] . ' - ' . $query['Bairro'] . ' - ' . $query['Municipio'] . '</td>
									</tr>
									';
									
									}
									
									if ($query['Cep']) {
										
									echo '                                                 
									<tr>
										<td><span class="glyphicon glyphicon-envelope"></span> Cep:</td>
										<td>' . $query['Cep'] . '</td>
									</tr>
									';
									
									}
									
									if ($query['CpfCliente']) {
										
									echo '                                                 
									<tr>
										<td><span class="glyphicon glyphicon-pencil"></span> CpfCliente:</td>
										<td>' . $query['CpfCliente'] . '</td>
									</tr>
									';
									
									}
									
									if ($query['Rg'] || $query['OrgaoExp'] || $query['Estado'] || $query['DataEmissao']) {
										
									echo '                                                 
									<tr>
										<td><span class="glyphicon glyphicon-pencil"></span> Rg:</td>
										<td>' . $query['Rg'] . ' - ' . $query['OrgaoExp'] . ' - ' . $query['Estado'] . ' - ' . $query['DataEmissao'] . '</td>
									</tr>
									';
									
									}
									
									if ($query['Email']) {
										
									echo '                                                 
									<tr>
										<td><span class="glyphicon glyphicon-envelope"></span> E-mail:</td>
										<td>' . $query['Email'] . '</td>
									</tr>
									';
									
									}
									
									if ($query['Obs']) {
										
									echo '                                                 
									<tr>
										<td><span class="glyphicon glyphicon-file"></span> Obs:</td>
										<td>' . nl2br($query['Obs']) . '</td>
									</tr>
									';
									
									}
									
									if ($query['Profissional']) {
										
									echo '                                                 
									<tr>
										<td><span class="glyphicon glyphicon-user"></span> Profissional:</td>
										<td>' . $query['Profissional'] . '</td>
									</tr>
									';
									
									}
									
									if ($query['Ativo']) {
										
									echo '                                                 
									<tr>
										<td><span class="glyphicon glyphicon-alert"></span> Ativo:</td>
										<td>' . $query['Ativo'] . '</td>
									</tr>
									';
									
									}
									?>
									
								</tbody>
							</table>

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
												<div class="alert alert-info" role="alert"><b>Nenhum Cad.</b></div>
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
					</div>		
				</div>
			</div>									
			
		</div>
		<div class="col-md-2"></div>
	</div>	
</div>


      

