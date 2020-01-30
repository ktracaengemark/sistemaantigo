<?php if (isset($msg)) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Cliente'])) { ?>

<div class="container-fluid">
	<div class="row">
	
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<?php echo form_open_multipart($form_open_path); ?>
			<div class="panel panel-primary">
				
				<div class="panel-heading">
					<div class="btn-group">
						<button type="button" class="btn btn-sm btn-default  dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-file"></span> <?php echo '<small>' . $_SESSION['Cliente']['NomeCliente'] . '</small> - <small>Id.: ' . $_SESSION['Cliente']['idApp_Cliente'] . '</small>' ?> <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li>
								<a <?php if (preg_match("/cliente\/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
									<a href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
										<span class="glyphicon glyphicon-file"> </span>Ver Dados do Cliente
									</a>
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<li>
								<a <?php if (preg_match("/cliente\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
									<a href="<?php echo base_url() . 'cliente/alterar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Editar Dados do Cliente
									</a>
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<li>
								<a <?php if (preg_match("/cliente\/alterarlogo\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
									<a href="<?php echo base_url() . 'cliente/alterarlogo/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Alterar Logo
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
									<h3 class="text-left">Dados do Cliente  </h3>
									<div class="form-group">
										<div class="row">
											<div class="col-md-3">
												<label for="NomeCliente">Nome do Cliente:</label>
												<input type="text" class="form-control" id="NomeCliente" maxlength="45" readonly=''
														name="NomeCliente" autofocus value="<?php echo $query['NomeCliente']; ?>">
											</div>

										</div>
									</div>

									<h3 class="text-left">Foto do Perfil  </h3>									
									<?php if ($metodo != 3) { ?>

									<div class="form-group">
										<div class="row">
											<div class="col-md-12 "> 
												<a href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
													<img alt="User Pic" src="<?php echo base_url() . 'arquivos/imagens/clientes/' . $_SESSION['Cliente']['Arquivo'] . ''; ?>" 
													class="img-circle img-responsive" width='200'>
												</a>												
											</div>
										</div>
									</div>
									
									<div class="form-group">
										<div class="row">
											<div class="col-md-12">
												<label for="Arquivo">Arquivo: *</label>
												<input type="file" class="file" multiple="false" data-show-upload="false" data-show-caption="true" 
													   name="Arquivo" value="<?php echo $file['Arquivo']; ?>">
											</div>
										</div>
									</div>
													
									<?php } else { ?>

									<div class="form-group">
										<div class="row">
											<div class="col-md-12">
												<label for="Arquivo">Arquivo: *</label><br>
												<a href="<?php echo base_url() . 'arquivos/imagens/clientes/' . $file['Arquivo']?>" target="_blank" class="btn btn-info">
													<span class="glyphicon glyphicon-file"></span> Visualizar
												</a>
												<?php echo $file['Arquivo']; ?>
											</div>
										</div>
									</div>                
									
									<?php } ?>
									</form>
								</div>
							</div>
						</div>
					</div>		
					<div class="form-group">
						<div class="row">
							<input type="hidden" name="idApp_Cliente" value="<?php echo $query['idApp_Cliente']; ?>">
							<?php if ($metodo == 2) { ?>

								<div class="col-md-6">
									<button class="btn btn-sm btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
										<span class="glyphicon glyphicon-save"></span> Salvar
									</button>
								</div>
								<!--
								<div class="col-md-6 text-right">
									<button  type="button" class="btn btn-lg btn-danger" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
										<span class="glyphicon glyphicon-trash"></span> Excluir
									</button>
								</div>
								-->
								<div class="modal fade bs-excluir-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header bg-danger">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												<h4 class="modal-title">Tem certeza que deseja excluir?</h4>
											</div>
											<div class="modal-body">
												<p>Ao confirmar esta operação todos os dados serão excluídos permanentemente do sistema.
													Esta operação é irreversível.</p>
											</div>
											<div class="modal-footer">
												<div class="col-md-6 text-left">
													<button type="button" class="btn btn-warning" data-dismiss="modal">
														<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
													</button>
												</div>
												<div class="col-md-6 text-right">
													<a class="btn btn-danger" href="<?php echo base_url() . 'cliente/excluir/' . $query['idApp_Cliente'] ?>" role="button">
														<span class="glyphicon glyphicon-trash"></span> Confirmar Exclusão
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>

							<?php } elseif ($metodo == 3) { ?>
								<div class="col-md-12 text-center">
									<!--
									<button class="btn btn-lg btn-danger" id="inputDb" data-loading-text="Aguarde..." name="submit" value="1" type="submit">
										<span class="glyphicon glyphicon-trash"></span> Excluir
									</button>
									-->
									<button class="btn btn-sm btn-warning" id="inputDb" onClick="history.go(-1);
											return true;">
										<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
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
		</div>
	</div>	
</div>
<?php } ?>