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
						<th class="active">id <?php echo $titulo1; ?></th>
						<?php if($query['TipoProcedimento'] == 3 || $query['TipoProcedimento'] == 4) { ?>
							<th class="active">Tipo <?php echo $titulo1; ?></th>
						<?php } ?>
						<th class="active">id <?php echo $nome; ?></th>
                        <th class="active"><?php echo $nome; ?></th>
                        <th class="active">Quem_Cadastrou</th>
						<?php if($query['TipoProcedimento'] == 3) { ?>
							<th class="active">Quem_Fazer</th>
						<?php } ?>	
						<?php if($query['TipoProcedimento'] != 4) { ?>
							<?php if($query['TipoProcedimento'] == 1 || $query['TipoProcedimento'] == 2) { ?>
								<th class="active">Procedimrnto</th>
							<?php }elseif($query['TipoProcedimento'] == 3) { ?>	
								<th class="active">Solicitação</th>
							<?php } ?>
						<?php } ?>
						<th class="active">Data</th>
						<th class="active">Hora</th>
						<th class="active">Concluída?</th>
						<?php if($query['TipoProcedimento'] == 3 || $query['TipoProcedimento'] == 4) { ?>
							<th class="active">Ação</th>
							<th class="active">Data</th>
							<th class="active">Hora</th>
							<th class="active">Concluída?</th>
						<?php } ?>	
                    </tr>
                </thead>

				<tbody>

                    <?php
                    foreach ($report->result_array() as $row) {

                        echo '<tr>';
							//echo '<tr class="clickable-row" data-href="' . base_url() . 'procedimento/alterar/' . $row['idApp_Procedimento'] . '">';
							if($query['TipoProcedimento'] == 1 || $query['TipoProcedimento'] == 2) {
								if(isset($row['idApp_OrcaTrata']) && $row['idApp_OrcaTrata'] != 0){
									if($nome == "Cliente"){
										if(isset($row['idApp_' . $nome]) && $row['idApp_' . $nome] != 0){
											echo '<td class="notclickable">
													<a class="btn btn-md btn-warning notclickable" href="' . base_url() . 'orcatrata/alterarstatus/' . $row['idApp_OrcaTrata'] . '">
														 ' . $row['idApp_OrcaTrata'] . '
													</a>
												</td>';
										}else{	
											echo '<td class="notclickable">
													<a class="btn btn-md btn-warning notclickable" href="' . base_url() . 'orcatrata/alterarstatus/' . $row['idApp_OrcaTrata'] . '">
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
							}elseif($query['TipoProcedimento'] == 3 || $query['TipoProcedimento'] == 4) {
								if($query['TipoProcedimento'] == 3){
									echo '<td class="notclickable">
											<a class="btn btn-md btn-' . $panel . ' notclickable" href="' . base_url() . 'procedimento/alterarproc/' . $row['idApp_Procedimento'] . '">
												 ' . $row['idApp_Procedimento'] . '
											</a>
										</td>';
								}elseif($query['TipoProcedimento'] == 4){
									echo '<td class="notclickable">
											<a class="btn btn-md btn-' . $panel . ' notclickable" href="' . base_url() . 'procedimento/alterarcampanha/' . $row['idApp_Procedimento'] . '">
												 ' . $row['idApp_Procedimento'] . '
											</a>
										</td>';
								}
							}
							if($query['TipoProcedimento'] == 3 || $query['TipoProcedimento'] == 4) {
								echo '<td>' . $row[$titulo1] . '</td>';
							}
         
		 /*
			  //echo $this->db->last_query();
		  echo "<br>";
          echo "<pre>";
          print_r($row['idApp_' . $nome]);
          echo "</pre>";
          exit();
	 		*/					
							if($nome == "Cliente"){	
								if(isset($row['idApp_' . $nome]) && $row['idApp_' . $nome] != 0){	
									if(isset($row['idApp_OrcaTrata']) && $row['idApp_OrcaTrata'] != 0){
										echo '<td class="notclickable">
												<a class="btn btn-md btn-info notclickable" href="' . base_url() . 'orcatrata/listar/' . $row['idApp_' . $nome] . '">
													 ' . $row['idApp_' . $nome] . '
												</a>
											</td>';
									}else{
										if($query['TipoProcedimento'] == 3){
											echo '<td class="notclickable">
													<a class="btn btn-md btn-info notclickable" href="' . base_url() . 'procedimento/listarproc/' . $row['idApp_' . $nome] . '">
														 ' . $row['idApp_' . $nome] . '
													</a>
												</td>';
										}elseif($query['TipoProcedimento'] == 4){	
											echo '<td class="notclickable">
													<a class="btn btn-md btn-info notclickable" href="' . base_url() . 'procedimento/listarcampanha/' . $row['idApp_' . $nome] . '">
														 ' . $row['idApp_' . $nome] . '
													</a>
												</td>';
										}		
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
                            echo '<td>' . $row['NomeUsuario'] . '</td>';
							if($query['TipoProcedimento'] == 3){	
								echo '<td>' . $row['NomeCompartilhar'] . '</td>';
							}	
							/*
							echo '<td class="notclickable">
									<a class="btn btn-md btn-info notclickable" href="' . base_url() . 'procedimento/alterar/' . $row['idApp_Procedimento'] . '">
										 ' . $row['idApp_Procedimento'] . '
									</a>
								</td>';
								*/
                            #echo '<td>' . $row['idApp_Procedimento'] . '</td>';
							if($query['TipoProcedimento'] != 4){
								echo '<td>' . $row['Procedimento'] . '</td>';
							}
							echo '<td>' . $row['DataProcedimento'] . '</td>';
							echo '<td>' . $row['HoraProcedimento'] . '</td>';							
							echo '<td>' . $row['ConcluidoProcedimento'] . '</td>';
							if($query['TipoProcedimento'] == 3 || $query['TipoProcedimento'] == 4) {
								echo '<td>' . $row['SubProcedimento'] . '</td>';
								echo '<td>' . $row['DataSubProcedimento'] . '</td>';
								echo '<td>' . $row['HoraSubProcedimento'] . '</td>';							
								echo '<td>' . $row['ConcluidoSubProcedimento'] . '</td>';
							}

                        echo '</tr>';
                    }
                    ?>

                </tbody>

            </table>

        </div>

    </div>

</div>
