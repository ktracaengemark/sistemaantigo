<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Atributo_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

    public function set_atributo($data) {

        $query = $this->db->insert('Tab_Atributo', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_arquivo($data) {

        $query = $this->db->insert('Sis_Arquivo', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        }
        else {
            #return TRUE;
            return $this->db->insert_id();
        }

    }

    public function set_opcao($data) {

        $query = $this->db->insert_batch('Tab_Opcao', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }
	
    public function set_atributo2($data) {

        $query = $this->db->insert_batch('Tab_Atributo', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }	
	
    public function set_atributo1($data) {

        $query = $this->db->insert('Tab_Atributo', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }	

    public function set_produto($data) {

        $query = $this->db->insert_batch('Tab_Cor_Prod', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }
	
    public function set_procedimento($data) {

        $query = $this->db->insert_batch('Tab_Tam_Prod', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }	
	
    public function get_atributo($data) {
        $query = $this->db->query('SELECT * FROM Tab_Atributo WHERE idTab_Atributo = ' . $data);
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

	public function get_opcao($data) {
		$query = $this->db->query('
			SELECT * 
			FROM 
				Tab_Opcao 
			WHERE 
				idTab_Atributo = ' . $data . ' 
		');
        $query = $query->result_array();

        return $query;
    }
	
	public function get_atributo1($data, $item) {
		$query = $this->db->query('
			SELECT * 
			FROM 
				Tab_Atributo 
			WHERE 
				idTab_Atributo = ' . $data . ' AND
				Item_Atributo = '. $item . '
		');
        $query = $query->result_array();

        return $query;
    }
	
    public function get_atributo2($data, $item) {
		$query = $this->db->query('
			SELECT * 
			FROM 
				Tab_Atributo 
			WHERE 
				idTab_Atributo = ' . $data . ' AND
				Item_Atributo = '. $item . '
		');
        $query = $query->result_array();

        return $query;
    }	

    public function list_atributo1($id, $aprovado, $completo) {

        $query = $this->db->query('
            SELECT
                TF.idTab_Atributo,
                TF.TipoProduto,
                TF.Atributo
            FROM
                Tab_Atributo AS TF
            WHERE
                TF.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' 
            ORDER BY
                TF.TipoProduto ASC
				
        ');
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

                    $row->TipoProduto = $this->get_tipoproduto($row->TipoProduto);
                }
                return $query;
            }
        }
    }

    public function lista_atributo($x) {

		#$data['Atributo'] = ($data['Atributo']) ? ' AND TP.idTab_Atributo = ' . $data['Atributo'] : FALSE;
		
        $query = $this->db->query('
			SELECT 
				TP.idTab_Atributo,
				TP.Atributo,
				T3.Prodaux3,
				TV.AtributoProduto
			FROM 
				Tab_Atributo AS TP
				 LEFT JOIN Tab_Prodaux3 AS T3 ON T3.idTab_Prodaux3 = TP.Prodaux3
				 LEFT JOIN Tab_Atributo AS TV ON TV.idTab_Atributo = TP.idTab_Atributo
				 
			WHERE 
                TP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TP.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				TV.idTab_Atributo = TP.idTab_Atributo
			ORDER BY 
				T3.Prodaux3 ASC, 
				TP.Atributo ASC 
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
	
    public function update_atributo($data, $id) {

        unset($data['idTab_Atributo']);
        $query = $this->db->update('Tab_Atributo', $data, array('idTab_Atributo' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_atributo3($data) {

        $query = $this->db->update_batch('Tab_Atributo', $data, 'idTab_Atributo');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }
	
    public function update_opcao($data) {

        $query = $this->db->update_batch('Tab_Opcao', $data, 'idTab_Opcao');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }	

    public function update_atributo2($data) {

        $query = $this->db->update_batch('Tab_Atributo', $data, 'idTab_Atributo');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }	
	
    public function delete_atributo3($data) {

        $this->db->where_in('idTab_Atributo', $data);
        $this->db->delete('Tab_Atributo');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_opcao($data) {

        $this->db->where_in('idTab_Opcao', $data);
        $this->db->delete('Tab_Opcao');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
    public function delete_atributo2($data) {

        $this->db->where_in('idTab_Atributo', $data);
        $this->db->delete('Tab_Atributo');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
    public function delete_atributo($id) {

		$query = $this->db->delete('Tab_Opcao', array('idTab_Atributo' => $id));
        $query = $this->db->delete('Tab_Atributo', array('idTab_Atributo' => $id));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function get_tipoproduto($data) {
		$query = $this->db->query('SELECT TipoProduto FROM Tab_TipoProduto WHERE idTab_TipoProduto = ' . $data);
        $query = $query->result_array();

        return (isset($query[0]['TipoProduto'])) ? $query[0]['TipoProduto'] : FALSE;
    }
	
	public function select_atributo($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
            'SELECT
                TPV.idTab_Atributo,
				CONCAT(IFNULL(TPV.CodProd,""), " -- ", IFNULL(TP3.Prodaux3,""), " -- ", IFNULL(TPV.Atributo,""), " -- ", IFNULL(TP1.Prodaux1,""), " -- ", IFNULL(TP2.Prodaux2,""), " -- ", IFNULL(TPV.UnidadeProduto,""), " -- ", IFNULL(TFO.NomeFornecedor,"")) AS NomeProduto,
				TPV.AtributoCompraProduto,
				TPV.Categoria
            FROM
                Tab_Atributo AS TPV
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
				TPV.Atributo ASC,
				TP1.Prodaux1,
				TP2.Prodaux2 
    ');
        } else {
            $query = $this->db->query(
            'SELECT
                TPV.idTab_Atributo,
				CONCAT(IFNULL(TPV.CodProd,""), " -- ", IFNULL(TP3.Prodaux3,""), " -- ", IFNULL(TPV.Atributo,""), " -- ", IFNULL(TP1.Prodaux1,""), " -- ", IFNULL(TP2.Prodaux2,""), " -- ", IFNULL(TPV.UnidadeProduto,""), " -- ", IFNULL(TFO.NomeFornecedor,"")) AS NomeProduto,
				TPV.AtributoCompraProduto,
				TPV.Categoria
            FROM
                Tab_Atributo AS TPV
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
				TPV.Atributo ASC,
				TP1.Prodaux1,
				TP2.Prodaux2 
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Atributo] = $row->NomeProduto;
            }
        }

        return $array;
    }	
	
	public function select_prodaux33() {

        $query = $this->db->query('
            SELECT
                P.idTab_Prodaux3,
                P.Prodaux3
            FROM
                Tab_Prodaux3 AS P
            WHERE
                P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
            ORDER BY
                Prodaux3 ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_Prodaux3] = $row->Prodaux3;
        }

        return $array;
    }
	
}
