<div class="container-fluid">
    <div class="row">

        <div>
			<table class="table table-bordered table-condensed table-striped">	
				<tfoot>
                    <tr>
                        <th colspan="9" class="active">Total: <?php echo $report->num_rows(); ?> resultado(s)</th>
                    </tr>
                </tfoot>
			</table>	
            <table class="table table-bordered table-condensed table-striped">								
                <thead>
                    <tr>
                        <th class="active">id Orç.</th>
                        <th class="active">id <?php echo $nome; ?></th>
                        <th class="active"><?php echo $nome; ?></th>
                        <th class="active">Colaborador</th>
                        <th class="active">id Prc</th>
                        <th class="active">Procedimento</th>
						<th class="active">Data</th>
						<th class="active">Concluída?</th>
                    </tr>
                </thead>

				<tbody>

                    <?php
                    foreach ($report->result_array() as $row) {

                        echo '<tr>';
							//echo '<tr class="clickable-row" data-href="' . base_url() . 'procedimento/alterar/' . $row['idApp_Procedimento'] . '">';
							if(isset($row['idApp_OrcaTrata']) && $row['idApp_OrcaTrata'] != 0){
								if($nome == "Cliente"){
									if(isset($row['idApp_' . $nome]) && $row['idApp_' . $nome] != 0){
										echo '<td class="notclickable">
												<a class="btn btn-md btn-warning notclickable" href="' . base_url() . 'orcatrata/alterar/' . $row['idApp_OrcaTrata'] . '">
													 ' . $row['idApp_OrcaTrata'] . '
												</a>
											</td>';
									}else{	
										echo '<td class="notclickable">
												<a class="btn btn-md btn-warning notclickable" href="' . base_url() . 'statuspedido/alterarstatus/' . $row['idApp_OrcaTrata'] . '">
													 ' . $row['idApp_OrcaTrata'] . '
												</a>
											</td>';
									}
								}else{
									echo '<td class="notclickable">
											<a class="btn btn-md btn-warning notclickable" href="' . base_url() . 'orcatrata/alterardesp/' . $row['idApp_OrcaTrata'] . '">
												 ' . $row['idApp_OrcaTrata'] . '
											</a>
										</td>';
								}	
							}else{
								echo '<td class="notclickable">
										<a class="notclickable" >
											
										</a>
									</td>';
							}
							if($nome == "Cliente"){	
								if(isset($row['idApp_' . $nome]) && $row['idApp_' . $nome] != 0){	
									if(isset($row['idApp_OrcaTrata']) && $row['idApp_OrcaTrata'] != 0){
										echo '<td class="notclickable">
												<a class="btn btn-md btn-info notclickable" href="' . base_url() . 'orcatrata/alterar/' . $row['idApp_OrcaTrata'] . '">
													 ' . $row['idApp_' . $nome] . '
												</a>
											</td>';
									}else{			
										echo '<td class="notclickable">
												<a class="btn btn-md btn-info notclickable" href="' . base_url() . 'procedimento/alterarproc/' . $row['idApp_Procedimento'] . '">
													 ' . $row['idApp_' . $nome] . '
												</a>
											</td>';
									}	
								}else{
									echo '<td class="notclickable">
											<a class="notclickable" >
												
											</a>
										</td>';
								}
							}else{
								if(isset($row['idApp_' . $nome]) && $row['idApp_' . $nome] != 0){
									echo '<td class="notclickable">
											<a class="btn btn-md btn-warning notclickable" href="' . base_url() . 'orcatrata/alterardesp/' . $row['idApp_OrcaTrata'] . '">
												 ' . $row['idApp_' . $nome] . '
											</a>
										</td>';
								}else{
									echo '<td class="notclickable">
											<a class="notclickable" >
												
											</a>
										</td>';
								
								}		
							}	
                            echo '<td>' . $row['Nome' . $nome] . '</td>';
                            echo '<td>' . $row['Nome'] . '</td>';
							echo '<td class="notclickable">
									<a class="btn btn-md btn-info notclickable" href="' . base_url() . 'procedimento/alterar/' . $row['idApp_Procedimento'] . '">
										 ' . $row['idApp_Procedimento'] . '
									</a>
								</td>';
                            #echo '<td>' . $row['idApp_Procedimento'] . '</td>';
                            echo '<td>' . $row['Procedimento'] . '</td>';
							echo '<td>' . $row['DataProcedimento'] . '</td>';							
							echo '<td>' . $row['ConcluidoProcedimento'] . '</td>';

                        echo '</tr>';
                    }
                    ?>

                </tbody>

            </table>

        </div>

    </div>

</div>
