<div style="overflow: auto; height: auto; ">	
	<div class="container-fluid">
		

			<div>
				<table class="table table-bordered table-condensed table-striped">	
					<tfoot>
						<tr>
							<th colspan="3" class="active">Total encontrado: <?php echo $report->num_rows(); ?> resultado(s)</th>
						</tr>
					</tfoot>
				</table>
				<?php if ($_SESSION['log']['NivelEmpresa'] <= 3 ) { ?>
				<table class="table table-bordered table-condensed table-striped">

					<thead>
						<tr>                       																	
							<!--<th class="active">Id.</th>-->
							<th class="active">Cod.</th>
							<th class="active">Produto</th>
							<th class="active">Valor</th>																																
						</tr>
					</thead>

					<tbody>
						
						<?php
						foreach ($report->result_array() as $row) {

							#echo '<tr>';
							echo '<tr class="clickable-row" data-href="' . base_url() . 'produtos/alterar/' . $row['idTab_Produto'] . '">';
								#echo '<td>' . $row['idTab_Produto'] . '</td>';
								echo '<td>' . $row['CodProd'] . '</td>';
								echo '<td>' . $row['Produtos'] . '</td>';
								echo '<td>' . $row['ValorProduto'] . '</td>';	
							echo '</tr>';
						}
						?>
						
					</tbody>

				</table>
				<?php } ?>
				<?php if (($_SESSION['log']['NivelEmpresa'] >= 4) AND ($_SESSION['log']['NivelEmpresa'] <= 7) ) { ?>
				<table class="table table-bordered table-condensed table-striped">

					<thead>
						<tr>                       																	
							<!--<th class="active">Id.</th>-->
							<th class="active">Cod.</th>
							<th class="active">Categoria</th>							
							
							<th class="active">Produto</th>
							<th class="active">Unid.</th>							
							<th class="active">Valor</th>
							<th class="active">V/C</th>
							<th class="active">Prod/Serv</th>
							<!--<th class="active">Aux1</th>
							<th class="active">Aux2</th>
							<th class="active">Custo</th>						
							<th class="active">Tabelas & Planos</th>
							<th class="active">Descrição</th>						
							<th class="active">Fornec.</th>-->
													
																																								
						</tr>
					</thead>

					<tbody>
						
						<?php
						foreach ($report->result_array() as $row) {

							#echo '<tr>';
							echo '<tr class="clickable-row" data-href="' . base_url() . 'produtos/alterar/' . $row['idTab_Produto'] . '">';
								#echo '<td>' . $row['idTab_Produto'] . '</td>';
								echo '<td>' . $row['CodProd'] . '</td>';
								echo '<td>' . $row['Prodaux3'] . '</td>';								
								
								echo '<td>' . $row['Produtos'] . '</td>';
								echo '<td>' . $row['UnidadeProduto'] . '</td>';								
								echo '<td>' . $row['ValorProduto'] . '</td>';	
								echo '<td>' . $row['TipoProduto'] . '</td>';													
								echo '<td>' . $row['Categoria'] . '</td>'; 							
								#echo '<td>' . $row['Prodaux1'] . '</td>';
								#echo '<td>' . $row['Prodaux2'] . '</td>';
								#echo '<td>' . $row['ValorCompraProduto'] . '</td>';								
								#echo '<td>' . $row['Convenio'] . '</td>';
								#echo '<td>' . $row['Convdesc'] . '</td>';							
								#echo '<td>' . $row['NomeFornecedor'] . '</td>';	
							
							echo '</tr>';
						}
						?>
						
					</tbody>

				</table>
				<?php } ?>
				
				<?php if (($_SESSION['log']['NivelEmpresa'] >= 8) AND ($_SESSION['log']['NivelEmpresa'] <= 10) ) { ?>
				<table class="table table-bordered table-condensed table-striped">

					<thead>
						<tr>                       																	
							<!--<th class="active">Id.</th>-->
							<th class="active">Cod.</th>
							<th class="active">Categoria</th>
							<th class="active">Produto</th>
							<th class="active">Valor</th>
							<th class="active">V/C</th>
							<th class="active">Prod/Serv</th>
							<th class="active">Unid.</th>
							
							<th class="active">Aux1</th>
							<th class="active">Aux2</th>
							<!--<th class="active">Custo</th>-->						
							<th class="active">Tabelas & Planos</th>
							<th class="active">Descrição</th>						
							<th class="active">Fornec.</th>
													
																																								
						</tr>
					</thead>

					<tbody>
						
						<?php
						foreach ($report->result_array() as $row) {

							#echo '<tr>';
							echo '<tr class="clickable-row" data-href="' . base_url() . 'produtos/alterar/' . $row['idTab_Produto'] . '">';
								#echo '<td>' . $row['idTab_Produto'] . '</td>';
								echo '<td>' . $row['CodProd'] . '</td>';
								echo '<td>' . $row['Prodaux3'] . '</td>';
								echo '<td>' . $row['Produtos'] . '</td>';
								echo '<td>' . $row['ValorProduto'] . '</td>';	
							
								echo '<td>' . $row['TipoProduto'] . '</td>';													
								echo '<td>' . $row['Categoria'] . '</td>'; 							
								echo '<td>' . $row['UnidadeProduto'] . '</td>';
								
								echo '<td>' . $row['Prodaux1'] . '</td>';
								echo '<td>' . $row['Prodaux2'] . '</td>';
								#echo '<td>' . $row['ValorCompraProduto'] . '</td>';								
								echo '<td>' . $row['Convenio'] . '</td>';
								echo '<td>' . $row['Convdesc'] . '</td>';							
								echo '<td>' . $row['NomeFornecedor'] . '</td>';	
							
							echo '</tr>';
						}
						?>
						
					</tbody>

				</table>
				<?php } ?>				
			</div>

		

	</div>
</div>
