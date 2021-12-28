<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_category extends CI_Controller 
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



    public function index($id_input='') 
    {
        if ($this->login_model->login_check() === TRUE) 
        {
            if(strtolower($_SESSION['username']) != 'viewer')
            {
                $id = NULL;
                $id_input_ok = FALSE;

                if ($id_input == '') 
                { 
                    $id_input_ok = FALSE; 
                } 
                else if ((($id_input != '') || (!empty($id_input))) && (preg_match('/^[1-9][0-9]*$/', $id_input))) 
                { 
                    $id_input_ok = TRUE;
                    $id = $id_input;
                }
                else 
                {
                    $id_input_ok = FALSE;
                    show_404(current_url());
                }

                if(isset($id) && ($id_input_ok === TRUE))
                {
                    if($this->labmanob_view_model->count_test_categories_by_id($id) > 0)
                    {
                        $test_category = $this->labmanob_view_model->test_category($id, TRUE);
                        $test_category = $test_category[0];


                        $this->form_validation->set_rules('category_name', 'Category Name', 'trim|required|max_length[150]'); 
                        
                        $this->form_validation->set_rules('category_codename', 'Category Code Name', 'trim|required|max_length[150]|callback_category_codename_not_exists_from_id['.$test_category->id.']'); 
                        $this->form_validation->set_message('category_codename_not_exists_from_id', 'The %s already exists! Try another.'); 
                        
                        $this->form_validation->set_rules('category_description', 'Category Description', 'trim|max_length[255]'); 
                        

                        if ($this->form_validation->run() == FALSE) 
                        {
                            $h_view_data = array(); 
                            $view_data = array(); 
                            $f_view_data = array(); 
                        
                            $h_view_data['title'] = "Edit Test Category"; 
                            $view_data['summary'] = $this->labmanob_summary_model->get_full_summary();                 

                            $view_data['test_category'] = $test_category;

                            $this->load->view('header', $h_view_data); 
                            $this->load->view('labmanob/l_col_main', $view_data); 
                            $this->load->view('labmanob/edit/test_category/m_col_main', $view_data); 
                            $this->load->view('labmanob/r_col_main', $view_data); 
                            $this->load->view('footer', $f_view_data);
                        }
                        else 
                        {
                            //success
                            $category_name = $this->input->post('category_name'); 
                            $category_codename = $this->input->post('category_codename'); 
                            $category_description = $this->input->post('category_description'); 
                            
                            $db_data = array(
                                'category_name' => $category_name, 
                                'category_codename' => $category_codename, 
                                'category_description' => $category_description, 
                                'ctrl__status' => 1
                            ); 
                            
                            
                            if ($this->labmanob_edit_model->test_category($db_data, $id) === TRUE) 
                            { 
                                // ALL Done and Success
                                // log the username who updated the information
                                log_message('error', '===== EDIT ACTION INFORMATION =====> Username: '.$_SESSION['username'].' ----- User ID: '.$_SESSION['user_id'].' ----- Test Category ID: '.$id.' ----- Updated Test Category info.');

                                $this->session->set_flashdata('message_display', 'Test Category Updated!'); 
                                redirect('labmanob/edit/test_category/index/'.$test_category->id, 'refresh');
                                
                                $h_view_data = array(); 
                                $view_data = array(); 
                                $f_view_data = array(); 
                            
                                $h_view_data['title'] = "Edit Test Category"; 
                                $view_data['summary'] = $this->labmanob_summary_model->get_full_summary();                 

                                $view_data['test_category'] = $test_category;

                                $this->load->view('header', $h_view_data); 
                                $this->load->view('labmanob/l_col_main', $view_data); 
                                $this->load->view('labmanob/edit/test_category/m_col_main', $view_data); 
                                $this->load->view('labmanob/r_col_main', $view_data); 
                                $this->load->view('footer', $f_view_data);
                                
                            }
                            else
                            {
                                $h_view_data = array(); 
                                $view_data = array(); 
                                $f_view_data = array(); 
                            
                                $h_view_data['title'] = "Edit Test Category"; 
                                $view_data['summary'] = $this->labmanob_summary_model->get_full_summary();                 

                                $view_data['test_category'] = $test_category;
                                $view_data['error_message'] = "Some error occurred while updating test category database! Try again.";

                                $this->load->view('header', $h_view_data); 
                                $this->load->view('labmanob/l_col_main', $view_data); 
                                $this->load->view('labmanob/edit/test_category/m_col_main', $view_data); 
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

                    $this->form_validation->set_rules('test_category_id', 'Test Category ID', array('trim', 'required', 'is_natural', 'min_length[1]', 'max_length[11]', array('has_test_category_id', array($this->labmanob_add_model, 'has_test_category_id')))); 
                    $this->form_validation->set_message('has_test_category_id', 'The {field} does not exist! Please check and try again.'); 

                    if ($this->form_validation->run() == FALSE) 
                    {
                        $h_view_data = array(); 
                        $view_data = array(); 
                        $f_view_data = array(); 
                        
                        $h_view_data['title'] = "Select Test Category | Edit Test Category"; 
                        $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                        
                        $this->load->view('header', $h_view_data); 
                        $this->load->view('labmanob/l_col_main', $view_data); 
                        $this->load->view('labmanob/edit/test_category/m_col_select_test_category', $view_data);
                        $this->load->view('labmanob/r_col_main', $view_data); 
                        $this->load->view('footer', $f_view_data);
                    }
                    else
                    {
                        redirect('labmanob/edit/test_category/index/'.$this->input->post('test_category_id', TRUE), 'refresh');
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



    public function category_codename_not_exists_from_id($input, $test_category_id)
    {
        return $this->labmanob_edit_model->category_codename_not_exists_from_id($input, $test_category_id);
    }



} 

?>