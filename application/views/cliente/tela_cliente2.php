<?php if ($msg) echo $msg; ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<?php if ( !isset($evento) && $_SESSION['log']['idSis_Empresa'] != 5 && isset($_SESSION['Cliente'])) { ?>
				<?php if ($_SESSION['Cliente']['idApp_Cliente'] != 150001 && $_SESSION['Cliente']['idApp_Cliente'] != 1 && $_SESSION['Cliente']['idApp_Cliente'] != 0) { ?>
					<nav class="navbar navbar-inverse navbar-fixed-top " role="banner">
						<div class="container-fluid">
							<div class="navbar-header ">
								<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
									<span class="sr-only">MENU</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
								<a type="button" class="navbar-toggle btn btn-lg btn-primary  " href="javascript:window.close()">
									<span class="glyphicon glyphicon-remove"></span> Fechar
								</a>			
							</div>
							<div class="collapse navbar-collapse" id="myNavbar">		
								<ul class="nav navbar-nav navbar-center">
									
									<li class="btn-toolbar btn-lg navbar-form" role="toolbar" aria-label="...">
										<div class="btn-group " role="group" aria-label="...">
											<!--<a href="<?php echo base_url(); ?>relatorio2/clientes3" role="button">-->
											<a href="<?php echo base_url(); ?>cliente2/pesquisar2" role="button">
												<button type="button" class="btn btn-lg btn-warning ">
													<span class="glyphicon glyphicon-search"></span> Clientes
												</button>
											</a>						
										</div>					
									</li>
									<li class="btn-toolbar btn-lg navbar-form" role="toolbar" aria-label="...">
										<div class="btn-group " role="group" aria-label="...">
											<!--
											<a href="<?php echo base_url(); ?>cliente2/alterar3/<?php echo $_SESSION['Cliente']['idApp_Cliente'];?>" role="button">
												<button type="button" class="btn btn-lg btn-primary ">
													<span class="glyphicon glyphicon-edit"></span> Editar
												</button>
											</a>
											-->
											<a href="<?php echo base_url() . 'cliente2/alterar3/' . $_SESSION['Cliente']['idApp_Cliente']; ?>" role="button">
												<button type="button" class="btn btn-lg btn-primary ">
													<span class="glyphicon glyphicon-edit"></span> Editar
												</button>
											</a>
											
										</div>					
									</li>
									<li class="btn-toolbar btn-lg navbar-form" role="toolbar" aria-label="...">
										<div class="btn-group " role="group" aria-label="...">
											<a type="button" class="btn btn-lg btn-default " href="javascript:window.close()">
												<span class="glyphicon glyphicon-remove"></span> Fechar
											</a>
										</div>					
									</li>				
								</ul>			
							</div>
						</div>
					</nav>
					<br>
				<?php } ?>
			<?php } ?>			
			
			<div class="row">
				<div class="col-sm-offset-1 col-md-10 ">
					<div class="panel panel-<?php echo $panel; ?>">

						<div class="panel-heading">
							<strong>Cliente: </strong>
							<?php echo '<small>' . $_SESSION['Cliente']['NomeCliente'] . '</small> - <small>' . $_SESSION['Cliente']['idApp_Cliente'] . '.</small>' ?>
						</div>
						<div class="panel-body">				
							<div style="overflow: auto; height: 500px; ">																											 
								<div class="form-group">	
									<div class="row">
										
										<div class=" col-md-6">	
											<div class="row">	
												<div class="col-sm-offset-2 col-md-10 " align="left"> 
													<!--<a href="<?php echo base_url() . 'cliente/alterarlogo/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">-->
													<a>
														<img alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/miniatura/' . $_SESSION['Cliente']['Arquivo'] . ''; ?>" class="img-circle img-responsive" width='200'>
													</a>													
												</div>
											</div>		
										</div>
										
										<div class=" col-md-6">								
											<table class="table table-user-information">
												<tbody>
													
													<?php 
													
													if ($query['idSis_Empresa']) {
														
													echo ' 
													<tr>
														<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-home"></span> Empresa:</td>
														<td>' . $query['idSis_Empresa'] . '</td>
													</tr>  
													';
													
													}
													
													if ($query['NomeCliente']) {
														
													echo ' 
													<tr>
														<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-user"></span> Cliente:</td>
														<td>' . $query['NomeCliente'] . '</td>
													</tr>  
													';
													
													}
													
													if ($query['RegistroFicha']) {
														
													echo ' 
													<tr>
														<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-user"></span> Ficha N�:</td>
														<td>' . $query['RegistroFicha'] . '</td>
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
													
													if ($query['Telefone']) {
														
													echo '                                                 
													<tr>
														<td><span class="glyphicon glyphicon-phone-alt"></span> Telefone:</td>
														<td>' . $query['Telefone'] . '</td>
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
													
													if ($query['CepCliente']) {
														
													echo '                                                 
													<tr>
														<td><span class="glyphicon glyphicon-envelope"></span> Cep:</td>
														<td>' . $query['CepCliente'] . '</td>
													</tr>
													';
													
													}
													
													if ($query['EnderecoCliente'] || 
														$query['NumeroCliente'] ||  
														$query['ComplementoCliente'] ||  
														$query['BairroCliente'] ||   
														$query['MunicipioCliente'] ||
														$query['EstadoCliente']) {
														
													echo '                                                 
													<tr>
														<td><span class="glyphicon glyphicon-home"></span>Endere�o:</td>
														<td>' . $query['EnderecoCliente'] . 
															' - ' . $query['NumeroCliente'] .
															' - ' . $query['ComplementoCliente'] .
															' - ' . $query['BairroCliente'] . 
															' - ' . $query['MunicipioCliente'] . 
															' - ' . $query['EstadoCliente'] .
															'</td>
													</tr>
													';
													
													}
													
													if ($query['ReferenciaCliente']) {
														
													echo '                                                 
													<tr>
														<td><span class="glyphicon glyphicon-pencil"></span> Ref.:</td>
														<td>' . $query['ReferenciaCliente'] . '</td>
													</tr>
													';
													
													}
													
													if ($query['CpfCliente']) {
														
													echo '                                                 
													<tr>
														<td><span class="glyphicon glyphicon-pencil"></span> CpfCliente:</td>
														<td>' . $query['CpfCliente'] . '</td>
													</tr>
													';
													
													}
													
													if ($query['Rg'] || $query['OrgaoExp'] || $query['EstadoCliente'] || $query['DataEmissao']) {
														
													echo '                                                 
													<tr>
														<td><span class="glyphicon glyphicon-pencil"></span> Rg:</td>
														<td>' . $query['Rg'] . ' - ' . $query['OrgaoExp'] . ' - ' . $query['EstadoCliente'] . ' - ' . $query['DataEmissao'] . '</td>
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
													
													if ($query['Obs']) {
														
													echo '                                                 
													<tr>
														<td><span class="glyphicon glyphicon-file"></span> Obs:</td>
														<td>' . nl2br($query['Obs']) . '</td>
													</tr>
													';
													
													}
													
													if ($query['Profissional']) {
														
													echo '                                                 
													<tr>
														<td><span class="glyphicon glyphicon-user"></span> Profissional:</td>
														<td>' . $query['Profissional'] . '</td>
													</tr>
													';
													
													}
													
													if ($query['ClienteConsultor']) {
														
													echo '                                                 
													<tr>
														<td><span class="glyphicon glyphicon-alert"></span> Cliente Consultor:</td>
														<td>' . $query['ClienteConsultor'] . '</td>
													</tr>
													';
													
													}
													
													if ($query['Ativo']) {
														
													echo '                                                 
													<tr>
														<td><span class="glyphicon glyphicon-alert"></span> Ativo:</td>
														<td>' . $query['Ativo'] . '</td>
													</tr>
													';
													
													}
													?>
													
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<!--
								<div class="row">
				
									<div class="col-md-12 col-lg-12">

										<div class="panel panel-primary">

											<div class="panel-heading"><strong>Contato</strong></div>
											<div class="panel-body">
										
												
												<?php
												if (!$list) {
												?>
													<a class="btn btn-md btn-warning" href="<?php echo base_url() ?>contatocliente/cadastrar" role="button"> 
														<span class="glyphicon glyphicon-plus"></span> Cad.
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
	</div>	
</div>


      

