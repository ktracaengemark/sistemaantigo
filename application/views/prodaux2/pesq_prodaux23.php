<nav class="navbar navbar-inverse navbar-fixed-top " role="banner">
  <div class="container-fluid">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span> 
		</button>
	</div>
	<div class="collapse navbar-collapse" id="myNavbar">
		<ul class="nav navbar-nav navbar-center">
			<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
				<div class="btn-group " role="group" aria-label="...">
					<a <?php if (preg_match("/relatorio\/produtos2\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
						<a href="<?php echo base_url() . 'relatorio/produtos2/'; ?>">
							<button type="button" class="btn btn-lg btn-info ">
								<span class="glyphicon glyphicon-search"></span> Pesquisar
							</button>										
						</a>
					</a>
				</div>
				<div class="btn-group " role="group" aria-label="...">
					<a href="javascript:window.close()">
						<button type="button" class="btn btn-lg btn-default ">
							<span class="glyphicon glyphicon-remove"></span> Fechar
						</button>
					</a>
				</div>				
			</li>
		</ul>
	</div>
  </div>
</nav>

<?php if (isset($msg)) echo $msg; ?>
<div class="container-fluid">	
	<div class="row">

		<div class="col-md-2"></div>
		<div class="col-md-8">

			<?php echo validation_errors(); ?>

			<div class="panel panel-primary">

				<div class="panel-heading"><strong><?php echo $titulo; ?></strong></div>
				<div class="panel-body">

					<?php echo form_open($form_open_path, 'role="form"'); ?>
						<div class="row">
							<div class="col-md-4">
								<label for="Prodaux2">Tipo:</label><br>
								<input type="text" class="form-control" maxlength="30"
									   autofocus name="Prodaux2" value="<?php echo $query['Prodaux2'] ?>">
							</div>
							
							<div class="col-md-3">
								<label for="Abrev2">Abrev.:</label><br>
								<input type="text" class="form-control" maxlength="4"
										name="Abrev2" value="<?php echo $query['Abrev2'] ?>">
							</div>
						</div>
						<br>
						<div class="form-group">
							<div class="row">
								<input type="hidden" name="idTab_Prodaux2" value="<?php echo $query['idTab_Prodaux2']; ?>">
								<?php if ($metodo == 2) { ?>

									<div class="col-md-6">
										<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
											<span class="glyphicon glyphicon-save"></span> Salvar
										</button>
									</div>
									<div class="col-md-6 text-right">
										<button  type="button" class="btn btn-lg btn-danger" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
											<span class="glyphicon glyphicon-trash"></span> Excluir
										</button>
									</div>

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
														<a class="btn btn-danger" href="<?php echo base_url() . 'prodaux2/excluir3/' . $query['idTab_Prodaux2'] ?>" role="button">
															<span class="glyphicon glyphicon-trash"></span> Confirmar Exclusão
														</a>
													</div>
												</div>
											</div>
										</div>
									</div>

								<?php } else { ?>
									<div class="col-md-6">
										<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
											<span class="glyphicon glyphicon-save"></span> Salvar
										</button>
									</div>
								<?php } ?>
							</div>
						</div>
						
					</form>

					<br>                
					
					<?php if (isset($list)) echo $list; ?>

				</div>

			</div>

		</div>
		<div class="col-md-2"></div>

	</div>
</div>