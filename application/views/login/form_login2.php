<?php if (isset($msg)) echo $msg; ?>
<div class="container col-sm-offset-1 col-md-5 ">	
    <?php echo form_open('login/index2', 'role="form"'); ?>

	<h2 class="form-signin-heading text-center">enkontraki</h2>		 
	<div class="col-md-5 ">		
		<center>
			<figure>
				<div class="boxVideo">
					<iframe width="270" height="270" src="https://www.youtube.com/embed/videoseries?list=PLPP9yl-2bfZFWltdqkqZ2WSazBo7dnDx1" frameborder="0" allowfullscreen></iframe>
					<!--<iframe width="255" height="255" src="<?php echo base_url() . 'arquivos/videos/apresentacao.mp4'; ?>" frameborder="0" allowfullscreen></iframe>-->
				</div>
			</figure>
		</center>
		<script type="text/javascript">
			$('#ca-container').contentcarousel();
		</script>	
	</div>
	<div class="col-md-2 "></div>
	<div class="col-md-5 ">
		<div class="row">
			<label class="sr-only">Empresa</label>
			<select data-placeholder="Selecione uma opção..." class="form-control" id="idSis_Empresa" name="idSis_Empresa">			
				<option value="">Selecione sua Empresa</option>
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
			<label class="sr-only">Celular do Usuário</label>
			<input type="text" id="inputText" maxlength="11" class="form-control" placeholder="Celular Usuário (xx)999999999" autofocus name="CelularUsuario" value="<?php echo set_value('CelularUsuario'); ?>">	   
			<?php echo form_error('CelularUsuario'); ?>
			<label class="sr-only">Senha</label>
			<input type="password" id="inputPassword" class="form-control" placeholder="Senha" name="Senha" value="">
			<?php echo form_error('Senha'); ?>
			<input type="hidden" name="modulo" value="<?php echo $modulo; ?>">
			<button class="btn btn-md btn-info btn-block" type="submit"><span class="glyphicon glyphicon-log-in"></span> Acessar Conta Empresa</button>	
			
			<!--<p><a href="<?php echo base_url(); ?>login/recuperar/?usuario=<?php echo set_value('CelularUsuario'); ?>">Esqueci usuário/senha!</a></p>-->

			<a class="btn btn btn-warning  btn-block" href="<?php echo base_url(); ?>login/index1" role="button"><span class="glyphicon glyphicon-log-in"></span> Acessar Conta Pessoal</a>			
			<!--
			<a class="btn btn btn-primary btn-block" href="<?php echo base_url(); ?>loginempresa/index" role="button"><span class="glyphicon glyphicon-log-in"></span> Acesso Conta Admin.</a>	
			-->
			<br>
			<a class="btn btn-md btn-success  btn-block" href="<?php echo base_url(); ?>login/index3" role="button">
				<span class="glyphicon glyphicon-plus"></span> Cadastrar Nova Conta
			</a>
			<br>			
			<a class="btn btn-lg btn-danger btn-block" href="<?php echo base_url(); ?>pesquisar/empresas" role="button">
				<span class="glyphicon glyphicon-search"></span> Produtos & Serviços
			</a>		
		</div>	
	</div>	
</div>
<div class="container col-md-4 text-center">
	<center>
	<h2 class="form-signin-heading text-center">patrocinadores</h2>	
	</center>	
	<div class="row">
		<div class="col-md-6 col-sm-3 col-xs-6">
		  <div class="thumbnail"> 
			<a href="https://www.enkontraki.com/passareladoslanches" target="_blank"><img src="<?php echo base_url() . 'arquivos/imagens/patroc/profile-37.jpg'; ?>" alt="..." class="team-img"><h5>Passarela dos Lanches</h5></a>
		  </div>
		</div>
		<div class="col-md-6 col-sm-3 col-xs-6">
		  <div class="thumbnail"> 
			<a href="https://www.enkontraki.com/npastor" target="_blank"><img src="<?php echo base_url() . 'arquivos/imagens/patroc/profile-44.jpg'; ?>" alt="..." class="team-img"><h5>NPastor Advogados</h5></a>
		  </div>
		</div>				
	</div>
	<div class="row">
		<div class="col-md-6 col-sm-3 col-xs-6">
		  <div class="thumbnail"> 
			<a href="https://www.enkontraki.com/espmmoda" target="_blank"><img src="<?php echo base_url() . 'arquivos/imagens/patroc/profile-43.jpg'; ?>" alt="..." class="team-img"><h5>Mãos a Moda</h5></a>
		  </div>
		</div>
		<div class="col-md-6 col-sm-3 col-xs-6">
		  <div class="thumbnail"> 
			<a href="https://www.enkontraki.com/elefantax" target="_blank"><img src="<?php echo base_url() . 'arquivos/imagens/patroc/profile-33.jpg'; ?>" alt="..." class="team-img"><h5>Elefantax</h5></a>
		  </div>
		</div>			
	</div>
</div>
<div class="container col-md-2 text-center"></div>