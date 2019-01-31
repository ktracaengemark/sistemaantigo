<?php if (isset($msg)) echo $msg; ?>
<div class="container col-sm-offset-4 col-md-4 ">
    <?php echo form_open('relatorio/loginempresa', 'role="form"'); ?>

	<div class="col-md-2 "></div>
	<div class="col-md-8 ">
		<div class="row">	

			<label class="sr-only">Empresa</label>
			<select data-placeholder="Selecione uma opção..." class="form-control" id="idSis_Empresa" name="idSis_Empresa" readonly=''>			
				<!--<option value="">Selecione sua Empresa</option>-->
				<?php
				foreach ($select['idSis_Empresa'] as $key => $row) {
					if ($query['idSis_Empresa'] == $key) {
						echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
					} else {
						echo '<option value="' . $key . '">' . $row . '</option>';
					}
				}
				?>   
			</select> 
			<?php echo form_error('idSis_Empresa'); ?>
			<label class="sr-only">Celular do Admin</label>
			<input type="text" id="inputText" maxlength="11" class="form-control" placeholder="Celular Admin (xx)999999999" autofocus name="CelularAdmin" value="<?php echo set_value('CelularAdmin'); ?>">	   
			<?php echo form_error('CelularAdmin'); ?>
			<label class="sr-only">Senha</label>
			<input type="password" id="inputPassword" class="form-control" placeholder="Senha" name="Senha" value="">
			<?php echo form_error('Senha'); ?>
			<input type="hidden" name="modulo" value="<?php echo $modulo; ?>">
			<button class="btn btn-lg btn-primary btn-block" type="submit"><span class="glyphicon glyphicon-log-in"></span> Acessar Conta Admin.</button>
		</div>	
	</div>
	<div class="col-md-2 "></div>
</div>
<div class="container col-md-4"></div>