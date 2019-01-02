<div class="container text-center" id="login">

    <!--<?php #echo validation_errors(); ?>-->

    <?php if (isset($msg)) echo $msg; ?>

    <?php echo form_open('login/index2', 'role="form"'); ?>

    <p class="text-center">
        <a href="<?php echo base_url(); ?>login/index2">
            <img src="<?php echo base_url() . 'arquivos/imagens/' . $modulo . '.png'; ?>" />
        </a>
    </p>
    <!--<h2 class="form-signin-heading text-center">Agenda <?php echo ucfirst($nome_modulo) ?></h2><h4><b>***** versão alpha *****</b></h4>-->
    <h2 class="form-signin-heading text-center">Conta Empresa</h2>	
	<!--
	<label class="sr-only">Empresa</label>
    <input type="text" id="inputText" class="form-control" placeholder="Empresa" autofocus name="idSis_Empresa" value="<?php echo set_value('idSis_Empresa'); ?>">
	-->
	<label class="sr-only">Empresa</label>
	<select data-placeholder="Selecione uma opção..." class="form-control" id="idSis_Empresa" name="idSis_Empresa">			
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
	<label class="sr-only">Cpf do Usuário</label>
    <input type="text" id="inputText" maxlength="11" class="form-control" placeholder="CPF do Usuário - 99999999999" autofocus name="CpfUsuario" value="<?php echo set_value('CpfUsuario'); ?>">	   
	<?php echo form_error('CpfUsuario'); ?>
	<label class="sr-only">Senha</label>
    <input type="password" id="inputPassword" class="form-control" placeholder="Senha" name="Senha" value="">
    <?php echo form_error('Senha'); ?>
	<input type="hidden" name="modulo" value="<?php echo $modulo; ?>">
    <button class="btn btn-lg btn-primary btn-block" type="submit"><span class="glyphicon glyphicon-log-in"></span> Acesso dos Usuários </button>	
    <br>
	<!--<p><a href="<?php echo base_url(); ?>login/recuperar/?usuario=<?php echo set_value('CpfUsuario'); ?>">Esqueci usuário/senha!</a></p>-->
	<a class="btn btn-lg btn-success btn-block" href="<?php echo base_url(); ?>pesquisar/empresas" role="button">
		<span class="glyphicon glyphicon-search"></span> Produtos & Serviços
	</a>
	<br>	
	<a class="btn btn btn-warning btn-block" href="<?php echo base_url(); ?>loginempresa/index" role="button"><span class="glyphicon glyphicon-log-in"></span> Acesso dos Administradores</a>
	<a class="btn btn btn-danger btn-block" href="<?php echo base_url(); ?>loginempresa/registrar" role="button"><span class="glyphicon glyphicon-plus"></span> Nova Empresa</a>	
	<a class="btn btn btn-primary  btn-block" href="<?php echo base_url(); ?>login/index1" role="button"><span class="glyphicon glyphicon-log-in"></span> Conta Pessoal</a>
	
</form>

</div>