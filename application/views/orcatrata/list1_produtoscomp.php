<div style="overflow: auto; height: auto; ">	
	<table class="table table-hover">
		<thead>
			<tr>
				<!--<th class="active">EdtOrç</th>
				<th class="active">Imp.</th>-->							
				<th class="active">Orc.</th>
				<th class="active">Fornec.</th>
				<th class="active">Data</th>
				
			</tr>
		</thead>
		<tbody>
			<?php
			$i=0;
			if ($q) {

				foreach ($q as $row)
				{

					$url = base_url() . 'orcatrata/alterardesp/' . $row['idApp_OrcaTrata'];
					#$url = '';

					echo '<tr class="clickable-row" data-href="' . $url . '">';
						echo '<td>' . $row['idApp_OrcaTrata'] . '</td>';
						echo '<td>' . $row['NomeFornecedor'] . '</td>';
						echo '<td>' . $row['DataOrca'] . '</td>';
						
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


