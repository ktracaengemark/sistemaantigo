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
				<div class="navbar-form btn-group">
					<!--
					<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
						<span class="glyphicon glyphicon-user"></span>
					</button>
					-->
					<a type="button" class="btn btn-md btn-default " href="javascript:window.print()">
						<span class="glyphicon glyphicon-print"></span> Print
					</a>		
					<a  type="button" class="btn btn-md btn-default text-left" href="<?php echo base_url() ?>relatorio/receitas" role="button"> 
						<span class="glyphicon glyphicon-pencil"></span> Receitas
					</a>
				</div>
			</div>
		</div>
	  </div>
	</nav>	
	<?php if( isset($count['POCount']) ) { ?>
		<div style="overflow: auto; height: auto; ">
			<table class="  table-condensed table-striped">
				<thead>
					<tr>
						<td class="col-md-1" scope="col"><img  alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Empresa']['Arquivo'] . ''; ?>"class="img-circle img-responsive" width='50'></td>
						<td class="col-md-3 text-left" scope="col">
							<?php 
								echo '<strong>' . $_SESSION['Empresa']['NomeEmpresa'] . '</strong>  "' . $titulo . '"'
							?>
						</td>
						<td class="col-md-4 text-left" scope="col">
							<?php if($Imprimir['DataInicio'] || $Imprimir['DataFim']){ echo '<h4>Receita:</h4>';} ?>
							<?php if($Imprimir['DataInicio']){ echo 'Inic <strong>'  . $Imprimir['DataInicio'] . '</strong> ';} ?>
							<?php if($Imprimir['DataFim']){ echo 'Fim <strong>'  . $Imprimir['DataFim'] . '</strong> ';} ?>
						</td>
						<td class="col-md-4 text-left" scope="col">
							<?php if($Imprimir['DataInicio6'] || $Imprimir['DataFim6']){ echo '<h4>Cadastro:</h4>';} ?>
							<?php if($Imprimir['DataInicio6']){ echo 'Inic <strong>'  . $Imprimir['DataInicio6'] . '</strong> ';} ?>
							<?php if($Imprimir['DataFim6']){ echo 'Fim <strong>'  . $Imprimir['DataFim6'] . '</strong> ';} ?>
						</td>
					</tr>
				</thead>
			</table>
			<table class="table table-bordered table-condensed table-striped">	
				<thead>
					<tr>
						<th class="col-md-1" scope="col">cont: <?php echo $count['POCount'] ?> - Pedido</th>
						<th class="col-md-1" scope="col">DtPedido</th>
						<th class="col-md-1" scope="col">id</th>
						<th class="col-md-2" scope="col">Cliente</th>
						<th class="col-md-2" scope="col">Cadastro</th>
						<th class="col-md-2" scope="col">Tel</th>
						<th class="col-md-1" scope="col">Lc/Fr.Pag.</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					for ($i=1; $i <= $count['POCount']; $i++) { 
					?>
						<tr>
							<td class="col-md-1" scope="col"><?php echo $i ?> - <?php echo $orcatrata[$i]['idApp_OrcaTrata'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $orcatrata[$i]['DataOrca'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $orcatrata[$i]['idApp_Cliente'] ?></td>
							<td class="col-md-2" scope="col"><?php echo $orcatrata[$i]['NomeCliente'] ?></td>
							<td class="col-md-2" scope="col"><?php echo $orcatrata[$i]['DataCadastroCliente'] ?></td>
							<td class="col-md-2" scope="col"><?php echo $orcatrata[$i]['CelularCliente'] ?>
															- <?php echo $orcatrata[$i]['Telefone'] ?>
															- <?php echo $orcatrata[$i]['Telefone2'] ?>
															- <?php echo $orcatrata[$i]['Telefone3'] ?>
															</td>
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