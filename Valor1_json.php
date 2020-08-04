<?php

session_start();

$link = mysql_connect($_SESSION['db']['hostname'], $_SESSION['db']['username'], $_SESSION['db']['password']);
if (!$link) {
    die('Não foi possível conectar: ' . mysql_error());
}

$db = mysql_select_db($_SESSION['db']['database'], $link);
if (!$db) {
    die('Não foi possível selecionar banco de dados: ' . mysql_error());
}

#echo 'Conexão bem sucedida';
$result = mysql_query(
        'SELECT
            V.idTab_Modulo,
			V.idSis_Empresa,
			V.idTab_Valor,
			V.idTab_Produtos,
			V.ValorProduto,
			V.QtdProdutoDesconto,
			V.QtdProdutoIncremento,
			V.Convdesc,
			TP.idTab_Produto,
			TP.Produtos,
			TP.UnidadeProduto,
			P.Nome_Prod,
			P.NomeProdutos,
			P.Cod_Prod,
			P.Arquivo,
			P.Opcao_Atributo_1,
			TOP2.Opcao,
			TOP1.Opcao,
			TDS.Desconto,
			TPM.Promocao,
			CONCAT(IFNULL(P.Nome_Prod,""),"-",IFNULL(TOP2.Opcao,""),"-",IFNULL(TOP1.Opcao,""),"-",IFNULL(V.Convdesc,"")) AS NomeProduto
        FROM
            Tab_' . $_GET['tabela'] . ' AS V
				LEFT JOIN Tab_Promocao AS TPM ON TPM.idTab_Promocao = V.idTab_Promocao
				LEFT JOIN Tab_Desconto AS TDS ON TDS.idTab_Desconto = V.Desconto
				LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = V.idTab_Modelo
				LEFT JOIN Tab_Produtos AS P ON P.idTab_Produtos = V.idTab_Produtos
				LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = P.Opcao_Atributo_1
				LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = P.Opcao_Atributo_2
        WHERE
			V.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
			V.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
');

if ($_GET['tabela']) {

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_' . $_GET['tabela']],
            'valor' => str_replace(".", ",", $row['ValorProduto']),
			'nomeprod' => $row['NomeProduto'],
			'qtdprod' => $row['QtdProdutoDesconto'],
			'qtdinc' => $row['QtdProdutoIncremento'],
			'id_produto' => $row['idTab_Produtos'],
			'id_valor' => $row['idTab_Valor'],
        );
    }
}
else {

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_' . $_GET['tabela']],
            'valor' => str_replace(".", ",", $row['ValorProduto']),
			'nomeprod' => $row['NomeProduto'],
			'qtdprod' => $row['QtdProdutoDesconto'],
			'qtdinc' => $row['QtdProdutoIncremento'],
			'id_produto' => $row['idTab_Produtos'],
			'id_valor' => $row['idTab_Valor'],
        );
    }

}

echo json_encode($event_array);
mysql_close($link);
?>
