<?php
	
include_once '../../conexao.php';

if ($_GET['id']) {
	//echo $_GET['id'];

	$result = 'SELECT *
				FROM
					App_Produto
				WHERE
					idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
					idApp_Cliente = "' . $_GET['id'] . '" AND
					StatusCashBack = "N" AND
					id_Orca_CashBack = 0 AND
					ValorComissaoCashBack > 0.00
			';

	$resultado = mysqli_query($conn, $result);
	$cashtotal = 0;
	while ($row = mysqli_fetch_assoc($resultado) ) {
		$cashtotal += $row['ValorComissaoCashBack'];
		
		$agendados[] = array(
			
			'id' 		=> $row['idApp_Produto'],
			'valorcash_id' 		=> $row['ValorComissaoCashBack'],
			'cashtotal' => $cashtotal,
			
		);
		
	}

	//echo(json_encode($agendados));
	echo(json_encode($cashtotal));
}else{
	echo false;
}
mysqli_close($conn);
