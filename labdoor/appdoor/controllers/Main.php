<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller 
{

    public function  __construct()
    {
        parent::__construct();
        //$this->load->library(array('session'));
        $this->load->model('accounts/login_model', 'login_model'); 
        
    }



    public function index() 
    {
        
        if ($this->login_model->login_check() === TRUE) 
        { 
            redirect('labmanob', 'refresh'); 
        } 
        else 
        { 
            redirect('accounts', 'refresh'); 
        } 
    }



}

?>