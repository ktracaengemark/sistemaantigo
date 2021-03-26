<?php
	
include_once '../../conexao.php';

if ($_GET['id']) {
	//echo $_GET['id'];
	$result = "SELECT * FROM App_ClientePet WHERE idApp_ClientePet='". $_GET['id'] ."'";
	//echo $result;
	$resultado = mysqli_query($conn, $result);
	//echo $resultado;
	$row_resultado = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
	//echo $row_resultado;
	$event_array[0] = array(
		'id' => $row_resultado['idApp_ClientePet'],
		'nome' => utf8_encode($row_resultado['NomeClientePet']),
		'nascimento' => utf8_encode($row_resultado['DataNascimentoPet']),
		'sexo' => utf8_encode($row_resultado['SexoPet']),
		'especie' => utf8_encode($row_resultado['EspeciePet']),
		'raca' => utf8_encode($row_resultado['RacaPet']),
		'pelo' => utf8_encode($row_resultado['PeloPet']),
		'cor' => utf8_encode($row_resultado['CorPet']),
		'porte' => utf8_encode($row_resultado['PortePet']),
		'obs' => utf8_encode($row_resultado['ObsPet']),
	);
	echo json_encode($event_array);
	//echo json_encode($row_resultado);
}else{
	echo false;
}

mysqli_close($conn);
