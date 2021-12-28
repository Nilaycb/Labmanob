<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts_edit_model extends CI_Model 
{

    public function __construct()
    {
    parent::__construct();
    $this->load->database();
    $this->db->db_select($this->db->database); 
    }



    public function user($data, $user_id) 
    {
        $this->load->helper('install_db_tables'); 
        
        $datetime = date('Y-m-d H:i:s', now()); 
        
        $this->db->set('modified', $datetime, TRUE); 
        $this->db->where('id', $user_id);
        
        return $this->db->update($this->registry->db_tables['users']['name'], $data);
    } 



} 

?>