<div style="overflow: auto; height: auto; ">	
	<table class="table table-hover">
		<thead>
			<tr>
				<!--<th class="active">EdtOrç</th>-->
				<th class="active">Imp.</th>							
				<th class="active">Orc.</th>
				<th class="active">Parc</th>	
				<th class="active">Desc.</th>
				<th class="active">Valor</th>
				<th class="active">Venc.</th>
				<th class="active">Pago?</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i=0;
			if ($q4) {

				foreach ($q4 as $row)
				{

					#$url = base_url() . 'orcatrata/alterardesp/' . $row['idApp_OrcaTrata'];
					#$url = '';

					#echo '<tr class="clickable-row" data-href="' . $url . '">';
					echo '<td class="notclickable">
							<a class="btn btn-md btn-danger notclickable" href="' . base_url() . 'OrcatrataPrintDesp/imprimirdesp/' . $row['idApp_OrcaTrata'] . '">
								<span class="glyphicon glyphicon-print notclickable"></span>
							</a>
							
						</td>';					
						echo '<td>' . $row['idApp_OrcaTrata'] . '</td>';
						echo '<td>' . $row['Parcela'] . '</td>';
						echo '<td>' . $row['Descricao'] . '</td>';
						echo '<td>R$' . number_format($row['ValorParcela'], 2, ',', '.') . '</td>';
						echo '<td>' . $row['DataVencimento'] . '</td>';
						echo '<td>' . $this->basico->mascara_palavra_completa($row['Quitado'], 'NS') . '</td>';
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


