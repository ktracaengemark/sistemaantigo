<div style="overflow: auto; height: auto; ">	
	<table class="table table-hover">
		<thead>
			<tr>
				<!--<th class="active">EdtOrç</th>
				<th class="active">Imp.</th>-->							
				<th class="col-md-2 active" scope="col">Pedido</th>
				<th class="col-md-4 active" scope="col">Cliente</th>
				<th class="col-md-2 active" scope="col">Data</th>
				<th class="col-md-4 active" scope="col">Entrega</th>
				<!--<th class="active">Qtd</th>								
				<th class="active">Produto</th>
				<th class="active">Obs.</th>
				<th class="active">Valid.</th>
				<th class="active">Hora.</th>
				<th class="active">Entr.?</th>-->
				
			</tr>
		</thead>
		<tbody>
			<?php
			$i=0;
			if ($q) {

				foreach ($q as $row)
				{

					$url = base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_OrcaTrata'];
					#$url = '';

					echo '<tr class="clickable-row" data-href="' . $url . '">';
						echo '<td>' . $row['idApp_OrcaTrata'] . '</td>';
						echo '<td>' . $row['NomeCliente'] . '</td>';
						echo '<td>' . $row['DataOrca'] . '</td>';
						echo '<td>' . $row['TipoFrete'] . '</td>';
						#echo '<td>' . $row['QtdProduto'] . '</td>';
						#echo '<td>' . $row['Produtos'] . '</td>';
						#echo '<td>R$' . number_format($row['ValorProduto'], 2, ',', '.') . '</td>';
						#echo '<td>' . $row['ObsProduto'] . '</td>';
						#echo '<td>' . $row['DataValidadeProduto'] . '</td>';
						#echo '<td>' . $row['HoraValidadeProduto'] . '</td>';
						#echo '<td>' . $this->basico->mascara_palavra_completa($row['ConcluidoProduto'], 'NS') . '</td>';
						
					echo '</tr>';            

					$i++;
				}
				
			}
			?>

		</tbody>
		<tfoot>
			<tr>
				<th colspan="7">Total encontrado: <?php echo $i; ?> resultado(s)</th>
			</tr>
		</tfoot>
	</table>
</div>


