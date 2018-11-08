<div class="container text-center" id="login">

    <!--<?php echo validation_errors(); ?>-->

    <?php if (isset($msg)) echo $msg; ?>

    <?php echo form_open('login', 'role="form"'); ?>

    <p class="text-center">
        <a href="<?php echo base_url(); ?>login">
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
					(!$query['idSis_Empresa']) ? $query['idSis_Empresa'] = '5' : FALSE;	
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
    <input type="text" id="inputText" class="form-control" placeholder="Usu�rio ou E-mail" autofocus name="Usuario" value="<?php echo set_value('Usuario'); ?>">	   
	<?php echo form_error('Usuario'); ?>
	<label class="sr-only">Senha</label>
    <input type="password" id="inputPassword" class="form-control" placeholder="Senha" name="Senha" value="">
    <?php echo form_error('Senha'); ?>
	<input type="hidden" name="modulo" value="<?php echo $modulo; ?>">
    <button class="btn btn-lg btn-primary btn-block" type="submit">Acesso dos Usu�rios das Emp.</button>	
    <br>
	<p><a href="<?php echo base_url(); ?>login/recuperar/?usuario=<?php echo set_value('Usuario'); ?>">Esqueci usu�rio/senha!</a></p>
    
	
	<a class="btn btn btn-primary btn-warning btn-block" href="<?php echo base_url(); ?>logincli/index" role="button">Acesso Controle Pessoal</a>
	<a class="btn btn btn-primary btn-warning btn-block" href="<?php echo base_url(); ?>loginempresa/index" role="button">Acesso dos Admin. das Empresas</a>
	<a class="btn btn btn-primary btn-warning btn-block" href="<?php echo base_url(); ?>loginempresamatriz/index" role="button">Acesso do Admin. Ktraca</a>		
	<a class="btn btn btn-primary btn-warning btn-block" href="<?php echo base_url(); ?>loginmatriz/index" role="button">Acesso dos Usu�rio Ktraca</a>
	<a class="btn btn btn-primary btn-danger btn-block" href="<?php echo base_url(); ?>loginempresa/registrar" role="button">Cadastrar Nova Empresa</a>	
	<a class="btn btn btn-primary btn-danger btn-block" href="<?php echo base_url(); ?>logincli/registrar" role="button">Cad. Controle Pessoal</a>
	
</form>

</div>