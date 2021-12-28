<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_invoice extends CI_Controller 
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



    public function index() 
    {
        if ($this->login_model->login_check() === TRUE) 
        {
            if(strtolower($_SESSION['username']) != 'viewer')
            {
                $h_view_data = array(); 
                $view_data = array(); 
                $f_view_data = array(); 
                
                $h_view_data['title'] = "Edit Test Invoice"; 
                $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                
                $this->load->view('header', $h_view_data); 
                $this->load->view('labmanob/l_col_main', $view_data); 
                $this->load->view('labmanob/edit/test_invoice/m_col_main', $view_data);
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



    public function payment($test_invoice_id_input='') 
    {
        if ($this->login_model->login_check() === TRUE) 
        {
            if(strtolower($_SESSION['username']) != 'viewer')
            {
                $test_invoice_id = NULL;
                $test_invoice_id_input_ok = FALSE;

                if ($test_invoice_id_input == '') 
                { 
                    $test_invoice_id_input_ok = FALSE; 
                } 
                else if ((($test_invoice_id_input != '') || (!empty($test_invoice_id_input))) && (preg_match('/^[1-9][0-9]*$/', $test_invoice_id_input))) 
                { 
                    $test_invoice_id_input_ok = TRUE;
                    $test_invoice_id = $test_invoice_id_input;
                }
                else 
                {
                    $test_invoice_id_input_ok = FALSE;
                    show_404(current_url());
                }

                if(isset($test_invoice_id) && ($test_invoice_id_input_ok === TRUE))
                {
                    if($this->labmanob_view_model->count_test_invoices_by_id($test_invoice_id) > 0)
                    {
                        $this->form_validation->set_rules('final_discount', 'Discount', array('trim', 'min_length[1]', 'max_length[9]', array('check_regex_discount', array($this->labmanob_add_model, 'check_regex_discount')), array('check_discount_range', array($this->labmanob_add_model, 'check_discount_range')))); 
                        $this->form_validation->set_message('check_regex_discount', 'The %s field may only contain numbers or percentage.');
                        $this->form_validation->set_message("check_discount_range", "The %s field must be greater than zero or from 0 percent to 100 percent.");
                        
                        $this->form_validation->set_rules('final_discount_by', 'Discount By', array('trim', 'alpha_numeric_spaces', 'min_length[1]', 'max_length[200]'));
        
                        $this->form_validation->set_rules('paid_amount', 'Paid Amount', 'trim|required|max_length[15]|numeric|greater_than_equal_to[0]'); 
        
                        $this->form_validation->set_rules('extra_info', 'Extra Information', 'trim|max_length[255]');
                        

                        if ($this->form_validation->run() == FALSE) 
                        {
                            $test_invoice = $this->labmanob_view_model->test_invoice($test_invoice_id, TRUE);
                            $test_invoice = $test_invoice[0];

                            $test_invoice_patient = $this->labmanob_view_model->test_invoice_patient($test_invoice->patient_id, TRUE);
                            $test_invoice_patient = $test_invoice_patient[0];

                            $test_invoice_payment = $this->labmanob_view_model->test_invoice_payment($test_invoice->id, TRUE);
                            $test_invoice_payment = $test_invoice_payment[0];

                            $test_invoice_records = $this->labmanob_view_model->test_invoice_records_by_test_invoice_id($test_invoice_id, FALSE);

                            /* set sessions for test_invoice_logs database */
                            $_SESSION['test_invoice'] = $test_invoice;
                            $_SESSION['test_invoice__patient'] = $test_invoice_patient;
                            $_SESSION['test_invoice__payment'] = $test_invoice_payment;
                            /* set sessions for test_invoice_logs database end */

                            $h_view_data = array(); 
                            $view_data = array(); 
                            $f_view_data = array(); 
                        
                            $h_view_data['title'] = "Edit Test Invoice Payment"; 
                            $view_data['summary'] = $this->labmanob_summary_model->get_full_summary();                 

                            $table_tpl = array(
                                'table_open' => '<table class="uk-table uk-table-striped uk-table-hover uk-table-middle uk-table-small">'
                                ); 
                        
                            $this->table->set_template($table_tpl);
                            $this->table->set_heading('Serial No', 'Test ID', 'Test Name', 'Price', 'Quantity', 'Total', 'Discount', 'Discount By', 'Subtotal');
                        
                            $total_discount = 0;
                            $total = 0;
                            $i = 1;
                            foreach ($test_invoice_records as $test_key => $test_items)
                            {
                                $test_name_result = $this->labmanob_view_model->get_tests_name_by_id($test_items['test_id']);
                                $test_name = ($test_name_result !== FALSE) ? $test_name_result[0]->test_name : '';

                                $discount = 0;

                                if(!empty($test_items['discount']))
                                {
                                    $discount = $this->labmanob_view_model->calc_discount($test_items['discount'], $test_items['total']);
                                    $total_discount += $discount;
                                }

                                $total += $test_items['total'];
                                $this->table->add_row($i, $test_items['test_id'], $test_name, $test_items['test_price'], $test_items['quantity'], sprintf("%.2f", (float)$test_items['total']), $test_items['discount'], $test_items['discount_by'], sprintf("%.2f", (float)$test_items['subtotal'])); 
                                $i++;
                            }
                            $final_total = $test_invoice->total;
                            $this->table->add_row('', '', '', '', '', sprintf("%.2f", (float)$total), sprintf("%.2f", (float)$total_discount), '', sprintf("%.2f", (float)$final_total));

                            $view_data['test_invoice'] = $test_invoice;
                            $view_data['test_invoice_patient'] = $test_invoice_patient;
                            $view_data['test_invoice_payment'] = $test_invoice_payment;
                            $view_data['test_invoice_records_table'] = $this->table->generate();

                            $this->load->view('header', $h_view_data); 
                            $this->load->view('labmanob/l_col_main', $view_data); 
                            $this->load->view('labmanob/edit/test_invoice/payment/m_col_main', $view_data); 
                            $this->load->view('labmanob/r_col_main', $view_data); 
                            $this->load->view('footer', $f_view_data);
                        }
                        else 
                        {
                            //success
                            $test_invoice = $this->labmanob_view_model->test_invoice($test_invoice_id, TRUE);
                            $test_invoice = $test_invoice[0];

                            $this->labmanob_edit_model->trans_start();
                            
                            $error_count = 0;
                            $final_total = $test_invoice->total;
                            $final_discount_input = ($this->input->post('final_discount')) ? $this->input->post('final_discount') : 0.00;
                            $final_discount = $this->labmanob_edit_model->calc_discount($final_discount_input, $final_total); 
                            $final_subtotal = $final_total - $final_discount;

                            $db_data = array(
                                'discount' => $final_discount,
                                'discount_by' => $this->input->post('final_discount_by'),
                                'subtotal' => $final_subtotal,
                                'extra_info' => $this->input->post('extra_info')
                            );

                            $db_return = NULL;
                            $db_return = $this->labmanob_edit_model->test_invoice($db_data, $test_invoice_id);

                            if ($db_return !== FALSE) 
                            {
                                $paid_amount = ($this->input->post('paid_amount')) ? $this->input->post('paid_amount') : 0; 
                                $is_full_paid = ($paid_amount >= $final_subtotal) ? 1 : 0;

                                $db_data = array(
                                    'is_full_paid' => $is_full_paid,
                                    'paid_amount' => $paid_amount
                                );

                                $db_return = NULL;
                                $db_return = $this->labmanob_edit_model->test_invoice_payment($db_data, $test_invoice_id);

                                if($db_return !== FALSE)
                                {
                                    if(isset($_SESSION['test_invoice']) && isset($_SESSION['test_invoice__patient']) && isset($_SESSION['test_invoice__payment']) && ($test_invoice_id == $_SESSION['test_invoice']->id))
                                    {
                                        $db_data = array(
                                            'test_invoice_id' => $test_invoice_id,
                                            'username' => $_SESSION['username'],
                                            'prev_total' => $final_total,
                                            'prev_discount' => $_SESSION['test_invoice']->discount,
                                            'prev_discount_by' => $_SESSION['test_invoice']->discount_by,
                                            'prev_subtotal' => $_SESSION['test_invoice']->subtotal,
                                            'prev_is_full_paid' => $_SESSION['test_invoice__payment']->is_full_paid,
                                            "prev_paid_amount" => $_SESSION['test_invoice__payment']->paid_amount,
                                            'total' => $final_total,
                                            'discount' => $final_discount,
                                            'discount_by' => $this->input->post('final_discount_by'),
                                            'subtotal' => $final_subtotal,
                                            'is_full_paid' => $is_full_paid,
                                            "paid_amount" => $paid_amount,
                                            'ctrl__status' => 1
                                        );
            
                                        $db_return = NULL;
                                        $db_return = $this->labmanob_add_model->new_test_invoice_log($db_data); 

                                        if($db_return !== FALSE)
                                        {
                                            // ALL OPERATIONS SUCCESSFULL
                                            $_SESSION['test_invoice_log__id'] = $db_return;
                                        }
                                        else
                                        {
                                            $error_count++;
                                            $error_message = "Some error occurred while updating test invoice log database! Try agian.";
                                        }
                                    }
                                    else
                                    {
                                        $error_count++;
                                        $error_message = "Some error occurred while validating test invoice! Try agian.";
                                    }
                                }
                                else
                                {
                                    $error_count++;
                                    $error_message = "Some error occurred while updating test invoice payment database! Try agian.";
                                }
                            }
                            else
                            {
                                $error_count++;
                                $error_message = "Some error occurred while updating test invoice database! Try agian.";
                            }

                            $this->labmanob_edit_model->trans_complete();


                            // database has been updated
                            if($error_count != 0)
                            {
                                $test_invoice = $this->labmanob_view_model->test_invoice($test_invoice_id, TRUE);
                                $test_invoice = $test_invoice[0];

                                $test_invoice_patient = $this->labmanob_view_model->test_invoice_patient($test_invoice->patient_id, TRUE);
                                $test_invoice_patient = $test_invoice_patient[0];

                                $test_invoice_payment = $this->labmanob_view_model->test_invoice_payment($test_invoice->id, TRUE);
                                $test_invoice_payment = $test_invoice_payment[0];

                                $test_invoice_records = $this->labmanob_view_model->test_invoice_records_by_test_invoice_id($test_invoice_id, FALSE);

                                $h_view_data = array(); 
                                $view_data = array(); 
                                $f_view_data = array(); 
                            
                                $h_view_data['title'] = "Edit Test Invoice Payment"; 
                                $view_data['summary'] = $this->labmanob_summary_model->get_full_summary();                 

                                $table_tpl = array(
                                    'table_open' => '<table class="uk-table uk-table-striped uk-table-hover uk-table-middle uk-table-small">'
                                    ); 
                            
                                $this->table->set_template($table_tpl);
                                $this->table->set_heading('Serial No', 'Test ID', 'Test Name', 'Price', 'Quantity', 'Total', 'Discount', 'Discount By', 'Subtotal');
                            
                                $total_discount = 0;
                                $total = 0;
                                $i = 1;
                                foreach ($test_invoice_records as $test_key => $test_items)
                                {
                                    $test_name_result = $this->labmanob_view_model->get_tests_name_by_id($test_items['test_id']);
                                    $test_name = ($test_name_result !== FALSE) ? $test_name_result[0]->test_name : '';

                                    $discount = 0;

                                    if(!empty($test_items['discount']))
                                    {
                                        $discount = $this->labmanob_view_model->calc_discount($test_items['discount'], $test_items['total']);
                                        $total_discount += $discount;
                                    }

                                    $total += $test_items['total'];
                                    $this->table->add_row($i, $test_items['test_id'], $test_name, $test_items['test_price'], $test_items['quantity'], sprintf("%.2f", (float)$test_items['total']), $test_items['discount'], $test_items['discount_by'], sprintf("%.2f", (float)$test_items['subtotal'])); 
                                    $i++;
                                }
                                $final_total = $test_invoice->total;
                                $this->table->add_row('', '', '', '', '', sprintf("%.2f", (float)$total), sprintf("%.2f", (float)$total_discount), '', sprintf("%.2f", (float)$final_total));

                                $view_data['test_invoice'] = $test_invoice;
                                $view_data['test_invoice_patient'] = $test_invoice_patient;
                                $view_data['test_invoice_payment'] = $test_invoice_payment;
                                $view_data['test_invoice_records_table'] = $this->table->generate();

                                $this->load->view('header', $h_view_data); 
                                $this->load->view('labmanob/l_col_main', $view_data); 
                                $this->load->view('labmanob/edit/test_invoice/payment/m_col_main', $view_data); 
                                $this->load->view('labmanob/r_col_main', $view_data); 
                                $this->load->view('footer', $f_view_data);
                            }
                            else
                            {
                                // ALL Done and Success
                                // log the username who updated the information
                                $test_invoice_log_id = (isset($_SESSION['test_invoice_log__id'])) ? $_SESSION['test_invoice_log__id'] : ' ';
                                log_message('error', '===== EDIT ACTION INFORMATION =====> Username: '.$_SESSION['username'].' ----- User ID: '.$_SESSION['user_id'].' ----- Test Invoice ID: '.$test_invoice_id.' ----- Test Invoice Log ID: '.$test_invoice_log_id.' ----- Updated Test Invoice Payment info.');

                                /* clearing sessions */
                                if(isset($_SESSION['test_invoice']))
                                {
                                    unset($_SESSION['test_invoice']);
                                }

                                if(isset($_SESSION['test_invoice__patient']))
                                {
                                    unset($_SESSION['test_invoice__patient']);
                                }

                                if(isset($_SESSION['test_invoice__payment']))
                                {
                                    unset($_SESSION['test_invoice__payment']);
                                }

                                if(isset($_SESSION['test_invoice_log__id']))
                                {
                                    unset($_SESSION['test_invoice_log__id']);
                                }
                                /* clearing sessions end */

                                $this->session->set_flashdata('message_display', 'Test Invoice Payment Updated!'); 
                                redirect('labmanob/view/test_invoice/'.$test_invoice_id, 'refresh');
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
                    //No Test Invoice ID given
                    //Show Select Test Invoice form

                    $this->form_validation->set_rules('test_invoice_id', 'Test Invoice ID', array('trim', 'required', 'is_natural', 'min_length[1]', 'max_length[11]', array('has_test_invoice_id', array($this->labmanob_add_model, 'has_test_invoice_id')))); 
                    $this->form_validation->set_message('has_test_invoice_id', 'The {field} does not exist! Please check and try again.'); 

                    if ($this->form_validation->run() == FALSE) 
                    {
                        $h_view_data = array(); 
                        $view_data = array(); 
                        $f_view_data = array(); 
                        
                        $h_view_data['title'] = "Select Test Invoice | Edit Test Invoice Payment"; 
                        $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                        
                        $this->load->view('header', $h_view_data); 
                        $this->load->view('labmanob/l_col_main', $view_data); 
                        $this->load->view('labmanob/edit/test_invoice/payment/m_col_select_test_invoice', $view_data);
                        $this->load->view('labmanob/r_col_main', $view_data); 
                        $this->load->view('footer', $f_view_data);
                    }
                    else
                    {
                        redirect('labmanob/edit/test_invoice/payment/'.$this->input->post('test_invoice_id', TRUE), 'refresh');
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