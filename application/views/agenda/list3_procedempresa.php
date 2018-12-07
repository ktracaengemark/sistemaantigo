<div style="overflow: auto; height: 410px; ">
	<div class="container-fluid">
		<div class="row">
			<table class="table table-bordered table-condensed table-striped">	
				<tfoot>
					<tr>
						<th colspan="9" class="active">Total: <?php echo $report->num_rows(); ?> resultado(s)</th>
					</tr>
				</tfoot>
			</table>
			<?php if ($_SESSION['log']['idSis_Empresa'] == 5 ) { ?>
			<table class="table table-bordered table-condensed table-striped">								
				<thead>
					<tr>
						<th class="active">Resp.</th>
						<th class="active">Pergunta</th>
						<th class="active">DtEnv</th>
						<th class="active">Emp.Rec</th>
						<!--<th class="active">Recptor</th>-->
						<th class="active">Resposta</th>
						<th class="active">DtRes</th>
					</tr>
				</thead>
				<tbody>

					<?php
					foreach ($report->result_array() as $row) {

						echo '<tr class="clickable-row" data-href="' . base_url() . 'orcatrata/alterarprocedempresa/' . $row['idSis_Empresa'] . '">';

							echo '<td>' . $row['ConcluidoProcedimento'] . '</td>';
							echo '<td>' . $row['ProcedimentoCli'] . '</td>';
							echo '<td>' . $row['DataProcedimentoCli'] . '</td>';
							echo '<td>' . $row['NomeEmpresa'] . '</td>';
							#echo '<td>' . $row['Nome'] . '</td>';
							echo '<td>' . $row['Procedimento'] . '</td>';
							echo '<td>' . $row['DataProcedimento'] . '</td>';

						echo '</tr>';
					}
					?>
				</tbody>
			</table>
			<?php } ?>
			<?php if ($_SESSION['log']['idSis_Empresa'] != 5 ) { ?>
			<table class="table table-bordered table-condensed table-striped">								
				<thead>
					<tr>
						<th class="active">Resp.</th>
						<!--<th class="active">id</th>-->
						<th class="active">Emissor</th>
						<th class="active">Emp.Env</th>
						<th class="active">Pergunta</th>
						<th class="active">DtEnv</th>
						<th class="active">Emp.Rec</th>
						<!--<th class="active">Recptor</th>-->
						<th class="active">Resposta</th>
						<th class="active">DtRes</th>
					</tr>
				</thead>
				<tbody>

					<?php
					foreach ($report->result_array() as $row) {

						echo '<tr class="clickable-row" data-href="' . base_url() . 'orcatrata/alterarprocedempresa/' . $row['idSis_Empresa'] . '">';

							echo '<td>' . $row['ConcluidoProcedimento'] . '</td>';
							#echo '<td>' . $row['idApp_Procedimento'] . '</td>';
							echo '<td>' . $row['NomeCli'] . '</td>';
							echo '<td>' . $row['NomeEmpresaCli'] . '</td>';
							echo '<td>' . $row['ProcedimentoCli'] . '</td>';
							echo '<td>' . $row['DataProcedimentoCli'] . '</td>';
							echo '<td>' . $row['NomeEmpresa'] . '</td>';
							#echo '<td>' . $row['Nome'] . '</td>';
							echo '<td>' . $row['Procedimento'] . '</td>';
							echo '<td>' . $row['DataProcedimento'] . '</td>';

						echo '</tr>';
					}
					?>
				</tbody>
			</table>
			<?php } ?>
		</div>
	</div>
</div>