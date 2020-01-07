<div style="overflow: auto; height: auto; ">	
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="row">	
				<div class="col-md-12">
					<!--<label> Total:</label>-->
					<div class="input-group">
						<span class="input-group-addon">Total: R$</span>
						<input type="text" class="form-control" disabled aria-label="Total de Entradas" value="<?php echo $q4->soma->somareceber ?>">
					</div>
				</div>				
			</div>	
		</div>
	</div>	
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
				
			</tr>
		</thead>
		<tbody>
			<?php
			$i=0;
			if ($q4) {

				foreach ($q4->result_array() as $row)
				{

					#$url = base_url() . 'orcatrata/alterar2/' . $row['idApp_OrcaTrata'];
					#$url = '';

					#echo '<tr class="clickable-row" data-href="' . $url . '">';
					echo '<td class="notclickable">
							<a class="btn btn-md btn-info notclickable" href="' . base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_OrcaTrata'] . '">
								<span class="glyphicon glyphicon-print notclickable"></span>
							</a>
							
						</td>';						
						echo '<td>' . $row['idApp_OrcaTrata'] . '</td>';
						echo '<td>' . $row['Parcela'] . '</td>';
						echo '<td>' . $row['Descricao'] . '</td>';
						echo '<td>R$' . $row['ValorParcela'] . '</td>';
						echo '<td>' . $row['DataVencimento'] . '</td>';
						echo '<td>' . $this->basico->mascara_palavra_completa($row['Quitado'], 'NS') . '</td>';
						
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


