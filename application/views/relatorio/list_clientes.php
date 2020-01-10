<div style="overflow: auto; height: 550px; ">	
	<div class="container-fluid">
		
		<div>
			<table class="table table-bordered table-condensed table-striped">	
				<tfoot>
					<tr>
						<th colspan="9" class="active">Total encontrado: <?php echo $report->num_rows(); ?> resultado(s)</th>
					</tr>
				</tfoot>
			</table>	
			<table class="table table-bordered table-condensed table-striped">								
				<thead>
					<tr>
						<th class="active">id</th>
						<th class="active">Cliente</th>
						<th class="active">Sexo</th>
						<th class="active">Celular</th>
						<th class="active">Telefone2</th>
						<th class="active">Telefone3</th>
						<th class="active">Nascimento</th>
						<th class="active">Endereço</th>
						<th class="active">Bairro</th>
						<th class="active">Município</th>
						<th class="active">E-mail</th>
						<th class="active">Ativo?</th>
						<!--<th class="active">Contato</th>
						<th class="active">Sexo</th>
						<th class="active">Rel. Com.</th>
						<th class="active">Rel. Pes.</th>-->

					</tr>
				</thead>

				<tbody>

					<?php
					$cont_feminino = 0;
					$cont_masculino = 0;
					$cont_outros = 0;
					$cont_nao_infor = 0;
					foreach ($report->result_array() as $row) {

						#echo '<tr>';
						echo '<tr class="clickable-row" data-href="' . base_url() . 'cliente/prontuario/' . $row['idApp_Cliente'] . '">';
							echo '<td>' . $row['idApp_Cliente'] . '</td>';
							echo '<td>' . $row['NomeCliente'] . '</td>';
							echo '<td>' . $row['Sexo'] . '</td>';
							echo '<td>' . $row['CelularCliente'] . '</td>';
							echo '<td>' . $row['Telefone2'] . '</td>';
							echo '<td>' . $row['Telefone3'] . '</td>';
							echo '<td>' . $row['DataNascimento'] . '</td>';							
							echo '<td>' . $row['Endereco'] . '</td>';
							echo '<td>' . $row['Bairro'] . '</td>';
							echo '<td>' . $row['Municipio'] . '</td>';
							echo '<td>' . $row['Email'] . '</td>';
							echo '<td>' . $row['Ativo'] . '</td>';
							#echo '<td>' . $row['NomeContatoCliente'] . '</td>';
							#echo '<td>' . $row['Sexo'] . '</td>';
							#echo '<td>' . $row['RelaCom'] . '</td>';
							#echo '<td>' . $row['RelaPes'] . '</td>';
						echo '</tr>';
						
						if($row['Sexo'] == 'F')
							$cont_feminino++;
						else if ($row['Sexo'] == 'M')
							$cont_masculino++;
						else if ($row['Sexo'] == 'O')
							$cont_outros++;
						else 
							$cont_nao_infor++;
					}
					?>

				</tbody>

			</table>
			  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
			  <script type="text/javascript">
				google.charts.load("current", {packages:['corechart']});
				google.charts.setOnLoadCallback(drawChart);
				
				function drawChart() {
				  var data = google.visualization.arrayToDataTable([
					["Sexo", "Quantidade", { role: "style" } ],
					["Feminino", <?php echo $cont_feminino; ?>, "#b87333"],
					["Masculino", <?php echo $cont_masculino; ?>, "silver"],
					["Outros", <?php echo $cont_outros; ?>, "gold"],
					["Nao Inform", <?php echo $cont_nao_infor; ?>, "color: #e5e4e2"]			
				  ]);

				  var view = new google.visualization.DataView(data);
				  view.setColumns([0, 1,
								   { calc: "stringify",
									 sourceColumn: 1,
									 type: "string",
									 role: "annotation" },
								   2]);

				  var options = {
					title: "Sexo",
					width: 600,
					height: 400,
					bar: {groupWidth: "95%"},
					legend: { position: "none" },
				  };
				  var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
				  chart.draw(view, options);
			  }
			  </script>			
			<div id="columnchart_values" style="width: 900px; height: 300px;"></div>
		</div>
	</div>	
</div>