<div style="overflow: auto; height: auto; ">
	<table class="table table-hover">
		<thead>
			<tr>
				<!--<th class="active text-center">id</th>-->
				<th class="active text-left">Cliente</th>
				<th class="active text-left">A Receber</th>
			</tr>
		</thead>
		<thead>
			<tr>						
				<th colspan="1" class="active">Total :</th>
				<th colspan="1" class="active">R$ <?php echo $q2->soma->somaqtdparc ?></th>												
			</tr>
		</thead>
		<tbody>
			<?php
			$i=-1;
			if ($q2) {

				foreach ($q2 as $row)
				{

					#$url = base_url() . 'orcatrata/alterar2/' . $row['idApp_OrcaTrata'];
					#$url = '';

					#echo '<tr class="clickable-row" data-href="' . $url . '">';

								if(isset($row->NomeCliente)) {
								#echo '<tr>';
								#echo '<tr class="clickable-row" data-href="' . base_url() . 'cliente/prontuario/' . $row->idApp_Cliente . '">';
								#echo '<tr class="clickable-row" data-href="' . base_url() . 'cliente/prontuario/' . $row->NomeCliente . '">';
									#echo '<td>' . $row->idApp_Cliente . '</td>';
									echo '<td>' . $row->NomeCliente . '</td>';
									echo '<td>R$ ' . $row->QtdParc . '</td>';							

								echo '</tr>';
								}            

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


