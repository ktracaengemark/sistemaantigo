<?php
	
include_once '../../conexao.php';

if($_GET['q'] == 1000) {
	
	if ($_GET['idCliente']) {
		//echo $_GET['tabela'];
		
		$result = mysql_query('
			SELECT *
			FROM
				App_Consulta
			WHERE
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				DataInicio = "' . $_GET['idCliente'] . '"
		');

		while ($row = mysql_fetch_assoc($result)) {

			$event_array[] = array(
				'id' => $row['idApp_Consulta'],
				'dataehora' => $row['DataInicio'],
			);
		}		
		
		echo json_encode($event_array);	
		
		/*
		$result = "SELECT * FROM Tab_Catprod WHERE idTab_Catprod='". $_GET['id'] ."'";
		
		//echo $result;
		$resultado = mysqli_query($conn, $result);
		//echo $resultado;
		$row_resultado = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
		//echo $row_resultado;
		//echo $row_resultado['Catprod'];
		
		$event_array[0] = array(
			'id' => $row_resultado['idTab_Catprod'],
			'nome' => utf8_encode($row_resultado['Catprod']),
		);
		echo json_encode($event_array);
		
		//echo json_encode($row_resultado);
		*/
	}
	
}else{
	echo false;
}

//echo json_encode($event_array);
//mysql_close($link);
mysqli_close($conn);
