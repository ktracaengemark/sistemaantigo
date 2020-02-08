<?php if ($msg) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Empresa'] ) && isset($_SESSION['Documentos'] )) { ?>

	<div class="panel-body">
		<div class="espaco-topo">
			<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
			<!-- Indicators -->
				<ol class="carousel-indicators">
					<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
					<li data-target="#carousel-example-generic" data-slide-to="1"></li>				
				</ol>

				<!-- Wrapper for slides -->
				<div class="carousel-inner" role="listbox">
					<div class="item active">						<!--///////////// Mudar ""Número da Empresa"" //////////////////////////////////-->
						<a href="<?php echo base_url() . 'empresa/alterar_slide_1/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
							<img src="<?php echo base_url() . 'arquivos/imagens/empresas/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Documentos']['Slide1'] . ''; ?>">
						</a>
					</div>
					<div class="item">								<!--///////////////Mudar ""Número da Empresa"" //////////////////////////////////-->
						<a href="<?php echo base_url() . 'empresa/alterar_slide_2/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
							<img src="<?php echo base_url() . 'arquivos/imagens/empresas/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Documentos']['Slide2'] . ''; ?>">
						</a>
					</div> 					
				</div>

				<!-- Controls -->
				<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
		</div>		
		<div class="container">
			<div class="row">
				<div class="col-md-12">
				<h2 class="form-signin-heading text-left">Nossos Produtos!</h2>
				</div>	
				<div class="col-md-3 col-sm-3 col-xs-6">	
					<div class="thumbnail">
						<a href="<?php echo base_url() . 'empresa/alterar_imagem_1/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">	
							<img alt="User Pic" src="<?php echo base_url() . 'arquivos/imagens/empresas/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Documentos']['Arquivo1'] . ''; ?>" 
							class="img-responsive" width='200'>
						</a>
						<div class="caption">
							<a href="<?php echo base_url() . 'empresa/alterar_texto_1/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
								<h5><?php echo $_SESSION['Documentos']['Texto_Arquivo1']; ?></h5>
							</a>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-6">	
					<div class="thumbnail"> 
						<a href="<?php echo base_url() . 'empresa/alterar_imagem_2/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">	
							<img alt="User Pic" src="<?php echo base_url() . 'arquivos/imagens/empresas/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Documentos']['Arquivo2'] . ''; ?>" 
							class="img-responsive" width='200'>
						</a>
						<div class="caption">
							<a href="<?php echo base_url() . 'empresa/alterar_texto_1/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
								<h5><?php echo $_SESSION['Documentos']['Texto_Arquivo2']; ?></h5>
							</a>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-6">	
					<div class="thumbnail">
						<a href="<?php echo base_url() . 'empresa/alterar_imagem_3/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">	
							<img alt="User Pic" src="<?php echo base_url() . 'arquivos/imagens/empresas/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Documentos']['Arquivo3'] . ''; ?>" 
							class="img-responsive" width='200'>
						</a>
						<div class="caption">
							<a href="<?php echo base_url() . 'empresa/alterar_texto_1/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
								<h5><?php echo $_SESSION['Documentos']['Texto_Arquivo3']; ?></h5>
							</a>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-6">	
					<div class="thumbnail">
						<a href="<?php echo base_url() . 'empresa/alterar_imagem_4/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">	
							<img alt="User Pic" src="<?php echo base_url() . 'arquivos/imagens/empresas/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Documentos']['Arquivo4'] . ''; ?>" 
							class="img-responsive" width='200'>
						</a>
						<div class="caption">
							<a href="<?php echo base_url() . 'empresa/alterar_texto_1/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
								<h5><?php echo $_SESSION['Documentos']['Texto_Arquivo4']; ?></h5>
							</a>
						</div>
					</div>
				</div>
			</div>								
		</div>
	</div>
				

<?php } ?>
