<?php if (isset($msg)) echo $msg; ?>

<?php echo validation_errors(); ?>
<div class="col-md-1"></div>
<div class="col-md-10">	
	<nav class="navbar navbar-inverse navbar-fixed" role="banner">
	  <div class="container-fluid">
		<div class="navbar-header">
			<div class="btn-line " role="group" aria-label="...">	
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span> 
				</button>
				<a type="button" class="btn btn-md btn-default " href="javascript:window.print()">
					<span class="glyphicon glyphicon-print"></span>
				</a>
				
				<a type="button" class="btn btn-md btn-warning"  href="<?php echo base_url() . $imprimirlista . $_SESSION['log']['idSis_Empresa']; ?>">
					<span class="glyphicon glyphicon-pencil"></span> Vers�o Lista
				</a>
				
			</div>
		</div>
	  </div>
	</nav>	
	<?php if( isset($count['POCount']) ) { ?>	
		<?php for ($i=1; $i <= $count['POCount']; $i++) { ?>
			<div style="overflow: auto; height: auto; ">
				<table class="table table-bordered table-condensed table-striped">
					<thead>
						<tr>
							<td class="col-md-3 text-left" scope="col"><?php echo ''  . $titulo . ': <strong>' . $procedimento[$i]['idApp_Procedimento'] . '</strong> - '
																				. 'Tipo: <strong>'  . $procedimento[$i][$titulo] . '</strong>'
																				. '<br>Cliente: <strong>' . $procedimento[$i]['NomeCliente'] . '</strong> - ' . $procedimento[$i]['idApp_Cliente'] . ''
																			?></td>
							<td class="col-md-3 text-left" scope="col"><?php echo '<strong>Relato:</strong> ' . $procedimento[$i]['Procedimento'] . ''
																		?></td>
							<td class="col-md-1 text-center" scope="col"><?php echo 'Data: <strong>'  . $procedimento[$i]['DataProcedimento'] . '</strong>'
																				. '<br>Hora: <strong>'  . $procedimento[$i]['HoraProcedimento'] . '</strong>'
																				. '<br><br>cont: <strong>'  . $i . '/' . $count['POCount'] . '</strong>'
																			?></td>
						</tr>
					</thead>
					<thead>
						<tr>
							<th class="col-md-3" scope="col">A��es</th>
							<th class="col-md-3" scope="col">Data - Hora</th>
							<th class="col-md-1" scope="col">Concl?</th>										
						</tr>
					</thead>
					<tbody>
					
					<?php for ($j=1; $j <= $count['PMCount']; $j++) { ?>
						<?php 
							if($procedimento[$i]['idApp_Procedimento'] == $subprocedimento[$j]['idApp_Procedimento']){
						?>
							<tr>
								<td class="col-md-3" scope="col"><?php echo $subprocedimento[$j]['SubProcedimento'] ?></td>
								<td class="col-md-3" scope="col"><?php echo $subprocedimento[$j]['DataSubProcedimento'] ?> - <?php echo $subprocedimento[$j]['HoraSubProcedimento'] ?></td>
								<td class="col-md-1" scope="col"><?php echo $subprocedimento[$j]['ConcluidoSubProcedimento'] ?></td>									
								
							</tr>
						<?php 
						}
						?>
					<?php } ?>
					</tbody>					
				</table>
			</div>
		<?php } ?>
	<?php } else echo '<h3 class="text-center">Nenhum Or�amento Filtrado!</h3>';{?>
	<?php } ?>		

</div>	