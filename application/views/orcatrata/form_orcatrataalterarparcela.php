<?php if (isset($msg)) echo $msg; ?>


<div class="container-fluid">
	<div class="row">

		<div class="col-md-1"></div>
		<div class="col-md-10 ">

			<div class="row">

				<div class="col-md-12 col-lg-12">
				
					<?php echo validation_errors(); ?>
					<?php echo form_open_multipart($form_open_path); ?>

					<div class="panel panel-primary panel-<?php echo $panel; ?>">
						<div class="panel-heading">
							<button  class="btn btn-sm btn-info" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
								<span class="glyphicon glyphicon-search"></span> <?php echo $titulo; ?>
							</button>
						</div>
						<div class="panel-body">
							
							<div class="modal fade bs-excluir-modal2-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
								<div class="modal-dialog modal-md" role="document">
									<div class="modal-content">
										<div class="modal-header bg-danger">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtros das Parcelas</h4>
										</div>
										<div class="modal-footer">
											<div class="row">
												<div class="col-md-3 text-left">
													<label for="QuitadoRecebiveis">Parc. Quit.</label>
													<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block" 
															id="QuitadoRecebiveis" name="QuitadoRecebiveis">
														<?php
														foreach ($select['QuitadoRecebiveis'] as $key => $row) {
															if ($query['QuitadoRecebiveis'] == $key) {
																echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
															} else {
																echo '<option value="' . $key . '">' . $row . '</option>';
															}
														}
														?>
													</select>
												</div>
												<div class="col-md-3 text-left" >
													<label for="Ordenamento">Dia do Venc.:</label>
													<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block" 
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
													<label for="Ordenamento">M�s do Venc.:</label>
													<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block" 
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
													<div>
														<input type="text" class="form-control Numero" maxlength="4" placeholder="AAAA"
															   autofocus name="Ano" value="<?php echo set_value('Ano', $query['Ano']); ?>">
													</div>
												</div>
											</div>
											<div class="row">
												<br>
												<div class="form-group col-md-3 text-left">
													<div class="form-footer ">
														<button class="btn btn-success btn-block" name="pesquisar" value="0" type="submit">
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
														<a class="btn btn-warning btn-block" href="<?php echo base_url() ?>relatorio/despesas" role="button">
															<span class="glyphicon glyphicon-ok"></span> Despesas
														</a>
													</div>	
												</div>
											</div>
										</div>									
									</div>								
								</div>
							</div>	
							<div class="panel-group">	
								<div class="panel panel-primary">

									
									<div class="panel-heading text-left">
										<a class="btn btn-primary" type="button" data-toggle="collapse" data-target="#Parcelas1" aria-expanded="false" aria-controls="Parcelas1">
											<span class="glyphicon glyphicon-menu-down"></span> Parcelas
										</a>
									</div>
									
									<div <?php echo $collapse; ?> id="Parcelas1">
										<div class="panel-body">
											<!--App_parcelasRec-->
											<input type="hidden" name="PRCount" id="PRCount" value="<?php echo $count['PRCount']; ?>"/>

											<div class="input_fields_wrap21">

											<?php
											for ($i=1; $i <= $count['PRCount']; $i++) {
											?>

												<?php if ($metodo > 1) { ?>
												<input type="hidden" name="idApp_ParcelasRecebiveis<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['idApp_ParcelasRecebiveis']; ?>"/>
												<?php } ?>

												<div class="form-group" id="21div<?php echo $i ?>">
													<div class="panel panel-warning">
														<div class="panel-heading">
															<div class="row">
																<div class="col-md-2">
																	<label for="ParcelaRecebiveis">Parcela:</label><br>
																	<input type="text" class="form-control" maxlength="6" readonly=""
																		   name="ParcelaRecebiveis<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['ParcelaRecebiveis'] ?>">
																</div>
																<div class="col-md-2">
																	<label for="ValorParcelaRecebiveis">Valor Parcela:</label><br>
																	<div class="input-group" id="txtHint">
																		<span class="input-group-addon" id="basic-addon1">R$</span>
																		<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" id="ValorParcelaRecebiveis<?php echo $i ?>"
																			   name="ValorParcelaRecebiveis<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['ValorParcelaRecebiveis'] ?>">
																	</div>
																</div>
																<div class="col-md-2">
																	<label for="DataVencimentoRecebiveis">Data Venc. Parc.</label>
																	<div class="input-group DatePicker">
																		<span class="input-group-addon" disabled>
																			<span class="glyphicon glyphicon-calendar"></span>
																		</span>
																		<input type="text" class="form-control Date" id="DataVencimentoRecebiveis<?php echo $i ?>" maxlength="10" placeholder="DD/MM/AAAA"
																			   name="DataVencimentoRecebiveis<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['DataVencimentoRecebiveis'] ?>">																
																	</div>
																</div>
																<div class="col-md-2">
																	<label for="ValorPagoRecebiveis">Valor Pago:</label><br>
																	<div class="input-group" id="txtHint">
																		<span class="input-group-addon" id="basic-addon1">R$</span>
																		<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" id="ValorPagoRecebiveis<?php echo $i ?>"
																			   name="ValorPagoRecebiveis<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['ValorPagoRecebiveis'] ?>">
																	</div>
																</div>
																<div class="col-md-2">
																	<label for="DataPagoRecebiveis">Data Pag.</label>
																	<div class="input-group DatePicker">
																		<span class="input-group-addon" disabled>
																			<span class="glyphicon glyphicon-calendar"></span>
																		</span>
																		<input type="text" class="form-control Date" id="DataPagoRecebiveis<?php echo $i ?>" maxlength="10" placeholder="DD/MM/AAAA"
																			   name="DataPagoRecebiveis<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['DataPagoRecebiveis'] ?>">																
																	</div>
																</div>
																<div class="col-md-2">
																	<label for="QuitadoRecebiveis">Quitado????</label><br>
																	<div class="form-group">
																		<div class="btn-group" data-toggle="buttons">
																			<?php
																			foreach ($select['QuitadoRecebiveis'] as $key => $row) {
																				(!$parcelasrec[$i]['QuitadoRecebiveis']) ? $parcelasrec[$i]['QuitadoRecebiveis'] = 'N' : FALSE;

																				if ($parcelasrec[$i]['QuitadoRecebiveis'] == $key) {
																					echo ''
																					. '<label class="btn btn-warning active" name="radiobutton_QuitadoRecebiveis' . $i . '" id="radiobutton_QuitadoRecebiveis' . $i .  $key . '">'
																					. '<input type="radio" name="QuitadoRecebiveis' . $i . '" id="radiobuttondinamico" '
																					. 'onchange="carregaQuitado(this.value,this.name,'.$i.')" '
																					. 'autocomplete="off" value="' . $key . '" checked>' . $row
																					. '</label>'
																					;
																				} else {
																					echo ''
																					. '<label class="btn btn-default" name="radiobutton_QuitadoRecebiveis' . $i . '" id="radiobutton_QuitadoRecebiveis' . $i .  $key . '">'
																					. '<input type="radio" name="QuitadoRecebiveis' . $i . '" id="radiobuttondinamico" '
																					. 'onchange="carregaQuitado(this.value,this.name,'.$i.')" '
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
															<!--
															<div class="row">
																<div class="col-md-10"></div>
																<div class="col-md-2 text-right">
																	<label><br></label><br>
																	<button type="button" id="<?php echo $i ?>" class="remove_field21 btn btn-danger">
																		<span class="glyphicon glyphicon-trash"></span>
																	</button>
																</div>
															</div>
															-->
														</div>
													</div>
												</div>

											<?php
											}
											?>
											</div>
											<!--
											<div class="panel panel-warning">
												<div class="panel-heading">										
													<div class="form-group">	
														<div class="row">	
															<div class="col-md-2 text-left">
																<button class="btn btn-warning" type="button" data-toggle="collapse" onclick="adicionaParcelasRecebiveis()"
																		data-target="#Parcelas" aria-expanded="false" aria-controls="Parcelas">
																	<span class="glyphicon glyphicon-plus"></span> Adicionar Parcelas
																</button>
															</div>
														</div>
													</div>	
												</div>
											</div>
											-->
										</div>
									</div>
								</div>
							</div>
							
							<div class="panel-group">	
								<div class="panel panel-primary">

									<div class="panel-heading text-left">
										<a class="btn btn-primary" type="button" data-toggle="collapse" data-target="#Statusorca" aria-expanded="false" aria-controls="Statusorca">
											<span class="glyphicon glyphicon-menu-down"></span> Status
										</a>
									</div>
									
									<div <?php echo $collapse; ?> id="Statusorca">
										<div class="panel-body">
											<div class="form-group">
												<div class="panel panel-info">
													<div class="panel-heading">

														<div class="col-md-1"></div>
														<div class="form-group text-left">
															<div class="row">
																<div class="col-md-3">
																	<label for="DataOrca">Data da Edi��o:</label>
																	<div class="input-group <?php echo $datepicker; ?>">
																		<span class="input-group-addon" disabled>
																			<span class="glyphicon glyphicon-calendar"></span>
																		</span>
																		<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																				name="DataOrca" value="<?php echo $orcatrata['DataOrca']; ?>">
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<div class="row">
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
														<p>Ao confirmar esta opera��o todos os dados ser�o exclu�dos permanentemente do sistema.
															Esta opera��o � irrevers�vel.</p>
													</div>
													<div class="modal-footer">
														<div class="col-md-6 text-left">
															<button type="button" class="btn btn-warning" data-dismiss="modal">
																<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
															</button>
														</div>
														<div class="col-md-6 text-right">
															<a class="btn btn-danger" href="<?php echo base_url() . 'orcatrata/excluir2/' . $orcatrata['idApp_OrcaTrata'] ?>" role="button">
																<span class="glyphicon glyphicon-trash"></span> Confirmar Exclus�o
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
		<div class="col-md-1"></div>
	</div>
</div>
