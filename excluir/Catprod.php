<?php

include_once '../conexao.php';

$Dados 	= filter_input_array(INPUT_POST, FILTER_DEFAULT);

$id 	= filter_var($Dados['id_Categoria_Excluir'], FILTER_SANITIZE_NUMBER_INT);

if(!empty($id)){

	$result_opcao = "DELETE FROM Tab_Opcao WHERE idTab_Catprod = '$id'";
	$resultado_categoria = mysqli_query($conn, $result_opcao);
	
	$result_atributo = "DELETE FROM Tab_Atributo WHERE idTab_Catprod = '$id'";
	$resultado_categoria = mysqli_query($conn, $result_atributo);	

	$result_categoria = "DELETE FROM Tab_Catprod WHERE idTab_Catprod = '$id'";
	$resultado_categoria = mysqli_query($conn, $result_categoria);

	if(mysqli_affected_rows($conn)){
		echo true;
	}else{
		echo false;
	}
}else{
	echo false;
}	
unset($id, $categoria);
mysqli_close($conn);