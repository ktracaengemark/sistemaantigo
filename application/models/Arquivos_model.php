<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Arquivos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

    public function set_arquivos($data) {

        $query = $this->db->insert('App_Arquivos', $data);

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
	
    public function get_arquivos($data) {
        $query = $this->db->query('SELECT * FROM App_Arquivos WHERE idApp_Arquivos = ' . $data);
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

    public function get_orcatrata($data) {
        $query = $this->db->query('
			SELECT 
				OT.*
			FROM 
				App_OrcaTrata AS OT
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
	
    public function update_arquivos($data, $id) {

        unset($data['idApp_Arquivos']);
        $query = $this->db->update('App_Arquivos', $data, array('idApp_Arquivos' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function delete_arquivos($id) {

        $query = $this->db->delete('App_Arquivos', array('idApp_Arquivos' => $id));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
}
