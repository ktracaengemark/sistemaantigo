<?php if (isset($msg)) echo $msg; ?>
<div class="container col-sm-offset-1 col-md-5 ">
    <?php echo form_open('loginempresa', 'role="form"'); ?>

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
		<script>
			function mostrarSenha(){
				var tipo = document.getElementById("inputPassword");
				if(tipo.type == "password"){
					tipo.type = "text";
					$('.Mostrar').hide();
					$('.NMostrar').show();
				}else{
					tipo.type = "password";
					$('.Mostrar').show();
					$('.NMostrar').hide();
				}
			}
		</script>
	</div>
	<div class="col-md-2 "></div>
	<div class="col-md-5 ">
		<div class="row">	

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
			<label class="sr-only">Celular do Admin</label>
			<input type="text" id="inputText" maxlength="11" class="form-control" placeholder="Celular Admin (xx)999999999" autofocus name="CelularAdmin" value="<?php echo set_value('CelularAdmin'); ?>">	   
			<?php echo form_error('CelularAdmin'); ?>
			<label class="sr-only">Senha</label>
			<div class="input-group">
				<input type="password" name="Senha" id="inputPassword" placeholder="Digite a sua senha" class="form-control btn-sm " value="">
				<span class="input-group-btn">
					<button class="btn btn-info btn-md " type="button" onclick="mostrarSenha()">
						
						<span class="Mostrar glyphicon glyphicon-eye-open"></span>
						
						<span class="NMostrar glyphicon glyphicon-eye-close"></span>
						
					</button>
				</span>
			</div>
			<!--<input type="password" id="inputPassword" class="form-control" placeholder="Senha" name="Senha" value="">-->
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
				<span class="glyphicon glyphicon-search"></span> Produtos & Servi�os
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
			<a href="http://159.89.138.173/passareladoslanches" target="_blank"><img src="<?php echo base_url() . 'arquivos/imagens/patroc/profile-37.jpg'; ?>" alt="..." class="team-img"><h5>Passarela dos Lanches</h5></a>
		  </div>
		</div>
		<div class="col-md-6 col-sm-3 col-xs-6">
		  <div class="thumbnail"> 
			<a href="http://159.89.138.173/academia" target="_blank"><img src="<?php echo base_url() . 'arquivos/imagens/patroc/profile-34.jpg'; ?>" alt="..." class="team-img"><h5>Fitness Brasil</h5></a>
		  </div>
		</div>				
	</div>
	<div class="row">
		<div class="col-md-6 col-sm-3 col-xs-6">
		  <div class="thumbnail"> 
			<a href="http://159.89.138.173/espmmoda" target="_blank"><img src="<?php echo base_url() . 'arquivos/imagens/patroc/profile-43.jpg'; ?>" alt="..." class="team-img"><h5>M�os a Moda</h5></a>
		  </div>
		</div>
		<div class="col-md-6 col-sm-3 col-xs-6">
		  <div class="thumbnail"> 
			<a href="http://159.89.138.173/salaoadrielly" target="_blank"><img src="<?php echo base_url() . 'arquivos/imagens/patroc/profile-50.jpg'; ?>" alt="..." class="team-img"><h5>Sal�o Adrielly</h5></a>
		  </div>
		</div>			
	</div>
</div>
<div class="container col-md-2 text-center"></div>