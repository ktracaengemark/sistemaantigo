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
						<a class="btn btn-danger btn-lg" href="<?php echo base_url() ?>cliente2/cadastrar3" role="button">
							<span class="glyphicon glyphicon-plus"></span> Novo Cliente
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
<?php if (isset($msg)) echo $msg; ?>
<div class="container-fluid">
	<div class="row">

		<div class="col-md-2"></div>
		<div class="col-md-8">

			<?php echo validation_errors(); ?>

			<div class="panel panel-primary">

				<div class="panel-heading"><strong><?php echo $titulo; ?></strong></div>
				<div class="panel-body">

					<p>Informe <b>o Id, ou Nome, ou Ficha, ou Telefone</b> do Cliente:</p>

					<div class="row">
						<?php echo form_open('cliente2/pesquisar2', 'role="form"'); ?>
						<div class="col-md-6">

							<input type="text" id="inputText" class="form-control"
								   autofocus name="Pesquisa" value="<?php echo set_value('Pesquisa', $Pesquisa); ?>">

						</div>

						<div class="col-md-3">
							<button class="btn btn-sm btn-primary" name="pesquisar" value="0" type="submit">
								<span class="glyphicon glyphicon-search"></span> Pesquisar
							</button>
						</div>
						</form>
						
					<?php if ($cadastrar) { ?>
					
						<div class="col-md-3">                        
							<a class="btn btn-sm btn-warning" href="<?php echo base_url() ?>cliente2/cadastrar3" role="button"> 
								<span class="glyphicon glyphicon-plus"></span> Novo Cadastro
							</a>
						</div>
					
					<?php } ?>
					
					</div>              
					
					<?php if (isset($list)) echo $list; ?>

				</div>

			</div>

		</div>
		<div class="col-md-2"></div>

	</div>
</div>	