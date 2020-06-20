<?php

#modelo que verifica usu�rio e senha e loga o usu�rio no sistema, criando as sess�es necess�rias

defined('BASEPATH') OR exit('No direct script access allowed');

class Prodaux1_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }

    public function set_prodaux1($data) {

        $query = $this->db->insert('Tab_Prodaux1', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_prodaux1($data) {
        $query = $this->db->query('SELECT * FROM Tab_Prodaux1 WHERE idTab_Prodaux1 = ' . $data);
        $query = $query->result_array();

        return $query[0];
    }

    public function update_prodaux1($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('Tab_Prodaux1', $data, array('idTab_Prodaux1' => $id));
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
	
	public function delete_prodaux1($data) {        
		$query = $this->db->delete('Tab_Prodaux1', array('idTab_Prodaux1' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function lista_prodaux1_BKP($x) {

        $query = $this->db->query('SELECT * '
                . 'FROM Tab_Prodaux1 '
                . 'WHERE '
                . 'idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND '
                . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' '
                . 'ORDER BY Abrev1 ASC ');

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

    public function lista_prodaux1($x) {

        $query = $this->db->query('
			SELECT 
				TP1.idTab_Prodaux1,
				TP1.Prodaux1,
				TP1.Abrev1,
				TP3.Prodaux3
			FROM 
				  Tab_Prodaux1 AS TP1
					LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = TP1.Prodaux3
			WHERE
                TP1.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND 
                TP1.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				TP1.Prodaux3 = ' . $_SESSION['Produto']['Prodaux3'] . '
			ORDER BY 
				TP3.Prodaux3 ASC,
				TP1.Prodaux1 ASC
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
	
    public function select_prodaux13($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT '
                    . 'idTab_Prodaux1, '
                    . 'Prodaux1, '
					. 'Abrev1, '
                    . 'FROM '
                    . 'Tab_Prodaux1 '
					. 'ORDER BY idTab_Prodaux1 ASC ');
					#. 'WHERE '
                   # . 'idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND '
                   # . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] ) . ' '
					
        } else {
            #$query = $this->db->query('SELECT idTab_Prodaux1, Prodaux1, Abrev1 FROM Tab_Prodaux1 WHERE idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario']);
			$query = $this->db->query('SELECT idTab_Prodaux1 FROM Tab_Prodaux1 ORDER BY Prodaux1 ASC ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Prodaux1] = $row->Prodaux1;
            }
        }

        return $array;
    }
	
	public function select_prodaux11($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT                
				idTab_Prodaux1,
				Prodaux1,
				Abrev1
            FROM
                Tab_Prodaux1
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . '
                ORDER BY Prodaux1 ASC'
    );
        } else {
            $query = $this->db->query(
                'SELECT                
				idTab_Prodaux1,
				Prodaux1,
				Abrev1
            FROM
                Tab_Prodaux1
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . '
                ORDER BY Prodaux1 ASC'
    );
	
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Prodaux1] = $row->Prodaux1;
            }
        }

        return $array;
    }
	
	public function select_Prodaux1_BKP($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT                
				idTab_Prodaux1,
				CONCAT(Prodaux1, " - " , idTab_Prodaux1) AS Prodaux1,
				Abrev1
            FROM
                Tab_Prodaux1
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				Prodaux1 ASC,
				idTab_Prodaux1
    ');
        } else {
            $query = $this->db->query(
                'SELECT                
				idTab_Prodaux1,
				CONCAT(Prodaux1, " - " , idTab_Prodaux1) AS Prodaux1,
				Abrev1
            FROM
                Tab_Prodaux1
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				Prodaux1 ASC,
				idTab_Prodaux1
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Prodaux1] = $row->Prodaux1;
            }
        }

        return $array;
    }

	public function select_Prodaux1($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('
            SELECT
				P.idTab_Prodaux1,
				P.Prodaux1,
				P3.Prodaux3,
				CONCAT(IFNULL(P3.Prodaux3,""), " - ", IFNULL(P.Prodaux1,"")) AS Prodaux1
            FROM
                Tab_Prodaux1 AS P
					LEFT JOIN Tab_Prodaux3 AS P3 ON P3.idTab_Prodaux3 = P.Prodaux3
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '  
			ORDER BY 
				P3.Prodaux3 ASC,
				P.Prodaux1 ASC			
    ');
        } else {
            $query = $this->db->query('
            SELECT
				P.idTab_Prodaux1,
				P.Prodaux1,
				P3.Prodaux3,
				CONCAT(IFNULL(P3.Prodaux3,""), " - ", IFNULL(P.Prodaux1,"")) AS Prodaux1
            FROM
                Tab_Prodaux1 AS P
					LEFT JOIN Tab_Prodaux3 AS P3 ON P3.idTab_Prodaux3 = P.Prodaux3
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '  
			ORDER BY 
				P3.Prodaux3 ASC,
				P.Prodaux1 ASC			
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Prodaux1] = $row->Prodaux1;
            }
        }

        return $array;
    }

	public function select_Prodaux14($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('
            SELECT
				P.idTab_Prodaux1,
				P.Prodaux1,
				P.Prodaux3,
				P3.Prodaux3,
				CONCAT(IFNULL(P3.Prodaux3,""), " - ", IFNULL(P.Prodaux1,"")) AS Prodaux1
            FROM
                Tab_Prodaux1 AS P
					LEFT JOIN Tab_Prodaux3 AS P3 ON P3.idTab_Prodaux3 = P.Prodaux3
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.Prodaux3 = ' . $_SESSION['Produto']['Prodaux3'] . '
			ORDER BY 
				P3.Prodaux3 ASC,
				P.Prodaux1 ASC			
    ');
        } else {
            $query = $this->db->query('
            SELECT
				P.idTab_Prodaux1,
				P.Prodaux1,
				P.Prodaux3,
				P3.Prodaux3,
				CONCAT(IFNULL(P3.Prodaux3,""), " - ", IFNULL(P.Prodaux1,"")) AS Prodaux1
            FROM
                Tab_Prodaux1 AS P
					LEFT JOIN Tab_Prodaux3 AS P3 ON P3.idTab_Prodaux3 = P.Prodaux3
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.Prodaux3 = ' . $_SESSION['Produto']['Prodaux3'] . ' 
			ORDER BY 
				P3.Prodaux3 ASC,
				P.Prodaux1 ASC			
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Prodaux1] = $row->Prodaux1;
            }
        }

        return $array;
    }	
}
