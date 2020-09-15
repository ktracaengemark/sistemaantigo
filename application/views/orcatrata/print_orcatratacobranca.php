<?php if (isset($msg)) echo $msg; ?>

<?php echo validation_errors(); ?>

<div class="col-md-12 ">	
	<nav class="navbar navbar-inverse navbar-fixed" role="banner">
	  <div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span> 
			</button>
		</div>
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
	  </div>
	</nav>	
	<?php if( isset($count['POCount']) ) { ?>	
		<?php for ($i=1; $i <= $count['POCount']; $i++) { ?>
			<div style="overflow: auto; height: auto; ">
				<table class="table table-bordered table-condensed table-striped">
					<tbody>
						<tr>
							<td class="col-md-1" scope="col"><img  alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Empresa']['Arquivo'] . ''; ?>"class="img-circle img-responsive" width='100'></td>
							<td class="col-md-4 text-left" scope="col"><?php echo '<strong>' . $_SESSION['Empresa']['NomeEmpresa'] . ' <br> Cliente: ' . $orcatrata[$i]['NomeCliente'] . ' id: ' . $orcatrata[$i]['idApp_Cliente'] . ' <br> Orçamento:' . $orcatrata[$i]['idApp_OrcaTrata'] . '</strong>' ?></td>
							<td class="col-md-1" scope="col"><?php echo 'Data: <br>'  . $orcatrata[$i]['DataOrca'] . '<br>' . $i ?></td>
							<td class="col-md-1" scope="col"><img  alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Empresa']['Arquivo'] . ''; ?>"class="img-circle img-responsive" width='100'></td>
							<td class="col-md-4 text-left" scope="col"><?php echo '<strong>' . $_SESSION['Empresa']['NomeEmpresa'] . ' <br> Cliente: ' . $orcatrata[$i]['NomeCliente'] . ' id: ' . $orcatrata[$i]['idApp_Cliente'] . ' <br> Orçamento:' . $orcatrata[$i]['idApp_OrcaTrata'] . '</strong>' ?></td>
							<td class="col-md-1" scope="col"><?php echo 'Data: <br>'  . $orcatrata[$i]['DataOrca'] . '<br>' . $i ?></td>
						</tr>
					</tbody>
				</table>								
				
				<?php if( isset($count['PCount']) ) { ?>
				<!--<h3 class="text-left">Produtos</h3>-->

				<table class="table table-bordered table-condensed table-striped">
					<thead>
						<tr>
							
							<th class="col-md-1" scope="col">Qtd</th>
							<th class="col-md-3" scope="col">Produto</th>							
							<th class="col-md-1" scope="col">R$</th>
							<th class="col-md-1" scope="col">Ent</th>
							
							<th class="col-md-1" scope="col">Qtd</th>
							<th class="col-md-3" scope="col">Produto</th>							
							<th class="col-md-1" scope="col">R$</th>
							<th class="col-md-1" scope="col">Ent</th>
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
				</table>
				<!--
				<table class="table table-bordered table-condensed table-striped">
					<thead>
							
						<tr>
							
								
							<th class="col-md-2" scope="col">Obs</th>
							<th class="col-md-1" scope="col">Ent</th>
							
							
								
							<th class="col-md-2" scope="col">Obs</th>
							<th class="col-md-1" scope="col">Ent</th>											
							
						</tr>
					</thead>

					<tbody>

						<?php
						for ($k=1; $k <= $count['PCount']; $k++) {
						?>
						<?php if($orcatrata[$i]['idApp_OrcaTrata'] == $produto[$k]['idApp_OrcaTrata']) { ?>
												
						<tr>
							
							
							<td class="col-md-2" scope="col"><?php echo $produto[$i]['ObsProduto'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $produto[$k]['ConcluidoProduto'] ?></td>
						
							
							
							<td class="col-md-2" scope="col"><?php echo $produto[$i]['ObsProduto'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $produto[$k]['ConcluidoProduto'] ?></td>										
						</tr>

						
						<?php
						}
						?>
						
						<?php
						}
						?>

					</tbody>
				</table>
				-->
				<?php } else echo '<h3 class="text-left">S/Produtos Entregues </h3>';{?>
				<?php } ?>						

				<!--<h3 class="text-left">Parcelas</h3>-->
				<table class="table table-bordered table-condensed table-striped">
					<thead>
						<tr>
							<!--<th class="col-md-2" scope="col">j</th>-->
							<th class="col-md-1" scope="col">Parcela</th>
							<th class="col-md-3" scope="col">R$</th>											
							<th class="col-md-1" scope="col">Venc.</th>
							<th class="col-md-1" scope="col">Qt?</th>
							
							<th class="col-md-1" scope="col">Parcela</th>
							<th class="col-md-3" scope="col">R$</th>											
							<th class="col-md-1" scope="col">Venc.</th>
							<th class="col-md-1" scope="col">Qt?</th>											
						</tr>
					</thead>
					<tbody>
					<?php for ($j=1; $j <= $count['PRCount']; $j++) { ?>
						<?php if($orcatrata[$i]['idApp_OrcaTrata'] == $parcelasrec[$j]['idApp_OrcaTrata']) { ?>
						<tr>
							<!--<td><?php echo $j ?></td>-->
							<td class="col-md-1" scope="col"><?php echo $parcelasrec[$j]['Parcela'] ?></td>
							<td class="col-md-3" scope="col"><?php echo number_format($parcelasrec[$j]['ValorParcela'], 2, ',', '.') ?></td>											
							<td class="col-md-1" scope="col"><?php echo $parcelasrec[$j]['DataVencimento'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $this->basico->mascara_palavra_completa($parcelasrec[$j]['Quitado'], 'NS') ?></td>									
						
							<td class="col-md-1" scope="col"><?php echo $parcelasrec[$j]['Parcela'] ?></td>
							<td class="col-md-3" scope="col"><?php echo number_format($parcelasrec[$j]['ValorParcela'], 2, ',', '.') ?></td>											
							<td class="col-md-1" scope="col"><?php echo $parcelasrec[$j]['DataVencimento'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $this->basico->mascara_palavra_completa($parcelasrec[$j]['Quitado'], 'NS') ?></td>										
						</tr>
						<?php } ?>
					<?php } ?>
					</tbody>
				</table>
			</div>
		<?php } ?>
	<?php } else echo '<h3 class="text-center">Nenhum Orçamento Filtrado!</h3>';{?>
	<?php } ?>		

</div>	