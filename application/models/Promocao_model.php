<?php

#modelo que verifica usu�rio e senha e loga o usu�rio no sistema, criando as sess�es necess�rias

defined('BASEPATH') OR exit('No direct script access allowed');

class Promocao_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

    public function set_promocao($data) {

        $query = $this->db->insert('Tab_Promocao', $data);

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
	
    public function set_item_promocao($data) {

        $query = $this->db->insert_batch('Tab_Valor', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_dia_promocao($data) {

        $query = $this->db->insert('Tab_Dia_Prom', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        }
        else {
            #return TRUE;
            return $this->db->insert_id();
        }

    }	

    public function get_promocao($data) {
        $query = $this->db->query('
			SELECT  
				TPM.*
			FROM 
				Tab_Promocao AS TPM
			WHERE 
				TPM.idTab_Promocao = ' . $data . '
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

	public function get_item_promocao($data, $desconto) {
		$query = $this->db->query('
			SELECT 
				TV.*,
				TPS.Nome_Prod
			FROM 
				Tab_Valor AS TV
					LEFT JOIN Tab_Produtos AS TPS ON TPS.idTab_Produtos = TV.idTab_Produtos
			WHERE 
				TV.idTab_Promocao = ' . $data . '
		');
        $query = $query->result_array();

        return $query;
    }

	public function get_dia_promocao($data, $desconto) {
		$query = $this->db->query('
			SELECT 
				TD.*
			FROM 
				Tab_Dia_Prom AS TD
			WHERE 
				TD.idTab_Promocao = ' . $data . '
		');
        $query = $query->result_array();

        return $query;
    }
	
	public function list_promocoes($data, $x) {

        $query = $this->db->query('
			SELECT 
				TPM.*
			FROM 
				Tab_Promocao AS TPM
			WHERE 
                TPM.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TPM.Desconto = "2"
			ORDER BY
				TPM.Promocao ASC 
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
    
	public function list_itens_promocao($data, $x) {
		
		$data['idTab_Promocao'] = ($data['idTab_Promocao'] != 0) ? ' AND TV.idTab_Promocao = ' . $data['idTab_Promocao'] : FALSE;
			
			/*
			echo "<pre>";
			print_r($data['idTab_Promocao']);
			echo "</pre>";
			exit();
			*/
		
		
        $query = $this->db->query('
			SELECT 
				TV.*,
				TPM.idTab_Promocao,
				TPS.idTab_Produtos,
				TPS.Nome_Prod
			FROM 
				Tab_Valor AS TV
					LEFT JOIN Tab_Promocao AS TPM ON TPM.idTab_Promocao = TV.idTab_Promocao
					LEFT JOIN Tab_Produtos AS TPS ON TPS.idTab_Produtos = TV.idTab_Produtos
			WHERE 
                TV.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
				' . $data['idTab_Promocao'] . '
			ORDER BY  
				TPS.Nome_Prod ASC 
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

    public function lista_promocao($x) {

		#$data['Promocao'] = ($data['Promocao']) ? ' AND TP.idTab_Promocao = ' . $data['Promocao'] : FALSE;
		
        $query = $this->db->query('
			SELECT 
				TP.idTab_Promocao,
				TP.Promocao,
				T3.Prodaux3,
				TV.ValorProduto
			FROM 
				Tab_Promocao AS TP
				 LEFT JOIN Tab_Prodaux3 AS T3 ON T3.idTab_Prodaux3 = TP.Prodaux3
				 LEFT JOIN Tab_Valor AS TV ON TV.idTab_Promocao = TP.idTab_Promocao
				 
			WHERE 
                TP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
                TP.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				TV.idTab_Promocao = TP.idTab_Promocao
			ORDER BY 
				T3.Prodaux3 ASC, 
				TP.Promocao ASC 
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
	
    public function update_promocao($data, $id) {

        unset($data['idTab_Promocao']);
        $query = $this->db->update('Tab_Promocao', $data, array('idTab_Promocao' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_item_promocao($data) {

        $query = $this->db->update_batch('Tab_Valor', $data, 'idTab_Valor');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }	

    public function update_dia_promocao($data) {

        $query = $this->db->update_batch('Tab_Dia_Prom', $data, 'idTab_Dia_Prom');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }	
	
    public function delete_item_promocao($data) {

        $this->db->where_in('idTab_Valor', $data);
        $this->db->delete('Tab_Valor');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
    public function delete_dia_promocao($data) {

        $this->db->where_in('idTab_Dia_Prom', $data);
        $this->db->delete('Tab_Dia_Prom');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
		
    public function delete_promocao($id) {

        $query = $this->db->delete('Tab_Promocao', array('idTab_Promocao' => $id));
        $query = $this->db->delete('Tab_Valor', array('idTab_Promocao' => $id));
        $query = $this->db->delete('Tab_Dia_Prom', array('idTab_Promocao' => $id));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
