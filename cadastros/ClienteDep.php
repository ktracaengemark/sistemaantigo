<?php

include_once '../conexao.php';

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$cliente = filter_var($dados['id_Cliente'], FILTER_SANITIZE_STRING);
$clientedep0 = filter_var($dados['NomeClienteDep'], FILTER_SANITIZE_STRING);
$sexo0 = filter_var($dados['SexoDep'], FILTER_SANITIZE_STRING);
$relacao0 = filter_var($dados['RelacaoDep'], FILTER_SANITIZE_STRING);
$obsdep0 = filter_var($dados['ObsDep'], FILTER_SANITIZE_STRING);

$datanascimento = $dados['DataNascimentoDep'];
        
if (preg_match("/[0-9]{2,4}(\/|-)[0-9]{2,4}(\/|-)[0-9]{2,4}/", $datanascimento)) {
	
	if ($datanascimento) {
		$datanascimento = DateTime::createFromFormat('d/m/Y', $datanascimento);
		$datanascimento = $datanascimento->format('Y-m-d');
	} else {
		$datanascimento = NULL;
	}
}

$clientedep = trim(mb_strtoupper($clientedep0, 'ISO-8859-1'));
$sexo = trim(mb_strtoupper($sexo0, 'ISO-8859-1'));
$obsdep = trim(mb_strtoupper($obsdep0, 'ISO-8859-1'));

$usuario 	= $_SESSION['log']['idSis_Usuario'];
$empresa 	= $_SESSION['log']['idSis_Empresa'];
$modulo 	= $_SESSION['log']['idTab_Modulo'];
$datacad	= date('Y-m-d H:i:s', time());
$DataCadastroFornecedor = date('Y-m-d', time());

$result_clientedep = "INSERT INTO App_ClienteDep (
													idSis_Empresa, 
													idTab_Modulo, 
													idSis_Usuario,
													idApp_Cliente, 
													NomeClienteDep,
													DataNascimentoDep,
													SexoDep,
													RelacaoDep,
													ObsDep
												) 
												VALUES (
													'" .$empresa. "',
													'1',
													'" .$usuario. "',
													'" .$cliente. "',
													'" .$clientedep. "',
													'" .$datanascimento. "',
													'" .$sexo. "',
													'" .$relacao0. "',
													'" .$obsdep. "'
												)";
$resultado_clientedep = mysqli_query($conn, $result_clientedep);
$id_clientedep = mysqli_insert_id($conn);

if($id_clientedep){
	echo true;
}else{
	echo false;
}

unset($usuario, $empresa, $modulo, $datacad);
//echo json_encode($event_array);
//mysql_close($link);
mysqli_close($conn);
