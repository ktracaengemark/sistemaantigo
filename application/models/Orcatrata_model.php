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

        $query = $this->db->insert_batch('App_ServicoVenda', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_produto_venda($data) {

        $query = $this->db->insert_batch('App_ProdutoVenda', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_parcelasrec($data) {

        $query = $this->db->insert_batch('App_ParcelasRecebiveis', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_parcelasrecalterar($data) {

        $query = $this->db->insert_batch('App_ParcelasRecebiveis', $data);

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
        $query = $this->db->query('SELECT * FROM App_OrcaTrata WHERE TipoRD = "D" AND idApp_OrcaTrata = ' . $data);
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

    public function get_orcatrataparceladesp($data) {
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
		$query = $this->db->query('SELECT * FROM App_ServicoVenda WHERE idApp_OrcaTrata = ' . $data);
        $query = $query->result_array();

        return $query;
    }

	public function get_servicodesp($data) {
		$query = $this->db->query('SELECT * FROM App_ServicoVenda WHERE TipoProduto = "CONS" AND idApp_OrcaTrata = ' . $data);
        $query = $query->result_array();

        return $query;
    }
	
    public function get_produto($data) {
		$query = $this->db->query('SELECT * FROM App_ProdutoVenda WHERE idApp_OrcaTrata = ' . $data);
        $query = $query->result_array();

        return $query;
    }

    public function get_produtodesp($data) {
		$query = $this->db->query('SELECT * FROM App_ProdutoVenda WHERE TipoProduto = "COMP" AND idApp_OrcaTrata = ' . $data);
        $query = $query->result_array();

        return $query;
    }
	
    public function get_parcelasrec($data) {
		$query = $this->db->query('SELECT * FROM App_ParcelasRecebiveis WHERE idApp_OrcaTrata = ' . $data);
        $query = $query->result_array();

        return $query;
    }

    public function get_parcelasrecdesp($data) {
		$query = $this->db->query('SELECT * FROM App_ParcelasRecebiveis WHERE TipoRD = "D" AND idApp_OrcaTrata = ' . $data);
        $query = $query->result_array();

        return $query;
    }

    public function get_parcelasrecparceladesp1($data) {
		$query = $this->db->query('
			SELECT * 
			FROM 
				App_ParcelasRecebiveis 
			WHERE 
				idSis_Empresa = ' . $data . ' AND
				TipoRD = "D" AND
				(MONTH(DataVencimentoRecebiveis) = "08") AND
				(YEAR(DataVencimentoRecebiveis) = "2018") AND
				QuitadoRecebiveis = "N"  
			');
        $query = $query->result_array();

        return $query;
    }
	
    public function get_parcelasrecparceladesp($data) {
		
		#$data['Mesvenc'] = ($data['Mesvenc']) ? ' AND MONTH(PR.DataVencimentoRecebiveis) = ' . $data['Mesvenc'] : FALSE;
		
		$query = $this->db->query('
			SELECT
				OT.Receitas,
				OT.TipoReceita,
				CONCAT(IFNULL(PR.idApp_OrcaTrata,""), "-", IFNULL(OT.Receitas,"")) AS idApp_OrcaTrata,
				E.NomeEmpresa,
				CONCAT(PR.idSis_Empresa, "-", E.NomeEmpresa) AS idSis_Empresa,
				PR.idApp_ParcelasRecebiveis,
				CONCAT(IFNULL(PR.ParcelaRecebiveis,""), "--", IFNULL(OT.Receitas,""), "-", IFNULL(PR.idApp_OrcaTrata,"")) AS ParcelaRecebiveis,
				PR.ValorParcelaRecebiveis,
				PR.DataVencimentoRecebiveis,
				PR.ValorPagoRecebiveis,
				PR.DataPagoRecebiveis,
				PR.QuitadoRecebiveis
			FROM 
				App_ParcelasRecebiveis AS PR
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = PR.idApp_OrcaTrata

					LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = PR.idSis_Empresa
			WHERE 
				PR.idSis_Empresa = ' . $data . ' AND
				(MONTH(PR.DataVencimentoRecebiveis) = "10") AND
				(YEAR(PR.DataVencimentoRecebiveis) = "2018") AND
				PR.QuitadoRecebiveis = "N"
			ORDER BY
				PR.DataVencimentoRecebiveis  
		');
        $query = $query->result_array();

        return $query;
    }	
		
    public function get_procedimento($data) {
		$query = $this->db->query('SELECT * FROM App_Procedimento WHERE idApp_OrcaTrata = ' . $data);
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
			. 'OT.TipoRD = "R" AND '
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
	
    public function update_orcatrataparceladesp($data, $id) {

        unset($data['idSis_Empresa']);
        $query = $this->db->update('Sis_Empresa', $data, array('idSis_Empresa' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }	
	
    public function update_servico_venda($data) {

        $query = $this->db->update_batch('App_ServicoVenda', $data, 'idApp_ServicoVenda');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_produto_venda($data) {

        $query = $this->db->update_batch('App_ProdutoVenda', $data, 'idApp_ProdutoVenda');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_parcelasrec($data) {

        $query = $this->db->update_batch('App_ParcelasRecebiveis', $data, 'idApp_ParcelasRecebiveis');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }
	
    public function update_procedimento($data) {

        $query = $this->db->update_batch('App_Procedimento', $data, 'idApp_Procedimento');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function delete_servico_venda($data) {

        $this->db->where_in('idApp_ServicoVenda', $data);
        $this->db->delete('App_ServicoVenda');

        //$query = $this->db->delete('App_ServicoVenda', array('idApp_ServicoVenda' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_produto_venda($data) {

        $this->db->where_in('idApp_ProdutoVenda', $data);
        $this->db->delete('App_ProdutoVenda');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_parcelasrec($data) {

        $this->db->where_in('idApp_ParcelasRecebiveis', $data);
        $this->db->delete('App_ParcelasRecebiveis');

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
        $tables = array('App_ServicoVenda', 'App_ProdutoVenda', 'App_ParcelasRecebiveis', 'App_Procedimento', 'App_OrcaTrata');
        $this->db->where('idApp_Orcatrata', $id);
        $this->db->delete($tables);
        */

        $query = $this->db->delete('App_ServicoVenda', array('idApp_Orcatrata' => $id));
        $query = $this->db->delete('App_ProdutoVenda', array('idApp_Orcatrata' => $id));
        $query = $this->db->delete('App_ParcelasRecebiveis', array('idApp_Orcatrata' => $id));
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
