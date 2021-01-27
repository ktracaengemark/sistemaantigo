<br>

<table class="table table-hover">
    <thead>
        <tr>
			<th>Tipo</th>
			<th>Categoria</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i=0;
		$cont=1;
        if ($q1) {

            foreach ($q1 as $row)
            {

                #$url = base_url() . 'produtos/alterar2/' . $row['idTab_Catprod'];
                $url = '';

                echo '<tr class="clickable-row" data-href="' . $url . '">';
					echo '<td>' . $row['Prod_Serv'] . '</td>';
					echo '<td>'. $cont . ') ' . $row['Catprod'] . '</td>';
                    echo '<td></td>';
                echo '</tr>';            
				
				$cont++;
                $i++;
            }
            
        }
        ?>

    </tbody>
    <tfoot>
        <tr>
            <th colspan="3">Total encontrado: <?php echo $i; ?> resultado(s)</th>
        </tr>
    </tfoot>
</table>



