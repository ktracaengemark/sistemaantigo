<?php if ($msg) echo $msg; ?>

<div class="col-md-2"></div>
<div class="col-md-8">		
	<?php echo validation_errors(); ?>
	<div class="panel panel-info">
		<div class="panel-heading">
			<?php echo form_open('relatorio/fiadorec', 'role="form"'); ?>
			<!--<button  class="btn btn-sm btn-success" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal11-sm">
				<span class="glyphicon glyphicon-plus"></span>Rec.<?php #echo $titulo1; ?>
			</button>-->			
			<div class="col-md-6 text-left">
				<label class="sr-only" for="Ordenamento">Cliente:</label>
				<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" onchange="this.form.submit()"
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
			<!--
			<button  class="btn btn-sm btn-info" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
				<span class="glyphicon glyphicon-filter"></span>Filtrar Cliente<?php #echo $titulo1; ?>
			</button>
			-->
			<a href="<?php echo base_url() . 'orcatrata/alterarparcelarecfiado/' . $_SESSION['log']['idSis_Empresa']; ?>">
				<button type="button" class="btn btn-sm btn-info">
					<span class="glyphicon glyphicon-edit"></span> Editar Parcelas Filtradas
				</button>
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
							<div class="form-group">	
								<!--
								<div class="row">								
									<?php if ($_SESSION['log']['idSis_Empresa'] != 5 ) { ?>
									<div class="col-md-12 text-left">
										<label for="Ordenamento">Cliente:</label>
										<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" onchange="this.form.submit()"
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
								-->
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
										<a class="btn btn-success btn-block" href="<?php echo base_url() ?>relatorio/parcelasrec" role="button">
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
			<div <?php echo $collapse; ?> id="Receitas">
				<?php echo (isset($list1)) ? $list1 : FALSE ?>
			</div>
		</div>
	</div>
</div>	


