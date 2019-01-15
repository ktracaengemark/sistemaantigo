<?php if (isset($msg)) echo $msg; ?>

<div class="container col-sm-offset-3 col-md-3 ">
	
	<?php echo form_open('login', 'role="form"'); ?>
<!--
	<p class="text-center">
		<a href="<?php echo base_url(); ?>login">
			<img src="<?php echo base_url() . 'arquivos/imagens/' . $modulo . '.png'; ?>" />
		</a>
	</p>
-->
		

	<!--<div class="about_banner_wrap">
	  <h1 class="m_11">Apresentação</h1>
	</div>
	
	<div class="border"></div>-->
	<h2 class="form-signin-heading text-center">enkontraki</h2>		 
	<center>
		<figure>
			<div class="boxVideo">
				<!--<iframe width="270" height="270" src="https://www.youtube.com/embed/videoseries?list=PLPP9yl-2bfZFWltdqkqZ2WSazBo7dnDx1" frameborder="0" allowfullscreen></iframe>-->
				<iframe width="255" height="255" src="<?php echo base_url() . 'arquivos/videos/apresentacao.mp4'; ?>" frameborder="0" allowfullscreen></iframe>
			</div>
		</figure>
	</center>
	<script type="text/javascript">
		$('#ca-container').contentcarousel();
	</script>

	<!--<h2 class="form-signin-heading text-center">Agenda <?php echo ucfirst($nome_modulo) ?></h2><h4><b>***** versão alpha *****</b></h4>-->

	<!--
	<label class="sr-only">Empresa</label>
	<input type="text" id="inputText" class="form-control" placeholder="Empresa" autofocus name="idSis_Empresa" value="<?php echo set_value('idSis_Empresa'); ?>">
	-->
	<!--
	<label class="sr-only">Empresa</label>
	<select data-placeholder="Selecione uma opção..." class="form-control" id="idSis_Empresa" name="idSis_Empresa">			
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
	<?php #echo form_error('idSis_Empresa'); ?>
	<label class="sr-only">Usuário</label>
	<input type="text" id="inputText" class="form-control" placeholder="Usuário ou E-mail" autofocus name="Usuario" value="<?php #echo set_value('Usuario'); ?>">	   
	<?php #echo form_error('Usuario'); ?>
	<label class="sr-only">Senha</label>
	<input type="password" id="inputPassword" class="form-control" placeholder="Senha" name="Senha" value="">
	<?php #echo form_error('Senha'); ?>
	<input type="hidden" name="modulo" value="<?php #echo $modulo; ?>">
	<button class="btn btn-lg btn-primary btn-block" type="submit">Acesso dos Usuários </button>	
	<br>
	<p><a href="<?php #echo base_url(); ?>login/recuperar/?usuario=<?php #echo set_value('Usuario'); ?>">Esqueci usuário/senha!</a></p>
	<br>
	-->
	<center>
		<div class="container col-sm-offset-2 col-md-8 ">
			<a class="btn btn-lg btn-warning btn-block" href="<?php echo base_url(); ?>login/index2" role="button">Conta Empresa</a>
			<a class="btn btn-lg btn-danger btn-block" href="<?php echo base_url(); ?>login/index1" role="button">Conta Pessoal</a>	
			<a class="btn btn-lg btn-success btn-block" href="<?php echo base_url(); ?>pesquisar/empresas" role="button">
				<span class="glyphicon glyphicon-search"></span> Produtos & Serviços
			</a>
		</div>
	</center>
</div>

<div class="container col-md-4 text-center">
	<center>
	<h2 class="form-signin-heading text-center">patrocinadores</h2>	
	</center>	
	<div class="row">
		<div class="col-md-6 col-sm-3 col-xs-6">
		  <div class="thumbnail"> 
			<a href="https://www.enkontraki.com/espmmoda" target="_blank"><img src="<?php echo base_url() . 'arquivos/imagens/patroc/profile-43.png'; ?>" alt="..." class="team-img"><h5>Mãos a Moda</h5></a>
		  </div>
		</div>
		<div class="col-md-6 col-sm-3 col-xs-6">
		  <div class="thumbnail"> 
			<a href="https://www.enkontraki.com/npastor" target="_blank"><img src="<?php echo base_url() . 'arquivos/imagens/patroc/profile-44.png'; ?>" alt="..." class="team-img"><h5>NPastor Advog.</h5></a>
		  </div>
		</div>				
	</div>
	<div class="row">
		<div class="col-md-6 col-sm-3 col-xs-6">
		  <div class="thumbnail"> 
			<a href="https://www.enkontraki.com/agevet" target="_blank"><img src="<?php echo base_url() . 'arquivos/imagens/patroc/profile-7.png'; ?>" alt="..." class="team-img"><h5>AgeVet</h5></a>
		  </div>
		</div>
		<div class="col-md-6 col-sm-3 col-xs-6">
		  <div class="thumbnail"> 
			<a href="https://www.enkontraki.com/elefantax" target="_blank"><img src="<?php echo base_url() . 'arquivos/imagens/patroc/profile-33.png'; ?>" alt="..." class="team-img"><h5>Elefantax</h5></a>
		  </div>
		</div>			
	</div>
</div>
<div class="container col-md-2 text-center"></div>
	