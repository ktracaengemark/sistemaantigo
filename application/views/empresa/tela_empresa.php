<?php if ($msg) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Empresa'])) { ?>

<div class="container-fluid">
	<div class="row">

		<div class="col-md-2"></div>
		<div class="col-md-8">

			<div class="panel panel-primary">

				<div class="panel-heading"><strong><?php echo '<strong>' . $_SESSION['Empresa']['NomeEmpresa'] . '</strong> - <small>Id.: ' . $_SESSION['Empresa']['idSis_Empresa'] . '</small>' ?></strong></div>
				<div class="panel-body">


					<!--
					<div class="form-group">
						<div class="row">
							<div class="text-center t">
								<h3><?php echo '<strong>' . $_SESSION['Empresa']['NomeAdmin'] . '</strong> - <small>Id.: ' . $_SESSION['Empresa']['idSis_Empresa'] . '</small>' ?></h3>
							</div>
						</div>
					</div>
					-->
					<?php } ?>

					<div class="row">

						<div class="panel-body">
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

								<div class="col-md-12 col-lg-12">

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
		<div class="col-md-2"></div>
	</div>
</div>
