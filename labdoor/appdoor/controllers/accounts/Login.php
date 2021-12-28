<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller 
{ 
    var $next = '/'; 

    public function  __construct()
    {
        parent::__construct(); 
        $this->load->helper(array('form')); 
        $this->load->library(array('session', 'form_validation')); 
        $this->load->model('accounts/login_model', 'login_model'); 
        
    } 



    public function index() 
    {
        
        if ($this->login_model->login_check() === TRUE) 
        {
            redirect($this->next, 'refresh'); 
        }
        else
        {
            
            $this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric|min_length[5]|max_length[30]'); 
            $this->form_validation->set_rules('password', 'Password', 'trim|required'); 
            
            
            if ($this->form_validation->run() == FALSE) 
            { 
                $h_view_data = array(); 
                $h_view_data['title'] = "Log In"; 
                
                $this->load->view('header_blank.php', $h_view_data);
                $this->load->view('accounts/login_form.php');
                $this->load->view('footer_blank.php');
            }
            
            else 
            {
                $username = $this->input->post('username'); 
                $password = $this->input->post('password');
                if ($this->login_model->login($username, $password) === TRUE) 
                { 
                    redirect($this->next, 'refresh'); 
                }
                else 
                { 
                    $h_view_data = array(); 
                    $view_data = array(); 
                    $h_view_data['title'] = "Log In"; 
                    $view_data['error_message'] = "Incorrect Username or Password!"; 
                    
                    $this->load->view('header_blank.php', $h_view_data); 
                    $this->load->view('accounts/login_form.php', $view_data); 
                    $this->load->view('footer_blank.php');
                }
            }
            
            
        }
        
    } 



} 

?>