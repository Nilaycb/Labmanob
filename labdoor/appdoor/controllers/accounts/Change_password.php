<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Change_password extends CI_Controller 
{ 

    public function  __construct()
    {
        parent::__construct(); 
        $this->load->helper(array('form')); 
        $this->load->library(array('session', 'form_validation'));
        $this->load->model('accounts/login_model', 'login_model'); 
        $this->load->model('accounts/signup_model', 'signup_model');
        $this->load->model('accounts/accounts_edit_model', 'accounts_edit_model'); 
        
    } 



    public function index() 
    {
        if ($this->login_model->login_check() === TRUE) 
        {
            if(strtolower($_SESSION['username']) != 'viewer')
            {
                $this->form_validation->set_rules('password', 'Current Password', 'trim|required'); 
                $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[6]'); 
                $this->form_validation->set_rules('conf_password', 'Confirm Password', 'trim|required|matches[new_password]'); 
                
                
                if ($this->form_validation->run() == FALSE) 
                {
                    $h_view_data = array(); 
                    $view_data = array(); 
                    $f_view_data = array(); 
                    
                    $h_view_data['title'] = "Change Password - Accounts"; 
                    
                    $this->load->view('header', $h_view_data); 
                    $this->load->view('accounts/l_col_main', $view_data); 
                    $this->load->view('accounts/m_col_change_password', $view_data); 
                    $this->load->view('accounts/r_col_main', $view_data); 
                    $this->load->view('footer', $f_view_data);
                }
                else
                {
                    $password = $this->input->post('password');
                    $new_password = $this->input->post('new_password');
                    $conf_password = $this->input->post('conf_password');

                    if(empty($new_password) || empty($conf_password))
                    {
                        $h_view_data = array(); 
                        $view_data = array(); 
                        $f_view_data = array(); 

                        $h_view_data['title'] = "Change Password - Accounts"; 
                        $view_data['error_message'] = "New Password and Confirm Password fields are required!"; 
                        
                        $this->load->view('header', $h_view_data); 
                        $this->load->view('accounts/l_col_main', $view_data); 
                        $this->load->view('accounts/m_col_change_password', $view_data); 
                        $this->load->view('accounts/r_col_main', $view_data); 
                        $this->load->view('footer', $f_view_data);
                    }
                    else if($new_password != $conf_password)
                    {
                        $h_view_data = array(); 
                        $view_data = array(); 
                        $f_view_data = array(); 

                        $h_view_data['title'] = "Change Password - Accounts"; 
                        $view_data['error_message'] = "New Password and Confirm Password do not match!"; 
                        
                        $this->load->view('header', $h_view_data); 
                        $this->load->view('accounts/l_col_main', $view_data); 
                        $this->load->view('accounts/m_col_change_password', $view_data); 
                        $this->load->view('accounts/r_col_main', $view_data); 
                        $this->load->view('footer', $f_view_data);
                    }
                    else
                    {
                        if ($this->login_model->login($_SESSION['username'], $password, TRUE) === TRUE) 
                        { 
                            $new_password_hash = $this->signup_model->hash_the_password($new_password);

                            $db_data = array(
                                'password' => $new_password_hash
                            );

                            if($this->accounts_edit_model->user($db_data, $_SESSION['user_id']))
                            {
                                $this->session->set_flashdata('message_display', 'Password Changed!'); 
                                redirect(site_url('accounts/login'), 'refresh'); 

                                $h_view_data = array(); 
                                $view_data = array(); 
                                $f_view_data = array(); 
                                
                                $h_view_data['title'] = "Change Password - Accounts"; 
                                
                                $this->load->view('header', $h_view_data); 
                                $this->load->view('accounts/l_col_main', $view_data); 
                                $this->load->view('accounts/m_col_change_password', $view_data); 
                                $this->load->view('accounts/r_col_main', $view_data); 
                                $this->load->view('footer', $f_view_data);
                            }
                            else
                            {
                                $h_view_data = array(); 
                                $view_data = array(); 
                                $f_view_data = array(); 

                                $h_view_data['title'] = "Change Password - Accounts"; 
                                $view_data['error_message'] = "Couldn't Change Password!"; 
                                
                                $this->load->view('header', $h_view_data); 
                                $this->load->view('accounts/l_col_main', $view_data); 
                                $this->load->view('accounts/m_col_change_password', $view_data); 
                                $this->load->view('accounts/r_col_main', $view_data); 
                                $this->load->view('footer', $f_view_data);
                            }
                        }
                        else 
                        { 
                            $h_view_data = array(); 
                            $view_data = array(); 
                            $f_view_data = array(); 

                            $h_view_data['title'] = "Change Password - Accounts"; 
                            $view_data['error_message'] = "Incorrect Current Password!"; 
                            
                            $this->load->view('header', $h_view_data); 
                            $this->load->view('accounts/l_col_main', $view_data); 
                            $this->load->view('accounts/m_col_change_password', $view_data); 
                            $this->load->view('accounts/r_col_main', $view_data); 
                            $this->load->view('footer', $f_view_data);
                        }
                    }
                }
            }
            else 
            {
                $h_view_data = array(); 
                $view_data = array(); 
                $f_view_data = array(); 
                $h_view_data['title'] = "Access Denied"; 
                
                $this->load->view('errors/access/header', $h_view_data); 
                $this->load->view('errors/access/l_col_main', $view_data); 
                $this->load->view('errors/access/m_col_access_denied', $view_data); 
                $this->load->view('errors/access/r_col_main', $view_data); 
                $this->load->view('errors/access/footer', $f_view_data); 
            }
        }
        else
        {
            redirect('accounts/login', 'refresh'); 
        }
    } 



}

?>