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
					<!--
					<a class="navbar-brand" href="<?php echo base_url() . 'orcatrata/cadastrar3/'; ?>">
						<span class="glyphicon glyphicon-plus"></span> Novo
					</a>
					-->
					<a class="navbar-brand" href="<?php echo base_url() . 'statuspedido/alterarstatus/' . $query['idApp_OrcaTrata']; ?>">
						<span class="glyphicon glyphicon-edit"></span> Atualizar Status	"<?php echo $query['Tipo_Orca'];?>"									
					</a>
					<!--
					<a class="navbar-brand" href="<?php echo base_url() . 'orcatrata/alterar2/' . $query['idApp_OrcaTrata']; ?>">
						<span class="glyphicon glyphicon-edit"></span> Editar Pedido "<?php echo $query['Tipo_Orca'];?>"										
					</a>
					
					<a class="navbar-brand" href="<?php echo base_url() . 'cliente/prontuario/' . $cliente['idApp_Cliente']; ?>">
						<?php echo '<small>' . $cliente['idApp_Cliente'] . '</small> - <small>' . $cliente['NomeCliente'] . '.</small>' ?> 
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
									<a href="<?php echo base_url() . 'orcatrata/alterar2/' . $query['idApp_OrcaTrata']; ?>">
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
					<!--
					<div class="panel-heading">	
						<div class="row">
							<div class="panel-heading col-md-3 text-left">
								<img alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Empresa']['Arquivo'] . ''; ?>" class="img-responsive" width='120'>
							</div>
							<div class="col-md-9 text-left">
								<h2><?php echo '<strong>' . $query['NomeEmpresa'] . '</strong>' ?></h2>
								<h4>CNPJ:<?php echo '<strong>' . $orcatrata['Cnpj'] . '</strong>' ?></h4>
								<h4>Endereço:<?php echo '<small>' . $orcatrata['EnderecoEmpresa'] . '</small> <small>' . $orcatrata['NumeroEmpresa'] . '</small> <small>' . $orcatrata['ComplementoEmpresa'] . '</small><br>
														<small>' . $orcatrata['BairroEmpresa'] . '</small> - <small>' . $orcatrata['MunicipioEmpresa'] . '</small> - <small>' . $orcatrata['EstadoEmpresa'] . '</small>' ?></h4>
								<h5>Colab.:<?php echo '<strong>' . $usuario['Nome'] . '</strong>' ?></h5>
								<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>								
								
								<h3 class="text-left">Orçamento<?php echo ' - <strong>' . $query['idApp_OrcaTrata'] . '</strong>' ?> </h3>
								
								<?php } ?>							
															
							</div>						
						</div>
					</div>
					-->
					<table class="table table-bordered table-condensed table-striped">
						<tbody>
							<tr>
								<td class="col-md-4 text-center" scope="col"><img alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Empresa']['Arquivo'] . ''; ?>" class="img-responsive" width='200'></td>
								<td class="col-md-8 text-center" scope="col"><h3><?php echo '<strong>' . $query['NomeEmpresa'] . '</strong>' ?></h3>
								<h4>CNPJ:<?php echo '<strong>' . $orcatrata['Cnpj'] . '</strong>' ?></h4>
								<h4>Endereço:<?php echo '<small>' . $orcatrata['EnderecoEmpresa'] . '</small> <small>' . $orcatrata['NumeroEmpresa'] . '</small> <small>' . $orcatrata['ComplementoEmpresa'] . '</small><br>
														<small>' . $orcatrata['BairroEmpresa'] . '</small> - <small>' . $orcatrata['MunicipioEmpresa'] . '</small> - <small>' . $orcatrata['EstadoEmpresa'] . '</small>' ?></h4>
								<h5>Colab.:<?php echo '<strong>' . $usuario['Nome'] . '</strong>' ?></h5>
								<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>								
								
								<h4 class="text-center">Orçamento<?php echo ' - <strong>' . $query['idApp_OrcaTrata'] . '</strong>' ?> </h4>
								
								<?php } ?></td>
							</tr>
						</tbody>
					</table>
						
					<div class="panel-body">

						<!--<hr />-->
														
						<h3 class="text-left"><b>Cliente</b>: <?php echo '' . $cliente['NomeCliente'] . '' ?></h3>
						<h5 class="text-left"><b>Tel</b>: <?php echo '' . $cliente['CelularCliente'] . '' ?> - <b>ID</b>: <?php echo '' . $cliente['idApp_Cliente'] . '' ?> </h5>
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<th class="col-md-2" scope="col">Tipo</th>
									<th class="col-md-2" scope="col">Data</th>
									<th class="col-md-8" scope="col">Desc.</th>
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
									<!--<th scope="col">Nº</th>-->
									<th class="col-md-1" scope="col">Qtd</th>																				
									<!--<th scope="col">CodProd.</th>
									<th scope="col">CategProd.</th>-->												
									<th class="col-md-10" scope="col">Produto</th>							
									<!--<th class="col-md-1" scope="col">Valor</th>-->
									<th class="col-md-1" scope="col">Subtotal</th>
								</tr>
							</thead>

							<tbody>

								<?php
								for ($i=1; $i <= $count['PCount']; $i++) {
									#echo $produto[$i]['QtdProduto'];
								?>

								<tr>
									<!--<td><?php echo $produto[$i]['idApp_OrcaTrata'] ?></td>
									<td><?php echo $produto[$i]['QtdProduto'] ?> = <b><?php echo $produto[$i]['SubTotalQtd'] ?></b></td>-->
									<!--<td><?php echo $produto[$i]['CodProd'] ?></td>
									<td><?php echo $produto[$i]['Prodaux3'] ?></td>-->
									<td><h4><b><?php echo $produto[$i]['SubTotalQtd'] ?></b></h4></td>
									<td><h4><?php echo $produto[$i]['NomeProduto'] ?></h4></td>							
									<!--<td><?php echo number_format($produto[$i]['ValorProduto'], 2, ',', '.') ?></td>-->
									<td><?php echo $produto[$i]['SubtotalProduto'] ?></td>
								</tr>
								
								<?php
								}
								?>
								<tr>
									<td class="text-left">Total: <b><?php echo $orcatrata['QtdPrdOrca'] ?></b></td>
								</tr>
							</tbody>
						</table>
						<?php } else echo '<h3 class="text-left">S/Produtos</h3>';{?>
						<?php } ?>
						<?php } ?>
						
						<!--<hr />-->
						
						<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
						<?php if( isset($count['SCount']) ) { ?>							
						<h3 class="text-left"><b>Serviços</b></h3>
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<th class="col-md-1" scope="col">Qtd</th>																															
									<th class="col-md-10" scope="col">Serviço</th>							
									<!--<th class="col-md-1" scope="col">Valor</th>-->
									<th class="col-md-1" scope="col">Subtotal</th>
								</tr>	
							</thead>
							<tbody>

								<?php
								for ($i=1; $i <= $count['SCount']; $i++) {
									#echo $produto[$i]['QtdProduto'];
								?>

								<tr>
									<td><h4><b><?php echo $servico[$i]['QtdProduto'] ?></b></h4></td>																			
									<td><h4><?php echo $servico[$i]['NomeProduto'] ?></h4></td>							
									<!--<td><?php echo number_format($servico[$i]['ValorProduto'], 2, ',', '.') ?></td>-->
									<td><?php echo $servico[$i]['SubtotalProduto'] ?></td>
								</tr>

								<?php
								}
								?>

							</tbody>
						</table>
						<?php } else echo '<h3 class="text-left">S/Serviços</h3>';{?>
						<?php } ?>							
						<?php } ?>
												
						<h3 class="text-left"><b>Entrega</b>: <?php echo '<strong>' . $query['idApp_OrcaTrata'] . '</strong>' ?> - <b> Cliente:</b> <?php echo '' . $cliente['NomeCliente'] . '' ?> </h3><h4>Tel: <?php echo '' . $cliente['CelularCliente'] . '' ?> - id: <?php echo '' . $cliente['idApp_Cliente'] . '' ?></h4>
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<th class="col-md-3" scope="col">Tipo</th>
									<th class="col-md-3" scope="col">Entreg.</th>
									<th class="col-md-3" scope="col">Data</th>
									<th class="col-md-3" scope="col">Hora</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $orcatrata['TipoFrete'] ?></td>
									<td><?php echo $orcatrata['Entregador'] ?></td>
									<!--<td><?php echo number_format($orcatrata['ValorFrete'], 2, ',', '.') ?></td>-->
									<td><?php echo $orcatrata['DataEntregaOrca'] ?></td>
									<td><?php echo $orcatrata['HoraEntregaOrca'] ?></td>
								</tr>
							</tbody>
						</table>
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<th class="col-md-2" scope="col">Cep</th>
									<th class="col-md-4" scope="col">End.</th>
									<th class="col-md-2" scope="col">Número</th>
									<th class="col-md-4" scope="col">Compl.</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $orcatrata['Cep'] ?></td>
									<td><?php echo $orcatrata['Logradouro'] ?></td>
									<td><?php echo $orcatrata['Numero'] ?></td>
									<td><?php echo $orcatrata['Complemento'] ?></td>
								</tr>
							</tbody>
							<thead>
								<tr>
									<th class="col-md-2" scope="col">Bairro</th>
									<th class="col-md-4" scope="col">Cidade</th>
									<th class="col-md-2" scope="col">Estado</th>
									<th class="col-md-4" scope="col">Ref.</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $orcatrata['Bairro'] ?></td>
									<td><?php echo $orcatrata['Cidade'] ?></td>
									<td><?php echo $orcatrata['Estado'] ?></td>
									<td><?php echo $orcatrata['Referencia'] ?></td>
								</tr>
							</tbody>
						</table>					
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<th class="col-md-4" scope="col">Nome</th>
									<th class="col-md-4" scope="col">Tel.</th>
									<th class="col-md-4" scope="col">Paren</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $orcatrata['NomeRec'] ?></td>
									<td><?php echo $orcatrata['TelefoneRec'] ?></td>
									<td><?php echo $orcatrata['ParentescoRec'] ?></td>
								</tr>
							</tbody>
							<thead>
								<tr>
									<th class="col-md-4" scope="col">Aux1</th>
									<th class="col-md-4" scope="col">Aux2</th>
									<th class="col-md-4" scope="col">ObsEnt.</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $orcatrata['Aux1Entrega'] ?></td>
									<td><?php echo $orcatrata['Aux2Entrega'] ?></td>
									<td><?php echo $orcatrata['ObsEntrega'] ?></td>
								</tr>
							</tbody>
						</table>
						<h3 class="text-left"><b>Pagamento</b></h3>
						<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<th class="col-md-3" scope="col">Produtos</th>
									<th class="col-md-3" scope="col">Serviços</th>
									<th class="col-md-3" scope="col">Orçam.</th>
									<th class="col-md-3" scope="col">Frete</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>R$ <?php echo number_format($orcatrata['ValorOrca'], 2, ',', '.') ?></td>
									<td>R$ <?php echo number_format($orcatrata['ValorDev'], 2, ',', '.') ?></td>
									<td>R$ <?php echo number_format($orcatrata['ValorRestanteOrca'], 2, ',', '.') ?></td>
									<td>R$ <?php echo number_format($orcatrata['ValorFrete'], 2, ',', '.') ?></td>
								</tr>
							</tbody>
							<thead>
								<tr>
									<th class="col-md-3" scope="col">Total</th>
									<th class="col-md-3" scope="col">Troco para</th>
									<th class="col-md-3" scope="col">Troco</th>
									<th class="col-md-3" scope="col"></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>R$ <?php echo number_format($orcatrata['ValorTotalOrca'], 2, ',', '.') ?></td>
									<td>R$ <?php echo number_format($orcatrata['ValorDinheiro'], 2, ',', '.') ?></td>
									<td>R$ <?php echo number_format($orcatrata['ValorTroco'], 2, ',', '.') ?></td>
									<td></td>
								</tr>
							</tbody>
						</table>
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<!--<th class="col-md-4" scope="col">Tipo</th>-->
									<th class="col-md-4" scope="col">Onde</th>
									<th class="col-md-4" scope="col">Forma</th>
									<th class="col-md-4" scope="col">Venc.</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<!--<td><?php echo $orcatrata['Modalidade'] ?> em <?php echo $orcatrata['QtdParcelasOrca'] ?> X </td>-->
									<td><?php echo $orcatrata['OndePagar'] ?></td>
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