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

elseif ($_GET['q'] == 16) {

    $result = mysql_query('
            SELECT
                idTab_Atributo,
                CONCAT(IFNULL(Atributo,"")) AS Atributo
            FROM 
                Tab_Atributo 
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				Atributo ASC	
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Atributo'],
            'name' => utf8_encode($row['Atributo']),
        );
    } 
    
}

elseif ($_GET['q'] == 11) {

    $result = mysql_query('
            SELECT
                idTab_Produto,
                CONCAT(IFNULL(CodProd,""), " - ", IFNULL(Produtos,""), " - ", IFNULL(UnidadeProduto,""), " - ", IFNULL(ValorProdutoSite,"")) AS NomeProduto,
                ValorProdutoSite
            FROM 
                Tab_Produto 
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY
				NomeProduto ASC	
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Produto'],
            'name' => utf8_encode($row['NomeProduto']),
            'value' => $row['ValorProdutoSite'],
        );
    } 
    
}

elseif ($_GET['q'] == 12) {

    $result = mysql_query('
            SELECT
                TPS.idTab_Produtos,
				TPS.idTab_Produto,
				TOP2.Opcao,
				TOP1.Opcao,				
				CONCAT(IFNULL(TPS.Nome_Prod,""), " - ", IFNULL(TOP2.Opcao,""), " - ", IFNULL(TOP1.Opcao,""), " - ", IFNULL(TPS.Valor_Produto,"")) AS Nome_Prod,
                TPS.Valor_Produto
            FROM 
                Tab_Produtos AS TPS
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPS.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPS.Opcao_Atributo_2			
            WHERE
                TPS.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				TPS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TPS.idTab_Produto = ' . $_SESSION['Promocao']['Mod_1'] . '
			ORDER BY
				TPS.Nome_Prod ASC	
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Produtos'],
            'name' => utf8_encode($row['Nome_Prod']),
            'value' => $row['Valor_Produto'],
        );
    } 
    
}

elseif ($_GET['q'] == 15) {

    $result = mysql_query('
            SELECT
                TPS.idTab_Produtos,
				TPS.idTab_Produto,
				TOP2.Opcao,
				TOP1.Opcao,				
				CONCAT(IFNULL(TPS.Nome_Prod,""), " - ", IFNULL(TOP2.Opcao,""), " - ", IFNULL(TOP1.Opcao,""), " - ", IFNULL(TPS.Valor_Produto,"")) AS Nome_Prod,
                TPS.Valor_Produto
            FROM 
                Tab_Produtos AS TPS
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPS.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPS.Opcao_Atributo_2				
            WHERE
                TPS.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				TPS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TPS.idTab_Produto = ' . $_SESSION['Produto']['idTab_Produto'] . '
			ORDER BY
				TPS.Nome_Prod ASC	
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Produtos'],
            'name' => utf8_encode($row['Nome_Prod']),
            'value' => $row['Valor_Produto'],
        );
    } 
    
}

elseif ($_GET['q'] == 13) {

    $result = mysql_query('
            SELECT
                TPS.idTab_Produtos,
				TPS.idTab_Produto,
				TCP.idTab_Cor_Prod,
				TCP.Nome_Cor_Prod,
				TTP.idTab_Tam_Prod,
				TTP.Nome_Tam_Prod,
				CONCAT(IFNULL(TPS.Nome_Prod,""), " - ", IFNULL(TCP.Nome_Cor_Prod,""), " - ", IFNULL(TTP.Nome_Tam_Prod,""), " - ", IFNULL(TPS.Valor_Produto,"")) AS Nome_Prod,
                TPS.Valor_Produto
            FROM 
                Tab_Produtos AS TPS
					LEFT JOIN Tab_Cor_Prod AS TCP ON TCP.idTab_Cor_Prod = TPS.Opcao_Atributo_1
					LEFT JOIN Tab_Tam_Prod AS TTP ON TTP.idTab_Tam_Prod = TPS.Opcao_Atributo_2				
            WHERE
                TPS.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				TPS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TPS.idTab_Produto = ' . $_SESSION['Promocao']['Mod_2'] . '
			ORDER BY
				TPS.Nome_Prod ASC	
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Produtos'],
            'name' => utf8_encode($row['Nome_Prod']),
            'value' => $row['Valor_Produto'],
        );
    } 
    
}

