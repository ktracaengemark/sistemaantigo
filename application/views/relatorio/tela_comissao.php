<?php if ($msg) echo $msg; ?>

<div class="col-md-1 "></div>
<div class="col-md-10 ">		
	<?php echo validation_errors(); ?>
	<div class="panel panel-info">
		<div class="panel-heading">
			<?php echo form_open('relatorio/comissao', 'role="form"'); ?>
			<h4>Comissões</h4>
			<!--
			<div class="btn-group">
				<a type="button" class="btn btn-md btn-warning" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
					<span class="glyphicon glyphicon-filter"></span> Filtrar Receitas
				</a>
				<a class="btn btn-md btn-warning" type="button" href="<?php echo base_url() . 'orcatrata/alterarprodutorec/' . $_SESSION['log']['idSis_Empresa']; ?>">
					<span class="glyphicon glyphicon-pencil"></span> Editar Produtos Filtradas
				</a>
				
				<button type="button" class="btn btn-md btn-warning dropdown-toggle dropdown-toggle-split" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					
					<li>
						<a class="dropdown-item" href="<?php echo base_url() . 'orcatrata/alterarprodutorec/' . $_SESSION['log']['idSis_Empresa']; ?>">
							<span class="glyphicon glyphicon-pencil"></span> Editar Produtos Filtradas
						</a>
					</li>
					
				</ul>
				
			</div>
			-->
			<div class="btn-line">
				<a type="button" class="btn btn-md btn-warning" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
					<span class="glyphicon glyphicon-filter"></span> Filtrar
				</a>
				<a class="btn btn-md btn-warning" type="button" href="<?php echo base_url() . 'orcatrata/baixadacomissao/' . $_SESSION['log']['idSis_Empresa']; ?>">
					<span class="glyphicon glyphicon-pencil"></span> Editar
				</a>
				<!--
				<a class="btn btn-md btn-warning" type="button" href="<?php echo base_url() . 'orcatrata/alterarprodutorec/' . $_SESSION['log']['idSis_Empresa']; ?>">
					<span class="glyphicon glyphicon-print"></span> Impr.
				</a>
				-->
				<!--
				<button type="button" class="btn btn-md btn-warning dropdown-toggle dropdown-toggle-split" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					
					<li>
						<a class="dropdown-item" href="<?php echo base_url() . 'orcatrata/alterarprodutorec/' . $_SESSION['log']['idSis_Empresa']; ?>">
							<span class="glyphicon glyphicon-pencil"></span> Editar Produtos Filtradas
						</a>
					</li>
					
				</ul>
				-->
			</div>
		</div>
		<div class="panel-body">
			<div <?php echo $collapse; ?> id="Receitas">
				<?php echo (isset($list1)) ? $list1 : FALSE ?>
			</div>
		</div>
	</div>
</div>
	
<?php echo form_open('relatorio/comissao', 'role="form"'); ?>
<div class="modal fade bs-excluir-modal2-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bg-info">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtros</h4>
			</div>
			<div class="modal-footer">
				<div class="panel panel-info">
					<div class="panel-heading">							
						<div class="form-group text-left">	
							<div class="row">	
								<div class="col-md-3">
									<label for="Ordenamento">Local de Compra</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
											id="Tipo_Orca" name="Tipo_Orca">
										<?php
										foreach ($select['Tipo_Orca'] as $key => $row) {
											if ($query['Tipo_Orca'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>		
								<div class="col-md-6 text-left">
									<label for="Ordenamento">Colaborador:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen" 
											id="NomeUsuario" name="NomeUsuario">
										<?php
										foreach ($select['NomeUsuario'] as $key => $row) {
											if ($query['NomeUsuario'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3 text-left">
									<label for="AprovadoOrca">Status Pedido:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
											id="AprovadoOrca" name="AprovadoOrca">
										<?php
										foreach ($select['AprovadoOrca'] as $key => $row) {
											if ($query['AprovadoOrca'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<div class="col-md-3 text-left">
									<label for="ConcluidoOrca">Status Produos:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
											id="ConcluidoOrca" name="ConcluidoOrca">
										<?php
										foreach ($select['ConcluidoOrca'] as $key => $row) {
											if ($query['ConcluidoOrca'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<div class="col-md-3 text-left">
									<label for="QuitadoOrca">Status Pagamento:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
											id="QuitadoOrca" name="QuitadoOrca">
										<?php
										foreach ($select['QuitadoOrca'] as $key => $row) {
											if ($query['QuitadoOrca'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<div class="col-md-3 text-left">
									<label for="StatusComissaoOrca">Status Comissão:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
											id="StatusComissaoOrca" name="StatusComissaoOrca">
										<?php
										foreach ($select['StatusComissaoOrca'] as $key => $row) {
											if ($query['StatusComissaoOrca'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>										
							</div>
							<div class="row">
								<div class="col-md-3 text-left">
									<label for="DataInicio">De: "Data Início"</label>
									<div class="input-group DatePicker">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
										<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											   autofocus name="DataInicio" value="<?php echo set_value('DataInicio', $query['DataInicio']); ?>">
										
									</div>
								</div>
								<div class="col-md-3 text-left">
									<label for="DataFim">Até: "Data Fim"</label>
									<div class="input-group DatePicker">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
										<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
												name="DataFim" value="<?php echo set_value('DataFim', $query['DataFim']); ?>">
										
									</div>
								</div>
							</div>
							<!--
							<div class="row">	
								<div class="col-md-12 text-left">
									<label for="Ordenamento">Produtos:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
											id="Produtos" name="Produtos">
										<?php
										foreach ($select['Produtos'] as $key => $row) {
											if ($query['Produtos'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>								
							</div>
							-->
						</div>		
					</div>
				</div>
				<!--
				<div class="panel panel-info">
					<div class="panel-heading">
						<div class="row">								
							<div class="col-md-12 text-left">
								<label for="Ordenamento">Ordenamento:</label>
								<div class="form-group">
									<div class="row">
										<div class="col-md-6">
											<select data-placeholder="Selecione uma opção..." class="form-control btn-block Chosen " 
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
										<div class="col-md-6">
											<select data-placeholder="Selecione uma opção..." class="form-control btn-block Chosen" 
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
						</div>						
					</div>
				</div>
				-->
				<div class="row">
					<div class="form-group col-md-3 text-left">
						<div class="form-footer ">
							<button class="btn btn-warning btn-block" name="pesquisar" value="0" type="submit">
								<span class="glyphicon glyphicon-filter"></span> Filtrar
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>									
	</div>
</div>																				




