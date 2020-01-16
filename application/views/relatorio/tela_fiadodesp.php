<?php if ($msg) echo $msg; ?>

<div class="col-md-2"></div>
<div class="col-md-8 ">	
	<?php echo validation_errors(); ?>
	<div class="panel panel-danger">

		<div class="panel-heading">
			<?php echo form_open('relatorio/fiadodesp', 'role="form"'); ?>

			<!--<button  class="btn btn-sm btn-danger" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal13-sm">
				<span class="glyphicon glyphicon-plus"></span>Des.<?php #echo $titulo2; ?>
			</button>
			<button  class="btn btn-sm btn-info" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal4-sm">
				<span class="glyphicon glyphicon-filter"></span>Filtrar Fornecedor<?php #echo $titulo2; ?>
			</button>
			-->
			<div class="col-md-6 text-left">
				<label class="sr-only" for="Ordenamento">Fornecedor:</label>
				<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" onchange="this.form.submit()"
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
			<a href="<?php echo base_url() . 'orcatrata/alterarparceladespfiado/' . $_SESSION['log']['idSis_Empresa']; ?>">
				<button type="button" class="btn btn-sm btn-info">
					<span class="glyphicon glyphicon-edit"></span> Editar Parcelas Filtradas
				</button>
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
						<div class="modal-footer">
							<div class="form-group col-md-3 text-right">
								<div class="form-footer">		
									<a class="btn btn-warning btn-block" href="<?php echo base_url() ?>relatorio/financeiro" role="button">
										<span class="glyphicon glyphicon-search"></span> Pesquisar
									</a>
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
							<div class="form-group">	
								<div class="row">
									<?php if ($_SESSION['log']['idSis_Empresa'] != 5 ) { ?>
									<!--
									<div class="col-md-12 text-left">
										<label for="Ordenamento">Fornecedor:</label>
										<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" onchange="this.form.submit()"
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
									-->
									<?php } ?>
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

								<div class="form-group col-md-3 text-left">
									<div class="form-footer">		
										<a class="btn btn-danger btn-block" href="<?php echo base_url() ?>relatorio/parcelasdesp" role="button">
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
			<div <?php echo $collapse; ?> id="Despesas">
				<?php echo (isset($list2)) ? $list2 : FALSE ?>
			</div>
		</div>
	</div>
</div>


