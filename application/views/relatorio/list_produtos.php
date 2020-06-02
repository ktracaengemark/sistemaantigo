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
				<?php if ($_SESSION['log']['NivelEmpresa'] <= 3 ) { ?>
				<table class="table table-bordered table-condensed table-striped">

					<thead>
						<tr>                       																	
							<!--<th class="active">Id.</th>-->
							<th class="active">Cod.</th>
							<th class="active">Produto</th>
							<th class="active">Valor</th>																																
						</tr>
					</thead>

					<tbody>
						
						<?php
						foreach ($report->result_array() as $row) {

							#echo '<tr>';
							echo '<tr class="clickable-row" data-href="' . base_url() . 'produtos/alterar/' . $row['idTab_Produto'] . '">';
								#echo '<td>' . $row['idTab_Produto'] . '</td>';
								echo '<td>' . $row['CodProd'] . '</td>';
								echo '<td>' . $row['Produtos'] . '</td>';
								echo '<td>' . $row['ValorProduto'] . '</td>';	
							echo '</tr>';
						}
						?>
						
					</tbody>

				</table>
				<?php } ?>
				<!--
				<?php if (($_SESSION['log']['NivelEmpresa'] >= 4) AND ($_SESSION['log']['NivelEmpresa'] <= 7) ) { ?>
				<table class="table table-bordered table-condensed table-striped">
					<thead>
						<tr>                       																	
							<th class="active" scope="col">Foto</th>
							<th class="active">Id.</th>
							<th class="active">Cod.</th>
							<th class="active">Categoria</th>							
							<th class="active">Tipo</th>
							<th class="active">Esp</th>
							<th class="active">Produto</th>
							<th class="active">Unid.</th>
							<th class="active">Ativo</th>
							<th class="active">Comissão</th>
							<th class="active">Valor Site</th>
							<th class="active">Valor Balcao</th>
							<th class="active">V/C/A</th>																																
						</tr>
					</thead>

					<tbody>
						
						<?php
						foreach ($report->result_array() as $row) {?>

						
					<tr class="clickable-row" data-href="<?php echo base_url() . 'produtos/alterar/' . $row['idTab_Produto'] . ''; ?>">
						<td><img  alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/' . $row['Arquivo'] . ''; ?> "class="img-circle img-responsive" width='100'></td>
						<td><?php echo $row['idTab_Produto'] ?></td>
						<td><?php echo $row['CodProd'] ?></td>
						<td><?php echo $row['Prodaux3'] ?></td>
						<td><?php echo $row['Prodaux2'] ?></td>
						<td><?php echo $row['Prodaux1'] ?></td>
						<td><?php echo $row['Produtos'] ?></td>
						<td><?php echo $row['UnidadeProduto'] ?></td>
						<td><?php echo $row['Ativo'] ?></td>
						<td><?php echo $row['VendaSite'] ?></td>
						<td><?php echo number_format($row['Comissao'], 2, ',','.') ?></td>
						<td><?php echo number_format($row['ValorProduto'], 2, ',','.') ?></td>
						<td><?php echo $row['TipoProduto'] ?></td>						
						<?php } ?>

					</tbody>

				</table>
				<?php } ?>
				-->
				<?php if (($_SESSION['log']['NivelEmpresa'] >= 4) AND ($_SESSION['log']['NivelEmpresa'] <= 10) ) { ?>
				<table class="table table-bordered table-condensed table-striped">

					<thead>
						<tr>                       																	
							<th class="active" scope="col">Foto</th>
							<th class="active" scope="col">Editar</th>
							<th class="active">Id.</th>
							<th class="active">Cod.</th>
							<th class="active">Categoria</th>
							<th class="active">Produto</th>
							<th class="active">Fornecedor</th>
							<th class="active">Descricao</th>
							<th class="active">Ativo</th>
							<th class="active">Vender no Site</th>
							<th class="active">Peso(kg)</th>
							<th class="active">Comissao(%)</th>
							<th class="active">Valor Balcao</th>
							<th class="active">V/C/A</th>
							<th class="active">Prod/Serv</th>
							<th class="active">Unid.</th>
							<th class="active">Aux1</th>
							<th class="active">Aux2</th>
							<!--<th class="active">Custo</th>-->						
							<!--<th class="active">Fornec.</th>-->
						</tr>
					</thead>

					<tbody>
						<?php
						foreach ($report->result_array() as $row) {?>

					<!--<tr class="clickable-row" data-href="<?php echo base_url() . 'produtos/alterarlogo/' . $row['idTab_Produto'] . ''; ?>">-->
					<tr>	
						<td class="notclickable">
							<a class="notclickable" href="<?php echo base_url() . 'produtos/alterarlogo/' . $row['idTab_Produto'] . ''; ?>">
								<img  alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/' . $row['Arquivo'] . ''; ?> "class="img-circle img-responsive" width='100'>
							</a>
						</td>
						<td class="notclickable">
							<a class="btn btn-md btn-info notclickable" href="<?php echo base_url() . 'produtos/alterar/' . $row['idTab_Produto'] . ''; ?>">
								<span class="glyphicon glyphicon-edit notclickable"></span>
							</a>
						</td>						
						<!--<td><img  alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/' . $row['Arquivo'] . ''; ?> "class="img-circle img-responsive" width='100'></td>-->
						<td><?php echo $row['idTab_Produto'] ?></td>
						<td><?php echo $row['CodProd'] ?></td>
						<td><?php echo $row['Prodaux3'] ?></td>
						<td><?php echo $row['Produtos'] ?></td>
						<td><?php echo $row['NomeFornecedor'] ?></td>
						<td><?php echo $row['Convdesc'] ?></td>
						<td><?php echo $row['Ativo'] ?></td>
						<td><?php echo $row['VendaSite'] ?></td>
						<td><?php echo number_format($row['PesoProduto'], 3, ',','.') ?></td>
						<td><?php echo number_format($row['Comissao'], 2, ',','.') ?></td>
						<td><?php echo number_format($row['ValorProduto'], 2, ',','.') ?></td>
						<td><?php echo $row['TipoProduto'] ?></td>
						<td><?php echo $row['Categoria'] ?></td>
						<td><?php echo $row['UnidadeProduto'] ?></td>
						<td><?php echo $row['Prodaux1'] ?></td>
						<td><?php echo $row['Prodaux2'] ?></td>					
						<?php } ?>						
					</tbody>

				</table>
				<?php } ?>				
			</div>

		

	</div>
</div>
