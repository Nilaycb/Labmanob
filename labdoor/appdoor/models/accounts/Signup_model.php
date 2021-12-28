<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup_model extends CI_Model 
{

    public function __construct()
    {
    parent::__construct();
    $this->load->database();
    $this->db->db_select($this->db->database); 
    }



    public function has_username($username) 
    {
        
        if (empty($username)) 
        {
            return FALSE; 
        }
        else 
        {
            $stmt = "SELECT id FROM users WHERE username = ? LIMIT 1"; 
            $query = $this->db->query($stmt, array($username)); 
            
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



/** username_not_exists used in forms, it is similar to codeigniter's is_unique **/

    public function username_not_exists($username) 
    {
        
        if (empty($username)) 
        {
            return TRUE;
        }
        else 
        {
            if($this->has_username($username) === TRUE) 
            {
                return FALSE; 
            }
            else 
            {
                return TRUE; 
            }
            
        }
        
    }



    public function has_email($email) 
    {
        
        if (empty($email)) 
        {
            return FALSE; 
        }
        else 
        {
            $stmt = "SELECT id FROM users WHERE email = ? LIMIT 1"; 
            $query = $this->db->query($stmt, array($email)); 
            
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



    public function has_verified_email($email) 
    {
        
        if (empty($email)) 
        {
            return FALSE; 
        }
        else 
        {
            $stmt = "SELECT id FROM users WHERE email = ? AND verified = 1 LIMIT 1"; 
            $query = $this->db->query($stmt, array($email)); 
            
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



/** email_not_exists used in forms, only verified emails are counted, it is similar to codeigniter's is_unique **/

    public function email_not_exists($email) 
    {
        
        if (empty($email)) 
        {
            return TRUE;
        }
        else 
        {
            if($this->has_verified_email($email) === TRUE) 
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
        
        if (empty($firstname)) 
        { 
            return TRUE; 
        } 
        else 
        { 
            $firstname_pattern='/^([a-zA-Z]+)\w*(\s*\w*(\s*)*)*$/'; 
            
            if(!preg_match($firstname_pattern, $firstname)) 
            { 
                return FALSE; 
            } 
            else 
            { 
                return TRUE; 
            } 
            
        }
        
    }



/** check_regex_lastname used in forms to check regex of lastname  **/

    public function check_regex_lastname($lastname) 
    { 
        
        if (empty($lastname)) 
        { 
            return TRUE; 
        } 
        else 
        { 
            $lastname_pattern='/^([a-zA-Z]+)\w*(\s*\w*(\s*)*)*$/'; 
            
            if(!preg_match($lastname_pattern, $lastname)) 
            { 
                return FALSE; 
            } 
            else 
            { 
                return TRUE; 
            } 
            
        }
        
    }



    public function hash_the_password($password) 
    {
        if (!empty($password)) 
        {
            $password = password_hash($password, PASSWORD_BCRYPT); 
            return $password; 
        } 
        else 
        {
            return NULL; 
        }
    } 



    public function signup($data) 
    {
        $this->load->helper('install_db_tables'); 
        
        $datetime = date('Y-m-d H:i:s', now()); 
        
        $this->db->set('created', $datetime, TRUE); 
        $this->db->set('modified', $datetime, TRUE); 
        
        if ($this->db->insert($this->registry->db_tables['users']['name'], $data, TRUE)) 
        {
            return TRUE; 
        } 
        else 
        {
            return FALSE; 
        } 
        
    } 



} 

?>