<?php if (isset($msg)) echo $msg; ?>
<div class="container col-sm-offset-3 col-md-3 ">
    <?php echo form_open('loginempresa', 'role="form"'); ?>

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
	<center>
		<div class="container col-sm-offset-1 col-md-10">
			<label class="sr-only">Empresa</label>
			<select data-placeholder="Selecione uma op��o..." class="form-control" id="idSis_Empresa" name="idSis_Empresa">			
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
			<label class="sr-only">CPF do Admin</label>
			<input type="text" id="inputText" maxlength="11" class="form-control" placeholder="CPF do Admin - 99999999999" autofocus name="CpfAdmin" value="<?php echo set_value('CpfAdmin'); ?>">	   
			<?php echo form_error('CpfAdmin'); ?>
			<label class="sr-only">Senha</label>
			<input type="password" id="inputPassword" class="form-control" placeholder="Senha" name="Senha" value="">
			<?php echo form_error('Senha'); ?>
			<input type="hidden" name="modulo" value="<?php echo $modulo; ?>">
			<button class="btn btn-lg btn-warning btn-block" type="submit"><span class="glyphicon glyphicon-log-in"></span> Conta Admin.</button>
			<br>
			<!--<p><a href="<?php echo base_url(); ?>loginempresa/recuperar/?usuario=<?php echo set_value('CpfAdmin'); ?>">Esqueci Admin./senha!</a></p>-->
			<a class="btn btn-lg btn-success btn-block" href="<?php echo base_url(); ?>pesquisar/empresas" role="button">
				<span class="glyphicon glyphicon-search"></span> Produtos & Servi�os
			</a>
			<br>	
			<a class="btn btn  btn-primary btn-block" href="<?php echo base_url(); ?>login/index2" role="button"><span class="glyphicon glyphicon-log-in"></span> Conta Empresa</a>
			<a class="btn btn  btn-danger btn-block" href="<?php echo base_url(); ?>login/index1" role="button"><span class="glyphicon glyphicon-log-in"></span> Conta Pessoal</a>
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
			<a href="https://www.enkontraki.com/espmmoda" target="_blank"><img src="<?php echo base_url() . 'arquivos/imagens/patroc/profile-43.png'; ?>" alt="..." class="team-img"><h5>M�os a Moda</h5></a>
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