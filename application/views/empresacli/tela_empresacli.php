<?php if ($msg) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Empresa'])) { ?>

<div class="container-fluid">
	<div class="row">
			
		<div class="col-md-offset-3 col-md-6">

			<div class="panel panel-primary">

				<div class="panel-heading"><strong><?php echo '<strong>' . $_SESSION['Empresa']['NomeEmpresa'] . '</strong> - <small>Id.: ' . $_SESSION['Empresa']['idSis_Empresa'] . '</small>' ?></strong></div>
				<div class="panel-body">
					<div style="overflow: auto; height: 400px; ">
						<div class="form-group">
							<div class="form-group">	
								<div class="row">
									<div class="col-sm-offset-1 col-lg-4 " align="left"> 
										<img alt="User Pic" src="<?php echo base_url() . 'arquivos/imagens/profile-' . $query['idSis_Empresa'] . '.png'; ?>" 
											 class="img-circle img-responsive">
									</div>
									<div class=" col-md-6"> 
										<table class="table table-user-information">
											<tbody>
												
												<?php 
												
												if ($query['NomeEmpresa']) {
													
												echo ' 
												<tr>
													<td><span class="glyphicon glyphicon-home"></span> Empresa:</td>
													<td>' . $query['NomeEmpresa'] . '</td>
												</tr>  
												';
												
												}
												
												if ($query['Celular']) {
													
												echo '                                                 
												<tr>
													<td><span class="glyphicon glyphicon-phone-alt"></span> Telefone:</td>
													<td>' . $query['Celular'] . '</td>
												</tr>
												';
												
												}
												
												
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
											
									</div>
 
								</div>
							</div>	
							<div class="row">
								<div class="col-md-12">
									<div class="col-md-6 text-center">
										<!--<label for="">Empresa:</label>-->
										<div class="form-group">
											<div class="row">							
												<a href="https://www.ktracaengenharia.com.br/<?php echo '' . $_SESSION['Empresa']['Site'] . '' ?> "target="_blank">
													<button type="button" class="btn btn-success">
														<strong>Clic aqui e </strong>
														<h3>Acesse o Site</h3>
														
													</button>
												</a>
											</div>
										</div>	
									</div>
									<div class="col-md-6 text-center">
										<div class="form-group">
											<div class="row">							
												<a <?php if (preg_match("/empresacli\/cadastrarproc\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'empresacli/cadastrarproc/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
														<button type="button" class="btn btn-info">
															<strong>Clic aqui e </strong>
															<h3>Fale Conosco</h3>
														</button>
													</a>
												</a>
											</div>
										</div>	
									</div>
									<!--
									<div class="col-md-4 text-left">
										<div class="form-group">
											<div class="row">							
												<a href="https://www.ktracaengenharia.com.br/<?php echo '' . $_SESSION['Empresa']['Site'] . '' ?> "target="_blank">
													<button type="button" class="btn btn-success">
														<strong>Fale Conosco2</strong>
														<h4>  <?php echo '<strong>' . $_SESSION['Empresa']['NomeEmpresa'] . '</strong>' ?> </h4>
													</button>
												</a>
											</div>
										</div>	
									</div>
									-->
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