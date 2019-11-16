<?php if (isset($msg)) echo $msg; ?>

<div class="col-sm-offset-3 col-md-6 ">		
	
	<?php echo validation_errors(); ?>
	
		<!--
		<div class="panel-heading">
			
			<a class=" text-left" href="javascript:window.print()">
				<button type="button" class="btn btn-primary">
					<span class="glyphicon glyphicon-print"></span>
				</button>			
			</a>
			<a class=" text-left" href="<?php echo base_url() . 'orcatrata/alterar2/' . $_SESSION['Orcatrata']['idApp_OrcaTrata']; ?>">
				<button type="button" class="btn btn-warning">
					<span class="glyphicon glyphicon-edit"></span>
				</button>
			</a>
			<a class=" text-left" href="<?php echo base_url() . 'orcatrata/cadastrar3/'; ?>">
				<button type="button" class=" btn btn-danger">
					<span class="glyphicon glyphicon-plus"></span>
				</button>
			</a>
			<a class=" text-right" href="<?php echo base_url() . 'agenda/'; ?>">
				<button type="button" class=" btn btn-info">
					<span class="glyphicon glyphicon-remove"></span>
				</button>
			</a>			
			
		</div>
		-->
		
	<?php if ( !isset($evento) && isset($_SESSION['Orcatrata'])) { ?>
		<?php if ($_SESSION['Orcatrata']['idApp_OrcaTrata'] != 1 ) { ?>
			
			<div class="row">	
				
					<div class="panel panel-info">
						<div class="panel-heading">
							
							<div class="panel-heading text-left">
								<h2><?php echo '<strong>' . $_SESSION['Orcatrata']['NomeEmpresa'] . '</strong><small> - ' . $_SESSION['Usuario']['Nome'] . '</small>' ?></h2>
								<?php if ($_SESSION['log']['NivelEmpresa'] >= 3 ) { ?>								
								<h3><?php echo '' . $_SESSION['Cliente']['NomeCliente'] . ' - ' . $_SESSION['Cliente']['idApp_Cliente'] . '' ?></h3>
								<?php } ?>							
															
							</div>

							<div class="panel-body">

								<!--<hr />-->
								<h3 class="text-left">Orçamento<?php echo '<strong> - ' . $_SESSION['Orcatrata']['idApp_OrcaTrata'] . '</strong>' ?> </h3>								
								<table class="table table-bordered table-condensed table-striped">
									<thead>
										<tr>
											<th class="col-md-3" scope="col">Tipo</th>
											<th class="col-md-9" scope="col">Descrição/Obs</th>
										</tr>
									</thead>
									<tbody>
										<tr>

											<td><?php echo $orcatrata['TipoFinanceiro'] ?></td>
											<td><?php echo $orcatrata['Descricao'] ?></td>
										</tr>
									</tbody>
								</table>
								<?php if ($_SESSION['log']['NivelEmpresa'] >= 3 ) { ?>								
								<h3 class="text-left">Produtos / Serviços </h3>

								<table class="table table-bordered table-condensed table-striped">
									<thead>
										<tr>
											<!--<th scope="col">Nº</th>-->
											<th class="col-md-1" scope="col">Qtd</th>																				
											<!--<th scope="col">CodProd.</th>
											<th scope="col">CategProd.</th>-->												
											<th class="col-md-8" scope="col">DescProd.</th>							
											<th class="col-md-1" scope="col">Valor</th>
											<th class="col-md-1" scope="col">Subtotal</th>
										</tr>	
										<tr>
											<th class="col-md-1" scope="col"></th>
											<th class="col-md-8" scope="col">id</th>	
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
								<?php } ?>								
								<!--<hr />-->
								<?php if ($_SESSION['log']['NivelEmpresa'] >= 10 ) { ?>
								<h3 class="text-left">Produtos Devolvidos  </h3>

								<table class="table table-bordered table-condensed table-striped">
									<thead>
										<tr>
											<th class="col-md-1" scope="col">Qtd</th>																															
											<th class="col-md-9" scope="col">DescProd.</th>							
											<th class="col-md-1" scope="col">Valor</th>
											<th class="col-md-1" scope="col">Subtotal</th>
										</tr>	
										<tr>
											<th class="col-md-1" scope="col"></th>
											<th class="col-md-9" scope="col">id</th>	

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
								
								<?php } ?>
								<h3 class="text-left">Pagamento</h3>
								<!--
								<table class="table table-bordered table-condensed table-striped">
									<thead>
										<tr>
											<th class="col-md-4" scope="col">Orçamento</th>
											<th class="col-md-4" scope="col">Desconto</th>
											
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><?php echo number_format($orcatrata['ValorOrca'], 2, ',', '.') ?></td>
											<td><?php echo number_format($orcatrata['ValorDev'], 2, ',', '.') ?></td>
											
										</tr>
									</tbody>
								</table>
								-->
								<table class="table table-bordered table-condensed table-striped">
									<thead>
										<tr>
											<th class="col-md-3" scope="col">R$</th>
											<th class="col-md-3" scope="col">Forma</th>
											<!--<th class="col-md-3" scope="col">Qtd Parc.</th>-->
											<th class="col-md-3" scope="col">Pago</th>
											<th class="col-md-3" scope="col">1º Venc.</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><?php echo number_format($orcatrata['ValorRestanteOrca'], 2, ',', '.') ?></td>
											<td><?php echo $orcatrata['Modalidade'] ?></td>
											<!--<td><?php echo $orcatrata['QtdParcelasOrca'] ?></td>-->
											<td><?php echo $orcatrata['QtdParcelasOrca'] ?>X<?php echo $orcatrata['FormaPag'] ?></td>
											<td><?php echo $orcatrata['DataVencimentoOrca'] ?></td>
										</tr>
									</tbody>
								</table>
								
								<h3 class="text-left">Parcelas</h3>

								<table class="table table-bordered table-condensed table-striped">
									<thead>
										<tr>
											<th class="col-md-3" scope="col">Parcela</th>
											<th class="col-md-3" scope="col">R$</th>											
											<th class="col-md-3" scope="col">Venc</th>
											<th class="col-md-3" scope="col">Quitado</th>
										</tr>
									</thead>

									<tbody>

										<?php
										for ($i=1; $i <= $orcatrata['QtdParcelasOrca']; $i++) {
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
											<?php if ($_SESSION['log']['NivelEmpresa'] >= 10 ) { ?>
											<th class="col-md-4" scope="col">Aprovado?</th>
											<th class="col-md-4" scope="col">Prod./Serv. Entregue?</th>
											<?php } ?>
											<th class="col-md-4" scope="col">Quitado?</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<?php if ($_SESSION['log']['NivelEmpresa'] >= 10 ) { ?>
											<td><?php echo $this->basico->mascara_palavra_completa($orcatrata['AprovadoOrca'], 'NS') ?></td>
											<td><?php echo $this->basico->mascara_palavra_completa($orcatrata['ConcluidoOrca'], 'NS') ?></td>
											<?php } ?>
											<td><?php echo $this->basico->mascara_palavra_completa($orcatrata['QuitadoOrca'], 'NS') ?></td>
										</tr>
									</tbody>
								</table>

								<table class="table table-bordered table-condensed table-striped">
									<thead>
										<tr>
											<th class="col-md-4" scope="col">Data do Orçamento</th>
											<?php if ($_SESSION['log']['NivelEmpresa'] >= 10 ) { ?>
											<th class="col-md-4" scope="col">Data da Conclusão</th>
											<th class="col-md-4" scope="col">Data do Quitação</th>
											<?php } ?>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><?php echo $orcatrata['DataOrca'] ?></td>
											<?php if ($_SESSION['log']['NivelEmpresa'] >= 10 ) { ?>
											<td><?php echo $orcatrata['DataConclusao'] ?></td>
											<td><?php echo $orcatrata['DataQuitado'] ?></td>
											<?php } ?>
										</tr>
									</tbody>
								</table>
								<!--
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

		<?php } ?>
	<?php } ?>	
		
</div>