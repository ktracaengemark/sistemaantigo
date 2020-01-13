<div style="overflow: auto; height: 183px; ">
	<div class="container-fluid">
		<div class="row">

			
				<table class="table table-bordered table-condensed table-striped">	
					<tfoot>
						<tr>
							<th colspan="9" class="active">Tarefas: <?php echo $report->num_rows(); ?> resultado(s)</th>
						</tr>
					</tfoot>
				</table>	
				<table class="table table-bordered table-condensed table-striped">								
					<thead>
						<tr>
							<!--<th class="active">Filt.</th>
							<th class="active">Edit</th>-->
							<th class="active">Pri.</th>
							<th class="active">Cnl.</th>
							<th class="active">Tarefa</th>
							<th class="active">Limite</th>
							<th class="active">Comp.</th>
							<th class="active">Usuario</th>
							<th class="active">Excl</th>
							<!--<th class="active">Data</th>-->
						</tr>
					</thead>

					<tbody>

						<?php
						foreach ($report->result_array() as $row) {

							#echo '<tr>';
							echo '<tr class="clickable-row" data-href="' . base_url() . 'tarefa/alterar/' . $row['idApp_Procedimento'] . '">';
							#echo '<tr class="clickable-row" data-href="' . base_url() . 'procedimento/alterar/' . $row['idApp_Procedimento'] . '">';
							#echo '<tr class="clickable-row" data-href="' . base_url() . 'orcatrata/alterarprocedimento/' . $row['idSis_Empresa'] . '">';

								/*
									echo '<td class="notclickable">
										<a class="btn btn-md btn-info notclickable" href="' . base_url() . 'orcatrata/alterarprocedimento/' . $row['idSis_Empresa'] . '">
											<span class="glyphicon glyphicon-edit notclickable"></span>
										</a>
									</td>';
								*/
								/*
								echo '<td class="notclickable">
										<a class="btn btn-md btn-primary notclickable" href="' . base_url() . 'procedimento/alterar/' . $row['idApp_Procedimento'] . '">
											<span class="glyphicon glyphicon-edit notclickable"></span>
										</a>
									</td>';
								*/	
								echo '<td>' . $row['Prioridade'] . '</td>';
								echo '<td>' . $row['ConcluidoProcedimento'] . '</td>';
								echo '<td>' . $row['Procedimento'] . '</td>';
								echo '<td>' . $row['DataProcedimentoLimite'] . '</td>';
								echo '<td>' . $row['Comp'] . '</td>';
								echo '<td>' . $row['NomeUsuario'] . '</td>';
								#echo '<td>' . $row['DataProcedimento'] . '</td>';
								echo '<td class="notclickable">
										<a class="btn btn-sm btn-danger notclickable" href="' . base_url() . 'tarefa/excluir/' . $row['idApp_Procedimento'] . '">
											<span class="glyphicon glyphicon-trash notclickable"></span>
										</a>
									</td>';
									
							echo '</tr>';
						}
						?>

					</tbody>

				</table>

			

		</div>

	</div>
</div>