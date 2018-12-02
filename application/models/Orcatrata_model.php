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
		
		$query = $this->db->query('
			SELECT
				
				OT.Receitas,
				OT.TipoReceita,
				TD.TipoDespesa,
				CONCAT(IFNULL(PR.idApp_OrcaTrata,""), "-", IFNULL(OT.Receitas,"")) AS idApp_OrcaTrata,
				E.NomeEmpresa,
				CONCAT(PR.idSis_Empresa, "-", E.NomeEmpresa) AS idSis_Empresa,
				PR.idSis_Usuario,
				PR.idApp_Parcelas,
				CONCAT(IFNULL(PR.Parcela,""), "--", IFNULL(TD.TipoDespesa,""), "--", IFNULL(OT.Receitas,"")) AS Parcela,
				PR.ValorParcela,
				PR.DataVencimento,
				PR.ValorPago,
				PR.DataPago,
				PR.Quitado
			FROM 
				App_Parcelas AS PR
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN Tab_TipoDespesa AS TD ON TD.idTab_TipoDespesa = OT.TipoReceita
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = PR.idSis_Empresa
			WHERE 
				' . $permissao . '
				PR.idSis_Empresa = ' . $data . ' AND
				PR.idTab_TipoRD = "1" AND
				(MONTH(PR.DataVencimento) = "11") AND
				(YEAR(PR.DataVencimento) = "2018") AND
				PR.Quitado = "N"
			ORDER BY
				PR.DataVencimento  
		');
        $query = $query->result_array();

        return $query;
    }	

    public function get_alterarparcelarec($data) {
		
		#$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $data['Mesvenc'] : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'PR.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND ' : FALSE;
		
		$query = $this->db->query('
			SELECT
				C.NomeCliente,
				OT.Receitas,
				OT.TipoReceita,
				TR.TipoReceita,
				CONCAT(IFNULL(PR.idApp_OrcaTrata,""), "-", IFNULL(OT.Receitas,"")) AS idApp_OrcaTrata,
				E.NomeEmpresa,
				PR.idSis_Usuario,
				CONCAT(PR.idSis_Empresa, "-", E.NomeEmpresa) AS idSis_Empresa,
				PR.idApp_Parcelas,
				CONCAT(IFNULL(PR.Parcela,""), "--", IFNULL(TR.TipoReceita,""), "--", IFNULL(C.NomeCliente,""), "--", IFNULL(OT.Receitas,"")) AS Parcela,
				PR.ValorParcela,
				PR.DataVencimento,
				PR.ValorPago,
				PR.DataPago,
				PR.Quitado
			FROM 
				App_Parcelas AS PR
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN Tab_TipoReceita AS TR ON TR.idTab_TipoReceita = OT.TipoReceita
					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = PR.idSis_Empresa
			WHERE 
				' . $permissao . '
				PR.idSis_Empresa = ' . $data . ' AND
				PR.idTab_TipoRD = "2" AND
				(MONTH(PR.DataVencimento) = "11") AND
				(YEAR(PR.DataVencimento) = "2018") AND
				PR.Quitado = "N"
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
		
		$query = $this->db->query('
			SELECT
				
				U.CpfUsuario,
				P.idSis_Usuario,
				P.idSis_Empresa,
				P.idApp_Procedimento,
                P.Procedimento,
				P.DataProcedimento,
				P.ConcluidoProcedimento
            FROM
				App_Procedimento AS P
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = P.idSis_Usuario
			WHERE 

				((P.idSis_Empresa = ' . $data . '  AND
				U.CpfUsuario = ' . $_SESSION['log']['CpfUsuario'] . ' ) OR
				U.CpfUsuario = ' . $_SESSION['log']['CpfUsuario'] . ' )AND
				P.ConcluidoProcedimento = "N" AND 
				P.idApp_OrcaTrata = "0" AND
				P.idApp_Cliente = "0" 
		');
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
			. 'OT.ServicoConcluido, '
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
			. 'OT.ServicoConcluido ASC, '
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
					$row->ServicoConcluido = $this->basico->mascara_palavra_completa($row->ServicoConcluido, 'NS');
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
