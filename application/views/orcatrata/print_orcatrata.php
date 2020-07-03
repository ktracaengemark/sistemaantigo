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
					<a class="navbar-brand" href="<?php echo base_url() . 'orcatrata/cadastrar3/'; ?>">
						<span class="glyphicon glyphicon-plus"></span> Novo
					</a>
					<?php if ($_SESSION['Orcatrata']['Tipo_Orca'] == "B" ) { ?>
						<a class="navbar-brand" href="<?php echo base_url() . 'orcatrata/alterarstatus/' . $_SESSION['Orcatrata']['idApp_OrcaTrata']; ?>">
							<span class="glyphicon glyphicon-edit"></span> Alterar Status										
						</a>
						<a class="navbar-brand" href="<?php echo base_url() . 'orcatrata/alterar2/' . $_SESSION['Orcatrata']['idApp_OrcaTrata']; ?>">
							<span class="glyphicon glyphicon-edit"></span> Editar Pedido										
						</a>
					<?php } else if ($_SESSION['Orcatrata']['Tipo_Orca'] == "O" ) { ?>
						<a class="navbar-brand" href="<?php echo base_url() . 'orcatrata/alteraronline/' . $_SESSION['Orcatrata']['idApp_OrcaTrata']; ?>">
							<span class="glyphicon glyphicon-edit"></span> Editar "O"										
						</a>					
					<?php } ?>
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
								<a <?php if (preg_match("/orcatrata\/alterar2\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
									<a href="<?php echo base_url() . 'orcatrata/alterar2/' . $_SESSION['Orcatrata']['idApp_OrcaTrata']; ?>">
										<button type="button" class="btn btn-md btn-default">
											<span class="glyphicon glyphicon-edit"></span> Editar
										</button>										
									</a>
								</a>										
							</div>
						</li>								
						<li class="btn-toolbar btn-lg navbar-form" role="toolbar" aria-label="...">
							<div class="btn-group " role="group" aria-label="...">
								<a <?php if (preg_match("/orcatrata\/cadastrar3\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
									<a href="<?php echo base_url() . 'orcatrata/cadastrar3/'; ?>">
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
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="panel-heading">	
						<div class="row">
							<div class="panel-heading col-md-3 text-left">
								<!--<img alt="User Pic" src="<?php echo base_url() . 'arquivos/imagens/empresas/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Empresa']['Arquivo'] . ''; ?>" class="img-responsive" width='120'>-->
								<img alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Empresa']['Arquivo'] . ''; ?>" class="img-responsive" width='120'>
							</div>
							<div class="col-md-9 text-left">
								<h2><?php echo '<strong>' . $_SESSION['Orcatrata']['NomeEmpresa'] . '</strong><br><small>' . $_SESSION['Usuario']['Nome'] . '</small>' ?></h2>
								<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>								
								
								<h3 class="text-left">Orçamento<?php echo ' - <strong>' . $_SESSION['Orcatrata']['idApp_OrcaTrata'] . '</strong>' ?> </h3>
								
								<?php } ?>							
															
							</div>						
						</div>
					</div>	
					<div class="panel-body">

						<!--<hr />-->
														
						<h3 class="text-left"><b>Cliente</b>: <?php echo '' . $_SESSION['Cliente']['NomeCliente'] . ' - ' . $_SESSION['Cliente']['idApp_Cliente'] . '' ?></h3>
						
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<th class="col-md-2" scope="col">Tipo</th>
									<th class="col-md-2" scope="col">Data Orç.</th>
									<th class="col-md-3" scope="col">Descrição</th>
									<th class="col-md-5" scope="col">Observções</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $orcatrata['TipoFinanceiro'] ?></td>
									<td><?php echo $orcatrata['DataOrca'] ?></td>
									<td><?php echo $orcatrata['Descricao'] ?></td>
									<td><?php echo $orcatrata['ObsOrca'] ?></td>
								</tr>
							</tbody>
						</table>
						<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
						<?php if( isset($count['PCount']) ) { ?>
						<h3 class="text-left"><b>Produtos</b></h3>

						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<!--<th scope="col">Nº</th>-->
									<th class="col-md-2" scope="col">Qtd</th>																				
									<!--<th scope="col">CodProd.</th>
									<th scope="col">CategProd.</th>-->												
									<th class="col-md-6" scope="col">DescProd.</th>							
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
									<td>Data: <?php echo $produto[$i]['DataValidadeProduto'] ?> - Obs: <?php if ($_SESSION['log']['idSis_Empresa'] != 42 ) echo $produto[$i]['ObsProduto'] ?></td>
									<!--<td><?php echo $produto[$i]['ConcluidoProduto'] ?></td>														
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
						<?php } else echo '<h3 class="text-left">S/Produtos Entregues </h3>';{?>
						<?php } ?>
						<?php } ?>
						
						<!--<hr />-->
						
						<?php if ($_SESSION['log']['NivelEmpresa'] >= 20 ) { ?>
						<?php if( isset($count['SCount']) ) { ?>							
						<h3 class="text-left">Produtos Devolvidos  </h3>
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<th class="col-md-2" scope="col">Qtd</th>																															
									<th class="col-md-7" scope="col">DescProd.</th>							
									<th class="col-md-1" scope="col">Valor</th>
									<th class="col-md-1" scope="col">Subtotal</th>
								</tr>	
								<tr>
									<th class="col-md-2" scope="col"></th>
									<th class="col-md-7" scope="col">id-Ent-Obs.:</th>	
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
						<?php } else echo '<h3 class="text-left">S/Produtos Devolvidos </h3>';{?>
						<?php } ?>							
						<?php } ?>
						
						
						<h3 class="text-left"><b>Entrega</b></h3>
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<th class="col-md-3" scope="col">Tipo</th>
									<th class="col-md-3" scope="col">Entregador</th>
									<th class="col-md-3" scope="col">Frete R$</th>
									<th class="col-md-3" scope="col">Prazo</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $orcatrata['TipoFrete'] ?></td>
									<td><?php echo $orcatrata['Entregador'] ?></td>
									<td><?php echo number_format($orcatrata['ValorFrete'], 2, ',', '.') ?></td>
									<td><?php echo $orcatrata['PrazoEntrega'] ?></td>
								</tr>
							</tbody>
						</table>
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<th class="col-md-1" scope="col">Cep</th>
									<th class="col-md-3" scope="col">Endereço</th>
									<th class="col-md-1" scope="col">Número</th>
									<th class="col-md-1" scope="col">Compl.</th>
									<th class="col-md-1" scope="col">Bairro</th>
									<th class="col-md-1" scope="col">Cidade</th>
									<th class="col-md-1" scope="col">Estado</th>
									<th class="col-md-3" scope="col">Ref.</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $orcatrata['Cep'] ?></td>
									<td><?php echo $orcatrata['Logradouro'] ?></td>
									<td><?php echo $orcatrata['Numero'] ?></td>
									<td><?php echo $orcatrata['Complemento'] ?></td>
									<td><?php echo $orcatrata['Bairro'] ?></td>
									<td><?php echo $orcatrata['Cidade'] ?></td>
									<td><?php echo $orcatrata['Estado'] ?></td>
									<td><?php echo $orcatrata['Referencia'] ?></td>
								</tr>
							</tbody>
						</table>					
						
						<h3 class="text-left"><b>Pagamento</b></h3>
						<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<th class="col-md-2" scope="col">Orçam. R$</th>
									<th class="col-md-2" scope="col">Desc. R$</th>
									<th class="col-md-2" scope="col">Frete R$</th>
									<th class="col-md-2" scope="col">Total R$</th>
									<th class="col-md-2" scope="col">Dinheiro R$</th>
									<th class="col-md-2" scope="col">Troco R$</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo number_format($orcatrata['ValorOrca'], 2, ',', '.') ?></td>
									<td><?php echo number_format($orcatrata['ValorDev'], 2, ',', '.') ?></td>
									<td><?php echo number_format($orcatrata['ValorFrete'], 2, ',', '.') ?></td>
									<td><?php echo number_format($orcatrata['ValorTotalOrca'], 2, ',', '.') ?></td>
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
									<td><?php echo number_format($orcatrata['ValorTotalOrca'], 2, ',', '.') ?></td>
									<td><?php echo $orcatrata['Modalidade'] ?></td>
									<td><?php echo $orcatrata['QtdParcelasOrca'] ?>X<?php echo $orcatrata['FormaPag'] ?></td>
									<td><?php echo $orcatrata['DataVencimentoOrca'] ?></td>
								</tr>
							</tbody>
						</table>						
						<?php } ?>
						
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
						<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
						<h3 class="text-left"><b>Status do Pedido</b></h3>
						
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									
									<th class="col-md-2" scope="col">Aprovado?</th>
									<th class="col-md-2" scope="col">Finalizado?</th>
									<th class="col-md-2" scope="col">Pronto?</th>
									<th class="col-md-2" scope="col">Enviado?</th>
									<th class="col-md-2" scope="col">Entregue?</th>
									<th class="col-md-2" scope="col">Pago?</th>

								</tr>
							</thead>
							<tbody>
								<tr>
									
									<td><?php echo $this->basico->mascara_palavra_completa($orcatrata['AprovadoOrca'], 'NS') ?></td>
									<td><?php echo $this->basico->mascara_palavra_completa($orcatrata['FinalizadoOrca'], 'NS') ?></td>
									<td><?php echo $this->basico->mascara_palavra_completa($orcatrata['ProntoOrca'], 'NS') ?></td>
									<td><?php echo $this->basico->mascara_palavra_completa($orcatrata['EnviadoOrca'], 'NS') ?></td>
									<td><?php echo $this->basico->mascara_palavra_completa($orcatrata['ConcluidoOrca'], 'NS') ?></td>
									<td><?php echo $this->basico->mascara_palavra_completa($orcatrata['QuitadoOrca'], 'NS') ?></td>
								</tr>
							</tbody>
						</table>
						<?php } ?>
						<!--
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>

									<th class="col-md-4" scope="col">Data da Entrega</th>
									<th class="col-md-4" scope="col">Data do Quitação</th>
									
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
									<th class="col-md-8" scope="col">Observações</th>
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
					<p>Ao confirmar esta operação todos os dados serão excluídos permanentemente do sistema.
						Esta operação é irreversível.</p>
				</div>
				<div class="modal-footer">
					<div class="col-md-6 text-left">
						<button type="button" class="btn btn-warning" data-dismiss="modal">
							<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
						</button>
					</div>
					<div class="col-md-6 text-right">
						<a class="btn btn-danger" href="<?php echo base_url() . 'orcatrata/excluir2/' . $_SESSION['Orcatrata']['idApp_OrcaTrata'] ?>" role="button">
							<span class="glyphicon glyphicon-trash"></span>Confirmar Exclusão do Orç:
							<?php echo $_SESSION['Orcatrata']['idApp_OrcaTrata']; ?>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
<?php } ?>