<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Orcatrata_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

    public function set_orcatrata($data) {

        $query = $this->db->insert('App_OrcaTrata', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }	

    public function set_servico($data) {

        /*
        //echo $this->db->last_query();
        echo '<br>';
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        //exit ();
        */

        $query = $this->db->insert_batch('App_Servico', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_produto($data) {

        $query = $this->db->insert_batch('App_Produto', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
		#return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_parcelas($data) {

        $query = $this->db->insert_batch('App_Parcelas', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }
	
    public function set_procedimento($data) {

        $query = $this->db->insert_batch('App_Procedimento', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_orcatrata($data) {
        $query = $this->db->query('
			SELECT * 
			FROM 
				App_OrcaTrata AS OT 
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN Tab_FormaPag AS FP ON FP.idTab_FormaPag = OT.FormaPagamento
					LEFT JOIN Sis_Usuario AS SU ON SU.idSis_Usuario = OT.Entregador
			WHERE 
				idApp_OrcaTrata = ' . $data . '
		');
        $query = $query->result_array();

        /*
        //echo $this->db->last_query();
        echo '<br>';
        echo "<pre>";
        print_r($query);
        echo "</pre>";
        exit ();
        */

        return $query[0];
    }
	
    public function get_orcatrata2($data) {
        $query = $this->db->query('
		SELECT * 
			FROM 
				App_OrcaTrata AS OT 
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN Tab_FormaPag AS FP ON FP.idTab_FormaPag = OT.FormaPagamento
					LEFT JOIN Tab_AVAP AS TAVAP ON TAVAP.Abrev2 = OT.AVAP
					LEFT JOIN Tab_TipoFrete AS TTF ON TTF.idTab_TipoFrete = OT.TipoFrete
					LEFT JOIN Sis_Usuario AS SU ON SU.idSis_Usuario = OT.Entregador
			WHERE 
				idApp_OrcaTrata = ' . $data . '
		');
        $query = $query->result_array();

        /*
        //echo $this->db->last_query();
        echo '<br>';
        echo "<pre>";
        print_r($query);
        echo "</pre>";
        exit ();
        */

        return $query[0];
    }	

    public function get_cliente($data) {
        $query = $this->db->query('SELECT * FROM App_Cliente WHERE idApp_Cliente = ' . $data);

        $query = $query->result_array();

        return $query[0];
    }
	
    public function get_orcatrataalterar($data) {
        $query = $this->db->query('SELECT * FROM Sis_Empresa WHERE idSis_Empresa = ' . $data);
        $query = $query->result_array();

        /*
        //echo $this->db->last_query();
        echo '<br>';
        echo "<pre>";
        print_r($query);
        echo "</pre>";
        exit ();
        */

        return $query[0];
    }
	
	public function get_servico_bkp($data) {
		$query = $this->db->query('SELECT * FROM App_Servico WHERE idApp_OrcaTrata = ' . $data);
        $query = $query->result_array();

        return $query;
    }
	
    public function get_servico($data) {
		$query = $this->db->query('
			SELECT 
				TAP.idApp_Servico,
				TAP.idSis_Empresa,
				TAP.idTab_Modulo,
				TAP.idApp_OrcaTrata,
				TAP.idApp_Cliente,
				TAP.idApp_Fornecedor,
				TAP.idSis_Usuario,
				TAP.idTab_Servico,
				TAP.idTab_Valor_Servico,
				TAP.idTab_Produtos_Servico,
				TAP.ValorServico,
				TAP.ObsServico,
				TAP.QtdServico,
				TAP.QtdIncrementoServico,
				TAP.DataValidadeServico,
				TAP.ConcluidoServico,
				TAP.idTab_TipoRD,
				TAP.ProfissionalServico,
				P.Nome_Prod,
				TOP2.Opcao,
				TOP1.Opcao,
				SU.Nome,
				CONCAT(IFNULL(P.Nome_Prod,""), " - ", IFNULL(TOP2.Opcao,""), " - ", IFNULL(TOP1.Opcao,""), " - ", IFNULL(TDS.Desconto,""), " - ", IFNULL(TPM.Promocao,""), " - ", IFNULL(SU.Nome,"")) AS Servico,
				(TAP.QtdServico * TAP.ValorServico) AS Subtotal_Servico
			FROM 
				App_Servico AS TAP
					LEFT JOIN Sis_Usuario AS SU ON SU.idSis_Usuario = TAP.ProfissionalServico
					LEFT JOIN Tab_Valor AS V ON V.idTab_Valor = TAP.idTab_Servico
					LEFT JOIN Tab_Promocao AS TPM ON TPM.idTab_Promocao = V.idTab_Promocao
					LEFT JOIN Tab_Desconto AS TDS ON TDS.idTab_Desconto = V.Desconto
					LEFT JOIN Tab_Produtos AS P ON P.idTab_Produtos = V.idTab_Produtos
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = P.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = P.Opcao_Atributo_2
			WHERE 
				TAP.idApp_OrcaTrata = ' . $data . '
		');
        $query = $query->result_array();

        return $query;
    }	

	public function get_servicodesp($data) {
		$query = $this->db->query('SELECT * FROM App_Servico WHERE idTab_TipoRD = "3" AND idApp_OrcaTrata = ' . $data);
        $query = $query->result_array();

        return $query;
    }
	
    public function get_produto($data) {
		$query = $this->db->query('
			SELECT 
			TAP.idApp_Produto,
				TAP.idSis_Empresa,
				TAP.idTab_Modulo,
				TAP.idApp_OrcaTrata,
				TAP.idApp_Cliente,
				TAP.idApp_Fornecedor,
				TAP.idSis_Usuario,
				TAP.idTab_Produto,
				TAP.idTab_Valor_Produto,
				TAP.idTab_Produtos_Produto,
				TAP.NomeProduto,
				TAP.ValorProduto,
				TAP.QtdProduto,
				TAP.QtdIncrementoProduto,
				(TAP.QtdProduto * TAP.QtdIncrementoProduto) AS SubTotalQtd,
				TAP.ValorCompraProduto,
				TAP.QtdCompraProduto,
				TAP.ObsProduto,
				TAP.DataValidadeProduto,
				TAP.HoraValidadeProduto,
				TAP.ConcluidoProduto,
				TAP.DevolvidoProduto,
				TAP.CanceladoProduto,
				TAP.idTab_TipoRD,
				TAP.itens_pedido_valor_total,
				TAP.ComissaoProduto,
				TAP.StatusComissao,
				TAP.Aux_App_Produto_1,
				TAP.Aux_App_Produto_2,
				TAP.Aux_App_Produto_3,
				TAP.Aux_App_Produto_4,
				TAP.Aux_App_Produto_5,
				V.Convdesc,
				P.Nome_Prod,
				TOP2.Opcao,
				TOP1.Opcao,
				CONCAT(IFNULL(P.Nome_Prod,""), " - ",  IFNULL(TOP1.Opcao,""), " - ", IFNULL(TOP2.Opcao,""), " - ", IFNULL(V.Convdesc,"")) AS Produto,
				(TAP.QtdProduto * TAP.ValorProduto) AS Subtotal_Produto
			FROM 
				App_Produto AS TAP
					LEFT JOIN Tab_Valor AS V ON V.idTab_Valor = TAP.idTab_Produto
					LEFT JOIN Tab_Promocao AS TPM ON TPM.idTab_Promocao = V.idTab_Promocao
					LEFT JOIN Tab_Desconto AS TDS ON TDS.idTab_Desconto = V.Desconto
					LEFT JOIN Tab_Produtos AS P ON P.idTab_Produtos = V.idTab_Produtos
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = P.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = P.Opcao_Atributo_2
			WHERE 
				TAP.idApp_OrcaTrata = ' . $data . '
		');
        $query = $query->result_array();

        return $query;
    }

    public function get_produto_bkp($data) {
		$query = $this->db->query('
			SELECT * 
			FROM 
				App_Produto
			WHERE 
				idApp_OrcaTrata = ' . $data . '
		');
        $query = $query->result_array();

        return $query;
    }
	
    public function get_produtodesp_bkp($data) {
		$query = $this->db->query('SELECT * FROM App_Produto WHERE idTab_TipoRD = "1" AND idApp_OrcaTrata = ' . $data);
        $query = $query->result_array();

        return $query;
    }
	
    public function get_produtodesp($data) {
		$query = $this->db->query('
			SELECT
				TAP.idApp_Produto,
				TAP.idSis_Empresa,
				TAP.idTab_Modulo,
				TAP.idApp_OrcaTrata,
				TAP.idApp_Cliente,
				TAP.idApp_Fornecedor,
				TAP.idSis_Usuario,
				TAP.idTab_Produto,
				TAP.idTab_Valor_Produto,
				TAP.idTab_Produtos_Produto,
				TAP.NomeProduto,
				TAP.ValorProduto,
				TAP.QtdProduto,
				TAP.QtdIncrementoProduto,
				(TAP.QtdProduto * TAP.QtdIncrementoProduto) AS SubTotalQtd,
				TAP.ValorCompraProduto,
				TAP.QtdCompraProduto,
				TAP.ObsProduto,
				TAP.DataValidadeProduto,
				TAP.HoraValidadeProduto,
				TAP.ConcluidoProduto,
				TAP.DevolvidoProduto,
				TAP.CanceladoProduto,
				TAP.idTab_TipoRD,
				TAP.itens_pedido_valor_total,
				TAP.ComissaoProduto,
				TAP.StatusComissao,
				TAP.Aux_App_Produto_1,
				TAP.Aux_App_Produto_2,
				TAP.Aux_App_Produto_3,
				TAP.Aux_App_Produto_4,
				TAP.Aux_App_Produto_5,
				P.Nome_Prod,
				TOP2.Opcao,
				TOP1.Opcao,
				CONCAT(IFNULL(P.Nome_Prod,""), " - ",  IFNULL(TOP1.Opcao,""), " - ", IFNULL(TOP2.Opcao,"")) AS Produto,
				(TAP.QtdProduto * TAP.ValorProduto) AS Subtotal_Produto
			FROM 
				App_Produto AS TAP
					LEFT JOIN Tab_Produtos AS P ON P.idTab_Produtos = TAP.idTab_Produto
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = P.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = P.Opcao_Atributo_2 
			WHERE 
				TAP.idApp_OrcaTrata = ' . $data . '
		');
        $query = $query->result_array();

        return $query;
    }	

    public function get_parcelas($data) {
		$query = $this->db->query('SELECT * FROM App_Parcelas WHERE idApp_OrcaTrata = ' . $data);
        $query = $query->result_array();

        return $query;
    }
	
	public function get_alterarparceladesp($data) {

        if ($_SESSION['FiltroAlteraParcela']['DataFim']) {
            $consulta =
                '(PR.DataVencimento >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '" AND PR.DataVencimento <= "' . $_SESSION['FiltroAlteraParcela']['DataFim'] . '")';
        }
        else {
            $consulta =
                '(PR.DataVencimento >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '")';
        }
		#$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'PR.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		$permissao1 = ($_SESSION['FiltroAlteraParcela']['Quitado'] != "0" ) ? 'PR.Quitado = "' . $_SESSION['FiltroAlteraParcela']['Quitado'] . '" AND ' : FALSE;
		$permissao2 = ($_SESSION['FiltroAlteraParcela']['Mesvenc'] != "0" ) ? 'MONTH(PR.DataVencimento) = "' . $_SESSION['FiltroAlteraParcela']['Mesvenc'] . '" AND ' : FALSE;
		$permissao3 = ($_SESSION['FiltroAlteraParcela']['Ano'] != "0" ) ? 'YEAR(PR.DataVencimento) = "' . $_SESSION['FiltroAlteraParcela']['Ano'] . '" AND ' : FALSE;
		$permissao4 = ($_SESSION['FiltroAlteraParcela']['Orcades'] != "0" ) ? 'OT.idApp_OrcaTrata = "' . $_SESSION['FiltroAlteraParcela']['Orcades'] . '" AND ' : FALSE;
		$permissao6 = ($_SESSION['FiltroAlteraParcela']['FormaPagamento'] != "0" ) ? 'OT.FormaPagamento = "' . $_SESSION['FiltroAlteraParcela']['FormaPagamento'] . '" AND ' : FALSE;
		$permissao5 = (($_SESSION['log']['idSis_Empresa'] != 5) && ($_SESSION['FiltroAlteraParcela']['NomeFornecedor'] != "0" )) ? 'OT.idApp_Fornecedor = "' . $_SESSION['FiltroAlteraParcela']['NomeFornecedor'] . '" AND ' : FALSE;
		
		/*
		  echo $this->db->last_query();
          echo "<pre>";
          print_r($consulta);
          echo "</pre>";
          exit();		
		*/
		
		$query = $this->db->query('
			SELECT
				C.NomeFornecedor,
				OT.Descricao,
				OT.idApp_OrcaTrata,
				OT.TipoFinanceiro,
				DATE_FORMAT(OT.DataOrca, "%d/%m/%Y") AS DataOrca,				
				TD.TipoFinanceiro,
				CONCAT(IFNULL(PR.idApp_OrcaTrata,""), "-", IFNULL(OT.Descricao,"")) AS idApp_OrcaTrata,
				E.NomeEmpresa,
				CONCAT(PR.idSis_Empresa, "-", E.NomeEmpresa) AS idSis_Empresa,
				PR.idSis_Usuario,
				PR.idApp_Parcelas,
				PR.Parcela,
				CONCAT(IFNULL(PR.idApp_OrcaTrata,""), "--", IFNULL(TD.TipoFinanceiro,""), "--", IFNULL(C.NomeFornecedor,""), "--", IFNULL(OT.Descricao,"")) AS Despesa,
				PR.ValorParcela,
				PR.DataVencimento,
				PR.ValorPago,
				PR.DataPago,
				PR.Quitado
			FROM
				App_Parcelas AS PR
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN Tab_TipoFinanceiro AS TD ON TD.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = PR.idSis_Empresa
					LEFT JOIN App_Fornecedor AS C ON C.idApp_Fornecedor = OT.idApp_Fornecedor
			WHERE
				' . $permissao . '
				OT.idSis_Empresa = ' . $data . ' AND
				OT.idTab_TipoRD = "1" AND				
				OT.AprovadoOrca = "S" AND				
				PR.idSis_Empresa = ' . $data . ' AND
				' . $consulta . ' AND
				' . $permissao1 . '
				' . $permissao5 . '
				' . $permissao6 . '
				PR.idTab_TipoRD = "1"
			ORDER BY
				PR.DataVencimento
		');
        $query = $query->result_array();

        return $query;
    }
	
    public function get_alterarparcelarec($data) {

        if ($_SESSION['FiltroAlteraParcela']['DataFim']) {
            $consulta =
                '(PR.DataVencimento >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '" AND PR.DataVencimento <= "' . $_SESSION['FiltroAlteraParcela']['DataFim'] . '")';
        }
        else {
            $consulta =
                '(PR.DataVencimento >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '")';
        }		
		#$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'PR.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		$permissao1 = ($_SESSION['FiltroAlteraParcela']['Quitado'] != "0" ) ? 'PR.Quitado = "' . $_SESSION['FiltroAlteraParcela']['Quitado'] . '" AND ' : FALSE;
		$permissao7 = ($_SESSION['FiltroAlteraParcela']['AprovadoOrca'] != "0" ) ? 'OT.AprovadoOrca = "' . $_SESSION['FiltroAlteraParcela']['AprovadoOrca'] . '" AND ' : FALSE;
		$permissao8 = ($_SESSION['FiltroAlteraParcela']['ConcluidoOrca'] != "0" ) ? 'OT.ConcluidoOrca = "' . $_SESSION['FiltroAlteraParcela']['ConcluidoOrca'] . '" AND ' : FALSE;
		$permissao9 = ($_SESSION['FiltroAlteraParcela']['QuitadoOrca'] != "0" ) ? 'OT.QuitadoOrca = "' . $_SESSION['FiltroAlteraParcela']['QuitadoOrca'] . '" AND ' : FALSE;
		$permissao2 = ($_SESSION['FiltroAlteraParcela']['Mesvenc'] != "0" ) ? 'MONTH(PR.DataVencimento) = "' . $_SESSION['FiltroAlteraParcela']['Mesvenc'] . '" AND ' : FALSE;
		$permissao3 = ($_SESSION['FiltroAlteraParcela']['Ano'] != "0" ) ? 'YEAR(PR.DataVencimento) = "' . $_SESSION['FiltroAlteraParcela']['Ano'] . '" AND ' : FALSE;
		$permissao4 = ($_SESSION['FiltroAlteraParcela']['Orcarec'] != "0" ) ? 'OT.idApp_OrcaTrata = "' . $_SESSION['FiltroAlteraParcela']['Orcarec'] . '" AND ' : FALSE;
		$permissao6 = ($_SESSION['FiltroAlteraParcela']['FormaPagamento'] != "0" ) ? 'OT.FormaPagamento = "' . $_SESSION['FiltroAlteraParcela']['FormaPagamento'] . '" AND ' : FALSE;
		$permissao5 = (($_SESSION['log']['idSis_Empresa'] != 5) && ($_SESSION['FiltroAlteraParcela']['NomeCliente'] != "0" )) ? 'OT.idApp_Cliente = "' . $_SESSION['FiltroAlteraParcela']['NomeCliente'] . '" AND ' : FALSE;
		
		$query = $this->db->query('
			SELECT
				C.NomeCliente,
				OT.idApp_OrcaTrata,
				OT.Descricao,
				OT.TipoFinanceiro,
				OT.AprovadoOrca,
				OT.ConcluidoOrca,
				OT.QuitadoOrca,
				DATE_FORMAT(OT.DataOrca, "%d/%m/%Y") AS DataOrca,
				TR.TipoFinanceiro,
				CONCAT(IFNULL(PR.idApp_OrcaTrata,""), "-", IFNULL(OT.Descricao,"")) AS idApp_OrcaTrata,
				E.NomeEmpresa,
				PR.idSis_Usuario,
				CONCAT(PR.idSis_Empresa, "-", E.NomeEmpresa) AS idSis_Empresa,
				PR.idApp_Parcelas,
				PR.Parcela,
				CONCAT(IFNULL(PR.idApp_OrcaTrata,""), "--", IFNULL(TR.TipoFinanceiro,""), "--", IFNULL(C.NomeCliente,""), "--", IFNULL(OT.Descricao,"")) AS Receita,
				PR.ValorParcela,
				PR.DataVencimento,
				PR.ValorPago,
				PR.DataPago,
				PR.Quitado				
			FROM 
				App_Parcelas AS PR
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = PR.idSis_Empresa
			WHERE 
				' . $permissao . '
				OT.idSis_Empresa = ' . $data . ' AND
				OT.idTab_TipoRD = "2" AND				
				OT.AprovadoOrca = "S" AND				
				PR.idSis_Empresa = ' . $data . ' AND
				' . $consulta . ' AND				
				' . $permissao1 . '
				' . $permissao5 . '
				' . $permissao6 . '
				' . $permissao7 . '
				' . $permissao8 . '
				' . $permissao9 . '
				PR.idTab_TipoRD = "2"
			ORDER BY
				PR.DataVencimento  
		');
        $query = $query->result_array();
          
        return $query;
    }	

	public function get_alterarparceladespfiado($data) {

		#$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'PR.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		$permissao1 = ($_SESSION['FiltroAlteraParcela']['Quitado'] != "0" ) ? 'PR.Quitado = "' . $_SESSION['FiltroAlteraParcela']['Quitado'] . '" AND ' : FALSE;
		$permissao2 = ($_SESSION['FiltroAlteraParcela']['Mesvenc'] != "0" ) ? 'MONTH(PR.DataVencimento) = "' . $_SESSION['FiltroAlteraParcela']['Mesvenc'] . '" AND ' : FALSE;
		$permissao3 = ($_SESSION['FiltroAlteraParcela']['Ano'] != "0" ) ? 'YEAR(PR.DataVencimento) = "' . $_SESSION['FiltroAlteraParcela']['Ano'] . '" AND ' : FALSE;
		$permissao4 = ($_SESSION['FiltroAlteraParcela']['Orcades'] != "0" ) ? 'OT.idApp_OrcaTrata = "' . $_SESSION['FiltroAlteraParcela']['Orcades'] . '" AND ' : FALSE;
		$permissao5 = (($_SESSION['log']['idSis_Empresa'] != 5) && ($_SESSION['FiltroAlteraParcela']['NomeFornecedor'] != "0" )) ? 'OT.idApp_Fornecedor = "' . $_SESSION['FiltroAlteraParcela']['NomeFornecedor'] . '" AND ' : FALSE;
		
		$query = $this->db->query('
			SELECT
				C.NomeFornecedor,
				OT.Descricao,
				OT.idApp_OrcaTrata,
				OT.TipoFinanceiro,
				DATE_FORMAT(OT.DataOrca, "%d/%m/%Y") AS DataOrca,
				TD.TipoFinanceiro,
				CONCAT(IFNULL(PR.idApp_OrcaTrata,""), "-", IFNULL(OT.Descricao,"")) AS idApp_OrcaTrata,
				E.NomeEmpresa,
				CONCAT(PR.idSis_Empresa, "-", E.NomeEmpresa) AS idSis_Empresa,
				PR.idSis_Usuario,
				PR.idApp_Parcelas,
				PR.Parcela,
				CONCAT(IFNULL(PR.idApp_OrcaTrata,""), "--", IFNULL(TD.TipoFinanceiro,""), "--", IFNULL(C.NomeFornecedor,""), "--", IFNULL(OT.Descricao,"")) AS Despesa,
				PR.ValorParcela,
				PR.DataVencimento,
				PR.ValorPago,
				PR.DataPago,
				PR.Quitado
			FROM
				App_Parcelas AS PR
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN Tab_TipoFinanceiro AS TD ON TD.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = PR.idSis_Empresa
					LEFT JOIN App_Fornecedor AS C ON C.idApp_Fornecedor = OT.idApp_Fornecedor
			WHERE
				' . $permissao . '
				' . $permissao5 . '				
				OT.idSis_Empresa = ' . $data . ' AND
				OT.AprovadoOrca = "S" AND
				PR.idSis_Empresa = ' . $data . ' AND			
				PR.idTab_TipoRD = "1" AND
				PR.idTab_TipoRD = "1" AND
				PR.Quitado = "N" AND
				PR.DataVencimento <= "' . date("Y-m-t", mktime(0,0,0,date('m'),'01',date('Y'))) . '"				
			ORDER BY
				C.NomeFornecedor,
				PR.DataVencimento
		');
        $query = $query->result_array();

        return $query;
    }
	
    public function get_alterarparcelarecfiado($data) {
		
		#$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'PR.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		$permissao1 = ($_SESSION['FiltroAlteraParcela']['Quitado'] != "0" ) ? 'PR.Quitado = "' . $_SESSION['FiltroAlteraParcela']['Quitado'] . '" AND ' : FALSE;
		$permissao2 = ($_SESSION['FiltroAlteraParcela']['Mesvenc'] != "0" ) ? 'MONTH(PR.DataVencimento) = "' . $_SESSION['FiltroAlteraParcela']['Mesvenc'] . '" AND ' : FALSE;
		$permissao3 = ($_SESSION['FiltroAlteraParcela']['Ano'] != "0" ) ? 'YEAR(PR.DataVencimento) = "' . $_SESSION['FiltroAlteraParcela']['Ano'] . '" AND ' : FALSE;
		$permissao4 = ($_SESSION['FiltroAlteraParcela']['Orcarec'] != "0" ) ? 'OT.idApp_OrcaTrata = "' . $_SESSION['FiltroAlteraParcela']['Orcarec'] . '" AND ' : FALSE;
		$permissao5 = (($_SESSION['log']['idSis_Empresa'] != 5) && ($_SESSION['FiltroAlteraParcela']['NomeCliente'] != "0" )) ? 'OT.idApp_Cliente = "' . $_SESSION['FiltroAlteraParcela']['NomeCliente'] . '" AND ' : FALSE;
		
		$query = $this->db->query('
			SELECT
				C.NomeCliente,
				OT.idApp_OrcaTrata,
				OT.Descricao,
				OT.TipoFinanceiro,
				DATE_FORMAT(OT.DataOrca, "%d/%m/%Y") AS DataOrca,				
				TR.TipoFinanceiro,
				CONCAT(IFNULL(PR.idApp_OrcaTrata,""), "-", IFNULL(OT.Descricao,"")) AS idApp_OrcaTrata,
				E.NomeEmpresa,
				PR.idSis_Usuario,
				CONCAT(PR.idSis_Empresa, "-", E.NomeEmpresa) AS idSis_Empresa,
				PR.idApp_Parcelas,
				PR.Parcela,
				CONCAT(IFNULL(PR.idApp_OrcaTrata,""), "--", IFNULL(TR.TipoFinanceiro,""), "--", IFNULL(C.NomeCliente,""), "--", IFNULL(OT.Descricao,"")) AS Receita,
				PR.ValorParcela,
				PR.DataVencimento,
				PR.ValorPago,
				PR.DataPago,
				PR.Quitado
			FROM 
				App_Parcelas AS PR
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = PR.idSis_Empresa
			WHERE 
				' . $permissao . '
				' . $permissao5 . '					
				OT.idSis_Empresa = ' . $data . ' AND
				OT.idTab_TipoRD = "2" AND				
				OT.AprovadoOrca = "S" AND

				PR.idSis_Empresa = ' . $data . ' AND
				PR.idTab_TipoRD = "2" AND			
				PR.Quitado = "N" AND
				PR.DataVencimento <= "' . date("Y-m-t", mktime(0,0,0,date('m'),'01',date('Y'))) . '"
			ORDER BY
				C.NomeCliente,
				PR.DataVencimento
		');
        $query = $query->result_array();

        return $query;
    }	

    public function get_alterarservicorec($data) {
		
		#$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataValidadeServico) = ' . $data['Mesvenc'] : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'PR.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		$permissao1 = ($_SESSION['FiltroAlteraParcela']['ConcluidoServico'] != "0" ) ? 'PR.ConcluidoServico = "' . $_SESSION['FiltroAlteraParcela']['ConcluidoServico'] . '" AND ' : FALSE;
		$permissao2 = ($_SESSION['FiltroAlteraParcela']['Mesvenc'] != "0" ) ? 'MONTH(PR.DataValidadeServico) = "' . $_SESSION['FiltroAlteraParcela']['Mesvenc'] . '" AND ' : FALSE;
		$permissao3 = ($_SESSION['FiltroAlteraParcela']['Ano'] != "0" ) ? 'YEAR(PR.DataValidadeServico) = "' . $_SESSION['FiltroAlteraParcela']['Ano'] . '" AND ' : FALSE;
		$permissao4 = ($_SESSION['FiltroAlteraParcela']['Orcarec'] != "0" ) ? 'OT.idApp_OrcaTrata = "' . $_SESSION['FiltroAlteraParcela']['Orcarec'] . '" AND ' : FALSE;
		$permissao5 = (($_SESSION['log']['idSis_Empresa'] != 5) && ($_SESSION['FiltroAlteraParcela']['NomeCliente'] != "0" )) ? 'OT.idApp_Cliente = "' . $_SESSION['FiltroAlteraParcela']['NomeCliente'] . '" AND ' : FALSE;
		
		$query = $this->db->query('
			SELECT
				C.NomeCliente,
				OT.idApp_OrcaTrata,
				OT.Descricao,
				OT.TipoFinanceiro,
				TR.TipoFinanceiro,
				E.NomeEmpresa,
				PR.idSis_Usuario,
				CONCAT(PR.idSis_Empresa, "-", E.NomeEmpresa) AS idSis_Empresa,
				CONCAT(OT.idApp_OrcaTrata,"-",C.NomeCliente) AS Servico,
				PR.idTab_Servico,
				PR.idApp_Servico,
				PR.DataValidadeServico,
				PR.ValorServico,
				PR.ConcluidoServico,
				PR.QtdServico,
				PR.ObsServico,
				TP.Produtos
			FROM 
				App_Servico AS PR
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = PR.idSis_Empresa
					LEFT JOIN Tab_Valor AS TV ON TV.idTab_Valor = PR.idTab_Servico
					LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TV.idTab_Modelo
			WHERE 
				' . $permissao . '
				' . $permissao5 . '
				OT.idSis_Empresa = ' . $data . ' AND
				OT.idTab_TipoRD = "2" AND				
				OT.AprovadoOrca = "S" AND				
				PR.idSis_Empresa = ' . $data . ' AND
				
				PR.idTab_TipoRD = "4" 
			ORDER BY
				C.NomeCliente,
				PR.DataValidadeServico  
		');
        $query = $query->result_array();

        return $query;
    }	

    public function get_alterarprodutorec($data) {

        if ($_SESSION['FiltroAlteraParcela']['DataFim']) {
            $consulta =
                '(PR.DataValidadeProduto >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '" AND PR.DataValidadeProduto <= "' . $_SESSION['FiltroAlteraParcela']['DataFim'] . '")';
        }
        else {
            $consulta =
                '(PR.DataValidadeProduto >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '")';
        }		
		#$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataValidadeProduto) = ' . $data['Mesvenc'] : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'PR.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		$permissao7 = ($_SESSION['FiltroAlteraParcela']['Produtos'] != "0" ) ? 'TP.idTab_Produto = "' . $_SESSION['FiltroAlteraParcela']['Produtos'] . '" AND ' : FALSE;		
		$permissao1 = ($_SESSION['FiltroAlteraParcela']['ConcluidoProduto'] != "0" ) ? 'PR.ConcluidoProduto = "' . $_SESSION['FiltroAlteraParcela']['ConcluidoProduto'] . '" AND ' : FALSE;
		$permissao6 = ($_SESSION['FiltroAlteraParcela']['DevolvidoProduto'] != "0" ) ? 'PR.DevolvidoProduto = "' . $_SESSION['FiltroAlteraParcela']['DevolvidoProduto'] . '" AND ' : FALSE;
		$permissao8 = ($_SESSION['FiltroAlteraParcela']['Dia'] != "0" ) ? 'DAY(PR.DataValidadeProduto) = "' . $_SESSION['FiltroAlteraParcela']['Dia'] . '" AND ' : FALSE;
		$permissao2 = ($_SESSION['FiltroAlteraParcela']['Mesvenc'] != "0" ) ? 'MONTH(PR.DataValidadeProduto) = "' . $_SESSION['FiltroAlteraParcela']['Mesvenc'] . '" AND ' : FALSE;
		$permissao3 = ($_SESSION['FiltroAlteraParcela']['Ano'] != "0" ) ? 'YEAR(PR.DataValidadeProduto) = "' . $_SESSION['FiltroAlteraParcela']['Ano'] . '" AND ' : FALSE;
		$permissao4 = ($_SESSION['FiltroAlteraParcela']['Orcarec'] != "0" ) ? 'OT.idApp_OrcaTrata = "' . $_SESSION['FiltroAlteraParcela']['Orcarec'] . '" AND ' : FALSE;
		$permissao5 = (($_SESSION['log']['idSis_Empresa'] != 5) && ($_SESSION['FiltroAlteraParcela']['NomeCliente'] != "0" )) ? 'OT.idApp_Cliente = "' . $_SESSION['FiltroAlteraParcela']['NomeCliente'] . '" AND ' : FALSE;
			/*
              echo "<pre>";
              print_r($_SESSION['FiltroAlteraParcela']['Produtos']);
			  echo "<br>";
			  print_r($_SESSION['FiltroAlteraParcela']['ConcluidoProduto']);
			  echo "<br>";
			  print_r($_SESSION['FiltroAlteraParcela']['DevolvidoProduto']);			  
              echo "</pre>";
              exit();
			*/
		$query = $this->db->query('
			SELECT
				C.NomeCliente,
				OT.idApp_OrcaTrata,
				OT.Descricao,
				OT.TipoFinanceiro,
				TR.TipoFinanceiro,
				E.NomeEmpresa,
				PR.idSis_Usuario,
				CONCAT(PR.idSis_Empresa, "-", E.NomeEmpresa) AS idSis_Empresa,
				CONCAT(OT.idApp_OrcaTrata,"-",C.NomeCliente) AS Produto,
				PR.idTab_Produto,
				PR.idApp_Produto,
				PR.DataValidadeProduto,
				PR.ValorProduto,
				PR.ConcluidoProduto,
				PR.DevolvidoProduto,
				PR.QtdProduto,
				PR.ObsProduto,
				TP.Produtos
			FROM 
				App_Produto AS PR
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = PR.idSis_Empresa
					LEFT JOIN Tab_Valor AS TV ON TV.idTab_Valor = PR.idTab_Produto
					LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TV.idTab_Modelo					
			WHERE 
				' . $permissao . '
				' . $permissao5 . '
				' . $permissao1 . '
				' . $permissao2 . '
				' . $permissao3 . '
				' . $permissao6 . '
				' . $permissao4 . '
				' . $permissao7 . '
				' . $permissao8 . '
				OT.idSis_Empresa = ' . $data . ' AND
				OT.idTab_TipoRD = "2" AND				
				OT.AprovadoOrca = "S" AND				
				PR.idSis_Empresa = ' . $data . ' AND
				' . $consulta . ' AND
				PR.idTab_TipoRD = "2" 
			ORDER BY
				PR.DataValidadeProduto  DESC,
				C.NomeCliente
				
		');
        $query = $query->result_array();

        return $query;
    }	
	
    public function get_alterarservicodesp($data) {
		
		#$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataValidadeServico) = ' . $data['Mesvenc'] : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'PR.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		$permissao1 = ($_SESSION['FiltroAlteraParcela']['ConcluidoServico'] != "0" ) ? 'PR.ConcluidoServico = "' . $_SESSION['FiltroAlteraParcela']['ConcluidoServico'] . '" AND ' : FALSE;
		$permissao2 = ($_SESSION['FiltroAlteraParcela']['Mesvenc'] != "0" ) ? 'MONTH(PR.DataValidadeServico) = "' . $_SESSION['FiltroAlteraParcela']['Mesvenc'] . '" AND ' : FALSE;
		$permissao3 = ($_SESSION['FiltroAlteraParcela']['Ano'] != "0" ) ? 'YEAR(PR.DataValidadeServico) = "' . $_SESSION['FiltroAlteraParcela']['Ano'] . '" AND ' : FALSE;
		$permissao4 = ($_SESSION['FiltroAlteraParcela']['Orcades'] != "0" ) ? 'OT.idApp_OrcaTrata = "' . $_SESSION['FiltroAlteraParcela']['Orcades'] . '" AND ' : FALSE;
		$permissao5 = (($_SESSION['log']['idSis_Empresa'] != 5) && ($_SESSION['FiltroAlteraParcela']['NomeFornecedor'] != "0" )) ? 'OT.idApp_Fornecedor = "' . $_SESSION['FiltroAlteraParcela']['NomeFornecedor'] . '" AND ' : FALSE;
		
		$query = $this->db->query('
			SELECT
				C.NomeFornecedor,
				OT.idApp_OrcaTrata,
				OT.Descricao,
				OT.TipoFinanceiro,
				TR.TipoFinanceiro,
				E.NomeEmpresa,
				PR.idSis_Usuario,
				CONCAT(PR.idSis_Empresa, "-", E.NomeEmpresa) AS idSis_Empresa,
				CONCAT(OT.idApp_OrcaTrata,"-",C.NomeFornecedor) AS Servico,
				PR.idTab_Servico,
				PR.idApp_Servico,
				PR.DataValidadeServico,
				PR.ValorServico,
				PR.ConcluidoServico,
				PR.QtdServico,
				PR.ObsServico,
				TP.Produtos
			FROM 
				App_Servico AS PR
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN App_Fornecedor AS C ON C.idApp_Fornecedor = OT.idApp_Fornecedor
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = PR.idSis_Empresa
					LEFT JOIN Tab_Valor AS TV ON TV.idTab_Valor = PR.idTab_Servico
					LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TV.idTab_Modelo
			WHERE 
				' . $permissao . '
				' . $permissao5 . '
				' . $permissao1 . '				
				OT.idSis_Empresa = ' . $data . ' AND
				OT.idTab_TipoRD = "1" AND				
				OT.AprovadoOrca = "S" AND				
				PR.idSis_Empresa = ' . $data . ' AND
				
				PR.idTab_TipoRD = "3" 
			ORDER BY
				C.NomeFornecedor,
				PR.DataValidadeServico  
		');
        $query = $query->result_array();

        return $query;
    }	

    public function get_alterarprodutodesp($data) {

        if ($_SESSION['FiltroAlteraParcela']['DataFim']) {
            $consulta =
                '(PR.DataValidadeProduto >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '" AND PR.DataValidadeProduto <= "' . $_SESSION['FiltroAlteraParcela']['DataFim'] . '")';
        }
        else {
            $consulta =
                '(PR.DataValidadeProduto >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '")';
        }		
		#$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataValidadeProduto) = ' . $data['Mesvenc'] : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'PR.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		$permissao7 = ($_SESSION['FiltroAlteraParcela']['Produtos'] != "0" ) ? 'TP.idTab_Produto = "' . $_SESSION['FiltroAlteraParcela']['Produtos'] . '" AND ' : FALSE;
		$permissao1 = ($_SESSION['FiltroAlteraParcela']['ConcluidoProduto'] != "0" ) ? 'PR.ConcluidoProduto = "' . $_SESSION['FiltroAlteraParcela']['ConcluidoProduto'] . '" AND ' : FALSE;
		$permissao6 = ($_SESSION['FiltroAlteraParcela']['DevolvidoProduto'] != "0" ) ? 'PR.DevolvidoProduto = "' . $_SESSION['FiltroAlteraParcela']['DevolvidoProduto'] . '" AND ' : FALSE;		
		$permissao2 = ($_SESSION['FiltroAlteraParcela']['Mesvenc'] != "0" ) ? 'MONTH(PR.DataValidadeProduto) = "' . $_SESSION['FiltroAlteraParcela']['Mesvenc'] . '" AND ' : FALSE;
		$permissao3 = ($_SESSION['FiltroAlteraParcela']['Ano'] != "0" ) ? 'YEAR(PR.DataValidadeProduto) = "' . $_SESSION['FiltroAlteraParcela']['Ano'] . '" AND ' : FALSE;
		$permissao4 = ($_SESSION['FiltroAlteraParcela']['Orcades'] != "0" ) ? 'OT.idApp_OrcaTrata = "' . $_SESSION['FiltroAlteraParcela']['Orcades'] . '" AND ' : FALSE;
		$permissao5 = (($_SESSION['log']['idSis_Empresa'] != 5) && ($_SESSION['FiltroAlteraParcela']['NomeFornecedor'] != "0" )) ? 'OT.idApp_Fornecedor = "' . $_SESSION['FiltroAlteraParcela']['NomeFornecedor'] . '" AND ' : FALSE;
		
		$query = $this->db->query('
			SELECT
				C.NomeFornecedor,
				OT.idApp_OrcaTrata,
				OT.Descricao,
				OT.TipoFinanceiro,
				TR.TipoFinanceiro,
				E.NomeEmpresa,
				PR.idSis_Usuario,
				CONCAT(PR.idSis_Empresa, "-", E.NomeEmpresa) AS idSis_Empresa,
				CONCAT(OT.idApp_OrcaTrata,"-",C.NomeFornecedor) AS Produto,
				PR.idTab_Produto,
				PR.idApp_Produto,
				PR.DataValidadeProduto,
				PR.ValorProduto,
				PR.ConcluidoProduto,
				PR.DevolvidoProduto,
				PR.QtdProduto,
				PR.ObsProduto,
				TP.Produtos
			FROM 
				App_Produto AS PR
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN App_Fornecedor AS C ON C.idApp_Fornecedor = OT.idApp_Fornecedor
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = PR.idSis_Empresa
					LEFT JOIN Tab_Valor AS TV ON TV.idTab_Valor = PR.idTab_Produto
					LEFT JOIN Tab_Produto AS TP ON TP.idTab_Produto = TV.idTab_Modelo					
			WHERE 
				' . $permissao . '
				' . $permissao5 . '
				' . $permissao1 . '
				' . $permissao6 . '
				' . $permissao4 . '
				' . $permissao7 . '				
				OT.idSis_Empresa = ' . $data . ' AND
				OT.idTab_TipoRD = "1" AND				
				OT.AprovadoOrca = "S" AND				
				PR.idSis_Empresa = ' . $data . ' AND
				' . $consulta . ' AND
				PR.idTab_TipoRD = "1" 
			ORDER BY
				PR.DataValidadeProduto DESC,
				C.NomeFornecedor
				
		');
        $query = $query->result_array();

        return $query;
    }	
	
    public function get_procedimento($data) {
		$query = $this->db->query('SELECT * FROM App_Procedimento WHERE idApp_OrcaTrata = ' . $data);
        $query = $query->result_array();

        return $query;
    }

    public function get_alterarprocedimento($data) {
		
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		#$permissao1 = ($_SESSION['FiltroAlteraProcedimento']['ConcluidoProcedimento'] != '0' ) ? 'P.ConcluidoProcedimento = "' . $_SESSION['FiltroAlteraProcedimento']['ConcluidoProcedimento'] . '" AND ' : FALSE;
		$permissao6 = ($_SESSION['FiltroAlteraProcedimento']['Prioridade'] != '0' ) ? 'P.Prioridade = "' . $_SESSION['FiltroAlteraProcedimento']['Prioridade'] . '" AND ' : FALSE;
		$permissao7 = ($_SESSION['FiltroAlteraProcedimento']['Procedimento'] != '0' ) ? 'P.idApp_Procedimento = "' . $_SESSION['FiltroAlteraProcedimento']['Procedimento'] . '" AND ' : FALSE;
		$permissao2 = ($_SESSION['FiltroAlteraProcedimento']['Mesvenc'] != "0" ) ? 'MONTH(P.DataProcedimento) = "' . $_SESSION['FiltroAlteraProcedimento']['Mesvenc'] . '" AND ' : FALSE;
		$permissao3 = ($_SESSION['FiltroAlteraProcedimento']['Ano'] != "" ) ? 'YEAR(P.DataProcedimento) = "' . $_SESSION['FiltroAlteraProcedimento']['Ano'] . '" AND ' : FALSE;
		$permissao5 = ($_SESSION['FiltroAlteraProcedimento']['Dia'] != "0" ) ? 'DAY(P.DataProcedimento) = "' . $_SESSION['FiltroAlteraProcedimento']['Dia'] . '" AND ' : FALSE;
		$permissao8 = ($_SESSION['FiltroAlteraProcedimento']['Categoria'] != '0' ) ? 'P.Categoria = "' . $_SESSION['FiltroAlteraProcedimento']['Categoria'] . '" AND ' : FALSE;
		$permissao9 = ($_SESSION['FiltroAlteraProcedimento']['Statustarefa'] != '0' ) ? 'P.Statustarefa = "' . $_SESSION['FiltroAlteraProcedimento']['Statustarefa'] . '" AND ' : FALSE;
		
		$query = $this->db->query('
			SELECT
				
				U.CpfUsuario,
				U.CelularUsuario,
				P.idSis_Usuario,
				P.idSis_Empresa,
				P.idApp_Procedimento,
                P.Procedimento,
				P.DataProcedimento,
				P.DataProcedimentoLimite,
				P.ConcluidoProcedimento,
				P.Categoria,
				P.Prioridade,
				P.Statustarefa
            FROM
				App_Procedimento AS P
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = P.idSis_Usuario
					LEFT JOIN Sis_Usuario AS AU ON AU.idSis_Usuario = P.Compartilhar
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = P.idSis_Empresa
					LEFT JOIN Tab_StatusSN AS SN ON SN.Abrev = P.ConcluidoProcedimento
					LEFT JOIN Tab_Categoria AS CT ON CT.idTab_Categoria = P.Categoria
			WHERE 
				' . $permissao6 . '
				' . $permissao7 . '
				' . $permissao8 . '
				' . $permissao9 . '
				(U.CelularUsuario = ' . $_SESSION['log']['CelularUsuario'] . ' OR
				AU.CelularUsuario = ' . $_SESSION['log']['CelularUsuario'] . ' OR	
				P.Compartilhar = ' . $_SESSION['log']['idSis_Usuario'] . ' OR
				(P.Compartilhar = 51 AND P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '))
			ORDER BY
				P.DataProcedimento DESC,
				P.Prioridade ASC,
				CT.Categoria DESC
		');
        $query = $query->result_array();

        return $query;
    }

    public function get_alterarprocedimentocli($data) {
		
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		$permissao1 = ($_SESSION['FiltroAlteraProcedimento']['Concluidocli'] != '0' ) ? 'P.ConcluidoProcedimento = "' . $_SESSION['FiltroAlteraProcedimento']['Concluidocli'] . '" AND ' : FALSE;
		$permissao2 = ($_SESSION['FiltroAlteraProcedimento']['Mesvenccli'] != "0" ) ? 'MONTH(P.DataProcedimentoLimite) = "' . $_SESSION['FiltroAlteraProcedimento']['Mesvenccli'] . '" AND ' : FALSE;
		$permissao3 = ($_SESSION['FiltroAlteraProcedimento']['Anocli'] != "" ) ? 'YEAR(P.DataProcedimentoLimite) = "' . $_SESSION['FiltroAlteraProcedimento']['Anocli'] . '" AND ' : FALSE;
		$permissao4 = ($_SESSION['FiltroAlteraProcedimento']['NomeCliente'] != "0" ) ? 'C.idApp_Cliente = "' . $_SESSION['FiltroAlteraProcedimento']['NomeCliente'] . '" AND ' : FALSE;
		$permissao5 = ($_SESSION['FiltroAlteraProcedimento']['Diacli'] != "0" ) ? 'DAY(P.DataProcedimentoLimite) = "' . $_SESSION['FiltroAlteraProcedimento']['Diacli'] . '" AND ' : FALSE;
		
		$query = $this->db->query('
			SELECT
				C.idApp_Cliente,
				C.NomeCliente,
				U.CpfUsuario,
				P.idSis_Usuario,
				P.idSis_Empresa,
				P.idApp_Procedimento,
                P.Procedimento,
				P.DataProcedimento,
				P.DataProcedimentoLimite,				
				P.ConcluidoProcedimento
            FROM
				App_Procedimento AS P
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = P.idSis_Usuario
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = P.idApp_Cliente
			WHERE 

				P.idSis_Empresa = ' . $data . '  AND

				' . $permissao1 . '
				' . $permissao2 . '
				' . $permissao3 . '
				' . $permissao4 . '
				' . $permissao5 . '
				P.idApp_Cliente != "0" 
		');
        $query = $query->result_array();

        return $query;
    }

    public function get_alterarmensagemenv($data) {
		
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'P.idSis_UsuarioCli = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		$permissao1 = ($_SESSION['FiltroAlteraProcedimento']['Concluidoemp'] != '0' ) ? 'P.ConcluidoProcedimento = "' . $_SESSION['FiltroAlteraProcedimento']['Concluidoemp'] . '" AND ' : FALSE;
		$permissao2 = ($_SESSION['FiltroAlteraProcedimento']['Mesvencemp'] != "0" ) ? 'MONTH(P.DataProcedimentoCli) = "' . $_SESSION['FiltroAlteraProcedimento']['Mesvencemp'] . '" AND ' : FALSE;
		$permissao3 = ($_SESSION['FiltroAlteraProcedimento']['Anoemp'] != "" ) ? 'YEAR(P.DataProcedimentoCli) = "' . $_SESSION['FiltroAlteraProcedimento']['Anoemp'] . '" AND ' : FALSE;
		$permissao5 = ($_SESSION['FiltroAlteraProcedimento']['Diaemp'] != "0" ) ? 'DAY(P.DataProcedimentoCli) = "' . $_SESSION['FiltroAlteraProcedimento']['Diaemp'] . '" AND ' : FALSE;
		$permissao6 = ($_SESSION['FiltroAlteraProcedimento']['NomeEmpresa'] != "0" ) ? 'P.idSis_Empresa = "' . $_SESSION['FiltroAlteraProcedimento']['NomeEmpresa'] . '" AND ' : FALSE;
		$permissao7 = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['FiltroAlteraProcedimento']['NomeEmpresaCli'] != "0" ) ? 'P.idSis_EmpresaCli = "' . $_SESSION['FiltroAlteraProcedimento']['NomeEmpresaCli'] . '" AND ' : FALSE;
		
		$query = $this->db->query('
			SELECT
				
				P.idApp_Procedimento,
				
				UR.Nome AS Nome,
				P.idSis_Usuario,
				ER.NomeEmpresa AS NomeEmpresa,
				P.idSis_Empresa,
                P.Procedimento,
				P.DataProcedimento,
				P.ConcluidoProcedimento,
				
				UE.Nome AS NomeCli,
				P.idSis_UsuarioCli,
				EE.NomeEmpresa AS NomeEmpresaCli,
				P.idSis_EmpresaCli,
                P.ProcedimentoCli,
				P.DataProcedimentoCli,
				P.ConcluidoProcedimentoCli
            FROM
				App_Procedimento AS P
					LEFT JOIN Sis_Usuario AS UE ON UE.idSis_Usuario = P.idSis_UsuarioCli
					LEFT JOIN Sis_Usuario AS UR ON UR.idSis_Usuario = P.idSis_Usuario
					LEFT JOIN Sis_Empresa AS EE ON EE.idSis_Empresa = P.idSis_EmpresaCli
					LEFT JOIN Sis_Empresa AS ER ON ER.idSis_Empresa = P.idSis_Empresa
			WHERE 

				P.idSis_EmpresaCli = ' . $data . '  AND
				P.idApp_OrcaTrata = "0" AND
				' . $permissao . '
				' . $permissao1 . '
				' . $permissao2 . '
				' . $permissao3 . '
				' . $permissao5 . '
				' . $permissao6 . '

				P.idApp_Cliente = "0" 
		');
		/*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */
        $query = $query->result_array();

        return $query;
    }

    public function get_alterarmensagemrec($data) {
		
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'P.idSis_UsuarioCli = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		$permissao1 = ($_SESSION['FiltroAlteraProcedimento']['Concluidoemp'] != '0' ) ? 'P.ConcluidoProcedimento = "' . $_SESSION['FiltroAlteraProcedimento']['Concluidoemp'] . '" AND ' : FALSE;
		$permissao2 = ($_SESSION['FiltroAlteraProcedimento']['Mesvencemp'] != "0" ) ? 'MONTH(P.DataProcedimentoCli) = "' . $_SESSION['FiltroAlteraProcedimento']['Mesvencemp'] . '" AND ' : FALSE;
		$permissao3 = ($_SESSION['FiltroAlteraProcedimento']['Anoemp'] != "" ) ? 'YEAR(P.DataProcedimentoCli) = "' . $_SESSION['FiltroAlteraProcedimento']['Anoemp'] . '" AND ' : FALSE;
		$permissao5 = ($_SESSION['FiltroAlteraProcedimento']['Diaemp'] != "0" ) ? 'DAY(P.DataProcedimentoCli) = "' . $_SESSION['FiltroAlteraProcedimento']['Diaemp'] . '" AND ' : FALSE;
		$permissao6 = ($_SESSION['FiltroAlteraProcedimento']['NomeEmpresa'] != "0" ) ? 'P.idSis_Empresa = "' . $_SESSION['FiltroAlteraProcedimento']['NomeEmpresa'] . '" AND ' : FALSE;
		$permissao7 = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['FiltroAlteraProcedimento']['NomeEmpresaCli'] != "0" ) ? 'P.idSis_EmpresaCli = "' . $_SESSION['FiltroAlteraProcedimento']['NomeEmpresaCli'] . '" AND ' : FALSE;
		
		$query = $this->db->query('
			SELECT
				
				P.idApp_Procedimento,
				
				UR.Nome AS Nome,
				P.idSis_Usuario,
				ER.NomeEmpresa AS NomeEmpresa,
				P.idSis_Empresa,
                P.Procedimento,
				P.DataProcedimento,
				P.ConcluidoProcedimento,
				
				UE.Nome AS NomeCli,
				P.idSis_UsuarioCli,
				EE.NomeEmpresa AS NomeEmpresaCli,
				P.idSis_EmpresaCli,
                P.ProcedimentoCli,
				P.DataProcedimentoCli,
				P.ConcluidoProcedimentoCli
            FROM
				App_Procedimento AS P
					LEFT JOIN Sis_Usuario AS UE ON UE.idSis_Usuario = P.idSis_UsuarioCli
					LEFT JOIN Sis_Usuario AS UR ON UR.idSis_Usuario = P.idSis_Usuario
					LEFT JOIN Sis_Empresa AS EE ON EE.idSis_Empresa = P.idSis_EmpresaCli
					LEFT JOIN Sis_Empresa AS ER ON ER.idSis_Empresa = P.idSis_Empresa
			WHERE 

				P.idSis_Empresa =  ' . $data . '  AND
				P.idSis_EmpresaCli != "0" AND
				P.idApp_OrcaTrata = "0" AND
				' . $permissao . '
				' . $permissao1 . '
				' . $permissao2 . '
				' . $permissao3 . '
				' . $permissao5 . '

				' . $permissao7 . '
				P.idApp_Cliente = "0" 
		');
		/*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */
        $query = $query->result_array();

        return $query;
    }
	
    public function list_orcamento($id, $aprovado, $completo) {

        $query = $this->db->query('SELECT '
            . 'OT.idApp_OrcaTrata, '
			. 'OT.idSis_Empresa, '
            . 'OT.DataOrca, '
			. 'OT.DataPrazo, '
			. 'OT.DataConclusao, '
			. 'OT.DataQuitado, '
            . 'OT.ProfissionalOrca, '
            . 'OT.AprovadoOrca, '
			. 'OT.ConcluidoOrca, '
			. 'OT.QuitadoOrca, '
            . 'OT.ObsOrca '
            . 'FROM '
            . 'App_OrcaTrata AS OT '
            . 'WHERE '
			. 'OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND '
			. 'OT.idApp_Cliente = ' . $id . ' AND '
			. 'OT.idTab_TipoRD = "2" AND '
            . 'OT.AprovadoOrca = "' . $aprovado . '" '
            . 'ORDER BY '
			#. 'OT.DataOrca DESC, '
			. 'OT.ConcluidoOrca ASC, '
			. 'OT.QuitadoOrca ASC, '
			. 'OT.DataOrca DESC ');
        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */
        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
            if ($completo === FALSE) {
                return TRUE;
            } else {

                foreach ($query->result() as $row) {
					$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
					$row->DataPrazo = $this->basico->mascara_data($row->DataPrazo, 'barras');
					$row->DataConclusao = $this->basico->mascara_data($row->DataConclusao, 'barras');
					$row->DataQuitado = $this->basico->mascara_data($row->DataQuitado, 'barras');
                    $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
					$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
					$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
                    #$row->ProfissionalOrca = $this->get_profissional($row->ProfissionalOrca);
                }
                return $query;
            }
        }
    }

    public function list_orcatrataBKP($x) {

        $query = $this->db->query('SELECT '
            . 'OT.idApp_OrcaTrata, '
            . 'OT.DataOrca, '
			. 'OT.DataPrazo, '
            . 'OT.ProfissionalOrca, '
            . 'OT.AprovadoOrca, '
            . 'OT.ObsOrca '
            . 'FROM '
            . 'App_OrcaTrata AS OT '
            . 'WHERE '
            . 'OT.idApp_Cliente = ' . $_SESSION['OrcaTrataCons']['idApp_Cliente'] . ' '
            . 'ORDER BY OT.DataOrca DESC ');
        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */
        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
            if ($x === FALSE) {
                return TRUE;
            } else {

                foreach ($query->result() as $row) {
					$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
					$row->DataPrazo = $this->basico->mascara_data($row->DataPrazo, 'barras');                   
					$row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
                    #$row->ProfissionalOrca = $this->get_profissional($row->ProfissionalOrca);
                }

                return $query;
            }
        }
    }

    public function list1_produtosvend($x) {
		
        $query = $this->db->query('
			SELECT 
                C.NomeCliente,
				C.CelularCliente,
				OT.Descricao,
				OT.idApp_OrcaTrata,
				OT.AprovadoOrca,
				DATE_FORMAT(OT.DataOrca, "%d/%m/%Y") AS DataOrca,
				DATE_FORMAT(OT.DataEntregaOrca, "%d/%m/%Y") AS DataEntregaOrca,
				DATE_FORMAT(OT.HoraEntregaOrca, "%H:%i") AS HoraEntregaOrca,
				OT.DataEntradaOrca,
				OT.DataPrazo,
                OT.ValorOrca,
				OT.ValorDev,				
				OT.ValorEntradaOrca,
				OT.ValorRestanteOrca,
				OT.DataVencimentoOrca,
                OT.ConcluidoOrca,
                OT.QuitadoOrca,
				OT.CanceladoOrca,
				OT.FinalizadoOrca,
				OT.EnviadoOrca,
				OT.ProntoOrca,
                OT.DataConclusao,
                OT.DataQuitado,
				OT.DataRetorno,
				OT.idTab_TipoRD,
				OT.FormaPagamento,
				OT.ObsOrca,
				OT.QtdParcelasOrca,
				OT.Tipo_Orca,
				TF.TipoFrete,
				MD.Modalidade,
				VP.Abrev2,
				VP.AVAP,
				TFP.FormaPag,
				TR.TipoFinanceiro
			FROM 
                App_OrcaTrata AS OT
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
					LEFT JOIN Tab_AVAP AS VP ON VP.Abrev2 = OT.AVAP
					LEFT JOIN Tab_TipoFrete AS TF ON TF.idTab_TipoFrete = OT.TipoFrete
			WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OT.idTab_TipoRD = "2" AND
				OT.CanceladoOrca = "N" AND
				OT.AprovadoOrca = "S" AND
				OT.ConcluidoOrca = "N" AND
				OT.ProntoOrca = "N" AND
				OT.EnviadoOrca = "N"
				
			ORDER BY 
				OT.DataEntregaOrca ASC,
				OT.HoraEntregaOrca ASC,
				OT.idApp_OrcaTrata
		');

        /*
          echo $this->db->last_query();
          $query = $query->result_array();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */
        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
            if ($x === FALSE) {
                return TRUE;
            } else {
                #foreach ($query->result_array() as $row) {
                #    $row->idApp_Profissional = $row->idApp_Profissional;
                #    $row->NomeProfissional = $row->NomeProfissional;
                #}
                $query = $query->result_array();
                return $query;
            }
        }
    }
		
    public function list3_produtosaluguel($x) {

        $query = $this->db->query('
			SELECT 
                C.NomeCliente,
				C.CelularCliente,
				OT.Descricao,
				OT.idApp_OrcaTrata,
				OT.AprovadoOrca,
				DATE_FORMAT(OT.DataOrca, "%d/%m/%Y") AS DataOrca,
				DATE_FORMAT(OT.DataEntregaOrca, "%d/%m/%Y") AS DataEntregaOrca,
				DATE_FORMAT(OT.HoraEntregaOrca, "%H:%i") AS HoraEntregaOrca,
				OT.DataEntradaOrca,
				OT.DataPrazo,
                OT.ValorOrca,
				OT.ValorDev,				
				OT.ValorEntradaOrca,
				OT.ValorRestanteOrca,
				OT.DataVencimentoOrca,
                OT.ConcluidoOrca,
                OT.QuitadoOrca,
				OT.CanceladoOrca,
				OT.FinalizadoOrca,
				OT.EnviadoOrca,
				OT.ProntoOrca,
                OT.DataConclusao,
                OT.DataQuitado,
				OT.DataRetorno,
				OT.idTab_TipoRD,
				OT.FormaPagamento,
				OT.ObsOrca,
				OT.QtdParcelasOrca,
				OT.Tipo_Orca,
				TF.TipoFrete,
				MD.Modalidade,
				VP.Abrev2,
				VP.AVAP,
				TFP.FormaPag,
				TR.TipoFinanceiro
			FROM 
                App_OrcaTrata AS OT
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
					LEFT JOIN Tab_AVAP AS VP ON VP.Abrev2 = OT.AVAP
					LEFT JOIN Tab_TipoFrete AS TF ON TF.idTab_TipoFrete = OT.TipoFrete
			WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OT.idTab_TipoRD = "2" AND
				OT.CanceladoOrca = "N" AND
				OT.AprovadoOrca = "S" AND
				OT.ConcluidoOrca = "N" AND
				OT.ProntoOrca = "S" AND
				OT.EnviadoOrca = "N"
			ORDER BY 
				OT.DataEntregaOrca ASC,
				OT.HoraEntregaOrca ASC,
				OT.idApp_OrcaTrata
				
		');

        /*
          echo $this->db->last_query();
          $query = $query->result_array();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */
        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
            if ($x === FALSE) {
                return TRUE;
            } else {
                #foreach ($query->result_array() as $row) {
                #    $row->idApp_Profissional = $row->idApp_Profissional;
                #    $row->NomeProfissional = $row->NomeProfissional;
                #}
                $query = $query->result_array();
                return $query;
            }
        }
    }

    public function list5_produtosvend($x) {
		
        $query = $this->db->query('
			SELECT 
                C.NomeCliente,
				C.CelularCliente,
				OT.Descricao,
				OT.idApp_OrcaTrata,
				OT.AprovadoOrca,
				DATE_FORMAT(OT.DataOrca, "%d/%m/%Y") AS DataOrca,
				DATE_FORMAT(OT.DataEntregaOrca, "%d/%m/%Y") AS DataEntregaOrca,
				DATE_FORMAT(OT.HoraEntregaOrca, "%H:%i") AS HoraEntregaOrca,
				OT.DataEntradaOrca,
				OT.DataPrazo,
                OT.ValorOrca,
				OT.ValorDev,				
				OT.ValorEntradaOrca,
				OT.ValorRestanteOrca,
				OT.DataVencimentoOrca,
                OT.ConcluidoOrca,
                OT.QuitadoOrca,
				OT.CanceladoOrca,
				OT.FinalizadoOrca,
				OT.EnviadoOrca,
				OT.ProntoOrca,
                OT.DataConclusao,
                OT.DataQuitado,
				OT.DataRetorno,
				OT.idTab_TipoRD,
				OT.FormaPagamento,
				OT.ObsOrca,
				OT.QtdParcelasOrca,
				OT.Tipo_Orca,
				TF.TipoFrete,
				MD.Modalidade,
				VP.Abrev2,
				VP.AVAP,
				TFP.FormaPag,
				TR.TipoFinanceiro
			FROM 
                App_OrcaTrata AS OT
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
					LEFT JOIN Tab_AVAP AS VP ON VP.Abrev2 = OT.AVAP
					LEFT JOIN Tab_TipoFrete AS TF ON TF.idTab_TipoFrete = OT.TipoFrete
			WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OT.idTab_TipoRD = "2" AND
				OT.CanceladoOrca = "N" AND
				OT.AprovadoOrca = "S" AND
				OT.ProntoOrca = "S" AND
				OT.EnviadoOrca = "S" AND
				OT.ConcluidoOrca = "N"
			ORDER BY 
				OT.DataEntregaOrca ASC,
				OT.HoraEntregaOrca ASC,
				OT.idApp_OrcaTrata 
		');

        /*
          echo $this->db->last_query();
          $query = $query->result_array();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */
        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
            if ($x === FALSE) {
                return TRUE;
            } else {
                #foreach ($query->result_array() as $row) {
                #    $row->idApp_Profissional = $row->idApp_Profissional;
                #    $row->NomeProfissional = $row->NomeProfissional;
                #}
                $query = $query->result_array();
                return $query;
            }
        }
    }
	
    public function list6_produtosaluguel($x) {

        $query = $this->db->query('
			SELECT 
                C.NomeCliente,
				C.CelularCliente,
				OT.Descricao,
				OT.idApp_OrcaTrata,
				OT.AprovadoOrca,
				DATE_FORMAT(OT.DataOrca, "%d/%m/%Y") AS DataOrca,
				DATE_FORMAT(OT.DataEntregaOrca, "%d/%m/%Y") AS DataEntregaOrca,
				DATE_FORMAT(OT.HoraEntregaOrca, "%H:%i") AS HoraEntregaOrca,
				OT.DataEntradaOrca,
				OT.DataPrazo,
                OT.ValorOrca,
				OT.ValorDev,				
				OT.ValorEntradaOrca,
				OT.ValorRestanteOrca,
				OT.DataVencimentoOrca,
                OT.ConcluidoOrca,
                OT.QuitadoOrca,
				OT.CanceladoOrca,
				OT.FinalizadoOrca,
				OT.EnviadoOrca,
				OT.ProntoOrca,
                OT.DataConclusao,
                OT.DataQuitado,
				OT.DataRetorno,
				OT.idTab_TipoRD,
				OT.FormaPagamento,
				OT.ObsOrca,
				OT.QtdParcelasOrca,
				OT.Tipo_Orca,
				TF.TipoFrete,
				MD.Modalidade,
				VP.Abrev2,
				VP.AVAP,
				TFP.FormaPag,
				TR.TipoFinanceiro
			FROM 
                App_OrcaTrata AS OT
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
					LEFT JOIN Tab_AVAP AS VP ON VP.Abrev2 = OT.AVAP
					LEFT JOIN Tab_TipoFrete AS TF ON TF.idTab_TipoFrete = OT.TipoFrete
			WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OT.idTab_TipoRD = "2" AND
				OT.CanceladoOrca = "N" AND
				OT.AprovadoOrca = "S" AND
				OT.QuitadoOrca = "N" 
			ORDER BY 
				OT.DataEntregaOrca ASC,
				OT.HoraEntregaOrca ASC,
				OT.idApp_OrcaTrata
		');

        /*
          echo $this->db->last_query();
          $query = $query->result_array();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */
        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
            if ($x === FALSE) {
                return TRUE;
            } else {
                #foreach ($query->result_array() as $row) {
                #    $row->idApp_Profissional = $row->idApp_Profissional;
                #    $row->NomeProfissional = $row->NomeProfissional;
                #}
                $query = $query->result_array();
                return $query;
            }
        }
    }
	
    public function list7_combinar($x) {

        $query = $this->db->query('
			SELECT 
                C.NomeCliente,
				C.CelularCliente,
				OT.Descricao,
				OT.idApp_OrcaTrata,
				OT.AprovadoOrca,
				DATE_FORMAT(OT.DataOrca, "%d/%m/%Y") AS DataOrca,
				DATE_FORMAT(OT.DataEntregaOrca, "%d/%m/%Y") AS DataEntregaOrca,
				DATE_FORMAT(OT.HoraEntregaOrca, "%H:%i") AS HoraEntregaOrca,
				OT.DataEntradaOrca,
				OT.DataPrazo,
                OT.ValorOrca,
				OT.ValorDev,				
				OT.ValorEntradaOrca,
				OT.ValorRestanteOrca,
				OT.DataVencimentoOrca,
                OT.ConcluidoOrca,
                OT.QuitadoOrca,
				OT.FinalizadoOrca,
				OT.CanceladoOrca,
				OT.EnviadoOrca,
				OT.ProntoOrca,
                OT.DataConclusao,
                OT.DataQuitado,
				OT.DataRetorno,
				OT.idTab_TipoRD,
				OT.FormaPagamento,
				OT.ObsOrca,
				OT.QtdParcelasOrca,
				OT.Tipo_Orca,
				OT.CombinadoFrete,
				TF.TipoFrete,
				MD.Modalidade,
				VP.Abrev2,
				VP.AVAP,
				TFP.FormaPag,
				TR.TipoFinanceiro
			FROM 
                App_OrcaTrata AS OT
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
					LEFT JOIN Tab_AVAP AS VP ON VP.Abrev2 = OT.AVAP
					LEFT JOIN Tab_TipoFrete AS TF ON TF.idTab_TipoFrete = OT.TipoFrete
			WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OT.idTab_TipoRD = "2" AND
				OT.CanceladoOrca = "N" AND
				(OT.CombinadoFrete = "N" OR
				(OT.AprovadoOrca = "N" AND OT.AVAP != "O"))
				
			ORDER BY 
				OT.DataEntregaOrca ASC,
				OT.HoraEntregaOrca ASC,
				OT.idApp_OrcaTrata
		');

        /*
          echo $this->db->last_query();
          $query = $query->result_array();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */
        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
            if ($x === FALSE) {
                return TRUE;
            } else {
                #foreach ($query->result_array() as $row) {
                #    $row->idApp_Profissional = $row->idApp_Profissional;
                #    $row->NomeProfissional = $row->NomeProfissional;
                #}
                $query = $query->result_array();
                return $query;
            }
        }
    }

    public function list8_pagamentoonline($x) {

        $query = $this->db->query('
			SELECT 
                C.NomeCliente,
				C.CelularCliente,
				OT.Descricao,
				OT.idApp_OrcaTrata,
				OT.AprovadoOrca,
				DATE_FORMAT(OT.DataOrca, "%d/%m/%Y") AS DataOrca,
				DATE_FORMAT(OT.DataEntregaOrca, "%d/%m/%Y") AS DataEntregaOrca,
				DATE_FORMAT(OT.HoraEntregaOrca, "%H:%i") AS HoraEntregaOrca,
				OT.DataEntradaOrca,
				OT.DataPrazo,
                OT.ValorOrca,
				OT.ValorDev,				
				OT.ValorEntradaOrca,
				OT.ValorRestanteOrca,
				OT.DataVencimentoOrca,
                OT.ConcluidoOrca,
                OT.QuitadoOrca,
				OT.CanceladoOrca,
				OT.FinalizadoOrca,
				OT.EnviadoOrca,
				OT.ProntoOrca,
                OT.DataConclusao,
                OT.DataQuitado,
				OT.DataRetorno,
				OT.idTab_TipoRD,
				OT.FormaPagamento,
				OT.ObsOrca,
				OT.QtdParcelasOrca,
				OT.Tipo_Orca,
				OT.CombinadoFrete,
				TF.TipoFrete,
				MD.Modalidade,
				VP.Abrev2,
				VP.AVAP,
				TFP.FormaPag,
				TR.TipoFinanceiro
			FROM 
                App_OrcaTrata AS OT
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
					LEFT JOIN Tab_AVAP AS VP ON VP.Abrev2 = OT.AVAP
					LEFT JOIN Tab_TipoFrete AS TF ON TF.idTab_TipoFrete = OT.TipoFrete
			WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OT.idTab_TipoRD = "2" AND
				OT.CanceladoOrca = "N" AND
				OT.CombinadoFrete = "S" AND
				OT.AVAP = "O" AND
				OT.QuitadoOrca = "N"
			ORDER BY 
				OT.DataEntregaOrca ASC,
				OT.HoraEntregaOrca ASC,
				OT.idApp_OrcaTrata
		');

        /*
          echo $this->db->last_query();
          $query = $query->result_array();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */
        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
            if ($x === FALSE) {
                return TRUE;
            } else {
                #foreach ($query->result_array() as $row) {
                #    $row->idApp_Profissional = $row->idApp_Profissional;
                #    $row->NomeProfissional = $row->NomeProfissional;
                #}
                $query = $query->result_array();
                return $query;
            }
        }
    }

	
    public function list11_produtosvend($x) {
		
        $query = $this->db->query('
			SELECT 
                C.NomeFornecedor,
				C.Telefone1,
				OT.Descricao,
				OT.idApp_OrcaTrata,
				OT.AprovadoOrca,
				DATE_FORMAT(OT.DataOrca, "%d/%m/%Y") AS DataOrca,
				DATE_FORMAT(OT.DataEntregaOrca, "%d/%m/%Y") AS DataEntregaOrca,
				DATE_FORMAT(OT.HoraEntregaOrca, "%H:%i") AS HoraEntregaOrca,
				OT.DataEntradaOrca,
				OT.DataPrazo,
                OT.ValorOrca,
				OT.ValorDev,				
				OT.ValorEntradaOrca,
				OT.ValorRestanteOrca,
				OT.DataVencimentoOrca,
                OT.ConcluidoOrca,
                OT.QuitadoOrca,
				OT.CanceladoOrca,
				OT.FinalizadoOrca,
				OT.EnviadoOrca,
				OT.ProntoOrca,
                OT.DataConclusao,
                OT.DataQuitado,
				OT.DataRetorno,
				OT.idTab_TipoRD,
				OT.FormaPagamento,
				OT.ObsOrca,
				OT.QtdParcelasOrca,
				OT.Tipo_Orca,
				TF.TipoFrete,
				MD.Modalidade,
				VP.Abrev2,
				VP.AVAP,
				TFP.FormaPag,
				TR.TipoFinanceiro
			FROM 
                App_OrcaTrata AS OT
					LEFT JOIN App_Fornecedor AS C ON C.idApp_Fornecedor = OT.idApp_Fornecedor
					LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
					LEFT JOIN Tab_AVAP AS VP ON VP.Abrev2 = OT.AVAP
					LEFT JOIN Tab_TipoFrete AS TF ON TF.idTab_TipoFrete = OT.TipoFrete
			WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OT.idTab_TipoRD = "1" AND
				OT.CanceladoOrca = "N" AND
				OT.AprovadoOrca = "S" AND
				OT.ConcluidoOrca = "N"
			ORDER BY 
				OT.DataEntregaOrca ASC,
				OT.HoraEntregaOrca ASC,
				OT.idApp_OrcaTrata 
		');

        /*
          echo $this->db->last_query();
          $query = $query->result_array();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */
        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
            if ($x === FALSE) {
                return TRUE;
            } else {
                #foreach ($query->result_array() as $row) {
                #    $row->idApp_Profissional = $row->idApp_Profissional;
                #    $row->NomeProfissional = $row->NomeProfissional;
                #}
                $query = $query->result_array();
                return $query;
            }
        }
    }
	
    public function list12_produtosaluguel($x) {

        $query = $this->db->query('
			SELECT 
                C.NomeFornecedor,
				C.Telefone1,
				OT.Descricao,
				OT.idApp_OrcaTrata,
				OT.AprovadoOrca,
				DATE_FORMAT(OT.DataOrca, "%d/%m/%Y") AS DataOrca,
				DATE_FORMAT(OT.DataEntregaOrca, "%d/%m/%Y") AS DataEntregaOrca,
				DATE_FORMAT(OT.HoraEntregaOrca, "%H:%i") AS HoraEntregaOrca,
				OT.DataEntradaOrca,
				OT.DataPrazo,
                OT.ValorOrca,
				OT.ValorDev,				
				OT.ValorEntradaOrca,
				OT.ValorRestanteOrca,
				OT.DataVencimentoOrca,
                OT.ConcluidoOrca,
                OT.QuitadoOrca,
				OT.CanceladoOrca,
				OT.FinalizadoOrca,
				OT.EnviadoOrca,
				OT.ProntoOrca,
                OT.DataConclusao,
                OT.DataQuitado,
				OT.DataRetorno,
				OT.idTab_TipoRD,
				OT.FormaPagamento,
				OT.ObsOrca,
				OT.QtdParcelasOrca,
				OT.Tipo_Orca,
				TF.TipoFrete,
				MD.Modalidade,
				VP.Abrev2,
				VP.AVAP,
				TFP.FormaPag,
				TR.TipoFinanceiro
			FROM 
                App_OrcaTrata AS OT
					LEFT JOIN App_Fornecedor AS C ON C.idApp_Fornecedor = OT.idApp_Fornecedor
					LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
					LEFT JOIN Tab_AVAP AS VP ON VP.Abrev2 = OT.AVAP
					LEFT JOIN Tab_TipoFrete AS TF ON TF.idTab_TipoFrete = OT.TipoFrete
			WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OT.idTab_TipoRD = "1" AND
				OT.CanceladoOrca = "N" AND
				OT.AprovadoOrca = "S" AND
				OT.QuitadoOrca = "N" 
			ORDER BY 
				OT.DataEntregaOrca ASC,
				OT.HoraEntregaOrca ASC,
				OT.idApp_OrcaTrata
		');

        /*
          echo $this->db->last_query();
          $query = $query->result_array();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */
        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
            if ($x === FALSE) {
                return TRUE;
            } else {
                #foreach ($query->result_array() as $row) {
                #    $row->idApp_Profissional = $row->idApp_Profissional;
                #    $row->NomeProfissional = $row->NomeProfissional;
                #}
                $query = $query->result_array();
                return $query;
            }
        }
    }
	
    public function list1_produtoscomp($x) {

        $query = $this->db->query('
			SELECT 
                C.NomeFornecedor,
				OT.Descricao,
				OT.idApp_OrcaTrata,
				OT.AprovadoOrca,
                OT.DataOrca,
				DATE_FORMAT(OT.DataEntregaOrca, "%d/%m/%Y") AS DataEntregaOrca,
				OT.HoraEntregaOrca,
				OT.DataEntradaOrca,
				OT.DataPrazo,
                OT.ValorOrca,
				OT.ValorDev,				
				OT.ValorEntradaOrca,
				OT.ValorRestanteOrca,
				OT.DataVencimentoOrca,
                OT.ConcluidoOrca,
                OT.QuitadoOrca,
                OT.DataConclusao,
                OT.DataQuitado,
				OT.DataRetorno,
				OT.idTab_TipoRD,
				OT.FormaPagamento,
				OT.ObsOrca,
				OT.QtdParcelasOrca,
				MD.Modalidade,
				VP.Abrev2,
				VP.AVAP,
				TFP.FormaPag,
				AP.idApp_Produto,
				AP.QtdProduto,
				DATE_FORMAT(AP.DataValidadeProduto, "%d/%m/%Y") AS DataValidadeProduto,
				AP.ConcluidoProduto,
				AP.ValorProduto,
				AP.ObsProduto,
				TS.idApp_Servico,
				TS.QtdServico,
				TS.DataValidadeServico,
				TS.ConcluidoServico,
				TS.ValorServico,
				TR.TipoFinanceiro
			FROM 
                App_OrcaTrata AS OT
					LEFT JOIN App_Fornecedor AS C ON C.idApp_Fornecedor = OT.idApp_Fornecedor
					LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
					LEFT JOIN Tab_AVAP AS VP ON VP.Abrev2 = OT.AVAP
					LEFT JOIN App_Produto AS AP ON AP.idApp_Orcatrata = OT.idApp_OrcaTrata
					LEFT JOIN App_Servico AS TS ON TS.idApp_Orcatrata = OT.idApp_OrcaTrata
			WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND 
                OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				OT.idTab_TipoRD = "1" AND
				OT.AprovadoOrca = "N"
			ORDER BY 
				OT.idApp_OrcaTrata ASC 
		');

        /*
          echo $this->db->last_query();
          $query = $query->result_array();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */
        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
            if ($x === FALSE) {
                return TRUE;
            } else {
                #foreach ($query->result_array() as $row) {
                #    $row->idApp_Profissional = $row->idApp_Profissional;
                #    $row->NomeProfissional = $row->NomeProfissional;
                #}
                $query = $query->result_array();
                return $query;
            }
        }
    }

	public function list2_rankingfiado($data) {

        #$data['NomeCliente'] = ($data['NomeCliente']) ? ' AND TC.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
        #$data['Campo'] = (!$data['Campo']) ? 'TC.NomeCliente' : $data['Campo'];
        #$data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
				
        ####################################################################
        #LISTA DE CLIENTES
        $query['NomeCliente'] = $this->db->query('
            SELECT
                TC.idApp_Cliente,
                CONCAT(IFNULL(TC.NomeCliente,"")) AS NomeCliente
				
            FROM
                App_Cliente AS TC
				LEFT JOIN App_OrcaTrata AS TOT ON TOT.idApp_Cliente = TC.idApp_Cliente
				LEFT JOIN App_Parcelas AS TPR ON TPR.idApp_OrcaTrata = TOT.idApp_OrcaTrata
            WHERE
                TC.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TC.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				TOT.AprovadoOrca = "S" AND
				TPR.Quitado = "N" AND
				TPR.DataVencimento <= "' . date("Y-m-t", mktime(0,0,0,date('m'),'01',date('Y'))) . '"  

            ORDER BY
                TC.NomeCliente ASC
        ');
        $query['NomeCliente'] = $query['NomeCliente']->result();

        ####################################################################
        #Parcelas 
/*
        if ($data['DataFim']) {
            $consulta =
                '(TPR.DataVencimento >= "' . $data['DataInicio'] . '" AND TPR.DataVencimento <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(TPR.DataVencimento >= "' . $data['DataInicio'] . '")';
        }
*/
        $query['Parcelas'] = $this->db->query(
            'SELECT
                SUM(TPR.ValorParcela) AS QtdParc,
                TC.idApp_Cliente
            FROM
                App_OrcaTrata AS TOT
                    LEFT JOIN App_Cliente AS TC ON TC.idApp_Cliente = TOT.idApp_Cliente
					LEFT JOIN App_Parcelas AS TPR ON TPR.idApp_OrcaTrata = TOT.idApp_OrcaTrata

            WHERE
                TPR.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TPR.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                TOT.AprovadoOrca = "S" AND
				TPR.Quitado = "N" AND
				TPR.idTab_TipoRD = "2" AND
                TC.idApp_Cliente != "0" AND
				TPR.DataVencimento <= "' . date("Y-m-t", mktime(0,0,0,date('m'),'01',date('Y'))) . '"
            GROUP BY
                TC.idApp_Cliente
            ORDER BY
                TC.NomeCliente ASC'
        );
        $query['Parcelas'] = $query['Parcelas']->result();
		
		$rankingvendas = new stdClass();


        foreach ($query['NomeCliente'] as $row) {

            $rankingvendas->{$row->idApp_Cliente} = new stdClass();
            $rankingvendas->{$row->idApp_Cliente}->NomeCliente = $row->NomeCliente;
        }


		/*
echo "<pre>";
print_r($query['Comprados']);
echo "</pre>";
exit();*/


	
		foreach ($query['Parcelas'] as $row) {
            if (isset($rankingvendas->{$row->idApp_Cliente}))
                $rankingvendas->{$row->idApp_Cliente}->QtdParc = $row->QtdParc;
        }

		$rankingvendas->soma = new stdClass();
		$somaqtdorcam = $somaqtddescon = $somaqtdvendida = $somaqtdparc = $somaqtddevol = 0;

		foreach ($rankingvendas as $row) {

			$row->QtdParc = (!isset($row->QtdParc)) ? 0 : $row->QtdParc;

			$somaqtdparc += $row->QtdParc;
			$row->QtdParc = number_format($row->QtdParc, 2, ',', '.');																
        }


		$rankingvendas->soma->somaqtdparc = number_format($somaqtdparc, 2, ',', '.');
		

        /*
        echo $this->db->last_query();
        echo "<pre>";
        print_r($estoque);
        echo "</pre>";
        #echo "<pre>";
        #print_r($query);
        #echo "</pre>";
        exit();
        #*/

        return $rankingvendas;

    }

	public function list2_rankingfaturado($data) {

        #$data['NomeCliente'] = ($data['NomeCliente']) ? ' AND TC.idApp_Cliente = ' . $data['NomeCliente'] : FALSE;
        #$data['Campo'] = (!$data['Campo']) ? 'TC.NomeCliente' : $data['Campo'];
        #$data['Ordenamento'] = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
        ####################################################################
        #LISTA DE CLIENTES
        $query['NomeFornecedor'] = $this->db->query('
            SELECT
                TC.idApp_Fornecedor,
                CONCAT(IFNULL(TC.NomeFornecedor,"")) AS NomeFornecedor
				
            FROM
                App_Fornecedor AS TC
				LEFT JOIN App_OrcaTrata AS TOT ON TOT.idApp_Fornecedor = TC.idApp_Fornecedor
				LEFT JOIN App_Parcelas AS TPR ON TPR.idApp_OrcaTrata = TOT.idApp_OrcaTrata
            WHERE
                TC.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TC.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				TOT.AprovadoOrca = "S" AND
				TPR.Quitado = "N" AND
				TPR.DataVencimento <= "' . date("Y-m-t", mktime(0,0,0,date('m'),'01',date('Y'))) . '"
            ORDER BY
                TC.NomeFornecedor ASC
        ');
        $query['NomeFornecedor'] = $query['NomeFornecedor']->result();

        ####################################################################
        #Parcelas 
/*
        if ($data['DataFim']) {
            $consulta =
                '(TPR.DataVencimento >= "' . $data['DataInicio'] . '" AND TPR.DataVencimento <= "' . $data['DataFim'] . '")';
        }
        else {
            $consulta =
                '(TPR.DataVencimento >= "' . $data['DataInicio'] . '")';
        }
*/
        $query['Parcelas'] = $this->db->query(
            'SELECT
                SUM(TPR.ValorParcela) AS QtdParc,
                TC.idApp_Fornecedor
            FROM
                App_OrcaTrata AS TOT
                    LEFT JOIN App_Fornecedor AS TC ON TC.idApp_Fornecedor = TOT.idApp_Fornecedor
					LEFT JOIN App_Parcelas AS TPR ON TPR.idApp_OrcaTrata = TOT.idApp_OrcaTrata

            WHERE
                TPR.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TPR.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                TOT.AprovadoOrca = "S" AND
				TPR.Quitado = "N" AND
				TPR.idTab_TipoRD = "1" AND
                TC.idApp_Fornecedor != "0" AND
				TPR.DataVencimento <= "' . date("Y-m-t", mktime(0,0,0,date('m'),'01',date('Y'))) . '"
            GROUP BY
                TC.idApp_Fornecedor
            ORDER BY
                TC.NomeFornecedor ASC'
        );
        $query['Parcelas'] = $query['Parcelas']->result();
		
		$rankingvendas = new stdClass();


        foreach ($query['NomeFornecedor'] as $row) {

            $rankingvendas->{$row->idApp_Fornecedor} = new stdClass();
            $rankingvendas->{$row->idApp_Fornecedor}->NomeFornecedor = $row->NomeFornecedor;
        }


		/*
echo "<pre>";
print_r($query['Comprados']);
echo "</pre>";
exit();*/


	
		foreach ($query['Parcelas'] as $row) {
            if (isset($rankingvendas->{$row->idApp_Fornecedor}))
                $rankingvendas->{$row->idApp_Fornecedor}->QtdParc = $row->QtdParc;
        }

		$rankingvendas->soma = new stdClass();
		$somaqtdorcam = $somaqtddescon = $somaqtdvendida = $somaqtdparc = $somaqtddevol = 0;

		foreach ($rankingvendas as $row) {

			$row->QtdParc = (!isset($row->QtdParc)) ? 0 : $row->QtdParc;

			$somaqtdparc += $row->QtdParc;
			$row->QtdParc = number_format($row->QtdParc, 2, ',', '.');																
        }


		$rankingvendas->soma->somaqtdparc = number_format($somaqtdparc, 2, ',', '.');
		

        /*
        echo $this->db->last_query();
        echo "<pre>";
        print_r($somaqtdparc);
        echo "</pre>";
        #echo "<pre>";
        #print_r($query);
        #echo "</pre>";
        exit();
        #*/

        return $rankingvendas;

    }
    
    public function list4_receitasparc($x) {

        $query = $this->db->query('
			SELECT 
				CONCAT(IFNULL(TR.TipoFinanceiro,""), " - ", IFNULL(OT.Descricao,"")) AS Descricao,
				OT.idApp_OrcaTrata,
				OT.AprovadoOrca,
                OT.DataOrca,
				OT.DataEntradaOrca,
				OT.DataPrazo,
                OT.ValorOrca,
				OT.ValorDev,				
				OT.ValorEntradaOrca,
				OT.ValorRestanteOrca,
				OT.DataVencimentoOrca,
                OT.ConcluidoOrca,
                OT.QuitadoOrca,
                OT.DataConclusao,
                OT.DataQuitado,
				OT.DataRetorno,
				OT.idTab_TipoRD,
				OT.FormaPagamento,
				OT.ObsOrca,
				OT.QtdParcelasOrca,
				OT.idSis_Usuario,
				MD.Modalidade,
				VP.Abrev2,
				VP.AVAP,
				TFP.FormaPag,
				TR.TipoFinanceiro,
				PR.Quitado,
				DATE_FORMAT(PR.DataVencimento, "%d/%m/%Y") AS DataVencimento,
				PR.Parcela,
				PR.ValorParcela
			FROM 
                App_OrcaTrata AS OT
					LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
					LEFT JOIN Tab_AVAP AS VP ON VP.Abrev2 = OT.AVAP
					LEFT JOIN App_Parcelas AS PR ON PR.idApp_Orcatrata = OT.idApp_OrcaTrata
			WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND 
                OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
				OT.AprovadoOrca = "S" AND
				OT.idTab_TipoRD = "2" AND
				PR.idTab_TipoRD = "2" AND
				PR.Quitado = "N" AND
				PR.DataVencimento <= "' . date("Y-m-t", mktime(0,0,0,date('m'),'01',date('Y'))) . '"
			ORDER BY 
				PR.DataVencimento ASC 
		');

        /*
          echo $this->db->last_query();
          $query = $query->result_array();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */

            if ($x === FALSE) {
                return TRUE;
            } else {
                $somareceber=0;
				foreach ($query->result() as $row) {
					$somareceber += $row->ValorParcela;				
					$row->ValorParcela = number_format($row->ValorParcela, 2, ',', '.');                
				}
				
				$query->soma = new stdClass();
				$query->soma->somareceber = number_format($somareceber, 2, ',', '.');
			
                #$query = $query->result_array();
				
                return $query;
            }
        
    }

    public function list4_despesasparc($x) {

        $query = $this->db->query('
			SELECT 
				CONCAT(IFNULL(TR.TipoFinanceiro,""), " - ", IFNULL(OT.Descricao,"")) AS Descricao,
				OT.idApp_OrcaTrata,
				OT.AprovadoOrca,
                OT.DataOrca,
				OT.DataEntradaOrca,
				OT.DataPrazo,
                OT.ValorOrca,
				OT.ValorDev,				
				OT.ValorEntradaOrca,
				OT.ValorRestanteOrca,
				OT.DataVencimentoOrca,
                OT.ConcluidoOrca,
                OT.QuitadoOrca,
                OT.DataConclusao,
                OT.DataQuitado,
				OT.DataRetorno,
				OT.idTab_TipoRD,
				OT.FormaPagamento,
				OT.ObsOrca,
				OT.QtdParcelasOrca,
				OT.idSis_Usuario,
				MD.Modalidade,
				VP.Abrev2,
				VP.AVAP,
				TFP.FormaPag,
				TR.TipoFinanceiro,
				PR.Quitado,
				DATE_FORMAT(PR.DataVencimento, "%d/%m/%Y") AS DataVencimento,
				PR.Parcela,
				PR.ValorParcela
			FROM 
                App_OrcaTrata AS OT
					LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
					LEFT JOIN Tab_AVAP AS VP ON VP.Abrev2 = OT.AVAP
					LEFT JOIN App_Parcelas AS PR ON PR.idApp_Orcatrata = OT.idApp_OrcaTrata
			WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND 
                OT.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND
				OT.AprovadoOrca = "S" AND
				OT.idTab_TipoRD = "1" AND
				PR.idTab_TipoRD = "1" AND
				PR.Quitado = "N" AND
				PR.DataVencimento <= "' . date("Y-m-t", mktime(0,0,0,date('m'),'01',date('Y'))) . '"
			ORDER BY 
				PR.DataVencimento ASC 
		');

        /*
          echo $this->db->last_query();
          $query = $query->result_array();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */

            if ($x === FALSE) {
                return TRUE;
            } else {
                $somareceber=0;
				foreach ($query->result() as $row) {
					$somareceber += $row->ValorParcela;				
					$row->ValorParcela = number_format($row->ValorParcela, 2, ',', '.');                
				}
				
				$query->soma = new stdClass();
				$query->soma->somareceber = number_format($somareceber, 2, ',', '.');
                #$query = $query->result_array();
                return $query;
            }
        
    }
	
    public function update_orcatrata($data, $id) {

        unset($data['idApp_OrcaTrata']);
        $query = $this->db->update('App_OrcaTrata', $data, array('idApp_OrcaTrata' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_cliente($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('App_Cliente', $data, array('idApp_Cliente' => $id));
        /*
          echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit ();
         */
        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
    public function update_orcatrataalterar($data, $id) {

        unset($data['idSis_Empresa']);
        $query = $this->db->update('Sis_Empresa', $data, array('idSis_Empresa' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }
		
    public function update_servico($data) {

        $query = $this->db->update_batch('App_Servico', $data, 'idApp_Servico');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_produto($data) {

        $query = $this->db->update_batch('App_Produto', $data, 'idApp_Produto');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_parcelas($data) {

        $query = $this->db->update_batch('App_Parcelas', $data, 'idApp_Parcelas');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }
	
    public function update_procedimento($data) {

        $query = $this->db->update_batch('App_Procedimento', $data, 'idApp_Procedimento');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function delete_servico($data) {

        $this->db->where_in('idApp_Servico', $data);
        $this->db->delete('App_Servico');

        //$query = $this->db->delete('App_Servico', array('idApp_Servico' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
		return TRUE;
        }
    }

    public function delete_produto($data) {

        $this->db->where_in('idApp_Produto', $data);
        $this->db->delete('App_Produto');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_parcelas($data) {

        $this->db->where_in('idApp_Parcelas', $data);
        $this->db->delete('App_Parcelas');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
    public function delete_procedimento($data) {

        $this->db->where_in('idApp_Procedimento', $data);
        $this->db->delete('App_Procedimento');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_orcatrata($id) {

        /*
        $tables = array('App_Servico', 'App_Produto', 'App_Parcelas', 'App_Procedimento', 'App_OrcaTrata');
        $this->db->where('idApp_Orcatrata', $id);
        $this->db->delete($tables);
        */

        $query = $this->db->delete('App_Servico', array('idApp_Orcatrata' => $id));
        $query = $this->db->delete('App_Produto', array('idApp_Orcatrata' => $id));
        $query = $this->db->delete('App_Parcelas', array('idApp_Orcatrata' => $id));
        $query = $this->db->delete('App_Procedimento', array('idApp_Orcatrata' => $id));
        $query = $this->db->delete('App_OrcaTrata', array('idApp_Orcatrata' => $id));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function get_profissional($data) {
		$query = $this->db->query('SELECT NomeProfissional FROM App_Profissional WHERE idApp_Profissional = ' . $data);
        $query = $query->result_array();

        return (isset($query[0]['NomeProfissional'])) ? $query[0]['NomeProfissional'] : FALSE;
    }
	
}
