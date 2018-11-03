<?php if ($msg) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Empresa'])) { ?>

<div class="container-fluid">
	<div class="row">
	
		<div class="col-md-2"></div>
		<div class="col-md-8">
		
			<div class="panel panel-primary">
				
				<div class="panel-heading"><strong><?php echo '<strong>' . $_SESSION['Empresa']['NomeEmpresa'] . '</strong> - <small>Id.: ' . $_SESSION['Empresa']['idSis_Empresa'] . '</small>' ?></strong></div>
				<div class="panel-body">
			
					<div class="form-group">
						<div class="row">
							<div class="col-md-12 col-lg-12">
								<div class="col-md-4 text-left">
									<label for="">Empresa & Contatos:</label>
									
									<div class="form-group">
										<div class="row">							
											<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
												<a class="btn btn-lg btn-success" href="<?php echo base_url() . 'empresa/prontuario/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
													<span class="glyphicon glyphicon-file"> </span> Ver <span class="sr-only">(current)</span>
												</a>
											</a>								
											<?php if ($_SESSION['log']['idSis_Empresa'] == 4) { ?>
											<a <?php if (preg_match("/empresa\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
												<a class="btn btn-lg btn-warning" href="<?php echo base_url() . 'empresa/alterar/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
													<span class="glyphicon glyphicon-edit"></span> Edit.
												</a>
											</a>
											<?php } ?>
										</div>
									</div>
									
								</div>
							</div>	
						</div>
					</div>
					<!--
					<div class="form-group">
						<div class="row">
							<div class="text-center t">
								<h3><?php echo '<strong>' . $_SESSION['Empresa']['NomeEmpresa'] . '</strong> - <small>Id.: ' . $_SESSION['Empresa']['idSis_Empresa'] . '</small>' ?></h3>
							</div>
						</div>
					</div>
					-->
			
					<?php } ?>

					<div class="row">
					
						<div class="col-md-12 col-lg-12">

							<div class="panel panel-<?php echo $panel; ?>">

								<div class="panel-heading"><strong><?php echo '<strong>' . $_SESSION['Empresa']['NomeEmpresa'] . '</strong> - <small>Id.: ' . $_SESSION['Empresa']['idSis_Empresa'] . '</small>' ?></strong></div>
								<div class="panel-body">				
									<table class="table table-user-information">
										<tbody>
											
											<?php 

											if ($query['Endereco'] || $query['Bairro'] || $query['Municipio']) {
												
											echo '                                                 
											<tr>
												<td><span class="glyphicon glyphicon-home"></span> Endereço:</td>
												<td>' . $query['Endereco'] . ' ' . $query['Bairro'] . ' ' . $query['Municipio'] . '</td>
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
																							
											?>
											
										</tbody>
									</table>
									<?php if ($_SESSION['Empresa']['CompUsuario'] == "S") { ?>
									<div class="row">
					
										<div class="col-md-12 col-lg-12">

											<div class="panel panel-primary">

												<div class="panel-heading"><strong>Contatos</strong></div>
												<div class="panel-body">
											
													<?php
													if (!$list) {
													?>
														<a class="btn btn-lg btn-warning" href="<?php echo base_url() ?>contatoempresa/cadastrar" role="button"> 
															<span class="glyphicon glyphicon-plus"></span> Novo Contato
														</a>
														<br><br>
														<div class="alert alert-info" role="alert"><b>Nenhum contato cadastrado</b></div>
													<?php
													} else {
														echo $list;
													}
													?>       
													
												</div>
											</div>
										</div>
									</div>
									<?php } ?>
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
