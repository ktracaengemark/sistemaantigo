<?php if ($msg) echo $msg; ?>
<?php echo validation_errors(); ?>    
	<?php echo form_open('despesas/despesas', 'role="form"'); ?>
	<div class="col-md-2 "></div>
	<div class="col-md-8 ">
		<div class="row">	
			<div class="col-md-12 ">
				<div class="panel panel-danger">
					<div class="panel-heading">
						<div class="row">
							<!--
							<div class="col-md-2">	
								<h5 class="text-center"><b> Selecione o Pedido</b><?php #echo $titulo; ?></h5>
							</div>
							-->
							<div class="col-md-4">
								<label>Gestor de Despesas</label>
								<div class="input-group">
									<span class="input-group-btn">
										<button class="btn btn-danger btn-md" type="submit">
											<span class="glyphicon glyphicon-search"></span> 
										</button>
									</span>
									<input type="text" class="form-control Numero" placeholder="Pesquisar Despesa" name="Orcamento" value="<?php echo set_value('Orcamento', $query['Orcamento']); ?>">
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
								<label>Cadastrar Nova Despesa</label>
								<a class="btn btn-md btn-danger btn-block" href="<?php echo base_url() ?>orcatrata/cadastrardesp" role="button"> 
									<span class="glyphicon glyphicon-plus"></span> Nova Compra / Despesa
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
						<div class="panel panel-primary">
							<div class="panel-heading">
								Aguardando <b>Aprovação</b>
							</div>
							<div class="panel-body">
								
								<?php echo (isset($list_aprovar)) ? $list_aprovar : FALSE ?>
								
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
				<div class="row">	
					<div class="col-md-12">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<b>Cancelados</b>
							</div>
							<div class="panel-body">
								
								<?php echo (isset($list_pagonline)) ? $list_pagonline : FALSE ?>
								
							</div>
						</div>
					</div>
				</div>	
			</div>	
		</div>
	</div>	
</form>
