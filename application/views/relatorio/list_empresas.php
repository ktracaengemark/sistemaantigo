<div class="container-fluid">
    <div class="row">

        <div>
			<table class="table table-bordered table-condensed table-striped">	
				<tfoot>
                    <tr>
                        <th colspan="9" class="active">Total encontrado: <?php echo $report->num_rows(); ?> resultado(s)</th>
                    </tr>
                </tfoot>
			</table>
            <table class="table table-bordered table-condensed table-striped">

                <thead>
                    <tr>
                        <th class="active">N�</th>
                        <th class="active">Empresa</th>
						<th class="active">Site</th>

                    </tr>
                </thead>

                <tbody>

                    <?php
                    foreach ($report->result_array() as $row) {

                        #echo '<tr>';
                        #echo '<tr class="clickable-row" data-href="' . base_url() . 'empresa/prontuario/' . $row['idSis_Empresa'] . '">';
								
						echo '<tr class="clickable-row" data-href="https://www.ktracaengenharia.com.br/' . $row['Site'] . '">';	
							echo '<td>' . $row['idSis_Empresa'] . '</td>';
							echo '<td>' . $row['NomeEmpresa'] . '</td>';
                            echo '<td>' . $row['Site'] . '</td>';

                        echo '</tr>';
                    }
                    ?>

                </tbody>

            </table>

        </div>

    </div>

</div>
