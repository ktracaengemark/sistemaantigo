<?php if (isset($msg)) echo $msg; ?>

<?php echo validation_errors(); ?>
<div class="col-md-12">	
	<nav class="navbar navbar-inverse navbar-fixed" role="banner">
	  <div class="container-fluid">
		<div class="navbar-header">
			<div class="btn-line " role="group" aria-label="...">	
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span> 
				</button>
				<a type="button" class="btn btn-md btn-default " href="javascript:window.print()">
					<span class="glyphicon glyphicon-print"></span>
				</a>
				
				<a type="button" class="btn btn-md btn-warning"  href="<?php echo base_url() . 'OrcatrataPrintCobranca/imprimir/' . $_SESSION['log']['idSis_Empresa']; ?>">
					<span class="glyphicon glyphicon-pencil"></span> Vers�o Recibo
				</a>
				
			</div>
		</div>
		<!--
		<div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav navbar-center">
				<li class="btn-toolbar btn-lg navbar-form" role="toolbar" aria-label="...">
					<div class="btn-group " role="group" aria-label="...">
						
						<a href="javascript:window.print()">
							<button type="button" class="btn btn-md btn-default ">
								<span class="glyphicon glyphicon-print"></span> Imprimir
							</button>
						</a>
						
					</div>
				</li>
			</ul>
		</div>
		-->
	  </div>
	</nav>	
	<?php if( isset($count['POCount']) ) { ?>
		<div style="overflow: auto; height: auto; ">
			<table class="table table-bordered table-condensed table-striped">
				<thead>
					<tr>
						<th class="col-md-1" scope="col">cont: <?php echo $count['POCount'] ?></th>
						<th class="col-md-1" scope="col">Pedido</th>
						<th class="col-md-1" scope="col">Data</th>
						<th class="col-md-1" scope="col">idCli</th>
						<th class="col-md-3" scope="col">Cliente</th>
						<th class="col-md-2" scope="col">Tel</th>
						<th class="col-md-1" scope="col">Entr/Pago</th>
						<th class="col-md-1" scope="col">Valor</th>
						<th class="col-md-1" scope="col">Lc/Fr.Pag.</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					for ($i=1; $i <= $count['POCount']; $i++) { 
					?>
						<tr>
							<td class="col-md-1" scope="col"><?php echo $i ?></td>
							<td class="col-md-1" scope="col"><?php echo $orcatrata[$i]['idApp_OrcaTrata'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $orcatrata[$i]['DataOrca'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $orcatrata[$i]['idApp_Cliente'] ?></td>
							<td class="col-md-3" scope="col"><?php echo $orcatrata[$i]['NomeCliente'] ?></td>
							<td class="col-md-2" scope="col"><?php echo $orcatrata[$i]['CelularCliente'] ?>
															- <?php echo $orcatrata[$i]['Telefone'] ?>
															- <?php echo $orcatrata[$i]['Telefone2'] ?>
															- <?php echo $orcatrata[$i]['Telefone3'] ?>
															</td>
							<td class="col-md-1" scope="col"><?php echo $orcatrata[$i]['ConcluidoOrca'] ?> / <?php echo $orcatrata[$i]['QuitadoOrca'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $orcatrata[$i]['ValorTotalOrca'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $orcatrata[$i]['AVAP'] ?>/<?php echo $orcatrata[$i]['FormaPag'] ?></td>
						</tr>
					
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	<?php } else echo '<h3 class="text-center">Nenhum Or�amento Filtrado!</h3>';{?>
	<?php } ?>
</div>	