<?php if (isset($msg)) echo $msg; ?>

<div class="container-fluid">

	<div class="row">
		
		<div class="col-sm-offset-3 col-md-6 ">
			<div class="panel panel-info">
				<div class="panel-heading">
					
					<div class="panel-heading text-left">
						<h2><?php echo '<strong>Empresa: ' . $_SESSION['Orcatrata']['NomeEmpresa'] . '</strong> <br> 
						<h3><strong>Cliente: ' . $_SESSION['Cliente']['NomeCliente'] . ' - Id: ' . $_SESSION['Cliente']['idApp_Cliente'] . '</strong></h3> <br>
						<h4><strong>ORÇAMENTO Nº: ' . $_SESSION['Orcatrata']['idApp_OrcaTrata'] . '</strong></h4>' ?></h2>
					</div>

					<div class="panel-body">


						<?php echo '<h4>Atendente: ' . $_SESSION['Usuario']['Nome'] . ' - Id: ' . $_SESSION['Usuario']['idSis_Usuario'] . '</h4>' ?>
						<hr />

						<h3 class="text-center">Produtos / Serviços </h3>

						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<!--<th scope="col">Nº</th>-->
									<th class="col-md-1" scope="col">Qtd</th>																				
									<!--<th scope="col">CodProd.</th>
									<th scope="col">CategProd.</th>-->												
									<th class="col-md-9" scope="col">DescProd.</th>							
									<th class="col-md-1" scope="col">Valor</th>
									<th class="col-md-1" scope="col">Subtotal</th>
								</tr>	
								<tr>
									<th class="col-md-1" scope="col"></th>
									<th class="col-md-9" scope="col">id</th>	
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
						<hr />
						<?php if ($_SESSION['log']['NivelEmpresa'] >= 10 ) { ?>
						<h3 class="text-center">Produtos Devolvidos  </h3>

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

						<hr />
						
						<?php } ?>
						<h3 class="text-center">Pagamento</h3>
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
									<th class="col-md-3" scope="col">Valor</th>
									<th class="col-md-3" scope="col">Forma de Pag.</th>
									<th class="col-md-3" scope="col">Qtd Parc.</th>
									<th class="col-md-3" scope="col">Pago com</th>
									<th class="col-md-3" scope="col">1º Venc.</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>R$<?php echo number_format($orcatrata['ValorRestanteOrca'], 2, ',', '.') ?></td>
									<td><?php echo $orcatrata['AVAP'] ?></td>
									<td><?php echo $orcatrata['QtdParcelasOrca'] ?></td>
									<td><?php echo $orcatrata['FormaPag'] ?></td>
									<td><?php echo $orcatrata['DataVencimentoOrca'] ?></td>
								</tr>
							</tbody>
						</table>
						
						<hr />
						<h3 class="text-center">Parcelas</h3>

						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<th class="col-md-3" scope="col">Parcela</th>
									<th class="col-md-3" scope="col">Venc</th>
									<th class="col-md-3" scope="col">Valor</th>
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
									<td><?php echo $parcelasrec[$i]['DataVencimento'] ?></td>
									<td>R$ <?php echo number_format($parcelasrec[$i]['ValorParcela'], 2, ',', '.') ?></td>
									<td><?php echo $this->basico->mascara_palavra_completa($parcelasrec[$i]['Quitado'], 'NS') ?></td>
								</tr>

								<?php
								}
								?>

							</tbody>
						</table>

						<hr />
						<h3 class="text-center">Status</h3>
						
						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<th class="col-md-4" scope="col">Aprovado?</th>
									<th class="col-md-4" scope="col">Prod./Serv. Entregue?</th>
									<th class="col-md-4" scope="col">Quitado?</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $this->basico->mascara_palavra_completa($orcatrata['AprovadoOrca'], 'NS') ?></td>
									<td><?php echo $this->basico->mascara_palavra_completa($orcatrata['ConcluidoOrca'], 'NS') ?></td>
									<td><?php echo $this->basico->mascara_palavra_completa($orcatrata['QuitadoOrca'], 'NS') ?></td>
								</tr>
							</tbody>
						</table>

						<table class="table table-bordered table-condensed table-striped">
							<thead>
								<tr>
									<th class="col-md-4" scope="col">Data do Orçamento</th>
									<th class="col-md-4" scope="col">Data da Conclusão</th>
									<th class="col-md-4" scope="col">Data do Quitação</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $orcatrata['DataOrca'] ?></td>
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

					</div>
				</div>
			</div>
		</div>
	</div>

</div>
