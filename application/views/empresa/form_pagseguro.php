<?php if (isset($msg)) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Empresa']) && isset($_SESSION['PagSeguro'])) { ?>

<div class="container-fluid">
	<div class="row">
	
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<?php echo form_open_multipart($form_open_path); ?>
			<div class="panel panel-primary">
				
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
							<li role="separator" class="divider"></li>
							<li>
								<a <?php if (preg_match("/empresa\/atendimento\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
									<a href="<?php echo base_url() . 'empresa/atendimento/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Horario de Atendimento
									</a>
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<li>
								<a <?php if (preg_match("/empresa\/alterarlogo\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
									<a href="<?php echo base_url() . 'empresa/alterarlogo/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Alterar Logo
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<li>
								<a <?php if (preg_match("/empresa\/pagseguro\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
									<a href="<?php echo base_url() . 'empresa/pagseguro/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Pag Seguro
									</a>
								</a>
							</li>							
						</ul>
					</div>
				</div>
								
				<div class="panel-body">
					<div class="row">	
						<div class="col-md-12">	
						
							<?php echo validation_errors(); ?>

							<div class="panel panel-info">
								<div class="panel-heading">
									<h3 class="text-left">Dados do Pag Seguro</h3>
									<div class="form-group">
										<div class="row">										
											<div class="col-md-6">
												<label for="Email_Pagseguro">E-mail:</label>
												<input type="text" class="form-control" id="Email_Pagseguro" maxlength="100" <?php echo $readonly; ?>
													   name="Email_Pagseguro" value="<?php echo $pagseguro['Email_Pagseguro']; ?>">
											</div>
										</div>
									</div>	
									<div class="form-group">	
										<div class="row">	
											<div class="col-md-6">
												<label for="Token_Sandbox">Token Sandbox:</label>
												<input type="text" class="form-control " id="Token_Sandbox" maxlength="200" <?php echo $readonly; ?>
													   name="Token_Sandbox" value="<?php echo $pagseguro['Token_Sandbox']; ?>">
											</div>												
											<div class="col-md-6">
												<label for="Token_Producao">Token Producao:</label>
												<input type="text" class="form-control " id="Token_Producao" maxlength="200" <?php echo $readonly; ?>
													   name="Token_Producao" value="<?php echo $pagseguro['Token_Producao']; ?>">
											</div>																				
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>		
					<div class="form-group">
						<div class="row">
							<input type="hidden" name="idSis_Empresa" value="<?php echo $_SESSION['Empresa']['idSis_Empresa']; ?>">
							<input type="hidden" name="idApp_Documentos" value="<?php echo $pagseguro['idApp_Documentos']; ?>">
							<!--<input type="hidden" name="idSis_Empresa" value="<?php echo $pagseguro['idSis_Empresa']; ?>">-->
							<?php if ($metodo == 2) { ?>
								<div class="col-md-6">
									<button class="btn btn-sm btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
										<span class="glyphicon glyphicon-save"></span> Salvar
									</button>
								</div>
							<?php } else { ?>
								<div class="col-md-6">
									<button class="btn btn-sm btn-primary" id="inputDb" data-loading-text="Aguarde..." name="submit" value="1" type="submit">
										<span class="glyphicon glyphicon-save"></span> Salvar
									</button>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>	
			</div>
			</form>
		</div>
	</div>	
</div>
<?php } ?>