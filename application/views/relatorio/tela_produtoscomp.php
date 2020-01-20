<?php if ($msg) echo $msg; ?>
	
<div class="col-md-2 "></div>
<div class="col-md-8 ">	
	<?php echo validation_errors(); ?>
	<div class="panel panel-danger">

		<div class="panel-heading">
			<?php echo form_open('relatorio/produtoscomp', 'role="form"'); ?>

			<!--<button  class="btn btn-sm btn-danger" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal13-sm">
				<span class="glyphicon glyphicon-plus"></span><?php echo $titulo2; ?>
			</button>			
			<button  class="btn btn-md btn-danger" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
				<span class="glyphicon glyphicon-filter"></span>Filtrar Produtos Compras<?php #echo $titulo2; ?>
			</button>
			
			<a href="<?php echo base_url() . 'orcatrata/alterarprodutodesp/' . $_SESSION['log']['idSis_Empresa']; ?>">
				<button type="button" class="btn btn-md btn-info">
					<span class="glyphicon glyphicon-edit"></span> Editar Filtrados
				</button>
			</a>
			-->
			<div class="btn-group">
				<a type="button" class="btn btn-md btn-primary" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
					<span class="glyphicon glyphicon-filter"></span> Filtrar Produtos
				</a>
				<button type="button" class="btn btn-md btn-primary dropdown-toggle dropdown-toggle-split" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">							
					<li>
						<a class="dropdown-item" href="<?php echo base_url() . 'orcatrata/alterarprodutodesp/' . $_SESSION['log']['idSis_Empresa']; ?>">
							<span class="glyphicon glyphicon-pencil"></span> Editar Produtos Filtradas
						</a>
					</li>
					
				</ul>
			</div>			
			<!--
			<button class="btn btn-sm btn-danger" type="button" data-toggle="collapse" data-target="#Despesas" aria-expanded="false" aria-controls="Despesas">
				<span class="glyphicon glyphicon-menu-up"></span> Compras
			</button>			
			
			<a class="btn btn-sm btn-warning" href="<?php echo base_url() ?>relatorio/parcelas" role="button">
				<span class="glyphicon glyphicon-search"></span>Parcelas
			</a>
			<a class="btn btn-sm btn-success" href="<?php echo base_url() ?>relatorio/balanco" role="button">
				<span class="glyphicon glyphicon-search"></span>Balanço
			</a>
			-->
		</div>
		<div class="panel-body">
			<div <?php echo $collapse; ?> id="Despesas">
				<?php echo (isset($list2)) ? $list2 : FALSE ?>
			</div>
		</div>
	</div>
</div>

