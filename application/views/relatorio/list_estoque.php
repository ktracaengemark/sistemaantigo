<div class="container-fluid">
    <div class="row">

        <div>
            <table class="table table-bordered table-condensed table-striped">
				
                <thead>
                    <tr>
						<th class="active text-left">Categoria</th>
						<th class="active text-left">Produto</th>
						<th class="active text-left">Aux1</th>
						<th class="active text-left">Aux2</th>
                        <th class="active text-center">QTD COMPRA</th>
						<th class="active text-center">QTD VENDIDA</th>						
                        <!--<th class="active text-center">QTD ENTREGUE</th>-->
						<th class="active text-center">QTD DEV.COMPRA</th>						
						<th class="active text-center">QTD DEV.VENDA</th>
                        <th class="active text-center">QTD CONSUMO</th>
						<th class="active text-center">QTD ESTOQUE</th>
                    </tr>
                </thead>
				<!--
				<thead>
                    <tr>
						<th colspan="2" class="active"></th>
						<th colspan="2" class="active">Total de Produtos:</th>
						<th colspan="1" class="active"><?php echo $report->soma->somaqtdcompra ?></th>
						<th colspan="1" class="active"><?php echo $report->soma->somaqtdvendida ?></th>						
						<th colspan="1" class="active"><?php echo $report->soma->somaqtdvenda ?></th>
						<th colspan="1" class="active"><?php echo $report->soma->somaqtddevolve2 ?></th>						
						<th colspan="1" class="active"><?php echo $report->soma->somaqtddevolve ?></th>
						<th colspan="1" class="active"><?php echo $report->soma->somaqtdconsumo ?></th>
						<th colspan="1" class="active"><?php echo $report->soma->somaqtdestoque ?></th>
                    </tr>
                </thead>
				-->
                <tbody>

                    <?php

                    foreach ($report as $row) {
                    #for($i=0;$i<count($report);$i++) {

                        if(isset($row->Produtos)) {
                        echo '<tr>';
							echo '<td>' . $row->Prodaux3 . '</td>';
							echo '<td>' . $row->Produtos . '</td>';
							echo '<td>' . $row->Prodaux1 . '</td>';
							echo '<td>' . $row->Prodaux2 . '</td>';
							echo '<td>' . $row->QtdCompra . '</td>';
							#echo '<td>' . $row->QtdVendida . '</td>';							
							echo '<td>' . $row->Qtd . '</td>';
							echo '<td>' . $row->QtdDevolve2 . '</td>';							
							echo '<td>' . $row->QtdDevolve . '</td>';
                            echo '<td>' . $row->QtdConsumo . '</td>';
							echo '<td>' . $row->QtdEstoque . '</td>';
                        echo '</tr>';
                        }
                    }
                    ?>

                </tbody>
				<tfoot>
                    <tr>
						<th colspan="2" class="active"></th>
						<th colspan="2" class="active text-right">Total de Produtos:</th>
						<th colspan="1" class="active"><?php echo $report->soma->somaqtdcompra ?></th>
						<!--<th colspan="1" class="active"><?php echo $report->soma->somaqtdvendida ?></th>-->			
						<th colspan="1" class="active"><?php echo $report->soma->somaqtdvenda ?></th>
						<th colspan="1" class="active"><?php echo $report->soma->somaqtddevolve2 ?></th>						
						<th colspan="1" class="active"><?php echo $report->soma->somaqtddevolve ?></th>
						<th colspan="1" class="active"><?php echo $report->soma->somaqtdconsumo ?></th>
						<th colspan="1" class="active"><?php echo $report->soma->somaqtdestoque ?></th>
                    </tr>
                </tfoot>

            </table>

        </div>

    </div>

</div>
