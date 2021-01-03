<?php if (isset($msg)) echo $msg; ?>


<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 ">
				
					<?php echo validation_errors(); ?>
					<?php echo form_open_multipart($form_open_path); ?>

					<div class="panel panel-<?php echo $panel; ?>">
						<div class="panel-heading">
							<a class="btn btn-md btn-info" href="<?php echo base_url() ?>tarefa" role="button">
								<span class="glyphicon glyphicon-pencil"></span> <?php echo $titulo; ?>
							</a>
						</div>
						<div class="panel-body">
							
							<div class="panel-group">	
								<div class="panel panel-primary">

									<div  style="overflow: auto; height: 456px; ">
										<div class="panel-body">

											<input type="hidden" name="PMCount" id="PMCount" value="<?php echo $count['PMCount']; ?>"/>

											<div class="input_fields_wrap3">

											<?php
											for ($i=1; $i <= $count['PMCount']; $i++) {
											?>

											<?php if ($metodo > 1) { ?>
											<input type="hidden" name="idApp_Procedimento<?php echo $i ?>" value="<?php echo $procedimento[$i]['idApp_Procedimento']; ?>"/>
											<?php } ?>

											<div class="form-group" id="3div<?php echo $i ?>">
												<div class="panel panel-info">
													<div class="panel-heading">
														<div class="row">
															<div class="col-md-2">
																<label for="Compartilhar<?php echo $i ?>">Quem Fazer:</label>
																<select data-placeholder="Selecione uma opção..." class="form-control"
																		 id="listadinamicac<?php echo $i ?>" name="Compartilhar<?php echo $i ?>">
																	<!--<option value="">-- Selecione uma opção --</option>-->
																	<?php
																	foreach ($select['Compartilhar'] as $key => $row) {
																		if ($procedimento[$i]['Compartilhar'] == $key) {
																			echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																		} else {
																			echo '<option value="' . $key . '">' . $row . '</option>';
																		}
																	}
																	?>
																</select>
															</div>
															<div class="col-md-2">
																<label for="Procedimento<?php echo $i ?>">Tarefa <?php echo $i ?>/<?php echo $count['PMCount'] ?>:</label>
																<textarea class="form-control" id="Procedimento<?php echo $i ?>" <?php echo $readonly; ?>
																		  name="Procedimento<?php echo $i ?>"><?php echo $procedimento[$i]['Procedimento']; ?></textarea>
															</div>
															<div class="col-md-2">
																<label for="Categoria<?php echo $i ?>">Categoria:</label>

																<select data-placeholder="Selecione uma opção..." class="form-control" 
																		 id="listadinamicac<?php echo $i ?>" name="Categoria<?php echo $i ?>">
																	<option value="">-- Selecione uma Categoria --</option>
																	<?php
																	foreach ($select['Categoria'] as $key => $row) {
																		if ($procedimento[$i]['Categoria'] == $key) {
																			echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																		} else {
																			echo '<option value="' . $key . '">' . $row . '</option>';
																		}
																	}
																	?>
																</select>
															</div>															
															<div class="col-md-2">
																<label for="DataProcedimento<?php echo $i ?>">Iniciar em:</label>
																<div class="input-group <?php echo $datepicker; ?>">
																	<span class="input-group-addon" disabled>
																		<span class="glyphicon glyphicon-calendar"></span>
																	</span>
																	<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																		   name="DataProcedimento<?php echo $i ?>" value="<?php echo $procedimento[$i]['DataProcedimento']; ?>">
																</div>
															</div>															
															<div class="col-md-2">
																<label for="DataConcluidoProcedimento<?php echo $i ?>">Concluir em:</label>
																<div class="input-group <?php echo $datepicker; ?>">
																	<span class="input-group-addon" disabled>
																		<span class="glyphicon glyphicon-calendar"></span>
																	</span>
																	<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																		   name="DataConcluidoProcedimento<?php echo $i ?>" value="<?php echo $procedimento[$i]['DataConcluidoProcedimento']; ?>">
																</div>
															</div>
															
															<div class="col-md-2">
																<label for="ConcluidoProcedimento">Concluído? </label><br>
																<div class="form-group">
																	<div class="btn-group" data-toggle="buttons">
																		<?php
																		foreach ($select['ConcluidoProcedimento'] as $key => $row) {
																			(!$procedimento[$i]['ConcluidoProcedimento']) ? $procedimento[$i]['ConcluidoProcedimento'] = 'N' : FALSE;

																			if ($procedimento[$i]['ConcluidoProcedimento'] == $key) {
																				echo ''
																				. '<label class="btn btn-warning active" name="radiobutton_ConcluidoProcedimento' . $i . '" id="radiobutton_ConcluidoProcedimento' . $i .  $key . '">'
																				. '<input type="radio" name="ConcluidoProcedimento' . $i . '" id="radiobuttondinamico" '
																				. 'autocomplete="off" value="' . $key . '" checked>' . $row
																				. '</label>'
																				;
																			} else {
																				echo ''
																				. '<label class="btn btn-default" name="radiobutton_ConcluidoProcedimento' . $i . '" id="radiobutton_ConcluidoProcedimento' . $i .  $key . '">'
																				. '<input type="radio" name="ConcluidoProcedimento' . $i . '" id="radiobuttondinamico" '
																				. 'autocomplete="off" value="' . $key . '" >' . $row
																				. '</label>'
																				;
																			}
																		}
																		?>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

											<?php
											}
											?>

											</div>
										</div>
									</div>
								</div>
							</div>														
							<div class="row">
								<div class="form-group col-md-6">
									<div class="row">	
										<div class="col-md-5 text-left">
											<label  for="Cadastrar">Categoria</label>
											<div class="btn-group" data-toggle="buttons">
												<?php
												foreach ($select['Cadastrar'] as $key => $row) {
													if (!$cadastrar['Cadastrar']) $cadastrar['Cadastrar'] = 'S';

													($key == 'N') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

													if ($cadastrar['Cadastrar'] == $key) {
														echo ''
														. '<label class="btn btn-warning active" name="Cadastrar_' . $hideshow . '">'
														. '<input type="radio" name="Cadastrar" id="' . $hideshow . '" '
														. 'autocomplete="off" value="' . $key . '" checked>' . $row
														. '</label>'
														;
													} else {
														echo ''
														. '<label class="btn btn-default" name="Cadastrar_' . $hideshow . '">'
														. '<input type="radio" name="Cadastrar" id="' . $hideshow . '" '
														. 'autocomplete="off" value="' . $key . '" >' . $row
														. '</label>'
														;
													}
												}
												?>

											</div>
										</div>
										<div class="col-md-4 text-left" id="Cadastrar" <?php echo $div['Cadastrar']; ?>>
											<a class="btn btn-md btn-info"   target="_blank" href="<?php echo base_url() ?>categoria2/cadastrar3/" role="button"> 
												<span class="glyphicon glyphicon-plus"></span>Categoria
											</a>
											
											<button class="btn btn-md btn-primary"  id="inputDb" data-loading-text="Aguarde..." type="submit">
													<span class="glyphicon glyphicon-refresh"></span>Ref.
											</button>
											<?php echo form_error('Cadastrar'); ?>
										</div>
									</div>
								</div>
								<div class="form-group col-md-6">
									<!--<input type="hidden" name="idApp_Cliente" value="<?php echo $_SESSION['Cliente']['idApp_Cliente']; ?>">-->
									<input type="hidden" name="idSis_Empresa" value="<?php echo $orcatrata['idSis_Empresa']; ?>">
									<?php if ($metodo > 1) { ?>
									<!--<input type="hidden" name="idApp_Procedimento" value="<?php echo $procedimento['idApp_Procedimento']; ?>">
									<input type="hidden" name="idApp_ParcelasRec" value="<?php echo $parcelasrec['idApp_ParcelasRec']; ?>">-->
									<?php } ?>
									<?php if ($metodo == 2) { ?>

										<div class="col-md-6">
											<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
												<span class="glyphicon glyphicon-save"></span> Salvar
											</button>
										</div>
										<!--
										<div class="col-md-6 text-right">
											<button  type="button" class="btn btn-lg btn-danger" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
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
														<p>Ao confirmar esta operação todos os dados serão excluídos permanentemente do sistema.
															Esta operação é irreversível.</p>
													</div>
													<div class="modal-footer">
														<div class="col-md-6 text-left">
															<button type="button" class="btn btn-warning" data-dismiss="modal">
																<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
															</button>
														</div>
														<div class="col-md-6 text-right">
															<a class="btn btn-danger" href="<?php echo base_url() . 'orcatrata/excluir2/' . $orcatrata['idApp_OrcaTrata'] ?>" role="button">
																<span class="glyphicon glyphicon-trash"></span> Confirmar Exclusão
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									<?php } else { ?>
										<div class="col-md-6">
											<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
												<span class="glyphicon glyphicon-save"></span> Salvar
											</button>
										</div>

									<?php } ?>
								</div>
							</div>
							
							</form>

						</div>
					</div>
		</div>
	</div>
</div>
