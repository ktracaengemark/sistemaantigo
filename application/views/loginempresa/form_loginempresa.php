<?php if (isset($msg)) echo $msg; ?>
<div class="container col-sm-offset-1 col-md-5 ">
    <?php echo form_open('loginempresa', 'role="form"'); ?>

	<h2 class="form-signin-heading text-center">enkontraki</h2>		 
	<div class="col-md-5 ">		
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
			<label class="sr-only">Celular do Admin</label>
			<input type="text" id="inputText" maxlength="11" class="form-control" placeholder="Celular Admin (xx)999999999" autofocus name="CelularAdmin" value="<?php echo set_value('CelularAdmin'); ?>">	   
			<?php echo form_error('CelularAdmin'); ?>
			<label class="sr-only">Senha</label>
			<input type="password" id="inputPassword" class="form-control" placeholder="Senha" name="Senha" value="">
			<?php echo form_error('Senha'); ?>
			<input type="hidden" name="modulo" value="<?php echo $modulo; ?>">
			<button class="btn btn-md btn-primary btn-block" type="submit"><span class="glyphicon glyphicon-log-in"></span> Acessar Conta Admin.</button>
			<br>
			<!--<p><a href="<?php echo base_url(); ?>loginempresa/recuperar/?usuario=<?php echo set_value('CelularAdmin'); ?>">Esqueci Admin./senha!</a></p>-->
			<a class="btn btn  btn-warning btn-block" href="<?php echo base_url(); ?>login/index1" role="button"><span class="glyphicon glyphicon-log-in"></span> Acessar Conta Pessoal</a>				
			<a class="btn btn  btn-info btn-block" href="<?php echo base_url(); ?>login/index2" role="button"><span class="glyphicon glyphicon-log-in"></span> Acessar Conta Empresa</a>
			<br>
			<a class="btn btn-md btn-success btn-block" href="<?php echo base_url(); ?>login/index3" role="button">
				<span class="glyphicon glyphicon-plus"></span> Cadastrar Nova Conta
			</a>
			<a class="btn btn-md btn-danger btn-block" href="<?php echo base_url(); ?>pesquisar/empresas" role="button">
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