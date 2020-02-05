<div style="overflow: auto; height: 550px; ">	
	<div class="container-fluid">
		<div class="row">
			<div>
				<table class="table table-bordered table-condensed table-striped">	
					<tfoot>
						<tr>
							<th colspan="9" class="active">Total encontrado: <?php echo $report->num_rows(); ?> resultado(s)</th>
						</tr>
					</tfoot>
				</table>	
				<table class="table table-bordered table-condensed table-striped">								
					<thead>
						<tr>
							<th class=" col-md-1" scope="col">Foto</th>
							<th class="active">id</th>
							<th class="active">Cliente</th>
							<th class="active">Sexo</th>
							<th class="active">Celular</th>
							<th class="active">Telefone2</th>
							<th class="active">Telefone3</th>
							<th class="active">Nascimento</th>
							<th class="active">Endere�o</th>
							<th class="active">Bairro</th>
							<th class="active">Munic�pio</th>
							<th class="active">E-mail</th>
							<th class="active">Ativo?</th>
						</tr>
					</thead>

					<tbody>

					<?php
					foreach ($report->result_array() as $row) {
					?>
					<tr class="clickable-row" data-href="<?php echo base_url() . 'cliente2/alterar3/' . $row['idApp_Cliente'] . ''; ?>">
						<td><img  alt="User Pic" src="<?php echo base_url() . 'arquivos/imagens/empresas/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/' . $row['Arquivo'] . ''; ?> "class="img-circle img-responsive" width='100'></td>
						<td><?php echo $row['idApp_Cliente'] ?></td>
						<td><?php echo $row['NomeCliente'] ?></td>
						<td><?php echo $row['Sexo'] ?></td>
						<td><?php echo $row['CelularCliente'] ?></td>
						<td><?php echo $row['Telefone2'] ?></td>
						<td><?php echo $row['Telefone3'] ?></td>
						<td><?php echo $row['DataNascimento'] ?></td>
						<td><?php echo $row['Endereco'] ?></td>
						<td><?php echo $row['Bairro'] ?></td>
						<td><?php echo $row['Municipio'] ?></td>
						<td><?php echo $row['Email'] ?></td>
						<td><?php echo $row['Ativo'] ?></td>
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