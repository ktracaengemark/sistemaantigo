<?php if ($msg) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Empresa'] ) && isset($_SESSION['Documentos'] ) && isset($_SESSION['Produtos'] )) { ?>
<div class="col-lg-2"></div>
<div class="col-lg-8">
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
					<div class="item active">						
						<a href="<?php echo base_url() . 'empresa/alterar_slide_1/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
							<img src="<?php echo base_url() . 'arquivos/imagens/empresas/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Documentos']['Slide1'] . ''; ?>">
						</a>
					</div>
					<div class="item">								
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
		<div class="panel-body">
			<?php if (isset($list1)) echo $list1; ?>
		</div>
	</div>
</div>

<?php } ?>
