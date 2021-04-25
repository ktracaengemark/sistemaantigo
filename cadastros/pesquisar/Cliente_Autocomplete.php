<?php
include_once '../../conexao_pdo.php';

$cliente = filter_input(INPUT_GET, 'term', FILTER_SANITIZE_STRING);

//SQL para selecionar os registros
$result_msg_cont = "
						SELECT 
							idApp_Cliente,
							idSis_Empresa, 
							NomeCliente 
						FROM 
							App_Cliente 
						WHERE
							idSis_Empresa = " . $_SESSION['log']['idSis_Empresa'] . " AND
							NomeCliente LIKE '%".$cliente."%' 
						ORDER BY NomeCliente ASC 
						LIMIT 7
					";

//Seleciona os registros
$resultado_msg_cont = $conn->prepare($result_msg_cont);
$resultado_msg_cont->execute();

while($row_msg_cont = $resultado_msg_cont->fetch(PDO::FETCH_ASSOC)){
	
    //$data[] = $row_msg_cont['NomeCliente'];
	
	//$data[$row_msg_cont['idApp_Cliente']] = $row_msg_cont['NomeCliente'];
	$data[$row_msg_cont['NomeCliente']] = $row_msg_cont['idApp_Cliente'];
}

echo json_encode($data);