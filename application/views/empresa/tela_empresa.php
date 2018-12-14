<?php if ($msg) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Empresa'])) { ?>
	
	<div class="container-fluid">
		<div class="row">

			<div class="col-sm-offset-2 col-md-8">

				<div class="panel panel-primary">

					<div class="panel-heading">
					
					<?php echo '<small>' . $_SESSION['Empresa']['NomeEmpresa'] . '</small> - <small>Id.: ' . $_SESSION['Empresa']['idSis_Empresa'] . '</small>' ?>
					
					<a class="btn btn-sm btn-success" href="<?php echo base_url() . 'empresa/prontuario/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
						<span class="glyphicon glyphicon-file"> </span> Ver <span class="sr-only">(current)</span>
					</a>
					
					<a class="btn btn-sm btn-warning" href="<?php echo base_url() . 'empresa/alterar/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
						<span class="glyphicon glyphicon-edit"></span> Edit.
					</a>
					</div>
					<?php } ?>					
					<div class="panel-body">
						<div style="overflow: auto; height: 600px; ">
							<table class="table table-user-information">
								<tbody>

									<?php
									
									if ($query['NomeAdmin']) {

									echo '
									<tr>
										<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-user"></span> Admin:</td>
										<td>' . $query['NomeAdmin'] . '</td>
									</tr>
									';

									}
									/*
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
									*/
									
									if ($query['Celular']) {

									echo '
									<tr>
										<td><span class="glyphicon glyphicon-phone-alt"></span> Celular:</td>
										<td>' . $query['Celular'] . '</td>
									</tr>
									';

									}

									/*
									if ($query['Sexo']) {

									echo '
									<tr>
										<td><span class="glyphicon glyphicon-heart"></span> Sexo:</td>
										<td>' . $query['Sexo'] . '</td>
									</tr>
									';

									}
									*/
									
									if ($query['Email']) {

									echo '
									<tr>
										<td><span class="glyphicon glyphicon-envelope"></span> E-mail:</td>
										<td>' . $query['Email'] . '</td>
									</tr>
									';

									}
									
									if ($query['CategoriaEmpresa']) {

									echo '
									<tr>
										<td><span class="glyphicon glyphicon-envelope"></span> Categoria:</td>
										<td>' . $query['CategoriaEmpresa'] . '</td>
									</tr>
									';

									}
									
									if ($query['Atuacao']) {

									echo '
									<tr>
										<td><span class="glyphicon glyphicon-envelope"></span> Atuação:</td>
										<td>' . $query['Atuacao'] . '</td>
									</tr>
									';

									}

									if ($query['Site']) {

									echo '
									<tr>
										<td><span class="glyphicon glyphicon-envelope"></span> Site:</td>
										<td>' . $query['Site'] . '</td>
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

									?>

								</tbody>
							</table>
						
							<div class="row">

								<div class="col-md-12">

									<div class="panel panel-primary">

										<div class="panel-heading"><strong>Contatos</strong></div>
										<div class="panel-body">

											<?php
											if (!$list) {
											?>
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
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

