<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model 
{

    public function __construct()
    {
    parent::__construct();
    $this->load->database();
    $this->db->db_select($this->db->database);
    $this->load->library('session');
    $this->load->config('checkbrute');
    }



    /* hash_equals function for older php versions */

/** ##    if(!function_exists('hash_equals')) 
    {
        
        function hash_equals($str1, $str2) 
            { 
                if(strlen($str1) != strlen($str2)) 
            { 
                return false; 
            } 
            else 
            { 
                $res = $str1 ^ $str2; 
                $ret = 0; 
                
                for($i = strlen($res) - 1; $i >= 0; $i--) 
                { 
                    $ret |= ord($res[$i]); 
                } 
                
                return !$ret; 
            } 
        } 
    }
## **/



    public function login($username, $password, $bypass=FALSE) 
    {
        
        $username = filter_var($username, FILTER_SANITIZE_STRING);
        $password = filter_var($password, FILTER_SANITIZE_STRING);
        
        $username = strtolower($username); 
        
        $user_ip=(!empty($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : getenv('REMOTE_ADDR');
        $user_agent=$_SERVER['HTTP_USER_AGENT'];
        
        $stmt = "SELECT id FROM users WHERE username = ? AND ctrl__status=1 LIMIT 1";
        $query = $this->db->query($stmt, array($username)); 
        
        
        if ($query->num_rows() > 0) 
        { 
            $stmt2 = "SELECT id, username, password FROM users WHERE username = ? AND ctrl__status=1 LIMIT 1"; 
            $query2 = $this->db->query($stmt2, array($username)); 
            
            foreach ($query2->result() as $stmt2_results) 
            { 
                $user_id = $stmt2_results->id; 
                $username = $stmt2_results->username; 
                $db_password = $stmt2_results->password; 
            } 
            
            
            if($bypass !== TRUE)
            {
                // If the user exists we check if the account is locked 
                // from too many login attempts 
                
                if ($this->checkbrute($user_id) == true) 
                { 
                    // Account is locked 
                    // Send an email to user saying their account is locked 
                    
                    return false; 
                } 
                else 
                { 
                    
                    // Check if the password in the database matches 
                    // the password the user submitted. We are using 
                    // the password_verify function to avoid timing attacks. 
                    
                    if (password_verify($password, $db_password)) 
                    { 
                        
                        // Password is correct! 
                        // Get the user-agent string of the user. 
                        
                        $user_browser = $_SERVER['HTTP_USER_AGENT']; 
                        $user_id = preg_replace("/[^0-9]+/", "", $user_id); 
                        $_SESSION['user_id'] = $user_id; 
                        $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username); 
                        $_SESSION['username'] = $username;
                        $_SESSION['login_string'] = hash('sha512', $db_password . $user_browser); 
                        
                        // Login successful. 
                        
                        return true; 
                    }
                    else 
                    { 
                        
                        // Password is not correct 
                        // We record this attempt in the database 
                        
                        $now = now(); 
                        $datetime = date('Y-m-d H:i:s', $now); 
                        $stmt3 = "INSERT INTO login_attempts (uid, ip, agent, time_value, ctrl__status, date_time) VALUES (?, ?, ?, ?, 1, ?)"; 
                        $query3 = $this->db->query($stmt3, array($user_id, $user_ip, $user_agent, $now, $datetime)); 
                        
                        return false; 
                    } 
                }
            }
            else
            {
                if(password_verify($password, $db_password)) 
                { 
                    return true; 
                }
                else 
                {
                    return false;
                }
            }
             
        } 
        
        else 
        { 
            
            // No user exists.
            
            return false; 
        } 
    } 



    protected function checkbrute($user_id) 
    { 
        
        /* checkbrute configuration start */ 
        
        $use_checkbrute_func = $this->config->item('use_checkbrute', 'checkbrute'); 
        $allowed_attempts_count = $this->config->item('allowed_attempts', 'checkbrute'); 
        
        /* All login attempts are counted from the past 2 hours. */ 
        /* set value in seconds */ 
        
        $checkbrute_time_duration = $this->config->item('time_duration', 'checkbrute'); 
        
        /* checkbrute configuration end */ 
        
        
        if ($use_checkbrute_func === TRUE) 
        { 
            
            // Get timestamp of current time 
            
            $now = now(); 
            
            $valid_attempts = $now - $checkbrute_time_duration; 
            
            $stmt = "SELECT id FROM login_attempts WHERE uid = ? AND time_value > ? AND ctrl__status=1";
            $query = $this->db->query($stmt, array($user_id, $valid_attempts)); 
            
            
            // If there have been more than $allowed_attempts_count failed logins 
            
            if ($query->num_rows() > $allowed_attempts_count) 
            { 
                return true; 
            } 
            else 
            { 
                return false; 
            } 
        
        } 
        
        else 
        { 
            
            /* we are not using checkbrute function */
            
            return FALSE; 
        } 
        
    }



    public function login_check() 
    { 
        
        // Check if all session variables are set 
        
        if (isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) 
        { 
            
            $user_id = $_SESSION['user_id']; 
            $login_string = $_SESSION['login_string']; 
            $username = $_SESSION['username']; 
            $user_browser = $_SERVER['HTTP_USER_AGENT']; 
            
            $stmt = "SELECT username FROM users WHERE id = ? LIMIT 1"; 
            $query = $this->db->query($stmt, array($user_id)); 
            
            
            if ($query->num_rows() > 0) 
            { 
                
                // If the user exists get variables from result. 
                
                $stmt2 = "SELECT password FROM users WHERE id = ? LIMIT 1"; 
                $query2 = $this->db->query($stmt2, array($user_id)); 
                
                foreach ($query2->result() as $stmt2_results) { 
                    
                    $password = $stmt2_results->password; 
                    
                } 
                
                
                $login_check = hash('sha512', $password . $user_browser); 
                
                if (hash_equals($login_check, $login_string)) 
                { 
                    
                    // Logged In!!!! 
                    
                    return true; 
                } 
                
                else 
                { 
                    
                    // Not logged in 
                    
                    return false; 
                } 
                
            } 
            
            
            else 
            { 
                
                // user does not exists
                
                return false; 
            } 
            
        } 
        
        
    else { 
        
        // Not logged in 
        
        return false; 
        } 
        
    }



} 

?>