<?php if (isset($msg)) echo $msg; ?>

<?php echo validation_errors(); ?>
		
<nav class="navbar navbar-center navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span> 
		</button>
		<!--
		<a class="navbar-brand" href="<?php echo base_url() ?>orcatrata/cadastrar3/"> 
			 <span class="glyphicon glyphicon-plus"></span> Nova Produto
		</a>
		
		<a class="navbar-brand" href="<?php echo base_url() ?>relatorio/parcelas/">
			<span class="glyphicon glyphicon-usd"></span> Parcelas
		</a>
		-->
	</div>
	<div class="collapse navbar-collapse" id="myNavbar">
		<ul class="nav navbar-nav navbar-center">
			<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">
				<div class="btn-group " role="group" aria-label="...">
					<a href="<?php echo base_url(); ?>agenda">
						<button type="button" class="btn btn-sm btn-info ">
							<span class="glyphicon glyphicon-calendar"></span> Agenda
						</button>
					</a>
				</div>
				<?php if ($_SESSION['log']['NivelEmpresa'] >= 3 ) { ?>
				<div class="btn-group " role="group" aria-label="...">
					<a href="<?php echo base_url(); ?>relatorio/clientes">
						<button type="button" class="btn btn-sm btn-success ">
							<span class="glyphicon glyphicon-user"></span> Clientes
						</button>
					</a>
				</div>
				<div class="btn-group">
					<button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">
						<span class="glyphicon glyphicon-gift"></span> Produtos <span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">							
						<li><a href="<?php echo base_url() ?>relatorio/produtos"><span class="glyphicon glyphicon-usd"></span> Produtos</a></li>
						<li role="separator" class="divider"></li>							
						<li><a href="<?php echo base_url() ?>relatorio/estoque"><span class="glyphicon glyphicon-list-alt"></span> Estoque</a></li>
					</ul>
				</div>																				
				<?php } ?>
			</li>						
			<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">
				<div class="btn-group " role="group" aria-label="...">
					<a <?php if (preg_match("/orcatrata\/cadastrar3\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
						<a href="<?php echo base_url() . 'orcatrata/cadastrar3/'; ?>">
							<button type="button" class="btn btn-sm btn-primary ">
								<span class="glyphicon glyphicon-plus"></span> Receita
							</button>										
						</a>
					</a>
				</div>
				<div class="btn-group " role="group" aria-label="...">
					<a <?php if (preg_match("/orcatrata\/cadastrardesp\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
						<a href="<?php echo base_url() . 'orcatrata/cadastrardesp/'; ?>">
							<button type="button" class="btn btn-sm btn-danger ">
								<span class="glyphicon glyphicon-plus"></span> Despesa
							</button>										
						</a>
					</a>
				</div>
				<div class="btn-group">
					<button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
						<span class="glyphicon glyphicon-usd"></span> Financeiro <span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">							
						<li><a href="<?php echo base_url() ?>relatorio/financeiro"><span class="glyphicon glyphicon-usd"></span> Receitas & Despesas</a></li>
						<li role="separator" class="divider"></li>							
						<li><a href="<?php echo base_url() ?>relatorio/parcelas"><span class="glyphicon glyphicon-usd"></span> Parcelas</a></li>
						<li role="separator" class="divider"></li>							
						<li><a href="<?php echo base_url() ?>relatorio/balanco"><span class="glyphicon glyphicon-usd"></span> Balanço</a></li>									
					</ul>
				</div>																				
			</li>
			<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">
				<div class="btn-group " role="group" aria-label="...">
					<a href="javascript:window.print()">
						<button type="button" class="btn btn-sm btn-default ">
							<span class="glyphicon glyphicon-print"></span> Imprimir
						</button>
					</a>
				</div>
				<div class="btn-group " role="group" aria-label="...">
					<button  class="btn btn-sm btn-default" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
						<span class="glyphicon glyphicon-filter"></span>Filtros <!--<?php #echo $titulo; ?>-->
					</button>
				</div>				
			</li>						
			<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
				<div class="btn-group " role="group" aria-label="...">
					<a <?php if (preg_match("/relatorio\/parcelas\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
						<a href="<?php echo base_url() . 'relatorio/parcelas/'; ?>">
							<button type="button" class="btn btn-sm btn-default ">
								<span class="glyphicon glyphicon-pencil"></span> Parcelas
							</button>										
						</a>
					</a>
				</div>
				<div class="btn-group " role="group" aria-label="...">
					<a <?php if (preg_match("/relatorio\/balanco\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
						<a href="<?php echo base_url() . 'relatorio/balanco/'; ?>">
							<button type="button" class="btn btn-sm btn-default ">
								<span class="glyphicon glyphicon-pencil"></span> Balanco
							</button>										
						</a>
					</a>
				</div>							
			</li>						
			<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
				<div class="btn-group " role="group" aria-label="...">
					<a <?php if (preg_match("/agenda/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
						<a href="<?php echo base_url() . 'agenda/'; ?>">
							<button type="button" class="btn btn-sm btn-active ">
								<span class="glyphicon glyphicon-remove"></span> Fechar
							</button>										
						</a>
					</a>
				</div>
				<div class="btn-group" role="group" aria-label="..."> </div>							
			</li>						
		</ul>
	</div>
  </div>
</nav>
<div class="col-md-6 ">
	<div class="panel panel-info">
		<div class="panel-heading">			
			<?php echo (isset($list1)) ? $list1 : FALSE ?>
		</div>
	</div>
</div>
<div class="col-md-6 ">	
	<div class="panel panel-danger">
		<div class="panel-heading">	
			<?php echo (isset($list2)) ? $list2 : FALSE ?>	
		</div>
	</div>
</div>

<?php echo form_open('relatorio/financeiro', 'role="form"'); ?>

<div class="modal fade bs-excluir-modal11-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header bg-danger">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Evite cadastrar Receitas REPETIDAS!<br>
										"Pesquise"as Receitas Cadastradas!</h4>
			</div>
			<!--
			<div class="modal-body">
				<p>Ao confirmar esta operação todos os dados serão excluídos permanentemente do sistema. 
					Esta operação é irreversível.</p>
			</div>
			-->
			<div class="modal-footer">
				<div class="form-group col-md-3 text-left">
					<div class="form-footer">
						<button  class="btn btn-warning btn-block"" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
							<span class="glyphicon glyphicon-search"></span> Pesquisar
						</button>
					</div>
				</div>
				<!--
				<div class="form-group col-md-3 text-left">
					<div class="form-footer ">
						<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">
							<span class="glyphicon glyphicon-remove"></span> Fechar
						</button>
					</div>
				</div>
				-->
				<div class="form-group col-md-3 text-right">
					<div class="form-footer">		
						<a class="btn btn-success btn-block" href="<?php echo base_url() ?>orcatrata/cadastrar2" role="button">
							<span class="glyphicon glyphicon-plus"></span> Receitas
						</a>
					</div>	
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bs-excluir-modal2-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header bg-danger">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtros das Receitas</h4>
			</div>
			<div class="modal-footer">
				<div class="row">
					<?php if ($_SESSION['log']['NivelEmpresa'] >= 2 ) { ?>	
					<div class="col-md-3 text-left" >
						<label for="Ordenamento">Orçam.:</label>
						<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
								id="Orcarec" name="Orcarec">
							<?php
							foreach ($select['Orcarec'] as $key => $row) {
								if ($query['Orcarec'] == $key) {
									echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
								} else {
									echo '<option value="' . $key . '">' . $row . '</option>';
								}
							}
							?>
						</select>
					</div>
					<?php } ?>	
					<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>	
					<div class="col-md-3 text-left">
						<label for="AprovadoOrca">Aprovado</label>
						<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block " 
								id="AprovadoOrca" name="AprovadoOrca">
							<?php
							foreach ($select['AprovadoOrca'] as $key => $row) {
								if ($query['AprovadoOrca'] == $key) {
									echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
								} else {
									echo '<option value="' . $key . '">' . $row . '</option>';
								}
							}
							?>
						</select>
					</div>
					<div class="col-md-3 text-left">
						<label for="ConcluidoOrca">Concluído</label>
						<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
								id="ConcluidoOrca" name="ConcluidoOrca">
							<?php
							foreach ($select['ConcluidoOrca'] as $key => $row) {
								if ($query['ConcluidoOrca'] == $key) {
									echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
								} else {
									echo '<option value="' . $key . '">' . $row . '</option>';
								}
							}
							?>
						</select>
					</div>
					<?php } ?>	
					<?php if ($_SESSION['log']['NivelEmpresa'] >= 2 ) { ?>
					<div class="col-md-3 text-left">
						<label for="QuitadoOrca">Quitado</label>
						<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block " 
								id="QuitadoOrca" name="QuitadoOrca">
							<?php
							foreach ($select['QuitadoOrca'] as $key => $row) {
								if ($query['QuitadoOrca'] == $key) {
									echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
								} else {
									echo '<option value="' . $key . '">' . $row . '</option>';
								}
							}
							?>
						</select>
					</div>
					<?php } ?>
					<?php if ($_SESSION['log']['idSis_Empresa'] != 5 ) { ?>
					<div class="col-md-3 text-left">
						<label for="Ordenamento">Nome do Cliente:</label>
						<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
								id="NomeCliente" name="NomeCliente">
							<?php
							foreach ($select['NomeCliente'] as $key => $row) {
								if ($query['NomeCliente'] == $key) {
									echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
								} else {
									echo '<option value="' . $key . '">' . $row . '</option>';
								}
							}
							?>
						</select>
					</div>
					<?php } ?>
				</div>
				<br>
				<div class="row">
					<div class="form-group col-md-3 text-left">
						<div class="form-footer ">
							<button class="btn btn-info btn-block" name="pesquisar" value="0" type="submit">
								<span class="glyphicon glyphicon-filter"></span> Filtrar
							</button>
						</div>
					</div>
					<!--
					<div class="form-group col-md-3 text-left">
						<div class="form-footer ">
							<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">
								<span class="glyphicon glyphicon-remove"></span> Fechar
							</button>
						</div>
					</div>
					-->
					<div class="form-group col-md-3 text-left">
						<div class="form-footer">		
							<a class="btn btn-success btn-block" href="<?php echo base_url() ?>relatorio/receitas" role="button">
								<span class="glyphicon glyphicon-search"></span> Receitas
							</a>
						</div>	
					</div>
				</div>							
				<div class="row">
					<div class="col-md-3 text-left">
						<label for="Ordenamento">Tipo de Receita:</label>
						<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
								id="TipoFinanceiroR" name="TipoFinanceiroR">
							<?php
							foreach ($select['TipoFinanceiroR'] as $key => $row) {
								if ($query['TipoFinanceiroR'] == $key) {
									echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
								} else {
									echo '<option value="' . $key . '">' . $row . '</option>';
								}
							}
							?>
						</select>
					</div>
					<div class="col-md-3 text-left">
						<label for="AVAP">À Vista/Prazo</label>
						<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block " 
								id="AVAP" name="AVAP">
							<?php
							foreach ($select['AVAP'] as $key => $row) {
								if ($query['AVAP'] == $key) {
									echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
								} else {
									echo '<option value="' . $key . '">' . $row . '</option>';
								}
							}
							?>
						</select>
					</div>
					<div class="col-md-3 text-left">
						<label for="Modalidade">Parcel/Mensal</label>
						<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block " 
								id="Modalidade" name="Modalidade">
							<?php
							foreach ($select['Modalidade'] as $key => $row) {
								if ($query['Modalidade'] == $key) {
									echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
								} else {
									echo '<option value="' . $key . '">' . $row . '</option>';
								}
							}
							?>
						</select>
					</div>
					<div class="col-md-3 text-left">
						<label for="Ordenamento">Forma de Pag.</label>
						<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block "
								id="FormaPag" name="FormaPag">
							<?php
							foreach ($select['FormaPag'] as $key => $row) {
								if ($query['FormaPag'] == $key) {
									echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
								} else {
									echo '<option value="' . $key . '">' . $row . '</option>';
								}
							}
							?>
						</select>
					</div>								
				</div>
				<br>
				<div class="row">
					<div class="form-group col-md-3 text-left">
						<div class="form-footer ">
							<button class="btn btn-info btn-block" name="pesquisar" value="0" type="submit">
								<span class="glyphicon glyphicon-filter"></span> Filtrar
							</button>
						</div>
					</div>
					<!--
					<div class="form-group col-md-3 text-left">
						<div class="form-footer ">
							<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">
								<span class="glyphicon glyphicon-remove"></span> Fechar
							</button>
						</div>
					</div>
					-->
					<div class="form-group col-md-3 text-left">
						<div class="form-footer">		
							<a class="btn btn-success btn-block" href="<?php echo base_url() ?>relatorio/receitas" role="button">
								<span class="glyphicon glyphicon-search"></span> Receitas
							</a>
						</div>	
					</div>
				</div>
				<div class="row">								
					<div class="col-md-3 text-left" >
						<label for="Ordenamento">Dia do Venc.:</label>
						<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
								id="Dia" name="Dia">
							<?php
							foreach ($select['Dia'] as $key => $row) {
								if ($query['Dia'] == $key) {
									echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
								} else {
									echo '<option value="' . $key . '">' . $row . '</option>';
								}
							}
							?>
						</select>
					</div>
					<div class="col-md-3 text-left" >
						<label for="Ordenamento">Mês do Venc.:</label>
						<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
								id="Mesvenc" name="Mesvenc">
							<?php
							foreach ($select['Mesvenc'] as $key => $row) {
								if ($query['Mesvenc'] == $key) {
									echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
								} else {
									echo '<option value="' . $key . '">' . $row . '</option>';
								}
							}
							?>
						</select>
					</div>
					<div class="col-md-3 text-left" >
						<label for="Ordenamento">Ano do Venc.:</label>
						<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
								id="Ano" name="Ano">
							<?php
							foreach ($select['Ano'] as $key => $row) {
								if ($query['Ano'] == $key) {
									echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
								} else {
									echo '<option value="' . $key . '">' . $row . '</option>';
								}
							}
							?>
						</select>
					</div>								
					<!--
					<div class="col-md-3 text-left" >
						<label for="Ordenamento">Ano do Venc.:</label>
						<div>
							<input type="text" class="form-control Numero" maxlength="4" placeholder="AAAA"
								   autofocus name="Ano" value="<?php echo set_value('Ano', $query['Ano']); ?>">
						</div>
					</div>
					-->
				</div>
				<br>
				<div class="row">
					<div class="form-group col-md-3 text-left">
						<div class="form-footer ">
							<button class="btn btn-info btn-block" name="pesquisar" value="0" type="submit">
								<span class="glyphicon glyphicon-filter"></span> Filtrar
							</button>
						</div>
					</div>
					<!--
					<div class="form-group col-md-3 text-left">
						<div class="form-footer ">
							<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">
								<span class="glyphicon glyphicon-remove"></span> Fechar
							</button>
						</div>
					</div>
					-->
					<div class="form-group col-md-3 text-left">
						<div class="form-footer">		
							<a class="btn btn-success btn-block" href="<?php echo base_url() ?>relatorio/receitas" role="button">
								<span class="glyphicon glyphicon-search"></span> Receitas
							</a>
						</div>	
					</div>
				</div>

				<div class="row">								
					<div class="col-md-6 text-left">
						<label for="Ordenamento">Ordenamento:</label>
						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<select data-placeholder="Selecione uma opção..." class="form-control btn-block Chosen " 
											id="Campo" name="Campo">
										<?php
										foreach ($select['Campo'] as $key => $row) {
											if ($query['Campo'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>

								<div class="col-md-6">
									<select data-placeholder="Selecione uma opção..." class="form-control btn-block Chosen" 
											id="Ordenamento" name="Ordenamento">
										<?php
										foreach ($select['Ordenamento'] as $key => $row) {
											if ($query['Ordenamento'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>									
	</div>
</div>