<div style="overflow: auto; height: 400px; ">
	<div class="container-fluid">
		<div class="row">

			<div>
				<table class="table table-bordered table-condensed table-striped">	
					<tfoot>
						<tr>
							<th colspan="4" class="active">Total encontrado: <?php echo $report->num_rows(); ?> resultado(s)</th>
						</tr>
					</tfoot>
				</table>
				<table class="table table-bordered table-condensed table-striped">

					<thead>
						<tr>
							<th class="col-md-2" scope="col">LogoMarca</th>
							<th class="active">Empresa</th>
							<th class="active">Nº</th>
							<th class="active">Categoria</th>
						</tr>
					</thead>
					
					<tbody>

						<?php
						foreach ($report->result_array() as $row) {
						?>

						<tr class="clickable-row" data-href="<?php echo base_url() . 'empresacli2/prontuario/' . $row['idSis_Empresa'] . ''; ?>">
							<td><img  alt="User Pic" src="<?php echo base_url() . 'arquivos/imagens/empresas/profile-' . $row['idSis_Empresa'] . '.png'; ?> "class="img-circle img-responsive"></td>
							<td><?php echo $row['NomeEmpresa'] ?></td>
							<td><?php echo $row['idSis_Empresa'] ?></td>
							<td><?php echo $row['CategoriaEmpresa'] ?></td>							
						</tr>						

						<?php
						}
						?>

					</tbody>

				</table>

			</div>

		</div>

	</div>
</div>