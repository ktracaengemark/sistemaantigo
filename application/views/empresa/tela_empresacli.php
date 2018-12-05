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
							<div class="col-md-12 col-lg-12">
								<div class="col-md-4 text-left">
									<!--<label for="">Empresa:</label>-->
									<div class="form-group">
										<div class="row">							
											<a href="https://www.ktracaengenharia.com.br/<?php echo '' . $_SESSION['Empresa']['Site'] . '' ?> "target="_blank">
												<button type="button" class="btn btn-primary">
													<strong>Acesse o Site</strong>
													<h4>  <?php echo '<strong>' . $_SESSION['Empresa']['NomeEmpresa'] . '</strong>' ?> </h4>
												</button>
											</a>
											<!--
											<a <?php if (preg_match("/empresa\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
												<a class="btn btn-lg btn-warning" href="<?php echo base_url() . 'empresa/alterar/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
													<span class="glyphicon glyphicon-edit"></span> Edit.
												</a>
											</a>
											-->
										</div>
									</div>	
								</div>
								<div class="col-md-4 text-left">
									<div class="form-group">
										<div class="row">							

											<a href="https://www.ktracaengenharia.com.br/<?php echo '' . $_SESSION['Empresa']['Site'] . '' ?> "target="_blank">
												<button type="button" class="btn btn-info">
													<strong>Fale Conosco</strong>
													<h4>  <?php echo '<strong>' . $_SESSION['Empresa']['NomeEmpresa'] . '</strong>' ?> </h4>
												</button>
											</a>

										</div>
									</div>	
								</div>
								<div class="col-md-4 text-left">
									<div class="form-group">
										<div class="row">							

											<a href="https://www.ktracaengenharia.com.br/<?php echo '' . $_SESSION['Empresa']['Site'] . '' ?> "target="_blank">
												<button type="button" class="btn btn-success">
													<strong>yuyuuyuyu</strong>
													<h4>  <?php echo '<strong>' . $_SESSION['Empresa']['NomeEmpresa'] . '</strong>' ?> </h4>
												</button>
											</a>

										</div>
									</div>	
								</div>
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
