<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller 
{ 

    public function  __construct()
    {
        parent::__construct(); 
        $this->load->helper(array('form')); 
        $this->load->library(array('session', 'form_validation')); 
        $this->load->model('accounts/login_model', 'login_model'); 
        $this->load->model('labmanob/labmanob_summary_model', 'labmanob_summary_model'); 
        $this->load->model('labmanob/labmanob_search_model', 'labmanob_search_model'); 
        $this->load->model('labmanob/labmanob_add_model', 'labmanob_add_model'); 
        $this->load->model('labmanob/labmanob_upload_model', 'labmanob_upload_model'); 
        
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
                
                $h_view_data['title'] = "Upload"; 
                $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                
                $this->load->view('header', $h_view_data); 
                $this->load->view('labmanob/l_col_main', $view_data); 
                $this->load->view('labmanob/upload/m_col_main', $view_data); 
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



    public function patient_image($step_input='') 
    { 
        $step_input = strtolower($step_input); 
        
        if ($step_input == '') 
        { 
            $step = 'select_patient'; 
        } 
        else if ($step_input == 'upload_image') 
        { 
            $step = 'upload_image'; 
        } 
        else if ($step_input == 'upload_image_xmlhttprequest') 
        { 
            // same as upload_image, but returns json response
            $step = 'upload_image_xmlhttprequest'; 
        } 
        else if ($step_input == 'remove_patient') 
        { 
            $step = 'remove_patient'; 
        } 
        else if ($step_input == 'redirect_to_add_new_test_invoice') 
        { 
            $step = 'redirect_to_add_new_test_invoice'; 
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
                    
                    if (isset($_SESSION['upload_patient_image__patient_id']) && ($_SESSION['upload_patient_image__patient_id'] != '')) 
                    { 
                        $patients_array = $this->labmanob_search_model->patients_by_id($_SESSION['upload_patient_image__patient_id'], FALSE); 
                        
                        if ($patients_array !== FALSE) 
                        { 
                            $h_view_data = array(); 
                            $view_data = array(); 
                            $f_view_data = array(); 
                            
                            foreach ($patients_array as $patient) 
                            { 
                                $_SESSION['upload_patient_image__patient'] = $patient; 
                                $view_data['patient'] = $patient; 
                            } 
                            
                            $h_view_data['title'] = 'Upload Patient Image'; 
                            $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                            
                            $this->load->view('header', $h_view_data); 
                            $this->load->view('labmanob/l_col_main', $view_data); 
                            $this->load->view('labmanob/upload/patients/image/m_col_selected_patient', $view_data); 
                            $this->load->view('labmanob/r_col_main', $view_data); 
                            $this->load->view('footer', $f_view_data); 
                        } 
                        else 
                        { 
                            show_error('System was unable to face patient informations using the upload patient image patient id'); 
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
                            
                            $h_view_data['title'] = 'Select Patient - Upload Patient Image'; 
                            $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                            
                            $this->load->view('header', $h_view_data); 
                            $this->load->view('labmanob/l_col_main', $view_data); 
                            $this->load->view('labmanob/upload/patients/image/m_col_select_patient', $view_data); 
                            $this->load->view('labmanob/r_col_main', $view_data); 
                            $this->load->view('footer', $f_view_data); 
                        } 
                        else 
                        { 
                            $_SESSION['upload_patient_image__patient_id'] = $this->input->post('patient_id'); 
                            
                            redirect('labmanob/upload/patient_image', 'refresh'); 
                        } 
                        
                    } 
                    
                    /** step select_patient(2) end } **/ 
                    
                } 
                
                /** step select_patient end } **/
                
                
                /** step upload_image start { **/ 
                // ANY CHANGES HERE SHOULD ALSO BE CONFIGURED FOR upload_image_xmlhttprequest
                
                else if ($step == 'upload_image') 
                { 
                    if ( (isset($_SESSION['upload_patient_image__patient_id']) && ($_SESSION['upload_patient_image__patient_id'] != '')) && (isset($_SESSION['upload_patient_image__patient']) && ($_SESSION['upload_patient_image__patient'] != '')) ) 
                    { 
                        
                        /* permission check */ 
                        $get_img_id = $this->labmanob_upload_model->get_img_id_from_patients_by_id($_SESSION['upload_patient_image__patient_id'], TRUE);

                        if( (($get_img_id[0]->img_id != 1) && (($_SESSION['username'] == 'master') || ($_SESSION['username'] == 'admin'))) || ($get_img_id[0]->img_id == 1))
                        {
                            // csrf_has should only be supplied to allow resubmission where needed  

                            $image_encode_level = 2; // { 0 : no modification, 1 : base64 encoded only, 2 : encrypted using CI framework }
                            $upload_dir = 'patients/images/';
                            $upload_path = uploads_path().$upload_dir;

                            $config['upload_path']          =  $upload_path;
                            $config['allowed_types']        = 'gif|jpg|jpeg|png';
                            $config['file_ext_tolower']     = TRUE;
                            $config['max_size']             = 5120; // 5 MB
                            $config['max_width']            = 0;
                            $config['max_height']           = 0;
                            $config['encrypt_name']     = TRUE;

                            $this->load->library('upload', $config);
                            $this->load->library('encryption');

                            if ( ! $this->upload->do_upload('image_file', $image_encode_level))
                            {
                                $h_view_data = array(); 
                                $view_data = array(); 
                                $f_view_data = array();

                                $view_data['error_message'] = $this->upload->display_errors(); 
                                $view_data['patient'] = $_SESSION['upload_patient_image__patient']; 
                                
                                $h_view_data['title'] = 'Upload Patient Image'; 
                                $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                                
                                $this->load->view('header', $h_view_data); 
                                $this->load->view('labmanob/l_col_main', $view_data); 
                                $this->load->view('labmanob/upload/patients/image/m_col_selected_patient', $view_data); 
                                $this->load->view('labmanob/r_col_main', $view_data); 
                                $this->load->view('footer', $f_view_data); 
                            }
                            else
                            {
                                $uploaded_image_data = $this->upload->data();

                                /* upload informations to database */
                                $upload_patient_image_result = $this->labmanob_upload_model->upload_patient_image($_SESSION['upload_patient_image__patient_id'], $uploaded_image_data, $upload_dir, $image_encode_level);

                                if(($upload_patient_image_result != FALSE) && isset($upload_patient_image_result)) 
                                {
                                    // database upload successful
                                    // prepare and output the response

                                    $this->session->set_flashdata('message_display', 'Image uploaded successfully!'); 
                            
                                    $h_view_data = array(); 
                                    $view_data = array(); 
                                    $f_view_data = array();

                                    // if encoded/encrypted, decode/decrypt the data for output
                                    if($image_encode_level != 0)
                                    {
                                        $this->load->library('files_library');
                                        $get_encoded_image_data = $this->files_library->get_encoded_image_data($uploaded_image_data, $image_encode_level, TRUE);
                                        
                                        if($get_encoded_image_data != FALSE)
                                        {
                                            $encoded_image_data = $get_encoded_image_data;
                                        }
                                    }

                                    // provide output
                                    if(isset($encoded_image_data) && ($encoded_image_data != '')) 
                                    {
                                        $view_data['encoded_image_data'] = $encoded_image_data;
                                    }

                                    $view_data['uploaded_image_data'] = $uploaded_image_data;
                                    $view_data['upload_dir'] = $upload_dir;
                                    $view_data['patient'] = $_SESSION['upload_patient_image__patient']; 
                                    $view_data['redirect_to_add_new_test_invoice'] = FALSE;

                                    if( (isset($_SESSION['upload_patient_image__patient_id']) && ($_SESSION['upload_patient_image__patient_id'] != '')) && (isset($_SESSION['upload_patient_image__redirect_to_add_new_test_invoice']) && ($_SESSION['upload_patient_image__redirect_to_add_new_test_invoice'] != '')) )
                                    {
                                        $redirect_second = 5;
                                        $_SESSION['test_invoice__patient_id'] = $_SESSION['upload_patient_image__patient_id'];
                                        $view_data['redirect_to_add_new_test_invoice'] = TRUE;

                                        $this->session->set_flashdata('redirect_second', $redirect_second); 
                                        $this->session->set_flashdata('redirect_url', site_url('labmanob/add/new_test_invoice')); 
                                        $this->session->set_flashdata('message_redirect_to_add_new_test_invoice', 'Patient ID <b>'.$_SESSION['test_invoice__patient_id'].'</b> added to new test invoice. If this page does not redirect automatically in '.$redirect_second.' seconds, go to add new test invoice.'); 
                                    }

                                    $this->labmanob_upload_model->clear_patient_image_sess();
                                    
                                    $h_view_data['title'] = 'Upload Patient Image'; 
                                    $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                                    
                                    $this->load->view('header', $h_view_data); 
                                    $this->load->view('labmanob/l_col_main', $view_data); 
                                    $this->load->view('labmanob/upload/patients/image/m_col_selected_patient', $view_data); 
                                    $this->load->view('labmanob/r_col_main', $view_data); 
                                    $this->load->view('footer', $f_view_data); 
                                }
                                else 
                                {
                                    $h_view_data = array(); 
                                    $view_data = array(); 
                                    $f_view_data = array();

                                    $view_data['error_message'] = 'Error! There was an error while uploading informations to the database!'; 
                                    $view_data['patient'] = $_SESSION['upload_patient_image__patient']; 
                                    
                                    $h_view_data['title'] = 'Upload Patient Image'; 
                                    $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                                    
                                    $this->load->view('header', $h_view_data); 
                                    $this->load->view('labmanob/l_col_main', $view_data); 
                                    $this->load->view('labmanob/upload/patients/image/m_col_selected_patient', $view_data); 
                                    $this->load->view('labmanob/r_col_main', $view_data); 
                                    $this->load->view('footer', $f_view_data); 
                                }
                            }
                        }
                        /* permission check else */
                        else 
                        {
                            $h_view_data = array(); 
                            $view_data = array(); 
                            $f_view_data = array();

                            $view_data['error_message'] = 'Request denied! Not enough permissions!'; 
                            $view_data['patient'] = $_SESSION['upload_patient_image__patient']; 
                            
                            $h_view_data['title'] = 'Upload Patient Image'; 
                            $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                            
                            $this->load->view('header', $h_view_data); 
                            $this->load->view('labmanob/l_col_main', $view_data); 
                            $this->load->view('labmanob/upload/patients/image/m_col_selected_patient', $view_data); 
                            $this->load->view('labmanob/r_col_main', $view_data); 
                            $this->load->view('footer', $f_view_data); 
                        }
                        /* permission check end */
                    } 
                    else 
                    { 
                        
                        redirect('labmanob/upload/patient_image', 'refresh'); 
                    } 
                } 
                
                /** step upload_image end } **/
                
                
                /** step upload_image_xmlhttprequest start { **/ 
                // ANY CHANGES HERE SHOULD ALSO BE CONFIGURED FOR upload_image 
                
                else if ($step == 'upload_image_xmlhttprequest') 
                { 
                    if ( (isset($_SESSION['upload_patient_image__patient_id']) && ($_SESSION['upload_patient_image__patient_id'] != '')) && (isset($_SESSION['upload_patient_image__patient']) && ($_SESSION['upload_patient_image__patient'] != '')) ) 
                    { 

                        /* permission check */ 
                        $get_img_id = $this->labmanob_upload_model->get_img_id_from_patients_by_id($_SESSION['upload_patient_image__patient_id'], TRUE);

                        if( (($get_img_id[0]->img_id != 1) && (($_SESSION['username'] == 'master') || ($_SESSION['username'] == 'admin'))) || ($get_img_id[0]->img_id == 1))
                        {
                            // csrf_has should only be supplied to allow resubmission where needed  

                            $image_encode_level = 2; // { 0 : no modification, 1 : base64 encoded only, 2 : encrypted using CI framework }
                            $upload_dir = 'patients/images/';
                            $upload_path = uploads_path().$upload_dir;

                            $config['upload_path']          =  $upload_path;
                            $config['allowed_types']        = 'gif|jpg|jpeg|png';
                            $config['file_ext_tolower']     = TRUE;
                            $config['max_size']             = 5120; // 5 MB
                            $config['max_width']            = 0;
                            $config['max_height']           = 0;
                            $config['encrypt_name']     = TRUE;

                            $this->load->library('upload', $config);
                            $this->load->library('encryption');

                            if ( ! $this->upload->do_upload('image_file', $image_encode_level))
                            {
                                $error_message_data = array('upload_success' => FALSE, 
                                                            'error_message' => $this->upload->display_errors(),
                                                            'csrf_hash' => $this->security->get_csrf_hash(),
                                );
                                
                                echo json_encode($error_message_data);
                            }
                            else
                            {
                                $uploaded_image_data = $this->upload->data();
                                
                                /* upload informations to database */
                                $upload_patient_image_result = $this->labmanob_upload_model->upload_patient_image($_SESSION['upload_patient_image__patient_id'], $uploaded_image_data, $upload_dir, $image_encode_level);

                                if(($upload_patient_image_result != FALSE) && isset($upload_patient_image_result)) 
                                {
                                    // database upload successful
                                    // prepare and output the response
                                    // no csrf provided because of successful operation

                                    // if encoded/encrypted, decode/decrypt the data for output
                                    if($image_encode_level != 0)
                                    {
                                        $this->load->library('files_library');
                                        $get_encoded_image_data = $this->files_library->get_encoded_image_data($uploaded_image_data, $image_encode_level, TRUE);
                                        
                                        if($get_encoded_image_data != FALSE)
                                        {
                                            $encoded_image_data = $get_encoded_image_data;
                                        }
                                    }

                                    // provide output
                                    if( (isset($_SESSION['upload_patient_image__patient_id']) && ($_SESSION['upload_patient_image__patient_id'] != '')) && (isset($_SESSION['upload_patient_image__redirect_to_add_new_test_invoice']) && ($_SESSION['upload_patient_image__redirect_to_add_new_test_invoice'] != '')) )
                                    {
                                        $redirect_second = 5;
                                        $_SESSION['test_invoice__patient_id'] = $_SESSION['upload_patient_image__patient_id'];
                                        
                                        if(isset($encoded_image_data) && ($encoded_image_data != '')) 
                                        {
                                            $data = array('upload_success' => TRUE, 
                                                            'message_display' => 'Image uploaded successfully!', 
                                                            'uploaded_image_data' => $uploaded_image_data, 
                                                            'encoded_image_data'  => $encoded_image_data,
                                                            'redirect_to_add_new_test_invoice' => TRUE, 
                                                            'redirect_second' => $redirect_second,
                                                            'message_redirect_to_add_new_test_invoice' => 'Patient ID <b>'.$_SESSION['test_invoice__patient_id'].'</b> added to new test invoice. If this page does not redirect automatically in '.$redirect_second.' seconds, go to add new test invoice.',
                                            );
                                        }
                                        else 
                                        {
                                            // image not encoded, supply the upload_dir for image src generation
                                            $data = array('upload_success' => TRUE, 
                                                            'message_display' => 'Image uploaded successfully!', 
                                                            'uploaded_image_data' => $uploaded_image_data, 
                                                            'upload_dir' => $upload_dir,
                                                            'redirect_to_add_new_test_invoice' => TRUE, 
                                                            'redirect_second' => $redirect_second,
                                                            'message_redirect_to_add_new_test_invoice' => 'Patient ID <b>'.$_SESSION['test_invoice__patient_id'].'</b> added to new test invoice. If this page does not redirect automatically in '.$redirect_second.' seconds, go to add new test invoice.',
                                            );
                                        }
                                    }
                                    else 
                                    {
                                        if(isset($encoded_image_data) && ($encoded_image_data != '')) 
                                        {
                                            $data = array('upload_success' => TRUE, 
                                                            'message_display' => 'Image uploaded successfully!', 
                                                            'uploaded_image_data' => $uploaded_image_data,
                                                            'encoded_image_data'  => $encoded_image_data,
                                            );
                                        }
                                        else 
                                        {
                                            // image not encoded, supply the upload_dir for image src generation
                                            $data = array('upload_success' => TRUE, 
                                                            'message_display' => 'Image uploaded successfully!', 
                                                            'uploaded_image_data' => $uploaded_image_data,
                                                            'upload_dir' => $upload_dir,
                                            );
                                        }
                                    }
                                
                                    $this->labmanob_upload_model->clear_patient_image_sess();
        
                                    echo json_encode($data);
                                }
                                else 
                                {
                                    $error_message_data = array('upload_success' => FALSE, 
                                                                'error_message' => 'There was an error while uploading informations to the database!',
                                                                'csrf_hash' => $this->security->get_csrf_hash(),
                                    );
                                    
                                    echo json_encode($error_message_data);
                                }
                            }
                        }
                        /* permission check else */
                        else 
                        {
                            $error_message_data = array('upload_success' => FALSE, 
                                                        'error_message' => 'Request denied! Not enough permissions!',
                                                        'csrf_hash' => $this->security->get_csrf_hash(),
                            );
                                
                            echo json_encode($error_message_data);
                        }
                        /* permission check end */

                    } 
                    else 
                    { 
                        $error_message_data = array('upload_success' => FALSE, 
                                                    'error_message' => 'Invalid request!',
                        );
                            
                        echo json_encode($error_message_data);
                    } 
                } 
                
                /** step upload_image_xmlhttprequest end } **/
                
                
                /** step remove_patient start { **/ 
                
                else if ($step == 'remove_patient') 
                { 
                    $this->labmanob_upload_model->clear_patient_image_sess();
                    
                    redirect('labmanob/upload/patient_image', 'refresh'); 
                } 
                
                /** step remove_patient end } **/ 


                /** step redirect_to_add_new_test_invoice start { **/
                else if ($step == 'redirect_to_add_new_test_invoice')
                {
                    if(isset($_SESSION['upload_patient_image__patient_id']) && ($_SESSION['upload_patient_image__patient_id'] != ''))
                    {
                        $_SESSION['test_invoice__patient_id'] = $_SESSION['upload_patient_image__patient_id'];
                    }
                    
                    $this->labmanob_upload_model->clear_patient_image_sess();

                    redirect('labmanob/add/new_test_invoice', 'refresh');
                }
                /** step redirect_to_add_new_test_invoice end } **/ 


                /** step finish start { **/
                else if ($step == 'finish')
                {
                    $this->labmanob_upload_model->clear_patient_image_sess();

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



    public function affiliate_partner_image($step_input='') 
    { 
        $step_input = strtolower($step_input); 
        
        if ($step_input == '') 
        { 
            $step = 'select_affiliate_partner'; 
        } 
        else if ($step_input == 'upload_image') 
        { 
            $step = 'upload_image'; 
        } 
        else if ($step_input == 'upload_image_xmlhttprequest') 
        { 
            // same as upload_image, but returns json response
            $step = 'upload_image_xmlhttprequest'; 
        } 
        else if ($step_input == 'remove_affiliate_partner') 
        { 
            $step = 'remove_affiliate_partner'; 
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
            
                /** step select_affiliate_partner start { **/ 
                
                if ($step == 'select_affiliate_partner') 
                { 
                    
                    /** step select_affiliate_partner(1) start { **/ 
                    
                    if (isset($_SESSION['upload_affiliate_partner_image__affiliate_partner_id']) && ($_SESSION['upload_affiliate_partner_image__affiliate_partner_id'] != '')) 
                    { 
                        $affiliate_partners_array = $this->labmanob_search_model->affiliate_partners_by_id($_SESSION['upload_affiliate_partner_image__affiliate_partner_id'], FALSE); 
                        
                        if ($affiliate_partners_array !== FALSE) 
                        { 
                            $h_view_data = array(); 
                            $view_data = array(); 
                            $f_view_data = array(); 
                            
                            foreach ($affiliate_partners_array as $affiliate_partner) 
                            { 
                                $_SESSION['upload_affiliate_partner_image__affiliate_partner'] = $affiliate_partner; 
                                $view_data['affiliate_partner'] = $affiliate_partner; 
                            } 
                            
                            $h_view_data['title'] = 'Upload Affiliate Partner Image'; 
                            $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                            
                            $this->load->view('header', $h_view_data); 
                            $this->load->view('labmanob/l_col_main', $view_data); 
                            $this->load->view('labmanob/upload/affiliate_partners/image/m_col_selected_affiliate_partner', $view_data); 
                            $this->load->view('labmanob/r_col_main', $view_data); 
                            $this->load->view('footer', $f_view_data); 
                        } 
                        else 
                        { 
                            show_error('System was unable to face affiliate partner informations using the upload affiliate partner image affiliate partner id'); 
                            /** a log for this error can be set here using the affiliate_partner **/
                        } 
                    } 
                    
                    /** step select_affiliate_partner(1) end } **/ 
                    
                    
                    /** step select_affiliate_partner(2) start { **/ 
                    
                    else 
                    { 
                        
                        $this->form_validation->set_rules('affiliate_partner_id', 'Affiliate Partner ID', array('trim', 'required', 'is_natural', 'min_length[1]', 'max_length[11]', array('has_affiliate_partner_id', array($this->labmanob_add_model, 'has_affiliate_partner_id')))); 
                        $this->form_validation->set_message('has_affiliate_partner_id', 'The {field} does not exist! Please check and try again.'); 
                        
                        if ($this->form_validation->run() == FALSE) 
                        { 
                            $h_view_data = array(); 
                            $view_data = array(); 
                            $f_view_data = array(); 
                            
                            $h_view_data['title'] = 'Select Affiliate Partner - Upload Affiliate Partner Image'; 
                            $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                            
                            $this->load->view('header', $h_view_data); 
                            $this->load->view('labmanob/l_col_main', $view_data); 
                            $this->load->view('labmanob/upload/affiliate_partners/image/m_col_select_affiliate_partner', $view_data); 
                            $this->load->view('labmanob/r_col_main', $view_data); 
                            $this->load->view('footer', $f_view_data); 
                        } 
                        else 
                        { 
                            $_SESSION['upload_affiliate_partner_image__affiliate_partner_id'] = $this->input->post('affiliate_partner_id'); 
                            
                            redirect('labmanob/upload/affiliate_partner_image', 'refresh'); 
                        } 
                        
                    } 
                    
                    /** step select_affiliate_partner(2) end } **/ 
                    
                } 
                
                /** step select_affiliate_partner end } **/
                
                
                /** step upload_image start { **/ 
                // ANY CHANGES HERE SHOULD ALSO BE CONFIGURED FOR upload_image_xmlhttprequest
                
                else if ($step == 'upload_image') 
                { 
                    if ( (isset($_SESSION['upload_affiliate_partner_image__affiliate_partner_id']) && ($_SESSION['upload_affiliate_partner_image__affiliate_partner_id'] != '')) && (isset($_SESSION['upload_affiliate_partner_image__affiliate_partner']) && ($_SESSION['upload_affiliate_partner_image__affiliate_partner'] != '')) ) 
                    { 

                        /* permission check */ 
                        $get_img_id = $this->labmanob_upload_model->get_img_id_from_affiliate_partners_by_id($_SESSION['upload_affiliate_partner_image__affiliate_partner_id'], TRUE);

                        if( (($get_img_id[0]->img_id != 1) && (($_SESSION['username'] == 'master') || ($_SESSION['username'] == 'admin'))) || ($get_img_id[0]->img_id == 1))
                        {
                            // csrf_has should only be supplied to allow resubmission where needed  

                            $image_encode_level = 2; // { 0 : no modification, 1 : base64 encoded only, 2 : encrypted using CI framework }
                            $upload_dir = 'affiliate_partners/images/';
                            $upload_path = uploads_path().$upload_dir;

                            $config['upload_path']          =  $upload_path;
                            $config['allowed_types']        = 'gif|jpg|jpeg|png';
                            $config['file_ext_tolower']     = TRUE;
                            $config['max_size']             = 5120; // 5 MB
                            $config['max_width']            = 0;
                            $config['max_height']           = 0;
                            $config['encrypt_name']     = TRUE;

                            $this->load->library('upload', $config);
                            $this->load->library('encryption');

                            if ( ! $this->upload->do_upload('image_file', $image_encode_level))
                            {
                                $h_view_data = array(); 
                                $view_data = array(); 
                                $f_view_data = array();

                                $view_data['error_message'] = $this->upload->display_errors(); 
                                $view_data['affiliate_partner'] = $_SESSION['upload_affiliate_partner_image__affiliate_partner']; 
                                
                                $h_view_data['title'] = 'Upload Affiliate Partner Image'; 
                                $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                                
                                $this->load->view('header', $h_view_data); 
                                $this->load->view('labmanob/l_col_main', $view_data); 
                                $this->load->view('labmanob/upload/affiliate_partners/image/m_col_selected_affiliate_partner', $view_data); 
                                $this->load->view('labmanob/r_col_main', $view_data); 
                                $this->load->view('footer', $f_view_data); 
                            }
                            else
                            {
                                $uploaded_image_data = $this->upload->data();

                                /* upload informations to database */
                                $upload_affiliate_partner_image_result = $this->labmanob_upload_model->upload_affiliate_partner_image($_SESSION['upload_affiliate_partner_image__affiliate_partner_id'], $uploaded_image_data, $upload_dir, $image_encode_level);

                                if(($upload_affiliate_partner_image_result != FALSE) && isset($upload_affiliate_partner_image_result)) 
                                {
                                    // database upload successful
                                    // prepare and output the response

                                    $this->session->set_flashdata('message_display', 'Image uploaded successfully!'); 
                            
                                    $h_view_data = array(); 
                                    $view_data = array(); 
                                    $f_view_data = array();

                                    // if encoded/encrypted, decode/decrypt the data for output
                                    if($image_encode_level != 0)
                                    {
                                        $this->load->library('files_library');
                                        $get_encoded_image_data = $this->files_library->get_encoded_image_data($uploaded_image_data, $image_encode_level, TRUE);
                                        
                                        if($get_encoded_image_data != FALSE)
                                        {
                                            $encoded_image_data = $get_encoded_image_data;
                                        }
                                    }

                                    // provide output
                                    if(isset($encoded_image_data) && ($encoded_image_data != '')) 
                                    {
                                        $view_data['encoded_image_data'] = $encoded_image_data;
                                    }

                                    $view_data['uploaded_image_data'] = $uploaded_image_data;
                                    $view_data['upload_dir'] = $upload_dir;
                                    $view_data['affiliate_partner'] = $_SESSION['upload_affiliate_partner_image__affiliate_partner']; 

                                    $this->labmanob_upload_model->clear_affiliate_partner_image_sess();
                                    
                                    $h_view_data['title'] = 'Upload Affiliate Partner Image'; 
                                    $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                                    
                                    $this->load->view('header', $h_view_data); 
                                    $this->load->view('labmanob/l_col_main', $view_data); 
                                    $this->load->view('labmanob/upload/affiliate_partners/image/m_col_selected_affiliate_partner', $view_data); 
                                    $this->load->view('labmanob/r_col_main', $view_data); 
                                    $this->load->view('footer', $f_view_data); 
                                }
                                else 
                                {
                                    $h_view_data = array(); 
                                    $view_data = array(); 
                                    $f_view_data = array();

                                    $view_data['error_message'] = 'Error! There was an error while uploading informations to the database!'; 
                                    $view_data['affiliate_partner'] = $_SESSION['upload_affiliate_partner_image__affiliate_partner']; 
                                    
                                    $h_view_data['title'] = 'Upload Affiliate Partner Image'; 
                                    $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                                    
                                    $this->load->view('header', $h_view_data); 
                                    $this->load->view('labmanob/l_col_main', $view_data); 
                                    $this->load->view('labmanob/upload/affiliate_partners/image/m_col_selected_affiliate_partner', $view_data); 
                                    $this->load->view('labmanob/r_col_main', $view_data); 
                                    $this->load->view('footer', $f_view_data); 
                                }
                            }
                        }
                        /* permission check else */
                        else 
                        {
                            $h_view_data = array(); 
                            $view_data = array(); 
                            $f_view_data = array();

                            $view_data['error_message'] = 'Request denied! Not enough permissions!'; 
                            $view_data['affiliate_partner'] = $_SESSION['upload_affiliate_partner_image__affiliate_partner']; 
                            
                            $h_view_data['title'] = 'Upload Affiliate Partner Image'; 
                            $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                            
                            $this->load->view('header', $h_view_data); 
                            $this->load->view('labmanob/l_col_main', $view_data); 
                            $this->load->view('labmanob/upload/affiliate_partners/image/m_col_selected_affiliate_partner', $view_data); 
                            $this->load->view('labmanob/r_col_main', $view_data); 
                            $this->load->view('footer', $f_view_data); 
                        }
                        /* permission check end */

                    } 
                    else 
                    { 
                        
                        redirect('labmanob/upload/affiliate_partner_image', 'refresh'); 
                    } 
                } 
                
                /** step upload_image end } **/
                
                
                /** step upload_image_xmlhttprequest start { **/ 
                // ANY CHANGES HERE SHOULD ALSO BE CONFIGURED FOR upload_image 
                
                else if ($step == 'upload_image_xmlhttprequest') 
                { 
                    if ( (isset($_SESSION['upload_affiliate_partner_image__affiliate_partner_id']) && ($_SESSION['upload_affiliate_partner_image__affiliate_partner_id'] != '')) && (isset($_SESSION['upload_affiliate_partner_image__affiliate_partner']) && ($_SESSION['upload_affiliate_partner_image__affiliate_partner'] != '')) ) 
                    { 

                        /* permission check */ 
                        $get_img_id = $this->labmanob_upload_model->get_img_id_from_affiliate_partners_by_id($_SESSION['upload_affiliate_partner_image__affiliate_partner_id'], TRUE);

                        if( (($get_img_id[0]->img_id != 1) && (($_SESSION['username'] == 'master') || ($_SESSION['username'] == 'admin'))) || ($get_img_id[0]->img_id == 1))
                        {
                            // csrf_has should only be supplied to allow resubmission where needed  

                            $image_encode_level = 2; // { 0 : no modification, 1 : base64 encoded only, 2 : encrypted using CI framework }
                            $upload_dir = 'affiliate_partners/images/';
                            $upload_path = uploads_path().$upload_dir;

                            $config['upload_path']          =  $upload_path;
                            $config['allowed_types']        = 'gif|jpg|jpeg|png';
                            $config['file_ext_tolower']     = TRUE;
                            $config['max_size']             = 5120; // 5 MB
                            $config['max_width']            = 0;
                            $config['max_height']           = 0;
                            $config['encrypt_name']     = TRUE;

                            $this->load->library('upload', $config);
                            $this->load->library('encryption');

                            if ( ! $this->upload->do_upload('image_file', $image_encode_level))
                            {
                                $error_message_data = array('upload_success' => FALSE, 
                                                            'error_message' => $this->upload->display_errors(),
                                                            'csrf_hash' => $this->security->get_csrf_hash(),
                                );
                                
                                echo json_encode($error_message_data);
                            }
                            else
                            {
                                $uploaded_image_data = $this->upload->data();
                                
                                /* upload informations to database */
                                $upload_affiliate_partner_image_result = $this->labmanob_upload_model->upload_affiliate_partner_image($_SESSION['upload_affiliate_partner_image__affiliate_partner_id'], $uploaded_image_data, $upload_dir, $image_encode_level);

                                if(($upload_affiliate_partner_image_result != FALSE) && isset($upload_affiliate_partner_image_result)) 
                                {
                                    // database upload successful
                                    // prepare and output the response
                                    // no csrf provided because of successful operation

                                    // if encoded/encrypted, decode/decrypt the data for output
                                    if($image_encode_level != 0)
                                    {
                                        $this->load->library('files_library');
                                        $get_encoded_image_data = $this->files_library->get_encoded_image_data($uploaded_image_data, $image_encode_level, TRUE);
                                        
                                        if($get_encoded_image_data != FALSE)
                                        {
                                            $encoded_image_data = $get_encoded_image_data;
                                        }
                                    }

                                    // provide output
                                    if(isset($encoded_image_data) && ($encoded_image_data != '')) 
                                    {
                                        $data = array('upload_success' => TRUE, 
                                                        'message_display' => 'Image uploaded successfully!', 
                                                        'uploaded_image_data' => $uploaded_image_data,
                                                        'encoded_image_data'  => $encoded_image_data,
                                        );
                                    }
                                    else 
                                    {
                                        // image not encoded, supply the upload_dir for image src generation
                                        $data = array('upload_success' => TRUE, 
                                                        'message_display' => 'Image uploaded successfully!', 
                                                        'uploaded_image_data' => $uploaded_image_data,
                                                        'upload_dir' => $upload_dir,
                                        );
                                    }
                                
                                    $this->labmanob_upload_model->clear_affiliate_partner_image_sess();
        
                                    echo json_encode($data);
                                }
                                else 
                                {
                                    $error_message_data = array('upload_success' => FALSE, 
                                                                'error_message' => 'There was an error while uploading informations to the database!',
                                                                'csrf_hash' => $this->security->get_csrf_hash(),
                                    );
                                    
                                    echo json_encode($error_message_data);
                                }
                            }
                        }
                        /* permission check else */
                        else 
                        {
                            $error_message_data = array('upload_success' => FALSE, 
                                                        'error_message' => 'Request denied! Not enough permissions!',
                                                        'csrf_hash' => $this->security->get_csrf_hash(),
                            );
                                
                            echo json_encode($error_message_data);
                        }
                        /* permission check end */

                    } 
                    else 
                    { 
                        $error_message_data = array('upload_success' => FALSE, 
                                                    'error_message' => 'Invalid request!',
                        );
                            
                        echo json_encode($error_message_data);
                    } 
                } 
                
                /** step upload_image_xmlhttprequest end } **/
                
                
                /** step remove_affiliate_partner start { **/ 
                
                else if ($step == 'remove_affiliate_partner') 
                { 
                    $this->labmanob_upload_model->clear_affiliate_partner_image_sess();
                    
                    redirect('labmanob/upload/affiliate_partner_image', 'refresh'); 
                } 
                
                /** step remove_affiliate_partner end } **/ 


                /** step finish start { **/
                else if ($step == 'finish')
                {
                    $this->labmanob_upload_model->clear_affiliate_partner_image_sess();

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



}

?>