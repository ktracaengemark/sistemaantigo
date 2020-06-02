<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Prodaux4_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }

    public function set_prodaux4($data) {

        $query = $this->db->insert('Tab_Prodaux4', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_prodaux4($data) {
        $query = $this->db->query('SELECT * FROM Tab_Prodaux4 WHERE idTab_Prodaux4 = ' . $data);
        $query = $query->result_array();

        return $query[0];
    }

    public function update_prodaux4($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('Tab_Prodaux4', $data, array('idTab_Prodaux4' => $id));
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
	
	public function delete_prodaux4($data) {        
		$query = $this->db->delete('Tab_Prodaux4', array('idTab_Prodaux4' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function lista_prodaux4($x) {

        $query = $this->db->query('SELECT * '
                . 'FROM Tab_Prodaux4 '
                . 'WHERE '
                . 'idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND '
                . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' '
                . 'ORDER BY Abrev4 ASC ');

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

    public function select_prodaux43($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT '
                    . 'idTab_Prodaux4, '
                    . 'Prodaux4, '
					. 'Abrev4, '
                    . 'FROM '
                    . 'Tab_Prodaux4 '
					. 'ORDER BY idTab_Prodaux4 ASC ');
					#. 'WHERE '
                   # . 'idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND '
                   # . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] ) . ' '
					
        } else {
            #$query = $this->db->query('SELECT idTab_Prodaux4, Prodaux4, Abrev4 FROM Tab_Prodaux4 WHERE idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario']);
			$query = $this->db->query('SELECT idTab_Prodaux4 FROM Tab_Prodaux4 ORDER BY Prodaux4 ASC ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Prodaux4] = $row->Prodaux4;
            }
        }

        return $array;
    }
	
	public function select_prodaux41($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT                
				idTab_Prodaux4,
				Prodaux4,
				Abrev4
            FROM
                Tab_Prodaux4
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . '
                ORDER BY Prodaux4 ASC'
    );
        } else {
            $query = $this->db->query(
                'SELECT                
				idTab_Prodaux4,
				Prodaux4,
				Abrev4
            FROM
                Tab_Prodaux4
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . '
                ORDER BY Prodaux4 ASC'
    );

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Prodaux4] = $row->Prodaux4;
            }
        }

        return $array;
    }
	
	public function select_Prodaux4($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT                
				idTab_Prodaux4,
				CONCAT(Prodaux4, " - " , idTab_Prodaux4) AS Prodaux4,
				Abrev4
            FROM
                Tab_Prodaux4
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				Prodaux4 ASC,
				idTab_Prodaux4
    ');
        } else {
            $query = $this->db->query(
                'SELECT                
				idTab_Prodaux4,
				CONCAT(Prodaux4, " - " , idTab_Prodaux4) AS Prodaux4,
				Abrev4
            FROM
                Tab_Prodaux4
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				Prodaux4 ASC,
				idTab_Prodaux4
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Prodaux4] = $row->Prodaux4;
            }
        }

        return $array;
    }

}
