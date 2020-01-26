<?php if (isset($msg)) echo $msg; ?>
<?php if (( !isset($evento) && isset($_SESSION['log'])) || ( isset($_SESSION['Empresa']))) { ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-offset-3 col-md-6 text-center t">
			<div class="panel panel-primary">
				<div class="panel-heading"></div>
				<div class="panel-body">
					<div class="col-md-12 text-center t">
						<h4><?php echo '<small>Bem Vindo<br> </small><strong>"' . $_SESSION['Usuario']['Nome'] . '"</strong>'  ?></h4>
						<h4><?php echo '<small>a(o)<br></small><strong> ' . $_SESSION['Empresa']['NomeEmpresa'] . '</strong>.'  ?></h4>
					</div>
					<div class="col-sm-offset-4 col-lg-4 " align="center"> 
						<img alt="User Pic" src="<?php echo base_url() . 'arquivos/imagens/empresas/' . $_SESSION['Empresa']['Arquivo'] . ''; ?>" class="img-circle img-responsive" width='200'>
					</div>
					<div class="col-md-12 text-center t">
						<h4><?php echo '<small>Acesse o </small><strong> Menu </strong><small> acima <br>e tenha um bom trabalho! </small>'  ?></h4>
					</div>
				</div>	
			</div>		
		</div>
	</div>
</div>	
<?php } ?>