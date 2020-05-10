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
	
			
				<!--
				<div class="row">
					<div class="col-md-3 text-left">
						<img alt="User Pic" src="<?php echo base_url() . 'arquivos/imagens/empresas/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Empresa']['Arquivo'] . ''; ?>" class="img-responsive" width='120'>
					</div>
					
					<div class="col-md-9 text-left">
						<h2><?php echo '<strong>' . $_SESSION['Empresa']['NomeEmpresa'] . '</strong>' ?></h2>
						
						<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>								
						<h3><?php echo '' . $_SESSION['Cliente']['NomeCliente'] . ' - ' . $_SESSION['Cliente']['idApp_Cliente'] . '' ?></h3>
						<?php } ?>
						
						<h3><?php echo $orcatrata[$i]['NomeCliente'] ?> - <?php echo $orcatrata[$i]['idApp_Cliente'] ?></h3>						
					</div>
					
				</div>
										
				<h3 class="text-left">Orçamento - <?php echo $orcatrata[$i]['idApp_OrcaTrata'] ?></h3>
				-->
				<table class="table table-bordered table-condensed table-striped">
					<!--
					<thead>
						<tr>
							<th class="col-md-2" scope="col">Logo</th>
							<th class="col-md-2" scope="col">Orc.</th>

						</tr>
					</thead>
					-->
					<tbody>

						<tr>

							<td class="col-md-1" scope="col"><img  alt="User Pic" src="<?php echo base_url() . 'arquivos/imagens/empresas/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Empresa']['Arquivo'] . ''; ?>"class="img-circle img-responsive" width='100'></td>
							<td class="col-md-5 text-center" scope="col"><?php echo '<strong>' . $_SESSION['Empresa']['NomeEmpresa'] . ' <br><br> Cliente: ' . $orcatrata[$i]['NomeCliente'] . ' id: ' . $orcatrata[$i]['idApp_Cliente'] . ' <br><br> Orçamento:' . $orcatrata[$i]['idApp_OrcaTrata'] . '</strong>' ?> </td>
							<!--<td class="col-md-2" scope="col"></td>-->
							<td class="col-md-1" scope="col"><img  alt="User Pic" src="<?php echo base_url() . 'arquivos/imagens/empresas/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Empresa']['Arquivo'] . ''; ?>"class="img-circle img-responsive" width='100'></td>
							<td class="col-md-5 text-center" scope="col"><?php echo '<strong>' . $_SESSION['Empresa']['NomeEmpresa'] . ' <br><br> Cliente: ' . $orcatrata[$i]['NomeCliente'] . ' id: ' . $orcatrata[$i]['idApp_Cliente'] . ' <br><br> Orçamento:' . $orcatrata[$i]['idApp_OrcaTrata'] . '</strong>' ?> </td>
							<!--<td class="col-md-2" scope="col"></td>-->
						</tr>

					</tbody>
				</table>								
				
				
				<?php if( isset($count['PCount']) ) { ?>
				<!--<h3 class="text-left">Produtos</h3>-->

				<table class="table table-bordered table-condensed table-striped">
					<thead>
						<tr>
							<th class="col-md-1" scope="col">Orç</th>
							<th class="col-md-1" scope="col">Qtd</th>
							<th class="col-md-2" scope="col">Produto</th>							
							<th class="col-md-1" scope="col">Valor</th>
							<th class="col-md-1" scope="col">Subtotal</th>
							
							<th class="col-md-1" scope="col">Orç</th>
							<th class="col-md-1" scope="col">Qtd</th>
							<th class="col-md-2" scope="col">Produto</th>							
							<th class="col-md-1" scope="col">Valor</th>
							<th class="col-md-1" scope="col">Subtotal</th>										
						</tr>	
						<tr>
							<th class="col-md-1" scope="col">cont: <?php echo $i ?></th>
							<th class="col-md-1" scope="col">Data</th>	
							<th class="col-md-2" scope="col">Obs</th>
							<th class="col-md-1" scope="col">Ent</th>
							<th class="col-md-1" scope="col">Dev</th>
							
							<th class="col-md-1" scope="col">cont: <?php echo $i ?></th>
							<th class="col-md-1" scope="col">Data</th>	
							<th class="col-md-2" scope="col">Obs</th>
							<th class="col-md-1" scope="col">Ent</th>
							<th class="col-md-1" scope="col">Dev</th>											
							
						</tr>
					</thead>

					<tbody>

						<?php
						for ($k=1; $k <= $count['PCount']; $k++) {
						?>
						<?php if($orcatrata[$i]['idApp_OrcaTrata'] == $produto[$k]['idApp_OrcaTrata']) { ?>
						<tr>
							<td class="col-md-1" scope="col"><?php echo $produto[$k]['idApp_OrcaTrata'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $produto[$k]['QtdProduto'] ?></td>
							<td class="col-md-2" scope="col"><?php echo $produto[$k]['NomeProduto'] ?></td>							
							<td class="col-md-1" scope="col"><?php echo number_format($produto[$k]['ValorProduto'], 2, ',', '.') ?></td>
							<td class="col-md-1" scope="col"><?php echo $produto[$k]['SubtotalProduto'] ?></td>
						
							<td class="col-md-1" scope="col"><?php echo $produto[$k]['idApp_OrcaTrata'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $produto[$k]['QtdProduto'] ?></td>
							<td class="col-md-2" scope="col"><?php echo $produto[$k]['NomeProduto'] ?></td>							
							<td class="col-md-1" scope="col"><?php echo number_format($produto[$k]['ValorProduto'], 2, ',', '.') ?></td>
							<td class="col-md-1" scope="col"><?php echo $produto[$k]['SubtotalProduto'] ?></td>										
						</tr>						
						<tr>
							<td class="col-md-1" scope="col"></td>
							<td class="col-md-1" scope="col"><?php echo $produto[$k]['DataValidadeProduto'] ?></td>
							<td class="col-md-2" scope="col"><?php if ($_SESSION['log']['idSis_Empresa'] != 42 ) echo $produto[$i]['ObsProduto'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $produto[$k]['ConcluidoProduto'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $produto[$k]['DevolvidoProduto'] ?></td>
						
							<td class="col-md-1" scope="col"></td>
							<td class="col-md-1" scope="col"><?php echo $produto[$k]['DataValidadeProduto'] ?></td>
							<td class="col-md-2" scope="col"><?php if ($_SESSION['log']['idSis_Empresa'] != 42 ) echo $produto[$i]['ObsProduto'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $produto[$k]['ConcluidoProduto'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $produto[$k]['DevolvidoProduto'] ?></td>										
						</tr>

						
						<?php
						}
						?>
						
						<?php
						}
						?>

					</tbody>
				</table>
				<?php } else echo '<h3 class="text-left">S/Produtos Entregues </h3>';{?>
				<?php } ?>						

				
				
				<!--<h3 class="text-left">Parcelas</h3>-->
				<table class="table table-bordered table-condensed table-striped">
					<thead>
						<tr>
							<!--<th class="col-md-2" scope="col">j</th>-->
							<th class="col-md-1" scope="col">Orç</th>
							<th class="col-md-1" scope="col">Parcela</th>
							<th class="col-md-2" scope="col">R$</th>											
							<th class="col-md-1" scope="col">Venc Prc</th>
							<th class="col-md-1" scope="col">Prc.Qt?</th>
							
							<th class="col-md-1" scope="col">Orç</th>
							<th class="col-md-1" scope="col">Parcela</th>
							<th class="col-md-2" scope="col">R$</th>											
							<th class="col-md-1" scope="col">Venc Prc</th>
							<th class="col-md-1" scope="col">Prc.Qt?</th>											
						</tr>
					</thead>
					<tbody>
					<?php for ($j=1; $j <= $count['PRCount']; $j++) { ?>
						<?php if($orcatrata[$i]['idApp_OrcaTrata'] == $parcelasrec[$j]['idApp_OrcaTrata']) { ?>
						<tr>
							<!--<td><?php echo $j ?></td>-->
							<td class="col-md-1" scope="col"><?php echo $parcelasrec[$j]['idApp_OrcaTrata'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $parcelasrec[$j]['Parcela'] ?></td>
							<td class="col-md-2" scope="col"><?php echo number_format($parcelasrec[$j]['ValorParcela'], 2, ',', '.') ?></td>											
							<td class="col-md-1" scope="col"><?php echo $parcelasrec[$j]['DataVencimento'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $this->basico->mascara_palavra_completa($parcelasrec[$j]['Quitado'], 'NS') ?></td>									
						
							<td class="col-md-1" scope="col"><?php echo $parcelasrec[$j]['idApp_OrcaTrata'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $parcelasrec[$j]['Parcela'] ?></td>
							<td class="col-md-2" scope="col"><?php echo number_format($parcelasrec[$j]['ValorParcela'], 2, ',', '.') ?></td>											
							<td class="col-md-1" scope="col"><?php echo $parcelasrec[$j]['DataVencimento'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $this->basico->mascara_palavra_completa($parcelasrec[$j]['Quitado'], 'NS') ?></td>										
						</tr>
						<?php } ?>
					<?php } ?>
					</tbody>
				</table>

			

		<?php } ?>
	<?php } else echo '<h3 class="text-center">Nenhum Orçamento Filtrado!</h3>';{?>
	<?php } ?>		

</div>	