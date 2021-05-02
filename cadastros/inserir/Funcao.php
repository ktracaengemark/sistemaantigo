<?php

//session_start();

include_once '../../conexao.php';

$Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$Funcao0 = filter_var($Dados['Novo_Funcao'], FILTER_SANITIZE_STRING);

$Funcao = trim(mb_strtoupper($Funcao0, 'ISO-8859-1'));

//$usuario 	= $_SESSION['log']['idSis_Usuario'];
$usuario 	= $_SESSION['log']['idSis_Empresa'];
$empresa 	= $_SESSION['log']['idSis_Empresa'];
$modulo 	= $_SESSION['log']['idTab_Modulo'];
$datacad	= date('Y-m-d H:i:s', time());
$query_usuario = "INSERT INTO Tab_Funcao (Funcao, idSis_Usuario, idSis_Empresa, idTab_Modulo) VALUES ('$Funcao', '$usuario', '$empresa', '$modulo')";
mysqli_query($conn, $query_usuario);

if(mysqli_insert_id($conn)){
	echo true;
}else{
	echo false;
}
unset($usuario, $empresa, $modulo, $datacad);
//echo json_encode($event_array);
//mysql_close($link);
mysqli_close($conn);
