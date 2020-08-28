<br>

<table class="table table-hover">
    <thead>
        <tr>
            <th colspan="3">Total encontrado: <?php echo $query->num_rows(); ?> resultado(s)</th>
        </tr>
    </thead>	
    <thead>
        <tr>
            <th>id</th>
			<th>Cliente</th>
            <th>Ficha</th>
            <th>Telefone</th>
        </tr>
    </thead>
    <tbody>
        <?php

        foreach ($query->result_array() as $row) {
            
            if (isset($_SESSION['agenda']))
                $url = base_url() . 'consulta/cadastrar/' . $row['idApp_Cliente'];
            else
                $url = base_url() . 'cliente/prontuario/' . $row['idApp_Cliente'];
                    
            echo '<tr class="clickable-row" data-href="' . $url . '">';
                echo '<td>' . $row['idApp_Cliente'] . '</td>';
				echo '<td>' . $row['NomeCliente'] . '</td>';
				echo '<td>' . $row['RegistroFicha'] . '</td>';
                #echo '<td>' . $row['DataNascimento'] . '</td>';
                echo '<td>' . $row['CelularCliente'] . ' / ' . $row['Telefone'] . ' / ' . $row['Telefone2'] . ' / ' . $row['Telefone3'] . '</td>';
            echo '</tr>';            
        }
        ?>

    </tbody>
    <tfoot>
        <tr>
            <th colspan="3">Total encontrado: <?php echo $query->num_rows(); ?> resultado(s)</th>
        </tr>
    </tfoot>
</table>



