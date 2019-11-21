<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Produtos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

    public function set_produtos($data) {

        $query = $this->db->insert('Tab_Produto', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_valor($data) {

        $query = $this->db->insert_batch('Tab_Valor', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }
	
    public function set_valor1($data) {

        $query = $this->db->insert('Tab_Valor', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }	

    public function get_produtos($data) {
        $query = $this->db->query('SELECT * FROM Tab_Produto WHERE idTab_Produto = ' . $data);
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

    public function get_valor($data) {
		$query = $this->db->query('SELECT * FROM Tab_Valor WHERE idTab_Produto = ' . $data);
        $query = $query->result_array();

        return $query;
    }

    public function list_produtos($id, $aprovado, $completo) {

        $query = $this->db->query('
            SELECT
                TF.idTab_Produto,
                TF.TipoProduto,
                TF.Produtos
            FROM
                Tab_Produto AS TF
            WHERE
                TF.idSis_Usuario = ' . $_SESSION['log']['id'] . ' 
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

    public function update_produtos($data, $id) {

        unset($data['idTab_Produto']);
        $query = $this->db->update('Tab_Produto', $data, array('idTab_Produto' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_valor($data) {

        $query = $this->db->update_batch('Tab_Valor', $data, 'idTab_Valor');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }	

    public function delete_valor($data) {

        $this->db->where_in('idTab_Valor', $data);
        $this->db->delete('Tab_Valor');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_produtos($id) {


        $query = $this->db->delete('Tab_Valor', array('idTab_Produto' => $id));
        $query = $this->db->delete('Tab_Produto', array('idTab_Produto' => $id));

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
	
	public function select_produtos($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
            'SELECT
                TPV.idTab_Produto,
				CONCAT(IFNULL(TPV.CodProd,""), " -- ", IFNULL(TP3.Prodaux3,""), " -- ", IFNULL(TPV.Produtos,""), " -- ", IFNULL(TP1.Prodaux1,""), " -- ", IFNULL(TP2.Prodaux2,""), " -- ", IFNULL(TPV.UnidadeProduto,""), " -- ", IFNULL(TFO.NomeFornecedor,"")) AS NomeProduto,
				TPV.ValorCompraProduto,
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
        } else {
            $query = $this->db->query(
            'SELECT
                TPV.idTab_Produto,
				CONCAT(IFNULL(TPV.CodProd,""), " -- ", IFNULL(TP3.Prodaux3,""), " -- ", IFNULL(TPV.Produtos,""), " -- ", IFNULL(TP1.Prodaux1,""), " -- ", IFNULL(TP2.Prodaux2,""), " -- ", IFNULL(TPV.UnidadeProduto,""), " -- ", IFNULL(TFO.NomeFornecedor,"")) AS NomeProduto,
				TPV.ValorCompraProduto,
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

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Produto] = $row->NomeProduto;
            }
        }

        return $array;
    }	

}
