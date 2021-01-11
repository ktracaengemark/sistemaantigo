<?php

session_start();

$servidor = $_SESSION['db']['hostname'];
$usuario = $_SESSION['db']['username'];
$senha = $_SESSION['db']['password'];
$dbname = $_SESSION['db']['database'];

//Criar a conexao
$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
/*
$link = mysql_connect($_SESSION['db']['hostname'], $_SESSION['db']['username'], $_SESSION['db']['password']);
if (!$link) {
    die('N�o foi poss�vel conectar: ' . mysql_error());
}

$db = mysql_select_db($_SESSION['db']['database'], $link);
if (!$db) {
    die('N�o foi poss�vel selecionar banco de dados: ' . mysql_error());
}
*/
#echo 'Conex�o bem sucedida';

$motivo0 = filter_input(INPUT_POST, 'Motivo', FILTER_SANITIZE_STRING);
$descricao0 = filter_input(INPUT_POST, 'Desc_Motivo', FILTER_SANITIZE_STRING);

$motivo = trim(mb_strtoupper($motivo0, 'ISO-8859-1'));
$descricao = trim(mb_strtoupper($descricao0, 'ISO-8859-1'));

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