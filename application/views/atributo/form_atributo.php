<?php if (isset($msg)) echo $msg; ?>
			
<div class="col-md-12 ">	
<?php #echo validation_errors(); ?>

	<div class="panel panel-<?php echo $panel; ?>">
		<div class="panel-heading">
			<?php echo $titulo; ?> Atributo
			<a class="btn btn-sm btn-info" href="<?php echo base_url() ?>relatorio/atributo" role="button">
				<span class="glyphicon glyphicon-search"></span> Atributo
			</a>
		</div>			
		<div class="panel-body">

			<?php echo form_open_multipart($form_open_path); ?>

			<!--Tab_Atributo-->

			<div class="form-group">
				<div class="panel panel-info">
					<div class="panel-heading">	
						<div class="row">
							<div class="col-md-3">
								<label for="idTab_Catprod">Categoria *</label>
								<?php if ($metodo < 2) { ?>
									<select data-placeholder="Selecione uma opção..." class="form-control"
											id="idTab_Catprod" name="idTab_Catprod">
										<option value="">-- Selecione uma opção --</option>
										<?php
										foreach ($select['idTab_Catprod'] as $key => $row) {
											if ($atributo['idTab_Catprod'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								<?php } else { ?>
									<input type="hidden" id="idTab_Catprod" name="idTab_Catprod" value="<?php echo $_SESSION['Atributo']['idTab_Catprod']; ?>">
									<input class="form-control" readonly="" value="<?php echo $_SESSION['Atributo']['Catprod']; ?>">
								<?php } ?>
								<?php echo form_error('idTab_Catprod'); ?>
							</div>
							<div class="col-md-3">
								<label for="Atributo">Atributo *</label><br>
								<input type="text" class="form-control" maxlength="200"
										name="Atributo" value="<?php echo $atributo['Atributo']; ?>">
								<?php echo form_error('Atributo'); ?>
							</div>
						</div>
					</div>	
				</div>		
			</div>
			
			<?php if ($metodo > 2) { ?>
				<div class="row">		
					<div class="col-md-12">
						<div class="panel-group" id="accordion3" role="tablist" aria-multiselectable="true">
							<div class="panel panel-primary">
								 <div class="panel-heading" role="tab" id="heading3" data-toggle="collapse" data-parent="#accordion3" data-target="#collapse3">
									<h4 class="panel-title">
										<a class="accordion-toggle">
											<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
											Opções
										</a>
									</h4>
								</div>

								<div id="collapse3" class="panel-collapse" role="tabpanel" aria-labelledby="heading3" aria-expanded="false">
									<div class="panel-body">

										<input type="hidden" name="POCount" id="POCount" value="<?php echo $count['POCount']; ?>"/>

										<div class="input_fields_wrap32">

										<?php
										for ($i=1; $i <= $count['POCount']; $i++) {
										?>

										<?php if ($metodo > 1) { ?>
										<input type="hidden" name="idTab_Opcao<?php echo $i ?>" value="<?php echo $opcao[$i]['idTab_Opcao']; ?>"/>
										<?php } ?>

										<div class="form-group" id="32div<?php echo $i ?>">
											<div class="panel panel-info">
												<div class="panel-heading">			
													<div class="row">
														<div class="col-md-6">
															<label for="Opcao">Opção <?php echo $i ?></label>
																<input type="text" class="form-control" id="Opcao<?php echo $i ?>" maxlength="44"
																	name="Opcao<?php echo $i ?>" value="<?php echo $opcao[$i]['Opcao'] ?>">
														</div>											
														<!--
														<div class="col-md-1">
															<label><br></label><br>
															<button type="button" id="<?php echo $i ?>" class="remove_field32 btn btn-danger">
																<span class="glyphicon glyphicon-trash"></span>
															</button>
														</div>
														-->
													</div>
												</div>	
											</div>		
										</div>

										<?php
										}
										?>

										</div>

										<div class="form-group">
											<a class="btn btn-xs btn-danger" onclick="adiciona_opcao()">
												<span class="glyphicon glyphicon-arrow-up"></span> Adiciona Opção
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>	
				</div>
			<?php } ?>
			<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) || ($_SESSION['log']['idSis_Empresa'] == 5))  { ?>
			<div class="form-group">
				<div class="row">
					<!--<input type="hidden" name="idApp_Cliente" value="<?php echo $_SESSION['Cliente']['idApp_Cliente']; ?>">-->
					<input type="hidden" name="idTab_Atributo" value="<?php echo $atributo['idTab_Atributo']; ?>">
					<?php if ($metodo > 1) { ?>
					<!--<input type="hidden" name="idTab_Atributo" value="<?php echo $atributo['idTab_Atributo']; ?>">
					<input type="hidden" name="idApp_ParcelasRec" value="<?php echo $parcelasrec['idApp_ParcelasRec']; ?>">-->
					<?php } ?>
					<?php if ($metodo > 1) { ?>

						<div class="col-md-6">
							<button type="submit" class="btn btn-lg btn-primary" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." >
								<span class="glyphicon glyphicon-save"></span> Salvar
							</button>
						</div>
						<!--
						<div class="col-md-6 text-right">
							<button  type="button" class="btn btn-lg btn-danger" name="submeter2" id="submeter2" onclick="DesabilitaBotao(this.name)" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
								<span class="glyphicon glyphicon-trash"></span> Excluir
							</button>
						</div>
						-->
						<div class="modal fade bs-excluir-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header bg-danger">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title">Tem certeza que deseja excluir?</h4>
									</div>
									<div class="modal-body">
										<p>Ao confirmar a exclusão todos os dados serão excluídos do banco de dados. Esta operação é irreversível.</p>
									</div>
									<div class="modal-footer">
										<div class="col-md-6 text-left">
											<button type="button" class="btn btn-warning" data-dismiss="modal">
												<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
											</button>
										</div>
										<div class="col-md-6 text-right">
											<a class="btn btn-danger" href="<?php echo base_url() . 'atributo/excluir/' . $atributo['idTab_Atributo'] ?>" role="button">
												<span class="glyphicon glyphicon-trash"></span> Confirmar Exclusão
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php } else { ?>
						<div class="col-md-6">
							<button class="btn btn-lg btn-primary" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." type="submit">
								<span class="glyphicon glyphicon-save"></span> Salvar
							</button>
						</div>
					<?php } ?>
				</div>
			</div>
			<?php } ?>
			</form>

		</div>

	</div>

</div>	