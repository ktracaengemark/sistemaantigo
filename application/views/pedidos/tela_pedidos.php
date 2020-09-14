<?php if ($msg) echo $msg; ?>
<?php echo validation_errors(); ?>    
	<?php echo form_open('pedidos/pedidos', 'role="form"'); ?>
	<div class="col-md-2 "></div>
	<div class="col-md-8 ">
		<div class="row">	
			<div class="col-md-12 ">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<div class="row">
							<!--
							<div class="col-md-2">	
								<h5 class="text-center"><b> Selecione o Pedido</b><?php #echo $titulo; ?></h5>
							</div>
							-->
							<div class="col-md-4">
								<label>Gestor de Pedidos</label>
								<div class="input-group">
									<span class="input-group-btn">
										<button class="btn btn-info btn-md" type="submit">
											<span class="glyphicon glyphicon-search"></span> 
										</button>
									</span>
									<input type="text" class="form-control Numero" placeholder="Pesquisar Pedido" name="Orcamento" value="<?php echo set_value('Orcamento', $query['Orcamento']); ?>">
								</div>
							</div>
							<!--
								<div class="col-md-3 text-left">
								<br>
								<button class="btn btn-md btn-warning btn-block" name="pesquisar" value="0" type="submit">
									<span class="glyphicon glyphicon-search"></span> Pesquisar
								</button>
							</div>
							
							<div class="col-md-4">
								<div class="form-group">
									<label>Ordenamento</label>
									<div class="row">
										<div class="col-md-7">
											<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
													id="Campo" name="Campo">
												<?php
												foreach ($select['Campo'] as $key => $row) {
													if ($query['Campo'] == $key) {
														echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
													} else {
														echo '<option value="' . $key . '">' . $row . '</option>';
													}
												}
												?>
											</select>
										</div>

										<div class="col-md-5">
											<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
													id="Ordenamento" name="Ordenamento">
												<?php
												foreach ($select['Ordenamento'] as $key => $row) {
													if ($query['Ordenamento'] == $key) {
														echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
													} else {
														echo '<option value="' . $key . '">' . $row . '</option>';
													}
												}
												?>
											</select>
										</div>
									</div>
								</div>
							</div>
							-->
							<div class="col-md-4">										
								<label>Cadastrar novo Pedido</label>
								<a class="btn btn-md btn-danger btn-block" href="<?php echo base_url() ?>orcatrata/cadastrar3" role="button"> 
									<span class="glyphicon glyphicon-plus"></span> Novo Pedido
								</a>
							</div>
						</div>	
					</div>
				</div>
			</div>
		</div>	
		<div class="row">	
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								Aguardando <b>Combinar Entrega</b>
							</div>
							<div class="panel-body">
								
								<?php echo (isset($list_combinar)) ? $list_combinar : FALSE ?>
								
							</div>
						</div>
					</div>
				</div>
				<div class="row">	
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								Aguardando <b>Pagamento OnLine</b>
							</div>
							<div class="panel-body">
								
								<?php echo (isset($list_pagonline)) ? $list_pagonline : FALSE ?>
								
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-info">
							<div class="panel-heading">
								Aguardando <b>Produção</b>
							</div>
							<div class="panel-body">
								
								<?php echo (isset($list_producao)) ? $list_producao : FALSE ?>
								
							</div>
						</div>
					</div>
				</div>
				<div class="row">			
					<div class="col-md-12">
						<div class="panel panel-success">
							<div class="panel-heading">
								Aguardando <b>Envio</b>
							</div>
							<div class="panel-body">
								
								<?php echo (isset($list_envio)) ? $list_envio : FALSE ?>
								
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-warning">
							<div class="panel-heading">
								Aguardando <b>Entrega</b>
							</div>
							<div class="panel-body">
								
								<?php echo (isset($list_entrega)) ? $list_entrega : FALSE ?>
								
							</div>
						</div>
					</div>
				</div>
				<div class="row">			
					<div class="col-md-12">
						<div class="panel panel-warning">
							<div class="panel-heading">
								Aguardando <b>Pagamento</b>
							</div>
							<div class="panel-body">
								
								<?php echo (isset($list_pagamento)) ? $list_pagamento : FALSE ?>
								
							</div>
						</div>
					</div>
				</div>	
			</div>	
		</div>
	</div>	
</form>
