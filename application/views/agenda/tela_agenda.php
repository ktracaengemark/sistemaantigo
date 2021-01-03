<?php if (isset($msg)) echo $msg; ?>

<div id="fluxo" class="modal bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="fluxo" aria-hidden="true">
	<div class="vertical-alignment-helper">
		<div class="modal-dialog modal-sm vertical-align-center">
			<div class="modal-content">
				<div class="modal-body text-center">
					<div class="form-group">
						<div class="row">
							<div class="col-md-12 col-lg-12">
								<label for="">Agendamento:</label>
								<div class="form-group">
									<?php if ($_SESSION['log']['idSis_Empresa'] != 5 ) { ?>				
									<div class="row">
										<button type="button" id="MarcarConsulta" onclick="redirecionar(2)" class="btn btn-primary"> Com Cliente
										</button>
									</div>
									<?php } ?>
									<br>
									<div class="row">
										<button type="button" id="AgendarEvento" onclick="redirecionar(1)" class="btn btn-info"> Outro Evento
										</button>
									</div>
										<input type="hidden" id="start" />
										<input type="hidden" id="end" />
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="col-md-1"></div>
<div class="col-md-10">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<?php echo form_open('agenda', 'role="form"'); ?>		
			<?php if ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['log']['Permissao'] <= 2 ) { ?>	
				
			<div class="col-md-6 text-left">
				<label class="sr-only" for="Ordenamento">Agenda dos Prof.:</label>
				<select data-placeholder="Selecione uma opção..." class="form-control Chosen" onchange="this.form.submit()"
						id="NomeUsuario" name="NomeUsuario">
					<?php
					foreach ($select['NomeUsuario'] as $key => $row) {
						if ($query['NomeUsuario'] == $key) {
							echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
						} else {
							echo '<option value="' . $key . '">' . $row . '</option>';
						}
					}
					?>
				</select>
			</div>	
			<?php } ?>
			<!--
			<div class=" btn btn-success" type="button" data-toggle="collapse" data-target="#Agenda" aria-expanded="false" aria-controls="Agenda">
				<span class="glyphicon glyphicon-chevron-up"></span> Agenda
			</div>
			-->
			<div class=" btn btn-info" type="button" data-toggle="collapse" data-target="#Calendario" aria-expanded="false" aria-controls="Calendario">
				<span class="glyphicon glyphicon-calendar"></span> Calendário
			</div>
			
		</div>
		<div <?php echo $collapse; ?> id="Agenda">
			<div class="panel-body">
				<div <?php echo $collapse1; ?> id="Calendario">
					<div class="row">
						<div class="col-md-4"></div>
						<div class="col-md-4 form-group text-center" id="datepickerinline" >
						</div>
						<div class="col-md-4"></div>
					</div>
				</div>	
				<div class="row">	
					<div class="col-md-12 form-group">
						<div  style="overflow:auto; height:auto; "> 
								<table id="calendar" class="table table-condensed table-striped "></table>
						</div>
					</div>
				</div>
			</div>
		</div>	
	</div>
</div>
<div class="col-md-1"></div>