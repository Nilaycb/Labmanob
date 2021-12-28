<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add extends CI_Controller 
{ 

    public function  __construct()
    {
        parent::__construct(); 
        $this->load->helper(array('form')); 
        $this->load->library(array('session', 'form_validation', 'pagination', 'table', 'cart')); 
        $this->load->model('accounts/login_model', 'login_model'); 
        $this->load->model('labmanob/labmanob_summary_model', 'labmanob_summary_model'); 
        $this->load->model('labmanob/labmanob_view_model', 'labmanob_view_model'); 
        $this->load->model('labmanob/labmanob_search_model', 'labmanob_search_model'); 
        $this->load->model('labmanob/labmanob_add_model', 'labmanob_add_model'); 
        
    } 



    public function index() 
    { 
        
        if ($this->login_model->login_check() === TRUE) 
        {
            if(strtolower($_SESSION['username']) != 'viewer')
            {
                $h_view_data = array(); 
                $view_data = array(); 
                $f_view_data = array(); 
                
                $h_view_data['title'] = "Add"; 
                $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                
                $this->load->view('header', $h_view_data); 
                $this->load->view('labmanob/l_col_main', $view_data); 
                $this->load->view('labmanob/add/m_col_main', $view_data); 
                $this->load->view('labmanob/r_col_main', $view_data); 
                $this->load->view('footer', $f_view_data);
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



    public function new_patient() 
    { 
        
        if ($this->login_model->login_check() === TRUE) 
        { 
            if(strtolower($_SESSION['username']) != 'viewer')
            {
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
                
                $this->form_validation->set_rules('upload_patient_image', 'Upload new patient image', 'trim'); 
                
                $this->form_validation->set_rules('add_to_test_invoice', 'Add patient to new test invoice', 'trim'); 
                
                
                if ($this->form_validation->run() == FALSE) 
                { 
                    $h_view_data = array(); 
                    $view_data = array(); 
                    $f_view_data = array(); 
                    $h_view_data['title'] = "Add New Patient"; 
                    $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                    
                    $this->load->view('header', $h_view_data); 
                    $this->load->view('labmanob/l_col_main', $view_data); 
                    $this->load->view('labmanob/add/m_col_patients', $view_data); 
                    $this->load->view('labmanob/r_col_main', $view_data); 
                    $this->load->view('footer', $f_view_data); 
                    
                } 
                else 
                { 
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
                    
                    
                    $add_new_patient_result = $this->labmanob_add_model->new_patient($db_data); 
                    
                    if (($add_new_patient_result !== FALSE) && isset($add_new_patient_result))
                    { 
                        //success
                        //log this action
                        log_message('error', '===== ADD ACTION INFORMATION =====> Username: '.$_SESSION['username'].' ----- User ID: '.$_SESSION['user_id'].' ----- Patient ID: '.$add_new_patient_result.' ----- Added New Patient.');

                        $this->session->set_flashdata('message_display', 'New Patient added successfully! Patient ID <b>'.$add_new_patient_result.'</b>'); 
                        
                        $redirect_second = 5;

                        if (($this->input->post('upload_patient_image')) && (strtolower($this->input->post('upload_patient_image')) == 'yes')) 
                        { 
                            $this->load->model('labmanob/labmanob_upload_model', 'labmanob_upload_model'); 
                            $this->labmanob_upload_model->clear_patient_image_sess();

                            $_SESSION['upload_patient_image__patient_id'] = $add_new_patient_result; 

                            if (($this->input->post('add_to_test_invoice')) && (strtolower($this->input->post('add_to_test_invoice')) == 'yes')) 
                            { 
                                $_SESSION['upload_patient_image__redirect_to_add_new_test_invoice'] = $add_new_patient_result; 

                                $this->session->set_flashdata('redirect_second', $redirect_second); 
                                $this->session->set_flashdata('redirect_url', site_url('labmanob/upload/patient_image')); 
                                $this->session->set_flashdata('message_upload_patient_image', 'Patient ID <b>'.$_SESSION['upload_patient_image__patient_id'].'</b> set for patient image upload and added to new test invoice. If this page does not redirect automatically in '.$redirect_second.' seconds, go to upload patient image.');
                            }
                            else 
                            {
                                $this->session->set_flashdata('redirect_second', $redirect_second); 
                                $this->session->set_flashdata('redirect_url', site_url('labmanob/upload/patient_image')); 
                                $this->session->set_flashdata('message_upload_patient_image', 'Patient ID <b>'.$_SESSION['upload_patient_image__patient_id'].'</b> set for patient image upload. If this page does not redirect automatically in '.$redirect_second.' seconds, go to upload patient image.');
                            } 
                        } 
                        else if (($this->input->post('add_to_test_invoice')) && (strtolower($this->input->post('add_to_test_invoice')) == 'yes')) 
                        { 
                            $_SESSION['test_invoice__patient_id'] = $add_new_patient_result; 
                            $this->session->set_flashdata('redirect_second', $redirect_second); 
                            $this->session->set_flashdata('redirect_url', site_url('labmanob/add/new_test_invoice')); 
                            $this->session->set_flashdata('message_add_to_test_invoice', 'Patient ID <b>'.$_SESSION['test_invoice__patient_id'].'</b> added to new test invoice. If this page does not redirect automatically in '.$redirect_second.' seconds, go to add new test invoice.'); 
                        } 
                        
                        redirect(current_url(), 'refresh'); 
                        
                        $h_view_data = array(); 
                        $view_data = array(); 
                        $f_view_data = array(); 
                        $h_view_data['title'] = "Add New Patient"; 
                        $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                        
                        $this->load->view('header', $h_view_data); 
                        $this->load->view('labmanob/l_col_main', $view_data); 
                        $this->load->view('labmanob/add/m_col_patients', $view_data); 
                        $this->load->view('labmanob/r_col_main', $view_data); 
                        $this->load->view('footer', $f_view_data); 
                        
                    } 
                    else 
                    { 
                        $h_view_data = array(); 
                        $view_data = array(); 
                        $f_view_data = array(); 
                        $h_view_data['title'] = "Add New Patient"; 
                        $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                        $view_data['error_message'] = "Couldn't add new patient!"; 
                        
                        $this->load->view('header', $h_view_data); 
                        $this->load->view('labmanob/l_col_main', $view_data); 
                        $this->load->view('labmanob/add/m_col_patients', $view_data); 
                        $this->load->view('labmanob/r_col_main', $view_data); 
                        $this->load->view('footer', $f_view_data); 
                        
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



    public function new_affiliate_partner() 
    { 
        
        if ($this->login_model->login_check() === TRUE) 
        { 
            if(strtolower($_SESSION['username']) != 'viewer')
            {
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
                
                $this->form_validation->set_rules('upload_affiliate_partner_image', 'Upload new affiliate partner image', 'trim'); 
                
                
                if ($this->form_validation->run() == FALSE) 
                { 
                    $h_view_data = array(); 
                    $view_data = array(); 
                    $f_view_data = array(); 
                    $h_view_data['title'] = "Add New Affiliate Partner"; 
                    $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                    
                    $this->load->view('header', $h_view_data); 
                    $this->load->view('labmanob/l_col_main', $view_data); 
                    $this->load->view('labmanob/add/m_col_affiliate_partners', $view_data); 
                    $this->load->view('labmanob/r_col_main', $view_data); 
                    $this->load->view('footer', $f_view_data); 
                    
                } 
                else 
                { 
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
                    
                    
                    $add_new_affiliate_partner_result = $this->labmanob_add_model->new_affiliate_partner($db_data); 
                    
                    if (($add_new_affiliate_partner_result !== FALSE) && isset($add_new_affiliate_partner_result))
                    { 
                        //success
                        //log this action
                        log_message('error', '===== ADD ACTION INFORMATION =====> Username: '.$_SESSION['username'].' ----- User ID: '.$_SESSION['user_id'].' ----- Affiliate Partner ID: '.$add_new_affiliate_partner_result.' ----- Added New Affiliate Partner.');

                        $this->session->set_flashdata('message_display', 'New Affiliate Partner added successfully! Affiliate Partner ID <b>'.$add_new_affiliate_partner_result.'</b>'); 
                        
                        $redirect_second = 5;

                        if (($this->input->post('upload_affiliate_partner_image')) && (strtolower($this->input->post('upload_affiliate_partner_image')) == 'yes')) 
                        { 
                            $this->load->model('labmanob/labmanob_upload_model', 'labmanob_upload_model'); 
                            $this->labmanob_upload_model->clear_affiliate_partner_image_sess();

                            $_SESSION['upload_affiliate_partner_image__affiliate_partner_id'] = $add_new_affiliate_partner_result; 
                            
                            $this->session->set_flashdata('redirect_second', $redirect_second); 
                            $this->session->set_flashdata('redirect_url', site_url('labmanob/upload/affiliate_partner_image')); 
                            $this->session->set_flashdata('message_upload_affiliate_partner_image', 'Affiliate Partner ID <b>'.$_SESSION['upload_affiliate_partner_image__affiliate_partner_id'].'</b> set for affiliate partner image upload. If this page does not redirect automatically in '.$redirect_second.' seconds, go to upload affiliate partner image.'); 
                        } 
                        
                        redirect(current_url(), 'refresh'); 
                        
                        $h_view_data = array(); 
                        $view_data = array(); 
                        $f_view_data = array(); 
                        $h_view_data['title'] = "Add New Affiliate Partner"; 
                        $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                        
                        $this->load->view('header', $h_view_data); 
                        $this->load->view('labmanob/l_col_main', $view_data); 
                        $this->load->view('labmanob/add/m_col_affiliate_partners', $view_data); 
                        $this->load->view('labmanob/r_col_main', $view_data); 
                        $this->load->view('footer', $f_view_data); 
                        
                    } 
                    else 
                    { 
                        $h_view_data = array(); 
                        $view_data = array(); 
                        $f_view_data = array(); 
                        $h_view_data['title'] = "Add New Affiliate Partner"; 
                        $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                        $view_data['error_message'] = "Couldn't add new affiliate partner!"; 
                        
                        $this->load->view('header', $h_view_data); 
                        $this->load->view('labmanob/l_col_main', $view_data); 
                        $this->load->view('labmanob/add/m_col_affiliate_partners', $view_data); 
                        $this->load->view('labmanob/r_col_main', $view_data); 
                        $this->load->view('footer', $f_view_data); 
                        
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



    public function new_test_invoice($step_input='') 
    { 
        $step_input = strtolower($step_input); 
        
        if ($step_input == '') 
        { 
            $step = 'select_patient'; 
        } 
        else if ($step_input == 'remove_patient') 
        { 
            $step = 'remove_patient'; 
        } 
        else if ($step_input == 'select_tests') 
        { 
            $step = 'select_tests'; 
        } 
        else if ($step_input == 'set_tests_records') 
        { 
            $step = 'set_tests_records'; 
        } 
        else if ($step_input == 'set_payment') 
        { 
            $step = 'set_payment'; 
        } 
        else if ($step_input == 'finish') 
        { 
            $step = 'finish'; 
        } 
        else 
        { 
            show_404(current_url()); 
        } 
        
        
        if ($this->login_model->login_check() === TRUE) 
        { 
            if(strtolower($_SESSION['username']) != 'viewer')
            {
            
                /** step select_patient start { **/ 
                
                if ($step == 'select_patient') 
                { 
                    
                    /** step select_patient(1) start { **/ 
                    
                    if (isset($_SESSION['test_invoice__patient_id']) && ($_SESSION['test_invoice__patient_id'] != '')) 
                    { 
                        $patients_array = $this->labmanob_search_model->patients_by_id($_SESSION['test_invoice__patient_id'], FALSE); 
                        
                        if ($patients_array !== FALSE) 
                        { 
                            $h_view_data = array(); 
                            $view_data = array(); 
                            $f_view_data = array(); 
                            
                            foreach ($patients_array as $patient) 
                            { 
                                $_SESSION['test_invoice__patient'] = $patient; 
                                $view_data['patient'] = $patient; 
                            } 

                            /* codes for patient image generation start { */
                            if(!empty($patient))
                            {
                                $this->load->library('files_library');
                                $get_file_by_id_result = $this->files_library->get_file_by_id__db($patient['img_id'], FALSE);

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
                            
                            $h_view_data['title'] = 'Select Patient - Add New Test Invoice'; 
                            $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                            
                            $this->load->view('header', $h_view_data); 
                            $this->load->view('labmanob/l_col_main', $view_data); 
                            $this->load->view('labmanob/add/test_invoices/m_col_selected_patient', $view_data); 
                            $this->load->view('labmanob/r_col_main', $view_data); 
                            $this->load->view('footer', $f_view_data); 
                        } 
                        else 
                        { 
                            show_error('System was unable to face patient informations using the new test invoice patient id'); 
                            /** a log for this error can be set here using the test_invoice__patient_id **/
                        } 
                    } 
                    
                    /** step select_patient(1) end } **/ 
                    
                    
                    /** step select_patient(2) start { **/ 
                    
                    else 
                    { 
                        
                        $this->form_validation->set_rules('patient_id', 'Patient ID', array('trim', 'required', 'is_natural', 'min_length[1]', 'max_length[11]', array('has_patient_id', array($this->labmanob_add_model, 'has_patient_id')))); 
                        $this->form_validation->set_message('has_patient_id', 'The {field} does not exist! Please check and try again.'); 
                        
                        if ($this->form_validation->run() == FALSE) 
                        { 
                            $h_view_data = array(); 
                            $view_data = array(); 
                            $f_view_data = array(); 
                            
                            $h_view_data['title'] = 'Select Patient - Add New Test Invoice'; 
                            $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                            
                            $this->load->view('header', $h_view_data); 
                            $this->load->view('labmanob/l_col_main', $view_data); 
                            $this->load->view('labmanob/add/test_invoices/m_col_select_patient', $view_data); 
                            $this->load->view('labmanob/r_col_main', $view_data); 
                            $this->load->view('footer', $f_view_data); 
                        } 
                        else 
                        { 
                            $_SESSION['test_invoice__patient_id'] = $this->input->post('patient_id'); 
                            
                            redirect('labmanob/add/new_test_invoice', 'refresh'); 
                        } 
                        
                    } 
                    
                    /** step select_patient(2) end } **/ 
                    
                } 
                
                /** step select_patient end } **/ 
                
                
                /** step remove_patient start { **/ 
                
                else if ($step == 'remove_patient') 
                { 
                    $this->labmanob_add_model->clear_new_test_invoice_sess();
                    
                    redirect('labmanob/add/new_test_invoice', 'refresh'); 
                } 
                
                /** step remove_patient end } **/ 
                
                
                /** step select_tests start { **/ 
                
                else if ($step == 'select_tests') 
                { 
                    
                    /** step select_tests(1) start { **/ 
                    
                    if (isset($_SESSION['test_invoice__patient_id']) && ($_SESSION['test_invoice__patient_id'] != '') && !empty($_SESSION['test_invoice__patient'])) 
                    { 
                        
                        /** step select_tests(1/a) start { **/ 
                        
                        if ($this->labmanob_view_model->count_tests() > 0) 
                        { 
                            
                            /** step select_tests(1/a/1) start { **/ 
                            
                            $tests_id_input = $this->input->post('tests_id'); 
                            if (!empty($tests_id_input) && ($this->input->post('submit_select_tests') !== NULL)) 
                            { 
                                foreach ($tests_id_input as $key => $test_id) 
                                { 
                                    $this->form_validation->set_rules('tests_id['.$key.']', $key, array('trim', 'required', 'integer', 'min_length[1]', 'max_length[11]', array('has_test_id', array($this->labmanob_add_model, 'has_test_id')))); 
                                    $this->form_validation->set_message('has_test_id', 'The Test with codename {field} does not exist! Please check and try again.'); 
                                }
                            } 
                            else if (empty($tests_id_input) && ($this->input->post('submit_select_tests') !== NULL)) 
                            { 
                                $select_tests_error_message = "Please select at least one test to continue!"; 
                            } 
                            else 
                            { 
                                /** do nothing **/ 
                            } 
                            
                            
                            if (($this->form_validation->run() == FALSE) || (!empty($select_tests_error_message))) 
                            { 
                                $h_view_data = array(); 
                                $view_data = array(); 
                                $f_view_data = array(); 
                                
                                $h_view_data['title'] = "Select Tests - Add New Test Invoice"; 
                                $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                                
                                if (!empty($select_tests_error_message)) 
                                { 
                                    $view_data['error_message'] = $select_tests_error_message; 
                                    if (isset($_SESSION['test_invoice__tests_id'])) 
                                    { 
                                        unset($_SESSION['test_invoice__tests_id']); 
                                    } 
                                } 
                                
                                $tests = array(); 
                                $tests_with_blank_category = array(); 
                                $test_categories = array(); 
                                
                                
                                if ($this->labmanob_view_model->count_test_categories() > 0) 
                                { 
                                    $test_categories = $this->labmanob_view_model->test_categories(FALSE, $blank_value='', FALSE); 
                                    
                                foreach ($test_categories as $test_category) 
                                    { 
                                        $tests['tests'][] = $this->labmanob_search_model->tests_by_category_id($test_category['id'], FALSE); 
                                        $tests['categories'][] = $test_category; 
                                    } 
                                    
                                } 
                                
                                
                                if(!empty($tests['tests'])) 
                                { 
                                    $tests_category_id_array = array(); 
                                    
                                    foreach ($tests['tests'] as $test2) 
                                    { 
                                        foreach ($test2 as $test) 
                                        { 
                                            $tests_category_id_array[] = $test['test_category_id']; 
                                        } 
                                    } 
                                    
                                    $tests_with_blank_category = $this->labmanob_add_model->tests_where_not_category_id($tests_category_id_array, FALSE); 
                                } 
                                else 
                                { 
                                    $tests_with_blank_category = $this->labmanob_view_model->tests(FALSE, $blank_value='', FALSE); 
                                } 
                                
                                
                                $view_data['tests'] = (!empty($tests) ? $tests : array()); 
                                $view_data['tests_with_blank_category'] = (!empty($tests_with_blank_category) ? $tests_with_blank_category : array()); 
                                $view_data['test_categories'] = (!empty($test_categories) ? $test_categories : array()); 
                                
                                $this->load->view('header', $h_view_data); 
                                $this->load->view('labmanob/l_col_main', $view_data); 
                                $this->load->view('labmanob/add/test_invoices/m_col_select_tests', $view_data); 
                                $this->load->view('labmanob/r_col_main', $view_data); 
                                $this->load->view('footer', $f_view_data); 
                            } 
                            
                            /** step select_tests(1/a/1) end } **/ 
                            
                            
                            /** step select_tests(1/a/2) start { **/
                            
                            else 
                            { 
                                
                                if (!empty($tests_id_input)) 
                                { 
                                    $tests_id_array = array();
                                    $data = array();
                                    $this->cart->destroy();
                                
                                    foreach ($tests_id_input as $key => $test_id) 
                                    { 
                                        $tests_id_array[] = $test_id; 
                                        $test = $this->labmanob_search_model->tests_by_id($test_id, FALSE);
                                        $data[] = array(
                                            'id' => 'test_invoice_cart_'.$_SESSION["test_invoice__patient_id"].'_'.$test[0]["id"],
                                            'test_id' => $test[0]['id'],
                                            'name' => $test[0]['test_name'],
                                            'price' => $test[0]['test_price'],
                                            'qty' => '1',
                                            'discount' => '',
                                            'discount_by' => ''
                                        );
                                    } 
                                    
                                    $this->cart->insert($data);
                                    $_SESSION['test_invoice__tests_id'] = $tests_id_array; 
                                    redirect('labmanob/add/new_test_invoice/set_tests_records', 'refresh'); 
                                } 
                                
                            } 
                            
                            /** step select_tests(1/a/2) end } **/ 
                            
                        } 
                        
                        /** step select_tests(1/a) end } **/ 
                        
                        
                        /** step select_tests(1/b) start { **/ 
                        
                        else 
                        { 
                            $h_view_data = array(); 
                            $view_data = array(); 
                            $f_view_data = array(); 
                            
                            $h_view_data['title'] = "Select Tests - Add New Test Invoice"; 
                            $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                            
                            $this->load->view('header', $h_view_data); 
                            $this->load->view('labmanob/l_col_main', $view_data); 
                            $this->load->view('labmanob/add/test_invoices/m_col_select_tests_empty', $view_data); 
                            $this->load->view('labmanob/r_col_main', $view_data); 
                            $this->load->view('footer', $f_view_data); 
                        } 
                        
                        /** step select_tests(1/b) end } **/ 
                        
                    } 
                    
                    /** step select_tests(1) end } **/ 
                    
                    
                    /** step select_tests(2) start { **/ 
                    
                    else 
                    { 
                        redirect('labmanob/add/new_test_invoice', 'refresh'); 
                    } 
                    
                    /** step select_tests(2) end } **/ 
                    
                } 
                
                /** step select_tests end } **/ 
                
                
                /** step set_tests_records start { **/
                else if ($step == 'set_tests_records')
                {
                    
                    /** step set_tests_records(1) start { **/
                    
                    if (isset($_SESSION['test_invoice__patient_id']) && ($_SESSION['test_invoice__patient_id'] != '') && !empty($_SESSION['test_invoice__patient']) && !empty($_SESSION['test_invoice__tests_id'])) 
                    {
                        
                        /** step set_tests_records(1/a) start { **/
                        
                        // ## $tests_array = array(); 
                        
                        $i = 1;
                            
                        foreach ($this->cart->contents() as $test_key => $test_items)
                        {
                            // ## print_r($test_items);
                            $test_id = $test_items['test_id'];
                            // ## $tests_array[] = $this->labmanob_search_model->tests_by_id($test_id, FALSE); 
                        
                            $this->form_validation->set_rules('quantity_of_test_id_'.$test_id.'', 'Test no.'.$i.' Quantity', 'trim|required|numeric|greater_than_equal_to[1]|min_length[1]'); 
                            
                            $this->form_validation->set_rules('discount_on_test_id_'.$test_id.'', 'Test no.'.$i.' Discount', array('trim', 'min_length[1]', 'max_length[9]', array('check_regex_discount', array($this->labmanob_add_model, 'check_regex_discount')), array('check_discount_range', array($this->labmanob_add_model, 'check_discount_range')))); 
                            $this->form_validation->set_message('check_regex_discount', 'The %s field may only contain numbers or percentage.');
                            $this->form_validation->set_message("check_discount_range", "The %s field must be greater than zero or from 0 percent to 100 percent.");
                            
                            $this->form_validation->set_rules('discount_by_on_test_id_'.$test_id.'', 'Test no.'.$i.' Discount By', array('trim', 'alpha_numeric_spaces', 'min_length[1]', 'max_length[255]'));
                            
                            $i++;
                        }
                        
                        if ($this->form_validation->run() == FALSE)
                        {
                            $h_view_data = array(); 
                            $view_data = array(); 
                            $f_view_data = array(); 
                            
                            $h_view_data['title'] = "Set Tests Records - Add New Test Invoice"; 
                            $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                            
                            // ## $view_data['tests_array'] = $tests_array; 
                            
                            $this->load->view('header', $h_view_data); 
                            $this->load->view('labmanob/l_col_main', $view_data); 
                            $this->load->view('labmanob/add/test_invoices/m_col_set_tests_records', $view_data); 
                            $this->load->view('labmanob/r_col_main', $view_data); 
                            $this->load->view('footer', $f_view_data); 
                        }
                        
                        /** step set_tests_records(1/a) end } **/
                        
                        
                        /** step set_tests_records(1/b) start { **/
                        
                        else 
                        {
                            $data = array();
                            foreach ($this->cart->contents() as $test_key => $test_items)
                            {
                                $data[] = array(
                                    'rowid' => $this->input->post('rowid_of_test_id_'.$test_items["test_id"]),
                                    'id' => $test_items['id'],
                                    'test_id' => $test_items['test_id'],
                                    'name' => $test_items['name'],
                                    'price' => $test_items['price'],
                                    'qty' => $this->input->post('quantity_of_test_id_'.$test_items["test_id"]),
                                    'discount' => (!empty($this->input->post('discount_on_test_id_'.$test_items["test_id"])) && ($this->input->post('discount_on_test_id_'.$test_items["test_id"])) == 0) ? 0 : $this->input->post('discount_on_test_id_'.$test_items["test_id"]),
                                    'discount_by' => $this->input->post('discount_by_on_test_id_'.$test_items["test_id"])
                                );
                            }

                            $this->cart->update($data);
                            redirect('labmanob/add/new_test_invoice/set_payment', 'refresh');
                        }
                        
                        /** step set_tests_records(1/b) end } **/
                        
                    }
                    
                    /** step set_tests_records(1) end } **/
                    
                    
                    /** step set_tests_records(2) start { **/
                    
                    /** (optional else if) 
                    else if (isset($_SESSION['test_invoice__patient_id']) && ($_SESSION['test_invoice__patient_id'] != '') && !empty($_SESSION['test_invoice__patient']) && empty($_SESSION['test_invoice__tests_id'])) 
                    {
                        redirect('labmanob/add/new_test_invoice/select_tests', 'refresh');
                    }
                    **/
                    
                    /** step set_tests_records(2) end } **/
                    
                    
                    /** step set_tests_records(3) start { **/
                    
                    else 
                    {
                        redirect('labmanob/add/new_test_invoice', 'refresh');
                    }
                    
                    /** step set_tests_records(3) end } **/
                    
                }
                /** step set_tests_records end } **/
                

                /** step set_payment start { **/
                else if ($step == 'set_payment')
                {
                    if (isset($_SESSION['test_invoice__patient_id']) && ($_SESSION['test_invoice__patient_id'] != '') && !empty($_SESSION['test_invoice__patient']) && !empty($_SESSION['test_invoice__tests_id']) && ($this->cart->total_items() > 0)) 
                    {
                        $this->form_validation->set_rules('final_discount', 'Discount', array('trim', 'min_length[1]', 'max_length[9]', array('check_regex_discount', array($this->labmanob_add_model, 'check_regex_discount')), array('check_discount_range', array($this->labmanob_add_model, 'check_discount_range')))); 
                        $this->form_validation->set_message('check_regex_discount', 'The %s field may only contain numbers or percentage.');
                        $this->form_validation->set_message("check_discount_range", "The %s field must be greater than zero or from 0 percent to 100 percent.");
                        
                        $this->form_validation->set_rules('final_discount_by', 'Discount By', array('trim', 'alpha_numeric_spaces', 'min_length[1]', 'max_length[200]'));

                        $this->form_validation->set_rules('paid_amount', 'Paid Amount', 'trim|required|max_length[15]|numeric|greater_than_equal_to[0]'); 

                        $this->form_validation->set_rules('patient_age', 'Patient\'s Age', 'trim|required|max_length[3]|is_natural_no_zero|greater_than[0]'); 

                        //$this->form_validation->set_rules('ref_by', 'Ref By', array('trim', 'max_length[255]', array('check_regex_ref_by', array($this->labmanob_add_model, 'check_regex_name'))));
                        //$this->form_validation->set_message('check_regex_ref_by', 'The %s field may only contain alpha-numeric characters, underscores, spaces and must start with an alphabetical character!'); 

                        $this->form_validation->set_rules('ref_by', 'Ref By', array('trim', 'max_length[200]'));
                        $this->form_validation->set_rules('affiliate_partner_id', 'Affiliate Partner ID', array('trim', 'is_natural', 'min_length[1]', 'max_length[11]', array('has_affiliate_partner_id', array($this->labmanob_add_model, 'has_affiliate_partner_id')))); 
                        $this->form_validation->set_message('has_affiliate_partner_id', 'The {field} does not exist! Please check and try again.'); 

                        $this->form_validation->set_rules('extra_info', 'Extra Information', 'trim|max_length[255]');


                        if ($this->form_validation->run() == FALSE)
                        {
                            $h_view_data = array(); 
                            $view_data = array(); 
                            $f_view_data = array(); 
                        
                            $h_view_data['title'] = "Set Payment - Add New Test Invoice"; 
                            $view_data['summary'] = $this->labmanob_summary_model->get_full_summary();                 

                            $table_tpl = array(
                                'table_open' => '<table class="uk-table uk-table-striped uk-table-hover uk-table-middle uk-table-small">'
                                ); 
                        
                            $this->table->set_template($table_tpl);
                            $this->table->set_heading('Serial No', 'Test ID', 'Test Name', 'Price', 'Quantity', 'Total', 'Discount', 'Discount By', 'Subtotal');
                        
                            $total_discount = 0;
                            $final_total = 0;
                            $i = 1;
                            foreach ($this->cart->contents() as $test_key => $test_items)
                            {
                                $discount = 0;

                                if(!empty($test_items['discount']))
                                {
                                    $discount = $this->labmanob_add_model->calc_discount($test_items['discount'], $test_items['subtotal']);
                                    $total_discount += $discount;
                                }

                                $this->table->add_row($i, $test_items['test_id'], $test_items['name'], $test_items['price'], $test_items['qty'], sprintf("%.2f", (float)$test_items['subtotal']), $test_items['discount'], $test_items['discount_by'], sprintf("%.2f", (float)($test_items['subtotal'] - $discount))); 
                                $i++;
                            }
                            $final_total = ($this->cart->total() - $total_discount);
                            $this->table->add_row('', '', '', '', '', sprintf("%.2f", (float)$this->cart->total()), sprintf("%.2f", (float)$total_discount), '', sprintf("%.2f", (float)$final_total));

                            $view_data['total_discount'] = $total_discount;
                            $view_data['final_total'] = $final_total;
                            $view_data['payment_table'] = $this->table->generate();

                            $this->load->view('header', $h_view_data); 
                            $this->load->view('labmanob/l_col_main', $view_data); 
                            $this->load->view('labmanob/add/test_invoices/m_col_set_payment', $view_data); 
                            $this->load->view('labmanob/r_col_main', $view_data); 
                            $this->load->view('footer', $f_view_data);
                        }
                        else
                        {
                            $error_count = 0;
                            $test_invoice_records_id_array = array(); 
                            $total_discount = 0;
                            $final_total = 0;

                            $this->labmanob_add_model->trans_start();

                            foreach ($this->cart->contents() as $test_key => $test_items)
                            {
                                $discount = 0;

                                if(!empty($test_items['discount']))
                                {
                                    $discount = $this->labmanob_add_model->calc_discount($test_items['discount'], $test_items['subtotal']);
                                    $total_discount += $discount;
                                }
                            }

                            $final_total = ($this->cart->total() - $total_discount);
                            $test_invoice_insert_id = '';


                            $final_discount_input = ($this->input->post('final_discount')) ? $this->input->post('final_discount') : 0.00;
                            $final_discount = $this->labmanob_add_model->calc_discount($final_discount_input, $final_total); 
                            $final_discount_by = $this->input->post('final_discount_by'); 
                            $final_subtotal = $final_total - $final_discount;
                            $patient_age = $this->input->post('patient_age'); 
                            $ref_by = $this->input->post('ref_by'); 
                            $affiliate_partner_id = $this->input->post('affiliate_partner_id');
                            $extra_info = $this->input->post('extra_info');

                            $db_data = array(
                                'patient_id' => $_SESSION['test_invoice__patient_id'],
                                'patient_age' => $patient_age,
                                'ref_by' => $ref_by,
                                'affiliate_partner_id' => $affiliate_partner_id,
                                'total' => $final_total,
                                'discount' => $final_discount,
                                'discount_by' => $final_discount_by,
                                'subtotal' => $final_subtotal,
                                'extra_info' => $extra_info,
                                'ctrl__status' => 1
                            ); 

                            $db_return = NULL;
                            $db_return = $this->labmanob_add_model->new_test_invoice($db_data); 

                            if ($db_return !== FALSE) 
                            {
                                $test_invoice_insert_id = $db_return;

                                foreach ($this->cart->contents() as $test_key => $test_items)
                                {
                                    $discount = $this->labmanob_add_model->calc_discount($test_items['discount'], $test_items['subtotal']); 
                                    
                                    $db_data = array(
                                        'test_invoice_id' => $test_invoice_insert_id, 
                                        'test_id' => $test_items['test_id'], 
                                        'test_price' => $test_items['price'], 
                                        'quantity' => $test_items['qty'], 
                                        'discount' => $discount, 
                                        'discount_by' => $test_items['discount_by'], 
                                        'total' => sprintf("%.2f", (float)$test_items['subtotal']), 
                                        'subtotal' => sprintf("%.2f", (float)($test_items['subtotal'] - $discount)),
                                        'ctrl__status' => 1
                                    ); 
        
                                    $db_return = NULL;
                                    $db_return = $this->labmanob_add_model->new_test_invoice_record($db_data);
        
                                    if ($db_return !== FALSE)
                                    {
                                        //$test_invoice_records_id_array[] = $db_return;
                                    } 
                                    else 
                                    {
                                        $error_count++; 
                                    }
                                }
                                

                                if($error_count == 0)
                                {
                                    $paid_amount = ($this->input->post('paid_amount')) ? $this->input->post('paid_amount') : 0; 
                                    $is_full_paid = ($paid_amount >= $final_subtotal) ? 1 : 0;

                                    $db_data = array(
                                        'test_invoice_id' => $test_invoice_insert_id,
                                        'is_full_paid' => $is_full_paid,
                                        'paid_amount' => $paid_amount,
                                        'ctrl__status' => 1
                                    );

                                    $db_return = NULL;
                                    $db_return = $this->labmanob_add_model->new_test_invoice_payment($db_data);

                                    if($db_return === FALSE)
                                    {
                                        $error_count++;
                                        $error_message = "Some error occurred while inserting data into test invoice payment database! Try agian.";
                                    }
                                }
                                else 
                                {
                                    //error_message already issued for displaying
                                }
                            }
                            else
                            {
                                $error_count++;
                                $error_message = "Some error occurred while inserting data into test invoice database! Try agian.";
                            }

                            $this->labmanob_add_model->trans_complete();

                            // final process start {
                            // this condition loads the set_payment page for showing error
                            if(($error_count != 0) || ($test_invoice_insert_id == ''))
                            {
                                $h_view_data = array(); 
                                $view_data = array(); 
                                $f_view_data = array(); 
                        
                                $h_view_data['title'] = "Set Payment - Add New Test Invoice"; 
                                $view_data['summary'] = $this->labmanob_summary_model->get_full_summary();                 

                                $table_tpl = array(
                                    'table_open' => '<table class="uk-table uk-table-striped uk-table-hover uk-table-middle uk-table-small">'
                                    ); 
                                    
                                $this->table->set_template($table_tpl);
                                $this->table->set_heading('Serial No', 'Test ID', 'Test Name', 'Price', 'Quantity', 'Total', 'Discount', 'Discount By', 'Subtotal');
                        
                                $total_discount = 0;
                                $final_total = 0;
                                $i = 1;
                                foreach ($this->cart->contents() as $test_key => $test_items)
                                {
                                    $discount = 0;

                                    if(!empty($test_items['discount']))
                                    {
                                        $discount = $this->labmanob_add_model->calc_discount($test_items['discount'], $test_items['subtotal']);
                                        $total_discount += $discount;
                                    }

                                    $this->table->add_row($i, $test_items['test_id'], $test_items['name'], $test_items['price'], $test_items['qty'], sprintf("%.2f", (float)$test_items['subtotal']), $test_items['discount'], $test_items['discount_by'], sprintf("%.2f", (float)($test_items['subtotal'] - $discount))); 
                                    $i++;
                                }
                                $final_total = ($this->cart->total() - $total_discount);
                                $this->table->add_row('', '', '', '', '', sprintf("%.2f", (float)$this->cart->total()), sprintf("%.2f", (float)$total_discount), '', sprintf("%.2f", (float)$final_total));

                                $view_data['error_message'] = $error_message;
                                $view_data['total_discount'] = $total_discount;
                                $view_data['final_total'] = $final_total;
                                $view_data['payment_table'] = $this->table->generate();

                                $this->load->view('header', $h_view_data); 
                                $this->load->view('labmanob/l_col_main', $view_data); 
                                $this->load->view('labmanob/add/test_invoices/m_col_set_payment', $view_data); 
                                $this->load->view('labmanob/r_col_main', $view_data); 
                                $this->load->view('footer', $f_view_data);
                            }
                            else
                            {
                                //success
                                //log this action
                                log_message('error', '===== ADD ACTION INFORMATION =====> Username: '.$_SESSION['username'].' ----- User ID: '.$_SESSION['user_id'].' ----- Test Invoice ID: '.$test_invoice_insert_id.' ----- Added New Test Invoice.');

                                $this->labmanob_add_model->clear_new_test_invoice_sess();

                                redirect((($test_invoice_insert_id != '') ? 'labmanob/view/test_invoice/'.$test_invoice_insert_id : 'labmanob/view/test_invoices'), 'refresh');
                            }
                            // final process end }
                        }
                    }
                    else 
                    {
                        redirect('labmanob/add/new_test_invoice', 'refresh');
                    }
                    
                }
                /** step set_payment end } **/


                /** step finish start { **/
                else if ($step == 'finish')
                {
                    redirect('labmanob', 'refresh');
                }
                /** step finish end } **/
                
                else 
                { 
                    show_404(current_url()); 
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



    public function new_test_category() 
    { 
        
        if ($this->login_model->login_check() === TRUE) 
        { 
            if(strtolower($_SESSION['username']) != 'viewer')
            {
                $this->form_validation->set_rules('category_name', 'Category Name', 'trim|required|max_length[150]'); 
                
                $this->form_validation->set_rules('category_codename', 'Category Code Name', array('trim', 'required', 'max_length[150]', array('category_codename_not_exists', array($this->labmanob_add_model, 'category_codename_not_exists')))); 
                $this->form_validation->set_message('category_codename_not_exists', 'The %s already exists! Try another.'); 
                
                $this->form_validation->set_rules('category_description', 'Category Description', 'trim|max_length[255]'); 
                
                
                if ($this->form_validation->run() == FALSE) 
                { 
                    $h_view_data = array(); 
                    $view_data = array(); 
                    $f_view_data = array(); 
                    $h_view_data['title'] = "Add New Test Category"; 
                    $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                    
                    $this->load->view('header', $h_view_data); 
                    $this->load->view('labmanob/l_col_main', $view_data); 
                    $this->load->view('labmanob/add/m_col_test_categories', $view_data); 
                    $this->load->view('labmanob/r_col_main', $view_data); 
                    $this->load->view('footer', $f_view_data); 
                    
                } 
                else 
                { 
                    $category_name = $this->input->post('category_name'); 
                    $category_codename = $this->input->post('category_codename'); 
                    $category_description = $this->input->post('category_description'); 
                    
                    $db_data = array(
                        'category_name' => $category_name, 
                        'category_codename' => $category_codename, 
                        'category_description' => $category_description, 
                        'ctrl__status' => 1
                    ); 
                    
                    $add_new_test_category_result = $this->labmanob_add_model->new_test_category($db_data);

                    if (($add_new_test_category_result !== FALSE) && isset($add_new_test_category_result)) 
                    { 
                        //success
                        //log this action
                        log_message('error', '===== ADD ACTION INFORMATION =====> Username: '.$_SESSION['username'].' ----- User ID: '.$_SESSION['user_id'].' ----- Test Category ID: '.$add_new_test_category_result.' ----- Added New Test Category.');

                        $this->session->set_flashdata('message_display', 'New Test Category added successfully!'); 
                        redirect(current_url(), 'refresh'); 
                        
                        $h_view_data = array(); 
                        $view_data = array(); 
                        $f_view_data = array(); 
                        $h_view_data['title'] = "Add New Test Category"; 
                        $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                        
                        $this->load->view('header', $h_view_data); 
                        $this->load->view('labmanob/l_col_main', $view_data); 
                        $this->load->view('labmanob/add/m_col_test_categories', $view_data); 
                        $this->load->view('labmanob/r_col_main', $view_data); 
                        $this->load->view('footer', $f_view_data); 
                        
                    } 
                    else 
                    { 
                        $h_view_data = array(); 
                        $view_data = array(); 
                        $f_view_data = array(); 
                        $h_view_data['title'] = "Add New Test Category"; 
                        $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                        $view_data['error_message'] = "Couldn't add new test category!"; 
                        
                        $this->load->view('header', $h_view_data); 
                        $this->load->view('labmanob/l_col_main', $view_data); 
                        $this->load->view('labmanob/add/m_col_test_categories', $view_data); 
                        $this->load->view('labmanob/r_col_main', $view_data); 
                        $this->load->view('footer', $f_view_data); 
                        
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



    public function new_test() 
    { 
        
        if ($this->login_model->login_check() === TRUE) 
        { 
            if(strtolower($_SESSION['username']) != 'viewer')
            {
                $test_categories = $this->labmanob_view_model->test_categories(FALSE, $blank_value='', TRUE); 
                
                $this->form_validation->set_rules('test_name', 'Test Name', 'trim|required|max_length[150]'); 
                
                $this->form_validation->set_rules('test_codename', 'Test Code Name', array('trim', 'required', 'max_length[150]', array('test_codename_not_exists', array($this->labmanob_add_model, 'test_codename_not_exists')))); 
                $this->form_validation->set_message('test_codename_not_exists', 'The %s already exists! Try another.'); 
                
                $this->form_validation->set_rules('test_category_id', 'Test Category', array('trim', 'required', 'max_length[11]', 'numeric',  array('has_test_category_id', array($this->labmanob_add_model, 'has_test_category_id')))); 
                $this->form_validation->set_message('has_test_category_id', 'The {field} does not exist! Try again with correct {field} or add a new.'); 
                
                $this->form_validation->set_rules('test_price', 'Test Price', 'trim|required|max_length[15]|numeric'); 
                
                $this->form_validation->set_rules('test_description', 'Test Description', 'trim|max_length[255]'); 
                
                
                if ($this->form_validation->run() == FALSE) 
                { 
                    $h_view_data = array(); 
                    $view_data = array(); 
                    $f_view_data = array(); 
                    $h_view_data['title'] = "Add New Test"; 
                    $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                    $view_data['test_categories'] = $test_categories; 
                    
                    $this->load->view('header', $h_view_data); 
                    $this->load->view('labmanob/l_col_main', $view_data); 
                    $this->load->view('labmanob/add/m_col_tests', $view_data); 
                    $this->load->view('labmanob/r_col_main', $view_data); 
                    $this->load->view('footer', $f_view_data); 
                    
                } 
                else 
                { 
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
                    
                    $add_new_test_result = $this->labmanob_add_model->new_test($db_data);
                    
                    if (($add_new_test_result !== FALSE) && isset($add_new_test_result)) 
                    { 
                        //success
                        //log this action
                        log_message('error', '===== ADD ACTION INFORMATION =====> Username: '.$_SESSION['username'].' ----- User ID: '.$_SESSION['user_id'].' ----- Test ID: '.$add_new_test_result.' ----- Added New Test.'); 

                        $this->session->set_flashdata('message_display', 'New Test added successfully!'); 
                        redirect(current_url(), 'refresh'); 
                        
                        $h_view_data = array(); 
                        $view_data = array(); 
                        $f_view_data = array(); 
                        $h_view_data['title'] = "Add New Test"; 
                        $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                        $view_data['test_categories'] = $test_categories; 
                        
                        $this->load->view('header', $h_view_data); 
                        $this->load->view('labmanob/l_col_main', $view_data); 
                        $this->load->view('labmanob/add/m_col_tests', $view_data); 
                        $this->load->view('labmanob/r_col_main', $view_data); 
                        $this->load->view('footer', $f_view_data); 
                        
                    } 
                    else 
                    { 
                        $h_view_data = array(); 
                        $view_data = array(); 
                        $f_view_data = array(); 
                        $h_view_data['title'] = "Add New Test"; 
                        $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                        $view_data['error_message'] = "Couldn't add new test!"; 
                        $view_data['test_categories'] = $test_categories; 
                        
                        $this->load->view('header', $h_view_data); 
                        $this->load->view('labmanob/l_col_main', $view_data); 
                        $this->load->view('labmanob/add/m_col_tests', $view_data); 
                        $this->load->view('labmanob/r_col_main', $view_data); 
                        $this->load->view('footer', $f_view_data); 
                        
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