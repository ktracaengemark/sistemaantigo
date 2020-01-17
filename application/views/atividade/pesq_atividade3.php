<nav class="navbar navbar-inverse navbar-fixed-top " role="banner">
  <div class="container-fluid">
	<div class="navbar-header">
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
			<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
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

					<p><b>Nome do Atividade</b>: *</p>

					<div class="row">
						<?php echo form_open($form_open_path, 'role="form"'); ?>
						<div class="col-md-6">
							<input type="text" class="form-control" maxlength="45"
								   autofocus name="Atividade" value="<?php echo $query['Atividade'] ?>">
						</div>

						<div class="col-md-6">
							<?php echo $button ?>
						</div>
						
						<input type="hidden" name="idApp_Atividade" value="<?php echo $query['idApp_Atividade']; ?>">
						</form>

					</div>

					<br>                
					
					<?php if (isset($list)) echo $list; ?>

				</div>

			</div>

		</div>
		<div class="col-md-2"></div>

	</div>
</div>