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

if ($_GET['q']==1) {

    $result = mysql_query(
            'SELECT
                TSV.idTab_Servico,
                CONCAT(TSV.NomeServico, " --- R$ ", TSV.ValorServico) AS NomeServico,
                TSV.ValorServico
            FROM
                Tab_Servico AS TSV
            WHERE
				TSV.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				TSV.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY
				TSV.NomeServico ASC
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Servico'],
            'name' => utf8_encode($row['NomeServico']),
            'value' => $row['ValorServico'],
        );
    }

}

elseif ($_GET['q'] == 2) {

    $result = mysql_query('
            SELECT
                idTab_Produto,
                CONCAT(IFNULL(CodProd,""), " - ", IFNULL(Produtos,""), " - ", IFNULL(UnidadeProduto,"")) AS NomeProduto,
                ValorCompraProduto
            FROM 
                Tab_Produto 
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Produto'],
            'name' => utf8_encode($row['NomeProduto']),
            'value' => $row['ValorCompraProduto'],
        );
    } 
    
}

elseif ($_GET['q'] == 23) {

    $result = mysql_query(
            'SELECT
                TPV.idTab_Produto,
				CONCAT(IFNULL(TPV.CodProd,""), " - ", IFNULL(TPV.Produtos,""), " - ", IFNULL(TPV.UnidadeProduto,""), " - ",   
						IFNULL(TP3.Prodaux3,""), " - ", IFNULL(TP1.Prodaux1,""), " - ", IFNULL(TP2.Prodaux2,""), " - ",  
						IFNULL(TFO.NomeFornecedor,"")) AS NomeProduto,
				TPV.ValorProduto,
				TPV.Categoria
            FROM
                Tab_Produto AS TPV
					LEFT JOIN App_Fornecedor AS TFO ON TFO.idApp_Fornecedor = TPV.Fornecedor
					LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TPV.Prodaux3
					LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = TPV.Prodaux2
					LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = TPV.Prodaux1
            WHERE
                TPV.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				TPV.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY  
				TPV.CodProd ASC,
				TPV.Categoria ASC,
				TP3.Prodaux3,				
				TPV.Produtos ASC,
				TP1.Prodaux1,
				TP2.Prodaux2
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Produto'],
            'name' => utf8_encode($row['NomeProduto']),
            'value' => $row['ValorProduto'],
        );
    }

}

elseif ($_GET['q'] == 9) {

    $result = mysql_query(
            'SELECT
                V.idTab_Valor,
                CONCAT(IFNULL(P.CodProd,""), " - ", IFNULL(P.Produtos,""), " - R$ ", V.ValorProduto, " -- ", 
						IFNULL(V.Convdesc,""), " --- ", IFNULL(TP3.Prodaux3,""), " -- ", IFNULL(TP1.Prodaux1,""), " -- ", 
						IFNULL(TP2.Prodaux2,""), " -- ", IFNULL(TCO.Convenio,""), " -- ", IFNULL(TFO.NomeFornecedor,"")) AS NomeProduto,
                V.ValorProduto,
				P.Categoria
            FROM
                
                Tab_Valor AS V
					LEFT JOIN Tab_Convenio AS TCO ON idTab_Convenio = V.Convenio
					LEFT JOIN Tab_Produto AS P ON P.idTab_Produto = V.idTab_Produto
					LEFT JOIN App_Fornecedor AS TFO ON TFO.idApp_Fornecedor = P.Fornecedor
					LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = P.Prodaux3
					LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = P.Prodaux2
					LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = P.Prodaux1
            WHERE
				P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND 
                P.idTab_Produto = V.idTab_Produto
			ORDER BY
				P.CodProd ASC,
				P.Categoria ASC,
				TP3.Prodaux3,				
				P.Produtos ASC,
				TP1.Prodaux1,
				TP2.Prodaux2,
				TFO.NomeFornecedor ASC'
        );

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Valor'],
            #'name' => utf8_encode($row['NomeProduto']),
            #'name' => $row['NomeProduto'],
            'name' => mb_convert_encoding($row['NomeProduto'], "UTF-8", "ISO-8859-1"),
            'value' => $row['ValorProduto'],
        );
    }

}
elseif ($_GET['q'] == 6) {

    $result = mysql_query(
            'SELECT
				P.idApp_Profissional,
				CONCAT(F.Abrev, " --- ", P.NomeProfissional) AS NomeProfissional
            FROM
                App_Profissional AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.idSis_Usuario = ' . $_SESSION['log']['id'] . '
                ORDER BY F.Abrev ASC, P.NomeProfissional ASC'
    );

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idApp_Profissional'],
            'name' => utf8_encode($row['NomeProfissional']),
        );
    }

}

elseif ($_GET['q'] == 4) {

    $result = mysql_query(
            'SELECT
				idTab_Convenio,
				Convenio,
				Abrev
            FROM
                Tab_Convenio
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				((3 = ' . $_SESSION['log']['Nivel'] . ' OR 
				4 = ' . $_SESSION['log']['Nivel'] . ' ) AND
				idTab_Convenio = "53") OR 
				(6 = ' . $_SESSION['log']['Nivel'] . ' AND
				(idTab_Convenio = "53" OR 
				idTab_Convenio = "54"))
				
			ORDER BY Convenio ASC'
    );

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Convenio'],
            'name' => utf8_encode($row['Convenio']),
        );
    }

}

elseif ($_GET['q'] == 7) {

    $result = mysql_query(
            'SELECT
				idTab_Prioridade,
				Prioridade
            FROM
                Tab_Prioridade
			ORDER BY 
				idTab_Prioridade DESC'
    );

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Prioridade'],
            'name' => utf8_encode($row['Prioridade']),
        );
    }

}

elseif ($_GET['q'] == 3) {

    $result = mysql_query(
            'SELECT
				P.idSis_Usuario,
				CONCAT(P.Nome) AS Nome
            FROM
                Sis_Usuario AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.idSis_Usuario = ' . $_SESSION['log']['id'] . ' 
                ORDER BY P.Nome ASC'
    );

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idSis_Usuario'],
            'name' => utf8_encode($row['Nome']),
        );
    }

}

echo json_encode($event_array);
mysql_close($link);
?>
