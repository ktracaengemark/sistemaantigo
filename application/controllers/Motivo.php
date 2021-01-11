<?php

session_start();

include_once 'conexao.php';

$Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

//$motivo0 = filter_input(INPUT_POST, 'Motivo', FILTER_SANITIZE_STRING);
//$descricao0 = filter_input(INPUT_POST, 'Desc_Motivo', FILTER_SANITIZE_STRING);

$motivo0 = filter_var($Dados['Motivo'], FILTER_SANITIZE_STRING);
$descricao0 = filter_var($Dados['Desc_Motivo'], FILTER_SANITIZE_STRING);

//$motivo0 = filter_input(INPUT_POST, 'Motivo', FILTER_SANITIZE_STRING);
//$descricao0 = filter_input(INPUT_POST, 'Desc_Motivo', FILTER_SANITIZE_STRING);

$motivo = trim(mb_strtoupper($motivo0, 'ISO-8859-1'));
$descricao = trim(mb_strtoupper($descricao0, 'ISO-8859-1'));

//$motivo = trim(mb_strtoupper($Dados['Motivo'], 'ISO-8859-1'));
//$descricao = trim(mb_strtoupper($Dados['Desc_Motivo'], 'ISO-8859-1'));

$usuario = $_SESSION['log']['idSis_Usuario'];
$empresa = $_SESSION['log']['idSis_Empresa'];
$modulo = $_SESSION['log']['idTab_Modulo'];
$query_usuario = "INSERT INTO Tab_Motivo (Motivo, Desc_Motivo, idSis_Usuario, idSis_Empresa, idTab_Modulo) VALUES ('$motivo', '$descricao', '$usuario', '$empresa', '$modulo')";
mysqli_query($conn, $query_usuario);

if(mysqli_insert_id($conn)){
	echo true;
}else{
	echo false;
}