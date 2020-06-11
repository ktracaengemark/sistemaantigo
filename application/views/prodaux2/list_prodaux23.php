<br>

<table class="table table-hover">
    <thead>
        <tr>
            <th>Imagem</th>
			<th>Editar</th>
			<!--<th>Id</th>-->
			<th>Modelo</th>            
			<th>Tipo/Cor/Sabor</th>
			<!--<th>Abrev</th>-->
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i=0;
        if ($q) {

            foreach ($q as $row)
            {

                $url 	= 	base_url() . 'prodaux22/alterar3/' . $row['idTab_Prodaux2'];
				$url2 	=	base_url() . 'prodaux22/alterarlogo/' . $row['idTab_Prodaux2'];
				$url3 	= 	base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/' . $row['Arquivo'];
                
				#$url = '';

				#echo '<tr class="clickable-row" data-href="' . $url . '">';
				echo '<tr>';
					echo '<td class="notclickable">
								<a class="btn btn-md btn-info notclickable" href="' . $url2 . '">
									<img  alt="User Pic" src="' . $url3 . '" class="img-circle img-responsive" width="50">
								</a>
							</td>';					
					echo '<td class="notclickable">
								<a class="btn btn-md btn-info notclickable" href="' . $url . '">
									<span class="glyphicon glyphicon-edit notclickable"></span>
								</a>
							</td>';				
					#echo '<td>' . $row['idTab_Prodaux2'] . '</td>';
					echo '<td>' . $row['Prodaux4'] . '</td>';                    
					echo '<td>' . $row['Prodaux2'] . '</td>';
					#echo '<td>' . $row['Abrev2'] . '</td>';
                    #echo '<td></td>';

				echo '</tr>';            

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



