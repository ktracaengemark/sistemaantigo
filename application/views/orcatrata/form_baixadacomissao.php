<?php if (isset($msg)) echo $msg; ?>


<div class="container-fluid">
	<div class="row">

		<div class="col-md-1"></div>
		<div class="col-md-10 ">

			<div class="row">

				<div class="col-md-12 col-lg-12">
				
					<?php echo validation_errors(); ?>
					<?php echo form_open_multipart($form_open_path); ?>

					<div class="panel panel-<?php echo $panel; ?>">
						<div class="panel-heading">
							<a class="btn btn-md btn-warning" href="<?php echo base_url() ?>relatorio/comissao" role="button">
								<span class="glyphicon glyphicon-pencil"></span><?php echo $titulo; ?>
							</a>
						</div>
						<div class="panel-body">

							<div class="panel-group">	
								
								<div class="panel panel-primary">

									<div  style="overflow: auto; height: 456px; ">
										
									
										
											<div class="panel-body">
												<!--App_parcelasRec-->
												<input type="hidden" name="PRCount" id="PRCount" value="<?php echo $count['PRCount']; ?>"/>

												<div class="input_fields_wrap21">

												<?php
												for ($i=1; $i <= $count['PRCount']; $i++) {
												?>

													<?php if ($metodo > 1) { ?>
													<input type="hidden" name="idApp_OrcaTrata<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['idApp_OrcaTrata']; ?>"/>
													<?php } ?>

													<div class="form-group" id="21div<?php echo $i ?>">
														<div class="panel panel-warning">
															<div class="panel-heading">
																<div class="row">
																	<div class="col-md-1">
																		<label for="DataVencimentoOrca">Cont:</label><br>
																		<span><?php echo $i ?>/<?php echo $count['PRCount'] ?></span>
																	</div>
																	<div class="col-md-1">
																		<label for="DataVencimentoOrca">Pedido:</label>
																		<span><?php echo $parcelasrec[$i]['idApp_OrcaTrata'] ?></span>
																	</div>
																	<div class="col-md-2">
																		<label for="DataVencimentoOrca">Venc:</label>
																		<div class="input-group DatePicker">
																			<span class="input-group-addon" disabled>
																				<span class="glyphicon glyphicon-calendar"></span>
																			</span>
																			<input type="text" class="form-control Date" readonly="" id="DataVencimentoOrca<?php echo $i ?>" maxlength="10" placeholder="DD/MM/AAAA"
																				   name="DataVencimentoOrca<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['DataVencimentoOrca'] ?>">																
																		</div>
																	</div>
																	<div class="col-md-2">
																		<label for="ValorRestanteOrca">Valor:</label><br>
																		<div class="input-group" id="txtHint">
																			<span class="input-group-addon" id="basic-addon1">R$</span>
																			<input type="text" class="form-control Valor" readonly="" maxlength="10" placeholder="0,00" id="ValorRestanteOrca<?php echo $i ?>"
																				   name="ValorRestanteOrca<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['ValorRestanteOrca'] ?>">
																		</div>
																	</div>
																	<div class="col-md-2">
																		<label for="ValorComissao">Comissao:</label><br>
																		<div class="input-group" id="txtHint">
																			<span class="input-group-addon" id="basic-addon1">R$</span>
																			<input type="text" class="form-control Valor"  maxlength="10" placeholder="0,00" id="ValorComissao<?php echo $i ?>"
																				   name="ValorComissao<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['ValorComissao'] ?>">
																		</div>
																	</div>
																	<div class="col-md-2">
																		<label for="StatusComissaoOrca">Pago?</label><br>
																		<div class="form-group">
																			<div class="btn-group" data-toggle="buttons">
																				<?php
																				foreach ($select['StatusComissaoOrca'] as $key => $row) {
																					(!$parcelasrec[$i]['StatusComissaoOrca']) ? $parcelasrec[$i]['StatusComissaoOrca'] = 'N' : FALSE;

																					if ($parcelasrec[$i]['StatusComissaoOrca'] == $key) {
																						echo ''
																						. '<label class="btn btn-warning active" name="radiobutton_StatusComissaoOrca' . $i . '" id="radiobutton_StatusComissaoOrca' . $i .  $key . '">'
																						. '<input type="radio" name="StatusComissaoOrca' . $i . '" id="radiobuttondinamico" '
																						. 'autocomplete="off" value="' . $key . '" checked>' . $row
																						. '</label>'
																						;
																					} else {
																						echo ''
																						. '<label class="btn btn-default" name="radiobutton_StatusComissaoOrca' . $i . '" id="radiobutton_StatusComissaoOrca' . $i .  $key . '">'
																						. '<input type="radio" name="StatusComissaoOrca' . $i . '" id="radiobuttondinamico" '
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
						
							<div class="form-group">
								<div class="row">
									<!--<input type="hidden" name="idApp_Cliente" value="<?php echo $_SESSION['Cliente']['idApp_Cliente']; ?>">-->
									<input type="hidden" name="idSis_Empresa" value="<?php echo $_SESSION['log']['idSis_Empresa']; ?>">
									<!--<input type="hidden" name="idSis_Empresa" value="<?php echo $orcatrata['idSis_Empresa']; ?>">-->
									<?php if ($metodo > 1) { ?>
									<?php } ?>
									<?php if ($metodo == 2) { ?>
										<div class="col-md-6 text-left">
											<label for="QuitadoComissão">Todas as Comissões Quitadas?</label><br>
											<div class="btn-group" data-toggle="buttons">
												<?php
												foreach ($select['QuitadoComissão'] as $key => $row) {
													(!$query['QuitadoComissão']) ? $query['QuitadoComissão'] = 'N' : FALSE;

													if ($query['QuitadoComissão'] == $key) {
														echo ''
														. '<label class="btn btn-warning active" name="radiobutton_QuitadoComissão' . '" id="radiobutton_QuitadoComissão' .  $key . '">'
														. '<input type="radio" name="QuitadoComissão' . '" id="radiobuttondinamico" '
														. 'autocomplete="off" value="' . $key . '" checked>' . $row
														. '</label>'
														;
													} else {
														echo ''
														. '<label class="btn btn-default" name="radiobutton_QuitadoComissão' .  '" id="radiobutton_QuitadoComissão' .  $key . '">'
														. '<input type="radio" name="QuitadoComissão' . '" id="radiobuttondinamico" '
														. 'autocomplete="off" value="' . $key . '" >' . $row
														. '</label>'
														;
													}
												}
												?>
											</div>
											<?php #echo form_error('QuitadoComissão'); ?>
										</div>
										<div class="col-md-6 text-right">
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
														<!--
														<div class="col-md-6 text-right">
															<a class="btn btn-danger" href="<?php echo base_url() . 'orcatrata/excluir2/' . $orcatrata['idApp_OrcaTrata'] ?>" role="button">
																<span class="glyphicon glyphicon-trash"></span> Confirmar Exclusão
															</a>
														</div>
														-->
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
		<div class="col-md-1"></div>
	</div>
</div>
