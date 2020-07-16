<?php if (isset($msg)) echo $msg; ?>
			
<div class="col-sm-offset-3 col-md-6 ">		
	<?php if ( !isset($evento) && isset($_SESSION['Orcatrata'])) { ?>
	<?php if ($_SESSION['Orcatrata']['idApp_OrcaTrata'] != 1 ) { ?>
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
					<a class="navbar-brand"href="<?php echo base_url() . 'orcatrata/alterardesp/' . $_SESSION['Orcatrata']['idApp_OrcaTrata']; ?>">
						<span class="glyphicon glyphicon-edit"></span> Editar
					</a>					
					<!--
					<a class="navbar-brand" href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
						<?php echo '<small>' . $_SESSION['Cliente']['idApp_Cliente'] . '</small> - <small>' . $_SESSION['Cliente']['NomeCliente'] . '.</small>' ?> 
					</a>
					-->
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
						<!--
						<li class="btn-toolbar btn-lg navbar-form" role="toolbar" aria-label="...">
							<div class="btn-group " role="group" aria-label="...">
								<a <?php if (preg_match("/orcatrata\/alterardesp\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
									<a href="<?php echo base_url() . 'orcatrata/alterardesp/' . $_SESSION['Orcatrata']['idApp_OrcaTrata']; ?>">
										<button type="button" class="btn btn-md btn-default ">
											<span class="glyphicon glyphicon-edit"></span> Editar
										</button>										
									</a>
								</a>										
							</div>
						</li>								
						<li class="btn-toolbar btn-lg navbar-form" role="toolbar" aria-label="...">
							<div class="btn-group " role="group" aria-label="...">
								<a <?php if (preg_match("/orcatrata\/cadastrardesp\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
									<a href="<?php echo base_url() . 'orcatrata/cadastrardesp/'; ?>">
										<button type="button" class="btn btn-md btn-active ">
											<span class="glyphicon glyphicon-plus"></span> Novo
										</button>										
									</a>
								</a>
							</div>
						</li>
						-->
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
					<!--
					<div class="panel-heading text-left">
						<h2><?php echo '<strong>' . $_SESSION['Orcatrata']['NomeEmpresa'] . '</strong><br><small> - ' . $_SESSION['Usuario']['Nome'] . '</small>' ?></h2>
						<?php if ($_SESSION['log']['NivelEmpresa'] >= 3 ) { ?>								
						<h3><?php echo '' . $_SESSION['Fornecedor']['NomeFornecedor'] . ' - ' . $_SESSION['Fornecedor']['idApp_Fornecedor'] . '' ?></h3>
						<?php } ?>							
													
					</div>
					-->
					<div class="panel-heading">	
						<div class="row">
							<div class="panel-heading col-md-3 text-left">
								<!--<img alt="User Pic" src="<?php echo base_url() . 'arquivos/imagens/empresas/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Empresa']['Arquivo'] . ''; ?>" class="img-responsive" width='120'>-->
								<img alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Empresa']['Arquivo'] . ''; ?>" class="img-responsive" width='120'>
							</div>
							<div class="col-md-9 text-left">
								<h2><?php echo '<strong>' . $_SESSION['Orcatrata']['NomeEmpresa'] . '</strong><br><small>' . $_SESSION['Usuario']['Nome'] . '</small>' ?></h2>
								<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>								
								<h3 class="text-left">Or�amento<?php echo '<strong> - ' . $_SESSION['Orcatrata']['idApp_OrcaTrata'] . '</strong>' ?> </h3>
								
								
								<?php } ?>							
															
							</div>						
						</div>
					</div>					
					<div class="panel-body">

						<!--<hr />-->
						<h3 class="text-left">Fornecedor: <?php echo '' . $_SESSION['Fornecedor']['NomeFornecedor'] . ' - ' . $_SESSION['Fornecedor']['idApp_Fornecedor'] . '' ?></h3>								
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<th class="col-md-3" scope="col">Tipo</th>
									<th class="col-md-6" scope="col">Descri��o</th>
									<th class="col-md-3" scope="col">Dta Or�am</th>
								</tr>
							</thead>
							<tbody>
								<tr>

									<td><?php echo $orcatrata['TipoFinanceiro'] ?></td>
									<td><?php echo $orcatrata['Descricao'] ?></td>
									<td><?php echo $orcatrata['DataOrca'] ?></td>
								</tr>
							</tbody>
						</table>
						<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
						<?php if( isset($count['PCount']) ) { ?>								
						<h3 class="text-left">Produtos </h3>
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
								<tr>
									<th class="col-md-2" scope="col"></th>
									<th class="col-md-6" scope="col">Data / Obs.:</th>	
									<!--<th scope="col">Unidade</th>																				
									<th scope="col">Aux1</th>
									<th scope="col">Aux2</th>-->
									<!--<th scope="col">Tipo </th>
									<th scope="col">Desc </th>-->
									<th class="col-md-1" scope="col"></th>
									<th class="col-md-1" scope="col"></th>
								</tr>
							</thead>

							<tbody>

								<?php
								for ($i=1; $i <= $count['PCount']; $i++) {
									#echo $produto[$i]['QtdProduto'];
								?>

								<tr>
									<!--<td><?php echo $produto[$i]['idApp_OrcaTrata'] ?></td>-->
									<td><?php echo $produto[$i]['QtdProduto'] ?></td>														
									<!--<td><?php echo $produto[$i]['CodProd'] ?></td>
									<td><?php echo $produto[$i]['Prodaux3'] ?></td>-->					
									<td><?php echo $produto[$i]['NomeProduto'] ?></td>							
									<td><?php echo number_format($produto[$i]['ValorProduto'], 2, ',', '.') ?></td>
									<td><?php echo $produto[$i]['SubtotalProduto'] ?></td>
								</tr>						
								<tr>
									<td></td>
									<td>Data: <?php echo $produto[$i]['DataValidadeProduto'] ?> - Obs: <?php echo $produto[$i]['ObsProduto'] ?></td>
									<!--<td><?php echo $produto[$i]['UnidadeProduto'] ?></td>														
									<td><?php echo $produto[$i]['Prodaux1'] ?></td>
									<td><?php echo $produto[$i]['Prodaux2'] ?></td>-->
									<!--<td><?php echo $produto[$i]['Convenio'] ?></td>
									<td><?php echo $produto[$i]['Convdesc'] ?></td>-->
									<td>Ent: <?php echo $produto[$i]['ConcluidoProduto'] ?></td>
									<td>Dev: <?php echo $produto[$i]['DevolvidoProduto'] ?></td>							
								</tr>

								<?php
								}
								?>

							</tbody>
						</table>
						<?php } else echo '<h3 class="text-left">S/Produtos</h3>';{?>
						<?php } ?>								
						<?php } ?>								
						
						<!--<hr />-->
						
						<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
						<?php if( isset($count['SCount']) ) { ?>								
						<h3 class="text-left">Servi�os  </h3>
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<th class="col-md-1" scope="col">Qtd</th>																															
									<th class="col-md-9" scope="col">Servi�o</th>							
									<th class="col-md-1" scope="col">Valor</th>
									<th class="col-md-1" scope="col">Subtotal</th>
								</tr>	
								<tr>
									<th class="col-md-1" scope="col"></th>
									<th class="col-md-9" scope="col">id-Ent-Obs.:</th>	
									<th class="col-md-1" scope="col">Data</th>							
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
								<tr>
									<td></td>
									<td><?php echo $servico[$i]['idApp_Servico'] ?></td>
									<td><?php echo $servico[$i]['DataValidadeServico'] ?></td>							
								</tr>

								<?php
								}
								?>

							</tbody>
						</table>
						<?php } else echo '<h3 class="text-left">S/Servi�os </h3>';{?>
						<?php } ?>								
						<?php } ?>
						
						<h3 class="text-left">Entrega</h3>
						<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<th class="col-md-2" scope="col">Or�am. R$</th>
									<th class="col-md-2" scope="col">Desc. R$</th>
									<th class="col-md-4" scope="col">Total R$</th>
									<th class="col-md-2" scope="col">Dinheiro R$</th>
									<th class="col-md-2" scope="col">Troco R$</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo number_format($orcatrata['ValorOrca'], 2, ',', '.') ?></td>
									<td><?php echo number_format($orcatrata['ValorDev'], 2, ',', '.') ?></td>
									<td><?php echo number_format($orcatrata['ValorRestanteOrca'], 2, ',', '.') ?></td>
									<td><?php echo number_format($orcatrata['ValorDinheiro'], 2, ',', '.') ?></td>
									<td><?php echo number_format($orcatrata['ValorTroco'], 2, ',', '.') ?></td>
								</tr>
							</tbody>
						</table>
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<th class="col-md-4" scope="col">Forma</th>
									<th class="col-md-4" scope="col">Pago</th>
									<th class="col-md-4" scope="col">Venc.</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $orcatrata['Modalidade'] ?></td>
									<td><?php echo $orcatrata['QtdParcelasOrca'] ?>X<?php echo $orcatrata['FormaPag'] ?></td>
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
									<td><?php echo number_format($orcatrata['ValorRestanteOrca'], 2, ',', '.') ?></td>
									<td><?php echo $orcatrata['Modalidade'] ?></td>
									<td><?php echo $orcatrata['QtdParcelasOrca'] ?>X<?php echo $orcatrata['FormaPag'] ?></td>
									<td><?php echo $orcatrata['DataVencimentoOrca'] ?></td>
								</tr>
							</tbody>
						</table>						
						<?php } ?>						
						
						<h3 class="text-left">Pagamento</h3>
						<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<th class="col-md-2" scope="col">Or�am. R$</th>
									<th class="col-md-2" scope="col">Desc. R$</th>
									<th class="col-md-4" scope="col">Total R$</th>
									<th class="col-md-2" scope="col">Dinheiro R$</th>
									<th class="col-md-2" scope="col">Troco R$</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo number_format($orcatrata['ValorOrca'], 2, ',', '.') ?></td>
									<td><?php echo number_format($orcatrata['ValorDev'], 2, ',', '.') ?></td>
									<td><?php echo number_format($orcatrata['ValorRestanteOrca'], 2, ',', '.') ?></td>
									<td><?php echo number_format($orcatrata['ValorDinheiro'], 2, ',', '.') ?></td>
									<td><?php echo number_format($orcatrata['ValorTroco'], 2, ',', '.') ?></td>
								</tr>
							</tbody>
						</table>
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<th class="col-md-4" scope="col">Forma</th>
									<th class="col-md-4" scope="col">Pago</th>
									<th class="col-md-4" scope="col">Venc.</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $orcatrata['Modalidade'] ?></td>
									<td><?php echo $orcatrata['QtdParcelasOrca'] ?>X<?php echo $orcatrata['FormaPag'] ?></td>
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
									<td><?php echo number_format($orcatrata['ValorRestanteOrca'], 2, ',', '.') ?></td>
									<td><?php echo $orcatrata['Modalidade'] ?></td>
									<td><?php echo $orcatrata['QtdParcelasOrca'] ?>X<?php echo $orcatrata['FormaPag'] ?></td>
									<td><?php echo $orcatrata['DataVencimentoOrca'] ?></td>
								</tr>
							</tbody>
						</table>						
						<?php } ?>
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
						<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
						<h3 class="text-left">Status</h3>
						
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<th class="col-md-4" scope="col">Or�.Aprovado?</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $this->basico->mascara_palavra_completa($orcatrata['AprovadoOrca'], 'NS') ?></td>
								</tr>
							</tbody>
						</table>
						<?php } ?>
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
<?php if ( !isset($evento) && isset($_SESSION['Orcatrata'])) { ?>
	<?php if ($_SESSION['Orcatrata']['idApp_OrcaTrata'] != 1 ) { ?>		
	<div class="modal fade bs-excluir-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header bg-danger">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Tem certeza que deseja excluir?</h4>
				</div>
				<div class="modal-body">
					<p>Ao confirmar esta opera��o todos os dados ser�o exclu�dos permanentemente do sistema.
						Esta opera��o � irrevers�vel.</p>
				</div>
				<div class="modal-footer">
					<div class="col-md-6 text-left">
						<button type="button" class="btn btn-warning" data-dismiss="modal">
							<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
						</button>
					</div>
					<div class="col-md-6 text-right">
						<a class="btn btn-danger" href="<?php echo base_url() . 'orcatrata/excluirdesp/' . $_SESSION['Orcatrata']['idApp_OrcaTrata'] ?>" role="button">
							<span class="glyphicon glyphicon-trash"></span>Confirmar Exclus�o do Or�:
							<?php echo $_SESSION['Orcatrata']['idApp_OrcaTrata']; ?>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
<?php } ?>		