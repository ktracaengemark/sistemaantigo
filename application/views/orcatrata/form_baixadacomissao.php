<?php if (isset($msg)) echo $msg; ?>


<div class="container-fluid">
	<div class="row">

		<div class="col-md-12 ">

			<div class="row">

				<div class="col-md-12 col-lg-12">
				
					<?php echo validation_errors(); ?>
					<?php echo form_open_multipart($form_open_path); ?>

					<div class="panel panel-<?php echo $panel; ?>">
						<div class="panel-heading">
							<div class="btn-line">
								<a class="btn btn-md btn-warning" href="<?php echo base_url() . $comissao; ?>" role="button">
									<span class="glyphicon glyphicon-pencil"></span><?php echo $titulo; ?>
								</a>
								<a class="btn btn-md btn-warning" type="button" href="<?php echo base_url() . $imprimir . $_SESSION['log']['idSis_Empresa']; ?>">
									<span class="glyphicon glyphicon-print"></span> Print.
								</a>
								<a class="btn btn-md btn-warning" href="" role="button">
									<span class="glyphicon glyphicon-usd"></span>R$ <?php echo $somatotal; ?>
								</a>
							</div>	
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

												
												<input type="hidden" name="idApp_OrcaTrata<?php echo $i ?>" value="<?php echo $orcamento[$i]['idApp_OrcaTrata']; ?>"/>
												
												<div class="form-group" id="21div<?php echo $i ?>">
													<div class="panel panel-warning">
														<div class="panel-heading">
															<div class="row">
																<div class="col-md-2">
																	<label for="DataVencimentoOrca">Cont - Pedido - Local:</label><br>
																	<span><?php echo $i ?>/<?php echo $count['PRCount'] ?>
																		- <?php echo $orcamento[$i]['idApp_OrcaTrata'] ?>
																		
																		- <?php if($orcamento[$i]['Tipo_Orca'] == "O") {
																					echo 'On Line';
																				} elseif($orcamento[$i]['Tipo_Orca'] == "B"){
																					echo 'Na Loja';
																				}else{
																					echo 'Outros';
																				}?>
																	</span>
																</div>
																<div class="col-md-2">
																	<label><?php echo $nome; ?>:</label><br>
																	<span><?php echo $orcamento[$i][$nome] ?></span>	
																</div>
																<div class="col-md-2">
																	<label for="DataVencimentoOrca">Venc:</label>
																	<div class="input-group DatePicker">
																		<span class="input-group-addon" disabled>
																			<span class="glyphicon glyphicon-calendar"></span>
																		</span>
																		<input type="text" class="form-control Date" readonly="" id="DataVencimentoOrca<?php echo $i ?>" maxlength="10" placeholder="DD/MM/AAAA"
																			   name="DataVencimentoOrca<?php echo $i ?>" value="<?php echo $orcamento[$i]['DataVencimentoOrca'] ?>">																
																	</div>
																</div>
																<div class="col-md-2">
																	<label for="ValorRestanteOrca">Valor:</label><br>
																	<div class="input-group" id="txtHint">
																		<span class="input-group-addon" id="basic-addon1">R$</span>
																		<input type="text" class="form-control Valor" readonly="" maxlength="10" placeholder="0,00" id="ValorRestanteOrca<?php echo $i ?>"
																			   name="ValorRestanteOrca<?php echo $i ?>" value="<?php echo $orcamento[$i]['ValorRestanteOrca'] ?>">
																	</div>
																</div>
																<div class="col-md-2">
																	<label for="ValorComissao">Comissao:</label><br>
																	<div class="input-group" id="txtHint">
																		<span class="input-group-addon" id="basic-addon1">R$</span>
																		<input type="text" class="form-control Valor"  maxlength="10" placeholder="0,00" id="ValorComissao<?php echo $i ?>"
																			   name="ValorComissao<?php echo $i ?>" value="<?php echo $orcamento[$i]['ValorComissao'] ?>">
																	</div>
																</div>
																<?php if ($metodo == 1) { ?>
																	<div class="col-md-2">
																		<label for="StatusComissaoOrca">Pago NaLoja?</label><br>
																		<div class="form-group">
																			<div class="btn-group" data-toggle="buttons">
																				<?php
																				foreach ($select['StatusComissaoOrca'] as $key => $row) {
																					(!$orcamento[$i]['StatusComissaoOrca']) ? $orcamento[$i]['StatusComissaoOrca'] = 'N' : FALSE;

																					if ($orcamento[$i]['StatusComissaoOrca'] == $key) {
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
																<?php } else if ($metodo == 2) { ?>
																	<div class="col-md-2">
																		<label for="StatusComissaoOrca_Online">Pago OnLine?</label><br>
																		<div class="form-group">
																			<div class="btn-group" data-toggle="buttons">
																				<?php
																				foreach ($select['StatusComissaoOrca_Online'] as $key => $row) {
																					(!$orcamento[$i]['StatusComissaoOrca_Online']) ? $orcamento[$i]['StatusComissaoOrca_Online'] = 'N' : FALSE;

																					if ($orcamento[$i]['StatusComissaoOrca_Online'] == $key) {
																						echo ''
																						. '<label class="btn btn-warning active" name="radiobutton_StatusComissaoOrca_Online' . $i . '" id="radiobutton_StatusComissaoOrca_Online' . $i .  $key . '">'
																						. '<input type="radio" name="StatusComissaoOrca_Online' . $i . '" id="radiobuttondinamico" '
																						. 'autocomplete="off" value="' . $key . '" checked>' . $row
																						. '</label>'
																						;
																					} else {
																						echo ''
																						. '<label class="btn btn-default" name="radiobutton_StatusComissaoOrca_Online' . $i . '" id="radiobutton_StatusComissaoOrca_Online' . $i .  $key . '">'
																						. '<input type="radio" name="StatusComissaoOrca_Online' . $i . '" id="radiobuttondinamico" '
																						. 'autocomplete="off" value="' . $key . '" >' . $row
																						. '</label>'
																						;
																					}
																				}
																				?>
																			</div>
																		</div>
																	</div>
																<?php } ?>
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
									<!--<input type="hidden" name="idSis_Empresa" value="<?php echo $empresa['idSis_Empresa']; ?>">-->
									
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
								</div>
							</div>
						</div>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
