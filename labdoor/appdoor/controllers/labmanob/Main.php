<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller 
{ 

    public function  __construct()
    {
        parent::__construct(); 
        $this->load->model('accounts/login_model', 'login_model'); 
        $this->load->model('labmanob/labmanob_summary_model', 'labmanob_summary_model'); 
        
    } 



    public function index() 
    {
        if ($this->login_model->login_check() === TRUE) 
        {
            $h_view_data = array(); 
            $view_data = array(); 
            $f_view_data = array(); 
            
            $h_view_data['title'] = "Labmanob Home"; 
            $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
            
            $this->load->view('header', $h_view_data); 
            $this->load->view('labmanob/l_col_main', $view_data); 
            $this->load->view('labmanob/m_col_main', $view_data); 
            $this->load->view('labmanob/r_col_main', $view_data); 
            $this->load->view('footer', $f_view_data);
        }
        else
        {
            redirect('accounts/login', 'refresh'); 
        }
    } 



}

?>