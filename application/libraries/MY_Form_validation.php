<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * MY_Form_validation Class
 *
 * Extends Form_Validation library
 *
 */
class MY_Form_validation extends CI_Form_validation {

    private $_standard_date_format = 'Y-m-d H:i:s';
    private $mime_types;

    public function __construct() {
        parent::__construct();
    }

    /**
     *
     * decimar_br
     *
     * Verifica se � decimal, mas com virgula no lugar de .
     * @access	public
     * @param	string
     * @return	bool
     */
    public function decimal_br($str) {
        $CI = & get_instance();
        $CI->form_validation->set_message('decimal_br', 'O campo %s n�o contem um valor decimal v�lido.');

        return (bool) preg_match('/^[\-+]?[0-9]+\,[0-9]+$/', $str);
    }

    /**
     *
     * valid_cpf
     *
     * Verifica CPF � v�lido
     * @access	public
     * @param	string
     * @return	bool
     */
    function valid_cpf($cpf) {
        $CI = & get_instance();

        $CI->form_validation->set_message('valid_cpf', 'O <b>%s</b> informado n�o � v�lido.');

        if (preg_match('/^[0-9]{3}\.?[0-9]{3}\.?[0-9]{3}\-?[0-9]{2}$/', $cpf) == FALSE) {
            return FALSE;
        } else {

            $cpf = preg_replace('/[^0-9]/', '', $cpf);

            if (strlen($cpf) != 11 || preg_match('/^([0-9])\1+$/', $cpf)) {
                return FALSE;
            }

            // 9 primeiros digitos do cpf
            $digit = substr($cpf, 0, 9);

            // calculo dos 2 digitos verificadores
            for ($j = 10; $j <= 11; $j++) {
                $sum = 0;
                for ($i = 0; $i < $j - 1; $i++) {
                    $sum += ($j - $i) * ((int) $digit[$i]);
                }

                $summod11 = $sum % 11;
                $digit[$j - 1] = $summod11 < 2 ? 0 : 11 - $summod11;
            }

            return $digit[9] == ((int) $cpf[9]) && $digit[10] == ((int) $cpf[10]);
        }
    }
	
    function valid_aprovado($data) {
        $CI = & get_instance();

        $CI->form_validation->set_message('valid_aprovado', '<b>%s</b>');

		if (($data) != "S") {
			return FALSE;
		}
       
    }
	
