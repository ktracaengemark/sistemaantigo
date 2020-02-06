<?php if ($msg) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Empresa'] ) && isset($_SESSION['Documentos'] )) { ?>
	
	<div class="container-fluid">
		<div class="row">

			<div class="col-sm-offset-2 col-md-8">

				<div class="panel panel-primary">

					<div class="panel-heading">
						<div class="btn-group">
							<button type="button" class="btn btn-sm btn-default  dropdown-toggle" data-toggle="dropdown">
								<span class="glyphicon glyphicon-file"></span> <?php echo '<small>' . $_SESSION['Empresa']['NomeEmpresa'] . '</small> - <small>Id.: ' . $_SESSION['Empresa']['idSis_Empresa'] . '</small>' ?> <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li>
									<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
										<a href="<?php echo base_url() . 'empresa/prontuario/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
											<span class="glyphicon glyphicon-file"> </span> Ver Dados da Empresa
										</a>
									</a>
								</li>
								<li role="separator" class="divider"></li>
								<li>
									<a <?php if (preg_match("/empresa\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
										<a href="<?php echo base_url() . 'empresa/alterar/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
											<span class="glyphicon glyphicon-edit"></span> Editar Dados da Empresa
										</a>
									</a>
								</li>
								<li role="separator" class="divider"></li>
								<li>
									<a <?php if (preg_match("/empresa\/alterarlogo\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
										<a href="<?php echo base_url() . 'empresa/alterarlogo/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
											<span class="glyphicon glyphicon-edit"></span> Alterar Logo
										</a>
									</a>
								</li>								
							</ul>
						</div>
					</div>
					<div class="panel-body">
						<div style="overflow: auto; height: 500px; ">
							<div class="form-group">	
								<div class="row">
									<div class=" col-md-6">	
										<div class="row">	
											<div class="col-sm-offset-2 col-md-10 " align="left"> 
												<a href="<?php echo base_url() . 'empresa/alterar_pagina/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">	
													<img alt="User Pic" src="<?php echo base_url() . 'arquivos/imagens/empresas/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/' . $documentos['Arquivo1'] . ''; ?>" 
													class="img-circle img-responsive" width='200'>
												</a>
											</div>
										</div>		
									</div>
									<div class=" col-md-6">	
										<div class="row">	
											<div class="col-sm-offset-2 col-md-10 " align="left"> 
												<a href="<?php echo base_url() . 'empresa/alterar_pagina/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">	
													<img alt="User Pic" src="<?php echo base_url() . 'arquivos/imagens/empresas/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/' . $documentos['Arquivo2'] . ''; ?>" 
													class="img-circle img-responsive" width='200'>
												</a>
											</div>
										</div>		
									</div>
								</div>	
							</div>		
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
