<?php if ($msg) echo $msg; ?>

<div class="col-sm-offset-2 col-md-8 ">		
	
	<?php echo validation_errors(); ?>
	<div class="panel panel-primary">

		<div class="panel-heading">
			<?php echo form_open('relatorio/parcelas', 'role="form"'); ?>
			
			<button  class="btn btn-sm btn-success" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal11-sm">
				<span class="glyphicon glyphicon-plus"></span> Nova
			</button>			
			
			<button  class="btn btn-sm btn-info" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
				<span class="glyphicon glyphicon-filter"></span>Filtrar<?php #echo $titulo1; ?>
			</button>
			<a href="<?php echo base_url() . 'orcatrata/alterarparcelarec/' . $_SESSION['log']['idSis_Empresa']; ?>">
				<button type="button" class="btn btn-sm btn-info">
					<span class="glyphicon glyphicon-edit"></span>
				</button>
			</a>			
			<a class="btn btn-sm btn-warning" href="<?php echo base_url() ?>relatorio/financeiro" role="button">
				<span class="glyphicon glyphicon-search"></span> <?php echo $titulo1; ?>
			</a>

		</div>
		<div class="panel-body">
			<div class="modal fade bs-excluir-modal11-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header bg-danger">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">Evite cadastrar RECEITAS Repetidas!<br>
													"Pesquise"as Receitas Cadastradas!</h4>
						</div>
						<!--
						<div class="modal-body">
							<p>Ao confirmar esta operação todos os dados serão excluídos permanentemente do sistema. 
								Esta operação é irreversível.</p>
						</div>
						-->
						<div class="modal-footer">
							<!--<div class="form-group col-md-3 text-left">
								<div class="form-footer">
									<button  class="btn btn-warning btn-block"" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
										<span class="glyphicon glyphicon-search"></span> Pesquisar
									</button>
								</div>
							</div>-->
							<div class="form-group col-md-3 text-right">
								<div class="form-footer">		
									<a class="btn btn-warning btn-block" href="<?php echo base_url() ?>relatorio/financeiro" role="button">
										<span class="glyphicon glyphicon-search"></span> Pesquisar
									</a>
								</div>	
							</div>							
							<div class="form-group col-md-3 text-left">
								<div class="form-footer ">
									<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">
										<span class="glyphicon glyphicon-remove"> Fechar
									</button>
								</div>
							</div>
							<div class="form-group col-md-3 text-right">
								<div class="form-footer">		
									<a class="btn btn-success btn-block" href="<?php echo base_url() ?>orcatrata/cadastrar2" role="button">
										<span class="glyphicon glyphicon-plus"></span> Receitas
									</a>
								</div>	
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade bs-excluir-modal2-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content">
						<div class="modal-header bg-danger">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtros das Receitas</h4>
						</div>
						<div class="modal-footer">
							<div class="row">								
								<div class="col-md-3 text-left" >
									<label for="Ordenamento">Dia do Venc.:</label>
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
									<label for="Ordenamento">Mês do Venc.:</label>
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
									<label for="Ordenamento">Ano do Venc.:</label>
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
								<div class="col-md-3 text-left">
									<label for="Quitado">Parc. Quit.</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
											id="Quitado" name="Quitado">
										<?php
										foreach ($select['Quitado'] as $key => $row) {
											if ($query['Quitado'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
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
							<br>
							<div class="row">
								<div class="form-group col-md-3 text-left">
									<div class="form-footer ">
										<button class="btn btn-info btn-block" name="pesquisar" value="0" type="submit">
											<span class="glyphicon glyphicon-filter"></span> Filtrar
										</button>
									</div>
								</div>
								<div class="form-group col-md-3 text-left">
									<div class="form-footer ">
										<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">
											<span class="glyphicon glyphicon-remove"> Fechar
										</button>
									</div>
								</div>
								<div class="form-group col-md-3 text-left">
									<div class="form-footer">		
										<a class="btn btn-success btn-block" href="<?php echo base_url() ?>relatorio/financeiro" role="button">
											<span class="glyphicon glyphicon-search"></span> Receitas
										</a>
									</div>	
								</div>
							</div>
							<div class="row">
								<div class="col-md-3 text-left" >
									<label for="Ordenamento">Orçam.:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
											id="Orcarec" name="Orcarec">
										<?php
										foreach ($select['Orcarec'] as $key => $row) {
											if ($query['Orcarec'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<div class="col-md-3 text-left">
									<label for="Ordenamento">Tipo de Receita:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
											id="TipoFinanceiroR" name="TipoFinanceiroR">
										<?php
										foreach ($select['TipoFinanceiroR'] as $key => $row) {
											if ($query['TipoFinanceiroR'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<?php if ($_SESSION['log']['idSis_Empresa'] != 5 ) { ?>
								<div class="col-md-3 text-left">
									<label for="Ordenamento">Nome do Cliente:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
											id="NomeCliente" name="NomeCliente">
										<?php
										foreach ($select['NomeCliente'] as $key => $row) {
											if ($query['NomeCliente'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<?php } ?>									
							</div>
							<br>
							<div class="row">
								<div class="form-group col-md-3 text-left">
									<div class="form-footer ">
										<button class="btn btn-info btn-block" name="pesquisar" value="0" type="submit">
											<span class="glyphicon glyphicon-filter"></span> Filtrar
										</button>
									</div>
								</div>
								<div class="form-group col-md-3 text-left">
									<div class="form-footer ">
										<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">
											<span class="glyphicon glyphicon-remove"> Fechar
										</button>
									</div>
								</div>
								<div class="form-group col-md-3 text-left">
									<div class="form-footer">		
										<a class="btn btn-success btn-block" href="<?php echo base_url() ?>relatorio/financeiro" role="button">
											<span class="glyphicon glyphicon-search"></span> Receitas
										</a>
									</div>	
								</div>
							</div>							
						</div>
					</div>									
												
				</div>
			</div>																				
			</form>

			<?php echo (isset($list1)) ? $list1 : FALSE ?>

		</div>
	</div>

	<?php echo validation_errors(); ?>
	<div class="panel panel-primary">

		<div class="panel-heading">
			<?php echo form_open('relatorio/parcelas', 'role="form"'); ?>
			<button  class="btn btn-sm btn-danger" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal13-sm">
				<span class="glyphicon glyphicon-plus"></span>Nova
			</button>
			<button  class="btn btn-sm btn-info" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal4-sm">
				<span class="glyphicon glyphicon-filter"></span>Filtrar<?php #echo $titulo2; ?>
			</button>
			<a href="<?php echo base_url() . 'orcatrata/alterarparceladesp/' . $_SESSION['log']['idSis_Empresa']; ?>">
				<button type="button" class="btn btn-sm btn-info">
					<span class="glyphicon glyphicon-edit"></span>
				</button>
			</a>			
			<a class="btn btn-sm btn-warning" href="<?php echo base_url() ?>relatorio/financeiro" role="button">
				<span class="glyphicon glyphicon-search"></span><?php echo $titulo2; ?>
			</a>

		</div>
		<div class="panel-body">
			<div class="modal fade bs-excluir-modal13-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header bg-danger">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">Evite cadastrar DESPESAS Repetidas!<br>
													"Pesquise" as Despesas Cadastradas!</h4>
						</div>
						<!--
						<div class="modal-body">
							<p>Ao confirmar esta operação todos os dados serão excluídos permanentemente do sistema. 
								Esta operação é irreversível.</p>
						</div>
						-->
						<div class="modal-footer">
							
							<!--<div class="form-group col-md-3 text-left">
								<div class="form-footer">
									<button  class="btn btn-warning btn-block"" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal4-sm">
										<span class="glyphicon glyphicon-search"></span> Pesquisar
									</button>
								</div>
							</div>-->
							<div class="form-group col-md-3 text-right">
								<div class="form-footer">		
									<a class="btn btn-warning btn-block" href="<?php echo base_url() ?>relatorio/financeiro" role="button">
										<span class="glyphicon glyphicon-search"></span> Pesquisar
									</a>
								</div>	
							</div>							
							<div class="form-group col-md-3 text-left">
								<div class="form-footer ">
									<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">
										<span class="glyphicon glyphicon-remove"> Fechar
									</button>
								</div>
							</div>
							<div class="form-group col-md-3 text-right">
								<div class="form-footer">		
									<a class="btn btn-danger btn-block" href="<?php echo base_url() ?>orcatrata/cadastrardesp" role="button">
										<span class="glyphicon glyphicon-plus"></span> Despesas
									</a>
								</div>	
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade bs-excluir-modal4-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content">
						<div class="modal-header bg-danger">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtros das Despesas</h4>
						</div>
						<div class="modal-footer">							
							<div class="row">
								<div class="col-md-3 text-left" >
									<label for="Ordenamento">Dia do Venc.:</label>
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
									<label for="Ordenamento">Mês do Venc.:</label>
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
									<label for="Ordenamento">Ano do Venc.:</label>
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
								<div class="col-md-3 text-left">
									<label for="Quitado">Parc. Quit.</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
											id="Quitado" name="Quitado">
										<?php
										foreach ($select['Quitado'] as $key => $row) {
											if ($query['Quitado'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
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
							<br>
							<div class="row">
								<div class="form-group col-md-3 text-left">
									<div class="form-footer ">
										<button class="btn btn-info btn-block" name="pesquisar" value="0" type="submit">
											<span class="glyphicon glyphicon-filter"></span> Filtrar
										</button>
									</div>
								</div>
								<div class="form-group col-md-3 text-left">
									<div class="form-footer ">
										<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">
											<span class="glyphicon glyphicon-remove"> Fechar
										</button>
									</div>
								</div>
								<div class="form-group col-md-3 text-left">
									<div class="form-footer">		
										<a class="btn btn-danger btn-block" href="<?php echo base_url() ?>relatorio/financeiro" role="button">
											<span class="glyphicon glyphicon-search"></span> Despesas
										</a>
									</div>	
								</div>
							</div>
							<div class="row">
								<div class="col-md-3 text-left" >
									<label for="Ordenamento">Orçam.:</label>
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
									<label for="Ordenamento">Tipo de Despesa:</label>
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
							<br>
							<div class="row">
								<div class="form-group col-md-3 text-left">
									<div class="form-footer ">
										<button class="btn btn-info btn-block" name="pesquisar" value="0" type="submit">
											<span class="glyphicon glyphicon-filter"></span> Filtrar
										</button>
									</div>
								</div>
								<div class="form-group col-md-3 text-left">
									<div class="form-footer ">
										<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">
											<span class="glyphicon glyphicon-remove"> Fechar
										</button>
									</div>
								</div>
								<div class="form-group col-md-3 text-left">
									<div class="form-footer">		
										<a class="btn btn-danger btn-block" href="<?php echo base_url() ?>relatorio/financeiro" role="button">
											<span class="glyphicon glyphicon-search"></span> Despesas
										</a>
									</div>	
								</div>
							</div>							
						</div>
					</div>									
												
				</div>
			</div>																				
			</form>

			<?php echo (isset($list2)) ? $list2 : FALSE ?>

		</div>
	</div>
	
</div>


