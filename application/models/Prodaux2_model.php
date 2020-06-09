<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Prodaux2_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }

    public function set_prodaux2($data) {

        $query = $this->db->insert('Tab_Prodaux2', $data);

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
	
    public function get_prodaux2($data) {
        $query = $this->db->query('SELECT * FROM Tab_Prodaux2 WHERE idTab_Prodaux2 = ' . $data);
        $query = $query->result_array();

        return $query[0];
    }

    public function update_prodaux2($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('Tab_Prodaux2', $data, array('idTab_Prodaux2' => $id));
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
	
    public function update2_prodaux2($data, $id) {

        unset($data['idTab_Prodaux2']);
        $query = $this->db->update('Tab_Prodaux2', $data, array('idTab_Prodaux2' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }	
	
	public function delete_prodaux2($data) {        
		$query = $this->db->delete('Tab_Prodaux2', array('idTab_Prodaux2' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function lista_prodaux2_BKP($x) {

        $query = $this->db->query('SELECT * '
                . 'FROM Tab_Prodaux2 '
                . 'WHERE '
                . 'idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND '
                . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' '
                . 'ORDER BY Abrev2 ASC ');

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
	
    public function lista_prodaux2($x) {

        $query = $this->db->query('
			SELECT 
				TP2.idTab_Prodaux2,
				TP2.Prodaux2,
				TP2.Abrev2,
				TP2.Arquivo,
				TP4.Prodaux4
			FROM 
				  Tab_Prodaux2 AS TP2
					LEFT JOIN Tab_Prodaux4 AS TP4 ON TP4.idTab_Prodaux4 = TP2.Prodaux4
			WHERE
                TP2.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND 
                TP2.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
			ORDER BY 
				TP4.Prodaux4 ASC,
				TP2.Prodaux2 ASC
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

    public function select_prodaux23($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT '
                    . 'idTab_Prodaux2, '
                    . 'Prodaux2, '
					. 'Abrev2, '
                    . 'FROM '
                    . 'Tab_Prodaux2 '
					. 'ORDER BY idTab_Prodaux2 ASC ');
					#. 'WHERE '
                   # . 'idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND '
                   # . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] ) . ' '
					
        } else {
            #$query = $this->db->query('SELECT idTab_Prodaux2, Prodaux2, Abrev2 FROM Tab_Prodaux2 WHERE idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario']);
			$query = $this->db->query('SELECT idTab_Prodaux2 FROM Tab_Prodaux2 ORDER BY Prodaux2 ASC ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Prodaux2] = $row->Prodaux2;
            }
        }

        return $array;
    }
	
	public function select_prodaux21($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT                
				idTab_Prodaux2,
				Prodaux2,
				Abrev2
            FROM
                Tab_Prodaux2
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . '
                ORDER BY Prodaux2 ASC'
    );
        } else {
            $query = $this->db->query(
                'SELECT                
				idTab_Prodaux2,
				Prodaux2,
				Abrev2
            FROM
                Tab_Prodaux2
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . '
                ORDER BY Prodaux2 ASC'
    );

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Prodaux2] = $row->Prodaux2;
            }
        }

        return $array;
    }
	
	public function select_prodaux2_BKP($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT                
				idTab_Prodaux2,
				CONCAT(Prodaux2, " - " , idTab_Prodaux2) AS Prodaux2,
				Abrev2
            FROM
                Tab_Prodaux2
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				Prodaux2 ASC,
				idTab_Prodaux2
    ');
        } else {
            $query = $this->db->query(
                'SELECT                
				idTab_Prodaux2,
				CONCAT(Prodaux2, " - " , idTab_Prodaux2) AS Prodaux2,
				Abrev2
            FROM
                Tab_Prodaux2
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				Prodaux2 ASC,
				idTab_Prodaux2
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Prodaux2] = $row->Prodaux2;
            }
        }

        return $array;
    }

	public function select_prodaux2($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('
            SELECT
				P.idTab_Prodaux2,
				CONCAT(IFNULL(P4.Prodaux4,""), " - ", IFNULL(P.Prodaux2,"")) AS Prodaux2
            FROM
                Tab_Prodaux2 AS P
					LEFT JOIN Tab_Prodaux4 AS P4 ON P4.idTab_Prodaux4 = P.Prodaux4 
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '  
			ORDER BY 
				P4.Prodaux4 ASC,
				P.Prodaux2 ASC
    ');
        } else {
            $query = $this->db->query('
            SELECT
				P.idTab_Prodaux2,
				CONCAT(IFNULL(P4.Prodaux4,""), " - ", IFNULL(P.Prodaux2,"")) AS Prodaux2
            FROM
                Tab_Prodaux2 AS P
					LEFT JOIN Tab_Prodaux4 AS P4 ON P4.idTab_Prodaux4 = P.Prodaux4 
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '  
			ORDER BY 
				P4.Prodaux4 ASC,
				P.Prodaux2 ASC
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Prodaux2] = $row->Prodaux2;
            }
        }

        return $array;
    }
	
}
