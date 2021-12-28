<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller 
{ 

    public function  __construct()
    {
        parent::__construct(); 
        $this->load->helper(array('form')); 
        $this->load->library(array('session', 'form_validation', 'table')); 
        $this->load->model('accounts/login_model', 'login_model'); 
        $this->load->model('labmanob/labmanob_summary_model', 'labmanob_summary_model'); 
        $this->load->model('labmanob/labmanob_view_model', 'labmanob_view_model'); 
        $this->load->model('labmanob/labmanob_add_model', 'labmanob_add_model'); 
        $this->load->model('labmanob/labmanob_edit_model', 'labmanob_edit_model'); 
    } 



    public function index($test_id_input='') 
    {
        if ($this->login_model->login_check() === TRUE) 
        {
            if(strtolower($_SESSION['username']) != 'viewer')
            {
                $test_id = NULL;
                $test_id_input_ok = FALSE;

                if ($test_id_input == '') 
                { 
                    $test_id_input_ok = FALSE; 
                } 
                else if ((($test_id_input != '') || (!empty($test_id_input))) && (preg_match('/^[1-9][0-9]*$/', $test_id_input))) 
                { 
                    $test_id_input_ok = TRUE;
                    $test_id = $test_id_input;
                }
                else 
                {
                    $test_id_input_ok = FALSE;
                    show_404(current_url());
                }

                if(isset($test_id) && ($test_id_input_ok === TRUE))
                {
                    if($this->labmanob_view_model->count_tests_by_id($test_id) > 0)
                    {
                        $test = $this->labmanob_view_model->test($test_id, TRUE);
                        $test = $test[0];

                        if ($this->labmanob_view_model->count_test_categories_by_id($test->test_category_id) > 0) 
                        { 
                            $test_category = $this->labmanob_view_model->test_category($test->test_category_id, TRUE); 
                            $test_category = $test_category[0];

                            if ($test_category !== FALSE) 
                            { 
                                $test_category_codename = $test_category->category_codename; 
                            } 
                            else 
                            { 
                                $test_category_codename = ''; 
                            } 
                            
                        } 
                        else 
                        { 
                            $test_category_codename = ''; 
                        }

                        $test_categories = $this->labmanob_view_model->test_categories(FALSE, $blank_value='', TRUE); 

                        
                        $this->form_validation->set_rules('test_name', 'Test Name', 'trim|required|max_length[150]'); 
                        
                        $this->form_validation->set_rules('test_codename', 'Test Code Name', 'trim|required|max_length[150]|callback_test_codename_not_exists_from_id['.$test->id.']'); 
                        $this->form_validation->set_message('test_codename_not_exists_from_id', 'The %s already exists! Try another.'); 
                        
                        $this->form_validation->set_rules('test_category_id', 'Test Category', array('trim', 'required', 'max_length[11]', 'numeric',  array('has_test_category_id', array($this->labmanob_add_model, 'has_test_category_id')))); 
                        $this->form_validation->set_message('has_test_category_id', 'The {field} does not exist! Try again with correct {field} or add a new.'); 
                        
                        $this->form_validation->set_rules('test_price', 'Test Price', 'trim|required|max_length[15]|numeric'); 
                        
                        $this->form_validation->set_rules('test_description', 'Test Description', 'trim|max_length[255]'); 
                        

                        if ($this->form_validation->run() == FALSE) 
                        {
                            $h_view_data = array(); 
                            $view_data = array(); 
                            $f_view_data = array(); 
                        
                            $h_view_data['title'] = "Edit Test"; 
                            $view_data['summary'] = $this->labmanob_summary_model->get_full_summary();                 

                            $view_data['test'] = $test;
                            $view_data['test_category_codename'] = $test_category_codename;
                            $view_data['test_categories'] = $test_categories;

                            $this->load->view('header', $h_view_data); 
                            $this->load->view('labmanob/l_col_main', $view_data); 
                            $this->load->view('labmanob/edit/test/m_col_main', $view_data); 
                            $this->load->view('labmanob/r_col_main', $view_data); 
                            $this->load->view('footer', $f_view_data);
                        }
                        else 
                        {
                            //success
                            $test_name = $this->input->post('test_name'); 
                            $test_codename = $this->input->post('test_codename'); 
                            $test_category_id = $this->input->post('test_category_id'); 
                            $test_price = $this->input->post('test_price'); 
                            $test_description = $this->input->post('test_description'); 
                            
                            $db_data = array(
                                'test_name' => $test_name, 
                                'test_codename' => $test_codename, 
                                'test_category_id' => $test_category_id, 
                                'test_price' => $test_price, 
                                'test_description' => $test_description, 
                                'ctrl__status' => 1
                            ); 
                            
                            
                            if ($this->labmanob_edit_model->test($db_data, $test_id) === TRUE) 
                            { 
                                // ALL Done and Success
                                // log the username who updated the information
                                log_message('error', '===== EDIT ACTION INFORMATION =====> Username: '.$_SESSION['username'].' ----- User ID: '.$_SESSION['user_id'].' ----- Test ID: '.$test_id.' ----- Updated Test info.');

                                $this->session->set_flashdata('message_display', 'Test Updated!'); 
                                redirect('labmanob/edit/test/index/'.$test->id, 'refresh');
                                
                                $h_view_data = array(); 
                                $view_data = array(); 
                                $f_view_data = array(); 
                            
                                $h_view_data['title'] = "Edit Test"; 
                                $view_data['summary'] = $this->labmanob_summary_model->get_full_summary();                 

                                $view_data['test'] = $test;
                                $view_data['test_category_codename'] = $test_category_codename;
                                $view_data['test_categories'] = $test_categories;

                                $this->load->view('header', $h_view_data); 
                                $this->load->view('labmanob/l_col_main', $view_data); 
                                $this->load->view('labmanob/edit/test/m_col_main', $view_data); 
                                $this->load->view('labmanob/r_col_main', $view_data); 
                                $this->load->view('footer', $f_view_data);
                                
                            }
                            else
                            {
                                $h_view_data = array(); 
                                $view_data = array(); 
                                $f_view_data = array(); 
                            
                                $h_view_data['title'] = "Edit Test"; 
                                $view_data['summary'] = $this->labmanob_summary_model->get_full_summary();                 

                                $view_data['test'] = $test;
                                $view_data['test_category_codename'] = $test_category_codename;
                                $view_data['test_categories'] = $test_categories;
                                $view_data['error_message'] = "Some error occurred while updating test database! Try again.";

                                $this->load->view('header', $h_view_data); 
                                $this->load->view('labmanob/l_col_main', $view_data); 
                                $this->load->view('labmanob/edit/test/m_col_main', $view_data); 
                                $this->load->view('labmanob/r_col_main', $view_data); 
                                $this->load->view('footer', $f_view_data);
                            }
                        }
                    }
                    else
                    {
                        show_404(current_url());
                    }
                }
                else
                {
                    //No Test ID given
                    //Show Select Test form

                    $this->form_validation->set_rules('test_id', 'Test ID', array('trim', 'required', 'is_natural', 'min_length[1]', 'max_length[11]', array('has_test_id', array($this->labmanob_add_model, 'has_test_id')))); 
                    $this->form_validation->set_message('has_test_id', 'The {field} does not exist! Please check and try again.'); 

                    if ($this->form_validation->run() == FALSE) 
                    {
                        $h_view_data = array(); 
                        $view_data = array(); 
                        $f_view_data = array(); 
                        
                        $h_view_data['title'] = "Select Test | Edit Test"; 
                        $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                        
                        $this->load->view('header', $h_view_data); 
                        $this->load->view('labmanob/l_col_main', $view_data); 
                        $this->load->view('labmanob/edit/test/m_col_select_test', $view_data);
                        $this->load->view('labmanob/r_col_main', $view_data); 
                        $this->load->view('footer', $f_view_data);
                    }
                    else
                    {
                        redirect('labmanob/edit/test/index/'.$this->input->post('test_id', TRUE), 'refresh');
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



    public function test_codename_not_exists_from_id($input, $test_id)
    {
        return $this->labmanob_edit_model->test_codename_not_exists_from_id($input, $test_id);
    }



} 

?>