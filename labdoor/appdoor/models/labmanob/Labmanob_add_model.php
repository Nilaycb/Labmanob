<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Labmanob_add_model extends CI_Model 
{ 

    public function __construct()
    { 
    parent::__construct();
    $this->load->helper(array('discount'));
    $this->load->database();
    $this->db->db_select($this->db->database); 
    } 



    public function trans_start()
    {
        $this->db->trans_start();
    }



    public function trans_complete()
    {
        $this->db->trans_complete();
    }



    public function clear_new_test_invoice_sess()
    {
        $this->load->library(array('session', 'cart'));

        if (isset($_SESSION['test_invoice__patient_id'])) 
        { 
            unset($_SESSION['test_invoice__patient_id']); 
        } 
        
        if (isset($_SESSION['test_invoice__patient'])) 
        { 
            unset($_SESSION['test_invoice__patient']); 
        } 
        
        if (isset($_SESSION['test_invoice__tests_id'])) 
        { 
            unset($_SESSION['test_invoice__tests_id']); 
        } 

        $this->cart->destroy();
    }



    public function has_affiliate_partner_id($affiliate_partner_id) 
    {
        
        if (empty($affiliate_partner_id)) 
        {
            return FALSE; 
        }
        else 
        {
            $stmt = "SELECT id FROM affiliate_partners WHERE id = ? LIMIT 1"; 
            $query = $this->db->query($stmt, array($affiliate_partner_id)); 
            
            if ($query->num_rows() > 0) 
            {
                return TRUE; 
            }
            else 
            {
                return FALSE; 
            } 
        }
        
    } 



    public function has_patient_id($patient_id) 
    {
        
        if (empty($patient_id)) 
        {
            return FALSE; 
        }
        else 
        {
            $stmt = "SELECT id FROM patients WHERE id = ? LIMIT 1"; 
            $query = $this->db->query($stmt, array($patient_id)); 
            
            if ($query->num_rows() > 0) 
            {
                return TRUE; 
            }
            else 
            {
                return FALSE; 
            } 
        }
        
    } 



    public function has_test_id($test_id) 
    {
        
        if (empty($test_id)) 
        {
            return FALSE; 
        }
        else 
        {
            $stmt = "SELECT id FROM tests WHERE id = ? LIMIT 1"; 
            $query = $this->db->query($stmt, array($test_id)); 
            
            if ($query->num_rows() > 0) 
            {
                return TRUE; 
            }
            else 
            {
                return FALSE; 
            } 
        }
        
    } 



    public function has_category_codename($category_codename) 
    {
        
        if (empty($category_codename)) 
        {
            return FALSE; 
        }
        else 
        {
            $stmt = "SELECT id FROM test_categories WHERE category_codename = ? LIMIT 1"; 
            $query = $this->db->query($stmt, array($category_codename)); 
            
            if ($query->num_rows() > 0) 
            {
                return TRUE; 
            }
            else 
            {
                return FALSE; 
            } 
        }
        
    } 



/** category_codename_not_exists used in forms, it is similar to codeigniter's is_unique **/

    public function category_codename_not_exists($category_codename) 
    {
        
        if (empty($category_codename)) 
        {
            return TRUE;
        }
        else 
        {
            if($this->has_category_codename($category_codename) === TRUE) 
            {
                return FALSE; 
            }
            else 
            {
                return TRUE; 
            }
            
        }
        
    } 



    public function has_test_codename($test_codename) 
    {
        
        if (empty($test_codename)) 
        {
            return FALSE; 
        }
        else 
        {
            $stmt = "SELECT id FROM tests WHERE test_codename = ? LIMIT 1"; 
            $query = $this->db->query($stmt, array($test_codename)); 
            
            if ($query->num_rows() > 0) 
            {
                return TRUE; 
            }
            else 
            {
                return FALSE; 
            } 
        }
        
    } 



/** test_codename_not_exists used in forms, it is similar to codeigniter's is_unique **/

    public function test_codename_not_exists($test_codename) 
    {
        
        if (empty($test_codename)) 
        {
            return TRUE;
        }
        else 
        {
            if($this->has_test_codename($test_codename) === TRUE) 
            {
                return FALSE; 
            }
            else 
            {
                return TRUE; 
            }
            
        }
        
    } 



    public function has_test_category_id($test_category_id) 
    {
        
        if (empty($test_category_id)) 
        {
            return FALSE; 
        }
        else 
        {
            $stmt = "SELECT id FROM test_categories WHERE id = ? LIMIT 1"; 
            $query = $this->db->query($stmt, array($test_category_id)); 
            
            if ($query->num_rows() > 0) 
            {
                return TRUE; 
            }
            else 
            {
                return FALSE; 
            } 
        }
        
    } 



    public function has_test_invoice_id($test_invoice_id) 
    {
        
        if (empty($test_invoice_id)) 
        {
            return FALSE; 
        }
        else 
        {
            $stmt = "SELECT id FROM test_invoices WHERE id = ? LIMIT 1"; 
            $query = $this->db->query($stmt, array($test_invoice_id)); 
            
            if ($query->num_rows() > 0) 
            {
                return TRUE; 
            }
            else 
            {
                return FALSE; 
            } 
        }
        
    } 



/** check_regex_name used in forms to check regex of name  **/

public function check_regex_name($name) 
{ 
    
    if (empty($name)) 
    { 
        return TRUE; 
    } 
    else 
    { 
        $name_pattern='/^([a-zA-Z]+)\w*(\s*\w*(\s*)*)*$/'; 
        
        if(!preg_match($name_pattern, $name)) 
        { 
            return FALSE; 
        } 
        else 
        { 
            return TRUE; 
        } 
        
    }
    
}



/** check_regex_firstname used in forms to check regex of firstname  **/

    public function check_regex_firstname($firstname) 
    { 
        return $this->check_regex_name($firstname);
    }



/** check_regex_lastname used in forms to check regex of lastname  **/

    public function check_regex_lastname($lastname) 
    { 
        return $this->check_regex_name($lastname);
    }



/** check_regex_phone_no used in forms to check regex of phone no  **/

    public function check_regex_phone_no($phone_no) 
    { 
        
        if (empty($phone_no)) 
        { 
            return TRUE; 
        } 
        else 
        { 
            $phone_no_pattern='/((^|,)(\s)?((((\+)?((\d{3}[-])|(\d{3})))((\d{2}){1})([-])?((\d{4}){1})([-])?((\d{4}){1}))|(((\+)?((\d{3}[-])|(\d{3})))(\d{1})([-])?(\d{1})([-])?((\d{4}){1})([-])?((\d{4}){1}))|(((\+)?((\d{3}[-])|(\d{3})))((\d{3}){1})([-])?((\d{3}){1})([-])?((\d{4}){1}))|(((\+)?((\d{3}[-])|(\d{3})))((\d{4}){1})([-])?((\d{6}){1}))|(((\+)?((\d{2}[-])|(\d{2})))?(\d{7,11}){1})))+([,])?$/'; 
            
            /** 
            * Work with bd phone numbers
            *
            * /((^|,)(\s)?(part1|((\+)?((\d{2}[-])|(\d{2})))?(\d{7,11}){1}|part3))+$/
            *
            **/ 
            
            /** 
            * regex created using the reference from Wikipedia about Bangladesh Telephone Numbers formats 
            * URL: https://en.wikipedia.org/wiki/Telephone_numbers_in_Bangladesh
            *
            *
            * remove whitespaces before using 
            *
            * regex sequence 
            *
            * "+880-1X-NNNN-NNNN" & "+880-XX-NNNN-NNNN" (Mobile Network Operators & Fixed line network operators) 
            *
            * "+880-2-N-NNNN-NNNN" (Typical format for a BTCL line number in Dhaka) 
            *
            * "+880-XXX-NNN-NNNN" (Typical format for a BTCL line number elsewhere) 
            *
            * "+880-XXXX-NNNNNN" (Typical format for an IP telephone number) 
            *
            * the last one is "+88-{7 to 11 digit}" (custom format for the local numbers) 
            *
            * /((^|,)(\s)?((((\+)?((\d{3}[-])|(\d{3})))((\d{2}){1})([-])?((\d{4}){1})([-])?((\d{4}){1}))  |  (((\+)?((\d{3}[-])|(\d{3})))(\d{1})([-])?(\d{1})([-])?((\d{4}){1})([-])?((\d{4}){1}))  |  (((\+)?((\d{3}[-])|(\d{3})))((\d{3}){1})([-])?((\d{3}){1})([-])?((\d{4}){1}))  |  (((\+)?((\d{3}[-])|(\d{3})))((\d{4}){1})([-])?((\d{6}){1}))  |  (((\+)?((\d{2}[-])|(\d{2})))?(\d{7,11}){1})))+([,])?$/
            * 
            **/ 
            
            /** 
            * Nearly work with universal phone numbers 
            *
            * /^((\+)?(\d{2}[-])?(\d{10}){1})?(\d{11}){0,1}?$/
            *
            * used before "/((^|,)(\s)?(((\+)?((\d{2}[-])|(\d{2})))?(\d{7,11}){1}))+([,])?$/"
            *
            **/ 
            
            
            if(!preg_match($phone_no_pattern, $phone_no)) 
            { 
                return FALSE; 
            } 
            else 
            { 
                return TRUE; 
            } 
            
        }
        
    }



    public function tests_where_not_category_id($id_array=NULL, $return_as_obj=TRUE) 
    { 
        
        if (($id_array !== NULL) && is_array($id_array) && (!empty($id_array))) 
        { 
            $this->db->order_by('id', 'DESC'); 
            $this->db->where_not_in('test_category_id', $id_array); 
            $query = $this->db->get('tests'); 
            
            return ($return_as_obj) ? $query->result() : $query->result_array(); 
        } 
        else 
        { 
            return FALSE; 
        } 
        
    } 



    public function new_affiliate_partner($data) 
    {
        $this->load->helper('install_db_tables'); 
        
        $datetime = date('Y-m-d H:i:s', now()); 
        
        $this->db->set('created', $datetime, TRUE); 
        $this->db->set('modified', $datetime, TRUE); 
        
        if ($this->db->insert($this->registry->db_tables['affiliate_partners']['name'], $data, TRUE)) 
        {
            return $this->db->insert_id(); 
        } 
        else 
        {
            return FALSE; 
        } 
        
    }  



    public function new_patient($data) 
    {
        $this->load->helper('install_db_tables'); 
        
        $datetime = date('Y-m-d H:i:s', now()); 
        
        $this->db->set('created', $datetime, TRUE); 
        $this->db->set('modified', $datetime, TRUE); 
        
        if ($this->db->insert($this->registry->db_tables['patients']['name'], $data, TRUE)) 
        {
            return $this->db->insert_id(); 
        } 
        else 
        {
            return FALSE; 
        } 
        
    } 



    public function new_test_category($data) 
    {
        $this->load->helper('install_db_tables'); 
        
        $datetime = date('Y-m-d H:i:s', now()); 
        
        $this->db->set('created', $datetime, TRUE); 
        $this->db->set('modified', $datetime, TRUE); 
        
        if ($this->db->insert($this->registry->db_tables['test_categories']['name'], $data, TRUE)) 
        {
            return $this->db->insert_id();
        } 
        else 
        {
            return FALSE; 
        } 
        
    } 



    public function new_test($data) 
    {
        $this->load->helper('install_db_tables'); 
        
        $datetime = date('Y-m-d H:i:s', now()); 
        
        $this->db->set('created', $datetime, TRUE); 
        $this->db->set('modified', $datetime, TRUE); 
        
        if ($this->db->insert($this->registry->db_tables['tests']['name'], $data, TRUE)) 
        {
            return $this->db->insert_id();
        } 
        else 
        {
            return FALSE; 
        } 
        
    } 



    public function new_test_invoice_record($data) 
    {
        $this->load->helper('install_db_tables'); 
        
        $datetime = date('Y-m-d H:i:s', now()); 
        
        $this->db->set('created', $datetime, TRUE); 
        $this->db->set('modified', $datetime, TRUE); 
        
        if ($this->db->insert($this->registry->db_tables['test_invoice_records']['name'], $data, TRUE)) 
        {
            return $this->db->insert_id(); 
        } 
        else 
        {
            return FALSE; 
        } 
        
    } 



    public function new_test_invoice($data) 
    {
        $this->load->helper('install_db_tables'); 
        
        $datetime = date('Y-m-d H:i:s', now()); 
        
        $this->db->set('created', $datetime, TRUE); 
        $this->db->set('modified', $datetime, TRUE); 
        
        if ($this->db->insert($this->registry->db_tables['test_invoices']['name'], $data, TRUE)) 
        {
            return $this->db->insert_id(); 
        } 
        else 
        {
            return FALSE; 
        } 
        
    } 



    public function new_test_invoice_payment($data) 
    {
        $this->load->helper('install_db_tables'); 
        
        $datetime = date('Y-m-d H:i:s', now()); 
        
        $this->db->set('created', $datetime, TRUE); 
        $this->db->set('modified', $datetime, TRUE); 
        
        if ($this->db->insert($this->registry->db_tables['test_invoice_payments']['name'], $data, TRUE)) 
        {
            return TRUE; 
        } 
        else 
        {
            return FALSE; 
        } 
        
    } 



    public function new_test_invoice_log($data) 
    {
        $this->load->helper('install_db_tables'); 
        
        $datetime = date('Y-m-d H:i:s', now()); 
        
        $this->db->set('created', $datetime, TRUE); 
        $this->db->set('modified', $datetime, TRUE); 
        
        if ($this->db->insert($this->registry->db_tables['test_invoice_logs']['name'], $data, TRUE)) 
        {
            return $this->db->insert_id(); 
        } 
        else 
        {
            return FALSE; 
        } 
        
    } 
	
	
	
	public function check_regex_discount($discount)
	{
		return func__discount__check_regex($discount);
    }
    


    public function check_regex_pct_in_amount($discount)
	{
		return func__discount__check_regex_pct_in_discount($discount);
    }
    


    public function calc_discount($discount, $amount)
    {
        return func__discount__calc($discount, $amount);
    }
	
	
	
	public function check_discount_range($discount)
	{
		if (empty($discount)) 
        { 
            return TRUE; 
        } 
        else 
        { 
			if($this->check_regex_discount($discount))
			{
				$discount_pattern_1='/^([-]?)(([0-9]+)([.])?)?([0-9]+)$/';
				$discount_pattern_2='/^([-]?)(([0-9]+)([.])?)?([0-9]+)[%]$/';
				
				if(preg_match($discount_pattern_1, $discount))
				{
					if($discount < 0)
					{
						return FALSE;
					}
					else
					{
						return TRUE;
					}
				}
				else
				{
					$value_array = explode("%", $discount);
					
					if(($value_array[0] >= 0) && ($value_array[0] <= 100))
					{
						return TRUE;
					}
					else
					{
						return FALSE;
					}
				}
			}
			else
			{
				return TRUE;
			}
			 
        }
        
	}



} 

?>