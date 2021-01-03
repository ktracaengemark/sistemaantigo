<?php if (isset($msg)) echo $msg; ?>

<div class="col-sm-offset-2 col-md-8 ">
			
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
											<a <?php if (preg_match("/consulta\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
												<a href="<?php echo base_url() . 'consulta/cadastrar/' . $query['idApp_Cliente']; ?>">
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
										<span class="glyphicon glyphicon-usd"></span> Orçs. <span class="caret"></span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li>
											<a <?php if (preg_match("/orcatrata\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
												<a href="<?php echo base_url() . 'orcatrata/listar/' . $query['idApp_Cliente']; ?>">
													<span class="glyphicon glyphicon-usd"></span> Lista de Orçamentos
												</a>
											</a>
										</li>
										<li role="separator" class="divider"></li>
										<li>
											<a <?php if (preg_match("/orcatrata\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
												<a href="<?php echo base_url() . 'orcatrata/cadastrar/' . $query['idApp_Cliente']; ?>">
													<span class="glyphicon glyphicon-plus"></span> Novo Orçamento
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
											<span class="glyphicon glyphicon-print"></span> Imprimir
										</button>
									</a>
								</div>									
							</li>
						</ul>
					</div>
				</div>
			</nav>
		<?php } else if ($query['idApp_OrcaTrata'] != 1 && $query['idApp_OrcaTrata'] != 0) { ?>
			<nav class="navbar navbar-inverse navbar-fixed" role="banner">
			  <div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span> 
					</button>
					<a class="navbar-brand" href="<?php echo base_url() . 'statuspedido/alterarstatus/' . $query['idApp_OrcaTrata']; ?>">
						<span class="glyphicon glyphicon-edit"></span> Atualizar Status	"<?php echo $query['Tipo_Orca'];?>"									
					</a>
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
					</ul>
				</div>
			  </div>
			</nav>
		<?php } ?>
	<?php } ?>
		
	<?php echo validation_errors(); ?>
		
	<div style="overflow: auto; height: auto; ">
	
		<table class="table table-bordered table-condensed table-striped">
			<thead>
				<tr>
					<td class="col-md-1" scope="col"><img  alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Empresa']['Arquivo'] . ''; ?>"class="img-circle img-responsive" width='100'>
																				
																				</td>
					<td class="col-md-3 text-left" scope="col"><?php echo '<strong>' . $_SESSION['Empresa']['NomeEmpresa'] . '</strong>'
																		. '<br><br><strong>' . $orcatrata['NomeCliente'] . '</strong> - ' . $orcatrata['idApp_Cliente'] . ''
																		. '<br>' . $orcatrata['EnderecoCliente'] . ' - ' . $orcatrata['NumeroCliente'] . ''
																		. '<br>' . $orcatrata['ComplementoCliente'] . ' - ' . $orcatrata['BairroCliente'] . ' - ' . $orcatrata['CidadeCliente'] . ' - ' . $orcatrata['EstadoCliente'] . '<br>' . $orcatrata['ReferenciaCliente'] . ''
																		. '<br>Tel.:' . $orcatrata['CelularCliente'] . ' / ' . $orcatrata['Telefone'] . ' / ' . $orcatrata['Telefone2'] . ' / ' . $orcatrata['Telefone3'] . ''
																?></td>
					<td class="col-md-1 text-center" scope="col"><?php echo 'Data:<br><strong>'  . $orcatrata['DataOrca'] . '</strong>'
																		. '<br><br>Recebedor:<br><strong>'  . $orcatrata['NomeRec'] . '</strong>'
																	?></td>
					<td class="col-md-1 text-center" scope="col"><?php echo 'Orçamento:<br><strong>' . $orcatrata['idApp_OrcaTrata'] . '</strong>'
																		. '<br><br>Valor Total:'
																		. '<br>R$: <strong>'  . $orcatrata['ValorTotalOrca'] . '</strong>'
																		. '<br><br>Via da Empresa'
																	?></td>
				</tr>
			</thead>
			<thead>
				<tr>
					<td class="col-md-1" scope="col"><img  alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Empresa']['Arquivo'] . ''; ?>"class="img-circle img-responsive" width='100'>
																				
																				</td>
					<td class="col-md-3 text-left" scope="col"><?php echo '<strong>' . $_SESSION['Empresa']['NomeEmpresa'] . '</strong>'
																		. '<br><br><strong>' . $orcatrata['NomeCliente'] . '</strong> - ' . $orcatrata['idApp_Cliente'] . ''
																		. '<br>' . $orcatrata['EnderecoCliente'] . ' - ' . $orcatrata['NumeroCliente'] . ''
																		. '<br>' . $orcatrata['ComplementoCliente'] . ' - ' . $orcatrata['BairroCliente'] . ' - ' . $orcatrata['CidadeCliente'] . ' - ' . $orcatrata['EstadoCliente'] . '<br>' . $orcatrata['ReferenciaCliente'] . ''
																		. '<br>Tel.:' . $orcatrata['CelularCliente'] . ' / ' . $orcatrata['Telefone'] . ' / ' . $orcatrata['Telefone2'] . ' / ' . $orcatrata['Telefone3'] . ''
																?></td>
					<td class="col-md-1 text-center" scope="col"><?php echo 'Data:<br><strong>'  . $orcatrata['DataOrca'] . '</strong>'
																		. '<br><br>Recebedor:<br><strong>'  . $orcatrata['NomeRec'] . '</strong>'
																	?></td>
					<td class="col-md-1 text-center" scope="col"><?php echo 'Orçamento:<br><strong>' . $orcatrata['idApp_OrcaTrata'] . '</strong>'
																		. '<br><br>Valor Total:'
																		. '<br>R$: <strong>'  . $orcatrata['ValorTotalOrca'] . '</strong>'
																		. '<br><br>Via do Cliente'
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
			<?php if( isset($count['PCount']) ) { ?>
				<tbody>
				<?php for ($k=1; $k <= $count['PCount']; $k++) { ?>
					<tr>
						<td class="col-md-1" scope="col"><?php echo $produto[$k]['SubTotalQtd'] ?></td>
						<td class="col-md-3" scope="col"><?php echo $produto[$k]['NomeProduto'] ?></td>
						<td class="col-md-1" scope="col"><?php echo $produto[$k]['SubtotalProduto'] ?></td>
						<td class="col-md-1" scope="col"><?php echo $produto[$k]['ConcluidoProduto'] ?></td>										
					</tr>
				
				<?php
				}
				?>
				</tbody>
			<?php
			}
			?>
			
			<thead>
				<tr>
					<th class="col-md-1" scope="col">Parcela</th>
					<th class="col-md-3" scope="col">Venc.</th>
					<th class="col-md-1" scope="col">R$</th>
					<th class="col-md-1" scope="col">Pago?</th>										
				</tr>
			</thead>
			<?php if( isset($count['PRCount']) ) { ?>
				<tbody>
				<?php for ($j=1; $j <= $count['PRCount']; $j++) { ?>
					<tr>
						<td class="col-md-1" scope="col"><?php echo $parcelasrec[$j]['Parcela'] ?></td>
						<td class="col-md-3" scope="col"><?php echo $parcelasrec[$j]['DataVencimento'] ?></td>
						<td class="col-md-1" scope="col"><?php echo number_format($parcelasrec[$j]['ValorParcela'], 2, ',', '.') ?></td>
						<td class="col-md-1" scope="col"><?php echo $this->basico->mascara_palavra_completa($parcelasrec[$j]['Quitado'], 'NS') ?></td>									
					</tr>
				<?php
				} 
				?>
				</tbody>
			<?php
			} 
			?>					
		</table>
	
	</div>		

</div>	