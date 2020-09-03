<?php if (isset($msg)) echo $msg; ?>

<div class="col-md-8 ">
	<div class="row">
		<div class="col-md-12 col-lg-12">
			<?php echo validation_errors(); ?>
			<?php echo form_open_multipart($form_open_path); ?>
			<div class="panel panel-<?php echo $panel; ?>">
				<div class="panel-heading">
					<h1 class="text-center"><b> Selecione a <?php echo $titulo; ?></b></h1>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="col-md-4">
	<div class="panel panel-danger ">
		<div class="panel-heading">
			<div class="text-center" type="button" data-toggle="collapse" data-target="#StatusOrç" aria-expanded="false" aria-controls="StatusOrç">
				 <h4><b>Status dos Pedidos</b></h4>
			</div>		
		
			<div <?php echo $collapse; ?> id="StatusOrç">
						
					<div class="row">
					<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
						<div class="col-md-12">	
							<div class="panel panel-danger">
								<div class="panel-heading">
									<div type="button" data-toggle="collapse" data-target="#NaoEntregues" aria-expanded="false" aria-controls="NaoEntregues">
										Aguardando <b>Aprovação</b>
									</div>
									
								</div>
								<div <?php echo $collapse; ?> id="NaoEntregues">	
									<div class="panel-body">
										
										<?php if (isset($list1)) echo $list1; ?>

									</div>
								</div>	
							</div>
						</div>
						<div class="col-md-12">
							<div class="panel panel-warning">
								<div class="panel-heading">
									<div type="button" data-toggle="collapse" data-target="#NaoEntreguesOnline" aria-expanded="false" aria-controls="NaoEntreguesOnline">
										Aguardando <b>Entrega</b>
									</div>					
								</div>
								<div <?php echo $collapse; ?> id="NaoEntreguesOnline">
									<div class="panel-body">

										<?php if (isset($list11)) echo $list11; ?>

									</div>
								</div>	
							</div>
						</div>
						<div class="col-md-12">
							<div class="panel panel-warning">
								<div class="panel-heading">
									<div type="button" data-toggle="collapse" data-target="#NaoDevolvidosOnline" aria-expanded="false" aria-controls="NaoDevolvidosOnline">
										Aguardando <b>Pagamento</b>
									</div>			
								</div>
								<div <?php echo $collapse; ?> id="NaoDevolvidosOnline">				
									<div class="panel-body">

										<?php if (isset($list12)) echo $list12; ?>

									</div>
								</div>	
							</div>
						</div>		
						<!--
						<div class="col-md-12">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<div class=" btn btn-info" type="button" data-toggle="collapse" data-target="#NaoRecebidos" aria-expanded="false" aria-controls="NaoRecebidos">
										<span class="glyphicon glyphicon-chevron-up"></span> Não Recebidos
									</div>
									<a class="btn btn-md btn-warning" href="<?php #echo base_url() ?>relatorio/fiadorec" role="button">
										<span class="glyphicon glyphicon-search"></span> Fiado
									</a>
								</div>
								<div <?php #echo $collapse1; ?> id="NaoRecebidos">	
									<div class="panel-body">

										<?php #if (isset($list2)) echo $list2; ?>

									</div>
								</div>	
							</div>
						</div>
						-->	
					<?php } else { ?>
							
						<div class="col-md-12">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<div class=" btn btn-info" type="button" data-toggle="collapse" data-target="#NaoRecebidos" aria-expanded="false" aria-controls="NaoRecebidos">
										Resumo <span class="glyphicon glyphicon-chevron-down"></span>
									</div>					
									<a class="btn btn-md btn-warning" href="<?php echo base_url() ?>relatorio/parcelasrec" role="button">
										<span class="glyphicon glyphicon-search"></span> Rel. das Receitas
									</a>					
								</div>
								<div <?php echo $collapse1; ?> id="NaoRecebidos">
									<div class="panel-body">

										<?php if (isset($list4)) echo $list4; ?>

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