    /**
     * valid_date
     *
     * valida data no pradrao brasileiro
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    function valid_date($data) {
        $CI = & get_instance();
        $CI->form_validation->set_message('valid_date', '<b>%s</b> inv�lida. Use uma data v�lida no formato DD/MM/AAAA.');

        #$padrao = explode('/', $data);
        $CI->load->library('basico');

        return $CI->basico->check_date($data);
    }

    /**
     * valid_hour
     *
     * valida a hora
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    function valid_hour($data) {
        $CI = & get_instance();
        $CI->form_validation->set_message('valid_hour', '<b>%s</b> inv�lida. Use um hor�rio v�lido no formato HH:MM.');

        #$padrao = explode('/', $data);
        $CI->load->library('basico');

        return $CI->basico->check_hour($data);
    }

    /**
     * valid_period
     *
     * valida o per�odo, considerando uma data in�cio e fim e a data fim deve ser maior (posterior) que a data in�cio
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    function valid_periodo_hora($horafim, $horainicio) {

        $CI = & get_instance();
        $CI->form_validation->set_message('valid_periodo_hora', '<b>%s</b> inv�lida. A data final deve ser maior que a inicial.');

        $CI->load->library('basico');

        return $CI->basico->check_periodo_hora($horafim, $horainicio);
    }


    /**
     * valid_cep
     *
     * Verifica se CEP � v�lido
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    function valid_cep($cep) {
        $CI = & get_instance();
        $CI->form_validation->set_message('valid_cep', '<b>%s</b> inv�lido.');

        return (bool) preg_match('/^([0-9]{2})\.?([0-9]{3})-?([0-9]{3})$/', $cep);
        /*
          if ($retorno['resultado'] == 1 || $retorno['resultado'] == 2)
          return TRUE;
          else
          return FALSE;
         *
         */
    }

    public function is_unique($str, $field) {
        $CI = & get_instance();
        $CI->form_validation->set_message('is_unique', '<b>%s</b> j� cadastrado.');

        if ($field == "Cpf")
            $str = ltrim(preg_replace("/[^0-9]/", "", $str), '0');

        sscanf($field, '%[^.].%[^.]', $table, $field);
        return isset($this->CI->db) ? ($this->CI->db->limit(1)->get_where($table, array($field => $str))->num_rows() === 0) : FALSE;
    }

    public function is_unique_cpf($str, $field) {
        $CI = & get_instance();
        $CI->form_validation->set_message('is_unique_cpf', '<b>%s</b> j� cadastrado.');

        #$str = ltrim(preg_replace("/[^0-9]/", "", $str), '0');
        #exit();

        sscanf($field, '%[^.].%[^.]', $table, $field);
        #return isset($this->CI->db)
        #    ? ($this->CI->db->limit(1)->get_where($table, array($field => $str))->num_rows() === 0)
        #    : FALSE;

        $this->CI->db->limit(1)->get_where($table, array($field => $str));
        echo $this->CI->db->last_query();
        exit();
    }

    public function is_unique_by_id($str, $field) {
        $CI = & get_instance();
        $CI->form_validation->set_message('is_unique_by_id', '<b>%s</b> j� cadastrado.');

        #sscanf($field, '%[^.].%[^.]', $table, $field);
        sscanf($field, '%[^.].%[^.].%[^.]', $table, $field, $id);

        if ($field == "Cpf")
            $str = ltrim(preg_replace("/[^0-9]/", "", $str), '0');

        return isset($this->CI->db)
                #? ($this->CI->db->limit(1)->get_where($table, array($field => $str))->num_rows() === 0)
                ? ($this->CI->db->limit(1)->query('SELECT ' . $field . ' FROM ' . $table . ' WHERE '
                        . 'id' . $table . ' != "' . $id . '" AND ' . $field . ' = "' . $str . '"')->num_rows() === 0) : FALSE;
    }
	
	/**
	 * Unique
	 *
	 * Verifica se o valor j� est� cadastrado no banco
	 * unique[users.login] retorna FALSE se o valor postado j� estiver no campo login da tabela users
	 * unique[users.login.10] retorna FALSE se o valor postado j� estiver no campo login da tabela users, desde que o id seja diferente de 10.
	 * 						isso � �til quando for atualizar os dados
	 * unique[users.city.10:id_cidade] retorna FALSE se o valor postado j� estiver no campo city da tabela users, desde que o id_cidade seja diferente de 10.
	 						se n�o for passado o valor ap�s o : ser� usado o id.
	 * @access	public
	 * @param	string - dados que ser� buscado
	 * @param	string - campo, tabela e id
	 *
	 * @return	bool
	 */
	
	public function is_unique_emp($str = '', $field = '')	{
		$CI =& get_instance();
		
		$res = explode('.', $field, 3);
		
		$table	= $res[0];
		$column	= $res[1];
		$CI->form_validation->set_message('is_unique_emp', 'O %s j� est� cadastrado nesta EMPRESA.');
		
		
		$CI->db->select('COUNT(*) as total');
		$CI->db->where($column, $str);
		
		if( isset($res[2]) )
		{
			$res2 = explode(':', $res[2], 2);
			$ignore_value = $res2[0];
			
			if( isset($res2[1]) )
				$ignore_field = $res2[1];
			else
				$ignore_field = 'id';
			
			$CI->db->where($ignore_field . ' !=', $ignore_value);
		}
		$total = $CI->db->get($table)->row()->total;
		return ($total > 0) ? FALSE : TRUE;
	}
	
	    /**
     * valid_phone
     *
     * valida��o simples de telefone
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    function valid_phone($fone)
    {
        $CI =& get_instance();
        $CI->form_validation->set_message('valid_fone', 'O campo %s n�o cont�m um Telefone v�lido.');
        $fone = preg_replace('/[^0-9]/','',$fone);
        $fone = (string) $fone;
        if( strlen($fone) >= 10)
            return TRUE;
        else
            return FALSE;
    }
	
	public function is_unique_duplo($str, $field) {
        $CI = & get_instance();
        $CI->form_validation->set_message('is_unique_duplo', '<b>%s</b> j� cadastrado.');

        sscanf($field, '%[^.].%[^.].%[^.].%[^.]', $table, $field1, $field2, $str2);

        if ($field1 == "Cpf")
            $str = ltrim(preg_replace("/[^0-9]/", "", $str), '0');

        return isset($this->CI->db) ? ($this->CI->db->limit(1)->query('SELECT ' . $field1 . ' FROM ' . $table . ' WHERE '
                        . $field1 . ' = "' . $str . '" AND ' . $field2 . ' = "' . $str2 . '"')->num_rows() === 0) : FALSE;

    }	

}
