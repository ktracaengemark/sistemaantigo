<br>

<div class="text-center"><?php echo $pagination; ?></div>

<table class="table table-hover" data-toggle="table" data-search="false" data-search-align="right">
    <thead>

        <tr>
            <th colspan="6" class="text-center">Total encontrado: <?php echo $total_rows; ?></th>
        </tr>

        <tr>
            <th data-align="left" data-field="NomeCliente" data-align="right" data-searchable="true">Cliente</th>
			<th data-align="left" data-field="Telefone" data-align="right" data-searchable="true">Telefone</th>
            <th data-align="left" data-field="RegistroFicha" data-align="right" data-searchable="true">Ficha</th>
            <!--<th data-align="left" data-field="NumeroBe" data-align="right" data-searchable="true">BE</th>
            <th data-align="left" data-field="DataRegistroBe" data-align="right" data-searchable="true">Data Regristro BE</th>
            <th data-align="left" data-field="ArquivoPaginas" data-align="right" data-searchable="true">Páginas</th>-->
            <!--<th></th>-->
        </tr>
    </thead>
    <tbody>
        <?php

        define('FILEHREF', base_url() . 'arquivos/cliente/');
        foreach ($query->result_array() as $row) {

            $opt = 'class="clickable-row" data-href="' . base_url() . 'cliente/alterar/' . $row['idApp_Cliente'] . '"';
            echo '<tr>';
            echo '<td ' . $opt . '>' . $row['NomeCliente'] . '</td>';
			echo '<td ' . $opt . '>' . $row['Telefone'] . '</td>';
            echo '<td ' . $opt . '>' . $row['RegistroFicha'] . '</td>';
            #echo '<td ' . $opt . '>' . $row['NumeroBe'] . '</td>';
            #echo '<td ' . $opt . '>' . $row['DataRegistroBe'] . '</td>';
            #echo '<td ' . $opt . '>' . $row['ArquivoPaginas'] . '</td>';
           
            echo '</tr>';
        }

        ?>

    </tbody>
    <tfoot>
        <tr>
            <th colspan="6" class="text-center">Total encontrado: <?php echo $total_rows; ?></th>
        </tr>
    </tfoot>
</table>

<div class="text-center"><?php echo $pagination; ?></div>
