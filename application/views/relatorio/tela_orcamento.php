<?php if ($msg) echo $msg; ?>
    <div class="col-md-12">
		<div class="row">
				
			<div class="main">

				<?php echo validation_errors(); ?>

				<div class="panel panel-primary">

					<div class="panel-heading"><strong><?php echo $titulo; ?></strong></div>
					<div class="panel-body">

						<?php echo form_open('relatorio/orcamento', 'role="form"'); ?>

						<div class="form-group">
							<div class="row">
								<!--
								<div class="col-md-2 btn-group">
									<label for="Orcamento">Pedido:</label>
										<input type="text" class="form-control Numero" name="Orcamento" value="<?php echo set_value('Orcamento', $query['Orcamento']); ?>">
										<span class="input-group-btn">
											<button class="btn btn-info btn-md" type="submit">
												<span class="glyphicon glyphicon-user"></span> <span class="glyphicon glyphicon-search"></span> 
											</button>
										</span>
									
								</div>
								-->
								<div class="col-md-2">
									<label for="Orcamento">Pedido:</label>
									<div class="input-group">
										<input type="text" placeholder="Pesquisar Pedido" class="form-control Numero btn-sm" name="Orcamento" value="<?php echo set_value('Orcamento', $query['Orcamento']); ?>">
										<span class="input-group-btn">
											<button class="btn btn-info btn-md" type="submit">
												<span class="glyphicon glyphicon-search"></span> 
											</button>
										</span>
									</div>
								</div>	
								<div class="col-md-2">
									<label for="AprovadoOrca">Aprovado?</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
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
								<div class="col-md-2">
									<label for="ConcluidoOrca">Entregue?</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
											id="ConcluidoOrca" name="ConcluidoOrca">
										<?php
										foreach ($select['ConcluidoOrca'] as $key => $row) {
											if ($query['ConcluidoOrca'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<div class="col-md-2">
									<label for="QuitadoOrca">Pago?</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
											id="QuitadoOrca" name="QuitadoOrca">
										<?php
										foreach ($select['QuitadoOrca'] as $key => $row) {
											if ($query['QuitadoOrca'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<div class="col-md-2">
									<label for="CanceladoOrca">Cancelado?</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
											id="CanceladoOrca" name="CanceladoOrca">
										<?php
										foreach ($select['CanceladoOrca'] as $key => $row) {
											if ($query['CanceladoOrca'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<div class="col-md-2">
									<label for="FinalizadoOrca">Finalizado?</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
											id="FinalizadoOrca" name="FinalizadoOrca">
										<?php
										foreach ($select['FinalizadoOrca'] as $key => $row) {
											if ($query['FinalizadoOrca'] == $key) {
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
						<div class="form-group">	
							<div class="row">	
								<div class="col-md-2">
									<label for="Ordenamento">Local de Compra</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
											id="Tipo_Orca" name="Tipo_Orca">
										<?php
										foreach ($select['Tipo_Orca'] as $key => $row) {
											if ($query['Tipo_Orca'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>	
								<div class="col-md-2">
									<label for="Ordenamento">Local de Pag.</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
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
								<div class="col-md-2">
									<label for="Ordenamento">Forma de Pag.</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
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
								<div class="col-md-2">
									<label for="Ordenamento">Forma de Entrega</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
											id="TipoFrete" name="TipoFrete">
										<?php
										foreach ($select['TipoFrete'] as $key => $row) {
											if ($query['TipoFrete'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<!--
								<div class="col-md-4">
									<label for="Ordenamento">Entregador:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
											id="Entregador" name="Entregador">
										<?php
										foreach ($select['Entregador'] as $key => $row) {
											if ($query['Entregador'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								-->
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-2">
									<label for="DataInicio">Pedido - Data Inc.</label>
									<div class="input-group DatePicker">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
										<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											    autofocus name="DataInicio" value="<?php echo set_value('DataInicio', $query['DataInicio']); ?>">
									</div>
								</div>
								<div class="col-md-2">
									<label for="DataFim">Pedido - Data Fim</label>
									<div class="input-group DatePicker">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
										<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											    name="DataFim" value="<?php echo set_value('DataFim', $query['DataFim']); ?>">
									</div>
								</div>
								
								<div class="col-md-2">
									<label for="DataInicio2">Entrega - Data Inc.</label>
									<div class="input-group DatePicker">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
										<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											    name="DataInicio2" value="<?php echo set_value('DataInicio2', $query['DataInicio2']); ?>">
									</div>
								</div>
								<div class="col-md-2">
									<label for="DataFim2">Entrega - Data Fim</label>
									<div class="input-group DatePicker">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
										<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											    name="DataFim2" value="<?php echo set_value('DataFim2', $query['DataFim2']); ?>">
									</div>
								</div>
								<div class="col-md-2">
									<label for="DataInicio3">Vencimento - Data Inc.</label>
									<div class="input-group DatePicker">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
										<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											    name="DataInicio3" value="<?php echo set_value('DataInicio3', $query['DataInicio3']); ?>">
									</div>
								</div>
								<div class="col-md-2">
									<label for="DataFim3">Vencimento - Data Fim</label>
									<div class="input-group DatePicker">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
										<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											    name="DataFim3" value="<?php echo set_value('DataFim3', $query['DataFim3']); ?>">
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<!--
								<div class="col-md-2">
									<label for="DataInicio4">Quit. - Data Inc.</label>
									<div class="input-group DatePicker">
										<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											    name="DataInicio4" value="<?php echo set_value('DataInicio4', $query['DataInicio4']); ?>">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
								</div>
								<div class="col-md-2">
									<label for="DataFim4">Quit. - Data Fim</label>
									<div class="input-group DatePicker">
										<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											    name="DataFim4" value="<?php echo set_value('DataFim4', $query['DataFim4']); ?>">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
								</div>
								-->
								<div class="col-md-4">
									<label for="Ordenamento">Ordenamento:</label>
									<div class="form-group">
										<div class="row">
											<div class="col-md-6">
												<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
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

											<div class="col-md-5">
												<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
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

								<br>
								<div class="col-md-2 text-left">
									<button class="btn btn-lg btn-primary" name="pesquisar" value="0" type="submit">
										<span class="glyphicon glyphicon-search"></span> Pesquisar
									</button>
								</div>
								<div class="col-md-2 text-right">											
									<a class="btn btn-lg btn-danger" href="<?php echo base_url() ?>orcatrata/cadastrar3" role="button"> 
										<span class="glyphicon glyphicon-plus"></span> Novo Orç.
									</a>
								</div>

							</div>
						</div>
						</form>
						<br>
						<?php echo (isset($list)) ? $list : FALSE ?>
					</div>
				</div>			
			</div>
				
		</div>
	</div>	

