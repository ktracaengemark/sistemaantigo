<div class="container text-center" id="login">

    <?php echo validation_errors(); ?>

    <?php if (isset($msg)) echo $msg; ?>

    <?php echo form_open('loginempresamatriz', 'role="form"'); ?>

    <p class="text-center">
        <a href="<?php echo base_url(); ?>loginempresamatriz">
            <img src="<?php echo base_url() . 'arquivos/imagens/' . $modulo . '.png'; ?>" />
        </a>
    </p>
    <!--<h2 class="form-signin-heading text-center">Agenda <?php echo ucfirst($nome_modulo) ?></h2><h4><b>***** vers�o alpha *****</b></h4>-->
    <h2 class="form-signin-heading text-center">Rede Calisi de Vendas</h2>	
	
	<label class="sr-only">Usu�rio</label>
    <input type="text" id="inputText" class="form-control" placeholder="Usu�rio ou E-mail" autofocus name="UsuarioEmpresaMatriz" value="<?php echo set_value('UsuarioEmpresaMatriz'); ?>">	   
	<label class="sr-only">Senha</label>
    <input type="password" id="inputPassword" class="form-control" placeholder="Senha" name="Senha" value="">
    <input type="hidden" name="modulo" value="<?php echo $modulo; ?>">
    <button class="btn btn-lg btn-warning btn-block" type="submit">Acesso do Administrador</button>
    <p><a href="<?php echo base_url(); ?>loginempresamatriz/recuperar/?usuario=<?php echo set_value('UsuarioEmpresaMatriz'); ?>">Esqueci Usu�rio/senha!</a></p>
	<br>
	<a class="btn btn-lg btn-primary btn-block" href="<?php echo base_url(); ?>loginfuncionario/index" role="button">Acesso dos Profissionais</a>
	<br>	
	<!--<a class="btn btn-lg btn-info btn-block" href="<?php echo base_url(); ?>logincliente/index" role="button">Acesso dos Clientes</a>
	<br>-->
	<a class="btn btn-lg btn-success btn-block" href="<?php echo base_url(); ?>loginconsultor/index" role="button">Acesso dos Clientes</a>
	<!--<br>
	<a class="btn btn-lg btn-danger btn-block" href="<?php echo base_url(); ?>loginconsultor/registrar" role="button">Cadastrar Novo Consultor</a>-->

</form>

</div>