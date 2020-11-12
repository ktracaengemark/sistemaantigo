	
	<div class="container-fluid">
		

			<div>
				<table class="table table-bordered table-condensed table-striped">	
					<tfoot>
						<tr>
							<th colspan="3" class="active">Total encontrado: <?php echo $report->num_rows(); ?> resultado(s)</th>
						</tr>
					</tfoot>
				</table>
				<?php if (($_SESSION['log']['NivelEmpresa'] >= 4) AND ($_SESSION['log']['NivelEmpresa'] <= 10) ) { ?>
				<table class="table table-bordered table-condensed table-striped">

					<thead>
						<tr>                       																	
							<!--<th class="active">Id.Imagem</th>-->
							<th class="active" scope="col">Imagem</th>
							<th class="active" scope="col">Editar</th>
							<!--<th class="active">Id.P</th>-->
							<th class="active">Id</th>
							<th class="active">Venda</th>
							<th class="active">Tipo</th>
							<th class="active">Categoria</th>
							<th class="active">Modelo</th>
							<!--<th class="active">Cor/Sabor</th>
							<th class="active">Tamanho</th>-->
						</tr>
					</thead>

					<tbody>
						<?php
						foreach ($report->result_array() as $row) {?>

					<!--<tr class="clickable-row" data-href="<?php echo base_url() . 'produtos/alterarlogo/' . $row['idTab_Produto'] . ''; ?>">-->
					<tr>	
						<!--<td><?php echo $row['idTab_Prodaux2'] ?></td>-->
						
						<td class="notclickable">
							<a class="notclickable" href="<?php echo base_url() . 'produtos/alterarlogo/' . $row['idTab_Produto'] . ''; ?>">
								<img  alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/' . $row['Arquivo'] . ''; ?> "class="img-circle img-responsive" width='50'>
							</a>
						</td>
						
						<td class="notclickable">
							<a class="btn btn-md btn-info notclickable" href="<?php echo base_url() . 'produtos/alterar3/' . $row['idTab_Produto'] . ''; ?>">
								<span class="glyphicon glyphicon-edit notclickable"></span>
							</a>
						</td>						
						<!--<td><img  alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/' . $row['Arquivo'] . ''; ?> "class="img-circle img-responsive" width='100'></td>-->
						<!--<td><?php echo $row['idTab_Produtos'] ?></td>-->
						<td><?php echo $row['idTab_Produto'] ?></td>
						<td><?php echo $row['TipoProduto'] ?></td>
						<td><?php echo $row['Prod_Serv'] ?></td>
						<td><?php echo $row['Catprod'] ?></td>
						<td><?php echo $row['Produtos'] ?></td>
						<!--<td><?php echo $row['Nome_Cor_Prod'] ?></td>
						<td><?php echo $row['Nome_Tam_Prod'] ?></td>-->
						<?php } ?>						
					</tbody>

				</table>
				<?php } ?>				
			</div>

	</div>

