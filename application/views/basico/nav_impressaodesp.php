<nav class="navbar navbar-inverse navbar-fixed-top " role="banner">
	<div class="container-fluid">
		<div class="row">

			<div class="col-sm-offset-1 col-md-11 ">
				<div class="navbar-header ">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar1">
						<span class="sr-only">MENU</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?php echo base_url() ?>usuario2/prontuario/<?php echo $_SESSION['log']['idSis_Usuario']; ?>"> 
						 <?php echo $_SESSION['log']['Nome2']; ?>./<?php echo $_SESSION['log']['NomeEmpresa2']; ?>.
					</a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar1">

					<ul class="nav navbar-nav navbar-center">
						<li class="btn-toolbar btn-sm navbar-form" role="toolbar" aria-label="...">
							<div class="btn-group " role="group" aria-label="...">
								<a class=" text-left" href="javascript:window.print()">
									<button type="button" class="btn btn-primary">
										<span class="glyphicon glyphicon-print"></span>
									</button>			
								</a>
							</div>
							<!--
							<div class="btn-group " role="group" aria-label="...">
								<a class=" text-left" href="<?php echo base_url() . 'orcatrata/alterardesp/'; ?>">
									<button type="button" class="btn btn-warning">
										<span class="glyphicon glyphicon-edit"></span>
									</button>
								</a>
							</div>
							-->
							<div class="btn-group " role="group" aria-label="...">
								<a class=" text-right" href="<?php echo base_url() . 'relatorio/financeiro/'; ?>">
									<button type="button" class=" btn btn-success">
										<span class="glyphicon glyphicon-th-list"></span>
									</button>
								</a>
							</div>							
							<div class="btn-group " role="group" aria-label="...">
								<a class=" text-left" href="<?php echo base_url() . 'orcatrata/cadastrardesp/'; ?>">
									<button type="button" class=" btn btn-danger">
										<span class="glyphicon glyphicon-plus"></span>
									</button>
								</a>
							</div>
							<div class="btn-group " role="group" aria-label="...">
								<a class=" text-right" href="<?php echo base_url() . 'agenda/'; ?>">
									<button type="button" class=" btn btn-info">
										<span class="glyphicon glyphicon-remove"></span>
									</button>
								</a>
							</div>																											
						</li>
					</ul>
				</div>			
			</div>
		</div>
	</div>
</nav>
<br>
