<div style="overflow: auto; height: 220px;">
	<div class="container-fluid">
		<div class="row">

			<table class="table table-bordered table-condensed table-striped">

				<thead>
					<tr>
						<th class="active text-center"><?php echo '<small>' . $_SESSION['FiltroBalanco']['Ano'] . '</small>' ?></th>
						<th class="active text-center">JAN</th>
						<th class="active text-center">FEV</th>
						<th class="active text-center">MAR</th>
						<th class="active text-center">ABR</th>
						<th class="active text-center">MAI</th>
						<th class="active text-center">JUN</th>
						<th class="active text-center">JUL</th>
						<th class="active text-center">AGO</th>
						<th class="active text-center">SET</th>
						<th class="active text-center">OUT</th>
						<th class="active text-center">NOV</th>
						<th class="active text-center">DEZ</th>
						<th class="active text-center">TOTAL</th>
					</tr>
				</thead>

				<tbody>
					<!--
					<tr>
						<?php
						echo '<td><b>' . $report['RecVenc'][0]->Balancovenc . '</b></td>';
						for($i=1;$i<=12;$i++) {
							echo '<td class="text-right">' . $report['RecVenc'][0]->{'M'.$i} . '</td>';
						}
						echo '<td class="text-right">' . $report['TotalGeralvenc']->RecVenc . '</td>';
						?>
					</tr>
					-->
					<!--
					<tr>
						<?php
						echo '<td><b>' . $report['DesVenc'][0]->Balancovenc . '</b></td>';
						for($i=1;$i<=12;$i++) {
							echo '<td class="text-right">' . $report['DesVenc'][0]->{'M'.$i} . '</td>';
						}
						echo '<td class="text-right">' . $report['TotalGeralvenc']->DesVenc . '</td>';
						?>
					</tr>
					-->					
					<tr>
						<?php
						echo '<td><b>' . $report['RecPagar'][0]->Balancopagar . '</b></td>';
						for($i=1;$i<=12;$i++) {
							$bgcolor = ($report['RecPagar'][0]->{'M'.$i} <= 0) ? 'bg-info' : 'bg-info';
							echo '<td class="text-right ' . $bgcolor . '">' . $report['RecPagar'][0]->{'M'.$i} . '</td>';
						}
						$bgcolor = ($report['TotalGeralpagar']->RecPagar <= 0) ? 'bg-info' : 'bg-info';
						echo '<td class="text-right ' . $bgcolor . '">' . $report['TotalGeralpagar']->RecPagar . '</td>';
						?>
					</tr>
					<tr>
						<?php
						echo '<td><b>' . $report['DesPagar'][0]->Balancopagar . '</b></td>';
						for($i=1;$i<=12;$i++) {
							$bgcolor = ($report['DesPagar'][0]->{'M'.$i} <= 0) ? 'bg-danger' : 'bg-danger';
							echo '<td class="text-right ' . $bgcolor . '">' . $report['DesPagar'][0]->{'M'.$i} . '</td>';
						}
						$bgcolor = ($report['TotalGeralpagar']->DesPagar <= 0) ? 'bg-danger' : 'bg-danger';
						echo '<td class="text-right ' . $bgcolor . '">' . $report['TotalGeralpagar']->DesPagar . '</td>';
						?>
					</tr>					
					<tr>
						<?php
						echo '<td><b>' . $report['RecPago'][0]->Balancopago . '</b></td>';
						for($i=1;$i<=12;$i++) {
							$bgcolor = ($report['RecPago'][0]->{'M'.$i} <= 0) ? 'bg-info' : 'bg-info';
							echo '<td class="text-right ' . $bgcolor . '">' . $report['RecPago'][0]->{'M'.$i} . '</td>';
						}
						$bgcolor = ($report['TotalGeralpago']->RecPago <= 0) ? 'bg-info' : 'bg-info';
						echo '<td class="text-right ' . $bgcolor . '">' . $report['TotalGeralpago']->RecPago . '</td>';
						?>
					</tr>
					

					<tr>
						<?php
						echo '<td><b>' . $report['DesPago'][0]->Balancopago . '</b></td>';
						for($i=1;$i<=12;$i++) {
							$bgcolor = ($report['DesPago'][0]->{'M'.$i} <= 0) ? 'bg-danger' : 'bg-danger';
							echo '<td class="text-right ' . $bgcolor . '">' . $report['DesPago'][0]->{'M'.$i} . '</td>';
						}
						$bgcolor = ($report['TotalGeralpago']->DesPago <= 0) ? 'bg-danger' : 'bg-danger';
						echo '<td class="text-right ' . $bgcolor . '">' . $report['TotalGeralpago']->DesPago . '</td>';
						?>
					</tr>
					
					<!--
					<tr>
						<?php
						echo '<td><b>' . $report['TotalVenc']->Balancovenc . '</b></td>';
						for($i=1;$i<=12;$i++) {
							$bgcolor = ($report['TotalVenc']->{'M'.$i} < 0) ? 'bg-danger' : 'bg-info';
							echo '<td class="text-right ' . $bgcolor . '">' . $report['TotalVenc']->{'M'.$i} . '</td>';
						}
						$bgcolor = ($report['TotalGeralvenc']->BalancoGeralvenc < 0) ? 'bg-danger' : 'bg-info';
						echo '<td class="text-right ' . $bgcolor . '">' . $report['TotalGeralvenc']->BalancoGeralvenc . '</td>';
						?>
					</tr>
					-->
					<tr>
						<?php
						echo '<td><b>' . $report['TotalPago']->Balancopago . '</b></td>';
						for($i=1;$i<=12;$i++) {
							$bgcolor = ($report['TotalPago']->{'M'.$i} < 0) ? 'bg-danger' : 'bg-info';
							echo '<td class="text-right ' . $bgcolor . '">' . $report['TotalPago']->{'M'.$i} . '</td>';
						}
						$bgcolor = ($report['TotalGeralpago']->BalancoGeralpago < 0) ? 'bg-danger' : 'bg-info';
						echo '<td class="text-right ' . $bgcolor . '">' . $report['TotalGeralpago']->BalancoGeralpago . '</td>';
						?>
					</tr>

				</tbody>
				
			</table>

		</div>
		
	</div>

</div>
