<br>

<div class="text-center"><?php echo $pagination; ?></div>

<table class="table table-hover" data-toggle="table" data-search="false" data-search-align="right">
    <thead>

        <tr>
            <th colspan="6" class="text-center">Total encontrado: <?php echo $total_rows; ?></th>
        </tr>

        <tr>
            <th data-align="left" data-field="NomePaciente" data-align="right" data-searchable="true">Paciente</th>
            <th data-align="left" data-field="DataNascimento" data-align="right" data-searchable="true">Nascimento</th>
            <th data-align="left" data-field="NumeroBe" data-align="right" data-searchable="true">BE</th>
            <th data-align="left" data-field="DataRegistroBe" data-align="right" data-searchable="true">Data Regristro BE</th>
            <th data-align="left" data-field="ArquivoPaginas" data-align="right" data-searchable="true">Páginas</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php

        define('FILEHREF', base_url() . 'arquivos/sisbedam/be/');
        foreach ($query->result_array() as $row) {

            $opt = 'class="clickable-row" data-href="' . base_url() . 'sisbedam/be/alterar/' . $row['idSisbedam_Be'] . '"';
            echo '<tr>';
            echo '<td ' . $opt . '>' . $row['NomePaciente'] . '</td>';
            echo '<td ' . $opt . '>' . $row['DataNascimento'] . '</td>';
            echo '<td ' . $opt . '>' . $row['NumeroBe'] . '</td>';
            echo '<td ' . $opt . '>' . $row['DataRegistroBe'] . '</td>';
            echo '<td ' . $opt . '>' . $row['ArquivoPaginas'] . '</td>';
            echo '<td>
                <a href="' . FILEHREF . $row['Arquivo'] . '" target="_blank" class="btn btn-sm btn-info">
                    <span class="glyphicon glyphicon-file"></span>
                </a>';
            if ($_SESSION['log']['nivel'] < 3) {
                echo ' <a href="' . base_url() . 'sisbedam/be/excluir/' . $row['idSisbedam_Be'] . '" class="btn btn-sm btn-danger">
                    <span class="glyphicon glyphicon-trash"></span>
                </a>';
            }
            echo '</td>';
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
