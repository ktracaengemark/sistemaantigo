<!--
<div class="panel panel-default">
    <div class="panel-body">

		<div class="col-md-1"></div>
        <div class="col-md-3">
            <label for="DataFim">Total em Produtos:</label>
            <div class="input-group">
                <span class="input-group-addon">R$</span>
                <input type="text" class="form-control" disabled aria-label="Total Orcamentos" value="<?php echo $report->soma->somaorcamento ?>">
            </div>
        </div>
		
		<div class="col-md-3">
            <label for="DataFim">Total em Comissao:</label>
            <div class="input-group">
                <span class="input-group-addon">R$</span>
                <input type="text" class="form-control" disabled aria-label="Total Comissao" value="<?php echo $report->soma->somacomissao ?>">
            </div>
        </div>
		
		<div class="col-md-3">
            <label for="DataFim">Total A Receber:</label>
            <div class="input-group">
                <span class="input-group-addon">R$</span>
                <input type="text" class="form-control" disabled aria-label="Total Restante" value="<?php echo $report->soma->somarestante ?>">
            </div>
        </div>
		
		<div class="col-md-1"></div>
    </div>
</div>
-->
<div class="container-fluid">
    <div class="row">
        <div>
			<!--
			<table class="table table-bordered table-condensed table-striped">
				<tfoot>
                    <tr>
                        <th colspan="3" class="active">Total encontrado: <?php echo $report->num_rows(); ?> resultado(s)</th>
                    </tr>
                </tfoot>
			</table>
			-->
            <table class="table table-bordered table-condensed table-striped">
				<thead>
                    <tr>
                        <th colspan="10" class="active">Total encontrado: <?php echo $report->num_rows(); ?> resultado(s)</th>
                    </tr>
                </thead>                
				<thead>
                    <tr>

						
						<th class="active">Orç.</th>
                        <th class="active">Empresa</th>
						<th class="active">Cliente</th>
						<!--<th class="active">Valid. do Orçam.</th>
						<th class="active">Prazo de Entrega</th>-->
						<th class="active">Valor/Produtos</th>
						<th class="active">Valor/Comissao</th>
						<th class="active">Apv.?</th>
						<th class="active">Forma</th>
                        <th class="active">Dt. Orç.</th>
                        <th class="active">Dt. Venc.</th>
                        <th class="active"></th>
                    </tr>
                </thead>
				<tbody>
                    <?php
                    foreach ($report->result_array() as $row) {
                        #echo '<tr>';
                        echo '<tr class="clickable-row" data-href="' . base_url() . 'orcatrata/alteraronline/' . $row['idApp_OrcaTrata'] . '">';

                            #echo '<div class="clickable-row" data-href="' . base_url() . 'orcatrata/alterar/' . $row['idApp_OrcaTrata'] . '">';
							
							echo '<td>' . $row['idApp_OrcaTrata'] . '</td>';
                            echo '<td>' . $row['NomeEmpresa'] . '</td>';
							echo '<td>' . $row['NomeCliente'] . '</td>';
							#echo '<td>' . $row['DataEntradaOrca'] . '</td>';
							#echo '<td>' . $row['DataPrazo'] . '</td>';
							echo '<td class="text-left">R$ ' . $row['ValorRestanteOrca'] . '</td>';
							echo '<td class="text-left">R$ ' . $row['ValorComissao'] . '</td>';
							echo '<td>' . $row['AprovadoOrca'] . '</td>';
                            echo '<td>' . $row['FormaPag'] . '</td>';
                            echo '<td>' . $row['DataOrca'] . '</td>';
							echo '<td>' . $row['DataVencimentoOrca'] . '</td>';
                            #echo '</div>';
							echo '<td class="notclickable">
                                    <a class="btn btn-md btn-info notclickable" target="_blank" href="' . base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_OrcaTrata'] . '">
                                        <span class="glyphicon glyphicon-print notclickable"></span>
                                    </a>
                                </td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
				<tfoot>
                    <tr>
						<th colspan="3" class="active text-right">Totais</th>
						<th colspan="1" class="active">R$ <?php echo $report->soma->somaorcamento ?></th>
						<th colspan="1" class="active">R$ <?php echo $report->soma->somacomissao ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
