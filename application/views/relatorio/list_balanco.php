<div class="container-fluid">
    <div class="row">
		
		<div style="overflow: auto; height: 220px;"> 
			
			<table class="table table-bordered table-condensed table-striped">

				<thead>
					<tr>
						<th class="active text-center"></th>
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

					<tr>
						<?php
						echo '<td><b>' . $report['RecVenc'][0]->Balancovenc . '</b></td>';
						for($i=1;$i<=12;$i++) {
							echo '<td class="text-left">' . $report['RecVenc'][0]->{'M'.$i} . '</td>';
						}
						echo '<td class="text-left">' . $report['TotalGeralvenc']->RecVenc . '</td>';
						?>
					</tr>
					<tr>
						<?php
						echo '<td><b>' . $report['RecPago'][0]->Balancopago . '</b></td>';
						for($i=1;$i<=12;$i++) {
							echo '<td class="text-left">' . $report['RecPago'][0]->{'M'.$i} . '</td>';
						}
						echo '<td class="text-left">' . $report['TotalGeralpago']->RecPago . '</td>';
						?>
					</tr>
					
					<tr>
						<?php
						echo '<td><b>' . $report['DesVenc'][0]->Balancovenc . '</b></td>';
						for($i=1;$i<=12;$i++) {
							echo '<td class="text-left">' . $report['DesVenc'][0]->{'M'.$i} . '</td>';
						}
						echo '<td class="text-left">' . $report['TotalGeralvenc']->DesVenc . '</td>';
						?>
					</tr>
					<tr>
						<?php
						echo '<td><b>' . $report['DesPago'][0]->Balancopago . '</b></td>';
						for($i=1;$i<=12;$i++) {
							echo '<td class="text-left">' . $report['DesPago'][0]->{'M'.$i} . '</td>';
						}
						echo '<td class="text-left">' . $report['TotalGeralpago']->DesPago . '</td>';
						?>
					</tr>
					<!--
					<tr>
						<?php
						echo '<td><b>' . $report['TotalVenc']->Balancovenc . '</b></td>';
						for($i=1;$i<=12;$i++) {
							$bgcolor = ($report['TotalVenc']->{'M'.$i} < 0) ? 'bg-danger' : 'bg-success';
							echo '<td class="text-left ' . $bgcolor . '">' . $report['TotalVenc']->{'M'.$i} . '</td>';
						}
						$bgcolor = ($report['TotalGeralvenc']->BalancoGeralvenc < 0) ? 'bg-danger' : 'bg-info';
						echo '<td class="text-left ' . $bgcolor . '">' . $report['TotalGeralvenc']->BalancoGeralvenc . '</td>';
						?>
					</tr>
					-->
					<tr>
						<?php
						echo '<td><b>' . $report['TotalPago']->Balancopago . '</b></td>';
						for($i=1;$i<=12;$i++) {
							$bgcolor = ($report['TotalPago']->{'M'.$i} < 0) ? 'bg-danger' : 'bg-info';
							echo '<td class="text-left ' . $bgcolor . '">' . $report['TotalPago']->{'M'.$i} . '</td>';
						}
						$bgcolor = ($report['TotalGeralpago']->BalancoGeralpago < 0) ? 'bg-danger' : 'bg-info';
						echo '<td class="text-left ' . $bgcolor . '">' . $report['TotalGeralpago']->BalancoGeralpago . '</td>';
						?>
					</tr>

				</tbody>
				
			</table>

		</div>
		
    </div>
