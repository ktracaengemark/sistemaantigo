<?php if (isset($msg)) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Empresa'])) { ?>

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
						</ul>
					</div>
				</div>
				<div class="panel-body">
					<div class="row">	
						<div class="col-md-12">	
						
							<?php echo validation_errors(); ?>

							<div class="panel panel-info">
								<div class="panel-heading">
									<h3 class="text-left">Logo da Empresa  </h3>
									<div class="form-group">
										<div class="row">
											<!--
											<div class="col-md-3">
												<label for="NomeAdmin">Nome do Admin.:</label>
												<input type="text" class="form-control" id="NomeAdmin" maxlength="45" 
														name="NomeAdmin" autofocus value="<?php echo $query['NomeAdmin']; ?>">
											</div>
											<div class="col-md-3">
												<label for="DataNascimento">Data do Aniver.:</label>
												<input type="text" class="form-control Date" maxlength="10" <?php echo $readonly; ?>
													   name="DataNascimento" placeholder="DD/MM/AAAA" value="<?php echo $query['DataNascimento']; ?>">
											</div>
											-->
											<div class="col-md-3">	
												<body>	
													<label>(Ext: .jpg / Tam Max: 50K):</label>
													<form method="post" action="sistematestes" enctype="multipart/form-data"> <!--não sei se precisa colocar "sistemaantigo" -->
														<input type="file" required name="arquivo"> <!--não coloquei o "" required "" -->
														<input type="submit">
													</form>
													<div class="col-sm-offset-2 col-md-10 " align="left"> 
														<img alt="User Pic" src="<?php echo base_url() . 'arquivos/imagens/empresas/profile-' . $query['idSis_Empresa'] . '.jpg'; ?>" 
														class="img-circle img-responsive">
													</div>
													<?php
													
													$arquivo = isset ($_FILES['arquivo'])?$_FILES['arquivo']:"";

													if(isset($_FILES['arquivo'])){
														$nome 				= $arquivo['name'];
														$tiposPermitidos 	= ['jpg'];
														$tamanho			= $arquivo['size'];
														
														$extensao			= explode('.', $nome);
														$extensao			= end($extensao);
														$novoNome			= 'profile' . '-' . $_SESSION['Empresa']['idSis_Empresa'] . '.' . $extensao;
														
														//$novoNome			= 'VERIFICAR-' . 'profile' . '-' . $_SESSION['Empresa']['idSis_Empresa'] . '.' . $extensao; 
														//Essa linha será para, a Ktraca, verificar a logo, antes de ser exibida, 
														//pois a imagem pode não ser permitida. Depois criarei um método de verificação.
														//por enquanto a logo selhecionada, pelu usuário, entrará direto. 
														
														if(in_array($extensao, $tiposPermitidos)){
															if($tamanho > 60000){
																print "O Tamanho do Arquivo excede o limite permitido!";
															}else{
																$mover = move_uploaded_file($_FILES['arquivo']['tmp_name'], 'arquivos/imagens/empresas/' . $novoNome);
																print "Arquivo enviado com Sucesso!";
															}
														}else{
															print "O Tipo de Arquivo não é Permitido!";
														}
														
														//print_r($novoNome);
													}
													
													?>
												</body>
											</div>	
										</div>
									</div>
									

									<!--
									<div class="form-group">
										<div class="row">											
											<div class="col-md-3">
												<label for="CelularAdmin">Celular /(Login)</label>
												<input type="text" class="form-control Celular CelularVariavel" id="CelularAdmin" maxlength="11" <?php echo $readonly; ?>
													   name="CelularAdmin" placeholder="(XX)999999999" value="<?php echo $query['CelularAdmin']; ?>">
											</div>
											<div class="col-md-3">
												<label for="Senha">Senha:</label>
												<input type="password" class="form-control" id="Senha" maxlength="45"
													   name="Senha" value="<?php #echo $query['Senha']; ?>">
												<?php echo form_error('Senha'); ?>
											</div>
											<div class="col-md-3">
												<label for="Senha">Confirmar Senha:</label>
												<input type="password" class="form-control" id="Confirma" maxlength="45"
													   name="Confirma" value="<?php #echo $query['Senha']; ?>">
												<?php echo form_error('Confirma'); ?>
											</div>											
										</div>
									</div>
									
									
									<h3 class="text-left">Dados da Empresa  </h3>									
									<div class="form-group">
										<div class="row">
											<div class="col-md-3">
												<label for="CategoriaEmpresa">Categoria:*</label>
												<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
														id="CategoriaEmpresa" name="CategoriaEmpresa">
													<option value="">-- Selec. uma Categoria --</option>
													<?php
													foreach ($select['CategoriaEmpresa'] as $key => $row) {
														if ($query['CategoriaEmpresa'] == $key) {
															echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
														} else {
															echo '<option value="' . $key . '">' . $row . '</option>';
														}
													}
													?>   
												</select>          
											</div>
											<div class="col-md-6">
												<label for="Atuacao">Atuação:</label>
												<textarea class="form-control" id="Atuacao" <?php echo $readonly; ?>
														  name="Atuacao"><?php echo $query['Atuacao']; ?></textarea>
											</div>
											<div class="col-md-3">
												<label for="Site">Site:</label>
												<input type="text" class="form-control" maxlength="50" <?php echo $readonly; ?>
													   name="Site" value="<?php echo $query['Site']; ?>">
											<?php echo form_error('Site'); ?>
											</div>
										</div>
									</div>
									
									<div class="form-group">
										<div class="row">
											<div class="col-md-12 text-center">
												<button class="btn btn-info" type="button" data-toggle="collapse" data-target="#DadosComplementares" aria-expanded="false" aria-controls="DadosComplementares">
													<span class="glyphicon glyphicon-menu-down"></span> Completar Dados
												</button>
											</div>
										</div>
									</div>

									<div <?php echo $collapse; ?> id="DadosComplementares">
										<div class="form-group">
											<div class="row">										
												<div class="col-md-3">
													<label for="Email">E-mail Admin.:</label>
													<input type="text" class="form-control" id="Bairro" maxlength="100" <?php echo $readonly; ?>
														   name="Email" value="<?php echo $query['Email']; ?>">
												</div>												
												<div class="col-md-3">
													<label for="Cnpj">Cnpj:</label>
													<input type="text" class="form-control Cnpj" maxlength="18" <?php echo $readonly; ?>
														   name="Cnpj" placeholder="99.999.999/9999-98" value="<?php echo $query['Cnpj']; ?>">
												</div>
												<div class="col-md-3">
													<label for="InscEstadual">Insc.Estadual:</label>
													<input type="text" class="form-control" maxlength="11" <?php echo $readonly; ?>
														   name="InscEstadual" value="<?php echo $query['InscEstadual']; ?>">
												</div>
												<div class="col-md-3">
													<label for="Telefone">Tel.Empresa:</label>
													<input type="text" class="form-control Celular CelularVariavel" id="Telefone" maxlength="11" <?php echo $readonly; ?>
														   name="Telefone" placeholder="(XX)999999999" value="<?php echo $query['Telefone']; ?>">
												</div>																				
											</div>
										</div>
										
										<div class="form-group">
											<div class="row">
												<div class="col-md-3">
													<label for="Endereco">Endreço:</label>
													<input type="text" class="form-control" maxlength="200" <?php echo $readonly; ?>
														   name="Endereco" value="<?php echo $query['Endereco']; ?>">
												</div>
												<div class="col-md-3">
													<label for="Bairro">Bairro:</label>
													<input type="text" class="form-control" maxlength="100" <?php echo $readonly; ?>
														   name="Bairro" value="<?php echo $query['Bairro']; ?>">
												</div>
												<div class="col-md-3">
													<label for="Municipio">Municipio:</label>
													<input type="text" class="form-control" maxlength="100" <?php echo $readonly; ?>
														   name="Municipio" value="<?php echo $query['Municipio']; ?>">
												</div>												
												<div class="col-md-1">
													<label for="Estado">Estado:</label>
													<input type="text" class="form-control" maxlength="2" <?php echo $readonly; ?>
														   name="Estado" value="<?php echo $query['Estado']; ?>">
												</div>
												<div class="col-md-2">
													<label for="Cep">Cep:</label>
													<input type="text" class="form-control" maxlength="8" <?php echo $readonly; ?>
														   name="Cep" value="<?php echo $query['Cep']; ?>">
												</div>
											</div>
										</div>
									</div>
									-->
									</form>
								</div>
							</div>
						</div>
					</div>		
					
					<div class="form-group">
						<div class="row">
							<input type="hidden" name="idSis_Empresa" value="<?php echo $query['idSis_Empresa']; ?>">
						</div>
					</div>
					
				</div>	
			</div>		
		</div>
	</div>	
</div>
<?php } ?>