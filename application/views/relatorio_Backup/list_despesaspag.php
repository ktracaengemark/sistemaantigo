<div style="overflow: auto; height: 350px; ">	
	<div class="panel panel-default">
		<div class="panel-body">

			<div class="col-md-1"></div>

			<!--<div class="col-md-2">
				<label for="DataFim">Total de Desconto:</label>
				<div class="input-group">
					<span class="input-group-addon">R$</span>
					<input type="text" class="form-control" disabled aria-label="Total Entrada" value="<?php echo $report->soma->somaentrada ?>">
				</div>
			</div>-->
			<div class="col-md-3">
				<label for="DataFim">Total:</label>
				<div class="input-group">
					<span class="input-group-addon">R$</span>
					<input type="text" class="form-control" disabled aria-label="Total Entrada" value="<?php echo $report->soma->balanco ?>">
				</div>
			</div>		
			<div class="col-md-3">
				<label for="DataFim">Pago:</label>
				<div class="input-group">
					<span class="input-group-addon">R$</span>
					<input type="text" class="form-control" disabled aria-label="Total Pago" value="<?php echo $report->soma->somarecebido ?>">
				</div>
			</div>
			<div class="col-md-3">
				<label for="DataFim">À Pagar:</label>
				<div class="input-group">
					<span class="input-group-addon">R$</span>
					<input type="text" class="form-control" disabled aria-label="Total a receber" value="<?php echo $report->soma->somareceber ?>">
				</div>
			</div>      
			<!--<div class="col-md-2">
				<label for="DataFim">Total Real/Caixa:</label>
				<div class="input-group">
					<span class="input-group-addon">R$</span>
					<input type="text" class="form-control" disabled aria-label="Total Real" value="<?php echo $report->soma->somareal ?>">
				</div>
			</div>-->



			<div class="col-md-1"></div>

		</div>	
		
	</div>

	<div class="container-fluid">
		<div class="row">

			<div>
				<table class="table table-bordered table-condensed table-striped">
					<tfoot>
						<tr>
							<th colspan="3" class="active">Total encontrado: <?php echo $report->num_rows(); ?> resultado(s)</th>
						</tr>
					</tfoot>
				</table>	
				<table class="table table-bordered table-condensed table-striped">

					<thead>
						<tr>
							<!--<th class="active">Tipo</th>
							<th class="active">Nº</th>
							<th class="active">Mod.</th>
							<th class="active">Tipo</th>-->
							<th class="active">Despesa/Tipo</th>
							<th class="active">Pcl/Pg</th>
							<th class="active">Venc/Mod</th>
							<!--<th class="active">Pago</th>
							<th class="active">Quit.</th>
							<th class="active">Data do Pagam.</th>-->
							<th class="active">Valor</th>
							
						</tr>
					</thead>

					<tbody>

						<?php
						foreach ($report->result_array() as $row) {

							#echo '<tr>';
							echo '<tr class="clickable-row" data-href="' . base_url() . 'despesas/alterar/' . $row['idApp_Despesas'] . '">';
								#echo '<td>' . $row['TipoProduto'] . '</td>';
								#echo '<td>' . $row['idApp_Despesas'] . '</td>';							
								#echo '<td>' . $row['ModalidadeDespesas'] . '</td>';
								#echo '<td>' . $row['TipoDespesa'] . '</td>';
								echo '<td>' . $row['Despesa'] . '</td>';
															
								echo '<td>' . $row['ParcelaPagaveis'] . ' ' . $row['QuitadoPagaveis'] . '</td>';
								echo '<td>' . $row['DataVencimentoPagaveis'] . ' ' . $row['Modalidade'] . '</td>';
								#echo '<td>' . $row['DataPagoPagaveis'] . ' R$' . $row['ValorPagoPagaveis'] . '</td>';
								#echo '<td>' . $row['QuitadoPagaveis'] . '</td>';
								echo '<td class="text-left">' . $row['ValorParcelaPagaveis'] . '</td>';
								#echo '<td>' . $row['DataPagoPagaveis'] . '</td>';
								#echo '<td class="text-left">R$ ' . $row['ValorPagoPagaveis'] . '</td>';
								
							echo '</tr>';
						}
						?>

					</tbody>
					
				</table>

			</div>

		</div>

	</div>
</div>