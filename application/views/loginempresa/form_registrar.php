<div class="container" id="login">

    <?php #echo validation_errors(); ?>

    <?php if (isset($msg)) echo $msg; ?>

    <?php echo form_open('loginempresa/registrar', 'role="form"'); ?>

    <!--
    <p class="text-center">
        <a href="<?php echo base_url() . '/' . $_SESSION['log']['modulo']; ?>">
        <a href="<?php echo base_url() ?>">
            <img src="<?php echo base_url() . 'arquivos/imagens/' . $_SESSION['log']['modulo'] . '.png' ; ?>" width="25%" />
        </a>
    </p>
    -->
	<p class="text-center">
        <a href="<?php echo base_url(); ?>loginempresa/registrar">
            <img src="<?php echo base_url() . 'arquivos/imagens/' . $modulo . '.png'; ?>" />
        </a>
    </p>
    <h2 class="form-signin-heading text-center">Nova Empresa</h2>

	<label for="NomeEmpresa">Nome da Empresa:</label>
	<input type="text" class="form-control" id="NomeEmpresa" maxlength="45" 
		   autofocus name="NomeEmpresa" value="<?php echo $query['NomeEmpresa']; ?>">
	<?php echo form_error('NomeEmpresa'); ?>
	<br>
<!--
	<label for="NumUsuarios">Nº de Usuários:*</label>
	<select data-placeholder="Selecione uma opção..." class="form-control" id="NumUsuarios" name="NumUsuarios">			
		<option value="">-- Selecione uma NumUsuarios --</option>
		<?php
		foreach ($select['NumUsuarios'] as $key => $row) {
			(!$query['NumUsuarios']) ? $query['NumUsuarios'] = '1' : FALSE;
			if ($query['NumUsuarios'] == $key) {
				echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
			} else {
				echo '<option value="' . $key . '">' . $row . '</option>';
			}
		}
		?>   
	</select> 
    <?php #echo form_error('NumUsuarios'); ?>
    <br>
-->	
	<label for="NomeAdmin">Nome do Administrador:</label>
    <input type="text" class="form-control" id="NomeAdmin" maxlength="255"
           name="NomeAdmin" value="<?php echo $query['NomeAdmin']; ?>">
    <?php echo form_error('NomeAdmin'); ?>
    <br>

    <label for="Celular">Celular do Administrador:</label>
    <input type="text" class="form-control Celular Celular" id="Celular" maxlength="11"
           name="Celular" placeholder="(XX)999999999" value="<?php echo $query['Celular']; ?>">
    <?php echo form_error('Celular'); ?>
    <br>
<!--	
    <label class="text-">E-mail:</label>
    <input type="text" class="form-control" id="Email" maxlength="100"
           name="Email" value="<?php echo $query['Email']; ?>">
    <?php #echo form_error('Email'); ?>
    <br>

    <label for="UsuarioEmpresa">Usuário Admin:</label>
    <input type="text" class="form-control" id="UsuarioEmpresa" maxlength="45"
           name="UsuarioEmpresa" value="<?php echo $query['UsuarioEmpresa']; ?>">
    <?php #echo form_error('UsuarioEmpresa'); ?>
    <br>
-->
	<label for="CpfAdmin">CPF do Administrador:</label>
    <input type="text" class="form-control " id="CpfAdmin" maxlength="11"
           name="CpfAdmin" placeholder="99999999999" value="<?php echo $query['CpfAdmin']; ?>">
    <?php echo form_error('CpfAdmin'); ?>
    <br>
	
    <label for="Senha">Senha:</label>
    <input type="password" class="form-control" id="Senha" maxlength="45"
           name="Senha" value="<?php echo $query['Senha']; ?>">
    <?php echo form_error('Senha'); ?>
    <br>

    <label for="Senha">Confirmar Senha:</label>
    <input type="password" class="form-control" id="Confirma" maxlength="45"
           name="Confirma" value="<?php echo $query['Confirma']; ?>">
    <?php echo form_error('Confirma'); ?>
    <br>
	
    <button class="btn btn-lg btn-warning btn-block" type="submit">REGISTRAR</button>
	<br>
	<a class="btn btn btn-primary btn-block" href="<?php echo base_url(); ?>login/index" role="button">Acesso dos Usuários</a>
	<a class="btn btn btn-warning btn-block" href="<?php echo base_url(); ?>loginempresa/index" role="button">Acesso dos Administradores</a>		
</form>

</div>
