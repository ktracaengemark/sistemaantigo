<?php if (isset($msg)) echo $msg; ?>

<div class="col-sm-offset-3 col-md-6 ">	
	
		<?php if ( !isset($evento) && isset($query)) { ?>
			<?php if ($query['idApp_Cliente'] != 1 && $query['idApp_Cliente'] != 0) { ?>
				<nav class="navbar navbar-inverse navbar-fixed" role="banner">
					<div class="container-fluid">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span> 
							</button>
							
							<a class="navbar-brand" href="<?php echo base_url() . 'cliente/prontuario/' . $query['idApp_Cliente']; ?>">
								<?php echo '<small>' . $query['idApp_Cliente'] . '</small> - <small>' . $_SESSION['Cliente']['NomeCliente'] . '.</small>' ?> 
							</a>
						</div>
						<div class="collapse navbar-collapse" id="myNavbar">
							<ul class="nav navbar-nav navbar-center">
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
									<div class="btn-group">
										<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-user"></span> Cliente <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/cliente\/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'cliente/prontuario/' . $query['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-file"></span> Ver Dados do Cliente
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/cliente\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'cliente/alterar/' . $query['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-edit"></span> Editar Dados do Cliente
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
													<a href="<?php echo base_url() . 'cliente/prontuario/' . $query['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-user"></span> Contatos do Cliente
													</a>
												</a>
											</li>
										</ul>
									</div>									
								</li>
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
									<div class="btn-group">
										<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-calendar"></span> Agenda <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/consulta\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
													<a href="<?php echo base_url() . 'consulta/listar/' . $query['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-calendar"></span> Lista de Agendamentos
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/consulta\/cadastrar1\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'consulta/cadastrar1/' . $query['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-plus"></span> Novo Agendamento
													</a>
												</a>
											</li>
										</ul>
									</div>									
								</li>								
								<?php if ($query['idSis_Empresa'] == $_SESSION['log']['idSis_Empresa'] ) { ?>
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
									<div class="btn-group">
										<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-usd"></span> Or�s. <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/orcatrata\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
													<a href="<?php echo base_url() . 'orcatrata/listar/' . $query['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-usd"></span> Lista de Or�amentos
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/orcatrata\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'orcatrata/cadastrar/' . $query['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-plus"></span> Novo Or�amento
													</a>
												</a>
											</li>
										</ul>
									</div>
								</li>
								<?php } ?>
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
									<div class="btn-group">
										<a href="javascript:window.print()">
											<button type="button" class="btn btn-md btn-default ">
												<span class="glyphicon glyphicon-print"></span>
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
	
	
	<?php if ( !isset($evento) && isset($query)) { ?>
	<?php if ($query['idApp_OrcaTrata'] != 1 && $query['idApp_OrcaTrata'] != 0) { ?>
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
										<span class="glyphicon glyphicon-print"></span>
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
					<table class="table table-bordered table-condensed table-striped">
						<tbody>
							<tr>
								<td class="col-md-4 text-center" scope="col"><img alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Empresa']['Arquivo'] . ''; ?>" class="img-responsive" width='200'></td>
								<td class="col-md-8 text-center" scope="col"><h3><?php echo '<strong>' . $query['NomeEmpresa'] . '</strong>' ?></h3>
								<h4>CNPJ:<?php echo '<strong>' . $orcatrata['Cnpj'] . '</strong>' ?></h4>
								<h4>Endere�o:<?php echo '<small>' . $orcatrata['EnderecoEmpresa'] . '</small> <small>' . $orcatrata['NumeroEmpresa'] . '</small> <small>' . $orcatrata['ComplementoEmpresa'] . '</small><br>
														<small>' . $orcatrata['BairroEmpresa'] . '</small> - <small>' . $orcatrata['MunicipioEmpresa'] . '</small> - <small>' . $orcatrata['EstadoEmpresa'] . '</small>' ?></h4>
								<h5>Colab.:<?php echo '<strong>' . $usuario['Nome'] . '</strong>' ?></h5>
																
								
								<h4 class="text-center">Or�amento<?php echo ' - <strong>' . $query['idApp_OrcaTrata'] . '</strong>' ?> </h4>
								
								</td>
							</tr>
						</tbody>
					</table>
						
					<div class="panel-body">

						<!--<hr />-->
						<?php if($orcatrata['idApp_Cliente'] != 0) { ?>								
							<h3 class="text-left"><b>Cliente</b>: <?php echo '' . $cliente['NomeCliente'] . '' ?></h3>
							<h5 class="text-left"><b>Tel</b>: <?php echo '' . $cliente['CelularCliente'] . '' ?> - <b>ID</b>: <?php echo '' . $cliente['idApp_Cliente'] . '' ?> </h5>
						<?php }?>
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
									<th class="col-md-1" scope="col">Qtd</th>												
									<th class="col-md-10" scope="col">Produto</th>
									<th class="col-md-1" scope="col">Subtotal</th>
								</tr>
							</thead>

							<tbody>

								<?php
								for ($i=1; $i <= $count['PCount']; $i++) {
									#echo $produto[$i]['QtdProduto'];
								?>

								<tr>
									<td class="col-md-1" scope="col"><h4><b><?php echo $produto[$i]['SubTotalQtd'] ?></b></h4></td>
									<td class="col-md-10" scope="col"><h4><?php echo $produto[$i]['NomeProduto'] ?></h4></td>
									<td class="col-md-1" scope="col"><?php echo $produto[$i]['SubtotalProduto'] ?></td>
								</tr>
								
								<?php
								}
								?>
								<tr>
									<td class="col-md-1 text-left">Total: <b><?php echo $orcatrata['QtdPrdOrca'] ?></b></td>
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
									<th class="col-md-1" scope="col">Qtd</th>																															
									<th class="col-md-10" scope="col">Servi�o</th>
									<th class="col-md-1" scope="col">Subtotal</th>
								</tr>	
							</thead>
							<tbody>

								<?php
								for ($i=1; $i <= $count['SCount']; $i++) {
									#echo $produto[$i]['QtdProduto'];
								?>

								<tr>
									<td class="col-md-1" scope="col"><h4><b><?php echo $servico[$i]['SubTotalQtd'] ?></b></h4></td>																			
									<td class="col-md-10" scope="col"><h4><?php echo $servico[$i]['NomeProduto'] ?></h4></td>
									<td class="col-md-1" scope="col"><?php echo $servico[$i]['SubtotalProduto'] ?></td>
								</tr>

								<?php
								}
								?>
								<tr>
									<td class="col-md-1 text-left">Total: <b><?php echo $orcatrata['QtdSrvOrca'] ?></b></td>
								</tr>
							</tbody>
						</table>
						<?php } else echo '<h3 class="text-left">S/Servi�os</h3>';{?>
						<?php } ?>							
						<?php } ?>
						<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>						
						<h3 class="text-left"><b>Entrega</b>: <?php echo '<strong>' . $query['idApp_OrcaTrata'] . '</strong>' ?>
						<?php if($orcatrata['idApp_Cliente'] != 0) { ?>
							- <b> Cliente:</b> <?php echo '' . $cliente['NomeCliente'] . '' ?> </h3><h4>Tel: <?php echo '' . $cliente['CelularCliente'] . '' ?> - id: <?php echo '' . $cliente['idApp_Cliente'] . '' ?></h4>
						<?php } ?>
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<th class="col-md-3" scope="col">Onde</th>
									<th class="col-md-3" scope="col">Entregador</th>
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
									<th class="col-md-2" scope="col">N�mero</th>
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
						<?php } ?>
						<h3 class="text-left"><b>Pagamento</b></h3>
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<th class="col-md-3" scope="col">Extra</th>
									<th class="col-md-3" scope="col">Prudutos</th>
									<th class="col-md-3" scope="col">Servicos</th>
									<th class="col-md-3" scope="col">Extra + Prd + Srv</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>R$ <?php echo number_format($orcatrata['ValorExtraOrca'], 2, ',', '.') ?></td>
									<td>R$ <?php echo number_format($orcatrata['ValorOrca'], 2, ',', '.') ?></td>
									<td>R$ <?php echo number_format($orcatrata['ValorDev'], 2, ',', '.') ?></td>
									<td>R$ <?php echo number_format($orcatrata['ValorSomaOrca'], 2, ',', '.') ?></td>
								</tr>
							</tbody>
							<thead>
								<tr>
									<th class="col-md-3" scope="col">Taxa Entrega</th>
									<th class="col-md-3" scope="col">Total</th>
									<th class="col-md-3" scope="col">Troco para</th>
									<th class="col-md-3" scope="col">Troco</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>R$ <?php echo number_format($orcatrata['ValorFrete'], 2, ',', '.') ?></td>
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