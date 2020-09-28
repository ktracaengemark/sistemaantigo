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
		<?php for ($i=1; $i <= $count['POCount']; $i++) { ?>
			<div style="overflow: auto; height: auto; ">
				<table class="table table-bordered table-condensed table-striped">
					<thead>
						<tr>
							<td class="col-md-1 text-left" scope="col"><?php echo ''  . $i . '/' . $count['POCount'] . '' . ' - <strong>' . $orcatrata[$i]['idApp_OrcaTrata'] . '</strong>' . ' - '  . $orcatrata[$i]['DataOrca'] . ''
																		?></td>
							<td class="col-md-3 text-left" scope="col"><?php echo '' . $orcatrata[$i]['idApp_Cliente'] . ' - <strong>' . $orcatrata[$i]['NomeCliente'] . '</strong>'
																				. ' - <strong>Tel.:</strong>' . $orcatrata[$i]['CelularCliente'] . ' - ' . $orcatrata[$i]['Telefone'] . ' - ' . $orcatrata[$i]['Telefone2'] . ' - ' . $orcatrata[$i]['Telefone3'] . ''
																		?></td>
							<td class="col-md-1 text-left" scope="col"><?php echo 'Valor Total:' . 'R$: <strong>'  . $orcatrata[$i]['ValorTotalOrca'] . '</strong>'
																			?></td>
							<td class="col-md-1 text-left" scope="col"><?php echo ''  . $orcatrata[$i]['AVAP'] . '' . ' - <strong>'  . $orcatrata[$i]['FormaPag'] . '</strong>'
																			?></td>
						</tr>
					</thead>
					<thead>
						<tr>
							<th class="col-md-1" scope="col">Qtd</th>
							<th class="col-md-3" scope="col">Produto</th>							
							<th class="col-md-1" scope="col">R$</th>
							<th class="col-md-1" scope="col">Ent?</th>
						</tr>
					</thead>
					<tbody>

						<?php
						for ($k=1; $k <= $count['PCount']; $k++) {
						?>
						<?php if($orcatrata[$i]['idApp_OrcaTrata'] == $produto[$k]['idApp_OrcaTrata']) { ?>
						<tr>
							<td class="col-md-1" scope="col"><?php echo $produto[$k]['Qtd_Prod'] ?></td>
							<td class="col-md-3" scope="col"><?php echo $produto[$k]['NomeProduto'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $produto[$k]['SubtotalProduto'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $produto[$k]['ConcluidoProduto'] ?></td>										
						</tr>
						<?php
						}
						?>
						
						<?php
						}
						?>

					</tbody>
					<thead>
						<tr>
							<th class="col-md-1" scope="col">Parcela</th>
							<th class="col-md-3" scope="col">Venc.</th>
							<th class="col-md-1" scope="col">R$</th>
							<th class="col-md-1" scope="col">Pago?</th>										
						</tr>
					</thead>
					<tbody>
					<?php for ($j=1; $j <= $count['PRCount']; $j++) { ?>
						<?php if($orcatrata[$i]['idApp_OrcaTrata'] == $parcelasrec[$j]['idApp_OrcaTrata']) { ?>
						<tr>
							<td class="col-md-1" scope="col"><?php echo $parcelasrec[$j]['Parcela'] ?></td>
							<td class="col-md-3" scope="col"><?php echo $parcelasrec[$j]['DataVencimento'] ?></td>
							<td class="col-md-1" scope="col"><?php echo number_format($parcelasrec[$j]['ValorParcela'], 2, ',', '.') ?></td>
							<td class="col-md-1" scope="col"><?php echo $this->basico->mascara_palavra_completa($parcelasrec[$j]['Quitado'], 'NS') ?></td>									
						</tr>
						<?php } ?>
					<?php } ?>
					</tbody>					
				</table>
				<?php if( isset($count['PCount']) ) { ?>
				<?php } else echo '<h3 class="text-left">S/Produtos Entregues </h3>';{?>
				<?php } ?>
			</div>
		<?php } ?>
	<?php } else echo '<h3 class="text-center">Nenhum Or�amento Filtrado!</h3>';{?>
	<?php } ?>		

</div>	