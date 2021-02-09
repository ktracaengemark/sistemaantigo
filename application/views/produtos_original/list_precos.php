<div style="overflow: auto; height: auto; ">
	<table class="table table-hover">
		<thead>
			<tr>
				<th>id_Valor</th>
				<th>id_Produto</th>
				<th>Tipo</th>
				<th>Valor</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i=0;
			if ($q_precos) {

				foreach ($q_precos as $row)
				{

					$url = base_url() . 'produtos/tela/' . $row['idTab_Produtos'];
					//$url = '';

					echo '<tr class="clickable-row" data-href="' . $url . '">';
						echo '<td>' . $row['idTab_Valor'] . '</td>';
						echo '<td>' . $row['idTab_Produtos'] . '</td>';
						echo '<td>' . $row['Desconto'] . '</td>';
						echo '<td>' . $row['ValorProduto'] . '</td>';
						echo '<td></td>';
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
</div>

