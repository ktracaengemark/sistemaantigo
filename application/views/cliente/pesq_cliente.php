<?php if (isset($msg)) echo $msg; ?>
<div class="container-fluid">
	<div class="row">

		<div class="col-md-2"></div>
		<div class="col-md-8">

			<?php echo validation_errors(); ?>

			<div class="panel panel-primary">

				<div class="panel-heading"><strong><?php echo $titulo; ?></strong></div>
				<div class="panel-body">

					<!--<p>Informe <b>o Id, ou Nome, ou Ficha, ou Telefone</b> do Cliente:</p>-->

					<div class="row">
						<?php echo form_open('cliente/pesquisar', 'role="form"'); ?>
						<div class="col-md-6">
							<label for="Ordenamento">Nome</label>
							<input type="text" id="inputText" class="form-control"
								   autofocus name="NomeDoCliente" value="<?php echo set_value('NomeDoCliente', $NomeDoCliente); ?>">

						</div>
						<div class="col-md-3">
							<label for="Ordenamento">Ficha</label>
							<input type="text" id="inputText" class="form-control"
								    name="Pesquisa" value="<?php echo set_value('Pesquisa', $Pesquisa); ?>">

						</div>
						<div class="col-md-3">
							<label for="Ordenamento">Telefone</label>
							<input type="text" id="inputText" class="form-control"
								    name="TelefoneDoCliente" value="<?php echo set_value('TelefoneDoCliente', $TelefoneDoCliente); ?>">

						</div>
					</div>	
					<div class="row">	
						<div class="col-md-3">
							<label></label><br>
							<button class="btn btn-sm btn-primary" name="pesquisar" value="0" type="submit">
								<span class="glyphicon glyphicon-search"></span> Pesquisar
							</button>
						</div>
						</form>
						
						<?php if ($cadastrar) { ?>
					
						<div class="col-md-3">                        
							<label></label><br>
							<a class="btn btn-sm btn-warning" href="<?php echo base_url() ?>cliente/cadastrar" role="button"> 
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