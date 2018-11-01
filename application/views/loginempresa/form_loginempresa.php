<div class="container text-center" id="login">

    <?php echo validation_errors(); ?>

    <?php if (isset($msg)) echo $msg; ?>

    <?php echo form_open('loginempresa', 'role="form"'); ?>

    <p class="text-center">
        <a href="<?php echo base_url(); ?>loginempresa">
            <img src="<?php echo base_url() . 'arquivos/imagens/' . $modulo . '.png'; ?>" />
        </a>
    </p>
    <!--<h2 class="form-signin-heading text-center">Agenda <?php echo ucfirst($nome_modulo) ?></h2><h4><b>***** vers�o alpha *****</b></h4>-->
    <h2 class="form-signin-heading text-center">Com�rcio & Servi�os</h2>	
	
	<label class="sr-only">Usu�rio</label>
    <input type="text" id="inputText" class="form-control" placeholder="Usu�rio ou E-mail" autofocus name="UsuarioEmpresa" value="<?php echo set_value('UsuarioEmpresa'); ?>">	   
	<label class="sr-only">Senha</label>
    <input type="password" id="inputPassword" class="form-control" placeholder="Senha" name="Senha" value="">
    <input type="hidden" name="modulo" value="<?php echo $modulo; ?>">
    <button class="btn btn-lg btn-warning btn-block" type="submit">Acesso dos Administradores</button>
    <p><a href="<?php echo base_url(); ?>loginempresa/recuperar/?usuario=<?php echo set_value('UsuarioEmpresa'); ?>">Esqueci Admin./senha!</a></p>
    <br>
	<a class="btn btn  btn-primary btn-block" href="<?php echo base_url(); ?>login/index" role="button">Acesso dos Usu�rios</a>	   
	<a class="btn btn  btn-danger btn-block" href="<?php echo base_url(); ?>loginempresa/registrar" role="button">Cadastrar Nova Empresa</a>

</form>

</div>