elseif ($_GET['q'] == 14) {
	
    $result = mysql_query('
            SELECT
                TPS.idTab_Produtos,
				TPS.idTab_Produto,
				TCP.idTab_Cor_Prod,
				TCP.Nome_Cor_Prod,
				TTP.idTab_Tam_Prod,
				TTP.Nome_Tam_Prod,
				CONCAT(IFNULL(TPS.Nome_Prod,""), " - ", IFNULL(TCP.Nome_Cor_Prod,""), " - ", IFNULL(TTP.Nome_Tam_Prod,""), " - ", IFNULL(TPS.Valor_Produto,"")) AS Nome_Prod,
                TPS.Valor_Produto
            FROM 
                Tab_Produtos AS TPS
					LEFT JOIN Tab_Cor_Prod AS TCP ON TCP.idTab_Cor_Prod = TPS.Opcao_Atributo_1
					LEFT JOIN Tab_Tam_Prod AS TTP ON TTP.idTab_Tam_Prod = TPS.Opcao_Atributo_2				
            WHERE
                TPS.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				TPS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TPS.idTab_Produto = ' . $_SESSION['Promocao']['Mod_3'] . '
			ORDER BY
				TPS.Nome_Prod ASC	
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Produtos'],
            'name' => utf8_encode($row['Nome_Prod']),
            'value' => $row['Valor_Produto'],
        );
    } 
    
}

elseif ($_GET['q'] == 20) {

    $result = mysql_query('
            SELECT
                idTab_Produtos,
				Nome_Prod,
                CONCAT(IFNULL(Nome_Prod,"")) AS NomeProduto
            FROM 
                Tab_Produtos 
            WHERE
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Produtos'],
            'name' => utf8_encode($row['NomeProduto']),
        );
    } 
    
}

elseif ($_GET['q'] == 2) {

    $result = mysql_query('
            SELECT
                idTab_Produto,
                CONCAT(IFNULL(Produtos,"")) AS NomeProduto,
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

elseif ($_GET['q'] == 90) {

    $result = mysql_query('
            SELECT
                V.idTab_Valor,
                V.ValorProduto,
				V.QtdProdutoIncremento,
				TOP2.Opcao,
				TOP1.Opcao,				
				CONCAT(IFNULL(V.QtdProdutoIncremento,""), " - ", IFNULL(P.Nome_Prod,""), " - ", IFNULL(TOP2.Opcao,""), " - ", IFNULL(TOP1.Opcao,""), " - ", IFNULL(V.ValorProduto,"")) AS NomeProduto
            FROM
                Tab_Valor AS V
					LEFT JOIN Tab_Produtos AS P ON P.idTab_Produtos = V.idTab_Produtos
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = P.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = P.Opcao_Atributo_2				
            WHERE
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND 
				P.idTab_Produtos = V.idTab_Produtos
			ORDER BY
				P.Nome_Prod ASC
        ');

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

elseif ($_GET['q'] == 9) {

    $result = mysql_query(
            'SELECT
                V.idTab_Valor,
                CONCAT(IFNULL(P.CodProd,""), " - ", IFNULL(P.Produtos,""), " - ", IFNULL(TCO.Convenio,""), " - ", IFNULL(V.Convdesc,""), " - R$ ", V.ValorProduto) AS NomeProduto,
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
				P.TipoProduto DESC,
				TP3.Prodaux3,				
				P.Produtos ASC,				
				P.Categoria ASC,
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
                P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . '
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

elseif ($_GET['q'] == 5) {

    $result = mysql_query(
            'SELECT
				idApp_Fornecedor,
				NomeFornecedor
            FROM
                App_Fornecedor
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
			ORDER BY 
				NomeFornecedor ASC'
    );

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idApp_Fornecedor'],
            'name' => utf8_encode($row['NomeFornecedor']),
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
				idTab_Prioridade ASC'
    );

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Prioridade'],
            'name' => utf8_encode($row['Prioridade']),
        );
    }

}

elseif ($_GET['q'] == 8) {
	
    $result = mysql_query(
            'SELECT
				idTab_Desconto,
				Desconto
            FROM
                Tab_Desconto
			ORDER BY 
				idTab_Desconto ASC'
    );

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Desconto'],
            'name' => utf8_encode($row['Desconto']),
        );
    }

}

elseif ($_GET['q'] == 10) {

    $result = mysql_query(
            'SELECT
				idTab_Statustarefa,
				Statustarefa
            FROM
                Tab_Statustarefa
			ORDER BY 
				idTab_Statustarefa ASC'
    );

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Statustarefa'],
            'name' => utf8_encode($row['Statustarefa']),
        );
    }

}

