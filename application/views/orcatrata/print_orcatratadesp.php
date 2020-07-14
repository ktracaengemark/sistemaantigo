<?php if (isset($msg)) echo $msg; ?>

<div class="col-sm-offset-3 col-md-6 ">		
	<?php if ( !isset($evento) && isset($query)) { ?>
		<?php if ($query['idApp_OrcaTrata'] != 1 ) { ?>
			<nav class="navbar navbar-inverse navbar-fixed" role="banner">
			  <div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span> 
					</button>
					<a class="navbar-brand" href="<?php echo base_url() . 'orcatrata/cadastrardesp/'; ?>">
						<span class="glyphicon glyphicon-plus"></span> Novo
					</a>
					<a class="navbar-brand" href="<?php echo base_url() . 'orcatrata/alterardesp/' . $query['idApp_OrcaTrata']; ?>">
						<span class="glyphicon glyphicon-edit"></span> Editar Pedido										
					</a>
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
		<?php } ?>
	<?php } ?>			
	
	<?php echo validation_errors(); ?>
		
	<div style="overflow: auto; height: auto; ">		
		<div class="row">	
			<div class="panel panel-danger">
				<div class="panel-heading">
					<div class="panel-heading">	
						<div class="row">
							<div class="panel-heading col-md-3 text-left">
								<!--<img alt="User Pic" src="<?php echo base_url() . 'arquivos/imagens/empresas/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Empresa']['Arquivo'] . ''; ?>" class="img-responsive" width='120'>-->
								<img alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Empresa']['Arquivo'] . ''; ?>" class="img-responsive" width='120'>
							</div>
							<div class="col-md-9 text-left">
								<h2><?php echo '<strong>' . $query['NomeEmpresa'] . '</strong>' ?></h2>
								<h4>CNPJ:<?php echo '<strong>' . $orcatrata['Cnpj'] . '</strong>' ?></h4>
								<h4>Endere�o:<?php echo '<small>' . $orcatrata['EnderecoEmpresa'] . '</small> <small>' . $orcatrata['NumeroEmpresa'] . '</small> <small>' . $orcatrata['ComplementoEmpresa'] . '</small><br>
														<small>' . $orcatrata['BairroEmpresa'] . '</small> - <small>' . $orcatrata['MunicipioEmpresa'] . '</small> - <small>' . $orcatrata['EstadoEmpresa'] . '</small>' ?></h4>
								<h5>Colab.:<?php echo '<strong>' . $usuario['Nome'] . '</strong>' ?></h5>
								<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>								
								
								<h3 class="text-left">Or�amento<?php echo ' - <strong>' . $query['idApp_OrcaTrata'] . '</strong>' ?> </h3>
								
								<?php } ?>							
															
							</div>						
						</div>
					</div>	
					<div class="panel-body">

						<!--<hr />-->
														
						<h3 class="text-left"><b>Fornecedor</b>: <?php echo '' . $fornecedor['NomeFornecedor'] . '' ?></h3>
						<h5 class="text-left"><b>Tel</b>: <?php echo '' . $fornecedor['Telefone1'] . '' ?> - <b>ID</b>: <?php echo '' . $fornecedor['idApp_Fornecedor'] . '' ?> </h5>
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<th class="col-md-2" scope="col">Tipo</th>
									<th class="col-md-2" scope="col">Data</th>
									<th class="col-md-3" scope="col">Obs.</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $orcatrata['TipoFinanceiro'] ?></td>
									<td><?php echo $orcatrata['DataOrca'] ?></td>
									<td><?php echo $orcatrata['Descricao'] ?></td>
								</tr>
							</tbody>
						</table>
						<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
						<?php if( isset($count['PCount']) ) { ?>
						<h3 class="text-left"><b>Produtos</b></h3>

						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<!--<th scope="col">N�</th>-->
									<th class="col-md-2" scope="col">Qtd</th>																				
									<!--<th scope="col">CodProd.</th>
									<th scope="col">CategProd.</th>-->												
									<th class="col-md-6" scope="col">Produto</th>							
									<th class="col-md-1" scope="col">Valor</th>
									<th class="col-md-1" scope="col">Subtotal</th>
								</tr>
							</thead>

							<tbody>

								<?php
								for ($i=1; $i <= $count['PCount']; $i++) {
									#echo $produto[$i]['QtdProduto'];
								?>

								<tr>
									<!--<td><?php echo $produto[$i]['idApp_OrcaTrata'] ?></td>-->
									<td><?php echo $produto[$i]['QtdProduto'] ?> = <b><?php echo $produto[$i]['SubTotalQtd'] ?></b></td>														
									<!--<td><?php echo $produto[$i]['CodProd'] ?></td>
									<td><?php echo $produto[$i]['Prodaux3'] ?></td>-->					
									<td><?php echo $produto[$i]['NomeProduto'] ?></td>							
									<td><?php echo number_format($produto[$i]['ValorProduto'], 2, ',', '.') ?></td>
									<td><?php echo $produto[$i]['SubtotalProduto'] ?></td>
								</tr>
								<?php
								}
								?>
								<tr>
									<td class="text-right">Total: <b><?php echo $orcatrata['QtdPrdOrca'] ?></b></td>
								</tr>

							</tbody>
						</table>
						<?php } else echo '<h3 class="text-left">S/Produtos</h3>';{?>
						<?php } ?>
						<?php } ?>
						
						<!--<hr />-->
						
						<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
						<?php if( isset($count['SCount']) ) { ?>							
						<h3 class="text-left"><b>Servi�os</b></h3>
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<th class="col-md-2" scope="col">Qtd</th>																															
									<th class="col-md-7" scope="col">Servi�o</th>							
									<th class="col-md-1" scope="col">Valor</th>
									<th class="col-md-1" scope="col">Subtotal</th>
								</tr>	
							</thead>
							<tbody>

								<?php
								for ($i=1; $i <= $count['SCount']; $i++) {
									#echo $produto[$i]['QtdProduto'];
								?>

								<tr>
									<td><?php echo $servico[$i]['QtdServico'] ?></td>																			
									<td><?php echo $servico[$i]['NomeServico'] ?></td>							
									<td><?php echo number_format($servico[$i]['ValorServico'], 2, ',', '.') ?></td>
									<td><?php echo $servico[$i]['SubtotalServico'] ?></td>
								</tr>

								<?php
								}
								?>

							</tbody>
						</table>
						<?php } else echo '<h3 class="text-left">S/Servi�os </h3>';{?>
						<?php } ?>							
						<?php } ?>					
						
						<h3 class="text-left"><b>Pagamento</b></h3>
						<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<th class="col-md-2" scope="col">Produtos</th>
									<th class="col-md-2" scope="col">Servi�os</th>
									<th class="col-md-2" scope="col">Taxa Ent.</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>R$ <?php echo number_format($orcatrata['ValorOrca'], 2, ',', '.') ?></td>
									<td>R$ <?php echo number_format($orcatrata['ValorDev'], 2, ',', '.') ?></td>
									<td>R$ <?php echo number_format($orcatrata['ValorFrete'], 2, ',', '.') ?></td>
								</tr>
							</tbody>
							<thead>
								<tr>
									<th class="col-md-2" scope="col">Total</th>
									<th class="col-md-2" scope="col">Troco para</th>
									<th class="col-md-2" scope="col">Troco</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>R$ <?php echo number_format($orcatrata['ValorTotalOrca'], 2, ',', '.') ?></td>
									<td>R$ <?php echo number_format($orcatrata['ValorDinheiro'], 2, ',', '.') ?></td>
									<td>R$ <?php echo number_format($orcatrata['ValorTroco'], 2, ',', '.') ?></td>
								</tr>
							</tbody>
						</table>
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<!--<th class="col-md-4" scope="col">Tipo</th>-->
									<th class="col-md-8" scope="col">Forma de Pagamento</th>
									<th class="col-md-4" scope="col">Venc.</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<!--<td><?php echo $orcatrata['Modalidade'] ?> em <?php echo $orcatrata['QtdParcelasOrca'] ?> X </td>-->
									<td><?php echo $orcatrata['FormaPag'] ?></td>
									<td><?php echo $orcatrata['DataVencimentoOrca'] ?></td>
								</tr>
							</tbody>
						</table>
						<?php } else {?>
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<th class="col-md-3" scope="col">Total R$</th>
									<th class="col-md-3" scope="col">Forma</th>
									<th class="col-md-3" scope="col">Pago</th>
									<th class="col-md-3" scope="col">Venc.</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo number_format($orcatrata['ValorTotalOrca'], 2, ',', '.') ?></td>
									<td><?php echo $orcatrata['Modalidade'] ?></td>
									<td><?php echo $orcatrata['QtdParcelasOrca'] ?>X<?php echo $orcatrata['FormaPag'] ?></td>
									<td><?php echo $orcatrata['DataVencimentoOrca'] ?></td>
								</tr>
							</tbody>
						</table>						
						<?php } ?>
						<!--
						<?php if( isset($count['PRCount']) ) { ?>
						<h3 class="text-left">Parcelas</h3>
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<th class="col-md-3" scope="col">Parcela</th>
									<th class="col-md-3" scope="col">R$</th>											
									<th class="col-md-3" scope="col">Venc Prc</th>
									<th class="col-md-3" scope="col">Prc.Qt?</th>
								</tr>
							</thead>

							<tbody>

								<?php
								for ($i=1; $i <= $count['PRCount']; $i++) {
									#echo $produto[$i]['QtdProduto'];
								?>

								<tr>
									<td><?php echo $parcelasrec[$i]['Parcela'] ?></td>
									<td><?php echo number_format($parcelasrec[$i]['ValorParcela'], 2, ',', '.') ?></td>											
									<td><?php echo $parcelasrec[$i]['DataVencimento'] ?></td>
									<td><?php echo $this->basico->mascara_palavra_completa($parcelasrec[$i]['Quitado'], 'NS') ?></td>									
								</tr>

								<?php
								}
								?>

							</tbody>
						</table>
						<?php } else echo '<h3 class="text-left">S/Parcelas </h3>';{?>
						<?php } ?>
						-->
						<!--
						<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
						<h3 class="text-left"><b>Status do Pedido</b></h3>
						
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<th class="col-md-2" scope="col">Aprovado?</th>
									<th class="col-md-2" scope="col">Finalizado?</th>
									<th class="col-md-2" scope="col">Pronto?</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $this->basico->mascara_palavra_completa($orcatrata['AprovadoOrca'], 'NS') ?></td>
									<td><?php echo $this->basico->mascara_palavra_completa($orcatrata['FinalizadoOrca'], 'NS') ?></td>
									<td><?php echo $this->basico->mascara_palavra_completa($orcatrata['ProntoOrca'], 'NS') ?></td>
								</tr>
							</tbody>
							<thead>
								<tr>
									<th class="col-md-2" scope="col">Enviado?</th>
									<th class="col-md-2" scope="col">Entregue?</th>
									<th class="col-md-2" scope="col">Pago?</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $this->basico->mascara_palavra_completa($orcatrata['EnviadoOrca'], 'NS') ?></td>
									<td><?php echo $this->basico->mascara_palavra_completa($orcatrata['ConcluidoOrca'], 'NS') ?></td>
									<td><?php echo $this->basico->mascara_palavra_completa($orcatrata['QuitadoOrca'], 'NS') ?></td>
								</tr>
							</tbody>
						</table>
						<?php } ?>
						-->
						<!--
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>

									<th class="col-md-4" scope="col">Data da Entrega</th>
									<th class="col-md-4" scope="col">Data do Quita��o</th>
									
								</tr>
							</thead>
							<tbody>
								<tr>

									<td><?php echo $orcatrata['DataConclusao'] ?></td>
									<td><?php echo $orcatrata['DataQuitado'] ?></td>
									
								</tr>
							</tbody>
						</table>
						
						
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<th class="col-md-8" scope="col">Observa��es</th>
									<th class="col-md-4" scope="col">Data do Retorno</th>
								</tr>
							</thead>
							<tbody>
								<tr>

									<td><?php echo $orcatrata['ObsOrca'] ?></td>
									<td><?php echo $orcatrata['DataRetorno'] ?></td>
								</tr>
							</tbody>
						</table>
						-->
					</div>
				</div>
			</div>
		</div>
	</div>	
</div>