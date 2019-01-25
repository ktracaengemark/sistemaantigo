<?php if ($msg) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Usuario'])) { ?>

<div class="container-fluid">
	<div class="row">

		<div class="col-md-offset-2 col-md-8">
	
					<div class="panel panel-primary">
						<div class="panel-heading">
							<div class="btn-group">
								<button type="button" class="btn btn-sm btn-default  dropdown-toggle" data-toggle="dropdown">
									<span class="glyphicon glyphicon-file"></span> <?php echo '<small>' . $_SESSION['Usuario']['Nome'] . '</small> - <small>Id.: ' . $_SESSION['Usuario']['idSis_Usuario'] . '</small>' ?> <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li>
										<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
											<a href="<?php echo base_url() . 'usuario2/prontuario/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
												<span class="glyphicon glyphicon-file"> </span>Ver Dados do Usu�rio
											</a>
										</a>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a <?php if (preg_match("/usuario2\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
											<a href="<?php echo base_url() . 'usuario2/alterar/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados do Usu�rio
											</a>
										</a>
									</li>
								</ul>
							</div>
						</div>	

						<div class="panel-body">

							<div style="overflow: auto; height: 350px; ">

								<table class="table table-user-information">
									<tbody>

										<?php

										if ($query['Nome']) {

										echo '
										<tr>
											<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-user"></span> Usu�rio:</td>
											<td>' . $query['Nome'] . '</td>
										</tr>
										';

										}

										if ($query['DataNascimento']) {

										echo '
										<tr>
											<td><span class="glyphicon glyphicon-gift"></span> Data de Nascimento:</td>
												<td>' . $query['DataNascimento'] . '</td>
										</tr>
										<tr>
											<td><span class="glyphicon glyphicon-gift"></span> Idade:</td>
												<td>' . $query['Idade'] . ' anos</td>
										</tr>
										';

										}

										if ($query['CelularUsuario']) {

										echo '
										<tr>
											<td><span class="glyphicon glyphicon-phone-alt"></span> Celular:</td>
											<td>' . $query['CelularUsuario'] . '</td>
										</tr>
										';

										}

										if ($query['Sexo']) {

										echo '
										<tr>
											<td><span class="glyphicon glyphicon-heart"></span> Sexo:</td>
											<td>' . $query['Sexo'] . '</td>
										</tr>
										';

										}

										if ($query['Email']) {

										echo '
										<tr>
											<td><span class="glyphicon glyphicon-envelope"></span> E-mail:</td>
											<td>' . $query['Email'] . '</td>
										</tr>
										';

										}
										
										if ($query['CpfUsuario']) {

										echo '
										<tr>
											<td><span class="glyphicon glyphicon-envelope"></span> CPF:</td>
											<td>' . $query['CpfUsuario'] . '</td>
										</tr>
										';

										}
										
										if ($query['RgUsuario']) {

										echo '
										<tr>
											<td><span class="glyphicon glyphicon-envelope"></span> RG:</td>
											<td>' . $query['RgUsuario'] . '</td>
										</tr>
										';

										}


										if ($query['Permissao']) {

										echo '
										<tr>
											<td><span class="glyphicon glyphicon-alert"></span> N�vel:</td>
											<td>' . $query['Permissao'] . '</td>
										</tr>
										';

										}

										if ($query['Funcao']) {

										echo '
										<tr>
											<td><span class="glyphicon glyphicon-alert"></span> Fun��o:</td>
											<td>' . $query['Funcao'] . '</td>
										</tr>
										';

										}

										if ($query['Inativo']) {

										echo '
										<tr>
											<td><span class="glyphicon glyphicon-alert"></span> Ativo?:</td>
											<td>' . $query['Inativo'] . '</td>
										</tr>
										';

										}
										
										if ($query['CompAgenda']) {

										echo '
										<tr>
											<td><span class="glyphicon glyphicon-alert"></span> Comp. Agd.?</td>
											<td>' . $query['CompAgenda'] . '</td>
										</tr>
										';

										}

										?>

									</tbody>
								</table>
								<!--
								<div class="row">

									<div class="col-md-12">

										<div class="panel panel-primary">
											<div class="panel-heading">
												<div class="btn-group">
													<button type="button" class="btn btn-sm btn-default  dropdown-toggle" data-toggle="dropdown">
														<span class="glyphicon glyphicon-file"></span> Contatos <span class="caret"></span>
													</button>
													<ul class="dropdown-menu" role="menu">
														<li>
															<a <?php if (preg_match("/contatousuario\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar/    ?>>
																<a href="<?php echo base_url() . 'contatousuario/cadastrar/' ?>">
																	<span class="glyphicon glyphicon-plus"></span> Cadastrar Contato
																</a>
															</a>
														</li>
													</ul>
												</div>
											</div>											
											
											<div class="panel-body">

												<?php
												if (!$list) {
												?>
													<a class="btn btn-md btn-warning" href="<?php echo base_url() ?>contatousuario/cadastrar" role="button"> 
														<span class="glyphicon glyphicon-plus"></span> Novo Contato
													</a>
													<br><br>
													<div class="alert alert-info" role="alert"><b>Nenhum Cad.</b></div>
												<?php
												} else {
													echo $list;
												}
												?>

											</div>
										</div>
									</div>
								</div>
								-->
							</div>
						</div>
					</div>

		</div>
	</div>
</div>
<?php } ?>