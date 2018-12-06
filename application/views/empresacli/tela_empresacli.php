<?php if ($msg) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Empresa'])) { ?>

<div class="container-fluid">
	<div class="row">

		<div class="col-md-3"></div>
		<div class="col-md-6">

			<div class="panel panel-primary">

				<div class="panel-heading"><strong><?php echo '<strong>' . $_SESSION['Empresa']['NomeEmpresa'] . '</strong> - <small>Id.: ' . $_SESSION['Empresa']['idSis_Empresa'] . '</small>' ?></strong></div>
				<div class="panel-body">

					<div class="form-group">
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-6 text-center">
									<!--<label for="">Empresa:</label>-->
									<div class="form-group">
										<div class="row">							
											<a href="https://www.ktracaengenharia.com.br/<?php echo '' . $_SESSION['Empresa']['Site'] . '' ?> "target="_blank">
												<button type="button" class="btn btn-success">
													  <?php echo '<strong>' . $_SESSION['Empresa']['NomeEmpresa'] . '</strong>' ?> 
													<h1>Acesse o Site</h1>
													
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
														  <?php echo '<strong>' . $_SESSION['Empresa']['NomeEmpresa'] . '</strong>' ?> 
														<h1>Fale Conosco</h1>
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
					<?php } ?>
									
				</div>
			</div>
		</div>
		<div class="col-md-3"></div>
	</div>
</div>
