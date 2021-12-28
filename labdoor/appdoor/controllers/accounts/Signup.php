<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends CI_Controller 
{ 
    var $next = '/'; 
    var $token_length = 64; 

    public function  __construct()
    {
        parent::__construct(); 
        $this->load->helper(array('form')); 
        $this->load->library(array('session', 'form_validation')); 
        $this->load->model('accounts/login_model', 'login_model'); 
        $this->load->model('accounts/signup_model', 'signup_model');
        
    } 



    public function index() 
    {
        
        if ($this->login_model->login_check() === TRUE) 
        {
            redirect($this->next, 'refresh'); 
        }
        else
        {
            
            $this->load->config('signup'); 
            
            if($this->config->item('new_allowed', 'signup') === TRUE) 
            {
                
                $this->form_validation->set_rules('firstname', 'First Name', array('trim', 'required', 'max_length[100]', array('check_regex_firstname', array($this->signup_model, 'check_regex_firstname')))); 
                $this->form_validation->set_message('check_regex_firstname', 'The %s field may only contain alpha-numeric characters, underscores, spaces and must start with an alphabetical character!'); 
                
                $this->form_validation->set_rules('lastname', 'Last Name', array('trim', 'required', 'max_length[100]', array('check_regex_lastname', array($this->signup_model, 'check_regex_lastname')))); 
                $this->form_validation->set_message('check_regex_lastname', 'The %s field may only contain alpha-numeric characters, underscores, spaces and must start with an alphabetical character!'); 
                
                $this->form_validation->set_rules('username', 'Username', array('trim', 'required', 'alpha_numeric', 'min_length[5]', 'max_length[100]', array('username_not_exists', array($this->signup_model, 'username_not_exists')))); 
                $this->form_validation->set_message('username_not_exists', 'The %s already exists! Try another.'); 
                
                $this->form_validation->set_rules('email', 'Email', array('trim', 'required', 'valid_email', array('email_not_exists', array($this->signup_model, 'email_not_exists')))); 
                $this->form_validation->set_message('email_not_exists', 'The %s already exists! Try another.'); 
                
                $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]'); 
                
                $this->form_validation->set_rules('confpassword', 'Confirm Password', 'trim|required|matches[password]'); 
                
                
                if ($this->form_validation->run() == FALSE) 
                { 
                    $h_view_data = array(); 
                    $h_view_data['title'] = "Sign Up"; 
                    
                    $this->load->view('header_blank.php', $h_view_data);
                    $this->load->view('accounts/signup_form.php');
                    $this->load->view('footer_blank.php');
                }
                
                else 
                {
                    
                    $firstname = $this->input->post('firstname'); 
                    $lastname = $this->input->post('lastname'); 
                    $username = strtolower($this->input->post('username')); 
                    $email = $this->input->post('email'); 
                    $password = $this->input->post('password'); 
                    
                    $password = $this->signup_model->hash_the_password($password); 
                    
                    $this->load->helper('gen_pin_code'); 
                    $pin_code = func__gen_pin_code(); 
                    $token = bin2hex($this->security->get_random_bytes($this->token_length / 2)); 
                    $verified = $this->config->item('verified', 'signup'); 
                    
                    $db_data = array(
                        'username' => $username, 
                        'firstname' => $firstname, 
                        'lastname' => $lastname, 
                        'email' => $email, 
                        'password' => $password, 
                        'pin_code' => $pin_code, 
                        'token' => $token, 
                        'verified' => $verified, 
                        'ctrl__status' => 1
                    ); 
                    
                    
                    if ($this->signup_model->signup($db_data) === TRUE) 
                    { 
                        $this->session->set_flashdata('message_display', 'Sign Up successful!'); 
                        redirect(current_url(), 'refresh'); 
                        $h_view_data = array(); 
                        $h_view_data['title'] = "Sign Up"; 
                        
                        $this->load->view('header_blank.php', $h_view_data); 
                        $this->load->view('accounts/signup_form.php'); 
                        $this->load->view('footer_blank.php');
                    }
                    else 
                    { 
                        $h_view_data = array(); 
                        $view_data = array(); 
                        $h_view_data['title'] = "Sign Up"; 
                        $view_data['error_message'] = "Couldn't create new account!"; 
                        
                        $this->load->view('header_blank.php', $h_view_data); 
                        $this->load->view('accounts/signup_form.php', $view_data); 
                        $this->load->view('footer_blank.php');
                    }
                    
                    
                }
                
            }
            else 
            { 
                $h_view_data = array(); 
                $view_data = array(); 
                $h_view_data['title'] = "Sign Up"; 
                $view_data['error_message'] = "New Sign Up is currently not available!"; 
                
                $this->load->view('header_blank.php', $h_view_data); 
                $this->load->view('accounts/signup_form.php', $view_data); 
                $this->load->view('footer_blank.php');
                
            }
            
        }
        
    } 



} 

?>