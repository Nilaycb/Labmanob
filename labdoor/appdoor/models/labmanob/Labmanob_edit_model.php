<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Labmanob_edit_model extends CI_Model 
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



    public function test($data, $id) 
    {
        $this->load->helper('install_db_tables'); 
        
        $datetime = date('Y-m-d H:i:s', now()); 
        
        $this->db->set('modified', $datetime, TRUE); 
        $this->db->where('id', $id);
        
        return $this->db->update($this->registry->db_tables['tests']['name'], $data);
        
    } 



    public function test_category($data, $id) 
    {
        $this->load->helper('install_db_tables'); 
        
        $datetime = date('Y-m-d H:i:s', now()); 
        
        $this->db->set('modified', $datetime, TRUE); 
        $this->db->where('id', $id);
        
        return $this->db->update($this->registry->db_tables['test_categories']['name'], $data);
        
    } 



    public function affiliate_partner($data, $id) 
    {
        $this->load->helper('install_db_tables'); 
        
        $datetime = date('Y-m-d H:i:s', now()); 
        
        $this->db->set('modified', $datetime, TRUE); 
        $this->db->where('id', $id);
        
        return $this->db->update($this->registry->db_tables['affiliate_partners']['name'], $data);
        
    } 



    public function patient($data, $id) 
    {
        $this->load->helper('install_db_tables'); 
        
        $datetime = date('Y-m-d H:i:s', now()); 
        
        $this->db->set('modified', $datetime, TRUE); 
        $this->db->where('id', $id);
        
        return $this->db->update($this->registry->db_tables['patients']['name'], $data);
        
    } 



    public function test_invoice($data, $id, $skip_modified=FALSE) 
    {
        $this->load->helper('install_db_tables'); 
        
        $datetime = date('Y-m-d H:i:s', now()); 
        
        ($skip_modified) ? '' : $this->db->set('modified', $datetime, TRUE); 
        $this->db->where('id', $id);
        
        return $this->db->update($this->registry->db_tables['test_invoices']['name'], $data);
        
    } 



    public function test_invoice_payment($data, $test_invoice_id) 
    {
        $this->load->helper('install_db_tables'); 
        
        $datetime = date('Y-m-d H:i:s', now()); 
        
        $this->db->set('modified', $datetime, TRUE); 
        $this->db->where('test_invoice_id', $test_invoice_id);
        
        return $this->db->update($this->registry->db_tables['test_invoice_payments']['name'], $data);
    } 



    /** test_codename_not_exists_from_id used in forms, it is similar to codeigniter's is_unique **/

    public function test_codename_not_exists_from_id($test_codename, $test_id) 
    {
        
        if (empty($test_codename) || empty($test_id)) 
        {
            return FALSE;
        }
        else 
        {
            $this->db->select('id');
            $this->db->where('test_codename', $test_codename);
            $this->db->where('id !=', $test_id);
            $this->db->limit(1);
            
            if($this->db->count_all_results('tests') > 0)
            {
                return FALSE;
            }
            else
            {
                return TRUE;
            }
            
        }
        
    } 



    /** category_codename_not_exists_from_id used in forms, it is similar to codeigniter's is_unique **/

    public function category_codename_not_exists_from_id($category_codename, $test_category_id) 
    {
        
        if (empty($category_codename) || empty($test_category_id)) 
        {
            return FALSE;
        }
        else 
        {
            $this->db->select('id');
            $this->db->where('category_codename', $category_codename);
            $this->db->where('id !=', $test_category_id);
            $this->db->limit(1);
            
            if($this->db->count_all_results('test_categories') > 0)
            {
                return FALSE;
            }
            else
            {
                return TRUE;
            }
            
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



} 

?>