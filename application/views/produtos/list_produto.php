<br>

<table class="table table-hover">
    <thead>
        <tr>
			<th>Produto base</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i=0;
		$cont=1;
        if ($q2) {

            foreach ($q2 as $row)
            {

                #$url = base_url() . 'produtos/alterar2/' . $row['idTab_Catprod'];
                $url = '';

                echo '<tr class="clickable-row" data-href="' . $url . '">';
					echo '<td>'. $cont . ') ' . $row['Produtos'] . '</td>';
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