elseif ($_GET['q'] == 3) {

    $result = mysql_query('
            SELECT
				P.idSis_Usuario,
				CONCAT(IFNULL(P.Nome,""), " -- ", IFNULL(F.Funcao,"")) AS Nome
            FROM
                Sis_Usuario AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '  
			ORDER BY 
				F.Funcao ASC,
				P.Nome ASC
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idSis_Usuario'],
            'name' => utf8_encode($row['Nome']),
        );
    }

}

elseif ($_GET['q'] == 93) {
//// daqui, eu pego A Categoria
    $result = mysql_query('
            SELECT
				P.idTab_Prodaux3,
				P.Prodaux3
				
            FROM
                Tab_Prodaux3 AS P
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '  
			ORDER BY 
				P.Prodaux3 ASC
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Prodaux3'],
            'name' => utf8_encode($row['Prodaux3']),
        );
    }

}

elseif ($_GET['q'] == 92) {
//// daqui, Tipo/Cor, eu pego o Valor R$.....
    $result = mysql_query('
            SELECT
				P.idTab_Prodaux2,
				P.Prodaux2,
				P.Prodaux3,
				P3.Prodaux3,
				CONCAT(IFNULL(P3.Prodaux3,""), " - ", IFNULL(P.Prodaux2,"")) AS Prodaux2
            FROM
                Tab_Prodaux2 AS P
					LEFT JOIN Tab_Prodaux3 AS P3 ON P3.idTab_Prodaux3 = P.Prodaux3
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.Prodaux3 = ' . $_SESSION['Produto']['Prodaux3'] . ' 
			ORDER BY 
				P3.Prodaux3 ASC,
				P.Prodaux2 ASC
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Prodaux2'],
            'name' => utf8_encode($row['Prodaux2']),
        );
    }

}

elseif ($_GET['q'] == 91) {
//// daqui, Esp/Tamanho, eu pego o Fator de Multiplicação
    $result = mysql_query('
            SELECT
				P.idTab_Prodaux1,
				P.Prodaux1,
				P.Prodaux3,
				P3.Prodaux3,
				CONCAT(IFNULL(P3.Prodaux3,""), " - ", IFNULL(P.Prodaux1,"")) AS Prodaux1
            FROM
                Tab_Prodaux1 AS P
					LEFT JOIN Tab_Prodaux3 AS P3 ON P3.idTab_Prodaux3 = P.Prodaux3
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.Prodaux3 = ' . $_SESSION['Produto']['Prodaux3'] . ' 
			ORDER BY 
				P3.Prodaux3 ASC,
				P.Prodaux1 ASC
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Prodaux1'],
            'name' => utf8_encode($row['Prodaux1']),
        );
    }

}

elseif ($_GET['q'] == 95) {
//// daqui, Esp/Tamanho, eu pego o Fator de Multiplicação
    $result = mysql_query('
            SELECT
				P.idTab_Promocao,
				P.Promocao,
				P.Descricao,
				CONCAT(IFNULL(P.Promocao,""), " - ", IFNULL(P.Descricao,"")) AS Promocao
            FROM
                Tab_Promocao AS P
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '  
			ORDER BY 
				P.Promocao ASC
				
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Promocao'],
            'name' => utf8_encode($row['Promocao']),
        );
    }

}

