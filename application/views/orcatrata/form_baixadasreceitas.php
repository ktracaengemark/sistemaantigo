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
								<a class="btn btn-md btn-warning" href="<?php echo base_url() . $relatorio; ?>" role="button">
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
																	<label for="DataEntregaOrca">Entrega:</label>
																	<div class="input-group DatePicker">
																		<span class="input-group-addon" disabled>
																			<span class="glyphicon glyphicon-calendar"></span>
																		</span>
																		<input type="text" class="form-control Date" readonly="" id="DataEntregaOrca<?php echo $i ?>" maxlength="10" placeholder="DD/MM/AAAA"
																			   name="DataEntregaOrca<?php echo $i ?>" value="<?php echo $orcamento[$i]['DataEntregaOrca'] ?>">																
																	</div>
																</div>
																<div class="col-md-2">
																	<label for="ValorTotalOrca">Valor:</label><br>
																	<div class="input-group" id="txtHint">
																		<span class="input-group-addon" id="basic-addon1">R$</span>
																		<input type="text" class="form-control Valor" readonly="" maxlength="10" placeholder="0,00" id="ValorTotalOrca<?php echo $i ?>"
																			   name="ValorTotalOrca<?php echo $i ?>" value="<?php echo $orcamento[$i]['ValorTotalOrca'] ?>">
																	</div>
																</div>
																<div class="col-md-2">
																	<label for="FinalizadoOrca">Finalizado?</label><br>
																	<div class="form-group">
																		<div class="btn-group" data-toggle="buttons">
																			<?php
																			foreach ($select['FinalizadoOrca'] as $key => $row) {
																				(!$orcamento[$i]['FinalizadoOrca']) ? $orcamento[$i]['FinalizadoOrca'] = 'N' : FALSE;

																				if ($orcamento[$i]['FinalizadoOrca'] == $key) {
																					echo ''
																					. '<label class="btn btn-warning active" name="radiobutton_FinalizadoOrca' . $i . '" id="radiobutton_FinalizadoOrca' . $i .  $key . '">'
																					. '<input type="radio" name="FinalizadoOrca' . $i . '" id="radiobuttondinamico" '
																					. 'autocomplete="off" value="' . $key . '" checked>' . $row
																					. '</label>'
																					;
																				} else {
																					echo ''
																					. '<label class="btn btn-default" name="radiobutton_FinalizadoOrca' . $i . '" id="radiobutton_FinalizadoOrca' . $i .  $key . '">'
																					. '<input type="radio" name="FinalizadoOrca' . $i . '" id="radiobuttondinamico" '
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
									<!--<input type="hidden" name="idSis_Empresa" value="<?php echo $_SESSION['log']['idSis_Empresa']; ?>">-->
									<input type="hidden" name="idSis_Empresa" value="<?php echo $empresa['idSis_Empresa']; ?>">
									
									<div class="col-md-6 text-left">
										<label for="QuitadoComissão">Todas as Receitas Finalizadas?</label><br>
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
