<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller 
{ 

    public function  __construct()
    {
        parent::__construct(); 
        $this->load->library(array('session')); 
        $this->load->model('accounts/login_model', 'login_model'); 
        
    } 



    public function index() 
    {
        $_SESSION = array(); 
        unset($this->session); 
        session_destroy(); 
        redirect('accounts/login', 'refresh'); 
    } 



} 

?>