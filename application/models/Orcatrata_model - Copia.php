<?php

#modelo que verifica usu�rio e senha e loga o usu�rio no sistema, criando as sess�es necess�rias

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

    public function set_servico_venda($data) {

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

    public function set_produto_venda($data) {

        $query = $this->db->insert_batch('App_Produto', $data);

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

    public function set_parcelasrec($data) {

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
        $query = $this->db->query('SELECT * FROM App_OrcaTrata WHERE idApp_OrcaTrata = ' . $data);
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
	
    public function get_orcatratadesp($data) {
        $query = $this->db->query('SELECT * FROM App_OrcaTrata WHERE idTab_TipoRD = "1" AND idApp_OrcaTrata = ' . $data);
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

    public function get_orcatratarec($data) {
        $query = $this->db->query('SELECT * FROM App_OrcaTrata WHERE idTab_TipoRD = "2" AND idApp_OrcaTrata = ' . $data);
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
	
	public function get_servico($data) {
		$query = $this->db->query('SELECT * FROM App_Servico WHERE idApp_OrcaTrata = ' . $data);
        $query = $query->result_array();

        return $query;
    }

	public function get_servicodesp($data) {
		$query = $this->db->query('SELECT * FROM App_Servico WHERE idTab_TipoRD = "3" AND idApp_OrcaTrata = ' . $data);
        $query = $query->result_array();

        return $query;
    }
	
    public function get_produto($data) {
		$query = $this->db->query('SELECT * FROM App_Produto WHERE idApp_OrcaTrata = ' . $data);
        $query = $query->result_array();

        return $query;
    }

    public function get_produtodesp($data) {
		$query = $this->db->query('SELECT * FROM App_Produto WHERE idTab_TipoRD = "1" AND idApp_OrcaTrata = ' . $data);
        $query = $query->result_array();

        return $query;
    }

    public function get_parcelas($data) {
		$query = $this->db->query('SELECT * FROM App_Parcelas WHERE idApp_OrcaTrata = ' . $data);
        $query = $query->result_array();

        return $query;
    }
	
    public function get_parcelasrec($data) {
		$query = $this->db->query('SELECT * FROM App_Parcelas WHERE idApp_OrcaTrata = ' . $data);
        $query = $query->result_array();

        return $query;
    }

    public function get_parcelasrecdesp($data) {
		$query = $this->db->query('SELECT * FROM App_Parcelas WHERE idTab_TipoRD = "1" AND idApp_OrcaTrata = ' . $data);
        $query = $query->result_array();

        return $query;
    }
	
	public function get_alterarparceladesp($data) {

		#$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'PR.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND ' : FALSE;
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
				TD.TipoFinanceiro,
				CONCAT(IFNULL(PR.idApp_OrcaTrata,""), "-", IFNULL(OT.Descricao,"")) AS idApp_OrcaTrata,
				E.NomeEmpresa,
				CONCAT(PR.idSis_Empresa, "-", E.NomeEmpresa) AS idSis_Empresa,
				PR.idSis_Usuario,
				PR.idApp_Parcelas,
				CONCAT(IFNULL(PR.Parcela,""), "--", IFNULL(PR.idApp_OrcaTrata,""), "--", IFNULL(TD.TipoFinanceiro,""), "--", IFNULL(OT.Descricao,"")) AS Parcela,
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
				PR.idSis_Empresa = ' . $data . ' AND
				' . $permissao1 . '
				' . $permissao2 . '
				' . $permissao3 . '
				' . $permissao4 . '
				' . $permissao5 . '
				PR.idTab_TipoRD = "1"
			ORDER BY
				PR.DataVencimento
		');
        $query = $query->result_array();

        return $query;
    }
	
    public function get_alterarparcelarec($data) {
		
		#$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'PR.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND ' : FALSE;
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
				TR.TipoFinanceiro,
				CONCAT(IFNULL(PR.idApp_OrcaTrata,""), "-", IFNULL(OT.Descricao,"")) AS idApp_OrcaTrata,
				E.NomeEmpresa,
				PR.idSis_Usuario,
				CONCAT(PR.idSis_Empresa, "-", E.NomeEmpresa) AS idSis_Empresa,
				PR.idApp_Parcelas,
				CONCAT(IFNULL(PR.Parcela,""), "--", IFNULL(PR.idApp_OrcaTrata,""), "--", IFNULL(TR.TipoFinanceiro,""), "--", IFNULL(C.NomeCliente,""), "--", IFNULL(OT.Descricao,"")) AS Parcela,
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
				PR.idSis_Empresa = ' . $data . ' AND
				' . $permissao1 . '
				' . $permissao2 . '
				' . $permissao3 . '
				' . $permissao4 . '
				' . $permissao5 . '				
				PR.idTab_TipoRD = "2" 
			ORDER BY
				PR.DataVencimento  
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
		
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'P.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND ' : FALSE;
		$permissao1 = ($_SESSION['FiltroAlteraProcedimento']['ConcluidoProcedimento'] != '0' ) ? 'P.ConcluidoProcedimento = "' . $_SESSION['FiltroAlteraProcedimento']['ConcluidoProcedimento'] . '" AND ' : FALSE;
		$permissao6 = ($_SESSION['FiltroAlteraProcedimento']['Prioridade'] != '0' ) ? 'P.Prioridade = "' . $_SESSION['FiltroAlteraProcedimento']['Prioridade'] . '" AND ' : FALSE;
		$permissao7 = ($_SESSION['FiltroAlteraProcedimento']['Procedimento'] != '0' ) ? 'P.idApp_Procedimento = "' . $_SESSION['FiltroAlteraProcedimento']['Procedimento'] . '" AND ' : FALSE;
		$permissao2 = ($_SESSION['FiltroAlteraProcedimento']['Mesvenc'] != "0" ) ? 'MONTH(P.DataProcedimento) = "' . $_SESSION['FiltroAlteraProcedimento']['Mesvenc'] . '" AND ' : FALSE;
		$permissao3 = ($_SESSION['FiltroAlteraProcedimento']['Ano'] != "" ) ? 'YEAR(P.DataProcedimento) = "' . $_SESSION['FiltroAlteraProcedimento']['Ano'] . '" AND ' : FALSE;
		$permissao5 = ($_SESSION['FiltroAlteraProcedimento']['Dia'] != "0" ) ? 'DAY(P.DataProcedimento) = "' . $_SESSION['FiltroAlteraProcedimento']['Dia'] . '" AND ' : FALSE;
		
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
				P.Prioridade
            FROM
				App_Procedimento AS P
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = P.idSis_Usuario
			WHERE 

				((P.idSis_Empresa = ' . $data . '  AND
				U.CelularUsuario = ' . $_SESSION['log']['CelularUsuario'] . ' ) OR
				U.CelularUsuario = ' . $_SESSION['log']['CelularUsuario'] . ' )AND
				' . $permissao1 . '
				' . $permissao6 . '
				' . $permissao7 . '
				P.idApp_OrcaTrata = "0" AND
				P.idApp_Cliente = "0" 
			ORDER BY
				P.ConcluidoProcedimento,
				P.Prioridade ASC,
				P.DataProcedimento DESC
		');
        $query = $query->result_array();

        return $query;
    }

    public function get_alterarprocedimentocli($data) {
		
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'P.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND ' : FALSE;
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
		
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'P.idSis_UsuarioCli = ' . $_SESSION['log']['id'] . ' AND ' : FALSE;
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
		
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'P.idSis_UsuarioCli = ' . $_SESSION['log']['id'] . ' AND ' : FALSE;
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

    public function update_orcatrata($data, $id) {

        unset($data['idApp_OrcaTrata']);
        $query = $this->db->update('App_OrcaTrata', $data, array('idApp_OrcaTrata' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }
	
    public function update_orcatrataalterar($data, $id) {

        unset($data['idSis_Empresa']);
        $query = $this->db->update('Sis_Empresa', $data, array('idSis_Empresa' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }
		
    public function update_servico_venda($data) {

        $query = $this->db->update_batch('App_Servico', $data, 'idApp_Servico');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_produto_venda($data) {

        $query = $this->db->update_batch('App_Produto', $data, 'idApp_Produto');
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

    public function update_parcelasrec($data) {

        $query = $this->db->update_batch('App_Parcelas', $data, 'idApp_Parcelas');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }
	
    public function update_procedimento($data) {

        $query = $this->db->update_batch('App_Procedimento', $data, 'idApp_Procedimento');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function delete_servico_venda($data) {

        $this->db->where_in('idApp_Servico', $data);
        $this->db->delete('App_Servico');

        //$query = $this->db->delete('App_Servico', array('idApp_Servico' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_produto_venda($data) {

        $this->db->where_in('idApp_Produto', $data);
        $this->db->delete('App_Produto');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
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

    public function delete_parcelasrec($data) {

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