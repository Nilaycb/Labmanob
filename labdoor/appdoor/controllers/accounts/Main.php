<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller 
{ 

    public function  __construct()
    {
        parent::__construct(); 
        $this->load->model('accounts/login_model', 'login_model'); 
        
    } 



    public function index() 
    {
        if ($this->login_model->login_check() === TRUE) 
        {
            redirect('accounts/change_password', 'refresh'); 
            /*
            $h_view_data = array(); 
            $view_data = array(); 
            $f_view_data = array(); 
            
            $h_view_data['title'] = "Accounts Home"; 
            
            $this->load->view('header', $h_view_data); 
            $this->load->view('accounts/l_col_main', $view_data); 
            $this->load->view('accounts/m_col_main', $view_data); 
            $this->load->view('accounts/r_col_main', $view_data); 
            $this->load->view('footer', $f_view_data);*/
        }
        else
        {
            redirect('accounts/login', 'refresh'); 
        }
    } 



}

?>