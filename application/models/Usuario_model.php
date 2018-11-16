<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }


    ##############
    #RESPONSÁVEL
    ##############

    public function set_usuario($data) {

        $query = $this->db->insert('Sis_Usuario', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_agenda($data) {
        #unset($data['idSisgef_Fila']);
        /*
          echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit();
         */
        $query = $this->db->insert('App_Agenda', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        }
        else {
            #return TRUE;
            return $this->db->insert_id();
        }

    }
	
    public function get_usuario($data) {
        $query = $this->db->query('SELECT * FROM Sis_Usuario WHERE idSis_Usuario = ' . $data);

        $query = $query->result_array();

        return $query[0];
    }

    public function update_usuario($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('Sis_Usuario', $data, array('idSis_Usuario' => $id));
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

    public function delete_usuario($data) {

        $query = $this->db->query('SELECT idApp_OrcaTrata FROM App_OrcaTrata WHERE idSis_Usuario = ' . $data);
        $query = $query->result_array();

        /*
        echo $this->db->last_query();
        #$query = $query->result();
        echo '<br>';
        echo "<pre>";
        print_r($query);
        echo "</pre>";


        foreach ($query as $key) {
            /*
            echo $key['idApp_OrcaTrata'];
            echo '<br />';
            #echo $value;
            echo '<br />';
        }

        exit();

        */

        $this->db->delete('App_Consulta', array('idSis_Usuario' => $data));
        $this->db->delete('App_ContatoUsuario', array('idSis_Usuario' => $data));

        foreach ($query as $key) {
            $query = $this->db->delete('App_ProdutoVenda', array('idApp_OrcaTrata' => $key['idApp_OrcaTrata']));
            $query = $this->db->delete('App_ServicoVenda', array('idApp_OrcaTrata' => $key['idApp_OrcaTrata']));
            $query = $this->db->delete('App_ParcelasRecebiveis', array('idApp_OrcaTrata' => $key['idApp_OrcaTrata']));
            $query = $this->db->delete('App_Procedimento', array('idApp_OrcaTrata' => $key['idApp_OrcaTrata']));
        }

        $this->db->delete('App_OrcaTrata', array('idSis_Usuario' => $data));
        $this->db->delete('Sis_Usuario', array('idSis_Usuario' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function lista_usuario($data, $x) {

        $query = $this->db->query('SELECT * '
                . 'FROM Sis_Usuario WHERE '
                #. 'Usuario = ' . $_SESSION['log']['id'] . ' AND '
				. 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND '
                . '(Nome like "%' . $data . '%" OR '
                #. 'DataNascimento = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
                #. 'Nome like "%' . $data . '%" OR '
                . 'DataNascimento = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
                . 'Celular like "%' . $data . '%") '
                . 'ORDER BY Nome ASC ');
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
                    $row->DataNascimento = $this->basico->mascara_data($row->DataNascimento, 'barras');
                }

                return $query;
            }
        }
    }

    public function lista_contatousuario($id, $bool) {

        $query = $this->db->query(
            'SELECT * '
                . 'FROM App_ContatoUsuario WHERE '
                . 'idSis_Usuario = ' . $id . ' '
            . 'ORDER BY NomeContatoUsuario ASC ');
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
            if ($bool === FALSE) {
                return TRUE;
            } else {
                foreach ($query->result() as $row) {
                    $row->Idade = $this->basico->calcula_idade($row->DataNascimento);
                    $row->DataNascimento = $this->basico->mascara_data($row->DataNascimento, 'barras');
                    $row->Sexo = $this->Basico_model->get_sexo($row->Sexo);
                    $row->RelaPes = $this->Basico_model->get_relapes($row->RelaPes);
                    $row->RelaPes2 = $this->Basico_model->get_relapes($row->RelaPes2);
                }

                return $query;
            }
        }
    }

	public function select_usuario($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
				idSis_Usuario,
				Nome				
            FROM
                Sis_Usuario					
            WHERE
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				Nome ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT                
				idSis_Usuario,
				Nome
            FROM
                Sis_Usuario					
            WHERE
                idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				Nome ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idSis_Usuario] = $row->Nome;
            }
        }

        return $array;
    }	

	public function select_profissional1($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT
				P.idSis_Usuario,
				CONCAT(IFNULL(P.Nome,"")) AS Nome
            FROM
                Sis_Usuario AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				P.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
				(P.Nivel = "3" OR P.Nivel = "4")
  
			ORDER BY P.Nome ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT
				P.idSis_Usuario,
				CONCAT(IFNULL(P.Nome,"")) AS Nome
            FROM
                Sis_Usuario AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				P.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND
				(P.Nivel = "3" OR P.Nivel = "4")
 
			ORDER BY P.Nome ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idSis_Usuario] = $row->Nome;
            }
        }

        return $array;
    }

	public function select_profissional($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT
				P.idSis_Usuario,
				CONCAT(IFNULL(P.Nome,"")) AS Nome
            FROM
                Sis_Usuario AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				P.Nivel = "6"
  
			ORDER BY P.Nome ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT
				P.idSis_Usuario,
				CONCAT(IFNULL(P.Nome,"")) AS Nome
            FROM
                Sis_Usuario AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				P.Nivel = "6"
 
			ORDER BY P.Nome ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idSis_Usuario] = $row->Nome;
            }
        }

        return $array;
    }

	public function select_usuarioemp($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
				idSis_Usuario,
				Nome				
            FROM
                Sis_Usuario					
            WHERE
				Empresa = ' . $_SESSION['log']['id'] . '
			ORDER BY 
				Nome ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT                
				idSis_Usuario,
				Nome
            FROM
                Sis_Usuario					
            WHERE
                Empresa = ' . $_SESSION['log']['id'] . '
			ORDER BY 
				Nome ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idSis_Usuario] = $row->Nome;
            }
        }

        return $array;
    }	
	
}