<!--
    <div class="row">

        <div>
            <table class="table table-bordered table-condensed table-striped">

                <thead>
                    <tr>
						<th class="active text-center"></th>
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

                    <tr>
                        <?php
                        echo '<td><b>' . $report['RecPago'][0]->Balancopago . '</b></td>';
                        for($i=1;$i<=12;$i++) {
                            echo '<td class="text-left">' . $report['RecPago'][0]->{'M'.$i} . '</td>';
                        }
                        echo '<td class="text-left">' . $report['TotalGeralpago']->RecPago . '</td>';
                        ?>
                    </tr>

                    <tr>
                        <?php
                        echo '<td><b>' . $report['DesPago'][0]->Balancopago . '</b></td>';
                        for($i=1;$i<=12;$i++) {
							echo '<td class="text-left">' . $report['DesPago'][0]->{'M'.$i} . '</td>';
                        }
                        echo '<td class="text-left">' . $report['TotalGeralpago']->DesPago . '</td>';
                        ?>
                    </tr>

                    <tr>
                        <?php
                        echo '<td><b>' . $report['TotalPago']->Balancopago . '</b></td>';
                        for($i=1;$i<=12;$i++) {
                            $bgcolor = ($report['TotalPago']->{'M'.$i} < 0) ? 'bg-danger' : 'bg-info';
                            echo '<td class="text-left ' . $bgcolor . '">' . $report['TotalPago']->{'M'.$i} . '</td>';
                        }
                        $bgcolor = ($report['TotalGeralpago']->BalancoGeralpago < 0) ? 'bg-danger' : 'bg-success';
                        echo '<td class="text-left ' . $bgcolor . '">' . $report['TotalGeralpago']->BalancoGeralpago . '</td>';
                        ?>
                    </tr>


                </tbody>

            </table>

        </div>

    </div>

    <div class="row">

        <div>
            <table class="table table-bordered table-condensed table-striped">

                <thead>
                    <tr>
						<th class="active text-center"></th>
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

                    <tr>
                        <?php
                        echo '<td><b>' . $report['RecVenc'][0]->BalancoResRec . '</b></td>';
                        for($i=1;$i<=12;$i++) {
							echo '<td class="text-left">R$ ' . $report['RecVenc'][0]->{'M'.$i} . '</td>';
                        }
                        echo '<td class="text-left">R$ ' . $report['TotalGeralResRec']->RecVenc . '</td>';
                        ?>
                    </tr>
					
					<tr>
                        <?php
                        echo '<td><b>' . $report['RecPago'][0]->BalancoResRec . '</b></td>';
                        for($i=1;$i<=12;$i++) {
                            echo '<td class="text-left">R$ ' . $report['RecPago'][0]->{'M'.$i} . '</td>';
                        }
                        echo '<td class="text-left">R$ ' . $report['TotalGeralResRec']->RecPago . '</td>';
                        ?>
                    </tr>

                    

                    <tr>
                        <?php
                        echo '<td><b>' . $report['TotalResRec']->BalancoResRec . '</b></td>';
                        for($i=1;$i<=12;$i++) {
                            $bgcolor = ($report['TotalResRec']->{'M'.$i} < 0) ? 'bg-danger' : 'bg-success';
                            echo '<td class="text-left ' . $bgcolor . '">R$ ' . $report['TotalResRec']->{'M'.$i} . '</td>';
                        }
                        $bgcolor = ($report['TotalGeralResRec']->BalancoGeralResRec < 0) ? 'bg-danger' : 'bg-success';
                        echo '<td class="text-left ' . $bgcolor . '">R$ ' . $report['TotalGeralResRec']->BalancoGeralResRec . '</td>';
                        ?>
                    </tr>


                </tbody>

            </table>

        </div>

    </div>

    <div class="row">

        <div>
            <table class="table table-bordered table-condensed table-striped">

                <thead>
                    <tr>
						<th class="active text-center"></th>
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

                    <tr>
                        <?php
                        echo '<td><b>' . $report['DesVenc'][0]->BalancoResDes . '</b></td>';
                        for($i=1;$i<=12;$i++) {
							echo '<td class="text-left">R$ ' . $report['DesVenc'][0]->{'M'.$i} . '</td>';
                        }
                        echo '<td class="text-left">R$ ' . $report['TotalGeralResDes']->DesVenc . '</td>';
                        ?>
                    </tr>
					
					<tr>
                        <?php
                        echo '<td><b>' . $report['DesPago'][0]->BalancoResDes . '</b></td>';
                        for($i=1;$i<=12;$i++) {
                            echo '<td class="text-left">R$ ' . $report['DesPago'][0]->{'M'.$i} . '</td>';
                        }
                        echo '<td class="text-left">R$ ' . $report['TotalGeralResDes']->DesPago . '</td>';
                        ?>
                    </tr>

                    

                    <tr>
                        <?php
                        echo '<td><b>' . $report['TotalResDes']->BalancoResDes . '</b></td>';
                        for($i=1;$i<=12;$i++) {
                            $bgcolor = ($report['TotalResDes']->{'M'.$i} < 0) ? 'bg-danger' : 'bg-success';
                            echo '<td class="text-left ' . $bgcolor . '">R$ ' . $report['TotalResDes']->{'M'.$i} . '</td>';
                        }
                        $bgcolor = ($report['TotalGeralResDes']->BalancoGeralResDes < 0) ? 'bg-danger' : 'bg-success';
                        echo '<td class="text-left ' . $bgcolor . '">R$ ' . $report['TotalGeralResDes']->BalancoGeralResDes . '</td>';
                        ?>
                    </tr>


                </tbody>

            </table>

        </div>

    </div>
-->	
</div>
