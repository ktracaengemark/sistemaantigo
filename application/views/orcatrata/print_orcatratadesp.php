<?php if ( !isset($evento) && isset($_SESSION['Orcatrata'])) { ?>
	<?php if ($_SESSION['Orcatrata']['idApp_OrcaTrata'] != 1 ) { ?>
		<nav class="navbar navbar-center navbar-inverse navbar-fixed-top ">
		  <div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span> 
				</button>
				<li class="navbar-form">
					<a href="javascript:window.print()">
						<button type="button" class="btn btn-sm btn-default ">
							<span class="glyphicon glyphicon-print"></span> Imprimir
						</button>
					</a>
					<a <?php if (preg_match("/orcatrata\/alterardesp\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
						<a href="<?php echo base_url() . 'orcatrata/alterardesp/' . $_SESSION['Orcatrata']['idApp_OrcaTrata']; ?>">
							<button type="button" class="btn btn-sm btn-default ">
								<span class="glyphicon glyphicon-edit"></span> Editar
							</button>										
						</a>
					</a>
					<a <?php if (preg_match("/orcatrata\/cadastrardesp\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
						<a href="<?php echo base_url() . 'orcatrata/cadastrardesp/'; ?>">
							<button type="button" class="btn btn-sm btn-active ">
								<span class="glyphicon glyphicon-remove"></span> Novo
							</button>										
						</a>
					</a>
					<!--
					<button  type="button" class="btn btn-sm btn-default" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
						<span class="glyphicon glyphicon-trash"></span> Excluir
					</button>
					-->
				</li>				
				<!--
				<a class="navbar-brand" href="<?php echo base_url() ?>usuario2/prontuario/<?php echo $_SESSION['log']['id']; ?>"> 
					 <?php echo $_SESSION['log']['Nome2']; ?>./<?php echo $_SESSION['log']['NomeEmpresa2']; ?>.
				</a>					
				
				<a class="navbar-brand" href="<?php echo base_url() ?>orcatrata/cadastrardesp/"> 
					 <span class="glyphicon glyphicon-plus"></span> Nova Despesa
				</a>
				-->
			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav navbar-center">
					<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">
						<div class="btn-group " role="group" aria-label="...">
							<a href="<?php echo base_url(); ?>agenda">
								<button type="button" class="btn btn-lg btn-info ">
									<span class="glyphicon glyphicon-calendar"></span> Agenda
								</button>
							</a>
						</div>
					</li>
					<?php if ($_SESSION['log']['NivelEmpresa'] >= 3 ) { ?>
					<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">
						
						<div class="btn-group " role="group" aria-label="...">
							<a href="<?php echo base_url(); ?>relatorio/clientes">
								<button type="button" class="btn btn-sm btn-warning ">
									<span class="glyphicon glyphicon-user"></span> Clientes
								</button>
							</a>
						</div>
						<div class="btn-group">
							<button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">
								<span class="glyphicon glyphicon-user"></span> Fornecedores <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">							
								<li><a href="<?php echo base_url() ?>relatorio/fornecedor"><span class="glyphicon glyphicon-user"></span> Lista de Fornecedores</a></li>
								<li role="separator" class="divider"></li>							
								<li><a href="<?php echo base_url() ?>atividade/cadastrar"><span class="glyphicon glyphicon-list-alt"></span> Atividade dos Fornecedores</a></li>									
							</ul>
						</div>																				
						
					</li>
					<?php } ?>
					<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">
						<div class="btn-group " role="group" aria-label="...">
							<a href="<?php echo base_url(); ?>orcatrata/cadastrar3">
								<button type="button" class="btn btn-lg btn-primary ">
									<span class="glyphicon glyphicon-plus"></span>Receitas
								</button>
							</a>
						</div>
						<div class="btn-group " role="group" aria-label="...">
							<a href="<?php echo base_url(); ?>orcatrata/cadastrardesp">
								<button type="button" class="btn btn-lg btn-danger ">
									<span class="glyphicon glyphicon-plus"></span>Despesas
								</button>
							</a>
						</div>														
					</li>
					<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">
						<div class="btn-group">
							<button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
								<span class="glyphicon glyphicon-usd"></span> Financeiro <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">							
								<li><a href="<?php echo base_url() ?>relatorio/financeiro"><span class="glyphicon glyphicon-usd"></span> Orçamentos</a></li>
								<li role="separator" class="divider"></li>							
								<li><a href="<?php echo base_url() ?>relatorio/parcelas"><span class="glyphicon glyphicon-usd"></span> Receber X Pagar</a></li>
								<li role="separator" class="divider"></li>							
								<li><a href="<?php echo base_url() ?>relatorio/fiado"><span class="glyphicon glyphicon-usd"></span> Fiado</a></li>									
								<li role="separator" class="divider"></li>									
								<li><a href="<?php echo base_url() ?>relatorio/balanco"><span class="glyphicon glyphicon-usd"></span> Balanço</a></li>
								<?php if ($_SESSION['log']['NivelEmpresa'] >= 3 ) { ?>
								<li role="separator" class="divider"></li>
								<li><a href="<?php echo base_url() ?>relatorio/rankingvendas"><span class="glyphicon glyphicon-pencil"></span> Ranking de Vendas</a></li>
								<?php } ?>
							</ul>
						</div>							
						<?php if ($_SESSION['log']['NivelEmpresa'] >= 3 ) { ?>
						<div class="btn-group">
							<button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
								<span class="glyphicon glyphicon-gift"></span> Produtos <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">							
								<li><a href="<?php echo base_url() ?>relatorio/produtos"><span class="glyphicon glyphicon-usd"></span> Produtos & Valores</a></li>
								<li role="separator" class="divider"></li>							
								<li><a href="<?php echo base_url() ?>relatorio/estoque"><span class="glyphicon glyphicon-list-alt"></span> Produtos & Estoque</a></li>							
								<li role="separator" class="divider"></li>							
								<li><a href="<?php echo base_url() ?>relatorio/compvend"><span class="glyphicon glyphicon-pencil"></span> Produtos Comprados & Vendidos</a></li>
								<li role="separator" class="divider"></li>							
								<li><a href="<?php echo base_url() ?>Prodaux3/cadastrar"><span class="glyphicon glyphicon-list"></span> Lista de Categoria</a></li>										
								<li role="separator" class="divider"></li>																			
								<li><a data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal3-sm"><span class="glyphicon glyphicon-plus"></span> Novo Produto</a></li>
							</ul>
						</div>																				
						<?php } ?>
					</li>
					<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">								
						<div class="btn-group">
							<button type="button" class="btn btn-lg btn-default dropdown-toggle" data-toggle="dropdown">
								<span class="glyphicon glyphicon-home"></span> enkontraki
								<span class="caret"></span>
								<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) && ($_SESSION['log']['idSis_Empresa'] != 5))  { ?>
									<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); $intervalo = $data1->diff($data2); echo $intervalo->format('%a dias'); ?>
								<?php } else if ($_SESSION['log']['idSis_Empresa'] != 5){?>
									Renovar !!!
								<?php } ?>
							</button>
							<ul class="dropdown-menu" role="menu">							
								<?php if ($_SESSION['log']['NivelEmpresa'] >= 3 ) { ?>
								<li><a href="<?php echo base_url() ?>relatorio/loginempresa"><span class="glyphicon glyphicon-pencil"></span> Renovar Assinatura</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="<?php echo base_url() ?>relatorio/empresas"><span class="glyphicon glyphicon-pencil"></span> Dicas de Negócios</a></li>
								<li role="separator" class="divider"></li>									
								<?php } ?>
								<li><a href="<?php echo base_url() ?>relatorio/empresas"><span class="glyphicon glyphicon-home"></span> Outras Empresas</a></li>
							</ul>
						</div>
					</li>
					<!--
					<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">
						<div class="btn-group " role="group" aria-label="...">
							<a href="javascript:window.print()">
								<button type="button" class="btn btn-md btn-default ">
									<span class="glyphicon glyphicon-print"></span> Imprimir
								</button>
							</a>
						</div>
						<div class="btn-group " role="group" aria-label="...">
							<a <?php if (preg_match("/orcatrata\/alterardesp\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
								<a href="<?php echo base_url() . 'orcatrata/alterardesp/' . $_SESSION['Orcatrata']['idApp_OrcaTrata']; ?>">
									<button type="button" class="btn btn-md btn-default ">
										<span class="glyphicon glyphicon-edit"></span> Editar
									</button>										
								</a>
							</a>
						</div>
						<div class="btn-group " role="group" aria-label="...">
							<button  type="button" class="btn btn-md btn-default" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
								<span class="glyphicon glyphicon-trash"></span> Excluir
							</button>
						</div>																				
					</li>
					-->
					<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">		
						<div class="btn-group " role="group" aria-label="...">
							<a href="<?php echo base_url(); ?>login/sair">
								<button type="button" class="btn btn-sm btn-active ">
									<span class="glyphicon glyphicon-log-out"></span> Sair
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
<br>
<?php if (isset($msg)) echo $msg; ?>
			
<div class="col-sm-offset-3 col-md-6 ">		
	
	<?php echo validation_errors(); ?>
			
	<div style="overflow: auto; height: auto; ">
		<div class="row">	
			<div class="panel panel-danger">
				<div class="panel-heading">
					
					<div class="panel-heading text-left">
						<h2><?php echo '<strong>' . $_SESSION['Orcatrata']['NomeEmpresa'] . '</strong><small> - ' . $_SESSION['Usuario']['Nome'] . '</small>' ?></h2>
						<?php if ($_SESSION['log']['NivelEmpresa'] >= 3 ) { ?>								
						<h3><?php echo '' . $_SESSION['Fornecedor']['NomeFornecedor'] . ' - ' . $_SESSION['Fornecedor']['idApp_Fornecedor'] . '' ?></h3>
						<?php } ?>							
													
					</div>

					<div class="panel-body">

						<!--<hr />-->
						<h3 class="text-left">Orçamento<?php echo '<strong> - ' . $_SESSION['Orcatrata']['idApp_OrcaTrata'] . '</strong>' ?> </h3>								
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<th class="col-md-3" scope="col">Tipo</th>
									<th class="col-md-6" scope="col">Descrição</th>
									<th class="col-md-3" scope="col">Dta Orçam</th>
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
						<?php if ($_SESSION['log']['NivelEmpresa'] >= 3 ) { ?>
						<?php if( isset($count['PCount']) ) { ?>								
						<h3 class="text-left">Produtos Entregues </h3>
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<!--<th scope="col">Nº</th>-->
									<th class="col-md-1" scope="col">Qtd</th>																				
									<!--<th scope="col">CodProd.</th>
									<th scope="col">CategProd.</th>-->												
									<th class="col-md-8" scope="col">Produto</th>							
									<th class="col-md-1" scope="col">Valor</th>
									<th class="col-md-1" scope="col">Subtotal</th>
								</tr>	
								<tr>
									<th class="col-md-1" scope="col"></th>
									<th class="col-md-8" scope="col">id-Ent-Dev-Obs.:</th>	
									<!--<th scope="col">Unidade</th>																				
									<th scope="col">Aux1</th>
									<th scope="col">Aux2</th>-->
									<!--<th scope="col">Tipo </th>
									<th scope="col">Desc </th>-->
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
									<td><?php echo $produto[$i]['idApp_Produto'] ?></td>
									<!--<td><?php echo $produto[$i]['UnidadeProduto'] ?></td>														
									<td><?php echo $produto[$i]['Prodaux1'] ?></td>
									<td><?php echo $produto[$i]['Prodaux2'] ?></td>-->
									<!--<td><?php echo $produto[$i]['Convenio'] ?></td>
									<td><?php echo $produto[$i]['Convdesc'] ?></td>-->
									<td><?php echo $produto[$i]['DataValidadeProduto'] ?></td>							
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
						
						<?php if ($_SESSION['log']['NivelEmpresa'] >= 10 ) { ?>
						<?php if( isset($count['SCount']) ) { ?>								
						<h3 class="text-left">Produtos Devolvidos  </h3>
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<th class="col-md-1" scope="col">Qtd</th>																															
									<th class="col-md-9" scope="col">Produto</th>							
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
						<?php } else echo '<h3 class="text-left">S/Produtos Devolvidos </h3>';{?>
						<?php } ?>								
						<?php } ?>
						
						<h3 class="text-left">Pagamento</h3>
						<?php if ($_SESSION['log']['NivelEmpresa'] >= 3 ) { ?>
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<th class="col-md-2" scope="col">Orçam. R$</th>
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

						<h3 class="text-left">Status</h3>
						
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<th class="col-md-4" scope="col">Orç.Aprovado?</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $this->basico->mascara_palavra_completa($orcatrata['AprovadoOrca'], 'NS') ?></td>
								</tr>
							</tbody>
						</table>
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
						<a class="btn btn-danger" href="<?php echo base_url() . 'orcatrata/excluirdesp/' . $_SESSION['Orcatrata']['idApp_OrcaTrata'] ?>" role="button">
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