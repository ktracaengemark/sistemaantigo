<div style="overflow: auto; height: auto; ">	
	<table class="table table-hover">
		<thead>
			<tr>
				<!--<th class="active">EdtOrç</th>
				<th class="active">Imp.</th>-->							
				<th class="active">Orc.</th>
				<th class="active">Cliente</th>
				<th class="active">Qtd</th>								
				<th class="active">Produto</th>
				<th class="active">Valor</th>
				<th class="active">Valid.</th>
				<th class="active">Devolv?</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i=0;
			if ($q3) {

				foreach ($q3 as $row)
				{

					$url = base_url() . 'orcatrata/alterar2/' . $row['idApp_OrcaTrata'];
					#$url = '';

					echo '<tr class="clickable-row" data-href="' . $url . '">';
						echo '<td>' . $row['idApp_OrcaTrata'] . '</td>';
						echo '<td>' . $row['NomeCliente'] . '</td>';
						echo '<td>' . $row['QtdProduto'] . '</td>';
						echo '<td>' . $row['Produtos'] . '</td>';
						echo '<td>' . $row['ValorProduto'] . '</td>';
						echo '<td>' . $row['DataValidadeProduto'] . '</td>';
						echo '<td>' . $row['DevolvidoProduto'] . '</td>';
						echo '<td></td>';
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


