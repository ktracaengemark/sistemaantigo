<div style="overflow: auto; height: 550px; ">	
	<div class="container-fluid">
		

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
							<th class="active" scope="col">Foto</th>
							<th class="active" scope="col">Editar</th>
							<th class="active">Ativo</th>
							<th class="active">IdProm.</th>
							<th class="active">Tipo</th>
							<th class="active">Promocao</th>
							<th class="active">IdProd.</th>
							<th class="active">Qtd.</th>
							<th class="active">Produto</th>
							<th class="active">Valor</th>
						</tr>
					</thead>

					<tbody>
						<?php
						foreach ($report->result_array() as $row) {?>

					<!--<tr class="clickable-row" data-href="<?php echo base_url() . 'promocao/alterarlogo/' . $row['idTab_Promocao'] . ''; ?>">-->
						<tr>	
							<td class="notclickable">
								<a class="notclickable" href="<?php echo base_url() . 'promocao/alterarlogo/' . $row['idTab_Promocao'] . ''; ?>">
									<img  alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/' . $row['Arquivo'] . ''; ?> "class="img-circle img-responsive" width='100'>
								</a>
							</td>
							<td class="notclickable">
								<a class="btn btn-md btn-info notclickable" href="<?php echo base_url() . 'promocao/alterar/' . $row['idTab_Promocao'] . ''; ?>">
									<span class="glyphicon glyphicon-edit notclickable"></span>
								</a>
							</td>						
							<!--<td><img  alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/' . $row['Arquivo'] . ''; ?> "class="img-circle img-responsive" width='100'></td>-->
							<td><?php echo $row['Ativo'] ?></td>
							<td><?php echo $row['idTab_Promocao'] ?></td>
							<td><?php echo $row['Desconto'] ?></td>
							<td><?php echo $row['Promocao'] ?></td>
							<td><?php echo $row['Item_Promocao'] ?></td>
							<td><?php echo $row['QtdProdutoDesconto'] ?></td>
							<td><?php echo $row['Produtos'] ?></td>
							<td><?php echo number_format($row['ValorProduto'], 2, ',','.') ?></td>
						</tr>
						<?php } ?>						
					</tbody>

				</table>
								
			</div>

		

	</div>
</div>
