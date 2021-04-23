<?php if (isset($msg)) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Usuario'])) { ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-offset-2 col-md-8">
		<?php echo form_open_multipart($form_open_path); ?>
			<div class="panel panel-primary">
				<?php if ( !isset($evento) && isset($_SESSION['Empresa'])) { ?>
				<div class="panel-heading">
					<div class="btn-group">
						<button type="button" class="btn btn-sm btn-default  dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-file"></span> <?php echo '<small>' . $_SESSION['Empresa']['NomeEmpresa'] . '</small> - <small>Id.: ' . $_SESSION['Empresa']['idSis_Empresa'] . '</small>' ?> <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li>
								<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
									<a href="<?php echo base_url() . 'empresa/prontuario/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
										<span class="glyphicon glyphicon-file"> </span>Ver Dados da Empresa
									</a>
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<li>
								<a <?php if (preg_match("/empresa\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
									<a href="<?php echo base_url() . 'empresa/alterar/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Editar Dados da Empresa
									</a>
								</a>
							</li>
						</ul>
					</div>
				</div>
				<?php } ?>
				<div class="panel-body">
					
					<div class="row">
							
						<div class="col-md-12">	
							<?php #echo validation_errors(); ?>

							<div class="panel panel-<?php echo $panel; ?>">

								<div class="panel-heading">
									<div class="btn-group">
										<button type="button" class="btn btn-sm btn-default  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-file"></span> <?php echo '<small>' . $_SESSION['Usuario']['Nome'] . '</small> - <small>Id.: ' . $_SESSION['Usuario']['idSis_Usuario'] . '</small>' ?> <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/usuario\/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
													<a href="<?php echo base_url() . 'usuario/prontuario/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
														<span class="glyphicon glyphicon-file"> </span> Ver Dados do Usuário
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/usuario\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
													<a href="<?php echo base_url() . 'usuario/alterar/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
														<span class="glyphicon glyphicon-edit"></span> Editar Dados do Usuário
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/usuario\/alterar2\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
													<a href="<?php echo base_url() . 'usuario/alterar2/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
														<span class="glyphicon glyphicon-edit"></span> Alterar Senha do Usuário
													</a>
												</a>
											</li>											
										</ul>
									</div>
								</div>
								<div class="panel-body">
									<div class="panel panel-info">
										<div class="panel-heading">
											<h4>Serviços</h4>
											<div class="row">
												<div class="col-md-3">
													<label for="Agenda">Agenda?</label><br>
													<div class="form-group">
														<div class="btn-group" data-toggle="buttons">
															<?php
															foreach ($select['Agenda'] as $key => $row) {
																(!$query['Agenda']) ? $query['Agenda'] = 'N' : FALSE;

																if ($query['Agenda'] == $key) {
																	echo ''
																	. '<label class="btn btn-warning active" name="radiobutton_Agenda" id="radiobutton_Agenda' . $key . '">'
																	. '<input type="radio" name="Agenda" id="radiobutton" '
																	. 'autocomplete="off" value="' . $key . '" checked>' . $row
																	. '</label>'
																	;
																} else {
																	echo ''
																	. '<label class="btn btn-default" name="radiobutton_Agenda" id="radiobutton_Agenda' . $key . '">'
																	. '<input type="radio" name="Agenda" id="radiobutton" '
																	. 'autocomplete="off" value="' . $key . '" >' . $row
																	. '</label>'
																	;
																}
															}
															?>
														</div>
													</div>
												</div>
												<div class="col-md-3">
													<label for="Vendas">Vendas?</label><br>
													<div class="form-group">
														<div class="btn-group" data-toggle="buttons">
															<?php
															foreach ($select['Vendas'] as $key => $row) {
																(!$query['Vendas']) ? $query['Vendas'] = 'N' : FALSE;

																if ($query['Vendas'] == $key) {
																	echo ''
																	. '<label class="btn btn-warning active" name="radiobutton_Vendas" id="radiobutton_Vendas' . $key . '">'
																	. '<input type="radio" name="Vendas" id="radiobutton" '
																	. 'autocomplete="off" value="' . $key . '" checked>' . $row
																	. '</label>'
																	;
																} else {
																	echo ''
																	. '<label class="btn btn-default" name="radiobutton_Vendas" id="radiobutton_Vendas' . $key . '">'
																	. '<input type="radio" name="Vendas" id="radiobutton" '
																	. 'autocomplete="off" value="' . $key . '" >' . $row
																	. '</label>'
																	;
																}
															}
															?>
														</div>
													</div>
												</div>
												<div class="col-md-3">
													<label for="Servicos">Servicos?</label><br>
													<div class="form-group">
														<div class="btn-group" data-toggle="buttons">
															<?php
															foreach ($select['Servicos'] as $key => $row) {
																(!$query['Servicos']) ? $query['Servicos'] = 'N' : FALSE;

																if ($query['Servicos'] == $key) {
																	echo ''
																	. '<label class="btn btn-warning active" name="radiobutton_Servicos" id="radiobutton_Servicos' . $key . '">'
																	. '<input type="radio" name="Servicos" id="radiobutton" '
																	. 'autocomplete="off" value="' . $key . '" checked>' . $row
																	. '</label>'
																	;
																} else {
																	echo ''
																	. '<label class="btn btn-default" name="radiobutton_Servicos" id="radiobutton_Servicos' . $key . '">'
																	. '<input type="radio" name="Servicos" id="radiobutton" '
																	. 'autocomplete="off" value="' . $key . '" >' . $row
																	. '</label>'
																	;
																}
															}
															?>
														</div>
													</div>
												</div>
												<div class="col-md-3">
													<label for="Entregas">Entregas?</label><br>
													<div class="form-group">
														<div class="btn-group" data-toggle="buttons">
															<?php
															foreach ($select['Entregas'] as $key => $row) {
																(!$query['Entregas']) ? $query['Entregas'] = 'N' : FALSE;

																if ($query['Entregas'] == $key) {
																	echo ''
																	. '<label class="btn btn-warning active" name="radiobutton_Entregas" id="radiobutton_Entregas' . $key . '">'
																	. '<input type="radio" name="Entregas" id="radiobutton" '
																	. 'autocomplete="off" value="' . $key . '" checked>' . $row
																	. '</label>'
																	;
																} else {
																	echo ''
																	. '<label class="btn btn-default" name="radiobutton_Entregas" id="radiobutton_Entregas' . $key . '">'
																	. '<input type="radio" name="Entregas" id="radiobutton" '
																	. 'autocomplete="off" value="' . $key . '" >' . $row
																	. '</label>'
																	;
																}
															}
															?>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-info">
										<div class="panel-heading">
											<h4>Procedimentos</h4>
											<div class="row">
												<div class="col-md-3">
													<label for="Sac">Sac?</label><br>
													<div class="form-group">
														<div class="btn-group" data-toggle="buttons">
															<?php
															foreach ($select['Sac'] as $key => $row) {
																(!$query['Sac']) ? $query['Sac'] = 'N' : FALSE;

																if ($query['Sac'] == $key) {
																	echo ''
																	. '<label class="btn btn-warning active" name="radiobutton_Sac" id="radiobutton_Sac' . $key . '">'
																	. '<input type="radio" name="Sac" id="radiobutton" '
																	. 'autocomplete="off" value="' . $key . '" checked>' . $row
																	. '</label>'
																	;
																} else {
																	echo ''
																	. '<label class="btn btn-default" name="radiobutton_Sac" id="radiobutton_Sac' . $key . '">'
																	. '<input type="radio" name="Sac" id="radiobutton" '
																	. 'autocomplete="off" value="' . $key . '" >' . $row
																	. '</label>'
																	;
																}
															}
															?>
														</div>
													</div>
												</div>
												<div class="col-md-3">
													<label for="Marketing">Marketing?</label><br>
													<div class="form-group">
														<div class="btn-group" data-toggle="buttons">
															<?php
															foreach ($select['Marketing'] as $key => $row) {
																(!$query['Marketing']) ? $query['Marketing'] = 'N' : FALSE;

																if ($query['Marketing'] == $key) {
																	echo ''
																	. '<label class="btn btn-warning active" name="radiobutton_Marketing" id="radiobutton_Marketing' . $key . '">'
																	. '<input type="radio" name="Marketing" id="radiobutton" '
																	. 'autocomplete="off" value="' . $key . '" checked>' . $row
																	. '</label>'
																	;
																} else {
																	echo ''
																	. '<label class="btn btn-default" name="radiobutton_Marketing" id="radiobutton_Marketing' . $key . '">'
																	. '<input type="radio" name="Marketing" id="radiobutton" '
																	. 'autocomplete="off" value="' . $key . '" >' . $row
																	. '</label>'
																	;
																}
															}
															?>
														</div>
													</div>
												</div>
												<div class="col-md-3">
													<label for="Procedimentos">Procedimentos?</label><br>
													<div class="form-group">
														<div class="btn-group" data-toggle="buttons">
															<?php
															foreach ($select['Procedimentos'] as $key => $row) {
																(!$query['Procedimentos']) ? $query['Procedimentos'] = 'N' : FALSE;

																if ($query['Procedimentos'] == $key) {
																	echo ''
																	. '<label class="btn btn-warning active" name="radiobutton_Procedimentos" id="radiobutton_Procedimentos' . $key . '">'
																	. '<input type="radio" name="Procedimentos" id="radiobutton" '
																	. 'autocomplete="off" value="' . $key . '" checked>' . $row
																	. '</label>'
																	;
																} else {
																	echo ''
																	. '<label class="btn btn-default" name="radiobutton_Procedimentos" id="radiobutton_Procedimentos' . $key . '">'
																	. '<input type="radio" name="Procedimentos" id="radiobutton" '
																	. 'autocomplete="off" value="' . $key . '" >' . $row
																	. '</label>'
																	;
																}
															}
															?>
														</div>
													</div>
												</div>
												<div class="col-md-3">
													<label for="Tarefas">Tarefas?</label><br>
													<div class="form-group">
														<div class="btn-group" data-toggle="buttons">
															<?php
															foreach ($select['Tarefas'] as $key => $row) {
																(!$query['Tarefas']) ? $query['Tarefas'] = 'N' : FALSE;

																if ($query['Tarefas'] == $key) {
																	echo ''
																	. '<label class="btn btn-warning active" name="radiobutton_Tarefas" id="radiobutton_Tarefas' . $key . '">'
																	. '<input type="radio" name="Tarefas" id="radiobutton" '
																	. 'autocomplete="off" value="' . $key . '" checked>' . $row
																	. '</label>'
																	;
																} else {
																	echo ''
																	. '<label class="btn btn-default" name="radiobutton_Tarefas" id="radiobutton_Tarefas' . $key . '">'
																	. '<input type="radio" name="Tarefas" id="radiobutton" '
																	. 'autocomplete="off" value="' . $key . '" >' . $row
																	. '</label>'
																	;
																}
															}
															?>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<input type="hidden" name="idSis_Usuario" value="<?php echo $query['idSis_Usuario']; ?>">
											<input type="hidden" name="idSis_Empresa" value="<?php echo $query['idSis_Empresa']; ?>">
											<div class="col-md-6">
												<button class="btn btn-sm btn-primary" id="inputDb" data-loading-text="Aguarde..." name="submit" value="1" type="submit">
													<span class="glyphicon glyphicon-save"></span> Salvar
												</button>
											</div>
										</div>
									</div>
								</div>
							</div>							
						</div>	
					</div>
				</div>
			</div>
		</form>	
		</div>
	</div>	
</div>
<?php } ?>