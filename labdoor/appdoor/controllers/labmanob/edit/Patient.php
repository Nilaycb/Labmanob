<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patient extends CI_Controller 
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
                    if($this->labmanob_view_model->count_patients_by_id($id) > 0)
                    {
                        $patient = $this->labmanob_view_model->test_invoice_patient($id, TRUE);
                        $patient = $patient[0];


                        $this->form_validation->set_rules('firstname', 'First Name', array('trim', 'required', 'max_length[100]', array('check_regex_firstname', array($this->labmanob_add_model, 'check_regex_firstname')))); 
                        $this->form_validation->set_message('check_regex_firstname', 'The %s field may only contain alpha-numeric characters, underscores, spaces and must start with an alphabetical character!'); 
                        
                        $this->form_validation->set_rules('lastname', 'Last Name', array('trim', 'required', 'max_length[100]', array('check_regex_lastname', array($this->labmanob_add_model, 'check_regex_lastname')))); 
                        $this->form_validation->set_message('check_regex_lastname', 'The %s field may only contain alpha-numeric characters, underscores, spaces and must start with an alphabetical character!'); 
                        
                        $this->form_validation->set_rules('sex', 'Sex', 'trim|required|alpha|max_length[15]'); 
                        
                        $this->form_validation->set_rules('phone_no', 'Phone Number(s)', array('trim', 'required', 'max_length[100]', array('check_regex_phone_no', array($this->labmanob_add_model, 'check_regex_phone_no')))); 
                        $this->form_validation->set_message('check_regex_phone_no', 'The {field} field must contain valid {field}. Use comma(,) to separate more than one {field}.'); 
                        
                        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email'); 
                        
                        $this->form_validation->set_rules('current_address', 'Current Address', 'trim|required|max_length[255]'); 
                        
                        $this->form_validation->set_rules('current_city', 'Current City', 'trim|required|max_length[50]'); 
                        
                        $this->form_validation->set_rules('permanent_address', 'Permanent Address', 'trim|max_length[255]'); 
                        
                        $this->form_validation->set_rules('permanent_city', 'Permanent City', 'trim|max_length[50]'); 
                        
                        $this->form_validation->set_rules('extra_info', 'Extra Information', 'trim|max_length[255]');         
                        

                        if ($this->form_validation->run() == FALSE) 
                        {
                            $h_view_data = array(); 
                            $view_data = array(); 
                            $f_view_data = array(); 

                            /* codes for patient image generation start { */
                            if(!empty($patient))
                            {
                                $this->load->library('files_library');
                                $get_file_by_id_result = $this->files_library->get_file_by_id__db($patient->img_id, FALSE);

                                if(($get_file_by_id_result != FALSE) && isset($get_file_by_id_result)) 
                                {
                                    $get_file_by_id_result = $get_file_by_id_result[0];

                                    $view_data['patient_image_data'] = $get_file_by_id_result;
                                    
                                    if(isset($get_file_by_id_result['encode_level']) && ($get_file_by_id_result['encode_level'] != 0)) 
                                    {
                                        $encoded_patient_image_data = $this->files_library->get_encoded_image_data($get_file_by_id_result, $get_file_by_id_result['encode_level'], FALSE);
                                        
                                        if($encoded_patient_image_data !== FALSE)
                                        {
                                            $view_data['encoded_patient_image_data'] = $encoded_patient_image_data;
                                        }
                                    }
                                }
                            }
                            /* } codes for patient image generation end */
                        
                            $h_view_data['title'] = "Edit Patient"; 
                            $view_data['summary'] = $this->labmanob_summary_model->get_full_summary();                 

                            $view_data['patient'] = $patient;

                            $this->load->view('header', $h_view_data); 
                            $this->load->view('labmanob/l_col_main', $view_data); 
                            $this->load->view('labmanob/edit/patient/m_col_main', $view_data); 
                            $this->load->view('labmanob/r_col_main', $view_data); 
                            $this->load->view('footer', $f_view_data);
                        }
                        else 
                        {
                            //success

                            /** remove comma from both side **/ 
                            $phone_no_input = trim($this->input->post('phone_no'), ','); 
                            
                            /** create an array of phone number(s) and remove and add whitespaces equally in array **/
                            $phone_no_input_array = array_map('trim', explode(',', $phone_no_input)); 
                            
                            /** after that generate string from the array again **/
                            $phone_no_filtered = implode(', ', $phone_no_input_array); 
                            
                            
                            $firstname = $this->input->post('firstname'); 
                            $lastname = $this->input->post('lastname'); 
                            $sex = $this->input->post('sex'); 
                            $phone_no = $phone_no_filtered;  
                            $email = $this->input->post('email'); 
                            $img_id = 1; 
                            $current_address = $this->input->post('current_address'); 
                            $current_city = $this->input->post('current_city'); 
                            $permanent_address = $this->input->post('permanent_address'); 
                            $permanent_city = $this->input->post('permanent_city'); 
                            $extra_info = $this->input->post('extra_info'); 
                            
                            $db_data = array(
                                'firstname' => $firstname, 
                                'lastname' => $lastname, 
                                'sex' => $sex, 
                                'phone_no' => $phone_no, 
                                'email' => $email, 
                                'img_id' => $img_id, 
                                'current_address' => $current_address, 
                                'permanent_address' => $permanent_address, 
                                'current_city' => $current_city, 
                                'permanent_city' => $permanent_city, 
                                'extra_info' => $extra_info, 
                                'ctrl__status' => 1
                            ); 
                            
                            
                            if ($this->labmanob_edit_model->patient($db_data, $id) === TRUE) 
                            { 
                                // ALL Done and Success
                                // log the username who updated the information
                                log_message('error', '===== EDIT ACTION INFORMATION =====> Username: '.$_SESSION['username'].' ----- User ID: '.$_SESSION['user_id'].' ----- Patient ID: '.$id.' ----- Updated Patient info.');

                                $this->session->set_flashdata('message_display', 'Patient Updated!'); 
                                redirect('labmanob/edit/patient/index/'.$patient->id, 'refresh');
                                
                                $h_view_data = array(); 
                                $view_data = array(); 
                                $f_view_data = array(); 

                                /* codes for patient image generation start { */
                                if(!empty($patient))
                                {
                                    $this->load->library('files_library');
                                    $get_file_by_id_result = $this->files_library->get_file_by_id__db($patient->img_id, FALSE);

                                    if(($get_file_by_id_result != FALSE) && isset($get_file_by_id_result)) 
                                    {
                                        $get_file_by_id_result = $get_file_by_id_result[0];

                                        $view_data['patient_image_data'] = $get_file_by_id_result;
                                        
                                        if(isset($get_file_by_id_result['encode_level']) && ($get_file_by_id_result['encode_level'] != 0)) 
                                        {
                                            $encoded_patient_image_data = $this->files_library->get_encoded_image_data($get_file_by_id_result, $get_file_by_id_result['encode_level'], FALSE);
                                            
                                            if($encoded_patient_image_data !== FALSE)
                                            {
                                                $view_data['encoded_patient_image_data'] = $encoded_patient_image_data;
                                            }
                                        }
                                    }
                                }
                                /* } codes for patient image generation end */
                            
                                $h_view_data['title'] = "Edit Patient"; 
                                $view_data['summary'] = $this->labmanob_summary_model->get_full_summary();                 

                                $view_data['patient'] = $patient;

                                $this->load->view('header', $h_view_data); 
                                $this->load->view('labmanob/l_col_main', $view_data); 
                                $this->load->view('labmanob/edit/patient/m_col_main', $view_data); 
                                $this->load->view('labmanob/r_col_main', $view_data); 
                                $this->load->view('footer', $f_view_data);
                                
                            }
                            else
                            {
                                $h_view_data = array(); 
                                $view_data = array(); 
                                $f_view_data = array(); 

                                /* codes for patient image generation start { */
                                if(!empty($patient))
                                {
                                    $this->load->library('files_library');
                                    $get_file_by_id_result = $this->files_library->get_file_by_id__db($patient->img_id, FALSE);

                                    if(($get_file_by_id_result != FALSE) && isset($get_file_by_id_result)) 
                                    {
                                        $get_file_by_id_result = $get_file_by_id_result[0];

                                        $view_data['patient_image_data'] = $get_file_by_id_result;
                                        
                                        if(isset($get_file_by_id_result['encode_level']) && ($get_file_by_id_result['encode_level'] != 0)) 
                                        {
                                            $encoded_patient_image_data = $this->files_library->get_encoded_image_data($get_file_by_id_result, $get_file_by_id_result['encode_level'], FALSE);
                                            
                                            if($encoded_patient_image_data !== FALSE)
                                            {
                                                $view_data['encoded_patient_image_data'] = $encoded_patient_image_data;
                                            }
                                        }
                                    }
                                }
                                /* } codes for patient image generation end */
                            
                                $h_view_data['title'] = "Edit Patient"; 
                                $view_data['summary'] = $this->labmanob_summary_model->get_full_summary();                 

                                $view_data['patient'] = $patient;
                                $view_data['error_message'] = "Some error occurred while updating patient database! Try again.";

                                $this->load->view('header', $h_view_data); 
                                $this->load->view('labmanob/l_col_main', $view_data); 
                                $this->load->view('labmanob/edit/patient/m_col_main', $view_data); 
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
                    //No Patient ID given
                    //Show Select Patient form

                    $this->form_validation->set_rules('patient_id', 'Patient ID', array('trim', 'required', 'is_natural', 'min_length[1]', 'max_length[11]', array('has_patient_id', array($this->labmanob_add_model, 'has_patient_id')))); 
                    $this->form_validation->set_message('has_patient_id', 'The {field} does not exist! Please check and try again.'); 

                    if ($this->form_validation->run() == FALSE) 
                    {
                        $h_view_data = array(); 
                        $view_data = array(); 
                        $f_view_data = array(); 
                        
                        $h_view_data['title'] = "Select Patient | Edit Patient"; 
                        $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                        
                        $this->load->view('header', $h_view_data); 
                        $this->load->view('labmanob/l_col_main', $view_data); 
                        $this->load->view('labmanob/edit/patient/m_col_select_patient', $view_data);
                        $this->load->view('labmanob/r_col_main', $view_data); 
                        $this->load->view('footer', $f_view_data);
                    }
                    else
                    {
                        redirect('labmanob/edit/patient/index/'.$this->input->post('patient_id', TRUE), 'refresh');
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