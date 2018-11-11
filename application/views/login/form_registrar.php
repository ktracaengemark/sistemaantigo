<div class="container" id="login">

    <?php #echo validation_errors(); ?>

    <?php if (isset($msg)) echo $msg; ?>

    <?php echo form_open('login/registrar', 'role="form"'); ?>

    <!--
    <p class="text-center">
        <a href="<?php echo base_url() . '/' . $_SESSION['log']['modulo']; ?>">
        <a href="<?php echo base_url() ?>">
            <img src="<?php echo base_url() . 'arquivos/imagens/' . $_SESSION['log']['modulo'] . '.png' ; ?>" width="25%" />
        </a>
    </p>
    -->
	<p class="text-center">
        <a href="<?php echo base_url(); ?>login">
            <img src="<?php echo base_url() . 'arquivos/imagens/' . $modulo . '.png'; ?>" />
        </a>
    </p>
    <h2 class="form-signin-heading text-center">Conta Pessoal</h2>

	<label class="sr-only">Empresa</label>
	<select data-placeholder="Selecione uma opção..." class="form-control" id="idSis_Empresa" name="idSis_Empresa">			
		
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
	<br>
	
	<label for="Nome">Nome do Usuário:</label>
    <input type="text" class="form-control" id="Nome" maxlength="255"
           name="Nome" value="<?php echo $query['Nome']; ?>">
    <?php echo form_error('Nome'); ?>
    <br>

	<label for="CpfUsuario">CPF do Usuário:</label>
    <input type="text" class="form-control " id="CpfUsuario" maxlength="11"
           name="CpfUsuario" placeholder="99999999999" value="<?php echo $query['CpfUsuario']; ?>">
    <?php echo form_error('CpfUsuario'); ?>
    <br>
	
    <label for="Celular">Celular:</label>
    <input type="text" class="form-control Celular Celular" id="Celular" maxlength="11"
           name="Celular" placeholder="(XX)999999999" value="<?php echo $query['Celular']; ?>">
    <?php echo form_error('Celular'); ?>
    <br>

    <label for="DataNascimento">Data de Nascimento:</label>
    <input type="text" class="form-control Date" id="inputDate0" maxlength="10"
           name="DataNascimento" placeholder="DD/MM/AAAA" value="<?php echo $query['DataNascimento']; ?>">
    <?php echo form_error('DataNascimento'); ?>
    <br>

    <label for="Sexo">Sexo:</label>
    <select data-placeholder="Selecione um TROCA..." class="form-control" id="Sexo" name="Sexo">
        <option value=""></option>
        <?php
        foreach ($select['Sexo'] as $key => $row) {
            if ($query['Sexo'] == $key) {
                echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
            } else {
                echo '<option value="' . $key . '">' . $row . '</option>';
            }
        }
        ?>
    </select>
    <?php echo form_error('Sexo'); ?>
    <br>

    <label class="text-">E-mail:</label>
    <input type="text" class="form-control" id="Email" maxlength="100"
           name="Email" value="<?php echo $query['Email']; ?>">
    <?php echo form_error('Email'); ?>
    <br>

    <label class="text-">Confirmar E-mail:</label>
    <input type="text" class="form-control" id="ConfirmarEmail" maxlength="100"
           name="ConfirmarEmail" value="<?php echo $query['ConfirmarEmail']; ?>">
    <?php echo form_error('ConfirmarEmail'); ?>
    <br>
	
    <label for="Usuario">Usuário:</label>
    <input type="text" class="form-control" id="Usuario" maxlength="45"
           name="Usuario" value="<?php echo $query['Usuario']; ?>">
    <?php echo form_error('Usuario'); ?>
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

    <button class="btn btn-lg btn-success btn-block" type="submit">REGISTRAR</button>
	<br>
	<a class="btn btn btn-primary btn-block" href="<?php echo base_url(); ?>login/index" role="button">Acesso dos Usuários</a>
	<a class="btn btn btn-warning btn-block" href="<?php echo base_url(); ?>loginempresa/index" role="button">Acesso dos Administradores</a>
</form>

</div>