elseif ($_GET['q'] == 98) {
//// daqui, eu pegoo Tipo
    $result = mysql_query('
            SELECT
				P.idTab_Opcao_Select,
				P.idTab_Opcao,
				P.idTab_Produto,
				P.Item_Atributo,
				TOP.Opcao,
				CONCAT(IFNULL(TOP.Opcao,"")) AS Opcao
            FROM
                Tab_Opcao_Select AS P
					LEFT JOIN Tab_Opcao AS TOP ON TOP.idTab_Opcao = P.idTab_Opcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.idTab_Produto = ' . $_SESSION['Produto']['idTab_Produto'] . ' AND
				P.Item_Atributo = "1"
			ORDER BY 
				TOP.Opcao ASC
				
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Opcao'],
            'name' => utf8_encode($row['Opcao']),
        );
    }

}

elseif ($_GET['q'] == 97) {
//// daqui, eu pegoo Tipo
    $result = mysql_query('
            SELECT
				P.idTab_Opcao_Select,
				P.idTab_Opcao,
				P.idTab_Produto,
				P.Item_Atributo,
				TOP.Opcao,
				CONCAT(IFNULL(TOP.Opcao,"")) AS Opcao
            FROM
                Tab_Opcao_Select AS P
					LEFT JOIN Tab_Opcao AS TOP ON TOP.idTab_Opcao = P.idTab_Opcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.idTab_Produto = ' . $_SESSION['Produto']['idTab_Produto'] . ' AND
				P.Item_Atributo = "2"
			ORDER BY 
				TOP.Opcao ASC
				
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Opcao'],
            'name' => utf8_encode($row['Opcao']),
        );
    }

}

elseif ($_GET['q'] == 101) {

    $permissao1 = isset($_SESSION['Atributos'][1]) ? 'AND idTab_Atributo = ' . $_SESSION['Atributos'][1] : FALSE;
	
	$result = mysql_query('
            SELECT
                idTab_Opcao,
				idTab_Atributo,
				idTab_Catprod,
                CONCAT(IFNULL(Opcao,"")) AS Opcao
            FROM 
                Tab_Opcao 
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
				' . $permissao1 . '
			ORDER BY 
				Opcao ASC	
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Opcao'],
            'name' => utf8_encode($row['Opcao']),
        );
    } 
    
}

elseif ($_GET['q'] == 102) {

    $permissao2 = isset($_SESSION['Atributos'][2]) ? 'AND idTab_Atributo = ' . $_SESSION['Atributos'][2] : FALSE;
	
	$result = mysql_query('
            SELECT
                idTab_Opcao,
				idTab_Atributo,
				idTab_Catprod,
                CONCAT(IFNULL(Opcao,"")) AS Opcao
            FROM 
                Tab_Opcao 
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
				' . $permissao2 . '
			ORDER BY 
				Opcao ASC	
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Opcao'],
            'name' => utf8_encode($row['Opcao']),
        );
    } 
    
}

elseif ($_GET['q'] == 105) {

    $result = mysql_query('
            SELECT
                TAS.idTab_Atributo_Select,
				TAS.idTab_Atributo,
				TAS.idTab_Catprod,
				TAT.Atributo,
                CONCAT(IFNULL(TAT.Atributo,"")) AS Atributo
            FROM 
                Tab_Atributo_Select AS TAS
					LEFT JOIN Tab_Atributo AS TAT ON TAT.idTab_Atributo = TAS.idTab_Atributo
            WHERE
				TAS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TAS.idTab_Catprod = ' . $_SESSION['Produto']['Prodaux3'] . ' 
			ORDER BY 
				TAT.Atributo ASC	
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Atributo'],
            'name' => utf8_encode($row['Atributo']),
        );
    } 
    
}
echo json_encode($event_array);
mysql_close($link);
?>
