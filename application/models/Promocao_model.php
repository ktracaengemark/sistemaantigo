<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

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
	
    public function set_item_promocao2($data) {

        $query = $this->db->insert_batch('Tab_Valor', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }	
	
    public function set_item_promocao1($data) {

        $query = $this->db->insert('Tab_Valor', $data);

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
	
    public function get_promocao($data) {
        $query = $this->db->query('SELECT  
										TPM.idTab_Promocao,
										TPM.Promocao,
										TPM.Descricao,
										TPM.idSis_Usuario,
										TPM.idSis_Empresa,
										TPM.idTab_Modulo,
										TPM.Desconto,
										TPM.Ativo,
										TPM.Arquivo,
										TPM.UnidadeProduto,
										TPM.TipoProduto,
										TPM.CodProd,
										TPM.CodBarra,
										TPM.Prodaux1,
										TPM.Prodaux2,
										TPM.Prodaux3,
										TPM.Prodaux4,
										TPM.ValorCompraProduto,
										TPM.ValorProduto,
										TPM.ValorProdutoSite,
										TPM.Categoria,
										TPM.ProdutoProprio,
										TPM.Aprovado,
										TPM.VendaSite,
										TPM.produto_breve_descricao,
										TPM.ObsProduto,
										TPM.Comprimento,
										TPM.PesoProduto,
										TPM.Comissao,
										TPM.Fornecedor,
										TPM.Cat_1,
										TPM.Cat_2,
										TPM.Cat_3,
										TPM.Mod_1,
										TPM.Mod_2,
										TPM.Mod_3,
										TPM.VendaBalcao,
										TPM.ValorPromocao,
										TC1.idTab_Catprod,
										TC2.idTab_Catprod,
										TC3.idTab_Catprod,
										TC1.Catprod AS Cat1,
										TC2.Catprod AS Cat2,
										TC3.Catprod AS Cat3,
										TDS1.Desconto AS Tipo
									FROM 
										Tab_Promocao AS TPM
											LEFT JOIN Tab_Valor AS TV ON TV.idTab_Promocao = TPM.idTab_Promocao
											LEFT JOIN Tab_Catprod AS TC1 ON TC1.idTab_Catprod = TPM.Cat_1
											LEFT JOIN Tab_Catprod AS TC2 ON TC2.idTab_Catprod = TPM.Cat_2
											LEFT JOIN Tab_Catprod AS TC3 ON TC3.idTab_Catprod = TPM.Cat_3
											LEFT JOIN Tab_Desconto AS TDS1 ON TDS1.idTab_Desconto = TPM.Desconto
											LEFT JOIN Tab_Desconto AS TDS2 ON TDS2.idTab_Desconto = TV.Desconto
									WHERE 
										TPM.idTab_Promocao = ' . $data . '
								');
        $query = $query->result_array();

        /*
		
		LEFT JOIN Tab_Produto AS TP1 ON TP1.idTab_Produto = TPM.Mod_1
		LEFT JOIN Tab_Produto AS TP2 ON TP2.idTab_Produto = TPM.Mod_2
		LEFT JOIN Tab_Produto AS TP3 ON TP3.idTab_Produto = TPM.Mod_3
		LEFT JOIN Tab_Desconto AS TDS ON TDS.idTab_Desconto = TPM.Desconto
		

        //echo $this->db->last_query();
        echo '<br>';
        echo "<pre>";
        print_r($query);
        echo "</pre>";
        exit ();
        */

        return $query[0];
    }

	public function get_item_promocao1($data) {
		$query = $this->db->query('
			SELECT * 
			FROM 
				Tab_Valor 
			WHERE 
				idTab_Promocao = ' . $data . ' 
		');
        $query = $query->result_array();

        return $query;
    }
	
	public function get_item_promocao($data, $item) {
		$query = $this->db->query('
			SELECT * 
			FROM 
				Tab_Valor 
			WHERE 
				idTab_Promocao = ' . $data . ' AND
				Item_Promocao = '. $item . '
		');
        $query = $query->result_array();

        return $query;
    }
	
    public function get_item_promocao2($data, $item) {
		$query = $this->db->query('
			SELECT * 
			FROM 
				Tab_Valor 
			WHERE 
				idTab_Promocao = ' . $data . ' AND
				Item_Promocao = '. $item . '
		');
        $query = $query->result_array();

        return $query;
    }	

    public function list_promocao1($id, $aprovado, $completo) {

        $query = $this->db->query('
            SELECT
                TF.idTab_Promocao,
                TF.TipoProduto,
                TF.Promocao
            FROM
                Tab_Promocao AS TF
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

    public function update_item_promocao2($data) {

        $query = $this->db->update_batch('Tab_Valor', $data, 'idTab_Valor');
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

    public function delete_item_promocao2($data) {

        $this->db->where_in('idTab_Valor', $data);
        $this->db->delete('Tab_Valor');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
    public function delete_promocao($id) {


        $query = $this->db->delete('Tab_Valor', array('idTab_Promocao' => $id));
        $query = $this->db->delete('Tab_Promocao', array('idTab_Promocao' => $id));

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
	
	public function select_promocao($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
            'SELECT
                TPV.idTab_Promocao,
				CONCAT(IFNULL(TPV.CodProd,""), " -- ", IFNULL(TP3.Prodaux3,""), " -- ", IFNULL(TPV.Promocao,""), " -- ", IFNULL(TP1.Prodaux1,""), " -- ", IFNULL(TP2.Prodaux2,""), " -- ", IFNULL(TPV.UnidadeProduto,""), " -- ", IFNULL(TFO.NomeFornecedor,"")) AS NomeProduto,
				TPV.ValorCompraProduto,
				TPV.Categoria
            FROM
                Tab_Promocao AS TPV
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
				TPV.Promocao ASC,
				TP1.Prodaux1,
				TP2.Prodaux2 
    ');
        } else {
            $query = $this->db->query(
            'SELECT
                TPV.idTab_Promocao,
				CONCAT(IFNULL(TPV.CodProd,""), " -- ", IFNULL(TP3.Prodaux3,""), " -- ", IFNULL(TPV.Promocao,""), " -- ", IFNULL(TP1.Prodaux1,""), " -- ", IFNULL(TP2.Prodaux2,""), " -- ", IFNULL(TPV.UnidadeProduto,""), " -- ", IFNULL(TFO.NomeFornecedor,"")) AS NomeProduto,
				TPV.ValorCompraProduto,
				TPV.Categoria
            FROM
                Tab_Promocao AS TPV
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
				TPV.Promocao ASC,
				TP1.Prodaux1,
				TP2.Prodaux2 
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Promocao] = $row->NomeProduto;
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
