<div style="overflow: auto; height: auto; ">
	<h3>Precos</h3>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>id_Valor</th>
				<th>id_Produto</th>
				<th>Produto</th>
				<th>Tipo</th>
				<th>Valor</th>
				<th>Ativo</th>
				<th>Balcao</th>
				<th>Site</th>
				<th>Comissão</th>
				<th>Prazo</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i=0;
			if ($q_precos) {

				foreach ($q_precos as $row)
				{

					$url = base_url() . 'produtos/tela_valor/' . $row['idTab_Valor'];
					//$url = '';

					echo '<tr class="clickable-row" data-href="' . $url . '">';
						echo '<td>' . $row['idTab_Valor'] . '</td>';
						echo '<td>' . $row['idTab_Produtos'] . '</td>';
						echo '<td>' . $row['Nome_Prod'] . '</td>';
						echo '<td>' . $row['Desconto'] . '</td>';
						echo '<td>R$ ' . $row['ValorProduto'] . '</td>';
						echo '<td>' . $row['AtivoPreco'] . '</td>';
						echo '<td>' . $row['VendaBalcaoPreco'] . '</td>';
						echo '<td>' . $row['VendaSitePreco'] . '</td>';
						echo '<td>' . $row['ComissaoVenda'] . '%</td>';
						echo '<td>' . $row['TempoDeEntrega'] . '</td>';
					echo '</tr>';            

					$i++;
				}
				
			}
			?>

		</tbody>
		<tfoot>
			<tr>
				<th colspan="3">Total encontrado: <?php echo $i; ?> resultado(s)</th>
			</tr>
		</tfoot>
	</table>
	<hr>
</div>


