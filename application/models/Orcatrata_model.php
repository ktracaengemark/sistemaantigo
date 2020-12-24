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

        $query = $this->db->insert_batch('App_Produto', $data);

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
	
    public function set_comissao($data) {

        $query = $this->db->insert_batch('App_OrcaTrata', $data);

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
			SELECT 
				OT.*,
				C.*,
				FP.*,
				TF.*,
				TF.idTab_TipoFinanceiro AS TipoFinanceiro,
				TF.TipoFinanceiro AS NomeTipoFinanceiro,
				SU.*
			FROM 
				App_OrcaTrata AS OT 
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN Tab_FormaPag AS FP ON FP.idTab_FormaPag = OT.FormaPagamento
					LEFT JOIN Tab_TipoFinanceiro AS TF ON TF.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Sis_Usuario AS SU ON SU.idSis_Usuario = OT.idSis_Usuario
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

    public function get_orcatrata_baixa($data) {
        $query = $this->db->query('
			SELECT * 
			FROM 
				App_OrcaTrata
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
	
    public function get_fornecedor($data) {
        $query = $this->db->query('SELECT * FROM App_Fornecedor WHERE idApp_Fornecedor = ' . $data);

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
	
    public function get_servico_bkp_orig($data) {
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
				TAP.Prod_Serv_Servico,
				TAP.NomeServico,
				TAP.ComissaoServico,
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

    public function get_servico($data) {
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
				TAP.Prod_Serv_Produto,
				TAP.NomeProduto,
				TAP.ComissaoProduto,
				TAP.ValorProduto,
				TAP.ObsProduto,
				TAP.QtdProduto,
				TAP.QtdIncrementoProduto,
				TAP.DataValidadeProduto,
				TAP.DataConcluidoProduto,
				TAP.HoraConcluidoProduto,
				TAP.ConcluidoProduto,
				TAP.idTab_TipoRD,
				TAP.ProfissionalProduto,
				P.Nome_Prod,
				TOP2.Opcao,
				TOP1.Opcao,
				SU.Nome,
				CONCAT(IFNULL(P.Nome_Prod,""), " - ", IFNULL(TOP2.Opcao,""), " - ", IFNULL(TOP1.Opcao,""), " - ", IFNULL(TDS.Desconto,""), " - ", IFNULL(TPM.Promocao,""), " - ", IFNULL(SU.Nome,"")) AS Produto,
				(TAP.QtdProduto * TAP.ValorProduto) AS Subtotal_Produto
			FROM 
				App_Produto AS TAP
					LEFT JOIN Sis_Usuario AS SU ON SU.idSis_Usuario = TAP.ProfissionalProduto
					LEFT JOIN Tab_Valor AS V ON V.idTab_Valor = TAP.idTab_Produto
					LEFT JOIN Tab_Promocao AS TPM ON TPM.idTab_Promocao = V.idTab_Promocao
					LEFT JOIN Tab_Desconto AS TDS ON TDS.idTab_Desconto = V.Desconto
					LEFT JOIN Tab_Produtos AS P ON P.idTab_Produtos = V.idTab_Produtos
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = P.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = P.Opcao_Atributo_2
			WHERE 
				TAP.idApp_OrcaTrata = ' . $data . ' AND
				TAP.Prod_Serv_Produto = "S" 
		');
        $query = $query->result_array();

        return $query;
    }
	
	public function get_servicodesp($data) {
		$query = $this->db->query('SELECT * FROM App_Produto WHERE idApp_OrcaTrata = ' . $data . ' AND Prod_Serv_Produto = "S"  ');
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
				TAP.Prod_Serv_Produto,
				TAP.NomeProduto,
				TAP.ValorProduto,
				TAP.QtdProduto,
				TAP.QtdIncrementoProduto,
				(TAP.QtdProduto * TAP.QtdIncrementoProduto) AS SubTotalQtd,
				TAP.ValorCompraProduto,
				TAP.QtdCompraProduto,
				TAP.ObsProduto,
				TAP.DataValidadeProduto,
				TAP.DataConcluidoProduto,
				TAP.HoraConcluidoProduto,
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
				TAP.ProfissionalProduto,
				V.Convdesc,
				P.Nome_Prod,
				TOP2.Opcao,
				TOP1.Opcao,
				SU.Nome,
				CONCAT(IFNULL(P.Nome_Prod,""), " - ",  IFNULL(TOP1.Opcao,""), " - ", IFNULL(TOP2.Opcao,""), " - ", IFNULL(V.Convdesc,"")) AS Produto,
				(TAP.QtdProduto * TAP.ValorProduto) AS Subtotal_Produto
			FROM 
				App_Produto AS TAP
					LEFT JOIN Sis_Usuario AS SU ON SU.idSis_Usuario = TAP.ProfissionalProduto
					LEFT JOIN Tab_Valor AS V ON V.idTab_Valor = TAP.idTab_Produto
					LEFT JOIN Tab_Promocao AS TPM ON TPM.idTab_Promocao = V.idTab_Promocao
					LEFT JOIN Tab_Desconto AS TDS ON TDS.idTab_Desconto = V.Desconto
					LEFT JOIN Tab_Produtos AS P ON P.idTab_Produtos = V.idTab_Produtos
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = P.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = P.Opcao_Atributo_2
			WHERE 
				TAP.idApp_OrcaTrata = ' . $data . ' AND
				TAP.Prod_Serv_Produto = "P" 
		');
        $query = $query->result_array();

        return $query;
    }

    public function get_produto_baixa($data) {
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
		
    public function get_produto_posterior($data) {
		$query = $this->db->query('SELECT * FROM App_Produto WHERE idApp_OrcaTrata = ' . $data . ' AND ConcluidoProduto = "N"');
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
				TAP.Prod_Serv_Produto,
				TAP.NomeProduto,
				TAP.ValorProduto,
				TAP.QtdProduto,
				TAP.QtdIncrementoProduto,
				(TAP.QtdProduto * TAP.QtdIncrementoProduto) AS SubTotalQtd,
				TAP.ValorCompraProduto,
				TAP.QtdCompraProduto,
				TAP.ObsProduto,
				TAP.DataValidadeProduto,
				TAP.DataConcluidoProduto,
				TAP.HoraConcluidoProduto,
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
				TAP.idApp_OrcaTrata = ' . $data . ' AND
				TAP.Prod_Serv_Produto = "P" 
		');
        $query = $query->result_array();

        return $query;
    }	

    public function get_parcelas($data) {
		$query = $this->db->query('SELECT * FROM App_Parcelas WHERE idApp_OrcaTrata = ' . $data);
        $query = $query->result_array();

        return $query;
    }
	
    public function get_parcela($data) {
        $query = $this->db->query(' SELECT * FROM App_Parcelas WHERE idApp_Parcelas = ' . $data . '');
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
	
    public function get_parcelas_posterior($data) {
		$query = $this->db->query('SELECT * FROM App_Parcelas WHERE idApp_OrcaTrata = ' . $data . ' AND Quitado = "N"');
        $query = $query->result_array();

        return $query;
    }	

    public function get_parcelas_baixa($data) {
		$query = $this->db->query('SELECT * FROM App_Parcelas WHERE idApp_OrcaTrata = ' . $data);
        $query = $query->result_array();

        return $query;
    }
	
    public function get_alterarorcamentos($data) {

		if ($_SESSION['FiltroAlteraParcela']['DataFim']) {
            $consulta =
				'(OT.DataOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '" AND OT.DataOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '")';
        }
		
		if ($_SESSION['FiltroAlteraParcela']['DataFim2']) {
            $consulta2 =
				'(OT.DataEntregaOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio2'] . '" AND OT.DataEntregaOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(OT.DataEntregaOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio2'] . '")';
        }
		
		if ($_SESSION['FiltroAlteraParcela']['DataFim3']) {
            $consulta3 =
				'(OT.DataVencimentoOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio3'] . '" AND OT.DataVencimentoOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim3'] . '")';
        }
        else {
            $consulta3 =
                '(OT.DataVencimentoOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio3'] . '")';
        }
		
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND PR.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;

		$date_inicio_orca = ($_SESSION['FiltroAlteraParcela']['DataInicio']) ? 'OT.DataOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '" AND ' : FALSE;
		$date_fim_orca = ($_SESSION['FiltroAlteraParcela']['DataFim']) ? 'OT.DataOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim'] . '" AND ' : FALSE;

		$date_inicio_entrega = ($_SESSION['FiltroAlteraParcela']['DataInicio2']) ? 'OT.DataEntregaOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio2'] . '" AND ' : FALSE;
		$date_fim_entrega = ($_SESSION['FiltroAlteraParcela']['DataFim2']) ? 'OT.DataEntregaOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim2'] . '" AND ' : FALSE;

		$date_inicio_vnc = ($_SESSION['FiltroAlteraParcela']['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio3'] . '" AND ' : FALSE;
		$date_fim_vnc = ($_SESSION['FiltroAlteraParcela']['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim3'] . '" AND ' : FALSE;
		
		$date_inicio_vnc_prc = ($_SESSION['FiltroAlteraParcela']['DataInicio4']) ? 'PR.DataVencimento >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio4'] . '" AND ' : FALSE;
		$date_fim_vnc_prc = ($_SESSION['FiltroAlteraParcela']['DataFim4']) ? 'PR.DataVencimento <= "' . $_SESSION['FiltroAlteraParcela']['DataFim4'] . '" AND ' : FALSE;

		  
		$permissao30 = ($_SESSION['FiltroAlteraParcela']['Orcamento'] != "" ) ? 'OT.idApp_OrcaTrata = "' . $_SESSION['FiltroAlteraParcela']['Orcamento'] . '" AND ' : FALSE;
		$permissao31 = ($_SESSION['FiltroAlteraParcela']['Cliente'] != "" ) ? 'OT.idApp_Cliente = "' . $_SESSION['FiltroAlteraParcela']['Cliente'] . '" AND ' : FALSE;
		$permissao36 = ($_SESSION['FiltroAlteraParcela']['Fornecedor'] != "" ) ? 'OT.idApp_Fornecedor = "' . $_SESSION['FiltroAlteraParcela']['Fornecedor'] . '" AND ' : FALSE;
		$permissao13 = ($_SESSION['FiltroAlteraParcela']['CombinadoFrete'] != "0" ) ? 'OT.CombinadoFrete = "' . $_SESSION['FiltroAlteraParcela']['CombinadoFrete'] . '" AND ' : FALSE;
		$permissao1 = ($_SESSION['FiltroAlteraParcela']['AprovadoOrca'] != "0" ) ? 'OT.AprovadoOrca = "' . $_SESSION['FiltroAlteraParcela']['AprovadoOrca'] . '" AND ' : FALSE;
		$permissao3 = ($_SESSION['FiltroAlteraParcela']['ConcluidoOrca'] != "0" ) ? 'OT.ConcluidoOrca = "' . $_SESSION['FiltroAlteraParcela']['ConcluidoOrca'] . '" AND ' : FALSE;
		$permissao2 = ($_SESSION['FiltroAlteraParcela']['QuitadoOrca'] != "0" ) ? 'OT.QuitadoOrca = "' . $_SESSION['FiltroAlteraParcela']['QuitadoOrca'] . '" AND ' : FALSE;
		$permissao4 = ($_SESSION['FiltroAlteraParcela']['Quitado'] != "0" ) ? 'PR.Quitado = "' . $_SESSION['FiltroAlteraParcela']['Quitado'] . '" AND ' : FALSE;

		$permissao10 = ($_SESSION['FiltroAlteraParcela']['FinalizadoOrca'] != "0" ) ? 'OT.FinalizadoOrca = "' . $_SESSION['FiltroAlteraParcela']['FinalizadoOrca'] . '" AND ' : FALSE;
		$permissao11 = ($_SESSION['FiltroAlteraParcela']['CanceladoOrca'] != "0" ) ? 'OT.CanceladoOrca = "' . $_SESSION['FiltroAlteraParcela']['CanceladoOrca'] . '" AND ' : FALSE;
		
		//$permissao10 = 'OT.FinalizadoOrca = "N" AND ';
		//$permissao11 = 'OT.CanceladoOrca = "N" AND ';

		$permissao5 = ($_SESSION['FiltroAlteraParcela']['Modalidade'] != "0" ) ? 'OT.Modalidade = "' . $_SESSION['FiltroAlteraParcela']['Modalidade'] . '" AND ' : FALSE;
		$permissao7 = ($_SESSION['FiltroAlteraParcela']['Tipo_Orca'] != "0" ) ? 'OT.Tipo_Orca = "' . $_SESSION['FiltroAlteraParcela']['Tipo_Orca'] . '" AND ' : FALSE;
		$permissao33 = ($_SESSION['FiltroAlteraParcela']['AVAP'] != "0" ) ? 'OT.AVAP = "' . $_SESSION['FiltroAlteraParcela']['AVAP'] . '" AND ' : FALSE;
		$permissao34 = ($_SESSION['FiltroAlteraParcela']['TipoFrete'] != "0" ) ? 'OT.TipoFrete = "' . $_SESSION['FiltroAlteraParcela']['TipoFrete'] . '" AND ' : FALSE;
		$permissao6 = ($_SESSION['FiltroAlteraParcela']['FormaPagamento'] != "0" ) ? 'OT.FormaPagamento = "' . $_SESSION['FiltroAlteraParcela']['FormaPagamento'] . '" AND ' : FALSE;
		$permissao32 = ($_SESSION['FiltroAlteraParcela']['TipoFinanceiro'] != "0" ) ? 'OT.TipoFinanceiro = "' . $_SESSION['FiltroAlteraParcela']['TipoFinanceiro'] . '" AND ' : FALSE;
		$permissao35 = ($_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] != "" ) ? 'OT.idTab_TipoRD = "' . $_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] . '" AND PR.idTab_TipoRD = "' . $_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] . '" AND' : FALSE;
		
		$permissao26 = ($_SESSION['FiltroAlteraParcela']['Mesvenc'] != "0" ) ? 'MONTH(PR.DataVencimento) = "' . $_SESSION['FiltroAlteraParcela']['Mesvenc'] . '" AND ' : FALSE;
		$permissao27 = ($_SESSION['FiltroAlteraParcela']['Ano'] != "0" ) ? 'YEAR(PR.DataVencimento) = "' . $_SESSION['FiltroAlteraParcela']['Ano'] . '" AND ' : FALSE;
		$permissao25 = ($_SESSION['FiltroAlteraParcela']['Orcarec'] != "0" ) ? 'OT.idApp_OrcaTrata = "' . $_SESSION['FiltroAlteraParcela']['Orcarec'] . '" AND ' : FALSE;
		
		$permissao17 = ($_SESSION['FiltroAlteraParcela']['NomeUsuario'] != "0" ) ? 'OT.idSis_Usuario = "' . $_SESSION['FiltroAlteraParcela']['NomeUsuario'] . '" AND ' : FALSE;
		$permissao18 = ($_SESSION['FiltroAlteraParcela']['NomeAssociado'] != "" ) ? 'OT.Associado = "' . $_SESSION['FiltroAlteraParcela']['NomeAssociado'] . '" AND ' : FALSE;
		$permissao12 = ($_SESSION['FiltroAlteraParcela']['StatusComissaoOrca'] != "0" ) ? 'OT.StatusComissaoOrca = "' . $_SESSION['FiltroAlteraParcela']['StatusComissaoOrca'] . '" AND ' : FALSE;
		$permissao14 = ($_SESSION['FiltroAlteraParcela']['StatusComissaoOrca_Online'] != "0" ) ? 'OT.StatusComissaoOrca_Online = "' . $_SESSION['FiltroAlteraParcela']['StatusComissaoOrca_Online'] . '" AND ' : FALSE;
		
		$permissao60 = (!$_SESSION['FiltroAlteraParcela']['Campo']) ? 'OT.idApp_OrcaTrata' : $_SESSION['FiltroAlteraParcela']['Campo'];
        $permissao61 = (!$_SESSION['FiltroAlteraParcela']['Ordenamento']) ? 'ASC' : $_SESSION['FiltroAlteraParcela']['Ordenamento'];

		$query = $this->db->query('
            SELECT
				C.idApp_Cliente,
				C.NomeCliente,
				C.CelularCliente,
				C.Telefone,
				C.Telefone2,
				C.Telefone3,
				C.EnderecoCliente,
				C.NumeroCliente,
				C.ComplementoCliente,
				C.BairroCliente,
				C.CidadeCliente,
				C.EstadoCliente,
				F.idApp_Fornecedor,
				F.NomeFornecedor,
				OT.idSis_Empresa,
				OT.idApp_OrcaTrata,
				OT.CombinadoFrete,
				OT.AprovadoOrca,
				OT.ConcluidoOrca,
				OT.QuitadoOrca,
				OT.FinalizadoOrca,
				OT.CanceladoOrca,
				OT.DataOrca,
				OT.DataPrazo,
				OT.DataConclusao,
				OT.DataQuitado,				
				OT.DataRetorno,
				OT.DataEntradaOrca,
				OT.idApp_Cliente,
				OT.idApp_Fornecedor,
				OT.ValorOrca,
				OT.ValorTotalOrca,
				OT.ValorDev,
				OT.ValorDinheiro,
				OT.ValorTroco,
				OT.ValorEntradaOrca,
				OT.ValorRestanteOrca,
				OT.ValorComissao,
				OT.QtdParcelasOrca,
				OT.DataEntregaOrca,
				OT.HoraEntregaOrca,
				OT.DataVencimentoOrca,
				OT.StatusComissaoOrca,
				OT.StatusComissaoOrca_Online,
				OT.idSis_Usuario,
				OT.ObsOrca,
				OT.Descricao,
				OT.TipoFinanceiro,
				OT.Tipo_Orca,
				OT.FormaPagamento,
				OT.Associado,
				OT.idTab_TipoRD,
				TTF.TipoFrete,
				FP.FormaPag,				
				EF.NomeEmpresa,
				MO.AVAP,
				MO.Abrev2,
				OT.Modalidade,
				TP.TipoFinanceiro,
				PR.DataVencimento,
				PR.Quitado,
				PR.idTab_TipoRD,
				US.Nome AS NomeColaborador,
				USA.Nome AS NomeAssociado
            FROM
				App_OrcaTrata AS OT
				LEFT JOIN Sis_Empresa AS EF ON EF.idSis_Empresa = OT.idSis_Empresa
				LEFT JOIN Tab_FormaPag AS FP ON FP.idTab_FormaPag = OT.FormaPagamento
				LEFT JOIN Tab_TipoFinanceiro AS TP ON TP.idTab_TipoFinanceiro = OT.TipoFinanceiro
				LEFT JOIN Tab_AVAP AS MO ON MO.Abrev2 = OT.AVAP
				LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
				LEFT JOIN App_Fornecedor AS F ON F.idApp_Fornecedor = OT.idApp_Fornecedor
				LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
				LEFT JOIN Sis_Usuario AS US ON US.idSis_Usuario = OT.idSis_Usuario
				LEFT JOIN Sis_Usuario AS USA ON USA.idSis_Usuario = OT.Associado
				LEFT JOIN Tab_TipoFrete AS TTF ON TTF.idTab_TipoFrete = OT.TipoFrete
            WHERE
				' . $permissao . '
				' . $permissao30 . '
				' . $permissao31 . '
				' . $permissao13 . '
				' . $permissao1 . '
				' . $permissao3 . '
				' . $permissao2 . '
				' . $permissao4 . '
				' . $permissao10 . '
				' . $permissao11 . '
				' . $permissao12 . '
				' . $permissao14 . '
				' . $permissao6 . '
				' . $permissao5 . '
				' . $permissao7 . '
				' . $permissao32 . '
				' . $permissao33 . '
				' . $permissao34 . '
				' . $permissao17 . '
				' . $permissao18 . '
				' . $permissao35 . '
				' . $permissao36 . '
                ' . $date_inicio_orca . '
                ' . $date_fim_orca . '
                ' . $date_inicio_entrega . '
                ' . $date_fim_entrega . '
                ' . $date_inicio_vnc . '
                ' . $date_fim_vnc . '
                ' . $date_inicio_vnc_prc . '
                ' . $date_fim_vnc_prc . '
				OT.FinalizadoOrca = "N" AND 
				OT.CanceladoOrca = "N" AND			
				OT.idSis_Empresa = ' . $data . ' AND
				PR.idSis_Empresa = ' . $data . '
			GROUP BY
                OT.idApp_OrcaTrata	
            ORDER BY
				' . $permissao60 . '
				' . $permissao61 . '
			LIMIT 100
		');
        $query = $query->result_array();
 
        return $query;
    }
	
    public function get_baixadacomissao($data) {

		if ($_SESSION['FiltroAlteraParcela']['DataFim']) {
            $consulta =
				'(OT.DataOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '" AND OT.DataOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '")';
        }
		
		if ($_SESSION['FiltroAlteraParcela']['DataFim2']) {
            $consulta2 =
				'(OT.DataEntregaOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio2'] . '" AND OT.DataEntregaOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(OT.DataEntregaOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio2'] . '")';
        }
		
		if ($_SESSION['FiltroAlteraParcela']['DataFim3']) {
            $consulta3 =
				'(OT.DataVencimentoOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio3'] . '" AND OT.DataVencimentoOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim3'] . '")';
        }
        else {
            $consulta3 =
                '(OT.DataVencimentoOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio3'] . '")';
        }
		
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND PR.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;

		$date_inicio_orca = ($_SESSION['FiltroAlteraParcela']['DataInicio']) ? 'OT.DataOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '" AND ' : FALSE;
		$date_fim_orca = ($_SESSION['FiltroAlteraParcela']['DataFim']) ? 'OT.DataOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim'] . '" AND ' : FALSE;

		$date_inicio_entrega = ($_SESSION['FiltroAlteraParcela']['DataInicio2']) ? 'OT.DataEntregaOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio2'] . '" AND ' : FALSE;
		$date_fim_entrega = ($_SESSION['FiltroAlteraParcela']['DataFim2']) ? 'OT.DataEntregaOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim2'] . '" AND ' : FALSE;

		$date_inicio_vnc = ($_SESSION['FiltroAlteraParcela']['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio3'] . '" AND ' : FALSE;
		$date_fim_vnc = ($_SESSION['FiltroAlteraParcela']['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim3'] . '" AND ' : FALSE;
		
		$date_inicio_vnc_prc = ($_SESSION['FiltroAlteraParcela']['DataInicio4']) ? 'PR.DataVencimento >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio4'] . '" AND ' : FALSE;
		$date_fim_vnc_prc = ($_SESSION['FiltroAlteraParcela']['DataFim4']) ? 'PR.DataVencimento <= "' . $_SESSION['FiltroAlteraParcela']['DataFim4'] . '" AND ' : FALSE;

		  
		$permissao30 = ($_SESSION['FiltroAlteraParcela']['Orcamento'] != "" ) ? 'OT.idApp_OrcaTrata = "' . $_SESSION['FiltroAlteraParcela']['Orcamento'] . '" AND ' : FALSE;
		$permissao31 = ($_SESSION['FiltroAlteraParcela']['Cliente'] != "" ) ? 'OT.idApp_Cliente = "' . $_SESSION['FiltroAlteraParcela']['Cliente'] . '" AND ' : FALSE;
		$permissao13 = ($_SESSION['FiltroAlteraParcela']['CombinadoFrete'] != "0" ) ? 'OT.CombinadoFrete = "' . $_SESSION['FiltroAlteraParcela']['CombinadoFrete'] . '" AND ' : FALSE;
		$permissao1 = ($_SESSION['FiltroAlteraParcela']['AprovadoOrca'] != "0" ) ? 'OT.AprovadoOrca = "' . $_SESSION['FiltroAlteraParcela']['AprovadoOrca'] . '" AND ' : FALSE;
		$permissao3 = ($_SESSION['FiltroAlteraParcela']['ConcluidoOrca'] != "0" ) ? 'OT.ConcluidoOrca = "' . $_SESSION['FiltroAlteraParcela']['ConcluidoOrca'] . '" AND ' : FALSE;
		$permissao2 = ($_SESSION['FiltroAlteraParcela']['QuitadoOrca'] != "0" ) ? 'OT.QuitadoOrca = "' . $_SESSION['FiltroAlteraParcela']['QuitadoOrca'] . '" AND ' : FALSE;
		$permissao4 = ($_SESSION['FiltroAlteraParcela']['Quitado'] != "0" ) ? 'PR.Quitado = "' . $_SESSION['FiltroAlteraParcela']['Quitado'] . '" AND ' : FALSE;

		$permissao10 = ($_SESSION['FiltroAlteraParcela']['FinalizadoOrca'] != "0" ) ? 'OT.FinalizadoOrca = "' . $_SESSION['FiltroAlteraParcela']['FinalizadoOrca'] . '" AND ' : FALSE;
		$permissao11 = ($_SESSION['FiltroAlteraParcela']['CanceladoOrca'] != "0" ) ? 'OT.CanceladoOrca = "' . $_SESSION['FiltroAlteraParcela']['CanceladoOrca'] . '" AND ' : FALSE;
	
		$permissao7 = ($_SESSION['FiltroAlteraParcela']['Tipo_Orca'] != "0" ) ? 'OT.Tipo_Orca = "' . $_SESSION['FiltroAlteraParcela']['Tipo_Orca'] . '" AND ' : FALSE;
		$permissao33 = ($_SESSION['FiltroAlteraParcela']['AVAP'] != "0" ) ? 'OT.AVAP = "' . $_SESSION['FiltroAlteraParcela']['AVAP'] . '" AND ' : FALSE;
		$permissao34 = ($_SESSION['FiltroAlteraParcela']['TipoFrete'] != "0" ) ? 'OT.TipoFrete = "' . $_SESSION['FiltroAlteraParcela']['TipoFrete'] . '" AND ' : FALSE;
		$permissao6 = ($_SESSION['FiltroAlteraParcela']['FormaPagamento'] != "0" ) ? 'OT.FormaPagamento = "' . $_SESSION['FiltroAlteraParcela']['FormaPagamento'] . '" AND ' : FALSE;
		$permissao32 = ($_SESSION['FiltroAlteraParcela']['TipoFinanceiro'] != "0" ) ? 'OT.TipoFinanceiro = "' . $_SESSION['FiltroAlteraParcela']['TipoFinanceiro'] . '" AND ' : FALSE;
		
		$permissao26 = ($_SESSION['FiltroAlteraParcela']['Mesvenc'] != "0" ) ? 'MONTH(PR.DataVencimento) = "' . $_SESSION['FiltroAlteraParcela']['Mesvenc'] . '" AND ' : FALSE;
		$permissao27 = ($_SESSION['FiltroAlteraParcela']['Ano'] != "0" ) ? 'YEAR(PR.DataVencimento) = "' . $_SESSION['FiltroAlteraParcela']['Ano'] . '" AND ' : FALSE;
		$permissao25 = ($_SESSION['FiltroAlteraParcela']['Orcarec'] != "0" ) ? 'OT.idApp_OrcaTrata = "' . $_SESSION['FiltroAlteraParcela']['Orcarec'] . '" AND ' : FALSE;
		
		$permissao17 = ($_SESSION['FiltroAlteraParcela']['NomeUsuario'] != "0" ) ? 'OT.idSis_Usuario = "' . $_SESSION['FiltroAlteraParcela']['NomeUsuario'] . '" AND ' : FALSE;
		$permissao18 = ($_SESSION['FiltroAlteraParcela']['NomeAssociado'] != "" ) ? 'OT.Associado = "' . $_SESSION['FiltroAlteraParcela']['NomeAssociado'] . '" AND ' : FALSE;
		$permissao12 = ($_SESSION['FiltroAlteraParcela']['StatusComissaoOrca'] != "0" ) ? 'OT.StatusComissaoOrca = "' . $_SESSION['FiltroAlteraParcela']['StatusComissaoOrca'] . '" AND ' : FALSE;
		$permissao14 = ($_SESSION['FiltroAlteraParcela']['StatusComissaoOrca_Online'] != "0" ) ? 'OT.StatusComissaoOrca_Online = "' . $_SESSION['FiltroAlteraParcela']['StatusComissaoOrca_Online'] . '" AND ' : FALSE;

		$query = $this->db->query('
            SELECT
				C.NomeCliente,
				C.CelularCliente,
				C.Telefone,
				C.Telefone2,
				C.Telefone3,
				C.EnderecoCliente,
				C.NumeroCliente,
				C.ComplementoCliente,
				C.BairroCliente,
				C.CidadeCliente,
				C.EstadoCliente,
				OT.idSis_Empresa,
				OT.idApp_OrcaTrata,
				OT.CombinadoFrete,
				OT.AprovadoOrca,
				OT.ConcluidoOrca,
				OT.QuitadoOrca,
				OT.FinalizadoOrca,
				OT.CanceladoOrca,
				OT.DataOrca,
				OT.DataPrazo,
				OT.DataConclusao,
				OT.DataQuitado,				
				OT.DataRetorno,
				OT.DataEntradaOrca,
				OT.idApp_Cliente,
				OT.idApp_Fornecedor,
				OT.ValorOrca,
				OT.ValorTotalOrca,
				OT.ValorDev,
				OT.ValorDinheiro,
				OT.ValorTroco,
				OT.ValorEntradaOrca,
				OT.ValorRestanteOrca,
				OT.ValorComissao,
				OT.QtdParcelasOrca,
				OT.DataEntregaOrca,
				OT.DataVencimentoOrca,
				OT.StatusComissaoOrca,
				OT.StatusComissaoOrca_Online,
				OT.DataPagoComissaoOrca,
				OT.idSis_Usuario,
				OT.ObsOrca,
				OT.Descricao,
				OT.TipoFinanceiro,
				OT.Tipo_Orca,
				OT.FormaPagamento,
				OT.Associado,
				TTF.TipoFrete,
				FP.FormaPag,				
				EF.NomeEmpresa,
				MO.AVAP,
				MO.Abrev2,
				OT.Modalidade,
				TP.TipoFinanceiro,
				PR.DataVencimento,
				PR.Quitado,
				US.Nome AS NomeColaborador,
				USA.Nome AS NomeAssociado
            FROM
				App_OrcaTrata AS OT
				LEFT JOIN Sis_Empresa AS EF ON EF.idSis_Empresa = OT.idSis_Empresa
				LEFT JOIN Tab_FormaPag AS FP ON FP.idTab_FormaPag = OT.FormaPagamento
				LEFT JOIN Tab_TipoFinanceiro AS TP ON TP.idTab_TipoFinanceiro = OT.TipoFinanceiro
				LEFT JOIN Tab_AVAP AS MO ON MO.Abrev2 = OT.AVAP
				LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
				LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
				LEFT JOIN Sis_Usuario AS US ON US.idSis_Usuario = OT.idSis_Usuario
				LEFT JOIN Sis_Usuario AS USA ON USA.idSis_Usuario = OT.Associado
				LEFT JOIN Tab_TipoFrete AS TTF ON TTF.idTab_TipoFrete = OT.TipoFrete
            WHERE
				' . $permissao . '
				' . $permissao30 . '
				' . $permissao31 . '
				' . $permissao13 . '
				' . $permissao1 . '
				' . $permissao3 . '
				' . $permissao2 . '
				' . $permissao4 . '
				' . $permissao10 . '
				' . $permissao11 . '
				' . $permissao12 . '
				' . $permissao14 . '
				' . $permissao6 . '
				' . $permissao7 . '
				' . $permissao32 . '
				' . $permissao33 . '
				' . $permissao34 . '
				' . $permissao17 . '
				' . $permissao18 . '
                ' . $date_inicio_orca . '
                ' . $date_fim_orca . '
                ' . $date_inicio_entrega . '
                ' . $date_fim_entrega . '
                ' . $date_inicio_vnc . '
                ' . $date_fim_vnc . '
                ' . $date_inicio_vnc_prc . '
                ' . $date_fim_vnc_prc . '
				OT.idSis_Empresa = ' . $data . ' AND
				PR.idSis_Empresa = ' . $data . ' AND
				OT.idTab_TipoRD = "2" AND
				PR.idTab_TipoRD = "2" 
			GROUP BY
                OT.idApp_OrcaTrata	
            ORDER BY
				OT.DataVencimentoOrca,
				OT.idApp_OrcaTrata
			LIMIT 100
		');
        $query = $query->result_array();
 
        return $query;
    }
	
	public function get_alterarparceladesp_Original($data) {

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
	
    public function get_alterarparcela($data) {

        if ($_SESSION['FiltroAlteraParcela']['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '" AND OT.DataOrca  <= "' . $_SESSION['FiltroAlteraParcela']['DataFim'] . '")';
		}
        else {
            $consulta =
                '(OT.DataOrca  >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '")';
        }

        if ($_SESSION['FiltroAlteraParcela']['DataFim2']) {
            $consulta2 =
                '(OT.DataEntregaOrca  >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio2'] . '" AND OT.DataEntregaOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(OT.DataEntregaOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio2'] . '")';
        }
		#$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;		
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND PR.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;

		$date_inicio_orca = ($_SESSION['FiltroAlteraParcela']['DataInicio']) ? 'OT.DataOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '" AND ' : FALSE;
		$date_fim_orca = ($_SESSION['FiltroAlteraParcela']['DataFim']) ? 'OT.DataOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim'] . '" AND ' : FALSE;

		$date_inicio_entrega = ($_SESSION['FiltroAlteraParcela']['DataInicio2']) ? 'OT.DataEntregaOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio2'] . '" AND ' : FALSE;
		$date_fim_entrega = ($_SESSION['FiltroAlteraParcela']['DataFim2']) ? 'OT.DataEntregaOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim2'] . '" AND ' : FALSE;

		$date_inicio_vnc = ($_SESSION['FiltroAlteraParcela']['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio3'] . '" AND ' : FALSE;
		$date_fim_vnc = ($_SESSION['FiltroAlteraParcela']['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim3'] . '" AND ' : FALSE;
		
		$date_inicio_vnc_prc = ($_SESSION['FiltroAlteraParcela']['DataInicio4']) ? 'PR.DataVencimento >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio4'] . '" AND ' : FALSE;
		$date_fim_vnc_prc = ($_SESSION['FiltroAlteraParcela']['DataFim4']) ? 'PR.DataVencimento <= "' . $_SESSION['FiltroAlteraParcela']['DataFim4'] . '" AND ' : FALSE;
		
		$permissao30 = ($_SESSION['FiltroAlteraParcela']['Orcamento'] != "" ) ? 'OT.idApp_OrcaTrata = "' . $_SESSION['FiltroAlteraParcela']['Orcamento'] . '" AND ' : FALSE;
		$permissao31 = ($_SESSION['FiltroAlteraParcela']['Cliente'] != "" ) ? 'OT.idApp_Cliente = "' . $_SESSION['FiltroAlteraParcela']['Cliente'] . '" AND ' : FALSE;
		$permissao36 = ($_SESSION['FiltroAlteraParcela']['Fornecedor'] != "" ) ? 'OT.idApp_Fornecedor = "' . $_SESSION['FiltroAlteraParcela']['Fornecedor'] . '" AND ' : FALSE;
		$permissao13 = ($_SESSION['FiltroAlteraParcela']['CombinadoFrete'] != "0" ) ? 'OT.CombinadoFrete = "' . $_SESSION['FiltroAlteraParcela']['CombinadoFrete'] . '" AND ' : FALSE;
		$permissao1 = ($_SESSION['FiltroAlteraParcela']['AprovadoOrca'] != "0" ) ? 'OT.AprovadoOrca = "' . $_SESSION['FiltroAlteraParcela']['AprovadoOrca'] . '" AND ' : FALSE;
		$permissao3 = ($_SESSION['FiltroAlteraParcela']['ConcluidoOrca'] != "0" ) ? 'OT.ConcluidoOrca = "' . $_SESSION['FiltroAlteraParcela']['ConcluidoOrca'] . '" AND ' : FALSE;
		$permissao2 = ($_SESSION['FiltroAlteraParcela']['QuitadoOrca'] != "0" ) ? 'OT.QuitadoOrca = "' . $_SESSION['FiltroAlteraParcela']['QuitadoOrca'] . '" AND ' : FALSE;
		$permissao4 = ($_SESSION['FiltroAlteraParcela']['Quitado'] != "0" ) ? 'PR.Quitado = "' . $_SESSION['FiltroAlteraParcela']['Quitado'] . '" AND ' : FALSE;
		$permissao10 = ($_SESSION['FiltroAlteraParcela']['FinalizadoOrca'] != "0" ) ? 'OT.FinalizadoOrca = "' . $_SESSION['FiltroAlteraParcela']['FinalizadoOrca'] . '" AND ' : FALSE;
		$permissao11 = ($_SESSION['FiltroAlteraParcela']['CanceladoOrca'] != "0" ) ? 'OT.CanceladoOrca = "' . $_SESSION['FiltroAlteraParcela']['CanceladoOrca'] . '" AND ' : FALSE;
		
		$permissao7 = ($_SESSION['FiltroAlteraParcela']['Tipo_Orca'] != "0" ) ? 'OT.Tipo_Orca = "' . $_SESSION['FiltroAlteraParcela']['Tipo_Orca'] . '" AND ' : FALSE;
		$permissao33 = ($_SESSION['FiltroAlteraParcela']['AVAP'] != "0" ) ? 'OT.AVAP = "' . $_SESSION['FiltroAlteraParcela']['AVAP'] . '" AND ' : FALSE;
		$permissao34 = ($_SESSION['FiltroAlteraParcela']['TipoFrete'] != "0" ) ? 'OT.TipoFrete = "' . $_SESSION['FiltroAlteraParcela']['TipoFrete'] . '" AND ' : FALSE;
		$permissao5 = ($_SESSION['FiltroAlteraParcela']['Modalidade'] != "0" ) ? 'OT.Modalidade = "' . $_SESSION['FiltroAlteraParcela']['Modalidade'] . '" AND ' : FALSE;
		$permissao6 = ($_SESSION['FiltroAlteraParcela']['FormaPagamento'] != "0" ) ? 'OT.FormaPagamento = "' . $_SESSION['FiltroAlteraParcela']['FormaPagamento'] . '" AND ' : FALSE;
		$permissao32 = ($_SESSION['FiltroAlteraParcela']['TipoFinanceiro'] != "0" ) ? 'OT.TipoFinanceiro = "' . $_SESSION['FiltroAlteraParcela']['TipoFinanceiro'] . '" AND ' : FALSE;
		$permissao35 = ($_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] != "" ) ? 'OT.idTab_TipoRD = "' . $_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] . '" AND PR.idTab_TipoRD = "' . $_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] . '" AND' : FALSE;
		$permissao26 = ($_SESSION['FiltroAlteraParcela']['Mesvenc'] != "0" ) ? 'MONTH(PR.DataVencimento) = "' . $_SESSION['FiltroAlteraParcela']['Mesvenc'] . '" AND ' : FALSE;
		$permissao27 = ($_SESSION['FiltroAlteraParcela']['Ano'] != "0" ) ? 'YEAR(PR.DataVencimento) = "' . $_SESSION['FiltroAlteraParcela']['Ano'] . '" AND ' : FALSE;
		$permissao25 = ($_SESSION['FiltroAlteraParcela']['Orcarec'] != "0" ) ? 'OT.idApp_OrcaTrata = "' . $_SESSION['FiltroAlteraParcela']['Orcarec'] . '" AND ' : FALSE;
		//$permissao5 = (($_SESSION['log']['idSis_Empresa'] != 5) && ($_SESSION['FiltroAlteraParcela']['NomeCliente'] != "0" )) ? 'OT.idApp_Cliente = "' . $_SESSION['FiltroAlteraParcela']['NomeCliente'] . '" AND ' : FALSE;
		$permissao60 = (!$_SESSION['FiltroAlteraParcela']['Campo']) ? 'OT.idApp_OrcaTrata' : $_SESSION['FiltroAlteraParcela']['Campo'];
        $permissao61 = (!$_SESSION['FiltroAlteraParcela']['Ordenamento']) ? 'ASC' : $_SESSION['FiltroAlteraParcela']['Ordenamento'];
		
		$query = $this->db->query('
			SELECT
				C.idApp_Cliente,
				C.NomeCliente,
				F.idApp_Fornecedor,
				F.NomeFornecedor,
				OT.idApp_OrcaTrata,
				OT.idSis_Usuario,
				OT.Descricao,
				OT.TipoFinanceiro,
				OT.AprovadoOrca,
				OT.ConcluidoOrca,
				OT.QuitadoOrca,
				OT.FinalizadoOrca,
				OT.CanceladoOrca,
				OT.CombinadoFrete,
				OT.AVAP,
				OT.TipoFrete,
				OT.Modalidade,
				OT.DataOrca,
				TR.TipoFinanceiro,
				E.NomeEmpresa,
				PR.idSis_Usuario,
				CONCAT(PR.idSis_Empresa, "-", E.NomeEmpresa) AS idSis_Empresa,
				PR.idApp_Parcelas,
				PR.Parcela,
				PR.idApp_OrcaTrata,
				CONCAT(IFNULL(PR.idApp_OrcaTrata,""), "--", IFNULL(TR.TipoFinanceiro,""), "--", IFNULL(C.idApp_Cliente,""), "--", IFNULL(C.NomeCliente,""), "--", IFNULL(OT.Descricao,"")) AS Receita,
				CONCAT(IFNULL(PR.idApp_OrcaTrata,""), "--", IFNULL(TR.TipoFinanceiro,""), "--", IFNULL(F.idApp_Fornecedor,""), "--", IFNULL(F.NomeFornecedor,""), "--", IFNULL(OT.Descricao,"")) AS Despesa,
				PR.ValorParcela,
				PR.DataVencimento,
				PR.ValorPago,
				PR.DataPago,
				PR.Quitado				
			FROM 
				App_Parcelas AS PR
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN App_Fornecedor AS F ON F.idApp_Fornecedor = OT.idApp_Fornecedor
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = PR.idSis_Empresa
			WHERE
				' . $permissao . '
                ' . $date_inicio_orca . '
                ' . $date_fim_orca . '
                ' . $date_inicio_entrega . '
                ' . $date_fim_entrega . '
                ' . $date_inicio_vnc . '
                ' . $date_fim_vnc . '
                ' . $date_inicio_vnc_prc . '
                ' . $date_fim_vnc_prc . '
				OT.idSis_Empresa = ' . $data . ' AND
				' . $permissao1 . '
				' . $permissao2 . '
				' . $permissao3 . '
				' . $permissao4 . '
				' . $permissao5 . '
				' . $permissao6 . '
				' . $permissao7 . '
				' . $permissao10 . '
				' . $permissao11 . '
				' . $permissao13 . '
				' . $permissao30 . '
				' . $permissao31 . '
				' . $permissao32 . '
				' . $permissao33 . '
				' . $permissao34 . '
				' . $permissao35 . '
				' . $permissao36 . '
				PR.idSis_Empresa = ' . $data . '
			ORDER BY
				' . $permissao60 . '
				' . $permissao61 . ' 
		');
        $query = $query->result_array();
          
        return $query;
    }	
	
    public function get_alterarparceladesp($data) {

        if ($_SESSION['FiltroAlteraParcela']['DataFim']) {
            $consulta =
                '(OT.DataOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '" AND OT.DataOrca  <= "' . $_SESSION['FiltroAlteraParcela']['DataFim'] . '")';
		}
        else {
            $consulta =
                '(OT.DataOrca  >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '")';
        }

        if ($_SESSION['FiltroAlteraParcela']['DataFim2']) {
            $consulta2 =
                '(OT.DataEntregaOrca  >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio2'] . '" AND OT.DataEntregaOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(OT.DataEntregaOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio2'] . '")';
        }
		#$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;		
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND PR.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;

		$date_inicio_orca = ($_SESSION['FiltroAlteraParcela']['DataInicio']) ? 'OT.DataOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '" AND ' : FALSE;
		$date_fim_orca = ($_SESSION['FiltroAlteraParcela']['DataFim']) ? 'OT.DataOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim'] . '" AND ' : FALSE;

		$date_inicio_entrega = ($_SESSION['FiltroAlteraParcela']['DataInicio2']) ? 'OT.DataEntregaOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio2'] . '" AND ' : FALSE;
		$date_fim_entrega = ($_SESSION['FiltroAlteraParcela']['DataFim2']) ? 'OT.DataEntregaOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim2'] . '" AND ' : FALSE;

		$date_inicio_vnc = ($_SESSION['FiltroAlteraParcela']['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio3'] . '" AND ' : FALSE;
		$date_fim_vnc = ($_SESSION['FiltroAlteraParcela']['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim3'] . '" AND ' : FALSE;
		
		$date_inicio_vnc_prc = ($_SESSION['FiltroAlteraParcela']['DataInicio4']) ? 'PR.DataVencimento >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio4'] . '" AND ' : FALSE;
		$date_fim_vnc_prc = ($_SESSION['FiltroAlteraParcela']['DataFim4']) ? 'PR.DataVencimento <= "' . $_SESSION['FiltroAlteraParcela']['DataFim4'] . '" AND ' : FALSE;
		
		$permissao30 = ($_SESSION['FiltroAlteraParcela']['Orcamento'] != "" ) ? 'OT.idApp_OrcaTrata = "' . $_SESSION['FiltroAlteraParcela']['Orcamento'] . '" AND ' : FALSE;
		$permissao31 = ($_SESSION['FiltroAlteraParcela']['Fornecedor'] != "" ) ? 'OT.idApp_Fornecedor = "' . $_SESSION['FiltroAlteraParcela']['Fornecedor'] . '" AND ' : FALSE;
		$permissao13 = ($_SESSION['FiltroAlteraParcela']['CombinadoFrete'] != "0" ) ? 'OT.CombinadoFrete = "' . $_SESSION['FiltroAlteraParcela']['CombinadoFrete'] . '" AND ' : FALSE;
		$permissao1 = ($_SESSION['FiltroAlteraParcela']['AprovadoOrca'] != "0" ) ? 'OT.AprovadoOrca = "' . $_SESSION['FiltroAlteraParcela']['AprovadoOrca'] . '" AND ' : FALSE;
		$permissao3 = ($_SESSION['FiltroAlteraParcela']['ConcluidoOrca'] != "0" ) ? 'OT.ConcluidoOrca = "' . $_SESSION['FiltroAlteraParcela']['ConcluidoOrca'] . '" AND ' : FALSE;
		$permissao2 = ($_SESSION['FiltroAlteraParcela']['QuitadoOrca'] != "0" ) ? 'OT.QuitadoOrca = "' . $_SESSION['FiltroAlteraParcela']['QuitadoOrca'] . '" AND ' : FALSE;
		$permissao4 = ($_SESSION['FiltroAlteraParcela']['Quitado'] != "0" ) ? 'PR.Quitado = "' . $_SESSION['FiltroAlteraParcela']['Quitado'] . '" AND ' : FALSE;
		$permissao10 = ($_SESSION['FiltroAlteraParcela']['FinalizadoOrca'] != "0" ) ? 'OT.FinalizadoOrca = "' . $_SESSION['FiltroAlteraParcela']['FinalizadoOrca'] . '" AND ' : FALSE;
		$permissao11 = ($_SESSION['FiltroAlteraParcela']['CanceladoOrca'] != "0" ) ? 'OT.CanceladoOrca = "' . $_SESSION['FiltroAlteraParcela']['CanceladoOrca'] . '" AND ' : FALSE;
		
		$permissao7 = ($_SESSION['FiltroAlteraParcela']['Tipo_Orca'] != "0" ) ? 'OT.Tipo_Orca = "' . $_SESSION['FiltroAlteraParcela']['Tipo_Orca'] . '" AND ' : FALSE;
		$permissao33 = ($_SESSION['FiltroAlteraParcela']['AVAP'] != "0" ) ? 'OT.AVAP = "' . $_SESSION['FiltroAlteraParcela']['AVAP'] . '" AND ' : FALSE;
		$permissao34 = ($_SESSION['FiltroAlteraParcela']['TipoFrete'] != "0" ) ? 'OT.TipoFrete = "' . $_SESSION['FiltroAlteraParcela']['TipoFrete'] . '" AND ' : FALSE;
		$permissao5 = ($_SESSION['FiltroAlteraParcela']['Modalidade'] != "0" ) ? 'OT.Modalidade = "' . $_SESSION['FiltroAlteraParcela']['Modalidade'] . '" AND ' : FALSE;
		$permissao6 = ($_SESSION['FiltroAlteraParcela']['FormaPagamento'] != "0" ) ? 'OT.FormaPagamento = "' . $_SESSION['FiltroAlteraParcela']['FormaPagamento'] . '" AND ' : FALSE;
		//$permissao32 = ($_SESSION['FiltroAlteraParcela']['TipoFinanceiroD'] != "0" ) ? 'OT.TipoFinanceiro = "' . $_SESSION['FiltroAlteraParcela']['TipoFinanceiroD'] . '" AND ' : FALSE;
		
		$permissao26 = ($_SESSION['FiltroAlteraParcela']['Mesvenc'] != "0" ) ? 'MONTH(PR.DataVencimento) = "' . $_SESSION['FiltroAlteraParcela']['Mesvenc'] . '" AND ' : FALSE;
		$permissao27 = ($_SESSION['FiltroAlteraParcela']['Ano'] != "0" ) ? 'YEAR(PR.DataVencimento) = "' . $_SESSION['FiltroAlteraParcela']['Ano'] . '" AND ' : FALSE;
		$permissao25 = ($_SESSION['FiltroAlteraParcela']['Orcarec'] != "0" ) ? 'OT.idApp_OrcaTrata = "' . $_SESSION['FiltroAlteraParcela']['Orcarec'] . '" AND ' : FALSE;
		//$permissao5 = (($_SESSION['log']['idSis_Empresa'] != 5) && ($_SESSION['FiltroAlteraParcela']['NomeFornecedor'] != "0" )) ? 'OT.idApp_Fornecedor = "' . $_SESSION['FiltroAlteraParcela']['NomeFornecedor'] . '" AND ' : FALSE;
		
		$query = $this->db->query('
			SELECT
				C.NomeFornecedor,
				OT.idApp_OrcaTrata,
				OT.idSis_Usuario,
				OT.Descricao,
				OT.TipoFinanceiro,
				OT.AprovadoOrca,
				OT.ConcluidoOrca,
				OT.QuitadoOrca,
				OT.FinalizadoOrca,
				OT.CanceladoOrca,
				OT.CombinadoFrete,
				OT.AVAP,
				OT.TipoFrete,
				OT.Modalidade,
				DATE_FORMAT(OT.DataOrca, "%d/%m/%Y") AS DataOrca,
				TR.TipoFinanceiro,
				
				E.NomeEmpresa,
				PR.idSis_Usuario,
				CONCAT(PR.idSis_Empresa, "-", E.NomeEmpresa) AS idSis_Empresa,
				PR.idApp_Parcelas,
				PR.Parcela,
				PR.idApp_OrcaTrata,
				CONCAT(IFNULL(PR.idApp_OrcaTrata,""), "--", IFNULL(TR.TipoFinanceiro,""), "--", IFNULL(C.NomeFornecedor,""), "--", IFNULL(OT.Descricao,"")) AS Despesa,
				PR.ValorParcela,
				PR.DataVencimento,
				PR.ValorPago,
				PR.DataPago,
				PR.Quitado				
			FROM 
				App_Parcelas AS PR
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN App_Fornecedor AS C ON C.idApp_Fornecedor = OT.idApp_Fornecedor
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = PR.idSis_Empresa
			WHERE 
				' . $permissao . '
                ' . $date_inicio_orca . '
                ' . $date_fim_orca . '
                ' . $date_inicio_entrega . '
                ' . $date_fim_entrega . '
                ' . $date_inicio_vnc . '
                ' . $date_fim_vnc . '
                ' . $date_inicio_vnc_prc . '
                ' . $date_fim_vnc_prc . '
				OT.idSis_Empresa = ' . $data . ' AND
				OT.idTab_TipoRD = "1" AND
				
				PR.idSis_Empresa = ' . $data . ' AND		
				' . $permissao1 . '
				' . $permissao2 . '
				' . $permissao3 . '
				' . $permissao4 . '
				' . $permissao5 . '
				' . $permissao6 . '
				' . $permissao7 . '
				' . $permissao10 . '
				' . $permissao11 . '
				' . $permissao13 . '
				' . $permissao30 . '
				' . $permissao31 . '
				' . $permissao33 . '
				' . $permissao34 . '
				PR.idTab_TipoRD = "1"
			ORDER BY
				C.NomeFornecedor ASC,
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
		$query = $this->db->query('
			SELECT 
				PC.*,
				US.*
			FROM 
				App_Procedimento AS PC
					LEFT JOIN Sis_Usuario AS US ON US.idSis_Usuario = PC.idSis_Usuario
			WHERE 
				PC.idApp_OrcaTrata = ' . $data . '
		');
        $query = $query->result_array();

        return $query;
    }
	
    public function get_procedimento_posterior($data) {
		$query = $this->db->query('SELECT * FROM App_Procedimento WHERE idApp_OrcaTrata = ' . $data . ' AND ConcluidoProcedimento = "N"');
        $query = $query->result_array();

        return $query;
    }
	
    public function get_procedimento_baixa($data) {
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
				P.HoraProcedimento,
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
				P.HoraProcedimento,				
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

    public function list_orcamentocomb($id, $combinado, $completo) {

        $query = $this->db->query('SELECT '
            . 'OT.idApp_OrcaTrata, '
			. 'OT.idSis_Empresa, '
            . 'OT.DataOrca, '
            . 'OT.DataEntregaOrca, '
            . 'OT.DataVencimentoOrca, '
			. 'OT.DataPrazo, '
			. 'OT.DataConclusao, '
			. 'OT.DataQuitado, '
            . 'OT.ProfissionalOrca, '
            . 'OT.AprovadoOrca, '
			. 'OT.ConcluidoOrca, '
			. 'OT.QuitadoOrca, '
			. 'OT.FinalizadoOrca, '
			. 'OT.CanceladoOrca, '
			. 'OT.CombinadoFrete, '
            . 'OT.ObsOrca '
            . 'FROM '
            . 'App_OrcaTrata AS OT '
            . 'WHERE '
			. 'OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND '
			. 'OT.idApp_Cliente = ' . $id . ' AND '
			. 'OT.idTab_TipoRD = "2" AND '
            . 'OT.CombinadoFrete = "' . $combinado . '" AND '
            
            . 'OT.FinalizadoOrca = "N" AND '
			. 'OT.CanceladoOrca = "N" '
            . 'ORDER BY '
			. 'OT.DataOrca DESC, '
			. 'OT.DataEntregaOrca DESC, '
			. 'OT.DataVencimentoOrca DESC ');
        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */
        
            if ($completo === FALSE) {
                return TRUE;
            } else {

                foreach ($query->result() as $row) {
					$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
					$row->DataEntregaOrca = $this->basico->mascara_data($row->DataEntregaOrca, 'barras');
					$row->DataVencimentoOrca = $this->basico->mascara_data($row->DataVencimentoOrca, 'barras');
					$row->DataPrazo = $this->basico->mascara_data($row->DataPrazo, 'barras');
					$row->DataConclusao = $this->basico->mascara_data($row->DataConclusao, 'barras');
					$row->DataQuitado = $this->basico->mascara_data($row->DataQuitado, 'barras');
                    $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
					$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
					$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
					$row->FinalizadoOrca = $this->basico->mascara_palavra_completa($row->FinalizadoOrca, 'NS');
					$row->CanceladoOrca = $this->basico->mascara_palavra_completa($row->CanceladoOrca, 'NS');
					$row->CombinadoFrete = $this->basico->mascara_palavra_completa($row->CombinadoFrete, 'NS');
                    #$row->ProfissionalOrca = $this->get_profissional($row->ProfissionalOrca);
                }
                return $query;
            }
        
    }
	
    public function list_orcamento($id, $aprovado, $completo) {

        $query = $this->db->query('SELECT '
            . 'OT.idApp_OrcaTrata, '
			. 'OT.idSis_Empresa, '
            . 'OT.DataOrca, '
            . 'OT.DataEntregaOrca, '
            . 'OT.DataVencimentoOrca, '
			. 'OT.DataPrazo, '
			. 'OT.DataConclusao, '
			. 'OT.DataQuitado, '
            . 'OT.ProfissionalOrca, '
			. 'OT.CombinadoFrete, '
            . 'OT.AprovadoOrca, '
			. 'OT.ConcluidoOrca, '
			. 'OT.QuitadoOrca, '
			. 'OT.FinalizadoOrca, '
			. 'OT.CanceladoOrca, '
            . 'OT.ObsOrca '
            . 'FROM '
            . 'App_OrcaTrata AS OT '
            . 'WHERE '
			. 'OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND '
			. 'OT.idApp_Cliente = ' . $id . ' AND '
			. 'OT.idTab_TipoRD = "2" AND '
            . 'OT.CombinadoFrete = "S" AND '
            . 'OT.AprovadoOrca = "' . $aprovado . '" AND '
            . 'OT.FinalizadoOrca = "N" AND '
			. 'OT.CanceladoOrca = "N" '
            . 'ORDER BY '
			. 'OT.DataOrca DESC, '
			. 'OT.DataEntregaOrca DESC, '
			. 'OT.DataVencimentoOrca DESC ');
        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */
       
            if ($completo === FALSE) {
                return TRUE;
            } else {

                foreach ($query->result() as $row) {
					$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
					$row->DataEntregaOrca = $this->basico->mascara_data($row->DataEntregaOrca, 'barras');
					$row->DataVencimentoOrca = $this->basico->mascara_data($row->DataVencimentoOrca, 'barras');
					$row->DataPrazo = $this->basico->mascara_data($row->DataPrazo, 'barras');
					$row->DataConclusao = $this->basico->mascara_data($row->DataConclusao, 'barras');
					$row->DataQuitado = $this->basico->mascara_data($row->DataQuitado, 'barras');
                    $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
					$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
					$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
					$row->FinalizadoOrca = $this->basico->mascara_palavra_completa($row->FinalizadoOrca, 'NS');
					$row->CanceladoOrca = $this->basico->mascara_palavra_completa($row->CanceladoOrca, 'NS');
                    #$row->ProfissionalOrca = $this->get_profissional($row->ProfissionalOrca);
                }
                return $query;
            }
        
    }

    public function list_orcamentofinal($id, $finalizado, $completo) {

        $query = $this->db->query('SELECT '
            . 'OT.idApp_OrcaTrata, '
			. 'OT.idSis_Empresa, '
            . 'OT.DataOrca, '
            . 'OT.DataEntregaOrca, '
            . 'OT.DataVencimentoOrca, '
			. 'OT.DataPrazo, '
			. 'OT.DataConclusao, '
			. 'OT.DataQuitado, '
            . 'OT.ProfissionalOrca, '
            . 'OT.AprovadoOrca, '
			. 'OT.ConcluidoOrca, '
			. 'OT.QuitadoOrca, '
			. 'OT.FinalizadoOrca, '
			. 'OT.CanceladoOrca, '
            . 'OT.ObsOrca '
            . 'FROM '
            . 'App_OrcaTrata AS OT '
            . 'WHERE '
			. 'OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND '
			. 'OT.idApp_Cliente = ' . $id . ' AND '
			. 'OT.idTab_TipoRD = "2" AND '
            . 'OT.FinalizadoOrca = "' . $finalizado . '" AND '
			. 'OT.CanceladoOrca = "N" '
            . 'ORDER BY '
			. 'OT.DataOrca DESC, '
			. 'OT.DataEntregaOrca DESC, '
			. 'OT.DataVencimentoOrca DESC ');
        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */
        
            if ($completo === FALSE) {
                return TRUE;
            } else {

                foreach ($query->result() as $row) {
					$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
					$row->DataEntregaOrca = $this->basico->mascara_data($row->DataEntregaOrca, 'barras');
					$row->DataVencimentoOrca = $this->basico->mascara_data($row->DataVencimentoOrca, 'barras');
					$row->DataPrazo = $this->basico->mascara_data($row->DataPrazo, 'barras');
					$row->DataConclusao = $this->basico->mascara_data($row->DataConclusao, 'barras');
					$row->DataQuitado = $this->basico->mascara_data($row->DataQuitado, 'barras');
                    $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
					$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
					$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
					$row->FinalizadoOrca = $this->basico->mascara_palavra_completa($row->FinalizadoOrca, 'NS');
					$row->CanceladoOrca = $this->basico->mascara_palavra_completa($row->CanceladoOrca, 'NS');
                    #$row->ProfissionalOrca = $this->get_profissional($row->ProfissionalOrca);
                }
                return $query;
            }
        
    }

    public function list_orcamentocancel($id, $cancelado, $completo) {

        $query = $this->db->query('SELECT '
            . 'OT.idApp_OrcaTrata, '
			. 'OT.idSis_Empresa, '
            . 'OT.DataOrca, '
            . 'OT.DataEntregaOrca, '
            . 'OT.DataVencimentoOrca, '
			. 'OT.DataPrazo, '
			. 'OT.DataConclusao, '
			. 'OT.DataQuitado, '
            . 'OT.ProfissionalOrca, '
            . 'OT.AprovadoOrca, '
			. 'OT.ConcluidoOrca, '
			. 'OT.QuitadoOrca, '
			. 'OT.FinalizadoOrca, '
			. 'OT.CanceladoOrca, '
            . 'OT.ObsOrca '
            . 'FROM '
            . 'App_OrcaTrata AS OT '
            . 'WHERE '
			. 'OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND '
			. 'OT.idApp_Cliente = ' . $id . ' AND '
			. 'OT.idTab_TipoRD = "2" AND '
            . 'OT.CanceladoOrca = "' . $cancelado . '" '
            . 'ORDER BY '
			. 'OT.DataOrca DESC, '
			. 'OT.DataEntregaOrca DESC, '
			. 'OT.DataVencimentoOrca DESC ');
        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
          */
       
            if ($completo === FALSE) {
                return TRUE;
            } else {

                foreach ($query->result() as $row) {
					$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
					$row->DataEntregaOrca = $this->basico->mascara_data($row->DataEntregaOrca, 'barras');
					$row->DataVencimentoOrca = $this->basico->mascara_data($row->DataVencimentoOrca, 'barras');
					$row->DataPrazo = $this->basico->mascara_data($row->DataPrazo, 'barras');
					$row->DataConclusao = $this->basico->mascara_data($row->DataConclusao, 'barras');
					$row->DataQuitado = $this->basico->mascara_data($row->DataQuitado, 'barras');
                    $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
					$row->ConcluidoOrca = $this->basico->mascara_palavra_completa($row->ConcluidoOrca, 'NS');
					$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
					$row->FinalizadoOrca = $this->basico->mascara_palavra_completa($row->FinalizadoOrca, 'NS');
					$row->CanceladoOrca = $this->basico->mascara_palavra_completa($row->CanceladoOrca, 'NS');
                    #$row->ProfissionalOrca = $this->get_profissional($row->ProfissionalOrca);
                }
                return $query;
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

    public function update_fornecedor($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('App_Fornecedor', $data, array('idApp_Fornecedor' => $id));
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

        $query = $this->db->update_batch('App_Produto', $data, 'idApp_Produto');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_produto($data) {

        $query = $this->db->update_batch('App_Produto', $data, 'idApp_Produto');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_produto_id($data, $id) {

        unset($data['idApp_Produto']);
        $query = $this->db->update('App_Produto', $data, array('idApp_Produto' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_parcelas($data) {

        $query = $this->db->update_batch('App_Parcelas', $data, 'idApp_Parcelas');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }
	
    public function update_parcela($data, $id) {

        unset($data['idApp_Parcelas']);
        $query = $this->db->update('App_Parcelas', $data, array('idApp_Parcelas' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }
	
    public function update_parcelas_id($data, $id) {

        unset($data['idApp_Parcelas']);
        $query = $this->db->update('App_Parcelas', $data, array('idApp_Parcelas' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }	
	
    public function update_comissao($data) {

        $query = $this->db->update_batch('App_OrcaTrata', $data, 'idApp_OrcaTrata');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }	
	
    public function update_procedimento($data) {

        $query = $this->db->update_batch('App_Procedimento', $data, 'idApp_Procedimento');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_procedimento_id($data, $id) {

        unset($data['idApp_Procedimento']);
        $query = $this->db->update('App_Procedimento', $data, array('idApp_Procedimento' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function delete_servico($data) {

        $this->db->where_in('idApp_Produto', $data);
        $this->db->delete('App_Produto');

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
	
    public function delete_comissao($data) {

        $this->db->where_in('idApp_OrcaTrata', $data);
        $this->db->delete('App_OrcaTrata');

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