<?php echo form_open('relatorio/produtoscomp', 'role="form"'); ?>
<div class="modal fade bs-excluir-modal2-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header bg-danger">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtros</h4>
			</div>
			<div class="modal-footer">
				<div class="panel panel-danger">
					<div class="panel-heading">							
						<div class="form-group text-left">	
							<div class="row">		
								<div class="col-md-12 text-left">
									<label for="Ordenamento">Fornecedor:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
											id="NomeFornecedor" name="NomeFornecedor">
										<?php
										foreach ($select['NomeFornecedor'] as $key => $row) {
											if ($query['NomeFornecedor'] == $key) {
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
						<div class="row">
							<div class="col-md-3 text-left" >
								<label for="Ordenamento">Orçam.Desp:</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
										id="Orcades" name="Orcades">
									<?php
									foreach ($select['Orcades'] as $key => $row) {
										if ($query['Orcades'] == $key) {
											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
										} else {
											echo '<option value="' . $key . '">' . $row . '</option>';
										}
									}
									?>
								</select>
							</div>									
							<div class="col-md-3 text-left">
								<label for="Ordenamento">Tipo Despesa:</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
										id="TipoFinanceiroD" name="TipoFinanceiroD">
									<?php
									foreach ($select['TipoFinanceiroD'] as $key => $row) {
										if ($query['TipoFinanceiroD'] == $key) {
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
				<div class="panel panel-danger">
					<div class="panel-heading">
						<div class="form-group text-left">	
							<div class="row">	
								<div class="col-md-6 text-left">
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
								<div class="col-md-3 text-left">
									<label for="Ordenamento">Prod.Ent?</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
											id="ConcluidoProduto" name="ConcluidoProduto">
										<?php
										foreach ($select['ConcluidoProduto'] as $key => $row) {
											if ($query['ConcluidoProduto'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<div class="col-md-3 text-left">
									<label for="Ordenamento">Prod.Dev?</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
											id="DevolvidoProduto" name="DevolvidoProduto">
										<?php
										foreach ($select['DevolvidoProduto'] as $key => $row) {
											if ($query['DevolvidoProduto'] == $key) {
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
						<div class="form-group text-left">		
							<div class="row">	
								<div class="col-md-3 text-left">
									<label for="Ordenamento">Categoria:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
											id="Prodaux3" name="Prodaux3">
										<?php
										foreach ($select['Prodaux3'] as $key => $row) {
											if ($query['Prodaux3'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<div class="col-md-3 text-left">
									<label for="Ordenamento">Tipo:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
											id="Prodaux2" name="Prodaux2">
										<?php
										foreach ($select['Prodaux2'] as $key => $row) {
											if ($query['Prodaux2'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<div class="col-md-3 text-left">
									<label for="Ordenamento">Esp:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
											id="Prodaux1" name="Prodaux1">
										<?php
										foreach ($select['Prodaux1'] as $key => $row) {
											if ($query['Prodaux1'] == $key) {
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
						<div class="form-group text-left">
							<div class="row">								
								<div class="col-md-3 text-left" >
									<label for="Ordenamento">Dia.:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
											id="Dia" name="Dia">
										<?php
										foreach ($select['Dia'] as $key => $row) {
											if ($query['Dia'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<div class="col-md-3 text-left" >
									<label for="Ordenamento">Mês:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
											id="Mesvenc" name="Mesvenc">
										<?php
										foreach ($select['Mesvenc'] as $key => $row) {
											if ($query['Mesvenc'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<div class="col-md-3 text-left" >
									<label for="Ordenamento">Ano:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
											id="Ano" name="Ano">
										<?php
										foreach ($select['Ano'] as $key => $row) {
											if ($query['Ano'] == $key) {
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
						<div class="row">
							<div class="col-md-4 text-left">
								<label for="DataInicio">Data Início:</label>
								<div class="input-group DatePicker">
									<span class="input-group-addon" disabled>
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
										   autofocus name="DataInicio" value="<?php echo set_value('DataInicio', $query['DataInicio']); ?>">
									
								</div>
							</div>
							<div class="col-md-4 text-left">
								<label for="DataFim">Data Fim:</label>
								<div class="input-group DatePicker">
									<span class="input-group-addon" disabled>
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											name="DataFim" value="<?php echo set_value('DataFim', $query['DataFim']); ?>">
									
								</div>
							</div>											
							<!--
							<div class="col-md-3 text-left" >
								<label for="Ordenamento">Ano do Venc.:</label>
								<div>
									<input type="text" class="form-control Numero" maxlength="4" placeholder="AAAA"
										   autofocus name="Ano" value="<?php echo set_value('Ano', $query['Ano']); ?>">
								</div>
							</div>
							-->
						</div>
					</div>
				</div>							
				<div class="row">								
					<div class="col-md-6 text-left">
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
					
					<div class="col-md-3 text-left">
						<label for="AprovadoOrca">Aprovado</label>
						<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block " 
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
				</div>
				<div class="row">
					<div class="form-group col-md-3 text-left">
						<div class="form-footer ">
							<button class="btn btn-info btn-block" name="pesquisar" value="0" type="submit">
								<span class="glyphicon glyphicon-filter"></span> Filtrar
							</button>
						</div>
					</div>
				</div>
				<!--
				<div class="row">					
					<div class="col-md-3 text-left">
						<label for="AVAP">À Vista/Prazo</label>
						<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block " 
								id="AVAP" name="AVAP">
							<?php
							foreach ($select['AVAP'] as $key => $row) {
								if ($query['AVAP'] == $key) {
									echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
								} else {
									echo '<option value="' . $key . '">' . $row . '</option>';
								}
							}
							?>
						</select>
					</div>
					<div class="col-md-3 text-left">
						<label for="Modalidade">Parcel/Mensal</label>
						<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block " 
								id="Modalidade" name="Modalidade">
							<?php
							foreach ($select['Modalidade'] as $key => $row) {
								if ($query['Modalidade'] == $key) {
									echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
								} else {
									echo '<option value="' . $key . '">' . $row . '</option>';
								}
							}
							?>
						</select>
					</div>
					<div class="col-md-3 text-left">
						<label for="Ordenamento">Forma de Pag.</label>
						<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block "
								id="FormaPag" name="FormaPag">
							<?php
							foreach ($select['FormaPag'] as $key => $row) {
								if ($query['FormaPag'] == $key) {
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
</div>																				




