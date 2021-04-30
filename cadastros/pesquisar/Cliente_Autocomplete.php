<?php
include_once '../../conexao_pdo.php';

$cliente = filter_input(INPUT_GET, 'term', FILTER_SANITIZE_STRING);
//$cliente = filter_input(INPUT_GET, 'term');
//$cliente = mysql_real_escape_string($_GET['term']);

if(is_numeric($cliente)){
   
	if((strlen($cliente)) < 6){
		$query = 'RegistroFicha like "' . $cliente . '"';
	}elseif(strlen($cliente) >= 6 && strlen($cliente) <= 7){
		$query = 'idApp_Cliente like "' . $cliente . '"';
	}else{
		$query = '(CelularCliente like "%' . $cliente . '%" OR '
				. 'Telefone like "%' . $cliente . '%" OR '
				. 'Telefone2 like "%' . $cliente . '%" OR '
				. 'Telefone3 like "%' . $cliente . '%" )';
	}
				
}else{
	$query = '(NomeCliente like "' . $cliente . '%" )';
}

//SQL para selecionar os registros
$result_msg_cont = "
						SELECT 
							idApp_Cliente,
							idSis_Empresa, 
							NomeCliente,
							RegistroFicha,
							CelularCliente
						FROM 
							App_Cliente 
						WHERE
							idSis_Empresa = " . $_SESSION['log']['idSis_Empresa'] . " AND
							" . $query . "
						ORDER BY NomeCliente ASC 
						LIMIT 7
					";

//Seleciona os registros
$resultado_msg_cont = $conn->prepare($result_msg_cont);
$resultado_msg_cont->execute();

while($row_msg_cont = $resultado_msg_cont->fetch(PDO::FETCH_ASSOC)){
	
    //$data[] = $row_msg_cont['NomeCliente'];
	
	$data[$row_msg_cont['idApp_Cliente']] = $row_msg_cont['idApp_Cliente'] . '#' . $row_msg_cont['NomeCliente'] . ' | Fch:' . $row_msg_cont['RegistroFicha'] . ' | Cel:' . $row_msg_cont['CelularCliente'];
	//$data[$row_msg_cont['NomeCliente']] = $row_msg_cont['idApp_Cliente'];
}

echo json_encode($data);