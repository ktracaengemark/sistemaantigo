<div class="container text-center" id="login">

    <!--<?php echo validation_errors(); ?>-->

    <?php if (isset($msg)) echo $msg; ?>

    <?php echo form_open('loginempresa', 'role="form"'); ?>

    <p class="text-center">
        <a href="<?php echo base_url(); ?>loginempresa">
            <img src="<?php echo base_url() . 'arquivos/imagens/' . $modulo . '.png'; ?>" />
        </a>
    </p>
    <!--<h2 class="form-signin-heading text-center">Agenda <?php echo ucfirst($nome_modulo) ?></h2><h4><b>***** vers�o alpha *****</b></h4>-->
    <h2 class="form-signin-heading text-center">Produtos & Servi�os</h2>	
	<!--
	<label class="sr-only">Empresa</label>
    <input type="text" id="inputText" class="form-control" placeholder="Empresa" autofocus name="idSis_Empresa" value="<?php echo set_value('idSis_Empresa'); ?>">
	-->
	<label for="idSis_Empresa">Empresa</label>
	<select data-placeholder="Selecione uma op��o..." class="form-control" id="idSis_Empresa" name="idSis_Empresa">			
		<option value="">-- Selecione sua Empresa --</option>
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
	<label class="sr-only">Usu�rio</label>
    <input type="text" id="inputText" class="form-control" placeholder="Usu�rio ou E-mail" autofocus name="UsuarioEmpresa" value="<?php echo set_value('UsuarioEmpresa'); ?>">	   
	<?php echo form_error('UsuarioEmpresa'); ?>
	<label class="sr-only">Senha</label>
    <input type="password" id="inputPassword" class="form-control" placeholder="Senha" name="Senha" value="">
    <?php echo form_error('Senha'); ?>
	<input type="hidden" name="modulo" value="<?php echo $modulo; ?>">
    <button class="btn btn-lg btn-warning btn-block" type="submit">Acesso dos Admin. das Empresas</button>
    <p><a href="<?php echo base_url(); ?>loginempresa/recuperar/?usuario=<?php echo set_value('UsuarioEmpresa'); ?>">Esqueci Admin./senha!</a></p>
    <br>
	<a class="btn btn  btn-primary btn-block" href="<?php echo base_url(); ?>login/index" role="button">Acesso dos Usu�rios</a>
	<a class="btn btn  btn-primary btn-block" href="<?php echo base_url(); ?>loginempresamatriz/index" role="button">Acesso Ktraca</a>
	<a class="btn btn  btn-danger btn-block" href="<?php echo base_url(); ?>loginempresa/registrar" role="button">Cadastrar Nova Empresa</a>

</form>

</div>